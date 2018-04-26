<?php
require_once "../class/db.php";
require_once "../class/user.php";
require_once "../class/tranzaction.php";
require_once "../class/linechart.php";

$con = new Datebase();

$user = new User();
$traz = new Tranzaction();

$id_cur_user = $user->getUserId_Cookie();

//$temp = $con->getCash($id_cur_user);
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
if(isset($_POST['wanna_info_tr_plus']) && isset($_POST['data'])){
    $rez_1 = '';
    $arr_tr_min =array();
    $tmp =array();
    $traz->setUser_Id($id_cur_user);
    $traz->setStatus("plus");
    $traz->setData($_POST['data']);
    $data_tr_min = $traz->getDataByTranz(); // получить даты транзакций плюс
    $datas = $traz->getBalanceByData();
    echo (json_encode($datas));
}

if(isset($_POST['wanna_info_tr_min']) && isset($_POST["data"])){

    $rez_1 = '';
    $arr_tr_min =array();
    $tmp =array();
    $traz->setUser_Id($id_cur_user);
    $traz->setStatus("minus");
    //$data_tr_min = $traz->getDataByTranz(); // получить даты транзакций плюс
    $traz->setData($_POST['data']);
    $datas = $traz->getBalanceByData();
    echo (json_encode($datas));
}

if(isset($_POST['cont'])){
    $tmp_mas = array();
    $traz->setUser_Id($id_cur_user);
    $traz->setStatus("minus");
    $datas_tr = $traz->getDataByTranz();
    foreach($datas_tr as $item) {
        array_push($tmp_mas,substr($item,5,2));
    }
    $months = array_unique($tmp_mas);
    sort($months);
    echo(json_encode($months));

}

if(isset($_POST['label'])){
    $traz->setUser_Id($id_cur_user);
    $traz->setStatus("minus");
    $tmp = $traz->getEachTranzByChart($_POST['label']);
    echo(json_encode($tmp));
}

if(isset($_POST['getMinus']) && isset ($_POST['getPlus'])){
    $arr_tmp = array();
    $traz->setUser_Id($id_cur_user);
    $traz->setStatus('minus');
    $tmp1 = $traz->getBalanceByMonth($_POST['month_tr']);

    $traz->setStatus('plus');
    $tmp2 = $traz->getBalanceByMonth($_POST['month_tr']);
    array_push($arr_tmp,round($tmp1,2),round($tmp2,2));
    echo json_encode($arr_tmp);
    //echo($_POST['month_tr']);
}