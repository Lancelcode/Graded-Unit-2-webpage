<?php
require_once __DIR__ . '/../../includes/init.php';

if (!isset($_SESSION['username'])) {
    header('Location: ' . BASE_URL . '/pages/auth/login.php');
    exit();
}

$b        = BASE_URL;
$award    = isset($_GET['level']) ? htmlspecialchars($_GET['level']) : 'Certificate of Participation 👏';
$username = htmlspecialchars($_SESSION['username']);
$date     = date('F j, Y');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include ROOT_PATH . '/includes/head.php'; ?>
    <title>Green Certificate | GreenScore</title>
    <style>
        body {
            background: url('<?= $b ?>/assets/images/forest-hero.jpg') center/cover no-repeat fixed;
            margin: 0; color: #333; position: relative; min-height: 100vh;
        }
        body::before {
            content: ''; position: fixed; inset: 0;
            background: rgba(0,0,0,0.5); z-index: 0;
        }
        .page-wrapper {
            position: relative; z-index: 1;
            display: flex; flex-direction: column; min-height: 100vh;
        }
        .content-wrapper {
            flex: 1; padding: 5rem 1rem;
            display: flex; justify-content: center; align-items: center;
        }
        .certificate {
            background: #fff; padding: 4rem 2rem; max-width: 900px; width: 100%;
            border: 12px double #4CAF50; border-radius: 20px; text-align: center;
            box-shadow: 0 0 20px rgba(0,0,0,0.35);
        }
        .certificate h1 { font-size: 3.5rem; color: #2e7d32; font-weight: bold; }
        .certificate .lead { font-size: 1.4rem; }
        .certificate h2 { font-size: 2.5rem; color: #000; }
        .award-badge {
            font-size: 2rem; background-color: #e8f5e9; color: #388e3c;
            display: inline-block; padding: 0.5rem 1.5rem;
            border-radius: 30px; font-weight: bold;
        }
        .certificate p.date { margin-top: 1rem; font-style: italic; }
        footer { background-color: #fff; color: #444; padding: 2rem 0; }
    </style>
</head>
<body>
<div class="page-wrapper">
    <?php include ROOT_PATH . '/includes/nav.php'; ?>

    <div class="container content-wrapper">
        <div class="certificate">
            <h1>🌿 GreenScore Certificate</h1>
            <p class="lead">This certifies that</p>
            <h2><?= $username ?></h2>
            <p class="lead">has achieved the award level of</p>
            <div class="award-badge"><?= $award ?></div>
            <p class="date">Issued on <?= $date ?></p>

            <div class="d-flex justify-content-center gap-3 flex-wrap mt-4">
                <button onclick="window.print()" class="btn btn-success">
                    🖨️ Print / Save as PDF
                </button>
                <a href="<?= $b ?>/pages/calculator/certificate_history.php"
                   class="btn btn-outline-secondary">⬅ Back to History</a>
            </div>
        </div>
    </div>

    <?php include ROOT_PATH . '/includes/footer.php'; ?>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>