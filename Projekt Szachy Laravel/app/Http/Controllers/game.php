<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\db1;
use App\Models\config;
use App\Models\msg1;
use App\Models\user1;

class game extends Controller {
        private $uklad;
        private $gracz;
        private $litery = array(NULL,"A","B","C","D","E","F","G","H");
        private $tura;
        private $graczBiale;
        private $graczCzarne;
        private $komunikat;
        private $gid;

        private $db;
        private $config;
        private $msg;
        private $user;

        function __construct(){
            $this->db = new Db1();
            $this->config = new config();
            $this->msg = new msg1();
            $this->user = new user1();

            $this->db->przygotuj("SELECT GID, graczCzarne, graczBiale FROM gra WHERE graczBiale = :id OR graczCzarne = :id LIMIT 1");
            $this->db->zmienna(":id",$this->user->getUID(),"int");
            $this->db->wykonaj();
            $z = $this->db->przechwyc();
            while($baza = $z->fetch()){
                $this->gid = $baza['GID'];
                if($baza['graczCzarne'] == $this->user->getUID()) {
                    $this->gracz = 2;
                    $this->graczCzarne = $this->user->getLogin();
                    $this->graczBiale = $this->user->nick($baza['graczBiale']);
                }
                else {
                    $this->gracz = 1;
                    $this->graczBiale = $this->user->getLogin();
                    $this->graczCzarne = $this->user->nick($baza['graczCzarne']);
                }
            }
            $z->closeCursor();
        }

        function pokazFigure($linia,$kolumna){
            $figura = $this->uklad[$linia][$kolumna];
            if(($figura < 20 && $this->gracz == 2) || ($figura>20 && $this->gracz == 1)) $kl = "figuraMoja"; else $kl = "figuraWroga";
            if($figura != NULL)
                $fig = "<img src='".$this->config->folder."/images"."/".$figura.".png' alt='figura' class='$kl' id='figura-".$figura."'>";
            else
                $fig = "";

            return $fig;
        }

        function pokazFigure2($linia,$kolumna){
            $figura = $this->uklad[$linia][$kolumna];
            if(($figura < 20 && $this->gracz == 2) || ($figura>20 && $this->gracz == 1)) $kl = "figuraMoja"; else $kl = "figuraWroga";
            if($figura != NULL && $figura != "")
                $fig = $figura.",".$kl;
            else
                $fig = "";

            return $fig;
        }

        function wyloguj(){
            if(session_status() == PHP_SESSION_NONE) session_start();
            $_SESSION['wyloguj'] = true;
            unset($_SESSION['user']);
            header("Location: index.php");
            exit;
        }

        function koniecGry($wygral){
            $this->db->przygotuj("SELECT GID, tura, graczCzarne, graczBiale FROM gra WHERE graczBiale = :id OR graczCzarne = :id LIMIT 1");
            $this->db->zmienna(":id",$this->user->getUID(),"int");
            $this->db->wykonaj();
            $z = $this->db->przechwyc();
            while($baza = $z->fetch()){
                $GID = $baza['GID'];
                $czarne = $baza['graczCzarne'];
                $biale = $baza['graczBiale'];
            }
            $z->closeCursor();

            $this->db->przygotuj("DELETE FROM gra WHERE GID = :gid LIMIT 1");
            $this->db->zmienna(":gid",$GID,"int");
            $this->db->wykonaj();

            $this->db->przygotuj("DELETE FROM historia WHERE gra = :gid");
            $this->db->zmienna(":gid",$GID,"int");
            $this->db->wykonaj();


            $this->db->przygotuj("UPDATE gracz SET wygrane = wygrane + 1 WHERE login = :lo LIMIT 1");
            $this->db->zmienna(":lo",$wygral,"str");
            $this->db->wykonaj();
            echo "Niestroj2021";
            exit;
        }

