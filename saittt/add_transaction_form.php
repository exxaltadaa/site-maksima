<?php
session_start();
include 'db_connection.php';

?>

<!DOCTYPE html>
<html>
<head>
    <title>Добавить транзакцию</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<header>
        <h2 style="color: white;">Добро пожаловать!</h2>
    </header>
    <div class="container">
        <h1 style="text-align: center;">Моя Финансовая Панель</h1>
        <nav style="text-align: center;">
            <a href="dashboard.php" style="text-decoration: none; color: black; font-size: 20px;">Личный кабинет</a> |
            <a href="logout.php" style="text-decoration: none; color: black; font-size: 20px;">Выйти</a>
        </nav>

        <h2>Добавить транзакцию</h2>
        <form action="add_transaction.php" method="post">
            <label>Тип:</label>
            <select name="type">
                <option value="income">Доход</option>
                <option value="expense">Расход</option>
            </select>
            <br>
            <label>Сумма:</label>
            <input type="text" name="amount">
            <br>
            <label>Дата:</label>
            <input type="date" name="date">
            <br>
            <label>Категория:</label>
            <input type="text" name="category">
            <br>
            <input type="submit" value="Добавить">
        </form>
    </div>
</body>
</html>
