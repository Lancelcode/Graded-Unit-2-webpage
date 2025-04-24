<?php
require_once __DIR__ . '/includes/init.php';   // starts the session
require_once __DIR__ . '/includes/connect_db.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GreenScore - Empowering Sustainable Business</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body class="bg-light">

<?php include __DIR__ . '/includes/nav.php'; ?>

<!-- Hero Section -->
<section class="hero text-center text-white d-flex align-items-center" style="background: url('assets/images/forest-hero.jpg') center/cover; height: 70vh;">
    <div class="container">
        <h1 class="display-3 fw-bold mb-3">Welcome to GreenScore</h1>
        <p class="lead mb-4">Measure, Reduce, and Be Rewarded for Your Company's Carbon Footprint.</p>
        <a href="signup.php" class="btn btn-success btn-lg me-2">Get Started</a>
        <a href="#features" class="btn btn-outline-light btn-lg">Learn More</a>
    </div>
</section>

<!-- Features Section -->
<section id="features" class="py-5">
    <div class="container">
        <div class="row text-center">
            <div class="col-md-4 mb-4">
                <img src="/assets/images/analytics-icon.svg" alt="Analytics" class="mb-3" width="80">
                <h4>Real-Time Analytics</h4>
                <p>Track your emissions and progress with intuitive dashboards and detailed reports.</p>
            </div>
            <div class="col-md-4 mb-4">
                <img src="/assets/images/leaf-icon.svg" alt="Certification" class="mb-3" width="80">
                <h4>Certified Green Points</h4>
                <p>Earn GreenScore points when you hit emission-reduction milestones, recognized globally.</p>
            </div>
            <div class="col-md-4 mb-4">
                <img src="/assets/images/community-icon.svg" alt="Community" class="mb-3" width="80">
                <h4>Community & Support</h4>
                <p>Join a network of sustainability leaders sharing best practices and insights.</p>
            </div>
        </div>
    </div>
</section>

<!-- Carousel of Success Stories -->
<section class="py-5 bg-white">
    <div class="container">
        <h2 class="text-center mb-4">Success Stories</h2>
        <div id="successCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <?php
                // Fetch top 5 success stories
                $sql = "SELECT img, company_name, reduction_percentage FROM success_stories ORDER BY reduction_percentage DESC LIMIT 5";
                $res = mysqli_query($link, $sql);
                $first = true;
                while ($story = mysqli_fetch_assoc($res)) {
                    echo '<div class="carousel-item' . ($first ? ' active' : '') . '">';
                    echo '  <img src="' . htmlspecialchars($story['img']) . '" class="d-block w-100 rounded shadow-sm" alt="' . htmlspecialchars($story['company_name']) . '">';
                    echo '  <div class="carousel-caption d-none d-md-block bg-dark bg-opacity-50 rounded">';
                    echo '    <h5>' . htmlspecialchars($story['company_name']) . '</h5>';
                    echo '    <p>Reduced emissions by ' . htmlspecialchars($story['reduction_percentage']) . '%</p>';
                    echo '  </div>';
                    echo '</div>';
                    $first = false;
                }
                if (mysqli_num_rows($res) === 0) {
                    echo '<div class="carousel-item active"><p class="text-center py-5">No success stories yet. Be the first to make an impact!</p></div>';
                }
                ?>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#successCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#successCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>
</section>

<!-- Call to Action -->
<section class="cta text-center py-5 text-white" style="background: url('assets/images/earth-bg.jpg') center/cover;">
    <div class="container">
        <h2 class="mb-3">Ready to Earn Your GreenScore?</h2>
        <a href="register_company.php" class="btn btn-outline-light btn-lg">Register Your Company</a>
    </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>

<!-- Bootstrap JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
