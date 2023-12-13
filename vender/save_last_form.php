<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['lastForm'])) {
        $_SESSION['last_form'] = $_POST['lastForm'];
    }
}
?>
