<?php
require_once __DIR__ . '/includes/init.php';
require_once __DIR__ . '/includes/connect_db.php';

// Redirect guests to login
if (!isset($_SESSION['id'])) {
    require __DIR__ . '/login_tools.php';
    load();
}

// Page title for head.php
$pageTitle = 'Feedback | GreenScore';

// Handle new feedback submission
$user_id    = $_SESSION['id'];
$user_name  = $_SESSION['username'];
$user_email = $_SESSION['email'];

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

$success = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $message = trim($_POST['message'] ?? '');
    if ($message !== '') {
        $stmt = mysqli_prepare(
            $link,
            "INSERT INTO feedback
               (user_id, name, email, message, ip_address, machine_name, machine_uuid)
             VALUES (?, ?, ?, ?, ?, ?, ?)"
        );
        $ip      = getClientIP();
        $machine = getMachineName();
        $uuid    = getMachineUUID();

        mysqli_stmt_bind_param(
            $stmt,
            'issssss',
            $user_id,
            $user_name,
            $user_email,
            $message,
            $ip,
            $machine,
            $uuid
        );
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        $success = true;
    }
}

// Fetch public feedback
$sql = "SELECT name, email, created_at, message,
               admin_response, admin_username, admin_response_at
        FROM feedback
        WHERE visible_to_public = 1
        ORDER BY created_at DESC";
$res = mysqli_query($link, $sql);

// Render page
include __DIR__ . '/includes/head.php';
include __DIR__ . '/includes/nav.php';
include __DIR__ . '/includes/modals.php';
?>

    <div class="container mt-5">
        <h2 class="text-success mb-4">💬 We Value Your Feedback</h2>

        <?php if ($success): ?>
            <div class="alert alert-success">
                ✅ Thank you! Your feedback has been submitted, one of our staff will get back to you shortly.
            </div>
        <?php endif; ?>

        <form method="POST">
            <div class="form-group mb-3">
                <label>Your Name:</label>
                <input type="text" class="form-control" value="<?= htmlspecialchars($_SESSION['username']) ?>" disabled>
            </div>
            <div class="form-group mb-3">
                <label>Your Email:</label>
                <input type="email" class="form-control" value="<?= htmlspecialchars($_SESSION['email']) ?>" disabled>
            </div>
            <div class="form-group mb-3">
                <label>Your Feedback:</label>
                <textarea class="form-control" name="message" rows="4" required></textarea>
            </div>
            <button type="submit" class="btn btn-success">Submit Feedback</button>
        </form>

        <hr class="my-5">
        <h4 class="mb-4">🗃 Public Feedback</h4>

        <?php if (mysqli_num_rows($res) > 0): ?>
            <?php while ($row = mysqli_fetch_assoc($res)): ?>
                <div class="border p-3 mb-4 rounded">
                    <p class="mb-1">
                        <strong><?= htmlspecialchars($row['name']) ?></strong>
                        (<?= htmlspecialchars($row['email']) ?>)
                    </p>
                    <small class="text-muted">
                        Asked <?= date('F j, Y, g:i a', strtotime($row['created_at'])) ?>
                    </small>
                    <p class="mt-2"><?= nl2br(htmlspecialchars($row['message'])) ?></p>

                    <?php if (!empty($row['admin_response'])): ?>
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
            <?php endwhile; ?>
        <?php else: ?>
            <p class="text-muted">No public feedback yet.</p>
        <?php endif; ?>
    </div>

<?php include __DIR__ . '/includes/footer.php'; ?>