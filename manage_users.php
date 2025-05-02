<?php
require_once 'includes/init.php';
require_once 'includes/connect_db.php';



// ensure CSRF token
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$error = '';
$success = '';

// handle deletes
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'delete') {
    if (!hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'] ?? '')) {
        die('Invalid CSRF token.');
    }
    $delete_id = (int)($_POST['user_id'] ?? 0);
    if ($delete_id === (int)$_SESSION['user_id']) {
        $error = 'You cannot delete your own account.';
    } else {
        $stmt = mysqli_prepare($link, 'DELETE FROM new_users WHERE id = ?');
        mysqli_stmt_bind_param($stmt, 'i', $delete_id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        $success = 'User deleted.';
    }
}

// handle role‐updates
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'update_role') {
    if (!hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'] ?? '')) {
        die('Invalid CSRF token.');
    }
    $uid = (int)($_POST['user_id'] ?? 0);
    $newRole = ($_POST['role'] === 'admin') ? 'admin' : 'user';
    if ($uid !== (int)$_SESSION['user_id']) {
        $stmt = mysqli_prepare($link, 'UPDATE new_users SET role = ? WHERE id = ?');
        mysqli_stmt_bind_param($stmt, 'si', $newRole, $uid);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        $success = 'Role updated.';
    } else {
        $error = 'Cannot change your own role.';
    }
}

// handle status‐updates
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'update_status') {
    if (!hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'] ?? '')) {
        die('Invalid CSRF token.');
    }
    $uid = (int)($_POST['user_id'] ?? 0);
    $allowed = ['active','inactive','deactivated'];
    $newStatus = in_array($_POST['status'], $allowed) ? $_POST['status'] : 'active';
    $stmt = mysqli_prepare($link, 'UPDATE new_users SET status = ? WHERE id = ?');
    mysqli_stmt_bind_param($stmt, 'si', $newStatus, $uid);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    $success = 'Status updated.';
}

// fetch current users
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
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { padding-top:2rem; }
        .container { max-width:900px; }
        form.inline { display:inline; margin:0; }
        form.inline select { width:auto; display:inline-block; margin-right:.5rem; }
    </style>
</head>
<body>
<?php include 'includes/nav.php'; ?>

<div class="container">
    <h2 class="mb-4">Manage Users</h2>
    <?php if($error): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php elseif($success): ?>
        <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
    <?php endif; ?>

    <table class="table table-hover align-middle">
        <thead>
        <tr>
            <th>Username</th>
            <th>Email</th>
            <th>Registered</th>
            <th>Role</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php while($row = mysqli_fetch_assoc($result)): ?>
            <tr>
                <td><?= htmlspecialchars($row['username']) ?></td>
                <td><?= htmlspecialchars($row['email']) ?></td>
                <td><?= date('d/m/Y',strtotime($row['created_at'])) ?></td>

                <!-- Role with inline form -->
                <td>
                    <form method="post" class="inline">
                        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                        <input type="hidden" name="action" value="update_role">
                        <input type="hidden" name="user_id" value="<?= $row['id'] ?>">
                        <select name="role" class="form-select form-select-sm d-inline-block">
                            <option value="user" <?= $row['role']==='user'?'selected':''?>>User</option>
                            <option value="admin" <?= $row['role']==='admin'?'selected':''?>>Admin</option>
                        </select>
                        <button class="btn btn-sm btn-outline-primary" type="submit">Save</button>
                    </form>
                </td>

                <!-- Status with inline form -->
                <td>
                    <form method="post" class="inline">
                        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                        <input type="hidden" name="action" value="update_status">
                        <input type="hidden" name="user_id" value="<?= $row['id'] ?>">
                        <select name="status" class="form-select form-select-sm d-inline-block">
                            <option value="active" <?= $row['status']==='active'?'selected':''?>>Active</option>
                            <option value="inactive" <?= $row['status']==='inactive'?'selected':''?>>Inactive</option>
                            <option value="deactivated" <?= $row['status']==='deactivated'?'selected':''?>>Deactivated</option>
                        </select>
                        <button class="btn btn-sm btn-outline-primary" type="submit">Save</button>
                    </form>
                </td>

                <!-- Delete button -->
                <td>
                    <form method="post" class="inline">
                        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                        <input type="hidden" name="action"     value="delete">
                        <input type="hidden" name="user_id"    value="<?= $row['id'] ?>">
                        <button
                            class="btn btn-sm btn-danger"
                            type="submit"
                            <?= $row['id']===(int)$_SESSION['user_id']?'disabled':'' ?>
                        >Delete</button>
                    </form>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
</div>

<?php
mysqli_free_result($result);
mysqli_close($link);
?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
