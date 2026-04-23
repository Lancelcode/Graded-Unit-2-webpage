<?php
require_once __DIR__ . '/../../includes/init.php';
require_once ROOT_PATH . '/includes/connect_db.php';
include ROOT_PATH . '/includes/nav.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: ' . BASE_URL . '/pages/auth/login.php');
    exit();
}

$b              = BASE_URL;
$user_id        = (int) $_SESSION['user_id'];
$action_message = '';

if (isset($_POST['delete_id'])) {
    if (!hash_equals($_SESSION['csrf_token'] ?? '', $_POST['csrf_token'] ?? '')) die('Invalid CSRF token.');
    $delete_id = (int) $_POST['delete_id'];
    $stmt = mysqli_prepare($link, "DELETE FROM green_calculator_results WHERE id = ? AND user_id = ?");
    mysqli_stmt_bind_param($stmt, 'ii', $delete_id, $user_id);
    mysqli_stmt_execute($stmt); mysqli_stmt_close($stmt);
    $action_message = '❌ Entry deleted successfully.';
}

if (isset($_POST['reset_id'])) {
    if (!hash_equals($_SESSION['csrf_token'] ?? '', $_POST['csrf_token'] ?? '')) die('Invalid CSRF token.');
    $_SESSION['reset_entry_id'] = (int) $_POST['reset_id'];
    header('Location: ' . BASE_URL . '/pages/calculator/green_calculator.php?reset=1');
    exit();
}

if (isset($_POST['clear_all'])) {
    if (!hash_equals($_SESSION['csrf_token'] ?? '', $_POST['csrf_token'] ?? '')) die('Invalid CSRF token.');
    $stmt = mysqli_prepare($link, "DELETE FROM green_calculator_results WHERE user_id = ?");
    mysqli_stmt_bind_param($stmt, 'i', $user_id);
    mysqli_stmt_execute($stmt); mysqli_stmt_close($stmt);
    $action_message = '🧹 All entries cleared.';
}

if (isset($_POST['update_id'])) {
    if (!hash_equals($_SESSION['csrf_token'] ?? '', $_POST['csrf_token'] ?? '')) die('Invalid CSRF token.');
    $update_id    = (int) $_POST['update_id'];
    $new_award    = trim($_POST['award_level'] ?? '');
    $new_feedback = trim($_POST['feedback_message'] ?? '');
    $stmt = mysqli_prepare($link,
        "UPDATE green_calculator_results SET award_level = ?, feedback_message = ? WHERE id = ? AND user_id = ?"
    );
    mysqli_stmt_bind_param($stmt, 'ssii', $new_award, $new_feedback, $update_id, $user_id);
    mysqli_stmt_execute($stmt); mysqli_stmt_close($stmt);
    $action_message = '✏️ Entry updated.';
}

$levels_stmt = mysqli_prepare($link,
    "SELECT DISTINCT award_level FROM green_calculator_results WHERE user_id = ?"
);
mysqli_stmt_bind_param($levels_stmt, 'i', $user_id);
mysqli_stmt_execute($levels_stmt);
$levels_result = mysqli_stmt_get_result($levels_stmt);
$award_levels  = [];
while ($lvl = mysqli_fetch_assoc($levels_result)) $award_levels[] = $lvl['award_level'];
mysqli_stmt_close($levels_stmt);

$entries_per_page = 8;
$page         = isset($_GET['page']) ? max(1, (int) $_GET['page']) : 1;
$offset       = ($page - 1) * $entries_per_page;
$order        = (isset($_GET['sort']) && $_GET['sort'] === 'oldest') ? 'ASC' : 'DESC';
$level_filter = (isset($_GET['level']) && in_array($_GET['level'], $award_levels, true)) ? $_GET['level'] : '';

if ($level_filter !== '') {
    $count_stmt = mysqli_prepare($link,
        "SELECT COUNT(*) AS total FROM green_calculator_results WHERE user_id = ? AND award_level = ?"
    );
    mysqli_stmt_bind_param($count_stmt, 'is', $user_id, $level_filter);
} else {
    $count_stmt = mysqli_prepare($link,
        "SELECT COUNT(*) AS total FROM green_calculator_results WHERE user_id = ?"
    );
    mysqli_stmt_bind_param($count_stmt, 'i', $user_id);
}
mysqli_stmt_execute($count_stmt);
$total_entries = (int) mysqli_fetch_assoc(mysqli_stmt_get_result($count_stmt))['total'];
$total_pages   = (int) ceil($total_entries / $entries_per_page);
mysqli_stmt_close($count_stmt);

if ($level_filter !== '') {
    $data_stmt = mysqli_prepare($link,
        "SELECT * FROM green_calculator_results WHERE user_id = ? AND award_level = ?
         ORDER BY submitted_at $order LIMIT ? OFFSET ?"
    );
    mysqli_stmt_bind_param($data_stmt, 'isii', $user_id, $level_filter, $entries_per_page, $offset);
} else {
    $data_stmt = mysqli_prepare($link,
        "SELECT * FROM green_calculator_results WHERE user_id = ?
         ORDER BY submitted_at $order LIMIT ? OFFSET ?"
    );
    mysqli_stmt_bind_param($data_stmt, 'iii', $user_id, $entries_per_page, $offset);
}
mysqli_stmt_execute($data_stmt);
$results = mysqli_stmt_get_result($data_stmt);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include ROOT_PATH . '/includes/head.php'; ?>
    <title>Certificate History | GreenScore</title>
    <style>
        html, body { height: 100%; margin: 0; display: flex; flex-direction: column; }
        body {
            background: url('<?= $b ?>/assets/images/forest-hero.jpg') center/cover no-repeat fixed;
            position: relative;
        }
        body::before {
            content: ''; position: fixed; inset: 0;
            background: rgba(0,0,0,0.5); z-index: -1;
        }
        .page-wrapper { flex: 1; position: relative; z-index: 1; padding-top: 4rem; }
        .card-bg { background: rgba(255,255,255,0.95); border-radius: 1rem; }
    </style>
