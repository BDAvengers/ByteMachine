<?php
require '../vender/connect.php';
$group_id = $_GET['group_id']; 

// Выполните запрос к базе данных, чтобы извлечь данные
$stmt = $connect->prepare("SELECT * FROM schedule");
$stmt->execute();
$scheduleData = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Выполните запрос для получения информации о группах
$stmt2 = $connect->prepare("SELECT group_id, group_name, group_type FROM groups_all");
$stmt2->execute();
$groupData = $stmt2->fetchAll(PDO::FETCH_ASSOC);
// Создайте ассоциативный массив, используя group_id в качестве ключа
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
    <title>Create schedule</title>
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

    <?php if (isset($_SESSION['message'])) : ?>
        <p class="msg"> <?php echo $_SESSION['message']; ?> </p>
        <?php unset($_SESSION['message']); ?>
    <?php endif; ?>

    <form action="../vender/save_schedule.php" method="post">
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
                <tr class="schedule-row">
                    <td><input type="text" name="time[]" value="<?php echo $schedule['time']; ?>" readonly></td>
                    <?php for ($day = 1; $day <= 7; $day++): ?>
                        <?php
                        $readonly = ($schedule["day_$day"] == $group_id || $schedule["day_$day"] === NULL) ? '' : 'readonly';
                        $groupId = $schedule["day_$day"];
                        ?>
                        <td>
                            <input type="text" name="day_<?php echo $day; ?>[]" class="schedule-input" value="<?php echo $schedule["day_$day"]; ?>" <?php echo $readonly; ?>>
                        </td>
                    <?php endfor; ?>
                </tr>
            <?php endforeach; ?>

            </tbody>
        </table>
        <input type="submit" value="Сохранить">
    </form>
</body>
</html>
