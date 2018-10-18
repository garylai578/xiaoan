<?php
/**
 * 微教育模块
 *
 * @author 高贵血迹
 */
        global $_GPC, $_W;
   
        $weid = $_W['uniacid'];
       
		$tid = $_GPC['tid'];
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
		

        $operation = $_GPC['op'];
       
            load()->func('tpl');
            load()->func('file');
            $id = intval($_GPC['gkkid']);
            $gkkpjbz = pdo_fetchall("SELECT * FROM " . tablename($this->table_gkkpjbz) . " where schoolid='{$schoolid}' ORDER BY ssort ASC");
			
            if (!empty($id)) {
                $item = pdo_fetch("SELECT * FROM " . tablename($this->table_gongkaike) . " WHERE id = :id ", array(':id' => $id));
				$teachers = pdo_fetchall("SELECT id,tname FROM " . tablename ($this->table_teachers) . " where weid = :weid And schoolid = :schoolid ORDER BY  CONVERT(tname USING gbk)  ASC ", array(
					':weid' => $weid,
					':schoolid' => $schoolid
				) );
				
                if (empty($item)) {   
                   
                }
            }else{
	            $teachers = pdo_fetchall("SELECT * FROM " . tablename ($this->table_teachers) . " where weid = :weid And schoolid = :schoolid ORDER BY  CONVERT(tname USING gbk)  ASC ", array(
					':weid' => $weid,
					':schoolid' => $schoolid
				) );
            }
            //这里开始提交
            if ($operation == 'add') {
	            
	           
	            $date_temp  = strtotime($_GPC['gkkdate']);
	            $bj_id      = $_GPC['bj_id'];
	            $km_id      = $_GPC['km_id'];
	            $nj_id      = $_GPC['nj_id'];
	            $addr       = $_GPC['addr'];
	            $is_pj      = $_GPC['is_pj'];
	            $dagang     = $_GPC['dagang'];
	            $pjbz       = $_GPC['pjbz'];
				$title      = $_GPC['title'];
				$starttime  = $_GPC['starttime'];
				$endtime    = $_GPC['endtime'];
               


                                 
	           
                $data = array(
				    'weid' => $weid,
					'schoolid' => $schoolid,
					'tid' => intval($_GPC['tid']),
					'bzid' => $pjbz,
					'xq_id' => $nj_id,
					'km_id' => $km_id,
					'bj_id' => $bj_id,
					'name' => $title,
					'dagang' => $dagang,
					'addr' =>$addr,
					'is_pj' => $is_pj,
					'ssort' => intval($_GPC['ssort']),
					'starttime' => $starttime,
					'endtime' => $endtime
                );
			  
                if (!empty($id)){
                  //pdo_update($this->table_gongkaike, $data, array('id' => $id));
                }else{
	                
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
					$data_back['info'] = $result['message'];
				 	die(json_encode($data_back));
				//message($result['message'], referer(), 'fail');
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
									$data_back['info'] = '远程附件上传失败，'.$pathname.'请检查配置并重新上传';
									 die(json_encode($data_back));
									
								}
						}				
					
				}

						$data['createtime'] = time();
						$data['qrid'] = $qrid;
						$data['ticket'] = $result['ticket'];
                  		pdo_insert($this->table_gongkaike, $data);
                  		$data_back['status'] = 1 ;
	                   $data_back['info'] = '创建公开课成功';
						die(json_encode($data_back));
                }
             
            }
            ////到这里结束提交
         

        include $this->template ( ''.$school['style3'].'/gkkadd' );
?>