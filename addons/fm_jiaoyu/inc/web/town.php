<?php
/**
 * 微教育模块
 *
 * @author 高贵血迹
 */
global $_GPC, $_W;

$weid = $_W['uniacid'];
$this1 = 'no1';
$action = 'town';   //和core.php的135行对应
if($_W['os'] == 'mobile' && (!empty($_GPC['i']) || !empty($_SERVER['QUERY_STRING']))) {
    //$this->imessage('抱歉，请在电脑端打开本后台！', referer(), 'error');
}
$schoolid = $_GPC['schoolid'];
$GLOBALS['frames'] = $this->getNaveMenu($_GPC['schoolid'],$action);
$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
$logo = pdo_fetch("SELECT logo,title,is_cost,tpic,spic,issale FROM " . tablename($this->table_index) . " WHERE id = '{$schoolid}'");
$schooltype  = $_W['schooltype'];
$schooltypes = unitchecksctype();
if ($operation == 'display') {
    $nowdatatype = SchoolTypeFromLocal($schoolid,$weid);
    $rlsrll = $_W['siteroot'] . 'web/index.php?c=site&a=entry&schoolid=' . $schoolid . '&do=indexajax&op=changeschooltype&m=fm_jiaoyu';
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

    $start = mktime(0,0,0,date("m"),date("d"),date("Y"));
    $end = $start + 86399;
    $condition3 .= " AND createtime > '{$start}' AND createtime < '{$end}'";
    $condition4 .= " AND paytime > '{$start}' AND paytime < '{$end}'";
    $params[':start'] = $starttime;
    $params[':end'] = $endtime;
    /*$bm = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename($this->table_signup) . " WHERE weid = '{$weid}' AND schoolid = '{$schoolid}' ");
    $bjq = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename($this->table_bjq) . " WHERE weid = '{$weid}' AND schoolid = '{$schoolid}' ");
    $kq = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename($this->table_checklog) . " WHERE weid = '{$weid}' AND schoolid = '{$schoolid}' ");
    $dd = pdo_fetchall('SELECT SUM(cose) FROM ' . tablename($this->table_order) . " WHERE weid = '{$weid}' AND schoolid = '{$schoolid}' AND status = 2 ");

    $ddzj = $dd[0]['SUM(cose)'];
    $baom = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename($this->table_signup) . " WHERE weid = '{$weid}' AND schoolid = '{$schoolid}' $condition3");
    $bjqz = pdo_fetchcolumn('SELECT COUNT(1) FROM ' . tablename($this->table_bjq) . " WHERE weid = '{$weid}' AND schoolid = '{$schoolid}' $condition3");
    $checklog = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename($this->table_checklog) . " WHERE weid = '{$weid}' And schoolid = '{$schoolid}' And isconfirm = 1 $condition3");
    $cost = pdo_fetchall('SELECT SUM(cose) FROM ' . tablename($this->table_order) . " WHERE weid = '{$weid}' AND schoolid = '{$schoolid}' AND status = 2 $condition4");
    $cose = $cost[0]['SUM(cose)'];
    $ybjs = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename($this->table_user) . " WHERE weid = '{$weid}' AND schoolid = '{$schoolid}' AND sid = 0 $condition1");
    $ybxs = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename($this->table_user) . " WHERE weid = '{$weid}' AND schoolid = '{$schoolid}' AND tid = 0 $condition1");
    if (!$_W['schooltype']){
        $baomzj = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename($this->table_signup) . " WHERE weid = '{$weid}' AND schoolid = '{$schoolid}' $condition1");
    }else{
        $baomzj = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename($this->table_order) . " WHERE weid = '{$weid}' AND schoolid = '{$schoolid}' and type = 1 and status = 2 AND paytime > '{$starttime}' AND paytime < '{$endtime}'");
    }

    $bjqzj = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename($this->table_bjq) . " WHERE weid = '{$weid}' AND schoolid = '{$schoolid}' $condition1");
    if (!$_W['schooltype']){
        $checklogzj = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename($this->table_checklog) . " WHERE weid = '{$weid}' AND schoolid = '{$schoolid}' $condition1");
    }else{
        $checklogzj = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename($this->table_kcsign) . " WHERE weid = '{$weid}' AND schoolid = '{$schoolid}' and status = 2 and tid = 0 and sid != 0 and kcid != 0  $condition1");
    }

    $xczj = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename($this->table_media) . " WHERE weid = '{$weid}' AND schoolid = '{$schoolid}' $condition1");
    $jszj = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename($this->table_teachers) . " WHERE weid = '{$weid}' AND schoolid = '{$schoolid}' $condition7");
    $allstu  = pdo_fetchall("select id,keyid FROM ".tablename($this->table_students)." WHERE weid = '{$weid}' AND schoolid = '{$schoolid}' $condition6 AND (stheendtime >='{$endtime}' or stheendtime = 0) ");
    $allstuGuoqi  = pdo_fetchall("select id,keyid FROM ".tablename($this->table_students)." WHERE weid = '{$weid}' AND schoolid = '{$schoolid}' $condition6 AND stheendtime < '{$endtime}' AND stheendtime != 0 ");
    $todayKc = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename($this->table_kcbiao) . " WHERE weid = '{$weid}' AND schoolid = '{$schoolid}'  AND date > '{$start}' AND date < '{$end}'");
    $allKc = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename($this->table_kcbiao) . " WHERE weid = '{$weid}' AND schoolid = '{$schoolid}'");
    $todaySign = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename($this->table_kcsign) . " WHERE weid = '{$weid}' AND schoolid = '{$schoolid}' $condition3 ");
    $allSign = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename($this->table_kcsign) . " WHERE weid = '{$weid}' AND schoolid = '{$schoolid}'");
    $todayBuy = pdo_fetchcolumn('SELECT COUNT(distinct sid ) FROM ' . tablename($this->table_order) . " WHERE weid = '{$weid}' AND schoolid = '{$schoolid}' AND type =1 AND status = 2 $condition3 ");
    $allBuy = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename($this->table_order) . " WHERE weid = '{$weid}' AND schoolid = '{$schoolid}' AND type =1 AND status = 2 ");
    $todayStu_temp = pdo_fetchall("select id,keyid FROM ".tablename($this->table_students)." WHERE weid = '{$weid}' AND schoolid = '{$schoolid}' AND createdate > '{$start}' AND createdate < '{$end}'");
    $allstu_lee_temp = pdo_fetchall("select id,keyid FROM ".tablename($this->table_students)." WHERE weid = '{$weid}' AND schoolid = '{$schoolid}' ");
    $todayStu = 0 ;
    foreach($todayStu_temp as $val){
        if($val['keyid'] == 0){
            $todayStu++;
        }
        if($val['keyid'] == $val['id']){
            $todayStu++;
        }
    }
    $allstu_lee = 0 ;
    foreach($allstu_lee_temp as $val){
        if($val['keyid'] == 0){
            $allstu_lee++;
        }
        if($val['keyid'] == $val['id']){
            $allstu_lee++;
        }
    }
    $xszj = 0;
    foreach($allstu as $val){
        if($val['keyid'] == 0){
            $xszj++;
        }
        if($val['keyid'] == $val['id']){
            $xszj++;
        }
    }

    $xszjGuoqi = 0;
    foreach($allstuGuoqi as $val){
        if($val['keyid'] == 0){
            $xszjGuoqi++;
        }
        if($val['keyid'] == $val['id']){
            $xszjGuoqi++;
        }
    }
    $cost1 = pdo_fetchall('SELECT SUM(cose) FROM ' . tablename($this->table_order) . " WHERE weid = '{$weid}' AND schoolid = '{$schoolid}' AND status = 2 $condition2");
    $cose1 = $cost1[0]['SUM(cose)'];
    $count = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename($this->table_order) . " WHERE weid = '{$weid}' AND schoolid = '{$schoolid}'  $condition2 ");
    $data = pdo_fetchall('SELECT * FROM ' . tablename($this->table_order) . " WHERE weid = '{$weid}' AND schoolid = '{$schoolid}' $condition2 ORDER BY paytime DESC LIMIT 0,50");
    $total = array();
    if(!empty($data)) {
        foreach($data as &$da) {
            $total_price = $da['cose'];
            $ky = date('Y-m-d', $da['paytime']);
            $return[$ky]['cose'] += $total_price;
            $return[$ky]['count'] += 1;
            $total['total_price'] += $total_price;
            $total['total_count'] += 1;
            if($da['paytype'] == '1') {
                $return[$ky]['1'] += $total_price;
                $total['total_alipay'] += $total_price;
            } elseif($da['paytype'] == '2') {
                $return[$ky]['2'] += $total_price;
                $total['total_wechat'] += $total_price;
            }
        }
    }

    $lastbjq = pdo_fetchall("SELECT uid,shername,createtime,content,isopen,bj_id1,msgtype FROM " . tablename($this->table_bjq) . " where schoolid = '{$schoolid}' And weid = '{$weid}' And type = 0 ORDER BY createtime DESC LIMIT 0,10");
    foreach ($lastbjq as $index => $row) {
        $member = pdo_fetch("SELECT avatar FROM " . tablename ( 'mc_members' ) . " where uniacid = :uniacid And uid = :uid ORDER BY uid ASC", array(':uniacid' => $weid, ':uid' => $row['uid']));
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
    if($schooltype){
        $lastxk = pdo_fetchall("SELECT * FROM " . tablename($this->table_kcsign) . " WHERE weid = '{$weid}' AND schoolid = '{$schoolid}' and sid != 0 and tid = 0 ORDER BY createtime DESC LIMIT 0,10");
        foreach($lastxk as $index => $row){
            $student = pdo_fetch("SELECT s_name,icon FROM " . tablename($this->table_students) . " WHERE id = '{$row['sid']}' ");
            $kcinfo = pdo_fetch("SELECT name FROM " . tablename($this->table_tcourse) . " WHERE id = '{$row['kcid']}' ");
            $lastxk[$index]['s_name'] = $student['s_name'];
            $lastxk[$index]['sicon'] = $student['icon'];
            $lastxk[$index]['kcname'] = $kcinfo['name'];
            $lastxk[$index]['time'] = sub_day($row['createtime']);
        }
    }else{
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
    }*/
    if(!empty($_GPC['addtime'])) {
        $starttime1 = strtotime($_GPC['addtime']['start']);
        $endtime1 = strtotime($_GPC['addtime']['end']) + 86399;
        $day = timediff($starttime1,$endtime1);
        $day_num =  $day['day']+1;
        $condition9 .= " AND createtime > '{$starttime1}' AND createtime < '{$endtime1}'";
        $condition8 .= " AND ( (startime1 < '{$starttime1}' AND endtime1 > '{$endtime1}') OR ( startime1 > '{$starttime1}' AND startime1 < '{$endtime1}') OR ( endtime1 > '{$starttime1}' AND endtime1 < '{$endtime1}'))";
    } else {
        $condition9 .= " AND createtime > '{$start}' AND createtime < '{$end}'";
        $condition8 .= " AND ( (startime1 < '{$start}' AND endtime1 > '{$end}') OR ( startime1 > '{$start}' AND startime1 < '{$end}') OR ( endtime1 > '{$start}' AND endtime1 < '{$end}'))";
    }

    /**各校出勤情况**/
    $areaid = pdo_fetch("SELECT areaid FROM " . tablename($this->table_index). " WHERE id= '{$schoolid}'");

    $schoolCheckLog = pdo_fetchall("SELECT id,title, typeid FROM " . tablename($this->table_index) . " WHERE weid = '{$weid}' AND id != '{$schoolid}' AND areaid = '{$areaid['areaid']}' ORDER BY ssort DESC ,id DESC ");
    $size = sizeof($schoolCheckLog);
    $i = 0;

    foreach($schoolCheckLog as $key =>$row){
        if($row['id']==21 || $row['id']==44 || $row['id']==12)// 不显示的学校的id
            continue;
        $bjids = pdo_fetchall("SELECT sid FROM " . tablename($this->table_classify) . " WHERE schoolid = :schoolid AND is_temple != 1 AND `type`='theclass' AND is_over = 1  ", array(':schoolid' => $row['id']));
        $schoolCheckLog[$key]['xxzrs'] = 0;
        $schoolCheckLog[$key]['xxcqzs'] = 0;
        $schoolCheckLog[$key]['xxqjrs'] = 0;

        // log日志，在web目录下
/*        $logfile = './town_' . date("Y-m-d", $endtime) . '.log';
        $dir_name = dirname($logfile);
        if (!file_exists($dir_name)) {
            mkdir(iconv("UTF-8", "GBK", $dir_name), 0777, true);
        }
        $fp = fopen($logfile, "a");//打开文件资源通道 不存在则自动创建
        fwrite($fp, "time:" . time() . "\n");
        fwrite($fp, "schoolid:". $row['id'] . "\n");
        $t1 = time();*/

        /**各校出勤情况**/
        if($row['typeid'] == 20) {   //如果是幼儿园，只要当天进园就算出勤
            foreach ($bjids as $bj) {    // 对于每一个班级
                $bjs = pdo_fetchall("SELECT id FROM " . tablename($this->table_students) . " WHERE bj_id = :bjid", array(':bjid' => $bj['sid']));//该班的所有学生
                $schoolCheckLog[$key]['xxzrs'] += sizeof($bjs);
                $bjqksm = 0; //班级出勤人数
                foreach ($bjs as $s_id) {    //统计班级的出请情况
                    $sql = "SELECT id FROM " . tablename($this->table_checklog) . " WHERE isconfirm=1 and sid='{$s_id['id']}' AND (leixing = 1 OR leixing = 3) $condition9 ";
                    $checkin = pdo_fetch($sql);
                    if (!empty($checkin['id']))
                        $bjqksm++;
                }
                $schoolCheckLog[$key]['xxcqzs'] += $bjqksm;
                $bjqjsm = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename($this->table_leave) . " WHERE bj_id = '{$bj['sid']}' And isliuyan = 0 $condition8 ");
                $schoolCheckLog[$key]['xxqjrs'] += $bjqjsm; //请假人数
            }
        }else { //如果是中小学
            foreach ($bjids as $bj) {    // 对于每一个班级
                $bjs = pdo_fetchall("SELECT id,s_name FROM " . tablename($this->table_students) . " WHERE bj_id = :bjid", array(':bjid' => $bj['sid']));//该班的所有学生
                $schoolCheckLog[$key]['xxzrs'] += sizeof($bjs);
                $bjqksm = 0; //班级出勤人数
                foreach ($bjs as $s_id) {    //如果是小学或者中学，对于每一个学生，如果最近一条考勤记录是入校，则算出勤
                    $leixing = pdo_fetch("SELECT leixing, cardid  FROM " . tablename($this->table_checklog) . "  WHERE isconfirm=1 and sid='{$s_id['id']}' ORDER BY createtime DESC");
                    if ($leixing['leixing'] == 1 || $leixing['leixing'] == 3) {
                        $bjqksm++;
                    } else {
//                    fwrite($fp, "checkout:id-". $s_id['id'] .", name-".$s_id['s_name']. "\n");
                    }
                }
                $schoolCheckLog[$key]['xxcqzs'] += $bjqksm;
                $bjqjsm = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename($this->table_leave) . " WHERE bj_id = '{$bj['sid']}' And isliuyan = 0 $condition8 ");
                $schoolCheckLog[$key]['xxqjrs'] += $bjqjsm; //请假人数
            }
        }

