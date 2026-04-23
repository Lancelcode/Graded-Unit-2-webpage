<?php
require_once __DIR__ . '/../../includes/init.php';
require_once ROOT_PATH . '/includes/connect_db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['user_id'])) {
    if (!hash_equals($_SESSION['csrf_token'] ?? '', $_POST['csrf_token'] ?? '')) {
        die('Invalid CSRF token.');
    }

    $tip_id  = (int) ($_POST['id'] ?? 0);
    $user_id = (int) $_SESSION['user_id'];

    $stmt = $link->prepare("DELETE FROM community_tips WHERE id = ? AND user_id = ?");
    if ($stmt) {
        $stmt->bind_param("ii", $tip_id, $user_id);
        $stmt->execute();
        $stmt->close();
    }
}

mysqli_close($link);
header("Location: /pages/community/community.php");
exit();