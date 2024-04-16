<?php
$servername = "localhost";
$username = "root"; // Ваше имя пользователя для доступа к базе данных
$password = ""; // Ваш пароль для доступа к базе данных
$dbname = "finance_management"; // Название базы данных в phpmyadmin

// Создание соединения с базой данных
$conn = new mysqli($servername, $username, $password, $dbname);

// Проверка соединения
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
