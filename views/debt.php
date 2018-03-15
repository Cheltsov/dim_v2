<?php
if(!isset($_COOKIE['SingIN'])){
    header('Location:../index.php');
}
require "../controlers/control_debt.php";
require "partpage.php";

$part = new partPage();


echo("<title>Ledger - Долги</title>");
$part->head(); // Построение шапки страницы

$part->arr_links("mainPage.css","debt_style.css"); //подключить массив фалов стилей

$part->script_links("https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js","../js/partpage.js"); //подключить массив фалов javascript
echo('<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css">');

?>




<?php
//$part->script_links("../js/index_page.js", "../js/tranz.js");
$part->foot();// Построение подвала страницы
?>
