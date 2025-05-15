<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - MovieFlix</title>
    <link rel="stylesheet" href="../css/auth.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

</head>
<body>
<div class="auth-container">
<a class="btn-primary" href="../index.php" style="text-decoration:none; background:transparent; color: #e50914; font-size: 1.5rem;">                     
    <i class="fa-solid fa-arrow-left"></i>     
    </a>
    <form action="register_process.php" method="POST" class="auth-form" enctype="multipart/form-data">
        <h2>Create Your Account</h2>

        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>

        <label for="user_img">Profile Picture:</label>
        <input type="file" id="user_img" name="user_img" accept="image/*" required>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>

        <label for="confirm_password">Confirm Password:</label>
        <input type="password" id="confirm_password" name="confirm_password" required>

        <button type="submit" class="btn-primary">Register</button>

        <p class="auth-link">Already have an account? <a href="login.php">Login here</a></p>
    </form>
</div>

</body>
</html>