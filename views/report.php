<?php
if(!isset($_COOKIE['SingIN'])){
    header('Location:../index.php');
}
require "../controlers/control_main_page.php";


require "partpage.php";
$part = new partPage();
$part->PreLoader();
echo("<title>Ledger - Отчеты</title>");
$part->head();
echo('<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css">');
$part->arr_links("mainpage.css", "report_style.css" );
$part->script_links("https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js", "../js/accordion.js", "../js/tabs.js", "../libs/cellSelection.min.js","https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js");
?>

    <select id="month" style="position:relative; top:-40px">
    </select>
<div>
    <select id="chose">
        <option value="1">Расходы</option>
        <option value="2">Доходы</option>
    </select>
    <select id="chose_schedule">
        <option value="1">Line</option>
        <option value="2">Pie</option>
    </select>

</div>
    <br>
    <br>

<div style="width:65%;height:500px; color:white; background-color:white; float:left;">
    <canvas id="myChart" ></canvas>
    <canvas id="secChart" ></canvas>
</div>
    <div id="tranzaction_label" style="max-height:488px; overflow:auto; background-color:white; float:right; color:black; margin-right:30px; width:30%; font-size:12pt;  border-radius:10px;">
    </div>

    <!--
    <div id="content" style="color:black;">
        <h3>При нажатии на вершину графика вывести в блок имени транзакции, а также дополнительные параметры</h3>
        <h3>При получении баланса конвертировать валюту</h3>
        <h3>При наведении на вершину убрать квадрат</h3>
        <h3>Добавить круговой график</h3>
