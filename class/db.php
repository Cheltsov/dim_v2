<?php
if(!isset($_SESSION)){
    session_start();
}

require '../config/config_connect_DB.php';
require 'libs/rb.php';
require_once 'LineChart.php';
require_once "../controlers/getCourse.php";


class Datebase
{

    function __construct(){
        if(! R::testConnection()){
            R::setup('mysql:host='.HOST.'; dbname='.DBNAME.'; charset=utf8', ADMIN, PASS);
        }
        if(! R::testConnection()){
            exit("Подключение к базе не установлено!");
        }
    }

    function Connection(){
        if(! R::testConnection()){
            R::setup('mysql:host='.HOST.'; dbname='.DBNAME.'; charset=utf8', ADMIN, PASS);
        }
        if(! R::testConnection()){
            exit("Подключение к базе не установлено!");
        }
    }

//
//    //Перенес
//    function getUsers(){
//        $arr_tmp = array();
//        $users = R::findAll('users');
//        foreach($users as $item){
//            array_push($arr_tmp, $item->email);
//        }
//        return $arr_tmp;
//    }
//    //Перенес
//    function findIdUser(){
//        $users = R::findAll('users');
//        foreach($users as $item){
//            $name = $item->login;
//            if($name == $_COOKIE['SingIN'])
//                $idUser = ($item->id);
//        }
//        return  $idUser;
//    }
//
//    function findIdUserFromEmail($email){
//        $user = R::findAll('users',"email = '$email'");
//        foreach($user as $item){
//            return $item->id;
//        }
//    }

//    function Create_Cop($id_user, $namew, $type_money, $num_card, $type_cash, $balance,$comment){
//            $cash = R::dispense("cash");
//            $cash->iduser = $id_user;
//            $cash->name = $namew;
//            $cash->type_money = $type_money;
//            $cash->num_card = $num_card;
//            $cash->type_cash = $type_cash;
//            $cash->balance = $balance;
//            $cash->comment = $comment;
//            $cash->date_create = R::isoDateTime();
//            $cash->date_update = R::isoDateTime();
//            R::store($cash);
//            R::close();
//    }
//
//    function Insert_Cash($namew, $type_money, $num_card, $type_cash, $balance,$comment){
//        try{
//            $connect = new Datebase();
//            $tmp_idUser = $connect->findIdUser();
//
//            $cash = R::dispense("cash");
//            $cash->iduser = $tmp_idUser;
//            $cash->name = $namew;
//            $cash->type_money = $type_money;
//            $cash->num_card = $num_card;
//            $cash->type_cash = $type_cash;
//            $cash->balance = $balance;
//            $cash->comment = $comment;
//            $cash->date_create = R::isoDateTime();
//            $cash->date_update = R::isoDateTime();
//            R::store($cash);
//
//            $connect->createCashMonth($tmp_idUser, $namew, $type_money, $type_cash, $balance); // Создание кошелька на месяц
//        }
//        catch(Exception $e){
//            echo($e);
//        }
//        R::close();
//    }
//    //Перенес
//    function createCashMonth($id_user, $name, $type_money, $type_cash, $balance){ // Создание кошелька на месяц
//        try{
//            $cash = R::findAll("cash","iduser = $id_user and name = '$name' and type_money = '$type_money' and type_cash = $type_cash");
//            foreach($cash as $item){
//                $tmp_id_cash = $item->id;
//            }
//            $cash_month = R::dispense("cashmonth");
//            $cash_month->id_cash = $tmp_id_cash;
//            $cash_month->id_user = $id_user ;
//            $cash_month->name = $name;
//            $cash_month->type_money = $type_money;
//            $cash_month->type_cash = $type_cash;
//            $cash_month->balance = $balance;
//            R::store($cash_month);
//        }
//        catch(Exception $e){
//            echo($e);
//        }
//        R::close();
//    }
//
//    function Read($login_input){
//       //$loa =  R::load('users','1');
//       // $loads = R::loadAll('users', array());
//       //echo "<pre>"; print_r($loads); echo "</pre>";
//       /* foreach ($loads as $test){
//            echo($test->login);
//            echo("<br>");
//        }*/
//      // Перенес
//    }
//
//    function testLogin($login_input){
//        $names = R::find('users');
//        foreach ( $names as $item) {
//            if($item->login == $login_input){
//                $flag=true;
//            }
//            else{
//                $flag=false;
//            }
//        }
//        if($flag == true){
//            return true;
//        }
//        else{
//            return false;
//        }
//        R:close();
//      //Перенес
//        }
//
//    function searchEmail($email_input){
//        $flag = 0;
//        $e_names = R::findAll('users');
//        foreach ($e_names as $item) {
//            if($item->email == $email_input){
//                $flag = $item->id;
//            }
//        }
//        R::close();
//        return $flag;
//
//    }
//
//
//    function rewriteValue($id, $row, $value){
//        try{
//            $names = R::find('users');
//            $usersAll = R::load("users", $id);
//            $usersAll->$row=md5($value);
//            R::store($usersAll);
//        }
//        catch(Exception $e){
//            echo($e);
//        }
//        //R::freeze(); заморозка
//        R::close();
//    }
//
////Перенес
//    function Registration($login,$item_email,$password,$second_password){
//        $rou = new moveTo();
//        $connect = new Datebase();
//
//        if(!$connect->testLogin($login)){
//            $item_login = $login;
//        }
//        else{
//            echo("Такой пользователь существует')");
//            $rou->moveToIndex();
//        }
//        if(strlen($password)<30){
//            if($password == $second_password){
//                $item_password = md5($password);
//            }
//            else{
//                echo("Пароли не совпадают");
//            }
//        }
//        try {
//            if(isset($item_login) && isset($item_email) && isset($item_password)){
//              $connect->Insert_Registration($item_login,$item_email,$item_password);
//                $id_user = $connect->searchEmail($item_email);
//                $connect->Create_Cop($id_user, "Копилка", "UAH", null, "1", 0,"");
//              //echo("<script> alert('Регистрация прошла успешно!'); </script>");
//                echo('Регистрация прошла успешно!');
//              //$rou->moveToIndex();
//            }
//        }
//        catch (Exception $e) {
//            echo("Введите поля правильно");
//        }
//    }
//    //Перенес
//    function singIn($login,$password){
//        $rou = new moveTo();
//        $names = R::findAll('users');
//        foreach ($names as $item) {
//            if($login == $item->login) $your_pass = $item->password;
//        }
//        if(!isset($your_pass)){
//            $_SESSION['login'] = "0";
//            echo("<script> alert('Такого пользователя нет'); </script> ");
//            $rou->moveToIndex();
//            exit;
//        }
//        if($your_pass == md5($password)){
//            setcookie("SingIN", $login, time()+60*60*24*365*10, '/');
//            echo(1);
//        }
//        else{
//            $_SESSION['login'] = "1";
//            $rou->moveToIndex();
//        }
//        R::close();
//    }

