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
        $getMy = $_GPC['getMy'];
        //查询是否用户登录		
		$userid = pdo_fetch("SELECT * FROM " . tablename($this->table_user) . " where :schoolid = schoolid And :weid = weid And :openid = openid And :sid = sid", array(':weid' => $weid, ':schoolid' => $schoolid, ':openid' => $openid, ':sid' => 0), 'id');	
		$it = pdo_fetch("SELECT * FROM " . tablename($this->table_user) . " where weid = :weid AND id=:id ORDER BY id DESC", array(':weid' => $weid, ':id' => $userid['id']));	
		$school = pdo_fetch("SELECT * FROM " . tablename($this->table_index) . " where weid = :weid AND id=:id ORDER BY ssort DESC", array(':weid' => $weid, ':id' => $schoolid));
		$teachers = pdo_fetch("SELECT * FROM " . tablename($this->table_teachers) . " where weid = :weid AND id = :id", array(':weid' => $weid, ':id' => $it['tid']));		
		$bjlists = get_mylist($schoolid,$it['tid'],'teacher');	
		$fisrtbj =  pdo_fetch("SELECT bj_id FROM " . tablename($this->table_class) . " where weid = '{$weid}' And schoolid = '{$schoolid}'  And tid = {$it['tid']} ");

			
		if($teachers['status'] == 2){
			$myfisrtnj =  pdo_fetch("SELECT sid FROM " . tablename($this->table_classify) . " where weid = '{$weid}' And schoolid = '{$schoolid}' And tid = '{$it['tid']}' And type = 'semester'");
			$fisrtbj =  pdo_fetch("SELECT sid as bj_id FROM " . tablename($this->table_classify) . " where weid = '{$weid}' And schoolid = '{$schoolid}' And parentid = '{$myfisrtnj['sid']}'");
		}
		if($teachers['status'] == 3){
			$fisrtbj =  pdo_fetch("SELECT sid as bj_id FROM " . tablename($this->table_classify) . " where weid = '{$weid}' And schoolid = '{$schoolid}' ");
		}
		if(!empty($_GPC['bj_id'])){
			$bj_id = intval($_GPC['bj_id']);			
		}elseif($_GPC['getMy'] == 'my'){
				
		}else{
			$bj_id = $fisrtbj['bj_id'];
		}
		$nowbj = pdo_fetch("SELECT sname FROM " . tablename($this->table_classify) . " where sid = :sid ", array(':sid' => $bj_id));
		if($teachers['status'] == 2){
			$bjlist = pdo_fetchall("SELECT * FROM " . tablename($this->table_classify) . " where schoolid = '{$schoolid}' And weid = '{$weid}' And type = 'theclass' ORDER BY sid ASC, ssort DESC");
		}
		if($teachers['status'] == 3 || is_njzr($teachers['id'])){
			$mynjlist = pdo_fetchall("SELECT * FROM " . tablename($this->table_classify) . " where schoolid = '{$schoolid}' And weid = '{$weid}' And tid = '{$it['tid']}' And type = 'semester' ORDER BY ssort DESC");
			foreach($mynjlist as $key =>$row){
				$mynjlist[$key]['bjlist'] = pdo_fetchall("SELECT sid,sname FROM " . tablename($this->table_classify) . " where schoolid = '{$schoolid}' And weid = '{$weid}' And parentid = '{$row['sid']}' And type = 'theclass' ORDER BY sid ASC, ssort DESC");
				foreach($mynjlist[$key]['bjlist'] as $k => $v){

				}
			}
		}		
		$thistime = trim($_GPC['limit']);
		if($thistime){
			$condition = " AND createtime < '{$thistime}'";	
			if($getMy == 'my')
			{
				$gkklist1 = pdo_fetchall("SELECT * FROM " . tablename($this->table_gongkaike) . " where weid = '{$weid}' And schoolid = '{$schoolid}' And tid='{$it['tid']}'  $condition  ORDER BY createtime DESC LIMIT 0,10 ");
				
			}else{
				if(is_njzr($it['tid']) || $teachers['status'] == 2)
					{
						$gkklist1 = pdo_fetchall("SELECT * FROM " . tablename($this->table_gongkaike) . " where weid = '{$weid}' And schoolid = '{$schoolid}'  And bj_id ='{$bj_id}' $condition ORDER BY createtime DESC LIMIT 0,10 ");
					}else{
						$gkklist1 = pdo_fetchall("SELECT * FROM " . tablename($this->table_gongkaike) . " where weid = '{$weid}' And schoolid = '{$schoolid}' And tid='{$it['tid']}' And bj_id ='{$bj_id}' $condition ORDER BY createtime DESC LIMIT 0,10 ");
					}
			
			}
			foreach($gkklist1 as $key =>$row){
				$banji = pdo_fetch("SELECT sname FROM " . tablename($this->table_classify) . " where sid = :sid And schoolid = :schoolid ", array(':schoolid' => $schoolid,':sid' => $row['bj_id']));
				$teach = pdo_fetch("SELECT status,thumb,tname FROM " . tablename($this->table_teachers) . " where id = :id ", array(':id' => $row['tid']));
				$kemu = pdo_fetch("SELECT sname,icon FROM " . tablename($this->table_classify) . " where sid = :sid And schoolid = :schoolid ", array(':schoolid' => $schoolid,':sid' => $row['km_id']));
				
				$gkklist1[$key]['kmname'] = $kemu['sname'];
				$gkklist1[$key]['kmicon'] = empty($kemu['icon']) ? $school['logo'] : $kemu['icon'];
				$gkklist1[$key]['banji'] = $banji['sname'];
				$gkklist1[$key]['tname'] = $teach['tname'];
			} 
			include $this->template('comtool/gkklist');	 
		}else{
			
			if($getMy == 'my')
			{
				$gkklist = pdo_fetchall("SELECT * FROM " . tablename($this->table_gongkaike) . " where weid = '{$weid}' And schoolid = '{$schoolid}' And tid='{$it['tid']}'   ORDER BY createtime DESC LIMIT 0,10 ");
				
			}else{
				if(is_njzr($it['tid']) || $teachers['status'] == 2)
			{
				$gkklist = pdo_fetchall("SELECT * FROM " . tablename($this->table_gongkaike) . " where weid = '{$weid}' And schoolid = '{$schoolid}'  And bj_id ='{$bj_id}'  ORDER BY createtime DESC LIMIT 0,10 ");
			}else{
				$gkklist = pdo_fetchall("SELECT * FROM " . tablename($this->table_gongkaike) . " where weid = '{$weid}' And schoolid = '{$schoolid}' And tid='{$it['tid']}' And bj_id ='{$bj_id}'  ORDER BY createtime DESC LIMIT 0,10 ");
			}
			
			}
			
			
			//print_r($leave1);
			foreach($gkklist as $key =>$row){
				$banji = pdo_fetch("SELECT sname FROM " . tablename($this->table_classify) . " where sid = :sid And schoolid = :schoolid ", array(':schoolid' => $schoolid,':sid' => $row['bj_id']));
				$teach = pdo_fetch("SELECT status,thumb,tname FROM " . tablename($this->table_teachers) . " where id = :id ", array(':id' => $row['tid']));
				$kemu = pdo_fetch("SELECT sname,icon FROM " . tablename($this->table_classify) . " where sid = :sid And schoolid = :schoolid ", array(':schoolid' => $schoolid,':sid' => $row['km_id']));
				
				$gkklist[$key]['kmname'] = $kemu['sname'];
				$gkklist[$key]['kmicon'] = empty($kemu['icon']) ? $school['logo'] : $kemu['icon'];
				$gkklist[$key]['banji'] = $banji['sname'];
				$gkklist[$key]['tname'] = $teach['tname'];
				$leave[$key]['time'] = date('Y-m-d H:i', $row['createtime']);	
			} 
			include $this->template(''.$school['style3'].'/gkklist');	
		}				        		
        if(empty($userid['id'])){
			session_destroy();
            $stopurl = $_W['siteroot'] .'app/'.$this->createMobileUrl('bangding', array('schoolid' => $schoolid));
			header("location:$stopurl");
        }        
?>