        function pobierzUklad(){
            $this->db->przygotuj("SELECT uklad, tura, komunikat FROM gra WHERE graczBiale = :id OR graczCzarne = :id LIMIT 1");
            $this->db->zmienna(":id",$this->user->getUID(),"int");
            $this->db->wykonaj();
            $z = $this->db->przechwyc();
            while($baza = $z->fetch()){
                $uklad = $baza['uklad'];
                $this->tura = $baza['tura'];
                $this->komunikat = $baza['komunikat'];
            }
            $z->closeCursor();
            
            $bi = false;
            $cz = false;
            if(substr_count($uklad,"15")) $cz = true;
            if(substr_count($uklad,"35")) $bi = true;

            $this->uklad = explode("\r\n",$uklad);
            for($i=1;isset($this->uklad[$i]);$i++){
                $this->uklad[$i] = explode(",",$this->uklad[$i]);
            }

            if(!$bi) $this->koniecGry($this->graczCzarne);
            else if(!$cz) $this->koniecGry($this->graczBiale);
        }

        function zwrocUklad(){
            $r = "";
            for($i=0;$i<=8;$i++){
                for($j=0;$j<=8;$j++){
                    if(isset($this->uklad[$i][$j])) 
                        $r .= $this->pokazFigure2($i,$j).".";
                    else
                        $r .= ".";
                }
                $r .= "|";
            }

            $historia = $this->getHistoria();
            $h = "";
            foreach($historia as $e){
                if($h != "") $h .= "**";
                $h .= implode("*",$e);
            }

            if($this->tura == $this->gracz) 
                echo $r." ||| 1 ||| ".$this->komunikat." ||| ".$h;
            else
                echo $r." ||| 0 ||| ".$this->komunikat." ||| ".$h; 
        }

        function czyWymiana($uklad){
            if($this->tura == $this->gracz){
                for($i=1;$i<9;$i++){
                    if(isset($uklad[1][$i]) && $uklad[1][$i] != "" && ($uklad[1][$i] < 9 || ($uklad[1][$i] < 29 && $uklad[1][$i] > 20))) return $i;
                    else if(isset($uklad[8][$i]) && $uklad[8][$i] != "" && ($uklad[8][$i] < 9 || ($uklad[8][$i] < 29 && $uklad[8][$i] > 20))) return 10+$i;
                }
                return NULL;
            }
        }

        function zapiszRuch($request){
            $figura = addslashes($request->input("figura"));
            $poleCel = explode("-",addslashes($request->input("poleCel")));
            $poleZrodlo = explode("-",addslashes($request->input("poleZrodlo")));
            $poleZrodlo = array($poleZrodlo[1],$poleZrodlo[2]);

            $this->sprawdzRuch($figura,$poleCel,$poleZrodlo);

            $this->uklad[$poleZrodlo[0]][$poleZrodlo[1]] = NULL;
            $this->uklad[$poleCel[0]][$poleCel[1]] = $figura;

            $wymiana = $this->czyWymiana($this->uklad);

            $Nuklad = array();
            for($i=0;isset($this->uklad[$i]);$i++) if($this->uklad[$i] != "") $Nuklad[] = implode(",",$this->uklad[$i]); else $Nuklad[] = "";
            $Nuklad = implode("\r\n",$Nuklad);

            $komunikat = 0;

            $this->db->przygotuj("SELECT gra.GID, gra.tura FROM gra WHERE graczBiale = :id OR graczCzarne = :id LIMIT 1");
            $this->db->zmienna(":id",$this->user->getUID(),"int");
            $this->db->wykonaj();
            $z = $this->db->przechwyc();
            while($baza = $z->fetch()){
                if($wymiana == NULL)
                    $tura = $baza['tura'] == 1 ? 2 : 1;
                else{
                    $tura = $baza['tura'];
                    $komunikat = $wymiana;
                    $this->komunikat = $wymiana;
                }
            }
            $z->closeCursor();

            //zapisz historia
            $this->db->przygotuj("INSERT INTO historia VALUES(NULL, :gid, :figura, :zrodlo, :cel, :czas)");
            $this->db->zmienna(":gid",$this->gid,"int");
            $this->db->zmienna(":figura",$figura,"int");
            $this->db->zmienna(":zrodlo",$poleZrodlo[0]."-".$poleZrodlo[1],"str");
            $this->db->zmienna(":cel",$request->input("poleCel"),"str");
            $this->db->zmienna(":czas",date('Y-m-d H:i:s'),"str");
            $this->db->wykonaj();

            $this->db->przygotuj("UPDATE gra SET uklad = :uklad, tura = :tu, komunikat = :ko WHERE GID = :gid");
            $this->db->zmienna(":gid",$this->gid,"int");
            $this->db->zmienna(":uklad",$Nuklad,"str");
            $this->db->zmienna(":tu",$tura,"int");
            $this->db->zmienna(":ko",$komunikat,"int");
            $this->db->wykonaj();
            $this->tura = $tura;

            $this->zwrocUklad();
        }

