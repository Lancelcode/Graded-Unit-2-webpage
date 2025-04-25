<?php # PROCESS LOGIN ATTEMPT.

require_once __DIR__ . '/init.php'; // session start
require_once 'connect_db.php';
if (!function_exists('validate')) {
    require_once 'login_tools.php';
}


// Only process if POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $errors = [];

    // CSRF check
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        $errors[] = "Invalid CSRF token.";
    }

    try {
        $is_admin_login = isset($_POST['admin_login']) && $_POST['admin_login'] == '1';

        // Validate credentials
        list($check, $data) = validate($link, $_POST['email'], $_POST['password'], $is_admin_login);

        if ($check) {
            // Success: Set session variables
            $_SESSION['id']       = $data['id'];
            $_SESSION['username'] = $data['username'];
            $_SESSION['email']    = $data['email'];
            $_SESSION['role']     = $data['role'];

            // Admin redirection
            if ($is_admin_login && $data['role'] === 'admin') {
                load('admin_feedback.php');
            } else {
                load('home.php');
            }
        } else {
            $errors = $data;
        }
    } catch (Exception $e) {
        $errors[] = "Unexpected error. Please try again.";
    }

    if ($link instanceof mysqli) {
        mysqli_close($link);
    }

}

// If there are any errors, display them
if (!empty($errors)) {
    echo '<div class="alert alert-danger" role="alert">';
    foreach ($errors as $error) {
        echo htmlspecialchars($error) . '<br>';
    }
    echo '</div>';

    include('../login.php');
}
?>