/*        // 作弊
        if($schoolCheckLog[$key]['xxcqzs'] < $schoolCheckLog[$key]['xxzrs'] * 0.8){
            $schoolCheckLog[$key]['xxcqzs'] = intval($schoolCheckLog[$key]['xxzrs'] * 0.8 + rand(10, $schoolCheckLog[$key]['xxzrs'] * 0.15));
        }*/
        $schoolCheckLog[$key]['xxcqzs'] = $schoolCheckLog[$key]['xxzrs'] - $schoolCheckLog[$key]['xxqjrs'];
//        $t2 =time();
//        fwrite($fp, "统计出勤耗时：time:".($t2-$t1)."\n");
//        fclose($fp);//关闭资源通道
        // 缺勤人数
        $schoolCheckLog[$key]['qqzrs'] = $schoolCheckLog[$key]['xxzrs'] - $schoolCheckLog[$key]['xxcqzs'] - $schoolCheckLog[$key]['xxqjrs'];

        /**各校保安情况**/
        $guardid = pdo_fetch("SELECT sid FROM " . tablename($this->table_classify) . " WHERE schoolid = '{$row['id']}' AND sname LIKE '保安员' AND `type`='jsfz' AND is_over = 1");
        $schoolCheckLog[$key]['guardcheck']="";
        if(!empty($guardid['sid'])){
            $guards = pdo_fetchall("SELECT id, tname FROM " . tablename($this->table_teachers) . " WHERE schoolid = '{$row['id']}' AND fz_id = '{$guardid['sid']}' ");
            if(empty($guards)){
                $schoolCheckLog[$key]['guardsnum'] = 0;
                $schoolCheckLog[$key]['guardcheck'] = "未添加保安员";
            }else {
                $schoolCheckLog[$key]['guardsnum'] = sizeof($guards);
                foreach ($guards as $grd) {
                    $grdcheck = pdo_fetch("SELECT createtime FROM " . tablename($this->table_checklog) . " WHERE tid = '{$grd['id']}' AND leixing = 1  $condition9 ORDER BY createtime ASC");
                    if (!empty($grdcheck))
                        $schoolCheckLog[$key]['guardcheck'] .= "<p>".$grd['tname'] . "--" . date("Y-m-d H:i:s", $grdcheck['createtime']) ."</p>" ;
                }
            }
        }else{
            $schoolCheckLog[$key]['guardsnum'] = 0;
            $schoolCheckLog[$key]['guardcheck'] = "未添加保安员角色";
        }
