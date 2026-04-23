<?php
require_once __DIR__ . '/../../includes/init.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require ROOT_PATH . '/includes/connect_db.php';

    $errors = [];

    if (!isset($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        $errors[] = 'Invalid CSRF token.';
    }

    $fn             = trim($_POST['username']       ?? '');
    $e              = trim($_POST['email']          ?? '');
    $company_name   = trim($_POST['company_name']   ?? '');
    $contact_person = trim($_POST['contact_person'] ?? '');
    $phone_number   = trim($_POST['phone_number']   ?? '');
    $pass1          = $_POST['pass1'] ?? '';
    $pass2          = $_POST['pass2'] ?? '';

    if (empty($fn))             $errors[] = 'Enter your name.';
    if (empty($e))              $errors[] = 'Enter your email address.';
    if (empty($company_name))   $errors[] = 'Enter your company name.';
    if (empty($contact_person)) $errors[] = 'Enter the contact person\'s name.';
    if (empty($phone_number))   $errors[] = 'Enter a phone number.';

    if (empty($pass1)) {
        $errors[] = 'Enter your password.';
    } elseif ($pass1 !== $pass2) {
        $errors[] = 'Passwords do not match.';
    } else {
        $p = password_hash(trim($pass1), PASSWORD_DEFAULT);
    }

    if (empty($errors)) {
        $stmt = mysqli_prepare($link, "SELECT id FROM new_users WHERE email = ?");
        mysqli_stmt_bind_param($stmt, 's', $e);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
        if (mysqli_stmt_num_rows($stmt) !== 0) {
            $errors[] = 'Email address already registered. <a class="alert-link" href="/pages/auth/login.php">Sign In Now</a>';
        }
        mysqli_stmt_close($stmt);
    }

    if (empty($errors)) {
        $stmt = mysqli_prepare($link,
            "INSERT INTO new_users (username, email, password, company_name, contact_person, phone_number)
             VALUES (?, ?, ?, ?, ?, ?)"
        );
        mysqli_stmt_bind_param($stmt, 'ssssss', $fn, $e, $p, $company_name, $contact_person, $phone_number);
        $r = mysqli_stmt_execute($stmt);

        if ($r) {
            $user_id = mysqli_insert_id($link);
            mysqli_stmt_close($stmt);

            $stmt2 = mysqli_prepare($link,
                "INSERT INTO green_calculator_results
                    (user_id, total_score, green_count, amber_count, red_count,
                     award_level, emoji, feedback_message, shortfall, donation_cost)
                 VALUES (?, 0, 0, 0, 0, 'Initial Registration 🎟️', '🎟️', 'Thank you for joining GreenScore!', 0, 99.00)"
            );
            mysqli_stmt_bind_param($stmt2, 'i', $user_id);
            mysqli_stmt_execute($stmt2);
            mysqli_stmt_close($stmt2);

            mysqli_close($link);
            header("Location: /pages/auth/login.php?msg=Registered+Successfully");
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
        echo '<p><a href="/pages/auth/register.php">Go back</a></p></div>';
        mysqli_close($link);
    }
}