<?php
/**
 * By 高贵血迹
 */
$type = "异常进出";
$leixing = 3;
$now = str_replace(":",".",$nowtime);
$jxstart = str_replace(":",".",$school['jxstart']);
$lxstart = str_replace(":",".",$school['lxstart']);
$jxstart1 = str_replace(":",".",$school['jxstart1']);
$lxstart1 = str_replace(":",".",$school['lxstart1']);
$jxstart2 = str_replace(":",".",$school['jxstart2']);
$lxstart2 = str_replace(":",".",$school['lxstart2']);
$jxend = str_replace(":",".",$school['jxend']);
$lxend = str_replace(":",".",$school['lxend']);
$jxend1 = str_replace(":",".",$school['jxend1']);
$lxend1 = str_replace(":",".",$school['lxend1']);
$jxend2 = str_replace(":",".",$school['jxend2']);
$lxend2 = str_replace(":",".",$school['lxend2']);
if($signMode == 65 || $signMode == 66 || $signMode == 1 || $signMode == 2){
	if($signMode == 65 || $signMode == 1){
		if($macid == 'CC:B8:A8:32:A1:02' || $macid == 'CC:B8:A8:32:20:A6' || $macid == 'CC:B8:A8:2C:BA:96'){
			$leixing = 2;
			$lx = "离校";			
		}else{
			$leixing = 1;
			$lx = "进校";
		}
	}
	if($signMode == 66 || $signMode == 2){
		if($macid == 'CC:B8:A8:32:A1:02' || $macid == 'CC:B8:A8:32:20:A6' || $macid == 'CC:B8:A8:2C:BA:96'){
			$leixing = 1;
			$lx = "进校";			
		}else{
			$leixing = 2;
			$lx = "离校";
		}		
	}

	$sql2 = "SELECT * FROM " . tablename($this->table_leave) . " WHERE sid = ".$ckuser['sid']." And schoolid = ".$schoolid." And startime1 <= ".time()." And endtime1 >= ".time();
    $hasLeave = pdo_fetch($sql2);
//    $hasLeave = pdo_fetch("SELECT * FROM " . tablename($this->table_leave) . " WHERE sid = :sid And schoolid = :schoolid And startime1 <= :nowUTime1 And endtime1 >= :nowUTime2 ", array(':sid' =>$ckuser['sid'], ':schoolid' =>$schoolid, ':nowUTime1'=>time(), ':nowUTime2'=>time()));
    if(!empty($hasLeave)){
        $type = "正常请假".$lx;
    }else {
        if ($jxstart <= $now & $now <= $jxend) {
            $type = "早上" . $lx;
        }elseif($lxstart <= $now & $now <= $lxend) {
            $type = "下午" . $lx;
        }elseif($jxstart1 <= $now & $now <= $jxend1) {
            $type = "午间" . $lx;
        }elseif($lxstart1 <= $now & $now <= $lxend1) {
            $type = "午间" . $lx;
        }elseif($jxstart2 <= $now & $now <= $jxend2) {
            $type = "晚间" . $lx;
        }elseif($lxstart2 <= $now & $now <= $lxend2) {
            $type = "晚间" . $lx;
        }else{
            $type = $type.":".$lx;
        }
    }
}else{
    $sql2 = "SELECT * FROM " . tablename($this->table_leave) . " WHERE sid = ".$ckuser['sid']." And schoolid = ".$schoolid." And startime1 <= ".time()." And endtime1 >= ".time();
    $hasLeave = pdo_fetch($sql2);
	if ($jxstart <= $now & $now <= $jxend){
		$type = "早上进校";
		$leixing = 1;
	}
	if ($lxstart <= $now & $now <= $lxend){
		$type = "下午离校";
		$leixing = 2;
	}
	if ($jxstart1 <= $now & $now <= $jxend1){
		$type = "午间进校";
		$leixing = 1;
	}
	if ($lxstart1 <= $now & $now <= $lxend1){
		$type = "午间离校";
		$leixing = 2;
	}
	if ($jxstart2 <= $now & $now <= $jxend2){
		$type = "晚间进校";
		$leixing = 1;
	}
	if ($lxstart2 <= $now & $now <= $lxend2){
		$type = "晚间离校";
		$leixing = 2;
	}
    if(!empty($hasLeave)){
        $type = "正常请假:".$type;
    }
}
?>