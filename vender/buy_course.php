<?php
    session_start();
    require 'connect.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $client_id = $_SESSION['client_id'];      
        $group_id = $_POST['group_id'];  
        
        $timezone = new DateTimeZone('Asia/Almaty');
        $date = new DateTime('now', $timezone);
        $date_pay = $date->format('Y-m-d H:i:s'); // Текущая дата и время

        // Подготовка SQL-запроса
        $stmt = $connect->prepare("INSERT INTO trans (client_id, date_pay, group_id, status) 
        VALUES (:client_id, :date_pay, :group_id, 'Забронирован')");
        $stmt->bindParam(':client_id', $client_id);
        $stmt->bindParam(':date_pay', $date_pay);
        $stmt->bindParam(':group_id', $group_id);
        $stmt->execute();

        echo '<form action="https://kaspi.kz/pay/_gate?action=service_with_subservice&service_id=3025&subservice_id=20217&region_id=18" method="post" target="_blank">';
        echo '<input type="submit" value="Перейти к оплате">';
        echo '</form>';
    }
?>
