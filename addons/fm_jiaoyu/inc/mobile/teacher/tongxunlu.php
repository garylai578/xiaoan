<?php
/**
 * 微教育模块
 *
 * @author 高贵血迹
 */
        global $_W, $_GPC;
        $weid = $_W['uniacid'];
		$schoolid = intval($_GPC['schoolid']);
		$openid = $_W['openid'];
		//$obid = 2;
		$act = "tx";
        //查询是否用户登录
		$it = pdo_fetch("SELECT id,tid,is_allowmsg FROM " . tablename($this->table_user) . " where  weid = :weid And schoolid = :schoolid And openid = :openid And sid = :sid ", array(
					':weid' => $weid,
					':schoolid' => $schoolid,
					':openid' => $openid,
					':sid' => 0
		));
		$school = pdo_fetch("SELECT * FROM " . tablename($this->table_index) . " where weid = :weid AND id=:id ", array(':weid' => $weid, ':id' => $schoolid));
		$techers = pdo_fetch("SELECT * FROM " . tablename($this->table_teachers) . " WHERE schoolid = :schoolid And id = :id", array(':id' => $it['tid'], ':schoolid' => $schoolid));
        if(!empty($it)){
            $master = pdo_fetchall("SELECT tname,thumb,mobile,id,status,userid,fz_id FROM " . tablename($this->table_teachers) . " WHERE weid = :weid AND schoolid = :schoolid AND status = :status ORDER BY sort DESC", array(
				':weid' => $weid,
				':schoolid' => $schoolid,
				':status' => 2,
			));
			foreach( $master as $key => $value )
			{
				$master[$key]['Ttitle'] =GetTeacherTitle($value['status'],$value['fz_id']);
			}			
            $masterCount = count($master);
			$master1 = pdo_fetchall("SELECT sid,sname,tid FROM " . tablename($this->table_classify) . " WHERE weid = :weid AND schoolid = :schoolid AND type = :type ORDER BY sid DESC", array(
				':weid' => $weid,
				':schoolid' => $schoolid,
				':type' => 'semester',
			));
			$tidss = array();
			$masterCount1 = 0;
			foreach($master1 as $key => $row){
				$techer = pdo_fetch("SELECT tname,thumb,mobile,id,status,userid,fz_id FROM " . tablename($this->table_teachers) . " WHERE id =  :id ", array(':id' => $row['tid']));
				if($techer){
					if(!in_array($row['tid'],$tidss)){
						$tidss = array($row['tid']);
						$masterCount1++;
					}
					$master1[$key]['tname'] = $techer['tname'];
					$master1[$key]['thumb'] = $techer['thumb'];
					$master1[$key]['mobile'] = $techer['mobile'];
					$master1[$key]['id'] = $techer['id'];
					$master1[$key]['status'] = $techer['status'];
					$master1[$key]['userid'] = $techer['userid'];
					$master1[$key]['fz_id'] = $techer['fz_id'];
					$master1[$key]['Ttitle'] =GetTeacherTitle($techer['status'],$techer['fz_id']);
				}
			}		
			$master2 = pdo_fetchall("SELECT tname,thumb,mobile,id,status,userid,fz_id FROM " . tablename($this->table_teachers) . " WHERE weid = :weid AND schoolid = :schoolid AND status = :status ORDER BY sort DESC", array(
				':weid' => $weid,
				':schoolid' => $schoolid,
				':status' => 1,
			));
			foreach( $master2 as $key => $value )
			{
				$master2[$key]['Ttitle'] =GetTeacherTitle($value['status'],$value['fz_id']);
			}
            $masterCount2 = count($master2);	
			//普通教员
			if($techers['status'] == 1 || $techers['status'] == 0){
				$bjlists = pdo_fetchall("SELECT * FROM ".tablename($this->table_class)." WHERE tid = :tid And schoolid = :schoolid ", array(':tid' => $it['tid'],':schoolid' => $schoolid));

				foreach ($bjlists as $index => $row) {
					if(!in_array($row['bj_id'], $bjlists)){
						$bjlists[] = $row['bj_id'];
						$bj = pdo_fetch("SELECT sid,sname FROM " . tablename($this->table_classify) . " where schoolid = '{$schoolid}' And weid = '{$weid}' And sid = '{$row['bj_id']}' ");
						$bjlists[$index]['bjsid'] = $bj['sid'];
						$bjlists[$index]['bjname'] = $bj['sname'];
						$bjlists[$index]['sid'] = pdo_fetchall("SELECT id,s_name,icon FROM " . tablename($this->table_students) . " WHERE weid = :weid AND schoolid = :schoolid AND bj_id = :bj_id ", array(
							':weid' => $weid,
							':schoolid' => $schoolid,
							':bj_id' => $row['bj_id']
						));
						$bjlists[$index]['rs'] = 0;
						foreach($bjlists[$index]['sid'] as $k => $r){
							$bjlists[$index]['sid'][$k]['sid'] = pdo_fetchall("SELECT userinfo,pard,id,uid FROM " . tablename($this->table_user) . " WHERE weid = :weid AND schoolid = :schoolid AND sid = :sid ", array(
								':weid' => $weid,
								':schoolid' => $schoolid,
								':sid' => $r['id']
							));
							foreach($bjlists[$index]['sid'][$k]['sid'] as $key =>$row){
								$member = pdo_fetch("SELECT avatar FROM " . tablename ( 'mc_members' ) . " where uniacid = :uniacid And uid = :uid ", array(':uniacid' => $weid, ':uid' => $row['uid']));
								$bjlists[$index]['sid'][$k]['sid'][$key]['avatar'] = $member['avatar'];
								if ($row['userinfo']){
									$userinfo = iunserializer($row['userinfo']);
									$bjlists[$index]['sid'][$k]['sid'][$key]['name'] = $userinfo['name'];
									$bjlists[$index]['sid'][$k]['sid'][$key]['mobile'] = $userinfo['mobile'];
								}							
							$bjlists[$index]['rs'] ++;
							}
						}
					}					
				}
			}
			
			//取全校班级的家长
			if($techers['status'] == 2){
				$list = pdo_fetchall("SELECT sid,sname FROM " . tablename($this->table_classify) . " where schoolid = '{$schoolid}' And weid = '{$weid}' And type = 'theclass'  ORDER BY ssort DESC");	
				foreach ($list as $index => $row) {
					$list[$index]['sid'] = pdo_fetchall("SELECT id,s_name,icon FROM " . tablename($this->table_students) . " WHERE weid = :weid AND schoolid = :schoolid AND bj_id = :bj_id ", array(
						':weid' => $weid,
						':schoolid' => $schoolid,
						':bj_id' => $row['sid']
					));
					$list[$index]['rs'] = 0;
					foreach($list[$index]['sid'] as $k => $r){
						$list[$index]['sid'][$k]['sid'] = pdo_fetchall("SELECT userinfo,pard,id,uid FROM " . tablename($this->table_user) . " WHERE weid = :weid AND schoolid = :schoolid AND sid = :sid ", array(
							':weid' => $weid,
							':schoolid' => $schoolid,
							':sid' => $r['id']
						));
						foreach($list[$index]['sid'][$k]['sid'] as $key =>$row){
							$member = pdo_fetch("SELECT avatar FROM " . tablename ( 'mc_members' ) . " where uniacid = :uniacid And uid = :uid ", array(':uniacid' => $weid, ':uid' => $row['uid']));
							$list[$index]['sid'][$k]['sid'][$key]['avatar'] = $member['avatar'];
							if ($row['userinfo']){
								$userinfo = iunserializer($row['userinfo']);
								$list[$index]['sid'][$k]['sid'][$key]['name'] = $userinfo['name'];
								$list[$index]['sid'][$k]['sid'][$key]['mobile'] = $userinfo['mobile'];
							}							
						$list[$index]['rs'] ++;
						}
					}				
				}
			}
			if($techers['status'] == 3){
				$list = pdo_fetchall("SELECT sid,sname FROM " . tablename($this->table_classify) . " where schoolid = '{$schoolid}' And tid = '{$techers['id']}' And type = 'semester' ORDER BY ssort DESC"); 
				foreach ($list as $index => $row) {
					$list[$index]['bj_id'] = pdo_fetchall("SELECT sid,sname FROM " . tablename($this->table_classify) . " where schoolid = '{$schoolid}' And parentid = '{$row['sid']}' And type = 'theclass' ");
					foreach ($list[$index]['bj_id'] as $kk => $vel) {
						$list[$index]['bj_id'][$kk]['sd'] = pdo_fetchall("SELECT id,s_name,icon,bj_id FROM " . tablename($this->table_students) . " WHERE weid = :weid AND schoolid = :schoolid AND bj_id = :bj_id ", array(
							':weid' => $weid,
							':schoolid' => $schoolid,
							':bj_id' => $vel['sid']
						));
						$bj3count[$vel['sid']] = 0;
						foreach($list[$index]['bj_id'][$kk]['sd'] as $k => $r){
							$list[$index]['bj_id'][$kk]['sd'][$k]['sid'] = pdo_fetchall("SELECT userinfo,pard,id,uid FROM " . tablename($this->table_user) . " WHERE weid = :weid AND schoolid = :schoolid AND sid = :sid ", array(
								':weid' => $weid,
								':schoolid' => $schoolid,
								':sid' => $r['id']
							));
							foreach($list[$index]['bj_id'][$kk]['sd'][$k]['sid'] as $key =>$i){
								$member = pdo_fetch("SELECT avatar FROM " . tablename ( 'mc_members' ) . " where uniacid = :uniacid And uid = :uid ", array(':uniacid' => $weid, ':uid' => $i['uid']));
								$list[$index]['bj_id'][$kk]['sd'][$k]['sid'][$key]['avatar'] = $member['avatar'];
								if ($i['userinfo']){
									$userinfo = iunserializer($i['userinfo']);
									$list[$index]['bj_id'][$kk]['sd'][$k]['sid'][$key]['name'] = $userinfo['name'];
									$list[$index]['bj_id'][$kk]['sd'][$k]['sid'][$key]['mobile'] = $userinfo['mobile'];
								}								
							$bj3count[$vel['sid']] ++;
							}
						}				
					}
				}	
			}			
		    //$this->checkobjiect($schoolid, $student['id'], $obid);
		 include $this->template(''.$school['style3'].'/tongxunlu');
        }else{
         session_destroy();
            $stopurl = $_W['siteroot'] .'app/'.$this->createMobileUrl('bangding', array('schoolid' => $schoolid));
			header("location:$stopurl");
        }        
?>