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
            background: url('assets/images/forest-hero.jpg') center/cover no-repeat fixed;
            position: relative;
            color: #fff;
        }
        body::before {
            content: '';
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 0;
        }
        .container {
            position: relative;
            z-index: 1;
            padding: 3rem 1rem;
        }
        .text-center h1 {
            font-size: 2.5rem;
        }
        .text-center p {
            font-size: 1.25rem;
        }
        .section-title {
            font-size: 2rem;
            font-weight: bold;
            color: #4CAF50;
        }
        .lead {
            font-size: 1.1rem;
        }
        .row {
            margin-bottom: 3rem;
        }
        .img-fluid {
            border-radius: 1rem;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        .level-card h3 {
            font-size: 1.5rem;
        }
        .btn-success {
            font-size: 1.25rem;
            padding: 1rem 2rem;
            background-color: #4CAF50;
            border: none;
            border-radius: 2rem;
        }
        .btn-success:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>

<div class="container mt-5">
    <div class="text-center">
        <h1 class="text-success mb-4">💚 Why GreenScore?</h1>
        <p class="lead">A mission born from passion for the planet.</p>
    </div>

    <!-- Section 1 -->
    <div class="row align-items-center mb-5">
        <div class="col-md-6">
            <img src="assets/images/earth-hands.jpg" alt="Protecting Earth" class="img-fluid">
        </div>
        <div class="col-md-6">
            <h3 class="section-title">🌱 Small Actions, Big Impact</h3>
            <p>
                Climate change is real, and it affects all of us. But we believe that change doesn't always start with governments or corporations — it starts with <strong>you</strong>.<br><br>
                GreenScore was created as a fun, accessible, and data-driven tool to help you reflect on your habits, learn new ways to be sustainable, and celebrate progress at every step.
            </p>
        </div>
    </div>

    <!-- Section 2 -->
    <div class="row align-items-center mb-5">
        <div class="col-md-6 order-md-2">
            <img src="assets/images/team-green.jpg" alt="Green Team" class="img-fluid">
        </div>
        <div class="col-md-6 order-md-1">
            <h3 class="section-title">👥 Built for Real People</h3>
            <p>
                We designed this platform with <strong>accessibility</strong> and <strong>inclusivity</strong> in mind. Whether you're new to sustainability or already a green champion, GreenScore helps you track, learn, and grow.
            </p>
        </div>
    </div>

    <!-- Section 3 -->
    <div class="row align-items-center mb-5">
        <div class="col-md-6">
            <img src="assets/images/sdg.jpg" alt="Sustainable Development Goals" class="img-fluid">
        </div>
        <div class="col-md-6">
            <h3 class="section-title">📚 Backed by Global Goals</h3>
            <p>
                Our framework aligns with the <a href="https://sdgs.un.org/goals" target="_blank">UN Sustainable Development Goals</a>, particularly those focusing on responsible consumption, climate action, and quality education.<br><br>
                We're not just helping you score green points — we're helping the world move forward.
            </p>
        </div>
    </div>

    <!-- Closing Section -->
    <div class="text-center mb-5">
        <h2 class="text-success">🚀 The Journey Starts Here</h2>
        <p>
            We hope GreenScore inspires action — not perfection. Let's grow together, one habit at a time. 🌍💚
        </p>
        <a href="green_calculator.php" class="btn btn-success mt-3">Get Started</a>
    </div>
</div>

<?php include 'includes/footer.php'; ?>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
