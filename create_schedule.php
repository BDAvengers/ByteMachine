<?php
require 'vender/connect.php';
$group_id = $_GET['group_id'];

// Выполните запрос к базе данных, чтобы извлечь данные
    $stmt = $connect->prepare("SELECT * FROM schedule");
    $stmt->execute();
    $scheduleData = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($group_type as $type)
    $stmt2 = $connect->prepare("SELECT group_name, group_type from groups_all");
    $stmt2->execute();
    $group_type = $stmt2->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create schedule</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <?php require 'blocks/header.php'?>

    <?php if (isset($_SESSION['message'])) : ?>
        <p class="msg"> <?php echo $_SESSION['message']; ?> </p>
        <?php unset($_SESSION['message']); ?>
    <?php endif; ?>

    <form action="vender/save_schedule.php" method="post">
    <input type="hidden" name="group_id" value="<?php echo $_GET['group_id']; ?>">
        
        <table>
            <thead>
                <tr>
                    <th>Время</th>
                    <th>Пн</th>
                    <th>Вт</th>
                    <th>Ср</th>
                    <th>Чт</th>
                    <th>Пт</th>
                    <th>Сб</th>
                    <th>Вс</th>
                </tr>
            </thead>
            <tbody>

            <?php foreach($scheduleData as $schedule): ?>
                <tr class="schedule-row">
                    <td><input type="text" name="time[]" value="<?php echo $schedule['time']; ?>" readonly></td>
                    <?php for ($day = 1; $day <= 7; $day++): ?>
                        <?php
                            $readonly = ($schedule["day_$day"] == $group_id || $schedule["day_$day"] === NULL) ? '' : 'readonly';
                        ?>
                        <td><input type="text" name="day_<?php echo $day; ?>[]" class="schedule-input" value="<?php echo $schedule["day_$day"]; ?>" <?php echo $readonly; ?>></td>
                    <?php endfor; ?>
                </tr>
            <?php endforeach; ?>

            </tbody>
        </table>
    <input type="submit" value="Сохранить">
    </form>
</body>
</html>