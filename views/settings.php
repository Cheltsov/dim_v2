<?php
if(!isset($_COOKIE['SingIN'])){
    header('Location:../index.php');
}
require "../controlers/control_main_page.php";

require "../controlers/control_setting.php";

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

<div>
    <button id="add_user">Добавить пользователя</button>
</div>

<div id="dialog">
        <label for="">Введите email пользователя</label>
        <input type="text" require id="email_us">
        <br><br>
        <!--<input type="submit" value="Add">-->
        <button id="add_new_user">Add</button>
</div>

<div id="content">
    sd
</div>

<script>
    $('#dialog').dialog({
        autoOpen: false,
        show: {
            effect: 'drop',
            duration: 500
        },
        hide: {
            effect: 'clip',
            duration: 500
        },
        width: 500
    });

    $("#add_user").click(function(){

        $('#dialog').dialog("open");
    });

    $("#add_new_user").click(function(){
        $.post(
            "../controlers/control_setting.php",
            {getUsId:"1"},
            function(data){
                flag = 0;
                var obj = JSON.parse(data);
                for(i=0;i<obj.length;i++){
                    if($("#email_us").val() == obj[i].toString()){
                        alert("yes"); flag = 1;
                        postAdd($("#email_us").val());
                    }
                }
                if(flag == 0) alert("Такого пользоватеоя нет");
            }
        );
        function postAdd(user){
            $.post(
                "../controlers/control_setting.php",
                {addUser: user},
                function(data){
                    alert(data);
                    $("#content").append(data);

                }
            );
        }
    });
</script>


<?php
//$part->script_links("../js/tranz.js");
$part->foot();
?>
