<?php require_once 'includes/init.php'; ?>
<?php require_once 'includes/connect_db.php'; ?>
<?php include 'includes/nav.php'; ?>

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
        /* Ensure the body takes full height and content is pushed to the bottom */
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

        .content-wrapper {
            flex-grow: 1;
            padding: 4rem 1rem;
        }

        .card-bg {
            background: rgba(255, 255, 255, 0.9);
            color: #333;
            padding: 2rem;
            border-radius: 1rem;
        }

        .progress {
            height: 20px;
        }

        .badge-box {
            font-size: 1.2rem;
            font-weight: bold;
        }

        .footer {
            margin-top: auto;
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

    $total_q     = "SELECT COUNT(*) AS total FROM green_calculator_results WHERE user_id = $user_id";
    $green_q     = "SELECT SUM(green_count) AS green FROM green_calculator_results WHERE user_id = $user_id";
    $donation_q  = "SELECT SUM(donation_cost) AS donation FROM green_calculator_results WHERE user_id = $user_id";

    $total     = mysqli_fetch_assoc(mysqli_query($link, $total_q))['total'] ?? 0;
    $green     = mysqli_fetch_assoc(mysqli_query($link, $green_q))['green'] ?? 0;
    $donation  = mysqli_fetch_assoc(mysqli_query($link, $donation_q))['donation'] ?? 0;

    // Determine badge level
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

<!-- Footer will stay at the bottom -->
<?php include 'includes/footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php mysqli_close($link); ?>
