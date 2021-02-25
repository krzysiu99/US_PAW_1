<?php
    define("skrypt","http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
    if(substr_count(skrypt,"index.php")==1)
        define("folder",dirname(skrypt));
        else define("folder",dirname(skrypt."index.php"));