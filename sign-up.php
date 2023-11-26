<?php
    session_start();
    if (isset($_SESSION['clients']) || isset($_SESSION['employees'])) {
        header('Location: profile.php');
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Зарегистрироваться</title>
    <link rel="stylesheet" href="css/sign-up.css">
</head> 
<body> 
    <div class="wrap"> 
        <div class="container"> 
            <?php require 'blocks/header.php' ?>
        </div>
        <div class="section">
            <section>
                <form class="sign" action="vender/signup.php" method="post">
                    <h1 class="h3 mb-3 fw-normal">Зарегистрироваться</h1>
                    <div class="justify">
                    <div class="inputbox">
                        <div>
                            <label for="">ФИО</label>
                        </div>

                        <input type="text" name="full_name" id="full_name" placeholder="Введите свое полное имя">
                    </div>
                    <div class="inputbox">
                        <div>
                            <label for="date_birth">Дата рождения:</label>
                        </div>    
                        <input type="date" id="date_birth" name="date_birth">
                    </div>
                    <div class="inputbox">
                        <div>
                            <label for="">Адрес электронный почты</label>
                        </div> 
                        <input type="email" name="email" id="email" placeholder="Введите свой адрес электронной почты">
                    </div>
                    <div class="inputbox">
                        <div>
                            <label for="">Номер телефона</label>
                        </div>
                        <input type="text" name="phone_number" id="phone_number" placeholder="Введите номер телефона">
                    </div>
                    <div class="inputbox">
                        <div>
                            <label for="">Пароль</label>
                        </div>
                        <input type="password" name="password" placeholder="Пароль">
                    </div>
                    <div class="inputbox">
                        <div>
                            <label for="">Подтверждение пароля</label>
                        </div>
                        <input type="password" name="password_confirm" placeholder="Подтвердите пароль">
                    </div>
                    <button type="submit">Зарегистрироваться</button>
                    </div>

                    <div class="register">
                        <p>Если у вас есть аккаунт, пожалуйста, <a href="sign-in.php">войдите</a></p>
                    </div>
                <?php
                    if (isset($_SESSION['message'])) {
                        echo '<p class="msg"> ' . $_SESSION['message'] . ' </p>';
                        unset($_SESSION['message']);
                    }
                ?>
            </form>
        </div>
        <?php require "blocks/footer.php" ?>
    </div>

</body>
</html>