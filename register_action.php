<?php
require_once 'includes/init.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require('includes/connect_db.php');

    $errors = [];

    // CSRF protection
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        $errors[] = 'Invalid CSRF token.';
    }

    // Name
    if (empty($_POST['username'])) {
        $errors[] = 'Enter your name.';
    } else {
        $fn = mysqli_real_escape_string($link, trim($_POST['username']));
    }

    // Email
    if (empty($_POST['email'])) {
        $errors[] = 'Enter your email address.';
    } else {
        $e = mysqli_real_escape_string($link, trim($_POST['email']));
    }

    // Password
    if (!empty($_POST['pass1'])) {
        if ($_POST['pass1'] !== $_POST['pass2']) {
            $errors[] = 'Passwords do not match.';
        } else {
            $p = password_hash(trim($_POST['pass1']), PASSWORD_DEFAULT);
        }
    } else {
        $errors[] = 'Enter your password.';
    }

    // Required additional fields
    if (empty($_POST['company_name'])) {
        $errors[] = 'Enter your company name.';
    } else {
        $company_name = mysqli_real_escape_string($link, trim($_POST['company_name']));
    }

    if (empty($_POST['contact_person'])) {
        $errors[] = 'Enter the contact person\'s name.';
    } else {
        $contact_person = mysqli_real_escape_string($link, trim($_POST['contact_person']));
    }

    if (empty($_POST['phone_number'])) {
        $errors[] = 'Enter a phone number.';
    } else {
        $phone_number = mysqli_real_escape_string($link, trim($_POST['phone_number']));
    }

    // Check if email already exists
    if (empty($errors)) {
        $q = "SELECT id FROM new_users WHERE email=?";
        $stmt = mysqli_prepare($link, $q);
        mysqli_stmt_bind_param($stmt, 's', $e);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);

        if (mysqli_stmt_num_rows($stmt) != 0) {
            $errors[] = 'Email address already registered. <a class="alert-link" href="index.php">Sign In Now</a>';
        }

        mysqli_stmt_close($stmt);
    }

    // Register the user
    if (empty($errors)) {
        $q = "INSERT INTO new_users (username, email, password, company_name, contact_person, phone_number)
              VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($link, $q);
        mysqli_stmt_bind_param($stmt, 'ssssss', $fn, $e, $p, $company_name, $contact_person, $phone_number);
        $r = mysqli_stmt_execute($stmt);

        if ($r) {
            $user_id = mysqli_insert_id($link);
            mysqli_stmt_close($stmt);

            // ✅ Add £99 registration donation
            $insert_donation = "
                INSERT INTO green_calculator_results (
                    user_id, total_score, green_count, amber_count, red_count,
                    award_level, emoji, feedback_message, shortfall, donation_cost
                ) VALUES (?, 0, 0, 0, 0, 'Initial Registration 🎟️', '🎟️', 'Thank you for joining GreenScore!', 0, 99.00)
            ";
            $stmt2 = mysqli_prepare($link, $insert_donation);
            mysqli_stmt_bind_param($stmt2, 'i', $user_id);
            mysqli_stmt_execute($stmt2);
            mysqli_stmt_close($stmt2);

            mysqli_close($link);
            header("Location: login.php?msg=Registered+and+Charged+£99");
            exit();
        } else {
            mysqli_stmt_close($stmt);
            mysqli_close($link);
            echo "<p>Registration failed. Please try again.</p>";
        }
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
