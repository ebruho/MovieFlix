<?php
include "config.php";

try{
$users="CREATE TABLE IF NOT EXISTS Users (
            user_id INT PRIMARY KEY,
            username VARCHAR(255),
            email VARCHAR(255),
            user_password VARCHAR(255),
            user_img VARCHAR(255),
            joined_date TIMESTAMP
        )";
        $pdo->exec($users);

        $admins="CREATE TABLE IF NOT EXISTS Admins (
            admin_id INT PRIMARY KEY,
            admin_name VARCHAR(255),
            admin_email VARCHAR(255),
            admin_password VARCHAR(255)
        )";
        $pdo->exec($admins);
        
        $movie="CREATE TABLE IF NOT EXISTS Movie (
            movie_id INT PRIMARY KEY,
            movie_title VARCHAR(255),
            duration VARCHAR(255),
            movie_description VARCHAR(255),
            release_year INT,
            director_id INT,
            language_id INT,
            budget DECIMAL(7,2),
            keywords VARCHAR(255),
            movie_img VARCHAR(255),
            movie_link VARCHAR(255)
            -- FOREIGN KEY (rating_id) REFERENCES Ratings(rating_id),
            -- FOREIGN KEY (director_id) REFERENCES Director(director_id),
            -- FOREIGN KEY (language_id) REFERENCES MovieLanguage(language_id)
        )";
        $pdo->exec($movie);

        $rating="CREATE TABLE IF NOT EXISTS Rating (
            rating_id INT PRIMARY KEY,
            rating_num INT,
            comments VARCHAR(255),
            user_id INT,
            movie_id INT
            -- FOREIGN KEY (user_id) REFERENCES Users(user_id),
            -- FOREIGN KEY (movie_id) REFERENCES Movie(movie_id)
        )";
        $pdo->exec($rating);

        $watchlist="CREATE TABLE IF NOT EXISTS Watchlist (
            watchlist_id INT PRIMARY KEY,
            movie_id INT,
            user_id INT,
            added_date TIMESTAMP,
            is_watched CHAR(1)
            -- FOREIGN KEY (user_id) REFERENCES Users(user_id),
            -- FOREIGN KEY (movie_id) REFERENCES Movie(movie_id)
        )";
        $pdo->exec($watchlist);
        
        $actor="CREATE TABLE IF NOT EXISTS Actor (
            actor_id SERIAL PRIMARY KEY,
            actor_name VARCHAR(255)
        )";
        $pdo->exec($actor);

        $director="CREATE TABLE IF NOT EXISTS Director (
            director_id INT PRIMARY KEY,
            director_name VARCHAR(255)
        )";
        $pdo->exec($director);

$language="CREATE TABLE IF NOT EXISTS MovieLanguage (
            language_id INT PRIMARY KEY,
            language_name VARCHAR(255)
        )";
        $pdo->exec($language);
 
        $genre="CREATE TABLE IF NOT EXISTS Genre (
            genre_id INT PRIMARY KEY,
            genre_name VARCHAR(255)
        )";
        $pdo->exec($genre);
 
        

        $character="CREATE TABLE IF NOT EXISTS MovieCharacter (
            character_id INT PRIMARY KEY,
            character_name VARCHAR(255),
            actor_id INT,
            movie_id INT
            -- FOREIGN KEY (actor_id) REFERENCES Actor(actor_id),
            -- FOREIGN KEY (movie_id) REFERENCES Movie(movie_id)
        )";
        $pdo->exec($character);
 
        $movieGenre="CREATE TABLE IF NOT EXISTS MovieGenre (
            movieGenre_id INT PRIMARY KEY,
            movie_id INT,
            genre_id INT
            -- FOREIGN KEY (movie_id) REFERENCES Movie(movie_id),
            -- FOREIGN KEY (genre_id) REFERENCES Genre(genre_id)
        )";
        $pdo->exec($movieGenre);

        echo "All tables created.";
} catch (PDOException $e) {
    echo "Error:" . $e->getMessage();
}

?>