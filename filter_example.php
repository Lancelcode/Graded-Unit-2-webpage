<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">

    <title>Movie Search and Filter</title>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const genreFilter = document.getElementById('genre-filter');
            const sortFilter = document.getElementById('sort-filter');
            const orderFilter = document.getElementById('order-filter');
            const movieCards = document.querySelectorAll('.movie-card');

            genreFilter.addEventListener('change', () => filterMovies());
            sortFilter.addEventListener('change', () => sortMovies());
            orderFilter.addEventListener('change', () => sortMovies());

            function filterMovies() {
                const selectedGenre = genreFilter.value.toLowerCase();
                movieCards.forEach(card => {
                    const cardGenre = card.dataset.genre.toLowerCase();
                    card.style.display = (selectedGenre === 'all' || cardGenre === selectedGenre) ? '' : 'none';
                });
            }

            function sortMovies() {
                const sortValue = sortFilter.value;
                const orderValue = orderFilter.value;
                const grid = document.querySelector('.movie-grid');
                const cards = Array.from(movieCards);

                // Mapping for PG rating values
                const pgMapping = {
                    'G': 0,
                    'PG': 1,
                    'PG-13': 2,
                    'R': 3,
                    'NC-17': 4
                };

                // Sorting logic
                cards.sort((a, b) => {
                    let comparison = 0;

                    if (sortValue === 'release_date') {
                        comparison = new Date(a.dataset.release) - new Date(b.dataset.release);
                    } else if (sortValue === 'alphabetical') {
                        const titleA = a.dataset.movieTitle.toLowerCase();
                        const titleB = b.dataset.movieTitle.toLowerCase();
                        comparison = titleA.localeCompare(titleB);
                    } else if (sortValue === 'pg_rating') {
                        const ratingA = pgMapping[a.dataset.ageRating] || 5; // Default to 5 if no match
                        const ratingB = pgMapping[b.dataset.ageRating] || 5;
                        comparison = ratingA - ratingB;
                    }

                    // Apply ascending or descending order
                    return orderValue === 'desc' ? -comparison : comparison;
                });

                // Reattach sorted cards to the grid
                cards.forEach(card => grid.appendChild(card));
            }
        });
    </script>
  </head>
  
  <body>
  
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="#">Movie Search and Filter</a>
    <form class="form-inline my-2 my-lg-0">
        <!-- Genre Filter -->
        <select class="form-control" id="genre-filter">
            <option value="all">All Genres</option>
            <option value="action">Action</option>
            <option value="comedy">Comedy</option>
            <option value="drama">Drama</option>
            <option value="sci-fi">Sci-Fi</option>
        </select>

        <!-- Sort Filter -->
        <select class="form-control ml-2" id="sort-filter">
            <option value="release_date">Release Date</option>
            <option value="alphabetical">Alphabetical</option>
            <option value="pg_rating">PG Rating</option>
        </select>

        <!-- Order Filter -->
        <select class="form-control ml-2" id="order-filter">
            <option value="asc">Ascending</option>
            <option value="desc">Descending</option>
        </select>
    </form>
  </nav>

  <div class="container mt-4">
      <div class="movie-grid row">
          <?php
          require('connect_db.php');
          $q = "SELECT * FROM movie_listings";
          $r = mysqli_query($link, $q);

          if (mysqli_num_rows($r) > 0) {
              while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
                  echo '
                  <div class="movie-card col-md-4 mb-3" 
                       data-genre="' . $row['genre'] . '" 
                       data-release="' . $row['release'] . '" 
                       data-movie-title="' . $row['movie_title'] . '" 
                       data-age-rating="' . $row['age_rating'] . '">
                      <div class="card">
                          <img src="' . $row['poster_url'] . '" class="card-img-top" alt="Poster">
                          <div class="card-body">
                              <h5 class="card-title">' . $row['movie_title'] . '</h5>
                              <p class="card-text">Genre: ' . $row['genre'] . '</p>
                              <p class="card-text">Release Date: ' . $row['release'] . '</p>
                              <p class="card-text">Age Rating: ' . $row['age_rating'] . '</p>
                          </div>
                      </div>
                  </div>';
              }
          }
          mysqli_close($link);
          ?>
      </div>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>
