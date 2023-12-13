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


$statement = $connect->prepare("SELECT * FROM employees WHERE email = :email");
$statement->bindParam(':email', $email);
$statement->execute();
$employee = $statement->fetch(PDO::FETCH_ASSOC);

if ($employee['status'] !== 1 && $employee && password_verify($password, $employee['password'])) {
    $_SESSION['message'] = "Пожалуйста, подтвердите почту";
    header('Location: ../sign-in.php');
    exit();
} else if ($employee['status'] == 1 && $employee && password_verify($password, $employee['password'])) {
    $_SESSION['employees'] = [
        "emp_id" => $employee['emp_id'],
        "full_name" => $employee['full_name'],
        "email" => $employee['email'],
        "phone_number" => $employee['phone_number'], 
        "date_birth" => $employee['date_birth']
    ];
    $_SESSION['emp_id'] = $employee['emp_id'];
    header('Location: ../index.php');
    exit();
}

$statement = $connect->prepare("SELECT * FROM clients WHERE email = :email");
$statement->bindParam(':email', $email);
$statement->execute();
$client = $statement->fetch(PDO::FETCH_ASSOC);

if ($client['status'] !== 1 && $client && password_verify($password, $client['password'])) {
    $_SESSION['message'] = "Пожалуйста, подтвердите почту";
    header('Location: ../sign-in.php');
    exit();

} else if ($client['status'] == 1 && $client && password_verify($password, $client['password'])) {
    $_SESSION['clients'] = [
        "client_id" => $client['client_id'],
        "full_name" => $client['full_name'],
        "email" => $client['email'],
        "phone_number" => $client['phone_number'],
        "date_birth" => $client['date_birth']
    ];
    $_SESSION['client_id'] = $client['client_id'];
    header('Location: ../index.php');
    exit();
} 

$_SESSION['message'] = "Неверный email или пароль";
header('Location: ../sign-in.php');
exit();
?>
