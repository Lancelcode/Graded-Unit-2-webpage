<?php
require_once 'includes/init.php';
require_once 'includes/connect_db.php';

// Generate CSRF token if not already set
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    require 'includes/login_tools.php';
    load();
}

$user_id = (int) $_SESSION['user_id'];

// Fetch user info including new fields
$q = "SELECT username, email, created_at, status, company_name, contact_person, phone_number FROM new_users WHERE id = ?";
$stmt = mysqli_prepare($link, $q);
mysqli_stmt_bind_param($stmt, 'i', $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) > 0):
    $row = mysqli_fetch_assoc($result);
    $username = htmlspecialchars($row['username']);
    $email = htmlspecialchars($row['email']);
    $date = date('d/m/Y', strtotime($row['created_at']));
    $status = htmlspecialchars($row['status']);
    $company = htmlspecialchars($row['company_name'] ?? '—');
    $contact = htmlspecialchars($row['contact_person'] ?? '—');
    $phone = htmlspecialchars($row['phone_number'] ?? '—');
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>My Profile | GreenScore</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="style.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        <style>
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
            .content-wrapper {
                position: relative;
                z-index: 1;
                padding: 4rem 0;
            }
            .card-bg {
                background: rgba(255,255,255,0.85);
            }
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
                            <li class="list-group-item"><strong>Company:</strong> <?= $company ?></li>
                            <li class="list-group-item"><strong>Contact Person:</strong> <?= $contact ?></li>
                            <li class="list-group-item"><strong>Phone Number:</strong> <?= $phone ?></li>
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
                        <a href="green_calculator.php" class="btn btn-success mb-3">🧮 Take Green Calculator</a>
                        <?php
                        $btnClass = 'btn-info';
                        if ($status === 'inactive') $btnClass = 'btn-warning';
                        elseif ($status === 'deactivated') $btnClass = 'btn-dark';
                        ?>
                        <button class="btn <?= $btnClass ?> mt-auto" disabled>
                            🔖 Status: <?= ucfirst($status) ?>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Credit Card Form -->
            <div class="col-12">
                <div class="card card-bg shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">💳 Add Credit Card</h5>
                        <form action="manage_credit_card.php" method="POST" class="row g-3">
                            <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token']; ?>">
                            <input type="hidden" name="action" value="add">

                            <div class="col-md-6">
                                <label for="cardNumber" class="form-label">Card Number</label>
                                <input type="text" class="form-control" name="card_number" id="cardNumber" required>
                            </div>
                            <div class="col-md-3">
                                <label for="expiryDate" class="form-label">Expiry Date</label>
                                <input type="date" class="form-control" name="expiry_date" id="expiryDate" required>
                            </div>
                            <div class="col-md-3">
                                <label for="cvv" class="form-label">CVV</label>
                                <input type="text" class="form-control" name="cvv" id="cvv" required>
                            </div>
                            <div class="col-12">
                                <label for="cardHolder" class="form-label">Cardholder Name</label>
                                <input type="text" class="form-control" name="card_name" id="cardHolder" required>
                            </div>
                            <div class="row g-3 mt-3">
                                <div class="col-md-6">
                                    <button type="submit" class="btn btn-success w-100">💾 Add Card</button>
                                </div>
                                <div class="col-md-6">
                                    <a href="view_cards.php" class="btn btn-outline-dark w-100">📄 View Cards</a>
                                </div>
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
    header('Location: login.php');
    exit();
endif;

mysqli_free_result($result);
mysqli_close($link);