    /* function getIdCash($iduser){
         /*$cashes = R::findAll('usercash');
         foreach ($cashes as $item) {
             if($item->iduser == $iduser){
                 echo($item->idcash);
             }
         }
         $tmp_cash = R::find('usercash',"iduser = $iduser");*/

         //return ($tmp_cash->idcash);
       /* $cash = R::getAll( "select * from cash inner join usercash using(idcash) where usercash.iduser = 5");
         echo("<pre>");
         print_r($cash);
         echo("</pre>");
     }*/

       function getCash($id_user){
           $arr_cash = array();
           $cash = R::find('cash',"iduser = $id_user");
          /* foreach($cash as $item){
                array_push($arr_cash,$item->$point);
           }*/
           //return $arr_cash;
           R::close();
           return $cash;
       }
    //Перенес
    function getCashList($id_user){
            $arr_cash = array();
            $cash = R::find('cash',"iduser = $id_user");
            foreach($cash as $item){
                array_push($arr_cash,$item->id,$item->id_user,$item->name,$item->type_money,$item->type_cash,$item->balance, $item->comment, $item->data_create, $item->data_update, $item->num_card);
            }
            echo(json_encode($arr_cash));
            R::close();
    }



    function getCashMonth($id_user){
        $arr_cash = array();
        $cash_month = R::findAll('cashmonth', "id_user = $id_user");
        foreach($cash_month as $item){
            array_push($arr_cash,$item->id,$item->name,$item->type_money,$item->type_cash, $item->balance);
        }
        echo(json_encode($arr_cash));
        R::close();
    }
    //Переписал
    function getIdCash($id_cash){
        $arr_tmp = array();
        $cash = R::find('cash',"id = $id_cash");
         foreach($cash as $item){
             $us = R::findAll('users',"id = $item->iduser");
             foreach($us as $tmp_us){
                 $us_name = $tmp_us->login;
             }
              array_push($arr_tmp,$item->id,$us_name,$item->name,$item->type_money,$item->type_cash,$item->balance,$item->comment, $item->date_create,$item->date_update, $item->num_card);
         }
        //return $arr_cash;
       // print_r($arr_tmp);
        R::close();
        return $arr_tmp;
    }
//Перенес
    function getIdCashMonth($id_cash){
        $arr_tmp = array();
        $cash = R::find('cashmonth',"id_cash = $id_cash");
        foreach($cash as $item){
            $us = R::findAll('users',"id = $item->id_user");
            foreach($us as $tmp_us){
                $us_name = $tmp_us->login;
            }
            array_push($arr_tmp,$item->id,$item->id_cash,$us_name,$item->name,$item->type_money,$item->type_cash,$item->balance);
        }
        R::close();
        return $arr_tmp;
    }

    //Перенес
    function delCash($idCash){
        try{
            $cash = R::load("cash", $idCash);
            echo($cash->name);
            R::trash($cash);
            return true;
        }
        catch(Exception $e){
            echo($e);
        }
        R::close();

    }
    //Перенес
    function updataCash(){
        try{
            $numargs = func_num_args();
            $arg_list = func_get_args();

            $cash = R::load("cash", $arg_list[0]);
            $cash->name = $arg_list[1];
            $cash->type_money = $arg_list[2];
            $cash->type_cash = $arg_list[3];
            $cash->balance = $arg_list[4];
            $cash->comment = $arg_list[5];
            $cash->date_update = R::isoDateTime();
            R::store($cash);
        }
        catch(Exception $e){
            echo($e);
        }

        R::close();

    }
    //Пропустил
    function getCashNEW($id_user){

            $arr_cash = array();
            $cash = R::find('cash',"iduser = $id_user");
             foreach($cash as $item){
                  array_push($arr_cash,$item->name,$item->type_money, $item->type_cash,$item->balance,$item->comment,$item->iduser,$item->id);
             }
            R::close();
            return $arr_cash;
    }
    //Пропустил
    function getCashNEWDouble($id_user){

        $arr_cash = array();
        $cash = R::find('cash',"iduser = $id_user");
        foreach($cash as $item){
            array_push($arr_cash,$item->name,$item->type_money, $item->type_cash,$item->balance,$item->comment,$item->id_user,$item->id);
        }
        echo(json_encode($arr_cash));
        R::close();
    }

