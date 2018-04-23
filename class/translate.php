<?php
/**
 * Created by PhpStorm.
 * User: Константин
 * Date: 22.04.2018
 * Time: 20:16
 */

class Translate extends Datebase
{
    private $id;
    private $name;
    private $data;
    private $id_cash;
    private $cash_min;
    private $balance_min;
    private $course;
    private $cash_sum;
    private $balance_sum;
    private $comment;
    private $user_id;

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

    public function setId_Cash($id_cash){
        $this->id_cash = $id_cash;
    }
    public function getId_Cash(){
        return $this->id_cash;
    }

    public function setCash_Min($cash_min){
        $this->cash_min = $cash_min;
    }
    public function getCash_Min(){
        return $this->cash_min;
    }

    public function setBalance_Min($balance_min){
        $this->balance_min = $balance_min;
    }
    public function getBalance_Min(){
        return $this->balance_min;
    }

    public function setCourse($course){
        $this->course = $course;
    }
    public function getCourse(){
        return $this->course;
    }

    public function setCash_Sum($cash_sum){
        $this->cash_sum = $cash_sum;
    }
    public function getCash_Sum(){
        return $this->cash_sum;
    }

    public function setBalance_Sum($balance_sum){
        $this->balance_sum = $balance_sum;
    }
    public function getBalance_Sum(){
        return $this->balance_sum;
    }

    public function setComment($comment){
        $this->comment = $comment;
    }
    public function getComment(){
        return $this->comment;
    }

    public function setId_User($id_user){
        $this->id_user = $id_user;
    }
    public function getId_User(){
        return $this->id_user;
    }

    public function AddTrans(){
        try{
            $trans = R::dispense('translate');
            $trans->name = $this->name;
            if(!isset($this->data)) $trans->data = R::isoDateTime();
            else $trans->data = $this->data;
            $trans->cash_min = $this->cash_min;
            $trans->balance_min = $this->balance_min;
            $trans->course = $this->course;
            $trans->cash_sum = $this->cash_sum;
            $trans->balance_sum = $this->balance_sum;
            $trans->comment = $this->comment;
            $trans->id_user = $this->id_user;
            R::store($trans);
            return 1;
        }
        catch(Exception $e){
            echo($e);
        }
        R::close();
    }

    public function getTrans(){
        $arr_tmp = array();
        $name_cash_min="";
        $name_cash_sum="";
        $trans = R::findAll('translate', "id_user = $this->id_user");
        foreach($trans as $item){
            $cash1 = R::findAll('cash',"id = $item->cash_min");
            foreach($cash1 as $tmp1){
                $name_cash_min = $tmp1->name;
            }
            $cash2 = R::findAll('cash',"id = $item->cash_sum");
            foreach($cash2 as $tmp2){
                $name_cash_sum = $tmp2->name;
            }
            $us = R::findAll('users',"id = $item->id_user");
            foreach($us as $tmp_us){
                $us_name = $tmp_us->login;
            }
            array_push($arr_tmp,$item->id,$item->name,$item->data,$name_cash_min,$item->balance_min,$name_cash_sum,$item->balance_sum,$item->comment,$us_name);
            $name_cash_sum="";
            $name_cash_min="";
        }
        echo(json_encode($arr_tmp));
        R::close();
    }

    public function getTransFromData(){ //getTranslateFromData
        $arr_tmp = array();
        $name_cash_min="";
        $name_cash_sum="";
        $trans = R::findAll('translate', "id_user = $this->id_user and date(data) = '$this->data'");
        foreach($trans as $item){
            $cash1 = R::findAll('cash',"id = $item->cash_min");
            foreach($cash1 as $tmp1){
                $name_cash_min = $tmp1->name;
            }
            $cash2 = R::findAll('cash',"id = $item->cash_sum");
            foreach($cash2 as $tmp2){
                $name_cash_sum = $tmp2->name;
            }
            $us = R::findAll('users',"id = $item->id_user");
            foreach($us as $tmp_us){
                $us_name = $tmp_us->login;
            }
            array_push($arr_tmp,$item->id,$item->name,$item->data,$name_cash_min,$item->balance_min,$name_cash_sum,$item->balance_sum,$item->comment,$us_name);
            $name_cash_sum="";
            $name_cash_min="";
        }
        echo(json_encode($arr_tmp));
        R::close();
    }

