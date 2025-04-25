<?php
require_once __DIR__ . '/includes/init.php';
require_once __DIR__ . '/includes/connect_db.php';
include __DIR__ . '/includes/nav.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Green Partnerships | GreenScore</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <style>
        html, body {
            height: 100%;
            margin: 0;
        }

        body {
            display: flex;
            flex-direction: column;
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
            flex: 1;
            position: relative;
            z-index: 1;
            padding: 4rem 1rem;
        }

        .card-bg {
            background: rgba(255, 255, 255, 0.9);
            border-radius: 1rem;
        }

        .logo-grid img {
            max-height: 80px;
            object-fit: contain;
        }

        footer {
            position: relative;
            z-index: 1;
            background-color: #fff;
            padding: 2rem 0;
            width: 100%;
        }

        .section-title {
            font-size: 2rem;
            font-weight: bold;
            color: #4CAF50;
        }

        .lead {
            font-size: 1.1rem;
        }
    </style>
</head>
<body>

<div class="container content-wrapper text-center">
    <h1 class="text-white display-4 mb-4">🌍 GreenScore Partnerships</h1>
    <p class="text-white fs-5 mb-5">We collaborate with some of the most trusted eco-leaders and institutions around the world.</p>

    <div class="row row-cols-2 row-cols-sm-3 row-cols-md-4 g-4 justify-content-center logo-grid mb-5">
        <div class="col">
            <img src="assets/images/logos/un.png" class="img-fluid p-2 bg-white shadow-sm rounded" alt="UN">
        </div>
        <div class="col">
            <img src="assets/images/logos/greenpeace.png" class="img-fluid p-2 bg-white shadow-sm rounded" alt="Greenpeace">
        </div>
        <div class="col">
            <img src="assets/images/logos/defra.png" class="img-fluid p-2 bg-white shadow-sm rounded" alt="DEFRA">
        </div>
        <div class="col">
            <img src="assets/images/logos/wwf.png" class="img-fluid p-2 bg-white shadow-sm rounded" alt="WWF">
        </div>
        <div class="col">
            <img src="assets/images/logos/ukgov.png" class="img-fluid p-2 bg-white shadow-sm rounded" alt="UK Government">
        </div>
        <div class="col">
            <img src="assets/images/logos/oxfam.png" class="img-fluid p-2 bg-white shadow-sm rounded" alt="Oxfam">
        </div>
        <div class="col">
            <img src="assets/images/logos/energy_saving_trust.png" class="img-fluid p-2 bg-white shadow-sm rounded" alt="Energy Saving Trust">
        </div>
    </div>

    <div class="card card-bg shadow-sm p-4">
        <h2 class="mb-3 text-success">Why Partner With GreenScore?</h2>
        <p class="lead mb-3">We are building a cleaner future, together. Every logo above represents a verified sustainability effort and a shared mission to reduce carbon emissions globally.</p>
        <a href="register_company.php" class="btn btn-success btn-lg mt-3">🌱 Join the Movement</a>
    </div>
</div>

<?php include 'includes/footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php mysqli_close($link); ?>
