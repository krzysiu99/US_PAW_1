<?php
    include_once("init.php");

    switch($akcja){
        case "logowanie":
            include_once("app/logowanie.php");
        break;
        default:
            //include_once("app/kalkulator.class.php");
            $kalk = new app\kalkulator();
            
            //wymagane logowanie
            if($config->user != NULL)
                $kalk->wykonaj();
            else wymagane_logowanie();
    }