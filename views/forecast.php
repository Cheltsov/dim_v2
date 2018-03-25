<?php
if(!isset($_COOKIE['SingIN'])){
    header('Location:../index.php');
}
//require "../controlers/control_debt.php";
require "partpage.php";

$part = new partPage();


echo("<title>Ledger - Планировщик</title>");
$part->head(); // Построение шапки страницы

$part->arr_links("mainPage.css","forecast_style.css"); //подключить массив фалов стилей

$part->script_links("https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js","../js/partpage.js"); //подключить массив фалов javascript
echo('<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css">');

?>

<div>
    <select name="" id="sel_data">
        <option value="all">All</option>
        <option value="1">Янв</option>
        <option value="2">Фев</option>
        <option value="3">Март</option>
        <option value="4">Апрель</option>
        <option value="5">Май</option>
        <option value="6">Июнь</option>
        <option value="7">Июль</option>
        <option value="8">Август</option>
        <option value="9">Сентябрь</option>
        <option value="10">Октябрь</option>
        <option value="11">Ноябрь</option>
        <option value="12">Декабрь</option>
    </select>
</div>
<pre>
    <div id="content" style="color:white; max-height:600px; overflow:auto;float:left;margin-right:100px"></div>
    <div id="content2" style="color:white; max-height:600px; overflow:auto;"></div>
</pre>
    <script>
        $(document).ready(function(){
            $.post(
                "../controlers/control_forecast.php",
                {wanna_month_tr : "1"},
                function(data){
                    //alert(data);
                    $("#content").append(data);
                }
            );
            $.post(
                "../controlers/control_forecast.php",
                {wanna_month_tr2 : "1"},
                function(data){
                    //alert(data);
                    $("#content2").append(data);
                }
            );
        });
    </script>


<?php
//$part->script_links("../js/index_page.js", "../js/tranz.js");
$part->foot();// Построение подвала страницы
?>