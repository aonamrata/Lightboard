<?php

require_once './lightboard.php';


try {
    $board = new Lightboard();
    if ($_POST) {
        $boardData = $board->postAction($_POST);
        header("Content-Type: text/json");
        echo $boardData;
    } else {

        $boardData = $board->indexAction();
        header("Content-Type: text/json");
        echo $boardData;

    }
} catch (Exception $exec) {
    header("HTTP/1.1 500 Server Error");
    echo json_encode(array("Error" => $exec->getMessage()));
}