<?php
/**
 * 微教育模块
 *
 * @author 高贵血迹
 */

class zipfile {
    var $datasec = array ();
    var $ctrl_dir = array ();
    var $eof_ctrl_dir = "\x50\x4b\x05\x06\x00\x00\x00\x00";
    var $old_offset = 0;

    function unix2_dostime($unixtime = 0){
        $timearray = ($unixtime == 0) ? getdate () : getdate($unixtime);
        if ($timearray ['year'] < 1980){
            $timearray ['year'] = 1980;
            $timearray ['mon'] = 1;
            $timearray ['mday'] = 1;
            $timearray ['hours'] = 0;
            $timearray ['minutes'] = 0;
            $timearray ['seconds'] = 0;
        }
        return (($timearray ['year'] - 1980) << 25) | ($timearray ['mon'] << 21) | ($timearray ['mday'] << 16) | ($timearray ['hours'] << 11) | ($timearray ['minutes'] << 5) | ($timearray ['seconds'] >> 1);
    }
    function add_file($data, $name, $time = 0){
        $name = str_replace('\\', '/', $name);

        $dtime = dechex($this->unix2_dostime($time));
        $hexdtime = '\x' . $dtime [6] . $dtime [7] . '\x' . $dtime [4] . $dtime [5] . '\x' . $dtime [2] . $dtime [3] . '\x' . $dtime [0] . $dtime [1];
        eval('$hexdtime = "' . $hexdtime . '";');

        $fr = "\x50\x4b\x03\x04";
        $fr .= "\x14\x00";
        $fr .= "\x00\x00";
        $fr .= "\x08\x00";
        $fr .= $hexdtime;

        $unc_len = strlen($data);
        $crc = crc32($data);
        $zdata = gzcompress($data);
        $zdata = substr(substr($zdata, 0, strlen($zdata)- 4), 2);
        $c_len = strlen($zdata);
        $fr .= pack('V', $crc);
        $fr .= pack('V', $c_len);
        $fr .= pack('V', $unc_len);
        $fr .= pack('v', strlen($name));
        $fr .= pack('v', 0);
        $fr .= $name;

        $fr .= $zdata;
        $fr .= pack('V', $crc);
        $fr .= pack('V', $c_len);
        $fr .= pack('V', $unc_len);

        $this->datasec [] = $fr;

        $cdrec = "\x50\x4b\x01\x02";
        $cdrec .= "\x00\x00";
        $cdrec .= "\x14\x00";
        $cdrec .= "\x00\x00";
        $cdrec .= "\x08\x00";
        $cdrec .= $hexdtime;
        $cdrec .= pack('V', $crc);
        $cdrec .= pack('V', $c_len);
        $cdrec .= pack('V', $unc_len);
        $cdrec .= pack('v', strlen($name));
        $cdrec .= pack('v', 0);
        $cdrec .= pack('v', 0);
        $cdrec .= pack('v', 0);
        $cdrec .= pack('v', 0);
        $cdrec .= pack('V', 32);

        $cdrec .= pack('V', $this->old_offset);
        $this->old_offset += strlen($fr);

        $cdrec .= $name;

        $this->ctrl_dir[] = $cdrec;
    }
    function add_path($path, $l = 0){
        $d = @opendir($path);
        $l = $l > 0 ? $l : strlen($path) + 1;
        while($v = @readdir($d)){
            if($v == '.' || $v == '..'){
                continue;
            }
            $v = $path . '/' . $v;
            if(is_dir($v)){
                $this->add_path($v, $l);
            } else {
                $this->add_file(file_get_contents($v), substr($v, $l));
            }
        }
    }
    function file(){
        $data = implode('', $this->datasec);
        $ctrldir = implode('', $this->ctrl_dir);
        return $data . $ctrldir . $this->eof_ctrl_dir . pack('v', sizeof($this->ctrl_dir)) . pack('v', sizeof($this->ctrl_dir)) . pack('V', strlen($ctrldir)) . pack('V', strlen($data)) . "\x00\x00";
    }

    function add_files($files){
        foreach($files as $file){
            if (is_file($file)){
                $data = implode("", file($file));
                $this->add_file($data, $file);
            }
        }
    }
    function output($file){
        $fp = fopen($file, "w");
        fwrite($fp, $this->file ());
        fclose($fp);
    }
}


