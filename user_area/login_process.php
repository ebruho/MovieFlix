<?php
include('../config.php');
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    // Проверка за празни полета
    if (empty($email) || empty($password)) {
        die("Please fill in all fields.");
    }

    try {
        // Търсим потребителя по имейл
        $stmt = $pdo->prepare("SELECT * FROM Users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['user_password'])) {
            // Успешен вход — записваме данни в сесията
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['user_img'] = $user['user_img'];

            header("Location: profile.php");
            exit;
        } else {
            die("Invalid email or password.");
        }
    } catch (PDOException $e) {
        die("Database error: " . $e->getMessage());
    }
} else {
    die("Invalid request.");
}
