<?php
  session_start();
?> 

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comand</title>
<link rel="stylesheet" href="css/command.css">
</head>
<body>
<div class="wrap"> 
    <div class="container">
      <?php require "blocks/header.php" ?>
    </div>
      <div id="team" class="team">
        <h3 class="couses_children">Команда</h3>
        <div class="team__wrap">
          <div class="team_cards">
            <div class="team_card">
              <div class="team_card_left">
                <img class="teacher_img" src="images/2 учитель.png" alt="" />
              </div>
              <div class="team_card_right">
                <p class="teacher_name">Абдилдаева Асель</p>
                <div class="teacher_skill">
                  <p class="teacher_skill_offer">Должность:</p>
                  <p class="teacher_skill_text">Директор</p>
                </div>
                <div class="teacher_skill">
                  <p class="teacher_skill_offer">Ученая степень:</p>
                  <p class="teacher_skill_text">PhD, ассоц.профессор</p>
                </div>
                <div class="teacher_skill skill__none">
                  <p class="teacher_skill_offer">Образование:</p>
                  <p class="teacher_skill_text">
                    Доктор (PhD)- «Информационные системы» Международный
                    университет информационных технологий
                  </p>
                </div>
              </div>
            </div>
            <div class="team_card">
              <div class="team_card_left">
                <img class="teacher_img" src="images/Frame 1.png" alt="" />
              </div>
              <div class="team_card_right">
                <p class="teacher_name">Мэлс Женис</p>
                <div class="teacher_skill">
                  <p class="teacher_skill_offer">Должность:</p>
                  <p class="teacher_skill_text">Преподаватель</p>
                </div>
                <div class="teacher_skill">
                  <p class="teacher_skill_offer">Ученая степень:</p>
                  <p class="teacher_skill_text">Магистр</p>
                </div>
                <div class="teacher_skill">
                  <p class="teacher_skill_offer">Skills:</p>
                  <p class="teacher_skill_text">
                    HTML, CSS, JavaScript, CISCO, Figma
                  </p>
                </div>
                <div class="teacher_skill skill__none">
                  <p class="teacher_skill_offer">Образование:</p>
                  <p class="teacher_skill_text">
                    Master of Science: Computer science Astana International
                    university
                  </p>
                </div>
                <div class="teacher_skill">
                  <p class="teacher_skill_text">
                    Имеет опыт разработки веб-приложений и создания дизайна.
                  </p>
                </div>
              </div>
            </div>
          </div>
          <div class="team_cards">
            <div class="team_card">
              <div class="team_card_left">
                <img class="teacher_img" src="images/4 учитель.png" alt="" />
              </div>
              <div class="team_card_right">
                <p class="teacher_name">Марденов Ерик</p>
                <div class="teacher_skill">
                  <p class="teacher_skill_offer">Должность:</p>
                  <p class="teacher_skill_text">Преподаватель</p>
                </div>
                <div class="teacher_skill">
                  <p class="teacher_skill_offer">Ученая степень:</p>
                  <p class="teacher_skill_text">Магистр</p>
                </div>
                <div class="teacher_skill">
                  <p class="teacher_skill_offer">Skills:</p>
                  <p class="teacher_skill_text">
                    Базы данных, Машинное обучение
                  </p>
                </div>
                <div class="teacher_skill skill__none">
                  <p class="teacher_skill_offer">Образование:</p>
                  <p class="teacher_skill_text">Магистр: Приборостроение ВКТУ имени Д.Серикбаева</p>
                </div>
                <div class="teacher_skill">
                  <p class="teacher_skill_text">
                    Имеет опыт в машинном обучении и базы данных.
                  </p>
                </div>
              </div>
            </div>
            <div class="team_card">
              <div class="team_card_left">
                <img class="teacher_img" src="images/3 учитель.png" alt="" />
              </div>
              <div class="team_card_right">
                <p class="teacher_name">Курманбаев Азамат</p>
                <div class="teacher_skill">
                  <p class="teacher_skill_offer">Должность:</p>
                  <p class="teacher_skill_text">Преподаватель</p>
                </div>
                <div class="teacher_skill">
                  <p class="teacher_skill_offer">Ученая степень:</p>
                  <p class="teacher_skill_text">Магистр</p>
                </div>
                <div class="teacher_skill">
                  <p class="teacher_skill_offer">Skills:</p>
                  <p class="teacher_skill_text">
                    HTML, CSS, JavaScript, React, Figma
                  </p>
                </div>
                <div class="teacher_skill skill__none">
                  <p class="teacher_skill_offer">Образование:</p>
                  <p class="teacher_skill_text">Магистр: Информационные системы КазАТУ</p>
                </div>
                <div class="teacher_skill">
                  <p class="teacher_skill_text">
                    Имеет опыт разработки веб-приложений и создания дизайна.
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>


    <?php require "blocks/footer.php" ?>
    </div>

    <script src="js/dropdown.js"></script>
</body>
</html>