<?php
    session_start();
    require '../vender/connect.php';
   
    $course_id = $_GET['course_id'];
    
    if (isset($_SESSION['employees'])) {
        $stmt_check_group = $connect->prepare("SELECT COUNT(*) FROM courses WHERE emp_id = :emp_id AND course_id = :course_id");
        $stmt_check_group->bindParam(':emp_id', $_SESSION['emp_id']);
        $stmt_check_group->bindParam(':course_id', $course_id);
        $stmt_check_group->execute();
        $count=$stmt_check_group->fetchColumn();

        if ($count == 0) {
            header('Location: my_courses.php');
        }
    } 
    if (isset($_SESSION['clients'])) {
        $stmt_check_group2 = $connect->prepare("SELECT COUNt(*) FROM trans WHERE client_id = :client_id AND course_id = :course_id");
        $stmt_check_group2->bindParam(':client_id', $_SESSION['client_id']);
        $stmt_check_group2->bindParam(':course_id', $course_id);
        $stmt_check_group2->execute();
        $count2=$stmt_check_group2->fetchColumn();

        if ($count2 == 0) {
            header("Location: my_courses.php");
        }
    }

    

    $statement = $connect->prepare("SELECT * FROM courses JOIN groups_all ON courses.course_id = groups_all.course_id 
    WHERE courses.course_id = :course_id");
    $statement->bindParam(':course_id', $course_id);
    $statement->execute();
    $results = $statement->fetchAll(PDO::FETCH_ASSOC);

    $statement2 = $connect->prepare("SELECT * FROM courses JOIN trans ON courses.course_id = trans.course_id 
    WHERE courses.course_id = :course_id AND trans.client_id = :client_id");
    $statement2->bindParam(':client_id', $_SESSION['client_id']);
    $statement2->bindParam(':course_id', $course_id);
    $statement2->execute();
    $clientInf = $statement2->fetchAll(PDO::FETCH_ASSOC);

    if (!isset($_SESSION['clients']) && !isset($_SESSION['employees'])) {
        header('Location: index.php');
        exit();
    } else if (isset($_SESSION['clients'])) {
        // Действия, связанные с клиентом
        $user = $_SESSION['clients'];
        $userType = 'client';
    } else if (isset($_SESSION['employees'])) {
        // Действия, связанные со сотрудником
        $user = $_SESSION['employees'];
        $userType = 'employee';
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../css/style.css">
</head> 
<body>

    <div class="wrap">
        <div class="container">
            <header class="header">
            <a href="../index.php" class="logo">
                <img src="../images/logo_2.png" alt="" />
            </a>
            <ul class="nav">
                <li class="nav_item3">
                <a href="../index.php" class="nav_item_link">Главная</a>
                </li>
                <li class="nav_item">
                <a href="../about-us.php" class="nav_item_link">О нас</a>
                </li>
                <li class="nav_item">
                <a href="../course.php" class="nav_item_link">Курсы</a>
                </li>
                <li class="nav_item">
                <a href="../comand.php" class="nav_item_link">Команда</a>
                </li>
                <?php if (isset($_SESSION['clients']) || isset($_SESSION['employees'])) { ?>
                <li class="nav_item2">
                    <a href="../profile/profile.php" class="nav_item_link2"><?php echo $user['full_name']; ?></a>
                </li>
                <?php } else { ?>
                    <li class="nav_item2">
                        <a href="../sign-in.php" class="nav_item_link2">Войти</a>
                    </li>
                    <li class="nav_item2">
                        <a href="../sign-up.php" class="nav_item_link2">Регистрация</a>
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
        <p>Описания: <?= $results[0]['overview']; ?></p>
        <p>Курс начинается: <?= $results[0]['start_date']; ?></p>
        <p>Статус: <?= $results[0]['status']; ?></p>
        
        <?php if ($userType === 'client'): ?>
        <?php foreach ($clientInf as $clients): ?>
                <?php if ($clients['course_type'] == 'individual' || $clients['course_type'] == 'group'): ?>
                    <p>Тип группы: <?= $clients['course_type']; ?></p>
                <?php endif; ?>
        <?php endforeach; ?>

        <?php elseif ($userType === 'employee'): ?>
            <?php foreach ($results as $result): ?>
                <?php if ($result['group_type'] == 'individual'): ?>
                    <p>Тип группы: <?= $result['group_type']; ?> <a href="test_schedule.php?group_id=<?= $result['group_id'];?>">Добавить расписание</a></p>
                    <p>Цена: <?= $result['ind_price']; ?></p>
                <?php elseif ($result['group_type'] == 'group'): ?>
                    <p>Тип группы: <?= $result['group_type']; ?> <a href="test_schedule.php?group_id=<?= $result['group_id'];?>">Добавить расписание</a></p>
                    <p>Цена: <?= $result['group_price']; ?></p>
                <?php endif; ?>
        <?php endforeach; ?>
        <a href="my_schedules.php?course_id=<?= $result['course_id']; ?>">Мои расписания для этого курса</a>
        <?php endif; ?>
    <?php endif; ?>

</body>
</html>
