<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
require_once __DIR__ . '/includes/init.php';

if (!isset($_SESSION['username']) || !isset($_SESSION['user_id'])) {
    require('includes/login_tools.php');
    load();
}

require_once __DIR__ . '/includes/connect_db.php';
$userId = $_SESSION['user_id'];

$q = "SELECT * FROM credit_cards WHERE user_id = ?";
$stmt = mysqli_prepare($link, $q);
mysqli_stmt_bind_param($stmt, 'i', $userId);
mysqli_stmt_execute($stmt);
$r = mysqli_stmt_get_result($stmt);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Credit Cards | GreenScore</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        html, body { height: 100%; margin: 0; }
        body {
            display: flex;
            flex-direction: column;
            background: url('assets/images/forest-money.jpg') center/cover no-repeat fixed;
            position: relative;
            color: #333;
        }
        body::before {
            content: '';
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.5);
            z-index: 0;
            pointer-events: none;
        }
        .content-wrapper {
            flex: 1;
            position: relative;
            z-index: auto;
            padding: 4rem 0;
        }
        .card-bg {
            background: rgba(255,255,255,0.85);
        }
        footer {
            position: relative;
            z-index: 1;
            background-color: #fff;
            padding: 2rem 0;
            width: 100%;
        }
    </style>
</head>
<body>

<?php include 'includes/nav.php'; ?>

<div class="container content-wrapper">
    <h2 class="text-white text-center mb-4">💳 Your Saved Credit Cards</h2>

    <?php if (mysqli_num_rows($r) > 0): ?>
        <div class="card card-bg shadow-sm p-4 mb-4">
            <div class="table-responsive">
                <table class="table table-striped align-middle mb-0">
                    <thead class="table-success">
                    <tr>
                        <th>Card Number</th>
                        <th>Expiry Date</th>
                        <th>CVV</th>
                        <th>Cardholder Name</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)): ?>
                        <tr>
                            <td>**** **** **** <?= substr($row['card_number'], -4); ?></td>
                            <td><?= date("d/m/Y", strtotime($row['expiry_date'])); ?></td>
                            <td><?= htmlspecialchars($row['cvv']); ?></td>
                            <td><?= htmlspecialchars($row['cardholder_name']); ?></td>
                            <td class="d-flex gap-2">
                                <!-- Delete Button triggers confirmation modal -->
                                <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal<?= $row['id']; ?>">🗑 Delete</button>

                                <!-- Edit Button -->
                                <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editModal<?= $row['id']; ?>">✏️ Edit</button>

                                <!-- Delete Modal -->
                                <div class="modal fade" id="confirmDeleteModal<?= $row['id']; ?>" tabindex="-1" aria-labelledby="confirmDeleteLabel<?= $row['id']; ?>" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <form action="manage_credit_card.php" method="post">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="confirmDeleteLabel<?= $row['id']; ?>">Confirm Deletion</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token']; ?>">
                                                    <input type="hidden" name="action" value="delete">
                                                    <input type="hidden" name="card_id" value="<?= $row['id']; ?>">
                                                    Are you sure you want to delete this card ending in <?= substr($row['card_number'], -4); ?>?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                    <button type="submit" class="btn btn-danger">Yes, Delete</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <!-- Edit Modal -->
                                <div class="modal fade" id="editModal<?= $row['id']; ?>" tabindex="-1" aria-labelledby="editModalLabel<?= $row['id']; ?>" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <form action="manage_credit_card.php" method="post">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="editModalLabel<?= $row['id']; ?>">Edit Card</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token']; ?>">
                                                    <input type="hidden" name="action" value="update">
                                                    <input type="hidden" name="card_id" value="<?= $row['id']; ?>">
                                                    <div class="mb-3">
                                                        <label for="cardNumber<?= $row['id']; ?>" class="form-label">Card Number</label>
                                                        <input type="text" class="form-control" name="card_number" id="cardNumber<?= $row['id']; ?>" value="<?= htmlspecialchars($row['card_number']); ?>" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="expiryDate<?= $row['id']; ?>" class="form-label">Expiry Date</label>
                                                        <input type="date" class="form-control" name="expiry_date" id="expiryDate<?= $row['id']; ?>" value="<?= htmlspecialchars($row['expiry_date']); ?>" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="cvv<?= $row['id']; ?>" class="form-label">CVV</label>
                                                        <input type="text" class="form-control" name="cvv" id="cvv<?= $row['id']; ?>" value="<?= htmlspecialchars($row['cvv']); ?>" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="cardHolder<?= $row['id']; ?>" class="form-label">Cardholder Name</label>
                                                        <input type="text" class="form-control" name="card_name" id="cardHolder<?= $row['id']; ?>" value="<?= htmlspecialchars($row['cardholder_name']); ?>" required>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                    <button type="submit" class="btn btn-primary">💾 Save Changes</button>
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
        <div class="alert alert-info card-bg shadow-sm">You have no saved credit cards yet. Add one in your profile.</div>
    <?php endif; ?>

    <div class="mt-4 text-center">
        <a href="user_account.php" class="btn btn-outline-light">⬅ Back to My Profile</a>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php
mysqli_stmt_close($stmt);
mysqli_close($link);
?>
