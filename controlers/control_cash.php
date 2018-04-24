<?php
require_once "../class/db.php";
require_once "../class/user.php";
require_once "../class/cash.php";
require_once "../class/cashmonth.php";
require_once "getCourse.php";

$user = new User();
$cash = new Cash();
$cashmonth = new CashMonth();


$id_cur_user = $user->getUserId_Cookie();

if(isset($_POST['wanna_info_cash'])){
    $cash->setId_User($id_cur_user);
    $cash->getListCashFromId_User();
}

 // Получить кошельки по id пользователя return массив


if(isset($_POST['name_cash_add'])){
    try{
        if(!isset($_POST['num_card'])) $_POST['num_card'] ="";
        $cash->setName($_POST['name_cash_add']);
        $cash->setType_Money($_POST['type_money']);
        $cash->setNum_Card($_POST['num_card']);
        $cash->setType_Cash($_POST['type_cash']);
        $cash->setBalance($_POST['balance_add']);
        $cash->setComment($_POST['comment']);
        $cash->setId_User($id_cur_user);
        $cash->Create_Cash();

        $cashmonth->setName($_POST['name_cash_add']);
        $cashmonth->setId_User($id_cur_user);
        $cashmonth->setType_Money($_POST['type_money']);
        $cashmonth->setType_Cash($_POST['type_cash']);
        $cashmonth->setBalance($_POST['balance_add']);

        $cashmonth->AddCashMonth();

        echo("Кошелек успешно добавлен!");
    }
    catch (Exception $e){
        echo($e);
    }
}




//$temp = $con->getCash($id_cur_user);


/*
function getTempCash(){
    return $GLOBALS['temp'];
}*/



if(isset($_POST['id_but'])){
    $cash->setId($_POST['id_but']);
    $tmp = $cash->getCashFromId();
    echo(json_encode($tmp));

}

if(isset($_POST['num_id'])){
    $cash->setId($_POST['num_id']);
    $cash->delCashFromId();

    $cashmonth->setId_Cash($_POST['num_id']);
    $id = $cashmonth->getCashMonthID_from_Cash();
    $cashmonth->setId($id);
    $cashmonth->delCashMonth_FromId_Cash();
}
/*
if(isset($_POST['queryBut'])){
    $tp = $GLOBALS['temp'];
    echo(json_encode($tp));
}*/

if(isset($_POST['up_cash'])){
    $cash->setId($_POST['up_cash']);
    $row_cash = $cash->getCashFromId();
    echo(json_encode($row_cash));
}

if(isset($_POST['newname_cash']) && isset($_POST['newtype_cash']) && isset($_POST['newtype_money']) && isset($_POST['newbalance'])){
    $cash->setId($_POST['id_cash']);
    $cash->setName($_POST['newname_cash']);
    $cash->setType_Money($_POST['newtype_money']);
    $cash->setType_Cash($_POST['newtype_cash']);
    $cash->setBalance($_POST['newbalance']);
    $cash->setComment($_POST['newcomment']);
    $cash->UpdateCash();

    $cashmonth->setName($_POST['newname_cash']);
    $cashmonth->setId_Cash($cash->getId());
    $cashmonth->setType_Money($_POST['newtype_money']);
    $cashmonth->setType_Cash($_POST['newtype_cash']);

    $id = $cashmonth->getCashMonthID_from_Cash();
    $cashmonth->setId($id);
    $cashmonth->UpdateCashMonth();
}


if(isset($_POST['id_cash'])){
    echo('111');
}

if(isset($_POST['val'])){

    $last_course = $_POST['last_course'];
    $cur_course = $_POST['val'];
    $cur_balance = $_POST['bal'];

    $cur_course_val = getOneCourse($last_course);

    $new_cur_course_val = getOneCourse($cur_course);



    //$new_bal = 0;

    if($last_course == "UAH"){
        $new_bal = $cur_balance * $new_cur_course_val['sale'];
        echo($new_bal);
        exit;
    }
    if($cur_course == "UAH"){
        $new_bal = $cur_balance / $cur_course_val['buy'];
        echo($new_bal);
        exit;
    }
    else{
        $new_bal = $cur_balance * $cur_course_val['sale'] / $new_cur_course_val['buy'];
        echo($new_bal);
        exit;
    }
    /*
    echo($cur_balance);
    echo('---');
    echo($new_bal);*/


}
