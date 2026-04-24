<?php
require_once __DIR__ . '/../../includes/init.php';

if (!isset($_SESSION['username']) || !isset($_SESSION['user_id'])) {
    header('Location: ' . BASE_URL . '/pages/auth/login.php');
    exit();
}

require_once ROOT_PATH . '/includes/connect_db.php';
$b      = BASE_URL;
$userId = (int) $_SESSION['user_id'];

$stmt = mysqli_prepare($link,
    "SELECT id, card_number, expiry_date, cardholder_name, cvv
     FROM credit_cards
     WHERE user_id = ?"
);
mysqli_stmt_bind_param($stmt, 'i', $userId);
mysqli_stmt_execute($stmt);
$r = mysqli_stmt_get_result($stmt);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include ROOT_PATH . '/includes/head.php'; ?>
    <title>View Credit Cards | GreenScore</title>
    <style>
        footer { background-color: #fff; }
    </style>
</head>
<body class="bg-page overlay-50"
      style="background-image: url('<?= $b ?>/assets/images/forest-money.jpg'); color: #333;">
<?php include ROOT_PATH . '/includes/nav.php'; ?>

<div class="container content-wrapper">
    <h2 class="text-white text-center mb-4">💳 Your Saved Credit Cards</h2>

    <?php if (mysqli_num_rows($r) > 0): ?>
        <div class="card card-bg shadow-sm p-4 mb-4">
            <div class="table-responsive">
                <table class="table table-striped align-middle mb-0">
                    <thead class="table-success">
                        <tr>
                            <th>Card Number</th><th>Expiry</th><th>CVV</th>
                            <th>Cardholder</th><th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)): ?>
                        <tr>
                            <td>**** **** **** <?= substr($row['card_number'], -4) ?></td>
                            <td><?= date("d/m/Y", strtotime($row['expiry_date'])) ?></td>
                            <td><?= htmlspecialchars($row['cvv']) ?></td>
                            <td><?= htmlspecialchars($row['cardholder_name']) ?></td>
                            <td class="d-flex gap-2">
                                <button class="btn btn-sm btn-danger"
                                        data-bs-toggle="modal"
                                        data-bs-target="#delModal<?= $row['id'] ?>">
                                    🗑 Delete
                                </button>
                                <button class="btn btn-sm btn-warning"
                                        data-bs-toggle="modal"
                                        data-bs-target="#editModal<?= $row['id'] ?>">
                                    ✏️ Edit
                                </button>

                                <!-- Delete Modal -->
                                <div class="modal fade" id="delModal<?= $row['id'] ?>" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <form action="<?= $b ?>/pages/user/manage_credit_card.php"
                                                  method="post">
                                                <input type="hidden" name="csrf_token"
                                                       value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">
                                                <input type="hidden" name="action" value="delete">
                                                <input type="hidden" name="card_id" value="<?= $row['id'] ?>">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Confirm Deletion</h5>
                                                    <button type="button" class="btn-close"
                                                            data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    Delete card ending in <?= substr($row['card_number'], -4) ?>?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Cancel</button>
                                                    <button type="submit"
                                                            class="btn btn-danger">Yes, Delete</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <!-- Edit Modal -->
                                <div class="modal fade" id="editModal<?= $row['id'] ?>" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <form action="<?= $b ?>/pages/user/manage_credit_card.php"
                                                  method="post">
                                                <input type="hidden" name="csrf_token"
                                                       value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">
                                                <input type="hidden" name="action" value="update">
                                                <input type="hidden" name="card_id" value="<?= $row['id'] ?>">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Edit Card</h5>
                                                    <button type="button" class="btn-close"
                                                            data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label class="form-label">Card Number</label>
                                                        <input type="text" class="form-control"
                                                               name="card_number"
                                                               value="<?= htmlspecialchars($row['card_number']) ?>"
                                                               required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Expiry Date</label>
                                                        <input type="date" class="form-control"
                                                               name="expiry_date"
                                                               value="<?= htmlspecialchars($row['expiry_date']) ?>"
                                                               required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">CVV</label>
                                                        <input type="text" class="form-control"
                                                               name="cvv"
                                                               value="<?= htmlspecialchars($row['cvv']) ?>"
                                                               required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Cardholder Name</label>
                                                        <input type="text" class="form-control"
                                                               name="card_name"
                                                               value="<?= htmlspecialchars($row['cardholder_name']) ?>"
                                                               required>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Cancel</button>
                                                    <button type="submit" class="btn btn-primary">
                                                        💾 Save Changes
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php else: ?>
        <div class="card card-bg shadow-sm p-5 text-center">
            <div style="font-size:3rem;">💳</div>
            <h4 class="mt-3 mb-2">No saved cards yet</h4>
            <p class="text-muted mb-4">Add a credit card from your profile to use for contributions.</p>
            <a href="<?= $b ?>/pages/user/user_account.php"
               class="btn btn-success px-4">👤 Go to My Profile</a>
        </div>
    <?php endif; ?>

    <div class="mt-4 text-center">
        <a href="<?= $b ?>/pages/user/user_account.php" class="btn btn-outline-light">
            ⬅ Back to My Profile
        </a>
    </div>
</div>

<?php include ROOT_PATH . '/includes/footer.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php
mysqli_stmt_close($stmt);
mysqli_close($link);
?>