<?php
require_once __DIR__ . '/includes/init.php';   // starts the session once
// Redirect to login if the user is not authenticated
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}  // starts the session once
?>
<?php require('includes/connect_db.php'); ?>
<?php

if (isset($_GET['id'])) {
    $item_id = mysqli_real_escape_string($link, $_GET['id']);
    $query = "DELETE FROM products WHERE item_id='$item_id'";
    $result = mysqli_query($link, $query);

    if ($result) {
        header('Location: admin_panel.php');
        exit();
    } else {
        echo "Error deleting product: " . mysqli_error($link);
    }
}
?>
