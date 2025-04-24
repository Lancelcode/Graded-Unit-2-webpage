<?php
session_start();

// Generate CSRF token if not already set
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'includes/head.php'; ?>
    <title>Login | GreenScore</title>
</head>
<body>
<?php include 'includes/nav.php'; ?>

<div class="container" style="max-width: 400px; margin: 60px auto;">
    <h2 class="text-center">Login to GreenScore</h2>

    <?php if (isset($_SESSION['login_error'])): ?>
        <div class="card" style="border-left: 5px solid red;">
            <p style="color: red; margin: 0;"><?php echo $_SESSION['login_error']; unset($_SESSION['login_error']); ?></p>
        </div>
    <?php endif; ?>

    <form action="includes/login_action.php" method="post" class="card">
        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>

        <label for="password" style="margin-top: 10px;">Password:</label>
        <input type="password" id="password" name="password" required>

        <div style="margin-top: 20px;">
            <button type="submit" class="btn-success" style="width: 100%;">Login</button>
        </div>
    </form>
</div>

<?php include 'includes/footer.php'; ?>
<script src="darkmode.js"></script>
</body>
</html>
