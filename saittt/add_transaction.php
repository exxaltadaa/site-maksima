<?php
session_start();
include 'db_connection.php';

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['id'];
    $type = $_POST['type'];
    $amount = $_POST['amount'];
    $date = $_POST['date'];
    $category = $_POST['category'];

    // Подготовленный запрос для вставки данных
    $stmt = $conn->prepare("INSERT INTO transactions (user_id, type, amount, date, category) VALUES (?, ?, ?, ?, ?)");
    
    // Проверка на успешное создание запроса
    if ($stmt === false) {
        die('Ошибка при подготовке запроса: ' . $conn->error);
    }
    
    // Привязка параметров и выполнение запроса
    $stmt->bind_param("isdss", $user_id, $type, $amount, $date, $category);
    if ($stmt->execute()) {
        $message = "Транзакция успешно добавлена";
    } else {
        $message = "Ошибка при добавлении транзакции: " . $conn->error;
    }
    
    // Закрытие запроса
    $stmt->close();
}

// Закрытие соединения с базой данных
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Добавить транзакцию</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<header>
    <h2 style="color: white;">Добавить транзакцию</h2>
</header>
<div class="container">
    <div style="text-align: right;">
        <a href="dashboard.php" style="text-decoration: none; color: black; font-size: 24px;">Назад</a>
    </div>
    <div class="form-container">
        <h3>Добавить транзакцию</h3>
        <?php echo $message; ?>
        
    </div>
</div>
</body>
</html>

