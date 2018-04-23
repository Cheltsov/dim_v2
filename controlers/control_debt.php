<?php
require_once "../class/db.php";
//require_once 'getCourse.php';

$con = new Datebase();
$con->Connection();

//$course = getCourse();

$id_cur_user = $con->findIdUser();

if(isset($_POST['name_debt_minus']) ){
    $name = $_POST['name_debt_minus'];
    $data = $_POST['data1_debt_minus'];
    $data_end = $_POST['data2_debtend_minus'];
    $cash_id = $_POST['cash_debt_minus'];
    $balance = $_POST['balance_debt_minus'];
    $comment = $_POST['comment_debt_minus'];
    $status = "minus";

    $con->addDebt($name,$data,$data_end,$cash_id,$balance,$comment,$status, $id_cur_user);
}

if(isset($_POST['name_debt_plus']) ){
    $name = $_POST['name_debt_plus'];
    $data = $_POST['data1_debt_plus'];
    $data_end = $_POST['data2_debtend_plus'];
    $cash_id = $_POST['cash_debt_plus'];
    $balance = $_POST['balance_debt_plus'];
    $comment = $_POST['comment_debt_plus'];
    $status = "plus";

    $con->addDebt($name,$data,$data_end,$cash_id,$balance,$comment,$status, $id_cur_user);
}

if(isset($_POST['wanna_get_debts_minus'])){
    $arr_debts = $con->getDebtsMinus($id_cur_user);
    echo(json_encode($arr_debts));
}
if(isset($_POST['wanna_get_debts_plus'])){
    $arr_debts = $con->getDebtsPlus($id_cur_user);
    echo(json_encode($arr_debts));
}