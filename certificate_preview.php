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
    <title>GreenScore Certificate</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body { background-color: #f4f8f5; }
        .card-custom {
            border-radius: 15px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            padding: 30px;
        }
        .award {
            font-size: 1.5rem;
            margin: 15px 0;
        }
        .btn-group { margin-top: 20px; }
        .award-icon {
            font-size: 2rem;
        }
    </style>

</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="certificate-box text-center mx-auto">

        <h1 class="mb-4 text-success">🌿 GreenScore Certificate</h1>
        <h4>This certifies that</h4>
        <h2 class="fw-bold"><?= htmlspecialchars($username) ?></h2>

        <p class="my-3">has achieved the sustainability award level of</p>
        <div class="award-badge text-success"><?= $award ?></div>

        <p class="mt-3 text-muted">Issued on <?= $date ?></p>

        <!-- Button Group -->
        <div class="d-flex flex-wrap justify-content-center gap-3 mt-4">
            <a href="download_certificate.php" class="btn btn-outline-success">📄 Download</a>
            <a href="buy_points.php" class="btn btn-outline-primary">💰 Buy Points</a>
            <a href="community.php" class="btn btn-outline-info">🌱 Community</a>
            <a href="green_resources.php" class="btn btn-outline-dark">📚 Tips & Guides</a>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
