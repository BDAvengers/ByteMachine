<?php
    require '../vender/connect.php';
    session_start();
    $courses = [];
    $user = null;

    if (!isset($_SESSION['clients']) && !isset($_SESSION['employees'])) {
        header('Location: index.php');
        exit();
    } else if (isset($_SESSION['employees'])) {
        // Действия, связанные со сотрудником
        $user = $_SESSION['employees'];

        $statement = $connect->prepare("SELECT * FROM courses WHERE emp_id = :emp_id");
        $statement->bindParam(':emp_id', $_SESSION['emp_id']);
        $statement->execute();
        $courses = $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    if (isset($_SESSION['clients'])) {
        // Действия, связанные с клиентом
        $user = $_SESSION['clients'];
    
        $clientCourses = [];
        $statement = $connect->prepare("SELECT * FROM trans WHERE client_id = :client_id AND status = 'Оплачен'");
        $statement->bindParam(':client_id', $_SESSION['client_id']);
        $statement->execute();
        $transactions = $statement->fetchAll(PDO::FETCH_ASSOC);
    
        $course_ids = array();
        foreach ($transactions as $transaction) {
            $course_ids[] = $transaction['course_id'];
        }
    
        $course_ids = array_unique($course_ids);

        foreach ($course_ids as $id) {
            $statement = $connect->prepare("SELECT * FROM courses WHERE course_id = :id");
            $statement->bindParam(':id', $id);
            $statement->execute();
            $course = $statement->fetch(PDO::FETCH_ASSOC);
            if ($course) {
                $courses[] = $course;
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Мои курсы</title>
    <link rel="stylesheet" href="../css/course.css">
</head> 
<body>
    
    <div class="wrap">
        <div class="container">
            <?php require "../blocks/header_in_folder.php" ?>
        </div>
        <p class="couses_children">Мои курсы</p> 

            <?php if (isset($_SESSION['clients'])): ?> 
                <div class="create_course">
                    <a href="schedules_for_clt.php"><h3>Мои расписания</h3></a>
                </div>
            <?php elseif (isset($_SESSION['employees'])): ?>
                <div class="create_course">
                    <a href="schedules_for_emp.php"><h3>Мои расписания</h3></a>
                </div>
            <?php endif; ?>

            <div class="courses_box">
                <?php if (!empty($courses)): ?>
                <?php foreach ($courses as $course): ?>
                    <a href="change.php?course_id=<?php echo $course['course_id']; ?>">
                    <div class="courses">
                        <div class="couses_cart">
                            <div>
                                <img class="course_cart_image" src="../images/course1.png" alt="" />
                            </div>
                            <div class="course_cart_info">
                                <img src="../images/figma logo.svg" alt="" />
                                <p class="course_card_trans"><?= $course['course_name']; ?></p>
                            </div>
                            <p class="course_card_descr">
                                <?= $course['overview']; ?>
                            </p>
                            <div class="price">
                                <p class="course_card_descr_2">
                                    <p>Продолжительность (в месяцах): <?= $course['duration']; ?></p>
                                </p>
                            </div>
                        </div>
                    </div>
                    </a>
                <?php endforeach; ?>
                <?php else: ?>
                    <h2>У вас нет курса</h2> 
                <?php endif; ?>  
            </div>
        <?php require "../blocks/footer_in_folder.php" ?> 
    </div>

    <script src="../js/dropdown.js"></script>
</body>
</html>
