<?php

require_once './locking.php';


try {
    $lock = new Locking();
    if ($_POST && !empty($_POST['user_name'])) {
        $lockData = $lock->setLockStatus($_POST);
        header("Content-Type: text/json");
        echo $lockData;

    }else if ($_POST && empty($_POST['user_name'])) {
        
        $lockData = $lock->deleteLockStatus();
        header("Content-Type: text/json");
        echo $lockData;
    
    } else {

        $lockData = $lock->getLockStatus();
        header("Content-Type: text/json");
        echo $lockData;

    }
} catch (Exception $exec) {
    header("HTTP/1.1 500 Server Error");
    echo json_encode(array("Error" => $exec->getMessage()));
}