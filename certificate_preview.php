<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

$award = isset($_GET['level']) ? htmlspecialchars($_GET['level']) : 'Participation';
$username = $_SESSION['username'];
$date = date('F j, Y');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Green Certificate | GreenScore</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Styles -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body {
            background: url('assets/images/forest-hero.jpg') center/cover no-repeat fixed;
            margin: 0;
            padding: 2rem;
            font-family: 'Segoe UI', sans-serif;
            color: #333;
            position: relative;
        }

        body::before {
            content: '';
            position: absolute;
            inset: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 0;
        }

        .certificate {
            background: #fff;
            padding: 3rem;
            max-width: 800px;
            margin: auto;
            border: 10px double #4CAF50;
            border-radius: 20px;
            text-align: center;
            position: relative;
            z-index: 1;
            box-shadow: 0 0 10px rgba(0,0,0,0.3);
        }

        h1 {
            font-size: 3rem;
            color: #4CAF50;
            margin-bottom: 1rem;
        }

        .award-badge {
            font-size: 2.5rem;
            margin: 1rem 0;
            color: #2c7a7b;
        }

        .btn-group {
            margin-top: 2rem;
        }
    </style>
</head>
<body>

<?php include 'includes/nav.php'; ?>

<div class="certificate">
    <h1>🌿 GreenScore Certificate</h1>
    <p class="lead">This certifies that</p>
    <h2><strong><?= htmlspecialchars($username) ?></strong></h2>
    <p>has achieved the award level of</p>
    <div class="award-badge"><strong><?= $award ?></strong></div>
    <p>Issued on <?= $date ?></p>

    <div class="btn-group d-flex justify-content-center gap-3 flex-wrap">
        <button onclick="window.print()" class="btn btn-success">
            🖨️ Print / Save as PDF
        </button>
        <a href="certificate_history.php" class="btn btn-outline-secondary">
            ⬅ Back to History
        </a>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
