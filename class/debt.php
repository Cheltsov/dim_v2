<?php
/**
 * Created by PhpStorm.
 * User: Константин
 * Date: 02.05.2018
 * Time: 15:43
 */
require_once "db.php";

class Debt extends Datebase{
    private $id;
    private $name;
    private $data;
    private $data_end;
    private $type_money;
    private $balance;
    private $comment;
    private $status;
    private $user_id;
    private $pay;

    public function setDebt($name,$data,$data_end,$type_money,$balance,$comment,$status,$user_id){
        $this->name = $name;
        $this->data = $data;
        $this->data_end = $data_end;
        $this->type_money = $type_money;
        $this->balance = $balance;
        $this->comment = $comment;
        $this->status = $status;
        $this->user_id = $user_id;
    }

    public function setId($id){
        $this->id = $id;
    }
    public function getId(){
        return $this->id;
    }

    public function setName($name){
        $this->name = $name;
    }
    public function getName(){
        return $this->name;
    }

    public function setData($data){
        $this->data = $data;
    }
    public function getData(){
        return $this->data;
    }

    public function setData_End($data_end){
        $this->data_end = $data_end;
    }
    public function getData_End(){
        return $this->data_end;
    }

    public function setType_Money($type_money){
        $this->type_money = $type_money;
    }
    public function getType_Money(){
        return $this->type_money;
    }

    public function setBalance($balance){
        $this->balance = $balance;
    }
    public function getBalance(){
        return $this->balance;
    }

    public function setPay($pay){
        $this->pay = $pay;
    }
    public function getPay(){
        return $this->pay;
    }

    public function setComment($comment){
        $this->comment = $comment;
    }
    public function getComment(){
        return $this->comment;
    }

    public function setUser_Id($user_id){
        $this->user_id = $user_id;
    }
    public function getUser_Id(){
        return $this->user_id;
    }

    public function setStatus($status){
        $this->status = $status;
    }
    public function getStatus(){
        return $this->status;
    }

    public function getDebts(){
        $arr_tmp = array();
        try{
            $debts = R::findAll("debt", "user_id = $this->user_id");
            foreach($debts as $item){
                if($item->status == $this->status){
                    array_push($arr_tmp, $item->id, $item->name, $item->data, $item->data_end, $item->type_money, $item->balance, $item->pay ,$item->comment,$item->user_id);
                }
            }
            return $arr_tmp;
        }
        catch(Exception $e){
            echo($e);
        }
    }

    public function AddDebt(){
        try{
            $debt = R::dispense("debt");
            $debt->name = $this->name;
            $debt->data = $this->data;
            $debt->data_end = $this->data_end;
            $debt->type_money = $this->type_money;
            $debt->balance = $this->balance;
            $debt->pay = 0;
            $debt->comment = $this->comment;
            $debt->status = $this->status;
            $debt->user_id = $this->user_id;
            $debt->tr = "";
            R::store($debt);
            return true;
        }
        catch(Exception $e){
            echo("Ошибка при добавлении... "+$e);
        }
        R::close();
    }

    public function DelDebt(){
        try{
            $debt = R::load("debt",$this->id);
            R::trash($debt);
            return true;
        }
        catch(Exception $e){
            echo($e);
        }
        R::close();
    }

    public function getStatusById($id){
        try{
            $debt = R::find("debt","id = $id");
            foreach($debt as $item){
                return $item['status'];
            }
        }
        catch(Exception $e){
            echo($e);
        }
        R::close();
    }

    public function getDebtById(){
        try{
            $arr_tmp = array();
            $debt = R::find('debt',"id=$this->id and user_id = $this->user_id");
            foreach($debt as $item){
                array_push($arr_tmp, $item->id, $item->name, $item->data, $item->data_end, $item->type_money, $item->balance, $item->pay ,$item->comment,$item->user_id, $item->status);
            }
            return $arr_tmp;
        }
        catch(Exception $e){
            echo($e);
        }
        R::close();
    }

    public function UpdateDebt(){
        try{
            $debt = R::load('debt',$this->id);
            $debt->name = $this->name;
            $debt->data = $this->data;
            $debt->data_end = $this->data_end;
            $debt->type_money = $this->type_money;
            $debt->balance = $this->balance;
            $debt->comment = $this->comment;
            R::store($debt);
            return true;
        }
        catch(Exception $e){
            echo($e);
        }
        R::close();
    }

    public function NewPay($bal,$tr){
        try{
            $debt = R::load("debt",$this->id);
            if($this->status == "plus"){
                $debt->pay += $bal;
                //$debt->balance -= $bal;
            }
            if($this->status == "minus"){
                $debt->pay += $bal;
               // $debt->balance -= $bal;
            }
            $debt->td_ids .= ",".$tr;
            R::store($debt);
            return true;
        }
        catch(Exception $e){
            echo($e);
        }
        R::close();
    }

    public function getListEnum($id){
        $arr_tr_id = Array();
        $arr_rez = Array();
        $test = R::find( 'debt', "id = $id");
        foreach($test as $item){
            $str_tr_id = $item['td_ids'];
        }
        $arr_tr_id = explode(",",$str_tr_id);
        for($i=1;$i<count($arr_tr_id);$i++){
            array_push($arr_rez,$arr_tr_id[$i]);
        }
        return $arr_rez;
        R::close();
    }

    public function getDebtPayById(){
        $debt = R::find("debt",$this->id);
        foreach($debt as $item){
            return $item->pay;
        }
        R::close();
    }

    public function UpdateDebtPayMinus(){
        $debt = R::load("debt",$this->id);
        $debt->pay -= $this->pay;
        R::store($debt);
        R::close();
        return true;
    }

    public function UpdateDebtPayPlus(){

        $debt = R::load("debt",$this->id);
        $debt->pay += $this->pay;
        R::store($debt);
        R::close();
        return true;
    }

    public function delEnum($id_tr){
        try{
            $arr_enum = array();
            $debt = R::find("debt","id = $this->id");
            foreach($debt as $item){
                $enum = $item->td_ids;
            }
            $arr_enum = explode(",",$enum);
            for($i=0;$i<count($arr_enum);$i++){
                if($arr_enum[$i] == $id_tr){
                    unset($arr_enum[$i]);
                    sort($arr_enum);
                }
            }
            $str = implode(",", $arr_enum);

            $debt_load = R::load("debt",$this->id);
            $debt_load->td_ids = $str;
            R::store($debt_load);
            return true;
        }
        catch(Exception $e){
            echo($e);
        }
        R::close();
    }

}