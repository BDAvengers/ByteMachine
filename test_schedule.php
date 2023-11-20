<?php 
session_start();
require 'vender/connect.php';
$group_id = $_GET['group_id'];
$stmt = $connect->prepare("SELECT * FROM schedule");
$stmt->execute();
$scheduleData = $stmt->fetchAll(PDO::FETCH_ASSOC);
$stmt2 = $connect->prepare("SELECT group_id, group_name, group_type FROM groups_all");
$stmt2->execute();
$groupData = $stmt2->fetchAll(PDO::FETCH_ASSOC);
$groupMap = [];
foreach ($groupData as $group) {
    $groupMap[$group['group_id']] = $group;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test</title>
</head>
<body>
    <?php if (isset($_SESSION['message'])) : ?>
        <p class="msg"> <?php echo $_SESSION['message']; ?> </p>
        <?php unset($_SESSION['message']); ?>
    <?php endif; ?>
    <form action="vender/save_test.php" method="post">
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
                <?php foreach ($scheduleData as $schedule): ?>
                    <tr>
                        <td><input type="text" name="time[]" value="<?php echo $schedule['time']; ?>" readonly></td>
                        <?php
                        $days = array('day_1', 'day_2', 'day_3', 'day_4', 'day_5', 'day_6', 'day_7');
                        foreach ($days as $day) {
                            $groupId = $schedule[$day];
                            ?>
                            <td>
                                <?php if (is_null($groupId)) : ?>
                                    <input type="text" name="<?php echo $day; ?>[]" value="<?php echo $groupId; ?>">
                                <?php else : ?>
                                    <input type="hidden" name="<?php echo $day; ?>[]" value="<?php echo $groupId; ?>">
                                    <input type="text" value="<?php echo isset($groupMap[$groupId]['group_name']) ? $groupMap[$groupId]['group_name'] . ' - ' . $groupMap[$groupId]['group_type'] : ''; ?>">
                                <?php endif; ?>
                            </td>
                            <?php
                        }
                        ?>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <input type="submit" value="Сохранить">
    </form>
</body>
</html>
