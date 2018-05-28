<?php

class Tranzaction extends Datebase{

    private $id;
    private $name;
    private $cash;
    private $balance;
    private $course;
    private $comment;
    private $user_id;
    private $data;
    private $status;

    public function setId($id){
        $this->id = $id;
    }
    public function getId(){
        return $this->id;
    }

    public function setName($name){
        $this->name = $name;
    }
    public function getName(){
        return $this->name;
    }

    public function setCash_Tr($cash){
        $this->cash = $cash;
    }
    public function getCash_Tr(){
        return $this->cash;
    }

    public function setBalance($balance){
        $this->balance = $balance;
    }
    public function getBalance(){
        return $this->balance;
    }

    public function setCourse($course){
        $this->course = $course;
    }
    public function getCourse(){
        return $this->course;
    }

    public function setComment($comment){
        $this->comment = $comment;
    }
    public function getComment(){
        return $this->comment;
    }

    public function setUser_Id($user_id){
        $this->user_id = $user_id;
    }
    public function getUser_Id(){
        return $this->user_id;
    }

    public function setData($data){
        $this->data = $data;
    }
    public function getData(){
        return $this->data;
    }

    public function setStatus($status){
        $this->status = $status;
    }
    public function getStatus(){
        return $this->status;
    }

    public function FindTr(){
        try{
            $traz = R::find("tranzaction","name = '$this->name' and cash = $this->cash and user_id=$this->user_id and data = '$this->data' and status='$this->status'");
            foreach($traz as $item){
                return $item['id'];
            }
        }
        catch(Exception $e){
            echo($e);
        }
        R::close();
    }

    public function AddTranz(){
        try{
            $tr_course1 = $this->getCourseCash();
            $tr = R::dispense("tranzaction");
            $tr->name = $this->name;
            $tr->cash = $this->cash;
            $tr->balance = $this->balance;
            $tr->course = round($tr_course1,2);
            $tr->comment = $this->comment;
            $tr->userId = $this->user_id;
            if(!isset($this->data)) $tr->data = date("Y-m-d H:m");
            else $tr->data = $this->data;
            $tr->status = $this->status;
            R::store($tr);
            return true;
        }
        catch(Exception $e){
            echo($e);
        }
        R::close();
    }

    public function getCourseCash(){
            $tr_course = 0;
            $cash = R::find("cash","id = $this->cash");
            foreach($cash as $item){
                $cash_type_money = $item->type_money;
            }
            $date = date_create($this->data);
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
            return $tr_course;
    }

    public function ExtraTranzaction(){
        try{
            $now = date("2018-04-01");
            //$now = date("Y-m-d");
            $date = new DateTime($now);
            $date->modify('-1 day');
            $last_day = $date->format('Y-m-d');

            $cash = R::find("cash","name='Копилка' and iduser = $this->user_id");
            foreach($cash as $item){
                $id_ex_cash = $item->id;
            }

            $ex_tr = R::dispense("tranzaction");
            $ex_tr->name = "Дополнительная транзакция";
            $ex_tr->cash = $id_ex_cash;
            $ex_tr->balance = $this->balance;
            $ex_tr->comment = "Можно изменить";
            $ex_tr->user_id = $this->user_id;
            $ex_tr->data = $last_day." 23:59";
            $ex_tr->status = $this->status;
            $ex_tr->course = 0;
            R::store($ex_tr);

            $cash = R::load("cash",$id_ex_cash);
            if($this->status == "minus"){
                $cash->balance -= $this->balance;
            }
            if($this->status == "plus"){
                $cash->balance += $this->balance;
            }
            R::store($cash);
        }
        catch(Exception $e){
            echo($e);
        }
        R::close();
    }

    public function getTranzacionById(){
        $arr_tmp = array();
        $st = "";
        $tr = R::findAll('tranzaction',"id = $this->id");
        foreach($tr as $item) {
            $cash = R::findAll('cash',"id = $item->cash");
            foreach($cash as $tmp){
                $name_cash = $tmp->name;
                $name_val = $tmp->type_money;
            }
            if($name_cash=="")  $name_cash="Удален";

            if($item['status'] == 'minus') $st = "Расход";
            if($item['status'] == 'plus') $st = "Доход";
            array_push($arr_tmp, $item->id, $item->name, $name_cash, $item->balance, $item->comment, $item->user_id, $item->data, $st,$name_val);
        }
        R::close();
        return $arr_tmp;
    }

