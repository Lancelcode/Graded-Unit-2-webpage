<?php
require_once 'includes/init.php';
require_once 'includes/connect_db.php';

if (!isset($_SESSION['id'])) {
    require 'login_tools.php';
    load();
}

$user_id = $_SESSION['id'];
$q       = "SELECT * FROM new_users WHERE id = $user_id";
$r       = mysqli_query($link, $q);

if (mysqli_num_rows($r) > 0):
    $row      = mysqli_fetch_array($r, MYSQLI_ASSOC);
    $username = htmlspecialchars($row['username']);
    $email    = htmlspecialchars($row['email']);
    $date     = date('d/m/Y', strtotime($row['created_at']));
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>My Profile | GreenScore</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <style>
            /* Full-page forest background + overlay */
            body {
                min-height: 100vh;
                margin: 0;
                background: url('assets/images/forest-hero.jpg') center/cover no-repeat fixed;
                position: relative;
            }
            body::before {
                content: '';
                position: absolute;
                inset: 0;
                background: rgba(0,0,0,0.5);
                z-index: 0;
            }
            /* Everything in here floats above the overlay */
            .content-wrapper {
                position: relative;
                z-index: 1;
                padding: 4rem 0;
            }
            .card-bg {
                background: rgba(255,255,255,0.85);
            }
            /* Ensure footer text is legible */
            footer {
                position: relative;
                z-index: 1;
                color: #444;
                padding: 2rem 0;
            }
        </style>
    </head>
    <body>

    <?php include 'includes/nav.php'; ?>

    <div class="container content-wrapper">
        <h1 class="text-white text-center display-5 mb-5">
            👤 My Profile — Welcome, <span class="text-success"><?= $username ?></span>!
        </h1>

        <div class="row gy-4">
            <!-- Account Details -->
            <div class="col-md-6">
                <div class="card card-bg shadow-sm h-100">
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
            </div>

            <!-- Actions -->
            <div class="col-md-6">
                <div class="card card-bg shadow-sm h-100">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">Actions</h5>
                        <a href="my_impact.php" class="btn btn-success mb-3">📈 View My Impact</a>
                        <a href="certificate_history.php" class="btn btn-success mb-3">🏅 Certificate History</a>
                        <a href="green_calculator.php" class="btn btn-success">🧮 Take Green Calculator</a>
                    </div>
                </div>
            </div>

            <!-- Credit Card Form -->
            <div class="col-12">
                <div class="card card-bg shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">💳 Add Credit Card</h5>
                        <form action="manage_credit_card.php" method="POST" class="row g-3">
                            <input type="hidden" name="action" value="add">
                            <div class="col-md-6">
                                <label for="cardNumber" class="form-label">Card Number</label>
                                <input type="text" class="form-control" name="cardNumber" id="cardNumber" required>
                            </div>
                            <div class="col-md-3">
                                <label for="expiryDate" class="form-label">Expiry Date</label>
                                <input type="date" class="form-control" name="expiryDate" id="expiryDate" required>
                            </div>
                            <div class="col-md-3">
                                <label for="cvv" class="form-label">CVV</label>
                                <input type="password" class="form-control" name="cvv" id="cvv">
                            </div>
                            <div class="col-md-6">
                                <label for="cardHolder" class="form-label">Cardholder Name</label>
                                <input type="text" class="form-control" name="cardHolder" id="cardHolder" required>
                            </div>
                            <div class="col-12 d-flex justify-content-end">
                                <button type="submit" class="btn btn-success me-2">💾 Save</button>
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
else:
    echo '<div class="container mt-5"><div class="alert alert-warning">User not found.</div></div>';
endif;
mysqli_close($link);
