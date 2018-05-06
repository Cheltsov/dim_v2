<?php
if(!isset($_COOKIE['SingIN'])){
    header('Location:../index.php');
}

require "partpage.php";
require_once "../controlers/control_debt.php";

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
        height: 290px;
        margin-bottom:20px;
    }
    .if-table{
        max-height: 200px;
        overflow: auto;
    }
    .menu table{
        width:100%
    }
    .menu td, th{
        border:1px solid black;
        padding:6px;
        text-align:center
    }
    .menu tr:nth-child(2n+1){
        background-color:lightgrey;
    }

    .minTa{
        height: 300px;
    }

    #minTable{
        width:100%;
    }
    #minTable td, th{
        border:1px solid black;
        padding:6px;
        text-align:center
    }
    #minTable tr:nth-child(2n+1){
        background-color:lightgrey;
    }
    .debt_oper{
        float:none;
    }
    .debt_oper button{
        width:80px;
        height:30px;
        float:right;
        margin-right:20px;
    }
    .tranz_oper{
        float:none;
    }
    .tranz_oper button{
        width:80px;
        height:30px;
        float:right;
        margin-right:20px;
    }
    .add_pay{
        text-align:center
    }
</style>
<div id="tabs_debt" class="menu" >
    <ul>
        <li><a href="#fragment-1">Мне должны</a></li>
        <li><a href="#fragment-2">Я должен</a></li>
    </ul>
    <div id="fragment-1" class="if-table">
        <table id = "plusDebt" >
        </table>
    </div>
    <div id="fragment-2" class="if-table">
        <table id = "minDebt" >
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


<div id="tab_tabl" style="width:100%; margin-left:20px; ">
    <div style="background-color:white; width:85%; float:left" id="tabs_traz" class="minTa">
        <ul>
            <li><a href="#fragment-1">Выплаты</a></li>
        </ul>
        <div id="fragment-1" class="if-table">
            <table id = "minTable" >
            </table>
        </div>
    </div>
    <div class="tranz_oper" style="height:30px; float:right; width:8%; padding-right:45px;margin-top:60px">
        <button id="add_pay">Добавить</button>
        <br><br>
        <button id="up_pay" style="margin-top:10px;">Изменить</button>
        <br><br>
        <button id="del_pay" style="margin-top:15px;">Удалить</button>
    </div>
    <div id="test"></div>
</div>




<div id="dialog" >

    <h3 style="text-align:center; width:100%">Добавить</h3>

    <div id="tabs_dialog">
        <ul>
            <li><a href="#fragment-1">Взять кредит</a></li>
            <li><a href="#fragment-2">Дать в долг</a></li>
        </ul>
        <div id="fragment-1">
            <form action=""  id="debt_tr_form_minus">
                <p>Название:</p>
                <input type="text"  required name="debt_name_tr_minus"><br><br>
                <p>Дата:</p>
                <input type="text" id="add_data_debt_minus" required><br><br>
                <p>Дата окончания:</p>
                <input type="text" id="add_dataEnd_debt_minus" required><br><br>
                <p>Валюта:</p>
                <select name="val_minus" id="add_val_min" required >
                    <option value="EUR">EUR</option>
                    <option value="USD">USD</option>
                    <option value="UAH">UAH</option>
                    <option value="RUR">RUR</option>
                </select>
                <br><br>
                <p>Сумма к выплате:</p>
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
            <p>Валюта:</p>
            <select name="val_plus" id="val_plus" required >
                <option value="EUR">EUR</option>
                <option value="USD">USD</option>
                <option value="UAH">UAH</option>
                <option value="RUR">RUR</option>
            </select>
            <br><br>
            <p>Сумма к выплате:</p>
            <input type="number" required step="any" name="debt_balance_plus"> <br><br>
            <p>Комментарий:</p>
            <textarea id="dent_comment_plusid" cols="20" rows="5" name="dent_comment_plus"></textarea><br><br>
            <input type="submit" value="Добавить" id="add_tr_debt_two">
        </div>

    </div>


</div>

