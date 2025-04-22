<?php
require_once 'includes/init.php';
require_once 'includes/connect_db.php';

if (!isset($_GET['id']) || !isset($_SESSION['id'])) {
    header('Location: community.php');
    exit();
}

$id = (int)$_GET['id'];
$user_id = $_SESSION['id'];

$q = mysqli_query($link, "SELECT * FROM community_tips WHERE id = $id AND user_id = $user_id");

if (mysqli_num_rows($q) === 0) {
    header('Location: community.php');
    exit();
}

$row = mysqli_fetch_assoc($q);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $updated_msg = mysqli_real_escape_string($link, trim($_POST['message']));
    mysqli_query($link, "UPDATE community_tips SET message = '$updated_msg' WHERE id = $id AND user_id = $user_id");
    header('Location: community.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Tip | GreenScore</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<?php include 'includes/nav.php'; ?>
<div class="container mt-5">
    <h2 class="text-success mb-4">✏️ Edit Your Tip</h2>
    <form method="POST">
        <textarea name="message" class="form-control mb-3" rows="4" required><?= htmlspecialchars($row['message']) ?></textarea>
        <button type="submit" class="btn btn-success">Update Tip</button>
        <a href="community.php" class="btn btn-secondary">Cancel</a>
    </form>
</div>
<?php include 'includes/footer.php'; ?>
</body>
</html>
