<?php
require_once 'includes/init.php';
require_once 'includes/connect_db.php';

// FIX: was a GET request — any link could trigger a delete without user knowledge
// Now requires POST + CSRF
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
header("Location: community.php");
exit();