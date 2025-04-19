<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}
require('includes/connect_db.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Snack-MANIA! - I-Cinema</title>
    <!-- Bootstrap 4.5.2 CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php include('includes/nav.php'); ?>

<div class="container mt-5">
    <!-- Page Banner -->
    <div class="banner">
        <h1>Welcome to Snack-MANIA!</h1>
        <p>Indulge in our wide range of delicious snacks and refreshing beverages. Perfect for your movie experience!</p>
    </div>

    <!-- Snacks Section -->
    <div class="row">
        <!-- Snack Item 1 -->
        <div class="col-md-4 mb-4">
            <div class="card snack-card">
                <img src="https://via.placeholder.com/400x200?text=Popcorn" alt="Popcorn">
                <div class="card-body">
                    <h5>Classic Butter Popcorn</h5>
                    <p>Freshly popped buttery goodness to complement your movie time.</p>
                    <p class="price">$5.99</p>
                    <button class="btn add-to-cart-btn btn-block">Add to Cart</button>
                </div>
            </div>
        </div>
        <!-- Snack Item 2 -->
        <div class="col-md-4 mb-4">
            <div class="card snack-card">
                <img src="https://via.placeholder.com/400x200?text=Soda" alt="Soda">
                <div class="card-body">
                    <h5>Refreshing Soda</h5>
                    <p>Choose from a variety of flavors: Cola, Sprite, Orange, and more.</p>
                    <p class="price">$2.99</p>
                    <button class="btn add-to-cart-btn btn-block">Add to Cart</button>
                </div>
            </div>
        </div>
        <!-- Snack Item 3 -->
        <div class="col-md-4 mb-4">
            <div class="card snack-card">
                <img src="https://via.placeholder.com/400x200?text=Nachos" alt="Nachos">
                <div class="card-body">
                    <h5>Cheesy Nachos</h5>
                    <p>Crispy nachos served with warm, gooey cheese dip.</p>
                    <p class="price">$4.99</p>
                    <button class="btn add-to-cart-btn btn-block">Add to Cart</button>
                </div>
            </div>
        </div>
        <!-- Additional snack items -->
        <!-- Add as needed -->
    </div>
</div>
<?php include('includes/footer.php'); ?>
<!-- Bootstrap 4.5.2 JS -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>