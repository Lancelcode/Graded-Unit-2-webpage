<?php require_once 'includes/init.php'; ?>
<?php include 'includes/nav.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Green Resource Hub | GreenScore</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome for icons (optional but recommended) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Custom Styles -->
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<div class="container mt-5">
    <h1 class="mb-4 text-success">📚 Green Resource Hub</h1>

    <p class="lead">Explore ways to be more eco-conscious in your daily life, at work, and in your community.</p>

    <div class="result-box mb-4">
        <h4>🌍 United Nations Sustainable Development Goals</h4>
        <p>Learn more about the global goals for a better future:</p>
        <a href="https://sdgs.un.org/goals" target="_blank" class="btn btn-outline-success mb-2">
            🌐 View UN SDGs
        </a>
    </div>

    <div class="result-box mb-4">
        <h4>📝 Quick Green Guides</h4>
        <ul>
            <li><a href="assets/docs/green_at_work.pdf" target="_blank">💼 10 Ways to Be Greener at Work (PDF)</a></li>
            <li><a href="assets/docs/home_energy_tips.pdf" target="_blank">🏠 Home Energy Saving Tips (PDF)</a></li>
        </ul>
        <p class="text-muted">These short guides are designed to make your transition to greener habits easier.</p>
    </div>

    <div class="result-box">
        <h4>📎 Additional Resources</h4>
        <ul>
            <li><a href="https://www.energysavingtrust.org.uk/" target="_blank">UK Energy Saving Trust</a></li>
            <li><a href="https://www.gov.uk/government/publications/25-year-environment-plan" target="_blank">25-Year Environment Plan (UK Gov)</a></li>
        </ul>
    </div>
</div>

<?php include 'includes/footer.php'; ?>

</body>
</html>
