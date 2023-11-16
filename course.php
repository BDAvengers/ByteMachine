<?php 
  require 'vender/connect.php';
      
  $courses = [];
  $statement = $connect->prepare("SELECT * FROM courses");
  $statement->execute();
  $courses = $statement->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Courses</title>
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/normalize.css" />
    <link rel="stylesheet" href="css/style.css" />
</head>
<body>

    <?php require "blocks/header.php" ?>
    
    <?php 
    $isEmployee = isset($_SESSION['employees']);
    if ($isEmployee) {
        // Пользователь является сотрудником, поэтому отображаем кнопку "Создать курс"
        $showCreateCourseButton = true;
    } else {
        // Пользователь не является сотрудником, поэтому скрываем кнопку "Создать курс"
        $showCreateCourseButton = false;
    }
    ?>

    <?php if ($showCreateCourseButton) { ?>
      <div class="create_course">
        <a href="create_course.php"><h3>Создать свой курс</h3></a>
      </div>
    <?php } ?>
 
      <p class="couses_children">Все курсы</p>
      <?php foreach ($courses as $course): ?>
        <a href="course_inf.php?course_id=<?php echo $course['course_id']; ?>">
          <div class="courses">
            <div class="couses_cart">
              <div>
                <img class="course_cart_image" src="images/course1.png" alt="" />
              </div>
              <div class="course_cart_info">
                <img src="images/figma logo.svg" alt="" />
                <p class="course_card_trans"><?= $course['course_name']; ?></p>
              </div>
              <p class="course_card_descr">
                <?= $course['overview']; ?>
              </p>
              <div class="price">
                  <p class="course_card_descr_2">
                  <p>Цена: <?= $course['price']; ?> тг</p>
                  <p>Продолжительность (в месяцах): <?= $course['duration']; ?></p>
                  </p>
              </div>
            </div>
          </div>
        </a>
      <?php endforeach; ?>
</body>
</html>
