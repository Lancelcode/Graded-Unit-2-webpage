<?php
require_once 'includes/init.php';
require_once 'includes/connect_db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // FIX: CSRF token was never verified
    if (!hash_equals($_SESSION['csrf_token'] ?? '', $_POST['csrf_token'] ?? '')) {
        die('Invalid CSRF token.');
    }

    $tip_id  = (int) ($_POST['tip_id'] ?? 0);
    $message = trim($_POST['message'] ?? '');
    $user_id = (int) $_SESSION['user_id'];

    if (!empty($message) && $tip_id > 0) {
        $stmt = $link->prepare("UPDATE community_tips SET message = ? WHERE id = ? AND user_id = ?");
        if ($stmt) {
            $stmt->bind_param("sii", $message, $tip_id, $user_id);
            $stmt->execute();
            $stmt->close();
        }
    }
}

mysqli_close($link);
header("Location: community.php");
exit();