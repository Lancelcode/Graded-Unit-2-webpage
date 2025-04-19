<?session_start();
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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $item_name = mysqli_real_escape_string($link, $_POST['item_name']);
    $item_desc = mysqli_real_escape_string($link, $_POST['item_desc']);
    $item_img = mysqli_real_escape_string($link, $_POST['item_img']);
    $item_price = mysqli_real_escape_string($link, $_POST['item_price']);

    $query = "INSERT INTO products (item_name, item_desc, item_img, item_price) VALUES ('$item_name', '$item_desc', '$item_img', '$item_price')";
    $result = mysqli_query($link, $query);

    if ($result) {
        header('Location: admin_panel.php');
        exit();
    } else {
        echo "Error creating product: " . mysqli_error($link);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Product</title>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <link rel="stylesheet" href="style.css">
</head>
<body>
<?php include('includes/nav.php'); ?>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Create Product</div>
                <div class="card-body">
                    <form action="create.php" method="POST">
                        <div class="form-group">
                            <label for="item_name">Name</label>
                            <input type="text" class="form-control" id="item_name" name="item_name" required>
                        </div>
                        <div class="form-group">
                            <label for="item_desc">Description</label>
                            <textarea class="form-control" id="item_desc" name="item_desc" rows="3" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="item_img">Image URL</label>
                            <input type="text" class="form-control" id="item_img" name="item_img" required>
                        </div>
                        <div class="form-group">
                            <label for="item_price">Price</label>
                            <input type="number" class="form-control" id="item_price" name="item_price" step="0.01" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Create</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include('includes/footer.php'); ?>
</body>
</html>
