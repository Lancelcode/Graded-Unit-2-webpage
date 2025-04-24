<?php # PROCESS LOGIN ATTEMPT.

require_once __DIR__ . '/includes/init.php';   // starts / resumes the session

# Check form submitted.
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    # Open database connection.
    require('includes/connect_db.php');

    # Get connection, load, and validate functions.
    require('includes/login_tools.php');

    try {
        # Check if admin login checkbox is ticked.
        $is_admin_login = isset($_POST['admin_login']) && $_POST['admin_login'] == '1';

        # Check login with optional admin requirement.
        list($check, $data) = validate($link, $_POST['email'], $_POST['password'], $is_admin_login);

        # On success set session data and redirect.
        if ($check) {
            $_SESSION['id'] = $data['id'];
            $_SESSION['username'] = $data['username'];
            $_SESSION['email'] = $data['email'];
            $_SESSION['role'] = $data['role'];

            if ($is_admin_login && $data['role'] === 'admin') {
                load('admin_dashboard.php');
            } else {
                load('home.php');
            }
        } else {
            # On failure, set errors.
            $errors = $data;
        }
    } catch (Exception $e) {
        $errors[] = "An unexpected error occurred. Please try again later.";
    }

    # Close database connection.
    mysqli_close($link);
}

# If there are errors, display them.
if (!empty($errors)) {
    echo '<div class="alert alert-danger" role="alert">';
    foreach ($errors as $error) {
        echo htmlspecialchars($error) . '<br>';
    }
    echo '</div>';
}

# Continue to display login page on failure.
include('login.php');
?>
