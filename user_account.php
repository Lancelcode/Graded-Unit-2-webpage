<?php require_once 'includes/init.php'; ?>
<?php require_once 'includes/connect_db.php'; ?>
<?php include 'includes/nav.php'; ?>

<?php
if (!isset($_SESSION['id'])) {
    require 'login_tools.php';
    load();
}

$user_id = $_SESSION['id'];
$q = "SELECT * FROM new_users WHERE id = $user_id";
$r = mysqli_query($link, $q);

if (mysqli_num_rows($r) > 0) {
    $row = mysqli_fetch_array($r, MYSQLI_ASSOC);
    $username = htmlspecialchars($row['username']);
    $email = htmlspecialchars($row['email']);
    $date = date('d/m/Y', strtotime($row['created_at']));
    ?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>My Profile | GreenScore</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <link rel="stylesheet" href="style.css">
    </head>
    <body>

    <div class="container mt-5">
        <h2 class="mb-4 text-success">👤 My Profile</h2>

        <div class="row">
            <!-- Left Side: User Info -->
            <div class="col-md-6 mb-4">
                <ul class="list-group">
                    <li class="list-group-item"><strong>Username:</strong> <?= $username ?></li>
                    <li class="list-group-item"><strong>User ID:</strong> EC2024/<?= $user_id ?></li>
                    <li class="list-group-item"><strong>Email:</strong> <?= $email ?></li>
                    <li class="list-group-item"><strong>Member Since:</strong> <?= $date ?></li>
                </ul>

                <ul class="list-group mt-4">
                    <li class="list-group-item">
                        <a href="my_impact.php" class="text-success">📈 My Impact Report</a>
                    </li>
                    <li class="list-group-item">
                        <a href="certificate_preview.php" class="text-success">🏅 Certificate History</a>
                    </li>
                    <li class="list-group-item">
                        <a href="green_calculator.php" class="text-success">🧮 Take Green Calculator</a>
                    </li>
                </ul>
            </div>

            <!-- Right Side: Credit Card Form -->
            <div class="col-md-6">
                <h4 class="mb-3">💳 Add Credit Card</h4>
                <form action="manage_credit_card.php" method="POST">
                    <input type="hidden" name="action" value="add">

                    <div class="form-group">
                        <label for="cardNumber">Card Number</label>
                        <input type="text" class="form-control" name="cardNumber" required>
                    </div>

                    <div class="form-group">
                        <label for="expiryDate">Expiry Date</label>
                        <input type="date" class="form-control" name="expiryDate" required>
                    </div>

                    <div class="form-group">
                        <label for="cardHolder">Cardholder Name</label>
                        <input type="text" class="form-control" name="cardHolder" required>
                    </div>

                    <div class="form-group">
                        <label for="cvv">CVV (Optional)</label>
                        <input type="password" class="form-control" name="cvv">
                    </div>

                    <div class="d-flex justify-content-between">
                        <button type="submit" class="btn btn-success">💾 Save</button>
                        <a href="view_cards.php" class="btn btn-outline-secondary">🔍 View Cards</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php include 'includes/footer.php'; ?>

    <!-- Bootstrap Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    </body>
    </html>

    <?php
} else {
    echo '<div class="container mt-5"><div class="alert alert-warning">User not found.</div></div>';
}
mysqli_close($link);
?>
