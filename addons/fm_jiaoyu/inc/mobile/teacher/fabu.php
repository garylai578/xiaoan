<?php
/**
 * 微教育模块
 *
 * @author 高贵血迹
 */
        global $_W, $_GPC;
        $weid = $_W ['uniacid'];
		$schoolid = intval($_GPC['schoolid']);
		$openid = $_W['openid'];
        
        //查询是否用户登录		
		$userid = pdo_fetch("SELECT * FROM " . tablename($this->table_user) . " where :schoolid = schoolid And :weid = weid And :openid = openid And :sid = sid", array(':weid' => $weid, ':schoolid' => $schoolid, ':openid' => $openid, ':sid' => 0), 'id');
		$it = pdo_fetch("SELECT * FROM " . tablename($this->table_user) . " where weid = :weid AND id=:id ORDER BY id DESC", array(':weid' => $weid, ':id' => $userid['id']));
		$teachers = pdo_fetch("SELECT * FROM " . tablename($this->table_teachers) . " where weid = :weid AND id = :id", array(':weid' => $_W ['uniacid'], ':id' => $it['tid']));
		$school = pdo_fetch("SELECT is_fbnew,style3,title,txid,txms,is_fbnew,is_fbvocie FROM " . tablename($this->table_index) . " where weid = :weid AND id=:id", array(':weid' => $weid, ':id' => $schoolid));				
        if(!empty($userid['id'])){
 		$bjlists = get_mylist($schoolid,$it['tid'],'teacher');
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
			include $this->template(''.$school['style3'].'/fabunew');
		}else{
         
			session_destroy();
            $stopurl = $_W['siteroot'] .'app/'.$this->createMobileUrl('bangding', array('schoolid' => $schoolid));
			header("location:$stopurl");
        
		}        
?>