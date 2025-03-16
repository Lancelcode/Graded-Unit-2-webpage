<?php
session_start();
require('includes/connect_db.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Offers & Codes - I-Cinema</title>
    <!-- Bootstrap 4.5.2 CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            background-color: #001c35; /* Deep bluish background */
            color: #ffffff;
            font-family: 'Roboto', sans-serif;
        }
        .offer-card {
            border-radius: 15px;
            overflow: hidden;
            background-color: #002c5f; /* Dark bluish card */
            color: #ffffff;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        .offer-card:hover {
            transform: scale(1.05);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.3);
        }
        .offer-card img {
            width: 100%;
            height: 150px;
            object-fit: cover;
        }
        .offer-card h5 {
            font-size: 1.25rem;
            font-weight: bold;
            color: #1eb1f6; /* Light blue text for headings */
        }
        .offer-card p {
            font-size: 0.9rem;
            color: #d0eaff; /* Soft blue for descriptions */
        }
        .coupon-code {
            font-size: 1.2rem;
            font-weight: bold;
            color: #ffcc00;
            background-color: #004d7a; /* Slightly lighter blue */
            padding: 10px 15px;
            border-radius: 5px;
            display: inline-block;
            margin-top: 10px;
        }
        .copy-btn {
            margin-left: 10px;
            font-size: 0.9rem;
            padding: 5px 10px;
            background-color: #ffcc00;
            color: #00293c;
            border: none;
            transition: background-color 0.3s ease;
        }
        .copy-btn:hover {
            background-color: #e6b800;
        }
        .banner {
            background: linear-gradient(to right, #002c5f, #003d7a); /* Gradient for banner */
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
        <h1>Special Offers & Promo Codes</h1>
        <p>Save big on your favorite movies and snacks! Check out our latest deals below.</p>
    </div>

    <!-- Offers Section -->
    <div class="row">
        <!-- Example Offer Card 1 -->
        <div class="col-md-4 mb-4">
            <div class="card offer-card">
                <img src="https://via.placeholder.com/400x200?text=Free+Popcorn" alt="Free Popcorn Offer">
                <div class="card-body">
                    <h5>Free Popcorn with Every Ticket</h5>
                    <p>Enjoy a free medium popcorn when you book two or more tickets. Valid for a limited time only.</p>
                    <div>
                        <span class="coupon-code">FREEPOP</span>
                        <button class="btn copy-btn" onclick="copyCode('FREEPOP')">Copy</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Example Offer Card 2 -->
        <div class="col-md-4 mb-4">
            <div class="card offer-card">
                <img src="https://via.placeholder.com/400x200?text=20%25+Off" alt="20% Off Offer">
                <div class="card-body">
                    <h5>20% Off on Weekend Bookings</h5>
                    <p>Book your tickets for Saturday or Sunday and get 20% off on your total bill.</p>
                    <div>
                        <span class="coupon-code">WEEKEND20</span>
                        <button class="btn copy-btn" onclick="copyCode('WEEKEND20')">Copy</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Example Offer Card 3 -->
        <div class="col-md-4 mb-4">
            <div class="card offer-card">
                <img src="https://via.placeholder.com/400x200?text=Buy+1+Get+1" alt="Buy 1 Get 1 Offer">
                <div class="card-body">
                    <h5>Buy 1 Get 1 Free on IMAX Tickets</h5>
                    <p>Experience the ultimate IMAX viewing. Buy one ticket and get the second one absolutely free.</p>
                    <div>
                        <span class="coupon-code">IMAXB1G1</span>
                        <button class="btn copy-btn" onclick="copyCode('IMAXB1G1')">Copy</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Function to copy coupon code to clipboard
    function copyCode(code) {
        navigator.clipboard.writeText(code).then(() => {
            alert('Coupon code "' + code + '" copied to clipboard!');
        });
    }
</script>

<!-- Bootstrap 4.5.2 JS -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
