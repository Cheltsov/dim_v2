<?php
	require_once '../class/mail.php';
	require_once '../class/user.php';
	require_once '../class/cash.php';

	$mail = new Mail();
	$user = new User();
	$cash = new Cash();


if(isset($_POST['first_email']) && isset($_POST['pass'])){
    $user->setLogin($_POST['first_email']);
    $user->setPassword($_POST['pass']);
    $tmp =  $user->SingIn_User();
    if($tmp) echo(1);
    else echo(0);
}

if(isset($_POST['login']) && isset($_POST['email']) && isset($_POST['password'])){
		$user->setLogin($_POST['login']);
		$user->setPassword($_POST['password']);
        $user->setEmail($_POST['email']);
        if($user->getIdUserFromEmail() == 0){
            $tmp = $user->AddUser();

            $user->setEmail($_POST['email']);
            $id_user = $user->getIdUserFromEmail();
            $cash->setId_User($id_user);
            $cash->setName("Копилка");
            $cash->setType_Money("UAH");
            $cash->setType_Cash(1);
            $cash->setBalance(0);
            $cash->setComment("Первый кошелек");
            $tmp2 = $cash->Create_Cash();

            if($tmp && $tmp2) echo("Регистрация прошла успешно!");
            else echo("При регистрации возникли ошибки");
        }
        else echo("Такой пользователь уже есть!");
	}

	if(isset($_POST['email_new'])){
        $user->setEmail($_POST['email_new']);
        $id = $user->getIdUserFromEmail();
        if($id !=0){
            //Генерировать случайный пароль
            $pass_key = $mail->randPass();
            // смена значения пароля на '1111'
            $user->setId($id);
            $user->setPassword($pass_key);
            $user->NewPassword();
            //Отправить пароль на почту
            $mail->SentMail($user->getEmail(), $pass_key);
            echo("На почту выслан новый пароль");
        }
        else{
            echo("Пользователя не существует");
        }
	}

 ?>