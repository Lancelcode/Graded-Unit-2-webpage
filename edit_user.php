<?php
require_once 'includes/init.php';
require_once 'includes/connect_db.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    die('Access denied.');
}

$user_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($user_id <= 0) {
    die('Invalid user ID.');
}

// Fetch user details
$stmt = mysqli_prepare($link, "SELECT username, email, role, status, company_name, contact_person, phone_number FROM new_users WHERE id = ?");
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $username, $email, $role, $status, $company, $contact, $phone);
if (!mysqli_stmt_fetch($stmt)) {
    mysqli_stmt_close($stmt);
    die('User not found.');
}
mysqli_stmt_close($stmt);

$error = '';
$success = '';

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'] ?? '')) {
        die('Invalid CSRF token.');
    }

    $new_username = trim($_POST['username'] ?? '');
    $new_email = trim($_POST['email'] ?? '');
    $new_company = trim($_POST['company_name'] ?? '');
    $new_contact = trim($_POST['contact_person'] ?? '');
    $new_phone = trim($_POST['phone_number'] ?? '');
    $new_role = ($_POST['role'] === 'admin') ? 'admin' : 'user';
    $allowed_statuses = ['active', 'inactive', 'deactivated'];
    $new_status = in_array($_POST['status'], $allowed_statuses) ? $_POST['status'] : 'active';

    if ($new_username && $new_email) {
        $stmt = mysqli_prepare($link, "UPDATE new_users SET username = ?, email = ?, role = ?, status = ?, company_name = ?, contact_person = ?, phone_number = ? WHERE id = ?");
        mysqli_stmt_bind_param($stmt, "sssssssi", $new_username, $new_email, $new_role, $new_status, $new_company, $new_contact, $new_phone, $user_id);
        if (mysqli_stmt_execute($stmt)) {
            $success = "User updated successfully.";
            $username = $new_username;
            $email = $new_email;
            $role = $new_role;
            $status = $new_status;
            $company = $new_company;
            $contact = $new_contact;
            $phone = $new_phone;
        } else {
            $error = "Failed to update user.";
        }
        mysqli_stmt_close($stmt);
    } else {
        $error = "Username and email cannot be empty.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit User | GreenScore</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
    <style>
        html, body {
            height: 100%;
            margin: 0;
            display: flex;
            flex-direction: column;
        }

        body {
            flex: 1;
            background: url('assets/images/forest-hero.jpg') center/cover no-repeat fixed;
            position: relative;
        }

        main {
            flex: 1;
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
<body class="bg-light">
<?php include 'includes/nav.php'; ?>

<div class="container mt-5">
    <div class="card p-4 shadow">
        <h2>Edit User</h2>

        <?php if ($error): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
        <?php elseif ($success): ?>
            <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
        <?php endif; ?>

        <form method="post" class="mt-4">
            <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">

            <div class="mb-3">
                <label for="username" class="form-label">Username:</label>
                <input type="text" name="username" id="username" class="form-control" value="<?= htmlspecialchars($username) ?>" required>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email:</label>
                <input type="email" name="email" id="email" class="form-control" value="<?= htmlspecialchars($email) ?>" required>
            </div>

            <div class="mb-3">
                <label for="company_name" class="form-label">Company Name:</label>
                <input type="text" name="company_name" id="company_name" class="form-control" value="<?= htmlspecialchars($company ?? '') ?>">
            </div>

            <div class="mb-3">
                <label for="contact_person" class="form-label">Contact Person:</label>
                <input type="text" name="contact_person" id="contact_person" class="form-control" value="<?= htmlspecialchars($contact ?? '') ?>">
            </div>

            <div class="mb-3">
                <label for="phone_number" class="form-label">Phone Number:</label>
                <input type="text" name="phone_number" id="phone_number" class="form-control" value="<?= htmlspecialchars($phone ?? '') ?>">
            </div>

            <div class="mb-3">
                <label for="role" class="form-label">Role:</label>
                <select name="role" id="role" class="form-select">
                    <option value="user" <?= $role === 'user' ? 'selected' : '' ?>>User</option>
                    <option value="admin" <?= $role === 'admin' ? 'selected' : '' ?>>Admin</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="status" class="form-label">Status:</label>
                <select name="status" id="status" class="form-select">
                    <option value="active" <?= $status === 'active' ? 'selected' : '' ?>>Active</option>
                    <option value="inactive" <?= $status === 'inactive' ? 'selected' : '' ?>>Inactive</option>
                    <option value="deactivated" <?= $status === 'deactivated' ? 'selected' : '' ?>>Deactivated</option>
                </select>
            </div>

            <div class="d-flex justify-content-between">
                <a href="manage_users.php" class="btn btn-secondary">Back</a>
                <button type="submit" class="btn btn-success">Update User</button>
            </div>
        </form>
    </div>
</div>
<?php include 'includes/footer.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
