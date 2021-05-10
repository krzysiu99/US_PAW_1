<?php
/*                    Projekt Szachy Online                        */
/*  Języki Programowania Dynamicznych Stron Internetowych          */
/*                     Krzysztof Niestrój                          */
/*              krzysztof.niestroj@o365.us.edu.pl                  */
/*                     Framework Laravel                           */
/*                         10.05.2021                              */

namespace App\Models;
class config{
    public $skrypt;
    public $folder;
    public $user;
    public $root_path;

    function __construct(){
        $this->skrypt = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];

        if(substr_count($this->skrypt,"index.php")==1)
            $this->folder = dirname($this->skrypt);
        else 
            $this->folder = dirname($this->skrypt."index.php");
        $this->root_path = dirname(__FILE__);
    }
}