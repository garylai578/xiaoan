<?php
/**
 * 微教育模块
 *
 * @author 高贵血迹
 */
   global $_W, $_GPC;
   $operation = in_array ( $_GPC ['op'], array ('default','get_stu_info','change_msg','delstu','set_stu_info','search_stu_info','jzjb') ) ? $_GPC ['op'] : 'default';

    if ($operation == 'default') {
	   die ( json_encode ( array (
			 'result' => false,
			 'msg' => '参数错误'
			) ) );		
    }
	if ($operation == 'jzjb') {
		if (! $_GPC ['schoolid']) {
		    die ( json_encode ( array (
				'result' => false,
				'msg' => '非法请求！' 
			) ) );
	    }
		$user = pdo_fetch("SELECT id,pard,openid,sid FROM " . tablename($this->table_user) . " where :schoolid = schoolid And :id = id", array(':schoolid' => $_GPC ['schoolid'], ':id'=>$_GPC ['userid']));
		if (empty($user)) {
			die ( json_encode ( array (
				'result' => false,
				'msg' => '非法请求，没找用户信息！' 
			) ) );
		}				  
		if (empty($user['openid'])) {
                  die ( json_encode ( array (
                    'result' => false,
                    'msg' => '非法请求！' 
		               ) ) );
		}else{
			$student = pdo_fetch("SELECT keyid FROM " . tablename($this->table_students) . " where :schoolid = schoolid And :id = id", array(':schoolid' => $_GPC ['schoolid'],':id'=>$user ['sid']));
			if($student['keyid'] != '0' ){
				$otherStu = pdo_fetchall("SELECT * FROM " . tablename($this->table_students) . " where :schoolid = schoolid And :weid = weid And :keyid = keyid", array(
	         	':weid' => $_W ['weid'],
			 	':schoolid' => $_GPC ['schoolid'],
			 	':keyid'=>$student ['keyid']
			  	));
			  	
			  	foreach( $otherStu as $key => $value ){
					$thisuser = pdo_fetch("SELECT * FROM " . tablename($this->table_user) . " where :schoolid = schoolid And :sid = sid And :openid = openid", array(':schoolid' => $_GPC ['schoolid'],':sid' => $value ['id'],':openid'=>$user ['openid']));
			  		if($user['pard'] == 2){
						$temp = array( 
						    'mom' => 0,
							'muserid' => 0,
							'muid'=> 0
					    );
					}
					if($user['pard'] == 3){
						$temp = array(
						    'dad' => 0,
							'duserid' => 0,
							'duid'=> 0
						    );
					}
					if($user['pard'] == 4){
						$temp = array(
						    'own' => 0,
							'ouserid' => 0,
							'ouid'=> 0
						    );
					}
					if($user['pard'] == 5){
						$temp = array(
						    'other' => 0,
							'otheruserid' => 0,
							'otheruid'=> 0
						    );
					}
		            pdo_update($this->table_students, $temp, array('id' => $value['id']));
					pdo_delete($this->table_leave, array('userid' => $thisuser['id']));
					pdo_delete($this->table_camerapl, array('userid' => $thisuser['id']));
					pdo_delete($this->table_bjq, array('userid' => $thisuser['id']));
					pdo_delete($this->table_user, array('id' => $thisuser['id']));
			  	}				
			}else{
				if($user['pard'] == 2){
					$temp = array( 
					    'mom' => 0,
						'muserid' => 0,
						'muid'=> 0
				    );
				}
				if($user['pard'] == 3){
					$temp = array(
					    'dad' => 0,
						'duserid' => 0,
						'duid'=> 0
				    );
				}
				if($user['pard'] == 4){
					$temp = array(
					    'own' => 0,
						'ouserid' => 0,
						'ouid'=> 0
				    );
				}
				if($user['pard'] == 5){
					$temp = array(
					    'other' => 0,
						'otheruserid' => 0,
						'otheruid'=> 0
				    );
				}
		        pdo_update($this->table_students, $temp, array('id' => $user['sid']));			   
		        pdo_delete($this->table_user, array('id' => $user['id']));	
				pdo_delete($this->table_leave, array('userid' => $user['id']));
				pdo_delete($this->table_camerapl, array('userid' => $user['id']));
				pdo_delete($this->table_bjq, array('userid' => $user['id']));				
			}
			$data ['result'] = true;
			$data ['msg'] = '解绑成功！';
		 die ( json_encode ( $data ) );
		}
    }	
    if ($operation == 'get_stu_info')  {
		if (! $_GPC ['schoolid']) {
               die ( json_encode ( array (
                    'result' => false,
                    'msg' => '非法请求！' 
		               ) ) );
	    }else{
			$student = pdo_fetch("select id,mobile,s_name,sex,numberid,area_addr,qrcode_id,code from " . tablename($this->table_students) . " where id = :id ", array(':id' => $_GPC ['sid']));
			if($student){
				$qrurl = pdo_fetch("SELECT show_url,expire FROM " . tablename($this->table_qrinfo) . " WHERE id = '{$student['qrcode_id']}'");
				$datass ['sid'] = $student['id'];
				$datass ['sex'] = $student['sex'];
				$datass ['mobile'] = $student['mobile'];
				$datass ['s_name'] = $student['s_name'];
				$datass ['numberid'] = $student['numberid'];
				$datass ['area_addr'] = $student['area_addr'];
				$datass ['code'] = $student['code'];
				$datass ['overtime'] = true;
				if($qrurl['expire'] > time()){
					$datass ['overtime'] = false;
					$datass ['ercode'] = tomedia($qrurl['show_url']);
				}
				$family = pdo_fetchall("SELECT id,uid,pard,status,userinfo FROM " . tablename($this->table_user) . " WHERE sid = '{$student['id']}'");
				if($family){
					foreach($family as $key => $row){
						$member = pdo_fetch("SELECT avatar FROM " . tablename ( 'mc_members' ) . " where uniacid = :uniacid And uid = :uid ", array(':uniacid' => $_W['uniacid'], ':uid' => $row['uid']));
						$family[$key]['avatar'] = $member['avatar'];
						if($row['userinfo']){
							$userinfo = iunserializer($row['userinfo']);
							$family[$key]['username'] = $userinfo['name'];
						}
						if($row['pard'] == 4){
							$family[$key]['pard'] = '本人';
						}else{
							$family[$key]['pard'] = get_guanxi($row['pard']);
						}
						if($row['status'] == 1){
							$family[$key]['ischeck'] = '';
							$family[$key]['isjy'] = '禁言中';
						}else{
							$family[$key]['ischeck'] = 'checked';
							$family[$key]['isjy'] = '允许发言';
						}
					}
				}
				$datass ['family'] = $family;
				$datass ['result'] = true;
				$datass ['msg'] = '获取信息成功';				
			}else{
				$datass ['result'] = false;
				$datass ['msg'] = '获取信息失败';					
			}
		}
		die ( json_encode ( $datass ) );
    }
    if ($operation == 'change_msg')  {
		if (! $_GPC ['schoolid']) {
               die ( json_encode ( array (
                    'result' => false,
                    'msg' => '非法请求！' 
		               ) ) );
	    }else{
			$user = pdo_fetch("select status from " . tablename($this->table_user) . " where id = :id ", array(':id' => $_GPC ['id']));
			if($user){
				if($user['status'] == 1){
					pdo_update($this->table_user, array('status' => 0), array('id' =>$_GPC ['id']));
					$datass ['msg'] = '允许发言';
				}else{
					pdo_update($this->table_user, array('status' => 1), array('id' =>$_GPC ['id']));
					$datass ['msg'] = '禁言成功';
				}
				$datass ['result'] = true;
			}else{
				$datass ['result'] = false;
				$datass ['msg'] = '修改失败';					
			}
		}
		die ( json_encode ( $datass ) );
    }
    if ($operation == 'delstu')  {
		if (! $_GPC ['schoolid']) {
               die ( json_encode ( array (
                    'result' => false,
                    'msg' => '非法请求！' 
		               ) ) );
	    }else{
			$student = pdo_fetch("select id,qrcode_id from " . tablename($this->table_students) . " where id = :id ", array(':id' => $_GPC ['sid']));
			if($student){
				pdo_delete($this->table_user,array('sid' =>$student['id']));
				pdo_delete($this->table_qrinfo,array('id' =>$student['qrcode_id']));
				pdo_delete($this->table_students,array('id' =>$student['id']));
				$datass ['result'] = true;
				$datass ['msg'] = '删除成功';					
			}else{
				$datass ['result'] = false;
				$datass ['msg'] = '无法查询到本学生';					
			}
		}
		die ( json_encode ( $datass ) );
    }
    if ($operation == 'set_stu_info')  {
		if (! $_GPC ['schoolid']) {
               die ( json_encode ( array (
                    'result' => false,
                    'msg' => '非法请求！' 
		               ) ) );
	    }else{
			$school = pdo_fetch("select is_stuewcode,spic from " . tablename($this->table_index) . " where id = :id ", array(':id' => $_GPC ['schoolid']));
			$xq_id = pdo_fetch("select parentid,sname from " . tablename($this->table_classify) . " where sid = :sid ", array(':sid' => $_GPC ['bj_id']));
			if($_GPC['sid']){
				$student = pdo_fetch("select id,icon,qrcode_id from " . tablename($this->table_students) . " where id = :id ", array(':id' => $_GPC ['sid']));
				if($student){
					$pard = pdo_fetchall("SELECT pard FROM ".tablename($this->table_user)." WHERE schoolid = '{$_GPC['schoolid']}' And sid = '{$student['id']}' ");
					if($pard){
						foreach($pard as $k => $v){
							$pard[$k]['pardid'] = $v['pard'];
							if($v['pard'] == 4){
								$pard[$k]['guanxi'] = "本人";
							}else{
								$pard[$k]['guanxi'] = get_guanxi($v['pard']);
							}
						}
					}					
					$temp = array(
						's_name' 	=> trim($_GPC ['s_name']),
						'sex' 	 	=> intval($_GPC ['sex']),
						'mobile' 	=> trim($_GPC ['mobile']),
						'area_addr' => trim($_GPC ['area_addr']),
						'numberid'  => trim($_GPC ['numberid']),
						'code'      => trim($_GPC ['code'])
					);
					$sid = $student['id'];
					pdo_update($this->table_students, $temp, array('id' =>$_GPC ['sid']));
					include $this->template('comtool/newstulist');
				}else{
					$datass ['result'] = false;
					$datass ['msg'] = '未查询到学生信息,请刷新本页';
					die ( json_encode ( $datass ) );	
				}
			}else{
				if(!$_GPC['code']){
					$randStr = str_shuffle('123456789');
					$rand    = substr($randStr, 0, 6);
				}else{
					$rand = trim($_GPC['code']);
				}							
				$temp = array(
					'weid' 		=> $_W ['weid'],
					'schoolid' 	=> trim($_GPC ['schoolid']),
					's_name' 	=> trim($_GPC ['s_name']),
					'sex' 	 	=> intval($_GPC ['sex']),
					'mobile' 	=> trim($_GPC ['mobile']),
					'bj_id' 	=> trim($_GPC ['bj_id']),
					'xq_id' 	=> $xq_id['parentid'],
					'area_addr' => trim($_GPC ['area_addr']),
					'numberid'  => trim($_GPC ['numberid']),
					'seffectivetime' => time(),
					'code'           => $rand
				);
				pdo_insert($this->table_students, $temp);
				$sid = pdo_insertid();
				if($school['is_stuewcode'] == 1){
					load()->func('tpl');
					load()->func('file');
					if(empty($school['spic'])){
						$datass ['result'] = false;
						$datass ['msg'] = '创建失败,联系管理员设置校园默认头像';
						 die ( json_encode ( $datass ) );
					}
					$barcode = array(
						'expire_seconds' =>2592000 ,
						'action_name' => '',
						'action_info' => array(
							'scene' => array(
									'scene_id' => $sid
							),
						),
					);
					$uniacccount = WeAccount::create($weid);
					$barcode['action_name'] = 'QR_SCENE';
					$result = $uniacccount->barCodeCreateDisposable($barcode);
					if (is_error($result)) {
						message($result['message'], referer(), 'fail');
					}
					if (!is_error($result)) {
						$showurl = $this->createImageUrlCenterForUser("https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=" . $result['ticket'], $sid, 0, $_GPC ['schoolid']);
						$urlarr = explode('/',$showurl);
						$qrurls = "images/fm_jiaoyu/".$urlarr['4'];	
						$insert = array(
							'weid' => $_W['uniacid'],
							'schoolid' => $_GPC['schoolid'],
							'qrcid' => $sid, 
							'name' => '用户绑定临时二维码', 
							'model' => 1,
							'qr_url' => ltrim($result['url'],"http://weixin.qq.com/q/"),
							'ticket' => $result['ticket'],
							'show_url' => $qrurls,
							'expire' => $result['expire_seconds'] + time(), 
							'createtime' => time(),
							'status' => '1',
							'type' => '3'
						);
						pdo_insert($this->table_qrinfo, $insert);
						$qrid = pdo_insertid();
						$qrurl = pdo_fetch("SELECT show_url FROM " . tablename($this->table_qrinfo) . " WHERE id = '{$qrid}'");
						$arr = explode('/',$qrurl['show_url']);
						$pathname = "images/fm_jiaoyu/".$arr['2'];
						if (!empty($_W['setting']['remote']['type'])) {
							$remotestatus = file_remote_upload($pathname);
								if (is_error($remotestatus)) {
									message('远程附件上传失败，'.$pathname.'请检查配置并重新上传');
								}
						}					
					}
				}
				$temps = array(
					'keyid'    => $sid,
					'qrcode_id'=> $qrid,
				);
				pdo_update($this->table_students, $temps, array('id' =>$sid));
				pdo_update($this->table_students, $temps, array('keyid' =>$sid));
				include $this->template('comtool/newstulist');
			}
		}
    }
	if ($operation == 'search_stu_info')  {
		$bj_id = trim($_GPC['bj_id']);
		$kc_id = trim($_GPC['kc_id']);
		$search = trim($_GPC['search']);
		$schoolid = trim($_GPC['schoolid']);
		$condition = " AND (s_name LIKE '%{$search}%' Or mobile = '{$search}' Or numberid = '{$search}') ";	
		if($_W['schooltype']){
			$thisKcStu = pdo_fetchall("SELECT distinct sid FROM " . tablename($this->table_order) . " where schoolid = '{$schoolid}' And kcid = '{$kc_id}' and type='1' and sid != 0 ORDER BY id DESC ");
			$Stu_str_temp = '';
			foreach($thisKcStu as $u){
				$Stu_str_temp .=$u['sid'].",";
			}
			$stu_str = trim($Stu_str_temp,",");
			$leave2 = pdo_fetchall("SELECT id,s_name,numberid,qrcode_id,bj_id,sex,icon FROM " . tablename($this->table_students) . " where schoolid = '{$schoolid}' And FIND_IN_SET(id,'{$stu_str}') $condition ORDER BY id DESC ");
		}else{
			$leave2 = pdo_fetchall("SELECT id,s_name,numberid,qrcode_id,bj_id,sex,icon FROM " . tablename($this->table_students) . " where schoolid = '{$schoolid}' And bj_id = '{$bj_id}' $condition ORDER BY id DESC ");
		}

		$school = pdo_fetch("SELECT spic FROM " . tablename($this->table_index) . " where id = :id ", array(':id' => $schoolid));
		foreach($leave2 as $key =>$row){
			$banji = pdo_fetch("SELECT sname FROM " . tablename($this->table_classify) . " where sid = :sid And schoolid = :schoolid ", array(':schoolid' => $schoolid,':sid' => $row['bj_id']));
			$leave2[$key]['banji'] = $banji['sname'];
			$leave2[$key]['pard'] = pdo_fetchall("SELECT pard FROM ".tablename($this->table_user)." WHERE schoolid = '{$schoolid}' And sid = '{$row['id']}' ");
			if($leave2[$key]['pard']){
				foreach($leave2[$key]['pard'] as $k => $v){
					$leave2[$key]['pard'][$k]['pardid'] = $v['pard'];
					if($v['pard'] == 4){
						$leave2[$key]['pard'][$k]['guanxi'] = "本人";
					}else{
						$leave2[$key]['pard'][$k]['guanxi'] = get_guanxi($v['pard']);
					}
				}
			}
		}
		include $this->template('comtool/stulist');		
	}	
?>