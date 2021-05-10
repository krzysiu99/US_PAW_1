<?php
/*                    Projekt Szachy Online                        */
/*  Języki Programowania Dynamicznych Stron Internetowych          */
/*                     Krzysztof Niestrój                          */
/*              krzysztof.niestroj@o365.us.edu.pl                  */
/*                     Framework Laravel                           */
/*                         10.05.2021                              */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\config;
use App\Models\msg1;
use App\Models\user1;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\game;

class poczekalnia extends Controller {
        private $config;
        private $msg;
        private $user;

        function __construct(){
            $this->config = new config();
            $this->msg = new msg1();
            $this->user = new user1();
        }

        function wyloguj(){ //wylogowanie z systemu
            if(session_status() == PHP_SESSION_NONE) session_start();
            $_SESSION['wyloguj'] = true;
            unset($_SESSION['user']);
            header("Location: index.php");
            exit;
        }

        function czyGra(){ //sprawdzanie czy jest aktywna gra dla wybranego użytkownika
            $gry = DB::table('gra')->where('graczBiale', $this->user->getUID())->orWhere('graczCzarne', $this->user->getUID())->get();
            $a = false;
            foreach ($gry as $ee){
                $a = true;
                break;
            }
            if($a) return true;
            else return false;
        }

        function nowaGra($u1,$u2){ //tworzenie nowej gry po sparowaniu
            $a = rand(1,2);
            $uk = "\r\n,11,12,13,14,15,16,17,18,\r\n,1,2,3,4,5,6,7,8,\r\n,,,,,,,,,\r\n,,,,,,,,,\r\n,,,,,,,,,\r\n,,,,,,,,,\r\n,21,22,23,24,25,26,27,28,\r\n,31,32,33,34,35,36,37,38,";
            if($a%2 == 0) {
                $g1 = $u1;
                $g2 = $u2;
            } else {
                $g1 = $u2;
                $g2 = $u1;
            }
            DB::table('gra')->insert(array(
                'GID' => NULL, 
                'tura' => 1,
                'uklad' => $uk,
                'komunikat' => 0,
                'data_rozpoczecia' => date('Y-m-d'),
                'graczBiale' => $g1,
                'graczCzarne' => $g2
            ));

            echo 1;
            exit;
        }

        function akceptuj($us){ //akceptacja zaproszenia do gry
            $akceptowany = (int) $us;
            
            $login = $this->user->getlogin();
            $id = $this->user->getUID();
            $zaproszenia = $this->user->getZaproszenia();

            if($this->user->czyOnline($akceptowany)){ //sprawdzanie czy gracz jest online
                if($this->czyJest($zaproszenia,$akceptowany)) { //sprawdzanie czy wskazany gracz zaprosił obecnego użytkownika
                    DB::table('zaproszenie')->where('zaproszony', $id)->delete();
                    $this->nowaGra($id,$akceptowany);
                }
            }
            exit;
        }


        function odrzuc($us){ //odrzucanie zaproszenia
            $odrzucany = (int) $us;
            
            $login = $this->user->getlogin();
            $id = $this->user->getUID();
            $zaproszenia = $this->user->getZaproszenia();

            if($this->user->czyOnline($odrzucany)){ //sprawdzanie czy wskazany gracz zaprosił obecnego użytkownika
                if($this->czyJest($zaproszenia,$odrzucany)) //czy wskazany gracz zaprosił mnie
                    DB::table('zaproszenie')->where('zaproszony', $id)->where('zapraszajacy', $odrzucany)->delete();
            }
            exit;
        }

        function sprawdz(){ //dynamiczne sprawdzanie listy online i zaproszeń przez ajax
            DB::table('gracz')->where('login', $this->user->getlogin())->update(array(
                'ostatnio_online'=>date('Y-m-d H:i:s')
            ));
            $zm = $this->listaOnline();
            for($i = 0; isset($zm[$i]);$i++){
                $zm[$i] = implode(" | ",$zm[$i]);
            }
            echo implode(" || ",$zm);
            $this->msg = $this->msg->display();
            if($this->msg != NULL) echo $this->msg;
        }

