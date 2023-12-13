<?php
session_start();
require 'connect.php';

if (isset($_GET['token'])) {
    $token = $_GET['token'];

    $isClient = false;
    $isEmployee = false;

    // Проверяем, является ли токен клиентским
    $statementClient = $connect->prepare("SELECT verify_token, status FROM clients WHERE verify_token = :token");
    $statementClient->bindParam(':token', $token);
    $statementClient->execute();
    $verifyQueryClient = $statementClient->fetch(PDO::FETCH_ASSOC);

    if ($verifyQueryClient) {
        $isClient = true;
    }

    // Проверяем, является ли токен сотрудническим
    $statementEmployee = $connect->prepare("SELECT verify_token, status FROM employees WHERE verify_token = :token");
    $statementEmployee->bindParam(':token', $token);
    $statementEmployee->execute();
    $verifyQueryEmployee = $statementEmployee->fetch(PDO::FETCH_ASSOC);

    if ($verifyQueryEmployee) {
        $isEmployee = true;
    }

    // Обработка токена клиента
    if ($isClient && $verifyQueryClient['status'] == 0) {
        $updateStatement = $connect->prepare("UPDATE clients SET status = 1 WHERE verify_token = :token");
        $updateStatement->bindParam(':token', $token);
        $updateStatement->execute();

        $_SESSION['message'] = 'Электронная почта успешно подтверждена!';
        header("Location: ../sign-in.php");
        exit();
    } elseif ($isClient && $verifyQueryClient['status'] == 1) {
        $_SESSION['message'] = 'Электронная почта уже подтверждена. Пожалуйста, войдите в аккаунт!';
        header("Location: ../sign-in.php");
        exit();
    }

    // Обработка токена сотрудника
    if ($isEmployee && $verifyQueryEmployee['status'] == 0) {
        $updateStatement = $connect->prepare("UPDATE employees SET status = 1 WHERE verify_token = :token");
        $updateStatement->bindParam(':token', $token);
        $updateStatement->execute();

        $_SESSION['message'] = 'Электронная почта успешно подтверждена!';
        header("Location: ../sign-in.php");
        exit();
    } elseif ($isEmployee && $verifyQueryEmployee['status'] == 1) {
        $_SESSION['message'] = 'Электронная почта уже подтверждена. Пожалуйста, войдите в аккаунт!';
        header("Location: ../sign-in.php");
        exit();
    }

    // Если токен не соответствует ни клиенту, ни сотруднику
    $_SESSION['message'] = 'Недействительный токен подтверждения.';
    header("Location: ../sign-up.php");
    exit();
} else {
    $_SESSION['message'] = 'Отсутствует токен подтверждения.';
    header("Location: ../sign-up.php");
    exit();
}
?>
