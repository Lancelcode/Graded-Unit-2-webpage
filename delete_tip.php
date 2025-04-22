<?php
require_once 'includes/init.php';
require_once 'includes/connect_db.php';

if (!isset($_GET['id']) || !isset($_SESSION['id'])) {
    header('Location: community.php');
    exit();
}

$id = (int)$_GET['id'];
$user_id = $_SESSION['id'];

mysqli_query($link, "DELETE FROM community_tips WHERE id = $id AND user_id = $user_id");

header('Location: community.php');
exit();