        function zapros($us){ //zaproszenie do gry
            $zaproszony = (int) $us;
            
            $login = $this->user->getlogin();
            $id = $this->user->getUID();

            if($this->user->czyOnline($zaproszony)){ //sprawdzanie czy uzytkownik jest online
                $zaproszenia = DB::table('zaproszenie')->where('zaproszony', $zaproszony)->get();
                $lista = array();
                foreach($zaproszenia as $e){
                    $lista[] = $e->zapraszajacy;
                }

                if(!$this->czyJest($lista,$id)) { //sprawdzanie czy obecny gracz już zaprosił tamtego gracza
                    if($this->czyJest($this->user->getZaproszenia(),$zaproszony)) { //przy wzajemnym jednoczesnym zaproszeniu automatyczna akceptacja
                        DB::table('zaproszenie')->where('zaproszony', $id)->where('zapraszajacy', $zaproszony)->delete();
                        $this->nowaGra($id,$zaproszony);
                        exit;
                    }
                    DB::table('zaproszenie')->insert(array(
                        'ZID' => NULL, 
                        'zapraszajacy' => $id,
                        'zaproszony' => $zaproszony
                    ));
                }
            }
        }

        function czyJest($arr,$id){ //sprawdzanie czy w liście zaproszeń obecnego użytkownika jest id wskazanego gracza
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

        function listaOnline(){ //lista graczy online oraz zaproszeń
            $gracze = array();
            
            $id = $this->user->getUID();
            $zapr = $this->user->getZaproszenia();

            
            $lista = DB::table("gracz as t1")->leftJoin("gra as t2", function ($join) {
                $join->on('t2.graczCzarne','t1.UID')
                ->orOn('t2.graczBiale','t1.UID')
                ->where('t2.graczCzarne', NULL)
                ->orWhere('t2.graczBiale', NULL);
            })->select(DB::raw('t1.login as login, t1.UID as UID, t1.wygrane as wygrane, t1.ostatnio_online as ostatnio_online'))->get();

            foreach($lista as $e){
                if($this->user->czyOnline($e->UID) && $e->UID != $this->user->getUID()){
                    $z = DB::table('zaproszenie')->where('zaproszony', $e->UID)->get();
                    $a = false;
                    foreach($z as $ee){
                        if($ee->zapraszajacy == $id) {
                            $a = true;
                            $gracze[] = array($e->login,$e->wygrane,1,$e->UID);
                            break;
                        }
                    }
                    if(!$a){
                        if($this->czyJest($zapr,$e->UID))
                            $gracze[] = array($e->login,$e->wygrane,2,$e->UID);
                        else 
                            $gracze[] = array($e->login,$e->wygrane,0,$e->UID);
                    }
                }
            }

            return $gracze;

        }


        function wyswietl(){ //wyświetlanie widoku
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

        function wykonaj(Request $request){ //punkt wejścia do klasy dla metod GET i POST
            if($this->czyGra()) { //sprawdzanie czy gracze mają już stworozną grę
                $game = new game();
                return $game->wykonaj($request); //jeśli tak to wejście do gry
            } else {
                if(!empty($request->input("sprawdz"))) return $this->sprawdz(); //sprawdzanie dynamiczne listy ajax
                if(!empty($request->input("wyloguj"))) return $this->wyloguj(); //wylogowanie z systemu
                if(!empty($request->input("zapros"))) return $this->zapros($request->input("zapros")); //zapraszanie użytkownika do gry
                if(!empty($request->input("odrzuc"))) return $this->odrzuc($request->input("odrzuc")); //odrzucanie zaproszeń
                if(!empty($request->input("akceptuj"))) return $this->akceptuj($request->input("akceptuj")); //akceptacja zaproszeń

                return $this->wyswietl(); //widok strony  
            }
        }
    }