<?php
    session_start();
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
    <title>Schedule</title>
    <link rel="stylesheet" href="css/schedule.css">
</head>
<body>
    <div class="wrap"> 
        <div class="container">

        <?php require 'blocks/header.php'?>

        </div>
        <div class="schedule">
            <?php if (isset($_SESSION['message'])) : ?>
                <p class="msg"> <?php echo $_SESSION['message']; ?> </p>
                <?php unset($_SESSION['message']); ?>
            <?php endif; ?>

            <?php if (!$hasSchedule): ?>
                <p>Преподаватель еще не добавил расписание</p>
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
                                        foreach ($scheduleData as $schedule) {
                                            // Проверяем, соответствует ли время и день в расписании текущему времени и дню цикла
                                            $timeRange = sprintf('%02d:00 - %02d:50', $hour, $hour);
                                            if ($schedule["time"] == $timeRange && $schedule["day_$day"] == $group_id) {
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

            <?php if (isset($_SESSION['clients'])): ?>
                <form action="vender/buy_course.php" method="post"> 
                    <input type="hidden" id="client_id" name="client_id" value="<?php echo $_SESSION['client_id']; ?>">
                    <input type="hidden" id="date_pay" name="date_pay">
                    <input type="hidden" id="group_id" name="group_id" value="<?php echo $_GET['group_id']; ?>">   
                    <input type="submit" value="Купить этот курс">                
                </form>     
            <?php endif; ?>   
        </div>
        <?php require "blocks/footer.php" ?>
    </div>
    <script src="js/dropdown.js"></script>
        
</body>
</html>