    public function getTranzFrom_Id_and_CurMonth(){
        $now_month = date("m");
        $arr_tmp = array();
        $tr = R::findAll('tranzaction',"id = $this->id");
        foreach($tr as $item) {
            $up_data_month = date("m", strtotime($item->data));
            if ($up_data_month < $now_month) {
                $flag = false;
                return $flag;
            }
            else {
                array_push($arr_tmp, $item->id, $item->name, $item->cash, $item->balance, $item->comment, $item->user_id, $item->data, $item->status);
            }
        }
        R::close();
        //return json_encode($arr_tmp);
        return $arr_tmp;
    }

    public function getTranz(){
        $arr_tmp = array();
        $name_cash = "";
        $tr = R::findAll('tranzaction',"user_id = $this->user_id order by data");
        foreach($tr as $item){
            if($item->status == $this->status){
                $cash = R::findAll('cash',"id = $item->cash");
                foreach($cash as $tmp){
                    $name_cash = $tmp->name;
                    $name_val = $tmp->type_money;
                }
                $us = R::findAll('users',"id = $item->user_id");
                foreach($us as $tmp_us){
                    $us_name = $tmp_us->login;
                }
                if($name_cash=="")  $name_cash="Удален";
                array_push($arr_tmp,$item->id,$item->name,$name_cash,$item->balance,$item->comment,$us_name,$item->data,$name_val);
                $name_cash="";
            }
        }
        echo(json_encode($arr_tmp));
        R::close();
    }

    public function getTranzNotJSON($hid_month){
        $arr_tmp = array();
        $name_cash = "";
        $tr = R::findAll('tranzaction',"user_id = $this->user_id and month(data) = $hid_month order by data");
        foreach($tr as $item){
            if($item->status == $this->status){
                $cash = R::findAll('cash',"id = $item->cash");
                foreach($cash as $tmp){
                    $name_cash = $tmp->name;
                    $valuta = $tmp->type_money;
                }
                $us = R::findAll('users',"id = $item->user_id");
                foreach($us as $tmp_us){
                    $us_name = $tmp_us->login;
                }
                if($name_cash=="")  $name_cash="Удален";
                array_push($arr_tmp,$item->id,$item->name,$name_cash,$item->balance,$item->comment,$us_name,$item->data, $valuta);
                $name_cash="";
            }
        }
        return $arr_tmp;
        R::close();
    }

    public function getTranzFromData(){ //getTrMinFromData
        $arr_tmp = array();
        $name_cash = "";
        $tr = R::findAll('tranzaction',"user_id = $this->user_id and date(data) = '$this->data' order by data");
        foreach($tr as $item){
            if($item->status == $this->status){
                $cash = R::findAll('cash',"id = $item->cash");
                foreach($cash as $tmp){
                    $name_cash = $tmp->name;
                    $name_valute = $tmp->type_money;
                }
                $us = R::findAll('users',"id = $item->user_id");
                foreach($us as $tmp_us){
                    $us_name = $tmp_us->login;
                }
                if($name_cash=="")  $name_cash="Удален";
                array_push($arr_tmp,$item->id,$item->name,$name_cash,$item->balance,$item->comment,$us_name,$item->data,$name_valute);
                $name_cash="";
            }
        }
        echo(json_encode($arr_tmp));
        R::close();
    }