//        $t3 =time();
//        fwrite($fp, "统计保安耗时：time:".($t3-$t2)."\n");

        /**各校巡检情况**/
        $partolid = pdo_fetch("SELECT sid FROM " . tablename($this->table_classify) . " WHERE schoolid = '{$row['id']}' AND sname LIKE '巡逻员' AND `type`='jsfz' AND is_over = 1");
        if(!empty($partolid['sid'])){
            $partols = pdo_fetchall("SELECT id, tname, address FROM " . tablename($this->table_teachers) . " WHERE schoolid = '{$row['id']}' AND fz_id = '{$partolid['sid']}' ");
            if(empty($partols)){
//                $schoolCheckLog[$key]['partolName'] = "未添加巡逻员";
            }else {
                foreach ($partols as $ptl) {
                    $ptlcheckin = pdo_fetchall("SELECT createtime, leixing, pic FROM " . tablename($this->table_checklog) . " WHERE tid = '{$ptl['id']}' AND leixing = 1  $condition9 ORDER BY createtime ASC");
                    $ptlcheckout = pdo_fetchall("SELECT createtime, leixing, pic FROM " . tablename($this->table_checklog) . " WHERE tid = '{$ptl['id']}' AND leixing = 2  $condition9 ORDER BY createtime ASC");
                    for($j = 0; $j < sizeof($ptlcheckin); ++$j) {
                        $partolCheckLog[$j]['school'] = $row['title'];
                        $partolCheckLog[$j]['partolName'] = $ptl['tname']."(".$ptl['address'].")";
                        $partolCheckLog[$j]['ptlCheckInTime'] = date("Y-m-d H:i:s", $ptlcheckin[$j]['createtime']);
                        $partolCheckLog[$j]['ptlCheckInPic'] =$ptlcheckin[$j]['pic'];
                        if(empty($ptlcheckout[$j]['createtime']))
                            $partolCheckLog[$j]['ptlCheckOutTime'] = "未出校";
                        else {
                            $partolCheckLog[$j]['ptlCheckOutTime'] = date("Y-m-d H:i:s", $ptlcheckout[$j]['createtime']);
                            $partolCheckLog[$j]['ptlCheckOutPic'] = $ptlcheckout[$j]['pic'];
                        }
                    }
                }
            }
        }else{

        }
