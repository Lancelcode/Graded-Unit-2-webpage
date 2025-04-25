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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        html, body {
            height: 100%;
            margin: 0;
        }
        body {
            display: flex;
            flex-direction: column;
            background: url('assets/images/forest-hero.jpg') center/cover no-repeat fixed;
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
            background: rgba(255,255,255,0.95);
            border-radius: 1rem;
            padding: 2rem;
            box-shadow: 0 0 12px rgba(0, 0, 0, 0.2);
            transition: transform 0.2s ease;
        }
        .card-bg:hover {
            transform: translateY(-4px);
        }
        .form-group {
            margin-bottom: 1.5rem;
        }
        .form-control {
            border-radius: 0.5rem;
            padding: 0.8rem;
            font-size: 1rem;
        }
        .form-control:focus {
            box-shadow: 0 0 5px rgba(76, 175, 80, 0.7);
        }
        .btn-success {
            font-size: 1.25rem;
            padding: 1rem 2rem;
            background-color: #4CAF50;
            border: none;
            border-radius: 2rem;
            width: 100%;
        }
        .btn-success:hover {
            background-color: #45a049;
        }
        .error-message {
            background-color: #f8d7da;
            color: #721c24;
            padding: 1rem;
            border-radius: 0.5rem;
            margin-bottom: 1.5rem;
            font-size: 1rem;
        }
        footer {
            position: relative;
            z-index: 1;
            background-color: #fff;
            padding: 2rem 0;
            width: 100%;
        }
        .section-title {
            font-size: 2rem;
            font-weight: bold;
            color: #4CAF50;
            text-align: center;
            margin-bottom: 1rem;
        }
    </style>
</head>
<body>
<?php include 'includes/nav.php'; ?>

<div class="container content-wrapper">
    <h2 class="text-success section-title">Login to GreenScore</h2>

    <?php if (isset($_SESSION['login_error'])): ?>
        <div class="error-message">
            <p><?php echo $_SESSION['login_error']; unset($_SESSION['login_error']); ?></p>
        </div>
    <?php endif; ?>

    <form action="includes/login_action.php" method="post">
        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">

        <div class="form-group">
            <label for="email" class="form-label">Email:</label>
            <input type="email" id="email" name="email" class="form-control" required placeholder="Enter your email">
        </div>

        <div class="form-group">
            <label for="password" class="form-label">Password:</label>
            <input type="password" id="password" name="password" class="form-control" required placeholder="Enter your password">
        </div>

        <button type="submit" class="btn btn-success">Login</button>
    </form>
</div>

<?php include 'includes/footer.php'; ?>

<script src="darkmode.js"></script>
</body>
</html>
