<?php
require_once 'includes/init.php';

// Generate CSRF token if not already set
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'includes/head.php'; ?>
    <meta charset="UTF-8">
    <title>Register | GreenScore</title>
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
            background: rgba(255, 255, 255, 0.95);
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
        .btn-primary {
            font-size: 1.25rem;
            padding: 1rem 2rem;
            background-color: #007bff;
            border: none;
            border-radius: 2rem;
            width: 100%;
        }
        .btn-primary:hover {
            background-color: #0056b3;
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
    <div class="card-bg">
        <h2 class="text-success section-title">Create Your Account</h2>
        <form action="register_action.php" method="POST">
            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>" />

            <div class="form-group">
                <label for="username" class="form-label">Name:</label>
                <input type="text" name="username" id="username" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="email" class="form-label">Email address:</label>
                <input type="email" name="email" id="email" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="pass1" class="form-label">Password:</label>
                <input type="password" name="pass1" id="pass1" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="pass2" class="form-label">Confirm Password:</label>
                <input type="password" name="pass2" id="pass2" class="form-control" required>
            </div>

            <div class="form-group">
                <input type="submit" value="Register" class="btn btn-primary">
            </div>
        </form>
    </div>
</div>

<?php include 'includes/footer.php'; ?>

</body>
</html>
