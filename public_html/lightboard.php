<?php

class Lightboard {

    protected $boardData;
    protected static $conn;

    public function __construct() {
        
    }

    protected static function getConnction() {
        if (!self::$conn) {
            try {
                // Ideally this would be in a noSql flat table.
                self::$conn = new PDO(
                        'mysql:host=localhost;dbname=mydatabase', 'root', ''
                );
            } catch (PDOException $e) {
                //Need to raise exception and let error controller handle it.
                echo json_encode(array("Error" => $e->getMessage()));
                die();
            }
        }
        return self::$conn;
    }

    public function indexAction() {
        self::getConnction();
        $sth = self::$conn->prepare('SELECT * from lightboard limit 1');
        $sth->execute();
        $result = $sth->fetchAll(PDO::FETCH_OBJ);

        if (count($result) > 0) {
            return array_pop($result)->board_data;
        } else {
            $data = $this->createNewBoard();
            $sth = self::$conn->prepare('INSERT INTO lightboard (board_data) VALUES (:data)');
            if ($sth->execute(array('data' => json_encode($data)))) {
                return json_encode($data);
            } else {
                throw new Exception("Some error saving board data");
            }
        }
    }

    public function postAction($data) {
        $this->validatePost($data);
        self::getConnction();
        $sth = self::$conn->prepare('SELECT * from lightboard limit 1');
        $sth->execute();
        $result = $sth->fetchAll(PDO::FETCH_OBJ);
        $selRow = array_pop($result);
        $boardData = json_decode($selRow->board_data, true);
        $boardData[$data['row']][$data['col']] = $data['color'];
        $sth2 = self::$conn->prepare('UPDATE lightboard SET board_data = :data WHERE id= :id');
        if ($sth2->execute(array('data' => json_encode($boardData), 'id' => $selRow->id))) {
            return json_encode($boardData);
        } else {
            throw new Exception("Some error updating board data");
        }
        return json_encode($boardData);
    }

    protected function validatePost($data) {
        if (!isset($data['row']) || !isset($data['col']) || !isset($data['color'])) {
            throw new Exception("Invalid board data to save.");
        }
    }

    protected function createNewBoard() {
        $lightBoard = array();
        for ($row = 0; $row < 10; $row++) {
            for ($column = 0; $column < 10; $column++) {
                $lightBoard[$row][$column] = "0";
            }
        }

        return $lightBoard;
    }

}
