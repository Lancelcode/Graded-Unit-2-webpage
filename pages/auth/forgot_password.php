<?php
require_once __DIR__ . '/../../includes/init.php';
require_once ROOT_PATH . '/includes/connect_db.php';

if (isset($_SESSION['user_id'])) {
    header('Location: ' . BASE_URL . '/index.php');
    exit();
}

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$errors  = [];
$success = false;
$b       = BASE_URL;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'] ?? '')) {
        die('Invalid CSRF token');
    }

    $email = trim($_POST['email']          ?? '');
    $pass1 = $_POST['new_password']        ?? '';
    $pass2 = $_POST['confirm_password']    ?? '';

    if (empty($email))      $errors[] = 'Email is required.';
    if (strlen($pass1) < 1) $errors[] = 'Password must not be empty.';
    if ($pass1 !== $pass2)  $errors[] = 'Passwords do not match.';

    if (empty($errors)) {
        $stmt = mysqli_prepare($link, "SELECT id FROM new_users WHERE email = ?");
        mysqli_stmt_bind_param($stmt, 's', $email);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $uid);
        mysqli_stmt_fetch($stmt);
        mysqli_stmt_close($stmt);

        if ($uid) {
            $hash = password_hash($pass1, PASSWORD_DEFAULT);
            $u    = mysqli_prepare($link, "UPDATE new_users SET password = ? WHERE id = ?");
            mysqli_stmt_bind_param($u, 'si', $hash, $uid);
            mysqli_stmt_execute($u);
            mysqli_stmt_close($u);
            $success = true;
        } else {
            $errors[] = 'No account found with that email address.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include ROOT_PATH . '/includes/head.php'; ?>
    <title>Reset Password | GreenScore</title>
    <style>
        .auth-wrapper { max-width: 450px; margin: 5rem auto; }
        h3 { text-align: center; color: #2e7d32; font-weight: bold; margin-bottom: 2rem; }
    </style>
</head>
<body class="bg-page overlay-50"
      style="background-image: url('<?= $b ?>/assets/images/forest-hero.jpg');">

<div class="container auth-wrapper">
    <div class="auth-card">
        <h3>🔄 Reset Your Password</h3>

        <?php if ($success): ?>
            <div class="alert alert-success">
                ✅ Password updated.
                <a href="<?= $b ?>/pages/auth/login.php">Log in now</a>.
            </div>
        <?php else: ?>
            <?php if (!empty($errors)): ?>
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        <?php foreach ($errors as $err): ?>
                            <li><?= htmlspecialchars($err) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form method="POST">
                <input type="hidden" name="csrf_token"
                       value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="text" name="email" class="form-control"
                           value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">New Password</label>
                    <input type="password" name="new_password" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Confirm Password</label>
                    <input type="password" name="confirm_password" class="form-control" required>
                </div>
                <button class="btn btn-success w-100">Reset Password</button>
                <div class="text-center mt-3">
                    <a href="<?= $b ?>/pages/auth/login.php" class="text-decoration-none">
                        ← Back to Login
                    </a>
                </div>
            </form>
        <?php endif; ?>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>