<?php
require_once __DIR__ . '/../../includes/init.php';
require_once ROOT_PATH . '/includes/connect_db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: ' . BASE_URL . '/pages/auth/login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!hash_equals($_SESSION['csrf_token'] ?? '', $_POST['csrf_token'] ?? '')) {
        die('Invalid CSRF token.');
    }
    $message = trim($_POST['message'] ?? '');
    $user_id = (int) $_SESSION['user_id'];

    if (!empty($message)) {
        $stmt = $link->prepare("INSERT INTO community_tips (user_id, message) VALUES (?, ?)");
        if ($stmt) {
            $stmt->bind_param("is", $user_id, $message);
            $stmt->execute();
            $stmt->close();
        }
    }
}

mysqli_close($link);
header('Location: ' . BASE_URL . '/pages/community/community.php');
exit();