<?php
/**
 * By 高贵血迹
 */

	global $_GPC, $_W;
	
	$operation = in_array ( $_GPC ['op'], array ('default', 'login', 'classinfo', 'check', 'gps', 'banner', 'video') ) ? $_GPC ['op'] : 'default';
	$weid = $_GPC['i'];
	$schoolid = $_GPC['schoolid'];
	$macid = $_GPC['macid'];
	$ckmac = pdo_fetch("SELECT * FROM " . tablename($this->table_checkmac) . " WHERE macid = '{$macid}' And schoolid = '{$schoolid}' ");
	$school = pdo_fetch("SELECT * FROM " . tablename($this->table_index) . " WHERE id = '{$schoolid}' ");
	if ($operation == 'default') {
		echo("错误，未知操作");
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
			$result['data']['schoolInfo'] = array(
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
			$result['code'] = 1000;
			$result['msg'] = "success";
			$result['ServerTime'] = date('Y-m-d H:i:s',time());
			echo json_encode($result);
		}
    }

	if ($operation == 'classinfo') {
		$classid = $_GPC['classId'];
		$isfz = pdo_fetch("SELECT type  FROM " . tablename($this->table_classify) . " WHERE weid = '{$weid}' And schoolid = '{$school['id']}' And sid = '{$classid}'");	
		if ($isfz['type'] == 'theclass'){
			if(!empty($ckmac)){
				$class = pdo_fetchall("SELECT id as childId, bj_id as classId, icon as headIcon, s_name as name FROM " . tablename($this->table_students) . " WHERE weid = '{$weid}' And schoolid = {$school['id']} And bj_id = '{$classid}' ORDER BY id DESC");
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
			if(!empty($ckuser)){
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
				if($_GPC['signId'] == '999999999'){
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
		$ims = tomedia($banner['pic1']).'#'.tomedia($banner['pic2']).'#'.tomedia($banner['pic3']).'#'.tomedia($banner['pic4']);
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
	

?>