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
            <h1 class="text-success mb-3">💼 Why GreenScore?</h1>
            <p class="lead">Empowering organizations to measure, track, and improve sustainability efforts.</p>
        </div>
    </div>

    <div class="row gy-5">
        <div class="col-lg-12">
            <div class="card card-bg">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <img src="assets/images/earth-hands.jpg" alt="Sustainable Responsibility" class="img-fluid mb-3 mb-md-0">
                    </div>
                    <div class="col-md-6">
                        <h3 class="section-title">🌍 Purpose-Built for Corporate Sustainability</h3>
                        <p>
                            GreenScore is designed to support educational institutions, businesses, and public organizations in meeting their environmental responsibilities. Through a structured evaluation of sustainability measures, organizations gain insight into how their actions align with best practices in waste reduction, energy efficiency, water conservation, and more.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-12">
            <div class="card card-bg">
                <div class="row align-items-center">
                    <div class="col-md-6 order-md-2">
                        <img src="assets/images/team-green.jpg" alt="Collaborative Sustainability" class="img-fluid mb-3 mb-md-0">
                    </div>
                    <div class="col-md-6 order-md-1">
                        <h3 class="section-title">📈 Track, Learn, Grow</h3>
                        <p>
                            With GreenScore, your organization can quantify environmental efforts, set benchmarks, and receive recognition through a point-based certification model. Data is stored securely and can be used to generate detailed reports or download digital certificates, promoting transparency and internal accountability.
                        </p>
                        <p>
                            More importantly, everyone gets to play a part, from leadership to frontline teams, fostering a shared sense of purpose and belonging in your sustainability journey. GreenScore helps build an inclusive green team where every contribution counts.
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
                            GreenScore is inspired by the <a href="https://sdgs.un.org/goals" target="_blank">UN Sustainable Development Goals</a> and the core pillars of sustainability as outlined by <strong>UNESCO</strong>:
                        </p>
                        <ul>
                            <li><strong>🌿 Environmental Sustainability</strong> | Promote eco-friendly habits, reduce emissions, and protect natural resources.</li>
                            <li><strong>💼 Economic Sustainability</strong> | Encourage responsible consumption and sustainable business practices.</li>
                            <li><strong>🤝 Social Sustainability</strong> | Support inclusivity, equity, and the well-being of communities through shared action.</li>
                            <li><strong>🎭 Cultural Sustainability</strong> | Respect cultural diversity, traditional knowledge, and local values.</li>
                        </ul>
                        <p>
                            By aligning with these global principles, GreenScore goes beyond tracking, it empowers meaningful, holistic progress.
                        </p>
                    </div>
                </div>
            </div>
        </div>


        <div class="col-12 text-center">
            <div class="card card-bg">
                <h2 class="text-success mb-3">🚀 Start Your Green Transformation</h2>
                <p>
                    Whether you're a college campus, a non-profit, or a forward-thinking enterprise, GreenScore provides a practical and engaging way to take environmental action.<br>
                    Track your progress, share your achievements, and lead by example. 🌿
                </p>
                <a href="green_calculator.php" class="btn btn-success mt-3">Begin Assessment</a>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
