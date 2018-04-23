<?php
/**
 * Created by PhpStorm.
 * User: Константин
 * Date: 22.04.2018
 * Time: 16:16
 */

class CashMonth
{
    private $id;
    private $id_cash;
    private $id_user;
    private $name;
    private $type_money;
    private $type_cash;
    private $balance;

    public function setId($id){
        $this->id = $id;
    }
    public function getId(){
        return $this->id;
    }

    public function setId_Cash($id_cash){
        $this->id_cash = $id_cash;
    }
    public function getId_Cash(){
        return $this->id_cash;
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

    public function AddCashMonth(){ //createCashMonth
        try{
            $cash = R::findAll("cash","iduser = $this->id_user and name = '$this->name' and type_money = $this->type_money and type_cash = $this->type_cash");
            foreach($cash as $item){
                $tmp_id_cash = $item->id;
            }
            $cash_month = R::dispense("cashmonth");
            $cash_month->id_cash = $tmp_id_cash;
            $cash_month->id_user = $this->id_user ;
            $cash_month->name = $this->name;
            $cash_month->type_money = $this->type_money;
            $cash_month->type_cash = $this->type_cash;
            $cash_month->balance = $this->balance;
            R::store($cash_month);
            return true;
        }
        catch(Exception $e){
            echo($e);
        }
        R::close();
    }

    public function getCashMonth_FromId_User(){ //getCashMonth
        try{
            $arr_cash = array();
            $cash_month = R::findAll('cashmonth', "id_user = $this->id_user");
            foreach($cash_month as $item){
                array_push($arr_cash,$item->id,$item->name,$item->type_money,$item->type_cash, $item->balance);
            }
            echo(json_encode($arr_cash));
            R::close();
        }
        catch(Exception $e){
            echo $e;
        }
    }

    public function getCashMonth_FromCash(){ //getIdCashMonth
        try{
            $arr_tmp = array();
            $cash = R::find('cashmonth',"id_cash = $this->id_cash");
            foreach($cash as $item){
                $us = R::findAll('users',"id = $item->id_user");
                foreach($us as $tmp_us){
                    $us_name = $tmp_us->login;
                }
                array_push($arr_tmp,$item->id,$item->id_cash,$us_name,$item->name,$item->type_money,$item->type_cash,$item->balance);
            }
        }
        catch(Exception $e){
            echo $e;
        }
        R::close();
        return $arr_tmp;
    }

   /* public function delCash_FromId(){ //delCash
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
    }*/

    public function getCashMonthID_from_Cash(){ //findCashMonthID_from_Cash
        $id_cashmonth = 0;
        $cash_month = R::find("cashmonth","id_cash = '$this->id_cash'");
        foreach($cash_month as $item){
            $id_cashmonth = $item->id;
        }
        return $id_cashmonth;
        R::close();
    }

    public function UpdateCashMonth_Balance(){ //updateBalanceCashMonth
        try{
            $cash_month = R::load('cashmonth', $this->id);
            $cash_month->balance = $this->balance;
            R::store($cash_month);
            return true;
        }
        catch(Exception $e){
            echo($e);
        }
        R::close();
    }

    public function UpdateCashMonth_BalanceMin(){
        $id = $this->getCashMonthID_from_Cash();
        $cashmonth = R::load("cashmonth", $id);
        $cashmonth->balance -= $this->balance;
        R::store($cashmonth);
        return true;
    }

    public function UpdateCashMonth_BalancePlus(){
        $id = $this->getCashMonthID_from_Cash();
        $cashmonth = R::load("cashmonth", $id);
        $cashmonth->balance += $this->balance;
        R::store($cashmonth);
        return true;
    }




}