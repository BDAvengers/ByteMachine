<?php 
    session_start();
    require "connect.php";

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $client_id = $_SESSION['client_id']; 
        $group_id = $_POST['group_id']; 

        $statment = $connect->prepare("SELECT status FROM trans where client_id = :client_id and group_id = :group_id");
        $statment->bindParam(':client_id', $client_id);
        $statment->bindParam(':group_id', $group_id);
        $statment->execute();
        $status = $statment->fetchColumn();

        if ($status == 'Забронирован') {
            $_SESSION['message'] = "Вы все еше не купили курс. Если вы оплатили, пожалуйста, подождите. Оплата поступает в течение минуты";
            header("Location: ../confirm_course.php?group_id=$group_id");
            exit();
        } else if ($status == 'Не оплачен') {
            $_SESSION['message'] = "Ошибка при покупка курса. Пожалуйста, убедитесь что вы оплатили полную сумму и без ошибок при заполнение";
            header("Location: ../confirm_course.php?group_id=$group_id");
            exit();
        } else if ($status == 'Оплачен') {
            $_SESSION['message'] = "Поздравляем! Вы успешно купили курс. Теперь вы можете просматривать его в этом странице. Спасибо за покупку, и приятного обучения!";
            header("Location: ../profile/my_courses.php");
            exit();
        }
    } 
?>
