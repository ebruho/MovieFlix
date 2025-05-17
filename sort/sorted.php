<?php 
include "../config.php";
?>
<?php
session_start();?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MovieFlix - Movies</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="../css/sort_movie.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body class="dark-mode">
    <!-- Header -->
    <header>
        <nav class="navbar">
            <div class="logo">
                <h1>MovieFlix</h1>
            </div>
            <ul class="nav-links">
                <li><a href="../index.php" class="active">Home</a></li>
                <li><a href="sort/sort_movies.html">Movies</a></li>
                <li><a href="#">TV Shows</a></li>
                <li><a href="#">Watchlist</a></li>
            </ul>
            <div class="nav-actions">
                <button class="theme-toggle">
                    <i class="fas fa-moon"></i>
                </button>
                <div class="search-bar">
                    <form action="">
                        <input type="text" placeholder="Search movies...">
                        <button><i class="fas fa-search"></i></button>
                    </form>
                </div>
            </div>
        </nav>
    </header>

    <!-- Main Content -->
    <main>
        <!-- <section class="hero">
            <h2>Discover Your Next Favorite Movie</h2>
            <p>Browse through thousands of movies and find the perfect one for your mood</p>
        </section> -->
        <section class="featured-movies">
            <h3>Featured Movies</h3>
            
            
                <!-- Movie cards will be added here -->
                
                
                    
                      <!-- <input class="form-check-input me-1" name="sortMovie[]" type="checkbox" value="actors">
                      Actors<br>
                      <input class="form-check-input me-1" name="sortMovie[]" type="checkbox" value="names">
                      Names<br>
                      <input class="form-check-input me-1" name="sortMovie[]" type="checkbox" value="director">
                      Director<br>
                      <input class="form-check-input me-1" name="sortMovie[]" type="checkbox" value="rating">
                      Ratings<br>
                      <input class="form-check-input me-1" name="sortMovie[]" type="checkbox" value="genre">
                      Genre<br></label> -->
                    
                    
                    <!-- <label class="list-group-item">
                      <input class="form-check-input me-1" type="checkbox" value="actors">
                      Actors
                    </label><br>
                    <label class="list-group-item">
                      <input class="form-check-input me-1" type="checkbox" value="names">
                      Names
                    </label>
                    <label class="list-group-item">
                      <input class="form-check-input me-1" type="checkbox" value="director">
                      Director
                    </label><br>
                    <label class="list-group-item">
                      
                    </label> -->
                    
                  </div>
                  <div class="row mx-0">
                    <div class="col-lg-3"><div class="accordion">
                        <div class="list-group">
                                        <div class="section">
                                        <a class="section-title" href="#accordion-1" style="text-decoration: none;">Actors</a>
                                        <div id="accordion-1" class="section-content">
                                        <p><form method="POST" action="#">
<?php


$showTableGenre="SELECT actor_name FROM actor ORDER BY actor_name";
    $movie_stmt2=$pdo->query($showTableGenre);
    $movies2 = $movie_stmt2->fetchAll(PDO::FETCH_ASSOC);
        foreach($movies2 as $movie2){
            $string=$movie2['actor_name'];
            //$string=trim($string);
            echo "<input class='form-check-input me-1' name='sortActor[]' type='checkbox' value='$string'>";
            echo $movie2['actor_name'];echo "<br>";
        }?>
                                        </div><!-- section-content end -->
                                        <a class="section-title" href="#accordion-1" style="text-decoration: none;">Name</a>
                                        <div id="accordion-1" class="section-content">
                                        <p>
                                            <input class="form-check-input me-1" name="sortName[]" type="radio" value="A-Z">
                                            From A-Z<br>
                                            <input class="form-check-input me-1" name="sortName[]" type="radio" value="Z-A">
                                            From Z-A<br></p>
                                        </div>
                                        <a class="section-title" href="#accordion-1" style="text-decoration: none;">Rating</a>
                                        <div id="accordion-1" class="section-content">
                                        <p>
                                            <input class="form-check-input me-1" name="sortRating[]" type="radio" value="years">
                                            1 Star<br>
                                            <input class="form-check-input me-1" name="sortRating[]" type="radio" value="years">
                                            2 Stars<br>
                                        <input class="form-check-input me-1" name="sortRating[]" type="radio" value="years">
                                            3 Stars<br>
                                            <input class="form-check-input me-1" name="sortRating[]" type="radio" value="years">
                                            4 Stars<br>
                                            <input class="form-check-input me-1" name="sortRating[]" type="radio" value="years">
                                            5 Stars<br></p>
                                        </div>
                                        <!--</div> section end -->
                                        <a class="section-title" href="#accordion-1">Year</a>
                                        <div id="accordion-1" class="section-content">
                                        <p>
                                        <?php


