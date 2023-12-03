<?php
    session_start();
    if (isset($_SESSION['clients']) || isset($_SESSION['employees'])) {
        header('Location: profile/profile.php');
    }
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign in</title>
    <link rel="stylesheet" href="css/sign-in.css">
    <link rel="stylesheet" href="css/message.css">
    <link rel="website icon" type="png" href="images/logo_2.png">
</head> 
<body>
    <div class="wrap"> 
        <div class="container">
            <?php require 'blocks/header.php' ?>
        </div>
            <div class="section">
                <section>
                    <form class="sign" action="vender/signin.php" method="post">
                        <h1>Войти в аккаунт</h1>
                        <div>
                        <?php
                        if (isset($_SESSION['message'])) {
                            echo '<p class="msg"> ' . $_SESSION['message'] . ' </p>';
                            unset($_SESSION['message']);
                        }
                        ?>
                        <div class="inputbox">
                        
                            <div>
                                <label for="email">Email</label>
                            </div>
                            <input type="text" name="email" id="email" placeholder="Введите email" autocomplete="new-email">
                        </div>
                        <div class="inputbox">
                            <div>
                                <label for="password">Пароль</label>
                            </div>
                            <input type="password" name="password" id="password" placeholder="Пароль" autocomplete="new-password">
                        </div>
                        <div class="forget">
                            <input class="form-check-input" type="checkbox" name="remember_me" id="flexCheckDefault">
                            <label class="form-check-label" for="flexCheckDefault">Запомнить меня</label>
                            <div>
                                <a href="#">Забыли пароль?</a>
                            </div>
                        </div>
                        
                        <button type="submit">Войти</button>
                        <div class="register">
                            <p class="upper">Если у вас нет аккаунта, пожалуйста, <a class="text-decoration-none" href="sign-up.php">зарегистрируйтесь</a></p>
                        </div>
                        </div>
                        
                    </form>
                </section>
            </div>
        
        <?php require 'blocks/footer.php' ?>
        </div>
</body>
</html>