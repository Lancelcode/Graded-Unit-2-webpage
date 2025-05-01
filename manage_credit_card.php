<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once 'includes/init.php';

if (!isset($_SESSION['username']) || !isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

require_once 'includes/connect_db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die('CSRF token validation failed.');
    }

    $action = $_POST['action'] ?? null;

    if (!$action) {
        die('No action specified.');
    }

    $userId = $_SESSION['user_id'];

    if ($action === 'add') {
        $cardNumber = trim($_POST['card_number']);
        $expiryDate = trim($_POST['expiry_date']);
        $cardHolder = trim($_POST['card_name']);
        $cvv = trim($_POST['cvv']);

        $date = DateTime::createFromFormat('Y-m-d', $expiryDate);
        if (!$date) {
            die('Invalid date format.');
        }
        $expiryDateFormatted = $date->format('Y-m-d');

        $q = "INSERT INTO credit_cards (user_id, card_number, expiry_date, cardholder_name, cvv)
              VALUES (?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($link, $q);
        mysqli_stmt_bind_param($stmt, 'issss', $userId, $cardNumber, $expiryDateFormatted, $cardHolder, $cvv);

        if (!mysqli_stmt_execute($stmt)) {
            die('Error adding card: ' . mysqli_error($link));
        }

        mysqli_stmt_close($stmt);
        header('Location: view_cards.php');
        exit();
    }

    if ($action === 'update') {
        $cardId     = $_POST['card_id'];
        $cardNumber = trim($_POST['card_number']);
        $expiryDate = trim($_POST['expiry_date']);
        $cardHolder = trim($_POST['card_name']);
        $cvv        = trim($_POST['cvv']);

        $date = DateTime::createFromFormat('Y-m-d', $expiryDate);
        if (!$date) {
            die('Invalid date format.');
        }
        $expiryDateFormatted = $date->format('Y-m-d');

        $q = "UPDATE credit_cards 
              SET card_number = ?, expiry_date = ?, cardholder_name = ?, cvv = ?
              WHERE id = ? AND user_id = ?";
        $stmt = mysqli_prepare($link, $q);
        mysqli_stmt_bind_param($stmt, 'ssssii', $cardNumber, $expiryDateFormatted, $cardHolder, $cvv, $cardId, $userId);

        if (!mysqli_stmt_execute($stmt)) {
            die('Error updating card: ' . mysqli_error($link));
        }

        mysqli_stmt_close($stmt);
        header('Location: view_cards.php');
        exit();
    }

    if ($action === 'delete') {
        $cardId = $_POST['card_id'];

        $q = "DELETE FROM credit_cards WHERE id = ? AND user_id = ?";
        $stmt = mysqli_prepare($link, $q);
        mysqli_stmt_bind_param($stmt, 'ii', $cardId, $userId);

        if (!mysqli_stmt_execute($stmt)) {
            die('Error deleting card: ' . mysqli_error($link));
        }

        mysqli_stmt_close($stmt);
        header('Location: view_cards.php');
        exit();
    }

    die('Invalid action.');
}

mysqli_close($link);
?>
