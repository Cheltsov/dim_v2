<?php
/**
 * Created by PhpStorm.
 * User: Константин
 * Date: 24.01.2018
 * Time: 23:00
 */



class PartPage
{
    public function head(){
        echo('
            <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">

                <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
                <script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>

                <script src="../js/partpage.js"></script>


            </head>
            <body>

                <div class="display_one">
                    <div class="header">
                    <img src="../im/logo.png" alt="">

                    <ul type="none">
                        <li><a href="index.php" class="go_to" id="main">Главная</a></li>
                        <li><a href="tranzactions.php" class="go_to" id="tranz">Транзакции</a></li>
                        <li><a href="debt.php" class="go_to" id="debt">Долги</a></li>
                        <li><a href="forecast.php" class="go_to" id="forecast">Планировщик</a></li>
                        <li><a href="report.php" class="go_to" id="report">Отчеты</a></li>
                        <li><a href="cash.php" class="go_to" id="cash">Счета</a></li>
                        <li><a href="#" class="go_to" id="il2">Настройки</a></li>
                        <li>
                        <button type="submit" name="exit" id="exit">Выйти</input>

                        </li>
                    </ul>
                </div>
        ');
    }

    public function foot(){
        echo('
            <script src="../js/exit.js"></script>
            </body>
            </html>
        ');
    }

    public function arr_links(){
        $numargs = func_num_args();
        $arg_list = func_get_args();
        for ($i = 0; $i < $numargs; $i++) {
            echo "<link rel='stylesheet' href='../style/".$arg_list[$i]."'><br>";
        }
    }
    public function script_links(){
        $numargs = func_num_args();
        $arg_list = func_get_args();
        for ($i = 0; $i < $numargs; $i++) {
            echo "<script src=".$arg_list[$i]."></script><br>";
        }
    }

    public function cashContent($cash_info){ //вывот контекта определенного кошелька

    }

    public function PreLoader(){
        echo('
            <style type="text/css">
            #hellopreloader>p{display:none;}#hellopreloader_preload{display: block;position: fixed;z-index: 99999;top: 0;left: 0;width: 100%;height: 100%;min-width: 1000px;background: #2574A9 url(http://hello-site.ru//main/images/preloads/oval.svg) center center no-repeat;background-size:124px;}</style>
            <div id="hellopreloader"><div id="hellopreloader_preload"></div><p><a href="http://hello-site.ru">Hello-Site.ru. Бесплатный конструктор сайтов.</a></p></div>
            <script type="text/javascript">var hellopreloader = document.getElementById("hellopreloader_preload");function fadeOutnojquery(el){el.style.opacity = 1;var interhellopreloader = setInterval(function(){el.style.opacity = el.style.opacity - 0.05;if (el.style.opacity <=0.05){ clearInterval(interhellopreloader);hellopreloader.style.display = "none";}},16);}window.onload = function(){setTimeout(function(){fadeOutnojquery(hellopreloader);},500);};</script>
            ');
    }

}
?>

