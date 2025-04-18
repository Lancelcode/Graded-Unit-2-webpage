<?php
# Open database connection.
require('includes/connect_db.php');
# Retrieve movies from 'movie_listing' database table.
$q = "SELECT * FROM movie_listings" ;
$r = mysqli_query( $link, $q ) ;
if ( mysqli_num_rows( $r ) > 0 )
{
    # Display body section.

    while ( $row = mysqli_fetch_array( $r, MYSQLI_ASSOC ))
    {
        echo '
	
        <div class="col-md-3 d-flex justify-content-center">
        <div class="card" style="width: 18rem;">
        <div class="card text-center">
                        
        <img src='. $row['img'].' alt="Movie" class="img-thumbnail bg-secondary">
        <h5 class="card-title">'. $row['movie_title'].'</h5>
        <a href="movie.php?id='.$row['movie_id'].'" class="btn btn-secondary btn-block" role="button">
            Book Now</a>
        </div>
        </div>
        </div>  
	';
    }
    # Close database connection.
    mysqli_close( $link) ;
}
# Or display message.
else { echo '<p>There are currently no movies showing.</p>
	' ; }
?>
