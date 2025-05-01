<?php
require_once 'includes/init.php';
require_once 'includes/connect_db.php';
include 'includes/nav.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

// Pagination setup
$entries_per_page = 8;
$page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$offset = ($page - 1) * $entries_per_page;

// Get unique award levels
$levels_query = "SELECT DISTINCT award_level FROM green_calculator_results WHERE user_id = $user_id";
$levels_result = mysqli_query($link, $levels_query);
$award_levels = [];
while ($lvl = mysqli_fetch_assoc($levels_result)) {
    $award_levels[] = $lvl['award_level'];
}

// Handle sorting/filtering
$order = "DESC";
$filter = "";

if (isset($_GET['sort']) && $_GET['sort'] === 'oldest') {
    $order = "ASC";
}

if (isset($_GET['level']) && in_array($_GET['level'], $award_levels)) {
    $filter = "AND award_level = '" . mysqli_real_escape_string($link, $_GET['level']) . "'";
}

// Count total records
$count_query = "SELECT COUNT(*) as total FROM green_calculator_results WHERE user_id = $user_id $filter";
$count_result = mysqli_query($link, $count_query);
$total_entries = mysqli_fetch_assoc($count_result)['total'];
$total_pages = ceil($total_entries / $entries_per_page);

// Fetch paginated data
$query = "SELECT * FROM green_calculator_results WHERE user_id = $user_id $filter ORDER BY submitted_at $order LIMIT $entries_per_page OFFSET $offset";
$result = mysqli_query($link, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Certificate History | GreenScore</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
    <style>
        html, body {
            height: 100%;
            margin: 0;
        }
        body {
            display: flex;
            flex-direction: column;
            background: url('assets/images/forest-hero.jpg') center/cover no-repeat fixed;
            position: relative;
            color: #333;
        }
        body::before {
            content: '';
            position: absolute;
            inset: 0;
            background: rgba(0,0,0,0.5);
            z-index: 0;
        }
        .content-wrapper {
            flex: 1;
            position: relative;
            z-index: 1;
            padding: 4rem 0;
        }
        .card-bg {
            background: rgba(255,255,255,0.9);
        }
        footer {
            position: relative;
            z-index: 1;
            background-color: #fff;
            padding: 2rem 0;
            width: 100%;
        }
    </style>
</head>
<body>

<div class="container content-wrapper">
    <h1 class="text-white text-center mb-4">📜 Certificate History</h1>

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

    <?php if (mysqli_num_rows($result) > 0): ?>
        <div class="card card-bg shadow-sm p-4 mb-4">
            <div class="table-responsive">
                <table class="table table-striped align-middle mb-0">
                    <thead class="table-success">
                    <tr>
                        <th>#</th>
                        <th>Date</th>
                        <th>Score</th>
                        <th>Award</th>
                        <th>Green</th>
                        <th>Amber</th>
                        <th>Red</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $count = $offset + 1;
                    while ($row = mysqli_fetch_assoc($result)):
                        $award = $row['award_level'];
                        $emoji = match($award) {
                            'Gold' => '🥇',
                            'Silver' => '🥈',
                            'Bronze' => '🥉',
                            'Keep Going' => '💪',
                            'Great Effort' => '🌟',
                            'Starter' => '🌱',
                            default => null
                        };
                        ?>
                        <tr>
                            <td><?= $count++ ?></td>
                            <td><?= date('d/m/Y', strtotime($row['submitted_at'])) ?></td>
                            <td><?= $row['total_score'] ?>/100</td>
                            <td><?= ($emoji ? $emoji . ' ' : '') . htmlspecialchars($award) ?></td>
                            <td><?= $row['green_count'] ?></td>
                            <td><?= $row['amber_count'] ?></td>
                            <td><?= $row['red_count'] ?></td>
                            <td>
                                <a href="certificate_preview.php?level=<?= urlencode($row['award_level']) ?>" class="btn btn-outline-success btn-sm">📄 View</a>
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

    <?php else: ?>
        <div class="card card-bg shadow-sm p-4 mb-4">
            <p class="mb-0">No certificates found. Try the <a href="green_calculator.php">Green Calculator</a> to get started on your journey.</p>
        </div>
    <?php endif;

    mysqli_close($link);
    ?>
</div>

<?php include 'includes/footer.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
