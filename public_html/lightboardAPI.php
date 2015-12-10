<?php

require_once './lightboard.php';


try {
    $board = new Lightboard();
    if ($_POST) {
        $boardData = $board->postAction($_POST);
        header("Content-Type: text/json");
        header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
        header("Pragma: no-cache"); // HTTP 1.0.
        header("Expires: 0"); // Proxies.
        echo $boardData;
    } else {

        $boardData = $board->indexAction();
        header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
        header("Pragma: no-cache"); // HTTP 1.0.
        header("Expires: 0"); // Proxies.
        header("Content-Type: text/json");
        echo $boardData;
    }
} catch (Exception $exec) {
    header("HTTP/1.1 500 Server Error");
    header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
    header("Pragma: no-cache"); // HTTP 1.0.
    header("Expires: 0"); // Proxies.
    echo json_encode(array("Error" => $exec->getMessage()));
}