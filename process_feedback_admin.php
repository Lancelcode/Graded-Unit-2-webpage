<?php
require_once 'includes/init.php';
require_once 'includes/connect_db.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    echo "<div class='container mt-5'>
            <div class='alert alert-danger'>Access denied. Admins only.</div>
          </div>";
    include 'includes/footer.php';
    exit();
}

// CSRF check
if (!hash_equals($_SESSION['csrf_token'] ?? '', $_POST['csrf_token'] ?? '')) {
    die('Invalid CSRF token.');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // FIX: one prepared statement, reused for each feedback row
    $stmt = mysqli_prepare($link,
        "UPDATE feedback
         SET visible_to_public  = ?,
             admin_response     = ?,
             admin_username     = ?,
             admin_response_at  = NOW()
         WHERE id = ?"
    );

    foreach ($_POST['admin_response'] as $id => $response) {
        $id         = (int) $id;
        $response   = trim($response);
        $is_public  = isset($_POST['visible_to_public'][$id]) ? 1 : 0;
        $admin_user = $_SESSION['username'];

        mysqli_stmt_bind_param($stmt, 'issi', $is_public, $response, $admin_user, $id);
        mysqli_stmt_execute($stmt);
    }

    mysqli_stmt_close($stmt);
    mysqli_close($link);

    header('Location: admin_feedback.php?updated=1');
    exit();
}