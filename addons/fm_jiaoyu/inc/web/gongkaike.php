<?php
/**
 * 微教育模块
 *
 * @author 高贵血迹
 */
        global $_GPC, $_W;
       include 'phpqrcode.php';  
        $weid = $_W['uniacid'];
        $action = 'kecheng';
		$this1 = 'no2';
		
		$GLOBALS['frames'] = $this->getNaveMenu($_GPC['schoolid'],$action);
	    $schoolid = intval($_GPC['schoolid']);
		$logo = pdo_fetch("SELECT logo,title FROM " . tablename($this->table_index) . " WHERE id = '{$schoolid}'");
		$school = pdo_fetch("SELECT * FROM " . tablename($this->table_index) . " where id = :id ", array(':id' => $schoolid));
		$it = pdo_fetch("SELECT * FROM " . tablename($this->table_classify) . " WHERE sid = :sid", array(':sid' => $sid));
		$xueqi = pdo_fetchall("SELECT sid,sname FROM " . tablename($this->table_classify) . " where weid = :weid AND schoolid = :schoolid And type = :type ORDER BY ssort DESC", array(':weid' => $weid, ':type' => 'semester', ':schoolid' => $schoolid));		
		$km = pdo_fetchall("SELECT sid,sname FROM " . tablename($this->table_classify) . " where weid = :weid AND schoolid = :schoolid And type = :type ORDER BY ssort DESC", array(':weid' => $weid, ':type' => 'subject', ':schoolid' => $schoolid));
		$bj = pdo_fetchall("SELECT sid,sname FROM " . tablename($this->table_classify) . " where weid = :weid AND schoolid = :schoolid And type = :type ORDER BY ssort DESC", array(':weid' => $weid, ':type' => 'theclass', ':schoolid' => $schoolid));
		$xq = pdo_fetchall("SELECT sid,sname FROM " . tablename($this->table_classify) . " where weid = :weid AND schoolid = :schoolid And type = :type ORDER BY ssort DESC", array(':weid' => $weid, ':type' => 'week', ':schoolid' => $schoolid));
		$sd = pdo_fetchall("SELECT sid,sname FROM " . tablename($this->table_classify) . " where weid = :weid AND schoolid = :schoolid And type = :type ORDER BY ssort DESC", array(':weid' => $weid, ':type' => 'timeframe', ':schoolid' => $schoolid));
		$qh = pdo_fetchall("SELECT sid,sname FROM " . tablename($this->table_classify) . " where weid = :weid AND schoolid = :schoolid And type = :type ORDER BY ssort DESC", array(':weid' => $weid, ':type' => 'score', ':schoolid' => $schoolid));
        $category = pdo_fetchall("SELECT sid,sname FROM " . tablename($this->table_classify) . " WHERE weid = :weid AND schoolid = :schoolid ORDER BY sid ASC, ssort DESC", array(':weid' => $weid, ':schoolid' => $schoolid), 'sid');
        $operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
        $tid_global = $_W['tid'];
		if($tid_global !='founder' && $tid_global != 'owner'){
			$loginTeaFzid =  pdo_fetch("SELECT fz_id FROM " . tablename ($this->table_teachers) . " where weid = :weid And schoolid = :schoolid And id =:id ", array(':weid' => $weid,':schoolid' => $schoolid,':id'=>$tid_global));
			$qxarr = GetQxByFz($loginTeaFzid['fz_id'],1,$schoolid);
		}
        if ($operation == 'post') {
	        if (!(IsHasQx($tid_global,1000952,1,$schoolid))){
				$this->imessage('非法访问，您无权操作该页面','','error');	
			}
            load()->func('tpl');
            load()->func('file');
            $id = intval($_GPC['id']);
            $gkkpjbz = pdo_fetchall("SELECT * FROM " . tablename($this->table_gkkpjbz) . " where schoolid='{$schoolid}' ORDER BY ssort ASC");
			$payweid = pdo_fetchall("SELECT * FROM " . tablename('account_wechats') . " where level = 4 ORDER BY acid ASC");
            if (!empty($id)) {
                $item = pdo_fetch("SELECT * FROM " . tablename($this->table_gongkaike) . " WHERE id = :id ", array(':id' => $id));
				$teachers = pdo_fetchall("SELECT * FROM " . tablename ($this->table_teachers) . " where weid = :weid And schoolid = :schoolid ", array(
					':weid' => $weid,
					':schoolid' => $schoolid
				));
				
                if (empty($item)) {   
                    message('抱歉，本条信息不存在在或是已经删除！', '', 'error');
                }
            }else{
	            $teachers = pdo_fetchall("SELECT * FROM " . tablename ($this->table_teachers) . " where weid = :weid And schoolid = :schoolid ", array(
					':weid' => $weid,
					':schoolid' => $schoolid
				));
            }
            if (checksubmit('submit')) {
	            $start_temp = strtotime($_GPC['starttime']);
	            $end_temp   = strtotime($_GPC['endtime']);
	            $date_temp  = strtotime($_GPC['date']);
	            	            
	            $gkkdate   = date("Y-m-d",$date_temp);
	            $starttime = date("H:i:s",$start_temp);
	            $endtime   = date("H:i:s",$end_temp);
	            
             	$start = strtotime($gkkdate." ".$starttime) ;
             	$end   = strtotime($gkkdate." ".$endtime) ;
	            $S2E = $end - $start;
	            //var_dump($S2E);
	            //die();
	            if($S2E < 1800){
		             message('抱歉，课程持续时间不能小于半小时！', '', 'error');
	            }
	            if( $_GPC['xq'] == 0 || $_GPC['km'] == 0 )
	            {
		             message('抱歉，未选择年级或科目！', '', 'error');
	            }
                $data = array(
				    'weid' => $weid,
					'schoolid' => $schoolid,
					'tid' => intval($_GPC['tid']),
					'bzid' => intval($_GPC['bzid']),
					'xq_id' => trim($_GPC['xq']),
					'km_id' => trim($_GPC['km']),
					'bj_id' => trim($_GPC['bj']),
					'name' => trim($_GPC['name']),
					'dagang' => trim($_GPC['dagang']),
					'addr' => trim($_GPC['addr']),
					'is_pj' => intval($_GPC['is_pj']),
					'ssort' => intval($_GPC['ssort']),
					'starttime' => $start,
					'endtime' => $end
                );
			
                if (!empty($id)){
                  pdo_update($this->table_gongkaike, $data, array('id' => $id));
                }else{
	                
						
	                	//  $value = $this->createMobileUrl('tcalendar', array('schoolid' => $schoolid), true); //二维码内容     
						// $errorCorrectionLevel = 'L'; //容错级别     
						// $matrixPointSize = 6; //生成图片大小  
					  
						// 生成二维码图片     
						// QRcode::png($value, 'qrcode2.png', $errorCorrectionLevel, $matrixPointSize, 2);  
					    // 输出二维码图片  
						// echo '<img src="qrcode2.png">';

					$barcode = array(
						'expire_seconds' =>2592000 ,
						'action_name' => '',
						'action_info' => array(
										'scene' => array(
												'scene_id' => ''
										),
						),
					);
				$uniacccount = WeAccount::create($weid);
				$qrcid = pdo_fetchcolumn("SELECT qrcid FROM " . tablename($this->table_qrinfo) . " WHERE model = '1' ORDER BY qrcid DESC");
			
				$barcode['action_info']['scene']['scene_id'] = !empty($qrcid) ? ($qrcid + 1) : 100001;
				$barcode['action_name'] = 'QR_SCENE';
				$result = $uniacccount->barCodeCreateDisposable($barcode);
				if (is_error($result)) {
				message($result['message'], referer(), 'fail');
				}
				if (!is_error($result)) {
					
					$showurl = $this->createImageUrlCenter("https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=" . $result['ticket'], $schoolid);
					$urlarr = explode('/',$showurl);
					$qrurls = "images/".$urlarr['3'];	
					
					$insert = array(
					'weid' => $weid, 
					'qrcid' => $barcode['action_info']['scene']['scene_id'], 
					'name' => '公开课临时二维码', 
					'model' => 1,
					//'rid' => trim($_GPC['ruleid']),
					'ticket' => $result['ticket'], 
					'show_url' => $qrurls,
					'expire' => $result['expire_seconds'], 
					'createtime' => TIMESTAMP,
					'status' => '1',
					'type' => '2'
					);
					
					pdo_insert($this->table_qrinfo, $insert);
					$qrid = pdo_insertid();
					$qrurl = pdo_fetch("SELECT show_url FROM " . tablename($this->table_qrinfo) . " WHERE id = '{$qrid}'");
					$arr = explode('/',$qrurl['show_url']);
					$pathname = "images/".$arr['1'];
						if (!empty($_W['setting']['remote']['type'])) { // 
							$remotestatus = file_remote_upload($pathname); //
								if (is_error($remotestatus)) {
									message('远程附件上传失败，'.$pathname.'请检查配置并重新上传');
								}
						}				
					
				}

						$data['createtime'] = time();
						$data['qrid'] = $qrid;
						$data['ticket'] = $result['ticket'];
                  		pdo_insert($this->table_gongkaike, $data);
	                   
                }
              message('操作成功！', $this->createWebUrl('gongkaike', array('op' => 'display', 'schoolid' => $schoolid)), 'success');
            }
        } elseif ($operation == 'display') {
	        if (!(IsHasQx($tid_global,1000951,1,$schoolid))){
				$this->imessage('非法访问，您无权操作该页面','','error');	
			}
            if (checksubmit('submit')) { //排序
                if (is_array($_GPC['ssort'])) {
                    foreach ($_GPC['ssort'] as $id => $val) {
                        $data = array('ssort' => intval($_GPC['ssort'][$id]));
                        pdo_update($this->table_gongkaike, $data, array('id' => $id));
                    }
                }
                message('批量修排序成功!', $url);
            }			

            $pindex = max(1, intval($_GPC['page']));
            $psize = 10;
            $condition = '';
			
		    if (!empty($_GPC['t_name'])) {
			     $teacher_temp = pdo_fetch("SELECT * FROM " . tablename ($this->table_teachers) . " where weid = :weid And schoolid = :schoolid AND tname= :t_name ", array(
					':weid' => $weid,
					':schoolid' => $schoolid,
					':t_name' => $_GPC['t_name']
				));
                $condition .= " AND tid ='{$teacher_temp['id']}' ";
            }
			if (!empty($_GPC['name'])) {
                $condition .= " AND name LIKE '%{$_GPC['name']}%' ";
            }			
            if (!empty($_GPC['bj_id'])) {
                $cid = intval($_GPC['bj_id']);
                $condition .= " AND bj_id = '{$cid}'";
            }	
			 if (!empty($_GPC['xq_id'])) {
                $cid = intval($_GPC['xq_id']);
                 
	                 $condition .= " AND xq_id = '{$cid}'";
                
               
            }			
            if (!empty($_GPC['km_id'])) {
                $cid = intval($_GPC['km_id']);
               
	                 $condition .= " AND km_id = '{$cid}'";
                
               
            }

            if(!empty($_GPC['searchtime']))
            {
	            $searchtime = $_GPC['searchtime'];
	            $starttime = strtotime($searchtime['start']);
	            $endtime = strtotime($searchtime['end']);
	            if($starttime != '-28800' && $endtime != '-28800')
	            {
		             $condition .= " AND starttime >= '{$starttime}' AND endtime <= '{$endtime}' ";
	            }
	            
	             
	            }		
				
            $list = pdo_fetchall("SELECT * FROM " . tablename($this->table_gongkaike) . " WHERE weid = '{$weid}' AND schoolid = '{$schoolid}' $condition ORDER BY id DESC LIMIT " . ($pindex - 1) * $psize . ',' . $psize);
				foreach($list as $key => $row){
					$teacher = pdo_fetch("SELECT * FROM " . tablename ($this->table_teachers) . " where id = :id ", array(':id' => $row['tid']));
					$yb = pdo_fetchcolumn("select count(*) FROM ".tablename('wx_school_order')." WHERE kcid = '".$row['id']."' And status = 2 ");
					$allks = pdo_fetchcolumn("select count(*) FROM ".tablename('wx_school_kcbiao')." WHERE kcid = '".$row['id']."'");
					$list[$key]['allks'] = $allks;
					$list[$key]['yib'] = $yb +$row['yibao'];
					$list[$key]['tname'] = $teacher['tname'];
					$list[$key]['shengyu'] = $row['minge'] - $yb;
				}
            $total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename($this->table_gongkaike) . " WHERE weid = '{$weid}' AND schoolid = '{$schoolid}' $condition");

            $pager = pagination($total, $pindex, $psize);
        } elseif ($operation == 'delete') {
            $id = intval($_GPC['id']);
            if (empty($id)) {
                message('抱歉，本条信息不存在在或是已经被删除！');
            }
            pdo_delete($this->table_gongkaike, array('id' => $id));
            message('删除成功！', referer(), 'success');
        } elseif ($operation == 'deleteall') {
            $rowcount = 0;
            $notrowcount = 0;
            foreach ($_GPC['idArr'] as $k => $id) {
                $id = intval($id);
                if (!empty($id)) {
                    $goods = pdo_fetch("SELECT * FROM " . tablename($this->table_gongkaike) . " WHERE id = :id", array(':id' => $id));
                    if (empty($goods)) {
                        $notrowcount++;
                        continue;
                    }
                    pdo_delete($this->table_gongkaike, array('id' => $id, 'weid' => $weid));
                    $rowcount++;
                }
            }
            message("操作成功！共删除{$rowcount}条数据,{$notrowcount}条数据不能删除!", '', 0);
        }elseif($operation == 'out_putcode'){
				  $list_out = pdo_fetchall("SELECT * FROM " . tablename($this->table_gongkaike) . " WHERE weid = '{$weid}' AND schoolid = '{$schoolid}'  ORDER BY ssort DESC " );
				$ii   = 0;
				foreach($list_out as $index => $row){

					$teacher = pdo_fetch("SELECT * FROM " . tablename ($this->table_teachers) . " where id = {$row['tid']}   and weid ={$weid} AND schoolid={$schoolid} ");
					$pjbz = pdo_fetch("SELECT * FROM " . tablename ($this->table_gkkpjbz) . " where id = {$row['bzid']} and weid ={$weid} AND schoolid={$schoolid}");
					$arr[$ii]['name'] = $row['name'];
					$arr[$ii]['tname'] = $teacher['tname'];
					$arr[$ii]['njname'] = $category[$row['xq_id']]['sname'];
					$arr[$ii]['bjname'] = $category[$row['bj_id']]['sname'];
					$arr[$ii]['addr'] = $row['addr'];
					$arr[$ii]['starttime']  = date("Y-M-D h:i",$row['starttime']);
					$arr[$ii]['endtime']  = date("Y-m-d h:i",$row['endtime']);
					if( $row['is_pj'] == 0 )
					{
						$arr[$ii]['is_pj'] = "可评价";
						$arr[$ii]['pjbz'] = $pjbz['title'];
					}else{
						$arr[$ii]['is_pj'] = "不可评价";
						$arr[$ii]['pjbz'] = "不可评价";
						
					}
					

					
					$ii++;
				}
				$this->exportexcel($arr, array('公开课','教师名称','年级','班级','上课地址','开始时间' ,'结束时间','是否可评价','评价标准'), '公开课信息');
                exit();




        } elseif ($operation == 'add') {
			load()->func('tpl');
            $id = intval($_GPC['id']);
            if (!empty($id)) {
                $item = pdo_fetch("SELECT * FROM " . tablename($this->table_tcourse) . " WHERE id = :id", array(':id' => $id));	
				$teachers = pdo_fetch("SELECT * FROM " . tablename ($this->table_teachers) . " where id = :id ", array(':id' => $item['tid']));				
                if (empty($item)) {
                    message('抱歉，教师不存在或是已经删除！', '', 'error');
                }
            }
			if (checksubmit('submit')) {
                $data = array(
				    'weid' => $weid,
					'schoolid' => $schoolid,
					'tid' => intval($_GPC['tid']),
					'kcid' => trim($_GPC['kcid']),
					'bj_id' => trim($_GPC['bj_id']),
					'km_id' => trim($_GPC['km_id']),					
					'sd_id' => trim($_GPC['sd']),
					'xq_id' => trim($_GPC['xq']),					
					'nub' => trim($_GPC['nub']),
					'isxiangqing' => trim($_GPC['isxiangqing']),
					'content' => trim($_GPC['content']),
					'date' => strtotime($_GPC['date']),
                );

                if (istrlen($data['nub']) == 0) {
                    message('没有输入编号.', '', 'error');
                }	
										
				pdo_insert($this->table_kcbiao, $data);
					message('操作成功', $this->createWebUrl('kecheng', array('op' => 'display', 'schoolid' => $schoolid)), 'success');    
            }
		}	
        include $this->template ( 'web/gongkaike' );
?>