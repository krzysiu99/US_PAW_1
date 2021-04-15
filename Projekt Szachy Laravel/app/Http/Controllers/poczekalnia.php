<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\db1;
use App\Models\config;
use App\Models\msg1;
use App\Models\user1;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\game;

class poczekalnia extends Controller {
        private $listaZaproszen = array();
        private $db;
        private $config;
        private $msg;
        private $user;

        function __construct(){ //<==================== do zmiany !!!
            $this->db = new Db1();
            $this->config = new config();
            $this->msg = new msg1();
            $this->user = new user1();
        }

        function wyloguj(){
            if(session_status() == PHP_SESSION_NONE) session_start();
            $_SESSION['wyloguj'] = true;
            unset($_SESSION['user']);
            header("Location: index.php");
            exit;
        }

        function czyGra(){
            
            $id = $this->user->getUID();
            
            $this->db->przygotuj("SELECT t1.GID FROM gra t1 LEFT JOIN para t2 ON t2.PID = t1.para WHERE (t2.czarne = :id OR t2.biale = :id) LIMIT 1");
            $this->db->zmienna(":id",$id,"int");
            $this->db->wykonaj();
            $z = $this->db->przechwyc();
            $a = false;
            while($baza = $z->fetch()){
                $a = true;
            }
            $z->closeCursor();
            if($a) return true;
            else return false;
        }

        function nowaGra($u1,$u2){
            
            $a = rand(1,2);
            $this->db->przygotuj("INSERT INTO para VALUES (NULL, :g1, :g2)");
            if($a%2 == 0) {
                $this->db->zmienna(":g1",$u1,"int");
                $this->db->zmienna(":g2",$u2,"int");
            } else {
                $this->db->zmienna(":g1",$u2,"int");
                $this->db->zmienna(":g2",$u1,"int");
            }
            $this->db->wykonaj();
            $PID = $this->db->ostatnieId();

            $uk = "\r\n,11,12,13,14,15,16,17,18,\r\n,1,2,3,4,5,6,7,8,\r\n,,,,,,,,,\r\n,,,,,,,,,\r\n,,,,,,,,,\r\n,,,,,,,,,\r\n,21,22,23,24,25,26,27,28,\r\n,31,32,33,34,35,36,37,38,";

            $this->db->przygotuj("INSERT INTO gra VALUES (NULL, 1, :uk, :id, '')");
            $this->db->zmienna(":uk",$uk,"str");
            $this->db->zmienna(":id",$PID,"int");
            $this->db->wykonaj();


            echo 1;
            exit;
        }

        function akceptuj($us){
            $nick = addslashes(htmlspecialchars($us));
            
            $login = $this->user->getlogin();
            $id = $this->user->getUID();
            $zaproszenia = $this->user->getZaproszenia();

            $this->db->przygotuj("SELECT UID FROM gracz WHERE login = :ni LIMIT 1");
            $this->db->zmienna(":ni",$nick,"str");
            $this->db->wykonaj();
            $z = $this->db->przechwyc();

            while($baza = $z->fetch()){
                if($this->czyJest($zaproszenia,$baza['UID'])) {
                    $this->db->przygotuj("UPDATE gracz SET zaproszenia = '' WHERE UID = :id LIMIT 1");
                    $this->db->zmienna(":id",$id,"int");
                    $this->db->wykonaj();

                    $this->nowaGra($id,$baza['UID']);
                    exit;
                }
            }
            $z->closeCursor();
            exit;
        }


        function odrzuc($us){
            $nick = addslashes($us);
            
            $login = $this->user->getlogin();
            $id = $this->user->getUID();
            $zaproszenia = $this->user->getZaproszenia();

            $this->db->przygotuj("SELECT UID FROM gracz WHERE login = :ni LIMIT 1");
            $this->db->zmienna(":ni",$nick,"str");
            $this->db->wykonaj();
            $z = $this->db->przechwyc();
   
            while($baza = $z->fetch()){
                $N = "";
                for($i=0;isset($zaproszenia[$i]);$i++){
                    if($zaproszenia[$i] != $baza['UID']) $N .= ".".$zaproszenia[$i];
                }
                if($N != "") $N .= ".";

                $this->db->przygotuj("UPDATE gracz SET zaproszenia = :za WHERE UID = :id LIMIT 1");
                $this->db->zmienna(":za",$N,"str");
                $this->db->zmienna(":id",$id,"int");
                $this->db->wykonaj();
            }
            $z->closeCursor();
            exit;
        }

        function sprawdz(){
            
            $login = $this->user->getlogin();
            $this->db->przygotuj("UPDATE gracz SET ostatnio_online = :daca WHERE login = :lo LIMIT 1");
            $this->db->zmienna(':daca',date('Y-m-d H:i:s'),"str");
            $this->db->zmienna(':lo',$login,"str");
            $this->db->wykonaj();

            $zm = $this->listaOnline();
            for($i = 0; isset($zm[$i]);$i++){
                $zm[$i] = implode(" | ",$zm[$i]);
            }
            echo implode(" || ",$zm);
            
            $this->msg = $this->msg->display();
            if($this->msg != NULL) echo $this->msg;

            //return $this->wyswietl();
        }

