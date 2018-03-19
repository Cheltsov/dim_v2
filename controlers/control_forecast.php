<?php
require_once "db.php";

$con = new Datebase();
$con->Connection();

$id_cur_user = $con->findIdUser();

$k=0.5; $b=0.6;

if(isset($_POST['wanna_month_tr'])){
    $arr_month = array();
    $data_tr = $con->getDataOfTr_Sum($id_cur_user);
    foreach($data_tr as $item){
        $month = substr($item,5,2);
        if(!in_array($month,$arr_month))
            array_push($arr_month,$month);  // Месяца в которых есть транзакции
    }


    $arr_tmp = array("17986229", "23571964","25537589","24630951","24429696","26116377","27931500","25914893","24904130","22360354");
    $period = array();
    $error_model = array();
    $deviation = array();

    print_r($arr_tmp);

    $Bal_cur_month = $arr_tmp[0];
    $Lt = $Bal_cur_month;
    $Tt = 0;

    array_push($period,($Lt + $Tt));

    for($i=0; $i<count($arr_tmp)-1; $i++){
        $Bal_next_month = $arr_tmp[$i+1];
        $Lt_new = (0.6 * $Bal_next_month) + (1-0.6) * ($Lt - $Tt);
        $Tt_new = (0.7 * ($Lt_new - $Lt)) + ((1-0.7) * $Tt);
        $Lt = $Lt_new;
        $Tt = $Tt_new;
        echo("Lt = ".$Lt_new."<br>");
        echo("Tt = ".$Tt_new ."<br>");
        array_push($period,($Lt_new + $Tt_new));
        array_push($error_model, ($Bal_next_month - $period[$i]));
        $tmp = round( pow($error_model[$i],2) / pow($Bal_next_month ,2),3 );
        array_push($deviation, $tmp);

        echo("<br>0.6 * $Bal_next_month + (1-0.6) * ($Lt - $Tt)<br><br>");
    }
    $fc = $Lt_new + 1 * $Tt_new;
    $fc_two = $Lt_new + 2 * $Tt_new;
    echo("Forecash1 = " . $fc."<br>");
    echo("Forecash2 = " . $fc_two);
    print_r($period);
    print_r($error_model);
    print_r($deviation);
    $accuracy = round(1 - (array_sum($deviation)/count($deviation)),3);

    echo("Точность прогноза = ".$accuracy);


    echo("<br>------------------------------------------------<br><br><br>");
    $period = array();
    $error_model = array();
    $deviation = array();
    $arr_tmp = array();

    for($i=2;$i<=(int)date('m');$i++){
        $rez = $con->getBalanceFromMonth($id_cur_user, $i, 'plus');
        array_push($arr_tmp,$rez);
    }

    $Bal_cur_month = $arr_tmp[0];
    $Lt = $Bal_cur_month;
    $Tt = 0;

    array_push($period,($Lt + $Tt));

    for($i=0; $i<count($arr_tmp)-1; $i++){
        $Bal_next_month = $arr_tmp[$i+1];
        $Lt_new = (0.6 * $Bal_next_month) + (1-0.6) * ($Lt - $Tt);
        $Tt_new = (0.7 * ($Lt_new - $Lt)) + ((1-0.7) * $Tt);
        $Lt = $Lt_new;
        $Tt = $Tt_new;
        echo("Lt = ".$Lt_new."<br>");
        echo("Tt = ".$Tt_new ."<br>");
        array_push($period,($Lt_new + $Tt_new));
        array_push($error_model, ($Bal_next_month - $period[$i]));
        $tmp = round( pow($error_model[$i],2) / pow($Bal_next_month ,2),3 );
        array_push($deviation, $tmp);

        echo("<br>0.6 * $Bal_next_month + (1-0.6) * ($Lt - $Tt)<br><br>");
    }
    $fc = $Lt_new + 1 * $Tt_new;
    $fc_two = $Lt_new + 2 * $Tt_new;
    echo("Forecash1 = " . $fc."<br>");
    echo("Forecash2 = " . $fc_two);
    print_r($period);
    print_r($error_model);
    print_r($deviation);
    $accuracy = round(1 - (array_sum($deviation)/count($deviation)),3);

    echo("Точность прогноза = ".$accuracy);


}