<?php
/**
 * 微教育模块
 *
 * @author 高贵血迹
 */
global $_GPC, $_W;

$weid              = $_W['uniacid'];
$action            = 'chengji';
$this1             = 'no2';
$GLOBALS['frames'] = $this->getNaveMenu($_GPC['schoolid'], $action);
$schoolid          = intval($_GPC['schoolid']);
$logo              = pdo_fetch("SELECT logo,title FROM " . tablename($this->table_index) . " WHERE id = '{$schoolid}'");
$km    = pdo_fetchall("SELECT sid,sname FROM " . tablename($this->table_classify) . " where weid = '{$weid}' AND schoolid ={$schoolid} And type = 'subject' ORDER BY ssort DESC", array(':weid' => $weid, ':type' => 'subject', ':schoolid' => $schoolid));
$bj    = pdo_fetchall("SELECT sid,sname FROM " . tablename($this->table_classify) . " where weid = '{$weid}' AND schoolid ={$schoolid} And type = 'theclass' ORDER BY ssort DESC", array(':weid' => $weid, ':type' => 'theclass', ':schoolid' => $schoolid));
$xq    = pdo_fetchall("SELECT sid,sname FROM " . tablename($this->table_classify) . " where weid = '{$weid}' AND schoolid ={$schoolid} And type = 'week' ORDER BY ssort DESC", array(':weid' => $weid, ':type' => 'week', ':schoolid' => $schoolid));
$sd    = pdo_fetchall("SELECT sid,sname FROM " . tablename($this->table_classify) . " where weid = '{$weid}' AND schoolid ={$schoolid} And type = 'timeframe' ORDER BY ssort DESC", array(':weid' => $weid, ':type' => 'timeframe', ':schoolid' => $schoolid));
$qh    = pdo_fetchall("SELECT sid,sname FROM " . tablename($this->table_classify) . " where weid = '{$weid}' AND schoolid ={$schoolid} And type = 'score' ORDER BY ssort DESC", array(':weid' => $weid, ':type' => 'score', ':schoolid' => $schoolid));

$category = pdo_fetchall("SELECT sid,sname FROM " . tablename($this->table_classify) . " WHERE weid =  '{$weid}' AND schoolid ={$schoolid} ORDER BY sid ASC, ssort DESC", array(':weid' => $weid, ':schoolid' => $schoolid), 'sid');

