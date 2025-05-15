<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - MovieFlix</title>
    <link rel="stylesheet" href="../css/auth.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

</head>
<body>
<div class="auth-container">
<a class="btn-primary" href="../index.php" style="text-decoration:none; background:transparent; color: #e50914; font-size: 1.5rem;">                     
    <i class="fa-solid fa-arrow-left"></i>     
    </a>
    <form action="login_process.php" method="POST" class="auth-form">
        <h2>Login to MovieFlix</h2>
        
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>

        <button type="submit" class="btn-primary">Login</button>

        <p class="auth-link">Don't have an account? <a href="register.php">Register here</a></p>
    </form>
</div>

</body>
</html>