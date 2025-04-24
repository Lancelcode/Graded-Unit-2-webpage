<?php
require_once 'includes/init.php';
require_once 'includes/connect_db.php';

// Check if admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    echo "<div class='container mt-5'><div class='alert alert-danger'>Access denied. Admins only.</div></div>";
    include 'includes/footer.php';
    exit();
}

// Loop through feedback items
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach ($_POST['admin_response'] as $id => $response) {
        // Determine visibility (if the checkbox was checked)
        $is_public = isset($_POST['visible_to_public'][$id]) ? 1 : 0;

        // Sanitize inputs
        $id = intval($id);
        $response = mysqli_real_escape_string($link, trim($response));

        // Update query
        $query = "UPDATE feedback 
                  SET visible_to_public = $is_public, 
                      admin_response = '$response' 
                  WHERE id = $id";
        mysqli_query($link, $query);
    }

    // Redirect back to admin panel with success message (optional)
    header("Location: admin_feedback");
    exit();
}
?>
