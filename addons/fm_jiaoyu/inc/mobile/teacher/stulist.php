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
		$it = pdo_fetch("SELECT * FROM " . tablename($this->table_user) . " where weid = :weid And :schoolid = schoolid And :openid = openid And :sid = sid", array(':weid' => $weid,':schoolid' => $schoolid,':openid' => $openid,':sid' => 0));	
		$tid_global = $it['tid'];
		if (!(IsHasQx($tid_global,2000501,2,$schoolid))){
			message('您无权查看本页面');
		}
		$school = pdo_fetch("SELECT * FROM " . tablename($this->table_index) . " where weid = :weid AND id=:id ", array(':weid' => $weid, ':id' => $schoolid));
		$teachers = pdo_fetch("SELECT * FROM " . tablename($this->table_teachers) . " where weid = :weid AND id = :id", array(':weid' => $weid, ':id' => $it['tid']));		
		$bjlists = get_mylist($schoolid,$it['tid'],'teacher');	
		$ertype = true;
		if($school['is_stuewcode'] == 2){
			$ertype = false;
		}
		if(is_njzr($teachers['id'])){
			$myfisrtnj =  pdo_fetch("SELECT sid FROM " . tablename($this->table_classify) . " where weid = '{$weid}' And schoolid = '{$schoolid}' And tid = '{$it['tid']}' And type = 'semester'");
			$fisrtbj =  pdo_fetch("SELECT sid as bj_id FROM " . tablename($this->table_classify) . " where weid = '{$weid}' And schoolid = '{$schoolid}' And parentid = '{$myfisrtnj['sid']}'");
		}else{
			$fisrtbj =  pdo_fetch("SELECT bj_id FROM " . tablename($this->table_class) . " where weid = '{$weid}' And schoolid = '{$schoolid}'  And tid = {$it['tid']} ");
			if($teachers['status'] == 2){
				$fisrtbj =  pdo_fetch("SELECT sid as bj_id FROM " . tablename($this->table_classify) . " where weid = '{$weid}' And schoolid = '{$schoolid}' And type = 'theclass'");
			}			
		}
		if(!empty($_GPC['bj_id'])){
			$bj_id = intval($_GPC['bj_id']);			
		}else{
			$bj_id = $fisrtbj['bj_id'];
		}
		$nowbj = pdo_fetch("SELECT sname FROM " . tablename($this->table_classify) . " where sid = :sid ", array(':sid' => $bj_id));
		if(is_njzr($teachers['id'])){
			$mynjlist = pdo_fetchall("SELECT * FROM " . tablename($this->table_classify) . " where schoolid = '{$schoolid}' And weid = '{$weid}' And tid = '{$it['tid']}' And type = 'semester' ORDER BY ssort DESC");
			foreach($mynjlist as $key =>$row){
				$mynjlist[$key]['bjlist'] = pdo_fetchall("SELECT sid,sname FROM " . tablename($this->table_classify) . " where schoolid = '{$schoolid}' And weid = '{$weid}' And parentid = '{$row['sid']}' And type = 'theclass' ORDER BY sid ASC, ssort DESC");
				foreach($mynjlist[$key]['bjlist'] as $k => $v){

				}
			}
		}else{
			if($teachers['status'] == 2){
				$bjlist = pdo_fetchall("SELECT * FROM " . tablename($this->table_classify) . " where schoolid = '{$schoolid}' And weid = '{$weid}' And type = 'theclass' ORDER BY sid ASC, ssort DESC");
			}			
		}
		$thisbj = pdo_fetchall("SELECT id FROM " . tablename($this->table_students) . " where weid = '{$weid}' And schoolid = '{$schoolid}' And bj_id = '{$bj_id}' ORDER BY id DESC ");
		$bjallrs = count($thisbj);
		$bjxs = 0;
		$alljz =0;
		foreach($thisbj as $u){
			$checkuser = pdo_fetch("SELECT id FROM " . tablename($this->table_user) . " where sid = :sid ", array(':sid' => $u['id']));
			if($checkuser){
				$checkusers = pdo_fetchall("SELECT id FROM " . tablename($this->table_user) . " where sid = :sid ", array(':sid' => $u['id']));
				$alljz = $alljz + count($checkusers);
				$bjxs++;
			}
		}
		$thistime = trim($_GPC['limit']);
		if($thistime){
			$condition = " AND id < '{$thistime}'";	
			$leave1 = pdo_fetchall("SELECT id,s_name,numberid,qrcode_id,bj_id,sex,icon FROM " . tablename($this->table_students) . " where weid = '{$weid}' And schoolid = '{$schoolid}' And bj_id = '{$bj_id}' $condition ORDER BY id DESC LIMIT 0,10 ");
			foreach($leave1 as $key =>$row){
				$banji = pdo_fetch("SELECT sname FROM " . tablename($this->table_classify) . " where sid = :sid And schoolid = :schoolid ", array(':schoolid' => $schoolid,':sid' => $row['bj_id']));
				$leave1[$key]['banji'] = $banji['sname'];
				$leave1[$key]['pard'] = pdo_fetchall("SELECT pard FROM ".tablename($this->table_user)." WHERE weid = '{$weid}' And schoolid = '{$schoolid}' And sid = '{$row['id']}' ");
				if($leave1[$key]['pard']){
					foreach($leave1[$key]['pard'] as $k => $v){
						$leave1[$key]['pard'][$k]['pardid'] = $v['pard'];
						if($v['pard'] == 4){
							$leave1[$key]['pard'][$k]['guanxi'] = "本人";
						}else{
							$leave1[$key]['pard'][$k]['guanxi'] = get_guanxi($v['pard']);
						}
					}
				}
			}
			include $this->template('comtool/stulist'); 
		}else{
			$leave = pdo_fetchall("SELECT id,s_name,numberid,qrcode_id,bj_id,sex,icon FROM " . tablename($this->table_students) . " where weid = '{$weid}' And schoolid = '{$schoolid}' And bj_id = '{$bj_id}' ORDER BY id DESC LIMIT 0,10 ");
			foreach($leave as $key =>$row){
				$banji = pdo_fetch("SELECT sname FROM " . tablename($this->table_classify) . " where sid = :sid And schoolid = :schoolid ", array(':schoolid' => $schoolid,':sid' => $row['bj_id']));
				$leave[$key]['banji'] = $banji['sname'];
				$leave[$key]['pard'] = pdo_fetchall("SELECT pard FROM ".tablename($this->table_user)." WHERE weid = '{$weid}' And schoolid = '{$schoolid}' And sid = '{$row['id']}' ");
				if($leave[$key]['pard']){
					foreach($leave[$key]['pard'] as $k => $v){
						$leave[$key]['pard'][$k]['pardid'] = $v['pard'];
						if($v['pard'] == 4){
							$leave[$key]['pard'][$k]['guanxi'] = "本人";
						}else{
							$leave[$key]['pard'][$k]['guanxi'] = get_guanxi($v['pard']);
						}
					}
				}
			}
			include $this->template(''.$school['style3'].'/stulist');	
		}				        		
        if(empty($it)){
			session_destroy();
            $stopurl = $_W['siteroot'] .'app/'.$this->createMobileUrl('bangding', array('schoolid' => $schoolid));
			header("location:$stopurl");
        }        
?>