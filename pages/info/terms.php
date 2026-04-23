<?php
require_once __DIR__ . '/../../includes/init.php';
require_once ROOT_PATH . '/includes/connect_db.php';
include ROOT_PATH . '/includes/nav.php';
$b = BASE_URL;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include ROOT_PATH . '/includes/head.php'; ?>
    <title>Terms &amp; Conditions | GreenScore</title>
    <style>
        html, body { margin: 0; height: 100%; }
        body {
            background: url('<?= $b ?>/assets/images/forest-hero.jpg') center/cover no-repeat fixed;
            color: #333; position: relative;
        }
        body::before {
            content: ''; position: fixed; top: 0; left: 0;
            width: 100vw; height: 100vh;
            background: rgba(0,0,0,0.5); z-index: 0;
        }
        .page-wrapper {
            position: relative; z-index: 1;
            display: flex; flex-direction: column; min-height: 100vh;
        }
        .content-wrapper { flex: 1; padding: 4rem 0; }
        .card-bg { background: rgba(255,255,255,0.9); }
        footer { background-color: #fff; padding: 2rem 0; width: 100%;
                 z-index: 1; position: relative; }
        h2.section-title { color: #2c7a7b; }
    </style>
</head>
<body>
<div class="page-wrapper">
    <div class="container content-wrapper">
        <h1 class="text-white text-center mb-4">Terms &amp; Conditions</h1>

        <div class="card card-bg shadow-sm p-4 mb-4">
            <h2 class="section-title mb-3">1. Acceptance of Terms</h2>
            <p>By accessing or using GreenScore, you agree to be bound by these Terms
            and our Privacy Policy.</p>
        </div>
        <div class="card card-bg shadow-sm p-4 mb-4">
            <h2 class="section-title mb-3">2. Use of Service</h2>
            <ul>
                <li>You must provide accurate company information when registering.</li>
                <li>Do not misuse our services or upload harmful content.</li>
                <li>Respect intellectual property rights.</li>
            </ul>
        </div>
        <div class="card card-bg shadow-sm p-4 mb-4">
            <h2 class="section-title mb-3">3. User Accounts</h2>
            <ul>
                <li>Keep your account credentials secure.</li>
                <li>Notify us immediately of any unauthorised account use.</li>
                <li>We reserve the right to suspend or terminate accounts.</li>
            </ul>
        </div>
        <div class="card card-bg shadow-sm p-4 mb-4">
            <h2 class="section-title mb-3">4. GreenScore Points &amp; Certifications</h2>
            <p>Points are awarded based on verified emission reductions. Certifications may be
            revoked if fraud or misrepresentation is detected.</p>
        </div>
        <div class="card card-bg shadow-sm p-4 mb-4">
            <h2 class="section-title mb-3">5. Limitation of Liability</h2>
            <p>To the fullest extent permitted by law, GreenScore is not liable for indirect,
            incidental, or consequential damages.</p>
        </div>
        <div class="card card-bg shadow-sm p-4 mb-4">
            <h2 class="section-title mb-3">6. Changes to Terms</h2>
            <p>We may update these terms occasionally. Continued use after changes implies acceptance.</p>
        </div>

        <div class="text-center">
            <a href="<?= $b ?>/pages/user/user_account.php" class="btn btn-outline-light">
                ⬅ Back to My Profile
            </a>
        </div>
    </div>
    <?php include ROOT_PATH . '/includes/footer.php'; ?>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php mysqli_close($link); ?>