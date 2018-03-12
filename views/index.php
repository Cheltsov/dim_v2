<?php
if(!isset($_COOKIE['SingIN'])){
    header('Location:../index.php');
}
require "../controlers/control_main_page.php";
require "partpage.php";

$part = new partPage();


echo("<title>Ledger - Главная</title>");
$part->head(); // Построение шапки страницы

$part->arr_links("mainPage.css"); //подключить массив фалов стилей

$part->script_links("../js/partpage.js"); //подключить массив фалов javascript


?>
<style>
    table{
        margin-top:100px;
    }
    td{
        width:80px;
        height: 50px;
        text-align: center;
    }
</style>

<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.21.0/moment.min.js"></script>
<link rel="stylesheet" href="../libs/node_modules_call/pg-calendar/dist/css/pignose.calendar.css">
<script src="../libs/node_modules_call/pg-calendar/dist/js/pignose.calendar.full.js"></script>
<style>
    .pignose-calendar-top{
        padding:20px 0; !important
    }
    .pignose-calendar .pignose-calendar-top .pignose-calendar-top-date{
        padding: 1em 0; !important
    }
    .calender{
        border:1px solid red;
        width:18%;
        height:320px;
        font-size:10pt;
        margin-top:30px;
    }
    .courses{
        background-color:white;
        border:1px solid red;
        margin-top:0px;
        width:18%;
    }
    #header_tables{
        background-color:#009fe3;
        color:white;
        height:40px;
        font-size:12pt;
    }
    .courses td{
        border:1px solid black;
        padding:0px;
    }
</style>
<div class="calender"></div>

<table class="courses">
    <tr id="header_tables">
        <th>Валюта</th>
        <th>Покупка</th>
        <th>Продажа</th>
    </tr>
</table>

<div id="content"></div>
<script>
    $('.calender').pignoseCalendar({
        lang: 'en',
        date: moment(),
        week:1,
        theme: 'blue',
        format: 'YYYY-MM-DD',
        select: function(date, context) {
            alert(date[0]['_i']); // получить дату
        }
    });


    $(document).ready(function(){
        $.post("../controlers/control_main_page.php",
            {wanna_course : "1"},
            function(data){
                var obj = JSON.parse(data);
                for(i=0;i<obj.length-1;i++){
                    $(".courses").append("<tr><td>"+obj[i]['ccy']+"</td><td>"+obj[i]['buy']+"</td><td>"+obj[i]['sale']+"</td></tr>");
                }
            }
        );
    });

    $.post("../controlers/control_main_page.php",
        {test:"1"},
        function(data){
            alert(data);
        }
    );

</script>
<?php
    $part->foot();// Построение подвала страницы
?>
