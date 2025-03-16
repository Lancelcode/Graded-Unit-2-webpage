<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();
require('connect_db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'];

    if ($action === 'add') {
        // Add a new review
        $userId = $_SESSION['id'];
        $movieId = $_POST['movieId'];
        $reviewDesc = $_POST['review_desc'];
        $rating = $_POST['rating'];

        // Validate inputs
        if (empty($reviewDesc) || !is_numeric($rating) || $rating < 1 || $rating > 5) {
            die('Invalid review data.');
        }

        $q = "INSERT INTO movie_reviews (id, movie_id, review_desc, rating, created_at) VALUES (?, ?, ?, ?, NOW())";
        $stmt = mysqli_prepare($link, $q);
        mysqli_stmt_bind_param($stmt, 'iisi', $userId, $movieId, $reviewDesc, $rating);

        if (!mysqli_stmt_execute($stmt)) {
            die('Error: ' . mysqli_error($link));
        }

        mysqli_stmt_close($stmt);
        header('Location: movie_reviews.php');
        exit();
    }

    if ($action === 'update') {
        // Update an existing review
        $reviewId = $_POST['review_id'];
        $reviewDesc = $_POST['review_desc'];
        $rating = $_POST['rating'];

        // Validate inputs
        if (empty($reviewDesc) || !is_numeric($rating) || $rating < 1 || $rating > 5) {
            die('Invalid review data.');
        }

        $q = "UPDATE movie_reviews SET review_desc = ?, rating = ? WHERE review_id = ? AND id = ?";
        $stmt = mysqli_prepare($link, $q);
        mysqli_stmt_bind_param($stmt, 'siii', $reviewDesc, $rating, $reviewId, $_SESSION['id']);

        if (!mysqli_stmt_execute($stmt)) {
            die('Error: ' . mysqli_error($link));
        }

        mysqli_stmt_close($stmt);
        header('Location: movie_reviews.php');
        exit();
    }

    if ($action === 'delete') {
        // Delete a review
        $reviewId = $_POST['review_id'];
        $q = "DELETE FROM movie_reviews WHERE review_id = ? AND id = ?";
        $stmt = mysqli_prepare($link, $q);
        mysqli_stmt_bind_param($stmt, 'ii', $reviewId, $_SESSION['id']);

        if (!mysqli_stmt_execute($stmt)) {
            die('Error: ' . mysqli_error($link));
        }

        mysqli_stmt_close($stmt);
        header('Location: movie_reviews.php');
        exit();
    }
}

mysqli_close($link);
?>
