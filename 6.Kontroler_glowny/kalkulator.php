<?php include_once("config.php"); include_once("straznik.php");

    include_once("kalkulator.class.php");
    $kalk = new kalkulator();
    
    //wymagane logowanie
    if($config->user != NULL)
        $kalk->wykonaj();
    else {
        include('lib/smarty/Smarty.class.php');
        $smarty = new Smarty;
        $smarty->assign('folder', $config->folder);
        $smarty->assign('skrypt', $config->skrypt);
        $smarty->assign('user', $config->user);
        $smarty->display('wymagane-logowanie.tpl');
    }

    

    