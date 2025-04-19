<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}
require('includes/connect_db.php');

// Redirect to login if the user is not authenticated
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}
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
    <style>
        .card {
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }
        .card:hover {
            transform: scale(1.05);
        }
        .card img {
            object-fit: cover;
        }
        .modal .form-control, .modal .form-select {
            border-radius: 5px;
        }
    </style>
</head>
<body>
<?php include('includes/nav1.php'); ?>
<div class="container mt-5">
    <h1 class="mb-4">Movie Listings</h1>
    <div class="row">
        <?php
        // Fetch all movies from the database
        $query = "SELECT * FROM movie_listings";
        $result = mysqli_query($link, $query);

        // Check if there are movies available
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<div class='col-md-4 mb-4'>";
                echo "<div class='card'>";
                echo "<img src='{$row['img']}' class='card-img-top' alt='{$row['movie_title']}'>";
                echo "<div class='card-body'>";
                echo "<h5 class='card-title'>{$row['movie_title']}</h5>";
                echo "<p class='card-text'>Genre: {$row['genre']}</p>";
                echo "<p class='card-text'>Release: {$row['release']}</p>";
                echo "<div>";
                echo "<a href='movie.php?movie_id={$row['movie_id']}' class='btn btn-primary btn-block mb-2'>Details</a>";
                echo "<button class='btn btn-secondary btn-block' data-bs-toggle='modal' data-bs-target='#reviewModal{$row['movie_id']}'>Review</button>";
                echo "</div>";
                echo "</div></div></div>";

                // Modal Form for Adding a Review
                echo "
                <div class='modal fade' id='reviewModal{$row['movie_id']}' tabindex='-1' aria-labelledby='reviewModalLabel{$row['movie_id']}' aria-hidden='true'>
                    <div class='modal-dialog'>
                        <div class='modal-content'>
                            <div class='modal-header'>
                                <h5 class='modal-title' id='reviewModalLabel{$row['movie_id']}'>Add Review for {$row['movie_title']}</h5>
                                <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                            </div>
                            <form action='submit_review.php' method='POST'>
                                <div class='modal-body'>
                                    <input type='hidden' name='movie_id' value='{$row['movie_id']}'>
                                    <div class='mb-3'>
                                        <label for='rating{$row['movie_id']}' class='form-label'>Rating (out of 5)</label>
                                        <select class='form-select' id='rating{$row['movie_id']}' name='rating' required>
                                            <option value='5'>5 - Excellent</option>
                                            <option value='4'>4 - Good</option>
                                            <option value='3'>3 - Average</option>
                                            <option value='2'>2 - Poor</option>
                                            <option value='1'>1 - Terrible</option>
                                        </select>
                                    </div>
                                    <div class='mb-3'>
                                        <label for='review_desc{$row['movie_id']}' class='form-label'>Your Review</label>
                                        <textarea class='form-control' id='review_desc{$row['movie_id']}' name='review_desc' rows='4' required></textarea>
                                    </div>
                                </div>
                                <div class='modal-footer'>
                                    <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Cancel</button>
                                    <button type='submit' class='btn btn-primary'>Submit Review</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>";
            }
        } else {
            echo "<p class='text-center'>No movies available at the moment.</p>";
        }

        // Close the database connection
        mysqli_close($link);
        ?>
    </div>
</div>
<?php include('includes/footer2.php'); ?>

<!-- Bootstrap JS and dependencies -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