    function getCourseCashInDB($id_cash){
        $cash = R::findAll('cash',"id = $id_cash");
        foreach($cash as $item){
            return $item->type_money;
        }
        R::close();
    }
    //Перенес
    function findCashMonthID_from_Cash($tmp_id_cash){
        $cash_month = R::findAll("cashmonth","id_cash = $tmp_id_cash");
        foreach($cash_month as $item){
            $id_cashmonth = $item->id;
        }
        return $id_cashmonth;
    }

    function extraTranz($id_user, $balance, $status){
        try{
            $now = date("2018-04-01");
            //$now = date("Y-m-d");
            $date = new DateTime($now);
            $date->modify('-1 day');
            $last_day = $date->format('Y-m-d');

            $cash = R::find("cash","name='Копилка' and iduser = $id_user");
            foreach($cash as $item){
                $id_ex_cash = $item->id;
            }

            $ex_tr = R::dispense("tranzaction");
            $ex_tr->name = "Дополнительная транзакция";
            $ex_tr->cash = $id_ex_cash;
            $ex_tr->balance = $balance;
            $ex_tr->comment = "Можно изменить";
            $ex_tr->user_id = $id_user;
            $ex_tr->data = $last_day." 23:59:59";
            $ex_tr->status = $status;
            R::store($ex_tr);

            $cash = R::load("cash",$id_ex_cash);
            if($status == "minus"){
                $cash->balance -= $balance;
            }
            if($status == "plus"){
                $cash->balance += $balance;
            }
            R::store($cash);
        }
        catch(Exception $e){
            echo($e);
        }
        R::close();
    }
    //Перенес
    function addTranzMin(){

        try{
            $numargs = func_num_args();
            $arg_list = func_get_args();
            $connect = new Datebase();

            $cash = R::find("cash","id = $arg_list[1]");
            foreach($cash as $item){
                $cash_type_money = $item->type_money;
            }

            $date = date_create($arg_list[5]);
            $tr_day = date_format($date,"Y-m-d");
            $dayli_course = R::findAll("courses","day = '$tr_day'");

            if(isset($dayli_course)){
                foreach($dayli_course as $item){
                    switch($cash_type_money){
                        case "EUR": $tr_course = $item['eur_sale'];break;
                        case "USD": $tr_course = $item['usd_sale'];break;
                        case "RUR": $tr_course = $item['rur_sale'];break;
                    }
                }
            }
            if($tr_course == 0){
                $course = getOneCourse($cash_type_money);
                $tr_course = $course['sale'];
            }

            $tr = R::dispense("tranzaction");
            $tr->name = $arg_list[0];
            $tr->cash = $arg_list[1];
            $tr->balance = $arg_list[2];
            $tr->course = round($tr_course,2);
            $tr->comment = $arg_list[3];
            $tr->userId = $arg_list[4];
            if(!isset($arg_list[5])) $tr->data = R::isoDateTime();
            else $tr->data = $arg_list[5];
            $tr->status = "minus";

            $cash = R::load("cash", $arg_list[1]);
            $cash->balance = $cash->balance - $arg_list[2];

            $id_cash = $connect->findCashMonthID_from_Cash($arg_list[1]);
            $cash_month = R::load("cashmonth", $id_cash);
            $cash_month->balance = $cash_month->balance - $arg_list[2];

            R::store($tr);
            R::store($cash);
            R::store($cash_month);
        }
        catch(Exception $e){
            echo($e);
        }

        R::close();
    }
//Перенес
    function addTranzSum(){

        try{
            $numargs = func_num_args();
            $arg_list = func_get_args();
            $connect = new Datebase();

            $cash = R::find("cash","id = $arg_list[1]");
            foreach($cash as $item){
                $cash_type_money = $item->type_money;
            }

            $date = date_create($arg_list[5]);
            $tr_day = date_format($date,"Y-m-d");
            $dayli_course = R::findAll("courses","day = '$tr_day'");

            if(isset($dayli_course)){
                foreach($dayli_course as $item){
                    switch($cash_type_money){
                        case "EUR": $tr_course = $item['eur_sale'];break;
                        case "USD": $tr_course = $item['usd_sale'];break;
                        case "RUR": $tr_course = $item['rur_sale'];break;
                    }
                }
            }
            if($tr_course == 0){
                $course = getOneCourse($cash_type_money);
                $tr_course = $course['sale'];
            }

            $tr = R::dispense("tranzaction");
            $tr->name = $arg_list[0];
            $tr->cash = $arg_list[1];
            $tr->balance = $arg_list[2];

            $tr->course = round($tr_course,2);

            $tr->comment = $arg_list[3];
            $tr->userId = $arg_list[4];
            if(!isset($arg_list[5])) $tr->data = R::isoDateTime();
            else $tr->data = $arg_list[5];
            $tr->status = "plus";

            $cash = R::load("cash", $arg_list[1]);
            $cash->balance = $cash->balance + $arg_list[2];

            $id_cash = $connect->findCashMonthID_from_Cash($arg_list[1]);
            $cash_month = R::load("cashmonth", $id_cash);
            $cash_month->balance = $cash_month->balance + $arg_list[2];

            R::store($tr);
            R::store($cash);
            R::store($cash_month);
        }
        catch(Exception $e){
            echo($e);
        }
        R::close();
    }
    //Перенес
    function whatBalance($id_cash){
        $cash = R::findAll('cash',"id = $id_cash");
        foreach($cash as $item){
            $balance = $item->balance;
        }
        echo($balance);
        R::close();
    }

