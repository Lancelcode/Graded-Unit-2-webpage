<?php
require_once 'includes/init.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require('includes/connect_db.php');

    $errors = array();

    // CSRF protection
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        $errors[] = 'Invalid CSRF token.';
    }

    // Validate username
    if (empty($_POST['username'])) {
        $errors[] = 'Enter your name.';
    } else {
        $fn = mysqli_real_escape_string($link, trim($_POST['username']));
    }

    // Validate email
    if (empty($_POST['email'])) {
        $errors[] = 'Enter your email address.';
    } else {
        $e = mysqli_real_escape_string($link, trim($_POST['email']));
    }

    // Validate password
    if (!empty($_POST['pass1'])) {
        if ($_POST['pass1'] !== $_POST['pass2']) {
            $errors[] = 'Passwords do not match.';
        } else {
            $p = password_hash(trim($_POST['pass1']), PASSWORD_DEFAULT); // More secure than SHA2
        }
    } else {
        $errors[] = 'Enter your password.';
    }

    // Check if email already exists
    if (empty($errors)) {
        $q = "SELECT id FROM new_users WHERE email = ?";
        $stmt = mysqli_prepare($link, $q);
        mysqli_stmt_bind_param($stmt, 's', $e);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);

        if (mysqli_stmt_num_rows($stmt) > 0) {
            $errors[] = 'Email address already registered. <a class="alert-link" href="index.php">Sign In Now</a>';
        }

        mysqli_stmt_close($stmt);
    }

    // Insert user if no errors
    if (empty($errors)) {
        $q = "INSERT INTO new_users (username, email, password) VALUES (?, ?, ?)";
        $stmt = mysqli_prepare($link, $q);
        mysqli_stmt_bind_param($stmt, 'sss', $fn, $e, $p);
        $r = mysqli_stmt_execute($stmt);

        if ($r) {
            mysqli_close($link);
            header("Location: index.php");
            exit();
        } else {
            echo '<p>Something went wrong. Please try again.</p>';
        }

        mysqli_stmt_close($stmt);
    } else {
        // Display all errors
        echo '<div class="container mt-4">';
        echo '<h4>The following error(s) occurred:</h4>';
        foreach ($errors as $msg) {
            echo " - $msg<br>";
        }
        echo '<p>Please try again.</p></div>';
    }

    mysqli_close($link);
}
?>
