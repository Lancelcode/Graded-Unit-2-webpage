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
    <title>Green Certificate</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background: #fdf6e3;
            font-family: 'Segoe UI', sans-serif;
        }
        .certificate {
            margin: 50px auto;
            padding: 40px;
            border: 10px double #4CAF50;
            border-radius: 20px;
            background: white;
            text-align: center;
            width: 80%;
            max-width: 800px;
        }
        h1 {
            font-size: 3rem;
            color: #4CAF50;
        }
        h2 {
            margin: 20px 0;
        }
        .award-badge {
            font-size: 2.5rem;
        }
    </style>
</head>
<body>
<div class="certificate">
    <h1>🌿 Green Cinema Certificate</h1>
    <h2>This certifies that</h2>
    <h2><strong><?= htmlspecialchars($username) ?></strong></h2>
    <p>has achieved the sustainability award level of</p>
    <div class="award-badge"><strong><?= $award ?></strong></div>
    <p>Issued on <?= $date ?></p>
    <button class="btn btn-primary mt-4" onclick="window.print()">🖨️ Print / Save as PDF</button>
    <a href="green_calculator.php" class="btn btn-outline-secondary mt-4">⬅ Back to Calculator</a>
</div>
</body>
</html>
