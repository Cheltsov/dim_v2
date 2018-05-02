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
    private $cash_id;
    private $balance;
    private $comment;
    private $status;
    private $user_id;

    public function setDebt($name,$data,$data_end,$cash_id,$balance,$comment,$status,$user_id){
        $this->name = $name;
        $this->data = $data;
        $this->data_end = $data_end;
        $this->cash_id = $cash_id;
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

    public function setCash_Id($cash_id){
        $this->cash_id = $cash_id;
    }
    public function getCash_Id(){
        return $this->cash_id;
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
                    array_push($arr_tmp, $item->id, $item->name, $item->data, $item->data_end, $item->cash_id, $item->balance, $item->comment,$item->user_id);
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
            $debt->cash_id = $this->cash_id;
            $debt->balance= $this->balance;
            $debt->comment = $this->comment;
            $debt->status = $this->status;
            $debt->user_id = $this->user_id;
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

}