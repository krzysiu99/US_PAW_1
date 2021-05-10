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

class stronaStartowa extends Controller {
    private $config;
    private $msg;

    function __construct(){
        $this->config = new config();
        $this->msg = new msg1();
    }

    function logowanie(Request $request){ //punkt wejścia dla metody POST - przesłanie formularza logowania/rejestracji

        $login = htmlspecialchars(addslashes($request->input('login')));
        $haslo = htmlspecialchars(addslashes($request->input('haslo')));

        //czy login i has lo nie puste
        if(empty($login) || empty($haslo)) {
            $this->msg->add("uzupełnij oba pola");
            return $this->wyswietl();
            exit;
        }

        //walidacja pól
        $blad = false;
        if(!(strlen($login)>2 && strlen($login)<16)) $blad = true;
        if(!(strlen($haslo)>2 && strlen($haslo)<31)) $blad = true;
        if(!preg_match("/[A-Za-z0-9]+/",$login)) $blad = true;

        if($blad){
            $this->msg->add("niepoprawne znaki lub długość");
            return $this->wyswietl();
            exit;
        }

        //skrypty logowania na instniejące konto lub rejestracji
        if(!empty($request->input('zaloguj'))) return $this->loguj($login, $haslo);
        else return $this->rejestruj($login, $haslo);

    }

    function loguj($login, $haslo){ //logowanie na istniejące konto
        //sprawdzanie loginu i hasła
        $gracze = DB::table('gracz')->where('login', $login)->get();
        foreach($gracze as $e){
            $zalogowano = "";
            if(md5($haslo) == $e->haslo) $zalogowano = $e->UID;
        }

        if(!isset($zalogowano)){
            $this->msg->add("brak wskazanego użytkownika");
            return $this->wyswietl();
            exit;
        }
        if(empty($zalogowano)){
            $this->msg->add("błędne hasło");
            return $this->wyswietl();
            exit;
        } else { //gdy zalogowano
            if(session_status() == PHP_SESSION_NONE) session_start();
            DB::table('gracz')->where('login', $login)->update(array(
                'ostatnio_online'=>date('Y-m-d H:i:s')
            ));
            $_SESSION['user'] = $zalogowano;
            header("location: index.php");
            exit;
        }
    }

