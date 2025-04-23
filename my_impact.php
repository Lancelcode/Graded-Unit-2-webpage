<?php require_once 'includes/init.php'; ?>
<?php require_once 'includes/connect_db.php'; ?>
<?php include 'includes/nav.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Impact Report | GreenScore</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

<div class="container mt-5">
    <h1 class="mb-4 text-success">👤 My Impact Report</h1>

    <?php
    if (!isset($_SESSION['id'])) {
        echo "<div class='alert alert-warning'>Please <a href='login.php'>log in</a> to view your impact report.</div>";
        include 'includes/footer.php';
        exit();
    }

    $user_id = $_SESSION['id'];

    // Fetch user-specific stats
    $total_q     = "SELECT COUNT(*) AS total FROM green_calculator_results WHERE user_id = $user_id";
    $green_q     = "SELECT SUM(green_count) AS green FROM green_calculator_results WHERE user_id = $user_id";
    $donation_q  = "SELECT SUM(donation_cost) AS donation FROM green_calculator_results WHERE user_id = $user_id";

    $total     = mysqli_fetch_assoc(mysqli_query($link, $total_q))['total'] ?? 0;
    $green     = mysqli_fetch_assoc(mysqli_query($link, $green_q))['green'] ?? 0;
    $donation  = mysqli_fetch_assoc(mysqli_query($link, $donation_q))['donation'] ?? 0;

    // Assign badge based on green points
    $badge = "Eco Newbie";
    if ($green >= 50) {
        $badge = "Green Warrior";
    } elseif ($green >= 30) {
        $badge = "Eco Explorer";
    } elseif ($green >= 15) {
        $badge = "Green Starter";
    }
    ?>

    <div class="result-box">
        <h4>📊 Total Submissions: <?= $total ?></h4>
        <h4>🌱 Green Answers Earned: <?= $green ?></h4>
        <h4>💸 Total Donations: £<?= number_format($donation, 2) ?></h4>
        <h4 class="mt-3">🏅 Badge Earned: <span class="text-success"><?= $badge ?></span></h4>
    </div>

    <p class="mt-3 text-muted">
        Thank you for helping create a greener world, <strong><?= htmlspecialchars($_SESSION['username']) ?></strong> 💚
    </p>
</div>

<?php include 'includes/footer.php'; ?>

<!-- Bootstrap Scripts -->
<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