   /* function newBalance($id_user,$id_cash,$balance){

    }*/

    function getTranzFromID($id){ // after return json_encode
        $now_month = date("m");

        $arr_tmp = array();
        $tr = R::findAll('tranzaction',"id = $id");
        foreach($tr as $item) {

            $up_data_month = date("m", strtotime($item->data));
            if ($up_data_month != $now_month) {
                $flag = "false";
                return $flag;
            }
            else {
                array_push($arr_tmp, $item->id, $item->name, $item->cash, $item->balance, $item->comment, $item->user_id, $item->data, $item->status);
            }
        }
        R::close();
        return $arr_tmp;
    }

    function getTranzFromID_user($id_user){
        $arr_tmp = array();
        $tr = R::findAll('tranzaction',"user_id = $id_user");
        foreach($tr as $item){
            array_push($arr_tmp,$item->id,$item->name,$item->cash,$item->balance,$item->comment,$item->user_id,$item->data);
        }
        R::close();
        return(json_encode($arr_tmp));
    }
/*
    function getTrFromCash($id_cash){
        $arr_tmp = array();
        $tr = R::findAll('tranzaction',"cash = $id_cash");
        foreach($tr as $item){
            array_push($arr_tmp,$item->id,$item->name,$item->cash,$item->balance,$item->comment,$item->user_id,$item->data);
        }
        echo(json_encode($arr_tmp));
       //print_r($tr);
    }*/


    function getTrMin($id_user){
        $arr_tmp = array();
        $name_cash = "";
        $tr = R::findAll('tranzaction',"user_id = $id_user order by data");
        foreach($tr as $item){
            if($item->status == "minus"){
                $cash = R::findAll('cash',"id = $item->cash");
                foreach($cash as $tmp){
                    $name_cash = $tmp->name;
                }
                $us = R::findAll('users',"id = $item->user_id");
                foreach($us as $tmp_us){
                    $us_name = $tmp_us->login;
                }
                if($name_cash=="")  $name_cash="Удален";
                array_push($arr_tmp,$item->id,$item->name,$name_cash,$item->balance,$item->comment,$us_name,$item->data);
                $name_cash="";
            }
        }
        echo(json_encode($arr_tmp));
        R::close();
    }

    //////////////////////////////////////////////////////////////////////////////////
    /// перенес
    function getTrMinFromData($id_user,$data){
        $arr_tmp = array();
        $name_cash = "";
        $tr = R::findAll('tranzaction',"user_id = $id_user and date(data) = '$data' order by data");
        foreach($tr as $item){
            if($item->status == "minus"){
                $cash = R::findAll('cash',"id = $item->cash");
                foreach($cash as $tmp){
                    $name_cash = $tmp->name;
                }
                $us = R::findAll('users',"id = $item->user_id");
                foreach($us as $tmp_us){
                    $us_name = $tmp_us->login;
                }
                if($name_cash=="")  $name_cash="Удален";
                array_push($arr_tmp,$item->id,$item->name,$name_cash,$item->balance,$item->comment,$us_name,$item->data);
                $name_cash="";
            }
        }
        echo(json_encode($arr_tmp));
        R::close();
    }
    //ПЕренес
    function getTrMinFromDataRange($id_user,$data1, $data2){
        $arr_tmp = array();
        $name_cash = "";
        $tr = R::findAll('tranzaction',"user_id = $id_user and date(data) >= '$data1' and date(data) <= '$data2' order by data");
        foreach($tr as $item){
            if($item->status == "minus"){
                $cash = R::findAll('cash',"id = $item->cash");
                foreach($cash as $tmp){
                    $name_cash = $tmp->name;
                }
                $us = R::findAll('users',"id = $item->user_id");
                foreach($us as $tmp_us){
                    $us_name = $tmp_us->login;
                }
                if($name_cash=="")  $name_cash="Удален";
                array_push($arr_tmp,$item->id,$item->name,$name_cash,$item->balance,$item->comment,$us_name,$item->data);
                $name_cash="";
            }
        }
        echo(json_encode($arr_tmp));
        R::close();
    }
    /// ///////////////////////////////////////////////////////////////////////////////

