<?php
namespace core;
use \PDO;

class db {
    public $pdo;

    function __construct() {
        try{

            $pdo = new PDO("mysql:host=localhost;dbname=szachy;charset=utf8", "root", "");
            $this->pdo = $pdo;

        } catch(PDOException $e){
            $msg = getMsg();
            $msg->add($e);
        }
    }

    function getPDO(){
        return $this->pdo;
    }
}