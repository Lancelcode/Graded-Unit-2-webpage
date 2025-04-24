<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<header class="sticky-top shadow">
    <nav class="navbar navbar-expand-lg navbar-dark bg-success px-3">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold" href="index.php">🌱 GreenScore</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown"
                    aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <!-- Public Tools -->
                    <li class="nav-item"><a class="nav-link" href="home.php">🏠 Home</a></li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="toolsDropdown" role="button"
                           data-bs-toggle="dropdown" aria-expanded="false">🛠️ Tools</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="green_calculator.php">🧮 Green Calculator</a></li>
                            <li><a class="dropdown-item" href="certificate_history.php">📄 My Certificate History</a></li>
                            <li><a class="dropdown-item" href="buy_points.php">💸 Buy Points</a></li>
                            <li><a class="dropdown-item" href="my_impact.php">📊 My Impact</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="infoDropdown" role="button"
                           data-bs-toggle="dropdown" aria-expanded="false">📚 Resources</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="green_resources.php">🌿 Sustainability Info</a></li>
                            <li><a class="dropdown-item" href="about.php">ℹ️ About</a></li>
                            <li><a class="dropdown-item" href="privacy.php">🔐 Privacy Policy</a></li>
                            <li><a class="dropdown-item" href="terms.php">📜 Terms & Conditions</a></li>
                        </ul>
                    </li>

                    <!-- Admin Dashboard: only for admins -->
                    <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="adminDropdown" role="button"
                               data-bs-toggle="dropdown" aria-expanded="false">🛠 Admin Dashboard</a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="admin_feedback.php">📝 Review User Feedback</a></li>
                                <li><a class="dropdown-item" href="public_feedback.php">🌍 Public Feedback Submissions</a></li>
                                <!-- Future admin tools -->
                                <!-- <li><a class="dropdown-item" href="manage_users.php">👥 Manage Users</a></li> -->
                                <!-- <li><a class="dropdown-item" href="site_config.php">⚙️ Site Configuration</a></li> -->
                            </ul>
                        </li>

                    <?php endif; ?>

                    <li class="nav-item"><a class="nav-link" href="feedback.php">💬 Feedback</a></li>

                    <?php if (isset($_SESSION['username'])): ?>
                        <li class="nav-item"><a class="nav-link" href="user_account.php">👤 Profile</a></li>
                    <?php endif; ?>
                </ul>

                <ul class="navbar-nav mb-2 mb-lg-0">
                    <?php if (isset($_SESSION['username'])): ?>
                        <li class="nav-item d-flex align-items-center text-light me-3">
                            <span>👋 Hello, <strong><?= htmlspecialchars($_SESSION['username']) ?></strong></span>
                        </li>
                        <li class="nav-item me-2">
                            <a class="btn btn-outline-light" href="logout.php">Logout</a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item me-2">
                            <a class="btn btn-outline-light" href="#" data-bs-toggle="modal" data-bs-target="#loginModal">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="btn btn-light" href="#" data-bs-toggle="modal" data-bs-target="#registerModal">Register</a>
                        </li>
                    <?php endif; ?>
                    <li class="nav-item ms-3">
                        <button id="darkToggle" class="btn btn-sm btn-outline-light" title="Toggle Dark Mode">🌓</button>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>
