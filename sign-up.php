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
    <title>Sign in</title>
    
    <link rel="stylesheet" href="css/style.css">

</head> 
<body> 
<div class="wrap">
        <div class="container">
            <header class="header">
            <a href="index.php" class="logo">
                <img src="images/logo_2.png" alt="" />
            </a>
            <ul class="nav">
                <li class="nav_item3">
                <a href="index.php" class="nav_item_link">Главная</a>
                </li>
                <li class="nav_item">
                <a href="about-us.php" class="nav_item_link">О нас</a>
                </li>
                <li class="nav_item">
                <a href="course.php" class="nav_item_link">Курсы</a>
                </li>
                <li class="nav_item">
                <a href="comand.php" class="nav_item_link">Команда</a>
                </li>
                <?php if (isset($_SESSION['clients'])) { ?>
                <li class="nav_item2"> <a href="profile.php" class="nav_item_link2"><?php echo $_SESSION['clients']['full_name']; ?></a></li>
                <?php } else { ?>
                    <li class="nav_item2">
                        <a href="sign-in.php" class="nav_item_link2">Войти</a>
                    </li>
                    <li class="nav_item2">
                        <a href="sign-up.php" class="nav_item_link2">Регистрация</a>
                    </li>
                <?php } ?>
            </ul>
            </header>
        </div>
    </div> 
    <div class="forma">
        <form class="sign" action="vender/signup.php" method="post">
            <h1 class="h3 mb-3 fw-normal">Зарегистрироваться</h1>
            <label for="">ФИО</label>
            <input type="text" name="full_name" id="full_name" placeholder="Введите свое полное имя">

            <label for="">Адрес электронный почты</label>
            <input type="email" name="email" id="email" placeholder="Введите свой адрес электронной почты">

            <label for="">Номер телефона</label>
            <input type="text" name="phone_number" id="phone_number" placeholder="Введите номер телефона">

            <label for="">Пароль</label>
            <input type="password" name="password" class="form-control" id="password" placeholder="Пароль">

            <label for="">Подтверждение пароля</label>
            <input type="password" name="password_confirm" class="form-control" id="password" placeholder="Подтвердите пароль">

            <button class="btn btn-primary w-100 py-2" type="submit">Зарегистрироваться</button>

            <p class="upper">Если у вас есть аккаунт, пожалуйста, <a class="text-decoration-none" href="sign-in.php">войдите</a></p>
            <?php
                if (isset($_SESSION['message'])) {
                    echo '<p class="msg"> ' . $_SESSION['message'] . ' </p>';
                    unset($_SESSION['message']);
                }
            ?>
            
        </form>
    </div>
</body>
</html>