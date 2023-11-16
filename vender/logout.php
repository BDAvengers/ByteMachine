<?php
    session_start();
    unset($_SESSION['clients']);
    unset($_SESSION['employees']);
    header('Location: ../index.php');
    exit();
?>
