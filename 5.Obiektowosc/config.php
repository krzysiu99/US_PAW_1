<?php include_once("straznik.php"); include_once("config.class.php");
    $config = new config();

    $config->user = czy_zalogowany();

    $config->skrypt = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
    if(substr_count($config->skrypt,"index.php")==1)
        $config->folder = dirname($config->skrypt);
    else $config->folder = dirname($config->skrypt."index.php");