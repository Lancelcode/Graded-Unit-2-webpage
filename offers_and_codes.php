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
    <title>Offers & Codes - I-Cinema</title>
    <!-- Bootstrap 4.5.2 CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php include('includes/nav.php'); ?>

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