<div id="dialog2" >
    <h3 align="center">Изменить </h3>
    <div id="tabs2">
        <ul>
            <li><a href="#fragment-1">Мне должны</a></li>
            <li><a href="#fragment-2">Я должен</a></li>
        </ul>
        <div id="fragment-1">
                <p>Название:</p>
                <input type="text"  required name="debt_name_up_minus"><br><br>
                <p>Дата:</p>
                <input type="text" id="up_data_debt_minus" required><br><br>
                <p>Дата окончания:</p>
                <input type="text" id="up_dataEnd_debt_minus" required><br><br>
                <p>Валюта:</p>
                <select name="val_minus" id="up_val_min" required >
                    <option value="EUR">EUR</option>
                    <option value="USD">USD</option>
                    <option value="UAH">UAH</option>
                    <option value="RUR">RUR</option>
                </select>
                <br><br>
                <p>Сумма к выплате:</p>
                <input type="number" required step="any" name="debt_up_balance_minus"> <br><br>
                <p>Комментарий:</p>
                <textarea id="dent_comment_minusid" cols="20" rows="5" name="dent_up_comment_minus"></textarea><br><br>
                <input type="submit" value="Изменить" id="up_tr_debt_one">
        </div>
        <div id="fragment-2">
            <form action=""  id="debt_up_form_plus">
                <p>Название:</p>
                <input type="text"  required name="debt_name_up_plus"><br><br>
                <p>Дата:</p>
                <input type="text" id="up_data_debt_plus" required><br><br>
                <p>Дата окончания:</p>
                <input type="text" id="up_dataEnd_debt_plus" required><br><br>
                <p>Валюта:</p>
                <select name="val_plus" id="up_val_plus" required >
                    <option value="EUR">EUR</option>
                    <option value="USD">USD</option>
                    <option value="UAH">UAH</option>
                    <option value="RUR">RUR</option>
                </select>
                <br><br>
                <p>Сумма к выплате:</p>
                <input type="number" required step="any" name="debt_up_balance_plus"> <br><br>
                <p>Комментарий:</p>
                <textarea id="dent_comment_plusid" cols="20" rows="5" name="dent_up_comment_plus"></textarea><br><br>
                <input type="submit" value="Изменить" id="up_tr_debt_two">
            </form>

        </div>
    </div>


</div>

<div id="dialog3" style="text-align:center">
    <p >Вы действительно хотите удалить долг?</p>
    <br>
    <button id="yes">Да</button>
    <button id="no">Нет</button>

</div>

<div id="dialog4" >

    <h3 style="text-align:center; width:100%">Добавить выплату</h3>

    <div id="tabs_dialog4">
        <ul>
            <li><a href="#fragment-1">Расход</a></li>
            <li><a href="#fragment-2">Доход</a></li>
        </ul>
        <div id="fragment-1">
            <form action=""  id="add_pay_m">
                <p>Название:</p>
                <input type="text" required name="add_pay_name_m"><br><br>
                <p>Дата:</p>
                <input type="text" id="add_pay_data_m" required><br><br>
                <p>Кошелек:</p>
                <select name="val_minus" id="add_pay_cash_m" required>
                </select>
                <br><br>
                <p>Сумма</p>
                <input type="number" required step="any" name="add_pay_sum_m"> <br><br>
                <p>Комментарий:</p>
                <textarea id="add_pay_comment_min" cols="20" rows="5" name="add_pay_comment_m"></textarea><br><br>
                <input type="submit" value="Добавить" id="add_pay_one_m">
            </form>
        </div>
        <div id="fragment-2">
            <form action=""  id="add_pay_p">
                <p>Название:</p>
                <input type="text" required name="add_pay_name_p"><br><br>
                <p>Дата:</p>
                <input type="text" id="add_pay_data_p" required><br><br>
                <p>Кошелек:</p>
                <select name="val_minus" id="add_pay_cash_p" required>
                </select>
                <br><br>
                <p>Сумма</p>
                <input type="number" required step="any" name="add_pay_sum_p"> <br><br>
                <p>Комментарий:</p>
                <textarea id="dent_comment_plus" cols="20" rows="5" name="add_pay_comment_p"></textarea><br><br>
                <input type="submit" value="Добавить" id="add_pay_one_p">
            </form>
        </div>
    </div>


