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
        $p = trim($pwd);
    }

    if (empty($errors)) {
        $q = "SELECT id, username, email, password, role FROM new_users WHERE email='$e'";
        $r = mysqli_query($link, $q);

        if (mysqli_num_rows($r) === 1) {
            $row = mysqli_fetch_array($r, MYSQLI_ASSOC);

            // ✅ Verify using password_verify
            if (password_verify($p, $row['password'])) {
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
    $url = 'http://localhost/Graded-Unit-2-webpage/' . ltrim($page, '/');
    header("Location: $url");
    exit();
}
?>