        function sprawdzRuch($f,$poleCel,$poleZrodlo){
            $blad = false;

            //sprawdzanie tury
            if($this->gracz != $this->tura) $blad = true;

            //sprawdzanie czy liczby
            if(!(is_numeric($poleCel[0]) && is_numeric($poleCel[1]) && is_numeric($poleZrodlo[0]) && is_numeric($poleZrodlo[1]))) $blad = true;

            $poleCel[0] = intval($poleCel[0]);
            $poleCel[1] = intval($poleCel[1]);
            $poleZrodlo[0] = intval($poleZrodlo[0]);
            $poleZrodlo[1] = intval($poleZrodlo[1]);

            //sprawdzanie istnienia figur
            if(! (($f > 0 && $f < 9) || ($f > 10 && $f < 19) || ($f > 20 && $f < 29) || ($f > 20 && $f < 29) || ($f > 30 && $f < 39))) $blad = true;

            //sprawdzanie pól czy nie po za planszą
            if($poleZrodlo[0] > 8 || $poleZrodlo[0] < 1 || $poleCel[0] > 8 || $poleCel[0] < 1) $blad = true;

            //sprawdzanie czy figura jest w źródle
            if(!isset($this->uklad[$poleZrodlo[0]][$poleZrodlo[1]]) || $this->uklad[$poleZrodlo[0]][$poleZrodlo[1]] != $f) $blad = true;


            //sprawdzanie swoich figur
            if($this->gracz==1 && $f < 21) $blad = true;
            else if($this->gracz==2 && $f > 18) $blad = true;

            //sprawdzanie czy nie bije swojego
            if(!($this->uklad[$poleCel[0]][$poleCel[1]] == "" || (($this->uklad[$poleCel[0]][$poleCel[1]]<20 && $this->gracz==1) || ($this->uklad[$poleCel[0]][$poleCel[1]]>20 && $this->gracz==2)))) $blad = true;

            //wieza
            if($f == 11 || $f == 18 || $f == 31 || $f == 38){
                if($poleCel[0] != $poleZrodlo[0] && $poleCel[1] != $poleZrodlo[1]) $blad = true;
                if($poleCel[0] < $poleZrodlo[0]){
                    for($i=$poleCel[0];$i<$poleZrodlo[0];$i++) 
                        if($this->uklad[$i][$poleCel[1]] != "") 
                            if($poleCel[0] != $i) 
                                $blad = true;
                } else if($poleCel[0] > $poleZrodlo[0]){
                    for($i=$poleCel[0];$i>$poleZrodlo[0];$i--) 
                        if($this->uklad[$i][$poleCel[1]] != "") 
                            if($poleCel[0] != $i) 
                                $blad = true;
                } else if($poleCel[1] < $poleZrodlo[1]){
                    for($i=$poleCel[1];$i<$poleZrodlo[1];$i++) 
                        if($this->uklad[$poleCel[0]][$i] != "") 
                            if($poleCel[1] != $i) 
                                $blad = true;
                } else if($poleCel[1] > $poleZrodlo[1]){
                    for($i=$poleCel[1];$i>$poleZrodlo[1];$i--) 
                        if($this->uklad[$poleCel[0]][$i] != "") 
                            if($poleCel[1] != $i) 
                                $blad = true;
                }
            }
            //krol
            else if($f == 15 || $f == 35){
                if($poleCel[0] > $poleZrodlo[0]+1) $blad = true;
                if($poleCel[0] < $poleZrodlo[0]-1) $blad = true;
                if($poleCel[1] > $poleZrodlo[1]+1) $blad = true;
                if($poleCel[1] < $poleZrodlo[1]-1) $blad = true;
            }
            //kon
            else if($f == 12 || $f == 17 || $f == 32 || $f == 37){
                if(!(($poleCel[0] == $poleZrodlo[0]+1 && $poleCel[1] == $poleZrodlo[1]+2) || ($poleCel[0] == $poleZrodlo[0]+2 && $poleCel[1] == $poleZrodlo[1]+1) || ($poleCel[0] == $poleZrodlo[0]-1 && $poleCel[1] == $poleZrodlo[1]-2) || ($poleCel[0] == $poleZrodlo[0]-2 && $poleCel[1] == $poleZrodlo[1]-1) || ($poleCel[0] == $poleZrodlo[0]+2 && $poleCel[1] == $poleZrodlo[1]-1) || ($poleCel[0] == $poleZrodlo[0]+1 && $poleCel[1] == $poleZrodlo[1]-2) || ($poleCel[0] == $poleZrodlo[0]-1 && $poleCel[1] == $poleZrodlo[1]+2) || ($poleCel[0] == $poleZrodlo[0]-2 && $poleCel[1] == $poleZrodlo[1]+1))) $blad = true;
            }
            //pion
            else if($f < 9 || ($f > 20 && $f < 29)){
                if($f>9){ //białe
                    if(!(($poleZrodlo[0] == 7 && $poleCel[0] == $poleZrodlo[0]-2 && $poleCel[1] == $poleZrodlo[1] && $this->uklad[$poleCel[0]][$poleCel[1]] == "" && $this->uklad[$poleZrodlo[0]-1][$poleCel[1]] == "") || ($poleCel[0] == $poleZrodlo[0]-1 && $poleCel[1] == $poleZrodlo[1] && $this->uklad[$poleCel[0]][$poleCel[1]] == "") || ($poleCel[0] == $poleZrodlo[0]-1 && ($poleCel[1] == $poleZrodlo[1]+1 || $poleCel[1] == $poleZrodlo[1]-1) && $this->uklad[$poleCel[0]][$poleCel[1]] != "" && $this->uklad[$poleCel[0]][$poleCel[1]] < 20))) $blad = true;
                } else {
                    if(!(($poleZrodlo[0] == 2 && $poleCel[0] == $poleZrodlo[0]+2 && $poleCel[1] == $poleZrodlo[1] && $this->uklad[$poleCel[0]][$poleCel[1]] == "" && $this->uklad[$poleZrodlo[0]+1][$poleCel[1]] == "") || ($poleCel[0] == $poleZrodlo[0]+1 && $poleCel[1] == $poleZrodlo[1] && $this->uklad[$poleCel[0]][$poleCel[1]] == "") || ($poleCel[0] == $poleZrodlo[0]+1 && ($poleCel[1] == $poleZrodlo[1]+1 || $poleCel[1] == $poleZrodlo[1]-1) && $this->uklad[$poleCel[0]][$poleCel[1]] != "" && $this->uklad[$poleCel[0]][$poleCel[1]] > 20))) $blad = true;
                }
            }
            //goniec
            else if($f == 13 || $f == 16 || $f == 33 || $f == 36){
                if(!(abs($poleCel[0]-$poleZrodlo[0]) == abs($poleCel[1]-$poleZrodlo[1]))) $blad = true;

                if($poleCel[0]>$poleZrodlo[0]){
                    if($poleCel[1]>$poleZrodlo[1]){
                        for($i=1;$i<($poleCel[0]-$poleZrodlo[0]);$i++) if($this->uklad[$poleZrodlo[0]+$i][$poleZrodlo[1]+$i] != "") $blad = true;
                    } else {
                        for($i=1;$i<($poleCel[0]-$poleZrodlo[0]);$i++) if($this->uklad[$poleZrodlo[0]+$i][$poleZrodlo[1]-$i] != "") $blad = true;
                    }
                } else {
                    if($poleCel[1]<$poleZrodlo[1]){
                        for($i=1;$i<($poleZrodlo[0]-$poleCel[0]);$i++) if($this->uklad[$poleZrodlo[0]-$i][$poleZrodlo[1]-$i] != "") $blad = true;
                    } else {
                        for($i=1;$i<($poleZrodlo[0]-$poleCel[0]);$i++) if($this->uklad[$poleZrodlo[0]-$i][$poleZrodlo[1]+$i] != "") $blad = true;
                    }
                }
                
            }
            //hetman
            else if($f == 14 || $f == 34){
                if($poleCel[0] != $poleZrodlo[0] && $poleCel[1] != $poleZrodlo[1]){
                    if(!(abs($poleCel[0]-$poleZrodlo[0]) == abs($poleCel[1]-$poleZrodlo[1]))) 
                        $blad = true;
                    if($poleCel[0]>$poleZrodlo[0]){
                        if($poleCel[1]>$poleZrodlo[1]){
                            for($i=1;$i<($poleCel[0]-$poleZrodlo[0]);$i++) if($this->uklad[$poleZrodlo[0]+$i][$poleZrodlo[1]+$i] != "") $blad = true;
                        } else {
                            for($i=1;$i<($poleCel[0]-$poleZrodlo[0]);$i++) if($this->uklad[$poleZrodlo[0]+$i][$poleZrodlo[1]-$i] != "") $blad = true;
                        }
                    } else {
                        if($poleCel[1]<$poleZrodlo[1]){
                            for($i=1;$i<($poleZrodlo[0]-$poleCel[0]);$i++) if($this->uklad[$poleZrodlo[0]-$i][$poleZrodlo[1]-$i] != "") $blad = true;
                        } else {
                            for($i=1;$i<($poleZrodlo[0]-$poleCel[0]);$i++) if($this->uklad[$poleZrodlo[0]-$i][$poleZrodlo[1]+$i] != "") $blad = true;
                        }
                    }
                } else {
                    if($poleCel[0] < $poleZrodlo[0]){
                        for($i=$poleCel[0];$i<$poleZrodlo[0];$i++) 
                            if($this->uklad[$i][$poleCel[1]] != "") 
                                if($poleCel[0] != $i) 
                                    $blad = true;
                    } else if($poleCel[0] > $poleZrodlo[0]){
                        for($i=$poleCel[0];$i>$poleZrodlo[0];$i--) 
                            if($this->uklad[$i][$poleCel[1]] != "") 
                                if($poleCel[0] != $i) 
                                    $blad = true;
                    } else if($poleCel[1] < $poleZrodlo[1]){
                        for($i=$poleCel[1];$i<$poleZrodlo[1];$i++) 
                            if($this->uklad[$poleCel[0]][$i] != "") 
                                if($poleCel[1] != $i) 
                                    $blad = true;
                    } else if($poleCel[1] > $poleZrodlo[1]){
                        for($i=$poleCel[1];$i>$poleZrodlo[1];$i--) 
                            if($this->uklad[$poleCel[0]][$i] != "") 
                                if($poleCel[1] != $i) 
                                    $blad = true;
                    }
                }
            } else $blad = true;


            if($blad){
                $this->zwrocUklad();
                exit;
            }
        }

