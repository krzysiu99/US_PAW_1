<?php if(!defined('skrypt')) header("Location: index.php");

    session_start();

    $user = isset($_SESSION['user']) ? $_SESSION['user'] : NULL;

    if($user == NULL) {
        include_once("./login-kontroler.php");
        include_once("./login-widok.php");
        exit;
    }

    if(isset($_POST['wyloguj']) && isset($_SESSION['user'])){ //wyloguj
        session_destroy();
        header("Location: ".skrypt);
        exit;
    }