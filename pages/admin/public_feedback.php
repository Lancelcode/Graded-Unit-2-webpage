<?php
require_once __DIR__ . '/../../includes/init.php';
require_once ROOT_PATH . '/includes/connect_db.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    http_response_code(403);
    echo "<div class='container mt-5'><div class='alert alert-danger'>Access denied. Admins only.</div></div>";
    include ROOT_PATH . '/includes/footer.php';
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_feedback'])) {
    if (!hash_equals($_SESSION['csrf_token'] ?? '', $_POST['csrf_token'] ?? '')) {
        die('Invalid CSRF token.');
    }
    if (isset($_POST['delete_id']) && ctype_digit((string) $_POST['delete_id'])) {
        $deleteId = (int) $_POST['delete_id'];
        $stmt = mysqli_prepare($link, "DELETE FROM feedback WHERE id = ? LIMIT 1");
        mysqli_stmt_bind_param($stmt, 'i', $deleteId);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }
    if (!empty($_SERVER['HTTP_X_REQUESTED_WITH'])) {
        exit();
    }
    header('Location: /pages/admin/public_feedback.php');
    exit();
}

include ROOT_PATH . '/includes/nav.php';

$result = mysqli_query($link,
    "SELECT id, name, email, message, created_at,
            admin_response, admin_username, admin_response_at
     FROM feedback
     WHERE visible_to_public = 1
     ORDER BY created_at DESC"
);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include ROOT_PATH . '/includes/head.php'; ?>
    <title>Community Feedback | GreenScore</title>
    <style>
        html, body { height: 100%; margin: 0; }
        body {
            background: url('/assets/images/forest-hero.jpg') center/cover no-repeat fixed;
            position: relative;
            color: #fff;
            display: flex;
            flex-direction: column;
        }
        body::before {
            content: '';
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.6);
            z-index: -1;
        }
        .content-wrapper { flex-grow: 1; padding: 4rem 1rem; }
        .card-bg {
            background: rgba(255, 255, 255, 0.95);
            color: #333;
            padding: 2rem;
            border-radius: 1rem;
            box-shadow: 0 0 12px rgba(0, 0, 0, 0.2);
        }
        .fade-out { animation: fadeOut 0.6s ease-out forwards; }
        @keyframes fadeOut {
            to { opacity: 0; height: 0; padding: 0; margin: 0; overflow: hidden; }
        }
    </style>
</head>
<body class="d-flex flex-column min-vh-100">
<div class="container content-wrapper flex-grow-1">
    <h2 class="text-white text-center mb-5">💬 Community Feedback</h2>
    <div id="feedback-list">
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <div class="card card-bg mb-4" id="feedback-<?= (int) $row['id'] ?>">
                <p class="mb-1">
                    <strong><?= htmlspecialchars($row['name']) ?></strong>
                    (<?= htmlspecialchars($row['email']) ?>)
                </p>
                <small class="text-muted">
                    Asked <?= date('F j, Y, g:i a', strtotime($row['created_at'])) ?>
                </small>
                <p class="mt-2"><?= nl2br(htmlspecialchars($row['message'])) ?></p>

                <div class="d-flex justify-content-end gap-2 mb-2">
                    <form method="POST"
                          onsubmit="return deleteFeedback(this, <?= (int) $row['id'] ?>);"
                          class="d-inline">
                        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">
                        <input type="hidden" name="delete_id" value="<?= (int) $row['id'] ?>">
                        <button type="submit" name="delete_feedback"
                                class="btn btn-sm btn-outline-danger">🗑 Delete</button>
                    </form>
                </div>

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
    </div>
</div>

<?php include ROOT_PATH . '/includes/footer.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
function deleteFeedback(form, id) {
    fetch(window.location.href, {
        method: 'POST',
        headers: { 'X-Requested-With': 'XMLHttpRequest' },
        body: new FormData(form)
    }).then(() => {
        const card = document.getElementById('feedback-' + id);
        card.classList.add('fade-out');
        setTimeout(() => card.remove(), 600);
    });
    return false;
}
</script>
</body>
</html>
<?php mysqli_close($link); ?>