<?php require_once 'includes/init.php';
require('includes/connect_db.php');

if (!isset($_SESSION['username']) || !isset($_SESSION['id'])) {
    header('Location: login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Green Calculator | GreenScore</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap & Custom Styles -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    <style>
        body { background-color: #f4f8f5; }
        .card-custom {
            border-radius: 15px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            padding: 30px;
        }
        .award {
            font-size: 1.5rem;
            margin: 15px 0;
        }
        .btn-group { margin-top: 20px; }
        .award-icon {
            font-size: 2rem;
        }
    </style>
</head>
<body>
<?php include 'includes/nav.php'; ?>
<div class="container mt-5">
    <div class="card card-custom">
        <h1 class="text-success mb-4">🌿 I-Cinema Green Calculator</h1>
        <p class="lead">Evaluate your cinema visit's environmental impact by selecting your sustainability practices below.</p>

        <form method="POST">
            <?php
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

            foreach ($measures as $index => $measure) {
                echo "<div class='form-group'>";
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

        <?php
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
            $total = 0;
            $green = $amber = $red = 0;

            foreach ($measures as $index => $m) {
                $score = intval($_POST["measure_$index"]);
                $total += $score;
                if ($score === 10) $green++;
                elseif ($score === 5) $amber++;
                else $red++;
            }

            $shortfall = 100 - $total;
            $cost = $shortfall * 10;

            if ($total >= 80) $award = "Gold 🏅";
            elseif ($total >= 60) $award = "Silver 🥈";
            elseif ($total >= 40) $award = "Bronze 🥉";
            else $award = "Certificate of Encouragement 👏";

            // Save to DB
            $user_id = $_SESSION['id'];
            $stmt = mysqli_prepare($link, "INSERT INTO green_calculator_results (user_id, total_score, green_count, amber_count, red_count, award_level, shortfall, donation_cost) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            mysqli_stmt_bind_param($stmt, 'iiiissid', $user_id, $total, $green, $amber, $red, $award, $shortfall, $cost);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);

            echo "<div class='mt-4 p-4 bg-white rounded shadow-sm'>";
            echo "<h3 class='text-primary'>Your Sustainability Score</h3>";
            echo "<p><strong>Total Points:</strong> $total / 100</p>";
            echo "<p>🟢 Green: $green | 🟠 Amber: $amber | 🔴 Red: $red</p>";
            echo "<div class='award'><strong>🎖 Award:</strong> $award</div>";

            if ($shortfall > 0) {
                echo "<p class='text-danger'>You’re <strong>$shortfall points</strong> short of a perfect score. To go Gold, consider a donation of <strong>£$cost</strong>.</p>";
            } else {
                echo "<p class='text-success'>✅ You’ve achieved a perfect 100! You're a green superstar!</p>";
            }

            echo "<div class='d-flex flex-wrap gap-3 mt-4'>";
            echo "<a href='certificate_preview.php?level=" . urlencode($award) . "' class='btn btn-outline-success'>📄 Download Certificate</a>";
            if ($total < 80) {
                echo "<a href='buy_points.php?shortfall=$shortfall&cost=$cost' class='btn btn-outline-warning'>💸 Buy Points</a>";
            }
            echo "<a href='community.php' class='btn btn-outline-info'>🌱 Visit Community</a>";
            echo "<a href='green_resources.php' class='btn btn-outline-dark'>📚 Tips & Guides</a>";
            echo "</div></div>";

        }

        mysqli_close($link);
        ?>
    </div>
</div>
<?php include 'includes/footer.php'; ?>
<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
