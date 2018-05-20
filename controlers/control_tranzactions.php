<?php
require_once "../class/db.php";
require_once 'getCourse.php';
require_once "../class/user.php";
require_once "../class/cash.php";
require_once "../class/cashmonth.php";
require_once "../class/tranzaction.php";
require_once "../class/translate.php";

$con = new Datebase();

$cash = new Cash();
$cashmonth = new CashMonth();
$traz = new Tranzaction();
$tras = new Translate();

$user = new User();
$id_cur_user = $user->getUserId_Cookie();

$temp = $con->getCash($id_cur_user);

function Del_cookie(){

}

if(isset($_POST['wanna_info_cash'])){
    $cash->setId_User($id_cur_user);
    $cash->getListCashFromId_User();
}

if(isset($_POST['wanna_cash_month'])){
    $cashmonth->setId_User($id_cur_user);
    $cashmonth->getCashMonth_FromId_User();
}

function getTempCash(){
    return $GLOBALS['temp'];
}

if(isset($_POST['want_id_cash'])){
    $cash->setId_User($id_cur_user);
    $cash->getListCashFromId_User();
}

if(isset($_POST['name_trMin']) && isset($_POST['cash_trMin']) && isset($_POST['balance_trMin']) && isset($_POST['comment_trMin'])){
    AddTr($traz,$cashmonth,$cash,$id_cur_user);
}

function AddTr($traz,$cashmonth,$cash,$id_cur_user){
    $traz->setName($_POST['name_trMin']);
    $traz->setCash_Tr($_POST['cash_trMin']);
    $traz->setBalance($_POST['balance_trMin']);
    $traz->setComment($_POST['comment_trMin']);
    $traz->setUser_Id($id_cur_user);
    $traz->setData($_POST['data_trMin']);
    $traz->setStatus("minus");
    $tmp1 = $traz->AddTranz();

    $cash->setId($traz->getCash_Tr());
    $cash->setBalance($traz->getBalance());
    $tmp2 = $cash->UpdateCash_BalanceMin();

    $cashmonth->setId_Cash($traz->getCash_Tr());
    $cashmonth->setBalance($traz->getBalance());
    $tmp3 = $cashmonth->UpdateCashMonth_BalanceMin();

    if($tmp1 && $tmp3 && $tmp2 ) echo 1;
    else echo 0;
}

if(isset($_POST['name_trSum']) && isset($_POST['cash_trSum']) && isset($_POST['balance_trSum']) && isset($_POST['comment_trSum'])){
    $traz->setName($_POST['name_trSum']);
    $traz->setCash_Tr($_POST['cash_trSum']);
    $traz->setBalance($_POST['balance_trSum']);
    $traz->setComment($_POST['comment_trSum']);
    $traz->setUser_Id($id_cur_user);
    $traz->setData($_POST['data_trSum']);
    $traz->setStatus("plus");
    $tmp1 = $traz->AddTranz();

    $cash->setId($traz->getCash_Tr());
    $cash->setBalance($traz->getBalance());
    $tmp2 = $cash->UpdateCash_BalancePlus();

    $cashmonth->setId_Cash($traz->getCash_Tr());
    $cashmonth->setBalance($traz->getBalance());
    $tmp3 = $cashmonth->UpdateCashMonth_BalancePlus();

    if($tmp1 && $tmp3 && $tmp2 ) echo 1;
    else echo 0;
}
/*
if(isset($_POST['tmper'])){
    $id_cur_user = $con->findIdUser();
    $con->getTranz($id_cur_user);
}*/

if(isset($_POST['del_tr']) && isset($_POST['id_tr'])){
    $traz->setId($_POST['id_tr']);
    $arr_tmp = $traz->getTranzFrom_Id_and_CurMonth();

    if($arr_tmp != Array()){
        $cash->setId($arr_tmp[2]);
        $cash_tr = $cash->getCashFromId();

        $cashmonth->setId_Cash($arr_tmp[2]);
        $cashmonth_tr = $cashmonth->getCashMonth_FromCash();

        if($arr_tmp[7] == "minus"){
            $new_bal = $cash_tr[5] + $arr_tmp[3];
            $new_bal_month = $cashmonth_tr[6] + $arr_tmp[3];
        }
        if($arr_tmp[7] == 'plus'){
            $new_bal = $cash_tr[5] - $arr_tmp[3];
            $new_bal_month = $cashmonth_tr[6] - $arr_tmp[3];
        }

        $cash->setBalance($new_bal);
        $cash->setId($arr_tmp[2]);
        $cash->UpdataBalance();

        $cashmonth->setBalance($new_bal_month);
        $cashmonth->setId($cashmonth_tr[0]);
        $cashmonth->UpdateCashMonth_Balance();

        $flag1 = $traz->DelTranz();

        if($flag1){
            echo("Успешно!");
        }
        else echo("Не удачно...");
    }
    else echo("false");

}

