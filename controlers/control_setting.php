<?php
require_once "../class/user.php";
require_once "../class/cash.php";
require_once "exit.php";

$user = new User;
$cash = new Cash;
$user->setId($user->getUserId_Cookie());

if(isset($_POST['change_password'])){
	$user->setPassword($_POST['change_password']);
	$tmp = $user->NewPassword();
	if($tmp) echo("Пароль изменен");
	else echo("Ошибка при изменении пароля");
}

if(isset($_POST['change_email'])){
	$user->setEmail($_POST['change_email']);
	$tmp = $user->NewEmail();
	if($tmp) echo("Email изменен");
	else echo("Ошибка при изменении email");
}

if(isset($_POST['del_cash_prog'])){
	$tmp = $user->Del_Cash_Prog();
	if($tmp){
		$cash->setId_User($user->getId());
        $cash->setName("Копилка");
        $cash->setType_Money("UAH");
        $cash->setType_Cash("1");
        $cash->setBalance(0);
		$tmp2 = $cash->Create_Cash();
		if($tmp2) echo("Данные удалены");
	}
	else echo("Ошибка при удалении данных");
}

if(isset($_POST['del_cash_prog'])){
	$tmp = $user->Del_user();
	if($tmp){
		delCook();
	}
	else echo("0");
}

