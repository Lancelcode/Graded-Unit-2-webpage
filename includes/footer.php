<?php if (!defined('BASE_URL')) require_once __DIR__ . '/init.php'; ?>
<footer class="bg-success text-white pt-5 pb-3 mt-auto">
    <div class="container">
        <div class="row gy-4">

            <div class="col-12 col-md-3">
                <h4 class="fw-bold mb-2">🌱 GreenScore</h4>
                <p class="small mb-1">Building a Greener Future, Together.</p>
                <small class="d-block">
                    &copy; <?= date('Y') ?>
                    <a href="<?= BASE_URL ?>/pages/info/greenscore_copyright.php"
                       class="text-white-50 text-decoration-none">GreenScore</a>.
                    All rights reserved.
                </small>
            </div>

            <div class="col-6 col-md-2">
                <h6 class="text-uppercase fw-bold mb-3">Features</h6>
                <ul class="list-unstyled small">
                    <li><a class="text-white-50 text-decoration-none" href="<?= BASE_URL ?>/pages/calculator/green_calculator.php">Green Calculator</a></li>
                    <li><a class="text-white-50 text-decoration-none" href="<?= BASE_URL ?>/pages/calculator/certificate_preview.php">Certificate</a></li>
                </ul>
            </div>

            <div class="col-6 col-md-2">
                <h6 class="text-uppercase fw-bold mb-3">Resources</h6>
                <ul class="list-unstyled small">
                    <li><a class="text-white-50 text-decoration-none" href="<?= BASE_URL ?>/pages/info/green_resources.php">Guides &amp; Tips</a></li>
                    <li><a class="text-white-50 text-decoration-none" href="https://sdgs.un.org/goals" target="_blank">UN SDGs</a></li>
                </ul>
            </div>

            <div class="col-6 col-md-2">
                <h6 class="text-uppercase fw-bold mb-3">Community</h6>
                <ul class="list-unstyled small">
                    <li><a class="text-white-50 text-decoration-none" href="<?= BASE_URL ?>/pages/community/community.php">Community Board</a></li>
                    <li><a class="text-white-50 text-decoration-none" href="<?= BASE_URL ?>/pages/user/my_impact.php">My Impact</a></li>
                </ul>
            </div>

            <div class="col-6 col-md-3">
                <h6 class="text-uppercase fw-bold mb-3">Legal</h6>
                <ul class="list-unstyled small">
                    <li><a class="text-white-50 text-decoration-none" href="<?= BASE_URL ?>/pages/info/privacy.php">Privacy Policy</a></li>
                    <li><a class="text-white-50 text-decoration-none" href="<?= BASE_URL ?>/pages/info/terms.php">Terms of Use</a></li>
                </ul>
            </div>
        </div>

        <hr class="border-white-50 mt-4">

        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-2">
            <small class="text-white-50">Follow us:</small>
            <div>
                <a href="https://www.facebook.com" target="_blank"
                   class="text-white text-decoration-none me-3">
                    <i class="fab fa-facebook-f"></i> Facebook
                </a>
                <a href="https://www.twitter.com" target="_blank"
                   class="text-white text-decoration-none me-3">
                    <i class="fab fa-twitter"></i> Twitter
                </a>
                <a href="https://www.instagram.com" target="_blank"
                   class="text-white text-decoration-none">
                    <i class="fab fa-instagram"></i> Instagram
                </a>
            </div>
        </div>
    </div>
</footer>