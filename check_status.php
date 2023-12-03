<?php
    require 'vender/connect.php'; // Исправил опечатку в пути к файлу connect.php
    $timezone = new DateTimeZone('Asia/Almaty');
    $date = new DateTime('now', $timezone);
    $date_pay = $date->format('Y-m-d H:i:s'); // Текущая дата и время

    $stmt = $connect->prepare("SELECT date_pay FROM trans WHERE client_id = 19 AND group_id = 21");
    $stmt->execute();
    $date_pay_client = $stmt->fetchColumn();

    // Добавляем 1 минуту к $date_pay_client
    $date_pay_client_modified = new DateTime($date_pay_client, $timezone);
    $date_pay_client_modified->modify('+1 minute');
    // Выводим результат
    echo "Исходная дата клиента: $date_pay_client<br>";
    echo "Дата клиента с добавлением 1 минуты: " . $date_pay_client_modified->format('Y-m-d H:i:s') . '<br>';
    echo "Текущая дата и время: $date_pay<br>";

   
?>
