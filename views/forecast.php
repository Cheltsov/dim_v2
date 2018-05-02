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
    <script src="../js/circularloader.js"></script>

<pre>
<!--<!--    <div id="content" style="color:white; max-height:600px; overflow:auto;float:left;margin-right:100px"></div>-->
<!--<!--    <div id="content2" style="color:white; max-height:600px; overflow:auto;"></div>-->
</pre>

<div id="diargramm" style="background-color:white; width:65%; max-height:500px;float:left; margin-top:-10px; margin-left:35px; ">
    <canvas id="secChart"></canvas>
<!--    <canvas id="chartjs-1"></canvas>-->
</div>
    <div style="display:flex;flex-direction: column-reverse;justify-content: center;-webkit-align-items: center;
    -webkit-box-align: center;
    -ms-flex-align: center;
    align-items: center; ">
        <div id="loader2" style="width:180px; height:200px; "></div>
        <div id="loader1" style="width:180px;  height:200px;  "></div>
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
                    label: "Расход",
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

        $(document).ready(function(){
            $.post(
                "../controlers/control_forecast.php",
                {wanna_month_tr : "1"},
                function(data) {
                    //alert(data);
                   // $("#content").append(data);
                    obj = JSON.parse(data);
                    press = obj[0]['t'];
                    //$("#content").append("<br>Точность = " + press + "%<br>");

                    if(press==null){
                        press = 0;
                        alert("Некорректные данные для доходов");
                        Loader2(press);
                        return false;
                    }
                    else{
                        Loader2(press);
                        obj.splice(0, 1);
                        for (i = 0; i < obj.length; i++) {
                            //$("#content").append(obj[i]['month_d'] + "=" + obj[i].bal + "<br>");
                            myBarChart.data.labels[i] = GetMon(obj[i].month_d);
                            myBarChart.data.datasets[0].data[i] = obj[i].bal;
                            myBarChart.data.datasets[0].backgroundColor = "rgba(75, 192, 192, 0.4)";
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
                   // $("#content").append(data);
                    obj = JSON.parse(data);
                    pres = obj[0]['t'];
                    //$("#content").append("<br>Точность = " + pres + "%<br>");

                    if(pres==null){
                        pres = 0;
                        alert("Некорректные данные для расходов")
                        Loader1(pres);
                        return false;
                    }
                    else{
                        Loader1(pres);
                        obj.splice(0, 1);
                        for (i = 0; i < obj.length; i++) {
                           // $("#content").append(obj[i].month + "=" + obj[i].bal + "<br>");
                            myBarChart.data.labels[i] = GetMon(obj[i].month);
                            myBarChart.data.datasets[1].data[i] = obj[i].bal;
                            myBarChart.data.datasets[1].backgroundColor = "rgba(255, 99, 132, 0.4)";
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


        function Loader1(perc){
            $("#loader1").circularloader({
                backgroundColor: "#ffffff",//background colour of inner circle
                fontColor: "#000000",//font color of progress text
                fontSize: "40px",//font size of progress text
                radius: 60,//radius of circle
                progressBarBackground: "rgb(75, 192, 192)",//background colour of circular progress Bar
                progressBarColor: "rgba(255, 99, 132)",//colour of circular progress bar
                progressBarWidth: 15,//progress bar width
                progressPercent: perc,//progress percentage out of 100
                progressValue: perc,//diplay this value instead of percentage
                showText: true,//show progress text or not
                title: "Расход",//show header title for the progress bar
            });
            $("#loader1").find(".clProg").val(Math.round(perc,0)+"%");
            $("#loader1").find(".titleCircularLoader").css("color","white");
            $("#loader1").find(".titleCircularLoader").css("font-size","14pt");
        }
        function Loader2(perc){
            $("#loader2").circularloader({
                backgroundColor: "#ffffff",//background colour of inner circle
                fontColor: "#000000",//font color of progress text
                fontSize: "40px",//font size of progress text
                radius: 60,//radius of circle
                progressBarBackground: "rgba(255, 99, 132)",//background colour of circular progress Bar
                progressBarColor: "rgb(75, 192, 192)",//colour of circular progress bar
                progressBarWidth: 15,//progress bar width
                progressPercent: perc,//progress percentage out of 100
                progressValue: perc,//diplay this value instead of percentage
                showText: true,//show progress text or not
                title: "Доход",//show header title for the progress bar
            });
            $("#loader2").find(".clProg").val(Math.round(perc,0)+"%");
            $("#loader2").find(".titleCircularLoader").css("color","white");
            $("#loader2").find(".titleCircularLoader").css("font-size","14pt");
        }
    </script>


<?php
//$part->script_links("../js/index_page.js", "../js/tranz.js");
$part->foot();// Построение подвала страницы
?>