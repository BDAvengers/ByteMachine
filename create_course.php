<?php
    session_start();

    if (!isset($_SESSION['employees'])) {
        header('Location: course.php');
    } 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create course</title>
    <link rel="stylesheet" href="css/create_course.css">
    <link rel="stylesheet" href="css/message.css">
    <link rel="website icon" type="png" href="images/logo_2.png">
</head> 
<body>
    <div class="wrap">
        <div class="container">
            <?php require "blocks/header.php" ?>
        </div>

         

        <form class="newcourse" action="vender/save_course.php" method="post">

            <?php 
                if (isset($_SESSION['message'])) {
                    echo '<p class="msg"> ' . $_SESSION['message'] . ' </p>';
                    unset($_SESSION['message']);
                }
            ?>

            <label for="course_name">Название курса:</label>
            <input type="text" id="course_name" name="course_name" value="<?php echo $_SESSION['form_data']['course_name'] ?? ''; unset($_SESSION['form_data']['course_name']); ?>">

            <input type="hidden" id="emp_id" name="emp_id" value="<?php echo (isset($_SESSION['emp_id'])); ?>">

            <label for="lvl">Уровень сложности:</label>
            <input type="text" id="lvl" name="lvl" value="<?php echo $_SESSION['form_data']['lvl'] ?? ''; unset($_SESSION['form_data']['lvl']); ?>">

            <label for="overview">Обзор курса:</label>
            <textarea id="overview" name="overview" rows="4"><?php echo $_SESSION['form_data']['overview'] ?? ''; unset($_SESSION['form_data']['lvl']); ?></textarea>

            <label for="duration">Продолжительность курса (в месяцах):</label>
            <input type="text" id="duration" name="duration" value="<?php echo $_SESSION['form_data']['duration'] ?? ''; unset($_SESSION['form_data']['duration']); ?>">
             
            
                    <label for="ind_group">Индивидуальное занятие:</label>
                    <input type="text" id="ind_group" name="ind_group" value="<?php echo $_SESSION['form_data']['ind_group'] ?? ''; unset($_SESSION['form_data']['ind_group']); ?>">
                    
                    <label for="ind_price">Цена индивидуального занятия (в тг):</label>
                    <input type="numeric" id="ind_price" name="ind_price" value="<?php echo $_SESSION['form_data']['ind_price'] ?? ''; unset($_SESSION['form_data']['ind_price']); ?>">
    

            <label for="group_group">Групповое занятие:</label>
            <input type="text" id="group_group" name="group_group" value="<?php echo $_SESSION['form_data']['group_group'] ?? ''; unset($_SESSION['form_data']['group_group']); ?>">

            <label for="group_price">Цена группового занятия (в тг):</label>
            <input type="numeric" id="group_price" name="group_price" value="<?php echo $_SESSION['form_data']['group_price'] ?? ''; unset($_SESSION['form_data']['group_price']); ?>">

            <label for="start_date">Дата начала курса:</label>
            <input type="date" id="start_date" name="start_date" value="<?php echo $_SESSION['form_data']['start_date'] ?? ''; unset($_SESSION['form_data']['start_date']); ?>">
            
            <div class="submit">
                <input type="submit" class="submit_button" value="Создать курс">
            </div>
            
        </form>

        <?php require 'blocks/footer.php' ?>
    </div>

    <script src="js/dropdown.js"></script>
</body>
</html>
