<?php
/**
 * Created by PhpStorm.
 * User: laiguanhui
 * Date: 2019-09-05
 * Time: 11:23
 */
date_default_timezone_set("PRC");
header("Content-type:text/html;charset=utf-8");
require_once 'Car.class.php';
require_once 'config.php';
set_time_limit(0);

$mysqli = @new mysqli($mysql_conf['host'], $mysql_conf['db_user'], $mysql_conf['db_pwd']);
if ($mysqli->connect_errno) {
    fwrite($log, date("Y-m-d H:i:s", time())."  could not connect to the database:\r\n" . $mysqli->connect_error ."\r\n");
    die("could not connect to the database:\r\n" . $mysqli->connect_error);//诊断连接错误
}
$mysqli->query("set names 'utf8';");//编码转化
$select_db = $mysqli->select_db($mysql_conf['db']);
if (!$select_db) {
    fwrite($log, date("Y-m-d H:i:s", time())."  could not connect to the db:\r\n" .  $mysqli->error . "\r\n");
    die("could not connect to the db:\r\n" .  $mysqli->error);
}

//将车辆和其过闸信息上传至服务器
//上传车辆信息
$sql = "select * from car where isNew=1";
$res = $mysqli->query($sql);
$data=[];
while($car = $res->fetch_assoc()) {
    array_push($data['car'], $car);
}
$url = "http://jy.xingheoa.com/app/index.php?i=3&c=entry&schoolid=".$schoolid."&do=park&m=fm_jiaoyu&op=upload";
$data_json = json_encode($data);
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS,$data_json);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
print_r($response);
curl_close($ch);