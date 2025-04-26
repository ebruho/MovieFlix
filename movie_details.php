<?php

require 'config.php';

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
    <main class="movie-details">
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
                    <h1><?=htmlspecialchars($movie['movie_title']); ?> (<?=htmlspecialchars($movie['release_year']); ?>)</h1>
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
                        <button class="btn-primary">
                            <i class="fas fa-play"></i> Watch Now
                        </button>
                        <button class="btn-secondary">
                            <i class="fas fa-plus"></i> Add to Watchlist
                        </button>
                        <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#ratingModal">
                            <i class="fas fa-star me-2"></i> Rate Movie
                        </button>
                        <button class="btn-secondary back-btn" >
                            <i class="fa-solid fa-arrow-left"></i> Back
                        </button>
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
                        <img src="./images/default_actor.jpg" alt="<?= htmlspecialchars($member['actor_name']) ?>">
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
                        <p><?=htmlspecialchars($movie['release_year']); ?></p>
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

            <section class="similar-movies">
                <h2>Similar Movies</h2>
                <div class="movie-grid">
                    <div class="movie-card">
                        <img src="./images/miraculous.jpeg" alt="Similar Movie">
                        <div class="movie-info">
                            <h4>Similar Movie 1</h4>
                            <span class="rating">⭐ 4.3</span>
                        </div>
                    </div>
                    <div class="movie-card">
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
                    </div>
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
            const openBtn = document.querySelector('.btn.btn-warning'); // Бутонът за отваряне на модала
            const closeBtn = document.getElementById('closeModal');
            const submitBtn = document.getElementById('submitRating');
            const starsContainer = document.getElementById('starsContainer');
            const ratingValue = document.getElementById('ratingValue');
            const reviewText = document.getElementById('reviewText');

            let currentRating = 0;

            // Open modal
            openBtn.addEventListener('click', () => {
                modal.style.display = 'flex';
                document.body.style.overflow = 'hidden';
            });

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
            <h2>Rate this Movie</h2>
            <div class="stars-container" id="starsContainer">
                <i class="far fa-star fa-2x star" data-rating="1"></i>
                <i class="far fa-star fa-2x star" data-rating="2"></i>
                <i class="far fa-star fa-2x star" data-rating="3"></i>
                <i class="far fa-star fa-2x star" data-rating="4"></i>
                <i class="far fa-star fa-2x star" data-rating="5"></i>
            </div>
            <div class="rating-value mt-2">Selected Rating: <span id="ratingValue">0</span>/5</div>
            <textarea id="reviewText" placeholder="Your review (optional)..."></textarea>
            <div class="modal-buttons">
                <button id="submitRating" class="btn gradient">Submit</button>
            </div>
        </div>
    </div>

</body>

</html>