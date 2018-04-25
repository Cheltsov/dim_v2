<?php
/**
 * Created by PhpStorm.
 * User: Константин
 * Date: 06.03.2018
 * Time: 1:31
 */

class LineChart
{
    public $name;
    public $date;
    public $balance;
    public $type_money;

    function  __construct( $date, $balance,$name){
        $this->date=$date;
        $this->balance=$balance;
        $this->name = $name;
    }

    function  setLineChart($date, $balance,$name, $type_money){
        $this->date=$date;
        $this->balance=$balance;
        $this->balance=$name;
        $this->balance=$type_money;
    }


    public function setData($data){
        $this->data = $data;
    }
    public function getData(){
        return $this->data;
    }
    public function setBalance($balance){
        $this->balance = $balance;
    }
    public function getBalance(){
        return $this->balance;
    }
    public function setType_Money($type_money){
        $this->type_money = $type_money;
    }
    public function getType_Money(){
        return $this->type_money;
    }


}