<?php

require_once './locking.php';


try {
    $lock = new Locking();
    if ($_POST && !empty($_POST['user_name'])) {
        $lockData = $lock->setLockStatus($_POST);
        header("Content-Type: text/json");
        header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
        header("Pragma: no-cache"); // HTTP 1.0.
        header("Expires: 0"); // Proxies.
        echo $lockData;
    } else if ($_POST && empty($_POST['user_name'])) {

        $lockData = $lock->deleteLockStatus();
        header("Content-Type: text/json");
        header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
        header("Pragma: no-cache"); // HTTP 1.0.
        header("Expires: 0"); // Proxies.
        echo $lockData;
    } else {

        $lockData = $lock->getLockStatus();
        header("Content-Type: text/json");
        header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
        header("Pragma: no-cache"); // HTTP 1.0.
        header("Expires: 0"); // Proxies.
        echo $lockData;
    }
} catch (Exception $exec) {
    header("HTTP/1.1 500 Server Error");
    header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
    header("Pragma: no-cache"); // HTTP 1.0.
    header("Expires: 0"); // Proxies.
    echo json_encode(array("Error" => $exec->getMessage()));
}