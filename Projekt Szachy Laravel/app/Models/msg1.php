<?php
namespace App\Models;

class msg1 {
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
            for($i=0;isset($this->msg[$i]);$i++) $a .= $this->msg[$i];
            return $a;
        }
    }
}