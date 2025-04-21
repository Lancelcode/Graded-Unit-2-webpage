<?php include('includes/nav.php'); ?>

<div class="container mt-5">
    <h2>💬 We Value Your Feedback</h2>
    <form method="POST" action="">
        <label>Your Name:</label>
        <input type="text" class="form-control" name="name" required><br>
        <label>Your Feedback:</label>
        <textarea class="form-control" name="message" rows="4" required></textarea><br>
        <button type="submit" class="btn btn-success">Submit</button>
    </form>
</div>
