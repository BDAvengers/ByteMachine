<?php
session_start();
require 'connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $client_id = $_SESSION['client_id'];      
    $group_id = $_POST['group_id'];  

    // Проверка наличия записи в таблице trans
    $checkStmt = $connect->prepare("SELECT COUNT(*) FROM trans WHERE client_id = :client_id AND group_id = :group_id 
    AND status = 'Оплачен'");
    $checkStmt->bindParam(':client_id', $client_id);
    $checkStmt->bindParam(':group_id', $group_id);
    $checkStmt->execute();
    $count = $checkStmt->fetchColumn();

    // Проверка максимального количества для типа группы
    $stmt_max_capacity = $connect->prepare("SELECT group_type FROM groups_all WHERE group_id = :group_id ");
    $stmt_max_capacity->bindParam(':group_id', $group_id);
    $stmt_max_capacity->execute();
    $group_type = $stmt_max_capacity->fetchColumn();

    $max_capacity = ($group_type == 'individual') ? 1 : 10;

    // Проверка текущего количества записей в таблице trans
    $stmt_count = $connect->prepare("SELECT COUNT(*) FROM trans WHERE group_id = :group_id AND status in ('Оплачен', 'Забронирован')");
    $stmt_count->bindParam(':group_id', $group_id);
    $stmt_count->execute();
    $current_count = $stmt_count->fetchColumn();

    if ($count > 0) {
        $_SESSION['message'] = "Вы уже купили этот курс.";
        header("Location: ../schedule.php?group_id=$group_id");
        exit();
    } elseif ($current_count >= $max_capacity) {
        // Курс уже заполнен
        $_SESSION['message'] = "Курс уже заполнен. Невозможно провести покупку.";
        header("Location: ../schedule.php?group_id=$group_id");
        exit();
    } else {
        // Курс еще не заполнен, проводим процесс покупки
        $timezone = new DateTimeZone('Asia/Almaty');
        $date = new DateTime('now', $timezone);
        $date_pay = $date->format('Y-m-d H:i:s'); // Текущая дата и время

        // Подготовка SQL-запроса
        $stmt = $connect->prepare("INSERT INTO trans (client_id, date_pay, group_id, status) 
        VALUES (:client_id, :date_pay, :group_id, 'Забронирован')");
        $stmt->bindParam(':client_id', $client_id);
        $stmt->bindParam(':date_pay', $date_pay);
        $stmt->bindParam(':group_id', $group_id);

        if ($stmt->execute()) {
            $stmt2 = $connect->prepare("SELECT date_pay FROM trans WHERE client_id = :client_id AND group_id = :group_id");
            $stmt2->bindParam(':client_id', $client_id);
            $stmt2->bindParam(':group_id', $group_id);
            $stmt2->execute();
            $date_pay_client = $stmt2->fetchColumn();

            // Добавляем 1 минуту к $date_pay_client
            $date_pay_client_modified = new DateTime($date_pay_client, $timezone);
            $date_pay_client_modified->modify('+1 minute');
            
            if ($date_pay >= $date_pay_client_modified) {
                // Через минуту обновляем статус на "Не оплачен"
                $stmt_update = $connect->prepare("UPDATE trans SET status = 'Не оплачен' WHERE client_id = :client_id AND group_id = :group_id");
                $stmt_update->bindParam(':client_id', $client_id);
                $stmt_update->bindParam(':group_id', $group_id);
                $stmt_update->execute();
            }

            header("Location: https://kaspi.kz/pay/_gate?action=service_with_subservice&service_id=3025&subservice_id=20217&region_id=18");
            exit();
        }
    }
}
?>
