<?php
require_once 'includes/init.php';
require_once 'includes/connect_db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// CSRF token for delete form
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$error = '';

// Handle "Delete user" requests
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'delete') {
    // CSRF validation
    if (!hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'] ?? '')) {
        die('Invalid CSRF token.');
    }
    $delete_id = (int) ($_POST['user_id'] ?? 0);

    // Prevent admin from deleting themselves
    if ($delete_id === (int) $_SESSION['user_id']) {
        $error = 'You cannot delete your own account.';
    } else {
        $stmt = mysqli_prepare($link, 'DELETE FROM new_users WHERE id = ?');
        mysqli_stmt_bind_param($stmt, 'i', $delete_id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }
}

// Fetch all users (including role and status)
$sql = 'SELECT id, username, email, created_at, role, status FROM new_users ORDER BY username';
$result = mysqli_query($link, $sql);
if (!$result) {
    die('Query error: ' . mysqli_error($link));
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Users | GreenScore</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { padding-top: 2rem; }
        .container { max-width: 900px; }
    </style>
</head>
<body>
<?php include 'includes/nav.php'; ?>

<div class="container">
    <h2 class="mb-4">Manage Users</h2>

    <?php if ($error): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <table class="table table-hover align-middle">
        <thead>
        <tr>
            <th>Username</th>
            <th>Email</th>
            <th>Registered</th>
            <th>Role</th>
            <th>Status</th>
            <th>Delete</th>
        </tr>
        </thead>
        <tbody>
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <tr>
                <td><?= htmlspecialchars($row['username']) ?></td>
                <td><?= htmlspecialchars($row['email']) ?></td>
                <td><?= date('d/m/Y', strtotime($row['created_at'])) ?></td>
                <td>
                    <?php if ($row['role'] === 'admin'): ?>
                        <span class="badge bg-primary">Admin</span>
                    <?php else: ?>
                        <span class="badge bg-light text-dark">User</span>
                    <?php endif; ?>
                </td>
                <td>
                    <?php
                    switch ($row['status']) {
                        case 'inactive':
                            echo '<span class="badge bg-secondary">Inactive</span>';
                            break;
                        case 'deactivated':
                            echo '<span class="badge bg-dark">Deactivated</span>';
                            break;
                        default:
                            echo '<span class="badge bg-info">Active</span>';
                            break;
                    }
                    ?>
                </td>
                <td>
                    <form method="post" style="display:inline;">
                        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                        <input type="hidden" name="action"     value="delete">
                        <input type="hidden" name="user_id"    value="<?= $row['id'] ?>">
                        <button
                            type="submit"
                            class="btn btn-sm btn-danger"
                            <?= ($row['id'] === (int) $_SESSION['user_id']) ? 'disabled' : '' ?>
                        >
                            Delete
                        </button>
                    </form>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
</div>

<?php include 'includes/footer.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
mysqli_free_result($result);
mysqli_close($link);
?>
