<?php 
/**
 * 微教育模块
 *
 * @author 高贵血迹
 */
defined('IN_IA') or exit('Access Denied');
load()->func('communication');

function getalljsfzinfo($schoolid,$is_over,$schooltype){
	$condition = '';
	if($is_over){
		$condition .= " AND is_over = '{$is_over}' ";
	}
	$datas = pdo_fetchall("SELECT sid,sname FROM ".tablename('wx_school_classify')." WHERE  type ='jsfz' And schoolid='{$schoolid}' $condition ORDER BY parentid ASC ");
	foreach($datas as $key => $row){
		$total = pdo_fetchcolumn("select COUNT(id) FROM ".tablename('wx_school_teachers')." WHERE fz_id = '{$row['sid']}' ");
		$datas[$key]['sname'] = $row['sname'].'('.$total.'人)';
	}
	return $datas;
}

function getalljsfzallteainfo($schoolid,$is_over,$schooltype){
	$condition = '';
	if($is_over){
		$condition .= " AND is_over = '{$is_over}' ";
	}
	$school = pdo_fetch("SELECT tpic FROM ".tablename('wx_school_index')." WHERE id = '{$schoolid}' ");
	$fzlist = pdo_fetchall("SELECT sid,sname FROM ".tablename('wx_school_classify')." WHERE  type ='jsfz' And schoolid='{$schoolid}' $condition ORDER BY parentid ASC ");
	foreach($fzlist as $key => $item){
		$alltea = pdo_fetchall("SELECT id,tname,thumb FROM ".tablename('wx_school_teachers')." WHERE schoolid = '{$schoolid}' And fz_id ='{$item['sid']}' ORDER BY id ASC ");
		$fzlist[$key]['sname'] = $item['sname'].'('.count($alltea).'人)';
		foreach($alltea as $k =>$i){
			if($i['thumb']){
				$alltea[$k]['icon'] = tomedia($i['thumb']);
			}else{
				$alltea[$k]['icon'] = tomedia($school['tpic']);
			}
		}
		$fzlist[$key]['alltea'] = $alltea;
	}
	return $fzlist;
}
function TeaInfoByclassArr($staff_jsfz,$schoolid){
	if(is_array($staff_jsfz)){
		$teaarr = array();
		foreach($staff_jsfz as $row){
			$alltea = pdo_fetchall("SELECT id FROM ".tablename('wx_school_teachers')." WHERE  fz_id = '{$row}' And schoolid = '{$schoolid}' ORDER BY id ASC ");
			if($alltea){
				foreach($alltea as $r){
					$teaarr[] = intval($r['id']);
				}
			}
		}
	}
	return $teaarr;		
}

function getalljsfzallteainfo_nofz($schoolid,$schooltype){ //查询未分配分组教师	
	$school = pdo_fetch("SELECT tpic FROM ".tablename('wx_school_index')." WHERE id = '{$schoolid}' ");
	$alltea = pdo_fetchall("SELECT id,tname,thumb FROM ".tablename('wx_school_teachers')." WHERE schoolid = '{$schoolid}' And fz_id = 0 ORDER BY id ASC ");
	foreach($alltea as $k =>$i){
		if($i['thumb']){
			$alltea[$k]['icon'] = tomedia($i['thumb']);
		}else{
			$alltea[$k]['icon'] = tomedia($school['tpic']);
		}
	}
	return $alltea;		
}

function GetFzInfoByArr($fz_arr,$schooltype,$schoolid){//根据已知分组ID数组查询分组名称
	if(is_array($fz_arr)){
		$fzlist = array();
		foreach($fz_arr as $row){
			if($row == 0){
				$fzlist[]['name'] = '未分组';
			}else{
				$fzinfo = pdo_fetch("SELECT sname as name FROM " . tablename('wx_school_classify') . " WHERE sid = '{$row}' And schoolid = '{$schoolid}' ");
				if($fzinfo){
					$fzlist[] = $fzinfo;
				}
			}
		}	
	}	
	return $fzlist;
}

function GetTeaInfoByArr($tea_arr,$schooltype,$schoolid){//根据已知老师数组查询老师姓名和头像
	if(is_array($tea_arr)){
		$alltea = array();
		$school = pdo_fetch("SELECT tpic FROM ".tablename('wx_school_index')." WHERE id = '{$schoolid}' ");
		foreach($tea_arr as $row){
			if($row == 0 || $row != ""){
				$tea = pdo_fetch("SELECT tname as name,thumb FROM " . tablename('wx_school_teachers') . " WHERE id = '{$row}' And schoolid = '{$schoolid}' ");
				if($tea){
					if($tea['thumb']){
						$tea['icon'] = tomedia($tea['thumb']);
					}else{
						$tea['icon'] = tomedia($school['tpic']);
					}
					$alltea[] = $tea;
				}
			}
		}	
	}	
	return $alltea;
}

