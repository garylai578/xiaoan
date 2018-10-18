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
		
		$userss = !empty($_GPC['userid']) ? intval($_GPC['userid']) : 1;

	
		$obid = 2;
		$gkkid = $_GPC['gkkid'];
		$userid = $_GPC['userid'];

		$gkkinfo =  pdo_fetch("SELECT * FROM " . tablename($this->table_gongkaike) . " where id = :id And schoolid = :schoolid ", array(':id' => $gkkid,':schoolid' => $schoolid));
		
        //查询是否用户登录
		mload()->model('user');
		$_SESSION['user'] = check_userlogin_all($weid,$schoolid,$openid,$userss);
		if ($_SESSION['user'] ==2){
			include $this->template('bangding');
		}

		
		$alluser = get_myalluser($weid,$openid,$schoolid);
		$myname = array();
		foreach($alluser as $key=>$row)
		{
			if($row['id'] == $userid){
				$myname['type'] = $row['type'];
				if($row['type'] == 1)
				{
					$myname['name'] = $row['s_name'];
					$myname['bj'] = $row['bjname'];
				}else{
					$myname['name'] = $row['tname'];
				}
			}
		}
		$it = pdo_fetch("SELECT * FROM " . tablename($this->table_user) . " where :schoolid = schoolid And openid = :openid AND id=:id ", array(':schoolid' => $schoolid,':openid' => $openid, ':id' => $userid));
		$pard = get_guanxi($it['pard']);
		if(!$pard){
			$pard = '本人';
		}
		
		
		$it_check = pdo_fetch("SELECT id FROM " . tablename($this->table_user) . " where id = :id ", array(':id' => $_SESSION['user']));	
		$school = pdo_fetch("SELECT style1,title,spic,tpic,title,headcolor,thumb FROM " . tablename($this->table_index) . " where weid = :weid AND id=:id", array(':weid' => $weid, ':id' => $schoolid));

		
        if(!empty($it_check)){

			$mypl = pdo_fetch("SELECT content FROM " . tablename($this->table_gkkpj) . " where tid = :tid And gkkid = :gkkid And userid = :userid And type = :type ", array(':tid' => $gkkinfo['tid'],':gkkid' => $gkkid,':userid' => $userid,':type' => 1));

			$check = pdo_fetchall("SELECT distinct userid FROM " . tablename($this->table_gkkpj) . " where tid = :tid And gkkid = :gkkid ORDER BY createtime DESC  ", array(':tid' => $gkkinfo['tid'],':gkkid' => $gkkid));
			//var_dump($check);
			foreach( $check as $key => $value )
			{
				$userinfo = pdo_fetch("SELECT sid,tid,pard FROM " . tablename($this->table_user) . " where id = :id And schoolid =:schoolid", array(':id' => $value['userid'],'schoolid'=> $schoolid));
				if($userinfo['sid'] != 0 && $userinfo['tid'] == 0  ){
					$studentinfo = pdo_fetch("SELECT s_name,icon FROM " . tablename($this->table_students) . " where id = :id", array(':id' => $userinfo['sid']));
					if(!empty($studentinfo)){
					$pard = get_guanxi($userinfo['pard']);
					if(!$pard){
						$pard = '本人';
					}
					$check[$key]['s_name'] = $studentinfo['s_name'].$pard;
					$check[$key]['icon'] = $studentinfo['icon'];
				}
				}elseif($userinfo['sid'] == 0 && $userinfo['tid'] != 0  ){
					$teacherinfo = pdo_fetch("SELECT tname,thumb FROM " . tablename($this->table_teachers) . " where id = :id And schoolid = :schoolid ", array(':id' => $userinfo['tid'],':schoolid' => $schoolid));
					if(!empty($teacherinfo)){
						$check[$key]['s_name'] = $teacherinfo['tname']."老师";
						$check[$key]['icon'] = $teacherinfo['thumb'];
					}
				}

			}
			$gkkinfo =  pdo_fetch("SELECT * FROM " . tablename($this->table_gongkaike) . " where id = :id And schoolid = :schoolid ", array(':id' => $gkkid,':schoolid' => $schoolid));
			$teacher = pdo_fetch("SELECT * FROM " . tablename($this->table_teachers) . " where id = :id And schoolid = :schoolid ", array(':id' => $gkkinfo['tid'],':schoolid' => $schoolid));

			$list1 = pdo_fetchall("SELECT iconid,iconlevel FROM " . tablename($this->table_gkkpj) . " where userid = :userid And gkkid = :gkkid And type = :type  ORDER BY iconid ASC", array(
				':userid' => $userid,
				':gkkid' => $gkkid,
				':type' => 2
				
			));
			foreach($list1 as $key => $row){
				$scicon = pdo_fetch("SELECT * FROM " . tablename($this->table_gkkpjk) . " where id = :id ", array(':id' => $row['iconid']));
				$list1[$key]['title'] = $scicon['title'];	
				if ($row['iconlevel'] == 1){
					$list1[$key]['icontitle'] = $scicon['icon1title'];
					$list1[$key]['icon'] = $scicon['icon1'];						
				}
				if ($row['iconlevel'] == 2){
					$list1[$key]['icontitle'] = $scicon['icon2title'];
					$list1[$key]['icon'] = $scicon['icon2'];						
				}
				if ($row['iconlevel'] == 3){
					$list1[$key]['icontitle'] = $scicon['icon3title'];
					$list1[$key]['icon'] = $scicon['icon3'];						
				}
				if ($row['iconlevel'] == 4){
					$list1[$key]['icontitle'] = $scicon['icon4title'];
					$list1[$key]['icon'] = $scicon['icon4'];						
				}
				if ($row['iconlevel'] == 5){
					$list1[$key]['icontitle'] = $scicon['icon5title'];
					$list1[$key]['icon'] = $scicon['icon5'];						
				}					
			}

			//用于分享的几个参数start
			$title = '';
			 if (!empty($userid)){
				  $title .= $myname['name'];
			   	if ($myname['type'] == 1 ){
				    $title .=$pard;
			   	}else{ 
			    	$title .='老师';
			    }
			}
			$title .= '对公开课\"' . $gkkinfo['name'].'\"的评价';  
			$sharetitle = $title;
			$sharedesc = $title;
			$shareimgUrl = tomedia($school['thumb']);
			$links = $_W['siteroot'] .'app/'.$this->createMobileUrl('gkkpjshare', array('schoolid' => $schoolid,'gkkid' => $gkkid,'userid'=>$userid,'fenxiang'=> 'fenxiang','op'=>'check'));
			//end
			include $this->template(''.$school['style1'].'/gkkpjshare');
        }else{
			session_destroy();
		    $stopurl = $_W['siteroot'] .'app/'.$this->createMobileUrl('bangding', array('schoolid' => $schoolid));
			header("location:$stopurl");
			exit;
        }        
?>