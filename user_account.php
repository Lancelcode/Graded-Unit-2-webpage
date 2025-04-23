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
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="style.css">
    </head>
    <body>

    <div class="container mt-5">
        <h1 class="text-success mb-4">👤 My Profile</h1>

        <div class="row">
            <!-- User Info -->
            <div class="col-md-6">
                <div class="card shadow-sm mb-4">
                    <div class="card-body">
                        <h5 class="card-title">Account Details</h5>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item"><strong>Username:</strong> <?= $username ?></li>
                            <li class="list-group-item"><strong>User ID:</strong> EC2024/<?= $user_id ?></li>
                            <li class="list-group-item"><strong>Email:</strong> <?= $email ?></li>
                            <li class="list-group-item"><strong>Member Since:</strong> <?= $date ?></li>
                        </ul>
                    </div>
                </div>

                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Actions</h5>
                        <a href="my_impact.php" class="btn btn-outline-success w-100 mb-2">📈 View My Impact</a>
                        <a href="certificate_history.php" class="btn btn-outline-success w-100 mb-2">🏅 Certificate History</a>
                        <a href="green_calculator.php" class="btn btn-outline-success w-100">🧮 Take Green Calculator</a>
                    </div>
                </div>
            </div>

            <!-- Credit Card -->
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">💳 Add Credit Card</h5>
                        <form action="manage_credit_card.php" method="POST">
                            <input type="hidden" name="action" value="add">
                            <div class="mb-3">
                                <label for="cardNumber" class="form-label">Card Number</label>
                                <input type="text" class="form-control" name="cardNumber" required>
                            </div>
                            <div class="mb-3">
                                <label for="expiryDate" class="form-label">Expiry Date</label>
                                <input type="date" class="form-control" name="expiryDate" required>
                            </div>
                            <div class="mb-3">
                                <label for="cardHolder" class="form-label">Cardholder Name</label>
                                <input type="text" class="form-control" name="cardHolder" required>
                            </div>
                            <div class="mb-3">
                                <label for="cvv" class="form-label">CVV <small>(optional)</small></label>
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
        </div>
    </div>

    <?php include 'includes/footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    </body>
    </html>

    <?php
} else {
    echo '<div class="container mt-5"><div class="alert alert-warning">User not found.</div></div>';
}
mysqli_close($link);
?>
