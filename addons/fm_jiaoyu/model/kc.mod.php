<?php 
/**
 * 微教育模块
 *
 * @author 高贵血迹
 */
defined('IN_IA') or exit('Access Denied');
load()->func('communication');

//取正1间教室，正在上课或在打卡时间内即将开始打卡上课的课时
function Getnearks($roomid,$starttime,$endtime){
	$allks = pdo_fetchall("SELECT * FROM " . tablename('wx_school_kcbiao') . " WHERE  addr_id = '{$roomid}'  AND date > '{$starttime}' AND date < '{$endtime}' ORDER BY date ASC");
	if($allks){
		$nowtime = time();
		$nowkc = '';
		$nowks = '';
		foreach($allks as $row){
			/**取即将开始和已经开始的课程**/
			$plustime = 0;
			$sdinfo  = pdo_fetch("SELECT sd_start,sd_end FROM " . tablename('wx_school_classify') . " WHERE  sid = '{$row['sd_id']}'");
			$checkkc = pdo_fetch("SELECT * FROM " . tablename('wx_school_tcourse') . " WHERE id = :id ", array(':id' => $row['kcid']));
			if($checkkc['isSign'] == 1){
				$plustime = $checkkc['signTime']*60;
			}else{
				$plustime = 20*60;
			}
			$check_start = strtotime(date("Y-m-d",$nowtime).date(" H:i",$sdinfo['sd_start'])) - $plustime; //当前课时开始时间向前延伸到设置的签到的时间
			$check_end   = strtotime(date("Y-m-d",$nowtime).date(" H:i",$sdinfo['sd_end']));
			if($nowtime >= $check_start && $nowtime <= $check_end){
				$nowkc[] = $checkkc;
				$nowks[] = $row;
			}
		}
		if($nowkc && $nowks){
			$reslut['nowkc'] = $nowkc;
			$reslut['nowks'] = $nowks;
		}else{
			$reslut = false;
		}
	}else{
		$reslut = false;
	}
	return $reslut ;
}

function getksbiao($schoolid,$classid,$starttime,$endtime){
	$allks = pdo_fetchall("SELECT sd_id,kcid,tid FROM " . tablename('wx_school_kcbiao') . " WHERE  addr_id = '{$classid}'  AND date > '{$starttime}' AND date < '{$endtime}' ORDER BY date ASC");
	$week = date("w",time());
	$section = 0;
	foreach($allks as $key => $row){
		$section ++;
		$sd  = pdo_fetch("SELECT sd_start,sd_end FROM " . tablename('wx_school_classify') . " WHERE  sid = '{$row['sd_id']}'");
		$kc = pdo_fetch("SELECT name FROM " . tablename('wx_school_tcourse') . " WHERE id = :id ", array(':id' => $row['kcid']));
		$teacher = pdo_fetch("SELECT tname,thumb FROM " . tablename('wx_school_teachers') . " WHERE id = '{$row['tid']}'");
		$school = pdo_fetch("SELECT tpic FROM " . tablename('wx_school_index') . " WHERE id = '{$schoolid}'");
		$allks[$key]['week'] = $week;
		$allks[$key]['section'] = $section;
		$allks[$key]['course_name'] = $kc['name'];
		$allks[$key]['start_time'] = date(" H:i",$sd['sd_start']);
		$allks[$key]['end_time'] = date(" H:i",$sd['sd_end']);
		$allks[$key]['teacher_name'] = $teacher['tname'];
		$allks[$key]['teacher_img'] = !empty($teacher['thumb'])?tomedia($school['tpic']):tomedia($teacher['thumb']);
		unset($allks[$key]['sd_id']);
		unset($allks[$key]['kcid']);
		unset($allks[$key]['tid']);
	}
	return $allks ;
}

function GetStuInfoByKs($schoolid,$ksid){
	$ksinfo  = pdo_fetch("SELECT * FROM " . tablename('wx_school_kcbiao') . " WHERE id = '{$ksid}' and schoolid = '{$schoolid}' ");
	$signStu = pdo_fetchall("SELECT distinct sid FROM " . tablename('wx_school_kcsign') . " WHERE ksid = '{$ksid}' and schoolid = '{$schoolid}' and tid = 0 and sid != 0 ");
	$timeinfo = pdo_fetch("SELECT sd_start,sd_end FROM " . tablename('wx_school_classify') . " WHERE sid = '{$ksinfo['sd_id']}' and schoolid = '{$schoolid}' and type = 'timeframe' ");
	$starttime_str = date("Y-m-d",$ksinfo['date'])." ".date("H:i:s",$timeinfo['sd_start']);
	$endtime_str = date("Y-m-d",$ksinfo['date'])." ".date("H:i:s",$timeinfo['sd_end']);
	$starttime = strtotime($starttime_str);
	$endtime = strtotime($endtime_str);
	$LeaveStu = pdo_fetchall("SELECT distinct leaves.sid FROM " . tablename('wx_school_leave') . " as leaves , " . tablename('wx_school_order') . " as orderTab  WHERE orderTab.kcid = '{$ksinfo['kcid']}' and orderTab.schoolid = '{$schoolid}' and orderTab.type = 1 and orderTab.status = 2  and orderTab.sid != 0 and orderTab.sid = leaves.sid and leaves.startime1 <= '{$starttime}' and leaves.endtime1 >= '{$endtime}' "); 
	$AllStu = pdo_fetchall("SELECT sid FROM ". tablename('wx_school_order') . "  WHERE kcid = '{$ksinfo['kcid']}' and schoolid = '{$schoolid}' and type = 1 and status = 2  and sid != 0 "); 
	$result['signstu'] = count($signStu);
	$result['leavestu'] = count($LeaveStu);
	$result['allstu'] = count($AllStu);
	return $result;
	
}




?>