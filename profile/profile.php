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
    <link rel="stylesheet" href="../css/profile.css">
    <link rel="website icon" type="png" href="../images/logo_2.png">
</head> 
<body> 
    <div class="wrap">
        <div class="container">
            <?php require "../blocks/header_in_folder.php" ?>
        </div>
        <div class="container2">
            <div class="left_box"> 
                <div class="left_container">
                    <p><a href="../profile/my_courses.php">Мои курсы</a></p>
                    <p><a href="settings.php">Редактировать профиль</a></p>
                </div>
            </div>
            <div class="right_box">
                <div class="right_container">
                    <form class="prof">
                        <?php if (isset($_SESSION['clients']) || isset($_SESSION['employees'])) { ?>
                            <h1><?= $user['full_name']; ?></h1>
                            <p>Дата рождения: <?= $user['date_birth']; ?></p>
                            <p><?= $user['phone_number']; ?></h2>
                            <p>Электронная почта: <?= $user['email']; ?></p>
                        <?php } ?>
                    </form>
                </div>
                <h2>Образование</h2>
                <div class="right_container">
                    <form class="prof" method="post">
                        <?php if (isset($_SESSION['clients']) || isset($_SESSION['employees'])) { ?>
                            
                        <?php } ?>
                    </form>
                </div>
            </div>
        </div>
        <?php require "../blocks/footer_in_folder.php" ?>
    </div>
    <script src="../js/dropdown.js"></script>
</body>
</html>