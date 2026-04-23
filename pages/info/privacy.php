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
    <title>Privacy Policy | GreenScore</title>
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
        <h1 class="text-white text-center mb-4">Privacy Policy</h1>

        <div class="card card-bg shadow-sm p-4 mb-4">
            <h2 class="section-title mb-3">Introduction</h2>
            <p>At <strong>GreenScore</strong>, we respect your privacy and are committed to
            protecting your personal data.</p>
        </div>
        <div class="card card-bg shadow-sm p-4 mb-4">
            <h2 class="section-title mb-3">1. Information We Collect</h2>
            <ul>
                <li><strong>Account Information:</strong> Name, email, company details.</li>
                <li><strong>Usage Data:</strong> Dashboard interactions, emission reports.</li>
                <li><strong>Payment Information:</strong> Encrypted credit card details.</li>
            </ul>
        </div>
        <div class="card card-bg shadow-sm p-4 mb-4">
            <h2 class="section-title mb-3">2. How We Use Your Data</h2>
            <ul>
                <li>Provide and improve our services.</li>
                <li>Manage your account and customer support.</li>
                <li>Process payments securely.</li>
                <li>Send important updates (you can opt out anytime).</li>
            </ul>
        </div>
        <div class="card card-bg shadow-sm p-4 mb-4">
            <h2 class="section-title mb-3">3. Data Security</h2>
            <p>We implement SSL encryption, secure servers, and regular audits to protect
            your information from unauthorised access.</p>
        </div>
        <div class="card card-bg shadow-sm p-4 mb-4">
            <h2 class="section-title mb-3">4. Your Rights</h2>
            <ul>
                <li>Access and update your personal data.</li>
                <li>Request deletion of your account and data.</li>
                <li>Opt out of marketing communications.</li>
            </ul>
        </div>
        <div class="card card-bg shadow-sm p-4 mb-4">
            <h2 class="section-title mb-3">5. Contact Us</h2>
            <p>Questions? <a href="mailto:privacy@greenscore.com">Contact us here</a>.</p>
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