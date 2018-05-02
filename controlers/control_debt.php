<?php
require_once "../class/user.php";
require_once "../class/debt.php";

$user = new User();
$debt = new Debt();

$id_cur_user = $user->getUserId_Cookie();

if(isset($_POST['name_debt_minus']) ){
    $name = $_POST['name_debt_minus'];
    $data = $_POST['data1_debt_minus'];
    $data_end = $_POST['data2_debtend_minus'];
    $cash_id = $_POST['cash_debt_minus'];
    $balance = $_POST['balance_debt_minus'];
    $comment = $_POST['comment_debt_minus'];
    $status = "minus";

    $debt->setDebt($name,$data,$data_end,$cash_id,$balance,$comment,$status, $id_cur_user);
    $debt->AddDebt();
}

if(isset($_POST['name_debt_plus']) ){
    $name = $_POST['name_debt_plus'];
    $data = $_POST['data1_debt_plus'];
    $data_end = $_POST['data2_debtend_plus'];
    $cash_id = $_POST['cash_debt_plus'];
    $balance = $_POST['balance_debt_plus'];
    $comment = $_POST['comment_debt_plus'];
    $status = "plus";

    $debt->setDebt($name,$data,$data_end,$cash_id,$balance,$comment,$status, $id_cur_user);
    $tmp = $debt->AddDebt();
    if($tmp) echo("Запись успешно добавлена!");
    else echo("Запись не добавлена...");
}

if(isset($_POST['wanna_get_debts_minus'])){
    $debt->setStatus('minus');
    $debt->setUser_Id($id_cur_user);
    $arr_debts = $debt->getDebts();
    echo(json_encode($arr_debts));
}
if(isset($_POST['wanna_get_debts_plus'])){
    $debt->setStatus('plus');
    $debt->setUser_Id($id_cur_user);
    $arr_debts = $debt->getDebts();
    echo(json_encode($arr_debts));
}

if(isset($_POST['del_trans']) && isset($_POST['index_debt'])){
    $debt->setId($_POST['index_debt']);
    $tmp = $debt->DelDebt();
    if($tmp) echo("Запись успешно удалена!");
    else echo("Запись не удалена...");
}