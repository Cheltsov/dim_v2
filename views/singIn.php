<head>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</head>


<form   action="../controlers/test_conrol.php" method="post" class="form1" id="loginUp">
    <input type="text" placeholder="Введите логин" required name="first_name" maxlength="50" id="login"> <br>
    <input type="password"  placeholder="Введите пароль" required name="pass" maxlength="30" id="password"> <br>
    <input type="submit"  value="Войти" name="sing" id='ding'>
</form>

<button id="getCash">AddTr</button>


<div id="test"></div>

<script>
    $("#getCash").click(function(){
        $.post(
            "singin.php",
            {
                test_cash_id: "1"
            },
            function(data){
                alert(data);
                $("#test").append(data);
            }
        );
    });
</script>

<?php

require_once "../class/user.php";
require_once "../class/cash.php";
require_once "../class/cashmonth.php";


$user = new User();
$cash = new Cash();
$cashmonth = new CashMonth();



$id_cur_user = $user->getUserId_Cookie();

/*
if(isset($_POST['first_name']) && isset($_POST['sing'])){
    $user->setLogin($_POST['first_name']);
    $user->setPassword($_POST['pass']);
    $tmp = $user->SingIn_User();
    if($tmp) echo("Зарегистрирован");
    else echo("MOMOMO");
}*/
/*
if(isset($_POST['test_cash_id'])){
    $cash->setId(65);
    $tmp = $cash->delCashFromId();

    print_r($tmp);
}*/

if(isset($_POST['test_cash_id'])) {

    $cash->setId_User($id_cur_user);
    $cash->getListCashFromId_User();



    /* $cashmonth->setId_Cash($tras->getCash_Tr());
     $id_cash_month = $cashmonth->getCashMonthID_from_Cash();*/
    /*$cashmonth->setId_Cash($traz->getCash_Tr());
    $cashmonth->setBalance($traz->getBalance());
    $tmp3 = $cashmonth->UpdateCashMonth_BalanceMin();*/


    /*
    $traz->setUser_Id(32);
    $traz->setCash_Tr(55);
    $traz->getTranzFrom_Cash_User();
*/

    /*
    $tras->setId(16);
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


*/




    /*
    $traz->setId(373);
    $arr_tmp = $traz->getTranzFrom_Id();

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

       // $traz->setId($_POST['index']);
        $flag1 = $traz->DelTranz();

        if($flag1){
            echo("Успешно!");
        }
        else echo("Не удачно...");
    }
    else echo("false");
*/

/*

    $traz->setName("eeeeeeeee");
    $traz->setCash_Tr(54);
    $traz->setBalance(100);
    $traz->setComment("");
    $traz->setUser_Id(32);
    $traz->setData("2018-09-02");
    $traz->setStatus("minus");

    $tmp1 = $traz->AddTranz();

    $cash->setId($traz->getCash_Tr());
    $cash->setBalance($traz->getBalance());
    $tmp2 = $cash->UpdateCash_BalanceMin();

    $cashmonth->setId_Cash($traz->getCash_Tr());
    $cashmonth->setBalance($traz->getBalance());
    $tmp3 = $cashmonth->UpdateCashMonth_BalanceMin();

    if($tmp1 && $tmp3 && $tmp2 ) echo("cool");
    else echo("nonono");
*/
   /* $traz->setUser_Id(32);
    $traz->setStatus("plus");
    $traz->setData("2018-01-02");
    $tmp = $traz->getTranzBalanceFromMonth();
    echo "<pre>";
    print_r($tmp);*/


   /* ОБновление траназкции
    $traz->setId(364);
    $status = "plus";

    $tmp = $traz->getTranz_Balance_Id();

    if($status == "minus"){
        $cash->setId($tmp[1]);
        $tmp2 = $cash->UpdateCash_BalanceMin($tmp[0]);

        $cashmonth->setId_Cash($tmp[1]);
        $id_cash_month = $cashmonth->getCashMonthID_from_Cash();
        $cashmonth->setId($id_cash_month);
        $cashmonth->UpdateCashMonth_BalanceMin($tmp[0]);
    }
    if($status == "plus"){
        $cash->setId($tmp[1]);
        $tmp2 = $cash->UpdateCash_BalancePlus($tmp[0]);

        $cashmonth->setId_Cash($tmp[1]);
        $id_cash_month = $cashmonth->getCashMonthID_from_Cash();
        $cashmonth->setId($id_cash_month);
        $cashmonth->UpdateCashMonth_BalancePlus($tmp[0]);
    }
    */

/*
    $traz->setId(364);
    $traz->setName('TETSTS211'); // Update транзакцию
    $traz->setCash_Tr(61);
    $traz->setBalance(899);
    $traz->setCourse(0);
    $traz->setComment("new test22");
    $traz->setUser_Id(32);
    $traz->setData("2018-09-02 14:00:00");
    $traz->setStatus($status);

    $tmp1 = $traz->UpdateTranz();

    $cash->setId(61);
    if($status =="minus"){
        $tmp2 = $cash->UpdateCash_BalanceMin(899);
        $cashmonth->setId_Cash(60);
        $id_cash_month = $cashmonth->getCashMonthID_from_Cash();
        $cashmonth->setId($id_cash_month);
        $tmp3 = $cashmonth->UpdateCashMonth_BalanceMin(700);
    }
    if($status == "plus"){
        $tmp2 = $cash->UpdateCash_BalancePlus(899);
        $cashmonth->setId_Cash(60);
        $id_cash_month = $cashmonth->getCashMonthID_from_Cash();
        $cashmonth->setId($id_cash_month);
        $tmp3 = $cashmonth->UpdateCashMonth_BalancePlus(700);
    }

    if($tmp1 && $tmp3 && $tmp2 ) echo("cool");
    else echo("nonono");

*/


    /*
    $traz->setUser_Id(32);
    $traz->setStatus('plus');
    $traz->setCash_Tr(61);
    $traz->getTranzFrom_Cash_User();
    */
    /*
    $traz->setUser_Id(32);
    $traz->setStatus('plus');
    $traz->setData("2018-01-01");
    $traz->getTranzByRange("2018-01-01","2018-04-01");
*/
/*
    $traz->setUser_Id(32);
    $traz->setStatus('plus');
    $traz->setData("2018-01-01");
    $traz->getTranzFromData();
*/
    /*
    $traz->setUser_Id(32);
    $traz->setStatus('plus');
    $tmp = $traz->getTranz();
    echo("<pre>");
    print_r($tmp);
*/

 /* $traz->setName('TETSTS'); // Добавить транзакцию
    $traz->setCash_Tr(61);
    $traz->setBalance(700);
    $traz->setCourse(0);
    $traz->setComment("new test");
    $traz->setUser_Id(32);
    $traz->setData("2018-09-02 12:00:00");
    $traz->setStatus("minus");

    $tmp1 = $traz->AddTranz();

    $cash->setId(64);
    $tmp2 = $cash->UpdateCash_BalanceMin(700);

    $cashmonth->setId_Cash(60);
    $id_cash_month = $cashmonth->getCashMonthID_from_Cash();
    $cashmonth->setId($id_cash_month);
    $tmp3 = $cashmonth->UpdateCashMonth_BalanceMin(700);

    if($tmp1 && $tmp3 && $tmp2 ) echo("cool");
    else echo("nonono");*/
}


