<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<header class="sticky-top shadow">
    <nav class="navbar navbar-expand-lg navbar-dark bg-success px-3">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold" href="home.php">🌱 GreenScore</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown"
                    aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
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
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="toolsDropdown" role="button"
                           data-bs-toggle="dropdown" aria-expanded="false">🛠️ Admin dashboard</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="admin_feedback.php">🧮 Admin Feedback Panel</a></li>
                            <li><a class="dropdown-item" href="public_feedback.php">💸 Community Feedback</a></li>
                        </ul>
                    </li>
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

<!-- Register Modal -->
<div class="modal fade" id="registerModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form class="modal-content" action="register_action.php" method="POST">
            <div class="modal-header">
                <h5 class="modal-title">Register</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <label>Username:</label>
                <input type="text" name="username" class="form-control" required><br>

                <label>Email:</label>
                <input type="email" name="email" class="form-control" required><br>

                <label>Password:</label>
                <input type="password" name="pass1" class="form-control" required><br>

                <label>Confirm Password:</label>
                <input type="password" name="pass2" class="form-control" required><br>
            </div>
            <div class="modal-footer">
                <input type="submit" class="btn btn-success" value="Submit">
            </div>
        </form>
    </div>
</div>

<!-- Login Modal (Optional) -->
<div class="modal fade" id="loginModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form class="modal-content" action="login_action.php" method="POST">
            <div class="modal-header">
                <h5 class="modal-title">Login</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <label>Email:</label>
                <input type="text" name="email" class="form-control" required><br>
                <label>Password:</label>
                <input type="password" name="password" class="form-control" required><br>
            </div>
            <div class="modal-footer">
                <input type="submit" class="btn btn-success" value="Login">
            </div>
        </form>
    </div>
</div>

<script>
    if (localStorage.getItem('darkMode') === 'enabled') {
        document.body.classList.add('bg-dark', 'text-light');
    }
    document.getElementById('darkToggle').addEventListener('click', function () {
        document.body.classList.toggle('bg-dark');
        document.body.classList.toggle('text-light');
        localStorage.setItem('darkMode', document.body.classList.contains('bg-dark') ? 'enabled' : 'disabled');
    });
</script>
