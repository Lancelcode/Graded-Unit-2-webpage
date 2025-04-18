<?php
// If this registration logic truly belongs in the nav, keep it here.
// Otherwise, move it to a dedicated "register.php" or similar.
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    require ('connect_db.php');

    $errors = array();

    // Check username
    if (empty($_POST['username'])) {
        $errors[] = 'Enter your name.'; 
    } else {
        $fn = mysqli_real_escape_string($link, trim($_POST['username']));
    }

    // Check email
    if (empty($_POST['email'])) {
        $errors[] = 'Enter your email address.'; 
    } else {
        $e = mysqli_real_escape_string($link, trim($_POST['email']));
    }

    // Check password
    if (!empty($_POST['pass1'])) {
        if ($_POST['pass1'] != $_POST['pass2']) {
            $errors[] = 'Passwords do not match.'; 
        } else {
            $p = mysqli_real_escape_string($link, trim($_POST['pass1']));
        }
    } else {
        $errors[] = 'Enter your password.';
    }

    // Check if email address already registered
    if (empty($errors)) {
        $q = "SELECT id FROM new_users WHERE email='$e'";
        $r = @mysqli_query($link, $q);
        if (mysqli_num_rows($r) != 0) {
            $errors[] = 'Email address already registered. 
            <a class="alert-link" href="Index.php">Sign In Now</a>';
        }
    }

    // On success, register user
    if (empty($errors)) {
        $q = "INSERT INTO new_users (username, email, password)
              VALUES ('$fn', '$e', SHA2('$p',256))";
        $r = @mysqli_query($link, $q);

        if ($r) {
            // Redirect to the index page after successful registration
            mysqli_close($link);
            header("Location: index.php");
            exit();
        }

        mysqli_close($link);
        exit();
    } else {
        echo '<h4>The following error(s) occurred:</h4>';
        foreach ($errors as $msg) {
            echo " - $msg<br>";
        }
        echo '<p>or please try again.</p><br>';
        mysqli_close($link);
    }
}
?>

