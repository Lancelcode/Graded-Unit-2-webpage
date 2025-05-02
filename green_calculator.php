<?php
require_once 'includes/init.php';
require('includes/connect_db.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
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

    $user_id = $_SESSION['user_id']; // ✅ Fixed key here
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
        html {
            overflow-y: scroll;
        }
        body {
            background: url('assets/images/forest-hero.jpg') center/cover no-repeat fixed;
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .container {
            margin-top: 3rem;
            margin-bottom: 3rem;
        }

        .card {
            background-color: rgba(255, 255, 255, 0.95);
            border-radius: 1rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .modal-content {
            background-color: rgba(255, 255, 255, 0.97);
            border-radius: 0.75rem;
        }

        .modal-header {
            background-color: #198754;
            color: white;
            box-shadow: 0 0 15px rgba(40, 167, 69, 0.6);
            text-shadow: 1px 1px 4px rgba(0, 0, 0, 0.5);
        }

        label {
            font-weight: 500;
        }

        .btn-link i {
            color: #198754;
        }

        .progress {
            height: 20px;
            border-radius: 10px;
            overflow: hidden;
        }

        .progress-bar {
            font-size: 14px;
            font-weight: bold;
        }

        body.modal-open {
            padding-right: 0 !important;
        }

        .modal-title {
            color: #00ff66 !important; /* Bright green */
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
                    $explanations = [

                        "Waste Reduction" => "Waste reduction assesses how actively a company minimizes its total waste output through operational improvements, material efficiency, recycling programs, and waste prevention strategies. 
Examples: Conducting annual waste audits, setting formal waste reduction targets (e.g., 5%-10% per year), composting organic waste, eliminating single-use plastics, transitioning to digital documentation. 
Impact: Reduces landfill methane emissions, decreases environmental contamination, and lowers the demand for raw material extraction and manufacturing energy.",

                        "Renewable Energy Usage" => "Renewable energy usage evaluates the proportion of a company’s energy supply that comes from sustainable sources such as solar, wind, hydro, or biomass. 
Examples: Installing solar panels on company buildings, purchasing certified green electricity from suppliers, entering renewable energy power purchase agreements (PPAs). 
Impact: Cuts carbon dioxide emissions associated with fossil fuel combustion, contributing to climate change mitigation.",

                        "Water Conservation" => "Water conservation measures how effectively a company reduces its freshwater usage and improves water stewardship through technology upgrades, behavior changes, and reuse initiatives. 
Examples: Installing low-flow faucets and toilets, implementing rainwater harvesting systems, recycling greywater for landscaping, fixing leaks promptly. 
Impact: Reduces the energy and chemicals required for water treatment and delivery, preserving natural water ecosystems and lowering indirect carbon emissions.",

                        "Sustainable Supply Chain" => "Sustainable supply chain evaluates how a company integrates environmental responsibility into supplier selection, purchasing policies, and logistics. 
Examples: Preferring local suppliers to reduce transport emissions, sourcing certified sustainable raw materials, conducting supplier environmental audits, requiring supplier sustainability certifications (e.g., FSC, Fairtrade). 
Impact: Reduces environmental impact across the entire product lifecycle, from raw material extraction to delivery.",

                        "Eco-friendly Products/Services" => "Eco-friendly products/services measure the extent to which a company designs and offers products or services with reduced environmental impacts across their life cycles. 
Examples: Creating biodegradable packaging, developing energy-efficient devices, offering carbon-neutral services, designing for recyclability or modular repair. 
Impact: Lowers the total resource footprint, reduces end-of-life environmental harm, and encourages responsible consumer choices.",

                        "Energy-Efficient Infrastructure" => "Energy-efficient infrastructure assesses the extent to which company buildings and facilities are optimized to minimize energy use while maintaining productivity. 
Examples: Installing LED lighting, upgrading insulation and windows for better thermal performance, implementing energy management systems, and achieving green building certifications (e.g., LEED, BREEAM). 
Impact: Reduces operational carbon emissions, lowers utility costs, and supports net-zero building targets.",

                        "Transportation Sustainability" => "Transportation sustainability measures a company's efforts to minimize emissions associated with employee commuting, business travel, and logistics operations. 
Examples: Electrifying vehicle fleets, promoting public transport or cycling, offering telecommuting options, using carbon-neutral freight shipping. 
Impact: Reduces emissions from fossil fuel use in transportation — a major source of greenhouse gases.",

                        "Community Engagement" => "Community engagement evaluates a company's efforts to raise environmental awareness, support local sustainability initiatives, and foster collective climate action. 
Examples: Sponsoring local tree-planting drives, offering employee volunteer days for environmental causes, running public education campaigns on sustainability. 
Impact: Multiplies positive environmental impacts beyond the company itself and builds goodwill with stakeholders.",

                        "Carbon Offsetting" => "Carbon offsetting assesses a company's commitment to compensate for its unavoidable greenhouse gas emissions by supporting certified climate projects. 
Examples: Purchasing carbon credits from reforestation projects, investing in renewable energy farms, supporting verified carbon capture technologies. 
Impact: Balances out emissions while financing global climate mitigation initiatives and helping achieve net-zero targets.",

                        "Transparency and Reporting" => "Transparency and reporting evaluate how openly a company communicates its environmental impact, targets, and progress towards sustainability. 
Examples: Publishing annual sustainability reports aligned with standards (e.g., GRI, CDP), disclosing greenhouse gas inventories, setting science-based targets, providing third-party verification. 
Impact: Builds stakeholder trust, drives internal accountability, and strengthens continuous improvement toward emissions reduction goals."


                    ];

                    foreach ($measures as $index => $measure) {
                        $modalId = "info" . preg_replace('/[^A-Za-z0-9]/', '', $measure);
                        echo "<div class='form-group mb-3'>";
                        echo "<label><strong>$measure</strong>
                            <button type='button' class='btn btn-link p-0 ms-2' data-bs-toggle='modal' data-bs-target='#$modalId'>
                                <i class='fas fa-eye'></i>
                            </button></label>";
                        echo "<select class='form-control' name='measure_$index' required>
                            <option value=''>-- Select Level --</option>
                            <option value='10'>🟢 Green (Excellent)</option>
                            <option value='5'>🟠 Amber (Moderate)</option>
                            <option value='0'>🔴 Red (Not Implemented)</option>
                          </select>";
                        echo "</div>";

                        echo "<div class='modal fade' id='$modalId' tabindex='-1' aria-labelledby='{$modalId}Label' aria-hidden='true'>
                              <div class='modal-dialog'>
                                <div class='modal-content'>
                                  <div class='modal-header'>
                                    <h5 class='modal-title' id='{$modalId}Label'>$measure</h5>
                                    <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                                  </div>
                                  <div class='modal-body'>
                                    {$explanations[$measure]}
                                  </div>
                                </div>
                              </div>
                            </div>";
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
                            <div class="progress-bar bg-success" style="width: <?= $green * 10 ?>%"><?= $green ?></div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label>🟠 Amber</label>
                        <div class="progress">
                            <div class="progress-bar bg-warning text-dark" style="width: <?= $amber * 10 ?>%"><?= $amber ?></div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label>🔴 Red</label>
                        <div class="progress">
                            <div class="progress-bar bg-danger" style="width: <?= $red * 10 ?>%"><?= $red ?></div>
                        </div>
                    </div>

                    <?php if ($shortfall > 0): ?>
                        <p class="text-danger"><?= $emoji ?> <strong><?= $message ?></strong><br>You’re <strong><?= $shortfall ?> points</strong> short. Consider donating <strong>£<?= $cost ?></strong>.</p>
                    <?php else: ?>
                        <p class="text-success">✅ Perfect score! You’re a green superstar!</p>
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

