<?php
require_once __DIR__ . '/includes/init.php';   // starts the session once
if (!isset($_SESSION['username'])) { header('Location: login.php'); exit(); }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - I-Cinema</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

</head>
<body>
<?php include('includes/nav.php'); ?>
<div class="container mt-5 text-center">
    <h1 class="text-success mb-4">🌿 Welcome to GreenScore</h1>
    <p class="lead">Your journey toward sustainability starts here.</p>

    <a href="community.php" class="btn btn-outline-success btn-lg mt-3">
        💬 Visit the Community Board
    </a>
</div>


<?php include('includes/footer.php'); ?>

<!-- Bootstrap JS and dependencies -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
