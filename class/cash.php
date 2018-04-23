<?php
/**
 * Created by PhpStorm.
 * User: Константин
 * Date: 21.04.2018
 * Time: 19:18
 */
require_once "db.php";

class Cash extends Datebase
{
    private $id;
    private $id_user;
    private $name;
    private $type_money;
    private $num_card;
    private $type_cash;
    private $balance;
    private $comment;
    private $date_create;
    private $date_update;

    public function setId($id){
        $this->id = $id;
    }
    public function getId(){
        return $this->id;
    }

    public function setId_User($id_user){
        $this->id_user = $id_user;
    }
    public function getId_User(){
        return $this->id_user;
    }

    public function setName($name){
        $this->name = $name;
    }
    public function getName(){
        return $this->name;
    }

    public function setType_Money($type_money){
        $this->type_money = $type_money;
    }
    public function getType_Money(){
        return $this->type_money;
    }

    public function setType_Cash($type_cash){
        $this->type_cash = $type_cash;
    }
    public function getType_Cash(){
        return $this->type_cash;
    }

    public function setBalance($balance){
        $this->balance = $balance;
    }
    public function getBalance(){
        return $this->balance;
    }
    public function setComment($comment){
        $this->comment = $comment;
    }
    public function getComment(){
        return $this->comment;
    }

    public function setNum_Card($num_card){
        $this->num_card = $num_card;
    }
    public function getNum_Card(){
        return $this->num_card;
    }

    public function setDate_Update($date_update){
        $this->date_update = $date_update;
    }
    public function getDate_Update(){
        return $this->date_update;
    }

    public function setDate_Create($date_create){
        $this->date_create = $date_create;
    }
    public function getDate_Create(){
        return $this->date_create;
    }


    public function Create_Cash(){ //Create_Cop and Insert_Cash
        try{
            $cash = R::dispense("cash");
            $cash->iduser = $this->id_user;
            $cash->name = $this->name;
            $cash->type_money = $this->type_money;
            $cash->num_card = $this->num_card;
            $cash->type_cash = $this->type_cash;
            $cash->balance = $this->balance;
            $cash->comment = $this->comment;
            $cash->date_create = R::isoDateTime();
            $cash->date_update = R::isoDateTime();
            R::store($cash);
            return 1;
        }
        catch(Exception $e){
            echo $e;
        }
        R::close();
    }

    public function getListCashFromId_User(){ //getCashList($id_user)
        try{
            $arr_cash = array();
            $cash = R::find('cash',"iduser = '$this->id_user'");
            foreach($cash as $item){
                array_push($arr_cash,$item->id,$item->id_user,$item->name,$item->type_money,$item->type_cash,$item->balance, $item->comment, $item->data_create, $item->data_update, $item->num_card);

            }
            echo (json_encode($arr_cash));
        }
        catch(Exception $e){
            echo $e;
        }
        R::close();
    }

    public function getCashFromId(){ // getIdCash($id_cash)
        try{
            $arr_tmp = array();
            $cash = R::find('cash',"id = $this->id");
            foreach($cash as $item){
                $us = R::findAll('users',"id = $item->iduser");
                foreach($us as $tmp_us){
                    $us_name = $tmp_us->login;
                }
                array_push($arr_tmp,$item->id,$us_name,$item->name,$item->type_money,$item->type_cash,$item->balance,$item->comment, $item->date_create,$item->date_update, $item->num_card);
            }
        }
        catch(Exception $e){
            echo $e;
        }
        R::close();
        return $arr_tmp;
    }

    public function delCashFromId(){ // delCash($idCash)
        try{
            $cash = R::load("cash", $this->id);
            echo($cash->name);
            R::trash($cash);
            return true;
        }
        catch(Exception $e){
            echo($e);
        }
        R::close();
    }

    public function UpdateCash(){ // updataCash()
        try{
            $cash = R::load("cash", $this->id);
            $cash->name = $this->name;
            $cash->type_money = $this->type_money;
            $cash->type_cash = $this->type_cash;
            $cash->balance = $this->balance;
            $cash->comment = $this->comment;
            $cash->num_card = $this->num_card;
            $cash->date_update = R::isoDateTime();
            R::store($cash);
            return true;
        }
        catch(Exception $e){
            echo($e);
        }
        R::close();
    }

    public function getType_MoneyInDB(){  // getCourseCashInDB
        $cash = R::findAll('cash',"id = $this->id");
        foreach($cash as $item){
            return $item->type_money;
        }
        R::close();
    }

    public function UpdateCash_BalanceMin(){
        $cash = R::load("cash", $this->id);
        $cash->balance -= $this->balance;
        R::store($cash);
        return true;
    }
    public function UpdateCash_BalancePlus(){
        $cash = R::load("cash", $this->id);
        $cash->balance += $this->balance;
        R::store($cash);
        return true;

    }

    function getBalance_FromId_Cash($id_cash){ //whatBalance
        $cash = R::findAll('cash',"id = $this->id");
        foreach($cash as $item){
            $balance = $item->balance;
        }
        return $balance;
        R::close();
    }

    function UpdataBalance(){ //updateBalanceCash
        try{
            $cash = R::load('cash', $this->id);
            $cash->balance = $this->balance;
            R::store($cash);
        }
        catch(Exception $e){
            echo($e);
        }
        R::close();
    }


}