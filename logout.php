<?php # DISPLAY COMPLETE LOGGED OUT PAGE.

# Access session
session_start();

# Redirect if not logged in
if (!isset($_SESSION['id'])) {
    require('includes/login_tools.php');
    load('login.php');
}

# Clear all session variables
$_SESSION = array();

# Destroy the session
session_destroy();

# Redirect to homepage
header('Location: index.php');
exit();
?>