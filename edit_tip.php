<?php
require_once 'includes/init.php';
require_once 'includes/connect_db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['tip_id'], $_POST['message'], $_SESSION['id'])) {
    $tip_id = (int)$_POST['tip_id'];
    $message = trim($_POST['message']);
    $user_id = $_SESSION['id'];

    if (!empty($message)) {
        $stmt = $link->prepare("UPDATE community_tips SET message = ? WHERE id = ? AND user_id = ?");
        $stmt->bind_param("sii", $message, $tip_id, $user_id);
        $stmt->execute();
        $stmt->close();
    }
}

mysqli_close($link);
header("Location: community.php");
exit();
