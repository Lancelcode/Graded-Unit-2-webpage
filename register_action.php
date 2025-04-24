<?php
require_once 'includes/init.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require('includes/connect_db.php');

    $errors = array();

    // CSRF protection
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        $errors[] = 'Invalid CSRF token.';
    }

    if (empty($_POST['username'])) {
        $errors[] = 'Enter your name.';
    } else {
        $fn = mysqli_real_escape_string($link, trim($_POST['username']));
    }

    if (empty($_POST['email'])) {
        $errors[] = 'Enter your email address.';
    } else {
        $e = mysqli_real_escape_string($link, trim($_POST['email']));
    }

    if (!empty($_POST['pass1'])) {
        if ($_POST['pass1'] !== $_POST['pass2']) {
            $errors[] = 'Passwords do not match.';
        } else {
            $p = mysqli_real_escape_string($link, trim($_POST['pass1']));
        }
    } else {
        $errors[] = 'Enter your password.';
    }

    // Check if the email is already registered
    if (empty($errors)) {
        $q = "SELECT id FROM new_users WHERE email='$e'";
        $r = @mysqli_query($link, $q);
        if (mysqli_num_rows($r) != 0) {
            $errors[] = 'Email address already registered. <a class="alert-link" href="index.php">Sign In Now</a>';
        }
    }

    // Insert user if no errors
    if (empty($errors)) {
        $q = "INSERT INTO new_users (username, email, password) 
              VALUES ('$fn', '$e', SHA2('$p', 256))";
        $r = @mysqli_query($link, $q);

        if ($r) {
            mysqli_close($link);
            header("Location: index.php");
            exit();
        }

        echo '<p>Something went wrong. Please try again.</p>';
        mysqli_close($link);
    } else {
        echo '<div class="container mt-4">';
        echo '<h4>The following error(s) occurred:</h4>';
        foreach ($errors as $msg) {
            echo " - $msg<br>";
        }
        echo '<p>Please try again.</p></div>';
        mysqli_close($link);
    }
}
?>
