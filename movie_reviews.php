<?php
require_once __DIR__ . '/includes/init.php';   // starts the session once
// Redirect to login if the user is not authenticated
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}
require('includes/connect_db.php');



$user_id = $_SESSION['id'];

// Determine which view to show (default: all reviews)
$view = isset($_GET['view']) && $_GET['view'] === 'user' ? 'user' : 'all';

// Pagination settings
$reviewsPerPage = 10; // Number of reviews per page
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? intval($_GET['page']) : 1;
$offset = ($page - 1) * $reviewsPerPage;

// SQL Query
if ($view === 'user') {
    // User-specific reviews
    $q = "SELECT movie_reviews.review_id, movie_reviews.review_desc, movie_reviews.rating, movie_listings.movie_title, new_users.username, movie_reviews.id AS review_owner_id
          FROM movie_reviews
          INNER JOIN movie_listings ON movie_reviews.movie_id = movie_listings.movie_id
          INNER JOIN new_users ON movie_reviews.id = new_users.id
          WHERE movie_reviews.id = '$user_id'
          ORDER BY movie_reviews.review_id DESC
          LIMIT $reviewsPerPage OFFSET $offset";

    // Count total user reviews for pagination
    $qCount = "SELECT COUNT(*) AS total 
               FROM movie_reviews 
               WHERE movie_reviews.id = '$user_id'";
} else {
    // All reviews
    $q = "SELECT movie_reviews.review_id, movie_reviews.review_desc, movie_reviews.rating, movie_listings.movie_title, new_users.username, movie_reviews.id AS review_owner_id
          FROM movie_reviews
          INNER JOIN movie_listings ON movie_reviews.movie_id = movie_listings.movie_id
          INNER JOIN new_users ON movie_reviews.id = new_users.id
          ORDER BY movie_reviews.review_id DESC
          LIMIT $reviewsPerPage OFFSET $offset";

    // Count total reviews for pagination
    $qCount = "SELECT COUNT(*) AS total FROM movie_reviews";
}

// Execute the query
$r = mysqli_query($link, $q);
$rCount = mysqli_query($link, $qCount);
$rowCount = mysqli_fetch_assoc($rCount);
$totalReviews = $rowCount['total'];
$totalPages = ceil($totalReviews / $reviewsPerPage);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Reviews</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php include('includes/nav.php'); ?>

<div class="container mt-5">
    <h1 class="mb-4">Manage Reviews</h1>

    <!-- Toggle View Buttons -->
    <div class="mb-3">
        <a href="?view=all" class="btn btn-primary <?php echo ($view === 'all') ? 'active' : ''; ?>">Show All Reviews</a>
        <a href="?view=user" class="btn btn-secondary <?php echo ($view === 'user') ? 'active' : ''; ?>">Show My Reviews</a>
    </div>

    <?php if (mysqli_num_rows($r) > 0): ?>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>User</th>
                        <th>Movie Title</th>
                        <th>Review</th>
                        <th>Rating</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['username']); ?></td>
                            <td><?php echo htmlspecialchars($row['movie_title']); ?></td>
                            <td><?php echo htmlspecialchars($row['review_desc']); ?></td>
                            <td><?php echo htmlspecialchars($row['rating']); ?>/5</td>
                            <td>
                                <?php if ($row['review_owner_id'] == $user_id): ?>
                                    <!-- Delete Form -->
                                    <form action="manage_review.php" method="post" style="display:inline;">
                                        <input type="hidden" name="action" value="delete">
                                        <input type="hidden" name="review_id" value="<?php echo $row['review_id']; ?>">
                                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                    </form>
                                    <!-- Edit Button -->
                                    <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editModal<?php echo $row['review_id']; ?>">Edit</button>

                                    <!-- Edit Modal -->
                                    <div class="modal fade" id="editModal<?php echo $row['review_id']; ?>" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="editModalLabel">Edit Review for <?php echo htmlspecialchars($row['movie_title']); ?></h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <form action="manage_review.php" method="post">
                                                    <div class="modal-body">
                                                        <input type="hidden" name="action" value="update">
                                                        <input type="hidden" name="review_id" value="<?php echo $row['review_id']; ?>">
                                                        <div class="mb-3">
                                                            <label for="reviewDesc<?php echo $row['review_id']; ?>" class="form-label">Review</label>
                                                            <textarea class="form-control" id="reviewDesc<?php echo $row['review_id']; ?>" name="review_desc" rows="4" required><?php echo htmlspecialchars($row['review_desc']); ?></textarea>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="rating<?php echo $row['review_id']; ?>" class="form-label">Rating</label>
                                                            <select class="form-select" id="rating<?php echo $row['review_id']; ?>" name="rating" required>
                                                                <?php for ($i = 1; $i <= 5; $i++): ?>
                                                                    <option value="<?php echo $i; ?>" <?php echo ($i == $row['rating']) ? 'selected' : ''; ?>><?php echo $i; ?></option>
                                                                <?php endfor; ?>
                                                            </select>
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
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <nav>
            <ul class="pagination">
                <?php if ($page > 1): ?>
                    <li class="page-item">
                        <a class="page-link" href="?view=<?php echo $view; ?>&page=<?php echo $page - 1; ?>">&laquo; Previous</a>
                    </li>
                <?php endif; ?>

                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <li class="page-item <?php echo ($i == $page) ? 'active' : ''; ?>">
                        <a class="page-link" href="?view=<?php echo $view; ?>&page=<?php echo $i; ?>"><?php echo $i; ?></a>
                    </li>
                <?php endfor; ?>

                <?php if ($page < $totalPages): ?>
                    <li class="page-item">
                        <a class="page-link" href="?view=<?php echo $view; ?>&page=<?php echo $page + 1; ?>">Next &raquo;</a>
                    </li>
                <?php endif; ?>
            </ul>
        </nav>
    <?php else: ?>
        <p>No reviews found.</p>
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
