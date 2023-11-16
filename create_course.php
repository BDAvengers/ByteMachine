<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/style.css">
</head> 
<body>
    <?php require 'blocks/header.php' ?>
    <?php
        if (isset($_SESSION['clients'])) {
            header('Location: course.php');
        }
    ?>

    <?php 
        if (isset($_SESSION['message'])) {
            echo '<p class="msg"> ' . $_SESSION['message'] . ' </p>';
            unset($_SESSION['message']);
        }
    ?>

    <form class="newcourse" action="vender/save_course.php" method="post">
        <label for="course_name">Название курса:</label>
        <input type="text" id="course_name" name="course_name">

        <label for="price">Цена:</label>
        <input type="text" id="price" name="price">

        <input type="hidden" id="emp_id" name="emp_id" value="<?php echo (isset($_SESSION['emp_id'])); ?>">

        <label for="lvl">Уровень сложности:</label>
        <input type="text" id="lvl" name="lvl">

        <label for="overview">Обзор курса:</label>
        <textarea id="overview" name="overview" rows="4"></textarea>

        <label for="duration">Продолжительность курса (в месяцах):</label>
        <input type="text" id="duration" name="duration">

        <label for="hour_count">Количество часов в неделю:</label>
        <input type="text" id="hour_count" name="hour_count">

        <label for="ind_group">Индивидуальное занятие:</label>
        <input type="text" id="ind_group" name="ind_group">

        <label for="group_group">Групповое занятие:</label>
        <input type="text" id="group_group" name="group_group">

        <input type="submit" value="Создать курс">
    </form>

</body>
</html>
