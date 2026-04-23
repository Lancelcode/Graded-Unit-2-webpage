<?php
require_once __DIR__ . '/../../includes/init.php';
require_once ROOT_PATH . '/includes/connect_db.php';
include ROOT_PATH . '/includes/nav.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: /pages/auth/login.php');
    exit();
}

$user_id = (int) $_SESSION['user_id'];

$stmt = mysqli_prepare($link, "SELECT COUNT(*) AS total FROM green_calculator_results WHERE user_id = ?");
mysqli_stmt_bind_param($stmt, 'i', $user_id);
mysqli_stmt_execute($stmt);
$total = (int) mysqli_fetch_assoc(mysqli_stmt_get_result($stmt))['total'];
mysqli_stmt_close($stmt);

$stmt = mysqli_prepare($link, "SELECT SUM(green_count) AS green FROM green_calculator_results WHERE user_id = ?");
mysqli_stmt_bind_param($stmt, 'i', $user_id);
mysqli_stmt_execute($stmt);
$green = (int) (mysqli_fetch_assoc(mysqli_stmt_get_result($stmt))['green'] ?? 0);
mysqli_stmt_close($stmt);

$stmt = mysqli_prepare($link, "SELECT SUM(donation_cost) AS donation FROM green_calculator_results WHERE user_id = ?");
mysqli_stmt_bind_param($stmt, 'i', $user_id);
mysqli_stmt_execute($stmt);
$donation = (float) (mysqli_fetch_assoc(mysqli_stmt_get_result($stmt))['donation'] ?? 0);
mysqli_stmt_close($stmt);

$levels = [
    2   => ['green_starter',             '🌱 Green Starter'],
    5   => ['eco_explorer',              '🌿 Eco Explorer'],
    10  => ['climate_cadet',             '🎖 Climate Cadet'],
    15  => ['forest_friend',             '🌳 Forest Friend'],
    20  => ['carbon_cutter',             '✂️ Carbon Cutter'],
    25  => ['renewable_rookie',          '⚡ Renewable Rookie'],
    30  => ['sustainability_scout',      '🧭 Sustainability Scout'],
    40  => ['leaf_leader',               '🍃 Leaf Leader'],
    50  => ['green_visionary',           '👁 Green Visionary'],
    60  => ['eco_hero',                  '🦸 Eco Hero'],
    70  => ['planet_paladin',            '🪐 Planet Paladin'],
    80  => ['guardian_of_earth',         '🛡 Guardian of Earth'],
    90  => ['green_warrior',             '🌟 Green Warrior'],
    100 => ['champion_of_sustainability','🏆 Champion of Sustainability'],
];

$badgeSlug  = 'green_starter';
$badge      = '🌱 Green Starter';
$badgeLevel = 1;

ksort($levels);
foreach ($levels as $threshold => [$slug, $label]) {
    if ($green >= $threshold) {
        $badgeSlug  = $slug;
        $badge      = $label;
        $badgeLevel++;
    } else {
        break;
    }
}

$greenPercent = min(100, (int) round(($green / 100) * 100));

