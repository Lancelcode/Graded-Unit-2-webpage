<?php
require_once 'includes/init.php';
require_once 'includes/connect_db.php';
include 'includes/nav.php';

if (!isset($_SESSION['id'])) {
    require 'login_tools.php';
    load();
}

$user_id = $_SESSION['id'];
$user_name = $_SESSION['username'];
$user_email = $_SESSION['email'];

// Helper functions
function getClientIP() {
    return $_SERVER['REMOTE_ADDR'] ?? 'Unknown';
}

function getMachineName() {
    return gethostname() ?: 'Unknown';
}

function getMachineUUID() {
    ob_start();
    if (PHP_OS_FAMILY === 'Windows') {
        system('wmic csproduct get uuid');
    } else {
        system('cat /var/lib/dbus/machine-id');
    }
    $output = ob_get_clean();
    return trim(preg_replace('/[^a-zA-Z0-9\-]/', '', $output)) ?: 'Unavailable';
}

// Handle submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $message = trim($_POST['message']);
    if (!empty($message)) {
        $stmt = mysqli_prepare($link, "INSERT INTO feedback (user_id, name, email, message, ip_address, machine_name, machine_uuid) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $ip = getClientIP();
        $machine = getMachineName();
        $uuid = getMachineUUID();

        mysqli_stmt_bind_param($stmt, 'issssss', $user_id, $user_name, $user_email, $message, $ip, $machine, $uuid);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        $success = true;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Feedback | GreenScore</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container mt-5">
    <h2 class="text-success mb-4">💬 We Value Your Feedback</h2>

    <?php if (!empty($success)): ?>
        <div class="alert alert-success">✅ Thank you! Your feedback has been submitted.</div>
    <?php endif; ?>

    <form method="POST" action="">
        <div class="form-group mb-3">
            <label>Your Name:</label>
            <input type="text" class="form-control" value="<?= htmlspecialchars($user_name) ?>" disabled>
        </div>

        <div class="form-group mb-3">
            <label>Your Email:</label>
            <input type="email" class="form-control" value="<?= htmlspecialchars($user_email) ?>" disabled>
        </div>

        <div class="form-group mb-3">
            <label>Your Feedback:</label>
            <textarea class="form-control" name="message" rows="4" required></textarea>
        </div>

        <button type="submit" class="btn btn-success">Submit Feedback</button>
    </form>

    <hr class="my-5">
    <h4 class="mb-4">🗃 Public Feedback</h4>

    <?php
    $result = mysqli_query($link, "SELECT name, email, created_at, message, admin_response FROM feedback WHERE is_public = 1 ORDER BY created_at DESC");

    if (mysqli_num_rows($result) > 0):
        while ($row = mysqli_fetch_assoc($result)): ?>
            <div class="border p-3 mb-4 rounded">
                <p class="mb-1"><strong><?= htmlspecialchars($row['name']) ?></strong> (<?= htmlspecialchars($row['email']) ?>)</p>
                <p class="mb-2"><?= htmlspecialchars($row['message']) ?></p>
                <small class="text-muted">🕒 <?= date('F j, Y, g:i a', strtotime($row['created_at'])) ?></small>

                <?php if (!empty($row['admin_response'])): ?>
                    <div class="mt-2 alert alert-secondary">
                        <strong>Admin Response:</strong><br>
                        <?= htmlspecialchars($row['admin_response']) ?>
                    </div>
                <?php endif; ?>
            </div>
        <?php endwhile;
    else:
        echo "<p class='text-muted'>No public feedback yet.</p>";
    endif;

    mysqli_close($link);
    ?>
</div>

<?php include 'includes/footer.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
