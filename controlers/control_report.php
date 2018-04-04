<?php
require_once "db.php";

$con = new Datebase();
$con->Connection();

$id_cur_user = $con->findIdUser();

$temp = $con->getCash($id_cur_user);
/*
if(isset($_POST['wanna_info_tr'])){
    $all_balance = 0;
    $id_cur_user = $con->findIdUser();
    $all_tr = $con->getTranzFromID_user( $id_cur_user);
    $tmp = json_decode($all_tr);
    for ($i = 3; $i < count($tmp); $i+=7) {
        $all_balance += $tmp[$i];
    }
    echo($all_balance);
}*/
if(isset($_POST['wanna_info_tr_plus'])){
    $arr_tr_plus =array();
    $tmp =array();
    $id_cur_user = $con->findIdUser();
    $data_tr_plus = $con->getDataOfTr($id_cur_user,'plus'); // получить даты транзакций плюс
   // echo (json_encode($con->getAllBalOfData( $id_cur_user, "plus", $month)));
    echo (json_encode($con->getAllBalOfData( $id_cur_user, "plus")));
    //echo("<pre>");
    //print_r($arr_tr_min);
}
if(isset($_POST['wanna_info_tr_min'])){
    $rez_1 = '';
    $arr_tr_min =array();
    $tmp =array();
    //$month = $_POST['date'];
   /* if( $month == null){
        $month =(int) date('m');
    }*/
    $id_cur_user = $con->findIdUser();
    $data_tr_min = $con->getDataOfTr($id_cur_user,'minus'); // получить даты транзакций плюс
    //$datas = $con->getAllBalOfData( $id_cur_user, "minus", $month);
    $datas = $con->getAllBalOfData( $id_cur_user, "minus");
   /* for($i=1,$n=2;$i<count($datas);$i+=3,$n+=3){
        for($j=1;$j<count($datas);$j+=3){
            if($datas[$i] == $datas[$j]){
                $rez_1 .= $datas[$n]."|";
            }
        }
    }*/
    //print_r($datas);
    //echo($rez_1);
    //echo($month);
    echo (json_encode($datas));
    //echo $con->getAllBalanceOfData( $id_cur_user, "minus");
}

if(isset($_POST['cont'])){
    $tmp_mas = array();
    $datas_tr = $con->getDataOfTr($id_cur_user,'minus');
    foreach($datas_tr as $item) {
        array_push($tmp_mas,substr($item,5,2));
    }
    $months = array_unique($tmp_mas);
    sort($months);
    echo(json_encode($months));
    //echo('1');
}