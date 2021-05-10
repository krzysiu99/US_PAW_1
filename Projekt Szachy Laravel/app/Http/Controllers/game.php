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

class game extends Controller {
        private $uklad;
        private $gracz;
        private $litery = array(NULL,"A","B","C","D","E","F","G","H");
        private $tura;
        private $graczBiale;
        private $graczCzarne;
        private $komunikat;
        private $gid;

        private $config;
        private $msg;
        private $user;

        function __construct(){
            $this->config = new config();
            $this->msg = new msg1();
            $this->user = new user1();

            //sprawdzanie kto jakimi figurami gra
            $gra = DB::table('gra')->where('graczBiale', $this->user->getUID())->orWhere('graczCzarne', $this->user->getUID())->get();
            foreach($gra as $e){
                $this->gid = $e->GID;
                if($e->graczCzarne == $this->user->getUID()) {
                    $this->gracz = 2;
                    $this->graczCzarne = $this->user->getLogin();
                    $this->graczBiale = $this->user->nick($e->graczBiale);
                }
                else {
                    $this->gracz = 1;
                    $this->graczBiale = $this->user->getLogin();
                    $this->graczCzarne = $this->user->nick($e->graczCzarne);
                }
            }
        }

        function pokazFigure($linia,$kolumna){ //generowanie ikonki dla danej figury
            $figura = $this->uklad[$linia][$kolumna];
            if(($figura < 20 && $this->gracz == 2) || ($figura>20 && $this->gracz == 1)) $kl = "figuraMoja"; else $kl = "figuraWroga";
            if($figura != NULL)
                $fig = "<img src='".$this->config->folder."/images"."/".$figura.".png' alt='figura' class='$kl' id='figura-".$figura."'>";
            else
                $fig = "";
            return $fig;
        }

        function pokazFigure2($linia,$kolumna){ //jak wyżej tylko skrócona wersja dla ajax
            $figura = $this->uklad[$linia][$kolumna];
            if(($figura < 20 && $this->gracz == 2) || ($figura>20 && $this->gracz == 1)) $kl = "figuraMoja"; else $kl = "figuraWroga";
            if($figura != NULL && $figura != "")
                $fig = $figura.",".$kl;
            else
                $fig = "";
            return $fig;
        }

        function wyloguj(){ //wylogowanie bez kończenia gry
            if(session_status() == PHP_SESSION_NONE) session_start();
            $_SESSION['wyloguj'] = true;
            unset($_SESSION['user']);
            header("Location: index.php");
            exit;
        }

        function koniecGry($wygral){ //zakańczanie gry z ustaleniem zwycięzcy
            $gra = DB::table('gra')->where('graczBiale', $this->user->getUID())->orWhere('graczCzarne', $this->user->getUID())->get();
            foreach($gra as $e){
                $GID = $e->GID;
                $czarne = $e->graczCzarne;
                $biale = $e->graczBiale;
            }

            //kasowanie histori, gry oraz dodanie 1 w liczniku wygranych
            DB::table('gra')->where('GID', $GID)->delete();
            DB::table('historia')->where('gra', $GID)->delete();
            DB::table('gracz')->where('login', $wygral)->update(array(
                'wygrane'=>DB::raw('wygrane + 1')
            ));
            echo "Niestroj2021"; //tekst zwracany do ajax oznaczający konieczność przeładowania strony
            exit;
        }

        function pobierzUklad(){ //rozpakowywanie informacji o grze z bazy danych
            $gra = DB::table('gra')->where('graczBiale', $this->user->getUID())->orWhere('graczCzarne', $this->user->getUID())->get();
            foreach($gra as $e){
                $uklad = $e->uklad;
                $this->tura = $e->tura;
                $this->komunikat = $e->komunikat;
            }
            
            //czy są królowie w grze?
            $bi = false;
            $cz = false;
            if(substr_count($uklad,"15")) $cz = true; //15 i 35 to identyfikatory królów
            if(substr_count($uklad,"35")) $bi = true;

            //rozpakowywanie układu z postaci tekstowej do tablicowej
            $this->uklad = explode("\r\n",$uklad);
            for($i=1;isset($this->uklad[$i]);$i++){
                $this->uklad[$i] = explode(",",$this->uklad[$i]);
            }

            //sprawdzanie czy brakuje króla = przegrana
            if(!$bi) $this->koniecGry($this->graczCzarne);
            else if(!$cz) $this->koniecGry($this->graczBiale);
        }

