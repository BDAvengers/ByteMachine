<?php
    session_start();
    require 'vender/connect.php';

    $client_id = $_SESSION['client_id'];

    $statment = $connect->prepare("SELECT count(*) from trans WHERE client_id = :client_id AND group_id = 13 AND status = 'Забронирован'");
    $statment->bindparam(':client_id', $client_id);
    $statment->execute();
    $count = $statment->fetchColumn();

    if ($count === 1) {
        $interval = 10; // интервал в секундах

        while (true) {
            $stmt = $connect->prepare("SELECT status FROM trans WHERE client_id = :client_id AND group_id = 13");
            $stmt->bindParam(':client_id', $client_id);
            $stmt->execute();
            $status = $stmt->fetchColumn();

            if ($status == 'Забронирован') {
                // Если статус "Забронирован" и прошла минута, обновляем статус
                $stmt_update = $connect->prepare("UPDATE trans SET status = 'Не оплачен' WHERE client_id = :client_id AND group_id = 13 AND date_pay + INTERVAL '1 minute' <= NOW()");
                $stmt_update->bindParam(':client_id', $client_id);
                $stmt_update->execute();
            }

            sleep($interval);
        }
    } else {

    }
?>
