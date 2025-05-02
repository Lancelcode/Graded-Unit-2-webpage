<?php
require 'includes/init.php';
require 'includes/connect_db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
mysqli_query($link, "DELETE FROM community_tips WHERE user_id = $user_id");

header("Location: community.php");
exit();
