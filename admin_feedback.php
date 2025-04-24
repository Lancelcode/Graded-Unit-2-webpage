<?php
require_once 'includes/init.php';
require_once 'includes/connect_db.php';
include 'includes/nav.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    echo "<div class='container mt-5'>
            <div class='alert alert-danger'>Access denied. Admins only.</div>
          </div>";
    include 'includes/footer.php';
    exit();
}

$result = mysqli_query($link, "SELECT * FROM feedback ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Feedback Panel | GreenScore</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap & Font Awesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2 class="mb-4 text-success">🛠 Admin Feedback Panel</h2>

    <?php if (isset($_GET['updated'])): ?>
        <div class="alert alert-success">✔ Feedback changes saved successfully!</div>
    <?php endif; ?>

    <?php if (mysqli_num_rows($result) > 0): ?>
        <form action="process_feedback_admin.php" method="POST">
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <div class="card mb-4 shadow-sm">
                    <div class="card-body">
                        <p>
                            <strong>👤 User:</strong> <?= htmlspecialchars($row['name']) ?>
                            (<?= htmlspecialchars($row['email']) ?>)
                        </p>
                        <p><strong>💬 Feedback:</strong><br>
                            <?= nl2br(htmlspecialchars($row['message'])) ?>
                        </p>
                        <p><strong>🕒 Submitted:</strong> <?= $row['created_at'] ?></p>

                        <!-- Toggle switch for public visibility -->
                        <div class="form-check form-switch mt-3">
                            <input class="form-check-input"
                                   type="checkbox"
                                   role="switch"
                                   name="visible_to_public[<?= $row['id'] ?>]"
                                   id="visible_to_public<?= $row['id'] ?>"
                                <?= $row['visible_to_public'] ? 'checked' : '' ?>>
                            <label class="form-check-label fw-semibold" for="visible_to_public<?= $row['id'] ?>">
                                Publicly Visible
                            </label>
                        </div>

                        <!-- Admin response area -->
                        <div class="mt-3">
                            <label for="admin_response_<?= $row['id'] ?>">✍️ Admin Response</label>
                            <textarea class="form-control"
                                      name="admin_response[<?= $row['id'] ?>]"
                                      id="admin_response_<?= $row['id'] ?>"
                                      rows="3"><?= htmlspecialchars($row['admin_response']) ?></textarea>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>

            <!-- Submit button -->
            <div class="text-end">
                <button type="submit" class="btn btn-outline-success px-4 py-2 fw-bold shadow-sm">
                    <i class="fas fa-save me-2"></i> Save Feedback Updates
                </button>
            </div>
        </form>
    <?php else: ?>
        <div class="alert alert-info">No feedback submitted yet.</div>
    <?php endif;

    mysqli_close($link);
    ?>
</div>

<?php include 'includes/footer.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