    function getTrMin_fromID($id_user, $id_cash){
        $arr_tmp = array();
        $name_cash = "";
        $tr = R::findAll('tranzaction',"user_id = $id_user and cash = $id_cash");
        foreach($tr as $item){
            if($item->status == "minus"){
                $cash = R::findAll('cash',"id = $item->cash");
                foreach($cash as $tmp){
                    $name_cash = $tmp->name;
                }
                $us = R::findAll('users',"id = $item->user_id");
                foreach($us as $tmp_us){
                    $us_name = $tmp_us->login;
                }
                if($name_cash=="")  $name_cash="Удален";
                array_push($arr_tmp,$item->id,$item->name,$name_cash,$item->balance,$item->comment,$us_name,$item->data);
                $name_cash="";
            }
        }
        echo(json_encode($arr_tmp));
        R::close();
    }


    function getTrPlus($id_user){
        $arr_tmp = array();
        $name_cash = "";
        $tr = R::findAll('tranzaction',"user_id = $id_user order by data");
        foreach($tr as $item){
            if($item->status == "plus"){
                $cash = R::findAll('cash',"id = $item->cash");
                foreach($cash as $tmp){
                    $name_cash = $tmp->name;
                }
                $us = R::findAll('users',"id = $item->user_id");
                foreach($us as $tmp_us){
                    $us_name = $tmp_us->login;
                }
                if($name_cash=="")  $name_cash="Удален";
                array_push($arr_tmp,$item->id,$item->name,$name_cash,$item->balance,$item->comment,$us_name,$item->data);
                $name_cash="";
            }
        }
        echo(json_encode($arr_tmp));
        R::close();
    }

    ////////////////////////////////////////////////////////////////////
    function getTrPlusFromData($id_user, $data){
        $arr_tmp = array();
        $name_cash = "";
        $tr = R::findAll('tranzaction',"user_id = $id_user and date(data) = '$data' order by data");
        foreach($tr as $item){
            if($item->status == "plus"){
                $cash = R::findAll('cash',"id = $item->cash");
                foreach($cash as $tmp){
                    $name_cash = $tmp->name;
                }
                $us = R::findAll('users',"id = $item->user_id");
                foreach($us as $tmp_us){
                    $us_name = $tmp_us->login;
                }
                if($name_cash=="")  $name_cash="Удален";
                array_push($arr_tmp,$item->id,$item->name,$name_cash,$item->balance,$item->comment,$us_name,$item->data);
                $name_cash="";
            }
        }
        echo(json_encode($arr_tmp));
        R::close();
    }

    function getTrPlusFromDataRange($id_user, $data1, $data2){
        $arr_tmp = array();
        $name_cash = "";
        $tr = R::findAll('tranzaction',"user_id = $id_user and date(data) >= '$data1' and date(data) <= '$data2' order by data");
        foreach($tr as $item){
            if($item->status == "plus"){
                $cash = R::findAll('cash',"id = $item->cash");
                foreach($cash as $tmp){
                    $name_cash = $tmp->name;
                }
                $us = R::findAll('users',"id = $item->user_id");
                foreach($us as $tmp_us){
                    $us_name = $tmp_us->login;
                }
                if($name_cash=="")  $name_cash="Удален";
                array_push($arr_tmp,$item->id,$item->name,$name_cash,$item->balance,$item->comment,$us_name,$item->data);
                $name_cash="";
            }
        }
        echo(json_encode($arr_tmp));
        R::close();
    }
    /// ////////////////////////////////////////////////////////////////

    function getTrPlus_fromID($id_user, $id_cash){
        $arr_tmp = array();
        $name_cash = "";
        $tr = R::findAll('tranzaction',"user_id = $id_user and cash = $id_cash");
        foreach($tr as $item){
            if($item->status == "plus"){
                $cash = R::findAll('cash',"id = $item->cash");
                foreach($cash as $tmp){
                    $name_cash = $tmp->name;
                }
                $us = R::findAll('users',"id = $item->user_id");
                foreach($us as $tmp_us){
                    $us_name = $tmp_us->login;
                }
                if($name_cash=="")  $name_cash="Удален";
                array_push($arr_tmp,$item->id,$item->name,$name_cash,$item->balance,$item->comment,$us_name,$item->data);
                $name_cash="";
            }
        }
        echo(json_encode($arr_tmp));
        R::close();
    }
    //Перенес
    function getUser_nameFromId($id_user){
        $user = R::find('users', "id = $id_user");
        foreach($user as $item){
            echo($item->login);
        }
    }

    function updateBalanceCash($id_cash, $new_bal){
        try{
            $arr_tmp = "";
            $cash = R::load('cash', $id_cash);
            $cash->balance = $new_bal;
            R::store($cash);
        }
        catch(Exception $e){
            echo($e);
        }
        R::close();
    }
    function updateBalanceCashMonth($id_cashmonth,$new_bal_month){
        try{
            $arr_tmp = "";
            $cash_month = R::load('cashmonth', $id_cashmonth);
            $cash_month->balance = $new_bal_month;
            R::store($cash_month);
        }
        catch(Exception $e){
            echo($e);
        }
        R::close();
    }

    function Del_tr($index){
        try{
            $tr = R::load('tranzaction', $index);
            R::trash($tr);
            return true;
        }
        catch(Exception $e){
            echo($e);
        }
        R::close();
    }

    function Del_translate($id_trans){
        try{
            $trans = R::load('translate', $id_trans);
            R::trash($trans);
            return true;
        }
        catch(Excetpion $e){
            echo($e);
        }
        R::close();
    }

