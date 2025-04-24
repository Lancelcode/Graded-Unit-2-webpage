<?php
session_start();
if (!isset($_SESSION['username']) || !isset($_GET['shortfall']) || !isset($_GET['cost'])) {
    header('Location: green_calculator.php');
    exit();
}

$shortfall = (int) $_GET['shortfall'];
$cost = number_format((float) $_GET['cost'], 2);
$username = $_SESSION['username'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Buy Sustainability Points | GreenScore</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS & Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="style.css" rel="stylesheet">
    <style>
        body {
            background: url('assets/images/forest-hero.jpg') center/cover no-repeat fixed;
            position: relative;
            color: #333;
        }

        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            height: 100%;
            width: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 0;
        }

        .content-wrapper {
            position: relative;
            z-index: 1;
            padding: 5rem 1rem;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .card-bg {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 12px;
            padding: 3rem;
            max-width: 600px;
            width: 100%;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.25);
        }
    </style>
</head>
<body>

<?php include 'includes/nav.php'; ?>

<div class="container content-wrapper">
    <div class="card card-bg text-center">
        <h1 class="text-success mb-3">💸 Support Your Score</h1>
        <p class="lead">Hello <strong><?= htmlspecialchars($username) ?></strong>,</p>
        <p>You're currently <strong><?= $shortfall ?> points</strong> short of achieving a perfect sustainability score.</p>
        <p>By contributing <strong>£<?= $cost ?></strong>, you'll unlock full recognition and receive your updated certificate.</p>

        <form method="POST" class="mt-4">
            <button type="submit" name="donate" class="btn btn-warning btn-lg">✅ Confirm Contribution</button>
            <a href="green_calculator.php" class="btn btn-outline-secondary btn-lg ms-3">⬅ Cancel</a>
        </form>

        <?php
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['donate'])) {
            echo "<div class='alert alert-success mt-4'>";
            echo "🎉 Thank you for your support! You've unlocked the full score!";
            echo "</div>";
            echo "<a href='certificate_preview.php?level=Gold 🏅' class='btn btn-success mt-3'>📄 Download Your Certificate</a>";
        }
        ?>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
