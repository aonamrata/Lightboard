<?php

class Locking {

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

    public function getLockStatus() {
        self::getConnction();
        $sth = self::$conn->prepare('SELECT * from locking where lock_name = "lightboard"');
        $sth->execute();
        $lockResult = $sth->fetchAll(PDO::FETCH_OBJ);
        $lockData = '';
        if (count($lockResult) > 0) {
            $lockData = array_pop($lockResult);
        }

        return(json_encode($lockData));
    }
    
    public function setLockStatus($data) {
        self::getConnction();

        $sth2 = self::$conn->prepare('INSERT INTO locking (locked_by, lock_name) VALUES(:data , "lightboard")');
        if ($sth2->execute(array('data' => $data['user_name'] ))) {
            return $this->getLockStatus();
        } else {
            throw new Exception("Some error updating board data");
        }
    }
    
    public function deleteLockStatus() {
        self::getConnction();

        $sth2 = self::$conn->prepare('DELETE FROM locking where lock_name = "lightboard"');
        if ($sth2->execute()) {
            return $this->getLockStatus();
        } else {
//            print_r(self::$conn->errorInfo());
            throw new Exception("Some error updating board data");
        }
    }

}
