<?php session_start(); ?>
<?php require('includes/connect_db.php'); ?>
<?php
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<?php include('includes/nav.php'); ?>
<div class="container mt-5">
    <h1>Welcome, Admin!</h1>
    <p><a href="create.php" class="btn btn-primary">Create Product</a></p>
    <table class="table">
        <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Description</th>
            <th>Image</th>
            <th>Price</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $query = "SELECT * FROM products";
        $result = mysqli_query($link, $query);
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>{$row['item_id']}</td>";
            echo "<td>{$row['item_name']}</td>";
            echo "<td>{$row['item_desc']}</td>";
            echo "<td><img src='{$row['item_img']}' width='50' alt='Product Image'></td>";
            echo "<td>{$row['item_price']}</td>";
            echo "<td>
                    <a href='update.php?id={$row['item_id']}' class='btn btn-sm btn-warning'>Edit</a>
                    <a href='delete.php?id={$row['item_id']}' class='btn btn-sm btn-danger'>Delete</a>
                  </td>";
            echo "</tr>";
        }
        ?>
        </tbody>
    </table>
</div>
<?php include('includes/footer.php'); ?>
</body>
</html>
