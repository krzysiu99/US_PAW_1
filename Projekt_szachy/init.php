<?php
    include_once("core/config.class.php");
    $config = new core\config();
    include_once("config.php");

    function &getConfig(){
        global $config;
        return $config;
    }

    include_once("core/msg.class.php");
    $msg = new core\msg();

    function &getMsg(){
        global $msg;
        return $msg;
    }

    include_once("core/db.class.php");
    $db = new core\db();

    function &getDb(){
        global $db;
        return $db;
    }

    $smarty = null;

    function &getSmarty(){
        global $smarty;
        if(!isset($smarty)){
            include('lib/smarty/Smarty.class.php');
            $smarty = new Smarty;
            $config = getConfig();
            $smarty->assign('folder', $config->folder);
            $smarty->assign('skrypt', $config->skrypt);
            $smarty->assign('user', $config->user);
            $smarty->assign('action_root', $config->action_root);
            $smarty->setTemplateDir(array(
                'one' => 'app',
                'two' => 'teplemate'
            ));
        }
        return $smarty;
    }

    // include_once("app/logowanie.class.php");
    // $log = new app\logowanie();
    // $config = getConf();
    // $config->user = $log->getUser();
    // function &getLogowanie(){
    //     global $log;
    //     return $log;
    // }

    include_once("core/classLoader.class.php");
    $cloader = new core\ClassLoader();
    function &getLoader(){
        global $cloader;
        return $cloader;
    }

    include_once("core/functions.php");
    //$akcja = getAction();