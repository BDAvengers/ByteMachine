<?php 
    session_start();

    require 'connect.php';

    $client_id = $_SESSION['client_id'];      
    $group_id = $_POST['group_id'];  


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
                header("Location: ../confirm_course.php?group_id=$group_id");
                exit();
            }       
?>