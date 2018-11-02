<?php
/**
 * By 高贵血迹
 */

	global $_GPC, $_W;
	
	$operation = in_array ( $_GPC ['op'], array ('default', 'login', 'classinfo', 'check', 'gps', 'banner', 'video','checknew', 'checkold','all','banpai','allcard','getleave') ) ? $_GPC ['op'] : 'default';
	$weid = $_GPC['i'];
	$schoolid = $_GPC['schoolid'];
	$macid = empty($_GPC['macid']) ? $_GPC['terminalId']:$_GPC['macid'];
	$ckmac = pdo_fetch("SELECT * FROM " . tablename($this->table_checkmac) . " WHERE macid = '{$macid}' And schoolid = '{$schoolid}' ");
	$school = pdo_fetch("SELECT * FROM " . tablename($this->table_index) . " WHERE id = '{$schoolid}' ");
	if ($operation == 'default') {
		echo("对不起，你的请求不存在！");
		exit;
    }
	if(empty($school)){
		echo("找不到本校");
		exit;		
	}
	if(empty($ckmac)){
		echo("没找到设备");
		exit;		
	}	
	if($school['is_recordmac'] == 2){
		echo("本校无权使用设备");
		exit;		
	}	
	if ($ckmac['is_on'] ==2){
		echo("本设备已关闭");
		exit;
	}
	if (!empty($_W['setting']['remote']['type'])) { 
		$urls = $_W['attachurl']; 
	} else {
		$urls = $_W['siteroot'].'attachment/';
	}
	if ($operation == 'all') {
		if(!empty($ckmac)){
			$classes = pdo_fetchall("SELECT sid as classId,type, sname as className  FROM " . tablename($this->table_classify) . " WHERE weid = '{$weid}' And (type = 'theclass' OR type = 'jsfz') And schoolid = {$school['id']} ORDER BY sid DESC");
			$result = array(
				'code'=>1000,
				'msg'=>'success',
				'ServerTime'=>date('Y-m-d H:i:s',time()),
				'data'=>array()
			);
			$students = array('groupname'=>'r0','sjd'=>'00002359','users'=>array());
			$teachers = array('groupname'=>'teacher','sjd'=>'00002359','users'=>array());

			foreach ($classes as $cls) {
				$sql = "SELECT id as childId, bj_id as classId, s_name as name FROM " . tablename($this->table_students) . " WHERE weid = '{$weid}' And schoolid = {$school['id']} And bj_id = '{$cls['classId']}' ORDER BY id DESC";

				$colid = 'sid';
				if($cls['type'] == 'jsfz'){//教师
					$sql = "SELECT id as childId, fz_id as classId, tname as name FROM " . tablename($this->table_teachers) . " WHERE weid = '{$weid}' And schoolid = {$school['id']} And fz_id = '{$cls['classId']}' ORDER BY id DESC";
					$colid = 'tid';
				}
				$class = pdo_fetchall($sql);
				foreach($class as $key =>$row) {
					//$class[$key]['signId'] = "";
					$card = pdo_fetchall("SELECT idcard  FROM " . tablename($this->table_idcard) . " WHERE {$colid} = '{$row['childId']}' ORDER BY id DESC");
					$num = count($card);
					if ($num > 1){
						foreach($card as $k =>$r){
							if(!empty($r['idcard'])){
								$class[$key]['rfid'] .= "#" . $r['idcard'];
							}
						}
					}else{
						$class[$key]['rfid'] = $card['0']['idcard'];
					}
				}
				if($cls['type'] == 'jsfz'){
					$teachers['users'] = array_merge($teachers['users'],$class);
				}else{
					$students['users'] = array_merge($students['users'],$class);
				}
			}
			$result['data'][] = $students;
			$result['data'][] = $teachers;
		}
		exit(\json_encode($result));
	}
	if ($operation == 'allcard') {

		if(!empty($ckmac)){
			$result = array(
				'code'=>1000,
				'msg'=>'success',
				'data'=>array(),
				'ServerTime'=>date('Y-m-d H:i:s',time())
			);

			$sql = "SELECT a1.`sname` AS groupname ,a2.`s_name` AS real_name,a2.`icon` AS headIcon,a2.`area`AS tags ,a3.`idcard` AS idcard FROM `ims_wx_school_classify`  AS a1 LEFT JOIN `ims_wx_school_students` AS a2 ON a1.`sid`=a2.`bj_id` LEFT JOIN `ims_wx_school_idcard` AS a3 ON a2.`id`=a3.`sid` WHERE a1.`schoolid`={$school['id']}  AND a1.`type`='theclass' order by a1.`sname` desc";
			$students = pdo_fetchall($sql);

			foreach ($students as $student) {
				if ($student['idcard']) {
					$result['data'][$student['idcard']] =  array(
						'groupname'	=> $student['groupname'],
						'real_name'	=> $student['real_name'],
						'headIcon'	=> $urls.$student['headIcon'],
						//'tags'		=> ($student['board']?'住校':'走读').($tags?',':'').$tags
						//'tags'		=> $student['tags']
						'tags'		=> '走读'
					);
				}
			}
			
			$sql = "SELECT 
				a1.`sname` AS groupname ,
				a2.`tname` AS real_name,
				a2.`thumb` AS headIcon,
				a2.`star`AS tags ,
				a3.`idcard` AS idcard 
				FROM `ims_wx_school_classify` AS a1 LEFT JOIN `ims_wx_school_teachers` AS a2 ON a1.`schoolid`={$school['id']}  AND a1.`type`='jsfz' LEFT JOIN `ims_wx_school_idcard` AS a3  ON a2.`id`=a3.`tid` ";
			$teachers = pdo_fetchall($sql);

			foreach ($teachers as $teacher) {
				if ($teacher['idcard']) {
					$result['data'][$teacher['idcard']] =  array(
						'groupname'	=> $teacher['groupname'],
						'real_name'	=> $teacher['real_name'],
						'headIcon'	=> $urls.$teacher['headIcon'],
						//'tags'		=> ($student['board']?'住校':'走读').($tags?',':'').$tags
						//'tags'		=> $teacher['tags']
						'tags'		=> '教职工'
					);
				}
			}

		}
		exit(\json_encode($result));
	}	
	if ($operation == 'login') {
		if(!empty($ckmac)){
			$class = pdo_fetchall("SELECT sid as classId, sname as className  FROM " . tablename($this->table_classify) . " WHERE weid = '{$weid}' And (type = 'theclass' OR type = 'jsfz') And schoolid = {$school['id']} ORDER BY sid DESC");
			foreach($class as $key =>$row) {
				$checkclass = pdo_fetch("SELECT type,pname  FROM " . tablename($this->table_classify) . " WHERE sid = '{$row['classId']}'");
				if ($checkclass['type'] == 'theclass'){
					$class[$key]['className'] = $row['className'];
					$class[$key]['channel'] = $row['classId'];
					$class[$key]['channeldesc'] = $row['className'];
				}else{
					$class[$key]['className'] = $checkclass['pname'];
					$class[$key]['channel'] = $row['classId'];
					$class[$key]['channeldesc'] = $checkclass['pname'];					
				}				
			}
			$result['data']['classInfo'] = $class;
			$result['data']['posturl']   = urlencode($_W['siteroot'] . 'app/index.php?i=' . $weid . '&c=entry&schoolid=' . $schoolid . '&do=checkxz&op=checknew&m=fm_jiaoyu');
			$result['data']['oldposturl']   = urlencode($_W['siteroot'] . 'app/index.php?i=' . $weid . '&c=entry&schoolid=' . $schoolid . '&do=checkxz&op=checkold&m=fm_jiaoyu');
			$result['data']['leaveurl']   = urlencode( $_W['siteroot'] . 'app/index.php?i=' . $weid . '&c=entry&schoolid=' . $schoolid . '&do=checkwn&op=getleave&m=fm_jiaoyu');
			$result['data']['outTimeUrl']   = urlencode($_W['siteroot'] . 'app/index.php?i=' . $weid . '&c=entry&schoolid=' . $schoolid . '&do=checkwn&op=classinfo&m=fm_jiaoyu');
			$result['data']['schoolInfo']= array(
					'name' => $school['title'],
					'schoolId' => $school['id'],
					'logo' => $urls.$school['logo'],
					'tel' => $school['tel']
			);
			$result['data']['userInfo'] = array(
					'email' => "admin@sina.com",
					'name' => '',
					'sex' => '',
					'teacherId' => '',
					'tel' => ''
			);
			if($ckmac['twmac'] == -1){
				$result['data']['tempid'] = 1;
			}else{
				$result['data']['tempid'] = $ckmac['twmac'];
			}
			if($ckmac['cardtype'] == 1){
				$result['data']['cardtype'] = 1;
			}
			if($ckmac['cardtype'] == 2){
				$result['data']['cardtype'] = 2;
			}
			$result['data']['finger'] = 2;
			if($macid == '8c:18:d9:cd:e5:0d'){
				$result['data']['TerminalInfo'] = array(
						'fenqq' => 'ttyS2',
						'zhiw' => "ttyS3",
						'card' => "ttyS1",
						'shext' => '',
						'by1' => '',
						'by2' => '',
						'by3' => ''
				);
			}else{
				$result['data']['TerminalInfo'] = array(
						'fenqq' => 'ttyS4',
						'zhiw' => "ttyS3",
						'card' => "ttyS2",
						'shext' => '',
						'by1' => '',
						'by2' => '',
						'by3' => ''
				);				
			}


			//返回ipc信息
			$ipc = unserialize($ckmac['ipc']);
			if(!$ipc)$ipc = array();

			$result['data']['ipc'] = $ipc;

			$result['code'] = 1000;
			$result['msg'] = "success";
			$result['ServerTime'] = date('Y-m-d H:i:s',time());

			echo json_encode($result);
		}
    }
	if ($operation == 'banpai') {
		$nowtime = time();
		$date = date('Y-m-d',$nowtime);
		$riqi = explode ('-', $date);
		$starttime = mktime(0,0,0,$riqi[1],$riqi[2],$riqi[0]);
		$endtime = $starttime + 86399;
		$condition = " AND createtime > '{$starttime}' AND createtime < '{$endtime}'";		
		$classid = $ckmac['bj_id'];
		$theclass = pdo_fetch("SELECT * FROM " . tablename($this->table_classify) . " WHERE weid = '{$weid}' And schoolid = '{$school['id']}' And sid = '{$classid}'");	
		/*基本信息*/
		$banner = unserialize($ckmac['banner']);
		$result['sch_name'] = $school['title'];
		$result['sch_logo'] = tomedia($school['logo']);
		$result['areaid'] = $ckmac['areaid'];
		$result['cityname'] = $ckmac['cityname'];
		$result['mac_id'] = $macid;
		$result['model_type'] = $ckmac['model_type'];		
		/*班级*/
		$result['class_img'] = empty($banner['class_img'])?tomedia($school['thumb']):tomedia($banner['class_img']);
		$result['class_name'] = $theclass['sname'];
		$result['class_course'] = getkcbiao($school['id'],$nowtime,$classid);
		$classroom = pdo_fetch("SELECT sname FROM " . tablename($this->table_classify) . " WHERE weid = '{$weid}' And schoolid = '{$school['id']}' And sid = '{$theclass['js_id']}'");
		$result['class_room_name'] = empty($classroom) ? $theclass['sname'] : $classroom['sname'];//未绑定教室使用班级名称
		$grade = pdo_fetch("SELECT sname FROM " . tablename($this->table_classify) . " WHERE weid = '{$weid}' And schoolid = '{$school['id']}' And sid = '{$theclass['parentid']}'");	
		$result['grade_name'] = $grade['sname'];
		$master = pdo_fetch("SELECT tname,mobile,thumb FROM " . tablename($this->table_teachers) . " WHERE weid = '{$weid}' And schoolid = '{$school['id']}' And id = '{$theclass['tid']}'");	
		$result['master_img'] = !empty($master['thumb'])?tomedia($school['tpic']):tomedia($master['thumb']);
		$result['master_name'] = $master['tname'];
		$result['master_phone'] = $master['mobile'];
		$stu_num =  pdo_fetchcolumn("select COUNT(*) FROM ".tablename($this->table_students)." WHERE weid = '{$weid}' AND schoolid = '{$schoolid}' AND bj_id = '{$classid}'");
		$result['stu_num'] = $stu_num;
		$stu_leave_num =  pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename($this->table_leave) . " where schoolid = '{$schoolid}' And weid = '{$weid}' And tid = 0 And bj_id = '{$classid}' And isliuyan = 0 And status = 1 And endtime1 > '{$endtime}' ");
		$result['stu_leave_num'] = $stu_leave_num;
		$checkmub = pdo_fetchcolumn("SELECT  COUNT(distinct sid) FROM " . tablename($this->table_checklog) . " WHERE weid = '{$weid}' AND schoolid = '{$schoolid}'  And bj_id = '{$classid}' And isconfirm = 1 $condition ");
		$result['stu_absent_num'] = $stu_num - $checkmub;
		$result['class_honor'] = array();
		$class_honor = array('http://kstms.com/img/rongyu.png','http://kstms.com/img/rongyu.png');
		$result['class_honor'] = $class_honor;
		$student_honor = array();
		if($theclass['is_bjzx'] == 1 && !empty($theclass['star'])){
			$star = unserialize($theclass['star']);
			$student_honor[0] = array(
				'stu_id' => 1,
				'stu_name' => $star['name1'],
				'stu_img' => !empty($star['icon1'])?tomedia($star['icon1']):tomedia($school['spic']),
				'stu_label' => "班级之星"
			);
			$student_honor[1] = array(
				'stu_id' => 2,
				'stu_name' => $star['name2'],
				'stu_img' => !empty($star['icon2'])?tomedia($star['icon2']):tomedia($school['spic']),
				'stu_label' => "班级之星"
			); 
			$student_honor[2] = array(
				'stu_id' => 3,
				'stu_name' => $star['name3'],
				'stu_img' => !empty($star['icon3'])?tomedia($star['icon3']):tomedia($school['spic']),
				'stu_label' => "班级之星"
			);
			$student_honor[3] = array(
				'stu_id' => 4,
				'stu_name' => $star['name4'],
				'stu_img' => !empty($star['icon4'])?tomedia($star['icon4']):tomedia($school['spic']),
				'stu_label' => "班级之星"
			);
		}else{
			$student_honor = ''; //班级之星
		}
		$result['student_honor'] = $student_honor;
		$notice = pdo_fetch("SELECT * FROM " . tablename($this->table_notice) . " WHERE weid = '{$weid}' And schoolid = '{$school['id']}' And (type = 1 Or type = 2) ORDER BY createtime DESC ");
		$noticeteacher = pdo_fetch("SELECT tname FROM " . tablename($this->table_teachers) . " WHERE weid = '{$weid}' And schoolid = '{$school['id']}' And id = '{$notice['tid']}'");	
		$result['notice_dpt'] = $noticeteacher['tname'];
		$result['notice_name'] = $notice['title'];
		$result['notice_time'] = date('Y-m-d H:i',$notice['createtime']);
		$result['notice_txt'] = $notice['content'];
		/*公播*/
		$result['video_url'] = $banner['video_url'];
		/*考试*/
		$exam_name = pdo_fetch("SELECT sname FROM " . tablename($this->table_classify) . " WHERE weid = '{$weid}' And schoolid = '{$school['id']}' And sid = '{$ckmac['qh_id']}'");
		$result['exam_name'] = $exam_name['sname'];
		$result['exam_room_name'] = $ckmac['exam_room_name'];
		$result['exam_plan'] = array();
		if($ckmac['exam_plan']){
			$result['exam_plan'] = unserialize($ckmac['exam_plan']);//压缩数组
		}
		/*备用字段*/
		$result['spare_1'] = '';
		$result['spare_2'] = '';
		$result['spare_3'] = '';
		$result['spare_4'] = '';
		/*处理同步状态*/
		$temp = array(
			'isflow' => 2,
			'class_img' => $banner['class_img'],
			'video_url' => $banner['video_url'],
		);
		$temp1['banner'] = serialize($temp);
		pdo_update($this->table_checkmac, $temp1, array('id' => $ckmac['id']));	
		$result['cardtype'] = $ckmac['cardtype'];
		$result['code'] = 1000;
		$result['msg'] = "success";
		$result['ServerTime'] = date('Y-m-d H:i:s',time());
		echo json_encode($result);		
    }
	
	if ($operation == 'classinfo') {
		$classid = $_GPC['classId'];
		$isfz = pdo_fetch("SELECT type,datesetid  FROM " . tablename($this->table_classify) . " WHERE weid = '{$weid}' And schoolid = '{$school['id']}' And sid = '{$classid}'");	
		if ($isfz['type'] == 'theclass'){
			$nowdate = date("Y-n-j",time());
			$nowyear = date("Y",time());
			$nowweek = date("w",time()); 
			$todaytype = 0;
			$todaytimeset = array(
				array(
					'start'=>'00:00',
					'end'  =>'23:59'
				),
			); 
			if(!empty($isfz['datesetid'])){
				$checkdateset      =  pdo_fetch("SELECT * FROM " . tablename($this->table_checkdateset) . " WHERE weid = '{$weid}' And schoolid = {$school['id']} and  id = '{$isfz['datesetid']}'");
				$checkdateset_holi =  pdo_fetch("SELECT * FROM " . tablename($this->table_checkdatedetail) . " WHERE weid = '{$weid}' And schoolid = {$school['id']} and  checkdatesetid = '{$isfz['datesetid']}' and year = '{$nowyear}' ");
				
				$checktime         =  pdo_fetchall("SELECT * FROM " . tablename($this->table_checktimeset) . " WHERE weid = '{$weid}' And schoolid = {$school['id']} and  checkdatesetid = '{$isfz['datesetid']}' and date = '{$nowdate}' ORDER BY id ASC ");
				if(!empty($checktime)){
					if($checktime[0]['type'] == 6){
						//1放假2上课
						$todaytype = 1;
					}elseif($checktime[0]['type'] == 5){
						$todaytype    = 2;
						$todaytimeset = $checktime; 
					}
				}else{
					if(($nowdate >= $checkdateset_holi['win_start'] && $nowdate <=$checkdateset_holi['win_end']) || ($nowdate >= $checkdateset_holi['sum_start'] && $nowdate <=$checkdateset_holi['sum_end'])){
						$todaytype = 1;
					}else{
						$timeset_work = pdo_fetchall("SELECT start,end FROM " . tablename($this->table_checktimeset) . " WHERE weid = '{$weid}' And schoolid = {$school['id']} and  checkdatesetid = '{$isfz['datesetid']}' and type=1 ORDER BY id ASC ");
						//星期五
						if($nowweek == 5){
							$todaytype = 2;
							if($checkdateset['friday'] == 1){
								$timeset_fri = pdo_fetchall("SELECT start,end FROM " . tablename($this->table_checktimeset) . " WHERE weid = '{$weid}' And schoolid = {$school['id']} and  checkdatesetid = '{$isfz['datesetid']}' and type=2 ORDER BY id ASC ");
								$todaytimeset = $timeset_fri;
							}else{
								$todaytimeset = $timeset_work;
							}
						//星期六
						}elseif($nowweek == 6){
							if($checkdateset['saturday'] == 1){
								$timeset_sat = pdo_fetchall("SELECT start,end FROM " . tablename($this->table_checktimeset) . " WHERE weid = '{$weid}' And schoolid = {$school['id']} and  checkdatesetid = '{$isfz['datesetid']}' and type=3 ORDER BY id ASC ");
								$todaytype = 2;
								$todaytimeset = $timeset_sat;
							}else{
								$todaytype = 1;
							}
						
						//星期天
						}elseif($nowweek == 0){
							if($checkdateset['sunday'] == 1){
								$timeset_sun = pdo_fetchall("SELECT start,end FROM " . tablename($this->table_checktimeset) . " WHERE weid = '{$weid}' And schoolid = {$school['id']} and  checkdatesetid = '{$isfz['datesetid']}' and type=4 ORDER BY id ASC ");
								$todaytype    = 2;
								$todaytimeset = $timeset_sun;
							}else{
								$todaytype    = 1;
							}
						//工作日	
						}else{
							$todaytype    = 2;
							$todaytimeset = $timeset_work;
						}
					}
				}
				
			}
			$result['data']['todaytype'] = $todaytype;
			$result['data']['todaytimeset'] = $todaytimeset;
			if(!empty($ckmac)){
				$class = pdo_fetchall("SELECT id as childId, bj_id as classId, icon as headIcon, s_name as name,s_type FROM " . tablename($this->table_students) . " WHERE weid = '{$weid}' And schoolid = {$school['id']} And bj_id = '{$classid}' ORDER BY id DESC");
				foreach($class as $key =>$row) {
					if(!empty($row['headIcon'])){
						$class[$key]['headIcon'] = $urls.$row['headIcon'];
					}else{
						$class[$key]['headIcon'] = !empty($school['spic'])? $urls.$school['spic'] : "";
					}
					$class[$key]['name'] = $row['name'];
					$class[$key]['signId'] = "";
					$card = pdo_fetchall("SELECT idcard  FROM " . tablename($this->table_idcard) . " WHERE sid = '{$row['childId']}' ORDER BY id DESC");
					$num = count($card);
					if ($num > 1){
						foreach($card as $k =>$r){
							if(!empty($r['idcard'])){
								$class[$key]['signId'] .= "#" . $r['idcard'];
							}
						}
					}else{
						$class[$key]['signId'] = $card['0']['idcard'];
					}
					$class[$key]['fingerid1'] = "-1";
					$class[$key]['fingerid2'] = "-1";
					$class[$key]['fingerid3'] = "-1";
					$class[$key]['fingerid4'] = "-1";
					$class[$key]['fingerid5'] = "-1";
				}
				$result['data']['childs'] = $class;
				$result['code'] = 1000;
				$result['msg'] = "success";
				$result['ServerTime'] = date('Y-m-d H:i:s',time());
				echo json_encode($result);
			}
		}else{
			if(!empty($ckmac)){
				$class = pdo_fetchall("SELECT id as TID, fz_id as classId, thumb as headIcon, tname as name FROM " . tablename($this->table_teachers) . " WHERE weid = '{$weid}' And schoolid = {$school['id']} And fz_id = '{$classid}' ORDER BY id DESC");
				foreach($class as $key =>$row) {
					if(!empty($row['headIcon'])){
						$class[$key]['headIcon'] = $urls.$row['headIcon'];
					}else{
						$class[$key]['headIcon'] = !empty($school['tpic'])? $urls.$school['tpic'] : "";
					}
					$class[$key]['childId'] = "909".$row['TID'];
					$class[$key]['name'] = $row['name'];
					$class[$key]['signId'] = "";
					$card = pdo_fetchall("SELECT idcard  FROM " . tablename($this->table_idcard) . " WHERE tid = '{$row['TID']}' ORDER BY id DESC");
					$num = count($card);
					if ($num > 1){
						foreach($card as $k =>$r){
							if(!empty($r['idcard'])){
								$class[$key]['signId'] .= "#" . $r['idcard'];
							}
						}
					}else{
						$class[$key]['signId'] = $card['0']['idcard'];
					}
				}
				$result['data']['childs'] = $class;
				$result['code'] = 1000;
				$result['msg'] = "success";
				$result['ServerTime'] = date('Y-m-d H:i:s',time());
				echo json_encode($result);
			}			
		}
    }
	
	if ($operation == 'check') {
		$fstype = false;
		$ckuser = pdo_fetch("SELECT * FROM " . tablename($this->table_idcard) . " WHERE idcard = :idcard And schoolid = :schoolid ", array(':idcard' =>$_GPC['signId'],':schoolid' =>$schoolid));
		if($_GPC['mactype'] == 'other'){
			$signTime = strtotime($_GPC['signTime']);
		}else{
			$signTime = trim($_GPC['signTime']);
		}
		$checkthisdata = pdo_fetch("SELECT * FROM " . tablename($this->table_checklog) . " WHERE cardid = :cardid And schoolid = :schoolid And createtime = :createtime ", array(':cardid' =>$_GPC['signId'],':schoolid' =>$schoolid,':createtime' =>$signTime));
		if(empty($checkthisdata)){
			if(!empty($ckuser) || $_GPC['signId'] == '9999999999'){
				$times = TIMESTAMP;		
				$nowtime = date('H:i',$signTime);
				if($_GPC['picurl']) {
					load()->func('file');
					$urls = "http://www.daren007.com/attachment/";
					$path = "images/fm_jiaoyu/check/". date('Y/m/d/');	
					if (!is_dir(IA_ROOT."/attachment/". $path)) {
						mkdirs(IA_ROOT."/attachment/". $path, "0777");
					}
					$rand = random(30);
					if(!empty($_GPC['picurl'])) {
						$picurl = $path.$rand."_1.jpg";
						if($_GPC['mactype'] == 'other'){
							$pic_url = base64_decode(str_replace(" ","+",$_GPC['picurl']));
						}else{
							$pic_url = file_get_contents($urls.$_GPC['picurl']);
						}
					    file_write($picurl,$pic_url);
						if (!empty($_W['setting']['remote']['type'])){ 
							$remotestatus = file_remote_upload($picurl);
						}
						$pic = $picurl;
					}
					if(!empty($_GPC['picurl2'])) {
						$picurl2 = $path.$rand."_2.jpg";
						if($_GPC['mactype'] == 'other'){
							$pic_url2 = base64_decode(str_replace(" ","+",$_GPC['picurl2']));
						}else{
							$pic_url2 = file_get_contents($urls.$_GPC['picurl2']);
						}
					    file_write($picurl2,$pic_url2);					
						if (!empty($_W['setting']['remote']['type'])){ 
							$remotestatus = file_remote_upload($picurl2);
						}
						$pic2 = $picurl2;						
					}	
				}
				$signMode = $_GPC['signMode'];	
				if($ckmac['type'] !=0){
					include 'checktime2.php';	
				}else{
					include 'checktime.php';	
				}
				if($_GPC['signId'] == '9999999999'){
					$data = array(
					'weid' => $weid,
					'schoolid' => $schoolid,
					'macid' => $ckmac['id'],
					'lon' => $_GPC['lon'],
					'lat' => $_GPC['lat'],					
					'cardid' => $_GPC ['signId'],
					'type' => "无卡进出",
					'pic' => $pic,
					'pic2' => $pic2,
					'leixing' => $leixing,
					'createtime' => $signTime
					);
					pdo_insert($this->table_checklog, $data);
					$fstype = true;	
				}
				if(!empty($ckuser['sid'])){
					$bj = pdo_fetch("SELECT bj_id FROM " . tablename($this->table_students) . " WHERE id = :id ", array(':id' =>$ckuser['sid']));
					if($school['is_cardpay'] == 1){					
						if($ckuser['severend'] > $times){
							$data = array(
							'weid' => $weid,
							'schoolid' => $schoolid,
							'macid' => $ckmac['id'],
							'cardid' => $_GPC ['signId'],
							'sid' => $ckuser['sid'],
							'bj_id' => $bj['bj_id'],
							'type' => $type,
							'pic' => $pic,
							'pic2' => $pic2,
							'lon' => $_GPC['lon'],
							'lat' => $_GPC['lat'],							
							'temperature' => $_GPC ['signTemp'],
							'leixing' => $leixing,
							'pard' => $ckuser['pard'],
							'createtime' => $signTime
							);
							pdo_insert($this->table_checklog, $data);
							$checkid = pdo_insertid();							
							if($school['send_overtime'] >= 1){
								$overtime = $school['send_overtime']*60;
								$timecha = $times - $signTime;
								if($overtime >= $timecha){									
									$this->sendMobileJxlxtz($schoolid, $weid, $bj['bj_id'], $ckuser['sid'], $type, $leixing, $checkid, $ckuser['pard']);
								}else{
									$result['info'] = "延迟发送之数据将不推送刷卡提示";
								}
							}else{
								$this->sendMobileJxlxtz($schoolid, $weid, $bj['bj_id'], $ckuser['sid'], $type, $leixing, $checkid, $ckuser['pard']);
							}
						}else{
							$result['info'] = "本卡已失效,请联系学校管理员";
						}
						$fstype = true;	
					}else{
						$data = array(
						'weid' => $weid,
						'schoolid' => $schoolid,
						'macid' => $ckmac['id'],
						'cardid' => $_GPC ['signId'],
						'sid' => $ckuser['sid'],
						'bj_id' => $bj['bj_id'],
						'type' => $type,
						'pic' => $pic,
						'pic2' => $pic2,
						'lon' => $_GPC['lon'],
						'lat' => $_GPC['lat'],
						'temperature' => $_GPC ['signTemp'],
						'leixing' => $leixing,
						'pard' => $ckuser['pard'],
						'createtime' => $signTime
						);
						pdo_insert($this->table_checklog, $data);
						$checkid = pdo_insertid();
						if($school['send_overtime'] >= 1){
							$overtime = $school['send_overtime']*60;
							$timecha = $times - $signTime;
							if($overtime >= $timecha){									
								$this->sendMobileJxlxtz($schoolid, $weid, $bj['bj_id'], $ckuser['sid'], $type, $leixing, $checkid, $ckuser['pard']);
							}else{
								$result['info'] = "延迟发送之数据将不推送刷卡提示";
							}
						}else{
							$this->sendMobileJxlxtz($schoolid, $weid, $bj['bj_id'], $ckuser['sid'], $type, $leixing, $checkid, $ckuser['pard']);
						}
						$fstype = true;
					}
				}
				if(!empty($ckuser['tid'])){
					$data = array(
					'weid' => $weid,
					'schoolid' => $schoolid,
					'macid' => $ckmac['id'],
					'cardid' => $_GPC ['signId'],
					'tid' => $ckuser['tid'],
					'type' => $type,
					'leixing' => $leixing,
					'pic' => $pic,
					'pic2' => $pic2,
					'pard' => 1,
					'createtime' => $signTime
					);
					pdo_insert($this->table_checklog, $data);
					$fstype = true;		
				}	
			}else{
				$result['info'] = "本卡未绑定任何学生或老师";
			}
		}else{
			$fstype = true;
			$result['info'] = "不可重复相同刷卡数据";
		}
		if ($fstype ==true){
			$result['data'] = "";
			$result['code'] = 1000;
			$result['msg'] = "success";
			$result['ServerTime'] = date('Y-m-d H:i:s',time());
			echo json_encode($result);
			exit;
        }else{
			$result['data'] = "";
			$result['code'] = 300;
			$result['msg'] = "lose";
			$result['ServerTime'] = date('Y-m-d H:i:s',time());
			echo json_encode($result);
			exit;
		}		
	}
	
	if ($operation == 'checkold') {
		$signData = str_replace('&quot;','"',$_GPC['signData']);
		$datasss = json_decode($signData,true);
		if(!empty($datasss)){
			$up_file = $_FILES;
			foreach($datasss as $k => $v){			
				$fstype = false;
				$ckuser = pdo_fetch("SELECT * FROM " . tablename($this->table_idcard) . " WHERE idcard = :idcard And schoolid = :schoolid ", array(':idcard' =>$v['signId'],':schoolid' =>$schoolid));
				$signTime = strtotime($v['signTime']);
				$checkthisdata = pdo_fetch("SELECT * FROM " . tablename($this->table_checklog) . " WHERE cardid = :cardid And schoolid = :schoolid And createtime = :createtime ", array(':cardid' =>$v['signId'],':schoolid' =>$schoolid,':createtime' =>$signTime));
				if(empty($checkthisdata)){
					if(!empty($ckuser) || $v['signId'] == '9999999999'){
						$times = TIMESTAMP;		
						$nowtime = date('H:i',$signTime);
						load()->func('file');
						$files_image = current($up_file);//第一张图
						$files_image2 = next($up_file);//第二张图
						$path = "images/fm_jiaoyu/check/". date('Y/m/d/');
						if(!empty($files_image)) {
							if (!is_dir(IA_ROOT."/attachment/". $path)) {
								mkdirs(IA_ROOT."/attachment/". $path, "0777");
							}
							$picurl = $path.random(30) .".jpg";
							move_uploaded_file($_FILES["file1"]["tmp_name"], ATTACHMENT_ROOT."/$picurl");
							if (!empty($_W['setting']['remote']['type'])){ 
								$remotestatus = file_remote_upload($picurl);
							}
							$pic = $picurl;
						}			
						if(!empty($files_image2)) {
							$picurl2 = $path.random(31) .".jpg";
							move_uploaded_file($_FILES["file2"]["tmp_name"], ATTACHMENT_ROOT."/$picurl2");
							if (!empty($_W['setting']['remote']['type'])){ 
								$remotestatus = file_remote_upload($picurl2);
							}
							$pic2 = $picurl2;
						}
						$signMode = $v['signMode'];	
						if($ckmac['type'] !=0){
							include 'checktime2.php';	
						}else{
							include 'checktime.php';	
						}
						if($v['signId'] == '9999999999'){
							$data = array(
							'weid' => $weid,
							'schoolid' => $schoolid,
							'macid' => $ckmac['id'],
							'lon' => $v['lon'],
							'lat' => $v['lat'],					
							'cardid' => $v ['signId'],
							'type' => "无卡进出",
							'pic' => $pic,
							'pic2' => $pic2,
							'leixing' => $leixing,
							'createtime' => $signTime
							);
							pdo_insert($this->table_checklog, $data);
							$fstype = true;	
						}
						if(!empty($ckuser['sid'])){
							$bj = pdo_fetch("SELECT bj_id FROM " . tablename($this->table_students) . " WHERE id = :id ", array(':id' =>$ckuser['sid']));
							if($school['is_cardpay'] == 1){					
								if($ckuser['severend'] > $times){
									$data = array(
									'weid' => $weid,
									'schoolid' => $schoolid,
									'macid' => $ckmac['id'],
									'cardid' => $v ['signId'],
									'sid' => $ckuser['sid'],
									'bj_id' => $bj['bj_id'],
									'type' => $type,
									'pic' => $pic,
									'pic2' => $pic2,
									'lon' => $v['lon'],
									'lat' => $v['lat'],							
									'temperature' => $v ['signTemp'],
									'leixing' => $leixing,
									'pard' => $ckuser['pard'],
									'createtime' => $signTime
									);
									pdo_insert($this->table_checklog, $data);
									$checkid = pdo_insertid();							
									if($school['send_overtime'] >= 1){
										$overtime = $school['send_overtime']*60;
										$timecha = $times - $signTime;
										if($overtime >= $timecha){									
											$this->sendMobileJxlxtz($schoolid, $weid, $bj['bj_id'], $ckuser['sid'], $type, $leixing, $checkid, $ckuser['pard']);
										}else{
											$result['info'] = "延迟发送之数据将不推送刷卡提示";
										}
									}else{
										$this->sendMobileJxlxtz($schoolid, $weid, $bj['bj_id'], $ckuser['sid'], $type, $leixing, $checkid, $ckuser['pard']);
									}
								}else{
									$result['info'] = "本卡已失效,请联系学校管理员";
								}
								$fstype = true;	
							}else{
								$data = array(
								'weid' => $weid,
								'schoolid' => $schoolid,
								'macid' => $ckmac['id'],
								'cardid' => $v ['signId'],
								'sid' => $ckuser['sid'],
								'bj_id' => $bj['bj_id'],
								'type' => $type,
								'pic' => $pic,
								'pic2' => $pic2,
								'lon' => $v['lon'],
								'lat' => $v['lat'],
								'temperature' => $v ['signTemp'],
								'leixing' => $leixing,
								'pard' => $ckuser['pard'],
								'createtime' => $signTime
								);
								pdo_insert($this->table_checklog, $data);
								$checkid = pdo_insertid();
								if($school['send_overtime'] >= 1){
									$overtime = $school['send_overtime']*60;
									$timecha = $times - $signTime;
									if($overtime >= $timecha){									
										$this->sendMobileJxlxtz($schoolid, $weid, $bj['bj_id'], $ckuser['sid'], $type, $leixing, $checkid, $ckuser['pard']);
									}else{
										$result['info'] = "延迟发送之数据将不推送刷卡提示";
									}
								}else{
									$this->sendMobileJxlxtz($schoolid, $weid, $bj['bj_id'], $ckuser['sid'], $type, $leixing, $checkid, $ckuser['pard']);
								}
								$fstype = true;
							}
						}
						if(!empty($ckuser['tid'])){
							$data = array(
							'weid' => $weid,
							'schoolid' => $schoolid,
							'macid' => $ckmac['id'],
							'cardid' => $v ['signId'],
							'tid' => $ckuser['tid'],
							'type' => $type,
							'leixing' => $leixing,
							'pic' => $pic,
							'pic2' => $pic2,
							'pard' => 1,
							'createtime' => $signTime
							);
							pdo_insert($this->table_checklog, $data);
							$fstype = true;		
						}	
					}else{
						$result['info'] = "本卡未绑定任何学生或老师";
					}
				}else{
					$fstype = true;
					$result['info'] = "不可重复相同刷卡数据";
				}
				if ($fstype ==true){
					$result['data'] = "";
					$result['code'] = 1000;
					$result['msg'] = "success";
					$result['ServerTime'] = date('Y-m-d H:i:s',time());
					echo json_encode($result);
					exit;
				}else{
					$result['data'] = "";
					$result['code'] = 300;
					$result['msg'] = "lose";
					$result['ServerTime'] = date('Y-m-d H:i:s',time());
					echo json_encode($result);
					exit;
				}
			}
		}		
	}
	
	if ($operation == 'checknew') { //专用无障碍通道
			$signData = str_replace('&quot;','"',$_GPC['signData']);
			$datasss = json_decode($signData,true);
			if(!empty($datasss)){
				foreach($datasss as $k => $v){		
					$fstype = false;
					$ckuser = pdo_fetch("SELECT * FROM " . tablename($this->table_idcard) . " WHERE idcard = :idcard And schoolid = :schoolid ", array(':idcard' =>$v['signId'],':schoolid' =>$schoolid));
					$signTime = strtotime($v['signTime']);
					$signMode = $v['signMode'];
					$checkthisdata = pdo_fetch("SELECT * FROM " . tablename($this->table_checklog) . " WHERE cardid = :cardid And schoolid = :schoolid And createtime = :createtime ", array(':cardid' =>$v['signId'],':schoolid' =>$schoolid,':createtime' =>$signTime));
					if(empty($checkthisdata)){
						if(!empty($ckuser) || $v['signId'] == '9999999999'){
							$times = TIMESTAMP;		
							$nowtime = date('H:i',$signTime);
							if($v['kq_img']) {
								$pic = $v['kq_img'];							
							}	
							if($v['kq_img_2']) {
								$pic2 = $v['kq_img_2'];
							}							
							if($ckmac['type'] !=0){
								include 'checktime2.php';	
							}else{
								include 'checktime.php';	
							}
							if($v['signId'] == '9999999999'){
								$data = array(
								'weid' => $weid,
								'schoolid' => $schoolid,
								'macid' => $ckmac['id'],
								'lon' => $v['lon'],
								'lat' => $v['lat'],					
								'cardid' => $v ['signId'],
								'type' => "无卡进出",
								'pic' => $pic,
								'pic2' => $pic2,
								'leixing' => $leixing,
								'createtime' => $signTime
								);
								pdo_insert($this->table_checklog, $data);
								$fstype = true;	
							}
							if(!empty($ckuser['sid'])){
								$bj = pdo_fetch("SELECT bj_id FROM " . tablename($this->table_students) . " WHERE id = :id ", array(':id' =>$ckuser['sid']));
								if($school['is_cardpay'] == 1){					
									if($ckuser['severend'] > $times){
										$data = array(
										'weid' => $weid,
										'schoolid' => $schoolid,
										'macid' => $ckmac['id'],
										'cardid' => $v ['signId'],
										'sid' => $ckuser['sid'],
										'bj_id' => $bj['bj_id'],
										'type' => $type,
										'pic' => $pic,
										'pic2' => $pic2,
										'lon' => $v['lon'],
										'lat' => $v['lat'],							
										'temperature' => $v ['signTemp'],
										'leixing' => $leixing,
										'pard' => $ckuser['pard'],
										'createtime' => $signTime
										);
										pdo_insert($this->table_checklog, $data);
										$checkid = pdo_insertid();							
										if($school['send_overtime'] >= 1){
											$overtime = $school['send_overtime']*60;
											$timecha = $times - $signTime;
											if($overtime >= $timecha){									
												$this->sendMobileJxlxtz($schoolid, $weid, $bj['bj_id'], $ckuser['sid'], $type, $leixing, $checkid, $ckuser['pard']);
											}else{
												$result['info'] = "延迟发送之数据将不推送刷卡提示";
											}
										}else{
											$this->sendMobileJxlxtz($schoolid, $weid, $bj['bj_id'], $ckuser['sid'], $type, $leixing, $checkid, $ckuser['pard']);
										}
									}else{
										$result['info'] = "本卡已失效,请联系学校管理员";
									}
									$fstype = true;	
								}else{
									$data = array(
									'weid' => $weid,
									'schoolid' => $schoolid,
									'macid' => $ckmac['id'],
									'cardid' => $v ['signId'],
									'sid' => $ckuser['sid'],
									'bj_id' => $bj['bj_id'],
									'type' => $type,
									'pic' => $pic,
									'pic2' => $pic2,
									'lon' => $v['lon'],
									'lat' => $v['lat'],
									'temperature' => $v ['signTemp'],
									'leixing' => $leixing,
									'pard' => $ckuser['pard'],
									'createtime' => $signTime
									);
									pdo_insert($this->table_checklog, $data);
									$checkid = pdo_insertid();
									if($school['send_overtime'] >= 1){
										$overtime = $school['send_overtime']*60;
										$timecha = $times - $signTime;
										if($overtime >= $timecha){									
											$this->sendMobileJxlxtz($schoolid, $weid, $bj['bj_id'], $ckuser['sid'], $type, $leixing, $checkid, $ckuser['pard']);
										}else{
											$result['info'] = "延迟发送之数据将不推送刷卡提示";
										}
									}else{
										$this->sendMobileJxlxtz($schoolid, $weid, $bj['bj_id'], $ckuser['sid'], $type, $leixing, $checkid, $ckuser['pard']);
									}
									$fstype = true;
								}
							}
							if(!empty($ckuser['tid'])){
								$data = array(
								'weid' => $weid,
								'schoolid' => $schoolid,
								'macid' => $ckmac['id'],
								'cardid' => $v ['signId'],
								'tid' => $ckuser['tid'],
								'type' => $type,
								'leixing' => $leixing,
								'pic' => $pic,
								'pic2' => $pic2,
								'pard' => 1,
								'createtime' => $signTime
								);
								pdo_insert($this->table_checklog, $data);
								$fstype = true;		
							}	
						}else{
							$result['info'] = "本卡未绑定任何学生或老师";
						}
					}else{
						$fstype = true;
						$result['info'] = "不可重复相同刷卡数据";
					}
					if ($fstype ==true){
						$result['data'] = "";
						$result['code'] = 1000;
						$result['msg'] = "success";
						$result['ServerTime'] = date('Y-m-d H:i:s',time());
						echo json_encode($result);
						exit;
					}else{
						$result['data'] = "";
						$result['code'] = 300;
						$result['msg'] = "lose";
						$result['ServerTime'] = date('Y-m-d H:i:s',time());
						echo json_encode($result);
						exit;
					}					
				}
			}else{
				$result['data'] = "";
				$result['code'] = 300;
				$result['msg'] = "未接收到刷卡信息";
				$result['ServerTime'] = date('Y-m-d H:i:s',time());
				echo json_encode($result);
				exit;
			}	
	}	

	if ($operation == 'gps') {
		$fstype = false;
		$ckuser = pdo_fetch("SELECT * FROM " . tablename($this->table_idcard) . " WHERE idcard = '{$_GPC['signId']}' And weid = '{$weid}' And schoolid = '{$schoolid}' ");
		$bj = pdo_fetch("SELECT bj_id FROM " . tablename($this->table_students) . " WHERE id = '{$ckuser['sid']}' ");
		$checkthisdata = pdo_fetch("SELECT * FROM " . tablename($this->table_checklog) . " WHERE cardid = '{$_GPC['signId']}' And createtime = '{$_GPC['signTime']}' And schoolid = '{$schoolid}' ");
		if(empty($checkthisdata)){		
			if(!empty($ckuser)){
				$times = TIMESTAMP;		
				$nowtime = date('H:i',$times);	
				if($ckmac['type'] !=0){
					include 'checktime2.php';	
				}else{
					include 'checktime.php';
				}
				$signTime = trim($_GPC['signTime']);
				if(!empty($ckuser['sid'])){
					if($school['is_cardpay'] == 1){					
						if($ckuser['severend'] > $times){
							$data = array(
							'weid' => $weid,
							'schoolid' => $schoolid,
							'macid' => $ckmac['id'],
							'cardid' => $_GPC ['signId'],
							'sid' => $ckuser['sid'],
							'bj_id' => $bj['bj_id'],
							'type' => $type,
							'temperature' => $_GPC ['signTemp'],
							'leixing' => $leixing,
							'pard' => $ckuser['pard'],
							'lon' => $_GPC['lon'],
							'lat' => $_GPC['lat'],
							'createtime' => $signTime
							);
							pdo_insert($this->table_checklog, $data);
							$checkid = pdo_insertid();
							if($school['send_overtime'] >= 1){
								$overtime = $school['send_overtime']*60;
								$timecha = $times - $signTime;
								if($overtime >= $timecha){									
									$this->sendMobileJxlxtz($schoolid, $weid, $bj['bj_id'], $ckuser['sid'], $type, $leixing, $checkid, $ckuser['pard']);
								}else{
									$result['info'] = "延迟发送之数据将不推送刷卡提示";
								}
							}else{
								$this->sendMobileJxlxtz($schoolid, $weid, $bj['bj_id'], $ckuser['sid'], $type, $leixing, $checkid, $ckuser['pard']);
							}
							$fstype = true;
						}					
					}else{
						$data = array(
						'weid' => $weid,
						'schoolid' => $schoolid,
						'macid' => $ckmac['id'],
						'cardid' => $_GPC ['signId'],
						'sid' => $ckuser['sid'],
						'bj_id' => $bj['bj_id'],
						'type' => $type,
						'temperature' => $_GPC ['signTemp'],
						'leixing' => $leixing,
						'lon' => $_GPC['lon'],
						'lat' => $_GPC['lat'],
						'pard' => $ckuser['pard'],
						'createtime' => $signTime
						);
						pdo_insert($this->table_checklog, $data);
						$checkid = pdo_insertid();
						if($school['send_overtime'] >= 1){
							$overtime = $school['send_overtime']*60;
							$timecha = $times - $signTime;
							if($overtime >= $timecha){									
								$this->sendMobileJxlxtz($schoolid, $weid, $bj['bj_id'], $ckuser['sid'], $type, $leixing, $checkid, $ckuser['pard']);
							}else{
								$result['info'] = "延迟发送之数据将不推送刷卡提示";
							}
						}else{
							$this->sendMobileJxlxtz($schoolid, $weid, $bj['bj_id'], $ckuser['sid'], $type, $leixing, $checkid, $ckuser['pard']);
						}
						$fstype = true;
					}
				}
				if(!empty($ckuser['tid'])){
					$data = array(
					'weid' => $weid,
					'schoolid' => $schoolid,
					'macid' => $ckmac['id'],
					'cardid' => $_GPC ['signId'],
					'tid' => $ckuser['tid'],
					'type' => $type,
					'leixing' => $leixing,
					'pard' => 1,
					'lon' => $_GPC['lon'],
					'lat' => $_GPC['lat'],
					'createtime' => $signTime
					);
					pdo_insert($this->table_checklog, $data);
					$fstype = true;		
				}	
			}	
		}	
		if ($fstype !=false){
			$result['data'] = "";
			$result['code'] = 1000;
			$result['msg'] = "success";
			$result['ServerTime'] = date('Y-m-d H:i:s',time());
			echo json_encode($result);
			exit;
			//print_r($signData);
        }else{
			$result['data'] = "";
			$result['code'] = 300;
			$result['msg'] = "lose";
			$result['ServerTime'] = date('Y-m-d H:i:s',time());
			echo json_encode($result);
			exit;
			//print_r($signData);
		}	
	}	

	if ($operation == 'banner') {
		$banner = unserialize($ckmac['banner']);
		$ims = $urls.$banner['pic1'].'#'.$urls.$banner['pic2'].'#'.$urls.$banner['pic3'].'#'.$urls.$banner['pic4'];
		$result['data'] = array(
			'img' => $ims,
			'mc' => $banner['pop']
		);
		$result['code'] = 1000;
		$result['msg'] = "success";
		$result['ServerTime'] = date('Y-m-d H:i:s',time());
			$temp = array(
				'isflow' => 2,
				'pop' => $banner['pop'],
				'video' => $banner['video'],
				'pic1' => $banner['pic1'],
				'pic1' => $banner['pic1'],
				'pic2' => $banner['pic2'],
				'pic3' => $banner['pic3'],
				'pic4' => $banner['pic4'],
				'VOICEPRE' => $banner['VOICEPRE'],
				);
			$temp1['banner'] = serialize($temp);
			pdo_update($this->table_checkmac, $temp1, array('id' => $ckmac['id']));			
		echo json_encode($result);	
		exit;
    }
	
	if ($operation == 'video') {
		$banner = unserialize($ckmac['banner']);	
		$result['data'] = array(
			'videoId' => 2,
			'videoUrl' => $banner['video']
		);
		$result['code'] = 1000;
		$result['msg'] = "success";
		$result['ServerTime'] = date('Y-m-d H:i:s',time());
			$temp = array(
				'isflow' => 2,
				'pop' => $banner['pop'],
				'video' => $banner['video'],
				'pic1' => $banner['pic1'],
				'pic1' => $banner['pic1'],
				'pic2' => $banner['pic2'],
				'pic3' => $banner['pic3'],
				'pic4' => $banner['pic4'],
				'VOICEPRE' => $banner['VOICEPRE'],
				);
			$temp1['banner'] = serialize($temp);
			pdo_update($this->table_checkmac, $temp1, array('id' => $ckmac['id']));			
		echo json_encode($result);
		exit;		
    }	
	
	if ($operation == 'getleave') {	
		$time = $_GPC['signtime'];
		$ckuser        = pdo_fetch("SELECT sid FROM " . tablename($this->table_idcard) . " WHERE idcard = '{$_GPC['iccode']}' And weid = '{$weid}' And schoolid = '{$schoolid}' ");
		$leave        =  pdo_fetch("SELECT sid,startime1,endtime1 FROM " . tablename($this->table_leave) . " WHERE weid = '{$weid}'  And schoolid = '{$schoolid}' and isliuyan = 0 and status = 1 and startime1 <= '{$time}' and endtime1 >= '{$time}' and sid = '{$ckuser['sid']}' ");
		$result['code'] = 1000;
		$result['msg']    = "success";
		if(!empty($leave)){
			$result['data']['openDoor']   = 0;	
		}else{
			$result['data']['openDoor']   = 1;
		}
		
		echo json_encode($result);
		exit;
    }
?>