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
    <title>My Certificate History | GreenScore</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap & FontAwesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1 class="mb-4 text-success text-center">🏅 Sustainability Certificate History</h1>

    <?php
    $query = "SELECT * FROM green_calculator_results WHERE user_id = $user_id ORDER BY submitted_at DESC";
    $result = mysqli_query($link, $query);

    if (mysqli_num_rows($result) > 0): ?>
        <div class="table-responsive">
            <table class="table table-bordered table-striped shadow-sm">
                <thead class="table-success">
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
                        <td><span class="badge bg-success"><?= htmlspecialchars($row['award_level']) ?></span></td>
                        <td><?= $row['green_count'] ?></td>
                        <td><?= $row['amber_count'] ?></td>
                        <td><?= $row['red_count'] ?></td>
                        <td>
                            <a href="certificate_preview.php?level=<?= urlencode($row['award_level']) ?>" class="btn btn-outline-success btn-sm">
                                <i class="fa fa-download"></i> View
                            </a>
                        </td>
                    </tr>
                <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div class="alert alert-info">
            You haven't earned any certificates yet. Try the <a href="green_calculator.php" class="alert-link">Green Calculator</a> to get started!
        </div>
    <?php endif;

    mysqli_close($link);
    ?>
</div>

<?php include 'includes/footer.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
