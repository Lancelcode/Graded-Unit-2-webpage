<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<header class="sticky-top shadow">
    <nav class="navbar navbar-expand-lg navbar-dark bg-success px-3">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold" href="/index.php">🏠 GreenScore</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown"
                    aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="toolsDropdown"
                           role="button" data-bs-toggle="dropdown">🛠️ Tools</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="/pages/calculator/green_calculator.php">🧮 Green Calculator</a></li>
                            <li><a class="dropdown-item" href="/pages/calculator/certificate_history.php">📄 My Certificate History</a></li>
                            <li><a class="dropdown-item" href="/pages/calculator/buy_points.php">💸 Buy Points</a></li>
                            <li><a class="dropdown-item" href="/pages/user/my_impact.php">📊 My Impact</a></li>
                        </ul>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="infoDropdown"
                           role="button" data-bs-toggle="dropdown">📚 Resources</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="/pages/info/partner.php">🌱 Partners</a></li>
                            <li><a class="dropdown-item" href="/pages/info/green_resources.php">🌿 Sustainability Info</a></li>
                            <li><a class="dropdown-item" href="/pages/info/about.php">ℹ️ About</a></li>
                            <li><a class="dropdown-item" href="/pages/info/privacy.php">🔐 Privacy Policy</a></li>
                            <li><a class="dropdown-item" href="/pages/info/terms.php">📜 Terms &amp; Conditions</a></li>
                        </ul>
                    </li>

                    <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="adminDropdown"
                               role="button" data-bs-toggle="dropdown">🛠 Admin Dashboard</a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="/pages/admin/admin_feedback.php">📝 Review User Feedback</a></li>
                                <li><a class="dropdown-item" href="/pages/admin/public_feedback.php">🌍 Public Feedback Submissions</a></li>
                                <li><a class="dropdown-item" href="/pages/admin/manage_users.php">👥 Manage Users</a></li>
                            </ul>
                        </li>
                    <?php endif; ?>

                    <li class="nav-item">
                        <a class="nav-link" href="/pages/info/feedback.php">💬 Feedback</a>
                    </li>

                    <?php if (isset($_SESSION['username'])): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="/pages/user/user_account.php">👤 Profile</a>
                        </li>
                    <?php endif; ?>
                </ul>

                <ul class="navbar-nav mb-2 mb-lg-0">
                    <?php if (isset($_SESSION['username'])): ?>
                        <li class="nav-item d-flex align-items-center text-light me-3">
                            <span>👋 Hello, <strong><?= htmlspecialchars($_SESSION['username']) ?></strong></span>
                        </li>
                        <li class="nav-item me-2">
                            <a class="btn btn-outline-light" href="/pages/auth/logout.php">Logout</a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item me-2">
                            <a class="btn btn-outline-light" href="/pages/auth/login.php">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="btn btn-light" href="/pages/auth/register.php">Register</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>
</header>