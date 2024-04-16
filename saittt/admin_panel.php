<?php
session_start();
include 'db_connection.php';

if (!isset($_SESSION['loggedin'])) {
    header("Location: login.php");
    exit;
}

// Получение всех транзакций
$sql = "SELECT * FROM transactions";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html>
<head>
    <title>Админ панель</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <div style="text-align: right;">
            <a href="dashboard.php" style="text-decoration: none; color: black; font-size: 24px;">Личный кабинет</a> |
            <a href="logout.php" style="text-decoration: none; color: black; font-size: 24px;">Выйти</a>
        </div>
        <h2>Админ панель</h2>
        
        <h3>Транзакции</h3>
        <table border="1" style="text-align: center; margin-left: 35px">
            <tr>
                <th>ID</th>
                <th>Пользователь</th>
                <th>Тип</th>
                <th>Сумма</th>
                <th>Дата</th>
                <th>Категория</th>
                <th>Действие</th>
            </tr>
            <?php
            if ($result !== null && $result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    // Получение имени пользователя по ID
                    $user_id = $row['user_id'];
                    $sql_user = "SELECT username FROM users WHERE id='$user_id'";
                    $result_user = $conn->query($sql_user);
                    $row_user = $result_user->fetch_assoc();
                    $username = $row_user['username'];
                    
                    echo "<tr>";
                    echo "<td>" . $row['id'] . "</td>";
                    echo "<td>" . $username . "</td>";
                    echo "<td>" . $row['type'] . "</td>";
                    echo "<td>" . $row['amount'] . "</td>";
                    echo "<td>" . $row['date'] . "</td>";
                    echo "<td>" . $row['category'] . "</td>";
                    echo "<td><a href='admin_panel.php?delete_id=" . $row['id'] . "'>Удалить</a></td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='7'>Нет транзакций для отображения</td></tr>";
            }
            
            // Удаление транзакции
            if(isset($_GET['delete_id'])) {
                $delete_id = $_GET['delete_id'];
                $sql_delete = "DELETE FROM transactions WHERE id='$delete_id'";
                if ($conn->query($sql_delete) === TRUE) {
                    echo "<script>alert('Транзакция успешно удалена');</script>";
                    header("Location: admin_panel.php");
                } else {
                    echo "<script>alert('Ошибка при удалении транзакции: " . $conn->error . "');</script>";
                }
            }
            ?>
        </table>
    </div>
</body>
</html>