    function addTranslate(){
        try{
            $numargs = func_num_args();
            $arg_list = func_get_args();
            $connect = new Datebase();

            $trans = R::dispense('translate');
            $trans->name = $arg_list[0];

            $cash_min = R::load('cash', $arg_list[2]);
            $cash_min->balance -= $arg_list[3];

            $id_cash_min = $connect->findCashMonthID_from_Cash($arg_list[2]);
            $cash_month_min = R::load("cashmonth", $id_cash_min);
            $cash_month_min->balance -= $arg_list[3];

            $cash_sum = R::load('cash', $arg_list[5]);
            $cash_sum->balance += $arg_list[6];

            $id_cash_sum = $connect->findCashMonthID_from_Cash($arg_list[5]);
            $cash_month_sum = R::load("cashmonth", $id_cash_sum);
            $cash_month_sum->balance += $arg_list[6];

            if(!isset($arg_list[1])) $trans->data = R::isoDateTime();
            else $trans->data = $arg_list[1];

            $trans->cash_min = $arg_list[2];
            $trans->balance_min = $arg_list[3];
            $trans->course = $arg_list[4];
            $trans->cash_sum = $arg_list[5];
            $trans->balance_sum = $arg_list[6];
            $trans->comment = $arg_list[7];
            $trans->id_user = $arg_list[8];

            R::store($trans);
            R::store($cash_min);
            R::store($cash_sum);
            R::store($cash_month_sum);
            R::store($cash_month_min);
        }
        catch(Exception $e){
            echo($e);
        }
        R::close();
    }
 //Перенес
    function getTranslate($id_user){
        $arr_tmp = array();
        $name_cash_min="";
        $name_cash_sum="";
        $trans = R::findAll('translate', "id_user = $id_user");
        foreach($trans as $item){
            $cash1 = R::findAll('cash',"id = $item->cash_min");
            foreach($cash1 as $tmp1){
                $name_cash_min = $tmp1->name;
            }
            $cash2 = R::findAll('cash',"id = $item->cash_sum");
            foreach($cash2 as $tmp2){
                $name_cash_sum = $tmp2->name;
            }
            $us = R::findAll('users',"id = $item->id_user");
            foreach($us as $tmp_us){
                $us_name = $tmp_us->login;
            }
            array_push($arr_tmp,$item->id,$item->name,$item->data,$name_cash_min,$item->balance_min,$name_cash_sum,$item->balance_sum,$item->comment,$us_name);
            $name_cash_sum="";
            $name_cash_min="";
        }
        echo(json_encode($arr_tmp));
        R::close();
    }

    ///////////////////////////////////////////////////////////////
    /// Перенес
    function getTranslateFromData($id_user, $data){
        $arr_tmp = array();
        $name_cash_min="";
        $name_cash_sum="";
        $trans = R::findAll('translate', "id_user = $id_user and date(data) = '$data'");
        foreach($trans as $item){
            $cash1 = R::findAll('cash',"id = $item->cash_min");
            foreach($cash1 as $tmp1){
                $name_cash_min = $tmp1->name;
            }
            $cash2 = R::findAll('cash',"id = $item->cash_sum");
            foreach($cash2 as $tmp2){
                $name_cash_sum = $tmp2->name;
            }
            $us = R::findAll('users',"id = $item->id_user");
            foreach($us as $tmp_us){
                $us_name = $tmp_us->login;
            }
            array_push($arr_tmp,$item->id,$item->name,$item->data,$name_cash_min,$item->balance_min,$name_cash_sum,$item->balance_sum,$item->comment,$us_name);
            $name_cash_sum="";
            $name_cash_min="";
        }
        echo(json_encode($arr_tmp));
        R::close();
    }

    function getTranslateFromDataRange($id_user, $data1, $data2){
        $arr_tmp = array();
        $name_cash_min="";
        $name_cash_sum="";
        $trans = R::findAll('translate', "id_user = $id_user and date(data) >= '$data1' and date(data) <= '$data2'");
        foreach($trans as $item){
            $cash1 = R::findAll('cash',"id = $item->cash_min");
            foreach($cash1 as $tmp1){
                $name_cash_min = $tmp1->name;
            }
            $cash2 = R::findAll('cash',"id = $item->cash_sum");
            foreach($cash2 as $tmp2){
                $name_cash_sum = $tmp2->name;
            }
            $us = R::findAll('users',"id = $item->id_user");
            foreach($us as $tmp_us){
                $us_name = $tmp_us->login;
            }
            array_push($arr_tmp,$item->id,$item->name,$item->data,$name_cash_min,$item->balance_min,$name_cash_sum,$item->balance_sum,$item->comment,$us_name);
            $name_cash_sum="";
            $name_cash_min="";
        }
        echo(json_encode($arr_tmp));
        R::close();
    }
    /// //////////////////////////////////////////////////////////

