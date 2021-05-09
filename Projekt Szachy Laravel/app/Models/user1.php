<?php
namespace App\Models;

class user1 {
    public $user;
    public $login;
    private $zaproszenia = array();
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
            $this->wygrane = $baza['wygrane'];
            $this->ostGra = $baza['ostatnia_gra'];
        }
        $z->closeCursor();

        $db->przygotuj("SELECT zapraszajacy FROM zaproszenie WHERE zaproszony = :id");
        $db->zmienna(":id",$id,"int");
        $db->wykonaj();
        $z = $db->przechwyc();
        while($baza = $z->fetch()){
            $this->zaproszenia[] = $baza['zapraszajacy'];
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
        if($this->zaproszenia == "") 
            return NULL;
        else 
            return $this->zaproszenia;
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
    function czyOnline($id){
        $id = (int) $id;
        $db = new db1();
        $db->przygotuj("SELECT t1.login, t1.UID, t1.wygrane, t1.ostatnio_online FROM gracz t1 LEFT JOIN gra t2 ON t2.graczCzarne = t1.UID OR t2.graczBiale = t1.UID WHERE (t2.graczCzarne IS NULL OR t2.graczBiale IS NULL) AND t1.UID = :id");
        $db->zmienna(":id",$id,"int");
        $db->wykonaj();
        $z = $db->przechwyc();
        while($baza = $z->fetch()){
            if(strtotime($baza['ostatnio_online']) > strtotime(date("Y-m-d H:i:s"))-15) return true;
        }
        $z->closeCursor();
        return false;
    }
    function wygrane($id){
        $db = new db1();
        $db->przygotuj("SELECT wygrane FROM gracz WHERE UID = :id LIMIT 1");
        $db->zmienna(":id",$id,"int");
        $db->wykonaj();
        $z = $db->przechwyc();
        $wygrane = 0;
        while($baza = $z->fetch()){
            $wygrane = $baza['wygrane'];
        }
        $z->closeCursor();
        return $wygrane;
    }
    function getWygrane(){
        return $this->wygrane;
    }
    function getOstGra(){
        return $this->ostGra;
    }
}