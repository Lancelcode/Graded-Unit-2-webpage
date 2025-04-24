<?php
// includes/footer.php
?>
<!-- ========== FOOTER SECTION START ========== -->

<!-- Bootstrap 5 bundle (includes Popper) -->
<script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeo0r4b7Qfu9PLFornYk8Pm0i+U5yYk0Y+Ao5rW5U5Gu5T8L"
        crossorigin="anonymous"
></script>

<!-- Dark-mode toggle -->
<script>
    // Apply saved mode on load
    if (localStorage.getItem('darkMode') === 'enabled') {
        document.body.classList.add('bg-dark', 'text-light');
    }

    // Toggle handler
    document.getElementById('darkToggle').addEventListener('click', function () {
        document.body.classList.toggle('bg-dark');
        document.body.classList.toggle('text-light');
        localStorage.setItem(
            'darkMode',
            document.body.classList.contains('bg-dark') ? 'enabled' : 'disabled'
        );
    });
</script>

<!-- Main Footer -->
<footer class="bg-success text-white mt-auto">
    <div class="container py-5">
        <div class="row">
            <!-- Logo and About -->
            <div class="col-12 col-md mb-4">
                <h4 class="fw-bold">🌱 GreenScore</h4>
                <p class="small mb-0">Building a Greener Future, Together.</p>
                <small class="d-block">&copy; <?= date('Y'); ?> GreenScore. All rights reserved.</small>
            </div>

            <!-- Features -->
            <div class="col-6 col-md">
                <h5>Features</h5>
                <ul class="list-unstyled text-light small">
                    <li><a class="text-white-50" href="green_calculator.php">Green Calculator</a></li>
                    <li><a class="text-white-50" href="sustainability_snapshot.php">Insights Dashboard</a></li>
                    <li><a class="text-white-50" href="certificate_preview.php">Certificate</a></li>
                </ul>
            </div>

            <!-- Resources -->
            <div class="col-6 col-md">
                <h5>Resources</h5>
                <ul class="list-unstyled text-light small">
                    <li><a class="text-white-50" href="green_resources.php">Guides & Tips</a></li>
                    <li><a class="text-white-50" href="https://sdgs.un.org/goals" target="_blank">UN SDGs</a></li>
                </ul>
            </div>

            <!-- Community -->
            <div class="col-6 col-md">
                <h5>Community</h5>
                <ul class="list-unstyled text-light small">
                    <li><a class="text-white-50" href="community.php">Community Board</a></li>
                    <li><a class="text-white-50" href="my_impact.php">My Impact</a></li>
                </ul>
            </div>

            <!-- Legal -->
            <div class="col-6 col-md">
                <h5>Legal</h5>
                <ul class="list-unstyled text-light small">
                    <li><a class="text-white-50" href="#">Privacy Policy</a></li>
                    <li><a class="text-white-50" href="#">Terms of Use</a></li>
                </ul>
            </div>
        </div>

        <hr class="my-4 border-light">

        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center">
            <div class="text-center text-md-start mb-2 mb-md-0">
                <small class="text-white-50">Follow us on social media:</small>
            </div>
            <div class="text-center text-md-end">
                <a href="https://www.facebook.com" target="_blank" class="text-white me-3">
                    <i class="fab fa-facebook-f"></i> Facebook
                </a>
                <a href="https://www.twitter.com" target="_blank" class="text-white me-3">
                    <i class="fab fa-twitter"></i> Twitter
                </a>
                <a href="https://www.instagram.com" target="_blank" class="text-white">
                    <i class="fab fa-instagram"></i> Instagram
                </a>
            </div>
        </div>
    </div>
</footer>
</body>
</html>


