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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Купить курс</title>
    <link rel="website icon" type="png" href="images/logo_2.png">
</head>
<body>

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

</body>
</html>