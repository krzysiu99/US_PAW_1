<?php
    function getAction(){
        return isset($_GET['action']) ? $_GET['action'] : "";
    }
    function getFromPost($index){
        return isset($_POST[$index]) ? $_POST[$index] : NULL;
    }