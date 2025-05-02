<?php
include ('../config.php');
session_start();

// Проверка за изпратена форма
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';
    $joined_date = date('Y-m-d H:i:s');

    $user_img = $_FILES['user_img'];

    // Проверка за празни полета
    if (empty($username) || empty($email) || empty($password) || empty($confirm_password)) {
        die("Please fill in all required fields.");
    }

    // Проверка за съвпадение на пароли
    if ($password !== $confirm_password) {
        die("Passwords do not match.");
    }

    // Хеширане на паролата
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Обработка на качената снимка
    if (isset($_FILES['user_img']) && $_FILES['user_img']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['user_img']['tmp_name'];
        $fileName = basename($_FILES['user_img']['name']);
        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];

        if (!in_array($fileExtension, $allowedExtensions)) {
            die("Only JPG, JPEG, PNG, and GIF files are allowed.");
        }

        $newFileName = uniqid('avatar_', true) . '.' . $fileExtension;
        $uploadDir = 'uploads/';
        $destPath = $uploadDir . $newFileName;

        // Създай папка, ако не съществува
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        if (!move_uploaded_file($fileTmpPath, $destPath)) {
            die("There was an error uploading the image.");
        }
    } else {
        $destPath = null; // Ако не е качена снимка
    }

    // Запис в базата данни
    try {
        $stmt = $pdo->prepare("INSERT INTO Users (username, email, user_password, user_img, joined_date) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$username, $email, $hashed_password, $destPath, $joined_date]);

//         echo '<pre>';
// print_r($_FILES['user_img']);
// echo '</pre>';


        // Пренасочване към login страница или профил
        header("Location: login.php?success=1");
        exit;
    } catch (PDOException $e) {
        die("Database error: " . $e->getMessage());
    }
} else {
    die("Invalid request.");
}
