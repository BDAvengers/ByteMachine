<?php
    session_start(); 
    require 'connect.php';
    $course_name = filter_var(trim($_POST['course_name'] ?? ''), FILTER_SANITIZE_STRING);
    $emp_id = $_SESSION['emp_id']; // Получаем emp_id из сессии
    $lvl = filter_var(trim($_POST['lvl'] ?? ''), FILTER_SANITIZE_STRING);
    $overview = filter_var(trim($_POST['overview'] ?? ''), FILTER_SANITIZE_STRING);
    $duration = filter_var(trim($_POST['duration'] ?? ''), FILTER_SANITIZE_STRING);
    $ind_group = filter_var(trim($_POST['ind_group'] ?? ''), FILTER_SANITIZE_STRING);
    $ind_price = filter_var(trim($_POST['ind_price'] ?? ''), FILTER_SANITIZE_STRING);
    $group_group = filter_var(trim($_POST['group_group'] ?? ''), FILTER_SANITIZE_STRING);
    $group_price = filter_var(trim($_POST['group_price'] ?? ''), FILTER_SANITIZE_STRING);

    if (empty($course_name) || empty($lvl) || empty($overview) || empty($duration))  {
        $_SESSION['message'] = 'Пожалуйста, заполните все поля';
        header('Location: ../create_course.php');
        exit();
    } 

    $statement = $connect->prepare("INSERT INTO courses (course_name, emp_id, lvl, overview, duration, ind_group, ind_price, group_group, group_price) 
    VALUES (:course_name, :emp_id, :lvl, :overview, :duration, :ind_group, :ind_price, :group_group, :group_price)");
    $statement->bindParam(':course_name', $course_name);
    $statement->bindParam(':emp_id', $emp_id);
    $statement->bindParam(':lvl', $lvl);
    $statement->bindParam(':overview', $overview);
    $statement->bindParam(':duration', $duration);
    $statement->bindParam(':ind_group', $ind_group);
    $statement->bindParam(':ind_price', $ind_price);
    $statement->bindParam(':group_group', $group_group);
    $statement->bindParam(':group_price', $group_price);

    if ($statement->execute()) {
        $course_id_stmt = $connect->query("SELECT last_value FROM courses_course_id_seq");
        $course_id = $course_id_stmt->fetchColumn();
        $_SESSION['message'] = 'Курс успешно создан, теперь добавьте расписание!';
        header("Location: ../profile/change.php?course_id=$course_id");
        exit();
    } else {
        $_SESSION['message'] = 'Ошибка при создании курса';
        header('Location: ../create_course.php');
        exit();
    }
?> 