if(isset($_POST['del_trans']) && isset($_POST['index_trans'])){

    $tras->setId($_POST['index_trans']);
    $arr_tran = $tras->getTransFromId();

    if ($arr_tran != Array()) {

        $cash->setId($arr_tran[3]);
        $cash_tr_one = $cash->getCashFromId();

        $cash->setId($arr_tran[5]);
        $cash_tr_two = $cash->getCashFromId();

        $cashmonth->setId_Cash($arr_tran[3]);
        $cash_month_tr_one = $cashmonth->getCashMonth_FromCash();

        $cashmonth->setId_Cash($arr_tran[5]);
        $cash_month_tr_two = $cashmonth->getCashMonth_FromCash();

        $new_bal_one = $cash_tr_one[5] + $arr_tran[4];
        $new_bal_two = $cash_tr_two[5] - $arr_tran[6];

        $new_bal_month_one = $cash_month_tr_one[6] + $arr_tran[4];
        $new_bal_month_two = $cash_month_tr_two[6] - $arr_tran[6];

        $cash->setBalance($new_bal_one);
        $cash->setId($arr_tran[3]);
        $cash->UpdataBalance();

        $cash->setBalance($new_bal_two);
        $cash->setId($arr_tran[5]);
        $cash->UpdataBalance();

        $cashmonth->setBalance($new_bal_month_one);
        $cashmonth->setId($cash_month_tr_one[0]);
        $cashmonth->UpdateCashMonth_Balance();

        $cashmonth->setBalance($new_bal_month_two);
        $cashmonth->setId($cash_month_tr_two[0]);
        $cashmonth->UpdateCashMonth_Balance();

        $flag = $tras->DelTrans();
        if ($flag) {
            echo("Успешно!");
        } else echo("Не удачно...");
    } else {
        echo("false");
    }
}
/*
if(isset($_POST['on_cash'])){
    $id_cur_user = $con->findIdUser();
    $id_cashON = $_POST['id_cash'];

    $con->getTrFromCash($id_cashON);
}*/

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if(isset($_POST['wanna_tr_min'])){
    $traz->setUser_Id($id_cur_user);
    $traz->setStatus("minus");
    $traz->getTranz();
}

if(isset($_POST['wanna_tr_plus'])){
    $traz->setUser_Id($id_cur_user);
    $traz->setStatus("plus");
    $traz->getTranz();
}

if(isset($_POST['wanna_tr_min_fromID'])){
    $traz->setUser_Id($id_cur_user);
    $traz->setCash_Tr($_POST['cash_index']);
    $traz->setStatus("minus");
    $traz->getTranzFrom_Cash_User();
}

