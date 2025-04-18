<?php session_start();
require('includes/connect_db.php');
include('includes/nav.php');
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Login</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    
</head>
<body class="d-flex flex-column min-vh-100">

<h1>Login</h1>
<form action="login_action.php" method="post">
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
    <input type="submit" value="Login" >
</form>
<?php include('includes/footer.php'); ?>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

