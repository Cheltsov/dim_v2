<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

<button>Button</button>

<div id="test"></div>

<script>
    $("button").click(function(){
        $.post(
            "test_trans.php",
            {
                test_tr : "1"
            },
            function(data){
                //alert(data);
                $("#test").append(data);
            }
        );
    });
</script>

<?php
require_once '../class/user.php';
require_once '../class/cash.php';
require_once '../class/cashmonth.php';
require_once '../class/translate.php';

$trans = new Translate();
$user = new User();
$cashmonth = new Cashmonth();
$cash = new Cash();

if(isset($_POST['test_tr'])){




    /* Обновление Перевода
    $trans->setId(21);
    $trans->setName("Новое изменение222");
    $trans->setData("2018-04-22 23:54:12");
    $trans->setCash_Min(54);
    $trans->setBalance_Min(1000);
    $trans->setCourse(0);
    $trans->setCash_Sum(59);
    $trans->setBalance_Sum(100);
    $trans->setComment("");
    $trans->setId_User(32);

    $tmp = $trans->UpdateTrans();
    print $tmp;

    $cash->setBalance($trans->getBalance_Min());
    $cash->setId($trans->getCash_Min());
    $tmp2 = $cash->UpdateCash_BalanceMin();
    print $tmp2;

    $cashmonth->setBalance($trans->getBalance_Min());
    $cashmonth->setId_Cash($trans->getCash_Min());
    $tmp3 = $cashmonth->UpdateCashMonth_BalanceMin();
    print $tmp3;

    $cash->setBalance($trans->getBalance_Sum());
    $cash->setId($trans->getCash_Sum());
    $tmp4 = $cash->UpdateCash_BalancePlus();
    print $tmp4;

    $cashmonth->setBalance($trans->getBalance_Sum());
    $cashmonth->setId_Cash($trans->getCash_Sum());
    $tmp5 = $cashmonth->UpdateCashMonth_BalancePlus();
    print $tmp5;
*/

    /*
$trans->setId(21);
$tmp = $trans->getTransFromId();
echo("<pre>");
print_r($tmp);*/

    /*
$trans->setId_User(32);
$trans->setId_Cash(54);
$trans->getTransFromId_User_Id_Cash();*/

   /* $trans->setId_User(32);
    $trans->getTransFromDataRange("2018-01-01","2018-02-28");*/

   /* $trans->setId_User(32);
    $trans->setData("2018-01-01");
    $trans->getTransFromData();*/

   /* $trans->setId_User(32);
    $trans->getTrans();*/

/* ДОбавление перевода
    $trans->setName("Test_translate");
    $trans->setCash_Min(54);
    $trans->setBalance_Min(100);
    $trans->setCourse(2);
    $trans->setCash_Sum(59);
    $trans->setBalance_Sum(200);
    $trans->setComment("test translate");
    $trans->setId_User(32);
    $trans->setData("2018-04-22 23:14:00");

    $tmp = $trans->AddTrans();
    print $tmp;

    $cash->setBalance(100);
    $cash->setId(54);
    $tmp2 = $cash->UpdateCash_BalanceMin();
    print $tmp2;

    $cashmonth->setBalance(100);
    $cashmonth->setId_Cash(54);
    $tmp3 = $cashmonth->UpdateCashMonth_BalanceMin();
    print $tmp3;

    $cash->setBalance(200);
    $cash->setId(59);
    $tmp4 = $cash->UpdateCash_BalancePlus();
    print $tmp4;

    $cashmonth->setBalance(200);
    $cashmonth->setId_Cash(59);
    $tmp5 = $cashmonth->UpdateCashMonth_BalancePlus();
    print $tmp5;
*/
}



