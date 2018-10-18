<?php
/**
 * 微教育模块
 *
 * @author 高贵血迹
 */
        global $_W, $_GPC;
        $weid = $_W ['uniacid'];
		$schoolid = intval($_GPC['schoolid']);
		$openid = $_W['openid'];
		$time = $_GPC['time'];
		$logid = trim($_GPC['logid']);	
		if (!empty($_GPC['userid'])){
			$_SESSION['user'] = $_GPC['userid'];
		}
		$it = pdo_fetch("SELECT * FROM " . tablename($this->table_user) . " where id = :id And openid = :openid ", array(':id' => $_SESSION['user'],':openid' => $openid));
		$school = pdo_fetch("SELECT style2 FROM " . tablename($this->table_index) . " where weid = :weid AND id = :id ", array(':weid' => $weid, ':id' => $schoolid));
		$student = pdo_fetch("SELECT s_name,bj_id FROM " . tablename($this->table_students) . " where id = :id AND schoolid = :schoolid ", array(':id' => $it['sid'], ':schoolid' => $schoolid));
		if(!empty($it)){
			$time = $_GPC['time'];
			if(empty($time)){
				$starttime = mktime(0,0,0,date("m"),date("d"),date("Y"));
				$endtime = $starttime + 86399;
				$condition .= " AND createtime > '{$starttime}' AND createtime < '{$endtime}'";
			}else{
				$date = explode ( '-', $time );
				$starttime = mktime(0,0,0,$date[1],$date[2],$date[0]);
				$endtime = $starttime + 86399;
				$condition .= " AND createtime > '{$starttime}' AND createtime < '{$endtime}'";
			}
			$todayfrist = pdo_fetchall("SELECT id,macid,lon,lat,createtime FROM " . tablename($this->table_checklog) . " where weid = '{$weid}' AND schoolid = '{$schoolid}' AND sid = {$it['sid']} And lon !='' $condition ORDER by createtime ASC LIMIT 0,1");
			$fristpoint = $todayfrist[0]['lon'].','.$todayfrist[0]['lat'];
			//print_r($todayfrist);
			include $this->template(''.$school['style2'].'/schoolbus');
        }else{
			session_destroy();
		    $stopurl = $_W['siteroot'] .'app/'.$this->createMobileUrl('bangding', array('schoolid' => $schoolid));
			header("location:$stopurl");
			exit;
        }        
?>