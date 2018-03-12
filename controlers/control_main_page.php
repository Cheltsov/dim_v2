<?php
require_once "db.php";
require_once 'getCourse.php';

$con = new Datebase();
$con->Connection();

if(isset($_POST['wanna_course'])){
    $arr_tmp = getCourse();
    echo(json_encode($arr_tmp));
}

if(isset($_POST['test'])){
    $rez = $con->getCash("1");
    print_r($rez);
}


