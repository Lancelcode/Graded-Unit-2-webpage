<?php
require_once __DIR__ . '/includes/init.php';
require_once __DIR__ . '/includes/connect_db.php';
include __DIR__ . '/includes/nav.php';
?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Welcome to GreenScore</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- Bootstrap & FontAwesome -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
        <link href="style.css" rel="stylesheet">

        <style>
            html, body {
                height: 100%;
            }
            body {
                background: url('assets/images/earth-bg.jpg') center/cover no-repeat fixed;
                position: relative;
                color: #fff;
                font-size: 1.1rem;
            }
            body::before {
                content: '';
                position: fixed;
                inset: 0;
                background: rgba(0, 0, 0, 0.6);
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
                padding: 4rem 1rem;
            }
            .card-bg {
                background: rgba(255, 255, 255, 0.95);
                border-radius: 1rem;
            }
            .icon-circle {
                background-color: #e6f4ea;
                border-radius: 50%;
                padding: 15px;
                display: inline-block;
                margin-bottom: 1rem;
            }
            .carousel-item img {
                max-height: 450px;
                width: auto;
                margin: 0 auto;
                display: block;
            }
            .carousel-caption h5 {
                color: white;
                font-weight: bold;
                text-shadow: 1px 1px 5px rgba(0, 0, 0, 0.8);
            }
            footer {
                background: #222;
                color: #ccc;
                padding: 2rem 0;
                text-align: center;
                width: 100%;
            }
            footer a {
                color: #aaffcc;
                text-decoration: none;
            }
            footer a:hover {
                text-decoration: underline;
            }
        </style>
    </head>
    <body>

    <div class="page-wrapper">

        <!-- Hero Section -->
        <div class="container content-wrapper text-center">
            <h1 class="text-white display-4 mb-4">🌿 Welcome to GreenScore</h1>
            <p class="text-white fs-5 mb-4">Track, reduce, and showcase your sustainability progress.</p>
            <?php if (!isset($_SESSION['user_id'])): ?>
                <a href="register.php" class="btn btn-success btn-lg px-4">🌱 Join the Movement</a>
                <a href="login.php" class="btn btn-outline-light btn-lg px-4">🔐 Member Login</a>
            <?php endif; ?>
            <div class="text-center mt-3">
                <a href="about.php" class="btn btn-light btn-sm px-4">🌍 Our Mission</a>
            </div>

            <!-- Impact Commitment Text -->
            <div class="mt-4 p-4 bg-light bg-opacity-75 rounded text-dark shadow fs-6">
                <p class="mb-3 fw-semibold">
                    🌍 Earning the highest GreenScore badge is more than recognition, it's a verified contribution to planetary recovery.
                </p>
                <p class="mb-3">
                    By reaching this level, your organization actively safeguards over <strong>100 square meters of endangered rainforest</strong>, supporting biodiversity and protecting vital carbon sinks.
                </p>
                <p class="mb-3">
                    For every <strong>£10,000</strong> raised through certified sustainability practices, <strong>£1,000</strong> is directly reinvested into global reforestation and carbon offset initiatives, ensuring measurable, traceable climate impact.
                </p>
                <p class="mb-0">
                    GreenScore empowers responsible businesses to lead by example, aligning with the <a href="https://sdgs.un.org/goals" target="_blank" rel="noopener noreferrer"><em>United Nations Sustainable Development Goals</em></a> and demonstrating real commitment to environmental stewardship.
                </p>
            </div>
        </div>

        <!-- Features Section -->
        <div class="container content-wrapper">
            <div class="row row-cols-1 row-cols-md-3 g-4">
                <div class="col">
                    <div class="card card-bg shadow-sm h-100 text-center p-4">
                        <div class="icon-circle"><i class="fa fa-leaf fa-2x text-success"></i></div>
                        <h5>🌍 Measure Your Impact</h5>
                        <p>
                            Use our Green Calculator to evaluate your organization’s sustainability practices.
                            Identify where you stand and discover areas for improvement based on global standards.
                        </p>
                    </div>
                </div>
                <div class="col">
                    <div class="card card-bg shadow-sm h-100 text-center p-4">
                        <div class="icon-circle"><i class="fa fa-medal fa-2x text-warning"></i></div>
                        <h5>🏅 Earn Recognition</h5>
                        <p>
                            Gain certification levels — Gold, Silver, Bronze — and download official digital certificates
                            that show your progress and commitment toward sustainability goals.
                        </p>
                    </div>
                </div>
                <div class="col">
                    <div class="card card-bg shadow-sm h-100 text-center p-4">
                        <div class="icon-circle"><i class="fa fa-users fa-2x text-primary"></i></div>
                        <h5>🤝 Join the Green Community</h5>
                        <p>
                            Connect with like-minded organizations, share tips in the community space,
                            and contribute to a collective movement aligned with the UN’s sustainability goals.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Badge Carousel Section -->
        <div class="container content-wrapper">
            <h2 class="text-white text-center mb-4">🏆 GreenScore Badge Levels</h2>
            <div id="badgeCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="5000">
                <div class="carousel-inner">
                    <?php
                    $badges = [
                        ['slug' => 'green_starter', 'label' => '🌱 Green Starter'],
                        ['slug' => 'eco_explorer', 'label' => '🌿 Eco Explorer'],
                        ['slug' => 'climate_cadet', 'label' => '🎖 Climate Cadet'],
                        ['slug' => 'forest_friend', 'label' => '🌳 Forest Friend'],
                        ['slug' => 'carbon_cutter', 'label' => '✂️ Carbon Cutter'],
                        ['slug' => 'renewable_rookie', 'label' => '⚡ Renewable Rookie'],
                        ['slug' => 'sustainability_scout', 'label' => '🧭 Sustainability Scout'],
                        ['slug' => 'leaf_leader', 'label' => '🍃 Leaf Leader'],
                        ['slug' => 'green_visionary', 'label' => '👁 Green Visionary'],
                        ['slug' => 'eco_hero', 'label' => '🦸 Eco Hero'],
                        ['slug' => 'planet_paladin', 'label' => '🪐 Planet Paladin'],
                        ['slug' => 'guardian_of_earth', 'label' => '🛡 Guardian of Earth'],
                        ['slug' => 'green_warrior', 'label' => '🌟 Green Warrior'],
                        ['slug' => 'champion_of_sustainability', 'label' => '🏆 Champion of Sustainability']
                    ];
                    $first = true;
                    foreach ($badges as $badge) {
                        echo '<div class="carousel-item' . ($first ? ' active' : '') . '">';
                        echo '<img src="assets/images/illustrations/' . $badge['slug'] . '.jpg" class="d-block rounded shadow" alt="' . htmlspecialchars($badge['label']) . '">';
                        echo '<div class="carousel-caption d-none d-md-block bg-dark bg-opacity-50 rounded">';
                        echo '<h5>' . $badge['label'] . '</h5>';
                        echo '</div></div>';
                        $first = false;
                    }
                    ?>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#badgeCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#badgeCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>

        <?php include 'includes/footer.php'; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    </body>
    </html>

<?php mysqli_close($link); ?>