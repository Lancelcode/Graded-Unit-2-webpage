<?php
// forgot_password.php
require_once 'includes/init.php';
require_once 'includes/connect_db.php';

// If already logged in, send back
if (isset($_SESSION['user_id'])) {
    header('Location: green_calculator.php');
    exit();
}

// CSRF token
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$errors = [];
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // CSRF check
    if (!hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'] ?? '')) {
        die('Invalid CSRF token');
    }

    $email    = trim($_POST['email'] ?? '');
    $pass1    = $_POST['new_password'] ?? '';
    $pass2    = $_POST['confirm_password'] ?? '';

    // Validation
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Please enter a valid email address.';
    }
    if (strlen($pass1) < 6) {
        $errors[] = 'Password must be at least 6 characters.';
    }
    if ($pass1 !== $pass2) {
        $errors[] = 'Passwords do not match.';
    }

    if (empty($errors)) {
        // Look up user
        $stmt = mysqli_prepare($link, "SELECT id FROM new_users WHERE email = ?");
        mysqli_stmt_bind_param($stmt, 's', $email);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $uid);
        mysqli_stmt_fetch($stmt);
        mysqli_stmt_close($stmt);

        if ($uid) {
            // Update password column (was `pass`, now `password`)
            $hash = password_hash($pass1, PASSWORD_DEFAULT);
            $u    = mysqli_prepare($link, "UPDATE new_users SET `password` = ? WHERE id = ?");
            mysqli_stmt_bind_param($u, 'si', $hash, $uid);
            mysqli_stmt_execute($u);
            mysqli_stmt_close($u);

            $success = true;
        } else {
            $errors[] = 'No account found with that email.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reset Password | GreenScore</title>
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>body { padding-top:2rem; }</style>
</head>
<body>
<div class="container" style="max-width:400px;">
    <h3 class="mb-4 text-center">🔄 Reset Your Password</h3>

    <?php if ($success): ?>
        <div class="alert alert-success">
            ✅ Your password has been updated. <a href="login.php">Log in now</a>.
        </div>
    <?php else: ?>
        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger">
                <ul class="mb-0">
                    <?php foreach ($errors as $e): ?>
                        <li><?= htmlspecialchars($e) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form method="POST">
            <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email"
                       name="email"
                       class="form-control"
                       value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"
                       required>
            </div>
            <div class="mb-3">
                <label class="form-label">New Password</label>
                <input type="password"
                       name="new_password"
                       class="form-control"
                       required>
            </div>
            <div class="mb-3">
                <label class="form-label">Confirm Password</label>
                <input type="password"
                       name="confirm_password"
                       class="form-control"
                       required>
            </div>
            <button class="btn btn-primary w-100">Reset Password</button>
            <div class="text-center mt-2">
                <a href="login.php">← Back to Login</a>
            </div>
        </form>
    <?php endif; ?>
</div>
</body>
</html>

