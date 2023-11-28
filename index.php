<?php
  session_start();
?>
<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>ByteMachine</title>
  <link rel="stylesheet" href="css/main.css">
</head>

<body>
  <div class="wrap">
    <div class="container">
      <?php require 'blocks/header.php'?>
    </div>
      <div class="intro">
        <h1 class="h1">Byte<span class="h1_house">Machine</span></h1>
        <p class="h1_discr">Образовательная школа новых технологий</p>
        <a href="#contacts" class="intro_button">Заказать звонок</a>
      </div>
      
  </div>
  <div class="wrap_2">
    <div class="container2">
      <div class="why_th">
        <p class="why_th_text">
          Мы стремимся сделать обучение программированию доступным и понятным
          для всех, кто хочет освоить эту востребованную и перспективную
          профессию.
          Наши курсы предназначены как для начинающих, так и для тех, кто уже
          имеет некоторый опыт в программировании. Наша методика обучения
          основана на практических заданиях и проектах, что позволяет нашим
          ученикам получить реальный опыт работы и подготовиться к будущей
          карьере в программировании.
          Наша команда состоит из опытных и квалифицированных преподавателей,
          которые всегда готовы помочь и поддержать своих учеников на каждом
          этапе обучения.
          Мы гордимся тем, что наша компания имеет репутацию надежного и
          профессионального партнера в сфере обучения программированию.
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
  </div>

  <?php require 'blocks/footer.php'?>

  <script src="js/dropdown.js"></script>
  
</body>

</html>