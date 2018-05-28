<?php
require_once "../class/db.php";
require_once "../class/user.php";
require_once "../class/tranzaction.php";
require_once "../class/translate.php";
require_once 'getCourse.php';

$con = new Datebase();
$user = new User();
$traz = new Tranzaction();
$tras = new Translate();
$course = getCourse();
$id_cur_user = $user->getUserId_Cookie();

if(isset($_POST['wanna_course'])){
    echo(json_encode($course));
}
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
if(isset($_POST['getTrMinFromData']) && isset($_POST['data_tr_start'])){
    $traz->setUser_Id($id_cur_user);
    $traz->setStatus("minus");
    if($_POST['data_tr_end']!=""){
        $rez = $traz->getTranzByRange( $_POST['data_tr_start'],$_POST['data_tr_end']);
        echo($rez);
    }
    else{
        $traz->setData($_POST['data_tr_start']);
        $rez = $traz->getTranzFromData();
        echo($rez);
    }
}
if(isset($_POST['getTrPlusFromData']) && isset($_POST['data_tr_start'])){
    $traz->setUser_Id($id_cur_user);
    $traz->setStatus("plus");
    if($_POST['data_tr_end']!=""){
        $rez = $traz->getTranzByRange( $_POST['data_tr_start'],$_POST['data_tr_end']);
        echo($rez);
    }
    else{
        $traz->setData($_POST['data_tr_start']);
        $rez = $traz->getTranzFromData();
        echo($rez);
    }
}
if(isset($_POST['getTransFromData']) && isset($_POST['data_tr_start'])){
    $tras->setId_User($id_cur_user);
    if($_POST['data_tr_end']!=""){
        $rez = $tras->getTransFromDataRange($_POST['data_tr_start'],$_POST['data_tr_end']);
        echo($rez);
    }
    else{
        $tras->setData($_POST['data_tr_start']);
        $rez = $tras->getTransFromData();
        echo($rez);
    }
}
if(isset($_POST['add_courses'])){
    $day = date("d");
    if($day == "01"){
        clearCourses(); // Удалить записи в таблице
    }
    setDailyCourse(); //Добавить курсы валют в бд каждый день
}


