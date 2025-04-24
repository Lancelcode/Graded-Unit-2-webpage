<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once 'includes/init.php';

if (!isset($_SESSION['username']) || !isset($_SESSION['id'])) {
    header("Location: index.php");
    exit();
}

require('includes/connect_db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die('CSRF token validation failed.');
    }

    $action = $_POST['action'] ?? null;

    if (!$action) {
        die('No action specified.');
    }

    if ($action === 'add') {
        $userId = $_SESSION['id'];
        $cardNumber = $_POST['card_number'];
        $expiryDate = $_POST['expiry_date'];
        $cardHolder = $_POST['card_name'];

        $date = DateTime::createFromFormat('Y-m-d', $expiryDate);
        if (!$date) {
            die('Invalid date format.');
        }
        $expiryDateFormatted = $date->format('Y-m-d');

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
        $cardId = $_POST['cardId'];
        $cardNumber = $_POST['card_number'];
        $expiryDate = $_POST['expiry_date'];
        $cardHolder = $_POST['card_name'];

        $date = DateTime::createFromFormat('Y-m-d', $expiryDate);
        if (!$date) {
            die('Invalid date format.');
        }
        $expiryDateFormatted = $date->format('Y-m-d');

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
