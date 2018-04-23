<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

<form   class="form1" id="loginUp">
    <input type="text" placeholder="Введите логин" required name="first_name" maxlength="50" id="login"> <br>
    <input type="password"  placeholder="Введите пароль" required name="pass" maxlength="30" id="password"> <br>
    <input type="submit"  value="Войти" name="sing" id='ding'>
</form>

<form  id="logUP"  class="form1" >
    <input type="text" placeholder="Введите логин" required name="login" maxlength="50" > <br>
    <input type="email" placeholder="Введите email" required name="email" maxlength="50" > <br>
    <input type="password" id="pas1" placeholder="Введите пароль" required name="password" maxlength="30"> <br>
    <input type="password" id="pas2" placeholder="Повторите пароль" required name="second_password" maxlength="30"> <br>
    <input type="submit"  value="Отправить" name="singIn" id="logUp">
</form>




<div id="test"></div>


<script>

    $(document).ready(function(){
        $("#test").empty();
    });


    $("#loginUp").submit(function(){
        $("#test").empty();
        $.post(
            "test_addUser.php",
            {
                sing_email: $("#login").val(),
                sing_password: $("#password").val()
            },
            function(data){
                alert(data);
                $("#test").append(data);
                location.reload(false);
            }
        );
    });


    $("#logUP").submit(function(){
        $.post(
            "test_addUser.php",
            {
                login: $("input[name='login']").val(),
                email: $("input[name='email']").val(),
                password: $("input[name='password']").val()
            },
            function(data){
                //alert(data);
                $("#test").append(data);
            }
        );
    });
</script>

<?php

require_once "../controlers/user.php";
require_once "../controlers/cash.php";


$user = new User();
$cash = new Cash();

if(isset($_POST['login']) && isset($_POST['email']) && isset($_POST['password'])){

    $user->setLogin($_POST['login']) ;
    $user->setEmail($_POST['email']);
    $user->setPassword($_POST['password']);

    $id_user = $user->getIdUserFromEmail($_POST['email']);

    if(!empty($id_user)) {
        echo("Такой пользователя уже есть");
    }
    else{
        $tmp_addUser = $user->AddUser();

        $id_user = $user->getIdUserFromEmail($_POST['email']);

        $cash->setId_User($id_user);
        $cash->setName("Копилка");
        $cash->setType_Money("1");
        $cash->setType_Cash("1");
        $cash->setBalance("0");

        $tmp_createCash = $cash->Create_Cash();

        if($tmp_addUser && $tmp_createCash){
            echo("Регистрация прошла успешно");
        }
    }
}

