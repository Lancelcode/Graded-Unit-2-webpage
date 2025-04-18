<?php
$q = intval($_GET['q']);

# Open database connection.
require('includes/connect_db.php');
if (!$link) {
    die('Could not connect: ' . mysqli_error($link));
}
//change database name 
mysqli_select_db($link,"DATABASE NAME");
$sql="SELECT * FROM movie_listings WHERE movie_id = '".$q."'";
$result = mysqli_query($link,$sql);

echo "
	<div class=\"alert alert-dark\" role=\"alert\">
	<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">
    <span aria-hidden=\"true\">&times;</span>
  </button>
	
	
     ";
	 
while($row = mysqli_fetch_array($result)) {
    
	echo '<div class="container mt-5">
        <div class="row">
            <div class="col-md-4">
				<iframe class="embed-responsive-item" src='. $row['preview'].' 
					frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" 
					allowfullscreen>
				</iframe>
			 </div>
		<div class="col-md-8">
          <h1 class="display-4">'.$row['movie_title'].'</h1>
		  <p class="lead">Release Date:  '.$row['release'].'</p>
		  <p>Genre: '.$row['genre'].'</p>
		</div>
		 <p>'.$row['further_info'].'</p>
		
		<div class="col-sm-12 col-md-6">
		  <h4>Show Times</h4>
		  <div class="card-body">
            <h5 class="card-title">Screen:  '.$row['theatre'].'</h5>
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
		<hr>
		</div>
	</div>
</div>';
}


mysqli_close($link);
?>
