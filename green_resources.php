<?php
require_once 'includes/init.php';
require_once 'includes/connect_db.php';
include 'includes/nav.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Green Resources | GreenScore</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap & FontAwesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
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
            inset: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 0;
        }

        .content-wrapper {
            position: relative;
            z-index: 1;
            padding: 4rem 1rem;
        }

        .card-bg {
            background: rgba(255, 255, 255, 0.95);
            padding: 2rem;
            border-radius: 1rem;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        }

        .resource-title {
            color: #2c7a7b;
            font-weight: bold;
        }

        .resource-link {
            display: block;
            margin: 0.5rem 0;
        }

        .resource-link:hover {
            color: #198754;
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="container content-wrapper">
    <h1 class="text-white text-center mb-5">📚 Green Resources</h1>

    <div class="card card-bg">
        <h3 class="resource-title mb-3">🌍 United Nations SDG Resources</h3>
        <a class="resource-link" href="https://sdgs.un.org/goals" target="_blank">
            🌱 UN Sustainable Development Goals (Official Website)
        </a>
        <a class="resource-link" href="https://www.globalgoals.org/" target="_blank">
            🌏 The Global Goals Overview
        </a>
        <a class="resource-link" href="https://sdgs.un.org/sites/default/files/publications/21252030%20Agenda%20for%20Sustainable%20Development%20web.pdf" target="_blank">
            📖 SDG Agenda 2030 (UN PDF)
        </a>
    </div>

    <div class="card card-bg mt-5">
        <h3 class="resource-title mb-3">📁 Downloadable Guides</h3>
        <a class="resource-link" href="assets/documents/green_tips_guide.pdf" target="_blank">
            ✅ Green Living Tips Guide (PDF)
        </a>
        <a class="resource-link" href="assets/documents/carbon_reduction_checklist.pdf" target="_blank">
            ✅ Carbon Reduction Checklist (PDF)
        </a>
    </div>

    <div class="text-center mt-5">
        <a href="user_account.php" class="btn btn-outline-light">⬅ Back to My Profile</a>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php mysqli_close($link); ?>
