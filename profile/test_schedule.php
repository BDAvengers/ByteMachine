<?php
session_start();
require '../vender/connect.php';
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

if (!isset($_SESSION['clients']) && !isset($_SESSION['employees'])) {
    header('Location: ../index.php');
    exit();
} else if (isset($_SESSION['clients'])) {
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
    <title>create schedule</title>
    <link rel="stylesheet" href="../css/style.css">
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
            <header class="header">
            <a href="index.php" class="logo">
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
                    <a href="profile.php" class="nav_item_link2"><?php echo $user['full_name']; ?></a>
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


    
<?php if (isset($_SESSION['message'])) : ?>
    <p class="msg"> <?php echo $_SESSION['message']; ?> </p>
    <?php unset($_SESSION['message']); ?>
<?php endif; ?>
<form action="../vender/save_test.php" method="post">
    <input type="hidden" name="group_id" value="<?php echo $group_id; ?>">
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
    <input type="submit" value="Сохранить">
</form>
</body>
</html>