<header class="sticky-header">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="index.php">I-Cinema</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" 
                data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" 
                aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mr-auto">
                <!-- HOME -->
                <li class="nav-item">
                    <a class="nav-link" href="index.php">
                        <span class="icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                 fill="currentColor" class="bi bi-house" viewBox="0 0 16 16">
                                <path d="M8.707 1.5a1 1 0 0 0-1.414 0L.646 8.146a.5.5 0 0 0 
                                         .708.708L2 8.207V13.5A1.5 1.5 0 0 0 
                                         3.5 15h9a1.5 1.5 0 0 0 
                                         1.5-1.5V8.207l.646.647a.5.5 0 0 0 
                                         .708-.708L13 5.793V2.5a.5.5 0 0 0
                                         -.5-.5h-1a.5.5 0 0 0-.5.5v1.293zM13 
                                         7.207V13.5a.5.5 0 0 1-.5.5h-9a.5.5 
                                         0 0 1-.5-.5V7.207l5-5z"/>
                            </svg>
                        </span> 
                        Home
                    </a>
                </li>

                <!-- MOVIES -->
                <li class="nav-item">
                    <a class="nav-link" href="movie.php">
                        <span class="icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                 fill="currentColor" class="bi bi-film" viewBox="0 0 16 16">
                                <path d="M0 1a1 1 0 0 1 1-1h14a1 1 0 0 1 
                                         1 1v14a1 1 0 0 1-1 1H1a1 1 0 0 
                                         1-1-1zm4 0v6h8V1zm8 8H4v6h8zM1 
                                         1v2h2V1zm2 3H1v2h2zM1 7v2h2V7zm2 
                                         3H1v2h2zm-2 3v2h2v-2zM15 
                                         1h-2v2h2zm-2 3v2h2V4zm2 
                                         3h-2v2h2zm-2 3v2h2v-2zm2 
                                         3h-2v2h2z"/>
                            </svg>
                        </span>
                        Movies
                    </a>
                </li>

                <!-- CART -->
                <li class="nav-item">
                    <a class="nav-link" href="booking.php">
                        <span class="icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                 fill="currentColor" class="bi bi-bookmark" viewBox="0 0 16 16">
                                <path d="M2 2a2 2 0 0 1 
                                         2-2h8a2 2 0 0 1 
                                         2 2v13.5a.5.5 0 0 1
                                         -.777.416L8 13.101l-5.223 
                                         2.815A.5.5 0 0 1 
                                         2 15.5zm2-1a1 1 0 0 0-1 1v12.566
                                         l4.723-2.482a.5.5 0 0 1 .554 0L13 
                                         14.566V2a1 1 0 0 0-1-1z"/>
                            </svg>
                        </span>
                        Cart
                    </a>
                </li>

                <!-- PROFILE -->
                <li class="nav-item">
                    <a class="nav-link" href="user_account.php">
                        <span class="icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                 fill="currentColor" class="bi bi-person-lines-fill" 
                                 viewBox="0 0 16 16">
                                <path d="M6 8a3 3 0 1 0 0-6 
                                         3 3 0 0 0 0 6m-5 6s-1 0-1-1 
                                         1-4 6-4 6 3 6 4-1 1-1 
                                         1zM11 3.5a.5.5 0 0 1 
                                         .5-.5h4a.5.5 0 0 1 0 
                                         1h-4a.5.5 0 0 1-.5-.5m.5 
                                         2.5a.5.5 0 0 0 0 1h4a.5.5 
                                         0 0 0 0-1zm2 3a.5.5 0 0 0 
                                         0 1h2a.5.5 0 0 0 0-1zm0 
                                         3a.5.5 0 0 0 0 1h2a.5.5 0 
                                         0 0 0-1z"/>
                            </svg>
                        </span>
                        Profile
                    </a>
                </li>

                <!-- LOGIN / LOGOUT LINKS DEPEND ON SESSION -->
                <?php if (isset($_SESSION['username'])): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">
                            <span class="icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" 
                                     height="16" fill="currentColor" class="bi bi-door-closed" 
                                     viewBox="0 0 16 16">
                                    <path d="M3 2a1 1 0 0 1 1-1h8a1 1 
                                             0 0 1 1 1v13h1.5a.5.5 
                                             0 0 1 0 1h-13a.5.5 
                                             0 0 1 0-1H3zm1 13h8V2H4z"/>
                                    <path d="M9 9a1 1 0 1 0 2 0 
                                             1 1 0 0 0-2 0"/>
                                </svg>
                            </span>
                            Logout
                        </a>
                    </li>
                <?php else: ?>
                    <!-- Trigger modals instead of direct links (if you prefer that flow) -->
                    <li class="nav-item">
                        <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#staticBackdrop2">
                            <span class="icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                     fill="currentColor" class="bi bi-door-open" 
                                     viewBox="0 0 16 16">
                                    <path d="M8.5 10c-.276 0-.5-.448-.5-1s.224-1 
                                             .5-1 .5.448.5 1-.224 1-.5 
                                             1"/>
                                    <path d="M10.828.122A.5.5 0 0 1 
                                             11 .5V1h.5A1.5 1.5 0 0 1 
                                             13 2.5V15h1.5a.5.5 0 0 1 
                                             0 1h-13a.5.5 0 0 1 
                                             0-1H3V1.5a.5.5 0 0 1 
                                             .43-.495l7-1a.5.5 0 0 1 
                                             .398.117M11.5 2H11v13h1V2.5
                                             a.5.5 0 0 0-.5-.5M4 
                                             1.934V15h6V1.077z"/>
                                </svg>
                            </span>
                            Login
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#staticBackdrop1">
                            <span class="icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" 
                                     fill="currentColor" class="bi bi-r-square" 
                                     viewBox="0 0 16 16">
                                    <path d="M5.5 4.002h3.11c1.71 0 2.741.973 
                                             2.741 2.46 0 1.138-.667 
                                             1.94-1.495 2.24L11.5 
                                             12H9.98L8.52 8.924H6.836V12H5.5
                                             zm1.335 1.09v2.777h1.549c.995 
                                             0 1.573-.463 1.573-1.36 
                                             0-.913-.596-1.417-1.537-1.417z"/>
                                    <path d="M0 2a2 2 0 0 1 2-2h12a2 2 0 0 1 
                                             2 2v12a2 2 0 0 1-2 
                                             2H2a2 2 0 0 1-2-2zm15 
                                             0a1 1 0 0 0-1-1H2a1 1 0 
                                             0 0-1 1v12a1 1 0 0 0 
                                             1 1h12a1 1 0 0 0 
                                             1-1z"/>
                                </svg>
                            </span>
                            Register
                        </a>
                    </li>
                <?php endif; ?>

                <!-- MORE DROPDOWN -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" 
                       role="button" data-toggle="dropdown" 
                       aria-haspopup="true" aria-expanded="false">
                        More
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="offers_and_codes.php">Offers & Codes</a>
                        <a class="dropdown-item" href="snack_mania.php">Snack-MANIA!</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="xtream_wonder.php">Xtream Wonder</a>
                    </div>
                </li>
            </ul>

            <!-- SEARCH FORM -->
            <form class="form-inline my-2 my-lg-0">
                <input class="form-control mr-sm-2" 
                       type="search" 
                       placeholder="Search" 
                       aria-label="Search">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">
                    Search
                </button>
            </form>
        </div>
    </nav>
