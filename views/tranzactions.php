<?php
if(!isset($_COOKIE['SingIN'])){
    header('Location:../index.php');
}
require "../controlers/control_main_page.php";

//require "../controlers/control_tranzactions.php";



if(!isset($_COOKIE['SingIN'])){
    header('Location:../index.php');
}
require "partpage.php";
$part = new partPage();
$part->PreLoader();
echo("<title>Ledger - Транзакции</title>");
$part->head();
echo('<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css">');
$part->arr_links("mainpage.css", "tranz_style.css" );
$part->script_links("https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js", "../js/accordion.js", "../js/tabs.js", "../libs/cellSelection.min.js");
?>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css">
<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.12/datatables.min.js"></script>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.3.2/flatpickr.min.js"></script>
<link rel="stylesheet" type="text/css" href="../libs/node_modules/flatpickr/dist/themes/material_blue.css">
<script src="../libs/node_modules/flatpickr/dist/flatpickr.js"></script>

<!--<script src="../libs/cellSelection.min.js"></script>-->

<style>

    .but_forCash{
        border:1px solid white;
        text-align:left;
        font-size:16pt;
        background-color:#009fe3;
        color:white;
    }

    .accord{
        /* padding-top:50px;*/
        width:100%;
        float:left;

    }
    .accord h3{
        width:300px;
        background-color:lightgrey;
    }
    .accord div{
        width:244px;

    }
    .but_forCash:hover{
        border:2px solid blue;
    }
    .balance{
        float:left;
        /*border:1px solid green;*/
        width:350px;
    }
    .balance button{
        width:100%;
    }
    .menu{
        /*height:650px;*/
        /*background-color:white;*/
        width:65%;
        float:left;
        margin-right:20px;
        margin-left: 2px;
        max-height: 620px;
    }
    .menu td{
        border:1px solid black
    }
    .menu tr:nth-child(2n+1) {
        background: lightgrey; /* Цвет фона */
    }
    .menu tr:hover{
        background: grey;
    }
    .menu h3{
        padding-left:5px;
        height:30px;
        font-size:16pt;
        background-color:DarkSlateBlue;
        color:lightgrey;
        cursor: pointer

    }
    #fragment-1, #fragment-2, #fragment-3{
    	max-height: 540px;
    	overflow: auto;
    }
    .ui-tabs .ui-tabs-nav{
    	margin-bottom: 15px; !important
    }
    .ui-tabs .ui-tabs-panel{
    	padding:0 1.4em;
    }
    .in_conv{
        float:right;
        margin-rigth:10px;
    }
</style>


<div id="menu" class="balance" style="max-height:610px; overflow:auto; width:23%; margin-right:10px;">
    <button id="all_bal">Все транзакции </button>
    <br><br>
    <button class="but_forCash">Наличные</button>
    <ul id="hands">

    </ul>
    <button class="but_forCash">Карта</button>
    <ul id="cards">

    </ul>
    <br>
    <div id="conversion">
        <button>Пересчетать</button>
    </div>
    <br>
    <button class="but_forCash" id="but_forCash_month">Наличные</button>
    <ul id="hands_month">

    </ul>
    <button class="but_forCash" id="but_forCash_month_card">Карта</button>
    <ul id="cards_month">

    </ul>
</div>

<!--
<div class="balance">
    <button id="all_bal">Все транзакции </button>
    <br>
    <br>
    <div id="accordion" class="accord" >

        <h3>Наличные:</h3>
        <div id="hands">

        </div>
        <h3>Карта:</h3>
        <div id="cards">

        </div>

    </div>
</div>
-->


<div id="tabs_tables" class="menu">
    <ul>
        <li><a href="#fragment-1">Расходы</a></li>
        <li><a href="#fragment-2">Доходы</a></li>
        <li><a href="#fragment-3">Переводы</a></li>
    </ul>
    <div id="fragment-1">
        <table id = "minTable">
        </table>
    </div>
    <div id="fragment-2">
        <table id = "plusTable">
        </table>
    </div>
    <div id="fragment-3">
        <table id = "transTable">
        </table>
    </div>
</div>

<script>
    $(document).ready(function(){
        $( "#tabs_tables" ).tabs({
            active: 0,
            event: "click",
            heightStyle: 'content',
        });

    });
</script>


