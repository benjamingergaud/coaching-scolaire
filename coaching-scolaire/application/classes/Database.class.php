<?php
/**
 * Created by PhpStorm.
 * User: maxime
 * Date: 18/11/2017
 * Time: 13:12
 */

class Database {
    private $pdo;
    function __construct()
    {
        $dbhost = "localhost";
        $dbname = "coaching-scolaire";
        $dbuser = "root";
        $dbpass = "";

        $this->pdo = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass, [
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\'',
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);
    }

    function fetchAll($sql, array $arguments = [], $fetchType = PDO::FETCH_ASSOC) {
        $query = $this->pdo->prepare($sql);
        $query->execute($arguments);
        return $query->fetchAll($fetchType);
    }

    function queryOne($sql, array $arguments = [], $fetchType = PDO::FETCH_ASSOC) {
        $query = $this->pdo->prepare($sql);
        $query->execute($arguments);
        return $query->fetch($fetchType);
    }

    function executeSql($sql, array $arguments = []) {
        $query = $this->pdo->prepare($sql);
        $query->execute($arguments);
        return $this->pdo->lastInsertId();
    }

}