</div>
-->



    <script>

        $("#month").change(function(){
            if($("#chose_schedule").val()==1){
                if( $("#chose").val() == 1){
                    myLineChart.data.datasets[0].data = [];
                    myLineChart.data.labels = [];
                    myLineChart.data.datasets[0].borderColor = 'blue';
                    myLineChart.data.datasets[0].label =  "Расход";

                    $.post(
                        "../controlers/control_report.php",
                        {
                            wanna_info_tr_min : "1",
                            data:  $("#month").val()
                        },
                        function(data){
                            //alert(data);
                            $("#content").empty();
                            var obj = JSON.parse(data);
                            for(i=0;i<obj.length;i++){
                                myLineChart.data.labels[i] = obj[i]["date"];
                                myLineChart.data.datasets[0].data[i] = obj[i]["balance"];
                               // $("#content").append("name = "+ucFirst(obj[i]['name'])+" || data = "+obj[i]['date']+" || balance = "+obj[i]["balance"]+"<br>");
                            }
                            myLineChart.update();
                        }
                    );
                }
                else if($("#chose").val() == 2){
                    myLineChart.data.datasets[0].data = [];
                    myLineChart.data.labels = [];
                    myLineChart.data.datasets[0].borderColor = 'red';
                    myLineChart.data.datasets[0].label =  "Доход";

                    $.post(
                        "../controlers/control_report.php",
                        {
                            wanna_info_tr_plus : "1",
                            data:  $("#month").val()
                        },
                        function(data){
                            $("#content").empty();
                            var obj = JSON.parse(data);
                            for(i=0;i<obj.length;i++){
                                myLineChart.data.labels[i] = obj[i]["date"];
                                myLineChart.data.datasets[0].data[i] = obj[i]["balance"];
                               // $("#content").append("name = "+ucFirst(obj[i]['name'])+" || data = "+obj[i]['date']+" || balance = "+obj[i]["balance"]+"<br>");
                            }
                            myLineChart.update();
                        }
                    );
                }
            }
            if($("#chose_schedule").val()==2){
                PieChart();
            }
        });

        $(document).ready(function(){
            var monthNames = ["January", "February", "March", "April", "May", "June",
                "July", "August", "September", "October", "November", "December"
            ];
            //day = new Date();
           // $("#month").append("<option selected value="+(day.getMonth()+1)+">"+monthNames[parseInt(day.getMonth())]+"</option>");
            $.post(
                "../controlers/control_report.php",
                {cont:"1"},
                function(data){
                   var obj = JSON.parse(data);
                    $("#month").empty();
                    for(i=0;i<obj.length;i++){
                        $("#month").append("<option value='"+(i+1)+"'>"+monthNames[parseInt(obj[i])-1]+"</option>");
                        $("#month").val((i+1));
                    }
                });


        });
    </script>



    <script>
        $(document).ready(function(){
            $( "#chose" ).trigger( "change" );
        });
        var canvas = $('#myChart');
        var data = {
            //labels: ["January", "February", "March", "April", "May", "June", "July"],
            datasets: [
                {
                    label: "Расход",
                    fill: false,
                    lineTension: 0,
                    backgroundColor: "rgba(75,192,192,0.4)",
                    borderColor: "rgba(75,192,192,1)",
                    borderCapStyle: 'butt',
                    borderDash: [],
                    borderDashOffset: 0.0,
                    borderJoinStyle: 'miter',
                    pointBorderColor: "rgba(75,192,192,1)",
                    pointBackgroundColor: "#fff",
                    pointBorderWidth: 1,
                    pointHoverRadius: 5,
                    pointHoverBackgroundColor: "rgba(75,192,192,1)",
                    pointHoverBorderColor: "rgba(220,220,220,1)",
                    pointHoverBorderWidth: 2,
                    pointRadius: 5,
                    pointHitRadius: 10,
                    //data: [65, 59, 80, 0, 56, 55, 40],
                }
            ]
        };

        var myLineChart = Chart.Line(canvas,{
            data:data,
            options:{
                showLines: true,
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                },
                events:['click',"mousemove"],
                onClick: function(evt){
//                    alert(myLineChart.data.labels[this]);
//                    alert(myLineChart.data.labels);
                    var activePoints = myLineChart.getElementsAtEvent(evt);
                    if(activePoints.length > 0) {
                        //get the internal index of slice in pie chart
                        var clickedElementindex = activePoints[0]["_index"];
                        //get specific label by index
                        var label = myLineChart.data.labels[clickedElementindex];
                        //get value by index
                        var value = myLineChart.data.datasets[0].data[clickedElementindex];
                    }
                    $.post(
                        "../controlers/control_report.php",
                        {
                            label: label,
                        },
                        function(data){
                           // alert(data);
                            var obj = JSON.parse(data);

                            $("#tranzaction_label").empty();
                            $("#tranzaction_label").css("padding-left","10px");
                            $("#tranzaction_label").css("padding-bottom","10px");
                            for(i=0;i<obj.length;i++) {
                                //$tmp = "";
                               // alert(obj[i]['status']);
                                if(obj[i]['status'] == "minus") $tmp = "расход";
                                if(obj[i]['status'] == "plus") $tmp = "доход";
                                $("#tranzaction_label").append("<br>Название = "+ucFirst(obj[i]["name"])+"<br> Баланс = "+obj[i]['balance']+" ("+obj[i]['type_money']+")<br> Дата = "+obj[i]['date']+"<br> Статус = <span id='typ'>"+$tmp+"</span><br>");
                               // if($tmp == "расход") $("#typ").css("color","red");
                                //if($tmp == "доход") $("#typ").css("color","green");
                            }
                        }
                    );
                }
            }
        });


        $("#chose").change(function(){
            $("#chose_schedule").val("1");
            $("#myChart").css("display","block");
            $("#secChart").css("display","none");
            var date_now = new Date();
            date_now.setDate(date_now.getMonth() - 1);
            last_month = date_now.getMonth();
           if( $("#chose").val() == 1){

               myLineChart.data.datasets[0].data = [];
               myLineChart.data.labels = [];
               myLineChart.data.datasets[0].borderColor = 'blue';
               myLineChart.data.datasets[0].label =  "Расход";

               $("#month").val(last_month);
               $.post(
                   "../controlers/control_report.php",
                   {
                       wanna_info_tr_min : "1",
                       data:  last_month,
                   },
                   function(data){
                       //alert(data);
                       var obj = JSON.parse(data);
                       for(i=0;i<obj.length;i++){
                           myLineChart.data.labels[i] = obj[i]["date"];
                           myLineChart.data.datasets[0].data[i] = obj[i]["balance"];
                           $("#content").append("name = "+ucFirst(obj[i]['name'])+" || data = "+obj[i]['date']+" || balance = "+obj[i]["balance"]+"<br>");
                       }
                       myLineChart.update();
                   }
               );
            }
             else if($("#chose").val() == 2){
               $("#myChart").css("display","block");
               $("#secChart").css("display","none");
               myLineChart.data.datasets[0].data = [];
               myLineChart.data.labels = [];
               myLineChart.data.datasets[0].borderColor = 'red';
               myLineChart.data.datasets[0].label =  "Доход";

               $.post(
                   "../controlers/control_report.php",
                   {
                       wanna_info_tr_plus : "1",
                       data:  last_month,
                   },
                   function(data){
                       //alert(data);
                       var obj = JSON.parse(data);
                       for(i=0;i<obj.length;i++){
                           myLineChart.data.labels[i] = obj[i]["date"];
                           myLineChart.data.datasets[0].data[i] = obj[i]["balance"];
                       }
                       myLineChart.update();
                   }
               );
           }
        });

        $("#chose_schedule").change(function(){
            if($("#chose_schedule").val() == 1){
                $("#myChart").css("display","block");
                $("#secChart").css("display","none");
                var date_now = new Date();
                date_now.setDate(date_now.getMonth() - 1);
                last_month = date_now.getMonth();

                myLineChart.data.datasets[0].data = [];
                myLineChart.data.labels = [];
                myLineChart.data.datasets[0].borderColor = 'blue';
                myLineChart.data.datasets[0].label =  "Расход";

                $("#month").val(last_month);
                $.post(
                    "../controlers/control_report.php",
                    {
                        wanna_info_tr_min : "1",
                        data:  last_month,
                    },
                    function(data){
                        //alert(data);
                        var obj = JSON.parse(data);
                        for(i=0;i<obj.length;i++){
                            myLineChart.data.labels[i] = obj[i]["date"];
                            myLineChart.data.datasets[0].data[i] = obj[i]["balance"];
                          //  $("#content").append("name = "+ucFirst(obj[i]['name'])+" || data = "+obj[i]['date']+" || balance = "+obj[i]["balance"]+"<br>");
                        }
                        myLineChart.update();
                    }
                );
            }

            if($("#chose_schedule").val() == 2){
                PieChart();
            }

        });


        function ucFirst(str) {
            if (!str) return str;
            return str[0].toUpperCase() + str.slice(1);
        }


        function PieChart(){
            $("#myChart").css("display","none");
            $("#secChart").css("display","block");

            var ctx = document.getElementById('secChart').getContext('2d');
            var chart = new Chart(ctx, {
                type: 'pie',//'pie'doughnut
                data: {
                    datasets: [{
                        backgroundColor: ["red","green"],
                        borderColor: 'rgb(255, 99, 132)',
                        data: [],
                        fill: false,
                        lineTension: 0,
                    }],
                },
                // Configuration options go here
                options: {
                    title: {
                        display: false,
                        text: 'Расходы и доходы'
                    },
                    responsive: true,
                    maintainAspectRatio: false,
                    showLines: true,
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true
                            }
                        }]
                    },
                },

                /*events:['click',"mousemove"],
                onClick: function(evt){
//                    alert(myLineChart.data.labels[this]);
//                    alert(myLineChart.data.labels);
                    var activePoints = myLineChart.getElementsAtEvent(evt);
                    if(activePoints.length > 0) {
                        //get the internal index of slice in pie chart
                        var clickedElementindex = activePoints[0]["_index"];
                        //get specific label by index
                        var label = myLineChart.data.labels[clickedElementindex];
                        //get value by index
                        var value = myLineChart.data.datasets[0].data[clickedElementindex];
                    }
                    $.post(
                        "../controlers/control_report.php",
                        {
                            label: label,
                            status: "",
                        },
                        function(data){
                            //alert(data);
                            var obj = JSON.parse(data);

                            $("#tranzaction_label").empty();
                            for(i=0;i<obj.length;i++) {
                                $("#tranzaction_label").append("<br>Название = "+ucFirst(obj[i]["name"])+"<br> Баланс = "+obj[i]['balance']+" ("+obj[i]['type_money']+")<br> Дата = "+obj[i]['date']+"<br>");
                            }
                        }
                    );
                }*/

            });

            chart.data.labels = ["Расход","Доход"];

            chart.data.datasets[0].data = [];

            $.post(
                "../controlers/control_report.php",
                {
                    getMinus:"1",
                    getPlus:"1",
                    month_tr:$("#month").val()
                },
                function(data){
                    // alert(data);
                    obj = JSON.parse(data);
                    chart.data.datasets[0].data[0] = obj[0];
                    chart.data.datasets[0].data[1] = obj[1];
                    chart.update();
                }
            );
        }

    </script>
<?php
$part->script_links("../js/report.js");
$part->foot();
?>