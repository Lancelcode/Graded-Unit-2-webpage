<?php
require_once __DIR__ . '/../../includes/init.php';

if (
    !isset($_SESSION['username']) ||
    !isset($_SESSION['user_id']) ||
    !isset($_GET['shortfall']) ||
    !isset($_GET['cost'])
) {
    header('Location: /pages/calculator/green_calculator.php');
    exit();
}

$shortfall = (int) $_GET['shortfall'];
$cost      = number_format((float) $_GET['cost'], 2);
$username  = $_SESSION['username'];
$user_id   = $_SESSION['user_id'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include ROOT_PATH . '/includes/head.php'; ?>
    <title>Buy Sustainability Points | GreenScore</title>
    <style>
        html, body { height: 100%; margin: 0; }
        body {
            background: url('/assets/images/forest-hero.jpg') center/cover no-repeat fixed;
            position: relative;
        }
        body::before {
            content: '';
            position: absolute;
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
        }
        .content-wrapper {
            flex: 1;
            padding: 5rem 1rem;
            display: flex;
            justify-content: center;
        }
        .card-bg {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 1rem;
            padding: 3rem;
            max-width: 600px;
            width: 100%;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.25);
        }
    </style>
</head>
<body>
<?php include ROOT_PATH . '/includes/nav.php'; ?>

<div class="page-wrapper">
    <div class="container content-wrapper">
        <div class="card-bg text-center">
            <h1 class="text-success mb-3">💸 Support Your Score</h1>
            <p class="lead">Hello <strong><?= htmlspecialchars($username) ?></strong>,</p>
            <p>You're currently <strong><?= $shortfall ?> points</strong> short of a perfect score.</p>
            <p>Contributing <strong>£<?= $cost ?></strong> will boost your score and update your certificate.</p>

            <form method="POST" class="mt-4">
                <input type="hidden" name="csrf_token"
                       value="<?= htmlspecialchars($_SESSION['csrf_token'] ?? '') ?>">
                <button type="submit" name="donate" class="btn btn-warning btn-lg">
                    ✅ Confirm Contribution
                </button>
                <a href="/pages/calculator/green_calculator.php"
                   class="btn btn-outline-secondary btn-lg ms-3">⬅ Cancel</a>
            </form>

            <?php
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['donate'])) {
                if (!hash_equals($_SESSION['csrf_token'] ?? '', $_POST['csrf_token'] ?? '')) {
                    die('Invalid CSRF token.');
                }

                require ROOT_PATH . '/includes/connect_db.php';

                $award         = 'Certificate of Gold 🥇';
                $emoji         = '🥇';
                $message       = "Thank you for your contribution! You've unlocked full recognition!";
                $new_shortfall = 0;

                $select = "SELECT id FROM green_calculator_results
                           WHERE user_id = ? ORDER BY submitted_at DESC LIMIT 1";
                $stmt = mysqli_prepare($link, $select);
                mysqli_stmt_bind_param($stmt, 'i', $user_id);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
                mysqli_stmt_close($stmt);

                if ($row = mysqli_fetch_assoc($result)) {
                    $last_id = (int) $row['id'];

                    $update = "UPDATE green_calculator_results
                               SET award_level = ?, emoji = ?, feedback_message = ?,
                                   shortfall = ?, donation_cost = ?, submitted_at = NOW()
                               WHERE id = ?";
                    $stmt = mysqli_prepare($link, $update);
                    mysqli_stmt_bind_param($stmt, 'sssidi',
                        $award, $emoji, $message, $new_shortfall, $cost, $last_id
                    );
                    mysqli_stmt_execute($stmt);
                    mysqli_stmt_close($stmt);

                    echo "<div class='alert alert-success mt-4'>
                            🎉 Thank you! Your certificate has been updated to
                            <strong>" . htmlspecialchars($award) . "</strong>.
                          </div>";
                    echo "<a href='/pages/calculator/certificate_preview.php?level="
                        . urlencode($award) . "' class='btn btn-success mt-3'>
                            📄 View Your Certificate
                          </a>";
                } else {
                    echo "<div class='alert alert-danger mt-4'>
                            ⚠️ No previous certificate found to update.
                          </div>";
                }

                mysqli_close($link);
            }
            ?>
        </div>
    </div>

    <?php include ROOT_PATH . '/includes/footer.php'; ?>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>