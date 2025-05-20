
<?php
include 'config.php';

session_start();

try {
    
    if (!isset($_SESSION['user_id'])) {
     die("Plese, enter in system, to add a movie to watchlist.");
    }

    $user_id = $_SESSION['user_id'];

     if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $action = isset($_POST['action']) ? $_POST['action'] : '';
        $movie_id = isset($_POST['movie_id']) ? $_POST['movie_id'] : null;

        //$action = $_POST['action'] ?? '';
        //$movie_id = $_POST['movie_id'] ?? null;
      }

      if ($action === 'add_watchlist' && $movie_id) {
            $check = $pdo->prepare("SELECT * FROM watchlist WHERE user_id = :user_id AND movie_id = :movie_id");
            $check->execute(['user_id' => $user_id, 'movie_id' => $movie_id]);

            if ($check->rowCount() === 0) {
                $insert = $pdo->prepare("INSERT INTO watchlist (movie_id, user_id,) VALUES (:movie_id, :user_id,NOW(),FALSE)");
                $insert->execute(['user_id' => $user_id, 'movie_id' => $movie_id]);
            }
        }

        if ($action === 'remove' && $movie_id) {
            $delete = $pdo->prepare("DELETE FROM watchlist WHERE user_id = :user_id AND movie_id = :movie_id");
            $delete->execute(['user_id' => $user_id, 'movie_id' => $movie_id]);
        }

        if ($action === 'mark_watched' && $movie_id) {
            $update = $pdo->prepare("UPDATE watchlist SET is_watched = TRUE WHERE user_id = :user_id AND movie_id = :movie_id");
            $update->execute(['user_id' => $user_id, 'movie_id' => $movie_id]);
        }
    

      
     $stmt = $pdo->prepare("
        SELECT m.movie_id, m.movie_title, m.movie_img, r.rating_num, m.release_year, w.is_watched
        FROM watchlist w
        JOIN movie m ON w.movie_id = m.movie_id
        JOIN rating r ON r.movie_id = m.movie_id
        WHERE w.user_id = :user_id
    ");
    $stmt->execute(['user_id' => $user_id]);
    $movies = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Статистика
   $statsStmt = $pdo->prepare("
    SELECT
        COUNT(*) AS total,
        COUNT(*) FILTER (WHERE is_watched = TRUE) AS watched,
        COUNT(*) FILTER (WHERE is_watched = FALSE) AS to_watch
    FROM watchlist
    WHERE user_id = :user_id
");
$statsStmt->execute(['user_id' => $user_id]);
$stats = $statsStmt->fetch(PDO::FETCH_ASSOC);


} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
    die();
}
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
                <li><a href="#" class="active">Home</a></li>
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

        <div class="watchlist-stats">
            <div class="stat-item">
                <span class="stat-number"><?= $stats['total'] ?></span>
                <span class="stat-label">Total Movies</span>
            </div>
            <div class="stat-item">
                <span class="stat-number"><?= $stats['watched'] ?></span>
                <span class="stat-label">Watched</span>
            </div>
            <div class="stat-item">
                <span class="stat-number"><?= $stats['to_watch'] ?></span>
                <span class="stat-label">To Watch</span>
            </div>
        </div>

     <div class="watchlist-grid">
       <?php foreach ($movies as $movie): ?>
        <div class="watchlist-item <?= $movie['is_watched'] ? 'watched' : '' ?>">
            <div class="watchlist-item-poster">
                <img src="<?= htmlspecialchars($movie['movie_img']) ?>" alt="<?= htmlspecialchars($movie['movie_title']) ?>">
                <div class="watchlist-item-actions">
                    <!-- Play button -->
                    <button class="btn-watch"><i class="fas fa-play"></i></button>

                    <!-- Remove -->
                    <form method="POST" action="watchlist.php" style="display:inline;">
                        <input type="hidden" name="action" value="remove">
                        <input type="hidden" name="movie_id" value="<?= $movie['movie_id'] ?>">
                        <button class="btn-remove" type="submit"><i class="fas fa-trash"></i></button>
                    </form>

                    <!-- Mark as watched -->
                    <?php if (!$movie['is_watched']): ?>
                        <form method="POST" action="watchlist.php" style="display:inline;">
                            <input type="hidden" name="action" value="mark_watched">
                            <input type="hidden" name="movie_id" value="<?= $movie['movie_id'] ?>">
                            <button class="btn-mark-watched" type="submit"><i class="fas fa-check"></i></button>
                        </form>
                    <?php endif; ?>
                </div>
            </div>
            <div class="watchlist-item-info">
                <h3><?= htmlspecialchars($movie['movie_title']) ?></h3>
                <div class="movie-meta">
                    <span class="rating"><i class="fas fa-star"></i> <?= htmlspecialchars($movie['rating_num']) ?></span>
                    <span class="year"><?= htmlspecialchars($movie['release_year']) ?></span>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
   </div>

 <div class="empty-watchlist" style="display: none;">
            <i class="fas fa-film"></i>
            <h3>Your watchlist is empty</h3>
            <p>Start adding movies and shows you want to watch!</p>
            <a href="index.html" class="btn-primary">Browse Movies</a>
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