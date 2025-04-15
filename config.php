<?php
$host = "pg-4521b64-maria-e9ea.c.aivencloud.com";
$port = "19565";
$dbname = "defaultdb";
$user = "avnadmin";
$password = "AVNS_sxtYrfwV1ARAG3GdvI1"; 
$dsn = "pgsql:host=$host;port=$port;dbname=$dbname;sslmode=require";

try {
    // Свързваме се към базата данни
    $pdo = new PDO($dsn, $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Скрипт за създаване на таблицата test, ако не съществува
   /* $createTableSQL = "CREATE TABLE IF NOT EXISTS test (
        id SERIAL PRIMARY KEY,
        field1 VARCHAR(100),
        field2 INT,
        field3 TEXT
    )";
    $pdo->exec($createTableSQL);
*/
    // Проверяваме дали таблицата е празна
    // $stmt = $pdo->query("SELECT COUNT(*) FROM genre");
    // $rowCount = $stmt->fetchColumn();

    // // Ако таблицата е празна, въвеждаме тестови данни
    // if ($rowCount == 0) {
    //     $insertDataSQL = "INSERT INTO genre (id_genre,genre_name) VALUES 
    //         -- ('Sample Data 4', 100, 'Test text 1'),
    //         -- ('Sample Data 5', 200, 'Test text 2'),
    //         (1, 'action')";
    //     $pdo->exec($insertDataSQL);
    // }

    // // Изпълняваме заявка за извличане на всички редове от таблицата test
    // $stmt = $pdo->query("SELECT * FROM genre");
    // $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // // Извеждаме резултатите в HTML таблица
    // if ($results) {
    //     echo "<table border='1'>";
    //     // Извеждаме заглавния ред (имена на колоните)
    //     echo "<tr>";
    //     foreach (array_keys($results[0]) as $column) {
    //         echo "<th>" . htmlspecialchars($column) . "</th>";
    //     }
    //     echo "</tr>";

    //     // Извеждаме данните
    //     foreach ($results as $row) {
    //         echo "<tr>";
    //         foreach ($row as $cell) {
    //             echo "<td>" . htmlspecialchars($cell) . "</td>";
    //         }
    //         echo "</tr>";
    //     }
    //     echo "</table>";
    // } else {
    //     echo "Няма намерени резултати.";
    // }
} catch (PDOException $e) {
    // При възникване на грешка, извеждаме съобщението за грешка
    echo "Грешка: " . $e->getMessage();
 }

?>
