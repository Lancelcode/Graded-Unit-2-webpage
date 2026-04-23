<?php
function validate($link, $email = '', $pwd = '') {
    $errors = [];

    if (empty($email)) {
        $errors[] = 'Enter your email address.';
    }
    if (empty($pwd)) {
        $errors[] = 'Enter your password.';
    }

    if (!empty($errors)) {
        return [false, $errors];
    }

    // FIX: prepared statement — $email never touches the query string
    $stmt = mysqli_prepare($link, "SELECT id, username, email, password, role FROM new_users WHERE email = ?");
    mysqli_stmt_bind_param($stmt, 's', $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);
        mysqli_stmt_close($stmt);

        if (password_verify($pwd, $row['password'])) {
            return [true, $row];
        }

        $errors[] = 'Incorrect password.';
    } else {
        mysqli_stmt_close($stmt);
        $errors[] = 'Email address and password not found.';
    }

    return [false, $errors];
}

function load($page = 'login.php') {
    // FIX: was hardcoded to http://localhost/Graded-Unit-2-webpage/
    // Root-relative path works on any server
    $page = ltrim($page, '/');
    header('Location: /' . $page);
    exit();
}