    public function getTransFromDataRange($data1,$data2){ //getTranslateFromDataRange
        $arr_tmp = array();
        $name_cash_min="";
        $name_cash_sum="";
        $trans = R::findAll('translate', "id_user = $this->id_user and date(data) >= '$data1' and date(data) <= '$data2'");
        foreach($trans as $item){
            $cash1 = R::findAll('cash',"id = $item->cash_min");
            foreach($cash1 as $tmp1){
                $name_cash_min = $tmp1->name;
            }
            $cash2 = R::findAll('cash',"id = $item->cash_sum");
            foreach($cash2 as $tmp2){
                $name_cash_sum = $tmp2->name;
            }
            $us = R::findAll('users',"id = $item->id_user");
            foreach($us as $tmp_us){
                $us_name = $tmp_us->login;
            }
            array_push($arr_tmp,$item->id,$item->name,$item->data,$name_cash_min,$item->balance_min,$name_cash_sum,$item->balance_sum,$item->comment,$us_name);
            $name_cash_sum="";
            $name_cash_min="";
        }
        echo(json_encode($arr_tmp));
        R::close();
    }


    public function getTransFromId_User_Id_Cash(){ //getTranslate_fromID
        $arr_tmp = array();
        $name_cash_min="";
        $name_cash_sum="";
        $trans = R::findAll('translate', "id_user = $this->id_user and cash_min = $this->id_cash or cash_sum = $this->id_cash");
        foreach($trans as $item){
            $cash1 = R::findAll('cash',"id = $item->cash_min");
            foreach($cash1 as $tmp1){
                $name_cash_min = $tmp1->name;
            }
            $cash2 = R::findAll('cash',"id = $item->cash_sum");
            foreach($cash2 as $tmp2){
                $name_cash_sum = $tmp2->name;
            }
            $us = R::findAll('users',"id = $item->id_user");
            foreach($us as $tmp_us){
                $us_name = $tmp_us->login;
            }
            array_push($arr_tmp,$item->id,$item->name,$item->data,$name_cash_min,$item->balance_min,$name_cash_sum,$item->balance_sum,$item->comment,$us_name);
            $name_cash_sum="";
            $name_cash_min="";
        }
        echo(json_encode($arr_tmp));
        R::close();
    }

    public function getTransFromId(){   //getTranslateFromID
        $now_month = date("m");

        $arr_tmp = array();
        $trans = R::findAll('translate', "id = $this->id");
        foreach($trans as $item){
            $up_data_month = date("m", strtotime($item->data));
            if ($up_data_month < $now_month) {
                $flag = Array();
                return $flag;
            }
            else{
                array_push($arr_tmp,$item->id,$item->name,$item->data,$item->cash_min,$item->balance_min,$item->cash_sum,$item->balance_sum,$item->comment,$item->id_user,$item->course);
            }
        }
        R::close();
        return $arr_tmp;
    }

    public function UpdateTrans(){ //upDate_trans
        try{
            $trans = R::load('translate', $this->id);
            $trans->name = $this->name;
            $trans->data = $this->data;
            $trans->cash_min = $this->cash_min;
            $trans->balance_min = $this->balance_min;
            $trans->course = $this->course;
            $trans->cash_sum = $this->cash_sum;
            $trans->balance_sum = $this->balance_sum;
            $trans->comment = $this->comment;
            R::store($trans);
            return true;
        }
        catch(Exception $e){
            echo($e);
        }
        R::close();
    }

    public function DelTrans(){
        try{
            $trans = R::load('translate', $this->id);
            R::trash($trans);
            return true;
        }
        catch(Excetpion $e){
            echo($e);
        }
        R::close();
    }

}
