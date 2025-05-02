<?php
require_once 'includes/init.php';
require_once 'includes/connect_db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['message']) && isset($_SESSION['user_id'])) {
    $message = trim($_POST['message']);
    $user_id = $_SESSION['user_id']; // Fixed session key

    if (!empty($message)) {
        $stmt = $link->prepare("INSERT INTO community_tips (user_id, message) VALUES (?, ?)");
        $stmt->bind_param("is", $user_id, $message);
        $stmt->execute();
        $stmt->close();
    }
}

mysqli_close($link);
header("Location: community.php");
exit();
