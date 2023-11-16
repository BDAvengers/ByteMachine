<?php 
    session_start();
    $email = filter_var(trim($_POST['email'] ?? ''), FILTER_SANITIZE_STRING);
    $password = filter_var(trim($_POST['password'] ?? ''), FILTER_SANITIZE_STRING);
 
    if (empty($email) || empty($password)) {
        $_SESSION['message'] = "Пожалуйста, введите email и пароль";
        header('Location: ../sign-in.php');
        exit(); 
    }

    require 'connect.php';  

    $password = md5($password."jfgdhds2345");

    $statement = $connect->prepare("SELECT * FROM employees WHERE email = :email AND password = :password");
    $statement->bindParam(':email', $email);
    $statement->bindParam(':password', $password);
    $statement->execute();
    $employees = $statement->fetch(PDO::FETCH_ASSOC);

    if ($employees) {
        $_SESSION['employees'] = [
            "emp_id" => $employees['emp_id'], 
            "full_name" => $employees['full_name'],
            "email" => $employees['email'],
            "phone_number" => $employees['phone_number'],
            "date_birth" => $employees['date_birth']
        ];
        $_SESSION['emp_id'] = $employees['emp_id'];
        header('Location: ../profile.php');
        exit();
    } 
    
    $statement = $connect->prepare("SELECT * FROM clients WHERE email = :email AND password = :password");
    $statement->bindParam(':email', $email);
    $statement->bindParam(':password', $password);
    $statement->execute();
    $clients = $statement->fetch(PDO::FETCH_ASSOC);

    if ($clients) {
        $_SESSION['clients'] = [
            "client_id" => $clients['client_id'], 
            "full_name" => $clients['full_name'],
            "email" => $clients['email'],
            "phone_number" => $clients['phone_number']
        ];
        $_SESSION['client_id'] = $clients['client_id'];
        header('Location: ../profile.php');
        exit();
    } 

    $_SESSION['message'] = "Неверный email или пароль";
    header('Location: ../sign-in.php');
    exit();
?>