</div>

<div id="dialog5" >
    <h3 align="center">Изменить </h3>
    <div id="tabs5">
        <ul>
            <li><a href="#fragment-1">Транзакция</a></li>
        </ul>
        <div id="fragment-1">
            <form action=""  id="up_tr_form_minus">
                <p>Название:</p>
                <input type="text"  required name="up_name_tr_minus"><br><br>
                <p>Дата:</p>
                <input type="text" id="add_data4"><br><br>
                <p>Кошелек:</p>
                <select name="cash_minus" id="up_cash_minus_sel" required >
                </select>
                <br><br>
                <p>Сумма:</p>
                <input type="number" required step="any" name="up_balance_minus"> <br><br>
                <p>Комментарий:</p>
                <textarea id="up_comment" cols="20" rows="5" name="up_comment_minus"></textarea><br><br>
                <input type="submit" value="Изменить" name="add_tr_minus" id="up_sub">
            </form>
        </div>
    </div>


</div>


<script>

    $("#del_pay").click(function(){
        $.post("../controlers/control_debt.php", {
                delete_pay : "1",
                id_tmp_debt : tmp_id,
                id_tr : id_tr
            },
            function(data){
                if(data === "false"){
                    alert("Нельзя удалить");
                }
                else{
                    location.reload(true);
                    alert(data);
                }
            }
        );
    });

    $("#up_sub").click(function(){
        $.post("../controlers/control_debt.php",
            {
                up_name : ucFirst($("input[name='up_name_tr_minus']").val()),
                up_data : $("#add_data4").val(),
                up_cash_min : $("#up_cash_minus_sel").val(),
                up_balance_min : parseFloat($("input[name='up_balance_minus']").val()).toFixed(2),
                up_comment :  ucFirst($("#up_comment").val()),
                up_index : id_tr,
                up_debt :tmp_id,
                update_tranzaction:"1"
            },
            function(data){
                alert("Транзакция обновлена!");
            }
        );
    });


    $("#up_pay").click(function(){

        $("#dialog2").dialog('close');
        $("#dialog3").dialog('close');
        $("#dialog4").dialog('close');
        $("#dialog").dialog('close');

        if(id_tr!=""){
            $.post(
                "../controlers/control_tranzactions.php",
                {
                    want_id_cash: "1"
                },
                function(data){
                    $("#up_cash_minus_sel").empty();
                    data = JSON.parse(data);
                    for(i=2,j=5,k=0,vl=3;i<data.length;i+=10,j+=10,k+=10,vl+=10){ // получить имя кошльков
                        $("#up_cash_minus_sel").append("<option value='"+data[k]+"'>"+data[i]+" ("+parseFloat(data[j]).toFixed(2)+" "+data[vl]+")</option>").selectmenu('refresh');
                    }
                });

            $("option").remove();

            $.post(
                "../controlers/control_tranzactions.php",
                {
                    wanna_info_tranz : "1",
                    id_tr : id_tr,
                },
                function(data){
                    data = JSON.parse(data);
                    if(data != false){
                        $("input[name='up_name_tr_minus']").val(ucFirst(data[1]));
                        $("#add_data4").val(data[6]);
                        $("#up_cash_minus_sel").val(data[2]).selectmenu('refresh');
                        $("input[name='up_balance_minus']").val(data[3]);
                        $("#up_comment").val(ucFirst(data[4]));
                        $("input[name='up_name_tr_sum']").val(data[1]);
                        $("#add_data5").val(data[6]);
                        $("#up_cash_sum_sel").val(data[2]).selectmenu('refresh');
                        $("input[name='up_balance_sum']").val(data[3]);
                        $("#up_comment_sum").val(ucFirst(data[4]));
                    }
                    else{
                        alert("Нельзя изменить транзакцию");
                        return ;
                    }
                }
            );
            $("#dialog5").dialog('open');
        }
        else alert("Выберите транзакцию!");
    });


    $("#add_pay").click(function(){
        if(tmp_id !=""){
            $.post(
                "../controlers/control_debt.php",
                {
                    getCash: "1"
                },
                function(data){
                    data = JSON.parse(data);
                    $("#add_pay_cash_p").empty();
                    $("#add_pay_cash_m").empty();
                    for(i=2,j=5,k=0,vl=3;i<data.length;i+=10,j+=10,k+=10,vl+=10) { // получить имя кошльков
                        $("#add_pay_cash_p").append("<option value='" + data[k] + "'>" + data[i] + " (" + parseFloat(data[j]).toFixed(2) + " " + data[vl] + ")</option>");
                        $("#add_pay_cash_m").append("<option value='" + data[k] + "'>" + data[i] + " (" + parseFloat(data[j]).toFixed(2) + " " + data[vl] + ")</option>");
                    }
                }
            );

            $.post(
                "../controlers/control_debt.php",
                {getDebt:"1", id_debt_st:tmp_id},
                function(data){
                    obj = JSON.parse(data);
                    $("#add_pay_data_m").flatpickr({
                        enableTime: true,
                        dateFormat: "Y-m-d H:i",
                        time_24hr: true,
                        minDate: obj[2]
                    });
                }
            );

            $.post(
                "../controlers/control_debt.php",
                {getSt :"1", id_debt_status:tmp_id},
                function(data){
                    if(data == "plus"){
                        $("#tabs_dialog4").tabs("disable", 1);
                        $("#tabs_dialog4").tabs("enable", 0);
                        $("#tabs_dialog4").tabs("option", "active", 0);
                    }
                    if(data == "minus"){
                        $("#tabs_dialog4").tabs("disable", 0);
                        $("#tabs_dialog4").tabs("enable", 1);
                        $("#tabs_dialog4").tabs("option", "active", 1);
                    }
                }
            );
            $("#dialog4").dialog("open");
        }
        else alert("Выберите долг");
    });



    $("#add_pay_one_m").click(function(){
        if($('#add_pay_data_m').val() == "") alert("Введите дату");
        else{
            $.post(
                "../controlers/control_debt.php",
                {
                    add_pay_name_m : $("input[name='add_pay_name_m']").val(),
                    add_pay_data_m : $("#add_pay_data_m").val(),
                    add_pay_cash_m : $("#add_pay_cash_m").val(),
                    add_pay_sum_m : $("input[name='add_pay_sum_m']").val(),
                    add_pay_comment_m : $("#add_pay_comment_min").val(),
                    add_debt_id : tmp_id,
                },
                function(data){
                    alert(data);
                    $("#test").append(data);
                }
            );
        }
    });

