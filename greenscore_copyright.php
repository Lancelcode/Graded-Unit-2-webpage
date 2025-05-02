<?php
include('includes/head.php');
include('includes/nav.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Copyright | GreenScore</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
    <style>
        html, body {
            height: 100%;
            margin: 0;
        }
        body {
            background: url('assets/images/forest-hero.jpg') center/cover no-repeat fixed;
            position: relative;
            color: #333;
        }
        body::before {
            content: '';
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.6);
            z-index: -1;
            pointer-events: none;
        }
        .content-wrapper {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 1rem;
            padding: 3rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }
        footer {
            background-color: #fff;
            z-index: 2;
        }
        a.text-success:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
<main class="d-flex flex-column min-vh-100">
    <div class="container py-5 flex-grow-1">
        <div class="content-wrapper">
            <h1 class="mb-4">🌱 GreenScore Copyright</h1>

            <p>© <?= date('Y'); ?> <strong>GreenScore</strong>. All rights reserved.</p>

            <p>All content on this website, including text, graphics, logos, icons, images, and software, is the property of GreenScore unless otherwise stated. Unauthorized use, reproduction, or distribution of any material without prior written permission is strictly prohibited.</p>

            <p>We support sharing for educational and environmental purposes. You are welcome to reference our material provided proper credit is given and a link to GreenScore is included.</p>

            <p>If you wish to request permission for other uses, or have questions about our copyright policies, please contact us at:</p>

            <p><a href="mailto:contact@greenscore.com" class="text-success">contact@greenscore.com</a></p>
        </div>
    </div>
    <?php include('includes/footer.php'); ?>
</main>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
