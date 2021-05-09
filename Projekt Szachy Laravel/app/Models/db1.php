<?php
namespace App\Models;
use \PDO;

class db1 {
    public $pdo;
    private $zapytanie;

    function __construct() {
        try{

            $pdo = new PDO("mysql:host=192.168.8.254;dbname=niestroj21_szachy;charset=utf8", "root", "");
            $this->pdo = $pdo;

        } catch(PDOException $e){
            $msg = getMsg();
            $msg->add($e);
        }
    }

    function przygotuj($sql){
        try{
            $this->zapytanie = $this->pdo -> prepare($sql);
        } catch(PDOException $e){
            $msg = getMsg();
            $msg->add($e);
            return;
        }
    }

    function zmienna($zmienna,$wartość,$typ){
        if($typ=="int") $typ = PDO::PARAM_INT; else $typ = PDO::PARAM_STR;
        try{
            $this->zapytanie->bindValue($zmienna,$wartość,$typ);
        } catch(PDOException $e){
            $msg = getMsg();
            $msg->add($e);
            return;
        }
    }

    function wykonaj(){
        try{
            $this->zapytanie->execute();
        } catch(PDOException $e){
            $msg = getMsg();
            $msg->add($e);
            return;
        }
    }

    function ostatnieId(){
        try{
            return $this->pdo->lastInsertId();
        } catch(PDOException $e){
            $msg = getMsg();
            $msg->add($e);
            return;
        }
    }

    function przechwyc(){
        return $this->zapytanie;
    }

    function getPDO(){
        return $this->pdo;
    }
}