</head>
<body>
<div class="page-wrapper d-flex flex-column min-vh-100">
    <div class="container">
        <h1 class="text-white text-center mb-4">📜 Certificate History</h1>

        <?php if ($action_message): ?>
            <div class="alert alert-success text-center">
                <?= htmlspecialchars($action_message) ?>
            </div>
        <?php endif; ?>

        <form class="row justify-content-center mb-4" method="get">
            <div class="col-md-3">
                <select name="sort" class="form-select" onchange="this.form.submit()">
                    <option value="">Sort by Date</option>
                    <option value="newest" <?= (empty($_GET['sort']) || $_GET['sort'] === 'newest') ? 'selected' : '' ?>>Newest First</option>
                    <option value="oldest" <?= (($_GET['sort'] ?? '') === 'oldest') ? 'selected' : '' ?>>Oldest First</option>
                </select>
            </div>
            <div class="col-md-3">
                <select name="level" class="form-select" onchange="this.form.submit()">
                    <option value="">Filter by Award</option>
                    <?php foreach ($award_levels as $level): ?>
                        <option value="<?= htmlspecialchars($level) ?>"
                            <?= (($_GET['level'] ?? '') === $level) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($level) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </form>

        <?php if (mysqli_num_rows($results) > 0): ?>
            <div class="card card-bg shadow-sm p-4 mb-4">
                <form method="post" class="text-end mb-3"
                      onsubmit="return confirm('Clear all certificates?')">
                    <input type="hidden" name="csrf_token"
                           value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">
                    <button type="submit" name="clear_all" class="btn btn-outline-danger">
                        🧹 Clear All
                    </button>
                </form>

                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>#</th><th>Date</th><th>Award</th><th>Score</th>
                                <th>Green</th><th>Amber</th><th>Red</th>
                                <th>Feedback</th><th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php $count = $offset + 1; while ($row = mysqli_fetch_assoc($results)): ?>
                            <tr>
                                <form method="POST">
                                    <input type="hidden" name="csrf_token"
                                           value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">
                                    <input type="hidden" name="update_id" value="<?= (int) $row['id'] ?>">
                                    <td><?= $count++ ?></td>
                                    <td><?= date('d/m/Y', strtotime($row['submitted_at'])) ?></td>
                                    <td>
                                        <input type="text" name="award_level"
                                               value="<?= htmlspecialchars($row['award_level']) ?>"
                                               class="form-control form-control-sm" required>
                                    </td>
                                    <td><?= (int) $row['total_score'] ?></td>
                                    <td><?= (int) $row['green_count'] ?></td>
                                    <td><?= (int) $row['amber_count'] ?></td>
                                    <td><?= (int) $row['red_count'] ?></td>
                                    <td>
                                        <input type="text" name="feedback_message"
                                               value="<?= htmlspecialchars($row['feedback_message']) ?>"
                                               class="form-control form-control-sm" required>
                                    </td>
                                    <td class="text-nowrap">
                                        <button type="submit" class="btn btn-sm btn-primary">💾</button>
                                </form>
                                <form method="POST" style="display:inline;"
                                      onsubmit="return confirm('Reset this entry?')">
                                    <input type="hidden" name="csrf_token"
                                           value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">
                                    <input type="hidden" name="reset_id" value="<?= (int) $row['id'] ?>">
                                    <button type="submit" class="btn btn-sm btn-warning">🔁</button>
                                </form>
                                <form method="POST" style="display:inline;"
                                      onsubmit="return confirm('Delete this entry?')">
                                    <input type="hidden" name="csrf_token"
                                           value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">
                                    <input type="hidden" name="delete_id" value="<?= (int) $row['id'] ?>">
                                    <button type="submit" class="btn btn-sm btn-danger">🗑️</button>
                                </form>
                                    </td>
                            </tr>
                        <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <?php if ($total_pages > 1): ?>
            <nav class="text-center">
                <ul class="pagination justify-content-center">
                    <?php
                    $query_params = $_GET;
                    for ($i = 1; $i <= $total_pages; $i++) {
                        $query_params['page'] = $i;
                        $url    = $b . '/pages/calculator/certificate_history.php?'
                                . http_build_query($query_params);
                        $active = ($i === $page) ? 'active' : '';
                        echo "<li class='page-item $active'>
                                <a class='page-link' href='" . htmlspecialchars($url) . "'>$i</a>
                              </li>";
                    }
                    ?>
                </ul>
            </nav>
            <?php endif; ?>

        <?php else: ?>
            <div class="card card-bg shadow-sm p-4 mb-4">
                <p class="mb-0">No certificates found. Try the
                    <a href="<?= $b ?>/pages/calculator/green_calculator.php">Green Calculator</a>
                    to get started.
                </p>
            </div>
        <?php endif; ?>

        <div class="text-center mt-3">
            <a href="<?= $b ?>/pages/user/user_account.php" class="btn btn-outline-light">
                👤 Back to My Profile
            </a>
        </div>
    </div>

    <?php include ROOT_PATH . '/includes/footer.php'; ?>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php
mysqli_stmt_close($data_stmt);
mysqli_close($link);
?>