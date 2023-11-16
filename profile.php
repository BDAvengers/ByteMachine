<?php
    session_start();
    if (!isset($_SESSION['clients']) && !isset($_SESSION['employees'])) {
        header('Location: index.php');
        exit();
    } else if (isset($_SESSION['clients'])) {
        // Действия, связанные с клиентом
        $user = $_SESSION['clients']; 
    } else if (isset($_SESSION['employees'])) {
        // Действия, связанные со сотрудником
        $user = $_SESSION['employees'];
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/normalize.css"/>
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
                <?php if (isset($_SESSION['clients']) || isset($_SESSION['employees'])) { ?>
                <li class="nav_item2">
                    <a href="profile.php" class="nav_item_link2"><?php echo $user['full_name']; ?></a>
                </li>
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
        <div class="create_course">
            <a href="profile/my_courses.php"><h3>Мои курсы</h3></a>
        </div> 
    <div class="forma">
        <form class="prof" method="post">
            <?php if (isset($_SESSION['clients']) || isset($_SESSION['employees'])) { ?>
                <h1>ФИО: <?= $user['full_name']; ?></h1>
                <h2>Номер телефона: <?= $user['phone_number']; ?></h2>
                <h2>Электронная почта: <?= $user['email']; ?></h2>
                <a href="vender/logout.php" class="logout"> <h3>Выход</h3></a>
            <?php } ?>
        </form>
    </div>
</body>
</html>