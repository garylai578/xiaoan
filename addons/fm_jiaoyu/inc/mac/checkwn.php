<?php

/**

 * By 高贵血迹

 */



	global $_GPC, $_W;

	$operation = in_array ( $_GPC ['op'], array ('default', 'login', 'class', 'check', 'gps', 'banner', 'video', 'start', 'notice', 'users', 'getdate') ) ? $_GPC ['op'] : 'default';

	$weid = $_GPC['i'];

	$schoolid = $_GPC['schoolid'];

	$macid = empty($_GPC['macid'])? $_GPC['device_id'] : $_GPC['macid'];

	$ckmac = pdo_fetch("SELECT * FROM " . tablename($this->table_checkmac) . " WHERE macid = '{$macid}' And weid = '{$weid}' And schoolid = '{$schoolid}' ");

	$school = pdo_fetch("SELECT * FROM " . tablename($this->table_index) . " WHERE id = '{$schoolid}' ");



	if ($operation == 'default') {

		$result['status']    = -1;

		$result['msg'] = "对不起，你的请求不存在！";

		echo json_encode($result);

		exit;

    }

	if(empty($school)){

		$result['status']    = -1;

		$result['msg'] = "找不到本校，设备未关联学校?";

		echo json_encode($result);		

	}

	if(empty($ckmac)){

		$result['status']    = -1;

		$result['msg'] = "没找到设备,请添加设备";

		echo json_encode($result);

	}	

	if($school['is_recordmac'] == 2){

		$result['status']    = -1;

		$result['msg'] = "本校无权使用设备,请联系管理员";

		echo json_encode($result);		

	}	

	if ($ckmac['is_on'] == 2){

		$result['status']    = -1;

		$result['msg'] = "本设备已关闭,请联系管理员";

		echo json_encode($result);			

	}

	if (empty($_W['setting']['remote']['type'])) { 

		$urls = $_W['SITEROOT'].$_W['config']['upload']['attachdir'].'/'; 

	} else {

		$urls = $_W['attachurl'];

	}

	if ($operation == 'notice') { //getNotice

		if(!empty($school)){

			$banner          = unserialize($ckmac['banner']);

			$result['status'] = 0;

			$result['msg'] = "获取数据成功";

			$result['data'] = array(

				array(

					'id' => '1',

					'title' => '',

					'info' => $banner['pop'],

					'add_time' => date('Y-m-d H:i:s',time())

				)			

			);

			echo json_encode($result);

			exit;

		}

    }	

	if ($operation == 'users') { //getstatus获取学生信息

		if(!empty($ckmac)){		                  

			$users = pdo_fetchall("SELECT idcard, sid, pname, bj_id, usertype, tid FROM " . tablename($this->table_idcard) . " WHERE weid = '{$weid}' And schoolid = {$school['id']} And is_on = 1 ORDER BY id DESC");

				if($users){

					$result['status'] = 0;

					$result['msg'] = "获取数据成功";

					$result['countpage'] = "1";						

					foreach($users as $key =>$row) {

						if($row['usertype'] == 1){

							$teacher = pdo_fetch("SELECT tname,thumb,sex  FROM " . tablename($this->table_teachers) . " WHERE id = '{$row['tid']}' ");

							$users[$key]['id'] = "02".$row['tid'];

							$users[$key]['sex'] = $teacher['sex'];

							$users[$key]['name'] = $teacher['tname'];	

							$users[$key]['s_type'] = 2;	//暂时全部告诉考勤机都是走读学

							$users[$key]['code'] = "";

							$users[$key]['iccode'] = $row['idcard'];

							$users[$key]['parents'] = '';

							$users[$key]['parentsphone'] = '';

							$users[$key]['cid'] = '';

							$users[$key]['type'] = 2;

							$users[$key]['picrul'] = empty($teacher['thumb']) ? tomedia($school['tpic']) : tomedia($teacher['thumb']);//未设置头像，取默认头像

							$users[$key]['iccodes'] = array(

								array(

									'stu_id' => "02".$row['tid'],

									'iccode' => $row['idcard'],

									'type' => 2

								)			

							);

						}else{

							$student = pdo_fetch("SELECT s_name,icon,numberid,sex  FROM " . tablename($this->table_students) . " WHERE id = '{$row['sid']}' ");

							$users[$key]['id'] = $row['sid'];

							$users[$key]['sex'] = $student['sex'];

							$users[$key]['name'] = $student['s_name'];	

							$users[$key]['s_type'] = 2;	//暂时全部告诉考勤机都是走读学

							$users[$key]['code'] = $student['numberid'];

							$users[$key]['iccode'] = $row['idcard'];

							$users[$key]['parents'] = $row['pname'];

							/**关系 start**/

							$relation = pdo_fetch("SELECT  pard,idcard  FROM " . tablename($this->table_idcard) . " WHERE idcard = '{$row['idcard']}' ");

							$users[$key]['relationship'] = $relation['pard'];

							/**关系 end**/						
							
							$studentidcard = pdo_fetch("SELECT idcard  FROM " . tablename($this->table_idcard) . " WHERE sid = '{$row['sid']}' ");	

							$users[$key]['parentsphone'] = '';

							$users[$key]['cid'] = $row['bj_id'];

							$users[$key]['type'] = 1;

							$users[$key]['picrul'] = empty($student['icon']) ? tomedia($school['spic']) : tomedia($student['icon']);

							$users[$key]['iccodes'] = array(

								array(

									'stu_id' => $row['sid'],

									'iccode' => $studentidcard['idcard'],

									'type' => 1

								)			

							);						

						}

					}

					$result['data'] = $users;

				}else{

					$result['status']    = -1;

					$result['msg'] = "没有有效考勤卡信息";

				}

			echo json_encode($result);

			exit;

		}

    }	

	if ($operation == 'class') {//获取班级信息

		if(!empty($ckmac)){

			$class = pdo_fetchall("SELECT sid as id, sname as classes, schoolid as sid, ssort as score, tid FROM " . tablename($this->table_classify) . " WHERE weid = '{$weid}' And type = 'theclass' And schoolid = {$school['id']} ORDER BY ssort DESC");

			if($class){

				$result['status'] = 0;

				$result['msg'] = "获取数据成功";

				foreach($class as $key =>$row) {

						$class[$key]['info'] = $row['classes'];

						$class[$key]['yearid'] = '';

						$class[$key]['token'] = '';

						$class[$key]['fnum'] = '';

						$class[$key]['stnum'] = '';

						$class[$key]['dongnum'] = '';

						$class[$key]['tongnum'] = '';

						$class[$key]['jiaxiangnum'] = '';

						$class[$key]['laoxiangnum'] = '';

						$class[$key]['initial'] = '';

						$class[$key]['pic'] = '';

						$class[$key]['upgrade'] = '';

						$class[$key]['yearid'] = '';

						$class[$key]['yearid'] = '';

						$class[$key]['yearid'] = '';

						$class[$key]['mostart'] = '00:00';

						$class[$key]['moend'] = '23:59';

						$class[$key]['nostart'] = '';

						$class[$key]['noend'] = '';

						$class[$key]['afstart'] = '';

						$class[$key]['afend'] = '';

				}			

				$result['data'] = $class;

			}else{

				$result['status']    = -1;

				$result['msg'] = "本校未添加班级信息";				

			}

			echo json_encode($result);

		}

    }	

	if ($operation == 'login') { //获取学校信息

		$voice='';	

		if(!empty($ckmac)){			

			$result['status'] = 0;

			$result['msg'] = "获取数据成功";

			if($ckmac['banner']){

				$banner          = unserialize($ckmac['banner']);

				if($banner['pic1']){

					$pictures        = array(tomedia($banner['pic1']));

				}

				if($banner['pic1'] && $banner['pic2']){

					$pictures        = array(tomedia($banner['pic1']),tomedia($banner['pic2']));

				}

				if($banner['pic1'] && $banner['pic2'] && $banner['pic3']){

					$pictures        = array(tomedia($banner['pic1']),tomedia($banner['pic2']),tomedia($banner['pic3']));

				}

				if($banner['pic1'] && $banner['pic2'] && $banner['pic3'] && $banner['pic4']){

					$pictures        = array(tomedia($banner['pic1']),tomedia($banner['pic2']),tomedia($banner['pic3']),tomedia($banner['pic4']));

				}

				if($banner['pic1'] && $banner['pic2'] && $banner['pic3'] && $banner['pic4']  && $banner['pic5']){		

					$pictures        = array(tomedia($banner['pic1']),tomedia($banner['pic2']),tomedia($banner['pic3']),tomedia($banner['pic4']),tomedia($banner['pic5']));

				}

				if($banner['VOICEPRE2']){

					$voice = $banner['VOICEPRE2'];

				}				

				$result['data']['position3']['picture'] = $pictures;

				$temp = array(

					'isflow' => 2,

					'pop'  	 	 		=> $banner['pop'],

					'bgimg'  			=> $banner['bgimg'],

					'qrcode'			=> $banner['qrcode'],

					'video' 		    => $banner['video'],

					'pic1'  			=> $banner['pic1'],

					'pic2'  			=> $banner['pic2'],

					'pic3'   			=> $banner['pic3'],

					'pic4'  			=> $banner['pic4'],

					'pic5'   			=> $banner['pic5'],

					'VOICEPRE'			=> $banner['VOICEPRE'],

					'VOICEPRE2'			=> $banner['VOICEPRE2']

				);

				$data['banner'] = serialize($temp);

				pdo_update($this->table_checkmac, $data, array('id' => $ckmac['id']));

			}			

			$result['data'] = array(

				'admin_id' => '',

				'email' => '',

				'address' => $school['address'],

				'name' => $school['title'],

				'banner' => $pictures,

				'video' => $banner['video'],

				'gname' => '',

				'phone' => '',

				'yuyin' => $voice?$voice:'[name]',

				'logo' => tomedia($school['logo']),

				'receive_time' => '',

				'send_start' => '',

				'send_end' => '',

				'receive_start' => '',

				'receive_end' => '',

				'contentURL' => '',

				'hosturl' => getoauthurl(),

				'posturl' => $_W['siteroot'] . 'app/index.php?i=' . $weid . '&c=entry&schoolid=' . $schoolid . '&do=checkwn&op=check&m=fm_jiaoyu',

				'gpsurl' => $_W['siteroot'] . 'app/index.php?i=' . $weid . '&c=entry&schoolid=' . $schoolid . '&do=checkwn&op=gps&m=fm_jiaoyu',				

			);

			echo json_encode($result);

			exit;

		}

    }

	if ($operation == 'start') {			



    }

	

	if ($operation == 'gps') {			

		$result['status'] = 0;

		$result['msg'] = "定位上传成功";

		$result['data'] = array();

		echo json_encode($result);

		exit;

    }

	

	if ($operation == 'getdate') {					

		$result['status'] = "0";

		$result['msg'] = "获取数据成功";

		$result['data'] = array(

			'da_start' => array(1,2,3,4,5,6,7)	

		);

		echo json_encode($result);

		exit;

    }



	if ($operation == 'check') {

		$fstype = false;

		$ckuser = pdo_fetch("SELECT sid,pard,tid,severend FROM " . tablename($this->table_idcard) . " WHERE idcard = '{$_GPC['iccode']}' And weid = '{$weid}' And schoolid = '{$schoolid}' ");

		$bj = pdo_fetch("SELECT bj_id FROM " . tablename($this->table_students) . " WHERE id = '{$ckuser['sid']}' ");

		$signTime = strtotime($_GPC['signtime']);

		$checkthisdata = pdo_fetch("SELECT id FROM " . tablename($this->table_checklog) . " WHERE cardid = '{$_GPC['iccode']}' And createtime = '{$signTime}' And schoolid = '{$schoolid}' ");

		if(empty($checkthisdata)){

			if(!empty($ckuser)){

				$times = time();

				if(!empty($_GPC['headerimg']) || !empty($_GPC['headerimg_second'])){

					load()->func('file');

					load()->func('communication');

					$path = "images/fm_jiaoyu/checkwn/". date('Y/m/d/');

					$rand = random(30);

					if(!empty($_GPC['headerimg'])){

						$picurl = $path.$rand."_1.jpg";

						$files_image = base64_decode($_GPC['headerimg']);

						file_write($picurl,$files_image);

						if (!empty($_W['setting']['remote']['type'])) {

							file_remote_upload($picurl);

						}

						$pic = $picurl;

					}

					if(!empty($_GPC['headerimg_second'])){

						$picurl2 = $path.$rand."_2.jpg";

						$files_image2 = base64_decode($_GPC['headerimg_second']);

						file_write($picurl2,$files_image2);

						if (!empty($_W['setting']['remote']['type'])) {

							file_remote_upload($picurl2);

						}					

						$pic2 = $picurl2;

					}

				}			

				$nowtime = date('H:i',$signTime);

				if($ckmac['type'] !=0){

					include 'checktime2.php';	

				}else{

					$signMode = $_GPC['m_type'];

					include 'checktime.php';	

				}

				if(!empty($ckuser['sid'])){

					if($school['is_cardpay'] == 1){					

						if($ckuser['severend'] > $times){

							$data = array(

							'weid' => $weid,

							'schoolid' => $schoolid,

							'macid' => $ckmac['id'],

							'cardid' => $_GPC ['iccode'],

							'sid' => $ckuser['sid'],

							'bj_id' => $bj['bj_id'],

							'lon' => $_GPC['lon'],

							'lat' => $_GPC['lat'],							

							'type' => $type,

							'pic' => $pic,

							'pic2' => $pic2,

							'temperature' => $_GPC['signTemp'],

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

								}

							}else{

								$this->sendMobileJxlxtz($schoolid, $weid, $bj['bj_id'], $ckuser['sid'], $type, $leixing, $checkid, $ckuser['pard']);

							}

							$fstype = true;	

						}else{

							$fstype = false;

							$result['msg'] = "刷卡失败,本卡已过有效期";

						}					

					}else{

						$data = array(

						'weid' => $weid,

						'schoolid' => $schoolid,

						'macid' => $ckmac['id'],

						'cardid' => $_GPC ['iccode'],

						'sid' => $ckuser['sid'],

						'bj_id' => $bj['bj_id'],

						'lon' => $_GPC['lon'],

						'lat' => $_GPC['lat'],

						'type' => $type,

						'pic' => $pic,

						'pic2' => $pic2,

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

						'cardid' => $_GPC ['iccode'],

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

				$fstype = false;

				$result['msg'] = "未查询到本卡绑定情况";

			}

		}else{

			$fstype = false;

			$result['msg'] = "失败,本次刷卡为重复提交不写入记录";

		}		

		if ($fstype == true){

			$result['status'] = 0;

			$result['msg'] = "刷卡成功";

			echo json_encode($result);

			exit;

        }else{

			$result['status'] = -1;

			//$result['msg'] = "失败";

			echo json_encode($result);

			exit;

		}	

	}

?>