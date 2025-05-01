<?php
session_start();
if (
    !isset($_SESSION['username']) ||
    !isset($_SESSION['user_id']) ||
    !isset($_GET['shortfall']) ||
    !isset($_GET['cost'])
) {
    header('Location: green_calculator.php');
    exit();
}

$shortfall = (int) $_GET['shortfall'];
$cost = number_format((float) $_GET['cost'], 2);
$username = $_SESSION['username'];
$user_id = $_SESSION['user_id'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Buy Sustainability Points | GreenScore</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS & Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="style.css" rel="stylesheet">
    <style>
        body {
            background: url('assets/images/forest-hero.jpg') center/cover no-repeat fixed;
            position: relative;
            color: #333;
        }
        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            height: 100%;
            width: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 0;
        }
        .content-wrapper {
            position: relative;
            z-index: 1;
            padding: 5rem 1rem;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }
        .card-bg {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 12px;
            padding: 3rem;
            max-width: 600px;
            width: 100%;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.25);
        }
    </style>
</head>
<body>

<?php include 'includes/nav.php'; ?>

<div class="container content-wrapper">
    <div class="card card-bg text-center">
        <h1 class="text-success mb-3">💸 Support Your Score</h1>
        <p class="lead">Hello <strong><?= htmlspecialchars($username) ?></strong>,</p>
        <p>You're currently <strong><?= $shortfall ?> points</strong> short of a perfect sustainability score.</p>
        <p>Contributing <strong>£<?= $cost ?></strong> will boost your score and update your certificate.</p>

        <form method="POST" class="mt-4">
            <button type="submit" name="donate" class="btn btn-warning btn-lg">✅ Confirm Contribution</button>
            <a href="green_calculator.php" class="btn btn-outline-secondary btn-lg ms-3">⬅ Cancel</a>
        </form>

        <?php
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['donate'])) {
            require('includes/connect_db.php');

            // Define the new award details
            $award   = "Certificate of Gold 🥇";
            $emoji   = "🥇";
            $message = "Thank you for your contribution! You've unlocked full recognition!";
            $donation_cost = $cost;
            $new_shortfall = 0; // now fully offset

            // Fetch the most recent green_calculator_results row for this user
            $select = "SELECT id FROM green_calculator_results 
                       WHERE user_id = ? 
                       ORDER BY submitted_at DESC 
                       LIMIT 1";
            $stmt = mysqli_prepare($link, $select);
            mysqli_stmt_bind_param($stmt, 'i', $user_id);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            if ($row = mysqli_fetch_assoc($result)) {
                $last_id = (int) $row['id'];

                // Update only award, emoji, feedback_message, shortfall, donation_cost, submitted_at
                $update = "UPDATE green_calculator_results SET 
                              award_level = ?,
                              emoji       = ?,
                              feedback_message = ?,
                              shortfall   = ?,
                              donation_cost = ?,
                              submitted_at = NOW()
                           WHERE id = ?";
                $stmt = mysqli_prepare($link, $update);
                mysqli_stmt_bind_param(
                    $stmt,
                    'sssdii',
                    $award,
                    $emoji,
                    $message,
                    $new_shortfall,
                    $donation_cost,
                    $last_id
                );
                mysqli_stmt_execute($stmt);
                mysqli_stmt_close($stmt);

                echo "<div class='alert alert-success mt-4'>";
                echo "🎉 Thank you! Your certificate has been updated to <strong>$award</strong>.";
                echo "</div>";
                echo "<a href='certificate_preview.php?level=" . urlencode($award) . "' class='btn btn-success mt-3'>📄 View Your Certificate</a>";
            } else {
                echo "<div class='alert alert-danger mt-4'>⚠️ No previous certificate found to update.</div>";
            }

            mysqli_close($link);
        }
        ?>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
