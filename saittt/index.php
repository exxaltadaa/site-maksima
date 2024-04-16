<?php
session_start();

// Проверяем, вошел ли пользователь в систему. Если да, перенаправляем его на панель управления.
if (isset($_SESSION['loggedin'])) {
    header("Location: dashboard.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Финансовое приложение</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h2 style="color: white;">Добро пожаловать!</h2>
    </header>
    <div class="container">
        
        <div class="form-container">
            <h3>
                <a href="login.php" style="text-decoration: none; color: black;">Вход</a>
                
                <a href="register.php" style="text-decoration: none; color: black;">Регистрация</a>
            </h3>
        </div>
    </div>
</body>
</html>


