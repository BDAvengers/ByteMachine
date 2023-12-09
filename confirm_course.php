<?php 
    session_start();
    $client_id = $_SESSION['client_id']; 

    $group_id = $_GET['group_id'];  
    require 'vender/connect.php';
    $stmt = $connect->prepare("SELECT groups_all.group_name, groups_all.group_type, courses.ind_price, courses.group_price 
    FROM groups_all join courses on groups_all.course_id = courses.course_id where groups_all.group_id = :group_id");
    $stmt->bindParam(':group_id', $group_id);
    $stmt->execute();
    $GroupData = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Купить курс</title>
    <link rel="website icon" type="png" href="images/logo_2.png">
    <link rel="stylesheet" href="css/confirm_course.css">
    <link rel="stylesheet" href="css/message.css">
</head>
<body>

    <div class="wrap"> 
        <div class="container">
            <?php require 'blocks/header.php'; ?>
        </div>
 
        

        <div class="confirm_box">
            <?php if (isset($_SESSION['message'])) : ?>
                <p class="msg"> <?php echo $_SESSION['message']; ?> </p>
                <?php unset($_SESSION['message']); ?>
            <?php endif; ?>
            <h1 >Подтвердите оплату</h1>
            <?php foreach($GroupData as $data): ?>
                <h2>Имя курса: <?php echo $data['group_name']; ?></h2>
                <h2>Тип группы: <?php echo $data['group_type']; ?></h2>
                <h2>Идентификатор оплаты: <?php echo $client_id. '-' .$group_id; ?></h2>
                <?php if ($data['group_type'] == 'individual'): ?>
                    <h2>Цена этого курса: <?php echo $data['ind_price']; ?> тг</h2>
                <?php elseif ($data['group_type'] == 'group'): ?>
                    <h2>Цена этого курса: <?php echo $data['group_price']; ?> тг</h2>
                <?php endif; ?>
            <?php endforeach; ?>

            <form action="vender/buy_course.php" method="post"> 
                <input type="hidden" id="client_id" name="client_id">
                <input type="hidden" id="date_pay" name="date_pay">
                <input type="hidden" id="group_id" name="group_id" value="<?php echo $_GET['group_id']; ?>">   
                
                    <input type="submit" value="Оплатить">
                
            </form>     
        </div>
        <div class="confirm_box">

            <form action="vender/show_status.php" method="post">
                <input type="hidden" name="client_id">
                <input type="hidden" name="group_id" value="<?php echo $_GET['group_id']; ?>">
                
                    <input type="submit" value="Проверить свой статус">
                
            </form>
        </div>

        <?php require 'blocks/footer.php' ?>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        $(document).ready(function() {
            $("#submitBtn").on("click", function() {
                var client_id = $("#client_id").val();
                var date_pay = $("#date_pay").val();
                var group_id = $("#group_id").val();

                $.ajax({
                    type: "POST",
                    url: "vender/buy_course.php",
                    data: { client_id: client_id, date_pay: date_pay, group_id: group_id },
                    success: function(data) {
                        // Открыть новое окно после успешной отправки формы
                        var newWindow = window.open(data, "_blank");
                    }
                });
            });
        });
    </script>
    <script src="js/dropdown.js"></script>
</body>
</html>