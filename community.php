<?php
require_once 'includes/init.php';
require_once 'includes/connect_db.php';
include 'includes/nav.php';

$logged_in_user = $_SESSION['id'] ?? null;
$logged_in_username = $_SESSION['username'] ?? '';
$logged_in_email = $_SESSION['email'] ?? '';

// Pagination settings
$limit = 5;
$page = isset($_GET['page']) ? max((int)$_GET['page'], 1) : 1;
$offset = ($page - 1) * $limit;

// Count total tips
$total_query = mysqli_query($link, "SELECT COUNT(*) as total FROM community_tips");
$total = mysqli_fetch_assoc($total_query)['total'];
$total_pages = ceil($total / $limit);

// Get tips with user data
$query = "
    SELECT ct.*, u.username, u.email 
    FROM community_tips ct
    JOIN new_users u ON ct.user_id = u.id
    ORDER BY ct.created_at DESC
    LIMIT $limit OFFSET $offset
";
$results = mysqli_query($link, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Community Board | GreenScore</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
<div class="container mt-5">
    <h1 class="text-success text-center mb-4">📝 Sustainability Community Board</h1>
    <p class="lead text-center">Share your eco-friendly tips anonymously 💚</p>

    <!-- Post Form -->
    <div class="card mb-4">
        <div class="card-body">
            <form action="post_tip.php" method="POST">
                <textarea name="message" rows="3" class="form-control" placeholder="E.g. I switched to bamboo toothbrushes!" required></textarea>
                <button type="submit" class="btn btn-success mt-2">✅ Post Tip</button>
            </form>
        </div>
    </div>

    <!-- Tips -->
    <div class="card">
        <div class="card-body">
            <h4 class="mb-4">💬 Latest Tips</h4>

            <?php if (mysqli_num_rows($results) > 0): ?>
                <?php while ($row = mysqli_fetch_assoc($results)): ?>
                    <div class="mb-4 border-bottom pb-3">
                        <p class="mb-1">🟢 <?= htmlspecialchars($row['message']) ?></p>
                        <small class="text-muted">
                            By <?= htmlspecialchars($row['username']) ?> (<?= htmlspecialchars($row['email']) ?>)
                            • <?= date('F j, Y, g:i a', strtotime($row['created_at'])) ?>
                        </small>

                        <?php if ($logged_in_user === $row['user_id']): ?>
                            <div class="mt-2">
                                <button
                                        class="btn btn-sm btn-outline-primary"
                                        data-toggle="modal"
                                        data-target="#editModal"
                                        data-id="<?= $row['id'] ?>"
                                        data-message="<?= htmlspecialchars($row['message'], ENT_QUOTES) ?>">
                                    ✏️ Edit
                                </button>
                                <a href="delete_tip.php?id=<?= $row['id'] ?>"
                                   class="btn btn-sm btn-outline-danger"
                                   onclick="return confirm('Are you sure you want to delete this tip?');">
                                    🗑 Delete
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p class="text-muted">No tips yet — be the first to share!</p>
            <?php endif; ?>
        </div>
    </div>

    <!-- Pagination -->
    <nav class="mt-4">
        <ul class="pagination justify-content-center">
            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
                    <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                </li>
            <?php endfor; ?>
        </ul>
    </nav>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="edit_tip.php" method="POST" class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Your Tip</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="tip_id" id="editTipId">
                <textarea name="message" id="editMessage" rows="4" class="form-control" required></textarea>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">💾 Save Changes</button>
            </div>
        </form>
    </div>
</div>

<?php include 'includes/footer.php'; ?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Populate edit modal
    $('#editModal').on('show.bs.modal', function (event) {
        const button = $(event.relatedTarget);
        const tipId = button.data('id');
        const message = button.data('message');
        $('#editTipId').val(tipId);
        $('#editMessage').val(message);
    });
</script>
</body>
</html>
