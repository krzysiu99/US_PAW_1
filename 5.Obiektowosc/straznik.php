<?php
    session_start();

    function czy_zalogowany(){
        return isset($_SESSION['user']) ? $_SESSION['user'] : NULL;
}