<?php

/**
 * 微教育模块
 *
 * @author 高贵血迹
 */

global $_GPC, $_W;
$weid              = $_W['uniacid'];
$action            = 'checkdateset';
$this1             = 'no5';
$GLOBALS['frames'] = $this->getNaveMenu($_GPC['schoolid'], $action);
$schoolid          = intval($_GPC['schoolid']);
$logo              = pdo_fetch("SELECT logo,title FROM " . tablename($this->table_index) . " WHERE id = '{$schoolid}'");

$id = intval($_GPC['id']);


$checksetinfo = pdo_fetch("SELECT * FROM " . tablename($this->table_checkdateset) . " where weid = '{$weid}' And schoolid = '{$schoolid}' And id = '{$id}' ");

$workdayset = pdo_fetchall("SELECT start,end FROM " . tablename($this->table_checktimeset) . " where weid = '{$weid}' And schoolid = '{$schoolid}' And checkdatesetid = '{$id}' and type = 1  ORDER BY id ASC ");
$fridayset = pdo_fetchall("SELECT start,end  FROM " . tablename($this->table_checktimeset) . " where weid = '{$weid}' And schoolid = '{$schoolid}' And checkdatesetid = '{$id}' and type = 2  ORDER BY id ASC ");
$saturdayset = pdo_fetchall("SELECT start,end  FROM " . tablename($this->table_checktimeset) . " where weid = '{$weid}' And schoolid = '{$schoolid}' And checkdatesetid = '{$id}' and type = 3  ORDER BY id ASC ");
$sundayset = pdo_fetchall("SELECT start,end  FROM " . tablename($this->table_checktimeset) . " where weid = '{$weid}' And schoolid = '{$schoolid}' And checkdatesetid = '{$id}' and type = 4  ORDER BY id ASC ");

if(checksubmit('submit')){

	if(!empty($id)){
		pdo_delete($this->table_checktimeset, array('checkdatesetid' => $id,'schoolid'=>$schoolid,'weid'=>$weid,'type'=>1));
		pdo_delete($this->table_checktimeset, array('checkdatesetid' => $id,'schoolid'=>$schoolid,'weid'=>$weid,'type'=>2));
		pdo_delete($this->table_checktimeset, array('checkdatesetid' => $id,'schoolid'=>$schoolid,'weid'=>$weid,'type'=>3));
		pdo_delete($this->table_checktimeset, array('checkdatesetid' => $id,'schoolid'=>$schoolid,'weid'=>$weid,'type'=>4));
		
	}
	for($i=1;$i<=5;$i++){
		$work_name_start = 'work_start'.$i;
		$work_name_end = 'work_end'.$i;
		if(($_GPC[$work_name_start] != '00:00' && !empty($_GPC[$work_name_start])) || ($_GPC[$work_name_end] != '00:00' && !empty($_GPC[$work_name_end] ))){
			$dataw = array(
				'weid'=>$weid,
				'schoolid'=>$schoolid,
				'checkdatesetid' => $id,
				'start' => $_GPC[$work_name_start],
				'end' => $_GPC[$work_name_end],
				'type'=>1
			);
			pdo_insert($this->table_checktimeset, $dataw);
		}
		if($checksetinfo['friday'] == 1){
			$fri_name_start = 'fri_start'.$i;
			$fri_name_end = 'fri_end'.$i;
			if(($_GPC[$fri_name_start] != '00:00' && !empty($_GPC[$fri_name_start])) || ($_GPC[$fri_name_end] != '00:00' && !empty($_GPC[$fri_name_end]))){
				$dataf = array(
					'weid'=>$weid,
					'schoolid'=>$schoolid,
					'checkdatesetid' => $id,
					'start' => $_GPC[$fri_name_start],
					'end' => $_GPC[$fri_name_end],
					'type'=>2
				);
				pdo_insert($this->table_checktimeset, $dataf);
			}
		}
		if($checksetinfo['saturday'] == 1){
			$satur_name_start = 'satur_start'.$i;
			$satur_name_end = 'satur_end'.$i;
			if(($_GPC[$satur_name_start] != '00:00' && !empty($_GPC[$satur_name_start])) || ($_GPC[$satur_name_end] != '00:00' && !empty($_GPC[$satur_name_end]))){
				$datasa = array(
					'weid'=>$weid,
					'schoolid'=>$schoolid,
					'checkdatesetid' => $id,
					'start' => $_GPC[$satur_name_start],
					'end' => $_GPC[$satur_name_end],
					'type'=>3
				);
				pdo_insert($this->table_checktimeset, $datasa);
			}
		}
		if($checksetinfo['sunday'] == 1){
			$sun_name_start = 'sun_start'.$i;
			$sun_name_end = 'sun_end'.$i;
			if(($_GPC[$sun_name_start] != '00:00' && !empty($_GPC[$sun_name_start])) || ($_GPC[$sun_name_end] != '00:00' && !empty($_GPC[$sun_name_end]))){
				$datasu = array(
					'weid'=>$weid,
					'schoolid'=>$schoolid,
					'checkdatesetid' => $id,
					'start' => $_GPC[$sun_name_start],
					'end' => $_GPC[$sun_name_end],
					'type'=>4
				);
				pdo_insert($this->table_checktimeset, $datasu);
			}
		} 
	}

	//var_dump($datesetid);
  $this->imessage('更新时段设置成功！',$this->createWebUrl('checkdateset', array('op' => 'display', 'schoolid' => $schoolid)), 'success');
}

include $this->template('web/checktimeset');
?>