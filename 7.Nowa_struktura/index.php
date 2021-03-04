<?php
    include_once("init.php");

    switch($akcja){
        case "logowanie":
            //include_once("app/logowanie.php");
            $log = getLogowanie();
            $log->wykonaj();
        break;
        default:
            //sprawdz logowanie
            $log = getLogowanie();
            $log->sprawdz();

            $kalk = new app\kalkulator();
            $kalk->wykonaj();
    }