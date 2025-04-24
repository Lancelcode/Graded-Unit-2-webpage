<?php
require_once 'includes/init.php';
require_once 'includes/connect_db.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    echo "<div class='container mt-5'>
            <div class='alert alert-danger'>
              Access denied. Admins only.
            </div>
          </div>";
    include 'includes/footer.php';
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach ($_POST['admin_response'] as $id => $response) {
        $id            = intval($id);
        $response_safe = mysqli_real_escape_string($link, trim($response));
        $is_public     = isset($_POST['visible_to_public'][$id]) ? 1 : 0;
        $admin_user    = mysqli_real_escape_string($link, $_SESSION['username']);

        $sql = "
          UPDATE feedback
          SET visible_to_public  = $is_public,
              is_public          = $is_public,
              admin_response     = '$response_safe',
              admin_username     = '$admin_user',
              admin_response_at  = NOW()
          WHERE id = $id
        ";
        mysqli_query($link, $sql);
    }

    header("Location: admin_feedback.php?updated=1");
    exit();
}
?>
