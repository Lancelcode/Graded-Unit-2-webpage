<?php
require_once __DIR__ . '/../../includes/init.php';

if (isset($_SESSION['user_id'])) {
    header('Location: ' . BASE_URL . '/index.php');
    exit();
}


$b      = BASE_URL;
$errors = $_SESSION['register_errors'] ?? [];
$old    = $_SESSION['register_old']    ?? [];
unset($_SESSION['register_errors'], $_SESSION['register_old']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include ROOT_PATH . '/includes/head.php'; ?>
    <title>Register | GreenScore</title>
    <style>
        .auth-wrapper { max-width: 500px; margin: 0 auto; }
        .form-label   { color: #222; font-weight: 500; }
        footer        { position: relative; z-index: 1; background-color: #fff;
                        padding: 2rem 0; width: 100%; }
    </style>
</head>
<body class="bg-page overlay-50"
      style="background-image: url('<?= $b ?>/assets/images/forest-hero.jpg');">
<?php include ROOT_PATH . '/includes/nav.php'; ?>

<div class="container content-wrapper">
    <div class="auth-wrapper">
        <div class="auth-card">
            <h2 class="text-success text-center mb-4">Create Your Account</h2>

            <?php if (!empty($errors)): ?>
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        <?php foreach ($errors as $err): ?>
                            <li><?= htmlspecialchars($err) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form action="<?= $b ?>/pages/auth/register_action.php" method="POST">
                <input type="hidden" name="csrf_token"
                       value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">

                <div class="mb-3">
                    <label for="username" class="form-label">Name:</label>
                    <input type="text" name="username" id="username" class="form-control"
                           value="<?= htmlspecialchars($old['username'] ?? '') ?>" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email address:</label>
                    <input type="email" name="email" id="email" class="form-control"
                           value="<?= htmlspecialchars($old['email'] ?? '') ?>" required>
                </div>
                <div class="mb-3">
                    <label for="company_name" class="form-label">Company Name:</label>
                    <input type="text" name="company_name" id="company_name" class="form-control"
                           value="<?= htmlspecialchars($old['company_name'] ?? '') ?>" required>
                </div>
                <div class="mb-3">
                    <label for="contact_person" class="form-label">Contact Person:</label>
                    <input type="text" name="contact_person" id="contact_person" class="form-control"
                           value="<?= htmlspecialchars($old['contact_person'] ?? '') ?>" required>
                </div>
                <div class="mb-3">
                    <label for="phone_number" class="form-label">Phone Number:</label>
                    <input type="text" name="phone_number" id="phone_number" class="form-control"
                           value="<?= htmlspecialchars($old['phone_number'] ?? '') ?>" required>
                </div>
                <div class="mb-3">
                    <label for="pass1" class="form-label">Password:</label>
                    <input type="password" name="pass1" id="pass1"
                           class="form-control" required minlength="8">
                    <div class="form-text text-muted">Minimum 8 characters.</div>
                </div>
                <div class="mb-3">
                    <label for="pass2" class="form-label">Confirm Password:</label>
                    <input type="password" name="pass2" id="pass2"
                           class="form-control" required minlength="8">
                </div>

                <button type="submit" class="btn btn-success w-100 py-2">
                    Subscribe for just £99 a year!
                </button>
            </form>
            <div class="text-center mt-3">
                <a href="<?= $b ?>/pages/auth/login.php" class="text-muted">
                    Already have an account? Login
                </a>
            </div>
        </div>
    </div>
</div>

<?php include ROOT_PATH . '/includes/footer.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>