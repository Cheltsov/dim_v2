<?php
if(!isset($_COOKIE['SingIN'])){
    header('Location:../index.php');
}

require "partpage.php";
$part = new partPage();
$part->PreLoader();
echo("<title>Ledger - Настройки</title>");
$part->head();
echo('<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css">');
$part->arr_links("mainpage.css", "setting_style.css" );
$part->script_links("https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js", "../js/accordion.js", "../js/tabs.js", "../libs/cellSelection.min.js");
?>

<div style="margin-left: 25px;">
	<div style='color:white'>
	<h2>Изменение почтового адреса</h2>
	<br>
	<input type="text" id='new_email'>
    <button id="ch_email">Изменить email</button>

	</div>
<br><br>
<div style='color:white'>
	<h2>Изменение пароля</h2>
	<br>
	<input type="text" id="new_pas">
    <button id="ch_password">Изменить пароль</button>
</div>
<br><br>
<div style='color:white'>
    <button id="del_cash">Удалить кэш программы</button>
</div>
<br><br>
<div style='color:white'>
    <button id="del_user">Удалить аккаунт</button>
</div>
</div>




<script>
    $("#ch_email").click(function(){
        $.post(
            "../controlers/control_setting.php",
            {change_email:$("#new_email").val()},
            function(data){
                alert(data);
            }
        );
    });

    $("#ch_password").click(function(){
        $.post(
            "../controlers/control_setting.php",
            {change_password:$("#new_pas").val()},
            function(data){
                alert(data);
            }
        );
    });

    $("#del_cash").click(function(){
        $.post(
            "../controlers/control_setting.php",
            {del_cash_prog:"1"},
            function(data){
                alert(data);
            }
        );
    });

    $("#del_user").click(function(){
        $.post(
            "../controlers/control_setting.php",
            {del_user:"1"},
            function(data){
                if(data == "0") alert("Пользователь не удален");
            }
        );
    });
</script>


<?php
$part->foot();
?>
