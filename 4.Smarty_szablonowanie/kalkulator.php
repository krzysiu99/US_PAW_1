<?php include_once("config.php"); include_once("straznik.php");
    
    $user = NULL;

    //smarty
    include('./lib/smarty/Smarty.class.php');
    $smarty = new Smarty;
    $smarty->assign('folder', folder);
    $smarty->assign('skrypt', skrypt);

    $user = czy_zalogowany();
    $smarty->assign('user', $user);

    $text = array();
    $rata = NULL;
    $procent = NULL;
    $lat = NULL;
    $kwota = NULL;
    $kwota_wolna = NULL;
    
    //wymagane logowanie
    if($user != NULL){

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
        function sprawdz(&$procent,&$kwota,&$lat,&$text){
            switch($procent){
                case "3.5 %"; $procent = 3.5; break;
                case "5 %"; $procent = 5; break;
                default: $procent = 8;
            }
        
            if(!is_numeric($kwota) || !is_numeric($lat)){
                $text[] = "Wprowadź liczby do poniższych pól";
                return false;
            } else return true;
        }
        if(isset($_POST['oblicz'])){
            if(!isset($_POST['kwota']) || !isset($_POST['lat']) || !isset($_POST['procent'])) {
                $text[] = "Nie uzupełniłeś wszystkich wymaganych pól";
            } else {
                $kwota = $_POST['kwota'];
                $lat = $_POST['lat'];
                $procent = $_POST['procent'];
                $rata = null;
                $kwota_wolna = null;

                if(sprawdz($procent,$kwota,$lat,$text))
                    oblicz($kwota,$procent,$lat,$rata,$kwota_wolna);
            }
        }

        $smarty->assign('text', $text);
        $smarty->assign('rata', $rata);
        $smarty->assign('kwota_wolna', $kwota_wolna);
        $smarty->assign('kwota', $kwota);
        $smarty->assign('procent', $procent);
        $smarty->assign('lat', $lat);

        $smarty->display('kalkulator.tpl');
    } else $smarty->display('wymagane-logowanie.tpl');

    

    