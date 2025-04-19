<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movie Details</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>

<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
# DISPLAY COMPLETE LOGGED IN PAGE.
# Access session.
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
} ;
/*/ Session timeout duration (5 minutes)
$timeout_duration = 300;

// Check if the user is inactive for the timeout duration
if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > $timeout_duration)) {
    session_unset(); // Unset session variables
    session_destroy(); // Destroy the session
    header('Location: login.php'); // Redirect to login page
    exit();
}

// Update last activity time
$_SESSION['last_activity'] = time(); */

# Redirect if not logged in.
if ( !isset( $_SESSION[ 'id' ] ) ) { require ( 'login_tools.php' ) ; load() ; }
# Get passed movie id and assign it to a variable.
if ( isset( $_GET['movie_id'] ) ) $movie_id = $_GET['movie_id'] ;
# Open database connection.
require('includes/connect_db.php');
# Retrieve selective movie data from 'movie_listings' database table.
$q = "SELECT * FROM movie_listings WHERE movie_id = $movie_id" ;
$r = mysqli_query( $link, $q ) ;
if ( mysqli_num_rows( $r ) == 0 )
{
                        $row = mysqli_fetch_array( $r, MYSQLI_ASSOC );

                        # Check if cart already contains one movie id.
                        if ( isset( $_SESSION['cart'][$movie_id] ) )
                        {
                    # Add one more booking if needed.
                            $_SESSION['cart'][$movie_id]['quantity']++;
                            echo '
                        <<div class="container mt-4">
                                <div class="header">
                                    <h1 class="display-4">' . $row['movie_title'] . '</h1>
                                    <h3 class="lead">Genre: ' . $row['genre'] . '</h3>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6 mb-4">
                                        <div class="video-embed">
                                            <iframe src="' . $row['preview'] . '" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 mb-4">
                                        <img src="' . $row['img'] . '" alt="Movie Poster" class="poster mb-3">
                                        <h3><strong>Release Date:</strong> ' . $row['release'] . '</h3>
                                        <h3><strong>Age Rating:</strong> <img src="' . $row['age_rating'] . '" alt="Age Rating" width="50"></h3>
                                        <h3><strong>Synopsis:</strong> ' . $row['further_info'] . '</h3>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="card">
                                            <div class="card-body">
                                                <h3 class="card-title">Show Times - ' . $row['theatre'] . '</h3>
                                                <div class="d-flex flex-wrap justify-content-between">
                                                    <a href="show1.php"><button type="button" class="btn btn-secondary">Book > ' . $row['show1'] . '</button></a>
                                                    <a href="show2.php"><button type="button" class="btn btn-secondary">Book > ' . $row['show2'] . '</button></a>
                                                    <a href="show3.php"><button type="button" class="btn btn-secondary">Book > ' . $row['show3'] . '</button></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                    </div>			
				</div>
				<hr>
			</div>
		</div>
		';
    }
    else
    {
        # Or add one of movie booking to the cart.
        $_SESSION['cart'][$movie_id]= array ( 'quantity' => 1, 'price' => $row['mov_price'] ) ;

        echo '
      <div class="container mt-5">
        <div class="row">
            <div class="col-md-4">
				<iframe class="embed-responsive-item" src='. $row['preview'].' 
					frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" 
					allowcreen>
				</iframe>
			 </div>
		<div class="col-md-8">
          <h1 class="display-4">'.$row['movie_title'].'</h1>
		  <h3 class="lead">Release Date:  '.$row['release'].'</h3>
		  <h3>Genre: '.$row['genre'].'</h3>
		</div>
			<div class="col-sm-12 col-md-4">
			<img src='. $row['age_rating'].' alt="Movie" width="50px">
				
				<h3>'.$row['further_info'].'</h3>
			</div>
			<div class="col-sm-12 col-md-6">
				<h4>Show Times</h4>
				<hr>
				
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">'.$row['theatre'].'</h5>
				  <a href="show1.php"> 
				    <button type="button" class="btn btn-secondary" role="button"> Book >  ' . $row['show1'] . ' </button>
				  </a>
				  <a href="show2.php"> 
				    <button type="button" class="btn btn-secondary" role="button"> Book >  ' . $row['show2'] . ' </button>
				  </a>
				  <a href="show3.php"> 
				    <button type="button" class="btn btn-secondary" role="button"> Book >  ' . $row['show3'] . ' </button>
				  </a>
				</div>
				</div>
				<hr>
			</div>
		</div>
		';
    }
}

# Close database connection.
mysqli_close($link);
?>
<!-- Bootstrap JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>