$showTableGenre="SELECT DISTINCT release_year FROM movie";
    $movie_stmt2=$pdo->query($showTableGenre);
    $movies2 = $movie_stmt2->fetchAll(PDO::FETCH_ASSOC);
        foreach($movies2 as $movie2){
            $string=$movie2['release_year'];
            echo "<input class='form-check-input me-1' name='sortYear[]' type='checkbox' value='$string'>";
            echo $movie2['release_year'];echo "<br>";
        }?></p>
                                        </div><!-- section-content end -->
                                        <!-- </div>section end -->
                                        <a class="section-title" href="#accordion-1">Genre</a>
                                        <div id="accordion-1" class="section-content">
                                        <p>
<?php


$showTableGenre="SELECT * FROM genre ORDER BY genre_name";
    $movie_stmt2=$pdo->query($showTableGenre);
    $movies2 = $movie_stmt2->fetchAll(PDO::FETCH_ASSOC);
        foreach($movies2 as $movie2){
            $string=$movie2['genre_name'];
            echo "<input class='form-check-input me-1' name='sortGenre[]' type='checkbox' value='$string'>";
            echo $movie2['genre_name'];echo "<br>";
        }?>
                                        
                                            <!-- <input class="form-check-input me-1" name="sortActor[]" type="checkbox" value="years">
                                            Comedy<br>
                                            <input class="form-check-input me-1" name="sortActor[]" type="checkbox" value="years">
                                            Crime<br>
                                            <input class="form-check-input me-1" name="sortActor[]" type="checkbox" value="years">
                                            Drama<br></p> -->
                                        </div><!-- section-content end -->
                                        </div><!-- section end -->
                                         <input type="submit"name="submit"value="Sort"></form> </div>
                                        </div><!-- accordion end --></div>
                    <div class="col-lg-9"><div class="movie-grid">
</html>

                <?php 
