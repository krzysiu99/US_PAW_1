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
            
            $this->db->przygotuj("SELECT GID FROM gra WHERE graczBiale = :id OR graczCzarne = :id LIMIT 1");
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
            $uk = "\r\n,11,12,13,14,15,16,17,18,\r\n,1,2,3,4,5,6,7,8,\r\n,,,,,,,,,\r\n,,,,,,,,,\r\n,,,,,,,,,\r\n,,,,,,,,,\r\n,21,22,23,24,25,26,27,28,\r\n,31,32,33,34,35,36,37,38,";

            $this->db->przygotuj("INSERT INTO gra VALUES (NULL, 1, :uk, '', :data, :g1, :g2)");
            if($a%2 == 0) {
                $this->db->zmienna(":g1",$u1,"int");
                $this->db->zmienna(":g2",$u2,"int");
            } else {
                $this->db->zmienna(":g1",$u2,"int");
                $this->db->zmienna(":g2",$u1,"int");
            }
            $this->db->zmienna(":uk",$uk,"str");
            $this->db->zmienna(":data",date('Y-m-d'),"str");
            $this->db->wykonaj();


            echo 1;
            exit;
        }

        function akceptuj($us){
            $akceptowany = (int) $us;
            
            $login = $this->user->getlogin();
            $id = $this->user->getUID();
            $zaproszenia = $this->user->getZaproszenia();

            if($this->user->czyOnline($akceptowany)){
                if($this->czyJest($zaproszenia,$akceptowany)) { //czy wskazany gracz zaprosił mnie
                    $this->db->przygotuj("DELETE FROM zaproszenie WHERE zaproszony = :ja AND zapraszajacy = :on");
                    $this->db->zmienna(":on",$akceptowany,"int");
                    $this->db->zmienna(":ja",$id,"int");
                    $this->db->wykonaj();

                    $this->nowaGra($id,$akceptowany);
                }
            }
            exit;
        }


        function odrzuc($us){
            $odrzucany = (int) $us;
            
            $login = $this->user->getlogin();
            $id = $this->user->getUID();
            $zaproszenia = $this->user->getZaproszenia();

            if($this->user->czyOnline($odrzucany)){
                if($this->czyJest($zaproszenia,$odrzucany)) { //czy wskazany gracz zaprosił mnie
                    $this->db->przygotuj("DELETE FROM zaproszenie WHERE zaproszony = :ja AND zapraszajacy = :on");
                    $this->db->zmienna(":on",$odrzucany,"int");
                    $this->db->zmienna(":ja",$id,"int");
                    $this->db->wykonaj();
                }
            }
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
        }

        function zapros($us){
            $zaproszony = (int) $us;
            
            $login = $this->user->getlogin();
            $id = $this->user->getUID();

            if($this->user->czyOnline($zaproszony)){
                $this->db->przygotuj("SELECT zaproszajacy FROM zaproszenie WHERE zaproszony = :zaproszony");
                $this->db->zmienna(":zaproszony",$zaproszony,"int");
                $this->db->wykonaj();
                $z = $this->db->przechwyc();

                $lista = array();
                while($baza = $z->fetch()){
                    $lista[] = $baza['zaproszajacy'];
                }
                $z->closeCursor();

                if(!$this->czyJest($lista,$id)) { //czy już go zaprosiłem
                    if($this->czyJest($this->user->getZaproszenia(),$zaproszony)) { //przy podwójnym zaproszneiu
                        $this->db->przygotuj("DELETE FROM zaproszenie WHERE zaproszony = :ja AND zapraszajacy = :on");
                        $this->db->zmienna(":on",$akceptowany,"int");
                        $this->db->zmienna(":ja",$id,"int");
                        $this->db->wykonaj();

                        $this->nowaGra($id,$zaproszony);
                        exit;
                    }
                    $this->db->przygotuj("INSERT INTO zaproszenie VALUES (NULL, :zapraszajacy, :zaproszony)");
                    $this->db->zmienna(":zapraszajacy",$id,"int");
                    $this->db->zmienna(":zaproszony",$zaproszony,"int");
                    $this->db->wykonaj();
                }
            }
        }

        function czyJest($arr,$id){ //czy w tablicy zaproszeń jest id gracza z parametru 2
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

            
            $this->db->przygotuj("SELECT t1.login, t1.UID, t1.wygrane, t1.ostatnio_online FROM gracz t1 LEFT JOIN gra t2 ON t2.graczCzarne = t1.UID OR t2.graczBiale = t1.UID WHERE (t2.graczCzarne IS NULL OR t2.graczBiale IS NULL) AND t1.login != :lo");
            $this->db->zmienna(":lo",$login,"str");
            $this->db->wykonaj();
            $z = $this->db->przechwyc();

            while($baza = $z->fetch()){
                if($this->user->czyOnline($baza['UID'])){
                    $this->db->przygotuj("SELECT zapraszajacy FROM zaproszenie WHERE zaproszony = :id");
                    $this->db->zmienna(":id",$baza['UID'],"int");
                    $this->db->wykonaj();
                    $z1 = $this->db->przechwyc();
                    $a = false;
                    while($baza1 = $z1->fetch()){
                        if($baza1['zapraszajacy'] == $id) {
                            $a = true;
                            $gracze[] = array($baza['login'],$baza['wygrane'],1,$baza['UID']);
                            break;
                        }
                    }
                    $z1->closeCursor();
                    if(!$a){
                        if($this->czyJest($zapr,$baza['UID']))
                            $gracze[] = array($baza['login'],$baza['wygrane'],2,$baza['UID']);
                        else 
                            $gracze[] = array($baza['login'],$baza['wygrane'],0,$baza['UID']);
                    }
                }
            }
            $z->closeCursor();

            return $gracze;

        }


        function wyswietl(){
            $pozostalo = (7-((strtotime(date("Y-m-d H:i:s")) - strtotime($this->user->getOstGra().date("H:i:s")))/3600/24));

            $gracze = $this->listaOnline();

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
                ->with('zaproszenia', $this->user->getZaproszenia())
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