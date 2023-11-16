<?php
    session_start();
    require '../vender/connect.php';
    // расписания для сотрудника по course_id
    $course_id = $_GET['course_id'];

    // Найти все группы, связанные с данным курсом
    $stmt_groups = $connect->prepare("SELECT * FROM groups_all WHERE course_id = :course_id");
    $stmt_groups->bindParam(':course_id', $course_id);
    $stmt_groups->execute();
    $groups = $stmt_groups->fetchAll(PDO::FETCH_ASSOC);

    $scheduleData = array();
    $hasSchedule = false; // Флаг для отслеживания наличия расписания

    // Для каждой найденной группы, найти связанные с ней расписания
    foreach ($groups as $group) {
        $current_group_id = $group['group_id']; 
    
        $stmt = $connect->prepare("SELECT s.*, g.group_id, g.group_name, g.group_type
            FROM schedule s
            JOIN groups_all g ON s.day_1 = g.group_id OR s.day_2 = g.group_id OR s.day_3 = g.group_id OR s.day_4 = g.group_id OR s.day_5 = g.group_id OR s.day_6 = g.group_id OR s.day_7 = g.group_id
            WHERE g.group_id = :group_id");
        $stmt->bindParam(':group_id', $current_group_id);
        $stmt->execute();
        $groupSchedule = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        if (!empty($groupSchedule)) {
            $hasSchedule = true; // Установим флаг, если найдено хотя бы одно расписание
        }

        $scheduleData[$current_group_id] = $groupSchedule; // Используйте group_id в качестве ключа массива
    }


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
    <title>Create schedule</title>
    
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
                    <a href="../profile.php" class="nav_item_link2"><?php echo $user['full_name']; ?></a>
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

    <?php if (!$hasSchedule): ?>
        <p>Вы еще не добавили расписание</p>
    <?php else: ?>

        <table>
            <thead>
                <tr>
                    <th>Время</th>
                    <th>Понедельник</th>
                    <th>Вторник</th>
                    <th>Среда</th>
                    <th>Четверг</th>
                    <th>Пятница</th>
                    <th>Суббота</th>
                    <th>Воскресенье</th>
                </tr>
            </thead>
            <tbody>

            <?php for ($i = 9; $i <= 18; $i++): ?>
                <tr class="schedule-row">
                    <td><?php printf('%02d:00', $i); ?></td>
                    <?php for ($day = 1; $day <= 7; $day++): ?>
                        <td>
                            <?php
                                $currentGroups = array();
                                foreach ($groups as $group) {
                                    $groupId = $group['group_id'];
                                    $groupSchedule = $scheduleData[$groupId]; // Получите расписание для текущей группы
                                    foreach ($groupSchedule as $schedule) {
                                        if ($schedule["time"] == sprintf('%02d:00', $i) && $schedule["day_$day"] == $groupId) {
                                            $currentGroups[] = $schedule['group_name'] . '<br>' . $schedule['group_type'];
                                            break;
                                        }
                                    }
                                }
                                echo implode(', ', $currentGroups);
                            ?>
                        </td>
                    <?php endfor; ?>
                </tr>
            <?php endfor; ?>
            </tbody>
        </table>
    <?php endif; ?>
</body>
</html>
