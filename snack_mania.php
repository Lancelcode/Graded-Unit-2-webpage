<?php
session_start();
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
    <style>
        body {
            background-color: #001f3f; /* Dark blue background */
            color: #ffffff;
            font-family: 'Roboto', sans-serif;
        }
        .snack-card {
            border-radius: 15px;
            overflow: hidden;
            background-color: #002f6c; /* Bluish card background */
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        .snack-card:hover {
            transform: scale(1.05);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.3);
        }
        .snack-card img {
            width: 100%;
            height: 150px;
            object-fit: cover;
        }
        .snack-card h5 {
            font-size: 1.3rem;
            font-weight: bold;
            color: #1eb1f6; /* Light blue heading */
        }
        .snack-card p {
            font-size: 0.9rem;
            color: #d0eaff; /* Softer blue for descriptions */
        }
        .snack-card .price {
            font-size: 1.2rem;
            font-weight: bold;
            color: #1eb1f6; /* Price matches heading */
        }
        .add-to-cart-btn {
            background-color: #1eb1f6;
            border: none;
            color: #001f3f;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }
        .add-to-cart-btn:hover {
            background-color: #148db3;
        }
        .banner {
            background: linear-gradient(to right, #003366, #004080);
            border-radius: 10px;
            padding: 20px;
            text-align: center;
            margin-bottom: 30px;
        }
        .banner h1 {
            font-size: 2.5rem;
            color: #1eb1f6;
            font-weight: bold;
        }
        .banner p {
            font-size: 1.2rem;
            color: #d0eaff;
        }
    </style>
</head>
<body>
<?php include('includes/nav1.php'); ?>

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

<!-- Bootstrap 4.5.2 JS -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>