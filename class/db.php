<?php
if(!isset($_SESSION)){
    session_start();
}

require '../config/config_connect_DB.php';
require 'libs/rb.php';
require_once 'LineChart.php';
require_once "../controlers/getCourse.php";


class Datebase
{

    function __construct(){
        if(! R::testConnection()){
            R::setup('mysql:host='.HOST.'; dbname='.DBNAME.'; charset=utf8', ADMIN, PASS);
        }
        if(! R::testConnection()){
            exit("Подключение к базе не установлено!");
        }
    }

    function Connection(){
        if(! R::testConnection()){
            R::setup('mysql:host='.HOST.'; dbname='.DBNAME.'; charset=utf8', ADMIN, PASS);
        }
        if(! R::testConnection()){
            exit("Подключение к базе не установлено!");
        }
    }

    function delUser($id_user){
        $f1 = R::getAll("delete from cash where iduser = $id_user");
        $f2 = R::getAll("delete from cashmonth where id_user = $id_user");
        $f3 = R::getAll("delete from debt where user_id = $id_user");
        $f4 = R::getAll("delete from translate where id_user = $id_user");
        $f5 = R::getAll("delete from tranzaction where User_id = $id_user");
        $f6 = R::getAll("delete from users where id = $id_user");
        if($f1 && $f2 && $f3 && $f4 && $f5 && $f6){
            return true;
        }
        else return false;
    }

    function delUserByProg($id_user){
        $f1 = R::getAll("delete from cash where iduser = $id_user");
        $f2 = R::getAll("delete from cashmonth where id_user = $id_user");
        $f3 = R::getAll("delete from debt where user_id = $id_user");
        $f4 = R::getAll("delete from translate where id_user = $id_user");
        $f5 = R::getAll("delete from tranzaction where User_id = $id_user");
        if($f1 && $f2 && $f3 && $f4 && $f5){
            return true;
        }
        else return false;
    }

    //Пропустил
    function getCashNEW($id_user){

            $arr_cash = array();
            $cash = R::find('cash',"iduser = $id_user");
             foreach($cash as $item){
                  array_push($arr_cash,$item->name,$item->type_money, $item->type_cash,$item->balance,$item->comment,$item->iduser,$item->id);
             }
            R::close();
            return $arr_cash;
    }
    function getCashNEWDouble($id_user){

        $arr_cash = array();
        $cash = R::find('cash',"iduser = $id_user");
        foreach($cash as $item){
            array_push($arr_cash,$item->name,$item->type_money, $item->type_cash,$item->balance,$item->comment,$item->id_user,$item->id);
        }
        echo(json_encode($arr_cash));
        R::close();
    }

}



?>