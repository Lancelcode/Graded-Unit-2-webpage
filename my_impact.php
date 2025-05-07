<?php
require_once 'includes/init.php';
require_once 'includes/connect_db.php';
include 'includes/nav.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Impact Report | GreenScore</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
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
            background: rgba(0, 0, 0, 0.5);
            z-index: 0;
        }
        .content-wrapper {
            flex: 1;
            position: relative;
            z-index: 1;
            padding: 4rem 1rem;
        }
        .card-bg {
            background: rgba(255,255,255,0.95);
            border-radius: 1rem;
            padding: 2rem;
            box-shadow: 0 0 12px rgba(0, 0, 0, 0.2);
            transition: transform 0.2s ease;
        }
        .card-bg:hover {
            transform: translateY(-4px);
        }
        .resource-title {
            color: #2c7a7b;
            font-weight: 600;
            margin-bottom: 1rem;
        }
        .resource-link {
            display: flex;
            align-items: center;
            gap: 0.6rem;
            padding: 0.5rem 0;
            font-weight: 500;
            text-decoration: none;
            color: #155724;
        }
        .resource-link i {
            width: 20px;
        }
        .resource-link:hover {
            color: #0f5132;
            text-decoration: underline;
        }
        .badge-box {
            font-size: 1.2rem;
            font-weight: bold;
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
    <h1 class="text-white text-center mb-5">📊 My Sustainability Impact</h1>

    <?php if (!isset($_SESSION['user_id'])): ?>
        <div class="alert alert-warning text-center">
            Please <a href='login.php' class="alert-link">log in</a> to view your impact report.
        </div>
    <?php else:
        $user_id = $_SESSION['user_id'];
        $total     = mysqli_fetch_assoc(mysqli_query($link, "SELECT COUNT(*) AS total FROM green_calculator_results WHERE user_id = $user_id"))['total'] ?? 0;
        $green     = mysqli_fetch_assoc(mysqli_query($link, "SELECT SUM(green_count) AS green FROM green_calculator_results WHERE user_id = $user_id"))['green'] ?? 0;
        $donation  = mysqli_fetch_assoc(mysqli_query($link, "SELECT SUM(donation_cost) AS donation FROM green_calculator_results WHERE user_id = $user_id"))['donation'] ?? 0;

        $levels = [
            2  => ['green_starter', '🌱 Green Starter'],
            5  => ['eco_explorer', '🌿 Eco Explorer'],
            10 => ['climate_cadet', '🎖 Climate Cadet'],
            15 => ['forest_friend', '🌳 Forest Friend'],
            20 => ['carbon_cutter', '✂️ Carbon Cutter'],
            25 => ['renewable_rookie', '⚡ Renewable Rookie'],
            30 => ['sustainability_scout', '🧭 Sustainability Scout'],
            40 => ['leaf_leader', '🍃 Leaf Leader'],
            50 => ['green_visionary', '👁 Green Visionary'],
            60 => ['eco_hero', '🦸 Eco Hero'],
            70 => ['planet_paladin', '🪐 Planet Paladin'],
            80 => ['guardian_of_earth', '🛡 Guardian of Earth'],
            90 => ['green_warrior', '🌟 Green Warrior'],
            100 => ['champion_of_sustainability', '🏆 Champion of Sustainability']
        ];

        ksort($levels);
        $badgeLevel = 1;
        foreach ($levels as $threshold => [$slug, $label]) {
            if ($green >= $threshold) {
                $badgeSlug = $slug;
                $badge = $label;
            } else {
                break;
            }
            $badgeLevel++;
        }

        $greenPercent = min(100, round(($green / 100) * 100));
        ?>

        <div class="card card-bg shadow mb-5">
            <h3 class="mb-3 text-success">🧾 Report Summary</h3>
            <p><strong>Total Submissions:</strong> <?= $total ?></p>
            <p><strong>Green Answers Earned:</strong> <?= $green ?> / 100</p>
            <p><strong>Total Donations:</strong> £<?= number_format($donation, 2) ?></p>
            <div class="mb-3">
                <label class="form-label">Your Green Journey Progress</label>
                <div class="progress">
                    <div class="progress-bar bg-success" style="width: <?= $greenPercent ?>%;" role="progressbar">
                        <?= $greenPercent ?>%
                    </div>
                </div>
            </div>
            <p class="badge-box">🏅 Current Badge: <span class="text-success">Level <?= $badgeLevel ?> - <?= $badge ?></span></p>
        </div>

        <div class="text-center">
            <a href="certificate_history.php" class="btn btn-outline-light me-2">📄 View Certificates</a>
            <a href="green_calculator.php" class="btn btn-outline-success">🧮 Take the Calculator Again</a>
            <a href="user_account.php" class="btn btn-outline-light">👤 Back to My Profile</a>
        </div>

        <div class="card card-bg shadow mb-5 mt-4">
            <div class="card-body text-center px-4">
                <h3 class="text-success mb-3">🏆 Your Current Title</h3>
                <h5 class="text-muted mb-0">Level <?= $badgeLevel ?></h5>
                <h1 class="display-5 fw-bold mb-3"><?= $badge ?></h1>
                <?php
                $badgeImage = "assets/images/illustrations/" . $badgeSlug . ".jpg";
                $badgeText = match ($badgeSlug) {
                    'champion_of_sustainability' => "You’ve reached the highest honor in sustainability! 🌍👑",
                    'green_warrior' => "You’re a fierce champion of the environment! 🌿⚔️",
                    'guardian_of_earth' => "Defending the Earth one choice at a time. 🛡️",
                    'planet_paladin' => "You’ve pledged loyalty to the planet! 🌎",
                    'eco_hero' => "Heroic actions, greener future! 🦸‍♂️",
                    'green_visionary' => "You envision a cleaner world and act on it! 👁️🌱",
                    'leaf_leader' => "A natural-born leader in the green movement. 🍃",
                    'sustainability_scout' => "You're navigating the path to sustainability. 🧭",
                    'renewable_rookie' => "Just getting started with renewables. ⚡",
                    'carbon_cutter' => "You’re cutting down emissions daily. ✂️",
                    'forest_friend' => "Nature thanks you for your dedication! 🌳",
                    'climate_cadet' => "In training to save the planet! 🎖️",
                    'eco_explorer' => "Exploring the world of sustainability. 🌍",
                    'green_starter' => "Great start — keep growing green habits! 🌱",
                    default => "Welcome to your green journey! Let’s grow together. 🌱✨"
                };
                ?>
                <div class="d-flex justify-content-center">
                    <img src="<?= $badgeImage ?>" alt="<?= $badge ?> image" class="img-fluid my-4" style="max-width: 600px; border-radius: 1rem; box-shadow: 0 0 16px rgba(0,0,0,0.3);">
                </div>
                <p class="lead"><em><?= $badgeText ?></em></p>
            </div>
        </div>
    <?php endif; ?>
</div>

<?php include 'includes/footer.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php mysqli_close($link); ?>
