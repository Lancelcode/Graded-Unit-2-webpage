<?php
if (isset($_GET['updated'])) {
    $_SESSION['toast_success'] = 'Feedback changes saved successfully.';
}
require_once __DIR__ . '/../../includes/init.php';
require_once ROOT_PATH . '/includes/connect_db.php';
include ROOT_PATH . '/includes/nav.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    include ROOT_PATH . '/403.php';
    exit();
}

$b      = BASE_URL;
$result = mysqli_query($link,
    "SELECT id, name, email, message, created_at, visible_to_public, admin_response
     FROM feedback
     ORDER BY created_at DESC"
);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <?php include ROOT_PATH . '/includes/head.php'; ?>
    <title>Admin Feedback Panel | GreenScore</title>
</head>
<body class="bg-page overlay-50"
      style="background-image: url('<?= $b ?>/assets/images/forest-hero.jpg'); min-height: 100vh;">

<div class="container content-wrapper">
    <div class="card card-bg shadow-sm mb-4 p-4">
        <h2 class="mb-4 text-success text-center">🛠 Admin Feedback Panel</h2>

        <?php if (mysqli_num_rows($result) > 0): ?>
            <form action="<?= $b ?>/pages/admin/process_feedback_admin.php" method="POST">
                <input type="hidden" name="csrf_token"
                       value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">

                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <div class="card card-bg mb-4 shadow-sm p-3">
                        <div class="card-body">
                            <p>
                                <strong>👤 User:</strong> <?= htmlspecialchars($row['name']) ?>
                                (<?= htmlspecialchars($row['email']) ?>)
                            </p>
                            <p><strong>💬 Feedback:</strong><br>
                                <?= nl2br(htmlspecialchars($row['message'])) ?>
                            </p>
                            <p><strong>🕒 Submitted:</strong> <?= $row['created_at'] ?></p>

                            <div class="form-check form-switch mt-3">
                                <input class="form-check-input" type="checkbox" role="switch"
                                       name="visible_to_public[<?= $row['id'] ?>]"
                                       id="visible_to_public<?= $row['id'] ?>"
                                    <?= $row['visible_to_public'] ? 'checked' : '' ?>>
                                <label class="form-check-label fw-semibold"
                                       for="visible_to_public<?= $row['id'] ?>">
                                    Publicly Visible
                                </label>
                            </div>

                            <div class="mt-3">
                                <label for="admin_response_<?= $row['id'] ?>">✍️ Admin Response</label>
                                <textarea class="form-control"
                                          name="admin_response[<?= $row['id'] ?>]"
                                          id="admin_response_<?= $row['id'] ?>"
                                          rows="3"><?= htmlspecialchars($row['admin_response'] ?? '') ?></textarea>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>

                <div class="text-end">
                    <button type="submit" class="btn btn-success px-4 py-2 fw-bold shadow-sm">
                        <i class="fas fa-save me-2"></i> Save Feedback Updates
                    </button>
                </div>
            </form>
        <?php else: ?>
            <div class="alert alert-info">No feedback submitted yet.</div>
        <?php endif; ?>
    </div>
</div>

<?php include ROOT_PATH . '/includes/footer.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php mysqli_close($link); ?>