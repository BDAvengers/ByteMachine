<?php
    session_start();
    if (!isset($_SESSION['clients']) && !isset($_SESSION['employees'])) {
        header('Location: ../index.php');
        exit();
    } else if (isset($_SESSION['clients'])) {
        $user = $_SESSION['clients']; 
    } else if (isset($_SESSION['employees'])) {
        $user = $_SESSION['employees'];
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../css/normalize.css"/>
    <link rel="stylesheet" href="../css/style.css">
    
</head> 
<body> 
    <div class="wrap">
        <div class="container">
            <?php require "../blocks/header_in_folder.php" ?>
        </div>
    </div>
        <div class="create_course">
            <a href="my_courses.php"><h3>Мои курсы</h3></a>
        </div> 
    <div class="forma">
        <form class="prof" method="post">
            <?php if (isset($_SESSION['clients']) || isset($_SESSION['employees'])) { ?>
                <h1>ФИО: <?= $user['full_name']; ?></h1>
                <h2>Дата рождения: <?= $user['date_birth']; ?></h2>
                <h2>Номер телефона: <?= $user['phone_number']; ?></h2>
                <h2>Электронная почта: <?= $user['email']; ?></h2>
                <a href="../vender/logout.php" class="logout"> <h3>Выход</h3></a>
            <?php } ?>
        </form>
    </div>
</body>
</html>