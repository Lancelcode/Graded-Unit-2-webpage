<?php
require_once __DIR__ . '/../../includes/init.php';

if (isset($_SESSION['user_id'])) {
    header('Location: ' . BASE_URL . '/index.php');
    exit();
}

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
$b = BASE_URL;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include ROOT_PATH . '/includes/head.php'; ?>
    <title>Login | GreenScore</title>
    <style>
        .auth-card { margin-top: 5rem; }
        footer { background: white; z-index: 2; position: relative; }
    </style>
</head>
<body class="bg-page overlay-60"
      style="background-image: url('<?= $b ?>/assets/images/forest-hero.jpg'); color: #333;">
<?php include ROOT_PATH . '/includes/nav.php'; ?>

<div class="container" style="max-width: 500px;">
    <div class="auth-card">
        <h2 class="text-success text-center mb-4">Login to GreenScore</h2>

        <?php if (isset($_SESSION['login_error'])): ?>
            <div class="alert alert-danger">
                <?= $_SESSION['login_error']; unset($_SESSION['login_error']); ?>
            </div>
        <?php endif; ?>

        <?php if (isset($_SESSION['register_success'])): ?>
            <div class="alert alert-success">
                ✅ <?= htmlspecialchars($_SESSION['register_success']); unset($_SESSION['register_success']); ?>
            </div>
        <?php endif; ?>

        <form action="<?= $b ?>/includes/login_action.php" method="post">
            <input type="hidden" name="csrf_token"
                   value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">
            <div class="mb-3">
                <label for="email" class="form-label">Email:</label>
                <input type="email" id="email" name="email" class="form-control"
                       required placeholder="Enter your email">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password:</label>
                <input type="password" id="password" name="password" class="form-control"
                       required placeholder="Enter your password">
            </div>
            <button type="submit" class="btn btn-success w-100">Login</button>
        </form>

        <div class="text-center mt-3">
            <a href="<?= $b ?>/pages/auth/forgot_password.php" class="text-success">
                Forgot your password?
            </a>
        </div>
        <div class="text-center mt-2">
            <a href="<?= $b ?>/pages/auth/register.php" class="text-muted">
                Don't have an account? Register
            </a>
        </div>
    </div>
</div>

<?php include ROOT_PATH . '/includes/footer.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>