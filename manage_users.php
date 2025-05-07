<?php
require_once 'includes/init.php';
require_once 'includes/connect_db.php';

// Ensure CSRF token
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$error = '';
$success = '';

// Handle deletes
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

// Handle role updates
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

// Handle status updates
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'update_status') {
    if (!hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'] ?? '')) {
        die('Invalid CSRF token.');
    }
    $uid = (int)($_POST['user_id'] ?? 0);
    $allowed = ['active', 'inactive', 'deactivated'];
    $newStatus = in_array($_POST['status'], $allowed) ? $_POST['status'] : 'active';
    $stmt = mysqli_prepare($link, 'UPDATE new_users SET status = ? WHERE id = ?');
    mysqli_stmt_bind_param($stmt, 'si', $newStatus, $uid);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    $success = 'Status updated.';
}

// Fetch users
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
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
    <style>
        html, body {
            height: 100%;
            margin: 0;
        }
        body {
            background: url('assets/images/forest-hero.jpg') center/cover no-repeat fixed;
            position: relative;
        }
        body::before {
            content: '';
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.6);
            z-index: -1;
        }
        .content-wrapper {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 1rem;
            padding: 2rem;
            box-shadow: 0 0 12px rgba(0, 0, 0, 0.2);
            margin-top: 4rem;
        }
        h2, h3 {
            color: #198754;
        }
        .inline {
            display: inline-block;
        }
        .fade-out {
            animation: fadeOut 1s ease-out forwards;
        }
        @keyframes fadeOut {
            to {
                opacity: 0;
                height: 0;
                padding: 0;
                margin: 0;
                overflow: hidden;
            }
        }
        .deactivated-table, .inactive-table {
            margin-top: 3rem;
        }
    </style>
</head>
<body>
<?php include 'includes/nav.php'; ?>

