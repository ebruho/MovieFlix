<?php
include "../config.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Данни от формата
    $title = $_POST['title'];
    $description = $_POST['description'];
    $duration = $_POST['duration'];
    $budget = $_POST['budget'];
    $release_date = $_POST['release_date'];
    $keywords = $_POST['keywords'];
    $link = $_POST['link'];
    $languages = $_POST['languages'];
    $directors = $_POST['directors'];
    
    // Масиви от скритите input-и
    $genres = explode(",", $_POST['genres']); 
    $actors = explode(",", $_POST['actors']); 
    $roles = explode(",", $_POST['roles']); 
    $languages = explode(",", $_POST['languages']);
    $directors = explode(",", $_POST['directors']);
    
    $language_name = trim($languages[0] ?? '');
    $director_name = trim($directors[0] ?? '');
    

    // Качване на снимка
    $imgPath = '';
    if (!empty($_FILES["cover"]["name"])) {
        $imgName = time() . "_" . basename($_FILES["cover"]["name"]);
        $target = "uploads/" . $imgName;
        if (move_uploaded_file($_FILES["cover"]["tmp_name"], $target)) {
            $imgPath = $imgName;
        }
    }

    try {
        // Вмъкване или взимане на режисьор
       // Директори
$director_id = null;
if ($director_name !== '') {
    $stmt = $pdo->prepare("SELECT director_id FROM Director WHERE director_name = ?");
    $stmt->execute([$director_name]);
    $director_id = $stmt->fetchColumn();

    if (!$director_id) {
        $stmt = $pdo->prepare("INSERT INTO Director (director_name) VALUES (?) RETURNING director_id");
        $stmt->execute([$director_name]);
        $director_id = $stmt->fetchColumn();
    }
}

// Език
$language_id = null;
if ($language_name !== '') {
    $stmt = $pdo->prepare("SELECT language_id FROM MovieLanguage WHERE language_name = ?");
    $stmt->execute([$language_name]);
    $language_id = $stmt->fetchColumn();

    if (!$language_id) {
        $stmt = $pdo->prepare("INSERT INTO MovieLanguage (language_name) VALUES (?) RETURNING language_id");
        $stmt->execute([$language_name]);
        $language_id = $stmt->fetchColumn();
    }
}


        // Вмъкване на филма
        $stmt = $pdo->prepare("INSERT INTO Movie (movie_title, duration, movie_description, release_year, director_id, language_id, budget, keywords, movie_img, movie_link)
                               VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?) RETURNING movie_id");
        $stmt->execute([
            $title, $duration, $description, date("Y", strtotime($release_date)), $director_id, $language_id,
            $budget, $keywords, $imgPath, $link
        ]);
        $movie_id = $stmt->fetchColumn();

        // Жанрове
        foreach ($genres as $genre) {
            $genre = trim($genre);
            if (!$genre) continue;
            $stmt = $pdo->prepare("SELECT genre_id FROM Genre WHERE genre_name = ?");
            $stmt->execute([$genre]);
            $genre_id = $stmt->fetchColumn();
            if (!$genre_id) {
                $stmt = $pdo->prepare("INSERT INTO Genre (genre_name) VALUES (?) RETURNING genre_id");
                $stmt->execute([$genre]);
                $genre_id = $stmt->fetchColumn();
            }
            $stmt = $pdo->prepare("INSERT INTO MovieGenre (movie_id, genre_id) VALUES (?, ?)");
            $stmt->execute([$movie_id, $genre_id]);
        }

        // Актьори и роли
        for ($i = 0; $i < count($actors); $i++) {
            $actor = trim($actors[$i]);
            $role = trim($roles[$i]);
            if (!$actor || !$role) continue;

            $stmt = $pdo->prepare("SELECT actor_id FROM Actor WHERE actor_name = ?");
            $stmt->execute([$actor]);
            $actor_id = $stmt->fetchColumn();
            if (!$actor_id) {
                $stmt = $pdo->prepare("INSERT INTO Actor (actor_name) VALUES (?) RETURNING actor_id");
                $stmt->execute([$actor]);
                $actor_id = $stmt->fetchColumn();
            }

            $stmt = $pdo->prepare("INSERT INTO MovieCharacter (character_name, actor_id, movie_id) VALUES (?, ?, ?)");
            $stmt->execute([$role, $actor_id, $movie_id]);
        }

        echo "Movie added successfully!";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>

<?php
// include('../config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    echo "<pre>";
    print_r($_POST);
    print_r($_FILES);
    echo "</pre>";
}

// echo "<script>window.open('./admin_movies.php')</script>";
htmlspecialchars("<script> window.open('./admin_movies.php') </script>");
?>
