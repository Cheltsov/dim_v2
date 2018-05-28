<?php
require_once "../class/user.php";
require_once "../class/tranzaction.php";
require_once "../class/linechart.php";

require_once "../class/libs/tcpdf/tcpdf.php";

$user = new User();
$traz = new Tranzaction();

$id_cur_user = $user->getUserId_Cookie();


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
    //$traz->setStatus($_POST['status']);
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

