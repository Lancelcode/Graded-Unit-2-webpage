<?php
require_once 'includes/init.php';
require_once 'includes/connect_db.php';
include 'includes/nav.php';

if (!isset($_SESSION['id'])) {
    require 'includes/login_tools.php';
    load();
}

$user_id    = $_SESSION['id'];
$user_name  = $_SESSION['username'];
$user_email = $_SESSION['email'];

// Helpers (unchanged)…
function getClientIP() { /* … */ }
function getMachineName() { /* … */ }
function getMachineUUID() { /* … */ }

// Handle they submit new feedback
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $message = trim($_POST['message']);
    if ($message !== '') {
        $stmt = mysqli_prepare($link,
            "INSERT INTO feedback
               (user_id, name, email, message, ip_address, machine_name, machine_uuid)
             VALUES (?, ?, ?, ?, ?, ?, ?)"
        );
        $ip      = getClientIP();
        $machine = getMachineName();
        $uuid    = getMachineUUID();

        mysqli_stmt_bind_param($stmt, 'issssss',
            $user_id, $user_name, $user_email,
            $message, $ip, $machine, $uuid
        );
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
    <link
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
            rel="stylesheet">
    <link href="style.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2 class="text-success mb-4">💬 We Value Your Feedback</h2>

    <?php if (!empty($success)): ?>
        <div class="alert alert-success">
            ✅ Thank you! Your feedback has been submitted.
        </div>
    <?php endif; ?>

    <form method="POST">
        <!-- Name & Email pre-filled disabled -->
        <div class="form-group mb-3">
            <label>Your Name:</label>
            <input type="text" class="form-control"
                   value="<?= htmlspecialchars($user_name) ?>" disabled>
        </div>
        <div class="form-group mb-3">
            <label>Your Email:</label>
            <input type="email" class="form-control"
                   value="<?= htmlspecialchars($user_email) ?>" disabled>
        </div>
        <div class="form-group mb-3">
            <label>Your Feedback:</label>
            <textarea class="form-control" name="message" rows="4"
                      required></textarea>
        </div>
        <button type="submit" class="btn btn-success">Submit Feedback</button>
    </form>

    <hr class="my-5">
    <h4 class="mb-4">🗃 Public Feedback</h4>

    <?php
    // 🔑 USE visible_to_public (not is_public) and pull in admin_username, admin_response_at
    $sql = "
      SELECT name, email, created_at, message,
             admin_response, admin_username, admin_response_at
      FROM feedback
      WHERE visible_to_public = 1
      ORDER BY created_at DESC
    ";
    $res = mysqli_query($link, $sql);

    if (mysqli_num_rows($res) > 0):
        while ($row = mysqli_fetch_assoc($res)): ?>
            <div class="border p-3 mb-4 rounded">
                <!-- Question info -->
                <p class="mb-1">
                    <strong><?= htmlspecialchars($row['name']) ?></strong>
                    (<?= htmlspecialchars($row['email']) ?>)
                </p>
                <small class="text-muted">
                    Asked <?= date('F j, Y, g:i a', strtotime($row['created_at'])) ?>
                </small>
                <p class="mt-2"><?= nl2br(htmlspecialchars($row['message'])) ?></p>

                <?php if (!empty($row['admin_response'])): ?>
                    <!-- Admin answer -->
                    <hr>
                    <p class="mb-1">
                        <strong>Answered by <?= htmlspecialchars($row['admin_username']) ?></strong>
                        <small class="text-muted">
                            <?= date('F j, Y, g:i a', strtotime($row['admin_response_at'])) ?>
                        </small>
                    </p>
                    <div class="alert alert-secondary">
                        <?= nl2br(htmlspecialchars($row['admin_response'])) ?>
                    </div>
                <?php endif; ?>
            </div>
        <?php endwhile;
    else: ?>
        <p class="text-muted">No public feedback yet.</p>
    <?php endif;

    mysqli_close($link);
    ?>
</div>

<?php include 'includes/footer.php'; ?>
<script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js">
</script>
</body>
</html>