        function zapros($us){
            $nick = addslashes(htmlspecialchars($us));
            
            $login = $this->user->getlogin();
            $id = $this->user->getUID();

            $this->db->przygotuj("SELECT UID, zaproszenia FROM gracz WHERE login = :ni AND login != :lo LIMIT 1");
            $this->db->zmienna(":lo",$login,"str");
            $this->db->zmienna(":ni",$nick,"str");
            $this->db->wykonaj();
            $z = $this->db->przechwyc();

            while($baza = $z->fetch()){
                if($this->czyJest($this->user->getZaproszenia(),$baza['UID'])) {
                    $this->db->przygotuj("UPDATE gracz SET zaproszenia = '' WHERE UID = :id LIMIT 1");
                    $this->db->zmienna(":id",$id,"int");
                    $this->db->wykonaj();

                    $this->nowaGra($id,$baza['UID']);
                    exit;
                } else { //zapros
                    if($baza['zaproszenia'] == "") $N = "."; else $N = $baza['zaproszenia'];
                    $this->db->przygotuj("UPDATE gracz SET zaproszenia = :za WHERE UID = :id LIMIT 1");
                    $this->db->zmienna(":za",$N.$id.".","str");
                    $this->db->zmienna(":id",$baza['UID'],"int");
                    $this->db->wykonaj();
                    exit;
                }
            }
            $z->closeCursor();
        }

        function czyJest($arr,$id){
            if($arr != ""){
                foreach($arr as $e){
                    if($e == $id){
                        return true;
                        break;
                    }
                }
            }
            return false;
        }

        function listaOnline(){
            $gracze = array();
            
            $login = $this->user->getlogin();
            $id = $this->user->getUID();
            $zapr = $this->user->getZaproszenia();

            
            $this->db->przygotuj("SELECT t1.login, t1.UID, t1.wygrane , t1.ostatnio_online, t1.zaproszenia FROM gracz t1 LEFT JOIN para t2 ON t2.czarne = t1.UID OR t2.biale = t1.UID WHERE (t2.czarne IS NULL OR t2.biale IS NULL) AND t1.login != :lo");
            $this->db->zmienna(":lo",$login,"str");
            $this->db->wykonaj();
            $z = $this->db->przechwyc();

            while($baza = $z->fetch()){
                if(strtotime($baza['ostatnio_online']) > strtotime(date("Y-m-d H:i:s"))-15){
                    if($baza['zaproszenia'] == "" || substr_count($baza['zaproszenia'], ".".$id.'.')==0){
                        if($this->czyJest($zapr,$baza['UID'])) {
                            $b = 2;
                            $this->listaZaproszen[] = array($baza['login'],$baza['wygrane']);
                        } else $b = 0;
                    } else $b = 1;
                    $gracze[] = array($baza['login'],$baza['wygrane'],$b);
                }
            }
            $z->closeCursor();

            return $gracze;

        }

        function listaZaproszen(){
            return $this->listaZaproszen;
        }

        function wyswietl(){
            $pozostalo = (7-((strtotime(date("Y-m-d H:i:s")) - strtotime($this->user->getOstGra().date("H:i:s")))/3600/24));

            $gracze = $this->listaOnline();
            $zaproszenia = $this->listaZaproszen();

            $ost = explode("-",$this->user->getOstGra());

            if(!isset($ost[2])){
                if(session_status() == PHP_SESSION_NONE) session_start();
                $_SESSION['wyloguj'] = true;
                unset($_SESSION['user']);
                header("Location: index.php");
                exit;
            }

            return view('poczekalnia')
                ->with('ostGra', $ost[2].".".$ost[1].".".$ost[0])
                ->with('pozostalo', $pozostalo)
                ->with('gracze', $gracze)
                ->with('zaproszenia', $zaproszenia)
                ->with('wygrane', $this->user->getWygrane())
                ->with('msg', $this->msg->display())
                ->with('user', $this->user)
                ->with('folder', $this->config->folder);
        }

        function wykonaj(Request $request){
            if($this->czyGra()) {
                $game = new game();
                return $game->wykonaj($request);
            } else {
                if(!empty($request->input("sprawdz"))) return $this->sprawdz();
                if(!empty($request->input("wyloguj"))) return $this->wyloguj();
                if(!empty($request->input("zapros"))) return $this->zapros($request->input("zapros"));
                if(!empty($request->input("odrzuc"))) return $this->odrzuc($request->input("odrzuc"));
                if(!empty($request->input("akceptuj"))) return $this->akceptuj($request->input("akceptuj"));

                return $this->wyswietl();   
            }
        }
    }