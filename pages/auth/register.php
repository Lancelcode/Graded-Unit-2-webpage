<?php
require_once __DIR__ . '/../../includes/init.php';

if (isset($_SESSION['user_id'])) {
    header('Location: /index.php');
    exit();
}

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include ROOT_PATH . '/includes/head.php'; ?>
    <title>Register | GreenScore</title>
    <style>
        html, body { height: 100%; margin: 0; }
        body {
            display: flex;
            flex-direction: column;
            background: url('/assets/images/forest-hero.jpg') center/cover no-repeat fixed;
            position: relative;
            color: #fff;
        }
        .content-wrapper {
            flex: 1;
            position: relative;
            z-index: 1;
            padding: 4rem 1rem;
            max-width: 500px;
            margin: 0 auto;
        }
        .card-bg {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 1rem;
            padding: 2rem;
            box-shadow: 0 0 12px rgba(0, 0, 0, 0.2);
        }
        .form-label { color: #222; font-weight: 500; }
        footer {
            position: relative;
            z-index: 1;
            background-color: #fff;
            padding: 2rem 0;
            width: 100%;
        }
    </style>
</head>
<body>
<?php include ROOT_PATH . '/includes/nav.php'; ?>

<div class="container content-wrapper">
    <div class="card-bg">
        <h2 class="text-success text-center mb-4">Create Your Account</h2>
        <form action="/pages/auth/register_action.php" method="POST">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">

            <div class="mb-3">
                <label for="username" class="form-label">Name:</label>
                <input type="text" name="username" id="username" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email address:</label>
                <input type="email" name="email" id="email" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="company_name" class="form-label">Company Name:</label>
                <input type="text" name="company_name" id="company_name" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="contact_person" class="form-label">Contact Person:</label>
                <input type="text" name="contact_person" id="contact_person" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="phone_number" class="form-label">Phone Number:</label>
                <input type="text" name="phone_number" id="phone_number" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="pass1" class="form-label">Password:</label>
                <input type="password" name="pass1" id="pass1" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="pass2" class="form-label">Confirm Password:</label>
                <input type="password" name="pass2" id="pass2" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-success w-100 py-2">
                Subscribe for just £99 a year!
            </button>
        </form>
    </div>
</div>

<?php include ROOT_PATH . '/includes/footer.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>