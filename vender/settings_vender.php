<?php
session_start();
require 'connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $operation = $_POST['operation'];
    switch ($operation) {
        case 'edit_profile':
            $full_name = $_POST['full_name'];
            $phone_number = $_POST['phone_number'];
            $date_birth = $_POST['date_birth'];
            $client_id = isset($_SESSION['client_id']) ? $_SESSION['client_id'] : null;
            $emp_id = isset($_SESSION['emp_id']) ? $_SESSION['emp_id'] : null;

            $phone_number_pattern = '/^8{1}7{1}\d{9}$/';
            $phone_number_pattern2 = '/^\+77\d{9}$/';

            if (empty($full_name) || empty($phone_number) || empty($date_birth)) {
                $_SESSION['edit_profile_message'] = 'Пожалуйста, заполните полностью';
                header('Location: ../profile/settings.php ');
                exit();
            } else if (mb_strlen($full_name) < 4 || mb_strlen($full_name) > 50) {
                $_SESSION['edit_profile_message'] = "Недопустимая ФИО";
                header('Location: ../profile/settings.php');
                exit();
            } else if (!preg_match($phone_number_pattern, $phone_number) && !preg_match($phone_number_pattern2, $phone_number)) {
                $_SESSION['edit_profile_message'] = "Введите номер телефона в формате 87776665544 или +77776665544";
                header('Location: ../profile/settings.php');
                exit();
            }

            if (isset($_SESSION['clients'])) {
                $statment = $connect->prepare("UPDATE clients SET full_name = :full_name, phone_number = :phone_number, date_birth = :date_birth 
                    WHERE client_id = :client_id");
                $statment->bindparam(':full_name', $full_name);
                $statment->bindparam(':phone_number', $phone_number);
                $statment->bindparam(':date_birth', $date_birth);
                $statment->bindparam(':client_id', $client_id);
                $statment->execute();

                $_SESSION['clients']['full_name'] = $full_name;
                $_SESSION['clients']['phone_number'] = $phone_number;
                $_SESSION['clients']['date_birth'] = $date_birth;
            } elseif (isset($_SESSION['employees'])) {
                $statment = $connect->prepare("UPDATE employees SET full_name = :full_name, phone_number = :phone_number, date_birth = :date_birth 
                    WHERE emp_id = :emp_id");
                $statment->bindparam(':full_name', $full_name);
                $statment->bindparam(':phone_number', $phone_number);
                $statment->bindparam(':date_birth', $date_birth);
                $statment->bindparam(':emp_id', $emp_id);
                $statment->execute();

                $_SESSION['employees']['full_name'] = $full_name;
                $_SESSION['employees']['phone_number'] = $phone_number;
                $_SESSION['employees']['date_birth'] = $date_birth;
            }
            $_SESSION['edit_profile_message'] = "Успешно сохранено!";
            header("Location: ../profile/settings.php"); // добавлен якорь
            exit();
            
        case 'change_password':
            $password = $_POST['password'];
            $new_password = $_POST['new_password'];
            $confirm_password = $_POST['confirm_password'];
            $client_id = isset($_SESSION['client_id']) ? $_SESSION['client_id'] : null;
            $emp_id = isset($_SESSION['emp_id']) ? $_SESSION['emp_id'] : null;

            if (isset($_SESSION['clients'])) {
                $statment = $connect->prepare("SELECT password FROM clients WHERE client_id = :client_id");
                $statment->bindparam(':client_id', $client_id);
                $statment->execute();
                $check_password = $statment->fetch(PDO::FETCH_ASSOC);

                if (empty($password) || empty($new_password) || empty($confirm_password)) {
                    $_SESSION['change_password_message'] = "Пожалуйста, заполните пароли!";
                    header("Location: ../profile/settings.php");
                    exit();
                } else if ($new_password !== $confirm_password) {
                    $_SESSION['change_password_message'] = "Пароли не совпадают! Пожалуйста, заполните еще раз.";
                    header("Location: ../profile/settings.php");
                    exit();
                } else if ($password === $new_password && $password === $confirm_password) {
                    $_SESSION['change_password_message'] = "Новый пароль не должен совпадать с текущим паролем";
                    header("Location: ../profile/settings.php");
                    exit();
                }

                $password_hash = password_hash($new_password, PASSWORD_BCRYPT);

                if (password_verify($password, $check_password['password'])) {
                    $stmt = $connect->prepare("UPDATE clients SET password = :new_password WHERE client_id = :client_id");
                    $stmt->bindparam(':client_id', $client_id);
                    $stmt->bindparam(':new_password', $password_hash);
                    $stmt->execute();

                    $_SESSION['change_password_message'] = "Пароль успешно сохранен!";
                    header("Location: ../profile/settings.php"); 
                    exit();
                } else {
                    $_SESSION['change_password_message'] = "Неверный текущий пароль! Пожалуйста, заполните еще раз.";
                    header("Location: ../profile/settings.php");
                    exit();
                }
            } else if (isset($_SESSION['employees'])) {
                        $statment = $connect->prepare("SELECT password FROM employees WHERE emp_id = :emp_id");
                        $statment->bindparam(':emp_id', $emp_id);
                        $statment->execute();
                        $check_password = $statment->fetch(PDO::FETCH_ASSOC);
                
                        if (empty($password) || empty($new_password) || empty($confirm_password)) {
                            $_SESSION['change_password_message'] = "Пожалуйста, заполните пароли!";
                            header("Location: ../profile/settings.php");
                            exit();
                        } else if ($new_password !== $confirm_password) {
                            $_SESSION['change_password_message'] = "Пароли не совпадают! Пожалуйста, заполните еще раз.";
                            header("Location: ../profile/settings.php");
                            exit();
                        } else if ($password === $new_password && $password === $confirm_password) {
                            $_SESSION['change_password_message'] = "Новый пароль не должен совпадать с текущим паролем";
                            header("Location: ../profile/settings.php");
                            exit();
                            
                        }
                        $password_hash = password_hash($new_password, PASSWORD_BCRYPT);
                        if (password_verify($password, $check_password['password'])) {
                            $stmt = $connect->prepare("UPDATE employees SET password = :new_password WHERE emp_id = :emp_id");
                            $stmt->bindparam(':emp_id', $emp_id);
                            $stmt->bindparam(':new_password', $password_hash);
                            $stmt->execute();
            
                            $_SESSION['change_password_message'] = "Пароль успешно сохранен!";
                            header("Location: ../profile/settings.php"); 
                            exit();
                        } else {
                            $_SESSION['change_password_message'] = "Неверный текущий пароль! Пожалуйста, заполните еще раз.";
                            header("Location: ../profile/settings.php");
                            exit();
                        }
                    }
                break; 
            }
}
?>