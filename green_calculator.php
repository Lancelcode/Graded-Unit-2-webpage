<?php require_once 'includes/init.php'; ?>
<?php include 'includes/nav.php'; ?>
<link rel="stylesheet" href="assets/css/style.css">

<div class="container mt-5">
    <h1 class="mb-4 text-success">🌿 Green Calculator</h1>
    <p class="lead">Answer the following questions to assess your sustainability level. Your score determines your certification level.</p>

    <form action="logic/green_calculator_logic.php" method="POST">
        <?php
        $questions = [
            "Do you recycle regularly?",
            "Do you use energy-efficient appliances?",
            "Do you avoid single-use plastics?",
            "Do you bike, walk, or use public transport instead of driving?",
            "Do you reduce water usage at home?",
            "Do you compost food waste?",
            "Do you support eco-friendly brands?",
            "Do you plant trees or contribute to green spaces?",
            "Do you switch off electronics when not in use?",
            "Do you educate others about sustainability?"
        ];

        foreach ($questions as $index => $q) {
            echo "<div class='mb-3'>";
            echo "<label class='form-label fw-bold'>" . ($index + 1) . ". $q</label>";
            echo "<select class='form-select' name='q$index' required>
                    <option value=''>Choose an option</option>
                    <option value='green'>Green (Good Practice)</option>
                    <option value='amber'>Amber (Okay)</option>
                    <option value='red'>Red (Needs Improvement)</option>
                  </select>";
            echo "</div>";
        }
        ?>
        <div class="text-end">
            <button type="submit" class="btn btn-primary mt-3">Calculate My Score</button>
        </div>
    </form>
</div>

<?php include 'includes/footer.php'; ?>
