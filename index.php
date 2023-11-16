<?php
  session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>TechnoHouse</title>
  <link rel="stylesheet" href="css/normalize.css" />
  <link rel="stylesheet" href="css/main.css" />
  <link rel="stylesheet" href="css/style.css">
</head>

<body>
  <div class="wrap">
    <div class="container">
      
    <header class="header">
    <a href="" class="logo">
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

      
      <div class="intro">
        <h1 class="h1">Techno<span class="h1_house">House</span></h1>
        <p class="h1_discr">Образовательная школа новых технологий</p>
        <a href="#contacts" class="intro_button">Заказать звонок</a>
        <img src="images/Group 16.png" alt="" class="asel" />
      </div>
    </div>
  </div>
  <div class="wrap_2">
    <div class="container">
      <div class="why_th">
        <p class="why_th_text">
          Мы стремимся сделать обучение программированию доступным и понятным
          для всех, кто хочет освоить эту востребованную и перспективную
          профессию.<br />
          Наши курсы предназначены как для начинающих, так и для тех, кто уже
          имеет некоторый опыт в программировании. Наша методика обучения
          основана на практических заданиях и проектах, что позволяет нашим
          ученикам получить реальный опыт работы и подготовиться к будущей
          карьере в программировании.<br />
          Наша команда состоит из опытных и квалифицированных преподавателей,
          которые всегда готовы помочь и поддержать своих учеников на каждом
          этапе обучения.<br />
          Мы гордимся тем, что наша компания имеет репутацию надежного и
          профессионального партнера в сфере обучения программированию.<br />
          Мы стремимся к постоянному совершенствованию нашей методики обучения
          и к развитию новых курсов, чтобы удовлетворить потребности наших
          учеников и быть на шаг впереди в индустрии.
        </p>
      </div> 
    <div id="contacts" class="contacts">
      <div class="container">
        <div class="contacts__wrap">
          <div class="contacts__block">
            <form action="">
              <div class="contacts__header">
                <h1>Связаться с нами</h1>
                <p>
                  Заполните форму заявки ниже, чтобы получить консультацию от
                  нашей команды. Укажите свое имя и контактные данные, чтобы
                  мы могли связаться с вами и ознакомиться с вашими
                  потребностями.
                </p>
              </div>
              <div class="contacts__form">
                <input type="text" class="form__input" placeholder="ФИО" />
                <input type="text" class="form__input" placeholder="Город" />
                <input type="text" class="form__input" placeholder="Номер телефона" />
                <input type="text" class="form__input" placeholder="E-mail" />
                <!-- <input type="checkbox" name="" class="form__checkbox" id="" />
                <span>I want to protect my data by signing an NDA</span> -->
                <button class="form__btn" type="submit">
                  Записаться на курс
                </button>
              </div>
            </form>
          </div>
          <div class="contacts__map">
            <iframe
              src="https://yandex.ru/map-widget/v1/?um=constructor%3Abc4882d8a3bbf16a76ace6ac480efb285bde9e04ff20bd9c6b652a76d578a8d1&amp;source=constructor"
              width="520" height="683" frameborder="0"></iframe>
          </div>
        </div>
      </div>
    </div>
    <footer class="footer">
      <div class="container">
        <div class="footer__logo">
          <a href="./index.html">
            <img src="images/LOGO.svg" alt="" />
          </a>
        </div>
        <div class="footer__nav">
          <ul>
            <li class="footer__nav__item">
              <a href="">+7 747 908 51 29</a>
            </li>
            <li class="footer__nav__item">
              <a href="">techno.house.almaty@gmail.com</a>
            </li>
            <li class="footer__nav__item">
              <a href="">
                Казахстан, город Алматы<br />
                улица Абдуллиных, дом 30</a>
            </li>
          </ul>
        </div>
        <div class="footer__social">
          <div class="social__item">
            <a href="https://www.instagram.com/techno.house.almaty/">
              <img src="images/pngaaa 1.png" alt="" />
            </a>
          </div>
        </div>
      </div>
    </footer>
  </div>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
  <script src="js/slick.min.js"></script>
  <script src="js/main.js"></script>
</body>

</html>