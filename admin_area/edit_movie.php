<?php
include "../config.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $movie_id = $_POST['edit_movie_id'];
    $title = $_POST['edit_title'];
    $description = $_POST['edit_description'];
    $duration = $_POST['edit_duration'];
    $budget = $_POST['edit_budget'];
    $release_date = $_POST['edit_release_date'];
    $keywords = $_POST['edit_keywords'];
    $link = $_POST['edit_link'];

    $genres = explode(",", $_POST['edit_genres']);
    $actors = explode(",", $_POST['edit_actors']);
    $roles = explode(",", $_POST['edit_roles']);
    $languages = explode(",", $_POST['edit_languages']);
    $directors = explode(",", $_POST['edit_directors']);

    $language_name = trim($languages[0] ?? '');
    $director_name = trim($directors[0] ?? '');

    $imgPath = ''; // Нов път за снимката

    // Ако има нова снимка
    if (!empty($_FILES["edit_cover"]["name"])) {
        $imgName = time() . "_" . basename($_FILES["edit_cover"]["name"]);
        $target = "uploads/" . $imgName;
        if (move_uploaded_file($_FILES["edit_cover"]["tmp_name"], $target)) {
            $imgPath = $imgName;
        }
    }

    try {
        // Режисьор
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

        // Обновяване на филма
        $sql = "UPDATE Movie 
                SET movie_title = ?, duration = ?, movie_description = ?, release_year = ?, 
                    director_id = ?, language_id = ?, budget = ?, keywords = ?, movie_link = ?" . 
                    ($imgPath ? ", movie_img = ?" : "") . "
                WHERE movie_id = ?";
        
        $params = [
            $title, $duration, $description, date("Y", strtotime($release_date)), 
            $director_id, $language_id, $budget, $keywords, $link
        ];
        if ($imgPath) {
            $params[] = $imgPath;
        }
        $params[] = $movie_id;

        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);

        // Изчистване на старите връзки
        $pdo->prepare("DELETE FROM MovieGenre WHERE movie_id = ?")->execute([$movie_id]);
        $pdo->prepare("DELETE FROM MovieCharacter WHERE movie_id = ?")->execute([$movie_id]);

        // Добавяне на новите жанрове
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

        // Добавяне на новите актьори и роли
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

        echo "Movie updated successfully!";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
