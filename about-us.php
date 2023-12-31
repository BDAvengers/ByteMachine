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
    <link rel="website icon" type="png" href="images/logo_2.png">

    <script defer src="js/adaptive_menu.js"></script>
</head>
<body>

    <div class="wrap"> 
        <div class="container">
        
        <?php require "blocks/header.php" ?>
          
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

    <script src="js/dropdown.js"></script>
            
</body>
</html>