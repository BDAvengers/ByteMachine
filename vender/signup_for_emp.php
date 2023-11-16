<?php
    session_start();
    $full_name = filter_var(trim($_POST['full_name'] ?? ''), FILTER_SANITIZE_STRING);
    $email = filter_var(trim($_POST['email'] ?? ''), FILTER_SANITIZE_STRING);
    $phone_number = filter_var(trim($_POST['phone_number'] ?? ''), FILTER_SANITIZE_STRING);
    $password = filter_var(trim($_POST['password'] ?? ''), FILTER_SANITIZE_STRING);
    $password_confirm = filter_var(trim($_POST['password_confirm'] ?? ''), FILTER_SANITIZE_STRING);
    $phone_number_pattern = '/^8{1}7{1}\d{9}$/'; // Регулярное выражение для проверки номера телефона 

    if (empty($full_name) || empty($email) || empty($phone_number) || empty($password) || empty($password_confirm)) {
        $_SESSION['message'] = 'Пожалуйста, заполните все поля';
        header('Location: ../sign-up.php');
        exit();
    }

    if (mb_strlen($full_name) < 4 || mb_strlen($full_name) > 50) {
        $_SESSION['message'] = "Недопустимая ФИО";
        header('Location: ../sign-up.php');
        exit();
    } else if (!preg_match($phone_number_pattern, $phone_number)) {
        $_SESSION['message'] = "Введите номер телефона в формате 87776665544";
        header('Location: ../sign-up.php');
        exit();
    } else if (mb_strlen($password) < 6 || mb_strlen($password) > 30) {
        $_SESSION['message'] = "Пароль должен содержать от 6 до 30 символов";
        header('Location: ../sign-up.php');
        exit();
    }

    if ($password !== $password_confirm) {
        $_SESSION['message'] = 'Пароли не совпадают';
        header('Location: ../sign-up.php');
        exit();
    }

    if (!preg_match($phone_number_pattern, $phone_number)) {
        $_SESSION['message'] = "Введите номер телефона в формате 87776665544";
        header('Location: ../sign-up.php');
        exit();
    }

    require 'connect.php';
    
    $check_statement2 = $connect->prepare("SELECT * FROM employees WHERE email = :email");
    $check_statement2->bindParam(':email', $email);
    $check_statement2->execute();
    $existing_email2 = $check_statement2->fetch();

    if ($existing_email2) {
        $_SESSION['message'] = 'Такой email уже существует';
        header('Location: ../sign-up.php');
        exit();
    }
 
    // Хеширование пароля
    $password = md5($password."jfgdhds2345");

    $statement = $connect->prepare("INSERT INTO employees (full_name, email, phone_number, password) VALUES (:full_name, :email, :phone_number, :password)");
    $statement->bindParam(':full_name', $full_name);
    $statement->bindParam(':email', $email);
    $statement->bindParam(':phone_number', $phone_number);
    $statement->bindParam(':password', $password);
    $statement->execute();

    $_SESSION['message'] = 'Регистрация прошла успешно!';
    header('Location: ../sign-in.php');
    exit();
?>
