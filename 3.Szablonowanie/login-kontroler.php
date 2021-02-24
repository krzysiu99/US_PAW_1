<?php if(!defined('skrypt')) header("Location: index.php");

    if(session_id() == '') session_start();

    if(!isset($_POST['zaloguj'])) return;

    if(!isset($_POST['login']) || !isset($_POST['haslo'])) {
        $textLogin[] = "Nie uzupełniłeś wszystkich wymaganych pól";
        return;
    }

    $login = $_POST['login'];
    $haslo = $_POST['haslo'];

    //walidacja loginu i hasła
    if($login == "admin"){
        if($haslo == "12345") {
            $_SESSION['user'] = $login;
            header("location: ".skrypt);
            exit;
        }
        else $textLogin[] = "błędne hasło";

    } else if($login == "user"){
        if($haslo == "67890") {
            $_SESSION['user'] = $login;
            header("location: ".skrypt);
            exit;
        }
        else $textLogin[] = "błędne hasło";

    } else $textLogin[] = "Nie ma takiego użytkownika";