<?php namespace app;
    class game{
        private $uklad;
        private $gracz;
        private $litery = array(NULL,"A","B","C","D","E","F","G","H");

        function __construct(){
            // $this->uklad = array(
            //     array(NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
            //     array(NULL, 11, 12, 13, 14, 15, 16, 17, 18),
            //     array(NULL, 1, 2, 3, 4, 5, 6, 7, 8),
            //     array(NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
            //     array(NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
            //     array(NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
            //     array(NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
            //     array(NULL, 21, 22, 23, 24, 25, 26, 27, 28),
            //     array(NULL, 31, 32, 33, 34, 35, 36, 37, 38),
            // );
            $this->gracz = 1;
        }

        function pokazFigure($linia,$kolumna){
            $config = getConfig();
            $figura = $this->uklad[$linia][$kolumna];
            if(($figura < 20 && $this->gracz == 2) || ($figura>20 && $this->gracz == 1)) $kl = "figuraMoja"; else $kl = "figuraWroga";
            if($figura != NULL)
                $fig = "<img src='".$config->folder."/images"."/".$figura.".png' alt='figura' class='$kl' id='figura-".$figura."'>";
            else
                $fig = "";

            return $fig;
        }

        function pokazFigure2($linia,$kolumna){
            $config = getConfig();
            $figura = $this->uklad[$linia][$kolumna];
            if(($figura < 20 && $this->gracz == 2) || ($figura>20 && $this->gracz == 1)) $kl = "figuraMoja"; else $kl = "figuraWroga";
            if($figura != NULL && $figura != "")
                $fig = $figura.",".$kl;
            else
                $fig = "";

            return $fig;
        }

        function pobierzUklad(){
            //baza do zmiany na obj <-------------------- !!!
            $pdo = getDb();
            $pdo = $pdo->getPDO();
            try{
                $z = $pdo->prepare("SELECT uklad, tura FROM gra WHERE GID = 1");
                $z->execute();
                while($baza = $z->fetch()){
                    $uklad = $baza['uklad'];
                }
                $z->closeCursor();
            } catch(PDOException $e){
                $msg = getMsg();
                $msg->add($e);
            }
            $this->uklad = explode("\r\n",$uklad);
            for($i=1;isset($this->uklad[$i]);$i++){
                $this->uklad[$i] = explode(",",$this->uklad[$i]);
            }
        }

        function zwrocUklad(){
            $r = "";
            for($i=0;$i<=8;$i++){
                for($j=0;$j<=8;$j++){
                    if(isset($this->uklad[$i][$j])) 
                        $r .= $this->pokazFigure2($i,$j).".";
                    else
                        $r .= ".";
                }
                $r .= "|";
            }
            echo $r;
        }

        function zapiszRuch(){
            $figura = addslashes(getFromPost("figura"));
            $poleCel = explode("-",addslashes(getFromPost("poleCel")));
            $poleZrodlo = explode("-",addslashes(getFromPost("poleZrodlo")));
            $poleZrodlo = array($poleZrodlo[1],$poleZrodlo[2]);

            $this->sprawdzRuch($figura,$poleCel,$poleZrodlo);

            $this->uklad[$poleZrodlo[0]][$poleZrodlo[1]] = NULL;
            $this->uklad[$poleCel[0]][$poleCel[1]] = $figura;

            $pdo = getDb();
            $pdo = $pdo->getPDO();

            $Nuklad = array();
            for($i=0;isset($this->uklad[$i]);$i++) if($this->uklad[$i] != "") $Nuklad[] = implode(",",$this->uklad[$i]); else $Nuklad[] = "";
            $Nuklad = implode("\r\n",$Nuklad);

            try{
                $z = $pdo->prepare("UPDATE gra SET uklad = :uklad WHERE GID = 1");
                $z->bindParam(":uklad",$Nuklad);
                $z->execute();
            } catch(PDOException $e){
                $msg = getMsg();
                $msg->add($e);
            }

            $this->zwrocUklad();
        }

        function sprawdzRuch($f,$poleCel,$poleZrodlo){
            $blad = false;

            //sprawdzanie istnienia figur
            if(! (($f > 0 && $f < 9) || ($f > 10 && $f < 19) || ($f > 20 && $f < 29) || ($f > 20 && $f < 29) || ($f > 30 && $f < 39))) $blad = true;

            //sprawdzanie swoich figur
            if($this->gracz==1 && $f < 21) $blad = true;
            else if($this->gracz==2 && $f > 18) $blad = true;

            //wieza
            if($f == 11 || $f == 18 || $f == 31 || $f == 38){
                if($poleCel[0] != $poleZrodlo[0] && $poleCel[1] != $poleZrodlo[1]) $blad = true;
                if($poleCel[0] < $poleZrodlo[0]){
                    for($i=$poleCel[0];$i<$poleZrodlo[0];$i++) 
                        if($this->uklad[$i][$poleCel[1]] != "") 
                            if($poleCel[0] != $i) 
                                $blad = true;
                } else if($poleCel[0] > $poleZrodlo[0]){
                    for($i=$poleCel[0];$i>$poleZrodlo[0];$i--) 
                        if($this->uklad[$i][$poleCel[1]] != "") 
                            if($poleCel[0] != $i) 
                                $blad = true;
                } else if($poleCel[1] < $poleZrodlo[1]){
                    for($i=$poleCel[1];$i<$poleZrodlo[1];$i++) 
                        if($this->uklad[$poleCel[0]][$i] != "") 
                            if($poleCel[1] != $i) 
                                $blad = true;
                } else if($poleCel[1] > $poleZrodlo[1]){
                    for($i=$poleCel[1];$i>$poleZrodlo[1];$i--) 
                        if($this->uklad[$poleCel[0]][$i] != "") 
                            if($poleCel[1] != $i) 
                                $blad = true;
                }
            }
            //krol
            if($f == 15 || $f == 35){
                if($poleCel[0] > $poleZrodlo[0]+1) $blad = true;
                if($poleCel[0] < $poleZrodlo[0]-1) $blad = true;
                if($poleCel[1] > $poleZrodlo[1]+1) $blad = true;
                if($poleCel[1] < $poleZrodlo[1]-1) $blad = true;
            }
            //kon
            if($f == 12 || $f == 17 || $f == 32 || $f == 37){
                if($poleCel[0] == $poleZrodlo[0]+1 && $poleCel[1] == $poleZrodlo[1]+2) $blad = true;
            }


            if($blad){
                $this->zwrocUklad();
                exit;
            }
        }

        function wyswietl(){
            $smarty = getSmarty();
            $config = getConfig();

            $smarty->assign('folder', $config->folder);
            $smarty->assign('gracz', $this->gracz);
            $smarty->assign('linia', 8);
            $smarty->assign('kolumna', 8);
            $smarty->assign('this', $this);
            $smarty->assign('litery', $this->litery);

            $smarty->display('game.tpl');
            //include_once("game.view.php");
        }

        function wykonaj(){
            $this->pobierzUklad();
            if(!empty(getFromPost("figura")) && !empty(getFromPost("poleCel")) && !empty(getFromPost("poleZrodlo"))) 
                $this->zapiszRuch();
            else 
                $this->wyswietl();
        }
    }