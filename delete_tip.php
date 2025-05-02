<?php
require_once 'includes/init.php';
require_once 'includes/connect_db.php';

if (isset($_GET['id'], $_SESSION['user_id'])) {
    $tip_id = (int) $_GET['id'];
    $user_id = $_SESSION['user_id'];

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
