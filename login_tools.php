<?php # LOGIN HELPER FUNCTIONS.

/**
 * Redirects the user to a specified page.
 */
function load($page = 'login.php') {
    $url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']);
    $url = rtrim($url, '/\\');
    $url .= '/' . $page;
    header("Location: $url");
    exit();
}

/**
 * Validates user login credentials.
 * Uses SHA2 hashing (MySQL side) for password.
 * Supports optional admin login.
 */
function validate($link, $email = '', $pwd = '', $require_admin = false) {
    $errors = array();

    // Check email
    if (empty($email)) {
        $errors[] = 'Enter your email address.';
    } else {
        $e = mysqli_real_escape_string($link, trim($email));
    }

    // Check password
    if (empty($pwd)) {
        $errors[] = 'Enter your password.';
    } else {
        $p = mysqli_real_escape_string($link, trim($pwd));
    }

    // Only proceed if no input errors
    if (empty($errors)) {
        $admin_condition = $require_admin ? "AND role = 'admin'" : "";

        $q = "SELECT id, username, email, role FROM new_users 
              WHERE email = '$e' AND password = SHA2('$p', 256) $admin_condition";

        $r = mysqli_query($link, $q);

        if (mysqli_num_rows($r) == 1) {
            $user = mysqli_fetch_array($r, MYSQLI_ASSOC);
            return array(true, $user);
        } else {
            $errors[] = 'Email and password not found, or user is not an admin.';
        }
    }

    return array(false, $errors);
}
?>
