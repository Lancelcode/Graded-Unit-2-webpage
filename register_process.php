<?php

require_once __DIR__ . '/includes/init.php';
if (isset($_SESSION['username'])) {
    header('Location: index.php');
    exit();
}


# Include database connection.
require('includes/connect_db.php');

# Prepare response array.
$response = ['success' => false, 'errors' => []];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    # Collect and trim inputs.
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password1 = trim($_POST['pass1'] ?? '');
    $password2 = trim($_POST['pass2'] ?? '');

    # Validate inputs.
    if (empty($username)) {
        $response['errors'][] = 'Enter your name.';
    }

    if (empty($email)) {
        $response['errors'][] = 'Enter your email address.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $response['errors'][] = 'Enter a valid email address.';
    }

    if (empty($password1) || empty($password2)) {
        $response['errors'][] = 'Enter your password.';
    } elseif ($password1 !== $password2) {
        $response['errors'][] = 'Passwords do not match.';
    }

    # If no validation errors, proceed.
    if (empty($response['errors'])) {
        # Sanitize inputs.
        $username = mysqli_real_escape_string($link, $username);
        $email = mysqli_real_escape_string($link, $email);
        $passwordHash = hash('sha256', $password1);

        # Check if email already exists.
        $query = "SELECT id FROM new_users WHERE email='$email'";
        $result = mysqli_query($link, $query);

        if (mysqli_num_rows($result) > 0) {
            $response['errors'][] = 'Email address already registered.';
        } else {
            # Insert new user.
            $query = "INSERT INTO new_users (username, email, password) VALUES ('$username', '$email', '$passwordHash')";
            $result = mysqli_query($link, $query);

            if ($result) {
                $response['success'] = true;
            } else {
                $response['errors'][] = 'Database error: Unable to register.';
            }
        }
    }
}

# Close database connection.
mysqli_close($link);

# Return JSON response.
header('Content-Type: application/json');
echo json_encode($response);
?>
