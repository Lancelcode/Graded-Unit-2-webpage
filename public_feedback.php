<?php
require_once 'includes/init.php';
require_once 'includes/connect_db.php';
include 'includes/nav.php';

$sql = "
  SELECT id, name, email, message, created_at,
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
    <style>
        html, body {
            height: 100%;
            margin: 0;
        }
        body {
            background: url('assets/images/forest-hero.jpg') center/cover no-repeat fixed;
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
        .content-wrapper {
            flex-grow: 1;
            padding: 4rem 1rem;
        }
        .card-bg {
            background: rgba(255, 255, 255, 0.95);
            color: #333;
            padding: 2rem;
            border-radius: 1rem;
            box-shadow: 0 0 12px rgba(0, 0, 0, 0.2);
        }
        .fade-out {
            animation: fadeOut 1s ease-out forwards;
        }
        @keyframes fadeOut {
            to {
                opacity: 0;
                height: 0;
                padding: 0;
                margin: 0;
                overflow: hidden;
            }
        }
    </style>
</head>
<body class="d-flex flex-column min-vh-100">
<div class="container content-wrapper flex-grow-1">
    <h2 class="text-white text-center mb-5">💬 Community Feedback</h2>
    <div id="feedback-list">
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <div class="card card-bg mb-4" id="feedback-<?= $row['id'] ?>">
                <p class="mb-1">
                    <strong><?= htmlspecialchars($row['name']) ?></strong>
                    (<?= htmlspecialchars($row['email']) ?>)
                </p>
                <small class="text-muted">
                    Asked <?= date('F j, Y, g:i a', strtotime($row['created_at'])) ?>
                </small>
                <p class="mt-2 message-text"><?= nl2br(htmlspecialchars($row['message'])) ?></p>

                <div class="d-flex justify-content-end gap-2 mb-2">
                    <form method="POST" onsubmit="return deleteFeedback(this, <?= $row['id'] ?>);" class="d-inline">
                        <input type="hidden" name="delete_id" value="<?= $row['id'] ?>">
                        <button type="submit" name="delete_feedback" class="btn btn-sm btn-outline-danger">🗑 Delete</button>
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

<?php include 'includes/footer.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function deleteFeedback(form, id) {
        fetch(window.location.href, {
            method: 'POST',
            body: new FormData(form)
        })
            .then(() => {
                const card = document.getElementById('feedback-' + id);
                card.classList.add('fade-out');
                setTimeout(() => card.remove(), 1000);
            });
        return false;
    }
</script>
</body>
</html>
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_feedback']) && is_numeric($_POST['delete_id'])) {
    $deleteId = intval($_POST['delete_id']);
    mysqli_query($link, "DELETE FROM feedback WHERE id = $deleteId LIMIT 1");
    exit();
}
mysqli_close($link);
?>
