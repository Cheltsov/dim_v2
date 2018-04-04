<?php


function getCourse(){
    if (!defined('LINK'))
        define("LINK", 'https://api.privatbank.ua/p24api/pubinfo?json&exchange&coursid=11');
    $data = file_get_contents(LINK);
    $courses = json_decode($data, true);
    return $courses;
}

function getOneCourse($val){
    $course = getCourse();
    switch($val){
        case "USD": return $course[0]; break;
        case "EUR": return $course[1]; break;
        case "RUR": return $course[2]; break;
        case "BTC": return $course[3]; break;
    }
}

function setDailyCourse(){
    $now = date('Y-m-d');
    $cour = R::findAll("courses", "day = '$now'");
    if(!$cour){
        $courses = getCourse();
        $cour = R::dispense("courses");
        $cour->day = date("Y-m-d");
        $cour->usd_buy = $courses[0]['buy'];
        $cour->usd_sale = $courses[0]['sale'];
        $cour->eur_buy = $courses[1]['buy'];
        $cour->eur_sale = $courses[1]['sale'];
        $cour->rur_buy = $courses[2]['buy'];
        $cour->rur_sale = $courses[2]['sale'];
        R::store( $cour);
    }
    else echo('no');
    R::close();
}