</header>

<!-- ========== LOGIN MODAL ========== -->
<div class="modal fade" id="staticBackdrop2" data-bs-backdrop="static" 
     data-bs-keyboard="false" tabindex="-1" 
     aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
          <h1 class="modal-title fs-5" id="staticBackdropLabel">Login</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" 
                  aria-label="Close">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" 
                   fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">
                  <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 
                           7.293l5.146-5.147a.5.5 0 0 1 
                           .708.708L8.707 8l5.147 5.146a.5.5 
                           0 0 1-.708.708L8 8.707l-5.146 
                           5.147a.5.5 0 0 1-.708-.708L7.293 8z"/>
              </svg>
          </button>
      </div>
      <div class="modal-body">
        <form action="login_action.php" method="post">
            <label for="email">Email:</label><br>
            <input type="text" class="form-control" placeholder="Email" 
                   name="email" required>
            <br><br>

            <label for="password">Password:</label><br>
            <input type="password" class="form-control" placeholder="Password" 
                   name="password" required>
            <br><br>

            <input type="submit" value="Login">
        </form>
      </div>
    </div>
  </div>
</div>

<!-- ========== REGISTER MODAL ========== -->
<div class="modal fade" id="staticBackdrop1" data-bs-backdrop="static" 
     data-bs-keyboard="false" tabindex="-1" 
     aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
          <h1 class="modal-title fs-5" id="staticBackdropLabel">Register</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" 
                  aria-label="Close">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" 
                   fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">
                  <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 
                           7.293l5.146-5.147a.5.5 0 0 1 
                           .708.708L8.707 8l5.147 5.146a.5.5 
                           0 0 1-.708.708L8 8.707l-5.146 
                           5.147a.5.5 0 0 1-.708-.708L7.293 8z"/>
              </svg>
          </button>
      </div>
      <div class="modal-body">
        <!-- You can also post to a dedicated register_action.php if you like -->
        <form action="register.php" class="was-validated" method="post">
            <label for="username">Username:</label><br>
            <input type="text" 
                   name="username"
                   placeholder="Username"
                   class="form-control"
                   required>
            <br><br>

            <label for="email">Email:</label><br>
            <input type="email"
                   name="email"
                   class="form-control"
                   placeholder="Email"
                   required>
            <small id="emailHelp" class="form-text text-muted">
                We'll never share your email with anyone else.
            </small>
            <br><br>

            <label for="password">Password:</label><br>
            <input type="password"
                   name="pass1"
                   class="form-control"
                   placeholder="Create New Password"
                   required>
            <br><br>

            <label for="password">Confirm Password:</label><br>
            <input type="password"
                   name="pass2"
                   class="form-control"
                   placeholder="Confirm Password"
                   required>
            <br><br>

            <input type="submit" value="Submit">
        </form>
      </div>
    </div>
  </div>
</div>
