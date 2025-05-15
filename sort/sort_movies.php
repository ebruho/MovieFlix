
<?php
include "sort_movies.html";

if (isset($_POST['submit'])) {
    $sort=$_POST['sortMovie'];
}
foreach ($sort as $key => $value) {
    echo $key."=>".$value;
    if ($value=="actors"){
        $results=sortActor();
        $callA=displayData($results);
    }
    elseif ($value=="names") {
        $results=sortNames();
        $callN=displayData($results);
    }
}
function sortActor(){
    include "../config.php";
    $stmt = $pdo->query("SELECT Movie.movie_id,Movie.movie_title, Actor.actor_name FROM MovieCharacter 
    INNER JOIN Actor
    ON Actor.actor_id=MovieCharacter.actor_id 
    INNER JOIN Movie
    ON Movie.movie_id=MovieCharacter.movie_id
    ORDER BY actor_name");
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $results;
}
function sortNames(){
    include "../config.php";
    $stmt = $pdo->query("SELECT * FROM Movie ORDER BY movie_title");
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $results;
}
function displayData($results){
    // Извеждаме резултатите в HTML таблица
    if ($results) {
        echo "<table border='1'>";
        // Извеждаме заглавния ред (имена на колоните)
        echo "<tr>";
        foreach (array_keys($results[0]) as $column) {
            echo "<th>" . htmlspecialchars($column) . "</th>";
        }
        echo "</tr>";

        // Извеждаме данните
        foreach ($results as $row) {
            echo "<tr>";
            foreach ($row as $cell) {
                echo "<td>" . htmlspecialchars($cell) . "</td>";
            }
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "Няма намерени резултати.";
    }
}
?>