<?php
namespace core;

class msg {
    public $msg;
    public function __construct() {
        $this->msg = array();
    }
    function add($text) {
        $this->msg[] = $text;
    }
    function display(){
        return $this->msg;
    }
}