    function rejestruj($login, $haslo){ //tworzenie konta
        //sprawdzanie czy nick już zajęty
        $gracze = DB::table('gracz')->where('login', $login)->get();
        $zajety = false;
        foreach($gracze as $e){
            $zajety = true;
            break;
        }

        if($zajety){
            $this->msg->add("ten login jest zajęty");
            return $this->wyswietl();
            exit;
        } else { //nick wolny
            //tworzenie konta
            $UID = DB::table('gracz')->insertGetId(array(
                'UID' => NULL, 
                'login' => $login,
                'haslo' => md5($haslo),
                'ostatnia_gra' => date('Y-m-d'),
                'ostatnio_online' => date('Y-m-d H:i:s'),
                'wygrane' => 0
            ));

            //logowanie na stworzone konto
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

    function sprawdzKonta(){ //sprawdzanie czy są przeterminowane konta
        $min = strtotime(date("Y-m-d H:i:s"))-(7*24*3600); // 7 dni
        $gracze = DB::table('gracz')->get();
        foreach ($gracze as $e){
            if(strtotime($e->ostatnia_gra.date("H:i:s")) < $min){ //jeśli znaleziono to usuwanie konta i powiązanych: gier, historii i zaproszeń
                $gry = DB::table('gra')->where('graczBiale', $e->UID)->orWhere('graczCzarne', $e->UID)->get();
                foreach ($gry as $ee){
                    DB::table('historia')->where('gra', $ee->GID)->delete();
                }
                DB::table('gra')->where('graczBiale', $e->UID)->orWhere('graczCzarne', $e->UID)->delete();
                DB::table('zaproszenie')->where('zaproszony', $e->UID)->orWhere('zapraszajacy', $e->UID)->delete();
                DB::table('gracz')->where('UID', $e->UID)->delete();
            }
        }
    }
    function sprawdzBaze(){ //sprawdzanie bazy danych czy istnieją wymagane tabele
        $czy = DB::table('INFORMATION_SCHEMA.TABLES')->where('TABLE_NAME', 'gracz')->get();
        $ist = false;
        foreach ($czy as $e) {
            $ist = true;
            break;
        }
        if(!$ist){ //jeśli nie to tworzenie tabel
            DB::statement("CREATE TABLE `gra` (
                `GID` int(11) NOT NULL,
                `tura` int(1) NOT NULL,
                `uklad` text COLLATE utf8_polish_ci NOT NULL,
                `komunikat` int(11) NOT NULL,
                `data_rozpoczecia` date NOT NULL,
                `graczBiale` int(11) NOT NULL,
                `graczCzarne` int(11) NOT NULL
              ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;");
            DB::statement("CREATE TABLE `gracz` (
                `UID` int(11) NOT NULL,
                `login` text COLLATE utf8_polish_ci NOT NULL,
                `haslo` text COLLATE utf8_polish_ci NOT NULL,
                `ostatnia_gra` date NOT NULL,
                `ostatnio_online` datetime NOT NULL,
                `wygrane` int(11) NOT NULL DEFAULT 0
              ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;");
            DB::statement("CREATE TABLE `historia` (
                `RID` int(11) NOT NULL,
                `gra` int(11) NOT NULL,
                `figura` int(11) NOT NULL,
                `zrodlo` varchar(5) COLLATE utf8_polish_ci NOT NULL,
                `cel` varchar(5) COLLATE utf8_polish_ci NOT NULL,
                `czas` datetime NOT NULL
              ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;");
            DB::statement("CREATE TABLE `zaproszenie` (
                `ZID` int(11) NOT NULL,
                `zapraszajacy` int(11) NOT NULL,
                `zaproszony` int(11) NOT NULL
              ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;");
            DB::statement("ALTER TABLE `gra`
                ADD PRIMARY KEY (`GID`),
                ADD KEY `p1` (`graczBiale`),
                ADD KEY `p2` (`graczCzarne`);");
            DB::statement("ALTER TABLE `gra`
                MODIFY `GID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0;");
            DB::statement("ALTER TABLE `gracz`
                ADD PRIMARY KEY (`UID`);");
            DB::statement("ALTER TABLE `gracz`
                MODIFY `UID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0;");
            DB::statement("ALTER TABLE `historia`
                ADD PRIMARY KEY (`RID`),
                ADD KEY `p3` (`gra`);");
            DB::statement("ALTER TABLE `historia`
                MODIFY `RID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0;");
            DB::statement("ALTER TABLE `zaproszenie`
                ADD PRIMARY KEY (`ZID`),
                ADD KEY `z1` (`zapraszajacy`),
                ADD KEY `z2` (`zaproszony`);");
            DB::statement("ALTER TABLE `zaproszenie`
                MODIFY `ZID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0;");
            DB::statement("ALTER TABLE `gra`
                ADD CONSTRAINT `p1` FOREIGN KEY (`graczBiale`) REFERENCES `gracz` (`UID`) ON DELETE CASCADE ON UPDATE CASCADE,
                ADD CONSTRAINT `p2` FOREIGN KEY (`graczCzarne`) REFERENCES `gracz` (`UID`) ON DELETE CASCADE ON UPDATE CASCADE;");
            DB::statement("ALTER TABLE `historia`
                ADD CONSTRAINT `p3` FOREIGN KEY (`gra`) REFERENCES `gra` (`GID`) ON DELETE CASCADE ON UPDATE CASCADE;");
            DB::statement("ALTER TABLE `zaproszenie`
                ADD CONSTRAINT `z1` FOREIGN KEY (`zapraszajacy`) REFERENCES `gracz` (`UID`) ON DELETE CASCADE ON UPDATE CASCADE,
                ADD CONSTRAINT `z2` FOREIGN KEY (`zaproszony`) REFERENCES `gracz` (`UID`) ON DELETE CASCADE ON UPDATE CASCADE;");
        }
    }

    function wyswietl(){ //wyświetlanie widoku

        if(session_status() == PHP_SESSION_NONE) session_start();
        if(isset($_SESSION['wyloguj'])) { //wylogowanie
            $wylogowano = true;
            session_destroy();
        } else $wylogowano = false;

        
        return view('stronaStartowa')
            ->with('wyloguj', $wylogowano)
            ->with('folder',$this->config->folder)
            ->with('msg', $this->msg);
    }

    function wykonaj(){ //punkt wejścia do klasy dla metody GET
        $this->sprawdzBaze(); //sprawdź czy istnieją tabele w bazie
        $this->sprawdzKonta(); //sprawdź czy są przeterminowane konta
        return $this->wyswietl(); //wyświetlanie widoku
    }
}