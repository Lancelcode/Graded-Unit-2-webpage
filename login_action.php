<?php # PROCESS LOGIN ATTEMPT.

require_once __DIR__ . '/includes/init.php';   // starts / resumes the session


# Check form submitted.
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    # Open database connection.
    require('includes/connect_db.php');

    # Get connection, load, and validate functions.
    require('login_tools.php');

    try {
        # Check login.
        list($check, $data) = validate($link, $_POST['email'], $_POST['password']);

        # On success set session data and redirect to home page.
        if ($check) {
            $_SESSION['id'] = $data['id'];
            $_SESSION['username'] = $data['username'];
            $_SESSION['email'] = $data['email'];
            load('home.php');
        } else {
            # On failure, set errors.
            $errors = $data;
        }
    } catch (Exception $e) {
        # Catch any unexpected errors and store a custom error message.
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
