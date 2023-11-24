<?php
session_start();
require 'connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $client_id = $_SESSION['client_id'];      
    $group_id = $_POST['group_id'];

    // Проверка наличия записи в таблице trans
    $checkStmt = $connect->prepare("SELECT COUNT(*) FROM trans WHERE client_id = :client_id AND group_id = :group_id");
    $checkStmt->bindParam(':client_id', $client_id);
    $checkStmt->bindParam(':group_id', $group_id);
    $checkStmt->execute();
    $count = $checkStmt->fetchColumn();

    if ($count > 0) {
        // Курс уже был куплен
        $_SESSION['message'] = "Вы уже купили этот курс.";
    } else {
        // Курс еще не был куплен, проводим процесс покупки
        $timezone = new DateTimeZone('Asia/Almaty');
        $date = new DateTime('now', $timezone);
        $date_pay = $date->format('Y-m-d H:i:s'); // Текущая дата и время

        // Подготовка SQL-запроса
        $stmt = $connect->prepare("INSERT INTO trans (client_id, date_pay, group_id) 
        VALUES (:client_id, :date_pay, :group_id)");
        $stmt->bindParam(':client_id', $client_id);
        $stmt->bindParam(':date_pay', $date_pay);
        $stmt->bindParam(':group_id', $group_id);
        $stmt->execute();
        
        $_SESSION['message'] = "Поздравляем! Вы успешно купили курс. Теперь вы можете просматривать его в своем личном кабинете на странице 'Мои курсы'. Спасибо за покупку, и приятного обучения!";
    }

    header("Location: ../schedule.php?group_id=$group_id");
    exit();
}
?>
