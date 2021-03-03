<?php
    function getAction(){
        return isset($_GET['action']) ? $_GET['action'] : "";
    }