if(isset($_POST['wanna_tr_plus_fromID'])){
    $traz->setUser_Id($id_cur_user);
    $traz->setCash_Tr($_POST['cash_index']);
    $traz->setStatus("plus");
    $traz->getTranzFrom_Cash_User();
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if(isset($_POST['test'])){
    $con->getUser_nameFromId(2);
}

if(isset($_POST['update_tr']) && isset($_POST['index'])){

 /*   $traz->setId($_POST['index']);
    $rez = $traz->getTranzFrom_Id_and_CurMonth();
*/
    //$rez = $con->getTranzFromID($_POST['index']);
    //echo(json_encode($rez));
}

if(isset($_POST['getCashList'])){
    //$id_cur_user = $con->findIdUser();
    //$con->getCashList($id_cur_user);

}

if(isset($_POST['want_id_cashDouble'])){
   // $id_cur_user = $con->findIdUser();
   // $con->getCashNEWDouble( $id_cur_user);
}
//&& isset($_POST['date_trans']) && isset($_POST['cash_min_trans']) && isset($_POST['cash_min_trans'])
if(isset($_POST['name_trans']) ){
    try{
        $tras->setName($_POST['name_trans']);
        $tras->setData($_POST['date_trans']);
        $tras->setCash_Min($_POST['cash_min_trans']);
        $tras->setBalance_Min($_POST['balanc_min_trans']);
        $tras->setCourse($_POST['course_trans']);
        $tras->setCash_Sum($_POST['cash_sum_trans']);
        $tras->setBalance_Sum($_POST['balanc_sum_trans']);
        $tras->setComment($_POST['comment_trans']);
        $tras->setId_User($id_cur_user);

        $tmp = $tras->AddTrans();
        if($tmp) echo("Перевод добавлен!");
        else echo("Перевод не добавлен!");
    }
    catch(Exception $e){
        echo("Оперцация не прошла...");
    }
}

if(isset($_POST['wanna_tr_trans'])){
    $tras->setId_User($id_cur_user);
    $tras->getTrans();
}

if(isset($_POST['wanna_tr_trans_fromID'])){ ////////////////////////////////////////////////////////
    $tras->setId_User($id_cur_user);
    $tras->setId_Cash($_POST['cash_index']);
    $tras->getTransFromId_User_Id_Cash();
}

if(isset($_POST['getNewbalance'])){
    $arr_tmp = array();

    $balance = $_POST['balance'];
    $course = $_POST['course'];

    $cash->setId($_POST['last_cash']);
    $name1_type_money = $cash->getType_MoneyInDB();
    $cash->setId($_POST['new_cash']);
    $name2_type_money = $cash->getType_MoneyInDB();

    $get_cour1 = getOneCourse($name1_type_money);

    $get_cour2 = getOneCourse($name2_type_money);

    if($name1_type_money == $name2_type_money){
        $new_balance = (float)$balance;
        $courser=1;
        array_push($arr_tmp,(float)$courser, $new_balance);

    }
    else{
        if($name1_type_money == "UAH"){
            $new_balance = $balance / $get_cour2['sale'];
            $courser =round($get_cour2['sale'],2);
            array_push($arr_tmp,(float)$courser,(float)$new_balance);
        }
        if($name2_type_money == "UAH"){
            $new_balance = $balance * $get_cour1['buy'];
            $courser = $get_cour1['buy'];
            array_push($arr_tmp,(float)$courser,(float)$new_balance);
        }

        else{
            $new_balance = $balance * $get_cour1['sale'] / $get_cour2['buy'];
            $courser = $get_cour1['sale'] / $get_cour2['buy'];
            array_push($arr_tmp,(float)$courser,(float)$new_balance);
        }
    }
   echo(json_encode($arr_tmp));
}



if(isset($_POST['wanna_info_tranz'])){
    if($_POST['id_tr'] != ""){
        $traz->setId($_POST['id_tr']);
        $rez = $traz->getTranzFrom_Id_and_CurMonth();
        echo(json_encode($rez));
    }
    else{
        if($_POST['id_trans'] != ""){
           $tras->setId($_POST['id_trans']);
           $rez = $tras->getTransFromId();
           echo(json_encode($rez));
        }
    }
}

if(isset($_POST['up_name'])){

    $traz->setId($_POST['up_index']);
    $traz->setCash_Tr($_POST['up_cash_min']);

    $cash->setId($traz->getCash_Tr());
    $cash->setBalance($traz->getBalanceById());
    $tmp2 = $cash->UpdateCash_BalancePlus();

    $cashmonth->setId_Cash($traz->getCash_Tr());
    $cashmonth->setBalance($traz->getBalanceById());
    $tmp3 = $cashmonth->UpdateCashMonth_BalancePlus();

    $traz->setName($_POST['up_name']);
    $traz->setBalance($_POST['up_balance_min']);
    $traz->setComment($_POST['up_comment']);
    $traz->setData($_POST['up_data']);
    $traz->setStatus("minus");
    $tmp1 = $traz->UpdateTranz();

    $cash->setId($traz->getCash_Tr());
    $cash->setBalance($traz->getBalance());
    $tmp2 = $cash->UpdateCash_BalanceMin();

    $cashmonth->setId_Cash($traz->getCash_Tr());
    $cashmonth->setBalance($traz->getBalance());
    $tmp3 = $cashmonth->UpdateCashMonth_BalanceMin();

    if($tmp1 && $tmp3 && $tmp2 ) echo(1);
    else echo(0);

}

if(isset($_POST['up_name_sum'])){
    $traz->setId($_POST['up_index_sum']);
    $traz->setCash_Tr($_POST['up_cash_sum']);

    $cash->setId($traz->getCash_Tr());
    $cash->setBalance($traz->getBalanceById());
    $tmp2 = $cash->UpdateCash_BalanceMin();

    $cashmonth->setId_Cash($traz->getCash_Tr());
    $cashmonth->setBalance($traz->getBalanceById());
    $tmp3 = $cashmonth->UpdateCashMonth_BalanceMin();

    $traz->setName($_POST['up_name_sum']);

    $traz->setBalance($_POST['up_balance_sum']);
    $traz->setComment($_POST['up_comment_sum']);
    $traz->setData($_POST['up_data_sum']);
    $traz->setStatus("plus");

    $tmp1 = $traz->UpdateTranz();

    $cash->setId($traz->getCash_Tr());
    $cash->setBalance($traz->getBalance());
    $tmp2 = $cash->UpdateCash_BalancePlus();

    $cashmonth->setId_Cash($traz->getCash_Tr());
    $cashmonth->setBalance($traz->getBalance());
    $tmp3 = $cashmonth->UpdateCashMonth_BalancePlus();

    if($tmp1 && $tmp3 && $tmp2 ) echo(1);
    else echo(0);
}


if(isset($_POST['up_trans_index'])){

    $tras->setName($_POST['up_trans_name']);
    $tras->setId($_POST['up_trans_index']);
    $tras->setData($_POST['up_trans_data']);
    $tras->setCash_Min($_POST['up_trans_cash_min']);
    $tras->setBalance_Min($_POST['up_trans_balance_min']);
    $tras->setCourse($_POST['up_course']);
    $tras->setCash_Sum($_POST['up_trans_cash_sum']);
    $tras->setBalance_Sum($_POST['up_trans_balance_sum']);
    $tras->setComment($_POST['up_trans_comment']);

    $tras->UpdateTrans();

    $cash = R::load('cash', $tran_cash_min);
    $cash->balance += $tran_balance_min;
    R::store($cash);

    $cash->setId($tras->getCash_Min);
    $cash->UpdateCash_BalancePlus();

    $cashmonth->setId_Cash($tras->getCash_Min());
    $cashmonth->UpdateCashMonth_BalancePlus();

    $cash->setId($tras->getCash_Plus);
    $cash->UpdateCash_BalanceMin();

    $cashmonth->setId_Cash($tras->getCash_Plus());
    $cashmonth->UpdateCashMonth_BalanceMin();
}

if(isset($_POST['conv'])){
   // $con->getCashList($id_cur_user);

    $cash->setId_User($id_cur_user);
    $cash->getListCashFromId_User();
}

if(isset($_POST['test_event'])){
    //$pr_month = date("m")-1;
    //$now_day = date("d");
    $pr_month = date("04")-1;
    $now_day = date("01");
    if($now_day == "01") {
        // Посчитать баланс рас/дох за месяц и посчитать разницу
        $traz->setUser_Id(32);
        $traz->setData("2018-03-20");
        $traz->setStatus("minus");
        $all_tr_balance_minus = $traz->getTranzBalanceFromMonth();

        $traz->setStatus("plus");
        $all_tr_balance_plus = $traz->getTranzBalanceFromMonth();

        $rez_from_month = round($all_tr_balance_plus, 2) - round($all_tr_balance_minus, 2);

        if ($rez_from_month < 0) {
            //Создать буферную транзакцию за прошлый месяц со статусом минус
            $traz->setBalance(round($rez_from_month, 2));
            $traz->setStatus("minus");
            $traz->ExtraTranzaction();
            //$con->extraTranz($id_cur_user,$rez_from_month,"minus");
            echo("Добавлена Дополнительная транзакция");
        }
        if ($rez_from_month > 0) {
            //Создать буферную транзакцию за прошлый месяц со статусом плюс
            //$con->extraTranz($id_cur_user,round($rez_from_month,2),"plus");

            $traz->setBalance(round($rez_from_month, 2));
            $traz->setStatus("plus");
            $traz->ExtraTranzaction();
            echo("Добавлена Дополнительная транзакция");
        }
        if ($rez_from_month == 0)
            echo("Дополнительная транзакция не добавлена");
    }
}

if(isset($_POST['na_cashs_josn'])){
    //newBalance($id_user,$id_cash,$balance)
    $tmp = json_decode($_POST['na_cashs_josn'],true);

   foreach($tmp as $item){
       foreach($item as $key=>$value){
           echo($key."= ".$value.'|');
       }

   }
}
