<?php
/**
 * 微教育模块
 *
 * @author 高贵血迹
 */
global $_GPC, $_W;

$weid = $_W['uniacid'];
$this1 = 'no2';
$action = 'kecheng';
$schoolid = intval($_GPC['schoolid']);


$GLOBALS['frames'] = $this->getNaveMenu($_GPC['schoolid'],$action);
$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
$logo = pdo_fetch("SELECT logo,title,is_cost,tpic,spic FROM " . tablename($this->table_index) . " WHERE id = '{$schoolid}'");
$tid_global = $_W['tid'];
if($tid_global !='founder' && $tid_global != 'owner'){
	$loginTeaFzid =  pdo_fetch("SELECT fz_id FROM " . tablename ($this->table_teachers) . " where weid = :weid And schoolid = :schoolid And id =:id ", array(':weid' => $weid,':schoolid' => $schoolid,':id'=>$tid_global));
	$qxarr = GetQxByFz($loginTeaFzid['fz_id'],1,$schoolid);
}
if (!(IsHasQx($tid_global,1000959,1,$schoolid))){
	$this->imessage('非法访问，您无权操作该页面','','error');	
}
if ($operation == 'gettongji_gkk'){


	
		$gkkid = $_GPC['gkkid'];
		$schoolid = $_GPC['schoolid'];
		$weid = $_W['uniacid'];
	
	$gkkpjinfo = pdo_fetchall("SELECT distinct iconid FROM " . tablename($this->table_gkkpj) . " where gkkid =:gkkid and schoolid = :schoolid  AND weid = :weid ", array(':gkkid'=>$gkkid,  ':schoolid' =>$schoolid, ':weid' => $weid ));

	 $gkkall = pdo_fetchall('SELECT id,name FROM ' . tablename($this->table_gongkaike) . " WHERE weid = '{$weid}' AND schoolid = '{$schoolid}' ");
	foreach( $gkkpjinfo as $key => $value )
	{
		if($value['iconid'])
		{
			$level1 = pdo_fetchcolumn("SELECT count(*) FROM " . tablename('wx_school_gkkpj') . " where gkkid= :gkkid AND schoolid = :schoolid  AND weid = :weid And iconid =:iconid AND iconlevel = :iconlevel", array( ':gkkid' =>$gkkid, ':schoolid' =>$schoolid, ':weid' => $weid,':iconid'=>$value['iconid'],':iconlevel'=> 1 ));
			$level2 = pdo_fetchcolumn("SELECT count(*) FROM " . tablename('wx_school_gkkpj') . " where gkkid= :gkkid AND schoolid = :schoolid  AND weid = :weid And iconid =:iconid AND iconlevel = :iconlevel", array( ':gkkid' =>$gkkid, ':schoolid' =>$schoolid, ':weid' => $weid,':iconid'=>$value['iconid'],':iconlevel'=> 2 ));
			$level3 = pdo_fetchcolumn("SELECT count(*) FROM " . tablename('wx_school_gkkpj') . " where gkkid= :gkkid AND schoolid = :schoolid  AND weid = :weid And iconid =:iconid AND iconlevel = :iconlevel", array( ':gkkid' =>$gkkid, ':schoolid' =>$schoolid, ':weid' => $weid,':iconid'=>$value['iconid'],':iconlevel'=> 3 ));
			$level4 = pdo_fetchcolumn("SELECT count(*) FROM " . tablename('wx_school_gkkpj') . " where gkkid= :gkkid AND schoolid = :schoolid  AND weid = :weid And iconid =:iconid AND iconlevel = :iconlevel", array( ':gkkid' =>$gkkid, ':schoolid' =>$schoolid, ':weid' => $weid,':iconid'=>$value['iconid'],':iconlevel'=> 4 ));
			$level5 = pdo_fetchcolumn("SELECT count(*) FROM " . tablename('wx_school_gkkpj') . " where gkkid= :gkkid AND schoolid = :schoolid  AND weid = :weid And iconid =:iconid AND iconlevel = :iconlevel", array( ':gkkid' =>$gkkid, ':schoolid' =>$schoolid, ':weid' => $weid,':iconid'=>$value['iconid'],':iconlevel'=> 5 ));
			$xiangmu = pdo_fetch("SELECT * FROM " . tablename('wx_school_gkkpjk') . " where  schoolid = :schoolid  AND weid = :weid And id =:id ", array(':schoolid' =>$schoolid, ':weid' => $weid,':id'=>$value['iconid'] ));
			
			$JieGuo_temp = array(
				'question_content' => $xiangmu['title'],
			);

			$key_temp  ;
			if(!empty( $xiangmu['icon1title']))
			{
				$key_temp[0]['name'] = $xiangmu['icon1title'];
				$key_temp[0]['content'] = $xiangmu['icon1title'];
				$key_temp[0]['y'] = intval($level1);
			}
		
			if(!empty( $xiangmu['icon2title']))
			{
				$key_temp[1]['name'] = $xiangmu['icon2title'];
				$key_temp[1]['content'] = $xiangmu['icon21title'];
				$key_temp[1]['y'] =intval( $level2);
			}
			if(!empty( $xiangmu['icon3title']))
			{
				$key_temp[2]['name'] = $xiangmu['icon3title'];
				$key_temp[2]['content'] = $xiangmu['icon3title'];
				$key_temp[2]['y'] = intval($level3);
			}
			if(!empty( $xiangmu['icon4title']))
			{
				$key_temp[3]['name'] = $xiangmu['icon4title'];
				$key_temp[3]['content'] = $xiangmu['icon4title'];
				$key_temp[3]['y'] = intval($level4);
			}
			if(!empty( $xiangmu['icon5title']))
			{
				$key_temp[4]['name'] = $xiangmu['icon5title'];
				$key_temp[4]['content'] = $xiangmu['icon5title'];
				$key_temp[4]['y'] = intval($level5);
			}

			$str = json_encode($key_temp);
			 $do_str =  substr($str, 1,strlen($str)-2);
			$JieGuo_temp['question_data'] = $do_str ;
			
			$JieGuo_temp11 = array( $JieGuo_temp);
			$fanhui = json_encode($JieGuo_temp11);
			$fanhui1 = '"{'.$fanhui.'}"';
			
			$backinfo[] = $JieGuo_temp;
			unset($key_temp);
		}
		
	}
	
 include $this->template ( 'web/gkkpjtj' );
}