function GetAllClassInfoByTid($schoolid,$is_over,$schooltype,$tid){ //根据已知道老师查询可管辖班级情况
	$mynjlist = is_njzr($tid);
	$nowtime = time();
	if($schooltype){//查询授课班级或课程(不区分身份，后台安排的授课班级或课程)
		$kclist = pdo_fetchall("select id as sid ,name as sname, end FROM ".tablename('wx_school_tcourse')." WHERE schoolid = '{$schoolid}'  and (tid like '%,{$tid},%'  or tid like '%,{$tid}' or tid like '{$tid},%' or tid ='{$tid}') ORDER BY end DESC , ssort DESC ");
		foreach($kclist as $key =>$row){
			$kclist[$key]['is_over'] = 1;
			$total = pdo_fetchcolumn("select COUNT(id) FROM ".tablename('wx_school_order')." WHERE kcid = '{$row['sid']}' and type = 1 and status = 2 and sid != 0  ");
			$kclist[$key]['sname'] = $row['sname'].'('.$total.'人)';
			if($row['end'] < $nowtime){
				$kclist[$key]['info'] = '--(已结课)';
				$kclist[$key]['is_over'] = 2;
			}
		} 
	}else{
		$bjlists = get_myskbj($tid);//默认取未毕业班级
		foreach($bjlists as $i => $v){
			$total = pdo_fetchcolumn("select COUNT(id) FROM ".tablename('wx_school_students')." WHERE bj_id = '{$v['bj_id']}' ");
			$bjinfo = pdo_fetch("SELECT is_over,sname FROM " . tablename('wx_school_classify') . " where sid = :sid", array(':sid' => $v['bj_id']));
			$bjlists[$i]['sname'] = $bjinfo['sname'].'('.$total.'人)';
			$bjlists[$i]['sid'] = $v['bj_id'];
			$bjlists[$i]['is_over'] = $bjinfo['is_over'];
			if($bjinfo['is_over'] == 2){
				$bjlists[$i]['info'] = '--(已毕业)';
				if($is_over == 1){
					unset($bjlists[$i]);
				}
			}
		}		
	}	
	if($mynjlist){ 
		$getallnj = getallnj($tid);
		if($schooltype){//年级主任取管辖班级和授课班级
			$datas = array();
			$datas = array_merge($datas,$kclist);
			foreach($getallnj as $val){
				$str_nj .=$val['sid'].',';					
			}
			$str_nj = trim($str_nj,',');
			$kclist_nj = pdo_fetchall("select id as sid ,name as sname, end FROM ".tablename('wx_school_tcourse')." WHERE schoolid = :schoolid and FIND_IN_SET(xq_id,:str_nj) ORDER BY end DESC , ssort DESC ",array(':schoolid'=>$schoolid,':str_nj'=>$str_nj));
			if(!empty($kclist_nj)){
				
			 
				foreach($kclist_nj as $key =>$row){
					$kclist_nj[$key]['is_over'] = 1;
					$total = pdo_fetchcolumn("select COUNT(id) FROM ".tablename('wx_school_order')." WHERE kcid = '{$row['sid']}' and type = 1 and status = 2 and sid != 0  ");
					$kclist_nj[$key]['sname'] = $row['sname'].'('.$total.'人)';
					if($row['end'] < $nowtime){
						$kclist_nj[$key]['info'] = '--(已结课)';
						$kclist_nj[$key]['is_over'] = 2;
					}
				}	
				$datas = array_merge($datas,$kclist_nj);
			}
		}else{
			$condition = '';
			if($is_over == 1){
				//$condition .= " AND is_over = '{$is_over}' ";
			}			
			$datas = array();
			$datas = array_merge($datas,$bjlists);
			foreach($getallnj as $val){
				$classify = pdo_fetchall("SELECT sid,sname,is_over FROM ".tablename('wx_school_classify')." WHERE  type ='theclass' And schoolid='{$schoolid}' And parentid='{$val['sid']}' $condition ORDER BY ssort DESC ");
				foreach($classify as $key => $row){
					$total = pdo_fetchcolumn("select COUNT(id) FROM ".tablename('wx_school_students')." WHERE bj_id = '{$row['sid']}' ");
					$classify[$key]['sname'] = $row['sname'].'('.$total.'人)';
					if($row['is_over'] == 2){
						$classify[$key]['info'] = '--(已毕业)';
						if($is_over == 1){
							unset($classify[$key]);
						}
					}
				}
				$datas = array_merge($datas,$classify);
			}
		}
	}else{
		if(is_xiaozhang($tid)){//校长  取全校数据
			if($schooltype){//培训
				$condition = '';
				$nowtime = time();
				if($is_over == 1){
					//$condition .= " AND end >= $nowtime ";
				}		
				$datas = pdo_fetchall("SELECT id as sid,name as sname,end FROM " . tablename('wx_school_tcourse') . " WHERE schoolid='{$schoolid}' $condition  ORDER BY end DESC, ssort DESC");
				foreach($datas as $key =>$row){
					$datas[$key]['is_over'] = 1;
					$total = pdo_fetchcolumn("select COUNT(id) FROM ".tablename('wx_school_order')." WHERE kcid = '{$row['sid']}' and type = 1 and status = 2 and sid != 0  ");
					$datas[$key]['sname'] = $row['sname'].'('.$total.'人)';
					if($row['end'] < $nowtime){
						$datas[$key]['info'] = '--(已结课)';
						$datas[$key]['is_over'] = 2;
					}
				} 
			}else{//公立
				$condition = '';
				if($is_over == 1){
					$condition .= " AND is_over = '{$is_over}' ";
				}
				$datas = pdo_fetchall("SELECT sid,sname,is_over FROM ".tablename('wx_school_classify')." WHERE  type ='theclass' And schoolid='{$schoolid}' $condition ORDER BY parentid ASC ");
				foreach($datas as $key => $row){
					$total = pdo_fetchcolumn("select COUNT(id) FROM ".tablename('wx_school_students')." WHERE bj_id = '{$row['sid']}' ");
					$datas[$key]['sname'] = $row['sname'].'('.$total.'人)';
					if($row['is_over'] == 2){
						$datas[$key]['info'] = '--(已毕业)';
						if($is_over == 1){
							unset($datas[$key]);
						}
					}
				}
			}
		}else{ //普通老师取授课班级
			if($schooltype){//年级主任取管辖班级和授课班级
				$datas = $kclist;
			}else{
				$datas = $bjlists;//默认取未毕业班级
			}	
		}
	}
	$datas = array_sorts($datas,'is_over','asc');
	return $datas;	
}

