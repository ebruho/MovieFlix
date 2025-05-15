<?php

require 'config.php';

if (!isset($_GET['movie_id']) || !is_numeric($_GET['movie_id'])) {
    die("Invalid movie ID");
}
$movie_id = (int)$_GET['movie_id'];
?>
<?php
session_start();

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
                <li><a href="#">Movies</a></li>
                <?php if (isset($_SESSION['user_id'])): ?>
                <li><a href="user_area/profile.php">Profile</a></li>
                <?php else: ?>
                <li><a href="user_area/register.php">Register</a></li>
                <?php endif; ?>
                <li><a href="#">Contact</a></li>
                <?php if(isset($_SESSION['user_id'])): ?>
                <li><a href="#">Watchlist</a></li>
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
        <div class="video-section">
            <div class="video-player">
               

                <iframe 
                    id="moviePlayer"
                    src="https://www.youtube.com/embed/<?= $movie['movie_link'] ?>"
                    frameborder="0"
                    allowfullscreen
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                ></iframe>
                
                <!-- Custom Video Controls -->
                <!-- <div class="video-controls">
                    <div class="progress-container">
                        <div class="progress-bar">
                            <div class="progress"></div>
                        </div>
                        <div class="time-display">
                            <span class="current-time">0:00</span>
                            <span>/</span>
                            <span class="total-time">2:30:00</span>
                        </div>
                    </div>
                    <div class="controls-main">
                        <div class="controls-left">
                            <button class="play-pause">
                                <i class="fas fa-play"></i>
                            </button>
                            <button class="volume">
                                <i class="fas fa-volume-up"></i>
                            </button>
                            <input type="range" class="volume-slider" min="0" max="100" value="100">
                        </div>
                        <div class="controls-right">
                            <button class="quality">
                                <span>1080p</span>
                                <i class="fas fa-cog"></i>
                            </button>
                            <button class="fullscreen">
                                <i class="fas fa-expand"></i>
                            </button>
                        </div>
                    </div>
                </div> -->
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
                    <button class="btn-primary">
                        <i class="fas fa-plus"></i> Add to Watchlist
                    </button>
                    <!-- <button class="btn-secondary">
                        <i class="fas fa-share"></i> Share
                    </button> -->
                    <button class="btn-secondary">
                        <i class="fa-solid fa-arrow-left"></i> Back
                    </button>
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
            <img src="./images/default_actor.jpg" alt="<?= htmlspecialchars($member['actor_name']) ?>">
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

        <!-- <div class="next-up">
            <h3>Next Up</h3>
            <div class="next-episodes">
                <div class="episode-card">
                    <img src="https://via.placeholder.com/160x90" alt="Next Episode">
                    <div class="episode-info">
                        <h4>Next Movie Title</h4>
                        <p>Brief description of the next movie</p>
                    </div>
                </div>
            </div>
        </div> -->
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