<style>
    .col:hover{
         background-color:lightgrey;
     }
    th{
        padding:6px;
    }
    td{
        padding:6px;
        text-align:center
    }
    table{
        width:100%
    }
</style>

<div style="float:right">
    <button id="add_tr">Добавить</button>
    <br>
    <br>
    <button id="up_tr">Изменить</button>
    <br><br>
    <button id="del_tr">Удалить</button>
    <br>
    <br>
    <button id="test_tr">Test</button>
    <br>
</div>




<div id="dialog3" style="text-align:center">
    <p >Вы действительно хотите удалить транзакцию?</p>
    <br>
    <button id="yes">Да</button>
    <button id="no">Нет</button>

</div>


<div id="dialog_conv">
    <h3>Пересчетать финансовые стредства</h3>
    <br>
    <form action="" id="name_cash">

    </form>
</div>

<div id="content_test" style="margin:150px; float:none"></div>






<div id="dialog" >

    <h3 style="text-align:center; width:100%">Добавить</h3>

  <div id="tabs">
        <ul>
            <li><a href="#fragment-1">Расход</a></li>
            <li><a href="#fragment-2">Доход</a></li>
            <li><a href="#fragment-3" id="add_translate">Перевод</a></li>
        </ul>
        <div id="fragment-1">

            <form action="" method="post" id="tr_form_minus">
                <p>Название:</p>
                <input type="text"  required name="name_tr_minus"><br><br>
                <p>Дата:</p>
                <input type="text" required id="add_data"><br><br>
                <p>Кошелек:</p>
                <select name="cash_minus" id="cash_minus_sel" required >
                </select>
                <br><br>


                <p>Сумма:</p>
                <input type="number" required step="any" name="balance_minus"> <br><br>
                <p>Комментарий:</p>
                <textarea id="" cols="20" rows="5" name="comment_minus"></textarea><br><br>
                <input type="submit" value="Добавить" name="add_tr_minus" id="sub">
            </form>
        </div>
        <div id="fragment-2">

            <form action="" method="post" id="tr_form_sum">
                <p>Название:</p>
                <input type="text"  required name="name_tr_sum"><br><br>
                <p>Дата:</p>
                <input type="text" required id="add_data2"><br><br>
                <p>Кошелек:</p>
                <select name="cash_sum" id="cash_sum_sel" required >
                </select>
                <br><br>

                <p>Сумма:</p>
                <input type="number"  step="any" name="balance_sum"> <br><br>
                <p>Комментарий:</p>
                <textarea id="" cols="20" rows="5" name="comment_sum"></textarea><br><br>
                <input type="submit" value="Добавить" name="add_tr_sum" id="sub">
            </form>

        </div>
        <div id="fragment-3">
            <form action="" method="post" id="trans_from">
                <p>Название:</p>
                <input type="text"  required name="name_trans_cash">
                <p>Дата:</p>
                <input type="text" required id="add_data3" >
                <p>Cписать:</p>
                <select name="cash_trans_min" id="cash_trans_min" >
                </select>
                <p>Сумма:</p>
                <input type="number"  step="any" name="trans_balance_min" required >

                <p>Зачислить:</p>
                <select name="cash_trans_sum" id="cash_trans_sum"   >
                </select>
                <p>Курс:</p>
                <input type="number"  step="any" name="course" required  >
                <p>Сумма:</p>
                <input type="number"  step="any" name="trans_balance_sum" required >
                <p>Комментарий:</p>
                <textarea id="" cols="20" rows="5" name="comment_trans"></textarea><br><br>
                <input type="submit" value="Добавить" name="add_tr_sum" id="sub">
            </form>

        </div>
    </div>


</div>


<div id="dialog2" >
    <h3 align="center">Изменить </h3>
