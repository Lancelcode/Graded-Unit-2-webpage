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
        body {
            background: url('assets/images/earth-bg.jpg') center/cover no-repeat fixed;
            position: relative;
            color: #fff;
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


    <!-- Success Stories Carousel -->
    <!--<div class="container content-wrapper">
        <h2 class="text-white text-center mb-4">🌟 Success Stories</h2>
        <div id="successCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <?php
/*                $sql = "SELECT img, company_name, reduction_percentage FROM success_stories ORDER BY reduction_percentage DESC LIMIT 5";
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
                    echo '<div class="carousel-item active"><p class="text-center py-5 text-white">No success stories yet. Be the first to make an impact!</p></div>';
                }
                */?>
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
    </div>-->

    <?php include 'includes/footer.php'; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php mysqli_close($link); ?>
