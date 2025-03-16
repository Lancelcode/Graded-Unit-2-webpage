<?php
session_start();
require('includes/connect_db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['id'])) {
    $userId = $_SESSION['id']; // Assuming `id` corresponds to user ID in your session
    $movieId = $_POST['movie_id'];
    $rating = $_POST['rating'];
    $reviewDesc = $_POST['review_desc']; // Updated column name

    # Insert the review into the database
    $q = "INSERT INTO movie_reviews (id, movie_id, review_desc, rating) VALUES (?, ?, ?, ?)";
    $stmt = mysqli_prepare($link, $q);
    mysqli_stmt_bind_param($stmt, 'iisi', $userId, $movieId, $reviewDesc, $rating);

    if (mysqli_stmt_execute($stmt)) {
        header("Location: movie_reviews.php?movie_id=$movieId");
        exit();
    } else {
        echo "Error: " . mysqli_error($link);
    }

    mysqli_stmt_close($stmt);
}

mysqli_close($link);
?>
