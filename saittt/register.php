<?php
include 'db_connection.php';  // Подключение к базе данных

if ($_SERVER["REQUEST_METHOD"] == "POST") {  // Проверка метода запроса (POST)
    $username = $_POST['username'];  // Получение значения username из формы
    $email = $_POST['email'];  // Получение значения email из формы
    $password = $_POST['password'];  // Получение значения password из формы

    // Проверяем, подключено ли соединение с базой данных
    if(isset($conn)) {  // Проверка существования соединения с базой данных
        // Проверка на существование пользователя с таким email
        $check_sql = "SELECT * FROM users WHERE email='$email'";  // SQL-запрос для проверки наличия пользователя с указанным email
        $check_result = $conn->query($check_sql);  // Выполнение SQL-запроса

        if ($check_result->num_rows > 0) {  // Проверка наличия результата в выборке
            echo "Пользователь с таким email уже существует";  // Вывод сообщения о существующем пользователе
        } else {
            // Хэширование пароля
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);  // Хэширование пароля с использованием функции password_hash

            $sql = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$hashed_password')";  // SQL-запрос для добавления нового пользователя в базу данных

            if ($conn->query($sql) === TRUE) {  // Проверка успешного выполнения SQL-запроса
                // Перенаправляем пользователя на страницу профиля
                header("Location: dashboard.php");  // Перенаправление на страницу dashboard.php
                exit;  // Завершение выполнения скрипта
            } else {
                echo "Ошибка при регистрации: " . $conn->error;  // Вывод сообщения об ошибке при регистрации
            }
        }

        // Закрываем соединение с базой данных
        $conn->close();  // Закрытие соединения с базой данных
    } else {
        echo "Ошибка соединения с базой данных";  // Вывод сообщения об ошибке соединения с базой данных
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Регистрация пользователя</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<header>
    <h2 style="color: white;">Добро пожаловать!</h2>
</header>
<div class="container">
    <h2>Регистрация пользователя</h2>
    <div class="form-container">
        <h3><a href="login.php" style="text-decoration: none; color: red;">Вход</a></h3>
    </div>
    <div class="form-container">
        <h3>Регистрация</h3>
        <form action="" method="post">
            <input type="text" name="username" placeholder="Имя пользователя" required><br>
            <input type="email" name="email" placeholder="Email" required><br>
            <input type="password" name="password" placeholder="Пароль" required><br>
            <button type="submit">Зарегистрироваться</button>
        </form>
    </div>
</div>
</body>
</html>
