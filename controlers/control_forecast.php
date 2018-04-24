<?php
require_once "../class/db.php";
require_once "../class/user.php";

$con = new Datebase();

$user = new User();

$id_cur_user = $user->getUserId_Cookie();

if(isset($_POST['wanna_month_tr2'])){
    $arr_month = array();
    $arr_tmp = array();

    $data_tr = $con->getDataOfTr($id_cur_user,'minus');
    foreach($data_tr as $item){
        $month = substr($item,5,2);
        if(!in_array($month,$arr_month))
            array_push($arr_month,$month);  // Месяца в которых есть транзакции
    }

    echo("Месяца в которых есть транзакции<br>");
    print_r($arr_month);
    echo("<br>");

   /* for($i=(int)$arr_month[0];$i<=(int)date('m');$i++){
        $rez = $con->getBalanceFromMonth($id_cur_user, $i, 'minus');
        array_push($arr_tmp,$rez);
    }*/
    foreach($arr_month as $item){
        $rez = $con->getBalanceFromMonth($id_cur_user, $item, 'minus');
        array_push($arr_tmp,$rez);
    }
    echo("Общий баланс за месяц");
    print_r($arr_tmp);

    $rezalt = FC_nextMonth($arr_tmp);

    echo("Forecasr1= ".$rezalt[0]."<br>");
    echo("Forecasr2= ".$rezalt[1]."<br>");
    if($rezalt[2]<=0) echo("Точность= Некорректные данные");
    else echo("Точность= ".($rezalt[2]*100)."%<br>");

} // Получить прогноз на будущий месяц по расходам

if(isset($_POST['wanna_month_tr'])){
    $arr_month = array();
    $arr_tmp = array();

    $data_tr = $con->getDataOfTr($id_cur_user,'plus');
    foreach($data_tr as $item){
        $month = substr($item,5,2);
        if(!in_array($month,$arr_month))
            array_push($arr_month,$month);  // Месяца в которых есть транзакции
    }

    echo("Месяца в которых есть транзакции");
    print_r($arr_month);
    echo("<br>");

   /* for($i=(int)$arr_month[0];$i<=(int)date('m');$i++){
        $rez = $con->getBalanceFromMonth($id_cur_user, $i, 'plus');
        array_push($arr_tmp,$rez);
    }*/
    foreach($arr_month as $item){
        $rez = $con->getBalanceFromMonth($id_cur_user, $item, 'plus');
        array_push($arr_tmp,$rez);
    }

    $rezalt = FC_nextMonth($arr_tmp);

    echo("Forecasr1= ".$rezalt[0]."<br>");
    echo("Forecasr2= ".$rezalt[1]."<br>");
    if($rezalt[2]<=0) echo("Точность= Некорректные данные");
    else echo("Точность= ".($rezalt[2]*100)."%<br>");

} // Получить прогноз на будущий месяц по доходам

function FC_nextMonth($arr_tmp){
    $k=0.6; $b=0.7;
    $period = array();
    $error_model = array();
    $deviation = array();
    $return_rez = array();

   // array_push($arr_tmp,"4500","8000","4000","6500","7000","7500","4000");
    print_r($arr_tmp);
    $Bal_cur_month = $arr_tmp[0];
    $Lt = $Bal_cur_month;
    $Tt = 0;

    array_push($period,($Lt + $Tt));

    for($i=0; $i<count($arr_tmp)-1; $i++){
        $Bal_next_month = $arr_tmp[$i+1];
        $Lt_new = ($k * $Bal_next_month) + (1-$k) * ($Lt - $Tt);
        $Tt_new = ($b * ($Lt_new - $Lt)) + ((1-$b) * $Tt);
        $Lt = $Lt_new;
        $Tt = $Tt_new;
       // echo("Lt = ".$Lt_new."<br>");
       // echo("Tt = ".$Tt_new ."<br>");
        array_push($period,($Lt_new + $Tt_new));
        array_push($error_model, ($Bal_next_month - $period[$i]));
        $tmp = round( pow($error_model[$i],2) / pow($Bal_next_month ,2),3 );
        array_push($deviation, $tmp);
        // echo("<br>0.6 * $Bal_next_month + (1-0.6) * ($Lt - $Tt)<br><br>");
    }
    $fc = $Lt_new + 1 * $Tt_new;
    $fc_two = $Lt_new + 2 * $Tt_new;
    //echo("Forecash1 = " . $fc."<br>");
    //echo("Forecash2 = " . $fc_two."<br>");
    array_push($return_rez,$fc,$fc_two);
    //print_r($period);
    //print_r($error_model);
   // print_r($deviation);
    $accuracy = round(1 - (array_sum($deviation)/count($deviation)),3);
    //echo("Точность прогноза = ".$accuracy);
    array_push($return_rez,$accuracy);
    return $return_rez;
} // Алгоритм расчета прогноза транзакций на будущий месяц