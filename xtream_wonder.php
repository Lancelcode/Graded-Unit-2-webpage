<?php
session_start();
require('includes/connect_db.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xtream Wonder - I-Cinema</title>
    <!-- Bootstrap 4.5.2 CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            background-color: #1a1a2e;
            color: #ffffff;
            font-family: 'Roboto', sans-serif;
        }
        .experience-card {
            border-radius: 15px;
            overflow: hidden;
            background-color: #0f3460;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        .experience-card:hover {
            transform: scale(1.05);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.3);
        }
        .experience-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }
        .experience-card h5 {
            font-size: 1.5rem;
            font-weight: bold;
            color: #ffcc00;
        }
        .experience-card p {
            font-size: 1rem;
            color: #f0f0f0;
        }
        .btn-learn-more {
            background-color: #ffcc00;
            color: #1a1a2e;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }
        .btn-learn-more:hover {
            background-color: #d4a017;
        }
        .banner {
            background: linear-gradient(to right, #0f3460, #162447);
            border-radius: 10px;
            padding: 30px;
            text-align: center;
            margin-bottom: 40px;
        }
        .banner h1 {
            font-size: 3rem;
            color: #ffcc00;
            font-weight: bold;
        }
        .banner p {
            font-size: 1.5rem;
            color: #ffffff;
        }
    </style>
</head>
<body>
<?php include('includes/nav1.php'); ?>

<div class="container mt-5">
    <!-- Page Banner -->
    <div class="banner">
        <h1>Welcome to Xtream Wonder</h1>
        <p>Explore immersive experiences that redefine movie-watching. From breathtaking 3D to mind-blowing 4D and larger-than-life IMAX!</p>
    </div>

    <!-- Experience Section -->
    <div class="row">
        <!-- 3D Experience -->
        <div class="col-md-4 mb-4">
            <div class="card experience-card">
                <img src="https://via.placeholder.com/400x200?text=3D+Experience" alt="3D Experience">
                <div class="card-body">
                    <h5>Immersive 3D Experience</h5>
                    <p>Step into the action with state-of-the-art 3D technology. Watch every detail come to life in stunning clarity and depth.</p>
                    <a href="3d_info.php" class="btn btn-learn-more btn-block">Learn More</a>
                </div>
            </div>
        </div>
        <!-- 4D Experience -->
        <div class="col-md-4 mb-4">
            <div class="card experience-card">
                <img src="https://via.placeholder.com/400x200?text=4D+Experience" alt="4D Experience">
                <div class="card-body">
                    <h5>Mind-Blowing 4D Experience</h5>
                    <p>Feel the thrill with motion seats, wind effects, water sprays, and scents. 4D immerses you like never before!</p>
                    <a href="4d_info.php" class="btn btn-learn-more btn-block">Learn More</a>
                </div>
            </div>
        </div>
        <!-- IMAX Experience -->
        <div class="col-md-4 mb-4">
            <div class="card experience-card">
                <img src="https://via.placeholder.com/400x200?text=IMAX+Experience" alt="IMAX Experience">
                <div class="card-body">
                    <h5>Larger-Than-Life IMAX</h5>
                    <p>Witness epic visuals on a gigantic IMAX screen. Perfect for action-packed blockbusters and visually stunning films.</p>
                    <a href="imax_info.php" class="btn btn-learn-more btn-block">Learn More</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Additional Experiences Section -->
    <h2 class="text-center mt-5">Coming Soon</h2>
    <div class="row">
        <!-- Dolby Atmos -->
        <div class="col-md-6 mb-4">
            <div class="card experience-card">
                <img src="https://via.placeholder.com/400x200?text=Dolby+Atmos" alt="Dolby Atmos">
                <div class="card-body">
                    <h5>Dolby Atmos Surround Sound</h5>
                    <p>Experience sound that moves around you, making every moment feel closer and more realistic.</p>
                    <a href="dolby_info.php" class="btn btn-learn-more btn-block">Learn More</a>
                </div>
            </div>
        </div>
        <!-- VR Cinematic -->
        <div class="col-md-6 mb-4">
            <div class="card experience-card">
                <img src="https://via.placeholder.com/400x200?text=VR+Cinematic" alt="VR Cinematic">
                <div class="card-body">
                    <h5>Virtual Reality Cinematic</h5>
                    <p>Put on a VR headset and dive into a new era of cinematic experiences. Get fully immersed like never before.</p>
                    <a href="vr_info.php" class="btn btn-learn-more btn-block">Learn More</a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Include Bootstrap 4.5.2 JS -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
