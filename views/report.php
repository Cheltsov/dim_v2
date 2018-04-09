<?php
if(!isset($_COOKIE['SingIN'])){
    header('Location:../index.php');
}
require "../controlers/control_main_page.php";

require "../controlers/control_report.php";

require "partpage.php";
$part = new partPage();
$part->PreLoader();
echo("<title>Ledger - Отчеты</title>");
$part->head();
echo('<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css">');
$part->arr_links("mainpage.css", "report_style.css" );
$part->script_links("https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js", "../js/accordion.js", "../js/tabs.js", "../libs/cellSelection.min.js","https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js");
?>
<div>
    <select id="chose">
        <option value="1">Расходы</option>
        <option value="2">Доходы</option>
    </select>
    <select id="chose_schedule">
        <option value="1">Line</option>
        <option value="2">Pie</option>
    </select>
    <select id="month">
    </select>
</div>
    <br>
    <br>
<div style="width:65%;height:500px; color:white; background-color:white">
    <canvas id="myChart" ></canvas>

</div>

<div id="content" style="color:black;">
    <h3>При нажатии на вершину графика вывести в блок имени транзакции, а также дополнительные параметры</h3>
    <h3>При получении баланса конвертировать валюту</h3>
    <h3>При наведении на вершину убрать квадрат</h3>
    <h3>Добавить круговой график</h3>
</div>


    <script>
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
                onClick: function(){
                    alert(myLineChart.data.datasets[0].data);
                    alert(myLineChart.data.labels);
                }
            }
        });

        $("#chose").change(function(){
           if( $("#chose").val() == 1){
               myLineChart.data.datasets[0].data = [];
               myLineChart.data.labels = [];
               myLineChart.data.datasets[0].borderColor = 'blue';
               myLineChart.data.datasets[0].label =  "Расход";

               $.post(
                   "../controlers/control_report.php",
                   {
                       wanna_info_tr_min : "1",
                      // date:  $("#month").val()
                   },
                   function(data){

                       alert(data);
                    $("#content").append("= "+data);
                       var obj = JSON.parse(data);
                       for(i=0;i<obj.length;i++){
                           myLineChart.data.labels[i] = obj[i]["date"];
                           myLineChart.data.datasets[0].data[i] = obj[i]["balance"];
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
                       wanna_info_tr_plus : "1"
                   },
                   function(data){
                       var obj = JSON.parse(data);
                       for(i=0;i<obj.length;i++){
                           myLineChart.data.labels[i] = obj[i]["date"];
                           myLineChart.data.datasets[0].data[i] = obj[i]["balance"];
                           //alert(obj[i]["name"]);
                       }
                       myLineChart.update();
                   }
               );
           }
        });

        $("#chose_schedule").change(function(){
            var ctx = document.getElementById('myChart').getContext('2d');
            var chart = new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: ["January", "February", "March", "April", "May"],
                    datasets: [{
                        backgroundColor: ["red", "blue","lightblue","green","yellow"],
                        label: "My First dataset",
                        borderColor: 'rgb(255, 99, 132)',
                        data: [10, 5, 20, 30, 45],
                    }],

                },

                // Configuration options go here
                options: {
                    title: {
                        display: true,
                        text: 'Predicted world population (millions) in 2050'
                    }
                }
            });





        });



    </script>
<?php
$part->script_links("../js/report.js");
$part->foot();
?>