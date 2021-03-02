<?php
    include_once("config.php");
    include_once("straznik.php");

    $akcja = isset($_GET['action']) ? $_GET['action'] : "";

    switch($akcja){
        case "logowanie":
            include_once("logowanie.php");
        break;
        default:
            include_once("kalkulator.class.php");
            $kalk = new kalkulator();
            
            //wymagane logowanie
            if($config->user != NULL)
                $kalk->wykonaj();
            else wymagane_logowanie();
    }