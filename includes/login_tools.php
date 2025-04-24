<?php

function validate($link, $email = '', $pwd = '', $adminCheck = false) {
    $errors = [];

    if (empty($email)) {
        $errors[] = 'Enter your email address.';
    } else {
        $e = mysqli_real_escape_string($link, trim($email));
    }

    if (empty($pwd)) {
        $errors[] = 'Enter your password.';
    } else {
        $p = mysqli_real_escape_string($link, trim($pwd));
    }

    if (empty($errors)) {
        $q = "SELECT id, username, email, password, role FROM new_users WHERE email='$e'";
        $r = mysqli_query($link, $q);

        if (mysqli_num_rows($r) === 1) {
            $row = mysqli_fetch_array($r, MYSQLI_ASSOC);
            if ($row['password'] === hash('sha256', $p)) {
                // If admin checkbox was checked but user is not admin
                if ($adminCheck && $row['role'] !== 'admin') {
                    $errors[] = 'Admin access denied.';
                } else {
                    return [true, $row];
                }
            } else {
                $errors[] = 'Incorrect password.';
            }
        } else {
            $errors[] = 'Email address and password not found.';
        }
    }

    return [false, $errors];
}

// ✅ Fixed: always redirect to the root of your project
function load($page = 'login.php') {
    $url = 'http://localhost/Graded-Unit-2-webpage/' . ltrim($page, '/');
    header("Location: $url");
    exit();
}
