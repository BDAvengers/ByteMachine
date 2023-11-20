<?php
session_start();
require 'connect.php';

$group_id = $_POST['group_id'];
$times = $_POST['time'];
$days = array('day_1', 'day_2', 'day_3', 'day_4', 'day_5', 'day_6', 'day_7');

foreach ($times as $index => $time) {
    // Динамически строим запрос и параметры
    $updateClause = '';
    $params = array(':time' => $time);

    foreach ($days as $day) {
        $value = isset($_POST["$day"][$index]) ? filter_var(trim($_POST["$day"][$index]), FILTER_VALIDATE_INT) : null;

        // Преобразуем 0 в NULL
        $value = ($value !== false) ? $value : null;

        // Добавляем параметр в массив
        $paramName = ":$day";
        $params[$paramName] = $value;

        // Добавляем к части запроса
        $updateClause .= "$day = $paramName, ";
    }

    // Удаляем последнюю запятую и пробел
    $updateClause = rtrim($updateClause, ', ');

    $statement = $connect->prepare("UPDATE schedule SET $updateClause WHERE time = :time");

    // Биндим параметры динамически
    foreach ($params as $paramName => &$paramValue) {
        $paramType = is_null($paramValue) ? PDO::PARAM_NULL : PDO::PARAM_INT;
        $statement->bindParam($paramName, $paramValue, $paramType);
    }
    $statement->execute();
}

$_SESSION['message'] = 'Расписание успешно сохранено!';
header("Location: ../test_schedule.php?group_id=$group_id");
exit();
?>