        function zwrocUklad(){ //dynamiczne zwaracanie stanu gry do ajax
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

        function czyWymiana($uklad){ //sprawdzanie czy jest możliwa wymiana piona na inną figurę oraz zwracanie identyfikatora komunikatu
            if($this->tura == $this->gracz){
                for($i=1;$i<9;$i++){
                    if(isset($uklad[1][$i]) && $uklad[1][$i] != "" && ($uklad[1][$i] < 9 || ($uklad[1][$i] < 29 && $uklad[1][$i] > 20))) return $i;
                    else if(isset($uklad[8][$i]) && $uklad[8][$i] != "" && ($uklad[8][$i] < 9 || ($uklad[8][$i] < 29 && $uklad[8][$i] > 20))) return 10+$i;
                }
                return NULL;
            }
        }

        function zapiszRuch($request){ //zapisywanie pojedyńczego ruchu w grze
            $figura = addslashes($request->input("figura"));
            $poleCel = explode("-",addslashes($request->input("poleCel")));
            $poleZrodlo = explode("-",addslashes($request->input("poleZrodlo")));
            $poleZrodlo = array($poleZrodlo[1],$poleZrodlo[2]);

            //sprawdzanie czy wybrany ruch wybraną figurą jest dozwolony
            $this->sprawdzRuch($figura,$poleCel,$poleZrodlo);

            //zmiana układu szachownicy
            $this->uklad[$poleZrodlo[0]][$poleZrodlo[1]] = NULL;
            $this->uklad[$poleCel[0]][$poleCel[1]] = $figura;

            //sprawdzanie komunikatu o możliwej wymianie piona
            $wymiana = $this->czyWymiana($this->uklad);

            //pakowanie układu w postać tekstową dla bazy danych
            $Nuklad = array();
            for($i=0;isset($this->uklad[$i]);$i++) if($this->uklad[$i] != "") $Nuklad[] = implode(",",$this->uklad[$i]); else $Nuklad[] = "";
            $Nuklad = implode("\r\n",$Nuklad);

            $komunikat = 0;

            //zmiana tury i ewentualnego komunikatu
            $gra = DB::table('gra')->where('graczBiale', $this->user->getUID())->orWhere('graczCzarne', $this->user->getUID())->get();
            foreach($gra as $e){
                if($wymiana == NULL)
                    $tura = $e->tura == 1 ? 2 : 1;
                else{
                    $tura = $e->tura;
                    $komunikat = $wymiana;
                    $this->komunikat = $wymiana;
                }
            }

            //zapisywanie ruchu w historii
            DB::table('historia')->insert(array(
                'RID' => NULL, 
                'gra' => $this->gid,
                'figura' => $figura,
                'zrodlo' => $poleZrodlo[0]."-".$poleZrodlo[1],
                'cel' => $request->input("poleCel"),
                'czas' => date('Y-m-d H:i:s')
            ));

            //zapisywanie stanu gry
            DB::table('gra')->where('GID', $this->gid)->update(array(
                'uklad'=>$Nuklad,
                'tura'=>$tura,
                'komunikat'=>$komunikat
            ));
            $this->tura = $tura;

            //po zapisaniu ruchu odrazu aktualizuj grę zwracając układ dla ajax
            $this->zwrocUklad();
        }

        function sprawdzRuch($f,$poleCel,$poleZrodlo){ //sprawdzanie czy ruch wybraną figurą w wybrane miesjce jest dozwolony
            $blad = false;

            //sprawdzanie tury gracza
            if($this->gracz != $this->tura) $blad = true;

            //sprawdzanie czy pola są liczbami
            if(!(is_numeric($poleCel[0]) && is_numeric($poleCel[1]) && is_numeric($poleZrodlo[0]) && is_numeric($poleZrodlo[1]))) $blad = true;

            $poleCel[0] = intval($poleCel[0]);
            $poleCel[1] = intval($poleCel[1]);
            $poleZrodlo[0] = intval($poleZrodlo[0]);
            $poleZrodlo[1] = intval($poleZrodlo[1]);

            //sprawdzanie czy figura istnieje
            if(! (($f > 0 && $f < 9) || ($f > 10 && $f < 19) || ($f > 20 && $f < 29) || ($f > 20 && $f < 29) || ($f > 30 && $f < 39))) $blad = true;

            //sprawdzanie czy pola nie są po za planszą
            if($poleZrodlo[0] > 8 || $poleZrodlo[0] < 1 || $poleCel[0] > 8 || $poleCel[0] < 1) $blad = true;

            //sprawdzanie czy figura którą wykonuje się ruch jest tam gdzie twierdzi przeglądarka użytkownika
            if(!isset($this->uklad[$poleZrodlo[0]][$poleZrodlo[1]]) || $this->uklad[$poleZrodlo[0]][$poleZrodlo[1]] != $f) $blad = true;


            //sprawdzanie czy ruch wykonało sie swoją figurą
            if($this->gracz==1 && $f < 21) $blad = true;
            else if($this->gracz==2 && $f > 18) $blad = true;

            //sprawdzanie czy nie zbije swojej figruy
            if(!($this->uklad[$poleCel[0]][$poleCel[1]] == "" || (($this->uklad[$poleCel[0]][$poleCel[1]]<20 && $this->gracz==1) || ($this->uklad[$poleCel[0]][$poleCel[1]]>20 && $this->gracz==2)))) $blad = true;

            //sprawdzanie ruchu: wieza
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
            //sprawdzanie ruchu: król
            else if($f == 15 || $f == 35){
                if($poleCel[0] > $poleZrodlo[0]+1) $blad = true;
                if($poleCel[0] < $poleZrodlo[0]-1) $blad = true;
                if($poleCel[1] > $poleZrodlo[1]+1) $blad = true;
                if($poleCel[1] < $poleZrodlo[1]-1) $blad = true;
            }
            //sprawdzanie ruchu: koń
            else if($f == 12 || $f == 17 || $f == 32 || $f == 37){
                if(!(($poleCel[0] == $poleZrodlo[0]+1 && $poleCel[1] == $poleZrodlo[1]+2) || ($poleCel[0] == $poleZrodlo[0]+2 && $poleCel[1] == $poleZrodlo[1]+1) || ($poleCel[0] == $poleZrodlo[0]-1 && $poleCel[1] == $poleZrodlo[1]-2) || ($poleCel[0] == $poleZrodlo[0]-2 && $poleCel[1] == $poleZrodlo[1]-1) || ($poleCel[0] == $poleZrodlo[0]+2 && $poleCel[1] == $poleZrodlo[1]-1) || ($poleCel[0] == $poleZrodlo[0]+1 && $poleCel[1] == $poleZrodlo[1]-2) || ($poleCel[0] == $poleZrodlo[0]-1 && $poleCel[1] == $poleZrodlo[1]+2) || ($poleCel[0] == $poleZrodlo[0]-2 && $poleCel[1] == $poleZrodlo[1]+1))) $blad = true;
            }
            //sprawdzanie ruchu: pion
            else if($f < 9 || ($f > 20 && $f < 29)){
                if($f>9){ //białe
                    if(!(($poleZrodlo[0] == 7 && $poleCel[0] == $poleZrodlo[0]-2 && $poleCel[1] == $poleZrodlo[1] && $this->uklad[$poleCel[0]][$poleCel[1]] == "" && $this->uklad[$poleZrodlo[0]-1][$poleCel[1]] == "") || ($poleCel[0] == $poleZrodlo[0]-1 && $poleCel[1] == $poleZrodlo[1] && $this->uklad[$poleCel[0]][$poleCel[1]] == "") || ($poleCel[0] == $poleZrodlo[0]-1 && ($poleCel[1] == $poleZrodlo[1]+1 || $poleCel[1] == $poleZrodlo[1]-1) && $this->uklad[$poleCel[0]][$poleCel[1]] != "" && $this->uklad[$poleCel[0]][$poleCel[1]] < 20))) $blad = true;
                } else {
                    if(!(($poleZrodlo[0] == 2 && $poleCel[0] == $poleZrodlo[0]+2 && $poleCel[1] == $poleZrodlo[1] && $this->uklad[$poleCel[0]][$poleCel[1]] == "" && $this->uklad[$poleZrodlo[0]+1][$poleCel[1]] == "") || ($poleCel[0] == $poleZrodlo[0]+1 && $poleCel[1] == $poleZrodlo[1] && $this->uklad[$poleCel[0]][$poleCel[1]] == "") || ($poleCel[0] == $poleZrodlo[0]+1 && ($poleCel[1] == $poleZrodlo[1]+1 || $poleCel[1] == $poleZrodlo[1]-1) && $this->uklad[$poleCel[0]][$poleCel[1]] != "" && $this->uklad[$poleCel[0]][$poleCel[1]] > 20))) $blad = true;
                }
            }
            //sprawdzanie ruchu: goniec
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
            //sprawdzanie ruchu: królowa
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


            if($blad){ //jeśli gdzieś wystąpił błąd to wykonywanie kodu jest przerywane oraz wyświetlany jest aktualny układ
                $this->zwrocUklad();
                exit;
            }
        }

        function poddaj(){ //poddanie się podczas gry
            $gra = DB::table('gra')->where('graczBiale', $this->user->getUID())->orWhere('graczCzarne', $this->user->getUID())->get();
            foreach($gra as $e){
                $GID = $e->GID;
            }

            //czyszczenie historii i gry
            DB::table('gra')->where('GID', $GID)->delete();
            DB::table('historia')->where('gra', $GID)->delete();

            //ustalanie kto wygrał
            if($this->graczBiale == $this->user->getLogin()) 
                $wygral = $this->graczCzarne;
            else
                $wygral = $this->graczBiale;

            DB::table('gracz')->where('login', $wygral)->update(array(
                'wygrane'=>DB::raw('wygrane + 1')
            ));

            echo "Niestroj2021"; //tekst zwracany do ajax oznaczający konieczność przeładowania strony
            exit;
        }
        function wymien($pozycja,$figura){ //wymiana piona na inną figurę po po dotarciu do końca planszy
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

                //pakowanie układu
                $Nuklad = array();
                for($i=0;isset($this->uklad[$i]);$i++) if($this->uklad[$i] != "") $Nuklad[] = implode(",",$this->uklad[$i]); else $Nuklad[] = "";
                $Nuklad = implode("\r\n",$Nuklad);

                //aktualizacja stanu gry
                DB::table('gra')->where('GID', $this->gid)->update(array(
                    'uklad'=>$Nuklad,
                    'tura'=>$this->tura,
                    'komunikat'=>$this->komunikat
                ));

                //zapisz historia
                if(isset($poz)){
                    DB::table('historia')->insert(array(
                        'RID' => NULL, 
                        'gra' => $this->gid,
                        'figura' => $figura,
                        'zrodlo' => "",
                        'cel' => $poz,
                        'czas' => date('Y-m-d H:i:s')
                    ));
                }
            }
            $this->zwrocUklad(); //wyświetlanie aktualnego układu
            exit;
        }
        function getHistoria(){ //zwraca historię ruchów w postaci tablicy
            $historia = array();

            $hist = DB::table('historia')->where('gra', $this->gid)->orderBy('RID', 'desc')->get();
           foreach($hist as $e){
                $a = explode(" ",$e->czas);
                if($e->zrodlo != ""){
                    $c = explode("-",$e->zrodlo);
                    $zr = $this->litery[$c[1]].$c[0];
                } else $zr = "-";
                $d = explode("-",$e->cel);
                $historia[] = array($e->figura, $zr." > ".$this->litery[$d[1]].$d[0], $a[1]);
            }
            return $historia;
        }

        function wyswietl(){ //wyświetl stronę z szachownicą

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

        function wykonaj($request){ //punkt wejścia do klasy dla metod GET i POST
            if(!empty($request->input("wyloguj"))) 
                return $this->wyloguj(); //wylogowanie w trakcie gry
            $this->pobierzUklad(); //pobranie układu z bazy i rozpakowanie w tablice
            if(!empty($request->input("wymiana")) && !empty($request->input("figura"))) //wymiana piona po dotarciu do końca planszy
                return $this->wymien($request->input("wymiana"),$request->input("figura"));
            else if(!empty($request->input("figura")) && !empty($request->input("poleCel"))&& !empty($request->input("poleZrodlo"))) //wykonywanie ruchu w grze
                return $this->zapiszRuch($request);
            else if(!empty($request->input("poddaj"))) //poddanie się
                return $this->poddaj();
            else if(!empty($request->input("sprawdz2"))) //dynamiczne sprawdzanie gry przez ajax
                return $this->zwrocUklad();
            else
                return $this->wyswietl(); //wyświetlanie widoku
        }
    }