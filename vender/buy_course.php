<?php
    session_start();
    require 'connect.php';
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $client_id = $_SESSION['client_id'];      
        $group_id = $_POST['group_id'];
        $date_pay = date('Y-m-d H:i:s'); // Текущая дата

    // Подготовка SQL-запроса
    $stmt = $connect->prepare("INSERT INTO trans (client_id, date_pay, group_id) 
    VALUES (:client_id, :date_pay, :group_id)");
    $stmt->bindParam(':client_id', $client_id);
    $stmt->bindParam(':date_pay', $date_pay);
    $stmt->bindParam(':group_id', $group_id);
    $stmt->execute();
    
    $_SESSION['message'] = "Поздравляем! Вы успешно купили курс. Теперь вы можете просматривать его в своем личном кабинете на странице 'Мои курсы'. Спасибо за покупку, и приятного обучения!";
    header("Location: ../schedule.php?group_id=$group_id");
    exit();
    }
?>