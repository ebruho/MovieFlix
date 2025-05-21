<?php 
include "config.php";

function add_watchlist() {
    if (isset($_GET['add_watchlist']) && isset($_SESSION['user_id'])) {
        global $pdo;

        $user_id = $_SESSION['user_id'];
        $movie_id = (int)$_GET['add_watchlist'];

        // Проверка дали вече е в watchlist
        $stmt = $pdo->prepare("SELECT 1 FROM watchlist WHERE user_id = ? AND movie_id = ?");
        $stmt->execute([$user_id, $movie_id]);

        if ($stmt->fetch()) {
            // Вече е добавен
            $_SESSION['watchlist_message'] = "Movie is already in your watchlist.";
        } else {
            // Добавяне
            $stmt = $pdo->prepare("INSERT INTO watchlist (user_id, movie_id, added_date, is_watched) VALUES (?, ?, NOW(), '0')");
            $stmt->execute([$user_id, $movie_id]);
            $_SESSION['watchlist_message'] = "Movie successfully added to your watchlist!";
        }

        // Пренасочване към същия филм
        header('Location: watchmovie.php?movie_id=' . $movie_id);
        exit;
    }
}

function add_watchlist_details() {
    if (isset($_GET['add_watchlist']) && isset($_SESSION['user_id'])) {
        global $pdo;

        $user_id = $_SESSION['user_id'];
        $movie_id = (int)$_GET['add_watchlist'];

        // Проверка дали вече е в watchlist
        $stmt = $pdo->prepare("SELECT 1 FROM watchlist WHERE user_id = ? AND movie_id = ?");
        $stmt->execute([$user_id, $movie_id]);

        if ($stmt->fetch()) {
            // Вече е добавен
            $_SESSION['watchlist_message'] = "Movie is already in your watchlist.";
        } else {
            // Добавяне
            $stmt = $pdo->prepare("INSERT INTO watchlist (user_id, movie_id, added_date, is_watched) VALUES (?, ?, NOW(), '0')");
            $stmt->execute([$user_id, $movie_id]);
            $_SESSION['watchlist_message'] = "Movie successfully added to your watchlist!";
        }

        // Пренасочване към същия филм
        header('Location: movie_details.php?movie_id=' . $movie_id);
        exit;
    }
}

function remove_watchlist() {
    if (isset($_GET['remove_watchlist']) && isset($_SESSION['user_id'])) {
        global $pdo;

        $user_id = $_SESSION['user_id'];
        $movie_id = (int)$_GET['remove_watchlist'];

        // Премахване
        $stmt = $pdo->prepare("DELETE FROM watchlist WHERE user_id = ? AND movie_id = ?");
        $stmt->execute([$user_id, $movie_id]);

        $_SESSION['watchlist_message'] = "Movie successfully removed from your watchlist!";

        // Пренасочване към watchlist
        header('Location: watchlist.php');
        exit;
    }
}

function mark_as_watched() {
    if (isset($_GET['mark_as_watched']) && isset($_SESSION['user_id'])) {
        global $pdo;

        $user_id = $_SESSION['user_id'];
        $movie_id = (int)$_GET['mark_as_watched'];

        // Маркиране като гледан
        $stmt = $pdo->prepare("UPDATE watchlist SET is_watched = '1' WHERE user_id = ? AND movie_id = ?");
        $stmt->execute([$user_id, $movie_id]);

        $_SESSION['watchlist_message'] = "Movie marked as watched!";

        // Пренасочване към watchlist
        header('Location: watchlist.php');
        exit;
    }
}

function unmark_as_watched() {
    if (isset($_GET['unmark_as_watched']) && isset($_SESSION['user_id'])) {
        global $pdo;

        $user_id = $_SESSION['user_id'];
        $movie_id = (int)$_GET['unmark_as_watched'];

        // Премахване на отметката за гледан
        $stmt = $pdo->prepare("UPDATE watchlist SET is_watched = '0' WHERE user_id = ? AND movie_id = ?");
        $stmt->execute([$user_id, $movie_id]);

        $_SESSION['watchlist_message'] = "Movie marked as unwatched!";

        // Пренасочване към watchlist
        header('Location: watchlist.php');
        exit;
    }
}
?>

