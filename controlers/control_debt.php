<?php
require_once "db.php";
require_once 'getCourse.php';

$con = new Datebase();
$con->Connection();

$course = getCourse();

$id_cur_user = $con->findIdUser();