global $_GPC, $_W;
		$weid              = $_W['uniacid'];
		$action            = 'students';
		$this1             = 'no2';
		$GLOBALS['frames'] = $this->getNaveMenu($_GPC['schoolid'], $action);
		$schoolid          = intval($_GPC['schoolid']);
		$schooltype         = $_W['schooltype'];
		$school            = pdo_fetch("SELECT * FROM " . tablename($this->table_index) . " where id = :id ", array(':id' => $schoolid));
		$logo              = pdo_fetch("SELECT logo,title,is_stuewcode,spic FROM " . tablename($this->table_index) . " WHERE id = '{$schoolid}'");			
		$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
		$tid_global = $_W['tid'];
		if($operation == 'post'){
			if (!(IsHasQx($tid_global,1000702,1,$schoolid))){
				$this->imessage('非法访问，您无权操作该页面','','error');	
			}
			load()->func('tpl');
			$id = intval($_GPC['id']);
			if(!empty($id)){
				$item = pdo_fetch("SELECT * FROM " . tablename($this->table_students) . " WHERE id = :id", array(':id' => $id));
				
				if($item['keyid'] != '0' )
				{
					$other = pdo_fetchall("SELECT * FROM " . tablename($this->table_students) . " WHERE keyid = :id", array(':id' => $item['keyid']));
					foreach( $other as $key => $value )
					{
						if($value['keyid'] != $value['id']){
						$item['all'][] = array(
							'xq_id' => $value['xq_id'],
							'bj_id' => $value['bj_id'],
							'sid'   => $value['id']

						);
					}
					}
				}
				
				if(empty($item)){
					$this->imessage('抱歉，学生不存在或是已经删除1！', '', 'error');
				}else{
					if(!empty($item['thumb_url'])){
						$item['thumbArr'] = explode('|', $item['thumb_url']);
					}
				}
			}
			$xueqi             = pdo_fetchall("SELECT sid,sname FROM " . tablename($this->table_classify) . " where weid = :weid AND schoolid = :schoolid And type = :type ORDER BY ssort DESC", array(':weid' => $weid, ':type' => 'semester', ':schoolid' => $schoolid));
			$bj                = pdo_fetchall("SELECT sid,sname FROM " . tablename($this->table_classify) . " where weid = :weid AND schoolid = :schoolid And type = :type ORDER BY ssort DESC", array(':weid' => $weid, ':type' => 'theclass', ':schoolid' => $schoolid));			
			if($item['code'] == 0){
				$randStr = str_shuffle('123456789');
				$rand    = substr($randStr, 0, 6);
			}else{
				$rand = $item['code'];
			}
			if(!empty($_GPC['code'])){
				$rand = $_GPC['code'];
			}	
			if(checksubmit('submit')){
				if(!empty($_GPC['new'])){
					if(count($_GPC['bj_new']) != count(array_unique($_GPC['bj_new'])))
						{
							$this->imessage('对不起，您增加的班级有重复', '', 'error');
						}
						if(in_array(0,$_GPC['bj_new']))
						{
							$this->imessage('对不起，您有未选择的班级信息', '', 'error');
						}
				}
				$data  = array(
					'weid'           => $weid,
					'schoolid'       => $schoolid,
					's_name'         => trim($_GPC['s_name']),
					'icon'           => trim($_GPC['icon']),
					'sex'            => intval($_GPC['sex']),
					's_type'            => intval($_GPC['s_type']),
					'bj_id'          => trim($_GPC['bj']),
					'xq_id'          => trim($_GPC['xueqi']),
					'numberid'       => trim($_GPC['numberid']),
					'birthdate'      => strtotime($_GPC['birthdate']),
					'homephone'      => trim($_GPC['tel']),
					'mobile'         => trim($_GPC['mobile']),
					'area_addr'      => trim($_GPC['addr']),
					'seffectivetime' => strtotime($_GPC['seffectivetime']),
					'stheendtime'    => strtotime($_GPC['stheendtime']),
					'note'           => trim($_GPC['note']),
					'code'           => $rand,
                    'createdate'     => time(), //如果修改了与考勤相关的字段，则更新createdate
				);
				
				$check = pdo_fetch("SELECT * FROM " . tablename($this->table_students) . " WHERE s_name = :s_name And mobile = :mobile And schoolid = :schoolid", array(':s_name' => $_GPC['s_name'], ':mobile' => $_GPC['mobile'], ':schoolid' => $schoolid));
				if(empty($data['s_name'])){
					$this->imessage('请输入学生姓名！');
				}
				if(!empty($data['s_name'])){
					if(ischeckName($data['s_name']) == false){
						$this->imessage("禁止使用'测试、test'等作为学生姓名", referer(), 'error');
					}
				}				
				if(empty($data['mobile'])){
					$this->imessage('请输入学生家长手机');
				}
				if(empty($id)){
					if(!empty($check)){
						$this->imessage('录入失败，您输入的学生信息有重复，检查手机号和名字是否同时重复！');
					}
					pdo_insert($this->table_students, $data);
					$keysid = pdo_insertid();
					if($logo['is_stuewcode'] ==1){
						if(empty($_GPC['icon'])){
							if(empty($logo['spic'])){
								$this->imessage('抱歉,本校开启了用户二维码功能,请上传学生头像或设置校园默认学生头像');
							}
						}
						load()->func('tpl');
						load()->func('file');
						$barcode = array(
							'expire_seconds' =>2592000,
							'action_name' => '',
							'action_info' => array(
								'scene' => array(
									'scene_id' => $keysid
								),
							),
						);
						$uniacccount = WeAccount::create($wwwweid);
						$barcode['action_name'] = 'QR_SCENE';
						$result = $uniacccount->barCodeCreateDisposable($barcode);
						if (is_error($result)) {
							message($result['message'], referer(), 'fail');
						}
						if (!is_error($result)) {
							$showurl = $this->createImageUrlCenterForUser("https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=" . $result['ticket'], $keysid, 0, $schoolid);
							$urlarr = explode('/',$showurl);
							$qrurls = "images/fm_jiaoyu/".$urlarr['4'];	
							$insert = array(
								'weid' => $weid, 
								'schoolid' => $schoolid,
								'qrcid' => $keysid, 
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
					$temp1 = array(
						'keyid' => $keysid,
						'qrcode_id' => $qrid
					);
					pdo_update($this->table_students, $temp1, array('id' =>$keysid)); 
					
					if(!empty($_GPC['new'])){
						foreach($_GPC['new'] as $key => $v)
						{
							$datas  = array(
								'weid'           => $weid,
								'schoolid'       => $schoolid,
								's_name'         => trim($_GPC['s_name']),
								'icon'           => trim($_GPC['icon']),
								'sex'            => intval($_GPC['sex']),
								'bj_id'          => trim($_GPC['bj_new'][$key]),
								'xq_id'          => trim($_GPC['xueqi_new'][$key]),
								'numberid'       => trim($_GPC['numberid']),
								'keyid'          => $keysid,
								'qrcode_id'      => $qrid,
								'birthdate'      => strtotime($_GPC['birthdate']),
								'homephone'      => trim($_GPC['tel']),
								'mobile'         => trim($_GPC['mobile']),
								'area_addr'      => trim($_GPC['addr']),
								'seffectivetime' => strtotime($_GPC['seffectivetime']),
								'stheendtime'    => strtotime($_GPC['stheendtime']),
								'note'           => trim($_GPC['note']),
								'code'           => $rand,
                                'createdate'     => time(), //如果修改了与考勤相关的字段，则更新createdate
							);
							pdo_insert($this->table_students, $datas);
						};
					}
				}else{
					$checkcard = pdo_fetch("SELECT * FROM " . tablename($this->table_idcard) . " WHERE sid = :sid", array(':sid' => $id));
					if($checkcard){
						pdo_update($this->table_idcard, array('bj_id' => trim($_GPC['bj'])), array('sid' => $id));
					}
					$data['keyid'] = $id;
					pdo_update($this->table_students, $data, array('id' => $id));
					$primary = pdo_fetch("SELECT * FROM " . tablename($this->table_students) . " WHERE id=:sid And schoolid = :schoolid", array(':sid' => $id,':schoolid' => $schoolid));
					array_splice($primary,0,1);
					$before_sid_arr = pdo_fetchall("SELECT id FROM " . tablename($this->table_students) . " WHERE keyid=:keyid And schoolid = :schoolid", array(':keyid' => $id,':schoolid' => $schoolid));
					$LenOfBSid =  count($before_sid_arr,COUNT_NORMAL);
					if($LenOfBSid >1 && empty($_GPC['sid_before']))
					{
						foreach( $before_sid_arr as $key => $value )
						{
							if($value['id'] != $id )
							{
								//echo "删除的sid:".$value['id']."\n";
							pdo_delete($this->table_students,array('id' =>$value['id']));
							$checkUser = pdo_fetch("SELECT * FROM " . tablename($this->table_user) . " WHERE sid=:sid And schoolid = :schoolid", array(':sid' => $value['id'],':schoolid' => $schoolid));
							if($checkUser)
							{
								pdo_delete($this->table_user,array('sid' =>$value['id']));
									//echo "如果 user表里已绑定1，还要删除sid在user表里的数据\n";
							}	
							}
						}
					}
					if(!empty($_GPC['sid_before'])){
						if(in_array($_GPC['bj'],$_GPC['bj_before'] ))
						{
							$this->imessage('修改失败，修改后的班级有重复！');
						}
						
						$bj_before_arr = array();
						foreach( $_GPC['sid_before'] as $key => $value )
						{
							if(!empty($_GPC['new']))
						{
								if(in_array($_GPC['bj_before'][$key], $_GPC['bj_new'] ))
							{
								$this->imessage('修改失败，修改后的班级有重复！');
							}
						}
							$bj_before_arr[$value]['bj_id'] = $_GPC['bj_before'][$key];
							$bj_before_arr[$value]['xq_id'] = $_GPC['xueqi_before'][$key];
							
						}
						foreach( $before_sid_arr as $key => $value )
					{
						if(in_array($value['id'],$_GPC['sid_before']) )
						{
							$primaryThis = pdo_fetch("SELECT * FROM " . tablename($this->table_students) . " WHERE id=:sid And schoolid = :schoolid", array(':sid' => $value['id'],':schoolid' => $schoolid));
							
							$primaryThis['bj_id'] = $bj_before_arr[$value['id']]['bj_id'];
							$primaryThis['xq_id'] = $bj_before_arr[$value['id']]['xq_id'];
							$primaryThis['s_name'] = trim($_GPC['s_name']);
							$primaryThis['icon'] = trim($_GPC['icon']);
							$primaryThis['sex'] = trim($_GPC['sex']);
							$primaryThis['numberid'] = trim($_GPC['numberid']);
							$primaryThis['birthdate'] = strtotime($_GPC['birthdate']);
							$primaryThis['homephone'] = trim($_GPC['tel']);
							$primaryThis['mobile'] = trim($_GPC['mobile']);
							$primaryThis['area_addr'] = trim($_GPC['addr']);
							$primaryThis['seffectivetime'] = strtotime($_GPC['seffectivetime']);
							$primaryThis['stheendtime'] = strtotime($_GPC['stheendtime']);
							$primaryThis['note'] = trim($_GPC['note']);
							$primaryThis['code'] = $rand;
							$primaryThis['createdate'] = time();    //当修改了与考勤相关的字段时，更新一下createdate
							array_splice($primaryThis,0,1);
							//echo "修改的sid:".$value['id']."\n";
							
							pdo_update($this->table_students,$primaryThis,array('id'=>$value['id']));
							
						}elseif($value['id'] == $id){
							
							
						}else{
							//echo "删除的sid:".$value['id']."\n";
							pdo_delete($this->table_students,array('id' =>$value['id']));
							DeleteStudent($value['id']);
							$checkUser = pdo_fetch("SELECT * FROM " . tablename($this->table_user) . " WHERE sid=:sid And schoolid = :schoolid", array(':sid' => $value['id'],':schoolid' => $schoolid));
							if($checkUser)
							{
								pdo_delete($this->table_user,array('sid' =>$value['id']));
									//echo "如果 user表里已绑定1，还要删除sid在user表里的数据\n";
							}	
							
						}
						}
					}

					if(!empty($_GPC['new'])){
						if(in_array($_GPC['bj'], $_GPC['bj_new'] ))
						{
							$this->imessage('修改失败，修改后的班级有重复！');
						}
						foreach($_GPC['new'] as $key => $v)
						{
							$primary['bj_id'] = $_GPC['bj_new'][$key];
							$primary['xq_id'] = $_GPC['xueqi_new'][$key];
							$primary['createdate'] = time(); //如果修改了与考勤相关的字段，则更新createdate
							pdo_insert($this->table_students, $primary);
							$newsid = pdo_insertid();
							//echo "新增的bjid:".$_GPC['bj_new'][$key]."\n";
							
							$CkUrKid =  pdo_fetchall("SELECT sid,tid,weid,schoolid,uid,openid,userinfo,pard,status,is_allowmsg,is_frist,createtime FROM " . tablename($this->table_user) . " WHERE sid=:sid And schoolid = :schoolid", array(':sid' => $primary['keyid'],':schoolid' => $schoolid));
							if(!empty($CkUrKid))
							{
								//var_dump($CkUrKid);
								foreach( $CkUrKid as $key => $value )
								{
									$value['sid'] = $newsid;
									pdo_insert($this->table_user,$value);
									$uu = pdo_insertid();
									if( $value['pard'] == 2 )
									{
										$tempFromUser = array(
										'muserid' => $uu
										);
										pdo_update($this->table_students,$tempFromUser,array('id'=>$newsid));
									}
									if( $value['pard'] == 3 )
									{
										$tempFromUser = array(
										'duserid' => $uu
										);
										pdo_update($this->table_students,$tempFromUser,array('id'=>$newsid));
									}
									if( $value['pard'] == 4 )
									{
										$tempFromUser = array(
										'ouserid' => $uu
										);
										pdo_update($this->table_students,$tempFromUser,array('id'=>$newsid));
									}
									if( $value['pard'] == 5 )
									{
										$tempFromUser = array(
										'otheruserid' => $uu
										);
										pdo_update($this->table_students,$tempFromUser,array('id'=>$newsid));
									}
									
									
								
								//echo "如果user表里keyid已绑定1，还要新增user表的数据\n";
								//var_dump($uu);
								}
								
							}
							//die();
						};
					}
				}
				
				$this->imessage('操作学生信息成功！', $this->createWebUrl('students', array('op' => 'display', 'schoolid' => $schoolid)), 'success');
			}
		}elseif($operation == 'changebjdata'){
				$oldbjdata = pdo_fetchall("SELECT id,bj_id FROM " . tablename($this->table_students) . " WHERE weid = :weid AND schoolid = :schoolid ORDER BY id DESC");
				foreach($oldbjdata as $index => $row){
					if($row['bj_id']){
						$data1 = array(
							'weid'     => $weid,
							'schoolid' => $schoolid,
							'sid'      => $row['id'],
							'bj_id'    => $row['bj_id'],
							'type'     => 2,
						);
						pdo_insert($this->table_class, $data1);
					}					
				}
				$this->imessage('操作成功', $this->createWebUrl('students', array('op' => 'display', 'schoolid' => $schoolid)), 'success');			
		}elseif($operation == 'display'){
			if (!(IsHasQx($tid_global,1000701,1,$schoolid))){
				$this->imessage('非法访问，您无权操作该页面','','error');	
			}
			$xueqi             = pdo_fetchall("SELECT sid,sname FROM " . tablename($this->table_classify) . " where weid = :weid AND schoolid = :schoolid And type = :type ORDER BY ssort DESC", array(':weid' => $weid, ':type' => 'semester', ':schoolid' => $schoolid));			
			$allbj             = pdo_fetchall("SELECT sid,sname FROM " . tablename($this->table_classify) . " where weid = :weid AND schoolid = :schoolid And type = :type ORDER BY ssort DESC", array(':weid' => $weid, ':type' => 'theclass', ':schoolid' => $schoolid));
			$pindex    = max(1, intval($_GPC['page']));
			$psize     = 15;
			$condition = '';
			if(!empty($_GPC['keyword'])){
				$condition .= " AND s_name LIKE '%{$_GPC['keyword']}%'";
			}
			if(!empty($_GPC['bd_type'])){
				if($_GPC['bd_type'] == 1){
					$condition .= " AND (ouserid != 0 Or muserid != 0 Or duserid != 0 Or otheruserid != 0)";
				}
				if($_GPC['bd_type'] == 2){
					$condition .= " AND ouserid = 0 AND muserid = 0 AND duserid = 0 AND otheruserid = 0 ";
				}				
			}
			if(!empty($_GPC['nj_id'])){
				$condition .= " AND xq_id = '{$_GPC['nj_id']}'";
			}
			if(!empty($_GPC['s_type'])){
				$condition .= " AND s_type = '{$_GPC['s_type']}'";
			}
			if(!empty($_GPC['bj_id'])){
				$condition .= " AND bj_id = '{$_GPC['bj_id']}'";
			}
			$checkbjold = pdo_fetch("SELECT * FROM " . tablename($this->table_class) . " WHERE schoolid = :schoolid And type = :type ", array(':schoolid' => $schoolid,':type' => 2));			
			//////////导出数据/////////////////
			if($_GPC['out_putcode'] == 'out_putcode'){
				$lists = pdo_fetchall("SELECT s_name,code,mobile,numberid,bj_id FROM " . tablename($this->table_students) . " WHERE weid = '{$weid}' AND schoolid = '{$schoolid}' $condition ORDER BY id DESC");
				$ii   = 0;
				foreach($lists as $index => $row){
					$bj                = pdo_fetch("SELECT sname FROM " . tablename($this->table_classify) . " where sid = '{$row['bj_id']}'");
					$arr[$ii]['s_name'] = trim($row['s_name']);
					$arr[$ii]['code']  = $row['code'];
					$arr[$ii]['mobile']  = $row['mobile'];
					$arr[$ii]['numberid']  = $row['numberid'];
					$arr[$ii]['banji']  = $bj['sname'];
					$ii++;
				}
				$this->exportexcel($arr, array('学生', '绑定码', '报名预留手机号', '学号', '班级'), '学生绑定信息表');
				exit();
			}
            //////////导出学生头像/////////////////
            if($_GPC['out_studentImg'] == 'out_studentImg'){
                set_time_limit(0);
                ini_set('memory_limit', '512M');
                ob_end_clean();

                $lists = pdo_fetchall("SELECT id, numberid, s_name, bj_id, icon FROM " . tablename($this->table_students) . " WHERE weid = '{$weid}' AND schoolid = '{$schoolid}' ORDER BY icon DESC");
                $ii   = 0;
                $image = array(); //需要下载的图片数组信息
//                $excelFile = fopen("学生头像信息表.cvs", "w") or die("Unable to open file!");; //班级信息
                $txt = iconv("UTF-8", "GBK", "id, 学号, 姓名, 班级, 头像\n");
                foreach($lists as $index => $row){
                    $arr[$ii]['id'] = $row['id'];
                    $arr[$ii]['numberid'] = "'".$row['numberid'];//防止科学计数法
                    $bj                = pdo_fetch("SELECT sname FROM " . tablename($this->table_classify) . " where sid = '{$row['bj_id']}'");
                    $arr[$ii]['s_name'] = trim($row['s_name']);
                    $arr[$ii]['banji']  = $bj['sname'];
                    if(!empty($row['icon'])) {
                        $postfix = substr($row['icon'], strripos($row['icon'], "."));
                        $imangeName = iconv("UTF-8", "GBK", trim($row['s_name'])).$postfix;
                        $arr[$ii]['icon'] = $imangeName;
                        array_push($image, array('image_src' =>"http://qn.xingheoa.com/".$row['icon'], 'image_name' =>$imangeName));
                    }
                    else
                        $arr[$ii]['icon'] = "";
                    $ii++;
                }
//                $this->exportexcel($arr, array('id', '学号', '姓名', '班级', '头像'), '学生头像信息表');
                foreach ($arr as $key => $val) {
                    foreach ($val as $ck => $cv) {
                        $data[$key][$ck] = iconv("UTF-8", "GBK", $cv);
                    }
                    $data[$key] = implode(",", $data[$key]);

                }
                $txt = $txt.implode("\n", $data);

                //下面是实例操作过程：
                $dfile = tempnam('/tmp', 'tmp');//产生一个临时文件，用于缓存下载文件
                $zip = new zipfile();
                $zip->add_file($txt, "student_icon.csv");
                //----------------------
                $filename = 'image.zip'; //下载的默认文件名

                foreach($image as $v){
                    $zip->add_file(file_get_contents($v['image_src']), $v['image_name']);
                    // 添加打包的图片，第一个参数是图片内容，第二个参数是压缩包里面的显示的名称, 可包含路径
                    // 或是想打包整个目录 用 $zip->add_path($image_path);
                }
                //----------------------
                $zip->output($dfile);
                // 下载文件

                header('Pragma: public');
                header('Last-Modified:'.gmdate('D, d M Y H:i:s') . 'GMT');
                header('Cache-Control:no-store, no-cache, must-revalidate');
                header('Cache-Control:pre-check=0, post-check=0, max-age=0');
                header('Content-Transfer-Encoding:binary');
                header('Content-Encoding:none');
                header('Content-type:multipart/form-data');
                header('Content-Disposition:attachment; filename="'.$filename.'"'); //设置下载的默认文件名
                header('Content-length:'. filesize($dfile));
                $fp = fopen($dfile, 'r');
                while(connection_status() == 0 && $buf = @fread($fp, 8192)){
                    echo $buf;
                }
                fclose($fp);
                @unlink($dfile);
                @flush();
                @ob_flush();

                exit();
            }
			////////////////////////////////
            //////////导出学生信息/////////////////
            if($_GPC['out_studentMsg'] == 'out_studentMsg'){
                $lists = pdo_fetchall("SELECT id, numberid, s_name, xq_id, bj_id, mobile, s_type FROM " . tablename($this->table_students) . " WHERE weid = '{$weid}' AND schoolid = '{$schoolid}' order by bj_id");
                $ii   = 0;

                $txt = iconv("UTF-8", "GBK", "id, 学号, 姓名, 年级，班级, 手机, 类型，卡号\n");
                foreach($lists as $index => $row){
                    $arr[$ii]['id'] = $row['id'];
                    $arr[$ii]['numberid'] = "'".$row['numberid'];//防止科学计数法
                    $nj = pdo_fetch("SELECT sname FROM " . tablename($this->table_classify) . " where sid = '{$row['xq_id']}'");
                    $bj = pdo_fetch("SELECT sname FROM " . tablename($this->table_classify) . " where sid = '{$row['bj_id']}'");
                    $arr[$ii]['s_name'] = trim($row['s_name']);
                    $arr[$ii]['nanji'] = $nj['sname'];
                    $arr[$ii]['banji']  = $bj['sname'];
                    $arr[$ii]['mobile'] = $row['mobile'];
                    $arr[$ii]['s_type'] = $row['s_type'];
                    $cards = pdo_fetchall("SELECT idcard FROM " . tablename($this->table_idcard) . " where sid = '{$row['id']}'");
                    $cardlist="";
                    foreach ($cards as $k=>$v){
                        $cardlist += $v['idcard'] + ",";
                    }
                    $arr[$ii]['card'] = $cardlist;
                    $ii++;
                }
                $this->exportexcel($arr, array('id', '学号', '姓名', '年级', '班级', '手机', '类型', '卡号'), '学生信息表');

                exit();
            }
            ////////////////////////////////////////
			$category = pdo_fetchall("SELECT sid,sname FROM " . tablename($this->table_classify) . " WHERE weid = :weid AND schoolid = :schoolid ORDER BY sid ASC, ssort DESC", array(':weid' => $weid, ':schoolid' => $schoolid), 'sid');
			$list = pdo_fetchall("SELECT * FROM " . tablename($this->table_students) . " WHERE weid = '{$weid}' AND schoolid = '{$schoolid}' $condition ORDER BY id DESC LIMIT " . ($pindex - 1) * $psize . ',' . $psize);
			$listAfter = array();
			$ybdxs = 0;
			$chong = 0;
			foreach($list as $key => $value){
			
				if($value['ouid'] || $value['ouserid']){
					$ybdxs ++;
				}
				if($value['muid'] || $value['muserid']){
					$ybdxs ++;
				}
				if($value['duid'] || $value['duserid']){
					$ybdxs ++;
				}
				if($value['otheruid'] || $value['otheruserid']){
					$ybdxs ++;
				}	

				$member1 = array();
				$member2 = array();
				$member3 = array();
				$member4 = array();
				 


				$user1=  pdo_fetch("SELECT pard,openid FROM " . tablename($this->table_user) . " where  weid = :weid and  schoolid = :schoolid and sid = :sid and pard = :pard ", array(':pard' =>4, ':weid' => $weid, ':schoolid' => $schoolid,'sid'=>$value['id']));
				$fans_info1 = mc_fansinfo($user1['openid']);
				$member1['nickname'] = $fans_info1['nickname'];
				$member1['avatar']	 = $fans_info1['headimgurl'];
				
				$user2=  pdo_fetch("SELECT pard,openid FROM " . tablename($this->table_user) . " where  weid = :weid and  schoolid = :schoolid and sid = :sid and pard = :pard ", array(':pard' =>2, ':weid' => $weid, ':schoolid' => $schoolid,'sid'=>$value['id']));
				$fans_info2 = mc_fansinfo($user2['openid']);
				$member2['nickname'] = $fans_info2['nickname'];
				$member2['avatar']	 = $fans_info2['headimgurl'];
				
				$user3=  pdo_fetch("SELECT pard,openid FROM " . tablename($this->table_user) . " where  weid = :weid and  schoolid = :schoolid and sid = :sid and pard = :pard ", array(':pard' =>3, ':weid' => $weid, ':schoolid' => $schoolid,'sid'=>$value['id']));
				$fans_info3 = mc_fansinfo($user3['openid']);
				$member3['nickname'] = $fans_info3['nickname'];
				$member3['avatar']	 = $fans_info3['headimgurl'];
				
				$user4=  pdo_fetch("SELECT pard,openid FROM " . tablename($this->table_user) . " where  weid = :weid and  schoolid = :schoolid and sid = :sid and pard = :pard ", array(':pard' =>5, ':weid' => $weid, ':schoolid' => $schoolid,'sid'=>$value['id']));
				$fans_info4 = mc_fansinfo($user4['openid']);
				$member4['nickname'] = $fans_info4['nickname'];
				$member4['avatar']	 = $fans_info4['headimgurl'];
				$bj      = pdo_fetch("SELECT sname FROM " . tablename($this->table_classify) . " where sid = '{$row['bj_id']}'");
				$bmorder = pdo_fetchall("SELECT DISTINCT kcid FROM " . tablename($this->table_order) . " where sid = '{$value['id']}' AND type =1 and status = 2 ");
				$temporder = array();
				foreach( $bmorder as $key1 => $value1 )
				{
					$kc = pdo_fetch("SELECT name FROM " . tablename($this->table_tcourse) . " where id = '{$value1['kcid']}'");
					$buycourse = pdo_fetchcolumn("SELECT ksnum FROM " . tablename($this->table_coursebuy) . " WHERE sid = :sid AND kcid=:kcid and  schoolid =:schoolid", array(':sid' => $value['id'],':kcid'=> $value1['kcid'],':schoolid'=> $schoolid));
					$hasSign =  pdo_fetchcolumn("SELECT count(*) FROM " . tablename($this->table_kcsign) . " WHERE sid = :sid AND kcid=:kcid and  schoolid =:schoolid", array(':sid' =>  $value['id'],':kcid'=> $value1['kcid'],':schoolid'=> $schoolid));
					$rest = $buycourse - $hasSign; 
					$temporder[]= $kc['name']."【剩余".$rest."课时】";
				}
				$list[$key]['bmkc'] = $temporder;
				$list[$key]['onickname']     = $member1['nickname'];
				$list[$key]['oavatar']       = $member1['avatar'];
				$list[$key]['mnickname']     = $member2['nickname'];
				$list[$key]['mavatar']       = $member2['avatar'];
				$list[$key]['dnickname']     = $member3['nickname'];
				$list[$key]['davatar']       = $member3['avatar'];
				$list[$key]['othernickname'] = $member4['nickname'];
				$list[$key]['otheravatar']   = $member4['avatar'];				
				if($value['keyid'] != 0 ){
					$list[$key]['allbj'] = pdo_fetchall("SELECT bj_id,xq_id FROM " . tablename($this->table_students) . " where keyid = :keyid And schoolid = :schoolid  ORDER BY id ASC", array(':keyid' =>$value['keyid'], ':schoolid' => $schoolid));
				}
				if($value['qrcode_id']){
					$qrimg = pdo_fetch("SELECT id,show_url,expire,subnum,qrcid FROM " . tablename($this->table_qrinfo) . " where  id = '{$value['qrcode_id']}' ");
					$list[$key]['img_qr'] = tomedia($qrimg['show_url']);
					$list[$key]['qrcid'] = $qrimg['qrcid'];
					$list[$key]['subnum'] = $qrimg['subnum'];
					$list[$key]['overtime'] = true;
					if($qrimg['expire'] < time()){
						$list[$key]['overtime'] = false;
					}else{
						$list[$key]['restday'] = floor(($qrimg['expire'] - time())/86400);
					}
				}
			}
			if (empty($_GPC['bj_id']) && empty($_GPC['bd_type']) && empty($_GPC['nj_id'])){
				$to1 = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename($this->table_students) . " WHERE weid = '{$weid}' AND schoolid = '{$schoolid}' And keyid = 0 ");
				$to2 = pdo_fetchcolumn('SELECT COUNT(DISTINCT keyid) FROM ' . tablename($this->table_students) . " WHERE weid = '{$weid}' AND schoolid = '{$schoolid}' And keyid != 0 ");
				$totalsss = $to1 + $to2;
			}
			$total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename($this->table_students) . " WHERE weid = '{$weid}' AND schoolid = '{$schoolid}' $condition");
			$pager = pagination($total, $pindex, $psize);
			$starttime = mktime(0,0,0,date("m"),date("d"),date("Y"));
			$endtime = $starttime + 86399;
			$zrstarttime = $starttime - 86399;
			$conditions = " AND createtime > '{$starttime}' AND createtime < '{$endtime}'";
			$conditionss = " AND createtime > '{$zrstarttime}' AND createtime < '{$starttime}'";
			$jrbd  = pdo_fetchcolumn("select count(*) FROM ".tablename($this->table_user)." WHERE schoolid = '{$schoolid}' And weid = '{$weid}'  $conditions ");
			$zrbd  = pdo_fetchcolumn("select count(*) FROM ".tablename($this->table_user)." WHERE schoolid = '{$schoolid}' And tid = 0 $conditionss ");			
		}
		elseif($operation == 'delete'){
			$id  = intval($_GPC['id']);
			$row = pdo_fetch("SELECT * FROM " . tablename($this->table_students) . " WHERE id = :id", array(':id' => $id));

			if(empty($row)){
				$this->imessage('抱歉，学生不存在或是已经被删除！');
			}
			$sid_arr = pdo_fetchall("SELECT id FROM " . tablename($this->table_students) . " WHERE keyid = :keyid", array(':keyid' =>$id));
				
				if(!empty($sid_arr)){
					foreach($sid_arr as $key => $value)	{
						$rowloop = pdo_fetch("SELECT * FROM " . tablename($this->table_students) . " WHERE id = :id", array(':id' => $value['id']));
						if(!empty($rowloop))
						{
							pdo_delete($this->table_students, array('id' => $value['id'], 'schoolid' => $schoolid));
							
							DeleteStudent($value['id']);
							if(!empty($rowloop['otheruserid'])){
								pdo_delete($this->table_user, array('id' => $rowloop['otheruserid']));
							}else{
								pdo_delete($this->table_user, array('sid' => $value['id']));
							}
							if(!empty($rowloop['ouserid'])){
								pdo_delete($this->table_user, array('id' => $rowloop['ouserid']));
							}else{
								pdo_delete($this->table_user, array('sid' => $value['id']));
							}
							if(!empty($rowloop['muserid'])){
								pdo_delete($this->table_user, array('id' => $rowloop['muserid']));
							}else{
								pdo_delete($this->table_user, array('sid' => $value['id']));
							}
							if(!empty($rowloop['duserid'])){
								pdo_delete($this->table_user, array('id' => $rowloop['duserid']));
							}else{
								pdo_delete($this->table_user, array('sid' => $value['id']));
							}
						}
					}
				}else{
					pdo_delete($this->table_students, array('id' => $id, 'schoolid' => $schoolid));
					DeleteStudent($id);
					if(!empty($row['otheruserid'])){
						pdo_delete($this->table_user, array('id' => $row['otheruserid']));
					}else{
						pdo_delete($this->table_user, array('sid' => $id));
					}
					if(!empty($row['ouserid'])){
						pdo_delete($this->table_user, array('id' => $row['ouserid']));
					}else{
						pdo_delete($this->table_user, array('sid' => $id));
					}
					if(!empty($row['muserid'])){
						pdo_delete($this->table_user, array('id' => $row['muserid']));
					}else{
						pdo_delete($this->table_user, array('sid' => $id));
					}
					if(!empty($row['duserid'])){
						pdo_delete($this->table_user, array('id' => $row['duserid']));
					}else{
						pdo_delete($this->table_user, array('sid' => $id));
					}
				}
			if($row['qrcode_id']){
				pdo_delete($this->table_qrinfo, array('id' => $id));
			}
			$this->imessage('删除成功！', referer(), 'success');
		}elseif($operation == 'own'){
			$id     = intval($_GPC['id']);
			$openid = $_GPC['openid'];
			$row    = pdo_fetch("SELECT * FROM " . tablename($this->table_students) . " WHERE id = :id", array(':id' => $id));
			if($row['keyid'] != 0)
			{
				$sid_arr = pdo_fetchall("SELECT id FROM " . tablename($this->table_students) . " WHERE keyid = :keyid", array(':keyid' =>$id));
			}
			if(empty($row)){
					$this->imessage('抱歉，学生不存在或是已经被删除！');
					}
					$temp = array(
						'own'     => 0,
						'ouserid' => 0,
						'ouid'    => 0
					);
					if(!empty($row['ouserid'])){
						pdo_delete($this->table_user, array('id' => $row['ouserid']));
					}else{
						pdo_delete($this->table_user, array('sid' => $id, 'openid' => $openid, 'uid' => $row['ouid'], 'tid' => 0, 'pard' => 4));
					}
					pdo_update($this->table_students, $temp, array('id' => $id));
			if(!empty($sid_arr))
			{
				foreach( $sid_arr as $key => $value )
				{
					$rowloop    = pdo_fetch("SELECT * FROM " . tablename($this->table_students) . " WHERE id = :id", array(':id' => $value['id']));
					
					$temploop = array(
						'own'     => 0,
						'ouserid' => 0,
						'ouid'    => 0
					);
					if(!empty($rowloop['ouserid'])){
						pdo_delete($this->table_user, array('id' => $rowloop['ouserid']));
					}else{
						pdo_delete($this->table_user, array('sid' => $value['id'], 'openid' => $openid, 'uid' => $rowloop['ouid'], 'tid' => 0, 'pard' => 4));
					}
					pdo_update($this->table_students, $temploop, array('id' => $value['id']));
				}
			}
			$this->imessage('解绑成功！', referer(), 'success');
		}elseif($operation == 'mom'){
			$id     = intval($_GPC['id']);
			$openid = $_GPC['openid'];
			$row    = pdo_fetch("SELECT * FROM " . tablename($this->table_students) . " WHERE id = :id", array(':id' => $id));
			if($row['keyid'] != 0)
			{
				$sid_arr = pdo_fetchall("SELECT id FROM " . tablename($this->table_students) . " WHERE keyid = :keyid", array(':keyid' =>$id));
			}
			if(empty($row)){
				$this->imessage('抱歉，学生不存在或是已经被删除！');
			}
			$temp = array(
				'mom'     => 0,
				'muserid' => 0,
				'muid'    => 0
			);
			if(!empty($row['muserid'])){
				pdo_delete($this->table_user, array('id' => $row['muserid']));
			}else{
				pdo_delete($this->table_user, array('sid' => $id, 'openid' => $openid, 'uid' => $row['muid'], 'tid' => 0, 'pard' => 2));
			}
			pdo_update($this->table_students, $temp, array('id' => $id));
			if(!empty($sid_arr)) //多班级解绑
			{
				foreach( $sid_arr as $key => $value )
				{
					$rowloop    = pdo_fetch("SELECT * FROM " . tablename($this->table_students) . " WHERE id = :id", array(':id' => $value['id']));
					$temploop = array(
						'mom'     => 0,
						'muserid' => 0,
						'muid'    => 0
					);
					if(!empty($rowloop['muserid'])){
						pdo_delete($this->table_user, array('id' => $rowloop['muserid']));
					}else{
						pdo_delete($this->table_user, array('sid' => $value['id'], 'openid' => $openid, 'uid' => $rowloop['muid'], 'tid' => 0, 'pard' => 2));
					}
					pdo_update($this->table_students, $temploop, array('id' => $value['id']));
				}
			}
			$this->imessage('解绑成功！', referer(), 'success');
		}elseif($operation == 'fixavatar'){
				$frommembers   = pdo_fetchall("SELECT uid,avatar FROM " . tablename("mc_members")."where avatar LIKE '%/132132' ");
				
				foreach( $frommembers as $key => $value )
				{
					$temp_avatar = substr_replace($value['avatar'],"/132",-7);
					$data= array(
					'avatar' => $temp_avatar
					);
					pdo_update("mc_members", $data, array('uid' => $value['uid']));

				}
				$count = count($frommembers);
				$this->imessage('修复成功！', referer(), 'success');
				

			
		}elseif($operation == 'dad'){
			$id     = intval($_GPC['id']);
			$openid = $_GPC['openid'];
			$row    = pdo_fetch("SELECT * FROM " . tablename($this->table_students) . " WHERE id = :id", array(':id' => $id));
			if($row['keyid'] != 0)
			{
				$sid_arr = pdo_fetchall("SELECT id FROM " . tablename($this->table_students) . " WHERE keyid = :keyid", array(':keyid' =>$row['keyid']));
			}
		
			if(empty($row)){
				$this->imessage('抱歉，学生不存在或是已经被删除！');
			}
			$temp = array(
				'dad'     => 0,
				'duserid' => 0,
				'duid'    => 0
			);
			if(!empty($row['duserid'])){
				pdo_delete($this->table_user, array('id' => $row['duserid']));
			}else{
				pdo_delete($this->table_user, array('sid' => $id, 'openid' => $openid, 'uid' => $row['duid'], 'tid' => 0, 'pard' => 3));
			}
			pdo_update($this->table_students, $temp, array('id' => $id));
			if(!empty($sid_arr))
			{
				foreach( $sid_arr as $key => $value )
				{
					$rowloop    = pdo_fetch("SELECT * FROM " . tablename($this->table_students) . " WHERE id = :id", array(':id' => $value['id']));
					$temploop = array(
						'dad'     => 0,
						'duserid' => 0,
						'duid'    => 0
					);
					if(!empty($rowloop['duserid'])){
						pdo_delete($this->table_user, array('id' => $rowloop['duserid']));
						
					}else{
						pdo_delete($this->table_user, array('sid' =>  $value['id'], 'openid' => $openid, 'uid' => $rowloop['duid'], 'tid' => 0, 'pard' => 3));
						
					}
					pdo_update($this->table_students, $temploop, array('id' =>  $value['id']));
				}
			}
			
			$this->imessage('解绑成功！', referer(), 'success');
		}elseif($operation == 'other'){
			$id     = intval($_GPC['id']);
			$openid = $_GPC['openid'];
			$row    = pdo_fetch("SELECT * FROM " . tablename($this->table_students) . " WHERE id = :id", array(':id' => $id));
			if($row['keyid'] != 0)
			{
				$sid_arr = pdo_fetchall("SELECT id FROM " . tablename($this->table_students) . " WHERE keyid = :keyid", array(':keyid' =>$id)); 
			}
			if(empty($row)){
				$this->imessage('抱歉，学生不存在或是已经被删除！');
			}
			$temp = array(
				'other'       => 0,
				'otheruserid' => 0,
				'otheruid'    => 0
			);
			if(!empty($row['otheruserid'])){
				pdo_delete($this->table_user, array('id' => $row['otheruserid']));
			}else{
				pdo_delete($this->table_user, array('sid' => $id, 'openid' => $openid, 'uid' => $row['duid'], 'tid' => 0, 'pard' => 5));
			}
			pdo_update($this->table_students, $temp, array('id' => $id));
			if(!empty($sid_arr))
			{
				foreach( $sid_arr as $key => $value )
				{
					$rowloop    = pdo_fetch("SELECT * FROM " . tablename($this->table_students) . " WHERE id = :id", array(':id' => $value['id']));
					$temploop = array(
						'other'       => 0,
						'otheruserid' => 0,
						'otheruid'    => 0
					);
					if(!empty($rowloop['otheruserid'])){
						pdo_delete($this->table_user, array('id' => $rowloop['otheruserid']));
					}else{
						pdo_delete($this->table_user, array('sid' => $value['id'], 'openid' => $openid, 'uid' => $rowloop['duid'], 'tid' => 0, 'pard' => 5));
					}
					pdo_update($this->table_students, $temploop, array('id' => $value['id']));
				}
			}
			$this->imessage('解绑成功！', referer(), 'success');
		}elseif($operation == 'makecode'){
			$nocode = pdo_fetchall("SELECT id,code FROM " . tablename($this->table_students) . " WHERE schoolid = :schoolid ", array(':schoolid' => $schoolid));
			if($nocode){
				$notrowcount = 0;
				foreach($nocode as $k => $row){
					if(empty($row['code'])){
						$randStr = str_shuffle('123456789');
						$rand    = substr($randStr, 0, 6);
						$data = array(
							'code'     => $rand
						);					
						pdo_update($this->table_students, $data, array('id' => $row['id']));
						$notrowcount++;
					}
				}
				$this->imessage('操作成功,共为'.$notrowcount.'个学生生成了绑定码！', $this->createWebUrl('students', array('op' => 'display', 'schoolid' => $schoolid)), 'success');
			}else{
				$this->imessage('本校学生全部已生成绑定码，无需重复操作！', '', 'error');
			}
		}elseif($operation == 'makeallqr'){
			if(empty($logo['spic'])){
				$this->imessage('抱歉,本校开启了用户二维码功能,请设置校园默认学生头像');
			}			
			$notrowcount = 0;
			$gqeqrcount = 0;
			foreach($_GPC['idArr'] as $k => $id){
				load()->func('tpl');
				load()->func('file');
				$id = intval($id);
				$row = pdo_fetch("SELECT id,qrcode_id,keyid FROM " . tablename($this->table_students) . " WHERE id = '{$id}'");
				if($row['keyid'] == 0){
					if(!empty($row['qrcode_id'])){
						$qrinfo = pdo_fetch("SELECT id,expire,qrcid FROM " . tablename($this->table_qrinfo) . " WHERE weid = '{$weid}' And id = '{$row['qrcode_id']}' ");
						if(time() > $qrinfo['expire'] || $qrinfo['qrcid'] != $row['id']){
							$barcode = array(
								'expire_seconds' =>2592000 ,
								'action_name' => '',
								'action_info' => array(
												'scene' => array(
														'scene_id' => $row['id']
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
								$showurl = $this->createImageUrlCenterForUser("https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=" . $result['ticket'], $row ['id'], 0, $schoolid);
								$urlarr = explode('/',$showurl);
								$qrurls = "images/fm_jiaoyu/".$urlarr['4'];	
								$insert = array(
									'show_url' => $qrurls,
									'qrcid'   => $row['id'],
									'ticket' => $result['ticket'],
									'qr_url' => ltrim($result['url'],"http://weixin.qq.com/q/"),
									'expire' => $result['expire_seconds'] + time(), 
									'createtime' => time(),
								);
								pdo_update($this->table_qrinfo, $insert, array('id' =>$qrinfo ['id']));	
								$qrurl = pdo_fetch("SELECT show_url FROM " . tablename($this->table_qrinfo) . " WHERE id = '{$qrinfo ['id']}'");
								if (!empty($_W['setting']['remote']['type'])) {
									$remotestatus = file_remote_upload($qrurl['show_url']);
										if (is_error($remotestatus)) {
											message('远程附件上传失败，'.$qrurl['show_url'].'请检查配置并重新上传');
										}
								}
								$gqeqrcount++;
							}								
						}								
					}else{
						$barcode = array(
							'expire_seconds' =>2592000,
							'action_name' => '',
							'action_info' => array(
								'scene' => array(
									'scene_id' => $row['id']
								),
							),
						);
						$uniacccount = WeAccount::create($wwwweid);
						$barcode['action_name'] = 'QR_SCENE';
						$result = $uniacccount->barCodeCreateDisposable($barcode);
						if (is_error($result)) {
							message($result['message'], referer(), 'fail');
						}
						if (!is_error($result)) {
							$showurl = $this->createImageUrlCenterForUser("https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=" . $result['ticket'], $row['id'], 0, $schoolid);
							$urlarr = explode('/',$showurl);
							$qrurls = "images/fm_jiaoyu/".$urlarr['4'];	
							$insert = array(
								'weid' => $_W['uniacid'], 
								'schoolid' => $schoolid,
								'qrcid' => $row['id'], 
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
						pdo_update($this->table_students, array('qrcode_id' => $qrid), array('id' => $row['id']));
						$notrowcount++;
					}							
				}
				if($row['id'] == $row['keyid']){
					if(!empty($row['qrcode_id'])){
						$qrinfo = pdo_fetch("SELECT id,expire,qrcid FROM " . tablename($this->table_qrinfo) . " WHERE weid = '{$weid}' And id = '{$row['qrcode_id']}' ");
						if(time() > $qrinfo['expire'] || $qrinfo['qrcid'] != $row['id']){
							$barcode = array(
								'expire_seconds' =>2592000 ,
								'action_name' => '',
								'action_info' => array(
												'scene' => array(
														'scene_id' => $row['id']
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
								$showurl = $this->createImageUrlCenterForUser("https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=" . $result['ticket'], $row ['id'], 0, $schoolid);
								$urlarr = explode('/',$showurl);
								$qrurls = "images/fm_jiaoyu/".$urlarr['4'];	
								$insert = array(
									'show_url' => $qrurls,
									'qrcid' => $row['id'],
									'ticket' => $result['ticket'],
									'qr_url' => ltrim($result['url'],"http://weixin.qq.com/q/"),
									'expire' => $result['expire_seconds'] + time(), 
									'createtime' => time(),
								);
								pdo_update($this->table_qrinfo, $insert, array('id' =>$qrinfo ['id']));	
								$qrurl = pdo_fetch("SELECT show_url FROM " . tablename($this->table_qrinfo) . " WHERE id = '{$qrinfo ['id']}'");
								if (!empty($_W['setting']['remote']['type'])) {
									$remotestatus = file_remote_upload($qrurl['show_url']);
										if (is_error($remotestatus)) {
											message('远程附件上传失败，'.$qrurl['show_url'].'请检查配置并重新上传');
										}
								}
								$gqeqrcount++;
							}								
						}								
					}else{
						$barcode = array(
							'expire_seconds' =>2592000,
							'action_name' => '',
							'action_info' => array(
								'scene' => array(
									'scene_id' => $row['id']
								),
							),
						);
						$uniacccount = WeAccount::create($wwwweid);
						$barcode['action_name'] = 'QR_SCENE';
						$result = $uniacccount->barCodeCreateDisposable($barcode);
						if (is_error($result)) {
							message($result['message'], referer(), 'fail');
						}
						if (!is_error($result)) {
							$showurl = $this->createImageUrlCenterForUser("https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=" . $result['ticket'], $row['id'], 0, $schoolid);
							$urlarr = explode('/',$showurl);
							$qrurls = "images/fm_jiaoyu/".$urlarr['4'];	
							$insert = array(
								'weid' => $_W['uniacid'], 
								'schoolid' => $schoolid,
								'qrcid' => $row['id'], 
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
						pdo_update($this->table_students, array('qrcode_id' => $qrid), array('id' => $row['id']));
						$notrowcount++;
					}
				}			
			}
			$message = "操作成功,共为{$notrowcount}个学生生成了二维码,清理过期二维码并重新生成{$gqeqrcount}个！";
			$data ['result'] = true;
			$data ['msg'] = $message;				
			die (json_encode($data));			
		}elseif($operation == 'deleteall'){
			$rowcount    = 0;
			$notrowcount = 0;
			foreach($_GPC['idArr'] as $k => $id){
				$id = intval($id);
				if(!empty($id)){
					$goods = pdo_fetch("SELECT * FROM " . tablename($this->table_students) . " WHERE id = :id", array(':id' => $id));
					if(!empty($goods['mom'])){

						$message = '批量删除失败，学生' . $goods['s_name'] . '母亲微信未解绑！';

						die (json_encode(array(
							'result' => false,
							'msg'    => $message
						)));
					}
					if(!empty($goods['dad'])){

						$message = '批量删除失败，学生' . $goods['s_name'] . '父亲微信未解绑！';

						die (json_encode(array(
							'result' => false,
							'msg'    => $message
						)));
					}
					if(!empty($goods['own'])){

						$message = '批量删除失败，学生' . $goods['s_name'] . '本人微信未解绑！';

						die (json_encode(array(
							'result' => false,
							'msg'    => $message
						)));
					}
					if(!empty($goods['other'])){

						$message = '批量删除失败，学生' . $goods['s_name'] . '家长微信未解绑！';

						die (json_encode(array(
							'result' => false,
							'msg'    => $message
						)));
					}					
					if(empty($goods)){
						$notrowcount++;
						continue;
					}
					if($goods['qrcode_id']){
						pdo_delete($this->table_qrinfo, array('qrcode_id' => $goods['qrcode_id']));
					}
					$sid_arr = pdo_fetchall("SELECT id FROM " . tablename($this->table_students) . " WHERE keyid = :keyid", array(':keyid' =>$id));
					pdo_delete($this->table_students, array('id' => $id, 'schoolid' => $schoolid));
					pdo_delete($this->table_students, array('keyid' =>$id, 'schoolid' => $schoolid));
					if(!empty($sid_arr)){
						foreach($sid_arr as $key => $value)
						{
							DeleteStudent($value['id']);
						}
					} 
					$rowcount++;
				}
			}
			$message = "操作成功！共删除{$rowcount}条数据,{$notrowcount}条数据不能删除!";
			$data ['result'] = true;
			$data ['msg'] = $message;
			die (json_encode($data));
		}elseif($operation == 'add_bj'){  //批量增加班级
			$rowcount    = 0;
			$notrowcount = 0;
			$bj_id = intval($_GPC['bj_id']);
			$xueqi = pdo_fetch("SELECT parentid FROM " . tablename($this->table_classify) . " WHERE sid = :sid", array(':sid' => $bj_id));

				
			if(!empty($xueqi)){
				foreach($_GPC['idArr'] as $k => $id){
					$id = intval($id);
					if(!empty($id)){
						$goods = pdo_fetch("SELECT * FROM " . tablename($this->table_students) . " WHERE id = :id", array(':id' => $id));				
						if(empty($goods)){
							$notrowcount++;
							continue;
						}
						if($goods['keyid'] == 0 )
						{
							pdo_update($this->table_students, array('keyid'=>$id), array('id' => $id));
						}
						$userOld = 	pdo_fetchall("SELECT sid,tid,weid,schoolid,uid,openid,userinfo,pard,status,is_allowmsg,is_frist,createtime FROM " . tablename($this->table_user) . " WHERE sid = :sid", array(':sid' => $id));
						$stuOld =  pdo_fetch("SELECT * FROM " . tablename($this->table_students) . " WHERE id = :id", array(':id' => $id));				
						$allbj =  pdo_fetch("SELECT * FROM " . tablename($this->table_students) . " WHERE keyid = :keyid AND bj_id = :bj_id", array(':keyid' => $stuOld['keyid'],':bj_id'=>$bj_id));
						
						if($allbj )
						{
							
							$notrowcount++ ;
							
							
							continue;
						}
							
							
							
									
						array_splice($stuOld,0,1);
						$stuOld['bj_id'] = $bj_id;
						$stuOld['xq_id'] = $xueqi['parentid'];
						$stuOld['createdate'] = time(); //如果修改了与考勤相关的字段，则更新createdate
						pdo_insert($this->table_students,$stuOld);
						$newsid = pdo_insertid();
						foreach( $userOld as $key => $value )
						{
							$value['sid'] = $newsid;
							pdo_insert($this->table_user,$value);
						}
						$rowcount++;
					}
				}

				
				$data ['result'] = true;
				$message = "操作成功！共{$rowcount}个学生新增了班级,{$notrowcount}个学生不能新增!";
			}else{
				$data ['result'] = false;
				$message = "操作失败，你选择的班级无归属年级，请前往基本设置班级管理设置!";
			}
			$data ['msg'] = $message;
			die (json_encode($data));

		}elseif($operation == 'change_bj'){
			$rowcount    = 0;
			$notrowcount = 0;
			$bj_id = intval($_GPC['bj_id']);
			$xueqi = pdo_fetch("SELECT parentid FROM " . tablename($this->table_classify) . " WHERE sid = :sid", array(':sid' => $bj_id));	
			if(!empty($xueqi)){
				foreach($_GPC['idArr'] as $k => $id){
					$id = intval($id);
					if(!empty($id)){
						$checkcard = pdo_fetch("SELECT * FROM " . tablename($this->table_idcard) . " WHERE sid = :sid", array(':sid' => $id));
						if($checkcard){
							pdo_update($this->table_idcard, array('bj_id' => $bj_id), array('sid' => $id));
						}						
						$goods = pdo_fetch("SELECT id FROM " . tablename($this->table_students) . " WHERE id = :id", array(':id' => $id));					
						if(empty($goods)){
							$notrowcount++;
							continue;
						}
						pdo_update($this->table_students, array('bj_id' => $bj_id,'xq_id' => $xueqi['parentid'], 'createdate'=>time()), array('id' => $id));    //  如果修改了与考勤相关的字段，则更新createdate
						$rowcount++;
					}
				}
				$data ['result'] = true;
				$message = "操作成功！共转移{$rowcount}个学生,{$notrowcount}个学生不能转移!";
			}else{
				$data ['result'] = false;
				$message = "操作失败，你选择的班级无归属年级，请前往基本设置班级管理设置!";
			}
			$data ['msg'] = $message;
			die (json_encode($data));
		}elseif($operation == 'add'){
			load()->func('tpl');
			$id = intval($_GPC['id']);
			if(!empty($id)){
				$km                = pdo_fetchall("SELECT sid,sname FROM " . tablename($this->table_classify) . " where weid = :weid AND schoolid = :schoolid And type = :type ORDER BY ssort DESC", array(':weid' => $weid, ':type' => 'subject', ':schoolid' => $schoolid));
				$category = pdo_fetchall("SELECT sid,sname FROM " . tablename($this->table_classify) . " WHERE weid = :weid AND schoolid = :schoolid ORDER BY sid ASC, ssort DESC", array(':weid' => $weid, ':schoolid' => $schoolid), 'sid');
				$qh = get_myqh($id,$schoolid);
				$item = pdo_fetch("SELECT * FROM " . tablename($this->table_students) . " WHERE id = :id", array(':id' => $id));
				if(empty($item)){
					$this->imessage('抱歉，学生不存在或是已经删除！', '', 'error');
				}
			}
			if(checksubmit('submit')){
				$data = array(
					'weid'     => $weid,
					'schoolid' => $schoolid,
					'sid'      => intval($_GPC['id']),
					'km_id'    => trim($_GPC['km']),
					'bj_id'    => trim($_GPC['bj']),
					'qh_id'    => trim($_GPC['qh']),
					'xq_id'    => trim($_GPC['xueqi']),
					'my_score' => trim($_GPC['score']),
					'info'     => trim($_GPC['info']),
				);
				if(empty($data['km_id'])){
					$this->imessage('抱歉，请选择科目！', '', 'error');
				}
				if(empty($data['my_score'])){
					$this->imessage('抱歉，请录入分数成绩！', '', 'error');
				}				
				pdo_insert($this->table_score, $data);
				$this->imessage('录入成功，请勿重复录入！', $this->createWebUrl('students', array('op' => 'display', 'schoolid' => $schoolid)), 'success');
			}
		}elseif($operation == 'deleteallstudents'){
			pdo_delete($this->table_qrinfo, array('schoolid' => $schoolid, 'weid' => $weid, 'type' => 3));
			pdo_delete($this->table_students, array('schoolid' => $schoolid, 'weid' => $weid));
			pdo_delete($this->table_user, array('schoolid' => $schoolid, 'tid' => 0));
			$this->imessage('已全部删除本校学生！', $this->createWebUrl('students', array('op' => 'display', 'schoolid' => $schoolid)), 'success');
		}
		include $this->template('web/students');
?>