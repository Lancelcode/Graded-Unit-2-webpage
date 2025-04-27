<?php
require_once 'includes/init.php';
require('includes/connect_db.php');

if (!isset($_SESSION['username']) || !isset($_SESSION['id'])) {
    header('Location: login.php');
    exit();
}

$show_modal = false;
$award = $emoji = $message = '';
$total = $shortfall = $cost = 0;
$green = $amber = $red = 0;

$measures = [
    "Waste Reduction",
    "Renewable Energy Usage",
    "Water Conservation",
    "Sustainable Supply Chain",
    "Eco-friendly Products/Services",
    "Energy-Efficient Infrastructure",
    "Transportation Sustainability",
    "Community Engagement",
    "Carbon Offsetting",
    "Transparency and Reporting"
];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    foreach ($measures as $index => $m) {
        $score = intval($_POST["measure_$index"]);
        $total += $score;
        if ($score === 10) $green++;
        elseif ($score === 5) $amber++;
        else $red++;
    }

    $shortfall = 100 - $total;
    $cost = $shortfall * 10;

    if ($total >= 80) {
        $award = "Certificate of Gold 🥇";
        $emoji = "🥇";
        $message = "Outstanding! You're leading the way in sustainability.";
    } elseif ($total >= 65) {
        $award = "Certificate of Silver 🥈";
        $emoji = "🥈";
        $message = "Great job! You're making a positive environmental impact.";
    } elseif ($total > 50) {
        $award = "Certificate of Bronze 🥉";
        $emoji = "🥉";
        $message = "Nice effort! Keep building sustainable habits.";
    } else {
        $award = "Certificate of participation 👏";
        if ($total >= 41) {
            $emoji = "🌟";
            $message = "You're almost there! Just a few more changes will go a long way.";
        } elseif ($total >= 26) {
            $emoji = "💪";
            $message = "You're making progress. Small steps matter — keep going!";
        } else {
            $emoji = "🌱";
            $message = "Every journey starts somewhere — you've taken that first step!";
        }
    }

    $user_id = $_SESSION['id'];
    $stmt = mysqli_prepare($link, "INSERT INTO green_calculator_results (user_id, total_score, green_count, amber_count, red_count, award_level, emoji, feedback_message, shortfall, donation_cost, submitted_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())");
    mysqli_stmt_bind_param($stmt, 'iiiissssis', $user_id, $total, $green, $amber, $red, $award, $emoji, $message, $shortfall, $cost);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    $show_modal = true;
}
?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Green Calculator | GreenScore</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
        <link href="style.css" rel="stylesheet">
        <style>
            .modal-header {
                background-color: #198754;
                color: white;
                box-shadow: 0 0 20px rgba(40,167,69,0.6);
                text-shadow: 1px 1px 4px rgba(0,0,0,0.5);
            }
        </style>
    </head>
    <body>
    <?php include 'includes/nav.php'; ?>

    <div class="container mt-5">
        <div class="card p-4 shadow-sm">
            <div class="row">
                <div class="col-md-8">
                    <h1 class="text-success mb-4">🌿 Green Calculator</h1>
                    <p class="lead">Evaluate your sustainability impact by selecting your practices below.</p>
                    <form method="POST">
                        <?php
                        foreach ($measures as $index => $measure) {
                            echo "<div class='form-group mb-3'>";
                            echo "<label><strong>$measure</strong></label>";
                            echo "<select class='form-control' name='measure_$index' required>
                                <option value=''>-- Select Level --</option>
                                <option value='10'>🟢 Green (Excellent)</option>
                                <option value='5'>🟠 Amber (Moderate)</option>
                                <option value='0'>🔴 Red (Not Implemented)</option>
                              </select>";
                            echo "</div>";
                        }
                        ?>
                        <button class="btn btn-success btn-block mt-3" name="submit">Calculate My Score 🌍</button>
                    </form>
                </div>
                <div class="col-md-4">
                    <div class="card shadow-sm p-3">
                        <h5 class="mb-3 text-center">Legend</h5>
                        <ul class="list-unstyled mb-3">
                            <li>🟢 <strong>Green</strong> = 10 points</li>
                            <li>🟠 <strong>Amber</strong> = 5 points</li>
                            <li>🔴 <strong>Red</strong> = 0 points</li>
                        </ul>
                        <hr>
                        <h6 class="text-center mb-2">Awards:</h6>
                        <ul class="list-unstyled text-center mb-0">
                            <li>🥇 Gold: 80–100 pts</li>
                            <li>🥈 Silver: 65–79 pts</li>
                            <li>🥉 Bronze: 51–64 pts</li>
                            <li>👏 Certificate: 0–50 pts</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php if ($show_modal): ?>
        <div class="modal fade show" id="resultModal" tabindex="-1" style="display: block;" aria-modal="true" role="dialog">
            <div class="modal-dialog modal-dialog-centered animate__animated animate__zoomIn">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title animate__animated animate__rubberBand"><?= $emoji ?> <?= $award ?></h5>
                    </div>
                    <div class="modal-body">
                        <p><strong>Your Score:</strong> <?= $total ?> / 100</p>
                        <p><?= $message ?></p>
                        <div class="mb-3">
                            <label>🟢 Green</label>
                            <div class="progress">
                                <div class="progress-bar bg-success" role="progressbar" style="width: <?= $green * 10 ?>%;" aria-valuenow="<?= $green ?>" aria-valuemin="0" aria-valuemax="10"><?= $green ?></div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label>🟠 Amber</label>
                            <div class="progress">
                                <div class="progress-bar bg-warning text-dark" role="progressbar" style="width: <?= $amber * 10 ?>%;" aria-valuenow="<?= $amber ?>" aria-valuemin="0" aria-valuemax="10"><?= $amber ?></div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label>🔴 Red</label>
                            <div class="progress">
                                <div class="progress-bar bg-danger" role="progressbar" style="width: <?= $red * 10 ?>%;" aria-valuenow="<?= $red ?>" aria-valuemin="0" aria-valuemax="10"><?= $red ?></div>
                            </div>
                        </div>
                        <?php if ($shortfall > 0): ?>
                            <p class="text-danger">You're <strong><?= $shortfall ?> points</strong> short of 100. Consider donating <strong>£<?= $cost ?></strong> to offset.</p>
                        <?php else: ?>
                            <p class="text-success">✅ Perfect score! You're a green superstar!</p>
                        <?php endif; ?>
                    </div>
                    <div class="modal-footer d-flex flex-wrap justify-content-between gap-2">
                        <a href="certificate_preview.php?level=<?= urlencode($award) ?>" class="btn btn-outline-success">📄 Download Certificate</a>
                        <?php if ($shortfall > 0): ?>
                            <a href="buy_points.php?shortfall=<?= $shortfall ?>&cost=<?= $cost ?>" class="btn btn-outline-warning">💸 Buy Points</a>
                        <?php endif; ?>
                        <a href="community.php" class="btn btn-outline-info">🌱 Visit Community</a>
                        <a href="green_resources.php" class="btn btn-outline-dark">📚 Tips & Guides</a>
                        <button class="btn btn-secondary" onclick="window.location='green_calculator.php';">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-backdrop fade show"></div>
    <?php endif; ?>

    <?php include 'includes/footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    </body>
    </html>

<?php mysqli_close($link); ?>