$("#add_pay_one_p").click(function(){
    if($('#add_pay_data_p').val() == "") alert("Введите дату");
    else{
        $.post(
            "../controlers/control_debt.php",
            {
                add_pay_name_p : $("input[name='add_pay_name_p']").val(),
                add_pay_data_p : $("#add_pay_data_p").val(),
                add_pay_cash_p : $("#add_pay_cash_p").val(),
                add_pay_sum_p : $("input[name='add_pay_sum_p']").val(),
                add_pay_comment_p : $("#dent_comment_plus").val(),
                add_debt_id : tmp_id,
            },
            function(data){
                alert(data);
            }
        );
    }
});

    $("#minTable").on("click",'.col', function(){
        if($(this).css("background-color") == 'rgb(0, 159, 227)'){
            var li = $(".col"), i = li.length;
            while(i--) {
                li[i].style.backgroundColor = i%2 ? 'lightgrey' : 'white';
                tmp_id ="";
                index = "";
            }
            return false;
        }
        else{
            var li = $(".col"), i = li.length;
            while(i--) {
                li[i].style.backgroundColor = i%2 ? 'lightgrey' : 'white';
            }
            id_tr ="";
            index = "";
            string = this.id;
            str = string.split('');
            for(i=2;i<str.length;i++){
               id_tr += str[i];
            }
            flag_ts = "111";
            document.getElementById(string).style.backgroundColor = "#009fe3";
        }


    });


    $("#update_debt").click(function(){
        if(tmp_id != ""){
            $.post(
                "../controlers/control_debt.php",
                {
                    update_index : tmp_id,
                },
                function(data){
                    obj = JSON.parse(data);
                    if(obj[9] == 'minus'){
                        $("#tabs2").tabs("disable",1);
                        $("#tabs2").tabs("enable",0);
                        $( "#tabs2" ).tabs( "option", "active", 0 );
                        $("input[name='debt_name_up_minus']").val(ucFirst(obj[1]));
                        $("#up_data_debt_minus").val(obj[2]);
                        $("#up_dataEnd_debt_minus").val(obj[3]);
                        $("#up_val_min").val(obj[4]);
                        $("input[name='debt_up_balance_minus']").val(obj[5]);
                        $("textarea[name='dent_up_comment_minus']").val(obj[7]);
                    }
                    if(obj[9] == 'plus'){
                        $("#tabs2").tabs("disable",0);
                        $("#tabs2").tabs("enable",1);
                        $( "#tabs2" ).tabs( "option", "active", 1 );
                        $("input[name='debt_name_up_plus']").val(ucFirst(obj[1]));
                        $("#up_data_debt_plus").val(obj[2]);
                        $("#up_dataEnd_debt_plus").val(obj[3]);
                        $("#up_val_plus").val(obj[4]);
                        $("input[name='debt_up_balance_plus']").val(obj[5]);
                        $("textarea[name='dent_up_comment_plus']").val(obj[7]);
                    }
                }
            );
            $("#dialog2").dialog("open");
        }
        else alert("Выберите долг!");
    });

    $("#up_tr_debt_one").click(function(){
        $.post(
            "../controlers/control_debt.php",
            {
                up_id_debt: tmp_id,
                up_name_debt : $("input[name='debt_name_up_minus']").val(),
                up_data_start_debt  : $("#up_data_debt_minus").val(),
                up_data_end_debt  : $("#up_dataEnd_debt_minus").val(),
                up_type_money_debt  : $("#up_val_min").val(),
                up_balance_debt  : $("input[name='debt_up_balance_minus']").val(),
                up_comment_debt  : $("textarea[name='dent_up_comment_minus']").val()
            },
            function(data){
                alert(data);
                location.reload(true);
            }
        );
    });

    $("#up_tr_debt_two").click(function(){
        $.post(
            "../controlers/control_debt.php",
            {
                up_id_debt_minus: tmp_id,
                up_name_debt_minus : $("input[name='debt_name_up_plus']").val(),
                up_data_start_debt_minus  : $("#up_data_debt_plus").val(),
                up_data_end_debt_minus  : $("#up_dataEnd_debt_plus").val(),
                up_type_money_debt_minus  : $("#up_val_plus").val(),
                up_balance_debt_minus  : $("input[name='debt_up_balance_plus']").val(),
                up_comment_debt_minus  : $("textarea[name='dent_up_comment_plus']").val()
            },
            function(data){
                alert(data);
                location.reload(true);
            }
        );
    });


    tmp_id="";
    id_tr ="";

    $("#plusDebt, #minDebt").on("click",'.debts', function(){
        if($(this).css("background-color") == 'rgb(0, 159, 227)'){
            var li = $(".debts"), i = li.length;
            while(i--) {
                li[i].style.backgroundColor = i%2 ? 'lightgrey' : 'white';
                tmp_id ="";
                index = "";
                $("#minTable").empty();
            }
            return false;
        }
        else{
            var li = $(".debts"), i = li.length;
            while(i--) {
                li[i].style.backgroundColor = i%2 ? 'lightgrey' : 'white';
            }
            tmp_id ="";
            index = "";
            string = this.id;
            str = string.split('');
            for(i=5;i<str.length;i++){
                tmp_id += str[i];
            }
            flag_ts = "111";
            document.getElementById(string).style.backgroundColor = "#009fe3";

            $.post(
                "../controlers/control_debt.php",
                {
                    getEnumTr : "1",
                    debt_id:tmp_id
                },
                function(data){

                    $("#minTable").empty();
                    $("#minTable").append("<tr><th>Название</th><th>Кошелек</th><th>Сумма</th><th>Комментарий</th><th>Дата</th></tr>");
                    data = JSON.parse(data);
                    for(item=0;item<data.length;item++){
                        for(i=1,j=2,a=3,b=4,c=7,d=6,il=0;il<data.length;i+=7,j+=7,a+=7,b+=7,c+=7,d+=7,il+=7){
                            $("#minTable").append("<tr id='tr"+data[item][il]+"' class='col'>" +"<td id='name'>"+ucFirst(data[item][i])+"&nbsp</td>" + "<td id='cash'>"+ucFirst(data[item][j])+"</td>"+ "<td>"+parseFloat(data[item][a]).toFixed(2)+"</td>"+  "<td>"+ucFirst(data[item][b])+"</td>" + "<td>"+data[item][d]+"</td>"+"</tr>");
                        }
                    }

                }
            );
        }


    });


    $("#del_debt").click(function(){
        $("#dialog").dialog('close');
        if(!tmp_id){
            alert("Выберите долг!");
            return;
        }
        else{
            $("#dialog3").dialog('open');

            $("#no").click(function(){
                $("#dialog3").dialog('close');
            });

            $("#yes").click(function(){
                if(flag_ts == "111"){
                    $.post("../controlers/control_debt.php", {
                            del_trans : "1",
                            index_debt : tmp_id
                        },
                        function(data){
                            alert(data);
                            location.reload(true);
                            $("#dialog3").dialog('close');
                        }
                    );
                    flag_ts = "";
                }
            });

        }

    });

