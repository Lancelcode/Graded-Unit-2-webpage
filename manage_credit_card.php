<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();
require('connect_db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'];

    if ($action === 'add') {
        // Add a new card
        $userId = $_SESSION['id'];
        $cardNumber = $_POST['cardNumber'];
        $expiryDate = $_POST['expiryDate'];
        $cardHolder = $_POST['cardHolder'];

        // Format expiry date (YYYY-MM-DD) for database storage
        $date = DateTime::createFromFormat('Y-m-d', $expiryDate);
        if ($date) {
            $expiryDateFormatted = $date->format('Y-m-d');
        } else {
            die('Invalid date format');
        }

        $q = "INSERT INTO credit_cards (user_id, card_number, expiry_date, cardholder_name) VALUES (?, ?, ?, ?)";
        $stmt = mysqli_prepare($link, $q);
        mysqli_stmt_bind_param($stmt, 'isss', $userId, $cardNumber, $expiryDateFormatted, $cardHolder);

        if (!mysqli_stmt_execute($stmt)) {
            die('Error: ' . mysqli_error($link));
        }

        mysqli_stmt_close($stmt);
        header('Location: view_cards.php');
        exit();
    }

    if ($action === 'update') {
        // Update an existing card
        $cardId = $_POST['cardId'];
        $cardNumber = $_POST['cardNumber'];
        $expiryDate = $_POST['expiryDate'];
        $cardHolder = $_POST['cardHolder'];

        // Format expiry date (YYYY-MM-DD) for database storage
        $date = DateTime::createFromFormat('Y-m-d', $expiryDate);
        if ($date) {
            $expiryDateFormatted = $date->format('Y-m-d');
        } else {
            die('Invalid date format');
        }

        $q = "UPDATE credit_cards SET card_number = ?, expiry_date = ?, cardholder_name = ? WHERE id = ?";
        $stmt = mysqli_prepare($link, $q);
        mysqli_stmt_bind_param($stmt, 'sssi', $cardNumber, $expiryDateFormatted, $cardHolder, $cardId);

        if (!mysqli_stmt_execute($stmt)) {
            die('Error: ' . mysqli_error($link));
        }

        mysqli_stmt_close($stmt);
        header('Location: view_cards.php');
        exit();
    }

    if ($action === 'delete') {
        // Delete a card
        $cardId = $_POST['cardId'];
        $q = "DELETE FROM credit_cards WHERE id = ?";
        $stmt = mysqli_prepare($link, $q);
        mysqli_stmt_bind_param($stmt, 'i', $cardId);

        if (!mysqli_stmt_execute($stmt)) {
            die('Error: ' . mysqli_error($link));
        }

        mysqli_stmt_close($stmt);
        header('Location: view_cards.php');
        exit();
    }
}

mysqli_close($link);
?>
