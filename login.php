<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/includes/init.php';   // starts / resumes the session

// ── login‑required guard ─────────────────────
if (isset($_SESSION['username'])) {           // <- use the key you store
    header('Location: index.php');
    exit();
}

require('includes/connect_db.php');
include('includes/nav.php');
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
</head>
<body class="d-flex flex-column min-vh-100">

<h1>Login</h1>
<form action="includes/login_action.php" method="post">
    <h3 for="email">Email:</h3><br>
    <input type="text"
           class="form-control"
           placeholder="Email"
           name="email"
           required>
    <br><br>

    <h3 for="password">Password:</h3><br>
    <input type="password"
           class="form-control"
           placeholder="Password"
           name="password"
           required>
    <br><br>

    <label>
        <input type="checkbox" name="admin_login" value="1">
        Login as Admin
    </label>
    <br><br>

    <input type="submit" value="Login">
</form>

<?php include('includes/footer.php'); ?>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

