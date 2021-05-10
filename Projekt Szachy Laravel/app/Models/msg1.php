<?php
/*                    Projekt Szachy Online                        */
/*  Języki Programowania Dynamicznych Stron Internetowych          */
/*                     Krzysztof Niestrój                          */
/*              krzysztof.niestroj@o365.us.edu.pl                  */
/*                     Framework Laravel                           */
/*                         10.05.2021                              */

namespace App\Models;

class msg1 {
    public $msg;
    public function __construct() {
        $this->msg = array();
    }
    function add($text) { //dodaj komunikat do buforu
        $this->msg[] = $text;
    }
    function display(){ //wyświetl wszystkie komunikaty
        if(count($this->msg)==0) return NULL;
        else{
            $a = "";
            for($i=0;isset($this->msg[$i]);$i++) $a .= $this->msg[$i];
            return $a;
        }
    }
}