<div id="tabs2">
    <ul>
        <li><a href="#fragment-1">Расход</a></li>
        <li><a href="#fragment-2">Доход</a></li>
        <li><a href="#fragment-3">Перевод</a></li>
    </ul>
    <div id="fragment-1">
        <form action="" method="post" id="up_tr_form_minus">
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
    <div id="fragment-2">
        <form action="" method="post" id="up_tr_form_sum">
            <p>Название:</p>
            <input type="text"  required name="up_name_tr_sum"><br><br>
            <p>Дата:</p>
            <input type="text" id="add_data5"><br><br>
            <p>Кошелек:</p>
            <select name="cash_sum" id="up_cash_sum_sel" required >
            </select>
            <br><br>

            <p>Сумма:</p>
            <input type="number"  step="any" name="up_balance_sum"> <br><br>
            <p>Комментарий:</p>
            <textarea id="up_comment_sum" cols="20" rows="5" name="up_comment_sum"></textarea><br><br>
            <input type="submit" value="Изменить" name="add_tr_sum" id="up_sub">
        </form>

    </div>
    <div id="fragment-3">
        <form action="" method="post" id="up_trans_from">
            <p>Название:</p>
            <input type="text"  required name="up_name_trans_cash">
            <p>Дата:</p>
            <input type="text" id="add_data6" >
            <p>Cписать:</p>
            <select name="up_cash_trans_min" id="up_cash_trans_min" >
            </select>
            <p>Сумма:</p>
            <input type="number"  step="any" name="up_trans_balance_min" required >

            <p>Зачислить:</p>
            <select name="up_cash_trans_sum" id="up_cash_trans_sum"   >
            </select>
            <p>Курс:</p>
            <input type="number"  step="any" name="up_course" required  >
            <p>Сумма:</p>
            <input type="number"  step="any" name="up_trans_balance_sum" required >
            <p>Комментарий:</p>
            <textarea id="up_comment_trans" cols="20" rows="5" name="comment_trans"></textarea><br><br>
            <input type="submit" value="Изменить" name="add_tr_sum" id="sub">
        </form>

    </div>

</div>


</div>



<style>

</style>
<script>


    //-------------------------------------------------------------------------------------

    $("#test_tr").click(function(){
        //Запрос на добавление дополнительной транзакции
        $.post(
            "../controlers/control_tranzactions.php",
            {test_event: "1"},
            function(data){
                alert(data);
                location.reload();
            }
        );


    });

    $(document).ready(function(){
        $.post(
            "../controlers/control_tranzactions.php",
            {wanna_cash_month: "1"},
            function(data){
                $("#but_forCash_month").trigger("click");
                $("#but_forCash_month_card").trigger("click");
                data = JSON.parse(data);
                for(i=0,n=1,tm=2,tc=3,b=4;i<data.length;i+=5,n+=5,tm+=5,tc+=5,b+=5){
                    if(data[tc]==1){

                        $("#hands_month").append("<li><button class='type' id='cashm_"+data[i]+"'>"+data[n]+":"+data[b]+" ("+data[tm]+") </button></li>");
                    }
                    if(data[tc]==2){
                        $("#cards_month").append("<li><button class='type' id='cashm_"+data[i]+"'>"+data[n]+":"+data[b]+" ("+data[tm]+") </button></li>");
                    }
                }
            }
        );
    });

    $('#dialog_conv').dialog({
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

    $("#conversion").click(function(){
        $.post("../controlers/control_tranzactions.php",
            {conv : "1"},
            function(data){
                var obj = JSON.parse(data);
                for(i=0,j=2,v=3,b=5;i<obj.length;i+=10,j+=10,v+=10,b+=10){
                    $("#name_cash").append("<label>"+obj[j]+"("+obj[v]+")</label>&nbsp<input type='number' id='cov"+obj[i]+"' class='in_conv' step='any' name='cov_bal' value='"+obj[b]+"'><br><br>");
                }
                $("#name_cash").append("<button id = 'add_conv'>Добавить</button>");
            }
        );
        $("#dialog_conv").dialog('open');
    });

    var ary = [];
    cashs_json = "";

    $("#name_cash").on("click keyup",".in_conv",function(){


        id_cash = $(this).attr("id").substring(3);
        bal = $(this).val();

        var obj = {};
        obj[id_cash] = bal;
        ary.push(obj);
        for (var key in ary) {
            for (var key2 in ary[key]){
                console.log("k= "+key2+" rr="+ary[key][key2]);
                if(key2 == id_cash){
                    ary[key][key2] = bal;
                }
            }
        }





        cashs_json = JSON.stringify(ary);
    });




    $("#name_cash").on("click","#add_conv",function(){
        $("#name_cash").empty();
        alert(cashs_json);
        $.post(
            "../controlers/control_tranzactions.php",
            { na_cashs_josn : cashs_json},
            function(data){
                alert(data);
                //location.reload();
            }
        );
    });








</script>

<?php
$part->script_links("../js/tranz.js");
$part->foot();
?>
