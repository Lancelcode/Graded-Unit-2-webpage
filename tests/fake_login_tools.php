<?php
// Mock login_tools functions for PHPUnit
function validate($link, $email = '', $pwd = '') {
    $errors = [];

    if (empty($email)) {
        $errors[] = 'Enter your email address.';
    }

    if (empty($pwd)) {
        $errors[] = 'Enter your password.';
    }

    $test_users = [
        'admin@example.com' => ['password' => 'adminpass', 'id' => 1, 'username' => 'Admin User', 'role' => 'admin'],
        'user@example.com' => ['password' => 'userpass', 'id' => 2, 'username' => 'Test User', 'role' => 'user']
    ];

    if (empty($errors)) {
        if (isset($test_users[$email])) {
            if ($pwd === $test_users[$email]['password']) {
                return [true, $test_users[$email]];
            } else {
                $errors[] = 'Incorrect password.';
            }
        } else {
            $errors[] = 'Email address and password not found.';
        }
    }

    return [false, $errors];
}

function load($page = 'index.php') {
    // Prevent redirect during test
}
