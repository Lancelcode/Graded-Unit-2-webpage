<?php
require_once __DIR__ . '/includes/init.php';   // starts the session once
if (!isset($_SESSION['username'])) { header('Location: login.php'); exit(); }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - I-Cinema</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php include('includes/nav.php'); ?>

<div class="container mt-5">
    <!-- Search Form -->
    <form method="GET" action="home.php" class="mb-4">
        <div class="row g-3">
            <!-- Search Input -->
            <div class="col-md-6">
                <input type="text" name="search" class="form-control" placeholder="Search by title or release" value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
            </div>
            <!-- Combined Dropdown -->
            <div class="col-md-3">
                <select name="filter" class="form-select">
                    <option value="">Sort and Filter</option>
                    <option value="asc" <?php echo (isset($_GET['filter']) && $_GET['filter'] == 'asc') ? 'selected' : ''; ?>>Alphabetical (A-Z)</option>
                    <option value="desc" <?php echo (isset($_GET['filter']) && $_GET['filter'] == 'desc') ? 'selected' : ''; ?>>Alphabetical (Z-A)</option>
                    <option value="release" <?php echo (isset($_GET['filter']) && $_GET['filter'] == 'release') ? 'selected' : ''; ?>>Release Date</option>
                    <?php
                    // Fetch unique genres
                    $genre_query = "SELECT DISTINCT genre FROM movie_listings ORDER BY genre ASC";
                    $genre_result = mysqli_query($link, $genre_query);

                    if ($genre_result && mysqli_num_rows($genre_result) > 0) {
                        echo "<optgroup label='Genres'>";
                        while ($genre_row = mysqli_fetch_assoc($genre_result)) {
                            $selected = (isset($_GET['filter']) && $_GET['filter'] === $genre_row['genre']) ? 'selected' : '';
                            echo "<option value=\"{$genre_row['genre']}\" $selected>{$genre_row['genre']}</option>";
                        }
                        echo "</optgroup>";
                    }

                    // Fetch unique PG ratings
                    $pg_query = "SELECT DISTINCT age_rating FROM movie_listings ORDER BY age_rating ASC";
                    $pg_result = mysqli_query($link, $pg_query);

                    if ($pg_result && mysqli_num_rows($pg_result) > 0) {
                        echo "<optgroup label='Age Ratings'>";
                        while ($pg_row = mysqli_fetch_assoc($pg_result)) {
                            // Map file paths to readable labels
                            $readable_label = '';
                            switch ($pg_row['age_rating']) {
                                case 'img\\u.JPG': $readable_label = 'U'; break;
                                case 'img\\pg.JPG': $readable_label = 'PG'; break;
                                case 'img\\12a.JPG': $readable_label = '12A'; break;
                                case 'img\\18.JPG': $readable_label = '18'; break;
                                default: $readable_label = 'Unknown'; break;
                            }

                            $selected = (isset($_GET['filter']) && $_GET['filter'] === $pg_row['age_rating']) ? 'selected' : '';
                            echo "<option value=\"{$pg_row['age_rating']}\" $selected>$readable_label</option>";
                        }
                        echo "</optgroup>";
                    }
                    ?>
                </select>
            </div>
            <!-- Search Button -->
            <div class="col-md-3">
                <button type="submit" class="btn btn-primary w-100">Search</button>
            </div>
        </div>
    </form>

    <?php
    // Get form inputs
    $search = isset($_GET['search']) ? mysqli_real_escape_string($link, $_GET['search']) : '';
    $filter = isset($_GET['filter']) ? mysqli_real_escape_string($link, $_GET['filter']) : '';

    // Build the base query
    $query = "SELECT * FROM movie_listings WHERE 1=1";

    // Add search filter
    if (!empty($search)) {
        $query .= " AND (
            movie_title LIKE '%$search%' OR 
            `release` LIKE '%$search%'
        )";
    }

    // Add combined genre and PG rating filter or sorting
    if (!empty($filter)) {
        switch ($filter) {
            case 'asc':
                $query .= " ORDER BY movie_title ASC";
                break;
            case 'desc':
                $query .= " ORDER BY movie_title DESC";
                break;
            case 'release':
                $query .= " ORDER BY `release` ASC";
                break;
            default:
                // Check for genre or age rating match
                $query .= " AND (genre = '$filter' OR age_rating = '$filter')";
                break;
        }
    } else {
        // Default sorting if no specific filter selected
        $query .= " ORDER BY movie_title ASC";
    }

    // Execute the query
    $result = mysqli_query($link, $query);

    if (!$result) {
        echo '<p class="text-danger">Error executing query: ' . mysqli_error($link) . '</p>';
        exit();
    }

    // Display search results
    echo '<div class="search-results">';
    echo '<h2>Search Results</h2>';
    echo '<h2>You can find at the bottom of the page our ranking of best rated!</h2>';
    echo '<div class="row">';

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            // Dynamically generate movie.php link with movie_id
            echo "<div class='col-md-4 mb-4'>";
            echo "<a href='movie.php?movie_id={$row['movie_id']}' class='text-decoration-none' style='color: inherit;'>";
            echo "<div class='card'>";
            echo "<img src='{$row['img']}' class='card-img-top' alt='{$row['movie_title']}'>";
            echo "<div class='card-body'>";
            echo "<h5 class='card-title'>{$row['movie_title']}</h5>";
            echo "<p class='card-text'>Genre: {$row['genre']}</p>";
            echo "<p class='card-text'>Release: {$row['release']}</p>";
            echo "<p class='card-text'>PG: <img src='{$row['age_rating']}' class='rating-img' alt='PG Rating'></p>";
            echo "</div></div>";
            echo "</a>";
            echo "</div>";
        }
    } else {
        echo "<p class='text-center'>No movies match your search criteria.</p>";
    }
    
    echo '</div>'; // Close row
    echo '</div>'; // Close search-results
    ?>
