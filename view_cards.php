<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

# Redirect if not logged in.
if (!isset($_SESSION['id'])) {
    require('login_tools.php');
    load();
}

# Open database connection.
require('includes/connect_db.php');

# Retrieve the user's saved credit cards from the database.
$userId = $_SESSION['id'];
$q = "SELECT * FROM credit_cards WHERE user_id='$userId'";
$r = mysqli_query($link, $q);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Credit Cards</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php include('includes/nav.php'); ?>

<div class="container mt-5">
    <h1 class="mb-4">Your Saved Credit Cards</h1>

    <?php if (mysqli_num_rows($r) > 1): ?>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
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
                            <td>**** **** **** <?php echo substr($row['card_number'], -4); ?></td>
                            <td><?php echo date("d/m/Y", strtotime($row['expiry_date'])); ?></td>
                            <td><?php echo htmlspecialchars($row['cardholder_name']); ?></td>
                            <td>
                                <!-- Delete Form -->
                                <form action="manage_credit_card.php" method="post" style="display:inline;">
                                    <input type="hidden" name="action" value="delete">
                                    <input type="hidden" name="cardId" value="<?php echo $row['id']; ?>">
                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                </form>
                                <!-- Edit Button -->
                                <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editModal<?php echo $row['id']; ?>">Edit</button>

                                <!-- Edit Modal -->
                                <div class="modal fade" id="editModal<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editModalLabel">Edit Card Details</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <form action="manage_credit_card.php" method="post">
                                                <div class="modal-body">
                                                    <input type="hidden" name="action" value="update">
                                                    <input type="hidden" name="cardId" value="<?php echo $row['id']; ?>">
                                                    <div class="mb-3">
                                                        <label for="cardNumber<?php echo $row['id']; ?>" class="form-label">Card Number</label>
                                                        <input type="text" class="form-control" id="cardNumber<?php echo $row['id']; ?>" name="cardNumber" value="<?php echo htmlspecialchars($row['card_number']); ?>" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="expiryDate<?php echo $row['id']; ?>" class="form-label">Expiry Date</label>
                                                        <input type="date" class="form-control" id="expiryDate<?php echo $row['id']; ?>" name="expiryDate" value="<?php echo htmlspecialchars($row['expiry_date']); ?>" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="cardHolder<?php echo $row['id']; ?>" class="form-label">Cardholder Name</label>
                                                        <input type="text" class="form-control" id="cardHolder<?php echo $row['id']; ?>" name="cardHolder" value="<?php echo htmlspecialchars($row['cardholder_name']); ?>" required>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                    <button type="submit" class="btn btn-primary">Save Changes</button>
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
    <?php else: ?>
        <h3>No credit cards saved yet.</h3>
    <?php endif; ?>

    <a href="user_account.php" class="btn btn-secondary">Back to Account</a>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
<?php include('includes/footer.php'); ?>
</body>
</html>

<?php
# Close database connection.
mysqli_close($link);
?>
