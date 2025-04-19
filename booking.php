<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Most Recent Booking</title>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
</head>

<body>
<?php include('includes/nav.php'); ?>
<?php
# Ensure the user is logged in
if (!isset($_SESSION['id'])) {
    require('login_tools.php');
    load(); // Redirect to the login page
    exit();
}

# Get the logged-in user's ID
$user_id = $_SESSION['id'];

# Connect to the database
require('includes/nav.php');

# Check if the connection was successful
if (!$link) {
    die('Database connection failed: ' . mysqli_connect_error());
}

# Query to fetch the last booking for the logged-in user, including photo URL
$q = "
    SELECT 
        movie_listings.movie_title, 
        movie_listings.genre, 
        movie_listings.release, 
        movie_listings.duration, 
        movie_listings.age_rating, 
        movie_listings.further_info, 
        movie_listings.img, 
        bookings.seats, 
        bookings.total, 
        bookings.date, 
        bookings.time
    FROM bookings 
    INNER JOIN movie_listings 
        ON bookings.movie_id = movie_listings.movie_id 
    WHERE bookings.id = ? 
    ORDER BY bookings.date DESC 
    LIMIT 1
";

$stmt = mysqli_prepare($link, $q);

# Check if the query was prepared successfully
if (!$stmt) {
    die('Query preparation failed: ' . mysqli_error($link));
}

# Bind parameters and execute the statement
mysqli_stmt_bind_param($stmt, 'i', $user_id);
mysqli_stmt_execute($stmt);

# Bind result variables
mysqli_stmt_bind_result($stmt, $movie_title, $genre, $release, $duration, $age_rating, $further_info, $img, $seats, $total, $date, $time);

# Fetch and display the result
if (mysqli_stmt_fetch($stmt)) {
    echo '
    <div class="container mt-5">
        <h2>Most Recent Booking</h2>
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <img src="' . htmlspecialchars($img) . '" class="card-img-top img-thumbnail" alt="' . htmlspecialchars($movie_title) . '">
                    <div class="card-body">
                        <h3 class="card-title">' . htmlspecialchars($movie_title) . '</h3>
                        <p><strong>Genre:</strong> ' . htmlspecialchars($genre) . '</p>
                        <p><strong>Release Date:</strong> ' . htmlspecialchars($release) . '</p>
                        <p><strong>Duration:</strong> ' . htmlspecialchars($duration) . ' minutes</p>
                        <p><strong>Age Rating:</strong> ' . htmlspecialchars($age_rating) . '</p>
                        <p><strong>Seats:</strong> ' . htmlspecialchars($seats) . '</p>
                        <p><strong>Total Price:</strong> &pound;' . number_format($total, 2) . '</p>
                        <p><strong>Booking Date:</strong> ' . htmlspecialchars($date) . '</p>
                        <p><strong>Booking Time:</strong> ' . htmlspecialchars($time) . '</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body text-center">
                        <h4>Booking QR Code</h4>
                        <ul class="list-group">
                            <li class="list-group-item d-flex justify-content-center">
                                <img width="256" class="img-thumbnail" alt="QR Code" 
                                     src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=Booking-' . urlencode($movie_title) . '">
                            </li>
                        </ul>
                        <p class="mt-3">' . nl2br(htmlspecialchars($further_info)) . '</p>
                    </div>
                </div>
            </div>
        </div>
    </div>';
} else {
    echo '
    <div class="container mt-5">
        <div class="alert alert-warning">
            <h4>No recent bookings found.</h4>
            <p><a href="home.php" class="btn btn-primary">Explore Movies</a></p>
        </div>
    </div>';
}

# Close the statement and connection
mysqli_stmt_close($stmt);
mysqli_close($link);
?>

<?php include('includes/footer.php'); ?>
</body>
</html>
