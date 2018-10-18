<?php
/**
 * 微教育模块
 *
 * @author 高贵血迹
 */
        global $_W, $_GPC;
        $weid = $_W ['uniacid'];
        $from_user = $this->_fromuser;
		$schoolid = intval($_GPC['schoolid']);
		$openid = $_W['openid'];
		$leaveid = $_GPC['id'];
  		mload()->model('que');
  			$ZY_contents = GetZyContent($leaveid,$schoolid,$weid);
        //查询是否用户登录		
		$userid = pdo_fetch("SELECT * FROM " . tablename($this->table_user) . " where :schoolid = schoolid And :weid = weid And :openid = openid And :sid = sid", array(':weid' => $weid, ':schoolid' => $schoolid, ':openid' => $openid, ':sid' => 0), 'id');
		$it = pdo_fetch("SELECT * FROM " . tablename($this->table_user) . " where weid = :weid AND id=:id ORDER BY id DESC", array(':weid' => $weid, ':id' => $userid['id']));
		$leave = pdo_fetch("SELECT * FROM " . tablename($this->table_notice) . " where :id = id", array(':id' => $leaveid));
		  $anstype = iunserializer($leave['anstype']);
		$school = pdo_fetch("SELECT * FROM " . tablename($this->table_index) . " where weid = :weid AND id=:id ORDER BY ssort DESC", array(':weid' => $weid, ':id' => $schoolid));
		$nowbj =  pdo_fetch("SELECT sname FROM " . tablename($this->table_classify) . " WHERE sid =:sid ", array(':sid' => $leave['bj_id']));
		$nowkm =  pdo_fetch("SELECT sname FROM " . tablename($this->table_classify) . " WHERE sid =:sid ", array(':sid' => $leave['km_id']));		
        if(!empty($userid['id'])){
			$teacher = pdo_fetch("SELECT status FROM " . tablename($this->table_teachers) . " where id = :id", array(':id' => $it['tid']));	
			$is_njzr = check_bj($it['tid'],$leave['bj_id']);
			$allstud = pdo_fetchall("SELECT id,s_name,icon FROM " . tablename($this->table_students) . " where schoolid = :schoolid And bj_id = :bj_id ORDER BY id DESC", array(':schoolid' => $schoolid, ':bj_id' => $leave['bj_id']));
			$isbzr = pdo_fetch("SELECT * FROM " . tablename($this->table_teachers) . " where weid = :weid AND id = :id", array(':weid' => $weid, ':id' => $it['tid']));
			$picarr = iunserializer($leave['picarr']);	
			include $this->template(''.$school['style3'].'/zuoye');
        }else{
			session_destroy();
            $stopurl = $_W['siteroot'] .'app/'.$this->createMobileUrl('bangding', array('schoolid' => $schoolid));
			header("location:$stopurl");
        }        
?>