        function poddaj(){
            $this->db->przygotuj("SELECT GID, tura FROM gra WHERE graczBiale = :id OR graczCzarne = :id LIMIT 1");
            $this->db->zmienna(":id",$this->user->getUID(),"int");
            $this->db->wykonaj();
            $z = $this->db->przechwyc();
            while($baza = $z->fetch()){
                $GID = $baza['GID'];
            }
            $z->closeCursor();

            $this->db->przygotuj("DELETE FROM gra WHERE GID = :gid LIMIT 1");
            $this->db->zmienna(":gid",$GID,"int");
            $this->db->wykonaj();

            $this->db->przygotuj("DELETE FROM historia WHERE gra = :gid");
            $this->db->zmienna(":gid",$GID,"int");
            $this->db->wykonaj();

            $this->db->przygotuj("UPDATE gracz SET wygrane = wygrane + 1 WHERE login = :lo LIMIT 1");
            if($this->graczBiale == $this->user->getLogin()) 
                $this->db->zmienna(":lo",$this->graczCzarne,"str");
            else
                $this->db->zmienna(":lo",$this->graczBiale,"str");
            $this->db->wykonaj();
            echo "Niestroj2021";
            exit;
        }
        function wymien($pozycja,$figura){
            $pozycja = addslashes($pozycja);
            $figura = addslashes($figura);
            if($this->czyWymiana($this->uklad)){
                if($pozycja < 10 && $this->gracz == 1){
                    $this->uklad[1][$pozycja] = $figura;
                    $poz = "1-".$pozycja;
                    $this->tura = $this->tura==2 ? 1 : 2;
                    $this->komunikat = 0;
                } else if($pozycja > 10 && $this->gracz == 2){
                    $poz = "8-".($pozycja-10);
                    $this->uklad[8][$pozycja-10] = $figura;
                    $this->tura = $this->tura==2 ? 1 : 2;
                    $this->komunikat = 0;
                }
                /* */ //echo $pozycja.", ".$this->gracz; exit;

                $Nuklad = array();
                for($i=0;isset($this->uklad[$i]);$i++) if($this->uklad[$i] != "") $Nuklad[] = implode(",",$this->uklad[$i]); else $Nuklad[] = "";
                $Nuklad = implode("\r\n",$Nuklad);

                $this->db->przygotuj("UPDATE gra SET uklad = :uklad, tura = :tu, komunikat = :ko WHERE GID = :gid");
                $this->db->zmienna(":gid",$this->gid,"int");
                $this->db->zmienna(":uklad",$Nuklad,"str");
                $this->db->zmienna(":tu",$this->tura,"int");
                $this->db->zmienna(":ko",$this->komunikat,"int");
                $this->db->wykonaj();

                //zapisz historia
                if(isset($poz)){
                    $this->db->przygotuj("INSERT INTO historia VALUES(NULL, :gid, :figura, :zrodlo, :cel, :czas)");
                    $this->db->zmienna(":gid",$this->gid,"int");
                    $this->db->zmienna(":figura",$figura,"int");
                    $this->db->zmienna(":zrodlo","","str");
                    $this->db->zmienna(":cel",$poz,"str");
                    $this->db->zmienna(":czas",date('Y-m-d H:i:s'),"str");
                    $this->db->wykonaj();
                }
            }
            $this->zwrocUklad();
            exit;
        }
        function getHistoria(){
            $historia = array();
            $this->db->przygotuj("SELECT figura, zrodlo, cel, czas FROM historia WHERE gra = :gid ORDEr BY RID DESC");
            $this->db->zmienna(":gid",$this->gid,"int");
            $this->db->wykonaj();
            $z = $this->db->przechwyc();
            while($baza = $z->fetch()){
                $a = explode(" ",$baza['czas']);
                if($baza['zrodlo'] != ""){
                    $c = explode("-",$baza['zrodlo']);
                    $zr = $this->litery[$c[1]].$c[0];
                } else $zr = "-";
                $d = explode("-",$baza['cel']);
                $historia[] = array($baza['figura'], $zr." > ".$this->litery[$d[1]].$d[0], $a[1]);
            }
            $z->closeCursor();
            return $historia;
        }

