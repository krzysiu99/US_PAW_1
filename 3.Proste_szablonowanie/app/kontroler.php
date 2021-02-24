<?php if(!defined('skrypt')) header("Location: ../index.php");
    function oblicz(&$kwota,&$procent,&$lat,&$rata,&$kwota_wolna){
        //zamiana na liczby
        $kwota = floatval($kwota);
        $lat = intval($lat);
        $procent = floatval($procent);

        //obliczanie
        $kwota_wolna = $kwota / ($lat*12);
        $rata = $kwota_wolna + ($procent * $kwota_wolna / 100);
        $rata = round($rata,2);
        $kwota_wolna = round($kwota_wolna,2);
    }
    function sprawdz(&$procent,&$kwota,&$lat){
        switch($procent){
            case "3.5 %"; $procent = 3.5; break;
            case "5 %"; $procent = 5; break;
            default: $procent = 8;
        }
    
        if(!is_numeric($kwota) || !is_numeric($lat)){
            $text[] = "Wprowadź liczby do powyższych pól";
            return false;
        } else return true;
    }


    //wymagane logowanie
    include_once("./straznik.php");
    
    if(!isset($_POST['kwota']) || !isset($_POST['lat']) || !isset($_POST['procent'])) {
        $text[] = "Nie uzupełniłeś wszystkich wymaganych pól";
        return;
    }

    $kwota = $_POST['kwota'];
    $lat = $_POST['lat'];
    $procent = $_POST['procent'];
    $rata = null;
    $kwota_wolna = null;

    if(sprawdz($procent,$kwota,$lat))
        oblicz($kwota,$procent,$lat,$rata,$kwota_wolna);

    

    