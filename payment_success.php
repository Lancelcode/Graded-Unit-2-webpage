<?php
session_start();
require('includes/connect_db.php');

if (!isset($_SESSION['id'])) {
    header('Location: login.php');
    exit();
}

if (empty($_SESSION['cart']) || !isset($_GET['total'])) {
    echo '<div class="alert alert-warning">Cart is empty or total not specified.</div>';
    exit();
}

$user_id = $_SESSION['id'];
$total = htmlspecialchars($_GET['total']);

// Insert booking details into the database
foreach ($_SESSION['cart'] as $movie_id => $details) {
    $quantity = $details['quantity'];
    $price = $details['price'];
    $subtotal = $quantity * $price;

    $q = "INSERT INTO bookings (seats, total, date, time, id, movie_id) VALUES (?, ?, NOW(), '12:00 PM', ?, ?)";
    $stmt = mysqli_prepare($link, $q);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, 'idii', $quantity, $subtotal, $user_id, $movie_id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    } else {
        echo '<div class="alert alert-danger">Error: ' . mysqli_error($link) . '</div>';
    }
}

// Clear the cart
unset($_SESSION['cart']);
mysqli_close($link);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Success</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php include('includes/nav.php'); ?>

<div class="container mt-5">
    <h1 class="text-success">Payment Successful!</h1>
    <h3>Thank you for your booking. We look forward to seeing you at the I-Cinema!</h3>
    <a href="index.php" class="btn btn-primary">Return to Home</a>
</div>

<?php include('includes/footer.php'); ?>
</body>
</html>
