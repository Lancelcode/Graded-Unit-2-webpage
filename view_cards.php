<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
require_once __DIR__ . '/includes/init.php';

if (!isset($_SESSION['username']) || !isset($_SESSION['id'])) {
    require('login_tools.php');
    load();
}

require('includes/connect_db.php');

$userId = $_SESSION['id'];
$q = "SELECT * FROM credit_cards WHERE user_id='$userId'";
$r = mysqli_query($link, $q);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Credit Cards | GreenScore</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
</head>
<body>
<?php include('includes/nav.php'); ?>

<div class="container mt-5">
    <h2 class="text-success mb-4">💳 Your Saved Credit Cards</h2>

    <?php if (mysqli_num_rows($r) > 0): ?>
        <div class="table-responsive card shadow-sm p-4">
            <table class="table table-striped align-middle">
                <thead class="table-success">
                <tr>
                    <th>Card Number</th>
                    <th>Expiry Date</th>
                    <th>Cardholder Name</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                <?php while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)): ?>
                    <tr>
                        <td>**** **** **** <?= substr($row['card_number'], -4); ?></td>
                        <td><?= date("d/m/Y", strtotime($row['expiry_date'])); ?></td>
                        <td><?= htmlspecialchars($row['cardholder_name']); ?></td>
                        <td>
                            <!-- Delete -->
                            <form action="manage_credit_card.php" method="post" class="d-inline">
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="cardId" value="<?= $row['id']; ?>">
                                <button type="submit" class="btn btn-sm btn-danger">🗑 Delete</button>
                            </form>

                            <!-- Edit Trigger -->
                            <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editModal<?= $row['id']; ?>">✏️ Edit</button>

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
                                                <input type="hidden" name="action" value="update">
                                                <input type="hidden" name="cardId" value="<?= $row['id']; ?>">

                                                <div class="mb-3">
                                                    <label for="cardNumber<?= $row['id']; ?>" class="form-label">Card Number</label>
                                                    <input type="text" class="form-control" name="cardNumber" id="cardNumber<?= $row['id']; ?>" value="<?= htmlspecialchars($row['card_number']); ?>" required>
                                                </div>

                                                <div class="mb-3">
                                                    <label for="expiryDate<?= $row['id']; ?>" class="form-label">Expiry Date</label>
                                                    <input type="date" class="form-control" name="expiryDate" id="expiryDate<?= $row['id']; ?>" value="<?= htmlspecialchars($row['expiry_date']); ?>" required>
                                                </div>

                                                <div class="mb-3">
                                                    <label for="cardHolder<?= $row['id']; ?>" class="form-label">Cardholder Name</label>
                                                    <input type="text" class="form-control" name="cardHolder" id="cardHolder<?= $row['id']; ?>" value="<?= htmlspecialchars($row['cardholder_name']); ?>" required>
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
                            <!-- End Edit Modal -->
                        </td>
                    </tr>
                <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div class="alert alert-info">You have no saved credit cards yet. You can add one in your profile.</div>
    <?php endif; ?>

    <div class="mt-4">
        <a href="user_account.php" class="btn btn-outline-secondary">⬅ Back to My Profile</a>
    </div>
</div>

<?php include('includes/footer.php'); ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php mysqli_close($link); ?>
