<?php 
include('../config.php');

    $title=$_POST['title'] ?? '';
    $genres=explode(",", $_POST['genres'] ?? '');
    $actors = explode(",", $_POST['actors'] ?? '');
    $roles = explode(",", $_POST['roles'] ?? '');
    $languages =  $_POST['languages'] ?? '';
    $directors = $_POST['directors'] ?? '';

    $link = $_POST['link'] ?? '';
    $keywords = $_POST['keywords'] ?? '';
    $duration = $_POST['duration'] ?? '';
    $budget = $_POST['budget'] ?? '';
    $releaseDate = $_POST['release_date'] ?? '';
    $description = $_POST['description'] ?? '';

    // Обработка на снимка
    $cover_path = '';
    if (isset($_FILES['cover']) && $_FILES['cover']['error'] === 0) {
        $upload_dir = "uploads/";
        if (!is_dir($upload_dir)) mkdir($upload_dir);
        $cover_path = $upload_dir . basename($_FILES['cover']['name']);
        move_uploaded_file($_FILES['cover']['tmp_name'], $cover_path);
    }

    //adding data on movie table
    $movie_query="INSERT INTO movie (movie_title, duration, movie_description, release_year, budget, keywords, movie_img, movie_link)"



?>