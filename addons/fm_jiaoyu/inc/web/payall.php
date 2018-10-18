<?php
/**
 * 微教育模块
 *
 * @author 高贵血迹
 */
        global $_GPC, $_W;
       
        $weid = $_W['uniacid'];
        $action = 'payall';
		$this1 = 'no4';
		$GLOBALS['frames'] = $this->getNaveMenu($_GPC['schoolid'],$action);
	    $schoolid = intval($_GPC['schoolid']);
		$logo = pdo_fetch("SELECT logo,title FROM " . tablename($this->table_index) . " WHERE id = '{$schoolid}'");
		$school = pdo_fetch("SELECT * FROM " . tablename($this->table_index) . " where id = :id ", array(':id' => $schoolid));
						
        $operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
        $tid_global = $_W['tid'];
        if (!(IsHasQx($tid_global,1002101,1,$schoolid))){
			$this->imessage('非法访问，您无权操作该页面','','error');	
		}
        if ($operation == 'post') {
            load()->func('tpl');
            $id = intval($_GPC['id']);
            if (!empty($id)) {
                $item = pdo_fetch("SELECT * FROM " . tablename($this->table_order) . " WHERE id = :id ", array(':id' => $id));
                if (empty($item)) {   
                    $this->imessage('抱歉，本条信息不存在在或是已经删除！', '', 'error');
                }
            }
        } elseif ($operation == 'display') {
			$allkc = pdo_fetchall("SELECT id,name FROM " . tablename($this->table_tcourse) . " WHERE weid = :weid And schoolid = :schoolid ", array(
					':weid' => $weid,
					':schoolid' => $schoolid
					));
			$allob = pdo_fetchall("SELECT id,name FROM " . tablename($this->table_cost) . " WHERE weid = :weid And schoolid = :schoolid ", array(
					':weid' => $weid,
					':schoolid' => $schoolid
					));
			$allvod = pdo_fetchall("SELECT id,name FROM " . tablename($this->table_allcamera) . " WHERE weid = :weid And schoolid = :schoolid And is_pay = :is_pay", array(
					':weid' => $weid,
					':schoolid' => $schoolid,
					':is_pay' => 1
					));					
            $pindex = max(1, intval($_GPC['page']));
            $psize = 15;
            $condition = '';
            if (!empty($_GPC['number'])) {
                $condition .= " AND id = '{$_GPC['number']}'";
            }
            if (!empty($_GPC['uniontid'])) {
                $condition .= " AND uniontid = '{$_GPC['uniontid']}'";
            }			
			if ($_GPC['type'] ==1) {
				$type = intval($_GPC['type']);
				$condition .= " AND type = '{$type}' ";
			}
			if ($_GPC['type'] ==2) {
				$type = intval($_GPC['type']);
				$condition .= " AND type = '{$type}' ";
			}
			if ($_GPC['type'] ==3) {
				$type = intval($_GPC['type']);
				$condition .= " AND type = '{$type}' ";
			}
			if ($_GPC['type'] ==4) {
				$type = intval($_GPC['type']);
				$condition .= " AND type = '{$type}' ";
			}
			if ($_GPC['type'] ==5) {
				$type = intval($_GPC['type']);
				$condition .= " AND type = '{$type}' ";
			}
			if ($_GPC['type'] ==6) {
				$type = intval($_GPC['type']);
				$condition .= " AND type = '{$type}' ";
			}			
			if ($_GPC['paytype'] ==1) {
				$paytype = intval($_GPC['paytype']);
				$condition .= " AND paytype = '{$paytype}' ";
			}
			if ($_GPC['paytype'] ==2) {
				$paytype = intval($_GPC['paytype']);
				$condition .= " AND paytype = '{$paytype}' ";
			}									
            if (!empty($_GPC['obid'])) {
                $obid = intval($_GPC['obid']);
                $condition .= " AND costid = '{$obid}'";
            }
            if (!empty($_GPC['kcid'])) {
                $condition .= " AND kcid = '{$_GPC['kcid']}'";
            }
            if (!empty($_GPC['vodid'])) {
                $condition .= " AND vodid = '{$_GPC['vodid']}'";
            }			
            if (!empty($_GPC['costid'])) {
                $condition .= " AND costid = '{$_GPC['costid']}'";
            }			
			$is_pay = isset($_GPC['is_pay']) ? intval($_GPC['is_pay']) : -1;
			if($is_pay >= 0) {
				$condition .= " AND status = '{$is_pay}'";
				$params[':is_pay'] = $is_pay;
			}			
			if(!empty($_GPC['createtime'])) {
				$starttime = strtotime($_GPC['createtime']['start']);
				$endtime = strtotime($_GPC['createtime']['end']) + 86399;
				$condition .= " AND createtime > '{$starttime}' AND createtime < '{$endtime}'";
			} else {
				$starttime = strtotime('-600 day');
				$endtime = TIMESTAMP;
			}
            if (!empty($_GPC['keyword'])) {
				$stuid = '';
				$students = pdo_fetchall("SELECT id FROM " . tablename($this->table_students) . " WHERE schoolid = :schoolid And s_name = :s_name ", array(':schoolid' => $schoolid,':s_name' => trim($_GPC['keyword'])));
				
				$numofstudent = count($students);
				if($numofstudent == 1 && !empty($students) ){
					$stuid = $students[0]['id'];
					 $condition_t = " AND sid = '{$stuid}'";
				}elseif($numofstudent > 1){
					$temp = '';
					for( $i=0;$i<$numofstudent;$i++ )
					{
						$temp .="{$students[$i]['id']}";
						if($i != $numofstudent -1 ){
							$temp .=',';
						}
					}
					$condition_t = " AND sid in ({$temp})";
					
				}
				
				if(!empty($students))
				{
					$condition .= $condition_t;
				}elseif(empty($students))
				{
					$tea = pdo_fetch("SELECT id FROM " . tablename($this->table_teachers) . " WHERE schoolid = :schoolid And tname = :tname ", array(':schoolid' => $schoolid,':tname' => $_GPC['keyword']));
					$teaUser = pdo_fetch("SELECT id FROM " . tablename($this->table_user) . " WHERE schoolid = :schoolid And tid = :tid ", array(':schoolid' => $schoolid,':tid' => $tea['id']));
					if(!empty($tea))
					{
						 $condition .= " AND userid = '{$teaUser['id']}'";
					}
				}
               
            }	
            
			$params[':start'] = $starttime;
			$params[':end'] = $endtime;
            $list = pdo_fetchall("SELECT * FROM " . tablename($this->table_order) . " WHERE weid = '{$weid}' AND schoolid = '{$schoolid}' $condition ORDER BY paytime DESC LIMIT " . ($pindex - 1) * $psize . ',' . $psize);
				foreach($list as $index => $row){
							$kc = pdo_fetch("SELECT * FROM " . tablename($this->table_tcourse) . " WHERE id = :id ", array(':id' => $row['kcid']));
							$student = pdo_fetch("SELECT s_name,bj_id FROM " . tablename($this->table_students) . " WHERE id = :id ", array(':id' => $row['sid']));
							$bjinfo = pdo_fetch("SELECT sname FROM " . tablename($this->table_classify) . " WHERE sid = :sid ", array(':sid' => $student['bj_id']));
							$user = pdo_fetch("SELECT userinfo,pard,tid,sid FROM " . tablename($this->table_user) . " WHERE id = :id ", array(':id' => $row['userid']));
							$ob = pdo_fetch("SELECT name FROM " . tablename($this->table_cost) . " WHERE id = :id ", array(':id' => $row['costid']));
							$signup = pdo_fetch("SELECT name,pard,mobile FROM " . tablename($this->table_signup) . " WHERE orderid = :orderid ", array(':orderid' => $row['id']));
							if($row['pay_type'] != 'wxapp'){
								$payweid = pdo_fetch("SELECT name FROM " . tablename('account_wechats') . " where uniacid = :uniacid ", array(':uniacid' => $row['payweid']));
							}else{
								$payweid = pdo_fetch("SELECT name FROM " . tablename('account_wxapp') . " where uniacid = :uniacid ", array(':uniacid' => $row['payweid']));
							}
							$list[$index]['kcname'] = $kc['name'];
							$list[$index]['s_name'] = $student['s_name'];
							if(!empty($user)){
								$list[$index]['userinfo'] = $user['userinfo'];
							}else{
								if($list[$index]['tid'] == -1) {
									$list[$index]['who'] = "管理员";
								}elseif($list[$index]['tid'] != -1){
									if($list[$index]['tid'] =='founder'){
										$list[$index]['who'] = '站长';
									}elseif($list[$index]['tid'] =='owner'){
										$list[$index]['who'] = '主管理员';
									}else{
										$list[$index]['who'] = pdo_fetch("SELECT tname FROM " . tablename($this->table_teachers) . " WHERE schoolid = :schoolid And id = :id ", array(':schoolid' => $schoolid,':id' => $list[$index]['tid']))['tname'];
									}
								}
								
							}
							if($list[$index]['type'] == 6 ){
								if(!empty($user['tid']) && empty($user['sid'])){
									$teacher = pdo_fetch("SELECT * FROM " . tablename($this->table_teachers) . " WHERE id = :id And weid = :weid And schoolid = :schoolid", array(':id' => $user['tid'],':weid' => $weid,':schoolid' => $schoolid));
									if(!empty($teacher)){
								 		$list[$index]['t_name'] = $teacher['tname'];
								  		$list[$index]['s_name'] = $teacher['tname'];
								  		$list[$index]['t_phone'] = $teacher['mobile'];
								  		$list[$index]['bjname'] = '教师';
									}
								}else{
									$students = pdo_fetch("SELECT s_name ,bj_id FROM " . tablename($this->table_students) . " WHERE id = :id And weid = :weid And schoolid = :schoolid", array(':id' => $user['sid'],':weid' => $weid,':schoolid' => $schoolid));
									if(!empty($students)){
								  		$list[$index]['s_name'] = $students['s_name'];
								  		$bjinfos = pdo_fetch("SELECT sname FROM " . tablename($this->table_classify) . " WHERE sid = :sid ", array(':sid' => $students['bj_id']));
								  		$list[$index]['bjname'] = $bjinfos['sname'];
									}
								}
							}
							if($list[$index]['type'] == 7 ){
								$vod = pdo_fetch("SELECT name FROM " . tablename($this->table_allcamera) . " WHERE id = :id ", array(':id' => $row['vodid']));
								$list[$index]['vodname'] = $vod['name'];
							}
							if($list[$index]['type'] == 8 ){
								$taocan = pdo_fetch("SELECT chongzhi FROM " . tablename($this->table_chongzhi) . " WHERE id = :id ", array(':id' => $row['taocanid']));
								$list[$index]['chongzhi'] = $taocan['chongzhi'];
							}
							$list[$index]['pard'] = $user['pard'];
							$list[$index]['obname'] = $ob['name'];
							$list[$index]['signname'] = $signup['name'];
							$list[$index]['signpard'] = $signup['pard'];
							$list[$index]['signmob'] = $signup['mobile'];
							if($row['type'] != 6 )
							{
								
								$list[$index]['bjname'] = $bjinfo['sname'];
							}
							
							$list[$index]['payweidname'] = $payweid['name'];
				}
            $total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename($this->table_order) . " WHERE weid = '{$weid}' AND schoolid = '{$schoolid}' $condition");

            $pager = pagination($total, $pindex, $psize);			
			//////////导出数据/////////////////
			if ($_GPC['out_put'] == 'output') {
				$list = pdo_fetchall("SELECT * FROM " . tablename($this->table_order) . " WHERE weid = '{$weid}' AND schoolid ={$schoolid} $condition ORDER BY id DESC");
                $ii = 0;
               foreach($list as $index => $row){
							$kc = pdo_fetch("SELECT * FROM " . tablename($this->table_tcourse) . " WHERE id = :id ", array(':id' => $row['kcid']));
							$student = pdo_fetch("SELECT s_name,bj_id,numberid FROM " . tablename($this->table_students) . " WHERE id = :id ", array(':id' => $row['sid']));
							$bjinfo = pdo_fetch("SELECT sname FROM " . tablename($this->table_classify) . " WHERE sid = :sid ", array(':sid' => $student['bj_id']));
							$user = pdo_fetch("SELECT userinfo,pard FROM " . tablename($this->table_user) . " WHERE id = :id ", array(':id' => $row['userid']));
							$ob = pdo_fetch("SELECT name FROM " . tablename($this->table_cost) . " WHERE id = :id ", array(':id' => $row['costid']));
							$signup = pdo_fetch("SELECT * FROM " . tablename($this->table_signup) . " WHERE orderid = :orderid ", array(':orderid' => $row['id']));
							if($list[$index]['type'] == 7 ){
								$vod = pdo_fetch("SELECT name FROM " . tablename($this->table_allcamera) . " WHERE id = :id ", array(':id' => $row['vodid']));
								$list[$index]['vodname'] = $vod['name'];
							}							
							$arr[$ii]['id'] = $row['id'];
							if($row['type']==4){
								$kcname = '报名费';
							}else if($row['type']==5){
								$kcname = '考勤卡费';
							}else if($row['type']==7){
								$vod = pdo_fetch("SELECT name FROM " . tablename($this->table_allcamera) . " WHERE id = :id ", array(':id' => $row['vodid']));						
								$kcname = $vod['name'];
							}else{
								$kcname = $ob['name'].$kc['name'];
							}
							$arr[$ii]['project'] = $kcname;
							$arr[$ii]['student'] = ($row['type']!=4)?$student['s_name']:$signup['name'];
							$arr[$ii]['xuehao'] = !empty($student['numberid'])? $student['numberid']:'未填写';
							$arr[$ii]['classname'] = $bjinfo['sname'];
							$myuser = iunserializer($user['userinfo']);
							if(is_array($myuser)){
								$arr[$ii]['signpard'] = !empty($myuser['name'])? $myuser['name']:'未填写';
								$arr[$ii]['mobile'] = !empty($myuser['mobile'])? $myuser['mobile']:'未填写';
							}else{
								$arr[$ii]['signpard'] = !empty($myuser['name'])? $myuser['name']:'未填写';
								$arr[$ii]['mobile'] = !empty($myuser['mobile'])? $myuser['mobile']:'未填写';								
							}
							$arr[$ii]['paytime'] = date('Y年m月d日 h:i:sa',$row['paytime']);
							$arr[$ii]['cose'] = $row['cose'];
							if($row['status']=='1'){
								$status = '未支付';
							}
							else if($row['status']=='2'){
								$status = '已支付';
							}
							else if($row['status']=='3'){
								$status = '已退款';
							}
							$arr[$ii]['status'] = $status;
							if($row['pay_type']=='wechat'){
								$pay_type = '微信支付';
							}
							else if($row['pay_type']=='alipay'){
								$pay_type = '支付宝';
							}
							else if($row['pay_type']=='baifubao'){
								$pay_type = '百付宝';
							}
							else if($row['pay_type']=='unionpay'){
								$pay_type = '银联';
							}
							else if($row['pay_type']=='cash'){
								$pay_type = '现金支付';
							}
							else if($row['pay_type']=='credit'){
								$pay_type = '余额支付';
							}
							$arr[$ii]['pay_type'] = $pay_type;
							if($row['paytype']=='1'){
								$paytype = '在线支付';
							}
							else if($row['paytype']=='2'){
								$paytype = '现金支付';
							}
							$arr[$ii]['paytype'] = $paytype;
							if ($_W['isfounder'] || $_W['role'] == 'owner'){
								$payweid = pdo_fetch("SELECT name FROM " . tablename('account_wechats') . " where uniacid = :uniacid ", array(':uniacid' => $row['payweid']));
								$arr[$ii]['payacuont'] = $payweid['name'];
							}
							$ii++;
				}
				//echo "<pre>";print_r($arr);exit;
				if ($_W['isfounder'] || $_W['role'] == 'owner'){
					$this->exportexcel($arr, array('订单号','项目名','学生','学号','班级','缴费人','手机号','付费时间','金额','支付状态','支付方式','支付类型','收款公众号'), time());
				}else{
					$this->exportexcel($arr, array('订单号','项目名','学生','学号','班级','缴费人','手机号','付费时间','金额','支付状态','支付方式','支付类型'), time());
				}
                exit();
            }
			////////////////////////////////			

        } elseif ($operation == 'tuifei') {
            $id = intval($_GPC['id']);
            if (empty($id)) {
                $this->imessage('抱歉，本条信息不存在在或是已经被删除！');
            }
			$data = array('status' => 3); 
            pdo_update($this->table_order, $data, array('id' => $id));
            $this->imessage('操作成功！', referer(), 'success');
        } elseif ($operation == 'pay') {
            $id = intval($_GPC['id']);
            if (empty($id)){
                $this->imessage('抱歉，本条信息不存在在或是已经被删除！');
            }
			$data = array('status' => 2,'paytime' => time(),'paytype' => 2,'pay_type' => 'cash'); 
            pdo_update($this->table_order, $data, array('id' => $id));
            $temporder = pdo_fetch("SELECT * FROM " . tablename($this->table_order) . " WHERE weid = '{$weid}' AND schoolid ={$schoolid} And id = {$id}");
            if(!empty($temporder['morderid']))
            {
	            $Morder = pdo_fetch("SELECT * FROM " . tablename($this->table_mallorder) . " WHERE weid = '{$weid}' AND schoolid ={$schoolid} And id = {$temporder['morderid']}");
	             $Mdata = array('status' => 2);
             	if(!empty($Morder['tid']) && empty($Morder['sid'])){
					$teacher = pdo_fetch("SELECT point FROM " . tablename($this->table_teachers) . " where id = :id ", array(':id' => $Morder['tid']));
					if($teacher['point'] == $Morder['allpoint']){
						$new_point = 0 ;
					}elseif($teacher['point'] > $Morder['allpoint']){
						$new_point = intval($teacher['point']) - intval($Morder['allpoint']);
						pdo_update($this->table_teachers, array('point' => $new_point ), array('id' => $Morder['tid']));
					}elseif($teacher['point'] < $Morder['allpoint']){
						$this->imessage('抱歉，该教师剩余积分不足！');
					}
				}elseif(empty($Morder['tid'] ) && !empty($Morder['sid'])){
					$JFinfo =  pdo_fetch("SELECT Is_point,Cost2Point FROM " . tablename($this->table_index) . " WHERE :schoolid = id AND weid=:weid ", array(':schoolid' => $temporder['schoolid'],':weid'=>$temporder['weid'] ));
					if($JFinfo['Is_point'] ==1){
						$students = pdo_fetch("SELECT * FROM " . tablename($this->table_students) . " where id = :id ", array(':id' => $Morder['sid']));
						$money = $temporder['cose'];
						$Cost2Point = $JFinfo['Cost2Point'];
						$addpoint = intval($money * $Cost2Point);
						if($students['points'] == $Morder['allpoint']){
							$new_point = 0 + $addpoint;
						}elseif($students['points'] > $Morder['allpoint']){
							$new_point = intval($students['points']) - intval($Morder['allpoint']) + $addpoint;
							pdo_update($this->table_students, array('points' => $new_point ), array('id' => $Morder['sid']));
						}elseif($students['points'] < $Morder['allpoint']){
							$this->imessage('抱歉，该学生师剩余积分不足！');
						}
					}

				}
	            if(!empty($Morder))
	            {
		            pdo_update($this->table_mallorder, $Mdata, array('id' => $Morder['id']));
	            }
	        }
	        if($temporder['type'] == 1){
		        	if($temporder['tempsid'] != 0){
					$tempstu = pdo_fetch("SELECT * FROM " . tablename($this->table_tempstudent) . " where :id = id", array(':id' => $temporder['tempsid']));
					$randStr = str_shuffle('123456789');
       				$rand = substr($randStr,0,6);	
					$tempstudata = array(
						'schoolid' => $tempstu['schoolid'],
						'bj_id'=> $tempstu['bj_id'],
						'sex' => $tempstu['sex'],
						'createdate'=> time(),
						'seffectivetime' => time(),
						'code' => $rand,
						's_name' => $tempstu['sname'],
						'mobile'=> $tempstu['mobile'],
						'area_addr'=> $tempstu['adde'],
						'weid' => $tempstu['weid'],
					);
					pdo_insert($this->table_students,$tempstudata);
					$sid = pdo_insertid();
					pdo_update($this->table_students,array('keyid'=> $sid),array('id'=>$sid));
					$userinsert = array(
						'sid' => $sid,
						'weid' => $tempstu['weid'],
						'schoolid' => $tempstu['schoolid'],
						'uid' => $tempstu['uid'],
						'openid' => $tempstu['openid'],
						'pard' => $tempstu['pard'],
					);
					pdo_insert($this->table_user,$userinsert);
					$userid_tostu = pdo_insertid();
					$into_stu = array();
					if($tempstu['pard'] == 2){
						$into_stu['mom'] = $tempstu['openid'];
						$into_stu['muserid'] = $userid_tostu;
						$into_stu['muid'] = $tempstu['uid']; 
					}
					if($tempstu['pard'] == 3){
						$into_stu['dad'] = $tempstu['openid'];
						$into_stu['duserid'] = $userid_tostu;
						$into_stu['duid'] = $tempstu['uid']; 
					}
					if($tempstu['pard'] == 4){
						$into_stu['own'] = $tempstu['openid'];
						$into_stu['ouserid'] = $userid_tostu;
						$into_stu['ouid'] = $tempstu['uid']; 
					}
					if($tempstu['pard'] == 5){
						$into_stu['other'] = $tempstu['openid'];
						$into_stu['otheruserid'] = $userid_tostu;
						$into_stu['otheruid'] = $tempstu['uid']; 
					}
					pdo_update($this->table_students,$into_stu,array('id'=>$sid));
					$into_order = array(
						'userid' => $userid_tostu,
						'sid' => $sid
					);
					pdo_update($this->table_order,$into_order,array('id'=>$temporder['id']));
					$temporder = pdo_fetch("SELECT * FROM " . tablename($this->table_order) . " where id = :id ", array(':id' =>$temporder['id']));
				}
				if(!empty($temporder['ksnum'])){
					$kcinfo =  pdo_fetch("SELECT * FROM " . tablename($this->table_tcourse) . " where :id = id", array(':id' => $temporder['kcid']));
					$userinfo = pdo_fetch("SELECT sid FROM " . tablename($this->table_user) . " where :id = id", array(':id' => $temporder['userid']));
					$ygks = pdo_fetch("SELECT ksnum,id FROM " . tablename($this->table_coursebuy) . " where kcid=:kcid AND :sid = sid", array(':kcid' => $temporder['kcid'],':sid'=>$userinfo['sid']));
					if(!empty($ygks)){
						$newksnum = $ygks['ksnum'] + $temporder['ksnum'];
						$data_coursebuy = array(
							'ksnum'      => $newksnum,
						);
						pdo_update($this->table_coursebuy,$data_coursebuy,array('id' => $ygks['id']));
					}elseif(empty($ygks)){
							$userinfo = pdo_fetch("SELECT sid FROM " . tablename($this->table_user) . " where :id = id", array(':id' => $temporder['userid']));
						$data_coursebuy = array(
							'weid'       => $temporder['weid'],
							'schoolid'   => $temporder['schoolid'],
							'userid'     => $temporder['userid'],
							'sid'        => $userinfo['sid'],
							'kcid'       => $temporder['kcid'],
							'ksnum'      => $kcinfo['FirstNum'],
							'createtime' => time()
						);
						pdo_insert($this->table_coursebuy,$data_coursebuy);
					}
	        	}
       		}elseif($temporder['type'] == 8){
				$sid = $temporder['sid'];
				$students = pdo_fetch("SELECT chongzhi FROM " . tablename($this->table_students) . " where :id = id", array(':id' =>$sid));
				$taocan = pdo_fetch("SELECT chongzhi FROM " . tablename($this->table_chongzhi) . " where :id = id", array(':id' =>$temporder['taocanid']));
				$new = $students['chongzhi'] + $taocan['chongzhi'];
				pdo_update($this->table_students,array('chongzhi'=>$new),array('id'=>$sid));
			}
       		
            $this->imessage('操作成功！', referer(), 'success');
        } elseif ($operation == 'unpay') {
            $id = intval($_GPC['id']);
            if (empty($id)) {
                $this->imessage('抱歉，本条信息不存在在或是已经被删除！');
            }
			$data = array('status' => 1,'paytime' => '','paytype' => 3,'pay_type' => 'no'); 
            pdo_update($this->table_order, $data, array('id' => $id));
    		pdo_delete(core_paylog,array('tid' => $id));
             $temporder = pdo_fetch("SELECT * FROM " . tablename($this->table_order) . " WHERE weid = '{$weid}' AND schoolid ={$schoolid} And id = {$id}");
            $Morder = pdo_fetch("SELECT * FROM " . tablename($this->table_mallorder) . " WHERE weid = '{$weid}' AND schoolid ={$schoolid} And id = {$temporder['morderid']}");
            $Mdata = array('status' => 1);
             if(!empty($Morder))
            {
	             pdo_update($this->table_mallorder, $Mdata, array('id' => $Morder['id']));
            }
            $this->imessage('操作成功！', referer(), 'success');
        } elseif ($operation == 'delete') {
            $id = intval($_GPC['id']);
            if (empty($id)) {
                $this->imessage('抱歉，本条信息不存在在或是已经被删除！');
            }
            $temporder = pdo_fetch("SELECT * FROM " . tablename($this->table_order) . " WHERE weid = '{$weid}' AND schoolid ={$schoolid} And id = {$id}");
            if(!empty($temporder['morderid']))
            {
	            pdo_delete($this->table_mallorder, array('id' => $temporder['morderid']));
            }
            if(!empty($temporder['ksnum']) &&$temporder['status'] == 2){
	            $kcinfo =  pdo_fetch("SELECT * FROM " . tablename($this->table_tcourse) . " where :id = id", array(':id' => $temporder['kcid']));
				$userinfo = pdo_fetch("SELECT sid FROM " . tablename($this->table_user) . " where :id = id", array(':id' => $temporder['userid']));
				$ygks = pdo_fetch("SELECT ksnum,id FROM " . tablename($this->table_coursebuy) . " where kcid=:kcid AND :sid = sid", array(':kcid' => $temporder['kcid'],':sid'=>$userinfo['sid']));
				$newksnum = $ygks['ksnum'] - $temporder['ksnum'];
				if($newksnum != 0){
						$data_coursebuy = array(
							'ksnum'      => $newksnum,
						);
						pdo_update($this->table_coursebuy,$data_coursebuy,array('id' => $ygks['id']));
					}elseif($newksnum == 0){
						pdo_delete($this->table_coursebuy,array('id' => $ygks['id']));
					}
            }

            pdo_delete($this->table_order, array('id' => $id));
            pdo_delete(core_paylog,array('tid' => $id));
            $this->imessage('操作成功！', referer(), 'success');
        } elseif ($operation == 'payallorder') {
            $rowcount = 0;
            $notrowcount = 0;
            foreach ($_GPC['idArr'] as $k => $id) {
                $id = intval($id);
                if (!empty($id)) {
                    $goods = pdo_fetch("SELECT * FROM " . tablename($this->table_order) . " WHERE id = :id", array(':id' => $id));
                    if (empty($goods)) {
                        $notrowcount++;
                        continue;
                    }
					$data = array('status' => 2,'paytime' => time(),'paytype' => 2,'pay_type' => 'cash');
                    pdo_update($this->table_order, $data, array('id' => $id));
                    if(!empty($goods['morderid'])){
	                    $Mdata= array('status' => 2 );
	                    pdo_update($this->table_mallorder, $Mdata, array('id' => $goods['morderid']));
                    }
                    $rowcount++;
                }
            }
            message("操作成功！");
        } elseif ($operation == 'deleteall') {
            $rowcount = 0;
            $notrowcount = 0;
            foreach ($_GPC['idArr'] as $k => $id) {
                $id = intval($id);
                if (!empty($id)) {
                    $goods = pdo_fetch("SELECT * FROM " . tablename($this->table_order) . " WHERE id = :id", array(':id' => $id));
                    if (empty($goods)) {
                        $notrowcount++;
                        continue;
                    }
                    pdo_delete($this->table_order, array('id' => $id));
                    pdo_delete(core_paylog,array('tid' => $id));
                    if(!empty($goods['morderid'])){
	                    pdo_delete($this->table_mallorder, array('id' => $goods['morderid']));
                    }
                    $rowcount++;
                }
            }
			$message = "操作成功！共删除{$rowcount}条数据,{$notrowcount}条数据不能删除!";

			$data ['result'] = true;

			$data ['msg'] = $message;

			die (json_encode($data));
        }	
        include $this->template ( 'web/payall' );
?>