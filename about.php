<?php require_once 'includes/init.php'; ?>
<?php include 'includes/nav.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Why GreenScore?</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            min-height: 100vh;
            margin: 0;
            background: url('assets/images/forest-hero.jpg') center/cover no-repeat fixed;
            position: relative;
        }
        body::before {
            content: '';
            position: absolute;
            inset: 0;
            background: rgba(0,0,0,0.5);
            z-index: 0;
        }
        .content-wrapper {
            position: relative;
            z-index: 1;
            padding: 4rem 1rem;
        }
        .card-bg {
            background: rgba(255,255,255,0.9);
            border-radius: 1rem;
            padding: 2rem;
            box-shadow: 0 0 15px rgba(0,0,0,0.2);
        }
        .section-title {
            font-size: 1.75rem;
            font-weight: 600;
            color: #2e7d32;
        }
        .img-fluid {
            border-radius: 1rem;
            box-shadow: 0 4px 10px rgba(0,0,0,0.25);
        }
        .btn-success {
            border-radius: 2rem;
            padding: 0.75rem 2rem;
            font-size: 1.2rem;
        }
        .text-white a {
            color: #fff;
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="container content-wrapper">
    <div class="card card-bg mb-5">
        <div class="text-center">
            <h1 class="text-success mb-3">💚 Why GreenScore?</h1>
            <p class="lead">A mission born from passion for the planet.</p>
        </div>
    </div>

    <div class="row gy-5">
        <div class="col-lg-12">
            <div class="card card-bg">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <img src="assets/images/earth-hands.jpg" alt="Protecting Earth" class="img-fluid mb-3 mb-md-0">
                    </div>
                    <div class="col-md-6">
                        <h3 class="section-title">🌱 Small Actions, Big Impact</h3>
                        <p>
                            Climate change is real, and it affects all of us. But we believe that change doesn't always start with governments or corporations — it starts with <strong>you</strong>.<br><br>
                            GreenScore was created as a fun, accessible, and data-driven tool to help you reflect on your habits, learn new ways to be sustainable, and celebrate progress at every step.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-12">
            <div class="card card-bg">
                <div class="row align-items-center">
                    <div class="col-md-6 order-md-2">
                        <img src="assets/images/team-green.jpg" alt="Green Team" class="img-fluid mb-3 mb-md-0">
                    </div>
                    <div class="col-md-6 order-md-1">
                        <h3 class="section-title">👥 Built for Real People</h3>
                        <p>
                            We designed this platform with <strong>accessibility</strong> and <strong>inclusivity</strong> in mind. Whether you're new to sustainability or already a green champion, GreenScore helps you track, learn, and grow.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-12">
            <div class="card card-bg">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <img src="assets/images/sdg.jpg" alt="Sustainable Development Goals" class="img-fluid mb-3 mb-md-0">
                    </div>
                    <div class="col-md-6">
                        <h3 class="section-title">📚 Backed by Global Goals</h3>
                        <p>
                            Our framework aligns with the <a href="https://sdgs.un.org/goals" target="_blank">UN Sustainable Development Goals</a>, particularly those focusing on responsible consumption, climate action, and quality education.<br><br>
                            We're not just helping you score green points — we're helping the world move forward.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 text-center">
            <div class="card card-bg">
                <h2 class="text-success mb-3">🚀 The Journey Starts Here</h2>
                <p>
                    We hope GreenScore inspires action — not perfection.<br>Let's grow together, one habit at a time. 🌍💚
                </p>
                <a href="green_calculator.php" class="btn btn-success mt-3">Get Started</a>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