//alert($("#tabs_debt").tabs( "option" ));


    year = new Date().getFullYear();
    month = new Date().getMonth()+1;
    day = new Date().getDay();
    date_now = year+"-"+month+"-"+day;

    $( "#tabs_debt" ).tabs({
        active: 0,
        event: "click",
        heightStyle: 'content'
    });


    $("#tabs_traz").tabs({
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

    $('#dialog4').dialog({
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

    $('#dialog5').dialog({
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

    $('#dialog2').dialog({
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

    $('#dialog3').dialog({
        autoOpen: false,
        show: {effect: 'drop', duration: 500},
        hide: {effect: 'clip', duration: 500},
        width: 350
    });

    $( "#tabs2" ).tabs({
        active: 0,
        event: "click",
        heightStyle: 'content'
    });

    $( "#tabs5" ).tabs({
        active: 0,
        event: "click",
        heightStyle: 'content'
    });

    $( "#tabs_dialog" ).tabs({
        active: 0,
        event: "click",
        heightStyle: 'content'
    });
    $( "#tabs_dialog4" ).tabs({
        active: 0,
        event: "click",
        heightStyle: 'content'
    });

    $("#add_data_debt_minus").flatpickr({
        enableTime: true,
        dateFormat: "Y-m-d H:i",
        time_24hr: true
    });



$("#add_pay_data_p").flatpickr({
    enableTime: true,
    dateFormat: "Y-m-d H:i",
    time_24hr: true
});

$("#up_data_debt_minus").flatpickr({
    enableTime: true,
    dateFormat: "Y-m-d H:i",
    time_24hr: true
});

$("#up_dataEnd_debt_minus").flatpickr({
    enableTime: true,
    dateFormat: "Y-m-d H:i",
    time_24hr: true
});


    $("#up_data_debt_plus").flatpickr({
        enableTime: true,
        dateFormat: "Y-m-d H:i",
        time_24hr: true
    });

    $("#up_dataEnd_debt_plus").flatpickr({
        enableTime: true,
        dateFormat: "Y-m-d H:i",
        time_24hr: true
    });

    $("#add_data4").flatpickr({
        enableTime: true,
        dateFormat: "Y-m-d H:i",
        time_24hr: true
    });

    $("#add_dataEnd_debt_minus").flatpickr({
        enableTime: true,
        dateFormat: "Y-m-d H:i",
        time_24hr: true,
        minDate: date_now,
    });
    $("#add_data_debt_plus").flatpickr({
        enableTime: true,
        dateFormat: "Y-m-d H:i",
        time_24hr: true
    });
    $("#add_dataEnd_debt_plus").flatpickr({
        enableTime: true,
        dateFormat: "Y-m-d H:i",
        time_24hr: true,
        minDate: date_now,
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
                    type_money_minus: $("#add_val_min").val(),
                    balance_debt_minus: $("input[name='debt_balance_minus']").val(),
                    comment_debt_minus: $("#dent_comment_minusid").val(),
                },
                function(data){
                    alert(data);
                    $("#dialog").dialog('close');
                    location.reload(true);
                }
            );
        }
    }); // cin

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
                    type_money_plus: $("#val_plus").val(),
                    balance_debt_plus: $("input[name='debt_balance_plus']").val(),
                    comment_debt_plus: $("#dent_comment_plusid").val(),
                },
                function(data){
                    alert(data);
                    $("#dialog").dialog('close');
                    location.reload(true);
                }
            );
        }
    }); //cin

    $(document).ready(function(){
        $.post( // plusDebt == minus
            "../controlers/control_debt.php",
            {wanna_get_debts_minus : "1"},
            function(data){
                $("#plusDebt").append("<tr><th>Название</th><th>Сумма к выплате</th><th>Выплачено</th><th>Остаток</th><th>Процент</th><th>Дата</th><th>Дата окончания</th><th>Комментарий</th></tr>");
                obj = JSON.parse(data);
                for(i=1,j=2,a=3,b=4,c=5,d=6,e=7,il=0;i<obj.length;i+=9,j+=9,a+=9,b+=9,c+=9,d+=9,il+=9,e+=9){
                    var pay_del = obj[c] - obj[d];
                    var prec =100/(obj[c]/obj[d]);
                    if(prec<0) prec=0;
                    if(prec>100) prec =100;
                    $("#plusDebt").append("<tr id='debts"+obj[il]+"' class='debts'>" +"<td id='name'>"+ucFirst(obj[i])+"&nbsp</td>"  + "<td>"+parseInt(obj[c]).toFixed(2)+" ("+obj[b]+")</td>" + "<td>"+parseInt(obj[d]).toFixed(2)+"</td><td>"+parseInt(pay_del).toFixed(2)+"</td>"+"<td>"+prec.toFixed(2)+"%</td>"+"<td>"+obj[j]+"</td>"+ "<td>"+obj[a]+"</td>"+ "<td>"+ucFirst(obj[e])+"</td>"+"</tr>");
                }
            }
        );
        $.post( // plusDebt == minus
            "../controlers/control_debt.php",
            {wanna_get_debts_plus : "1"},
            function(data){
                //alert(data);
                $("#minDebt").append("<tr><th>Название</th><th>Сумма к выплате</th><th>Выплачено</th><th>Остаток</th><th>Процент</th><th>Дата</th><th>Дата окончания</th><th>Комментарий</th></tr>");
                obj = JSON.parse(data);
                for(i=1,j=2,a=3,b=4,c=5,d=6,e=7,il=0;i<obj.length;i+=9,j+=9,a+=9,b+=9,c+=9,d+=9,il+=9,e+=9){
                    var pay_del = obj[c] - obj[d];
                    var prec =100/(obj[c]/obj[d]);
                    if(prec<0) prec=0;
                    if(prec>100) prec =100;
                    $("#minDebt").append("<tr id='debts"+obj[il]+"' class='debts'>" +"<td id='name'>"+ucFirst(obj[i])+"&nbsp</td>"  + "<td>"+parseInt(obj[c]).toFixed(2)+" ("+obj[b]+")</td>" + "<td>"+parseInt(obj[d]).toFixed(2)+"</td><td>"+parseInt(pay_del).toFixed(2)+"</td>"+"<td>"+prec.toFixed(2)+"%</td>"+"<td>"+obj[j]+"</td>"+ "<td>"+obj[a]+"</td>"+ "<td>"+ucFirst(obj[e])+"</td>"+"</tr>");
                }
            }
        );
    }); // cout


    $( "#up_cash_minus_sel" )
        .selectmenu()
        .selectmenu( "menuWidget" )
        .addClass( "overflow" );

    $( "#up_cash_minus_sel" ).selectmenu({
        width: 315
    });


    function ucFirst(str) {
        if (!str) return str;
        return str[0].toUpperCase() + str.slice(1);
    }

</script>

<?php
//$part->script_links("../js/index_page.js", "../js/tranz.js");
$part->foot();// Построение подвала страницы
?>
