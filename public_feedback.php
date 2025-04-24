<?php
require_once 'includes/init.php';
require_once 'includes/connect_db.php';
include 'includes/nav.php';

// Show only feedback marked public by admin
$query = "
    SELECT name, email, message, created_at, admin_response
    FROM feedback
    WHERE visible_to_public = 1
    ORDER BY created_at DESC
";
$result = mysqli_query($link, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Community Feedback | GreenScore</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container mt-5">
    <h1 class="text-success mb-4">🌿 Community Feedback</h1>
    <p class="lead">Here's what our users are saying about their sustainability journey.</p>

    <?php if (mysqli_num_rows($result) > 0): ?>
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <div class="card mb-4 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title text-success"><?= htmlspecialchars($row['name']) ?>
                        <small class="text-muted">(&lt;<?= htmlspecialchars($row['email']) ?>&gt;)</small>
                    </h5>
                    <p class="card-text"><?= nl2br(htmlspecialchars($row['message'])) ?></p>
                    <p class="text-muted small mb-1">🕒 <?= date('F j, Y, g:i a', strtotime($row['created_at'])) ?></p>

                    <?php if (!empty($row['admin_response'])): ?>
                        <div class="alert alert-success mb-0">
                            <strong>Admin Response:</strong> <?= nl2br(htmlspecialchars($row['admin_response'])) ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <div class="alert alert-info">No public feedback available yet.</div>
    <?php endif; ?>
</div>

<?php include 'includes/footer.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
