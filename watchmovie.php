<?php
session_start();

require 'config.php';

include 'common_functions/functions.php';



 add_watchlist();


if (!isset($_GET['movie_id']) || !is_numeric($_GET['movie_id'])) {
    die("Invalid movie ID");
}
$movie_id = (int)$_GET['movie_id'];
?>
<?php


   
   

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MovieFlix - Watch Movie</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="./css/watchmovie.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .watchlist-message {
    background-color: #f0f0f0;
    color: #222;
    border: 1px solid #444;
    padding: 10px 20px;
    margin: 10px 0;
    border-radius: 6px;
    font-weight: bold;
    text-align: center;
}
    body.dark-mode .watchlist-message {
    background-color: #222;
    color: #f0f0f0;
}
    </style>
</head>

<body class="dark-mode">
    <!-- Header -->
    <header>
        <nav class="navbar">
            <div class="logo">
                <h1>MovieFlix</h1>
            </div>
            <ul class="nav-links">
                <li><a href="index.php" class="active">Home</a></li>
                <li><a href="./sort/sorted.php">Movies</a></li>
                <?php if (isset($_SESSION['user_id'])): ?>
                <li><a href="user_area/profile.php">Profile</a></li>
                <?php else: ?>
                <li><a href="user_area/register.php">Register</a></li>
                <?php endif; ?>
                <li><a href="#">Contact</a></li>
                <?php if(isset($_SESSION['user_id'])): ?>
                <li><a href="./watchlist.php">Watchlist</a></li>
                <?php endif; ?>            </ul>
            <div class="nav-actions">
                <button class="theme-toggle">
                    <i class="fas fa-moon"></i>
                </button>
                
                <ul class="nav-links">
                    <?php if (isset($_SESSION['user_id'])): ?>
                    <li><a href="./user_area/logout.php">Logout</a></li>
                    <?php else: ?>
                    <li><a href="./user_area/login.php">Login</a></li>
                    <?php endif; ?>
            </ul>
        </nav>
    </header>
    <main class="movie-details">
        <?php 
            $sql_query = "SELECT 
                m.movie_title,
                m.movie_img,
                m.release_year,
                m.duration,
                m.movie_description,
                m.budget,
                m.movie_link,
                d.director_name,
                l.language_name
                FROM movie m
                LEFT JOIN director d ON m.director_id = d.director_id
                LEFT JOIN movielanguage l ON m.language_id = l.language_id
                WHERE m.movie_id = ?";

                $stmt = $pdo->prepare($sql_query);
                $stmt->execute([$movie_id]);
                $movie = $stmt->fetch(PDO::FETCH_ASSOC);

                if(!$movie){
                    die("Movie not found");
                }
        ?>
    <!-- Main Content -->
    <main class="watch-container">
                    <!-- Messages -->
             <?php if (isset($_SESSION['watchlist_message'])): ?>
            <div class="watchlist-message">
            <?= htmlspecialchars($_SESSION['watchlist_message']) ?>
            </div>
            <?php unset($_SESSION['watchlist_message']); ?>
            <?php endif; ?>
            
            <div class="video-section">
            <div class="video-player">
               

                <iframe 
                    id="moviePlayer"
                    src="https://www.youtube.com/embed/<?= $movie['movie_link'] ?>"
                    frameborder="0"
                    allowfullscreen
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                ></iframe>
                
               
            </div>
        </div>

        <div class="watch-content">
            <div class="movie-info-panel">
                <div class="movie-primary-info">
                    <h1>Movie Title</h1>
                    <div class="movie-meta">
                        <span class="rating">
                            <i class="fas fa-star"></i> 4.5
                        </span>
                        <span class="year"><?= $movie['release_year'] ?></span>
                        <span class="duration"><?= $movie['duration']?> min</span>
                        <span class="quality">HD</span>
                    </div>
                </div>

                <div class="action-buttons">
                    <?php if (isset($_SESSION['user_id'])): ?>
                    <a class="btn-primary" style="text-decoration:none; margin: 10px;" href="watchmovie.php?add_watchlist=<?= $movie_id ?>">
                        <i class="fas fa-plus"></i> Add to Watchlist
                    </a>
                    <?php else: ?>
                    <a class="btn-primary" style="text-decoration:none; margin: 10px;" href="user_area/login.php">
                        <i class="fas fa-plus"></i> Add to Watchlist
                    </a>
                    <?php endif; ?>
                    <!-- <button class="btn-secondary">
                        <i class="fas fa-share"></i> Share
                    </button> -->
                    <a class="btn btn-secondary" style="text-decoration:none;" href="movie_details.php?movie_id=<?= $movie_id ?>">
                        <i class="fa-solid fa-arrow-left"></i> Back
                    </a>
                </div>
            </div>




            <div class="tabs-container">
                <div class="tabs">
                    <button class="tab-btn active">About</button>
                    <!-- <button class="tab-btn">Episodes</button>
                    <button class="tab-btn">More Like This</button> -->
                </div>

                <div class="tab-content">
                    <div class="tab-pane active">
                        <h3>Synopsis</h3>
                        <p><?= $movie['movie_description']?></p>
                        
                        <h3>Cast & Crew</h3>
                        <?php
                        $cast_sql = "
                            SELECT a.actor_name, ch.character_name
                            FROM moviecharacter ch
                            JOIN actor a ON ch.actor_id = a.actor_id
                            WHERE ch.movie_id = ?";

                            $cast_stmt = $pdo->prepare($cast_sql);
                            $cast_stmt->execute([$movie_id]);
                            $cast = $cast_stmt->fetchAll(PDO::FETCH_ASSOC);
                            ?>

                            <div class="cast-list">
                                <?php foreach ($cast as $member): ?>
                                    <div class="cast-member">
                                        <!-- <img src="./images/default_actor.jpg" alt="<?= htmlspecialchars($member['actor_name']) ?>"> -->
                                        <div class="cast-info">
                                            <h4>Actor Name: <?= htmlspecialchars($member['actor_name']) ?></h4>
                                            <p>Character Name: <?= htmlspecialchars($member['character_name']) ?></p>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>

                            <!-- More cast members -->
                        </div>
                    </div>
                </div>
            </div>
        </div>

      
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