        function wyswietl(){

            return view('game')
                ->with('msg', $this->msg->display())
                ->with('user', $this->user)
                ->with('folder', $this->config->folder)
                ->with('gracz', $this->gracz)
                ->with('nick', $this->user->getLogin())
                ->with('linia', 8)
                ->with('kolumna', 8)
                ->with('klasa', $this)
                ->with('litery', $this->litery)
                ->with('tura', $this->tura)
                ->with('historia', $this->getHistoria())
                ->with('graczBiale', $this->graczBiale)
                ->with('graczCzarne', $this->graczCzarne)
                ->with('wymiana', $this->komunikat);
        }

        function wykonaj($request){
            if(!empty($request->input("wyloguj"))) return $this->wyloguj();
                $this->pobierzUklad();
            if(!empty($request->input("wymiana")) && !empty($request->input("figura")))
                return $this->wymien($request->input("wymiana"),$request->input("figura"));
            else if(!empty($request->input("figura")) && !empty($request->input("poleCel"))&& !empty($request->input("poleZrodlo"))) 
                return $this->zapiszRuch($request);
            else if(!empty($request->input("poddaj")))
                return $this->poddaj();
            else if(!empty($request->input("sprawdz2"))) 
                return $this->zwrocUklad();
            else
                return $this->wyswietl();
        }
    }