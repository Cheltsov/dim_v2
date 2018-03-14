<?php
require_once "db.php";
require_once 'getCourse.php';

$con = new Datebase();
$con->Connection();

$course = getCourse();

$id_cur_user = $con->findIdUser();

if(isset($_POST['wanna_course'])){ // Получить курс валют
    /*$arr_tmp = getCourse();
    echo(json_encode($arr_tmp));*/
    echo(json_encode($course));
}
/*
if(isset($_POST['test'])){
    $rez = $con->getCash("1");
    print_r($rez);
}*/

if(isset($_POST['wanna_all_balance'])){ //Получить баланс по всем кошелькам
    $all_balance = 0;

    $all_sum = $con->getCashNEW($id_cur_user);
    for($i=0,$b=3,$tc=1;$i<count($all_sum);$i+=7,$b+=7,$tc+=7){
        switch($all_sum[$tc]){
            case "UAH" : $all_balance+=$all_sum[$b]; break;
            case "EUR" : $all_balance+=$all_sum[$b]*$course[1]['sale']; break;
            case "USD" : $all_balance+=$all_sum[$b]*$course[0]['sale']; break;
            case "RUR" : $all_balance+=$all_sum[$b]*$course[2]['sale']; break;
        }
    }
    echo(round($all_balance,2));
}

if(isset($_POST['getTrMinFromData']) && isset($_POST['data_tr'])){
    $rez = $con->getTrMinFromData( $id_cur_user, $_POST['data_tr']);
    echo($rez);
}

if(isset($_POST['getTrPlusFromData']) && isset($_POST['data_tr'])){
    $rez = $con->getTrPlusFromData( $id_cur_user, $_POST['data_tr']);
    echo($rez);
}

if(isset($_POST['getTransFromData']) && isset($_POST['data_tr'])){
    $rez = $con->getTranslateFromData( $id_cur_user, $_POST['data_tr']);
    echo($rez);
}


