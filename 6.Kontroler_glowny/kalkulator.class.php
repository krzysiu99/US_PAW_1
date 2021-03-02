<?php
    class kalkulator{
        private $text;
        private $rata;
        private $procent;
        private $lat;
        private $kwota;
        private $kwota_wolna;
        private $oblicz;

        function __construct(){
            $this->text = array();
            $this->rata = NULL;
            $this->procent = NULL;
            $this->lat = NULL;
            $this->kwota = NULL;
            $this->kwota_wolna = NULL;
            $this->oblicz = isset($_POST['oblicz']) ? true : false;
        }

        function pobierz(){
            $this->kwota = $_POST['kwota'];
            $this->lat = $_POST['lat'];
            $this->procent = $_POST['procent'];
        }
        function oblicz(){
            //zamiana na liczby
            $kwota = floatval($this->kwota);
            $lat = intval($this->lat);
            $procent = floatval($this->procent);

            //obliczanie
            $kwota_wolna = $kwota / ($lat*12);
            $rata = $kwota_wolna + ($procent * $kwota_wolna / 100);
            $this->rata = round($rata,2);
            $this->kwota_wolna = round($kwota_wolna,2);
        }
        function sprawdz(){
            switch($this->procent){
                case "3.5 %"; $this->procent = 3.5; break;
                case "5 %"; $this->procent = 5; break;
                default: $this->procent = 8;
            }
        
            if(!is_numeric($this->kwota) || !is_numeric($this->lat)){
                $this->text[] = "Wprowadź liczby do poniższych pól";
                return false;
            } else return true;
        }
        function wyswietl(){
            include('lib/smarty/Smarty.class.php');
            $smarty = new Smarty;
            global $config;
            $smarty->assign('folder', $config->folder);
            $smarty->assign('skrypt', $config->skrypt);
            $smarty->assign('user', $config->user);

            $smarty->assign('text', $this->text);
            $smarty->assign('rata', $this->rata);
            $smarty->assign('kwota_wolna', $this->kwota_wolna);
            $smarty->assign('kwota', $this->kwota);
            $smarty->assign('procent', $this->procent);
            $smarty->assign('lat', $this->lat);

            $smarty->display('kalkulator.tpl');
        }
        function wykonaj(){
            if($this->oblicz){
                $this->pobierz();
                if($this->sprawdz()) 
                    $this->oblicz();
            }
            $this->wyswietl();
        }
    }