    function getTranslate_fromID($id_user, $id_cash){
        $arr_tmp = array();
        $name_cash_min="";
        $name_cash_sum="";
        $trans = R::findAll('translate', "id_user = $id_user and cash_min = $id_cash or cash_sum = $id_cash");
        foreach($trans as $item){
            $cash1 = R::findAll('cash',"id = $item->cash_min");
            foreach($cash1 as $tmp1){
                $name_cash_min = $tmp1->name;
            }
            $cash2 = R::findAll('cash',"id = $item->cash_sum");
            foreach($cash2 as $tmp2){
                $name_cash_sum = $tmp2->name;
            }
            $us = R::findAll('users',"id = $item->id_user");
            foreach($us as $tmp_us){
                $us_name = $tmp_us->login;
            }
            array_push($arr_tmp,$item->id,$item->name,$item->data,$name_cash_min,$item->balance_min,$name_cash_sum,$item->balance_sum,$item->comment,$us_name);
            $name_cash_sum="";
            $name_cash_min="";
        }
        echo(json_encode($arr_tmp));
        R::close();
    }

    function getTranslateFromID($id){
        $now_month = date("m");

        $arr_tmp = array();
        $trans = R::findAll('translate', "id = $id");
        foreach($trans as $item){
            $up_data_month = date("m", strtotime($item->data));
            if ($up_data_month != $now_month) {
                $flag = "false";
                return $flag;
            }
            else{
                array_push($arr_tmp,$item->id,$item->name,$item->data,$item->cash_min,$item->balance_min,$item->cash_sum,$item->balance_sum,$item->comment,$item->id_user,$item->course);
            }
        }
        R::close();
        return $arr_tmp;
    }
    //Пропустил
    function minBalanceTr($id,$id_cash){
        $connect = new Datebase();

        $tr = R::findAll('tranzaction', "id = $id");
        foreach($tr as $item){
           $tr_balance = $item->balance;
           $tr_cash = $item->cash;
        }
        $cash = R::load('cash', $tr_cash);
        $cash->balance += $tr_balance;
        R::store($cash);

        $id_cash_month = $connect->findCashMonthID_from_Cash($tr_cash);
        $cash_month = R::load("cashmonth", $id_cash_month);
        $cash_month->balance += $tr_balance;
        R::store($cash_month);

        R::close();

    }
//Пропустил
    function plusBalanceTr($id,$id_cash){
        $connect = new Datebase();
        $tr = R::findAll('tranzaction', "id = $id");
        foreach($tr as $item){
            $tr_balance = $item->balance;
            $tr_cash = $item->cash;
        }
        $cash = R::load('cash', $tr_cash);
        $cash->balance -= $tr_balance;
        R::store($cash);

        $id_cash_month = $connect->findCashMonthID_from_Cash($tr_cash);
        $cash_month = R::load("cashmonth", $id_cash_month);
        $cash_month->balance -= $tr_balance;
        R::store($cash_month);

        R::close();
    }

    function trUpdateMin(){
        try{
            $numargs = func_num_args();
            $arg_list = func_get_args();
            $connect = new Datebase();

            $tr_new = R::load("tranzaction", $arg_list[0]);
            $tr_new->name = $arg_list[1];
            $tr_new->cash = $arg_list[2];
            $tr_new->balance = $arg_list[3];
            $tr_new->comment = $arg_list[4];
            $tr_new->status = $arg_list[5];
            $tr_new->data = $arg_list[6];
            R::store($tr_new);

            $cash = R::load('cash', $arg_list[2]);
            $cash->balance -= $arg_list[3];
            R::store($cash);

            $id_cash = $connect->findCashMonthID_from_Cash($arg_list[2]);
            $cash_month = R::load("cashmonth", $id_cash);
            $cash_month->balance -= $arg_list[3];
            R::store($cash_month);
        }
        catch(Exception $e){
            echo("Не удалось обновить транзакцию");
        }
        R::close();
    }

    function trUpdatePlus(){
        try{
            $numargs = func_num_args();
            $arg_list = func_get_args();
            $connect = new Datebase();

            $tr_new = R::load("tranzaction", $arg_list[0]);
            $tr_new->name = $arg_list[1];
            $tr_new->cash = $arg_list[2];
            $tr_new->balance = $arg_list[3];
            $tr_new->comment = $arg_list[4];
            $tr_new->status = $arg_list[5];
            $tr_new->data = $arg_list[6];
            R::store($tr_new);

            $cash = R::load('cash', $arg_list[2]);
            $cash->balance += $arg_list[3];
            R::store($cash);

            $id_cash = $connect->findCashMonthID_from_Cash($arg_list[2]);
            $cash_month = R::load("cashmonth", $id_cash);
            $cash_month->balance += $arg_list[3];
            R::store($cash_month);
        }
        catch(Exception $e){
            echo("Не удалось обновить транзакцию");
        }
        R::close();
    }

    function minplusBalanceTrans($id,$id_cash_min,$id_cash_sum){
        $connect = new Datebase();
        $trans = R::findAll('translate', "id = $id");
        foreach($trans as $item){
            $tran_cash_min = $item->cash_min;
            $tran_balance_min = $item->balance_min;
            $tran_cash_sum = $item->cash_sum;
            $tran_balance_sum = $item->balance_sum;
        }
        $cash = R::load('cash', $tran_cash_min);
        $cash->balance += $tran_balance_min;
        R::store($cash);

        $id_cash_min = $connect->findCashMonthID_from_Cash($tran_cash_min);
        $cash_month = R::load("cashmonth", $id_cash_min);
        $cash_month->balance += $tran_balance_min;
        R::store($cash_month);

        $cash_new = R::load('cash',  $tran_cash_sum);
        $cash_new->balance -= $tran_balance_sum;
        R::store($cash_new);

        $id_cash_sum = $connect->findCashMonthID_from_Cash($tran_cash_sum);
        $cash_month_new = R::load("cashmonth", $id_cash_sum);
        $cash_month_new->balance -= $tran_balance_sum;
        R::store($cash_month_new);

        R::close();

    }

