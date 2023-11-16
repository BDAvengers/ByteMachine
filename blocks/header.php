  <?php
    session_start();
  ?>
</html>
  <div class="wrap">
      <div class="container">
        <header class="header">
          <a href="Index.php" class="logo">
            <img src="images/logo_2.png" alt="" />
          </a>
          <ul class="nav">
            <li class="nav_item3">
              <a href="index.php" class="nav_item_link">Главная</a>
            </li>
            <li class="nav_item">
              <a href="about-us.php" class="nav_item_link">О нас</a>
            </li>
            <li class="nav_item">
              <a href="course.php" class="nav_item_link">Курсы</a>
            </li>
            <li class="nav_item">
              <a href="comand.php" class="nav_item_link">Команда</a>
            </li>

            <?php if (isset($_SESSION['clients']) || isset($_SESSION['employees'])) { ?>
            <li class="nav_item2">
                <a href="profile.php" class="nav_item_link2">
                    <?php 
                        if (isset($_SESSION['clients'])) {
                            echo $_SESSION['clients']['full_name'];
                        } else {
                            echo $_SESSION['employees']['full_name'];
                        }
                    ?>
                </a>
            </li>
            <?php } else { ?>
                <li class="nav_item2">
                    <a href="sign-in.php" class="nav_item_link2">Войти</a>
                </li>
                <li class="nav_item2">
                    <a href="sign-up.php" class="nav_item_link2">Регистрация</a>
                </li>
            <?php } ?>
            
          </ul>
        </header>
      </div>
  </div>
