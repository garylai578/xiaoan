<?php
/**
 * 微教育模块
 *
 * @author 高贵血迹
 */
        global $_W, $_GPC;
        $weid = $_W['uniacid'];
        $openid = $_W['openid'];
        $schoolid = intval($_GPC['schoolid']);
		$userss = intval($_GPC['userid']);
		$user = pdo_fetchall("SELECT * FROM " . tablename($this->table_user) . " where :weid = weid And :openid = openid And :tid = tid", array(
				':weid' => $weid,
				':openid' => $openid,
				':tid' => 0
				));
		$num = count($user);
		$flag = 1;
		if ($num > 1){
			$flag = 2;
		}
		
		$school = pdo_fetch("SELECT * FROM " . tablename($this->table_index) . " where weid = :weid AND id=:id", array(':weid' => $weid, ':id' => $schoolid));
		$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
		if($operation == "moreCourse"){
			
			$Ctype = $_GPC['Ctypeid'];
			if($Ctype != -1 ){
				$list_back = pdo_fetchall("SELECT * FROM " . tablename($this->table_tcourse) . " WHERE weid = :weid AND schoolid =:schoolid AND is_show = :is_show And Ctype = :Ctype ORDER BY end DESC LIMIT 0,10", array(':weid' => $_W['uniacid'], ':schoolid' => $schoolid, ':is_show' => 1,':Ctype' => $Ctype));
			}elseif($Ctype == -1){
				$list_back = pdo_fetchall("SELECT * FROM " . tablename($this->table_tcourse) . " WHERE weid = :weid AND schoolid =:schoolid AND is_show = :is_show  ORDER BY end DESC LIMIT 0,10", array(':weid' => $_W['uniacid'], ':schoolid' => $schoolid, ':is_show' => 1));
			}
			foreach( $list_back as $key => $value )
				{
					$list_back[$key]['localtion'] = $key ;
					$course_type = pdo_fetch("SELECT sname FROM " . tablename($this->table_classify) . " where weid = :weid AND sid=:sid", array(':weid' => $weid, ':sid' => $value['Ctype'])); 
        			$list_back[$key]['course_type'] =$course_type['sname']; 
				}
				//var_dump($list_back);
			include $this->template('comtool/courselist_new');
		}elseif($operation == 'scroll_more'){
			$limit = $_GPC['limit'];
			$Ctype = $_GPC['ctype'] ;
			$page_start = $limit + 1 ;
			if($Ctype != -1 ){
				$list_back = pdo_fetchall("SELECT * FROM " . tablename($this->table_tcourse) . " WHERE weid = :weid AND schoolid =:schoolid AND is_show = :is_show And Ctype = :Ctype ORDER BY end DESC LIMIT ".$page_start.",10", array(':weid' => $_W['uniacid'], ':schoolid' => $schoolid, ':is_show' => 1,':Ctype' => $Ctype));
				foreach( $list_back as $key => $value )
				{
					$list_back[$key]['localtion'] = $page_start + $key ;
				}
			}elseif($Ctype == -1){
				$list_back = pdo_fetchall("SELECT * FROM " . tablename($this->table_tcourse) . " WHERE weid = :weid AND schoolid =:schoolid AND is_show = :is_show  ORDER BY end DESC LIMIT ".$page_start.",10", array(':weid' => $_W['uniacid'], ':schoolid' => $schoolid, ':is_show' => 1));
				foreach( $list_back as $key => $value )
				{
					$list_back[$key]['localtion'] = $page_start + $key;
					$course_type = pdo_fetch("SELECT sname FROM " . tablename($this->table_classify) . " where weid = :weid AND sid=:sid", array(':weid' => $weid, ':sid' => $value['Ctype'])); 
        			$list_back[$key]['course_type'] =$course_type['sname']; 
				}
			}
			
			//var_dump($list_back);
			include $this->template('comtool/courselist_new');
		}elseif($operation == "display"){
			$Ctype = -1 ;
			foreach($user as $key => $row){
			$student = pdo_fetch("SELECT * FROM " . tablename($this->table_students) . " where id=:id ", array(':id' => $row['sid']));
			$bajinam = pdo_fetch("SELECT * FROM " . tablename($this->table_classify) . " where sid=:sid ", array(':sid' => $student['bj_id']));
			$user[$key]['s_name'] = $student['s_name'];
			$user[$key]['bjname'] = $bajinam['sname'];
			$user[$key]['sid'] = $student['id'];
			$user[$key]['schoolid'] = $student['schoolid'];
		}
		if(!empty($userss)){
			$ite = pdo_fetch("SELECT * FROM " . tablename($this->table_user) . " where :schoolid = schoolid And weid = :weid AND id=:id ", array(':schoolid' => $schoolid,':weid' => $weid, ':id' => $userss));
			if(!empty($ite)){
				$_SESSION['user'] = $ite['id'];
			}			
		}else{
			if(empty($_SESSION['user'])){
				$userid = pdo_fetch("SELECT * FROM " . tablename($this->table_user) . " where :schoolid = schoolid And :weid = weid And :openid = openid And :tid = tid LIMIT 0,1 ", array(':weid' => $weid, ':schoolid' => $schoolid, ':openid' => $openid, ':tid' => 0), 'id');
				if(!empty($userid)){
					$_SESSION['user'] = $userid['id'];
				}							
			}
		}	
			
		$leixing = pdo_fetchall("SELECT * FROM " . tablename($this->table_type) . " WHERE weid = :weid ORDER BY id ASC, ssort DESC", array(':weid' => $weid), 'id');
		$school = pdo_fetch("SELECT * FROM " . tablename($this->table_index) . " where weid = :weid AND id=:id", array(':weid' => $weid, ':id' => $schoolid));
        $list = pdo_fetchall("SELECT * FROM " . tablename($this->table_tcourse) . " WHERE weid = :weid AND schoolid =:schoolid AND is_show = :is_show  ORDER BY end DESC LIMIT 0,10", array(':weid' => $_W['uniacid'], ':schoolid' => $schoolid, ':is_show' => 1));
        $NumOfList = pdo_fetchall("SELECT id FROM " . tablename($this->table_tcourse) . " WHERE weid = :weid AND schoolid =:schoolid AND is_show = :is_show  ORDER BY ssort DESC", array(':weid' => $_W['uniacid'], ':schoolid' => $schoolid, ':is_show' => 1));
        $CourseType = pdo_fetchall("SELECT sid,sname FROM " . tablename($this->table_classify) . " where weid = :weid AND schoolid=:schoolid and type=:type ORDER BY ssort DESC ", array(':weid' => $weid,':schoolid'=>$schoolid ,':type' =>'coursetype'));
        $NumOfList = count($NumOfList);
        foreach($list as $key => $value)
        {
        	$course_type = pdo_fetch("SELECT sname FROM " . tablename($this->table_classify) . " where weid = :weid AND sid=:sid", array(':weid' => $weid, ':sid' => $value['Ctype'])); 
        	$list[$key]['course_type'] =$course_type['sname']; 
        }
        $item = pdo_fetch("SELECT * FROM " . tablename($this->table_tcourse) . " WHERE id = :id ", array(':id' => $id));
        $title = $item['title'];
        $category = pdo_fetchall("SELECT * FROM " . tablename($this->table_classify) . " WHERE weid = :weid AND schoolid = :schoolid ORDER BY sid ASC, ssort DESC", array(':weid' => $weid, ':schoolid' => $schoolid), 'sid');
		$km = pdo_fetchall("SELECT * FROM " . tablename($this->table_classify) . " where weid = :weid AND schoolid = :schoolid And type = :type ORDER BY ssort DESC", array(':weid' => $weid, ':type' => 'subject', ':schoolid' => $schoolid));
		$it = pdo_fetch("SELECT * FROM " . tablename($this->table_classify) . " WHERE sid = :sid", array(':sid' => $sid));
        if (empty($schoolid)) {
            message('没有找到该学校，请联系管理员！');
        }
		
        //include $this->template(''.$school['style1'].'/kc');
       	include $this->template(''.$school['style1'].'/courselist_new');
		}
		
?>