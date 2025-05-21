<?php
session_start();

require 'config.php';
include 'common_functions/functions.php';
mark_as_watched();
unmark_as_watched();
remove_watchlist();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MovieFlix - My Watchlist</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="./css/watchlist.css">
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
                <li><a href="./index.php" >Home</a></li>
                <li><a href="./sort/sorted.php">Movies</a></li>
                <?php if (isset($_SESSION['user_id'])): ?>
                <li><a href="user_area/profile.php">Profile</a></li>
                <?php else: ?>
                <li><a href="user_area/register.php">Register</a></li>
                <?php endif; ?>
                <li><a href="#">Contact</a></li>
                <?php if(isset($_SESSION['user_id'])): ?>
                <li><a href="./watchlist.php" class="active">Watchlist</a></li>
                <?php endif; ?>
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
                <?php if (isset($_SESSION['user_id'])): ?>
                <li><a href="./user_area/logout.php">Logout</a></li>
                <?php else: ?>
                <li><a href="./user_area/login.php">Login</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>

    <!-- Main Content -->
    <main class="watchlist-container">
        <div class="watchlist-header">
            <h2>My Watchlist</h2>
            <div class="watchlist-controls">
                <select class="sort-select">
                    <option value="date-added">Date Added</option>
                    <option value="title">Title</option>
                    <option value="rating">Rating</option>
                    <option value="release-date">Release Date</option>
                </select>
                <div class="view-toggle">
                    <button class="active"><i class="fas fa-th-large"></i></button>
                    <button><i class="fas fa-list"></i></button>
                </div>
            </div>
        </div>

        <?php 
$user_id = $_SESSION['user_id'];

// Общо филми
$total_movies_query = "SELECT COUNT(*) as total FROM watchlist WHERE user_id = ?";
$stmt_total = $pdo->prepare($total_movies_query);
$stmt_total->execute([$user_id]);
$total_movies = $stmt_total->fetch(PDO::FETCH_ASSOC);

// Гледани филми
$watched_query = "SELECT COUNT(*) as watched FROM watchlist WHERE user_id = ? AND is_watched = '1'";
$stmt_watched = $pdo->prepare($watched_query);
$stmt_watched->execute([$user_id]);
$watched_movies = $stmt_watched->fetch(PDO::FETCH_ASSOC);

// За гледане
$to_watch_query = "SELECT COUNT(*) as to_watch FROM watchlist WHERE user_id = ? AND is_watched = '0'";
$stmt_to_watch = $pdo->prepare($to_watch_query);
$stmt_to_watch->execute([$user_id]);
$to_watch_movies = $stmt_to_watch->fetch(PDO::FETCH_ASSOC);
?>

        <div class="watchlist-stats">
            <div class="stat-item">

                <span class="stat-number"><?php echo $total_movies['total']; ?></span>
                <span class="stat-label">Total Movies</span>
            </div>
            <div class="stat-item">
                <span class="stat-number"><?= $watched_movies['watched'] ?></span>
                <span class="stat-label">Watched</span>
            </div>
            <div class="stat-item">
                <span class="stat-number"><?= $to_watch_movies['to_watch'] ?></span>
                <span class="stat-label">To Watch</span>
            </div>
        </div>

        <?php 
        // Fetch watchlist items from the database
        $user_id = $_SESSION['user_id'];
        $watchlist_query = "SELECT 
                m.movie_id, 
                m.movie_title,
                m.movie_img,
                m.release_year,
                m.duration, 
                w.added_date,
                w.is_watched 
                FROM watchlist w 
                JOIN movie m ON w.movie_id = m.movie_id 
                WHERE w.user_id = ?";
        $stmt = $pdo->prepare($watchlist_query);
        $stmt->execute([$user_id]);
        ?>
        <div class="watchlist-grid">
            <!-- Watchlist Item -->
            <?php 
            $has_items = false;
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)): 
                $has_items = true;
            ?>
            <div class="watchlist-item">
                <div class="watchlist-item-poster">
                    <img src="./admin_area/uploads/<?php echo htmlspecialchars($row['movie_img']); ?>" alt="<?php echo htmlspecialchars($row['movie_title']); ?>">
                    <div class="watchlist-item-actions">
                        <button class="btn-watch"><a href="./movie_details.php?movie_id=<?php echo htmlspecialchars($row['movie_id']); ?>" style="color:white;"><i class="fas fa-play"></i></a></button>
                        <button class="btn-remove"><a href="watchlist.php?remove_watchlist=<?= htmlspecialchars($row['movie_id']) ?>"><i class="fas fa-trash" style="color:white;"></i></a></button>
                        <?php if($row['is_watched'] == '0'): ?>
                        <button class="btn-mark-watched" title="Mark as watched"><a href="watchlist.php?mark_as_watched=<?= htmlspecialchars($row['movie_id']) ?>" style="color:white;"><i class="fas fa-check"></i></a></button>
                        <?php else: ?>
                        <button class="btn-mark-watched" title="Unmark as watched"><a href="watchlist.php?unmark_as_watched=<?= htmlspecialchars($row['movie_id']) ?>" style="color:white;"><i class="fas fa-x" style="color:white;"></i></a></button>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="watchlist-item-info">
                    <h3><?php echo htmlspecialchars($row['movie_title']) ?></h3>
                    <div class="movie-meta">
                        <span class="rating"><i class="fas fa-star"></i> 4.5</span>
                        <span class="year"><?php echo htmlspecialchars($row['release_year']) ?></span>
                    </div>
                
                </div>
            </div>
                <?php endwhile; ?>
        </div>

        <?php if (!$has_items): ?>
        <div class="empty-watchlist">
            <i class="fas fa-film"></i>
            <h3>Your watchlist is empty</h3>
            <p>Start adding movies and shows you want to watch!</p>
            <a href="index.php" class="btn-primary" style="color:#e50914;">Browse Movies</a>
        </div>
        <?php endif; ?>




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