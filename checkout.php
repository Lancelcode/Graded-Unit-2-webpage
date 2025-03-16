<?php
session_start();

if (!isset($_SESSION['id'])) {
    header('Location: login.php');
    exit();
}

if (empty($_SESSION['cart'])) {
    echo '<div class="alert alert-warning">Your cart is empty. Please add movies to your cart.</div>';
    exit();
}

// Calculate total
$total = 0;
foreach ($_SESSION['cart'] as $movie_id => $details) {
    $total += $details['quantity'] * $details['price'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php include('includes/nav1.php'); ?>

<div class="container mt-5">
    <h1>Checkout</h1>
    <h3>Total Amount: £<?php echo number_format($total, 2); ?></h3>
    <form action="payment_success.php" method="GET">
        <input type="hidden" name="total" value="<?php echo $total; ?>">
        <button type="submit" class="btn btn-primary">Confirm and Pay</button>
    </form>
</div>

<?php include('includes/footer2.php'); ?>
</body>
</html>
