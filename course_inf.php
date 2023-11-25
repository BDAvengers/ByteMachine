<?php
    require 'vender/connect.php';
    $results = [];
    $course_id = $_GET['course_id']; 
    $statement = $connect->prepare("SELECT * FROM courses JOIN groups_all ON courses.course_id = groups_all.course_id 
    WHERE courses.course_id = :course_id");
    $statement->bindParam(':course_id', $course_id);
    $statement->execute();
    $results = $statement->fetchAll(PDO::FETCH_ASSOC);

    if (isset($_SESSION['clients'])) {
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
    <title>Course information</title>
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/style.css">
</head> 
<body>

    <?php require 'blocks/header.php'; ?>
    <?php  
        if (isset($_SESSION['message'])) {
            echo '<p class="msg"> ' . $_SESSION['message'] . ' </p>';
            unset($_SESSION['message']);
        }
    ?>

    <?php if ($results): ?>
        <p class="couses_children"><?= $results[0]['course_name']; ?></p>
        <p>Описания: <?= $results[0]['overview']; ?></p>
        <p>Курс начинается: <?= $results[0]['start_date']; ?></p>
        <p>Статус: <?= $results[0]['status']; ?></p>

        <?php foreach ($results as $result): ?>
            <?php
                $group_id = $result['group_id'];
                $max_capacity = ($result['group_type'] == 'individual') ? 1 : 10;
                
                // Подготовка SQL-запроса для подсчета количества человек
                $stmt_count = $connect->prepare("SELECT COUNT(*) as count FROM trans WHERE group_id = :group_id and status in ('Оплачен', 'Забронирован')");
                $stmt_count->bindParam(':group_id', $group_id);
                $stmt_count->execute();
                $count = $stmt_count->fetch(PDO::FETCH_ASSOC)['count'];
            ?>
            
            <p>
                Тип группы: <?= $result['group_type']; ?>
                <a href="schedule.php?group_id=<?= $result['group_id'];?>">Посмотреть расписание</a>
                (<?= $count . ' / ' . $max_capacity; ?>)
            </p>
            
            <?php if ($result['group_type'] == 'individual'): ?>
                <p>Цена: <?= $result['ind_price']; ?></p>
            <?php elseif ($result['group_type'] == 'group'): ?>
                <p>Цена: <?= $result['group_price']; ?></p>
            <?php endif; ?>
        <?php endforeach; ?>

    <?php endif; ?>
</body>
</html>