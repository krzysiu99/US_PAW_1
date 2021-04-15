<?php
namespace App\Models;
class config{
    public $skrypt;
    public $folder;
    public $user;
    public $action_root;
    public $root_path;

    function __construct(){
        $this->skrypt = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];

        if(substr_count($this->skrypt,"index.php")==1)
            $this->folder = dirname($this->skrypt);
        else 
            $this->folder = dirname($this->skrypt."index.php");
        $this->action_root = $this->folder."/index.php?action=";
        $this->root_path = dirname(__FILE__);
    }
}