$join="";         
$order=""; 
$where="";     
if (isset($_POST['submit'])) {
    if (isset($_POST['sortName'])) {
        $sort=$_POST['sortName'];
        foreach ($sort as $key => $value) {
            if ($value=="A-Z"){
                $order="ORDER BY movie.movie_title ASC";
            }
            elseif ($value=="Z-A") {
                $order="ORDER BY movie.movie_title DESC";
            }
        }
    }
    if (isset($_POST['sortActor'])) {
        $sort1=$_POST['sortActor'];
        $flag=false;
        $join=$join."INNER JOIN moviecharacter ON movie.movie_id=moviecharacter.movie_id
        INNER JOIN actor ON moviecharacter.actor_id=actor.actor_id ";
        if ($where!="") {
            $where=$where." OR actor.actor_name IN(";
            $flag=true;
        }
        foreach ($sort1 as $key => $value) {
        
        if ($flag==false) {
           if ($where=="") {
            $where=$where."WHERE actor.actor_name IN(";
        }
        else{
            $where=$where.", ";
        } 
        }
        
        $where=$where."'$value'";
        $flag=false;
    }$where=$where.")";
    }
    if (isset($_POST['sortYear'])) {
        $sort=$_POST['sortYear'];
        $flag=false;
        if ($where!="") {
            $where=$where." OR movie.release_year IN(";
            $flag=true;
        }
        foreach ($sort as $key => $value) {
        // $join="INNER JOIN moviecharacter ON movie.movie_id=moviecharacter.movie_id
        // INNER JOIN actor ON moviecharacter.actor_id=actor.actor_id";
        // echo $value;
        if ($flag==false) {
           if ($where=="") {
            $where=$where."WHERE movie.release_year IN(";
        }
        else{
            $where=$where.", ";
        } 
        }
        
        $where=$where."'$value'";
        $flag=false;
    }$where=$where.")";
    }
    if (isset($_POST['sortGenre'])) {
        $sort=$_POST['sortGenre'];
        $flag=false;
        $join=$join."INNER JOIN moviegenre ON movie.movie_id=moviegenre.movie_id
         INNER JOIN genre ON moviegenre.genre_id=genre.genre_id ";
        if ($where!="") {
            $where=$where." OR genre.genre_name IN(";
            $flag=true;
        }
        foreach ($sort as $key => $value) {
        
        // echo $value;
        if ($flag==false) {
           if ($where=="") {
            $where=$where."WHERE genre.genre_name IN(";
        }
        else{
            $where=$where.", ";
        } 
        }
        
        $where=$where."'$value'";
        $flag=false;
    }$where=$where.")";
    }
}
$movie_query="
                        SELECT DISTINCT
                            movie.movie_id,
                            movie.movie_title,
                            movie.movie_img
                        FROM movie
                        $join
                        $where
                        $order
                        LIMIT 8 OFFSET 0
                    "; 

//echo $movie_query;

// $stmt = $pdo->query("SELECT  FROM ");
//     $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

// // Извеждаме резултатите в HTML таблица
//     if ($results) {
//         echo "<table border='1'>";
//         // Извеждаме заглавния ред (имена на колоните)
//         echo "<tr>";
//         foreach (array_keys($results[0]) as $column) {
//             echo "<th>" . htmlspecialchars($column) . "</th>";
//         }
//         echo "</tr>";

//         // Извеждаме данните
//         foreach ($results as $row) {
//             echo "<tr>";
//             foreach ($row as $cell) {
//                 echo "<td>" . htmlspecialchars($cell) . "</td>";
//             }
//             echo "</tr>";
//         }
//         echo "</table>";
//     } else {
//         echo "Няма намерени резултати.";
//     }




                    $movie_stmt = $pdo->query($movie_query);
                    $movies = $movie_stmt->fetchAll(PDO::FETCH_ASSOC);
                ?>
                <?php foreach($movies as $movie): ?>
                <div class="movie-card">
                    <a href="../movie_details.php?movie_id=<?php echo $movie['movie_id']; ?>">
                        <img src="../admin_area/uploads/<?php echo htmlspecialchars($movie['movie_img']); ?>" alt="Movie poster">
                    </a>
                    <div class="movie-info">
                        <h4><?php echo htmlspecialchars($movie['movie_title']); ?></h4>
                        <span class="rating">⭐ 4.5</span>
                    </div>
                </div>
                <?php endforeach; ?>


                <!--  more movie cards -->
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer>
        <div class="footer-content">
            <div class="footer-section">
                <h4>About MovieFlix</h4>
                <p>Your ultimate destination for movie discovery and selection.</p>
            </div>
            <div class="footer-section">
                <h4>Quick Links</h4>
                <ul>
                    <li><a href="#">About Us</a></li>
                    <li><a href="#">Contact</a></li>
                    <li><a href="#">Privacy Policy</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <h4>Connect With Us</h4>
                <div class="social-links">
                    <a href="#"><i class="fab fa-facebook"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2024 MovieFlix. All rights reserved.</p>
        </div>
    </footer>
    <script src="script.js"></script>
</body>

</html>