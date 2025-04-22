<?php
require 'includes/init.php';
require 'includes/connect_db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty(trim($_POST['message']))) {
    $msg = mysqli_real_escape_string($link, trim($_POST['message']));

    $query = "INSERT INTO community_tips (message) VALUES ('$msg')";
    mysqli_query($link, $query);
}

mysqli_close($link);
header('Location:community.php');
exit();
