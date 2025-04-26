<?php 
include "config.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MovieFlix - Find Your Next Movie</title>
    <link rel="stylesheet" href="style.css">
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
                <li><a href="./index.php" class="active">Home</a></li>
                <li><a href="#">Movies</a></li>
                <li><a href="#">Register</a></li>
                <li><a href="#">Contact</a></li>
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
            <ul class="nav-links">
                <li><a href="#" class="active">Login</a></li>
            </ul>
        </nav>
    </header>

    <!-- Main Content -->
    <main>
        <section class="hero">
            <h2>Discover Your Next Favorite Movie</h2>
            <p>Browse through thousands of movies and find the perfect one for your mood</p>
        </section>

        <section class="featured-movies">
            <h3>Featured Movies</h3>
            <div class="movie-grid">
                <!-- Movie cards will be added here -->

                <!-- <div class="movie-card">
                    <img src="./images/minecraft.jpeg" alt="Movie poster">
                    <div class="movie-info">
                        <h4>Movie Title</h4>
                        <span class="rating">⭐ 4.5</span>
                    </div>
                </div> -->

                <?php 
                    $movie_query="
                        SELECT
                            movie_id,
                            movie_title,
                            movie_img
                        FROM movie
                        ORDER BY random()
                        LIMIT 5 OFFSET 0

                    ";

                    $movie_stmt = $pdo->query($movie_query);
                    $movies = $movie_stmt->fetchAll(PDO::FETCH_ASSOC);
                ?>
                <?php foreach($movies as $movie): ?>
                <div class="movie-card">
                    <a href="movie_details.php?movie_id=<?php echo $movie['movie_id']; ?>">
                        <img src="./admin_area/uploads/<?php echo htmlspecialchars($movie['movie_img']); ?>" alt="Movie poster">
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