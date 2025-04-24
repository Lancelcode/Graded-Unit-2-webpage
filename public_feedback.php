<?php
require_once 'includes/init.php';
require_once 'includes/connect_db.php';
include 'includes/nav.php';

$sql = "
  SELECT name, email, message, created_at,
         admin_response, admin_username, admin_response_at
  FROM feedback
  WHERE visible_to_public = 1
  ORDER BY created_at DESC
";
$result = mysqli_query($link, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Community Feedback | GreenScore</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2 class="text-success mb-4">💬 Community Feedback</h2>

    <?php if (mysqli_num_rows($result) > 0): ?>
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
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
        <div class="alert alert-info">
            No public feedback available yet.
        </div>
    <?php endif; ?>

    <?php mysqli_close($link); ?>
</div>

<?php include 'includes/footer.php'; ?>
<script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js">
</script>
</body>
</html>