    function upDate_trans(){
        try{
            $connect = new Datebase();
            $numargs = func_num_args();
            $arg_list = func_get_args();

            $trans = R::load('translate', $arg_list[0]);
            $trans->name = $arg_list[1];
            $trans->data = $arg_list[2];
            $trans->cash_min = $arg_list[3];
            $trans->balance_min = $arg_list[4];
            $trans->course = $arg_list[5];
            $trans->cash_sum = $arg_list[6];
            $trans->balance_sum = $arg_list[7];
            $trans->comment = $arg_list[8];
            R::store($trans);

            $cash = R::load('cash', $arg_list[3]);
            $cash->balance -= $arg_list[4];
            R::store($cash);

            $id_cash = $connect->findCashMonthID_from_Cash($arg_list[3]);
            $cash_month = R::load("cashmonth", $id_cash);
            $cash_month->balance -= $arg_list[4];
            R::store($cash_month);

            $cash_new = R::load('cash',$arg_list[6] );
            $cash_new->balance += $arg_list[7];
            R::store($cash_new);

            $id_cash_new = $connect->findCashMonthID_from_Cash($arg_list[6]);
            $cash_month_new = R::load("cashmonth", $id_cash_new);
            $cash_month_new->balance += $arg_list[7];
            R::store($cash_month_new);
        }
        catch(Exception $e){
            echo("Не удалось обновить транзакцию");
        }
        R::close();
    }

    function getDataOfTr($id_user,$status){ // получить дату транзакции по статусу
        $arr_tmp = array();
        $now_month = date("m");
        $tr = R::find('tranzaction',"user_id = $id_user and status = '$status' and month(data)<$now_month order by data ");

        foreach($tr as $item){
            array_push($arr_tmp,substr($item->data, 0,10));
        }
        $result = array_unique($arr_tmp);
        R::close();
        return($result);
    }

/*
   function getAllBalanceOfData($id_user, $status){
       $arr_tmp = array();
       $tr = R::getAll("select name, date(data) as data, sum(balance) as balance from tranzaction  where  user_id = $id_user and status = '$status' group by date(data)");
       foreach($tr as $item){
           array_push($arr_tmp, new LineChart($item["name"], $item["data"],$item["balance"]));
       }
       R::close();
       return $arr_tmp;
   }
*/


   function getAllBalOfData($id_user, $status){
       $balance = 0;
       $balances = array();
       $datas_tr = array();
       $tr_all_day = array();
       $data_tr = R::getAll("select date(data) as data from tranzaction where user_id = $id_user and status = '$status' and month(data)='2' group by date(data)");
       foreach($data_tr as $tmp){
           array_push($datas_tr,$tmp);
       }
       foreach($datas_tr as $item){
          /* $usd_sale = 1;
           $eur_sale = 1;
           $rur_sale = 1;*/
           //$tr = R::getAll("select date(data) as data, balance, cash from tranzaction where user_id = $id_user and status = '$status' and date(data) = '".$item['data']."'");
           $tr = R::getAll("select date(data) as data, tranzaction.balance, cash, cash.type_money, tranzaction.course as course from tranzaction inner join cash on tranzaction.cash=cash.id where user_id = $id_user and status = '$status' and date(data)='".$item['data']."'");
           //$tr = R::getAll("select date(tranzaction.data) as data, tranzaction.balance, cash, cash.type_money, day(tranzaction.data) as daytr from tranzaction inner join cash on tranzaction.cash=cash.id where user_id = $id_user and status = '$status' and date(data)='".$item['data']."' order by tranzaction.data");
           foreach($tr as $item){
                    if($item['course'] != 0){
                        $balance += $item['balance'] * $item['course'];
                    }
                    else{
                        $balance += $item['balance'];
                    }
                }

           array_push($tr_all_day, new LineChart($item["data"], round($balance,2)));
           $balance = 0;
       }
       R::close();
       return $tr_all_day;
       //return $courses;
   }

    function getBalanceFromMonth($id_user, $month, $status){ // Подсчитать баланс доходов за один месяц
        //$now_month = date("m");
        $all_bal_from_month = 0;
        $tr_plus= R::getAll("select tranzaction.balance, cash, cash.type_money, tranzaction.course as course from tranzaction inner join cash on tranzaction.cash=cash.id where user_id = $id_user and status = '$status' and month(data)=$month");
        foreach($tr_plus as $item){
                if($item['course'] != 0){
                    $all_bal_from_month += $item['balance'] * $item['course'];
                }
                else{
                    $all_bal_from_month += $item['balance'];
                }
        }
        R::close();
        return round($all_bal_from_month,2);
    }

    function addUserGroup($id_user,$id_guest){
        $group = R::dispense("groups");
        //$group->user_id = $id_user;
        //$group->admin = $id_user;
        $group->id_guest = $id_guest;
        R::store($group);
        R::close();
    }


}



?>