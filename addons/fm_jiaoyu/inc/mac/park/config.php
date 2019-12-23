<?php
/**
 * Created by PhpStorm.
 * User: laiguanhui
 * Date: 2019-06-18
 * Time: 17:33
 */

$mysql_conf = array(
    'host'    => '127.0.0.1:3306',
    'db'      => 'test',
    'db_user' => 'root',
    'db_pwd'  => 'root',
);

$schoolid=1;//学校id
$webservice_url = "http://59.39.179.76:9080/services/hole?wsdl";//webservice地址
$directArr = array(
    "1" => "1",
    "2" => "1"
);

//日志文件
$log = fopen("car.log", "a");