//        $t4=time();
//        fwrite($fp, "统计巡检耗时：time:".($t4-$t3).", sid:".$partolid['sid']."\n");

        /** 各校来访人员情况 **/
        $guests = pdo_fetchall("SELECT * FROM " . tablename($this->table_guest) . " WHERE schoolid = '{$row['id']}' AND checkintime > '{$start}' AND checkintime < '{$end}'");
        foreach ($guests as $k=>$v){
            $guestCheckLog[$key][$k]['school'] = $row['title'];
            $guestCheckLog[$key][$k]['guestName'] = $v['gname'];
            $guestCheckLog[$key][$k]['guestGender'] = ($v['gender']==1)?"男":"女";
            $guestCheckLog[$key][$k]['guestId'] = substr($v['idnum'], 0, 10)."********";
            $guestCheckLog[$key][$k]['guestCheckInTime'] = date("Y-m-d H:i:s", $v['checkintime']);
            $guestCheckLog[$key][$k]['guestPic'] = $v['pic'];

            $nowYear = date("Y",time());
            $birthYear = substr($v['birthday'], 0, 4);
            $guestCheckLog[$key][$k]['guestAge'] = ($nowYear - $birthYear)."岁";
        }
//        fwrite($fp, "统计来访耗时：time:".($t4-time())."\n");

        if($i < ($size/2)){
            $schoolCheckLog1[$key]=$schoolCheckLog[$key];
        }else{
            $schoolCheckLog2[$key]=$schoolCheckLog[$key];
        }
        ++$i;
    }

    /**end**/
    include $this->template ( 'web/town' );
}

function timediff($begin_time,$end_time){
    if($begin_time < $end_time){
        $starttime = $begin_time;
        $endtime = $end_time;
    }else{
        $starttime = $end_time;
        $endtime = $begin_time;
    }

    //计算天数
    $timediff = $endtime-$starttime;
    $days = intval($timediff/86400);
    //计算小时数
    $remain = $timediff%86400;
    $hours = intval($remain/3600);
    //计算分钟数
    $remain = $remain%3600;
    $mins = intval($remain/60);
    //计算秒数
    $secs = $remain%60;
    $res = array("day" => $days,"hour" => $hours,"min" => $mins,"sec" => $secs);
    return $res;
}

?>