<?php
require_once 'includes/init.php';
require_once 'includes/connect_db.php';
include 'includes/nav.php';

$logged_in_user = $_SESSION['user_id'] ?? null;
$logged_in_username = $_SESSION['username'] ?? '';
$logged_in_email = $_SESSION['email'] ?? '';

// Pagination
$limit = 5;
$page = isset($_GET['page']) ? max((int)$_GET['page'], 1) : 1;
$offset = ($page - 1) * $limit;

$total_query = mysqli_query($link, "SELECT COUNT(*) as total FROM community_tips");
$total = mysqli_fetch_assoc($total_query)['total'];
$total_pages = ceil($total / $limit);

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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
    <style>
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
        }

        body {
            display: flex;
            flex-direction: column;
            background: url('assets/images/forest-hero.jpg') center/cover no-repeat fixed;
        }

        .page-wrapper {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .content-wrapper {
            flex: 1;
            padding: 4rem 1rem;
        }

        .card-bg {
            background: rgba(255,255,255,0.95);
            border-radius: 1rem;
        }

        footer {
            background-color: #fff;
            color: #444;
            padding: 2rem 0;
            margin-top: auto;
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
<body>
<div class="overlay"></div>
<div class="page-wrapper">
    <div class="container content-wrapper">
        <h1 class="text-white text-center mb-4">📝 Sustainability Community Board</h1>
        <p class="lead text-center text-white mb-5">Share your eco-friendly tips 💚</p>

        <!-- Tip Form -->
        <div class="card card-bg shadow-sm mb-4">
            <div class="card-body">
                <form action="post_tip.php" method="POST">
                    <textarea name="message" rows="3" class="form-control" placeholder="E.g. I switched to bamboo toothbrushes!" required></textarea>
                    <button type="submit" class="btn btn-success mt-3">✅ Post Tip</button>
                </form>
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <form method="POST" action="clear_tips.php" onsubmit="return confirm('⚠️ Are you sure you want to clear all your tips? This cannot be undone.')">
                        <button type="submit" class="btn btn-danger">🧹 Clear My Tips</button>
                    </form>
                </div>
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <a href="user_account.php" class="btn btn-outline-dark">
                        👤 Back to My Profile
                    </a>
                </div>
            </div>
        </div>

        <!-- Tip List -->
        <div class="card card-bg shadow-sm mb-4">
            <div class="card-body">
                <h4 class="mb-4">💬 Latest Tips</h4>

                <?php if (mysqli_num_rows($results) > 0): ?>
                    <?php while ($row = mysqli_fetch_assoc($results)): ?>
                        <div class="mb-4 border-bottom pb-3" id="tip-<?= $row['id'] ?>">
                            <p class="mb-1">🟢 <?= htmlspecialchars($row['message']) ?></p>
                            <small class="text-muted">
                                By <?= htmlspecialchars($row['username']) ?> (<?= htmlspecialchars($row['email']) ?>)
                                • <?= date('F j, Y, g:i a', strtotime($row['created_at'])) ?>
                            </small>

                            <?php if ($logged_in_user == $row['user_id']): ?>
                                <div class="mt-2">
                                    <button class="btn btn-sm btn-outline-primary"
                                            data-bs-toggle="modal"
                                            data-bs-target="#editModal"
                                            data-id="<?= $row['id'] ?>"
                                            data-message="<?= htmlspecialchars($row['message'], ENT_QUOTES) ?>">
                                        ✏️ Edit
                                    </button>
                                    <form method="POST" onsubmit="return deleteTip(this, <?= $row['id'] ?>);" class="d-inline">
                                        <input type="hidden" name="delete_id" value="<?= $row['id'] ?>">
                                        <button type="submit" name="delete_tip" class="btn btn-sm btn-outline-danger">
                                            🗑 Delete
                                        </button>
                                    </form>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <div class="alert alert-info">No tips shared yet. Be the first!</div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Pagination -->
        <?php if ($total_pages > 1): ?>
            <nav class="mt-4">
                <ul class="pagination justify-content-center">
                    <?php for ($p = 1; $p <= $total_pages; $p++): ?>
                        <li class="page-item <?= $p === $page ? 'active' : '' ?>">
                            <a class="page-link" href="?page=<?= $p ?>"><?= $p ?></a>
                        </li>
                    <?php endfor; ?>
                </ul>
            </nav>
        <?php endif; ?>
    </div>

    <!-- Footer always at bottom -->
    <?php include 'includes/footer.php'; ?>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form class="modal-content" action="edit_tip.php" method="POST">
            <div class="modal-header">
                <h5 class="modal-title">Edit Tip</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="tip_id" id="editTipId">
                <textarea class="form-control" name="message" id="editTipMessage" rows="4" required></textarea>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success">📏 Save Changes</button>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const editModal = document.getElementById('editModal');
    editModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const tipId = button.getAttribute('data-id');
        const message = button.getAttribute('data-message');
        document.getElementById('editTipId').value = tipId;
        document.getElementById('editTipMessage').value = message;
    });

    function deleteTip(form, id) {
        fetch(window.location.href, {
            method: 'POST',
            body: new FormData(form)
        }).then(() => {
            const card = document.getElementById('tip-' + id);
            card.classList.add('fade-out');
            setTimeout(() => card.remove(), 1000);
        });
        return false;
    }
</script>
</body>
</html>
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_tip']) && is_numeric($_POST['delete_id'])) {
    $deleteId = intval($_POST['delete_id']);
    mysqli_query($link, "DELETE FROM community_tips WHERE id = $deleteId AND user_id = $logged_in_user LIMIT 1");
    exit();
}
mysqli_close($link);
?>
