<?php 
  session_start();
  require 'vender/connect.php';
  $courses = [];
  $statement = $connect->prepare("SELECT * FROM courses ORDER BY course_id");
  $statement->execute();
  $courses = $statement->fetchAll(PDO::FETCH_ASSOC);
    $isEmployee = isset($_SESSION['employees']);
    if ($isEmployee) {
        // Пользователь является сотрудником, поэтому отображаем кнопку "Создать курс"
        $showCreateCourseButton = true;
    } else {
        // Пользователь не является сотрудником, поэтому скрываем кнопку "Создать курс"
        $showCreateCourseButton = false;
    }
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Courses</title>
    <link rel="stylesheet" href="css/course.css">
    <link rel="website icon" type="png" href="images/logo_2.png">
</head>
<body> 
  <div class="wrap">
      <div class="container">
        <?php require "blocks/header.php" ?>
      </div>
      <p class="couses_children">Все курсы</p>

      <?php if ($showCreateCourseButton) { ?>
        <div class="create_course">
          <a href="create_course.php"><h3>Создать свой курс</h3></a>
        </div>
      <?php } ?>

      <div class="courses_box">
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
                      <p>Продолжительность (в месяцах): <?= $course['duration']; ?></p>
                    </p>
                </div>
              </div>
            </div>
          </a>
        <?php endforeach; ?>
      </div>
      <?php require 'blocks/footer.php' ?>
  </div>

  <script src="js/dropdown.js"></script>
  
</body>
</html>
