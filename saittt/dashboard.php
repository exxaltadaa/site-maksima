<?php
session_start();  // Начало новой сессии или возобновление существующей
include 'db_connection.php';  // Подключение к базе данных

if (!isset($_SESSION['loggedin'])) {  // Проверка авторизации пользователя
    header("Location: login.php");  // Перенаправление на страницу авторизации
    exit;  // Завершение выполнения скрипта
}

$user_id = $_SESSION['id'];  // Получение ID пользователя из сессии

// Получение информации о пользователе
$sql_user = "SELECT * FROM users WHERE id='$user_id'";  // SQL-запрос для получения информации о пользователе по ID
$result_user = $conn->query($sql_user);  // Выполнение SQL-запроса
$row_user = $result_user->fetch_assoc();  // Получение результата выборки в виде ассоциативного массива

// Получение роли пользователя
if(isset($row_user['role_id'])) {  // Проверка наличия роли у пользователя
    $role_id = $row_user['role_id'];  // Получение ID роли
    $sql_role = "SELECT role_name FROM roles WHERE role_id='$role_id'";  // SQL-запрос для получения названия роли по ID
    $result_role = $conn->query($sql_role);  // Выполнение SQL-запроса
    $row_role = $result_role->fetch_assoc();  // Получение результата выборки в виде ассоциативного массива
    $role_name = $row_role['role_name'];  // Получение названия роли
} else {
    $role_name = '';  // Установка пустого значения для роли, если роль не указана
}

// Удаление транзакции администратором
if(isset($_GET['delete_id']) && $role_name == 'Администратор') {  // Проверка наличия параметра delete_id в GET-запросе и роли администратора
    $delete_id = $_GET['delete_id'];  // Получение ID транзакции для удаления
    $sql_delete = "DELETE FROM transactions WHERE id='$delete_id'";  // SQL-запрос для удаления транзакции
    if ($conn->query($sql_delete) === TRUE) {  // Проверка успешного выполнения SQL-запроса
        echo "Транзакция успешно удалена";  // Вывод сообщения об успешном удалении транзакции
    } else {
        echo "Ошибка при удалении транзакции: " . $conn->error;  // Вывод сообщения об ошибке при удалении транзакции
    }
}

$sql = "SELECT * FROM transactions WHERE user_id='$user_id'";  // SQL-запрос для получения транзакций пользователя по ID
$result = $conn->query($sql);  // Выполнение SQL-запроса
?>


<!DOCTYPE html>
<html>
<head>
    <title>Личный кабинет</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<header>
        <h2 style="color: white;">Добро пожаловать!</h2>
    </header>
    <div class="container">
        <div style="text-align: right;">
        <?php
        // Отображение "Админ панели" для пользователя с ролью "Администратор"
        if ($role_name == 'Администратор') {
            echo "| <a href='admin_panel.php' style='text-decoration: none; color: black; font-size: 24px;'>Админ панель</a> | ";
        }
        ?>
        <a href="logout.php" style="text-decoration: none; color: black; font-size: 24px;">Выйти</a>
        </div>
        <h2>Личный кабинет</h2>
        <div class="user-info">
            <div style="text-align: center;">Имя пользователя: <br> <?php echo $row_user['username']; ?></div>
            <div style="text-align: center;">Email пользователя: <br> <?php echo $row_user['email']; ?></div>
        </div>
        <p><a href="add_transaction_form.php" style="text-decoration: none; color: black; font-size: 24px; margin-left: 170px;">Добавить транзакцию</a></p>
        <table border="1" style="text-align: center; margin-left: 90px">
            <tr>
                <th width="100px">Тип</th>
                <th width="100px">Сумма</th>
                <th width="100px">Дата</th>
                <th width="100px">Категория</th>
                <?php if ($role_name == 'Администратор') { echo "<th>Действие</th>"; } ?>
            </tr>
            <?php
            if ($result !== null && $result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['type'] . "</td>";
                    echo "<td>" . $row['amount'] . "</td>";
                    echo "<td>" . $row['date'] . "</td>";
                    echo "<td>" . $row['category'] . "</td>";
                    if ($role_name == 'Администратор') {
                        echo "<td><a href='dashboard.php?delete_id=" . $row['id'] . "'>Удалить</a></td>";
                    }
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='4'>Нет транзакций для отображения</td></tr>";
            }
            ?>
        </table>
    </div>
</body>
</html>
