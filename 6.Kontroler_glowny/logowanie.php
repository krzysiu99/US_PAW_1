<?php

    $user = NULL;

    //smarty
    include('lib/smarty/Smarty.class.php');
    $smarty = new Smarty();
    $smarty->assign('folder', $config->folder);
    $smarty->assign('skrypt', $config->skrypt);
    $smarty->assign('action_root', $config->action_root);

    if(session_id() == '') session_start();

    $user = czy_zalogowany();

    //sprawdz czy zalogowany
    if($user != NULL){ //wyloguj
        session_destroy();
        $smarty->assign('wylogowano', true);
    }

    if(isset($_POST['zaloguj'])) {

        if(!isset($_POST['login']) || !isset($_POST['haslo'])) {
            $textLogin[] = "Nie uzupełniłeś wszystkich wymaganych pól";
        } else {
            $login = $_POST['login'];
            $haslo = $_POST['haslo'];

            //walidacja loginu i hasła
            if($login == "admin"){
                if($haslo == "12345") {
                    $_SESSION['user'] = $login;
                    $user = $login;
                    header("location: index.php");
                }
                else $textLogin[] = "błędne hasło";

            } else if($login == "user"){
                if($haslo == "67890") {
                    $_SESSION['user'] = $login;
                    $user = $login;
                    header("location: index.php");
                }
                else $textLogin[] = "błędne hasło";

            } else $textLogin[] = "Nie ma takiego użytkownika";
        }
    }

    if(isset($textLogin)) $smarty->assign('textLogin', $textLogin);

    $smarty->assign('user', $user);
    $smarty->display('logowanie.tpl');