<?php
require_once __DIR__ . '/../../includes/init.php';
require_once ROOT_PATH . '/includes/connect_db.php';
include ROOT_PATH . '/includes/nav.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: ' . BASE_URL . '/pages/auth/login.php');
    exit();
}

$b          = BASE_URL;
$user_id    = $_SESSION['user_id'];
$user_name  = $_SESSION['username'];
$user_email = $_SESSION['email'];
$success    = false;
$error      = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!hash_equals($_SESSION['csrf_token'] ?? '', $_POST['csrf_token'] ?? '')) {
        die('Invalid CSRF token.');
    }
    try {
        $message = trim($_POST['message']);
        if (empty($message)) {
            throw new Exception("⚠️ Please enter your feedback before submitting.");
        }
        $stmt = mysqli_prepare($link,
            "INSERT INTO feedback (user_id, name, email, message) VALUES (?, ?, ?, ?)"
        );
        mysqli_stmt_bind_param($stmt, 'isss', $user_id, $user_name, $user_email, $message);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        $success = true;
    } catch (Exception $e) {
        $error = $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include ROOT_PATH . '/includes/head.php'; ?>
    <title>Feedback | GreenScore</title>
    <style>
        html, body { height: 100%; margin: 0; padding: 0; }
        body {
            display: flex; flex-direction: column;
            background: url('<?= $b ?>/assets/images/forest-hero.jpg') center/cover no-repeat fixed;
        }
        body::before {
            content: ''; position: fixed; inset: 0;
            background: rgba(0,0,0,0.5); z-index: 0;
        }
        .page-wrapper {
            display: flex; flex-direction: column;
            min-height: 100vh; position: relative; z-index: 1;
        }
        .content-wrapper { flex: 1; padding: 4rem 1rem; }
        .card-bg { background: rgba(255,255,255,0.95); border-radius: 1rem; }
        footer { background-color: #fff; padding: 2rem 0; margin-top: auto; }
    </style>
</head>
<body>
<div class="page-wrapper">
    <div class="container content-wrapper">
        <h2 class="text-white text-center mb-4">💬 We Value Your Feedback</h2>

        <?php if ($success): ?>
            <div class="alert alert-success shadow-sm">
                ✅ Thank you! Your feedback has been submitted and will be answered by
                one of our admins.
            </div>
        <?php endif; ?>
        <?php if ($error): ?>
            <div class="alert alert-warning shadow-sm"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form method="POST" class="card card-bg p-4 shadow-sm mb-5">
            <input type="hidden" name="csrf_token"
                   value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">
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
                <textarea class="form-control" name="message" rows="4"></textarea>
            </div>
            <button type="submit" class="btn btn-success w-100">✅ Submit Feedback</button>
        </form>

        <h4 class="text-white mb-4">🗃 Public Feedback</h4>

        <?php
        $sql = "SELECT name, email, created_at, message,
                       admin_response, admin_username, admin_response_at
                FROM feedback
                WHERE visible_to_public = 1
                ORDER BY created_at DESC";
        $res = mysqli_query($link, $sql);

        if (mysqli_num_rows($res) > 0):
            while ($row = mysqli_fetch_assoc($res)): ?>
                <div class="card card-bg card-body mb-4 shadow-sm">
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
                        <div class="alert alert-secondary mb-0">
                            <?= nl2br(htmlspecialchars($row['admin_response'])) ?>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endwhile;
        else: ?>
            <div class="alert alert-info card-bg">No public feedback yet.</div>
        <?php endif;
        mysqli_close($link);
        ?>
    </div>

    <?php include ROOT_PATH . '/includes/footer.php'; ?>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>