<?php
require_once __DIR__ . '/includes/init.php';   // starts the session once
// Include database connection
require('includes/connect_db.php');

// Retrieve user ID from session
$user_id = $_SESSION['id'];

// Fetch booking history for the logged-in user
$query = "
    SELECT 
        bookings.bookid AS booking_id, 
        movie_listings.movie_title AS movie_title, 
        bookings.date AS booking_date, 
        bookings.seats AS seats, 
        bookings.total AS total_amount
    FROM bookings 
    INNER JOIN movie_listings ON bookings.movie_id = movie_listings.movie_id
    WHERE bookings.id = ?
    ORDER BY bookings.date DESC
";

$stmt = mysqli_prepare($link, $query);

// Check if statement is prepared successfully
if (!$stmt) {
    die('Query preparation failed: ' . mysqli_error($link));
}

mysqli_stmt_bind_param($stmt, 'i', $user_id);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $booking_id, $movie_title, $booking_date, $seats, $total_amount);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking History</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Contrasting section style */
        .contrasting-section {
            background-color: #f8f9fa; /* Light gray background for contrast */
            padding: 20px;
            border-radius: 10px;
        }
    </style>
</head>
<body>
    <?php include('includes/nav.php'); ?>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Booking History</h1>
        <section class="contrasting-section">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>QR Code</th>
                            <th>Movie</th>
                            <th>Booking Date</th>
                            <th>Seats</th>
                            <th>Total Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $has_rows = false;
                        while (mysqli_stmt_fetch($stmt)): 
                            $has_rows = true; ?>
                            <tr>
                                <td>
                                    <li class="list-group-item d-flex justify-content-center">
                                        <img width="256" class="img-thumbnail" alt="QR Code" 
                                             src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=Booking-<?php echo urlencode($movie_title); ?>">
                                    </li>
                                </td>
                                <td><?php echo htmlspecialchars($movie_title); ?></td>
                                <td><?php echo htmlspecialchars($booking_date); ?></td>
                                <td><?php echo htmlspecialchars($seats); ?></td>
                                <td>&pound;<?php echo number_format($total_amount, 2); ?></td>
                            </tr>
                        <?php endwhile; ?>

                        <?php if (!$has_rows): ?>
                            <tr>
                                <td colspan="5" class="text-center">You have no booking history.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </section>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <?php include('includes/footer.php'); ?>
</body>
</html>

<?php
// Close the statement and database connection
mysqli_stmt_close($stmt);
mysqli_close($link);
?>
