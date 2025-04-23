<?php
require_once 'includes/init.php';
require_once 'includes/connect_db.php';
include 'includes/nav.php';

if (!isset($_SESSION['id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['id'];
$username = $_SESSION['username'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Certificate History | GreenScore</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap & Custom Styles -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container mt-5">
    <h1 class="text-success mb-4">📜 Your Certificate History</h1>

    <?php
    $query = "SELECT * FROM green_calculator_results WHERE user_id = $user_id ORDER BY submitted_at DESC";
    $result = mysqli_query($link, $query);

    if (mysqli_num_rows($result) > 0): ?>
        <div class="table-responsive">
            <table class="table table-bordered table-hover bg-white">
                <thead class="thead-light">
                <tr>
                    <th>#</th>
                    <th>Date</th>
                    <th>Score</th>
                    <th>Award</th>
                    <th>Green</th>
                    <th>Amber</th>
                    <th>Red</th>
                    <th>Download</th>
                </tr>
                </thead>
                <tbody>
                <?php $count = 1; while ($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?= $count++ ?></td>
                        <td><?= date('F j, Y', strtotime($row['submitted_at'])) ?></td>
                        <td><?= $row['total_score'] ?>/100</td>
                        <td><span class="badge badge-success"><?= $row['award_level'] ?></span></td>
                        <td><?= $row['green_count'] ?></td>
                        <td><?= $row['amber_count'] ?></td>
                        <td><?= $row['red_count'] ?></td>
                        <td>
                            <a href="certificate_preview.php?level=<?= urlencode($row['award_level']) ?>" class="btn btn-outline-success btn-sm">
                                📄 View
                            </a>
                        </td>
                    </tr>
                <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <p class="text-muted">You haven't earned any certificates yet. Try the <a href="green_calculator.php">Green Calculator</a>!</p>
    <?php endif;

    mysqli_close($link);
    ?>
</div>

<?php include 'includes/footer.php'; ?>
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
