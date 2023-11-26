<?php
    session_start();
?>    
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>О нас</title>
    <link rel="stylesheet" href="css/about-us.css" />
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
              <a href="command.php" class="nav_item_link">Команда</a>
            </li>

            <?php if (isset($_SESSION['clients']) || isset($_SESSION['employees'])) { ?>
            <li class="nav_item2">
                <a href="profile/profile.php" class="nav_item_link2">
                    <?php 
                        if (isset($_SESSION['clients'])) {
                            echo $_SESSION['clients']['full_name'];
                        } else {
                            echo $_SESSION['employees']['full_name'];
                        }
                    ?>
                </a>
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
            <div id="about" class="about_us">
                <div class="container_about_us">
                    <div class="container">
                        <div class="about_us_info">
                            <div class="about_us_text">
                                <p class="about_us_text_1">О НАС</p>
                                <h2 class="h2">
                                Изучай и осваивай новую профессию вместе с нами
                                </h2>
                            </div>
                        <div class="about_us_cart">
                            <p class="about_us_card_text">
                            Проект был основан в 2023 году, с целью развития среди молодых
                            профессионалов в сфере ИТ и программирования. <br /><br />Цель
                            реализации решение и развитие Казахстана посредством создания
                            новых проектов нашими выпускниками.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        
    </div>

    <?php require "blocks/footer.php" ?>
            
</body>
</html>