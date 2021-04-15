<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\db1;
use App\Models\config;
use App\Models\msg1;

class stronaStartowa extends Controller {
    private $db;
    private $config;
    private $msg;

    function __construct(){ //<==================== do zmiany !!!
        $this->db = new Db1();
        $this->config = new config();
        $this->msg = new msg1();
    }

    function logowanie(Request $request){

        $login = htmlspecialchars(addslashes($request->input('login')));
        $haslo = htmlspecialchars(addslashes($request->input('haslo')));

        //czy nie puste
        if(empty($login) || empty($haslo)) {
            $this->msg->add("uzupełnij oba pola");
            return $this->wyswietl();
            exit;
        }

        //walidacja
        $blad = false;
        if(!(strlen($login)>2 && strlen($login)<16)) $blad = true;
        if(!(strlen($haslo)>2 && strlen($haslo)<31)) $blad = true;
        if(!preg_match("/[A-Za-z0-9]+/",$login)) $blad = true;

        if($blad){
            $this->msg->add("niepoprawne znaki lub długość");
            return $this->wyswietl();
            exit;
        }

        if(!empty($request->input('zaloguj'))) return $this->loguj($login, $haslo);
        else return $this->rejestruj($login, $haslo);

    }

    function loguj($login, $haslo){
        $this->db->przygotuj("SELECT UID, haslo FROM gracz WHERE login = :lo LIMIT 1");
        $this->db->zmienna(':lo',$login,"str");
        $this->db->wykonaj();
        $z = $this->db->przechwyc();
        while($baza = $z->fetch()){
            $zalogowano = "";
            if(md5($haslo) == $baza['haslo']) $zalogowano = $baza['UID'];
        }
        $z->closeCursor();

        if(!isset($zalogowano)){
            $this->msg->add("brak wskazanego użytkownika");
            return $this->wyswietl();
            exit;
        }
        if(empty($zalogowano)){
            $this->msg->add("błędne hasło");
            return $this->wyswietl();
            exit;
        } else {
            if(session_status() == PHP_SESSION_NONE) session_start();
            $this->db->przygotuj("UPDATE gracz SET ostatnio_online = :daca WHERE login = :lo LIMIT 1");
            $this->db->zmienna(':daca',date('Y-m-d H:i:s'),"str");
            $this->db->zmienna(':lo',$login,"str");
            $this->db->wykonaj();
            $_SESSION['user'] = $zalogowano;
            header("location: index.php");
            exit;
        }
    }

    function rejestruj($login, $haslo){
        $this->db->przygotuj("SELECT login FROM gracz WHERE login = :lo LIMIT 1");
        $this->db->zmienna(':lo',$login,"str");
        $this->db->wykonaj();
        $zajety = false;
        $z = $this->db->przechwyc();
        while($baza = $z->fetch()){
            $zajety = true;
        }
        $z->closeCursor();

        if($zajety){
            $this->msg->add("ten login jest zajęty");
            return $this->wyswietl();
            exit;
        } else {
            $this->db->przygotuj("INSERT INTO gracz VALUES (NULL,:lo,:ha,'',:da,:daca,0)");
            $this->db->zmienna(':lo',$login,"str");
            $this->db->zmienna(':ha',md5($haslo),"str");
            $this->db->zmienna(':da',date('Y-m-d'),"str");
            $this->db->zmienna(':daca',date('Y-m-d H:i:s'),"str");
            $this->db->wykonaj();
            $UID = $this->db->ostatnieId();

            if(isset($UID) && !empty($UID)){
                if(session_status() == PHP_SESSION_NONE) session_start();
                $_SESSION['user'] = $UID;
                header("Location: index.php");
                exit;
            } else {
                $this->msg->add("Błąd tworzenia konta");
            }
        }
    }

    function sprawdzKonta(){
        $min = strtotime(date("Y-m-d H:i:s"))-(7*24*3600);

        $this->db->przygotuj("SELECT UID, ostatnia_gra FROM gracz");
        $this->db->wykonaj();
        $z = $this->db->przechwyc();
        while($baza = $z->fetch()){
            if(strtotime($baza['ostatnia_gra'].date("H:i:s")) < $min){
                $this->db->przygotuj("DELETE FROM gracz WHERE UID = :id LIMIT 1");
                $this->db->zmienna(':id',$baza['UID'],"int");
                $this->db->wykonaj();
            }
        }
        $z->closeCursor();

    }

    function wyswietl(){

        if(session_status() == PHP_SESSION_NONE) session_start();
        if(isset($_SESSION['wyloguj'])) {
            $wylogowano = true;
            session_destroy();
        } else $wylogowano = false;

        
        return view('stronaStartowa')
            ->with('wyloguj', $wylogowano)
            ->with('folder',$this->config->folder)
            ->with('msg', $this->msg);
    }

    function wykonaj(){
        //if(!empty(getFromPost('login')) && !empty(getFromPost('haslo'))) $this->logowanie();
        $this->sprawdzKonta();
        return $this->wyswietl();
    }
}