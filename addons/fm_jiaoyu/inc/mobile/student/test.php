<?php

$studentid=1816;

$overtime = time() + 3600*24; //Ĭ�϶�ά��72Сʱ����Ч
 
$ticket =$studentid.$overtime;
$ticket = sprintf("%018s",  $ticket);//  ticket�ֶ���ѧ��id+��Ч�ڣ�����18λ��ǰ�油0
   
 echo $ticket;

?>