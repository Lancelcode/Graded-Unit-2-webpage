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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $item_id = mysqli_real_escape_string($link, $_POST['item_id']);
    $item_name = mysqli_real_escape_string($link, $_POST['item_name']);
    $item_desc = mysqli_real_escape_string($link, $_POST['item_desc']);
    $item_img = mysqli_real_escape_string($link, $_POST['item_img']);
    $item_price = mysqli_real_escape_string($link, $_POST['item_price']);

    $query = "UPDATE products SET item_name='$item_name', item_desc='$item_desc', item_img='$item_img', item_price='$item_price' WHERE item_id='$item_id'";
    $result = mysqli_query($link, $query);

    if ($result) {
        header('Location: admin_panel.php');
        exit();
    } else {
        echo "Error updating product: " . mysqli_error($link);
    }
}

if (isset($_GET['id'])) {
    $item_id = mysqli_real_escape_string($link, $_GET['id']);

    $query = "SELECT * FROM products WHERE item_id='$item_id'";
    $result = mysqli_query($link, $query);

    if ($result && mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        $item_name = $row['item_name'];
        $item_desc = $row['item_desc'];
        $item_img = $row['item_img'];
        $item_price = $row['item_price'];
    } else {
        echo "Error fetching product: " . mysqli_error($link);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Product</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<?php include('includes/nav.php'); ?>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Update Product</div>
                <div class="card-body">
                    <form action="update.php" method="POST">
                        <input type="hidden" name="item_id" value="<?php echo $item_id; ?>">
                        <div class="form-group">
                            <label for="item_name">Name</label>
                            <input type="text" class="form-control" id="item_name" name="item_name" value="<?php echo $item_name; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="item_desc">Description</label>
                            <textarea class="form-control" id="item_desc" name="item_desc" rows="3" required><?php echo $item_desc; ?></textarea>
                        </div>
                        <div class="form-group">
                            <label for="item_img">Image URL</label>
                            <input type="text" class="form-control" id="item_img" name="item_img" value="<?php echo $item_img; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="item_price">Price</label>
                            <input type="number" class="form-control" id="item_price" name="item_price" step="0.01" value="<?php echo $item_price; ?>" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include('includes/footer.php'); ?>
</body>
</html>