if ($operation == 'gettongji_js'){
		$teaname = $_GPC['t_name'];
$teacher =  pdo_fetch("SELECT id FROM " . tablename($this->table_teachers) . " where tname =:name and schoolid = :schoolid  AND weid = :weid ", array(':name'=>$teaname,  ':schoolid' =>$schoolid, ':weid' => $weid ));
	var_dump($teacher);
	$tid =$teacher['id']; 
		$gkkid = $_GPC['gkkid'];
		$schoolid = $_GPC['schoolid'];
		$weid = $_W['uniacid'];
	
	$gkkpjinfo = pdo_fetchall("SELECT distinct iconid FROM " . tablename($this->table_gkkpj) . " where tid =:tid and schoolid = :schoolid  AND weid = :weid ", array(':tid'=>$tid,  ':schoolid' =>$schoolid, ':weid' => $weid ));

	 $gkkall = pdo_fetchall('SELECT id,name FROM ' . tablename($this->table_gongkaike) . " WHERE weid = '{$weid}' AND schoolid = '{$schoolid}' ");
	foreach( $gkkpjinfo as $key => $value )
	{
		if($value['iconid'])
		{
			$level1 = pdo_fetchcolumn("SELECT count(*) FROM " . tablename('wx_school_gkkpj') . " where tid= :tid AND schoolid = :schoolid  AND weid = :weid And iconid =:iconid AND iconlevel = :iconlevel", array( ':tid' =>$tid, ':schoolid' =>$schoolid, ':weid' => $weid,':iconid'=>$value['iconid'],':iconlevel'=> 1 ));
			$level2 = pdo_fetchcolumn("SELECT count(*) FROM " . tablename('wx_school_gkkpj') . " where tid= :tid AND schoolid = :schoolid  AND weid = :weid And iconid =:iconid AND iconlevel = :iconlevel", array( ':tid' =>$tid, ':schoolid' =>$schoolid, ':weid' => $weid,':iconid'=>$value['iconid'],':iconlevel'=> 2 ));
			$level3 = pdo_fetchcolumn("SELECT count(*) FROM " . tablename('wx_school_gkkpj') . " where tid= :tid AND schoolid = :schoolid  AND weid = :weid And iconid =:iconid AND iconlevel = :iconlevel", array( ':tid' =>$tid, ':schoolid' =>$schoolid, ':weid' => $weid,':iconid'=>$value['iconid'],':iconlevel'=> 3 ));
			$level4 = pdo_fetchcolumn("SELECT count(*) FROM " . tablename('wx_school_gkkpj') . " where tid= :tid AND schoolid = :schoolid  AND weid = :weid And iconid =:iconid AND iconlevel = :iconlevel", array( ':tid' =>$tid, ':schoolid' =>$schoolid, ':weid' => $weid,':iconid'=>$value['iconid'],':iconlevel'=> 4 ));
			$level5 = pdo_fetchcolumn("SELECT count(*) FROM " . tablename('wx_school_gkkpj') . " where tid= :tid AND schoolid = :schoolid  AND weid = :weid And iconid =:iconid AND iconlevel = :iconlevel", array( ':tid' =>$tid, ':schoolid' =>$schoolid, ':weid' => $weid,':iconid'=>$value['iconid'],':iconlevel'=> 5 ));
			$xiangmu = pdo_fetch("SELECT * FROM " . tablename('wx_school_gkkpjk') . " where  schoolid = :schoolid  AND weid = :weid And id =:id ", array(':schoolid' =>$schoolid, ':weid' => $weid,':id'=>$value['iconid'] ));
			
			$JieGuo_temp = array(
				'question_content' => $xiangmu['title'],
			);

			$key_temp  ;
			if(!empty( $xiangmu['icon1title']))
			{
				$key_temp[0]['name'] = $xiangmu['icon1title'];
				$key_temp[0]['content'] = $xiangmu['icon1title'];
				$key_temp[0]['y'] = intval($level1);
			}
		
			if(!empty( $xiangmu['icon2title']))
			{
				$key_temp[1]['name'] = $xiangmu['icon2title'];
				$key_temp[1]['content'] = $xiangmu['icon21title'];
				$key_temp[1]['y'] =intval( $level2);
			}
			if(!empty( $xiangmu['icon3title']))
			{
				$key_temp[2]['name'] = $xiangmu['icon3title'];
				$key_temp[2]['content'] = $xiangmu['icon3title'];
				$key_temp[2]['y'] = intval($level3);
			}
			if(!empty( $xiangmu['icon4title']))
			{
				$key_temp[3]['name'] = $xiangmu['icon4title'];
				$key_temp[3]['content'] = $xiangmu['icon4title'];
				$key_temp[3]['y'] = intval($level4);
			}
			if(!empty( $xiangmu['icon5title']))
			{
				$key_temp[4]['name'] = $xiangmu['icon5title'];
				$key_temp[4]['content'] = $xiangmu['icon5title'];
				$key_temp[4]['y'] = intval($level5);
			}

			$str = json_encode($key_temp);
			 $do_str =  substr($str, 1,strlen($str)-2);
			$JieGuo_temp['question_data'] = $do_str ;
			
			$JieGuo_temp11 = array( $JieGuo_temp);
			$fanhui = json_encode($JieGuo_temp11);
			$fanhui1 = '"{'.$fanhui.'}"';
			
			$backinfo[] = $JieGuo_temp;
			unset($key_temp);
		}
		
	}
	
 include $this->template ( 'web/gkkpjtj' );
}	

