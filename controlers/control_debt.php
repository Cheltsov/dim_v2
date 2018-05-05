<?php
require_once "../class/user.php";
require_once "../class/cash.php";
require_once "../class/cashmonth.php";
require_once "../class/debt.php";
require_once "../class/tranzaction.php";

$user = new User();
$cash = new Cash();
$cashmonth = new CashMonth();
$debt = new Debt();
$traz = new Tranzaction();

$id_cur_user = $user->getUserId_Cookie();

if(isset($_POST['name_debt_minus']) ){
    $name = $_POST['name_debt_minus'];
    $data = $_POST['data1_debt_minus'];
    $data_end = $_POST['data2_debtend_minus'];
    $type_money = $_POST['type_money_minus'];
    $balance = $_POST['balance_debt_minus'];
    $comment = $_POST['comment_debt_minus'];
    $status = "minus";

    $debt->setDebt($name,$data,$data_end,$type_money ,$balance,$comment,$status, $id_cur_user);
    echo $debt->AddDebt();
}

if(isset($_POST['name_debt_plus']) ){
    $name = $_POST['name_debt_plus'];
    $data = $_POST['data1_debt_plus'];
    $data_end = $_POST['data2_debtend_plus'];
    $type_money = $_POST['type_money_plus'];
    $balance = $_POST['balance_debt_plus'];
    $comment = $_POST['comment_debt_plus'];
    $status = "plus";

    $debt->setDebt($name,$data,$data_end,$type_money,$balance,$comment,$status, $id_cur_user);
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

if(isset($_POST['update_index'])){
    $debt->setUser_Id($id_cur_user);
    $debt->setId($_POST['update_index']);
    $tmp = $debt->getDebtById();
    echo json_encode($tmp);
}

if(isset($_POST['up_name_debt'])){
    $debt->setId($_POST['up_id_debt']);
    $debt->setDebt($_POST['up_name_debt'],$_POST['up_data_start_debt'],$_POST['up_data_end_debt'],$_POST['up_type_money_debt'],$_POST['up_balance_debt'],$_POST['up_comment_debt'],"minus", $id_cur_user);
    $tmp = $debt->UpdateDebt();
    if($tmp) echo("Запись успешно обновлена!");
    else echo("Запись не обновлена...");
}

if(isset($_POST['up_name_debt_minus'])){
    $debt->setId($_POST['up_id_debt_minus']);
    $debt->setDebt($_POST['up_name_debt_minus'],$_POST['up_data_start_debt_minus'],$_POST['up_data_end_debt_minus'],$_POST['up_type_money_debt_minus'],$_POST['up_balance_debt_minus'],$_POST['up_comment_debt_minus'],"plus", $id_cur_user);
    $tmp = $debt->UpdateDebt();
    if($tmp) echo("Запись успешно обновлена!");
    else echo("Запись не обновлена...");
}

if(isset($_POST['getCash'])){
    $cash->setId_User($id_cur_user);
    $tmp = $cash->getListCashFromId_User();
    echo $tmp;
}

if(isset($_POST['getSt'])){
    $tmp = $debt->getStatusById($_POST['id_debt_status']);
    echo $tmp;
}

if(isset($_POST['getDebt'])){
    $debt->setUser_Id($id_cur_user);
    $debt->setId($_POST['id_debt_st']);
    $tmp = $debt->getDebtById();
    echo json_encode($tmp);
}

if(isset($_POST['getEnumTr'])){
    $arr_tmp = array();
    $arr_rez = array();
    $id_tr = $debt->getListEnum($_POST['debt_id']);
    foreach($id_tr as $item){
        $traz->setId($item);
        $traz->setUser_Id($id_cur_user);
        $tmp = $traz->getTranzacionById();
        array_push($arr_rez,$tmp);
    }
    echo(json_encode($arr_rez));
}


if(isset($_POST['add_pay_name_m'])){
    $traz->setUser_Id($id_cur_user);
    $traz->setCash_Tr($_POST['add_pay_cash_m']);
    $traz->setData($_POST['add_pay_data_m']);
    $traz->setStatus("minus");
    $traz->setBalance($_POST['add_pay_sum_m']);
    $traz->setComment($_POST['add_pay_comment_m']);
    $traz->setName($_POST['add_pay_name_m']);
    $tmp1_tr = $traz->AddTranz();

    $cash->setId($traz->getCash_Tr());
    $cash->setBalance($traz->getBalance());
    $tmp2 = $cash->UpdateCash_BalanceMin();

    $cashmonth->setId_Cash($traz->getCash_Tr());
    $cashmonth->setBalance($traz->getBalance());
    $tmp3 = $cashmonth->UpdateCashMonth_BalanceMin();

    $debt->setId($_POST['add_debt_id']);
    $debt->setStatus("minus");
    $tmp_5 = $debt->NewPay($_POST['add_pay_sum_m'],$traz->FindTr());

    if ($tmp1_tr && $tmp2 && $tmp3 && $tmp_5) echo("Транзакция успешно добавлена!");
    else echo("Транзакция не добавлена...");
}

if(isset($_POST['add_pay_name_p'])){

    $traz->setUser_Id($id_cur_user);
    $traz->setCash_Tr($_POST['add_pay_cash_p']);
    $traz->setData($_POST['add_pay_data_p']);
    $traz->setStatus("plus");
    $traz->setBalance($_POST['add_pay_sum_p']);
    $traz->setComment($_POST['add_pay_comment_p']);
    $traz->setName($_POST['add_pay_name_p']);
    $tmp1_tr = $traz->AddTranz();

    $cash->setId($traz->getCash_Tr());
    $cash->setBalance($traz->getBalance());
    $tmp2 = $cash->UpdateCash_BalancePlus();

    $cashmonth->setId_Cash($traz->getCash_Tr());
    $cashmonth->setBalance($traz->getBalance());
    $tmp3 = $cashmonth->UpdateCashMonth_BalancePlus();

    $debt->setId($_POST['add_debt_id']);
    $debt->setStatus("plus");
    $tmp_5 = $debt->NewPay($_POST['add_pay_sum_p'],$traz->FindTr());

    if($tmp1_tr) echo("1 = true");
    if($tmp2) echo("2 = true");
    if($tmp3) echo("3 = true");
    if($tmp_5) echo("5 = true");

    if ($tmp1_tr && $tmp2 && $tmp3 && $tmp_5) echo("Транзакция успешно добавлена!");
    else echo("Транзакция не добавлена...");
}


if(isset($_POST['test_id_id'])){
    print_r($debt->getListEnum(7));
}

if(isset($_POST['id_traz']) && isset($_POST['wanna_update'])){
    if($_POST['id_tr'] != ""){
        $traz->setId($_POST['id_tr']);
        $rez = $traz->getTranzFrom_Id_and_CurMonth();
        echo(json_encode($rez));
    }
}
