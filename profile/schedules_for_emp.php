<?php
    session_start();
    require '../vender/connect.php';

    // расписания для сотрудника
    $emp_id = $_SESSION['emp_id'];
    $stmt_groups = $connect->prepare("SELECT * FROM courses JOIN groups_all ON courses.course_id = groups_all.course_id 
    WHERE emp_id = :emp_id");
    $stmt_groups->bindParam(':emp_id', $emp_id);
    $stmt_groups->execute();
    $groups = $stmt_groups->fetchAll(PDO::FETCH_ASSOC);

    $scheduleData = array();

    foreach ($groups as $group) {
        $current_group_id = $group['group_id']; 

        $stmt = $connect->prepare("SELECT s.*, g.group_id, g.group_name, g.group_type
        FROM schedule s
        JOIN groups_all g ON s.day_1 = g.group_id OR s.day_2 = g.group_id OR s.day_3 = g.group_id OR s.day_4 = g.group_id OR s.day_5 = g.group_id OR s.day_6 = g.group_id OR s.day_7 = g.group_id
        WHERE g.group_id = :group_id");
        $stmt->bindParam(':group_id', $current_group_id);
        $stmt->execute();
        $groupSchedule = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $scheduleData[$current_group_id] = $groupSchedule;
    } 

    $hasScheduleData = false;

    foreach ($groups as $group) {
        $groupId = $group['group_id'];
        $groupSchedule = $scheduleData[$groupId]; // Получите расписание для текущей группы

        // Проверка наличия хотя бы одного расписания
        if (!empty($groupSchedule)) {
            $hasScheduleData = true;
            break;
        }
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
    <title>Мои расписания</title>
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

        <?php if ($hasScheduleData): ?>
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
                    <?php for ($hour = 9; $hour <= 18; $hour++): ?>
                        <tr class="schedule-row">
                            <td><?php echo sprintf('%02d:00 - %02d:50', $hour, $hour); ?></td>
                            <?php for ($day = 1; $day <= 7; $day++): ?>
                                <td>
                                    <?php
                                        $currentGroups = array();
                                        foreach ($groups as $group) {
                                            $groupId = $group['group_id'];
                                            $groupSchedule = $scheduleData[$groupId]; // Получите расписание для текущей группы
                                            foreach ($groupSchedule as $schedule) {
                                                $timeRange = sprintf('%02d:00 - %02d:50', $hour, $hour);
                                                if ($schedule["time"] == $timeRange && $schedule["day_$day"] == $groupId) {
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

            <?php else: ?>
                <p>Вы еще не добавили расписание</p>
            <?php endif; ?>


</body>
</html>
