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
		$it = pdo_fetch("SELECT * FROM " . tablename($this->table_user) . " where weid = :weid AND id=:id ", array(':weid' => $weid, ':id' => $userid['id']));	
		$school = pdo_fetch("SELECT * FROM " . tablename($this->table_index) . " where weid = :weid AND id=:id", array(':weid' => $weid, ':id' => $schoolid));
						
        if(!empty($userid['id'])){
			 if(is_showgkk())
			 {
			        $njzr = GetNjzr($it['tid']);
			       // var_dump($njzr);
			       $is_njzr = is_njzr($it['tid']);
			      //var_dump($is_njzr);
			 }else{
				 $is_njzr = 1 ;
			 }
			$fzstr = GetFzByQx('shjsqj',2,$schoolid);
            $xzlist = pdo_fetchall("SELECT tname,openid,id FROM " . tablename($this->table_teachers) . " where weid = :weid AND schoolid=:schoolid AND status=:status", array(':weid' => $weid, ':schoolid' => $schoolid, ':status' => 2)); 
            $shlist = pdo_fetchall("SELECT tname,openid,id FROM " . tablename($this->table_teachers) . " where weid = :weid AND schoolid=:schoolid AND FIND_IN_SET(fz_id,:fzstr)", array(':weid' => $weid, ':schoolid' => $schoolid, ':fzstr' => $fzstr)); 
			$teacher = pdo_fetch("SELECT * FROM " . tablename($this->table_teachers) . " where weid = :weid AND id=:id ", array(':weid' => $weid, ':id' => $it['tid']));
			$item = pdo_fetch("SELECT * FROM " . tablename ( 'mc_members' ) . " where uniacid = :uniacid AND uid=:uid ", array(':uid' => $it['uid'], ':uniacid' => $weid)); 

		    $userinfo = iunserializer($it['userinfo']);
		    
		 include $this->template(''.$school['style3'].'/qingjia');
          }else{
     		session_destroy();
            $stopurl = $_W['siteroot'] .'app/'.$this->createMobileUrl('bangding', array('schoolid' => $schoolid));
			header("location:$stopurl");
          }        
?>