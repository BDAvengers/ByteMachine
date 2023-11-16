<?php 
session_start();
require 'connect.php';
$times = $_POST['time'];
$day_1s = $_POST['day_1'];
$day_2s = $_POST['day_2'];
$day_3s = $_POST['day_3'];
$day_4s = $_POST['day_4'];
$day_5s = $_POST['day_5'];
$day_6s = $_POST['day_6'];
$day_7s = $_POST['day_7'];

$group_id = $_POST['group_id'];

// Проверим, есть ли уже данные для данной группы
$checkStatement = $connect->prepare("SELECT COUNT(*) FROM schedule");
$checkStatement->execute();
$count = $checkStatement->fetchColumn();

if ($count > 0) {
    // Используйте столбец "time" как условие обновления записей
    $statement = $connect->prepare("UPDATE schedule SET day_1 = :day_1, day_2 = :day_2, day_3 = :day_3, 
    day_4 = :day_4, day_5 = :day_5, day_6 = :day_6, day_7 = :day_7 WHERE time = :time");
    $statement->bindParam(':time', $time);
} else { 
    // Если данных ещё нет, выполним операцию вставки
    $statement = $connect->prepare("INSERT INTO schedule (time, day_1, day_2, day_3, day_4, day_5, day_6, day_7) 
    VALUES (:time, :day_1, :day_2, :day_3, :day_4, :day_5, :day_6, :day_7)");
    $statement->bindParam(':time', $time);
}

$isEmpty = true;

foreach ($times as $index => $time) {
    $day_1 = isset($day_1s[$index]) && $day_1s[$index] !== '' ? filter_var(trim($day_1s[$index]), FILTER_VALIDATE_INT) : null;
    $day_2 = isset($day_2s[$index]) && $day_2s[$index] !== '' ? filter_var(trim($day_2s[$index]), FILTER_VALIDATE_INT) : null;
    $day_3 = isset($day_3s[$index]) && $day_3s[$index] !== '' ? filter_var(trim($day_3s[$index]), FILTER_VALIDATE_INT) : null;
    $day_4 = isset($day_4s[$index]) && $day_4s[$index] !== '' ? filter_var(trim($day_4s[$index]), FILTER_VALIDATE_INT) : null;
    $day_5 = isset($day_5s[$index]) && $day_5s[$index] !== '' ? filter_var(trim($day_5s[$index]), FILTER_VALIDATE_INT) : null;
    $day_6 = isset($day_6s[$index]) && $day_6s[$index] !== '' ? filter_var(trim($day_6s[$index]), FILTER_VALIDATE_INT) : null;
    $day_7 = isset($day_7s[$index]) && $day_7s[$index] !== '' ? filter_var(trim($day_7s[$index]), FILTER_VALIDATE_INT) : null;

    if ($time || $day_1 || $day_2 || $day_3 || $day_4 || $day_5 || $day_6 || $day_7) {
        $isEmpty = false;
        $statement->bindParam(':time', $time);
        $statement->bindParam(':day_1', $day_1);
        $statement->bindParam(':day_2', $day_2);
        $statement->bindParam(':day_3', $day_3);
        $statement->bindParam(':day_4', $day_4);
        $statement->bindParam(':day_5', $day_5);
        $statement->bindParam(':day_6', $day_6);
        $statement->bindParam(':day_7', $day_7);
        $statement->execute();
    }
}

if ($isEmpty) {
    $_SESSION['message'] = 'Пожалуйста, добавьте расписание';
    header("Location: ../create_schedule.php?group_id=$group_id");
    exit();
} else {
    $_SESSION['message'] = 'Расписания успешно сохранены!';
    header("Location: ../create_schedule.php?group_id=$group_id");
    exit();
}
?>
