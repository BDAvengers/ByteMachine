<?php 
    session_start();
?>    

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Страница банка</title>
</head>
<body>
    <h1>Страница банка</h1>
     
    <form action="vender/save_transaction.php" method="post">
        <input type="hidden" id="status" name="status" value="Оплачен"> 
        <input type="hidden" id="client_id" name="client_id" value="<?php echo $_SESSION['client_id']; ?>">
        <input type="hidden" id="group_id" name="group_id" value="<?php echo $_GET['group_id']; ?>">   
        <input type="submit" value="Оплатить">                
    </form>   
    
    <form action="vender/save_transaction.php" method="post">
        <input type="hidden" id="status" name="status" value="Не оплачен"> 
        <input type="hidden" id="client_id" name="client_id" value="<?php echo $_SESSION['client_id']; ?>">
        <input type="hidden" id="group_id" name="group_id" value="<?php echo $_GET['group_id']; ?>">   
        <input type="submit" value="Не оплатить">                
    </form>   

</body>
</html>