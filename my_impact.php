<?php
require_once 'includes/init.php';
require_once 'includes/connect_db.php';
include 'includes/nav.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Impact Report | GreenScore</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap & FontAwesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
    <style>
        html, body {
            height: 100%;
            margin: 0;
        }

        body {
            background: url('assets/images/forest-hero.jpg') center/cover no-repeat fixed;
            position: relative;
            color: #fff;
            display: flex;
            flex-direction: column;
        }

        body::before {
            content: '';
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.6);
            z-index: -1;
        }

        .content-wrapper {
            flex-grow: 1;
            padding: 4rem 1rem;
        }

        .card-bg {
            background: rgba(255, 255, 255, 0.95);
            color: #333;
            padding: 2rem;
            border-radius: 1rem;
            box-shadow: 0 0 12px rgba(0, 0, 0, 0.2);
        }

        .progress {
            height: 20px;
        }

        .badge-box {
            font-size: 1.2rem;
            font-weight: bold;
        }

        .btn-outline-light:hover {
            background-color: #fff;
            color: #198754;
        }

        footer {
            position: relative;
            z-index: 1;
        }
    </style>
</head>
<body>

<div class="container content-wrapper">
    <h1 class="text-white text-center mb-5">📊 My Sustainability Impact</h1>

    <?php
    if (!isset($_SESSION['user_id'])) {
        echo "<div class='alert alert-warning'>Please <a href='login.php'>log in</a> to view your impact report.</div>";
        include 'includes/footer.php';
        exit();
    }

    $user_id = $_SESSION['user_id'];

    $total     = mysqli_fetch_assoc(mysqli_query($link, "SELECT COUNT(*) AS total FROM green_calculator_results WHERE user_id = $user_id"))['total'] ?? 0;
    $green     = mysqli_fetch_assoc(mysqli_query($link, "SELECT SUM(green_count) AS green FROM green_calculator_results WHERE user_id = $user_id"))['green'] ?? 0;
    $donation  = mysqli_fetch_assoc(mysqli_query($link, "SELECT SUM(donation_cost) AS donation FROM green_calculator_results WHERE user_id = $user_id"))['donation'] ?? 0;

    $badge = "🪴 Eco Newbie";
    if ($green >= 50) {
        $badge = "🌟 Green Warrior";
    } elseif ($green >= 30) {
        $badge = "🌿 Eco Explorer";
    } elseif ($green >= 15) {
        $badge = "🌱 Green Starter";
    }

    $greenPercent = min(100, round(($green / 100) * 100));
    ?>

    <div class="card card-bg shadow mb-5">
        <h3 class="mb-3 text-success">🧾 Report Summary</h3>
        <p><strong>Total Submissions:</strong> <?= $total ?></p>
        <p><strong>Green Answers Earned:</strong> <?= $green ?> / 100</p>
        <p><strong>Total Donations:</strong> £<?= number_format($donation, 2) ?></p>

        <div class="mb-3">
            <label class="form-label">Your Green Journey Progress</label>
            <div class="progress">
                <div class="progress-bar bg-success" style="width: <?= $greenPercent ?>%;" role="progressbar">
                    <?= $greenPercent ?>%
                </div>
            </div>
        </div>

        <p class="badge-box">🏅 Current Badge: <span class="text-success"><?= $badge ?></span></p>
    </div>

    <div class="text-center">
        <a href="certificate_history.php" class="btn btn-outline-light me-2">📄 View Certificates</a>
        <a href="green_calculator.php" class="btn btn-outline-success">🧮 Take the Calculator Again</a>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php mysqli_close($link); ?>
