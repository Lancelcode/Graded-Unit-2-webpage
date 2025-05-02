<?php
require_once 'includes/init.php';
require_once 'includes/connect_db.php';
include 'includes/nav.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];
$action_message = '';

$entries_per_page = 8;
$page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$offset = ($page - 1) * $entries_per_page;

// Handle DELETE
if (isset($_POST['delete_id'])) {
    $delete_id = intval($_POST['delete_id']);
    mysqli_query($link, "DELETE FROM green_calculator_results WHERE id = $delete_id AND user_id = $user_id");
    $action_message = '❌ Entry deleted successfully.';
}

// Handle RESET (redirect to calculator)
if (isset($_POST['reset_id'])) {
    $reset_id = intval($_POST['reset_id']);
    $_SESSION['reset_entry_id'] = $reset_id;
    header("Location: green_calculator.php?reset=1");
    exit();
}

// Handle CLEAR (wipe all)
if (isset($_POST['clear_all'])) {
    mysqli_query($link, "DELETE FROM green_calculator_results WHERE user_id = $user_id");
    $action_message = '🧹 All entries cleared.';
}

// Handle UPDATE
if (isset($_POST['update_id'])) {
    $update_id = intval($_POST['update_id']);
    $new_award = mysqli_real_escape_string($link, $_POST['award_level']);
    $new_feedback = mysqli_real_escape_string($link, $_POST['feedback_message']);
    mysqli_query($link, "UPDATE green_calculator_results SET award_level = '$new_award', feedback_message = '$new_feedback' WHERE id = $update_id AND user_id = $user_id");
    $action_message = '✏️ Entry updated.';
}

$levels_query = "SELECT DISTINCT award_level FROM green_calculator_results WHERE user_id = $user_id";
$levels_result = mysqli_query($link, $levels_query);
$award_levels = [];
while ($lvl = mysqli_fetch_assoc($levels_result)) {
    $award_levels[] = $lvl['award_level'];
}

$order = "DESC";
$filter = "";

if (isset($_GET['sort']) && $_GET['sort'] === 'oldest') {
    $order = "ASC";
}

if (isset($_GET['level']) && in_array($_GET['level'], $award_levels)) {
    $filter = "AND award_level = '" . mysqli_real_escape_string($link, $_GET['level']) . "'";
}

$count_query = "SELECT COUNT(*) as total FROM green_calculator_results WHERE user_id = $user_id $filter";
$count_result = mysqli_query($link, $count_query);
$total_entries = mysqli_fetch_assoc($count_result)['total'];
$total_pages = ceil($total_entries / $entries_per_page);

$query = "SELECT * FROM green_calculator_results WHERE user_id = $user_id $filter ORDER BY submitted_at $order LIMIT $entries_per_page OFFSET $offset";
$results = mysqli_query($link, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Certificate History | GreenScore</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        html, body {
            height: 100%;
            margin: 0;
        }
        body {
            background: url('assets/images/forest-hero.jpg') center/cover no-repeat fixed;
            position: relative;
        }
        body::before {
            content: '';
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 0;
        }
        .page-wrapper {
            position: relative;
            z-index: 1;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            margin-top: 10rem;

        }


        .card-bg {
            background: rgba(255,255,255,0.95);
            border-radius: 1rem;
        }
        footer {
            background-color: #fff;
            color: #444;
            padding: 2rem 0;
            width: 100%;
        }
    </style>
</head>
<body>
<div class="page-wrapper d-flex flex-column min-vh-100">
    <div class="container">
    <h1 class="text-white text-center mb-4">📜 Certificate History</h1>

    <?php if ($action_message): ?>
        <div class="alert alert-success text-center"><?= $action_message ?></div>
    <?php endif; ?>

    <form class="row justify-content-center mb-4">
        <div class="col-md-3">
            <select name="sort" class="form-select" onchange="this.form.submit()">
                <option value="">Sort by Date</option>
                <option value="newest" <?= (!isset($_GET['sort']) || $_GET['sort'] === 'newest') ? 'selected' : '' ?>>Newest First</option>
                <option value="oldest" <?= ($_GET['sort'] ?? '') === 'oldest' ? 'selected' : '' ?>>Oldest First</option>
            </select>
        </div>
        <div class="col-md-3">
            <select name="level" class="form-select" onchange="this.form.submit()">
                <option value="">Filter by Award</option>
                <?php foreach ($award_levels as $level): ?>
                    <option value="<?= htmlspecialchars($level) ?>" <?= ($_GET['level'] ?? '') === $level ? 'selected' : '' ?>>
                        <?= htmlspecialchars($level) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
    </form>

    <?php if (mysqli_num_rows($results) > 0): ?>

        <div class="card card-bg shadow-sm p-4 mb-4">
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Date</th>
                        <th>Award</th>
                        <th>Score</th>
                        <th>Green</th>
                        <th>Amber</th>
                        <th>Red</th>
                        <th>Feedback</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <form method="post" onsubmit="return confirm('Are you sure you want to clear all certificates?');">
                        <button type="submit" name="clear_all" class="btn btn-outline-danger mb-3 float-end">
                            🧹 Clear All
                        </button>
                    </form>
                    <tbody>
                    <?php $count = $offset + 1; while ($row = mysqli_fetch_assoc($results)): ?>
                        <tr>
                            <form method="POST">
                                <input type="hidden" name="update_id" value="<?= $row['id'] ?>">
                                <td><?= $count++ ?></td>
                                <td><?= date('d/m/Y', strtotime($row['submitted_at'])) ?></td>
                                <td><input type="text" name="award_level" value="<?= htmlspecialchars($row['award_level']) ?>" class="form-control form-control-sm" required></td>
                                <td><?= $row['total_score'] ?></td>
                                <td><?= $row['green_count'] ?></td>
                                <td><?= $row['amber_count'] ?></td>
                                <td><?= $row['red_count'] ?></td>
                                <td><input type="text" name="feedback_message" value="<?= htmlspecialchars($row['feedback_message']) ?>" class="form-control form-control-sm" required></td>
                                <td class="text-nowrap">
                                    <button type="submit" class="btn btn-sm btn-primary">💾</button>
                            </form>
                            <form method="POST" style="display:inline;" onsubmit="return confirm('Reset this entry and redirect to calculator?');">
                                <input type="hidden" name="reset_id" value="<?= $row['id'] ?>">
                                <button type="submit" class="btn btn-sm btn-warning">🔁</button>
                            </form>
                            <form method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this entry?');">
                                <input type="hidden" name="delete_id" value="<?= $row['id'] ?>">
                                <button type="submit" class="btn btn-sm btn-danger">🗑️</button>
                            </form>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <nav class="text-center">
            <ul class="pagination justify-content-center">
                <?php
                $base_url = 'certificate_history.php?';
                $query_params = $_GET;
                for ($i = 1; $i <= $total_pages; $i++) {
                    $query_params['page'] = $i;
                    $url = $base_url . http_build_query($query_params);
                    $active = $i == $page ? 'active' : '';
                    echo "<li class='page-item $active'><a class='page-link' href='$url'>$i</a></li>";
                }
                ?>
            </ul>
        </nav>

        <div class="text-center mt-3">
            <a href="user_account.php" class="btn btn-outline-light">
                👤 Back to My Profile
            </a>
        </div>

    <?php else: ?>
        <div class="card card-bg shadow-sm p-4 mb-4">
            <p class="mb-0">No certificates found. Try the <a href="green_calculator.php">Green Calculator</a> to get started on your journey.</p>
        </div>
    <?php endif; ?>
</div>

<?php include 'includes/footer.php'; ?>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php mysqli_close($link); ?>
