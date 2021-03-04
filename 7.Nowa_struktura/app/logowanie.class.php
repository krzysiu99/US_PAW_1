<?php namespace app;
    class logowanie{
        private $user;
        private $textLogin = array();

        function __construct(){
            if(session_status() == PHP_SESSION_NONE) session_start();
            $user = isset($_SESSION['user']) ? $_SESSION['user'] : NULL;
            $this->user = $user;
        }

        function sprawdz(){
            $user = $this->user;
            if($user == NULL){
                $smarty = getSmarty();
                $smarty->display('wymagane-logowanie.tpl');
                exit;
            }
        }
        function getUser(){
            return $this->user;
        }
        function formularz(){
            if(isset($_POST['zaloguj'])) {
                $textLogin = array();
                if(!isset($_POST['login']) || !isset($_POST['haslo']) || empty($_POST['login']) || empty($_POST['haslo'])) {
                    $textLogin[] = "Nie uzupełniłeś wszystkich wymaganych pól";
                } else {
                    $login = $_POST['login'];
                    $haslo = $_POST['haslo'];
                    //walidacja loginu i hasła
                    if($login == "admin"){
                        if($haslo == "12345") {
                            $_SESSION['user'] = $login;
                            header("location: index.php");
                            exit;
                        }
                        else $textLogin[] = "błędne hasło";

                    } else if($login == "user"){
                        if($haslo == "67890") {
                            $_SESSION['user'] = $login;
                            header("location: index.php");
                            exit;
                        }
                        else $textLogin[] = "błędne hasło";
        
                    } else $textLogin[] = "Nie ma takiego użytkownika";
                }
                $this->textLogin = $textLogin;
            }
        }
        function wylogujJesliZalogowany(){
            if($this->user != NULL){
                session_destroy();
                $this->user = NULL;
                $smarty = getSmarty();
                $smarty->assign('wylogowano', true);
            }
        }
        function wyswietl(){
            $smarty = getSmarty();

            $smarty->assign('user', $this->user);
            $smarty->assign('textLogin', $this->textLogin);
            $smarty->display('logowanie.tpl');
        }
        function wykonaj(){
            $this->wylogujJesliZalogowany();
            $this->formularz();
            $this->wyswietl();
        }
    }