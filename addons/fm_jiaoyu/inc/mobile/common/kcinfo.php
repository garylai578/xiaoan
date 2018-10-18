<?php
/**
 * 微教育模块
 *
 * @author 高贵血迹
 */
        global $_W, $_GPC;
        $weid = $_W['uniacid'];
        $id = intval($_GPC['id']);
		$openid = $_W['openid'];
		$schoolid = intval($_GPC['schoolid']);
		//var_dump($openid);
		$myAllStudent = get_myallclass_this_school($weid,$openid,$schoolid);
		$xueqi = pdo_fetchall("SELECT sid,sname FROM " . tablename($this->table_classify) . " where weid = :weid AND schoolid = :schoolid And type = :type ORDER BY ssort DESC", array(':weid' => $weid, ':type' => 'semester', ':schoolid' => $schoolid));
$bj = pdo_fetchall("SELECT sid,sname FROM " . tablename($this->table_classify) . " where weid = :weid AND schoolid = :schoolid And type = :type ORDER BY CONVERT(sname USING gbk) ASC", array(':weid' => $weid, ':type' => 'theclass', ':schoolid' => $schoolid));
		$userid = pdo_fetch("SELECT * FROM " . tablename($this->table_user) . " where :schoolid = schoolid And :weid = weid And :openid = openid And :tid = tid", array(':weid' => $weid, ':schoolid' => $schoolid, ':openid' => $openid, ':tid' => 0), 'id');
		$its = pdo_fetch("SELECT * FROM " . tablename($this->table_user) . " where weid = :weid AND id=:id ", array(':weid' => $weid, ':id' => $_SESSION['user']));		
		$userinfo = iunserializer($its['userinfo']);
		$student = pdo_fetch("SELECT * FROM " . tablename($this->table_students) . " where weid = :weid AND schoolid=:schoolid AND id=:id", array(':weid' => $weid, ':schoolid' => $schoolid, ':id' => $its['sid']));
		$school = pdo_fetch("SELECT * FROM " . tablename($this->table_index) . " where weid = :weid AND id=:id", array(':weid' => $weid, ':id' => $schoolid));
        $list = pdo_fetchall("SELECT * FROM " . tablename($this->table_kcbiao) . " WHERE weid = :weid AND schoolid =:schoolid AND kcid = :kcid  ORDER BY date ASC", array(':weid' => $weid, ':schoolid' => $schoolid, ':kcid' => $id));
       
      	foreach( $list as $key => $value )
      	{
      		$weekarray=array("日","一","二","三","四","五","六"); //先定义一个数组
			$list[$key]['week'] = $weekarray[date("w",$value['date'])];
			$SD = pdo_fetch("SELECT sname FROM " . tablename($this->table_classify) . " WHERE weid = :weid AND schoolid =:schoolid AND sid = :sid  ", array(':weid' => $weid, ':schoolid' => $schoolid, ':sid' => $value['sd_id']));
			$list[$key]['sdname'] = $SD['sname'];
			
      	}
        $allnum = count($list);
        
		$item = pdo_fetch("SELECT * FROM " . tablename($this->table_tcourse) . " WHERE id = :id ", array(':id' => $id));
		$others = pdo_fetchall("SELECT * FROM " . tablename($this->table_tcourse) . " WHERE id != :id And weid=:weid And schoolid=:schoolid  And end > :timeEnd ORDER BY  RAND() LIMIT 0,5 ", array(':id' => $id,':weid'=>$weid,':schoolid'=>$schoolid,':timeEnd'=>time()));
		$yb = pdo_fetchcolumn("select count(*) FROM ".tablename('wx_school_order')." WHERE kcid = '".$id."' And status = 2 ");
		$addr = pdo_fetch("SELECT sname FROM " . tablename($this->table_classify) . " WHERE sid = :sid ", array(':sid' => $item['adrr']));
		$item['yb'] = $yb + $item['yibao'];
		$item['address'] = $addr['sname'];
		$teacher_array =  explode(',', $item['tid']);
		$tid_array = array();
		foreach( $teacher_array as $key => $value )
		{
			$teacher = pdo_fetch("SELECT tname,id,thumb FROM " . tablename($this->table_teachers) . " where weid = :weid AND schoolid=:schoolid AND id=:id", array(':weid' => $weid, ':schoolid' => $schoolid, ':id' => $value));
			$tid_array[$key]['tname']  = $teacher['tname'];
			$tid_array[$key]['tid']   = $teacher['id'];
			$tid_array[$key]['thumb'] = $teacher['thumb'];
		};
        $teacher = pdo_fetch("SELECT * FROM " . tablename($this->table_teachers) . " where weid = :weid AND schoolid=:schoolid AND id=:id", array(':weid' => $weid, ':schoolid' => $schoolid, ':id' => $item['tid']));
		$title = $item['title'];
        $category = pdo_fetchall("SELECT sid,sname FROM " . tablename($this->table_classify) . " WHERE weid =  :weid AND schoolid =:schoolid ORDER BY sid ASC, ssort DESC", array(':weid' => $weid, ':schoolid' => $schoolid), 'sid');
		$yb = pdo_fetchcolumn("select count(*) FROM ".tablename('wx_school_order')." WHERE kcid = '".$id."' And status = 2 ");
		$rest = $item['minge'] - $yb;
		
		$isfull =false;
		
		if ($rest < 1){
			
		$isfull =true;
		
		}
		
		$km = pdo_fetchall("SELECT * FROM " . tablename($this->table_classify) . " where weid = :weid AND schoolid =:schoolid And type =:type ORDER BY ssort DESC", array(':weid' => $weid, ':type' => 'subject', ':schoolid' => $schoolid));
		$it = pdo_fetch("SELECT * FROM " . tablename($this->table_classify) . " WHERE sid = :sid", array(':sid' => $sid));
   		
        //include $this->template(''.$school['style1'].'/kcinfo');
        include $this->template(''.$school['style1'].'/coursedetail_new');
?>