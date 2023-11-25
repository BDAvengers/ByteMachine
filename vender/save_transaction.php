<?php
session_start();
require 'connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $status_from_bank = $_POST['status'];
    $group_id = $_POST['group_id'];
    $client_id = $_SESSION['client_id'];

    // Подзапрос для выбора последнего trans_id
    $last_trans_id_query = $connect->prepare("SELECT MAX(trans_id) FROM trans WHERE group_id = :group_id AND client_id = :client_id");
    $last_trans_id_query->bindParam(':group_id', $group_id);
    $last_trans_id_query->bindParam(':client_id', $client_id);
    $last_trans_id_query->execute();
    $last_trans_id = $last_trans_id_query->fetchColumn();

    // Обновление статуса в последней записи
    $update_stmt = $connect->prepare("UPDATE trans SET status = :status_from_bank WHERE trans_id = :last_trans_id");
    $update_stmt->bindParam(':status_from_bank', $status_from_bank);
    $update_stmt->bindParam(':last_trans_id', $last_trans_id);
    $update_stmt->execute();

    if ($status_from_bank === 'Оплачен') {
        $_SESSION['message'] = "Поздравляем! Вы успешно купили курс. Теперь вы можете просматривать его в своем личном кабинете на странице 'Мои курсы'. Спасибо за покупку, и приятного обучения!";
    } elseif ($status_from_bank === 'Не оплачен') {
        $_SESSION['message'] = "Курс не оплачен.";
    }

    header("Location: ../schedule.php?group_id=$group_id");
    exit();
}

?>
