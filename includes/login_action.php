<?php
require_once __DIR__ . '/init.php';
require_once 'connect_db.php';
require_once 'login_tools.php';

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (!isset($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        $errors[] = 'Invalid CSRF token.';
    }

    $email    = trim($_POST['email']    ?? '');
    $password = trim($_POST['password'] ?? '');

    if (empty($email))    $errors[] = 'Email is required.';
    if (empty($password)) $errors[] = 'Password is required.';

    if (empty($errors)) {
        [$is_valid, $user_data] = validate($link, $email, $password);

        if ($is_valid) {
        // Regenerate session ID immediately on login — prevents session fixation
        session_regenerate_id(true);

        $_SESSION['user_id']  = $user_data['id'];
        $_SESSION['username'] = $user_data['username'];
        $_SESSION['email']    = $user_data['email'];
        $_SESSION['role']     = $user_data['role'];

            // FIX: use BASE_URL so redirect works in any subfolder
            header('Location: ' . BASE_URL . '/index.php');
            exit();
        } else {
            $errors = $user_data;
        }
    }

    if (!empty($errors)) {
        $_SESSION['login_error'] = implode('<br>', $errors);
        header('Location: ' . BASE_URL . '/pages/auth/login.php');
        exit();
    }
}