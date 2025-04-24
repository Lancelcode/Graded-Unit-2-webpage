<?php
// includes/modals.php
// Just your two Bootstrap modals—no <html> or <body> tags

// Register Modal
?>
<div class="modal fade" id="registerModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form class="modal-content" action="register_action.php" method="POST">
            <div class="modal-header">
                <h5 class="modal-title">Register</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <label>Username:</label>
                <input type="text" name="username" class="form-control" required><br>

                <label>Email:</label>
                <input type="email" name="email" class="form-control" required><br>

                <label>Password:</label>
                <input type="password" name="pass1" class="form-control" required><br>

                <label>Confirm Password:</label>
                <input type="password" name="pass2" class="form-control" required><br>
            </div>
            <div class="modal-footer">
                <input type="submit" class="btn btn-success" value="Submit">
            </div>
        </form>
    </div>
</div>

<?php
// Login Modal
?>
<div class="modal fade" id="loginModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form class="modal-content" action="login_action.php" method="POST">
            <div class="modal-header">
                <h5 class="modal-title">Login</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <label>Email:</label>
                <input type="text" name="email" class="form-control" required><br>
                <label>Password:</label>
                <input type="password" name="password" class="form-control" required><br>
            </div>
            <div class="modal-footer">
                <input type="submit" class="btn btn-success" value="Login">
            </div>
        </form>
    </div>
</div>
