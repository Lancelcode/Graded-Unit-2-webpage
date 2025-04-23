<?php
require_once 'includes/init.php';
require_once 'includes/connect_db.php';

if ($_SESSION['role'] !== 'admin') {
    header('Location: index.php');
    exit();
}

foreach ($_POST['admin_response'] as $id => $response) {
    $id = (int) $id;
    $response = mysqli_real_escape_string($link, $response);
    $visible = isset($_POST['visible'][$id]) ? 1 : 0;

    $query = "UPDATE feedback SET visible = $visible, admin_response = '$response' WHERE id = $id";
    mysqli_query($link, $query);
}

header("Location: admin_feedback.php");
exit();
