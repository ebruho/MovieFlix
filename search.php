 <?php
include 'config.php';

$search = isset($_GET['q']) ? trim($_GET['q']) : '';

if ($search !== '') {
    // Подготвена заявка с LIKE (ILIKE за case-insensitive в PostgreSQL)
    $stmt = $pdo->prepare("SELECT movie_id, movie_title FROM movie WHERE movie_title ILIKE :search");
    $stmt->bindValue(':search', '%' . $search . '%', PDO::PARAM_STR);
    $stmt->execute();

    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo "<h3>Results \"" . htmlspecialchars($search) . "\"</h3>";
    if ($results) {
        echo "<ul>";
        foreach ($results as $row) {
            echo "<li><a href=\"movie_details.php?id=" . (int)$row['movie_id'] . "\">" . htmlspecialchars($row['movie_title']) . "</a></li>";
        }
        echo "</ul>";
    } else {
        echo "<p>No movies found</p>";
    }
}
?>