$badgeText = match ($badgeSlug) {
    'champion_of_sustainability' => "You've reached the highest honour in sustainability! 🌍👑",
    'green_warrior'              => "You're a fierce champion of the environment! 🌿⚔️",
    'guardian_of_earth'          => "Defending the Earth one choice at a time. 🛡️",
    'planet_paladin'             => "You've pledged loyalty to the planet! 🌎",
    'eco_hero'                   => "Heroic actions, greener future! 🦸",
    'green_visionary'            => "You envision a cleaner world and act on it! 👁🌱",
    'leaf_leader'                => "A natural-born leader in the green movement. 🍃",
    'sustainability_scout'       => "Navigating the path to sustainability. 🧭",
    'renewable_rookie'           => "Just getting started with renewables. ⚡",
    'carbon_cutter'              => "Cutting down emissions daily. ✂️",
    'forest_friend'              => "Nature thanks you for your dedication! 🌳",
    'climate_cadet'              => "In training to save the planet! 🎖️",
    'eco_explorer'               => "Exploring the world of sustainability. 🌍",
    'green_starter'              => "Great start — keep growing green habits! 🌱",
    default                      => "Welcome to your green journey! Let's grow together. 🌱✨",
};
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include ROOT_PATH . '/includes/head.php'; ?>
    <title>My Impact Report | GreenScore</title>
    <style>
        html, body { height: 100%; margin: 0; }
        body {
            background: url('/assets/images/forest-hero.jpg') center/cover no-repeat fixed;
            position: relative;
            color: #fff;
            display: flex;
            flex-direction: column;
        }
        body::before {
            content: '';
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.6);
            z-index: -1;
        }
        .content-wrapper { flex-grow: 1; padding: 4rem 1rem; }
        .card-bg {
            background: rgba(255, 255, 255, 0.95);
            color: #333;
            padding: 2rem;
            border-radius: 1rem;
            box-shadow: 0 0 12px rgba(0, 0, 0, 0.2);
        }
        .progress { height: 20px; }
        footer { position: relative; z-index: 1; }
    </style>
</head>
<body class="d-flex flex-column min-vh-100">
<div class="container content-wrapper flex-grow-1">
    <h1 class="text-white text-center mb-5">📊 My Sustainability Impact</h1>

    <div class="card card-bg shadow mb-5">
        <h3 class="mb-3 text-success">🧾 Report Summary</h3>
        <p><strong>Total Submissions:</strong> <?= $total ?></p>
        <p><strong>Green Answers Earned:</strong> <?= $green ?> / 100</p>
        <p><strong>Total Contributions:</strong> £<?= number_format($donation, 2) ?></p>
        <div class="mb-3">
            <label class="form-label">Your Green Journey Progress</label>
            <div class="progress">
                <div class="progress-bar bg-success"
                     style="width: <?= $greenPercent ?>%;" role="progressbar">
                    <?= $greenPercent ?>%
                </div>
            </div>
        </div>
        <p class="fs-5 fw-bold">
            🏅 Current Badge:
            <span class="text-success">Level <?= $badgeLevel ?> — <?= $badge ?></span>
        </p>
    </div>

    <div class="text-center mt-4 d-flex flex-wrap justify-content-center gap-3">
        <a href="/pages/calculator/certificate_history.php"
           class="btn btn-lg btn-outline-light fw-bold px-4 py-2 shadow-sm">
            📄 View Certificates
        </a>
        <a href="/pages/calculator/green_calculator.php"
           class="btn btn-lg btn-success fw-bold px-4 py-2 shadow-sm">
            🧮 Take the Calculator Again
        </a>
        <a href="/pages/user/user_account.php"
           class="btn btn-lg btn-outline-light fw-bold px-4 py-2 shadow-sm">
            👤 Back to My Profile
        </a>
    </div>

    <div class="card card-bg shadow mt-5 mb-5">
        <div class="card-body text-center px-4">
            <h3 class="text-success mb-3">🏆 Your Current Title</h3>
            <h5 class="text-muted mb-0">Level <?= $badgeLevel ?></h5>
            <h1 class="display-5 fw-bold mb-3"><?= $badge ?></h1>
            <?php
            $badgeImage = ROOT_PATH . "/assets/images/illustrations/{$badgeSlug}.jpg";
            if (file_exists($badgeImage)) {
                echo "<div class='d-flex justify-content-center'>
                    <img src='/assets/images/illustrations/{$badgeSlug}.jpg'
                         alt='" . htmlspecialchars($badge) . "'
                         class='img-fluid my-4'
                         style='max-width:600px; border-radius:1rem; box-shadow:0 0 16px rgba(0,0,0,0.3);'>
                  </div>";
            }
            ?>
            <p class="lead"><em><?= htmlspecialchars($badgeText) ?></em></p>
        </div>
    </div>
</div>

<?php include ROOT_PATH . '/includes/footer.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php mysqli_close($link); ?>