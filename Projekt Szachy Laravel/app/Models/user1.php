<?php
namespace App\Models;

class user1 {
    public $user;
    public $login;
    private $zaproszenia;
    private $wygrane;
    private $ostGra;

    function __construct(){
        if(session_status() == PHP_SESSION_NONE) session_start();
        $this->user = isset($_SESSION['user']) ? $_SESSION['user'] : NULL;



        $id = (int)$this->user;
        $db = new db1();
        $db->przygotuj("SELECT * FROM gracz WHERE UID = :id LIMIT 1");
        $db->zmienna(":id",$id,"int");
        $db->wykonaj();
        $z = $db->przechwyc();
        while($baza = $z->fetch()){
            $this->login = $baza['login'];
            $this->zaproszenia = $baza['zaproszenia'];
            $this->wygrane = $baza['wygrane'];
            $this->ostGra = $baza['ostatnia_gra'];
        }
        $z->closeCursor();
    }
    function getLogin(){
        return $this->login;
    }
    function getUID(){
        return $this->user;
    }
    function getZaproszenia(){
        if($this->zaproszenia == "") return NULL;
        else{
            $z = explode(".",$this->zaproszenia);
            return $z;
        }
    }
    function nick($id){
        $db = new db1();
        $db->przygotuj("SELECT login FROM gracz WHERE UID = :id LIMIT 1");
        $db->zmienna(":id",$id,"int");
        $db->wykonaj();
        $z = $db->przechwyc();
        $nick = NULL;
        while($baza = $z->fetch()){
            $nick = $baza['login'];
        }
        $z->closeCursor();
        return $nick;
    }
    function getWygrane(){
        return $this->wygrane;
    }
    function getOstGra(){
        return $this->ostGra;
    }
}