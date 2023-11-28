        <header class="header">
          <a href="index.php" class="logo">
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
                <a href="command.php" class="nav_item_link">Команда</a>
                </li>
            </ul> 
        </header>
            <div class="user-box" id="user-box">
                <?php if (isset($_SESSION['clients']) || isset($_SESSION['employees'])) { ?>
                    <div class="dropdown" onclick="toggleDropdown(event)">
                        <a href="javascript:void(0);" class="dropdown-toggle">
                            <?php 
                                if (isset($_SESSION['clients'])) {
                                    echo $_SESSION['clients']['full_name'];
                                } else {
                                    echo $_SESSION['employees']['full_name'];
                                }
                            ?>
                        </a>
                        <div id="dropdown" class="dropdown-menu">
                            <a href="profile/profile.php" class="dropdown-link">Профиль</a>
                            <a href="profile/my_courses.php" class="dropdown-link">Мои курсы</a>
                            <a href="" class="dropdown-link">Мои расписания</a>
                            <a href="#" class="dropdown-link">Настройки</a>
                            <a href="vender/logout.php" class="dropdown-link">Выход</a>
                        </div>
                    </div>
                <?php } else { ?>
                    <div class="nav_item2">
                        <a href="sign-in.php" class="nav_item_link2">Войти</a>
                    </div>
                    <div class="nav_item2">
                        <a href="sign-up.php" class="nav_item_link2">Регистрация</a>
                    </div>
                <?php } ?>
            </div>