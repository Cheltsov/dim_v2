<?php
require_once "../class/user.php";
require_once "../class/cash.php";

$user = new User();

if(isset($_POST['first_name']) && isset($_POST['sing'])){
    $user->setLogin($_POST['first_name']);
    $user->setPassword($_POST['pass']);
    $tmp = $user->SingIn_User();
    if($tmp) echo("Зарегистрирован");
    else echo("MOMOMO");
}