<?php
session_start();  // Начало новой сессии или возобновление существующей

include 'db_connection.php'; // Подключение к базе данных

if ($_SERVER["REQUEST_METHOD"] == "POST") {  // Проверка метода запроса (POST)
    $email = $_POST['email'];  // Получение значения email из формы
    $password = $_POST['password'];  // Получение значения password из формы

    // Проверяем, подключено ли соединение с базой данных
    if(isset($conn)) {  // Проверка существования соединения с базой данных
        $sql = "SELECT id, username, email, password FROM users WHERE email='$email'";  // SQL-запрос для выборки данных пользователя по email
        $result = $conn->query($sql);  // Выполнение SQL-запроса

        if ($result->num_rows == 1) {  // Проверка наличия результата в выборке
            $row = $result->fetch_assoc();  // Получение результата выборки в виде ассоциативного массива
            if (password_verify($password, $row['password'])) {  // Проверка пароля с использованием функции password_verify
                $_SESSION['loggedin'] = true;  // Установка сессионной переменной для авторизации
                $_SESSION['username'] = $row['username'];  // Установка сессионной переменной для имени пользователя
                $_SESSION['email'] = $row['email'];  // Установка сессионной переменной для email пользователя
                $_SESSION['id'] = $row['id'];  // Установка сессионной переменной для ID пользователя
                header("Location: dashboard.php");  // Перенаправление на страницу dashboard.php
                exit;  // Завершение выполнения скрипта
            } else {
                echo "Неправильный пароль";  // Вывод сообщения о неправильном пароле
            }
        } else {
            echo "Пользователь не найден";  // Вывод сообщения о том, что пользователь не найден
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
    <title>Форма входа</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<header>
        <h2 style="color: white;">Добро пожаловать!</h2>
    </header>
    <div class="container">
        <h2>Добро пожаловать!</h2>
        <div class="form-container">
            <h3><a href="register.php" style="text-decoration: none; color: red;">Регистрация</a></h3>
        </div>
        <div class="form-container">
            <h3>Вход</h3>
            <form action="" method="post">
                <input type="email" name="email" placeholder="Email" required><br>
                <input type="password" name="password" placeholder="Пароль" required><br>
                <button type="submit">Войти</button>
            </form>
        </div>
    </div>
</body>
</html>


