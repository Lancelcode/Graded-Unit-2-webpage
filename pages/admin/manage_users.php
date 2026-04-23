<?php
require_once __DIR__ . '/../../includes/init.php';
require_once ROOT_PATH . '/includes/connect_db.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    http_response_code(403);
    die("<div class='container mt-5'>
           <div class='alert alert-danger'>Access denied. Admins only.</div>
         </div>");
}

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$b       = BASE_URL;
$error   = '';
$success = '';

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

if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'update_role') {
    if (!hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'] ?? '')) {
        die('Invalid CSRF token.');
    }
    $uid     = (int)($_POST['user_id'] ?? 0);
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

if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'update_status') {
    if (!hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'] ?? '')) {
        die('Invalid CSRF token.');
    }
    $uid       = (int)($_POST['user_id'] ?? 0);
    $allowed   = ['active', 'inactive', 'deactivated'];
    $newStatus = in_array($_POST['status'], $allowed) ? $_POST['status'] : 'active';
    $stmt      = mysqli_prepare($link, 'UPDATE new_users SET status = ? WHERE id = ?');
    mysqli_stmt_bind_param($stmt, 'si', $newStatus, $uid);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    $success = 'Status updated.';
}

$result = mysqli_query($link,
    'SELECT id, username, email, created_at, role, status FROM new_users ORDER BY username'
);
if (!$result) {
    die('Query error: ' . mysqli_error($link));
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include ROOT_PATH . '/includes/head.php'; ?>
    <title>Manage Users | GreenScore</title>
    <style>
        html, body { height: 100%; margin: 0; display: flex; flex-direction: column; }
        body {
            flex: 1;
            background: url('<?= $b ?>/assets/images/forest-hero.jpg') center/cover no-repeat fixed;
            position: relative;
        }
        body::before {
            content: ''; position: fixed; inset: 0;
            background: rgba(0,0,0,0.6); z-index: -1;
        }
        .content-wrapper {
            background: rgba(255,255,255,0.95); border-radius: 1rem;
            padding: 2rem; box-shadow: 0 0 12px rgba(0,0,0,0.2); margin-top: 4rem;
        }
        h2, h3 { color: #198754; }
        .fade-out { animation: fadeOut 1s ease-out forwards; }
        @keyframes fadeOut {
            to { opacity:0; height:0; padding:0; margin:0; overflow:hidden; }
        }
    </style>
</head>
<body>
<?php include ROOT_PATH . '/includes/nav.php'; ?>

<div class="container content-wrapper mt-5 p-4 bg-white rounded shadow">
    <h2 class="mb-4">👥 Manage Users</h2>

    <?php if ($error): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php elseif ($success): ?>
        <div class="alert alert-success fade-out"><?= htmlspecialchars($success) ?></div>
    <?php endif; ?>

    <?php
    function renderEditButton($id, $b) {
        return '<a href="' . $b . '/pages/admin/edit_user.php?id=' . $id
             . '" class="btn btn-sm btn-outline-secondary">✏️ Edit Details</a>';
    }

    function renderRoleStatusForms($row) {
        ob_start(); ?>
        <form method="post" class="d-inline-block me-2">
            <input type="hidden" name="csrf_token"
                   value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">
            <input type="hidden" name="action" value="update_role">
            <input type="hidden" name="user_id" value="<?= $row['id'] ?>">
            <select name="role" class="form-select form-select-sm d-inline-block w-auto">
                <option value="user"  <?= $row['role'] === 'user'  ? 'selected' : '' ?>>User</option>
                <option value="admin" <?= $row['role'] === 'admin' ? 'selected' : '' ?>>Admin</option>
            </select>
            <button class="btn btn-sm btn-outline-primary" type="submit">Save</button>
        </form>
        <form method="post" class="d-inline-block">
            <input type="hidden" name="csrf_token"
                   value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">
            <input type="hidden" name="action" value="update_status">
            <input type="hidden" name="user_id" value="<?= $row['id'] ?>">
            <select name="status" class="form-select form-select-sm d-inline-block w-auto">
                <option value="active"      <?= $row['status'] === 'active'      ? 'selected' : '' ?>>Active</option>
                <option value="inactive"    <?= $row['status'] === 'inactive'    ? 'selected' : '' ?>>Inactive</option>
                <option value="deactivated" <?= $row['status'] === 'deactivated' ? 'selected' : '' ?>>Deactivated</option>
            </select>
            <button class="btn btn-sm btn-outline-primary" type="submit">Save</button>
        </form>
        <?php return ob_get_clean();
    }

    $sections = [
        ['label' => '✅ Active Users',              'status' => 'active',      'head' => 'table-success', 'delete' => false],
        ['label' => '🕓 Inactive Users',            'status' => 'inactive',    'head' => 'table-warning', 'delete' => false],
        ['label' => '🗑️ Users Marked for Deletion', 'status' => 'deactivated', 'head' => 'table-danger',  'delete' => true ],
    ];

    foreach ($sections as $section):
        mysqli_data_seek($result, 0);
    ?>
    <h3 class="mt-4"><?= $section['label'] ?></h3>
    <div class="table-responsive">
        <table class="table table-hover align-middle bg-white rounded shadow-sm">
            <thead class="<?= $section['head'] ?>">
                <tr>
                    <th>Username</th><th>Email</th><th>Registered</th>
                    <th colspan="2">Role &amp; Status</th><th>Actions</th>
                </tr>
            </thead>
            <tbody>
            <?php while ($row = mysqli_fetch_assoc($result)):
                if ($row['status'] !== $section['status']) continue; ?>
                <tr id="user-row-<?= (int) $row['id'] ?>">
                    <td><?= htmlspecialchars($row['username']) ?></td>
                    <td><?= htmlspecialchars($row['email']) ?></td>
                    <td><?= date('d/m/Y', strtotime($row['created_at'])) ?></td>
                    <td colspan="2"><?= renderRoleStatusForms($row) ?></td>
                    <td>
                        <?= renderEditButton((int) $row['id'], $b) ?>
                        <?php if ($section['delete']): ?>
                        <form method="post" class="d-inline ms-2"
                              onsubmit="return deleteUser(this, <?= (int) $row['id'] ?>);">
                            <input type="hidden" name="csrf_token"
                                   value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">
                            <input type="hidden" name="action" value="delete">
                            <input type="hidden" name="user_id" value="<?= (int) $row['id'] ?>">
                            <button class="btn btn-sm btn-danger" type="submit">Delete</button>
                        </form>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endwhile; ?>
            </tbody>
        </table>
    </div>
    <?php endforeach; ?>
</div>

<?php include ROOT_PATH . '/includes/footer.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
function deleteUser(form, id) {
    if (!confirm('Permanently delete this user?')) return false;
    fetch(window.location.href, { method: 'POST', body: new FormData(form) })
        .then(() => {
            const row = document.getElementById('user-row-' + id);
            row.classList.add('fade-out');
            setTimeout(() => row.remove(), 1000);
        });
    return false;
}
</script>
</body>
</html>