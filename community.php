<?php
require_once 'includes/init.php';
require_once 'includes/connect_db.php';
include 'includes/nav.php';

$logged_in_user = $_SESSION['id'] ?? null;

// Pagination setup
$limit = 100;
$page = isset($_GET['page']) ? max((int)$_GET['page'], 1) : 1;
$offset = ($page - 1) * $limit;

// Total tip count
$total_query = mysqli_query($link, "SELECT COUNT(*) as total FROM community_tips");
$total = mysqli_fetch_assoc($total_query)['total'];
$total_pages = ceil($total / $limit);

// Fetch tips
$query = "SELECT * FROM community_tips ORDER BY created_at DESC LIMIT $limit OFFSET $offset";
$results = mysqli_query($link, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Community Board | GreenScore</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
<div class="container mt-5">
    <h1 class="mb-4 text-success text-center">📝 Sustainability Community Board</h1>
    <p class="lead text-center">Share your eco-friendly habits, discoveries, or sustainable tips anonymously 💚</p>

    <!-- Post Form -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <form action="logic/post_tip.php" method="POST">
                <div class="form-group">
                    <label for="message"><strong>Your Tip:</strong></label>
                    <textarea name="message" id="message" rows="3" class="form-control" placeholder="E.g. 'I switched to bamboo toothbrushes!'..." required></textarea>
                </div>
                <div class="text-end">
                    <button type="submit" class="btn btn-success">✅ Post Tip</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Tips Display -->
    <div class="card shadow-sm">
        <div class="card-body">
            <h4 class="mb-4">💬 Latest Tips</h4>

            <?php if (mysqli_num_rows($results) > 0): ?>
                <?php while ($row = mysqli_fetch_assoc($results)): ?>
                    <div class="mb-4 border-bottom pb-3">
                        <p class="mb-1">🟢 <?= htmlspecialchars($row['message']) ?></p>
                        <small class="text-muted"><?= date('F j, Y, g:i a', strtotime($row['created_at'])) ?></small>

                        <?php if ($logged_in_user && $row['id'] == $logged_in_user): ?>
                            <div class="mt-2">
                                <a href="edit_tip.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-outline-primary">✏️ Edit</a>
                                <a href="delete_tip.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to delete this tip?')">🗑 Delete</a>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p class="text-muted">No tips yet — be the first to share something inspiring!</p>
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

<?php include 'includes/footer.php'; ?>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
