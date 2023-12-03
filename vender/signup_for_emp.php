<?php
    session_start();
    
    function saveFormData($data)
    {
        $_SESSION['form_data'] = $data;
    }
    
    // Функция для получения сохраненных данных из сессии
    function getFormData()
    {
        $formData = $_SESSION['form_data'] ?? [];
        unset($_SESSION['form_data']); // Очистим сохраненные данные после использования
        return $formData;
    }

    $full_name = filter_var(trim($_POST['full_name'] ?? ''), FILTER_SANITIZE_STRING);
    $date_birth = filter_var(trim($_POST['date_birth'] ?? ''), FILTER_SANITIZE_STRING);
    $email = filter_var(trim($_POST['email'] ?? ''), FILTER_SANITIZE_STRING);
    $phone_number = filter_var(trim($_POST['phone_number'] ?? ''), FILTER_SANITIZE_STRING);
    $password = filter_var(trim($_POST['password'] ?? ''), FILTER_SANITIZE_STRING);
    $password_confirm = filter_var(trim($_POST['password_confirm'] ?? ''), FILTER_SANITIZE_STRING);
    $phone_number_pattern = '/^8{1}7{1}\d{9}$/';
    $phone_number_pattern2 = '/^\+77\d{9}$/';

    $timezone = new DateTimeZone('Asia/Almaty');
    $date = new DateTime('now', $timezone);
    $date_hire = $date->format('Y-m-d'); // Текущая дата и время

    if (empty($full_name) || empty($email) || empty($phone_number) || empty($password) || empty($password_confirm) || empty($date_birth)) {
        saveFormData([
            'full_name' => $full_name,
            'date_birth' => $date_birth,
            'email' => $email,
            'phone_number' => $phone_number,
            'password' => $password,
            'password_confirm' => $password_confirm
        ]);
        $_SESSION['message'] = 'Пожалуйста, заполните все поля';
        header('Location: ../sign-up_for_emp.php');
        exit();
    }

    if (mb_strlen($full_name) < 4 || mb_strlen($full_name) > 50) {
        saveFormData([
            'full_name' => $full_name,
            'date_birth' => $date_birth,
            'email' => $email,
            'phone_number' => $phone_number,
            'password' => $password,
            'password_confirm' => $password_confirm
        ]);
        $_SESSION['message'] = "Недопустимая ФИО";
        header('Location: ../sign-up_for_emp.php');
        exit();
    } else if (!preg_match($phone_number_pattern, $phone_number) && !preg_match($phone_number_pattern2, $phone_number)) {
        saveFormData([
            'full_name' => $full_name,
            'date_birth' => $date_birth,
            'email' => $email,
            'phone_number' => $phone_number,
            'password' => $password,
            'password_confirm' => $password_confirm
        ]);
        $_SESSION['message'] = "Введите номер телефона в формате 87776665544 или +77776665544";
        header('Location: ../sign-up_for_emp.php');
        exit();
    } else if (mb_strlen($password) < 6 || mb_strlen($password) > 50) {
        saveFormData([
            'full_name' => $full_name,
            'date_birth' => $date_birth,
            'email' => $email,
            'phone_number' => $phone_number,
            'password' => $password,
            'password_confirm' => $password_confirm
        ]);
    
        $_SESSION['message'] = "Пароль должен содержать от 6 до 50 символов";
        header('Location: ../sign-up_for_emp.php');
        exit();
    }

    if ($password !== $password_confirm) {
        saveFormData([
            'full_name' => $full_name,
            'date_birth' => $date_birth,
            'email' => $email,
            'phone_number' => $phone_number,
            'password' => $password,
            'password_confirm' => $password_confirm
        ]);
        $_SESSION['message'] = 'Пароли не совпадают';
        header('Location: ../sign-up_for_emp.php');
        exit();
    }

    require 'connect.php';
    $check_statement = $connect->prepare("SELECT * FROM clients WHERE email = :email");
    $check_statement->bindParam(':email', $email);
    $check_statement->execute();
    $existing_email = $check_statement->fetch();

    if ($existing_email) {
        saveFormData([
            'full_name' => $full_name,
            'date_birth' => $date_birth,
            'email' => $email,
            'phone_number' => $phone_number,
            'password' => $password,
            'password_confirm' => $password_confirm
        ]);
        $_SESSION['message'] = 'Такой email уже существует';
        header('Location: ../sign-up_for_emp.php');
        exit();
    }
    
    $check_statement2 = $connect->prepare("SELECT * FROM employees WHERE email = :email");
    $check_statement2->bindParam(':email', $email);
    $check_statement2->execute();
    $existing_email2 = $check_statement2->fetch();

    if ($existing_email2) {
        saveFormData([
            'full_name' => $full_name,
            'date_birth' => $date_birth,
            'email' => $email,
            'phone_number' => $phone_number,
            'password' => $password,
            'password_confirm' => $password_confirm
        ]);
        $_SESSION['message'] = 'Такой email уже существует';
        header('Location: ../sign-up_for_emp.php');
        exit();
    }

    unset($_SESSION['form_data']);
 
    $password_hash = password_hash($password, PASSWORD_BCRYPT);

    $statement = $connect->prepare("INSERT INTO employees (full_name, date_birth, email, phone_number, password, date_hire) 
    VALUES (:full_name, :date_birth, :email, :phone_number, :password, :date_hire)");

    $statement->bindParam(':full_name', $full_name);
    $statement->bindParam(':date_birth', $date_birth);
    $statement->bindParam(':email', $email);
    $statement->bindParam(':phone_number', $phone_number);
    $statement->bindParam(':password', $password_hash);
    $statement->bindParam(':date_hire', $date_hire);
    $statement->execute();

    $_SESSION['message'] = 'Регистрация прошла успешно!';
    header('Location: ../sign-in.php');
    exit();
?>
