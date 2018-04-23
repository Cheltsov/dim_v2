<?php
require_once "class/db.php";
require_once 'getCourse.php';

$con = new Datebase();
$con->Connection();

$id_cur_user = $con->findIdUser();

$temp = $con->getCash($id_cur_user);

if(isset($_POST['getUsId'])){
   $rex =  $con->getUsers();
   echo(json_encode($rex));
}

if(isset($_POST['addUser'])){
    $id_guest = $con->findIdUserFromEmail($_POST['addUser']);
    $con->addUserGroup($id_cur_user,$id_guest);
}

/*$arr_tmp = array($id_cur_user,"2");
   for($i=0;$i<count($arr_tmp);$i++)
        $con->getCashList($arr_tmp[$i]);*/