elseif ($operation == 'display') {
    if(!empty($_GPC['addtime'])) {
        $starttime = strtotime($_GPC['addtime']['start']);
        $endtime = strtotime($_GPC['addtime']['end']) + 86399;
        $condition1 .= " AND createtime > '{$starttime}' AND createtime < '{$endtime}'";
        $condition5 .= " AND createtime > '{$_GPC['addtime']['start']}' AND createtime < '{$_GPC['addtime']['end']}'";
        $condition6 .= " AND createdate > '{$starttime}' AND createdate < '{$endtime}'";
        $condition7 .= " AND jiontime > '{$starttime}' AND jiontime < '{$endtime}'";
        $condition2 .= " AND paytime > '{$starttime}' AND paytime < '{$endtime}'";
    } else {
        $starttime = strtotime('-180 day');
        $endtime = TIMESTAMP;
    }

 $gkkall = pdo_fetchall('SELECT id,name FROM ' . tablename($this->table_gongkaike) . " WHERE weid = '{$weid}' AND schoolid = '{$schoolid}' ");

    

    $start = mktime(0,0,0,date("m"),date("d"),date("Y"));
    $end = $start + 86399;
    $condition3 .= " AND createtime > '{$start}' AND createtime < '{$end}'";
    $condition4 .= " AND paytime > '{$start}' AND paytime < '{$end}'";
    $params[':start'] = $starttime;
    $params[':end'] = $endtime;
    $bm = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename($this->table_signup) . " WHERE weid = '{$weid}' AND schoolid = '{$schoolid}' ");
    $bjq = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename($this->table_bjq) . " WHERE weid = '{$weid}' AND schoolid = '{$schoolid}' ");
    $kq = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename($this->table_checklog) . " WHERE weid = '{$weid}' AND schoolid = '{$schoolid}' ");
    $dd = pdo_fetchall('SELECT SUM(cose) FROM ' . tablename($this->table_order) . " WHERE weid = '{$weid}' AND schoolid = '{$schoolid}' AND status = 2 ");

    $ddzj = $dd[0]['SUM(cose)'];
    $baom = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename($this->table_signup) . " WHERE weid = '{$weid}' AND schoolid = '{$schoolid}' $condition3");
    $bjqz = pdo_fetchcolumn('SELECT COUNT(1) FROM ' . tablename($this->table_bjq) . " WHERE weid = '{$weid}' AND schoolid = '{$schoolid}' $condition3");
    $checklog = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename($this->table_checklog) . " WHERE weid = '{$weid}' And schoolid = '{$schoolid}' And isconfirm = 1 $condition3");
    $cost = pdo_fetchall('SELECT SUM(cose) FROM ' . tablename($this->table_order) . " WHERE weid = '{$weid}' AND schoolid = '{$schoolid}' AND status = 2 $condition4");
    $cose = $cost[0]['SUM(cose)'];
    $ybjs = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename($this->table_user) . " WHERE weid = '{$weid}' AND schoolid = '{$schoolid}' AND sid = 0 $condition5");
    $ybxs = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename($this->table_user) . " WHERE weid = '{$weid}' AND schoolid = '{$schoolid}' AND tid = 0 $condition5");
    $baomzj = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename($this->table_signup) . " WHERE weid = '{$weid}' AND schoolid = '{$schoolid}' $condition1");
    $bjqzj = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename($this->table_bjq) . " WHERE weid = '{$weid}' AND schoolid = '{$schoolid}' $condition1");
    $checklogzj = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename($this->table_checklog) . " WHERE weid = '{$weid}' AND schoolid = '{$schoolid}' $condition1");
    $xczj = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename($this->table_media) . " WHERE weid = '{$weid}' AND schoolid = '{$schoolid}' $condition1");
    $jszj = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename($this->table_teachers) . " WHERE weid = '{$weid}' AND schoolid = '{$schoolid}' $condition7");
    $xszj = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename($this->table_students) . " WHERE weid = '{$weid}' AND schoolid = '{$schoolid}' $condition6");
    $cost1 = pdo_fetchall('SELECT SUM(cose) FROM ' . tablename($this->table_order) . " WHERE weid = '{$weid}' AND schoolid = '{$schoolid}' AND status = 2 $condition2");
    $cose1 = $cost1[0]['SUM(cose)'];
    $count = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename($this->table_order) . " WHERE weid = '{$weid}' AND schoolid = '{$schoolid}'  $condition2 ");
    $data = pdo_fetchall('SELECT * FROM ' . tablename($this->table_order) . " WHERE weid = '{$weid}' AND schoolid = '{$schoolid}' $condition2 ORDER BY paytime DESC LIMIT 0,20");
    $total = array();
    if(!empty($data)) {
        foreach($data as &$da) {
            $total_price = $da['cose'];
            $key = date('Y-m-d', $da['paytime']);
            $return[$key]['cose'] += $total_price;
            $return[$key]['count'] += 1;
            $total['total_price'] += $total_price;
            $total['total_count'] += 1;
            if($da['paytype'] == '1') {
                $return[$key]['1'] += $total_price;
                $total['total_alipay'] += $total_price;
            } elseif($da['paytype'] == '2') {
                $return[$key]['2'] += $total_price;
                $total['total_wechat'] += $total_price;
            }
        }
    }

    $lastbjq = pdo_fetchall("SELECT uid,shername,createtime,content,isopen,bj_id1,msgtype FROM " . tablename($this->table_bjq) . " where schoolid = '{$schoolid}' And weid = '{$weid}' And type = 0 ORDER BY createtime DESC LIMIT 0,10");
    foreach ($lastbjq as $index => $row) {
        $member = pdo_fetch("SELECT * FROM " . tablename ( 'mc_members' ) . " where uniacid = :uniacid And uid = :uid ORDER BY uid ASC", array(':uniacid' => $weid, ':uid' => $row['uid']));
        $bj = pdo_fetch("SELECT sname FROM " . tablename($this->table_classify) . " WHERE sid = :sid", array(':sid' => $row['bj_id1']));
        $lastbjq[$index]['bjname'] = $bj['sname'];
        $lastbjq[$index]['avatar'] = $member['avatar'];
        $lastbjq[$index]['time'] = sub_day($row['createtime']);
    }
    $lasttz = pdo_fetchall("SELECT * FROM ".tablename($this->table_notice)." WHERE weid = '{$weid}' And schoolid = '{$schoolid}' ORDER BY createtime DESC LIMIT 0,10");
    foreach($lasttz as $key => $row){
        $bj = pdo_fetch("SELECT sname FROM " . tablename($this->table_classify) . " WHERE sid = :sid", array(':sid' => $row['bj_id']));
        $ls = pdo_fetch("SELECT thumb FROM " . tablename($this->table_teachers) . " WHERE id = :id", array(':id' => $row['tid']));
        $lasttz[$key]['bjname'] = $bj['sname'];
        $lasttz[$key]['thumb'] = $ls['thumb'];
        $lasttz[$key]['time'] = sub_day($row['createtime']);
    }
    $lastkq = pdo_fetchall("SELECT * FROM " . tablename($this->table_checklog) . " WHERE weid = '{$weid}' AND schoolid = '{$schoolid}' ORDER BY createtime DESC LIMIT 0,10");
    foreach($lastkq as $index =>$row){
        $student = pdo_fetch("SELECT s_name,icon FROM " . tablename($this->table_students) . " WHERE id = '{$row['sid']}' ");
        $teacher = pdo_fetch("SELECT tname FROM " . tablename($this->table_teachers) . " WHERE id = '{$row['tid']}' ");
        $qdtid = pdo_fetch("SELECT tname,thumb FROM " . tablename($this->table_teachers) . " WHERE id = '{$row['qdtid']}' ");
        $idcard = pdo_fetch("SELECT pname FROM " . tablename($this->table_idcard) . " WHERE idcard = '{$row['cardid']}' ");
        $mac = pdo_fetch("SELECT name FROM " . tablename($this->table_checkmac) . " WHERE schoolid = '{$row['schoolid']}' And id = '{$row['macid']}' ");
        $banji = pdo_fetch("SELECT sname FROM " . tablename($this->table_classify) . " WHERE sid = '{$row['bj_id']}' ");
        $lastkq[$index]['s_name'] = $student['s_name'];
        $lastkq[$index]['sicon'] = $student['icon'];
        $lastkq[$index]['tname'] = $teacher['tname'];
        $lastkq[$index]['thumb'] = $teacher['thumb'];
        $lastkq[$index]['qdtname'] = $qdtid['tname'];
        $lastkq[$index]['mac'] = $mac['name'];
        $lastkq[$index]['pname'] = $idcard['pname'];
        $lastkq[$index]['bj_name'] = $banji['sname'];
        $lastkq[$index]['time'] = sub_day($row['createtime']);
    }

    include $this->template ( 'web/gkkpjtj' );
}




?>