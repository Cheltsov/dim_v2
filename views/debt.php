<?php
if(!isset($_COOKIE['SingIN'])){
    header('Location:../index.php');
}

require "partpage.php";

$part = new partPage();
$part->PreLoader();

echo("<title>Ledger - Долги</title>");
$part->head(); // Построение шапки страницы

$part->arr_links("mainPage.css","debt_style.css"); //подключить массив фалов стилей

$part->script_links("https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js","../js/partpage.js"); //подключить массив фалов javascript
echo('<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css">');

?>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.3.2/flatpickr.min.js"></script>
<link rel="stylesheet" type="text/css" href="../libs/node_modules/flatpickr/dist/themes/material_blue.css">
<script src="../libs/node_modules/flatpickr/dist/flatpickr.js"></script>


<style>
    .menu{
        width:85%;
        margin-left:20px;
        float:left;
        max-height:350px;
        overflow: auto;
    }
    .manu table{

    }
    .menu td, th{
        border:1px solid black;
        padding:6px;
        text-align:center
    }
    .menu tr:nth-child(2n+1){
        background-color:lightgrey;
    }
    .debt_oper{
        floate:none;
    }
    .debt_oper button{
        width:80px;
        height:30px;
        float:right;
        margin-right:20px;
        border:1px solid red;
    }
</style>
<div id="tabs_debt" class="menu" >
    <ul>
        <li><a href="#fragment-1">Мне должны</a></li>
        <li><a href="#fragment-2">Я должен</a></li>
    </ul>
    <div id="fragment-1">
        <table id = "plusDebt">
        </table>
    </div>
    <div id="fragment-2">
        <table id = "minDebt">
        </table>
    </div>
</div>
<div class="debt_oper">
    <button id="add_debt">Добавить</button>
    <br>
    <br>
    <button id="update_debt" style="margin-top:10px;">Изменить</button>
    <br><br>
    <button id="del_debt" style="margin-top:15px;">Удалить</button>
    <br>
</div>
<!--
<div id="tab_tabl" style="background-color:white;width:85%; margin-left:20px; border:1px solid red; position:relative;top:300px">
    <p>Выплаты</p>

</div>
-->

<div id="dialog" >

    <h3 style="text-align:center; width:100%">Добавить</h3>

    <div id="tabs_dialog">
        <ul>
            <li><a href="#fragment-1">Взять кредит</a></li>
            <li><a href="#fragment-2">Дать в долг</a></li>
        </ul>
        <div id="fragment-1">
            <form action="" method="post" id="debt_tr_form_minus">
                <p>Название:</p>
                <input type="text"  required name="debt_name_tr_minus"><br><br>
                <p>Дата:</p>
                <input type="text" id="add_data_debt_minus" required><br><br>
                <p>Дата окончания:</p>
                <input type="text" id="add_dataEnd_debt_minus" required><br><br>
                <p>Зачислить на счет:</p>
                <select name="cash_minus" id="debt_cash_minus_sel" required >
                </select>
                <br><br>
                <p>Сумма:</p>
                <input type="number" required step="any" name="debt_balance_minus"> <br><br>
                <p>Комментарий:</p>
                <textarea id="dent_comment_minusid" cols="20" rows="5" name="dent_comment_minus"></textarea><br><br>
                <input type="submit" value="Добавить" id="add_tr_debt_one">
            </form>
        </div>
        <div id="fragment-2">
            <p>Название:</p>
            <input type="text"  required name="debt_name_tr_plus"><br><br>
            <p>Дата:</p>
            <input type="text" id="add_data_debt_plus"><br><br>
            <p>Дата окончания:</p>
            <input type="text" id="add_dataEnd_debt_plus"><br><br>
            <p>Списать со счета:</p>
            <select name="cash_minus" id="debt_cash_plus_sel" required >
            </select>
            <br><br>
            <p>Сумма:</p>
            <input type="number" required step="any" name="debt_balance_plus"> <br><br>
            <p>Комментарий:</p>
            <textarea id="dent_comment_plusid" cols="20" rows="5" name="dent_comment_plus"></textarea><br><br>
            <input type="submit" value="Добавить" id="add_tr_debt_two">
        </div>

    </div>


</div>

