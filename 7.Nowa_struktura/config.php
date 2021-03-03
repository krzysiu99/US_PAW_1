<?php 
    $config->user = czy_zalogowany();
    $config->skrypt = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
    if(substr_count($config->skrypt,"index.php")==1)
        $config->folder = dirname($config->skrypt);
    else $config->folder = dirname($config->skrypt."index.php");
    $config->action_root = $config->folder."/index.php?action=";
    $config->root_path = dirname(__FILE__);