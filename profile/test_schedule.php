<?php
session_start();
require '../vender/connect.php';

if (!isset($_SESSION['employees']) || !isset($_SESSION['emp_id'])) {
    header('Location: ../index.php');
    exit();
} else if (isset($_SESSION['employees'])) { 
    // Действия, связанные со сотрудником
    $user = $_SESSION['employees'];
}

$emp_id = $_SESSION['emp_id'];

$group_id = $_GET['group_id'];

$stmt_check_group = $connect->prepare("SELECT COUNT(*) FROM courses 
    JOIN groups_all ON courses.course_id = groups_all.course_id 
    WHERE courses.emp_id = :emp_id AND groups_all.group_id = :group_id");

$stmt_check_group->bindParam(':group_id', $group_id);
$stmt_check_group->bindParam(':emp_id', $emp_id);
$stmt_check_group->execute();
$count = $stmt_check_group->fetchColumn();

if ($count == 0) {
    header("Location: ../index.php");
    exit();
}


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
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Добавить расписания</title>
    <link rel="stylesheet" href="../css/create_schedule.css">
    <link rel="stylesheet" href="../css/message.css">
</head>
<body>

<script>
    document.addEventListener('DOMContentLoaded', function () {
    var removeButtons = document.querySelectorAll('.remove-group');

    removeButtons.forEach(function (button) {
        button.addEventListener('click', function () {
            var groupId = this.getAttribute('data-group-id');
            var groupContainer = this.closest('.group-container');

            // Очищаем данные группы
            var hiddenInput = groupContainer.querySelector('input[type="hidden"]');
            hiddenInput.value = '';
            
            var groupInfo = groupContainer.querySelector('.group-info');
            groupInfo.innerHTML = '';

            // Создаем новый выпадающий список
            var select = document.createElement('select');
            select.name = hiddenInput.name;
            var option = document.createElement('option');
            option.value = "";
            select.appendChild(option);
            
            // Добавляем только текущую группу
            var currentGroup = <?php echo json_encode($groupMap[$group_id] ?? null); ?>;
            if (currentGroup) {
                var option = document.createElement('option');
                option.value = currentGroup['group_id'];
                option.text = currentGroup['group_name'] + ' - ' + currentGroup['group_type'];
                select.appendChild(option);
            }

            // Заменяем содержимое группы на новый выпадающий список
            groupContainer.innerHTML = '';
            groupContainer.appendChild(select);
        });
    });
    });
</script>

    <div class="wrap">
        <div class="container">
            <?php require "../blocks/header_in_folder.php" ?>
        </div>
        <div class="schedule_box">
            <div class="schedule">
                <div>
                    <?php if (isset($_SESSION['message'])) : ?>
                        <p class="msg"> <?php echo $_SESSION['message']; ?> </p>
                        <?php unset($_SESSION['message']); ?>
                    <?php endif; ?>
                </div>
                <form action="../vender/save_test.php" method="post">
                    <input type="hidden" name="group_id" value="<?php echo $group_id; ?>">
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
                            <?php foreach ($scheduleData as $schedule): ?>
                                <tr>
                                    <td><input class="time" type="text" name="time[]" value="<?php echo $schedule['time']; ?>" readonly></td>
                                    <?php
                                    $days = array('day_1', 'day_2', 'day_3', 'day_4', 'day_5', 'day_6', 'day_7');
                                    foreach ($days as $day) {
                                        $groupId = $schedule[$day];
                                        ?>
                                        <td>
                                            <?php if (is_null($groupId)) : ?>
                                                <select name="<?php echo $day; ?>[]">
                                                    <option value=""></option>
                                                    <?php foreach ($groupData as $groupOption): ?>
                                                        <?php if ($groupOption['group_id'] == $group_id): ?>
                                                        <option value="<?php echo $groupOption['group_id']; ?>">
                                                        Курс: <?php echo $groupOption['group_name'] . ' - ' . $groupOption['group_type']; ?>
                                                        </option>
                                                        <?php endif; ?>
                                                    <?php endforeach; ?>
                                                </select>
                                            <?php else : ?>
                                                <div class="group-container">
                                                    <input type="hidden" name="<?php echo $day; ?>[]" value="<?php echo $groupId; ?>">
                                                    <div>
                                                        <span class="group-info">
                                                            Курс: <?php echo isset($groupMap[$groupId]['group_name']) ? $groupMap[$groupId]['group_name'] . ' <br>Тип группы: ' . $groupMap[$groupId]['group_type'] : '';?>
                                                        </span>
                                                        <?php if ($groupId == $group_id): ?>
                                                            <button type="button" class="remove-group" data-group-id="<?php echo $groupId; ?>">x</button>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                        </td>
                                        <?php
                                    }
                                    ?>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <div class="save_schedule">
                        <input type="submit" value="Сохранить">
                    </div>
                </form>
            </div>
        </div>
        <?php require "../blocks/footer_in_folder.php" ?>
    </div>                         
    <script src="../js/dropdown.js"></script>
</body>
</html>
