<?php require_once __DIR__ . '/includes/init.php';   // starts the session once
require('includes/connect_db.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to I-Cinema</title>
    <!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<!-- Popper.js (Required for Bootstrap dropdowns) -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
<!-- Bootstrap JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"></script>

        
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <link rel="stylesheet" href="style.css">
</head>

<body>
<?php include('includes/nav.php'); ?>
<div class="container mt-5">
    <h1 class="display-4">Welcome to I-Cinema</h1>
    <h3 class="lead">Your gateway to the latest movies and seamless booking experience.</h3>

</div>

<div id="movieCarousel" class="carousel slide mt-5" data-bs-ride="carousel" data-bs-interval="3000">
    <div class="carousel-inner">
        <?php
        $query = "SELECT img, movie_title, genre FROM movie_listings LIMIT 5";
        $result = mysqli_query($link, $query);

        if ($result && mysqli_num_rows($result) > 0) {
            $isActive = true;
            while ($row = mysqli_fetch_assoc($result)) {
                echo '<div class="carousel-item' . ($isActive ? ' active' : '') . '">';
                echo '<img src="' . htmlspecialchars($row['img']) . '" class="d-block w-100 img-fluid" alt="Poster of ' . htmlspecialchars($row['movie_title']) . '">';
                echo '<div class="movie-details">';
                echo '<h5>' . htmlspecialchars($row['movie_title']) . '</h5>';
                echo '<p>Genre: ' . htmlspecialchars($row['genre']) . '</p>';
                echo '</div>';
                echo '</div>';
                $isActive = false;
            }
        } else {
            echo '<div class="carousel-item active">';
            echo '<p>No movies available to display in the carousel.</p>';
            echo '</div>';
        }
        ?>
    </div>
</div>

<?php include('includes/footer.php'); ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