    public function getTranzByRange($data1, $data2){ //getTrMinFromDataRange
        $arr_tmp = array();
        $name_cash = "";
        $tr = R::findAll('tranzaction',"user_id = $this->user_id and date(data) >= '$data1' and date(data) <= '$data2' order by data");
        foreach($tr as $item){
            if($item->status == $this->status){
                $cash = R::findAll('cash',"id = $item->cash");
                foreach($cash as $tmp){
                    $name_cash = $tmp->name;
                    $name_cash_val = $tmp->type_money;
                }
                $us = R::findAll('users',"id = $item->user_id");
                foreach($us as $tmp_us){
                    $us_name = $tmp_us->login;
                }
                if($name_cash=="")  $name_cash="Удален";
                array_push($arr_tmp,$item->id,$item->name,$name_cash,$item->balance,$item->comment,$us_name,$item->data,$name_cash_val);
                $name_cash="";
            }
        }
        echo(json_encode($arr_tmp));
        R::close();
    }

    public function getTranzFrom_Cash_User(){
        $arr_tmp = array();
        $name_cash = "";
        $tr = R::findAll('tranzaction',"user_id = $this->user_id and cash = $this->cash");
        foreach($tr as $item){
            if($item->status == $this->status){
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

    public function DelTranz(){
        try{
            $tr = R::load('tranzaction', $this->id);
            R::trash($tr);
            return true;
        }
        catch(Exception $e){
            echo($e);
        }
        R::close();
    }

    public function DelTranzByCash(){
        $tr = R::find("tranzaction", "cash = $this->cash");
       /* foreach($tr as $item){
            $tmp = R::load("tranzaction",$item['id']);
            R::trash($item[$tmp]);
        }*/

        return $tr;
        R::close();
    }

    public function getTranz_Balance_Id(){
        $arr_tmp = Array();
        $tr = R::findAll('tranzaction', "id = $this->id");
        foreach($tr as $item){
            $tr_balance = $item->balance;
            $tr_cash = $item->cash;
        }
        array_push($arr_tmp, $tr_balance,$tr_cash);
        return $arr_tmp;
        R::close();
    }

    public function UpdateTranz(){
        try{
            $tr_new = R::load("tranzaction", $this->id);
            $tr_new->name = $this->name;
            $tr_new->cash = $this->cash;
            $tr_new->balance = $this->balance;
            $tr_new->comment = $this->comment;
            if($this->status != "") $tr_new->status = $this->status;
            if($this->data == "") $tr_new->data = date("Y-m-d H:m");
            else $tr_new->data = $this->data;
            R::store($tr_new);
            return true;
        }
        catch(Exception $e){
            echo("Не удалось обновить транзакцию");
        }
        R::close();
    }

    function getTranzBalanceFromMonth(){ // Подсчитать баланс доходов за один месяц
        $date = date_create($this->data);
        $month = date_format($date,"m");
        //$now_month = date("m");
        $all_bal_from_month = 0;
        $tr_plus= R::getAll("select tranzaction.balance, cash, cash.type_money, tranzaction.course as course from tranzaction inner join cash on tranzaction.cash=cash.id where user_id = $this->user_id and status = '$this->status' and month(data)=$month");
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

    function getDataByTranz(){ // получить дату транзакции по статусу
        $arr_tmp = array();
        $now_month = date("m");
        $tr = R::find('tranzaction',"user_id = $this->user_id and status = '$this->status' and month(data)<$now_month order by data ");


        foreach($tr as $item){
            array_push($arr_tmp,substr($item->data, 0,10));
        }
        $result = array_unique($arr_tmp);
        R::close();
        return($result);
    }


    public function getBalanceByData(){
        $balance = 0;
        $tr_one_day = Array();
        $balances = array();
        $datas_tr = array();
        $tr_all_day = array();
        $data_tr = R::getAll("select date(data) as data from tranzaction where user_id = $this->user_id and status = '$this->status' and month(data)='$this->data' group by date(data)");
        foreach($data_tr as $tmp){
            array_push($datas_tr,$tmp);
        }
        foreach($datas_tr as $item){
            /* $usd_sale = 1;
             $eur_sale = 1;
             $rur_sale = 1;*/
            //$tr = R::getAll("select date(data) as data, balance, cash from tranzaction where user_id = $id_user and status = '$status' and date(data) = '".$item['data']."'");
            $tr = R::getAll("select date(data) as data, tranzaction.balance, tranzaction.name as name, tranzaction.course as course from tranzaction inner join cash on tranzaction.cash=cash.id where user_id = $this->user_id and status = '$this->status' and date(data)='".$item['data']."'");
            //$tr = R::getAll("select date(tranzaction.data) as data, tranzaction.balance, cash, cash.type_money, day(tranzaction.data) as daytr from tranzaction inner join cash on tranzaction.cash=cash.id where user_id = $id_user and status = '$status' and date(data)='".$item['data']."' order by tranzaction.data");
            //array_push($tr_one_day, $this->getEachTranzByChart($item['data']));
            foreach($tr as $item){
                if($item['course'] != 0){
                    $balance += $item['balance'] * $item['course'];
                }
                else{
                    $balance += $item['balance'];
                }
            }
//
            array_push($tr_all_day, new LineChart($item["data"], round($balance,2), $item['name']));
            $balance = 0;

//            //$line_chart->setData($item["data"]);
//            $line_chart->setBalance(round($balance,2));
//            array_push($tr_all_day, $line_chart->getData(),$line_chart->getBalance());
        }
        R::close();
        //return $tr_one_day;
        return $tr_all_day;
        //return $courses;
    }

    public function getEachTranzByChart($data){
        $arr_tmp = Array();
        $balance = 0;
        $tr = R::getAll("select status, date(data) as data, tranzaction.balance as balance, tranzaction.name as name, cash.type_money, tranzaction.course as course from tranzaction inner join cash on tranzaction.cash=cash.id where user_id = $this->user_id  and date(data)='$data'");
        foreach($tr as $item){
            if($item['course'] != 0){
                $balance = $item['balance'] * $item['course'];
            }
            else{
                $balance = $item['balance'];
            }

            $line_chart = new LineChart($item["data"], round($balance,2), $item['name']);
            $line_chart->setStatus($item['status']);
            //$line_chart = $lich->setLineTwo($item["data"], round($balance,2), $item['name']);
            $line_chart->setType_Money($item['type_money']);
            array_push($arr_tmp, $line_chart);
        }
        return $arr_tmp;
    }

    public function getCountTrazByCash(){
        //$tr = R::findAll("tranzaction", "user_id=$this->user_id and cash=$this->cash");
        $tr = R::getAll("select count(id) as count from tranzaction where user_id=$this->user_id and cash=$this->cash");
        foreach($tr as $item){
            echo($item['count']);
        }
    }

    public function getBalanceByMonth($month){
        $balance = 0;
        $tr = R::getAll("select tranzaction.balance, tranzaction.name as name, cash, cash.type_money, tranzaction.course as course from tranzaction inner join cash on tranzaction.cash=cash.id where user_id = $this->user_id and status = '$this->status' and month(data)=$month");
        foreach($tr as $item){
            if($item['course'] != 0){
                $balance += $item['balance'] * $item['course'];
            }
            else{
                $balance += $item['balance'];
            }
        }
        return $balance;
    }

    function getDataOfTran(){ // получить дату транзакции по статусу
        $arr_tmp = array();
        $now_month = date("m");
        $tr = R::find('tranzaction',"user_id = $this->user_id and status = '$this->status' and month(data)<$now_month order by data ");

        foreach($tr as $item){
            array_push($arr_tmp,substr($item->data, 0,10));
        }
        $result = array_unique($arr_tmp);
        R::close();
        return($result);
    }

    function getBalanceTranByMonth($month){
        //$now_month = date("m");
        $all_bal_from_month = 0;
        $tr_plus= R::getAll("select tranzaction.balance, cash, cash.type_money, tranzaction.course as course from tranzaction inner join cash on tranzaction.cash=cash.id where user_id = $this->user_id and status = '$this->status' and month(data)=$month");
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

    public function getBalanceById(){
        $tr = R::find("tranzaction","id=$this->id");
        foreach($tr as $item){
            return $item['balance'];
        }
        R::close();
    }

    public function getStatusById(){
        $tr = R::find("tranzaction","id=$this->id");
        foreach($tr as $item){
            return $item['status'];
        }
        R::close();
    }


}