<?php
include "config.php";

try{
$users="CREATE TABLE IF NOT EXISTS Users (
            user_id SERIAL PRIMARY KEY,
            username VARCHAR(255),
            email VARCHAR(255),
            user_password VARCHAR(255),
            user_img VARCHAR(255),
            joined_date TIMESTAMP
        )";
        $pdo->exec($users);

        $admins="CREATE TABLE IF NOT EXISTS Admins (
            admin_id SERIAL PRIMARY KEY,
            admin_name VARCHAR(255),
            admin_email VARCHAR(255),
            admin_password VARCHAR(255)
        )";
        $pdo->exec($admins);
        
        $movie="CREATE TABLE IF NOT EXISTS Movie (
            movie_id SERIAL PRIMARY KEY,
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
        )";
        $pdo->exec($movie);

        $rating="CREATE TABLE IF NOT EXISTS Rating (
            rating_id SERIAL PRIMARY KEY,
            rating_num INT,
            comments TEXT,
            user_id INT,
            movie_id INT
        )";
        $pdo->exec($rating);

        
        $watchlist="CREATE TABLE IF NOT EXISTS Watchlist (
            watchlist_id SERIAL PRIMARY KEY,
            movie_id INT,
            user_id INT,
            added_date TIMESTAMP,
            is_watched CHAR(1)
        )";
        $pdo->exec($watchlist);

        
        $actor="CREATE TABLE IF NOT EXISTS Actor (
            actor_id SERIAL PRIMARY KEY,
            actor_name VARCHAR(255)
        )";
        $pdo->exec($actor);

        $director="CREATE TABLE IF NOT EXISTS Director (
            director_id SERIAL PRIMARY KEY,
            director_name VARCHAR(255)

        )";
        $pdo->exec($director);

$language="CREATE TABLE IF NOT EXISTS MovieLanguage (
            language_id SERIAL PRIMARY KEY,
            language_name VARCHAR(255)
        )";
        $pdo->exec($language);
 
        $genre="CREATE TABLE IF NOT EXISTS Genre (
            genre_id SERIAL PRIMARY KEY,
            genre_name VARCHAR(255)
        )";
        $pdo->exec($genre);

        $character="CREATE TABLE IF NOT EXISTS MovieCharacter (
            character_id SERIAL PRIMARY KEY,
            character_name VARCHAR(255),
            actor_id INT,
            movie_id INT
        )";
        $pdo->exec($character);
 
        $movieGenre="CREATE TABLE IF NOT EXISTS MovieGenre (
            movieGenre_id SERIAL PRIMARY KEY,
            movie_id INT,
            genre_id INT 
        )";
        $pdo->exec($movieGenre);

        echo "All tables created.";

        $movieDirectorFK="ALTER TABLE Movie 
        ADD CONSTRAINT movie_director_FK
        FOREIGN KEY (director_id)
        REFERENCES Director(director_id)
        ON DELETE SET NULL";
        $pdo->exec($movieDirectorFK);
             
        $movieLanguageFK="ALTER TABLE Movie 
        ADD CONSTRAINT movie_movieLanguage_FK
        FOREIGN KEY (language_id)
        REFERENCES MovieLanguage(language_id)
        ON DELETE SET NULL";
        $pdo->exec($movieLanguageFK);  

        $ratingUsersFK="ALTER TABLE Rating
        ADD CONSTRAINT rating_users_FK
        FOREIGN KEY (user_id)
        REFERENCES Users(user_id)
        ON DELETE SET NULL";
        $pdo->exec($ratingUsersFK);

        $ratingMovieFK="ALTER TABLE Rating
        ADD CONSTRAINT rating_movie_FK
        FOREIGN KEY (movie_id)
        REFERENCES Movie(movie_id)
        ON DELETE SET NULL";
        $pdo->exec($ratingMovieFK);

        $watchlistUsersFK="ALTER TABLE Watchlist
        ADD CONSTRAINT watchlist_users_FK
        FOREIGN KEY (user_id)
        REFERENCES Users(user_id)
        ON DELETE SET NULL";
        $pdo->exec($watchlistUsersFK);

        $watchlistMovieFK="ALTER TABLE Watchlist
        ADD CONSTRAINT watchlist_movie_FK
        FOREIGN KEY (movie_id)
        REFERENCES Movie(movie_id)
        ON DELETE SET NULL";
        $pdo->exec($watchlistMovieFK);

        $fkcharacter="ALTER TABLE MovieCharacter
        ADD CONSTRAINT Character_Actor_FK
        FOREIGN KEY (actor_id) 
        REFERENCES Actor(actor_id)
        ON DELETE SET NULL";
        $pdo->exec($fkcharacter);

        $fkmoviecharacter="ALTER TABLE MovieCharacter
        ADD CONSTRAINT Character_Movie_FK
        FOREIGN KEY (movie_id) 
        REFERENCES Movie(movie_id)
        ON DELETE SET NULL";
        $pdo->exec($fkmoviecharacter);

        $fkgenre="ALTER TABLE MovieGenre
        ADD CONSTRAINT MovieGenre_Genre_FK
        FOREIGN KEY (genre_id)
        REFERENCES Genre(genre_id)
        ON DELETE SET NULL";
        $pdo->exec($fkgenre);

        $fkmoviegenre="ALTER TABLE MovieGenre 
        ADD CONSTRAINT MovieGenre_Movie_FK 
        FOREIGN KEY (movie_id) 
        REFERENCES Movie(movie_id) 
        ON DELETE SET NULL";
        $pdo->exec($fkmoviegenre);

        $budgetIncreaseValue="ALTER TABLE Movie ALTER COLUMN budget TYPE NUMERIC(10, 2)";


} catch (PDOException $e) {
    echo "Error:" . $e->getMessage();
}



?>