<div class="container content-wrapper">
    <h2 class="mb-4">👥 Manage Users</h2>

    <?php if ($error): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php elseif ($success): ?>
        <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
    <?php endif; ?>

    <div class="table-responsive">
        <table class="table table-hover align-middle bg-white rounded shadow-sm">
            <thead class="table-success">
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
            <?php mysqli_data_seek($result, 0); while ($row = mysqli_fetch_assoc($result)): ?>
                <?php if ($row['status'] === 'active'): ?>
                    <tr id="user-row-<?= $row['id'] ?>">
                        <td><?= htmlspecialchars($row['username']) ?></td>
                        <td><?= htmlspecialchars($row['email']) ?></td>
                        <td><?= date('d/m/Y', strtotime($row['created_at'])) ?></td>
                        <td>
                            <form method="post" class="inline">
                                <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                                <input type="hidden" name="action" value="update_role">
                                <input type="hidden" name="user_id" value="<?= $row['id'] ?>">
                                <select name="role" class="form-select form-select-sm d-inline-block">
                                    <option value="user" <?= $row['role'] === 'user' ? 'selected' : '' ?>>User</option>
                                    <option value="admin" <?= $row['role'] === 'admin' ? 'selected' : '' ?>>Admin</option>
                                </select>
                                <button class="btn btn-sm btn-outline-primary" type="submit">Save</button>
                            </form>
                        </td>
                        <td>
                            <form method="post" class="inline">
                                <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                                <input type="hidden" name="action" value="update_status">
                                <input type="hidden" name="user_id" value="<?= $row['id'] ?>">
                                <select name="status" class="form-select form-select-sm d-inline-block">
                                    <option value="active" <?= $row['status'] === 'active' ? 'selected' : '' ?>>Active</option>
                                    <option value="inactive" <?= $row['status'] === 'inactive' ? 'selected' : '' ?>>Inactive</option>
                                    <option value="deactivated" <?= $row['status'] === 'deactivated' ? 'selected' : '' ?>>Deactivated</option>
                                </select>
                                <button class="btn btn-sm btn-outline-primary" type="submit">Save</button>
                            </form>
                        </td>
                        <td>
                            <form method="post" class="inline" onsubmit="return deleteUser(this, <?= $row['id'] ?>);">
                                <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="user_id" value="<?= $row['id'] ?>">
                                <button class="btn btn-sm btn-danger" type="submit" <?= $row['id'] === (int)$_SESSION['user_id'] ? 'disabled' : '' ?>>Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endif; ?>
            <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <!-- Inactive Users Section -->
    <h3 class="mt-5 text-warning">🕓 Inactive Users</h3>
    <div class="table-responsive inactive-table">
        <table class="table table-hover align-middle bg-white rounded shadow-sm">
            <thead class="table-warning">
            <tr>
                <th>Username</th>
                <th>Email</th>
                <th>Registered</th>
                <th>Status</th>
            </tr>
            </thead>
            <tbody>
            <?php mysqli_data_seek($result, 0); while ($row = mysqli_fetch_assoc($result)): ?>
                <?php if ($row['status'] === 'inactive'): ?>
                    <tr id="user-row-<?= $row['id'] ?>">
                        <td><?= htmlspecialchars($row['username']) ?></td>
                        <td><?= htmlspecialchars($row['email']) ?></td>
                        <td><?= date('d/m/Y', strtotime($row['created_at'])) ?></td>
                        <td>
                            <form method="post" class="inline">
                                <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                                <input type="hidden" name="action" value="update_status">
                                <input type="hidden" name="user_id" value="<?= $row['id'] ?>">
                                <select name="status" class="form-select form-select-sm d-inline-block">
                                    <option value="active">Active</option>
                                    <option value="inactive" selected>Inactive</option>
                                    <option value="deactivated">Deactivated</option>
                                </select>
                                <button class="btn btn-sm btn-outline-primary" type="submit">Save</button>
                            </form>
                        </td>
                    </tr>
                <?php endif; ?>
            <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <!-- Deactivated Users Section -->
    <h3 class="mt-5 text-danger">🗑️ Users Marked for Deletion</h3>
    <div class="table-responsive deactivated-table">
        <table class="table table-hover align-middle bg-white rounded shadow-sm">
            <thead class="table-danger">
            <tr>
                <th>Username</th>
                <th>Email</th>
                <th>Registered</th>
                <th>Status</th>
                <th>Delete Permanently</th>
            </tr>
            </thead>
            <tbody>
            <?php mysqli_data_seek($result, 0); while ($row = mysqli_fetch_assoc($result)): ?>
                <?php if ($row['status'] === 'deactivated'): ?>
                    <tr id="user-row-<?= $row['id'] ?>">
                        <td><?= htmlspecialchars($row['username']) ?></td>
                        <td><?= htmlspecialchars($row['email']) ?></td>
                        <td><?= date('d/m/Y', strtotime($row['created_at'])) ?></td>
                        <td>
                            <form method="post" class="inline">
                                <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                                <input type="hidden" name="action" value="update_status">
                                <input type="hidden" name="user_id" value="<?= $row['id'] ?>">
                                <select name="status" class="form-select form-select-sm d-inline-block">
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
                                    <option value="deactivated" selected>Deactivated</option>
                                </select>
                                <button class="btn btn-sm btn-outline-primary" type="submit">Save</button>
                            </form>
                        </td>
                        <td>
                            <form method="post" class="inline" onsubmit="return deleteUser(this, <?= $row['id'] ?>);">
                                <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="user_id" value="<?= $row['id'] ?>">
                                <button class="btn btn-sm btn-danger" type="submit">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endif; ?>
            <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function deleteUser(form, id) {
        fetch(window.location.href, {
            method: 'POST',
            body: new FormData(form)
        }).then(() => {
            const row = document.getElementById('user-row-' + id);
            row.classList.add('fade-out');
            setTimeout(() => row.remove(), 1000);
        });
        return false;
    }
</script>
</body>
</html>