</div>


    <!-- Random Movies Section -->
<h1>🎥 Discover Something New! 🎥</h1>
<h3>Looking for a little adventure? Let us surprise you with a random selection of movies! Step out of your comfort zone 
    and dive into unexpected stories. Who knows, your next favorite film might be waiting here! 🍿✨ </h3>
<div class="row">
    <?php
    // Fetch 3 random movies for the Trending section
    $queryTrending = "SELECT * FROM movie_listings ORDER BY RAND() LIMIT 3";
    $resultTrending = mysqli_query($link, $queryTrending);

    if (mysqli_num_rows($resultTrending) > 0) {
        while ($row = mysqli_fetch_assoc($resultTrending)) {
            echo "<div class='col-md-4 mb-4'>";
            echo "<a href='movie.php?movie_id={$row['movie_id']}' class='text-decoration-none' style='color: inherit;'>";
            echo "<div class='card'>";
            echo "<img src='{$row['img']}' class='card-img-top' alt='{$row['movie_title']}'>";
            echo "<div class='card-body'>";
            echo "<h5 class='card-title'>{$row['movie_title']}</h5>";
            echo "<p class='card-text'>Genre: {$row['genre']}</p>";
            echo "<p class='card-text'>Release: {$row['release']}</p>";
            echo "</div></div>";
            echo "</a>";
            echo "</div>";
        }
    } else {
        echo "<p class='text-center'>No trending movies available at the moment.</p>";
    }
    ?>
</div>


    <!-- Best Rated Movies Section -->
<h2>⭐ Top Rated Movies, Handpicked for You! ⭐</h2>
<h3>Experience the magic of cinema with our best-rated movies! These fan favorites have captured hearts 
    and imaginations. Sit back, relax, and let the highest-rated stories entertain you. 🍿🌟</h3>
<div class="row">
    <?php
    // Fetch 3 movies with the best ratings
    $queryBestRated = "
        SELECT m.movie_id, m.movie_title, m.genre, m.release, m.img, 
               AVG(r.rating) as avg_rating 
        FROM movie_listings m
        JOIN movie_reviews r ON m.movie_id = r.movie_id
        GROUP BY m.movie_id, m.movie_title, m.genre, m.release, m.img
        ORDER BY avg_rating DESC
        LIMIT 3
    ";
    $resultBestRated = mysqli_query($link, $queryBestRated);

    if (mysqli_num_rows($resultBestRated) > 0) {
        while ($row = mysqli_fetch_assoc($resultBestRated)) {
            echo "<div class='col-md-4 mb-4'>";
            echo "<a href='movie.php?movie_id={$row['movie_id']}' class='text-decoration-none' style='color: inherit;'>";
            echo "<div class='card'>";
            echo "<img src='{$row['img']}' class='card-img-top' alt='{$row['movie_title']}'>";
            echo "<div class='card-body'>";
            echo "<h5 class='card-title'>{$row['movie_title']}</h5>";
            echo "<p class='card-text'>Genre: {$row['genre']}</p>";
            echo "<p class='card-text'>Release: {$row['release']}</p>";
            echo "<p class='card-text'>Average Rating: " . number_format($row['avg_rating'], 1) . "/5</p>";
            echo "</div></div>";
            echo "</a>";
            echo "</div>";
        }
    } else {
        echo "<p class='text-center'>No top-rated movies available at the moment.</p>";
    }
    ?>
</div>

</div>
<?php include('includes/footer.php'); ?>

<!-- Bootstrap JS and dependencies -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