function GetAllClassStuInfoByTid($schoolid,$is_over,$schooltype,$tid){ //根据已知道老师查询可管辖班级情况 及学生头像姓名
	$mynjlist = is_njzr($tid);
	$nowtime = time();
	$school = pdo_fetch("SELECT spic FROM ".tablename('wx_school_index')." WHERE id = '{$schoolid}' ");
	if($schooltype){//查询授课班级或课程(不区分身份，后台安排的授课班级或课程)
		$kclist = pdo_fetchall("select id as sid ,name as sname, end FROM ".tablename('wx_school_tcourse')." WHERE schoolid = '{$schoolid}'  and (tid like '%,{$tid},%'  or tid like '%,{$tid}' or tid like '{$tid},%' or tid ='{$tid}') ORDER BY end DESC , ssort DESC ");
		foreach($kclist as $key =>$row){
			$allstu = pdo_fetchall("SELECT students.id,students.s_name,students.icon FROM ".tablename('wx_school_students')." as students ,".tablename('wx_school_order')." as orders  WHERE orders.schoolid = '{$schoolid}' And orders.kcid = '{$row['sid']}' and orders.type = 1 and  orders.status = 2 and students.id = orders.sid GROUP BY students.id ORDER BY students.id  ASC ");
			foreach($allstu as $k =>$vs){
				if($vs['icon']){
					$allstu[$k]['icon'] = tomedia($vs['icon']);
				}else{
					$allstu[$k]['icon'] = tomedia($school['spic']);
				}
			}
			
			$kclist[$key]['allstu'] = $allstu;
			$kclist[$key]['is_over'] = 1;
			$total = pdo_fetchcolumn("select COUNT(distinct sid) FROM ".tablename('wx_school_order')." WHERE kcid = '{$row['sid']}' and type = 1 and status = 2 and sid != 0  ");
			$kclist[$key]['sname'] = $row['sname'].'('.$total.'人)';
			if($row['end'] < $nowtime){
				$kclist[$key]['info'] = '--(已结课)';
				$kclist[$key]['is_over'] = 2;
			}
		} 
	}else{
		$get_myskbj = get_myskbj($tid);//默认取未毕业班级
		$bjlists = array();
		foreach($get_myskbj as $i => $v){
			$allstu = pdo_fetchall("SELECT id,s_name,icon FROM ".tablename('wx_school_students')." WHERE schoolid = '{$schoolid}' And bj_id ='{$v['bj_id']}' ORDER BY id ASC ");
			foreach($allstu as $k =>$vs){
				if($vs['icon']){
					$allstu[$k]['icon'] = tomedia($vs['icon']);
				}else{
					$allstu[$k]['icon'] = tomedia($school['spic']);
				}
			}
			$bjlists[$i]['allstu'] = $allstu;
			$bjinfo = pdo_fetch("SELECT is_over,sname FROM " . tablename('wx_school_classify') . " where sid = :sid", array(':sid' => $v['bj_id']));
			$bjlists[$i]['sname'] = $bjinfo['sname'].'('.count($allstu).'人)';
			$bjlists[$i]['sid'] = $v['bj_id'];
			$bjlists[$i]['is_over'] = $bjinfo['is_over'];
			if($bjinfo['is_over'] == 2){
				$bjlists[$i]['info'] = '--(已毕业)';
				if($is_over == 1){
					unset($bjlists[$i]);
				}
			}
		}		
	}	
	if($mynjlist){ 
		$getallnj = getallnj($tid);
		if($schooltype){//年级主任取管辖班级和授课班级
			$datas = array();
			$datas = array_merge($datas,$kclist);
			foreach($getallnj as $val){
				$str_nj .=$val['sid'].',';					
			}
			$str_nj = trim($str_nj,',');
			$kclist_nj = pdo_fetchall("select id as sid ,name as sname, end FROM ".tablename('wx_school_tcourse')." WHERE schoolid = :schoolid and FIND_IN_SET(xq_id,:str_nj) ORDER BY end DESC , ssort DESC ",array(':schoolid'=>$schoolid,':str_nj'=>$str_nj));
			if(!empty($kclist_nj)){
				
			
				foreach($kclist_nj as $key =>$row){
					$allstu = pdo_fetchall("SELECT students.id,students.s_name,students.icon FROM ".tablename('wx_school_students')." as students ,".tablename('wx_school_order')." as orders  WHERE orders.schoolid = '{$schoolid}' And orders.kcid = '{$row['sid']}' and orders.type = 1 and orders.status = 2 and students.id = orders.sid GROUP BY students.id ORDER BY students.id ASC ");
					foreach($allstu as $k =>$vs){
						if($vs['icon']){
							$allstu[$k]['icon'] = tomedia($vs['icon']);
						}else{
							$allstu[$k]['icon'] = tomedia($school['spic']);
						}
					}
					$kclist_nj[$key]['allstu'] = $allstu;
					$kclist_nj[$key]['is_over'] = 1;
					$total = pdo_fetchcolumn("select COUNT(distinct sid) FROM ".tablename('wx_school_order')." WHERE kcid = '{$row['sid']}' and type = 1 and status = 2 and sid != 0  ");
					$kclist_nj[$key]['sname'] = $row['sname'].'('.$total.'人)';
					if($row['end'] < $nowtime){
						$kclist_nj[$key]['info'] = '--(已结课)';
						$kclist_nj[$key]['is_over'] = 2;
					}
				}	
				$datas = array_merge($datas,$kclist_nj);
			}
		}else{
			$condition = '';
			if($is_over == 1){
				//$condition .= " AND is_over = '{$is_over}' ";
			}			
			$datas = array();
			$datas = array_merge($datas,$bjlists);
			foreach($getallnj as $val){
				$classify = pdo_fetchall("SELECT sid,sname,is_over FROM ".tablename('wx_school_classify')." WHERE  type ='theclass' And schoolid='{$schoolid}' And parentid='{$val['sid']}' $condition ORDER BY ssort DESC ");
				foreach($classify as $key => $row){					
					$allstus = pdo_fetchall("SELECT id,s_name,icon FROM ".tablename('wx_school_students')." WHERE schoolid = '{$schoolid}' And bj_id ='{$row['sid']}' ORDER BY id ASC ");
					foreach($allstus as $ks =>$is){
						if($is['icon']){
							$allstus[$ks]['icon'] = tomedia($is['icon']);
						}else{
							$allstus[$ks]['icon'] = tomedia($school['spic']);
						}
					}
					$classify[$key]['allstu'] = $allstus;
					$classify[$key]['sname'] = $row['sname'].'('.count($allstus).'人)';
					if($row['is_over'] == 2){
						$classify[$key]['info'] = '--(已毕业)';
						if($is_over == 1){
							unset($classify[$key]);
						}
					}
				}
				$datas = array_merge($datas,$classify);
			}
		}
	}else{
		if(is_xiaozhang($tid)){//校长  取全校数据
			if($schooltype){//培训
				$condition = '';
				$nowtime = time();
				if($is_over == 1){
					//$condition .= " AND end >= $nowtime "; 
				}		
				$datas = pdo_fetchall("SELECT id as sid,name as sname,end FROM " . tablename('wx_school_tcourse') . " WHERE schoolid='{$schoolid}' $condition  ORDER BY end DESC, ssort DESC");
				foreach($datas as $key =>$row){
					$allstu = pdo_fetchall("SELECT students.id,students.s_name,students.icon FROM ".tablename('wx_school_students')." as students ,".tablename('wx_school_order')." as orders  WHERE orders.schoolid = '{$schoolid}' And orders.kcid = '{$row['sid']}' and orders.type = 1 and orders.status = 2 and students.id = orders.sid GROUP BY students.id ORDER BY students.id ASC ");
					foreach($allstu as $k =>$vs){
						if($vs['icon']){
							$allstu[$k]['icon'] = tomedia($vs['icon']);
						}else{
							$allstu[$k]['icon'] = tomedia($school['spic']);
						}
					}
					$datas[$key]['allstu'] = $allstu;
					$datas[$key]['is_over'] = 1;
					$total = pdo_fetchcolumn("select COUNT(distinct sid) FROM ".tablename('wx_school_order')." WHERE kcid = '{$row['sid']}' and type = 1 and status = 2 and sid != 0  ");
					$datas[$key]['sname'] = $row['sname'].'('.$total.'人)';
					if($row['end'] < $nowtime){
						$datas[$key]['info'] = '--(已结课)';
						$datas[$key]['is_over'] = 2;
					}
				} 
			}else{//公立
				$condition = '';
				if($is_over == 1){
					$condition .= " AND is_over = '{$is_over}' ";
				}
				$datas = pdo_fetchall("SELECT sid,sname,is_over FROM ".tablename('wx_school_classify')." WHERE  type ='theclass' And schoolid='{$schoolid}' $condition ORDER BY parentid ASC ");
				foreach($datas as $key => $row){
					$allstus = pdo_fetchall("SELECT id,s_name,icon FROM ".tablename('wx_school_students')." WHERE schoolid = '{$schoolid}' And bj_id ='{$row['sid']}' ORDER BY id ASC ");
					foreach($allstus as $ks =>$is){
						if($is['icon']){
							$allstus[$ks]['icon'] = tomedia($is['icon']);
						}else{
							$allstus[$ks]['icon'] = tomedia($school['spic']);
						}
					}
					$datas[$key]['allstu'] = $allstus;
					$total = pdo_fetchcolumn("select COUNT(id) FROM ".tablename('wx_school_students')." WHERE bj_id = '{$row['sid']}' ");
					$datas[$key]['sname'] = $row['sname'].'('.$total.'人)';
					if($row['is_over'] == 2){
						$datas[$key]['info'] = '--(已毕业)';
						if($is_over == 1){
							unset($datas[$key]);
						}
					}
				}
			}
		}else{ //普通老师取授课班级
			if($schooltype){//年级主任取管辖班级和授课班级
				$datas = $kclist;
			}else{
				$datas = $bjlists;//默认取未毕业班级
			}	
		}
	}
	$datas = array_sorts($datas,'is_over','asc');
	return $datas;
}

function get_myskbj($tid){ //根据tid查询授课班级包含毕业班
	$bjlist = pdo_fetchall("SELECT bj_id  FROM ".tablename('wx_school_user_class')." WHERE tid = :tid  ", array(':tid' => $tid));
	return $bjlist;	
}

function is_xiaozhang($tid){
	 $teacher = pdo_fetch("SELECT status FROM " . tablename('wx_school_teachers') . " where id = :id", array(':id' => $tid));
	if($teacher['status'] == 2){
		return true;
	}else{
		return false;
	}	
}


?>