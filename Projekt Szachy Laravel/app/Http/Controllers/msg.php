<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class msg extends Controller
{
    public $msg;
    public function __construct() {
        $this->msg = array();
    }
    function add($text) {
        $this->msg[] = $text;
    }
    function display(){
        if(count($this->msg)==0) return NULL;
        else{
            $a = "";
            for($i=0;isset($this->msg[$i]);$i++) $a .= $this->msg[$i]."<br>";
            return $a;
        }
    }
}
