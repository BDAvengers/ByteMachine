<?php
    session_start();
    if (!isset($_SESSION['clients']) && !isset($_SESSION['employees'])) {
        header('Location: ../index.php');
        exit();
    } else if (isset($_SESSION['clients'])) {
        $user = $_SESSION['clients']; 
    } else if (isset($_SESSION['employees'])) {
        $user = $_SESSION['employees'];
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Настройка</title>
    <link rel="stylesheet" href="../css/settings.css">
    <link rel="stylesheet" href="../css/message.css">
    <link rel="website icon" type="png" href="../images/logo_2.png">
</head> 
<body> 
    <div class="wrap">
        <div class="container">
            <?php require "../blocks/header_in_folder.php" ?>
        </div>
        <div class="container2">
            <div class="left_box"> 
                <div class="left_container">
                    <p><a href="javascript:void(0);" onclick="showForm('editProfileForm')">Редактировать профиль</a></p>
                    <p><a href="javascript:void(0);" onclick="showForm('changePasswordForm')">Изменить пароль</a></p>
                </div>
            </div>
            <div class="right_box">
                <div class="right_container" id="editProfileForm">
                    <form class="prof" action="../vender/settings_vender.php" method="post">
                        <?php if (isset($_SESSION['clients']) || isset($_SESSION['employees'])) { ?>
                            <h1>Редактирование профиля</h1>
                            <p>Ф.И.О: <input type="text" name="full_name" value="<?= $user['full_name']; ?>"></p>
                            <p>Номер телефона: <input type="text" name="phone_number" value="<?= $user['phone_number']; ?>"></p>
                            <p>Дата рождения: <input type="date" name="date_birth" value="<?= $user['date_birth']; ?>"></p>
                            <input type="hidden" name="operation" value="edit_profile">
                            <input type="submit" value="Сохранить">
                        <?php } ?>
                    </form>
                    <?php if (isset($_SESSION['edit_profile_message'])) : ?>
                        <p class="msg"> <?php echo $_SESSION['edit_profile_message']; ?> </p>
                        <?php unset($_SESSION['edit_profile_message']); ?>
                    <?php endif; ?>
                </div>
                <div class="right_container" id="changePasswordForm" style="display: none;">
                    <form class="prof" action="../vender/settings_vender.php" method="post">
                        <?php if (isset($_SESSION['clients']) || isset($_SESSION['employees'])) { ?>
                            <h1>Изменить пароль</h1>
                            <p>Текущий пароль: <input type="password" name="password"></p>
                            <p>Новый пароль: <input type="password" name="new_password"></p>
                            <p>Новый пароль (ещё раз): <input type="password" name="confirm_password"></p>
                            <input type="hidden" name="operation" value="change_password">
                            <input type="submit" value="Сохранить">
                        <?php } ?>
                    </form>
                    <?php if (isset($_SESSION['change_password_message'])) : ?>
                        <p class="msg"> <?php echo $_SESSION['change_password_message']; ?> </p>
                        <?php unset($_SESSION['change_password_message']); ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php require "../blocks/footer_in_folder.php" ?>
    </div>
    <script src="../js/dropdown.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        $(document).ready(function() {
            // Получить значение последней формы из сессии
            var lastForm = "<?php echo isset($_SESSION['last_form']) ? $_SESSION['last_form'] : 'editProfileForm'; ?>";

            // Скрыть все формы
            $('.right_container').hide();

            // Показать только выбранную форму
            $('#' + lastForm).show();

            // Добавить обработчик события клика на ссылки
            $('.left_container a').click(function() {
                // Удалить стиль активности у всех ссылок
                $('.left_container a').removeClass('active');

                // Добавить стиль активности к текущей ссылке
                $(this).addClass('active');

                // Сохранить значение последней открытой формы в сессии
                var formId = $(this).data('form');
                if (formId) {
                    $.post('../vender/save_last_form.php', { lastForm: formId });
                }
            });
        });

        function showForm(formId) {
            // Скрыть все формы
            $('.right_container').hide();

            // Показать только выбранную форму
            $('#' + formId).show();

            // Сохранить значение последней открытой формы в сессии
            $.post('../vender/save_last_form.php', { lastForm: formId });
        }
    </script>
</body>
</html>