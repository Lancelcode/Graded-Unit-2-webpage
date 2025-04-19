<?php

function validate($link, $email = '', $pwd = '') {
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
        $q = "SELECT id, username, email, password FROM new_users WHERE email='$e'";
        $r = mysqli_query($link, $q);

        if (mysqli_num_rows($r) === 1) {
            $row = mysqli_fetch_array($r, MYSQLI_ASSOC);
            // ✅ SHA-256 password check (must match registration logic)
            if ($row['password'] === hash('sha256', $p)) {
                return [true, $row];
            } else {
                $errors[] = 'Incorrect password.';
            }
        } else {
            $errors[] = 'Email address and password not found.';
        }
    }

    return [false, $errors];
}

function load($page = 'login.php') {
    $url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']);
    $url = rtrim($url, '/\\');
    $url .= '/' . $page;
    header("Location: $url");
    exit();
}
