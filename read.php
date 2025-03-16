<?php include('includes/nav.php'); ?>
<?php require('includes/connect_db.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movies</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <div class="row">
        <?php
        $query = "SELECT * FROM movie_listings";
        $result = mysqli_query($link, $query);
        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<div class='col-md-4 mb-4'>";
                echo "<div class='card'>";
                echo "<img src='{$row['img']}' class='card-img-top' alt='{$row['movie_title']}'>";
                echo "<div class='card-body'>";
                echo "<h5 class='card-title'>{$row['movie_title']}</h5>";
                echo "<p class='card-text'>Genre: {$row['genre']}</p>";
                echo "<p class='card-text'>Release: {$row['release']}</p>";
                echo "<a href='movie.php?id={$row['movie_id']}' class='btn btn-primary'>Details</a>";
                echo "</div></div></div>";
            }
        } else {
            echo "<p>No movies available.</p>";
        }
        ?>
    </div>
</div>
<?php include('includes/footer.php'); ?>
</body>
</html>
