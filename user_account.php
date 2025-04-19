<?php
session_start();


if (!isset($_SESSION['id'])) {
    require('login_tools.php');
    load();
}

require('includes/connect_db.php');

// Fetch user details from the database
$q = "SELECT * FROM new_users WHERE id={$_SESSION['id']}";
$r = mysqli_query($link, $q);

if (mysqli_num_rows($r) > 0) {
    $row = mysqli_fetch_array($r, MYSQLI_ASSOC);
    $date = $row["created_at"];
    $day = substr($date, 8, 2);
    $month = substr($date, 5, 2);
    $year = substr($date, 0, 4);
    $username = htmlspecialchars($row['username']);
    $email = htmlspecialchars($row['email']);
    $userId = htmlspecialchars($row['id']);
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>User Account</title>
        <!-- Bootstrap 4.6 CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
        <link rel="stylesheet" href="style.css">
        
    </head>
    <body>
    <?php include('includes/nav.php'); ?>
    <div class="container">
        <div class="row">
            <!-- Left Column: User Profile and User Information -->
            <div class="col-md-6">
                <!-- User Profile -->
                <div class="mb-4">
                    <ul class="list-group">
                        <li class="list-group-item"><h1><?php echo $username; ?>'s Profile</h1></li>
                        <li class="list-group-item"><strong>User ID:</strong> EC2024/<?php echo $userId; ?></li>
                        <li class="list-group-item"><strong>Email:</strong> <?php echo $email; ?></li>
                        <li class="list-group-item"><strong>Registration Date:</strong> <?php echo "$day/$month/$year"; ?></li>
                    </ul>
                </div>

                <!-- User Actions -->
                <div>
                    <ul class="list-group">
                        <li class="list-group-item">
                            <a href="booking.php">
                                <span class="icon"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-bookmark" viewBox="0 0 16 16">
                                    <path d="M2 2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v13.5a.5.5 0 0 1-.777.416L8 13.101l-5.223 2.815A.5.5 0 0 1 2 15.5zm2-1a1 1 0 0 0-1 1v12.566l4.723-2.482a.5.5 0 0 1 .554 0L13 14.566V2a1 1 0 0 0-1-1z"/>
                                </svg></span> Most Recent Booking
                            </a>
                        </li>
                        <li class="list-group-item">
                            <a href="booking_history.php">
                                <span class="icon"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-bookmark-check-fill" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M2 15.5V2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v13.5a.5.5 0 0 1-.74.439L8 13.069l-5.26 2.87A.5.5 0 0 1 2 15.5m8.854-9.646a.5.5 0 0 0-.708-.708L7.5 7.793 6.354 6.646a.5.5 0 1 0-.708.708l1.5 1.5a.5.5 0 0 0 .708 0z"/>
                                </svg></span> Booking History
                            </a>
                        </li>
                        <li class="list-group-item">
                            <a href="movie_reviews.php">
                                <span class="icon"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-journal-bookmark-fill" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M6 1h6v7a.5.5 0 0 1-.757.429L9 7.083 6.757 8.43A.5.5 0 0 1 6 8z"/>
                                    <path d="M3 0h10a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-1h1v1a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H3a1 1 0 0 0-1 1v1H1V2a2 2 0 0 1 2-2"/>
                                </svg></span> Reviews
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Right Column: Add Credit Card -->
            <div class="col-md-6">
                <h3>Add Credit Card</h3>
                <form action="manage_credit_card.php" method="post">
                    <input type="hidden" name="action" value="add">
                    <div class="mb-3">
                        <label for="cardNumber" class="form-label">Card Number</label>
                        <input type="text" class="form-control" id="cardNumber" name="cardNumber" placeholder="Enter card number" required>
                    </div>
                    <div class="mb-3">
                        <label for="expiryDate" class="form-label">Expiry Date</label>
                        <input type="date" class="form-control" id="expiryDate" name="expiryDate" required>
                    </div>
                    <div class="mb-3">
                        <label for="cardHolder" class="form-label">Cardholder Name</label>
                        <input type="text" class="form-control" id="cardHolder" name="cardHolder" placeholder="Enter cardholder name" required>
                    </div>
                    <div class="mb-3">
                        <label for="cvv" class="form-label">CVV (Optional)</label>
                        <input type="password" class="form-control" id="cvv" name="cvv" placeholder="Enter CVV">
                    </div>
                    <button type="submit" class="btn btn-primary">Save</button>
                    <a href="view_cards.php" class="btn btn-secondary">View Cards</a>
                </form>
            </div>
        </div>
    </div>
    <?php include('includes/footer.php'); ?>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"></script>
    </body>
    </html>
<?php
} else {
    echo '<h3>No user details found.</h3>';
}
mysqli_close($link);
