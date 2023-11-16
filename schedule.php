<?php
    require 'vender/connect.php';
    $group_id = $_GET['group_id'];
    $stmt = $connect->prepare("SELECT s.*, g.group_id, g.group_name, g.group_type
    FROM schedule s
    JOIN groups_all g ON s.day_1 = g.group_id OR s.day_2 = g.group_id OR s.day_3 = g.group_id OR s.day_4 = g.group_id OR s.day_5 = g.group_id OR s.day_6 = g.group_id OR s.day_7 = g.group_id
    WHERE g.group_id = :group_id");
    $stmt->bindParam(':group_id', $group_id);
    $stmt->execute();
    $scheduleData = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $hasSchedule = false; // Флаг для отслеживания наличия расписания
    if (!empty($scheduleData)) {
        $hasSchedule = true; // Установим флаг, если найдено хотя бы одно расписание
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create schedule</title>
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php require 'blocks/header.php'?>
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
                                foreach ($scheduleData as $schedule) {
                                    // Проверяем, соответствует ли время и день в расписании текущему времени и дню цикла
                                    if ($schedule["time"] == sprintf('%02d:00', $i) && $schedule["day_$day"] == $group_id) {
                                        $currentGroups[] = $schedule['group_name'] . '<br>' . $schedule['group_type'];
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