$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
$tid_global = $_W['tid'];
if($operation == 'post'){
	if (!(IsHasQx($tid_global,1000802,1,$schoolid))){
		$this->imessage('非法访问，您无权操作该页面','','error');	
	}
    load()->func('tpl');
    $id = intval($_GPC['id']);
    if(!empty($id)){
        $item    = pdo_fetch("SELECT * FROM " . tablename($this->table_score) . " WHERE id = :id", array(':id' => $id));
        $student = pdo_fetch("SELECT * FROM " . tablename($this->table_students) . " where id = :id ", array(':id' => $item['sid']));
        $bj      = pdo_fetch("SELECT * FROM " . tablename($this->table_classify) . " where sid = :sid ", array(':sid' => $item['bj_id']));
        if(empty($item)){
            $this->imessage('抱歉，本条信息不存在在或是已经删除！', '', 'error');
        }
    }
    if(checksubmit('submit')){
        $data = array(
            'weid'     => $weid,
            'schoolid' => $schoolid,
            'sid'      => intval($_GPC['sid']),
            'km_id'    => trim($_GPC['km']),
            'bj_id'    => trim($_GPC['bj']),
            'qh_id'    => trim($_GPC['qh']),
            'xq_id'    => trim($_GPC['xueqi']),
            'my_score' => trim($_GPC['score']),
            'info'     => trim($_GPC['info']),
        );

        if(empty($id)){
            $this->imessage('抱歉，本条信息不存在在或是已经删除！', '', 'error');
        }else{
            pdo_update($this->table_score, $data, array('id' => $id));
        }
        $this->imessage('修改学生成绩成功！', $this->createWebUrl('chengji', array('op' => 'display', 'schoolid' => $schoolid)), 'success');
    }
}elseif($operation == 'display'){
	if (!(IsHasQx($tid_global,1000801,1,$schoolid))){
		$this->imessage('非法访问，您无权操作该页面','','error');	
	}
    $pindex    = max(1, intval($_GPC['page']));
    $psize     = 20;
    $condition = '';
    if(!empty($_GPC['xsxm'])){
		$students = pdo_fetch("SELECT id FROM " . tablename($this->table_students) . " WHERE schoolid = :schoolid And s_name = :s_name ORDER BY id DESC LIMIT 1", array(':schoolid' => $schoolid,':s_name' => $_GPC['xsxm']));
		$condition .= " AND sid = '{$students['id']}'";		
    }
    if(!empty($_GPC['xuehao'])){
		$students = pdo_fetch("SELECT id FROM " . tablename($this->table_students) . " WHERE schoolid = :schoolid And numberid = :numberid ", array(':schoolid' => $schoolid,':numberid' => $_GPC['xuehao']));
		$condition .= " AND sid = '{$students['id']}'";
    }
    if(!empty($_GPC['qh_id'])){
        $cid       = intval($_GPC['qh_id']);
        $condition .= " AND qh_id = '{$cid}'";
    }
    if(!empty($_GPC['km_id'])){
        $cid       = intval($_GPC['km_id']);
        $condition .= " AND km_id = '{$cid}'";
    }
    $list = pdo_fetchall("SELECT * FROM " . tablename($this->table_score) . " WHERE weid = '{$weid}' AND schoolid = '{$schoolid}' $condition ORDER BY id DESC LIMIT " . ($pindex - 1) * $psize . ',' . $psize);
    foreach($list as $key => $row){
        $student                 = pdo_fetch("SELECT * FROM " . tablename($this->table_students) . " where id = :id ", array(':id' => $row['sid']));
        $list[$key]['s_name']    = $student['s_name'];
        $list[$key]['numberid']  = $student['numberid'];
        $list[$key]['birthdate'] = $student['birthdate'];
        $list[$key]['mobile']    = $student['mobile'];
        $list[$key]['sex']       = $student['sex'];
    }
    $total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename($this->table_score) . " WHERE weid = '{$weid}' AND schoolid = '{$schoolid}' $condition");

    $pager = pagination($total, $pindex, $psize);
}elseif($operation == 'export'){
	if(checksubmit()) {
		if(empty($_GPC['qh_id'])){
			 $this->imessage('抱歉，请先选择期号！','','error');
		}
		$file = upload_file($_FILES['file'], 'excel');
		if(is_error($file)) {
			$this->imessage($file['message'],'','error');
		}
		$data = read_excel($file);
		if(is_error($data)) {
			$this->imessage($data['message'],'','error');
		}
		unset($data[1]);
		if(empty($data)) {
			$this->imessage('没有要导入的数据','','error');
		}
		$suc_num = 0;
		$def_num = 0;
		$line = "";
		foreach($data as $key => $strs) {
			$banji = pdo_fetch("SELECT sid FROM " . tablename($this->table_classify) . " WHERE sname=:sname And schoolid=:schoolid ", array(':sname' => trim($strs[1]), ':schoolid'=> $schoolid));
			//名字处理
			$stu = pdo_fetch("SELECT id FROM " . tablename($this->table_students) . " WHERE s_name=:s_name And schoolid=:schoolid And bj_id = :bj_id ", array(':s_name' => trim($strs[0]),':bj_id' => $banji['sid'], ':schoolid'=> $schoolid));
			//科目处理
			$kemu = pdo_fetch("SELECT sid FROM " . tablename($this->table_classify) . " WHERE sname=:sname And schoolid=:schoolid ", array(':sname' => trim($strs[2]), ':schoolid'=> $schoolid));
			//年级处理
			$xueqi = pdo_fetch("SELECT parentid FROM " . tablename('wx_school_classify') . " WHERE sid=:sid  And schoolid=:schoolid ", array(':sid' => $banji['sid'],  ':schoolid'=>$schoolid));
			if(empty($banji) || empty($stu) || empty($kemu)){
				$def_num++;
				$line .= $key.",";
				continue;
			}else{
				$insert = array(
					'weid' => $weid,
					'schoolid' => $schoolid,
					'sid' => $stu['id'],
					'xq_id' => $xueqi['parentid'],
					'qh_id' => $_GPC['qh_id'],
					'bj_id' => $banji['sid'],
					'km_id' => $kemu['sid'],
					'my_score' => trim($strs[3]),
					'info' => intval($strs[4]),
					'createtime' => time()
				);
				pdo_insert($this->table_score, $insert);
				$score_id = pdo_insertid();
				$suc_num++;
			}
		}
		$errline = "其中第".$line."行,数据无法插入,请检查";
		$this->imessage('导入成功'.$suc_num.'条成绩，失败'.$def_num.'条,'.$errline.'', $this->createWebUrl('chengji', array('op' => 'display', 'schoolid' => $schoolid)), 'success');
	}
}elseif($operation == 'delete'){
    $id = intval($_GPC['id']);
    if(empty($id)){
        $this->imessage('抱歉，本条信息不存在在或是已经被删除！');
    }
    pdo_delete($this->table_score, array('id' => $id));
    $this->imessage('删除成功！', referer(), 'success');
}elseif($operation == 'deleteall'){
    $rowcount    = 0;
    $notrowcount = 0;
    foreach($_GPC['idArr'] as $k => $id){
        $id = intval($id);
        if(!empty($id)){
            $goods = pdo_fetch("SELECT * FROM " . tablename($this->table_score) . " WHERE id = :id", array(':id' => $id));
            if(empty($goods)){
                $notrowcount++;
                continue;
            }
            pdo_delete($this->table_score, array('id' => $id, 'weid' => $weid));
            $rowcount++;
        }
    }
    $message = "操作成功！共删除{$rowcount}条数据,{$notrowcount}条数据不能删除!";

    $data ['result'] = true;

    $data ['msg'] = $message;

    die (json_encode($data));
}
include $this->template('web/chengji');
?>