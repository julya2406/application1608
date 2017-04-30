<?php
class DataBase {
    protected static $pdo;

    public function __construct() {
        if (!self::$pdo) {
            self::$pdo = new PDO('mysql:host=' . DB_SERVER . ';dbname=' . DB_NAME . ';charset=' . DB_CHARSET, DB_USER, DB_PASSWORD);
            self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
    }

    public function rowsCount($tableName) {
        $query = 'SELECT COUNT(*) FROM ' . $tableName;
        $result = self::$pdo->query($query, PDO::FETCH_NUM);
        $row = $result->fetch();
        return $row[0];
    }

    public function insert($table, array $params) {
        $strfields = implode(', ', array_keys($params));
        $values = array_values($params);
        $parameters = implode(', ', array_fill(0, count($params), '?'));
        $query = 'INSERT INTO ' . $table . ' (' . $strfields . ') VALUES (' . $parameters . ')';
        $pdostmt = self::$pdo->prepare($query);
        for ($i = 0; $i<count($values); $i++) {
            $pdostmt->bindParam($i+1, $values[$i]);
        }
        $result = $pdostmt->execute();
        if ($result) {
            return self::$pdo->lastInsertId();
        } else {
            return false;
        }
    }

    public function select($query, $username) {
        //$values = array_values($params);
        $pdostmt = self::$pdo->prepare($query);
        //for ($i = 0; $i<count($values); $i++) {
        $pdostmt->bindParam(':username', $username);
        // }
        $result = $pdostmt->execute();
        if ($result) {
            return $pdostmt->fetchAll(PDO::FETCH_ASSOC);
        } else {
            return false;
        }
    }

    public function update($table, array $params){
        $query = "";
    }

    public function delete($table){

    }

}