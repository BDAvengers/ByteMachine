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
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My schedules</title>
    <link rel="stylesheet" href="../css/schedule.css">
    <link rel="website icon" type="png" href="../images/logo_2.png">
</head>
<body>

    <div class="wrap">
        <div class="container">
            <?php require '../blocks/header_in_folder.php'?>
        </div>

        <div class="schedule">
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
            <?php endif; ?>
            </div>
        <?php require "../blocks/footer_in_folder.php" ?>
    </div>
    <script src="js/dropdown.js"></script>
</body>
</html>
