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

?>