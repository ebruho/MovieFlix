<?php

 session_start();
// Проверка дали потребителят е влязъл в системата
require 'config.php';

include 'common_functions/functions.php';

add_watchlist_details();
// Проверка дали е зададен ID на филма и дали е валиден

if (!isset($_GET['movie_id']) || !is_numeric($_GET['movie_id'])) {
    die("Invalid movie ID");
}
$movie_id = (int)$_GET['movie_id'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MovieFlix - Movie Details</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="./css/movie_details.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"> -->
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

.btn-primary, .btn-secondary {
    padding: 0.8rem 1.5rem;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-weight: bold;
}

.btn-primary {
    background-color: var(--primary-color);
    color: white;
    text-decoration: none;
}

.btn-secondary {
    background-color: rgba(0, 0, 0, 0.1);
    color: var(--text-dark);
    text-decoration: none;
}

body.dark-mode .btn-secondary {
    background-color: rgba(255, 255, 255, 0.1);
    color: var(--text-light);
}

.btn-warning{
    padding: 1rem;
    background-color: gold;
    border: none;
    cursor: pointer;
    font-weight: bold;
    border-radius: 3px;
}

.back-btn{
    color: #e50914;background: rgba(229, 9, 20, 0.2);

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
    <main class="movie-details">
            <!-- Messages -->
             <?php if (isset($_SESSION['watchlist_message'])): ?>
            <div class="watchlist-message">
            <?= htmlspecialchars($_SESSION['watchlist_message']) ?>
            </div>
            <?php unset($_SESSION['watchlist_message']); ?>
            <?php endif; ?>
        <?php 
            $sql_query = "SELECT 
                m.movie_title,
                m.movie_img,
                m.release_year,
                m.duration,
                m.movie_description,
                m.budget,
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
        <div class="movie-header">
            <div class="movie-backdrop"></div>
            <div class="movie-header-content">
                <div class="movie-poster">
                    <img src="./admin_area/uploads/<?=htmlspecialchars($movie['movie_img']); ?>" alt="Movie Poster">
                </div>
                <div class="movie-info">
                    <h1><?=htmlspecialchars($movie['movie_title']); ?> (<?=htmlspecialchars(date("Y", strtotime($movie['release_year']))); ?>)</h1>
                    <div class="movie-meta">
                        <span class="rating">
                            <i class="fas fa-star"></i>
                            4.5/5
                        </span>
                        <span class="duration">
                            <i class="fas fa-clock"></i>
                            <?= htmlspecialchars($movie['duration']) ?> min
                        </span>
                        <?php
                            $genre_sql = "
                                SELECT g.genre_name
                                FROM moviegenre mg
                                JOIN genre g ON mg.genre_id = g.genre_id
                                WHERE mg.movie_id = ?";

                            $genre_stmt = $pdo->prepare($genre_sql);
                            $genre_stmt->execute([$movie_id]);
                            $genres = $genre_stmt->fetchAll(PDO::FETCH_COLUMN);
                        ?>

                        <span class="genre">
                            <?= implode(', ', $genres) ?>
                        </span>
                    </div>
                    <div class="action-buttons">
                        <a class="btn-primary" href="watchmovie.php?movie_id=<?= $movie_id ?>" style="text-decoration:none;">                     
                            <i class="fas fa-play"></i> Watch Now    
                        </a>
                        <?php if (isset($_SESSION['user_id'])): ?>
                        <a name="add_watchlist" class="btn-secondary" href="movie_details.php?add_watchlist=<?= $movie_id ?>" style="text-decoration:none;">
                            <i class="fas fa-plus"></i> Add to Watchlist
                        </a>
                        <?php else: ?>
                        <a class="btn-secondary" href="user_area/login.php" style="text-decoration:none;">
                            <i class="fas fa-plus"></i> Add to Watchlist
                        </a>
                        <?php endif; ?>

                      
<?php if (isset($_SESSION['user_id'])): ?>
    <button class="btn btn-warning" id="openRatingModal">
        <i class="fas fa-star me-2"></i> Rate Movie
    </button>
<?php else: ?>
    <a class="btn btn-warning" href="./user_area/login.php" style="text-decoration:none; color:black;">
        <i class="fas fa-star me-2"></i> Rate Movie
    </a>
<?php endif; ?>

                        <a class="btn-secondary back-btn" href="index.php" style="text-decoration:none;">
                            <i class="fa-solid fa-arrow-left"></i> Back
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="movie-content">
            <section class="synopsis">
                <h2>Synopsis</h2>
                <p><?= nl2br(htmlspecialchars($movie['movie_description'])) ?></p>
            </section>

            <section class="cast">
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

                <h2>Cast & Crew</h2>
                <div class="cast-grid">
                    <?php foreach ($cast as $member): ?>
                    <div class="cast-member">
                        <!-- <img src="./images/default_actor.jpg" alt="<?= htmlspecialchars($member['actor_name']) ?>"> -->
                        <h3><?= htmlspecialchars($member['actor_name']) ?></h3>
                        <p><?= htmlspecialchars($member['character_name']) ?></p>
                    </div>
                    <?php endforeach; ?>
                </div>

            </section>

            <section class="details">
                <h2>Movie Details</h2>
                <div class="details-grid">
                    <div class="detail-item">
                        <h3>Release Year</h3>
                        <p><?=htmlspecialchars(date("Y", strtotime($movie['release_year']))); ?></p>
                    </div>
                    <div class="detail-item">
                        <h3>Director</h3>
                        <p><?= htmlspecialchars($movie['director_name']) ?></p>
                    </div>
                    <div class="detail-item">
                        <h3>Language</h3>
                        <p><?= htmlspecialchars($movie['language_name']) ?></p>
                    </div>
                    <div class="detail-item">
                        <h3>Budget</h3>
                        <p>$<?= number_format($movie['budget']) ?></p>
                    </div>
                </div>
            </section>

            <section class="comment">
                <h2>Comments</h2>
                <div class="comment-grid">
                    <?php
                        $rate_sql="SELECT * FROM rating
                        INNER JOIN movie ON rating.movie_id=movie.movie_id
                        WHERE rating.movie_id=$movie_id";
                        $comment_stmt = $pdo->query($rate_sql);
                        $comment = $comment_stmt->fetchAll(PDO::FETCH_ASSOC);
                        if($comment==null){echo "<h3>There are no comments yet</h3>";}
                        else{
                            echo "<div class='comment-item'></div>";
                        }
                        ?>
                    
                        
                        <!-- 
                        <p><?= htmlspecialchars($movie['language_name']) ?></p> -->
                    
                    </div>
                    </section>

            <?php 
                    $movie_query="
                        SELECT
                            movie_id,
                            movie_title,
                            movie_img
                        FROM movie
                        ORDER BY random()
                        LIMIT 4 OFFSET 0

                    ";

                    $movie_stmt = $pdo->query($movie_query);
                    $movies = $movie_stmt->fetchAll(PDO::FETCH_ASSOC);
                ?>
            <section class="similar-movies">
                <h2>Similar Movies</h2>
                <div class="movie-grid">
                    <?php foreach ($movies as $movie) {
                        # code...
                    ?>
                    <div class="movie-card">
                        <a href="movie_details.php?movie_id=<?= htmlspecialchars($movie['movie_id']) ?>">
                            <img src="./admin_area/uploads/<?= $movie['movie_img'];?>" alt="Similar Movie">
                        </a>
                        <div class="movie-info">
                            <h4><?= htmlspecialchars($movie['movie_title']);?></h4>
                            <span class="rating">⭐<?= number_format(rand(3,5) + rand(0,9)/10, 1) ?></span>
                        </div>
                    </div>
                    <?php } ?>
                    <!-- <div class="movie-card">
                        <img src="./images/gundi.jpeg" alt="Similar Movie">
                        <div class="movie-info">
                            <h4>Similar Movie 2</h4>
                            <span class="rating">⭐ 4.1</span>
                        </div>
                    </div>
                    <div class="movie-card">
                        <img src="./images/minecraft.jpeg" alt="Similar Movie">
                        <div class="movie-info">
                            <h4>Similar Movie 3</h4>
                            <span class="rating">⭐ 4.4</span>
                        </div>
                    </div> -->
                </div>
            </section>
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Smooth scroll
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    e.preventDefault();
                    document.querySelector(this.getAttribute('href')).scrollIntoView({
                        behavior: 'smooth'
                    });
                });
            });

            // Tooltip init (ако все още използваш Bootstrap за други неща)
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });

            // Rating Modal Logic
            const modal = document.getElementById('ratingModal');
            const openBtn = document.getElementById('openRatingModal'); // Използвай само тази дефиниция
            const closeBtn = document.getElementById('closeModal');
            const submitBtn = document.getElementById('submitRating');
            const starsContainer = document.getElementById('starsContainer');
            const ratingValue = document.getElementById('ratingValue');
            const reviewText = document.getElementById('reviewText');

            let currentRating = 0;

            // Open modal
            if (openBtn) {
                openBtn.addEventListener('click', function () {
                    modal.style.display = 'flex';
                    document.body.style.overflow = 'hidden';
                });
            }



            // Close modal
            function closeModal() {
                modal.style.display = 'none';
                document.body.style.overflow = '';
            }

            closeBtn.addEventListener('click', closeModal);

            window.addEventListener('click', function (e) {
                if (e.target === modal) {
                    closeModal();
                }
            });

            submitBtn.addEventListener('click', function () {
                if (currentRating === 0) {
                    alert('Please select a rating before submitting!');
                    return;
                }

                const review = reviewText.value;
                alert(`Thanks for your ${currentRating}-star rating!`);
                return currentRating;
                // Log or send to backend
                console.log('Rating:', currentRating);
                console.log('Review:', review);
                
                currentRating = 0;
                updateStars(0);
                ratingValue.textContent = '0';
                reviewText.value = '';

                closeModal();
            });


            // Star rating click
            starsContainer.addEventListener('click', function (e) {
                if (e.target.classList.contains('star')) {
                    const rating = parseInt(e.target.dataset.rating);
                    currentRating = rating;
                    updateStars(rating);
                    ratingValue.textContent = rating;
                }
            });

            // Hover effect
            starsContainer.addEventListener('mouseover', function (e) {
                if (e.target.classList.contains('star')) {
                    const rating = parseInt(e.target.dataset.rating);
                    highlightStars(rating);
                }
            });

            starsContainer.addEventListener('mouseleave', function () {
                highlightStars(currentRating);
            });

            // Update stars visual
            function updateStars(rating) {
                const stars = starsContainer.querySelectorAll('.star');
                stars.forEach((star, index) => {
                    if (index < rating) {
                        star.classList.remove('far');
                        star.classList.add('fas');
                    } else {
                        star.classList.remove('fas');
                        star.classList.add('far');
                    }
                });
            }

            // Highlight stars on hover
            function highlightStars(rating) {
                const stars = starsContainer.querySelectorAll('.star');
                stars.forEach((star, index) => {
                    if (index < rating) {
                        star.classList.remove('far');
                        star.classList.add('fas');
                    } else {
                        star.classList.remove('fas');
                        star.classList.add('far');
                    }
                });
            }

            // Submit Rating
            // submitBtn.addEventListener('click', function () {
            //     if (currentRating === 0) {
            //         alert('Please select a rating before submitting!');
            //         return;
            //     }

            //     const review = reviewText.value;
            //     alert(`Thanks for your ${currentRating}-star rating!`);

            //     // Log or send to backend
            //     console.log('Rating:', currentRating);
            //     console.log('Review:', review);

            //     // Reset
            //     currentRating = 0;
            //     updateStars(0);
            //     ratingValue.textContent = '0';
            //     reviewText.value = '';

            //     // Close modal
            //     modal.style.display = 'none';
            // });
        });
    </script>


    <!-- Rating Modal -->
    <!-- Custom Modal -->
    <div id="ratingModal" class="custom-modal">
        <div class="custom-modal-content">
            <span class="close-modal" id="closeModal">&times;</span>
            <h2>Rate this Movie</h2><form method="POST" action="#">
            <div class="stars-container" id="starsContainer">
                <input type="hidden" id="1" value="1"><i class="far fa-star fa-2x star" data-rating="1"></i>
                <input type="hidden" id="2" value="2"><i class="far fa-star fa-2x star" data-rating="2"></i>
                <input type="hidden" id="rate[]" value="3"><i class="far fa-star fa-2x star" data-rating="3"></i>
                <input type="hidden" id="rate[]" value="4"><i class="far fa-star fa-2x star" data-rating="4"></i>
                <input type="hidden" id="rate[]" value="5"><i class="far fa-star fa-2x star" data-rating="5"></i>
            </div>
            
            <div class="rating-value mt-2">Selected Rating: <span id="ratingValue">0</span>/5</div>
            <textarea id="reviewText" placeholder="Your review (optional)..."></textarea>
            <div class="modal-buttons">
                <a id="submitRating" class="btn gradient">Submit</a>
            </form>
            </div>
        </div>
    </div>

</body>

</html>