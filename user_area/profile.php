<?php
include('../config.php');

session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}
$user_id = $_SESSION['user_id'];

$stmt = $pdo->prepare("SELECT * FROM users WHERE user_id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    die("User not found.");
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>MovieFlix - Profile</title>
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="../css/profile.css">

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
                <li><a href="../index.php">Home</a></li>
                <li><a href="#">Movies</a></li>
                <li><a href="./profile.php">Profile</a></li>
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
                <li><a href="logout.php" class="active">Logout</a></li>
            </ul>
        </nav>
    </header>

    <!-- Profile Content -->
    <main class="profile-container">
    <aside class="profile-sidebar">
        <!-- https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSzmu-JbHvRUSaviHHT3_iqD53kjBMSFye1Mg&s -->
        <img src="<?= htmlspecialchars($user['user_img']) ?>" alt="User Avatar" class="profile-avatar">
        <h2><?= htmlspecialchars($user['username']) ?> </h2>
        <p class="user-role">Member</p>
        <ul class="profile-nav">
            <li class="active"><i class="fas fa-user"></i> Overview</li>
            <li><i class="fas fa-edit"></i> Edit Info</li>
            <li><i class="fas fa-heart"></i> Watchlist</li>
            <li><i class="fas fa-lock"></i> Change Password</li>
            <li><i class="fas fa-sign-out-alt"></i> Logout</li>
        </ul>
    </aside>

    <section class="profile-main">
        <h3>Profile Overview</h3>
        <div class="info-group">
            <div class="info-item">
                <label>Username</label>
                <p><?= htmlspecialchars($user['username']) ?></p>
            </div>
            <div class="info-item">
                <label>Email</label>
                <p><?= htmlspecialchars($user['email']) ?></p>
            </div>
            <div class="info-item">
                <label>Joined</label>
                <p><?= date("F j, Y", strtotime($user['joined_date'])) ?></p>
            </div>
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
    <script src="../script.js"></script>
  
</body>
</html>