<script>
    $( "#tabs_debt" ).tabs({
        active: 0,
        event: "click",
        heightStyle: 'content'
    });

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
    $( "#tabs_dialog" ).tabs({
        active: 0,
        event: "click",
        heightStyle: 'content'
    });
    $("#add_data_debt_minus").flatpickr({
        enableTime: true,
        dateFormat: "Y-m-d H:i",
        time_24hr: true
    });
    $("#add_dataEnd_debt_minus").flatpickr({
        enableTime: true,
        dateFormat: "Y-m-d H:i",
        time_24hr: true
    });
    $("#add_data_debt_plus").flatpickr({
        enableTime: true,
        dateFormat: "Y-m-d H:i",
        time_24hr: true
    });
    $("#add_dataEnd_debt_plus").flatpickr({
        enableTime: true,
        dateFormat: "Y-m-d H:i",
        time_24hr: true
    });

    $( "#debt_cash_minus_sel" )
        .selectmenu()
        .selectmenu( "menuWidget" )
        .addClass( "overflow" );

    $( "#debt_cash_minus_sel" ).selectmenu({
        width: 315
    });
    $( "#debt_cash_plus_sel" )
        .selectmenu()
        .selectmenu( "menuWidget" )
        .addClass( "overflow" );

    $( "#debt_cash_plus_sel" ).selectmenu({
        width: 315
    });

    $("#add_debt").click(function(){
        $.post("../controlers/control_tranzactions.php",
            {want_id_cash: "1"},

            function(data){
                data = JSON.parse(data);
                for(i=0,j=3,k=6,vl=1;i<data.length;i+=7,j+=7,k+=7,vl+=7){ // получить имя кошльков
                    $("#debt_cash_minus_sel").append("<option value='"+data[k]+"'>"+data[i]+" ("+data[j]+" "+data[vl]+")</option>").selectmenu('refresh');
                    $("#debt_cash_plus_sel").append("<option value='"+data[k]+"'>"+data[i]+" ("+data[j]+" "+data[vl]+")</option>").selectmenu('refresh');
                    //$("#cash_trans_sum").append("<option value='"+data[k]+"'>"+data[i]+" ("+data[j]+" "+data[vl]+")</option>").selectmenu('refresh');
                    //$("#cash_trans_min").append("<option value='"+data[k]+"'>"+data[i]+" ("+data[j]+" "+data[vl]+")</option>").selectmenu('refresh');
                }
            });

        $("option").remove();
        $("#dialog").dialog('open');
    });


    $("#add_tr_debt_one").click(function(){
        data1=1;data2=1;data3=1;
        if($("#add_data_debt_minus").val()==""){alert("Выберите дату");data1=0;}
        if($("#add_dataEnd_debt_minus").val()==""){alert("Выберите дату окончания");data2=0;}
        if($("#add_data_debt_minus").val() > $("#add_dataEnd_debt_minus").val()){alert("Дата окончания введена неверно");data3=0;}
        if(data1!=0 && data2!=0 && data3!=0){
            $.post(
                "../controlers/control_debt.php",
                {
                    name_debt_minus: $("input[name='debt_name_tr_minus']").val(),
                    data1_debt_minus: $("#add_data_debt_minus").val(),
                    data2_debtend_minus: $("#add_dataEnd_debt_minus").val(),
                    cash_debt_minus: $("#debt_cash_minus_sel").val(),
                    balance_debt_minus: $("input[name='debt_balance_minus']").val(),
                    comment_debt_minus: $("#dent_comment_minusid").val(),
                },
                function(data){
                    alert(data);
                    $("#dialog").dialog('close');
                   // $( "#tabs_debt" ).tabs( "refresh" );
                }
            );
        }
    });

    $("#add_tr_debt_two").click(function(){
        data1=1;data2=1;data3=1;
        if($("#add_data_debt_plus").val()==""){alert("Выберите дату");data1=0;}
        if($("#add_dataEnd_debt_plus").val()==""){alert("Выберите дату окончания");data2=0;}
        if($("#add_data_debt_plus").val() > $("#add_dataEnd_debt_plus").val()){alert("Дата окончания введена неверно");data3=0;}
        if(data1!=0 && data2!=0 && data3!=0){
            $.post(
                "../controlers/control_debt.php",
                {
                    name_debt_plus: $("input[name='debt_name_tr_plus']").val(),
                    data1_debt_plus: $("#add_data_debt_plus").val(),
                    data2_debtend_plus: $("#add_dataEnd_debt_plus").val(),
                    cash_debt_plus: $("#debt_cash_plus_sel").val(),
                    balance_debt_plus: $("input[name='debt_balance_plus']").val(),
                    comment_debt_plus: $("#dent_comment_plusid").val(),
                },
                function(data){
                    alert(data);
                    $("#dialog").dialog('close');
                }
            );
        }
    });

    $(document).ready(function(){
        $.post( // plusDebt == minus
            "../controlers/control_debt.php",
            {wanna_get_debts_minus : "1"},
            function(data){
                //alert(data);
                $("#plusDebt").append("<tr><th>Название</th><th>Дата</th><th>Дата окончания</th><th>Кошелек</th><th>Сумма</th><th>Комментарий</th><th>Пользователь</th></tr>");
                obj = JSON.parse(data);
                for(i=1,j=2,a=3,b=4,c=5,d=6,e=7,il=0;i<obj.length;i+=8,j+=8,a+=8,b+=8,c+=8,d+=8,il+=8,e+=8){
                    $("#plusDebt").append("<tr id='debts"+obj[il]+"' class='debts'>" +"<td id='name'>"+obj[i]+"&nbsp</td>" + "<td id='cash'>"+obj[j]+"</td>"+ "<td>"+obj[a]+"</td>"+  "<td>"+obj[b]+"</td>" + "<td>"+obj[c]+"</td>" +  "<td>"+obj[d]+"</td>"+ "<td>"+obj[e]+"</td>"+"</tr>");
                }
            }
        );
        $.post( // plusDebt == minus
            "../controlers/control_debt.php",
            {wanna_get_debts_plus : "1"},
            function(data){
                //alert(data);
                $("#minDebt").append("<tr><th>Название</th><th>Дата</th><th>Дата окончания</th><th>Кошелек</th><th>Сумма</th><th>Комментарий</th><th>Пользователь</th></tr>");
                obj = JSON.parse(data);
                for(i=1,j=2,a=3,b=4,c=5,d=6,e=7,il=0;i<obj.length;i+=8,j+=8,a+=8,b+=8,c+=8,d+=8,il+=8,e+=8){
                    $("#minDebt").append("<tr id='debts"+obj[il]+"' class='debts'>" +"<td id='name'>"+obj[i]+"&nbsp</td>" + "<td id='cash'>"+obj[j]+"</td>"+ "<td>"+obj[a]+"</td>"+  "<td>"+obj[b]+"</td>" + "<td>"+obj[c]+"</td>" +  "<td>"+obj[d]+"</td>"+ "<td>"+obj[e]+"</td>"+"</tr>");
                }
            }
        );
    });

</script>

<?php
//$part->script_links("../js/index_page.js", "../js/tranz.js");
$part->foot();// Построение подвала страницы
?>
