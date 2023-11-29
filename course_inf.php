<?php
    session_start();
    require 'vender/connect.php';
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
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Информация о курсе</title>
    <link rel="stylesheet" href="css/course_inf.css">
</head> 
<body>
    <div class="wrap"> 
        <div class="container">
            <?php require 'blocks/header.php'; ?>
        </div>
        <?php if ($results): ?>
        <p class="couses_children"><?= $results[0]['course_name']; ?></p>
        <div class="container2">
            <div class="left_box">
                <div class="left_container">
                        <p>Описания: <?= $results[0]['overview']; ?></p>
                        <p>Курс начинается: <?= $results[0]['start_date']; ?></p>
                        <p>Статус: <?= $results[0]['status']; ?></p>
                </div>
            </div>

            <div class="right_box">
                <h2>Группы для этого курса:</h2>
                <?php foreach ($results as $result): ?>
                                <?php
                                    $group_id = $result['group_id'];
                                    $max_capacity = ($result['group_type'] == 'individual') ? 1 : 10;
                                    $stmt_count = $connect->prepare("SELECT COUNT(*) as count FROM trans WHERE group_id = :group_id and status in ('Оплачен', 'Забронирован')");
                                    $stmt_count->bindParam(':group_id', $group_id);
                                    $stmt_count->execute();
                                    $count = $stmt_count->fetch(PDO::FETCH_ASSOC)['count'];
                                ?>
                    <div class="right_container">
                        <div>
                            <p>
                                Тип группы: <?= $result['group_type']; ?> 
                            </p>
                            <p class="count_members">[<?= $count . ' / ' . $max_capacity; ?>]<p>
                        </div>
                        <?php if ($result['group_type'] == 'individual'): ?>
                            <p>Цена: <?= $result['ind_price']; ?></p>
                        <?php elseif ($result['group_type'] == 'group'): ?>
                            <p>Цена: <?= $result['group_price']; ?></p>
                        <?php endif; ?>
                        <a href="schedule.php?group_id=<?= $result['group_id'];?>">Посмотреть расписание</a>
                    </div>
                
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        </div> 
        <?php require 'blocks/footer.php' ?>
    </div>
    <script src="js/dropdown.js"></script>
</body>
</html>