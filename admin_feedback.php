<?php
require_once 'includes/init.php';
require_once 'includes/connect_db.php';
include 'includes/nav.php';

// Check if admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    echo "<div class='container mt-5'><div class='alert alert-danger'>Access denied. Admins only.</div></div>";
    include 'includes/footer.php';
    exit();
}

$query = "SELECT * FROM feedback ORDER BY created_at DESC";
$result = mysqli_query($link, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Feedback Panel | GreenScore</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container mt-5">
    <h2 class="mb-4 text-success">🛠 Admin Feedback Panel</h2>

    <?php if (mysqli_num_rows($result) > 0): ?>
        <form action="process_feedback_admin.php" method="post">
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <div class="card mb-4">
                    <div class="card-body">
                        <p><strong>👤 User:</strong> <?= htmlspecialchars($row['name']) ?> (<?= htmlspecialchars($row['email']) ?>)</p>
                        <p><strong>💬 Feedback:</strong> <?= nl2br(htmlspecialchars($row['message'])) ?></p>
                        <p><strong>🕒 Submitted:</strong> <?= $row['created_at'] ?></p>
                        <p><strong>🖥 IP:</strong> <?= $row['ip_address'] ?> | <strong>Machine:</strong> <?= $row['machine_name'] ?> | <strong>UUID:</strong> <?= $row['machine_uuid'] ?></p>

                        <div class="form-check mt-2">
                            <input class="form-check-input" type="checkbox" name="visible[<?= $row['id'] ?>]" id="visible<?= $row['id'] ?>" <?= $row['visible'] ? 'checked' : '' ?>>
                            <label class="form-check-label" for="visible<?= $row['id'] ?>">Make Public</label>
                        </div>

                        <div class="mt-2">
                            <label for="admin_response_<?= $row['id'] ?>">Admin Response</label>
                            <textarea class="form-control" name="admin_response[<?= $row['id'] ?>]" id="admin_response_<?= $row['id'] ?>" rows="2"><?= htmlspecialchars($row['admin_response']) ?></textarea>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
            <button type="submit" class="btn btn-success">💾 Save Changes</button>
        </form>
    <?php else: ?>
        <p class="text-muted">No feedback submitted yet.</p>
    <?php endif; ?>
</div>

<?php include 'includes/footer.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
