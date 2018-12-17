<?php

$studentid=1816;

$overtime = time() + 3600*24; //默认二维码72小时内有效
 
$ticket =$studentid.$overtime;
$ticket = sprintf("%018s",  $ticket);//  ticket字段是学生id+有效期，不足18位的前面补0
   
 echo $ticket;

?>