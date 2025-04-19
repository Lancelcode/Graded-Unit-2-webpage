<?php session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}?>
<?php require('includes/connect_db.php'); ?>
<?php
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

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
