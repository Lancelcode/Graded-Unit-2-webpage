<?php
session_start();
if (!isset($_SESSION['username']) || !isset($_GET['shortfall']) || !isset($_GET['cost'])) {
    header('Location: green_calculator.php');
    exit();
}

$shortfall = (int) $_GET['shortfall'];
$cost = number_format((float) $_GET['cost'], 2);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Buy Sustainability Points</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body { background-color: #f0fff0; }
        .box {
            max-width: 600px;
            margin: 80px auto;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 0 8px rgba(0,0,0,0.15);
            padding: 40px;
        }
    </style>
</head>
<body>
<div class="box text-center">
    <h1>💸 Purchase Points</h1>
    <p>You are <strong><?= $shortfall ?> points</strong> short of Gold.</p>
    <p>A donation of <strong>£<?= $cost ?></strong> will top up your sustainability score!</p>

    <form method="POST">
        <button name="donate" class="btn btn-warning btn-lg">Confirm Donation</button>
        <a href="green_calculator.php" class="btn btn-outline-secondary mt-3">Cancel</a>
    </form>

    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['donate'])) {
        // In a real system, payment would go here. We'll fake the success:
        echo "<div class='alert alert-success mt-4'>🎉 Thank you for your support! Your score is now considered Gold!</div>";
        echo "<a href='certificate_preview.php?level=Gold 🏅' class='btn btn-success mt-2'>Download Updated Certificate</a>";
    }
    ?>
</div>
</body>
</html>
