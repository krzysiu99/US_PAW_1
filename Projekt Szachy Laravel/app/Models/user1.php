<?php
/*                    Projekt Szachy Online                        */
/*  Języki Programowania Dynamicznych Stron Internetowych          */
/*                     Krzysztof Niestrój                          */
/*              krzysztof.niestroj@o365.us.edu.pl                  */
/*                     Framework Laravel                           */
/*                         10.05.2021                              */

namespace App\Models;
use Illuminate\Support\Facades\DB;

class user1 {
    public $user;
    public $login;
    private $zaproszenia = array();
    private $wygrane;
    private $ostGra;

    function __construct(){
        if(session_status() == PHP_SESSION_NONE) session_start();
        $this->user = isset($_SESSION['user']) ? $_SESSION['user'] : NULL; //spr czy jest się zalogowanym



        $id = (int)$this->user;

        $gracz = DB::table('gracz')->where('UID', $id)->get();
        foreach($gracz as $e){
            $this->login = $e->login;
            $this->wygrane = $e->wygrane;
            $this->ostGra = $e->ostatnia_gra;
            break;
        }

        //lista zaproszeń do gry
        $zapr = DB::table('zaproszenie')->where('zaproszony', $id)->get();
        foreach($zapr as $e){
            $this->zaproszenia[] = $e->zapraszajacy;
        }
        
    }
    function getLogin(){
        return $this->login;
    }
    function getUID(){
        return $this->user;
    }
    function getZaproszenia(){
        if($this->zaproszenia == "") 
            return NULL;
        else 
            return $this->zaproszenia;
    }
    function nick($id){ //zwraca nick gracza o podanym id
        $gracz = DB::table('gracz')->where('UID', $id)->get();
        $nick = null;
        foreach($gracz as $e){
            $nick = $e->login;
            break;
        }
        return $nick;
    }
    function czyOnline($id){ //spr czy wybrany gracz jest online
        $id = (int) $id;
        $gracz = DB::table("gracz as t1")->leftJoin("gra as t2", function ($join) {
            $join->on('t2.graczCzarne','t1.UID')
            ->orOn('t2.graczBiale','t1.UID')
            ->where('t2.graczCzarne', NULL)
            ->orWhere('t2.graczBiale', NULL);
        })->select(DB::raw('t1.login as login, t1.UID as UID, t1.wygrane as wygrane, t1.ostatnio_online as ostatnio_online'))->get();
        foreach($gracz as $e){
            if($e->UID == $id){
                if(strtotime($e->ostatnio_online) > strtotime(date("Y-m-d H:i:s"))-15) 
                    return true;
                else 
                    return false;
            }
        }
    }
    function wygrane($id){ //ile wygranych ma gracz o podanym id
        $gracz = DB::table('gracz')->where('UID', $id)->get();
        $wygrane = 0;
        foreach($gracz as $e){
            $wygrane = $e->wygrane;
            break;
        }
        return $wygrane;
    }
    function getWygrane(){
        return $this->wygrane;
    }
    function getOstGra(){
        return $this->ostGra;
    }
}