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
            $this->db->przygotuj("INSERT INTO gracz (`UID`, `login`, `haslo`, `ostatnia_gra`, `ostatnio_online`, `wygrane`) VALUES (NULL,:lo,:ha,:da,:daca,0)");
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
                return $this->wyswietl();
            }
        }
    }

    function sprawdzKonta(){
        $min = strtotime(date("Y-m-d H:i:s"))-(7*24*3600); // 7 dni

        $this->db->przygotuj("SELECT UID, ostatnia_gra FROM gracz");
        $this->db->wykonaj();
        $z = $this->db->przechwyc();
        while($baza = $z->fetch()){
            if(strtotime($baza['ostatnia_gra'].date("H:i:s")) < $min){
                $this->db->przygotuj("SELECT GID FROM gra WHERE graczBiale = :id OR graczCzarne = :id");
                $this->db->zmienna(':id',$baza['UID'],"int");
                $this->db->wykonaj();
                $z2 = $this->db->przechwyc();
                while($baza2 = $z2->fetch()){
                    $this->db->przygotuj("DELETE FROM historia WHERE gid = :gid");
                    $this->db->zmienna(':gid',$baza2['GID'],"int");
                    $this->db->wykonaj();
                }
                $z2->closeCursor();

                $this->db->przygotuj("DELETE FROM gra WHERE graczBiale = :id OR graczCzarne = :id");
                $this->db->zmienna(':id',$baza['UID'],"int");
                $this->db->wykonaj();

                $this->db->przygotuj("DELETE FROM gracz WHERE UID = :id LIMIT 1");
                $this->db->zmienna(':id',$baza['UID'],"int");
                $this->db->wykonaj();
            }
        }
        $z->closeCursor();
    }
    function sprawdzBaze(){
        $this->db->przygotuj("SELECT * FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_NAME = 'gracz'");
        $this->db->wykonaj();
        $z = $this->db->przechwyc();
        $ist = false;
        while($baza = $z->fetch()){
            $ist = true;
            break;
        }
        $z->closeCursor();
        if(!$ist){
            $this->db->przygotuj("CREATE TABLE `gra` (
                `GID` int(11) NOT NULL,
                `tura` int(1) NOT NULL,
                `uklad` text COLLATE utf8_polish_ci NOT NULL,
                `komunikat` int(11) NOT NULL,
                `data_rozpoczecia` date NOT NULL,
                `graczBiale` int(11) NOT NULL,
                `graczCzarne` int(11) NOT NULL
              ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;");
            $this->db->wykonaj();
            $this->db->przygotuj("CREATE TABLE `gracz` (
                `UID` int(11) NOT NULL,
                `login` text COLLATE utf8_polish_ci NOT NULL,
                `haslo` text COLLATE utf8_polish_ci NOT NULL,
                `ostatnia_gra` date NOT NULL,
                `ostatnio_online` datetime NOT NULL,
                `wygrane` int(11) NOT NULL DEFAULT 0
              ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;");
            $this->db->wykonaj();
            $this->db->przygotuj("CREATE TABLE `historia` (
                `RID` int(11) NOT NULL,
                `gra` int(11) NOT NULL,
                `figura` int(11) NOT NULL,
                `zrodlo` varchar(5) COLLATE utf8_polish_ci NOT NULL,
                `cel` varchar(5) COLLATE utf8_polish_ci NOT NULL,
                `czas` datetime NOT NULL
              ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;");
            $this->db->wykonaj();
            $this->db->przygotuj("CREATE TABLE `zaproszenie` (
                `ZID` int(11) NOT NULL,
                `zapraszajacy` int(11) NOT NULL,
                `zaproszony` int(11) NOT NULL
              ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;");
            $this->db->wykonaj();
            $this->db->przygotuj("ALTER TABLE `gra`
                ADD PRIMARY KEY (`GID`),
                ADD KEY `p1` (`graczBiale`),
                ADD KEY `p2` (`graczCzarne`);");
            $this->db->wykonaj();
            $this->db->przygotuj("ALTER TABLE `gra`
                MODIFY `GID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0;
                COMMIT;");
            $this->db->wykonaj();
            $this->db->przygotuj("ALTER TABLE `gracz`
                ADD PRIMARY KEY (`UID`);");
            $this->db->wykonaj();
            $this->db->przygotuj("ALTER TABLE `gracz`
                MODIFY `UID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0;
                COMMIT;");
            $this->db->wykonaj();
            $this->db->przygotuj("ALTER TABLE `historia`
                ADD PRIMARY KEY (`RID`),
                ADD KEY `p3` (`gra`);");
            $this->db->wykonaj();
            $this->db->przygotuj("ALTER TABLE `historia`
                MODIFY `RID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0;
                COMMIT;");
            $this->db->wykonaj();
            $this->db->przygotuj("ALTER TABLE `zaproszenie`
                ADD PRIMARY KEY (`ZID`),
                ADD KEY `z1` (`zapraszajacy`),
                ADD KEY `z2` (`zaproszony`);");
            $this->db->wykonaj();
            $this->db->przygotuj("ALTER TABLE `zaproszenie`
                MODIFY `ZID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0;
                COMMIT;");
            $this->db->wykonaj();
            $this->db->przygotuj("ALTER TABLE `gra`
                ADD CONSTRAINT `p1` FOREIGN KEY (`graczBiale`) REFERENCES `gracz` (`UID`) ON DELETE CASCADE ON UPDATE CASCADE,
                ADD CONSTRAINT `p2` FOREIGN KEY (`graczCzarne`) REFERENCES `gracz` (`UID`) ON DELETE CASCADE ON UPDATE CASCADE;");
            $this->db->wykonaj();
            $this->db->przygotuj("ALTER TABLE `historia`
                ADD CONSTRAINT `p3` FOREIGN KEY (`gra`) REFERENCES `gra` (`GID`) ON DELETE CASCADE ON UPDATE CASCADE;");
            $this->db->wykonaj();
            $this->db->przygotuj("ALTER TABLE `zaproszenie`
                ADD CONSTRAINT `z1` FOREIGN KEY (`zapraszajacy`) REFERENCES `gracz` (`UID`) ON DELETE CASCADE ON UPDATE CASCADE,
                ADD CONSTRAINT `z2` FOREIGN KEY (`zaproszony`) REFERENCES `gracz` (`UID`) ON DELETE CASCADE ON UPDATE CASCADE;
                COMMIT;");
            $this->db->wykonaj();
        }
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
        $this->sprawdzBaze();
        $this->sprawdzKonta();
        return $this->wyswietl();
    }
}