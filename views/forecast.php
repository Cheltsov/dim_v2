<?php
if(!isset($_COOKIE['SingIN'])){
    header('Location:../index.php');
}
//require "../controlers/control_debt.php";
require "partpage.php";

$part = new partPage();
$part->PreLoader();

echo("<title>Ledger - Планировщик</title>");
$part->head(); // Построение шапки страницы

$part->arr_links("mainPage.css","forecast_style.css"); //подключить массив фалов стилей

$part->script_links("https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js","../js/partpage.js","https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js"); //подключить массив фалов javascript
echo('<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css">');

?>


<pre>
    <div id="content" style="color:white; max-height:600px; overflow:auto;float:left;margin-right:100px"></div>
    <div id="content2" style="color:white; max-height:600px; overflow:auto;"></div>
</pre>

<div id="diargramm" style="background-color:white; width:65%;height:500px; border:1px solid red;margin-top:600px">
    <canvas id="secChart"></canvas>
    <canvas id="chartjs-1"></canvas>
</div>

 <script>

        var ctx = document.getElementById('secChart').getContext('2d');
        var myBarChart = new Chart(ctx, {
            type: 'bar',

            data:{
                labels:[],
                datasets:[{
                    label:"Доход",
                    data:[],
                    fill:false,
                    backgroundColor:["rgba(75, 192, 192, 0.2)"],//  rgba(255, 99, 132, 0.2)
                    borderColor:["rgb(75, 192, 192)"],//,"rgb(255, 99, 132)"
                    borderWidth:1
                }, {
                    label: "Рассход",
                    data: [],
                    fill: false,
                    backgroundColor: ["rgba(255, 99, 132, 0.2)", "rgba(255, 159, 64, 0.2)", "rgba(255, 205, 86, 0.2)", "rgba(75, 192, 192, 0.2)", "rgba(54, 162, 235, 0.2)", "rgba(153, 102, 255, 0.2)", "rgba(201, 203, 207, 0.2)"],
                    borderColor: ["rgb(255, 99, 132)", "rgb(255, 159, 64)", "rgb(255, 205, 86)", "rgb(75, 192, 192)", "rgb(54, 162, 235)", "rgb(153, 102, 255)", "rgb(201, 203, 207)"],
                    borderWidth: 1
                }]
            },
            options:{
                scales:{
                    yAxes:[{
                        ticks:{
                            beginAtZero:true
                        }
                    }]
                }
            }
        });


        myBarChart.data.label = "cool";
//myBarChart.data.labels[i] = obj[i]["date"];
        //myLineChart.data.datasets[0].data[i] = obj[i]["balance"];


        $(document).ready(function(){
            $.post(
                "../controlers/control_forecast.php",
                {wanna_month_tr : "1"},
                function(data) {
                    //alert(data);
                    $("#content").append(data);
                    obj = JSON.parse(data);
                    $("#content").append("<br>Точность = " + obj[0]['t'] + "%<br>");

                    if(obj[0]['t']==null){
                        alert("Некорректные данные для доходов");
                        return false;
                    }
                    else{
                        for (i = 0, j = 1; i < obj.length; i++, j++) {
                            $("#content").append(obj[j]['month_d'] + "=" + obj[j].bal + "<br>");
                            myBarChart.data.labels[i] = GetMon(obj[j].month_d);
                            myBarChart.data.datasets[0].data[i] = obj[j].bal;
                            myBarChart.data.datasets[0].backgroundColor = "rgba(75, 192, 192, 0.2)";
                            myBarChart.data.datasets[0].borderColor = "rgb(75, 192, 192)";
                        }
                        myBarChart.update();
                    }
                }
            );

            $.post(
                "../controlers/control_forecast.php",
                {wanna_month_tr2 : "1"},
                function(data){
                    //alert(data);
                    $("#content").append(data);
                    obj = JSON.parse(data);
                    $("#content").append("<br>Точность = " + obj[0]['t'] + "%<br>");
                    if(obj[0]['t']==null){
                        alert("Некорректные данные для расходов");
                        return false;
                    }
                    else{
                        for (i = 0, j = 1; i < obj.length; i++, j++) {
                            $("#content").append(obj[j].month + "=" + obj[j].bal + "<br>");
                            myBarChart.data.labels[i] = GetMon(obj[j].month);
                            myBarChart.data.datasets[1].data[i] = obj[j].bal;
                            myBarChart.data.datasets[1].backgroundColor = "rgba(255, 99, 132, 0.2)";
                            myBarChart.data.datasets[1].borderColor = "rgb(255, 99, 132)";
                        }
                        myBarChart.update();
                    }

                }
            );
        });


        function GetMon(month){
            var arr=[
                'Январь',
                'Февраль',
                'Март',
                'Апрель',
                'Май',
                'Июнь',
                'Июль',
                'Август',
                'Сентябрь',
                'Ноябрь',
                'Декабрь',
            ];
            return(arr[month-1]);
        }
    </script>


<?php
//$part->script_links("../js/index_page.js", "../js/tranz.js");
$part->foot();// Построение подвала страницы
?>