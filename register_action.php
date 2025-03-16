<?php
require('includes/connect_db.php');

$errors = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = mysqli_real_escape_string($link, $_POST['username']);
    $email = mysqli_real_escape_string($link, $_POST['email']);
    $password = mysqli_real_escape_string($link, $_POST['password']);
    $confirm_password = mysqli_real_escape_string($link, $_POST['confirm_password']);

    if ($password !== $confirm_password) {
        $errors[] = 'Passwords do not match.';
    }

    if (empty($errors)) {
        $hashed_password = hash('sha256', $password);
        $query = "INSERT INTO new_users (username, email, password) VALUES ('$username', '$email', '$hashed_password')";
        $result = mysqli_query($link, $query);

        if ($result) {
            header('Location: index.php');
            exit();
        } else {
            echo "Error: " . mysqli_error($link);
        }
    }
}

include('index.php');
?>
