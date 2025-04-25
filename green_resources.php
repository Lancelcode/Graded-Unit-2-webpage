<?php
require_once 'includes/init.php';
require_once 'includes/connect_db.php';
include 'includes/nav.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Green Resources | GreenScore</title>
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
    <h1 class="text-white text-center mb-5">📚 Green Resources</h1>

    <div class="row gy-4">
        <!-- SDG Resources -->
        <div class="col-md-6">
            <div class="card-bg">
                <h3 class="resource-title">🌍 United Nations SDG Resources</h3>
                <a class="resource-link" href="https://sdgs.un.org/goals" target="_blank"><i class="fas fa-leaf"></i> UN Sustainable Development Goals</a>
                <a class="resource-link" href="https://www.globalgoals.org/" target="_blank"><i class="fas fa-globe"></i> The Global Goals Overview</a>
                <a class="resource-link" href="https://sdgs.un.org/sites/default/files/publications/21252030%20Agenda%20for%20Sustainable%20Development%20web.pdf" target="_blank"><i class="fas fa-file-pdf"></i> SDG Agenda 2030 (PDF)</a>
            </div>
        </div>

        <!-- PDF Downloads -->
        <div class="col-md-6">
            <div class="card-bg">
                <h3 class="resource-title">📁 Downloadable Guides</h3>
                <a class="resource-link" href="assets/documents/green_tips_guide.pdf" target="_blank"><i class="fas fa-book"></i> Green Living Tips Guide (PDF)</a>
                <a class="resource-link" href="assets/documents/carbon_reduction_checklist.pdf" target="_blank"><i class="fas fa-list-check"></i> Carbon Reduction Checklist (PDF)</a>
            </div>
        </div>

        <!-- Educational Resources -->
        <div class="col-md-6">
            <div class="card-bg">
                <h3 class="resource-title">🧠 Educational & Research Platforms</h3>
                <a class="resource-link" href="https://www.epa.gov/sustainability" target="_blank"><i class="fas fa-recycle"></i> EPA: Learn About Sustainability</a>
                <a class="resource-link" href="https://climate.nasa.gov/" target="_blank"><i class="fas fa-satellite"></i> NASA Climate Data</a>
                <a class="resource-link" href="https://www.carbontrust.com/resources" target="_blank"><i class="fas fa-flask"></i> Carbon Trust Resource Hub</a>
            </div>
        </div>

        <!-- Government/NGO Resources -->
        <div class="col-md-6">
            <div class="card-bg">
                <h3 class="resource-title">🏛️ Government & NGO Initiatives</h3>
                <a class="resource-link" href="https://www.gov.uk/government/publications/net-zero-strategy" target="_blank"><i class="fas fa-flag-uk"></i> UK Gov: Net Zero Strategy</a>
                <a class="resource-link" href="https://climate.ec.europa.eu/" target="_blank"><i class="fas fa-globe-europe"></i> EU Climate Action</a>
                <a class="resource-link" href="https://footprint.wwf.org.uk/" target="_blank"><i class="fas fa-paw"></i> WWF Carbon Footprint Guide</a>
            </div>
        </div>
    </div>

    <div class="text-center mt-5">
        <a href="user_account.php" class="btn btn-outline-light">⬅ Back to My Profile</a>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php mysqli_close($link); ?>
