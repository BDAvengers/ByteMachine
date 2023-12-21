<?php
    try {
        $connect = new PDO("pgsql:host=srv-db-pgsql01.ps.kz;port=5432;dbname=technoh1_ByteMachine",
                           "technoh1_byte", "pajFCbxPCtc3ywB");
        $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
?>