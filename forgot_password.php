<?php
require_once 'includes/init.php';
require_once 'includes/connect_db.php';

if (isset($_SESSION['user_id'])) {
    header('Location: green_calculator.php');
    exit();
}

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$errors = [];
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'] ?? '')) {
        die('Invalid CSRF token');
    }

    $email  = trim($_POST['email'] ?? '');
    $pass1  = $_POST['new_password'] ?? '';
    $pass2  = $_POST['confirm_password'] ?? '';

    if (!preg_match('/^[^@]+@[^@]+$/', $email)) {
        $errors[] = 'Email must be in the format name@name (no domain).';
    }
    if (strlen($pass1) < 1) {
        $errors[] = 'Password must be at least 1 character.';
    }
    if ($pass1 !== $pass2) {
        $errors[] = 'Passwords do not match.';
    }

    if (empty($errors)) {
        $stmt = mysqli_prepare($link, "SELECT id FROM new_users WHERE email = ?");
        mysqli_stmt_bind_param($stmt, 's', $email);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $uid);
        mysqli_stmt_fetch($stmt);
        mysqli_stmt_close($stmt);

        if ($uid) {
            $hash = password_hash($pass1, PASSWORD_DEFAULT);
            $u = mysqli_prepare($link, "UPDATE new_users SET `password` = ? WHERE id = ?");
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
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            background: url('assets/images/forest-hero.jpg') center/cover no-repeat fixed;
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            position: relative;
            min-height: 100vh;
        }
        body::before {
            content: '';
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 0;
        }
        .content-wrapper {
            position: relative;
            z-index: 1;
            max-width: 450px;
            margin: 5rem auto;
            background: rgba(255, 255, 255, 0.95);
            padding: 3rem 2rem;
            border-radius: 1rem;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.3);
        }
        h3 {
            text-align: center;
            color: #2e7d32;
            font-weight: bold;
            margin-bottom: 2rem;
        }
    </style>
</head>
<body>
<div class="content-wrapper">
    <h3>🔄 Reset Your Password</h3>

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
                <input type="text"
                       name="email"
                       class="form-control"
                       value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"
                       required>
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
                <a href="login.php" class="text-decoration-none">← Back to Login</a>
            </div>
        </form>
    <?php endif; ?>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
