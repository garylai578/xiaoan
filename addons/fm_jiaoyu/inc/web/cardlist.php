<?php
/**
 * 微教育模块
 *
 * @author 高贵血迹
 */
global $_GPC, $_W;

$weid              = $_W['uniacid'];
$action            = 'cardlist';
$this1             = 'no5';
$GLOBALS['frames'] = $this->getNaveMenu($_GPC['schoolid'], $action);
$schoolid          = intval($_GPC['schoolid']);
$logo              = pdo_fetch("SELECT logo,title,spic,is_cardlist FROM " . tablename($this->table_index) . " WHERE id = '{$schoolid}'");
$bj 			   = pdo_fetchall("SELECT * FROM " . tablename($this->table_classify) . " where weid = :weid AND schoolid = :schoolid And type = :type ORDER BY ssort DESC", array(':weid' => $weid, ':type' => 'theclass', ':schoolid' => $schoolid));
$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
$tid_global = $_W['tid'];
if($operation == 'post'){
	if (!(IsHasQx($tid_global,1002502,1,$schoolid))){
		$this->imessage('非法访问，您无权操作该页面','','error');	
	}
    load()->func('tpl');
    $id = intval($_GPC['id']);
	$card = empty($_GPC['idcard_sd'])? trim($_GPC['idcard_kk']) : trim($_GPC['idcard_sd']);
    if(!empty($id)){
        $item    = pdo_fetch("SELECT * FROM " . tablename($this->table_idcard) . " WHERE id = :id", array(':id' => $id));
        $student = pdo_fetch("SELECT * FROM " . tablename($this->table_students) . " where id = :id ", array(':id' => $item['sid']));
        $teacher = pdo_fetch("SELECT * FROM " . tablename($this->table_teachers) . " where id = :id ", array(':id' => $item['tid']));
        $bj      = pdo_fetch("SELECT * FROM " . tablename($this->table_classify) . " where sid = :sid ", array(':sid' => $item['bj_id']));
		$allcard_no    = pdo_fetchall("SELECT * FROM " . tablename($this->table_idcard) . " WHERE schoolid = :schoolid And sid = :sid And tid =:tid", array(':schoolid' => $schoolid,':sid' => '0',':tid' => '0'));
        if(empty($item)){
            $this->imessage('抱歉，本条信息不存在在或是已经删除！', '', 'error');
        }
    }
    if(checksubmit('submit')){
        $data = array(
			'idcard' => trim($card),
            'severend' => strtotime($_GPC['severend'])
        );
		if(!empty($id)){
			if($_GPC['idcard_sd']){
				if($_GPC['idcard_sd'] != $item['idcard']){
					$idcard = pdo_fetch("SELECT * FROM " . tablename($this->table_idcard) . " WHERE idcard = :idcard And schoolid = :schoolid", array(':idcard' => trim($_GPC['idcard_sd']),':schoolid' => $schoolid));
					if($idcard){
						$this->imessage('抱歉，本卡号已经存在,请检查卡库！', '', 'error');
					}
				}
			}
		}
        if(empty($id)){
            $this->imessage('抱歉，本条信息不存在在或是已经删除！', '', 'error');
        }else{
            pdo_update($this->table_idcard, $data, array('id' => $id));
        }
        $this->imessage('修改成功！', $this->createWebUrl('cardlist', array('op' => 'display', 'schoolid' => $schoolid)), 'success');
    }
}elseif($operation == 'display'){
	if (!(IsHasQx($tid_global,1002501,1,$schoolid))){
		$this->imessage('非法访问，您无权操作该页面','','error');	
	}
    $pindex    = max(1, intval($_GPC['page']));
    $psize     = 30;
    $condition = '';

    if(!empty($_GPC['idcard'])){
        $cid       = $_GPC['idcard'];
        $condition .= " AND idcard LIKE '%{$cid}%'";
    }
	
    if(!empty($_GPC['s_name'])){
        $s_name       = trim($_GPC['s_name']);
		if($_GPC['bj_id'] != 0){
			$student = pdo_fetch("SELECT id FROM " . tablename($this->table_students) . " where schoolid = '{$schoolid}' And bj_id = '{$_GPC['bj_id']}' And s_name = '{$s_name}' ");
		}else{
			$this->imessage('抱歉，精确搜索学生请选择班级！', '', 'error');
		}
		if($student){
			$condition   .= " AND sid = '{$student['id']}' ";
		}
    }

    if(!empty($_GPC['tname'])){
        $tname       = trim($_GPC['tname']);
		$condition   .= " AND pname LIKE '%{$tname}%'";
    }	

    if(!empty($_GPC['bj_id']) && empty($_GPC['s_name'])){
        $bj_id     = intval($_GPC['bj_id']);
        $condition .= " AND bj_id = '{$bj_id}'";
    }

    if($_GPC['type'] == 1){
        $condition .= " AND sid >= 1";
    }
    if($_GPC['type'] == 2){
        $condition .= " AND tid >= 1";
    }
    if($_GPC['type'] == 3){
        $condition .= " AND sid < 1 AND tid < 1";
    }
    $list = pdo_fetchall("SELECT * FROM " . tablename($this->table_idcard) . " WHERE weid = '{$weid}' AND schoolid = '{$schoolid}' $condition ORDER BY sid DESC, tid DESC, id DESC LIMIT " . ($pindex - 1) * $psize . ',' . $psize);
    foreach($list as $key => $row){
        $student              = pdo_fetch("SELECT * FROM " . tablename($this->table_students) . " where id = :id ", array(':id' => $row['sid']));
        $teacher              = pdo_fetch("SELECT * FROM " . tablename($this->table_teachers) . " where id = :id ", array(':id' => $row['tid']));
        $bjlist               = pdo_fetch("SELECT * FROM " . tablename($this->table_classify) . " where sid = :sid ", array(':sid' => $row['bj_id']));
        $jxlog                = pdo_fetchall("SELECT * FROM " . tablename($this->table_checklog) . " where cardid = :cardid", array(':cardid' => $row['idcard']));
        $list[$key]['s_name'] = $student['s_name'];
        $list[$key]['tname']  = $teacher['tname'];
        $list[$key]['bjname'] = $bjlist['sname'];
        $list[$key]['num']    = count($jxlog);
    }
    $total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename($this->table_idcard) . " WHERE weid = '{$weid}' AND schoolid = '{$schoolid}' $condition");
    $pager = pagination($total, $pindex, $psize);
	$xskshl = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename($this->table_idcard) . " WHERE weid = '{$weid}' AND schoolid = '{$schoolid}'  AND sid != 0 ");	
	$jskshl = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename($this->table_idcard) . " WHERE weid = '{$weid}' AND schoolid = '{$schoolid}'  AND tid != 0 ");
	$kksm = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename($this->table_idcard) . " WHERE weid = '{$weid}' AND schoolid = '{$schoolid}'  AND tid = 0 AND sid = 0");
	//////////导出空卡/////////////////
	if($_GPC['out_put'] == 'out_put'){
		$listss = pdo_fetchall("SELECT * FROM " . tablename($this->table_idcard) . " WHERE weid = '{$weid}' AND schoolid = '{$schoolid}' And sid = 0 And tid = 0 ORDER BY id DESC");
		if($listss){
			$ii   = 0;
			foreach($listss as $index => $row){
				$arr[$ii]['idcard'] = 's'.$row['idcard'];
				$ii++;
			}
			$this->exportexcel($arr, array('卡号'), '空卡');
			exit();
		}else{
			$this->imessage('抱歉，本校无可用空卡号,请联系管理添加！');
		}
	}	
}elseif($operation == 'change_endtime'){
	$rowcount    = 0;
	$notrowcount = 0;
	$setendtime = strtotime($_GPC['setendtime']);			
	foreach($_GPC['idArr'] as $k => $id){
		$id = intval($id);
		$checkcard = pdo_fetch("SELECT * FROM " . tablename($this->table_idcard) . " WHERE id = :id", array(':id' => $id));
		if($checkcard){
			pdo_update($this->table_idcard, array('severend' => $setendtime), array('id' => $id));
			$rowcount++;
		}else{
			$notrowcount++;
			continue;			
		}
	}
	$data ['result'] = true;
	$data ['msg'] = "操作成功！共修改{$rowcount}张卡,{$notrowcount}张不能修改!";
	die (json_encode($data));
	exit;
}elseif($operation == 'jiebang'){
    $id  = intval($_GPC['id']);
    $row = pdo_fetch("SELECT sid FROM " . tablename($this->table_idcard) . " WHERE id = :id", array(':id' => $id));
    if(empty($row)){
        $this->imessage('抱歉，本卡不存在或是已经被删除！');
    }
    $temp = array(
        'sid'        => 0,
        'tid'        => 0,
        'pard'       => 0,
        'bj_id'      => 0,
        'usertype'   => 3,
        'createtime' => '',
        'pname'      => '',
        'severend'   => '',
        'spic'       => '',
        'tpic'       => '',
    );
    pdo_delete($this->table_checklog, array('sid' => $row['sid']));
    pdo_update($this->table_idcard, $temp, array('id' => $id));
    $this->imessage('解绑成功！', referer(), 'success');
}elseif($operation == 'delete'){
    $id = intval($_GPC['id']);
    if(empty($id)){
        $this->imessage('抱歉，本条信息不存在在或是已经被删除！');
    }
    pdo_delete($this->table_idcard, array('id' => $id));
    $this->imessage('删除成功！', referer(), 'success');
}elseif($operation == 'deleteall'){
    $rowcount    = 0;
    $notrowcount = 0;
    foreach($_GPC['idArr'] as $k => $id){
        $id = intval($id);
        if(!empty($id)){
            $goods = pdo_fetch("SELECT * FROM " . tablename($this->table_idcard) . " WHERE id = :id", array(':id' => $id));
            if(empty($goods)){
                $notrowcount++;
                continue;
            }
            pdo_delete($this->table_idcard, array('id' => $id, 'weid' => $weid));
            $rowcount++;
        }
    }
    $data ['result'] = true;

    $data ['msg'] = "操作成功！共删除{$rowcount}条数据,{$notrowcount}条数据不能删除!";

    die (json_encode($data));	
}
include $this->template('web/cardlist');
?>