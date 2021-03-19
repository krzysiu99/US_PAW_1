<?php
    session_start();

    function czy_zalogowany(){
        return isset($_SESSION['user']) ? $_SESSION['user'] : NULL;
    }

    function wymagane_logowanie(){
        include('lib/Smarty/Smarty.class.php');
        $smarty = new Smarty;
        global $config;
        
        $smarty->assign('folder', $config->folder);
        $smarty->assign('skrypt', $config->skrypt);
        $smarty->assign('user', $config->user);
        $smarty->display('wymagane-logowanie.tpl');
    }