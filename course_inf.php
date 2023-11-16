<?php
    session_start();
    require 'vender/connect.php';
    $results = [];
    $course_id = $_GET['course_id']; 
    $statement = $connect->prepare("SELECT * FROM courses JOIN groups_all ON courses.course_id = groups_all.course_id 
    WHERE courses.course_id = :course_id");
    $statement->bindParam(':course_id', $course_id);
    $statement->execute();
    $results = $statement->fetchAll(PDO::FETCH_ASSOC);

    if (isset($_SESSION['clients'])) {
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
    <?php 
        if (isset($_SESSION['message'])) {
            echo '<p class="msg"> ' . $_SESSION['message'] . ' </p>';
            unset($_SESSION['message']);
        }
    ?>

    <?php if ($results): ?>
        <p class="couses_children"><?= $results[0]['course_name']; ?></p>
        <p>Цена: <?= $results[0]['price']; ?></p>

        <?php foreach ($results as $result): ?>
            <?php if ($result['group_type'] == 'individual'): ?>
                <p>Тип группы: <?= $result['group_type']; ?> <a href="schedule.php?group_id=<?= $result['group_id'];?>">Посмотреть расписание</a></p>
            <?php elseif ($result['group_type'] == 'group'): ?>
                <p>Тип группы: <?= $result['group_type']; ?> <a href="schedule.php?group_id=<?= $result['group_id'];?>">Посмотреть расписание</a></p>
            <?php endif; ?>
        <?php endforeach; ?>

    <?php endif; ?>


</body>
</html>