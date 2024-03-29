<?php
/**
 * By 高贵血迹
 */

global $_GPC, $_W;

$operation = in_array ( $_GPC ['op'], array ('default', 'getMacIfc', 'login', 'classinfo', 'check', 'gps', 'banner', 'video','getleave', 'qrcode', 'identify') ) ? $_GPC ['op'] : 'default';
$weid = $_GPC['i'];
$schoolid = $_GPC['schoolid'];
$macid = $_GPC['macid'];
$ckmac = pdo_fetch("SELECT * FROM " . tablename($this->table_checkmac) . " WHERE macid = '{$macid}' And schoolid = '{$schoolid}' ");
$school = pdo_fetch("SELECT * FROM " . tablename($this->table_index) . " WHERE id = '{$schoolid}' ");
$todayTime = mktime(0,0,0,date("m"),date("d"),date("Y"));
$tomorrowTime = $todayTime + 3600*24;
if ($operation == 'default') {
    echo("错误，未知操作");
    exit;
}

// 获取4个接口信息，替代微教育的接口(返回的值是正确的，但是在客户端调用却无反应，不起作用，重新写了一个接口：http://jy.xingheoa.com/addons/fm_jiaoyu/macinterfaces.php)
if($operation == 'getMacIfc') {
    if (empty($macid)) {
        echo ('设备id不能为空');
        exit;
    }

    $mac = pdo_fetch("SELECT * FROM " . tablename($this->table_checkmac) . " WHERE macid = '{$macid}'");
    if (empty($mac)) {
        echo "你无权使用本设备！";
        exit;
    }

    $macIfc = array(
        "check" => urlencode("http://jy.xingheoa.com/app/index.php?i=".$weid."&c=entry&schoolid=" . $mac["schoolid"] . "&do=checkhx&m=fm_jiaoyu&op=check&mactype=other&macid=" . $macid),
        "login" => urlencode("http://jy.xingheoa.com/app/index.php?i=".$weid."&c=entry&schoolid=" . $mac["schoolid"] . "&do=checkhx&m=fm_jiaoyu&op=login&mactype=other&macid=" . $macid),
        "class" => urlencode("http://jy.xingheoa.com/app/index.php?i=".$weid."&c=entry&schoolid=" . $mac["schoolid"] . "&do=checkhx&m=fm_jiaoyu&op=classinfo&mactype=other&macid=" . $macid),
        "banner" => urlencode("http://jy.xingheoa.com/app/index.php?i=".$weid."&c=entry&schoolid=" . $mac["schoolid"] . "&do=checkhx&m=fm_jiaoyu&op=banner&mactype=other&macid=" . $macid)
    );
    echo json_encode($macIfc);
    exit;
}

if(empty($school)){
    echo("找不到本校");
    exit;
}

// 身份证读卡器接口
if($operation == 'identify'){
    $idnum = trim($_GPC['idnum']);
    $gender = trim($_GPC['gender']);
    $pic = $_GPC['pic'];

    if(empty($idnum) || !checkIdCard($idnum)){
        $result['data'] = "身份证格式不正确";
        $result['code'] = 300;
        $result['msg'] = "fails";
        $result['ServerTime'] = date('Y-m-d H:i:s',time());
        echo json_encode($result);
        exit;
    }
    if(empty($_GPC['checkintime'])){
        $result['data'] = "缺少刷卡时间";
        $result['code'] = 100;
        $result['msg'] = "fails";
        $result['ServerTime'] = date('Y-m-d H:i:s',time());
        echo json_encode($result);
        exit;
    }

    if($gender=='男')
        $gender = 1;
    elseif($gender=='女')
        $gender = 2;

    if($pic) {
        load()->func('file');
        $path = "images/fm_jiaoyu/check/". date('Y/m/d/');
        if (!is_dir(IA_ROOT."/attachment/". $path)) {
            mkdirs(IA_ROOT."/attachment/". $path, "0777");
        }
        $rand = random(30);
        if(!empty($pic)) {
            $picurl = $path.$rand."_1.jpg";
            $pic_url = base64_decode(str_replace(" ","+",$pic));
            file_write($picurl,$pic_url);
            $pic = $picurl;
        }
    }

    $data = array(
        'schoolid' => $schoolid,
        'gname' => trim($_GPC['gname']),
        'birthday' => trim($_GPC['birthday']),
        'gender' => $gender,
        'idnum' => trim($_GPC['idnum']),
        'nation' => trim($_GPC['nation']),
        'signedby' => trim($_GPC['signedby']),
        'address' => trim($_GPC['address']),
        'issueddate' => trim($_GPC['issueddate']),
        'validdate' => trim($_GPC['validdate']),
        'pic' => $pic,
        'checkintime' => trim($_GPC['checkintime']),
    );
    $res = pdo_insert($this->table_guest, $data);

    if (!empty($res)){
        $result['data'] = $res;
        $result['code'] = 1000;
        $result['msg'] = "success";
        $result['ServerTime'] = date('Y-m-d H:i:s',time());
        echo json_encode($result);
        exit;
    }else{
        $result['data'] = "";
        $result['code'] = 300;
        $result['msg'] = "lose:".$res;
        $result['ServerTime'] = date('Y-m-d H:i:s',time());
        echo json_encode($result);
        exit;
    }
}

if(empty($ckmac)){
    echo("没找到设备");
    exit;
}
if($school['is_recordmac'] == 2){
    echo("本校无权使用设备");
    exit;
}
if ($ckmac['is_on'] ==2){
    echo("本设备已关闭");
    exit;
}
if (!empty($_W['setting']['remote']['type'])) {
    $urls = $_W['attachurl'];
} else {
    $urls = $_W['siteroot'].'attachment/';
}

if ($operation == 'login') {
    if(!empty($ckmac)){
        $class = pdo_fetchall("SELECT sid as classId, sname as className  FROM " . tablename($this->table_classify) . " WHERE weid = '{$weid}' And (type = 'theclass' OR type = 'jsfz') And schoolid = {$school['id']} ORDER BY sid DESC");
        foreach($class as $key =>$row) {
            $checkclass = pdo_fetch("SELECT type,pname  FROM " . tablename($this->table_classify) . " WHERE sid = '{$row['classId']}'");
            if ($checkclass['type'] == 'theclass'){
                $class[$key]['className'] = $row['className'];
                $class[$key]['channel'] = $row['classId'];
                $class[$key]['channeldesc'] = $row['className'];
            }else{
                $class[$key]['className'] = $checkclass['pname'];
                $class[$key]['channel'] = $row['classId'];
                $class[$key]['channeldesc'] = $checkclass['pname'];
            }
        }
        $result['data']['classInfo'] = $class;
        $result['data']['schoolInfo'] = array(
            'name' => $school['title'],
            'schoolId' => $school['id'],
            'logo' => $urls.$school['logo'],
            'tel' => $school['tel']
        );
        $result['data']['userInfo'] = array(
            'email' => "admin@sina.com",
            'name' => '',
            'sex' => '',
            'teacherId' => '',
            'tel' => ''
        );
        if($ckmac['twmac'] == -1){
            $result['data']['tempid'] = 1;
        }else{
            $result['data']['tempid'] = $ckmac['twmac'];
        }
        if($ckmac['cardtype'] == 1){
            $result['data']['cardtype'] = 1;
        }
        if($ckmac['cardtype'] == 2){
            $result['data']['cardtype'] = 2;
        }
        $result['data']['finger'] = 2;
        if($macid == '8c:18:d9:cd:e5:0d'){
            $result['data']['TerminalInfo'] = array(
                'fenqq' => 'ttyS2',
                'zhiw' => "ttyS3",
                'card' => "ttyS1",
                'shext' => '',
                'by1' => '',
                'by2' => '',
                'by3' => ''
            );
        }else{
            $result['data']['TerminalInfo'] = array(
                'fenqq' => 'ttyS4',
                'zhiw' => "ttyS3",
                'card' => "ttyS2",
                'shext' => '',
                'by1' => '',
                'by2' => '',
                'by3' => ''
            );
        }
        $result['code'] = 1000;
        $result['msg'] = "success";
        $result['ServerTime'] = date('Y-m-d H:i:s',time());

        echo json_encode($result);
    }
}

if ($operation == 'classinfo') {
    $classid = $_GPC['classId'];
    $isfz = pdo_fetch("SELECT type,datesetid  FROM " . tablename($this->table_classify) . " WHERE weid = '{$weid}' And schoolid = '{$school['id']}' And sid = '{$classid}'");
    $isface = pdo_fetch("SELECT is_face FROM " . tablename($this->table_index) . " WHERE weid = '{$weid}' And id = '{$school['id']}'");
    if ($isfz['type'] == 'theclass'){
        if(!empty($ckmac)){
            $nowdate = date("Y-n-j",time());
            $nowyear = date("Y",time());
            $nowweek = date("w",time());
            $todaytype = 0;
            $todaytimeset = array(
                array(
                    'start'=>'00:00',
                    'end'  =>'23:59'
                ),
            );
            if(!empty($isfz['datesetid'])){
                $checkdateset      =  pdo_fetch("SELECT * FROM " . tablename($this->table_checkdateset) . " WHERE weid = '{$weid}' And schoolid = {$school['id']} and  id = '{$isfz['datesetid']}'");
                $checkdateset_holi =  pdo_fetch("SELECT * FROM " . tablename($this->table_checkdatedetail) . " WHERE weid = '{$weid}' And schoolid = {$school['id']} and  checkdatesetid = '{$isfz['datesetid']}' and year = '{$nowyear}' ");

                $checktime         =  pdo_fetchall("SELECT * FROM " . tablename($this->table_checktimeset) . " WHERE weid = '{$weid}' And schoolid = {$school['id']} and  checkdatesetid = '{$isfz['datesetid']}' and date = '{$nowdate}' ORDER BY id ASC ");
                if(!empty($checktime)){ // 如果checktime
                    if($checktime[0]['type'] == 6){ //type=1工作日，2周五，3周六，4周日，5特殊上，6特殊休
                        //1放假2上课
                        $todaytype = 1;
                    }elseif($checktime[0]['type'] == 5){
                        $todaytype    = 2;
                        $todaytimeset = $checktime;
                    }
                }else{
                    if(($nowdate >= $checkdateset_holi['win_start'] && $nowdate <=$checkdateset_holi['win_end']) || ($nowdate >= $checkdateset_holi['sum_start'] && $nowdate <=$checkdateset_holi['sum_end'])){ // 暑假和寒假放假
                        $todaytype = 1;
                    }else{
                        $timeset_work = pdo_fetchall("SELECT start,end FROM " . tablename($this->table_checktimeset) . " WHERE weid = '{$weid}' And schoolid = {$school['id']} and  checkdatesetid = '{$isfz['datesetid']}' and type=1 ORDER BY id ASC ");
                        //星期五
                        if($nowweek == 5){
                            $todaytype = 2;
                            if($checkdateset['friday'] == 1){
                                $timeset_fri = pdo_fetchall("SELECT start,end FROM " . tablename($this->table_checktimeset) . " WHERE weid = '{$weid}' And schoolid = {$school['id']} and  checkdatesetid = '{$isfz['datesetid']}' and type=2 ORDER BY id ASC ");
                                $todaytimeset = $timeset_fri;
                            }else{
                                $todaytimeset = $timeset_work;
                            }
                            //星期六
                        }elseif($nowweek == 6){
                            if($checkdateset['saturday'] == 1){
                                $timeset_sat = pdo_fetchall("SELECT start,end FROM " . tablename($this->table_checktimeset) . " WHERE weid = '{$weid}' And schoolid = {$school['id']} and  checkdatesetid = '{$isfz['datesetid']}' and type=3 ORDER BY id ASC ");
                                $todaytype = 2;
                                $todaytimeset = $timeset_sat;
                            }else{
                                $todaytype = 1;
                            }

                            //星期天
                        }elseif($nowweek == 0){
                            if($checkdateset['sunday'] == 1){
                                $timeset_sun = pdo_fetchall("SELECT start,end FROM " . tablename($this->table_checktimeset) . " WHERE weid = '{$weid}' And schoolid = {$school['id']} and  checkdatesetid = '{$isfz['datesetid']}' and type=4 ORDER BY id ASC ");
                                $todaytype    = 2;
                                $todaytimeset = $timeset_sun;
                            }else{
                                $todaytype    = 1;
                            }
                            //工作日
                        }else{
                            $todaytype    = 2;
                            $todaytimeset = $timeset_work;
                        }
                    }
                }

            }
            $result['data']['todaytype'] = $todaytype;
            $result['data']['todaytimeset'] = $todaytimeset;

            $class = pdo_fetchall("SELECT id as childId, bj_id as classId, icon as headIcon, s_name as name,s_type, createdate as updatetime FROM " . tablename($this->table_students) . " WHERE weid = '{$weid}' And schoolid = {$school['id']} And bj_id = '{$classid}' ORDER BY id DESC");
            foreach($class as $key =>$row) {
                if(!empty($row['headIcon'])){
                    $class[$key]['headIcon'] = $urls.$row['headIcon'];
                }else{
                    $class[$key]['headIcon'] = !empty($school['spic'])? $urls.$school['spic'] : "";
                }
                $class[$key]['name'] = $row['name'];
                $class[$key]['signId'] = "";
                $card = pdo_fetchall("SELECT idcard, severend FROM " . tablename($this->table_idcard) . " WHERE sid = '{$row['childId']}' ORDER BY id DESC");

                if(($card['0']['severend'] < time() && $card['0']['severend'] != 0) || $card['0']['severend'] == null) // 如果超出有效期，则更新标识
                    $class[$key]['updatetime']--;
                else {
                    $num = count($card);
                    if ($num > 1) {
                        foreach ($card as $k => $r) {
                            if (!empty($r['idcard'])) {
                                $class[$key]['signId'] .= "#" . $r['idcard'];
                            }
                        }
                    } else {
                        $class[$key]['signId'] = $card['0']['idcard'];
                    }
                }

                //  是否启用人脸识别。人脸识别的id卡号取关系是10（其他家长）的卡号
                if($isface['is_face'] == 1 || $isface['is_face'] == 4){
                    $faceid = pdo_fetch("SELECT idcard  FROM " . tablename($this->table_idcard) . " WHERE sid = '{$row['childId']}' and pard=10");
                    if(!empty($faceid))
                        $class[$key]['faceid'] = $faceid['idcard'];
                    else
                        $class[$key]['faceid'] = $card['0']['idcard'];
                }else
                    $class[$key]['faceid'] = -1;

                $class[$key]['fingerid1'] = "-1";
                $class[$key]['fingerid2'] = "-1";
                $class[$key]['fingerid3'] = "-1";
                $class[$key]['fingerid4'] = "-1";
                $class[$key]['fingerid5'] = "-1";
            }
            $result['data']['childs'] = $class;

            // 增加该班级所有的请假学生列表
            $nowUTime = time();
            $leaves = pdo_fetchall("SELECT sid as childid,startime1 as starttime,endtime1 as endtime FROM " . tablename($this->table_leave) . " WHERE weid = '{$weid}'  And schoolid = '{$schoolid}' and startime1 <= '{$nowUTime}' and endtime1 >= '{$nowUTime}' and bj_id ='{$classid}' and `status`=1 ");

            // 增加每周允许的出校门时间段
            if(empty($isfz['datesetid'])) {
                $res = pdo_fetch("SELECT id FROM " . tablename($this->table_checkdateset) . " WHERE weid = '{$weid}' And schoolid = {$school['id']} and  name = 'default'"); // 获取默认值
                $checkdatesetid = $res['id'];
            }else
                $checkdatesetid = $isfz['datesetid'];

            if (empty($checkdatesetid)) {//如果没有设置时间，则全天运行通行
                $todaytimeset = array(array('startTime'=>"00:00", 'endTime'=>"23:59"));
                for($i=0; $i<7; ++$i)
                    $week[$i] = array('weekno'=>$i, 'groups'=>$todaytimeset);
                $timeset1[0] = array('id'=>0, 'weeks'=>$week);
                $timeset1[1] = array('id'=>1, 'weeks'=>$week);
                $timeset1[2] = array('id'=>2, 'weeks'=>$week);
                $timeset1[3] = array('id'=>3, 'weeks'=>$week);
                $timeset1[4] = array('id'=>4, 'weeks'=>$week);
                $timeset1[5] = array('id'=>5, 'weeks'=>$week);
                $timeset1[6] = array('id'=>6, 'weeks'=>$week);
            } else {
                $sunday = date("Y-n-j",(time()-$nowweek*3600*24));
                $checkdateset      =  pdo_fetch("SELECT * FROM " . tablename($this->table_checkdateset) . " WHERE weid = '{$weid}' And schoolid = {$school['id']} and  id = '{$checkdatesetid}'"); //考勤时间设置
                // 如果是普通闸机通道
                if($ckmac['s_type'] == 1) {
                    for ($k = 0; $k < 7; ++$k) {
                        $todaytime = strtotime('+' . $k . ' day', strtotime($sunday));
                        $nowdate = date('Y-n-j', $todaytime);
                        $nowyear = date("Y", $todaytime);
                        $checkdateset_holi = pdo_fetch("SELECT * FROM " . tablename($this->table_checkdatedetail) . " WHERE weid = '{$weid}' And schoolid = {$school['id']} and  checkdatesetid = '{$checkdatesetid}' and year = '{$nowyear}' ");
                        $checktime = pdo_fetchall("SELECT * FROM " . tablename($this->table_checktimeset) . " WHERE weid = '{$weid}' And schoolid = {$school['id']} and  checkdatesetid = '{$checkdatesetid}' and date = '{$nowdate}' ORDER BY id ASC ");
                        if (!empty($checktime)) { // 如果周五、周六、周日单独设置（checktimeset里的date不为空）
                            if ($checktime[0]['type'] == 6) { //type=1工作日，2周五，3周六，4周日，5特殊上，6特殊休
                                $todaytimeset1 = $todaytimeset2 = $todaytimeset3 = $todaytimeset4 = $todaytimeset5 = $todaytimeset6 = array(array('startTime' => "00:00", 'endTime' => "23:59"));
                            } elseif ($checktime[0]['type'] == 5) {
                                $todaytimeset1 = transTimeset4T1($checktime);
//                                $todaytimeset2 = array(array('startTime' => $checktime[count($checktime) - 1]['start'], 'endTime' => $checktime[count($checktime) - 1]['end']));
                                $todaytimeset2 = array(array('startTime' => "00:00", 'endTime' => "00:00"));  //该逻辑需要修改：特殊上课日对于走读生来说，上完课是否运行出校，应该可以选择
                                $todaytimeset3 = transTimeset4T3($checktime);
                                $todaytimeset6 = transTimeset4T6($checktime);
                            }
                        } else {
                            if (($todaytime >= strtotime($checkdateset_holi['win_start']) && $todaytime <= strtotime($checkdateset_holi['win_end'])) || ($todaytime >= strtotime($checkdateset_holi['sum_start']) && $todaytime <= strtotime($checkdateset_holi['sum_end']))) { // 暑假和寒假放假
                                $todaytimeset1 = $todaytimeset2 = $todaytimeset3 = $todaytimeset6 = array(array('startTime' => "00:00", 'endTime' => "23:59"));
                            } else {
                                $timeset_work = pdo_fetchall("SELECT start,end FROM " . tablename($this->table_checktimeset) . " WHERE weid = '{$weid}' And schoolid = {$school['id']} and  checkdatesetid = '{$checkdatesetid}' and type=1 ORDER BY id ASC ");
                                if ($k == 5) {//星期五
                                    if ($checkdateset['friday'] == 1) {   // 如果周五单独设置，则周五最后一个时间段都可以放行
                                        $timeset_fri = pdo_fetchall("SELECT start,end FROM " . tablename($this->table_checktimeset) . " WHERE weid = '{$weid}' And schoolid = {$school['id']} and  checkdatesetid = '{$checkdatesetid}' and type=2 ORDER BY id ASC ");
                                        $todaytimeset1 = transTimeset4T1($timeset_fri);
                                        $todaytimeset2 = array(array('startTime' => $timeset_fri[count($timeset_fri) - 1]['start'], 'endTime' => $timeset_fri[count($timeset_fri) - 1]['end']));
                                        $todaytimeset3 = transTimeset4T3($timeset_fri);
                                        $todaytimeset6 = transTimeset4T6($timeset_fri);
                                    } else {
                                        $todaytimeset1 = transTimeset4T1($timeset_work);
                                        $todaytimeset2 = array(array('startTime' => $timeset_work[count($timeset_work) - 1]['start'], 'endTime' => $timeset_work[count($timeset_work) - 1]['end']));
                                        $todaytimeset3 = transTimeset4T3($timeset_work);
                                        $todaytimeset6 = transTimeset4T6($timeset_work);
                                    }
                                } elseif ($k == 6) {//星期六
                                    if($checkdateset['saturday'] == 0){ // 周六放假
                                        $todaytimeset1 = $todaytimeset2 = $todaytimeset3 = $todaytimeset6 = array(array('startTime' => "00:00", 'endTime' => "23:59"));
                                    }else{
                                        $timeset_sat = pdo_fetchall("SELECT start,end FROM " . tablename($this->table_checktimeset) . " WHERE weid = '{$weid}' And schoolid = {$school['id']} and  checkdatesetid = '{$checkdatesetid}' and type=3 ORDER BY id ASC ");
                                        $todaytimeset1 = transTimeset4T1($timeset_sat);
                                        $todaytimeset3 = transTimeset4T3($timeset_sat);
                                        $todaytimeset6 = transTimeset4T6($timeset_sat);
                                        if($checkdateset['saturday'] == 2)// 如果周六单独设置，2表示放学后住校生允许出校
                                            $todaytimeset2 = array(array('startTime'=>$timeset_sat[count($timeset_sat)-1]['start'], 'endTime'=>$timeset_sat[count($timeset_sat)-1]['end']));
                                        else //否则不允许出校
                                            $todaytimeset2 = array(array('startTime' => "00:00", 'endTime' => "00:00"));
                                    }
                                } elseif ($k == 0) {//星期天
                                    if($checkdateset['sunday'] == 0){ // 周天放假
                                        $todaytimeset1 = $todaytimeset2 = $todaytimeset3 = $todaytimeset6 = array(array('startTime' => "00:00", 'endTime' => "23:59"));
                                    }else{
                                        $timeset_sun = pdo_fetchall("SELECT start,end FROM " . tablename($this->table_checktimeset) . " WHERE weid = '{$weid}' And schoolid = {$school['id']} and  checkdatesetid = '{$checkdatesetid}' and type=4 ORDER BY id ASC ");
                                        $todaytimeset1 = transTimeset4T1($timeset_sun);
                                        $todaytimeset3 = transTimeset4T3($timeset_sun);
                                        $todaytimeset6 = transTimeset4T6($timeset_sun);
                                        if($checkdateset['sunday'] == 2)// 如果周日单独设置，2表示放学后住校生允许出校
                                            $todaytimeset2 = array(array('startTime'=>$timeset_sun[count($timeset_sun)-1]['start'], 'endTime'=>$timeset_sun[count($timeset_sun)-1]['end']));
                                        else //否则不允许出校
                                            $todaytimeset2 = array(array('startTime' => "00:00", 'endTime' => "00:00"));
                                    }
                                } else {//工作日
                                    $todaytimeset1 = transTimeset4T1($timeset_work);
                                    $todaytimeset2 = array(array('startTime' => "00:00", 'endTime' => "00:00"));
                                    $todaytimeset3 = transTimeset4T3($timeset_work);
                                    $todaytimeset6 = transTimeset4T6($timeset_work);
                                }
                            }
                        }
                        $week1[$k] = array('weekno' => $k, 'groups' => $todaytimeset1);
                        $week2[$k] = array('weekno' => $k, 'groups' => $todaytimeset2);
                        $week3[$k] = array('weekno' => $k, 'groups' => $todaytimeset3);
                        $week5[$k] = $week4[$k] = array('weekno' => $k, 'groups' => array(array('startTime' => "00:00", 'endTime' => "00:00")));
                        $week6[$k] = array('weekno' => $k, 'groups' => $todaytimeset6);
                        // 如果是特殊设置为放假，则放行
                        if(!empty($todaytimeset4))
                            $week4[$k] = array('weekno' => $k, 'groups' => $todaytimeset4);
                        if(!empty($todaytimeset5))
                            $week5[$k] = array('weekno' => $k, 'groups' => $todaytimeset5);
                    }
                }elseif($ckmac['s_type'] == 2){     //如果是接送通道
                    for ($k = 0; $k < 7; ++$k) {
                        $todaytime = strtotime('+' . $k . ' day', strtotime($sunday));
                        $nowdate = date('Y-n-j', $todaytime);
                        $nowyear = date("Y", $todaytime);
                        $checkdateset_holi = pdo_fetch("SELECT * FROM " . tablename($this->table_checkdatedetail) . " WHERE weid = '{$weid}' And schoolid = {$school['id']} and  checkdatesetid = '{$checkdatesetid}' and year = '{$nowyear}' ");
                        $checktime = pdo_fetchall("SELECT * FROM " . tablename($this->table_checktimeset) . " WHERE weid = '{$weid}' And schoolid = {$school['id']} and  checkdatesetid = '{$checkdatesetid}' and date = '{$nowdate}' ORDER BY id ASC ");
                        if (!empty($checktime)) { // 如果周五、周六、周日单独设置（checktimeset里的date不为空）
                            if ($checktime[0]['type'] == 6) { //type=1工作日，2周五，3周六，4周日，5特殊上，6特殊休
                                $todaytimeset4 = $todaytimeset5 = array(array('startTime' => "00:00", 'endTime' => "23:59"));
                            } elseif ($checktime[0]['type'] == 5) {
                                $todaytimeset4 = transTimeset4T1($checktime);
                                $todaytimeset5 = transTimeset4T5($checktime);
                            }
                        } else {
                            if (($todaytime >= strtotime($checkdateset_holi['win_start']) && $todaytime <= strtotime($checkdateset_holi['win_end'])) || ($todaytime >= strtotime($checkdateset_holi['sum_start']) && $todaytime <= strtotime($checkdateset_holi['sum_end']))) { // 暑假和寒假放假
                                $todaytimeset4 = $todaytimeset5 = array(array('startTime' => "00:00", 'endTime' => "23:59"));
                            } else {
                                $timeset_work = pdo_fetchall("SELECT start,end FROM " . tablename($this->table_checktimeset) . " WHERE weid = '{$weid}' And schoolid = {$school['id']} and  checkdatesetid = '{$checkdatesetid}' and type=1 ORDER BY id ASC ");
                                if ($k == 5) {//星期五
                                    if ($checkdateset['friday'] == 1) {   // 如果周五单独设置，则周五最后一个时间段都可以放行
                                        $timeset_fri = pdo_fetchall("SELECT start,end FROM " . tablename($this->table_checktimeset) . " WHERE weid = '{$weid}' And schoolid = {$school['id']} and  checkdatesetid = '{$checkdatesetid}' and type=2 ORDER BY id ASC ");
                                        $todaytimeset4 = transTimeset4T1($timeset_fri);
                                        $todaytimeset5 = transTimeset4T5($timeset_fri);
                                    } else {
                                        $todaytimeset4 = transTimeset4T1($timeset_work);
                                        $todaytimeset5 = transTimeset4T5($timeset_work);
                                    }
                                } elseif ($k == 6) {//星期六
                                    if ($checkdateset['saturday'] == 1) {     // 如果周六单独设置，则按照工作日的规则设置
                                        $timeset_sat = pdo_fetchall("SELECT start,end FROM " . tablename($this->table_checktimeset) . " WHERE weid = '{$weid}' And schoolid = {$school['id']} and  checkdatesetid = '{$checkdatesetid}' and type=3 ORDER BY id ASC ");
                                        $todaytimeset4 = transTimeset4T1($timeset_sat);
                                        $todaytimeset5 = transTimeset4T5($timeset_sat);
                                    } else {
                                        $todaytimeset4 = $todaytimeset5 = array(array('startTime' => "00:00", 'endTime' => "23:59"));
                                    }
                                } elseif ($k == 0) {//星期天
                                    if ($checkdateset['sunday'] == 1) {   // 如果周日单独设置，则按照工作日的规则设置
                                        $timeset_sun = pdo_fetchall("SELECT start,end FROM " . tablename($this->table_checktimeset) . " WHERE weid = '{$weid}' And schoolid = {$school['id']} and  checkdatesetid = '{$checkdatesetid}' and type=4 ORDER BY id ASC ");
                                        $todaytimeset4 = transTimeset4T1($timeset_sun);
                                        $todaytimeset5 = transTimeset4T5($timeset_sun);
                                    } else {
                                        $todaytimeset4 = $todaytimeset5 = array(array('startTime' => "00:00", 'endTime' => "23:59"));
                                    }
                                } else {//工作日
                                    $todaytimeset4 = transTimeset4T1($timeset_work);
                                    $todaytimeset5 = transTimeset4T5($timeset_work);
                                }
                            }
                        }
                        $week1[$k] = $week2[$k] = $week3[$k]= array('weekno' => $k, 'groups' => array(array('startTime' => "00:00", 'endTime' => "00:00")));
                        $week4[$k] = array('weekno' => $k, 'groups' => $todaytimeset4);
                        $week5[$k] = array('weekno' => $k, 'groups' => $todaytimeset5);
                        $week6[$k] = array('weekno' => $k, 'groups' => $todaytimeset5); //学生类型6在接送通道和类型5的规则是一样的
                    }
                }

                $timeset1[0] = array('id'=>0, 'weeks'=>$week1);
                $timeset1[1] = array('id'=>1, 'weeks'=>$week1);
                $timeset1[2] = array('id'=>2, 'weeks'=>$week2);
                $timeset1[3] = array('id'=>3, 'weeks'=>$week3);
                $timeset1[4] = array('id'=>4, 'weeks'=>$week4);
                $timeset1[5] = array('id'=>5, 'weeks'=>$week5);
                $timeset1[6] = array('id'=>6, 'weeks'=>$week6);
            }

            $result['data']['timeset'] = $timeset1; //  每周通行时间段
            $result['data']['leave'] = $leaves; // 请假人员名单
            $result['code'] = 1000;
            $result['msg'] = "success";
            $result['ServerTime'] = date('Y-m-d H:i:s',time());
            echo json_encode($result);
        }
    }else{//如果是教师
        if(!empty($ckmac)){
            $class = pdo_fetchall("SELECT id as TID, fz_id as classId, thumb as headIcon, tname as name, updatetime FROM " . tablename($this->table_teachers) . " WHERE weid = '{$weid}' And schoolid = {$school['id']} And fz_id = '{$classid}' ORDER BY id DESC");
            foreach($class as $key =>$row) {
                if(!empty($row['headIcon'])){
                    $class[$key]['headIcon'] = $urls.$row['headIcon'];
                }else{
                    $class[$key]['headIcon'] = !empty($school['tpic'])? $urls.$school['tpic'] : "";
                }
                $class[$key]['childId'] = "909".$row['TID'];
                $class[$key]['name'] = $row['name'];
                $class[$key]['signId'] = "";
                $class[$key]['s_type'] = "909"; //如果是老师，则s_type=909，通行不受限制
                $card = pdo_fetchall("SELECT idcard,severend  FROM " . tablename($this->table_idcard) . " WHERE tid = '{$row['TID']}'ORDER BY id DESC");
                if(($card['0']['severend'] < time() && $card['0']['severend'] != 0) || $card['0']['severend'] == null) // 如果超出有效期，则更新标识
                    $class[$key]['updatetime']--;
                else {
                    $num = count($card);
                    if ($num > 1) {
                        foreach ($card as $k => $r) {
                            if (!empty($r['idcard'])) {
                                $class[$key]['signId'] .= "#" . $r['idcard'];
                            }
                        }
                    } else {
                        $class[$key]['signId'] = $card['0']['idcard'];
                    }
                }

                //  是否启用人脸识别
                if($isface['is_face'] == 1 || $isface['is_face'] == 3){
                    $class[$key]['faceid'] = $card['0']['idcard'];
                }else
                    $class[$key]['faceid'] = -1;
            }
            $result['data']['childs'] = $class;
            $result['code'] = 1000;
            $result['msg'] = "success";
            $result['ServerTime'] = date('Y-m-d H:i:s',time());
            echo json_encode($result);
        }
    }
}

if ($operation == 'check') {
    $starttime=time();

    $fstype = false;
    if(strlen($_GPC['signId']) < 10) {  //  部分卡号前面是0时，被闸机删除了0，需要补回来
        $nums = 10 -  strlen($_GPC['signId']);
        for($i=0; $i < $nums; $i++)
            $_GPC['signId'] = '0' . $_GPC['signId'];
    }

    $ckuser = pdo_fetch("SELECT * FROM " . tablename($this->table_idcard) . " WHERE idcard = :idcard And schoolid = :schoolid ", array(':idcard' =>$_GPC['signId'],':schoolid' =>$schoolid));
    if($_GPC['mactype'] == 'other'){
        $signTime = strtotime($_GPC['signTime']);
    }else{
        $signTime = trim($_GPC['signTime']);
    }
    //如果签到时间与当前服务器时间相差大于10分钟，则将信息存入log表中
    if(abs($signTime - time()) > 3600){
        $log = pdo_fetch("SELECT * FROM " . tablename($this->table_log) . " WHERE schoolid = :schoolid AND type = 1 AND createtime > $todayTime AND createtime < $tomorrowTime", array(':schoolid' =>$schoolid));
        if(empty($log)){
            $data = array(
                'weid' => $weid,
                'schoolid' => $schoolid,
                'type' => 1,
                'createtime' => time(),
                'msg' => "学校服务器时间与后台时间偏差大于1小时，或服务器发送信息滞后，请检查！",
            );
            pdo_insert($this->table_log, $data);
        }
    }
//    $checkthisdata = pdo_fetch("SELECT * FROM " . tablename($this->table_checklog) . " WHERE cardid = :cardid And schoolid = :schoolid And createtime = :createtime ", array(':cardid' =>$_GPC['signId'],':schoolid' =>$schoolid,':createtime' =>$signTime));
    $checkthisdata = pdo_fetch("SELECT * FROM " . tablename($this->table_checklog) . " WHERE cardid = :cardid And schoolid = :schoolid ORDER BY createtime DESC, id DESC ", array(':cardid' =>$_GPC['signId'],':schoolid' =>$schoolid)); //解决刷进后马上刷出（间隔不到1秒），导致反复插入数据库的问题
    $signMode = $_GPC['signMode'];
    $nowtime = date('H:i',$signTime);
    if ($ckmac['type'] != 0) { // checkmac的type字段表示该设备是进校还是离校，0表示不区分
        include 'checktime2.php';
    } else {
        include 'checktime.php';
    }
    $checklog = false;  // 考勤信息是否录入系统
    if(empty($checkthisdata))   // 如果没有记录
        $checklog = true;
    elseif(abs($signTime - $checkthisdata['createtime']) > 60) //  如果刷卡间隔大于60秒
        $checklog = true;
    elseif($checkthisdata['leixing'] != $leixing)   //  如果不是同时刷进或刷出
        $checklog = true;

    $has_pic = false;
    if($checklog){ //1分钟内的相同方向刷卡都认为是重复刷卡
        if(!empty($ckuser)) {
            $times = TIMESTAMP;
            if($_GPC['picurl']) {
                load()->func('file');
                $urls = "http://www.daren007.com/attachment/";
                $path = "images/fm_jiaoyu/check/". date('Y/m/d/');
                if (!is_dir(IA_ROOT."/attachment/". $path)) {
                    mkdirs(IA_ROOT."/attachment/". $path, "0777");
                }
                $rand = random(30);
                if(!empty($_GPC['picurl'])) {
                    if(strpos($_GPC['picurl'], "images/fm_jiaoyu/check2/") === 0){  //  如果picurl是图片路径名称，则直接存储（由考勤机上传照片到七牛）
                        $has_pic = false;
                        $pic = $_GPC['picurl'];
                    }else {
                        $picurl = $path . $rand . "_1.jpg";
                        if ($_GPC['mactype'] == 'other') {
                            $pic_url = base64_decode(str_replace(" ", "+", $_GPC['picurl']));
                        } else {
                            $pic_url = file_get_contents($urls . $_GPC['picurl']);
                        }
                        file_write($picurl, $pic_url);
                        $pic = $picurl;
                        $has_pic = true;
                    }
                }
                if(!empty($_GPC['picurl2'])) {
                    $picurl2 = $path.$rand."_2.jpg";
                    if($_GPC['mactype'] == 'other'){
                        $pic_url2 = base64_decode(str_replace(" ","+",$_GPC['picurl2']));
                    }else{
                        $pic_url2 = file_get_contents($urls.$_GPC['picurl2']);
                    }
                    file_write($picurl2,$pic_url2);
                    if (!empty($_W['setting']['remote']['type'])){
                        $remotestatus = file_remote_upload($picurl2);
                    }
                    $pic2 = $picurl2;
                }
            }
            if($_GPC['signId'] == '999999999'){
                $data = array(
                    'weid' => $weid,
                    'schoolid' => $schoolid,
                    'macid' => $ckmac['id'],
                    'lon' => $_GPC['lon'],
                    'lat' => $_GPC['lat'],
                    'cardid' => $_GPC ['signId'],
                    'type' => "无卡进出",
                    'pic' => $pic,
                    'pic2' => $pic2,
                    'leixing' => $leixing,
                    'createtime' => $signTime
                );
                pdo_insert($this->table_checklog, $data);
                $fstype = true;
            }
            if(!empty($ckuser['sid'])){
                $bj = pdo_fetch("SELECT bj_id FROM " . tablename($this->table_students) . " WHERE id = :id ", array(':id' =>$ckuser['sid']));
                if($school['is_cardpay'] == 1){
                    if($ckuser['severend'] > $times){
                        $data = array(
                            'weid' => $weid,
                            'schoolid' => $schoolid,
                            'macid' => $ckmac['id'],
                            'cardid' => $_GPC ['signId'],
                            'sid' => $ckuser['sid'],
                            'bj_id' => $bj['bj_id'],
                            'type' => $type,
                            'pic' => $pic,
                            'pic2' => $pic2,
                            'lon' => $_GPC['lon'],
                            'lat' => $_GPC['lat'],
                            'temperature' => $_GPC ['signTemp'],
                            'leixing' => $leixing,
                            'pard' => $ckuser['pard'],
                            'createtime' => $signTime
                        );
                        pdo_insert($this->table_checklog, $data);
                        $checkid = pdo_insertid();
                        if($school['send_overtime'] >= 1){
                            $overtime = $school['send_overtime']*60;
                            $timecha = $times - $signTime;
                            if($overtime >= $timecha){
                                $this->sendMobileJxlxtz($schoolid, $weid, $bj['bj_id'], $ckuser['sid'], $type, $leixing, $checkid, $ckuser['pard']);
                            }else{
                                $result['info'] = "延迟发送之数据将不推送刷卡提示";
                            }
                        }else{
                            $this->sendMobileJxlxtz($schoolid, $weid, $bj['bj_id'], $ckuser['sid'], $type, $leixing, $checkid, $ckuser['pard']);
                        }
                    }else{
                        $result['info'] = "本卡已失效,请联系学校管理员";
                    }
                    $fstype = true;
                }
                else{
                    $data = array(
                        'weid' => $weid,
                        'schoolid' => $schoolid,
                        'macid' => $ckmac['id'],
                        'cardid' => $_GPC ['signId'],
                        'sid' => $ckuser['sid'],
                        'bj_id' => $bj['bj_id'],
                        'type' => $type,
                        'pic' => $pic,
                        'pic2' => $pic2,
                        'lon' => $_GPC['lon'],
                        'lat' => $_GPC['lat'],
                        'temperature' => $_GPC ['signTemp'],
                        'leixing' => $leixing,
                        'pard' => $ckuser['pard'],
                        'createtime' => $signTime
                    );
                    pdo_insert($this->table_checklog, $data);
                    $checkid = pdo_insertid();

                    $wxres = "";
                    $wxstate = 1; // 1-发送成功，2-用户没有绑定微信， 3-超过设置的延时不发送， 4-发送失败
                    if($school['send_overtime'] >= 1){ // 如果设置了延时不发送
                        $overtime = $school['send_overtime']*60;
                        $timecha = $times - $signTime;
                        if($overtime >= $timecha){
                            $res = $this->sendMobileJxlxtz($schoolid, $weid, $bj['bj_id'], $ckuser['sid'], $type, $leixing, $checkid, $ckuser['pard']);
                        }else{
                            $result['info'] = "延迟发送之数据将不推送刷卡提示";
                            $wxres="delay not send, shcoolid: ".$schoolid. ", cardid：".$_GPC ['signId'].", signTime：".date("Y-m-d h:i:s", $signTime).", sendTime：".date("Y-m-d h:i:s");
                            $wxstate = 3;
                        }
                    }else{
                        $res = $this->sendMobileJxlxtz($schoolid, $weid, $bj['bj_id'], $ckuser['sid'], $type, $leixing, $checkid, $ckuser['pard']);
                    }

                    if(is_array($res)) {
                        $wxstate = $res['code'];
                        if ($wxstate == 4) { //部分发送成功
                            $wxres = $res['content'];
                        }
                    }
                    $rse = pdo_update($this->table_checklog, array('wxstate' => $wxstate, 'remark'=> $wxres), array('id' => $checkid));
                    $fstype = true;
                }
            }
            if(!empty($ckuser['tid'])){
                $data = array(
                    'weid' => $weid,
                    'schoolid' => $schoolid,
                    'macid' => $ckmac['id'],
                    'cardid' => $_GPC ['signId'],
                    'tid' => $ckuser['tid'],
                    'type' => $type,
                    'leixing' => $leixing,
                    'pic' => $pic,
                    'pic2' => $pic2,
                    'pard' => 1,
                    'createtime' => $signTime
                );
                pdo_insert($this->table_checklog, $data);
                $fstype = true;
            }
        }else{
            $result['info'] = "本卡(".$_GPC['signId'].")未绑定任何学生或老师";
        }
    }else{
        $fstype = true;
        $result['info'] = "1分钟内不可重复相同刷卡数据，signTime=".$signTime.", checkthisdata=".$checkthisdata['createtime'].", checkthisdata=".$checkthisdata['leixing'].", leixing=".$leixing;
    }
    if ($fstype ==true){
        $end7=time();
        $result['data'] = "";
        $result['code'] = 1000;
        $result['msg'] = "success";
        $result['ServerTime'] = date('Y-m-d H:i:s',time());
        $result['CostTime'] = $end7-$starttime;
        echo json_encode($result);

        $s1 = time();
        if ($has_pic==true && !empty($_W['setting']['remote']['type'])){//上传远程附件，此处耗时较多
            $remotestatus = file_remote_upload($picurl, true);
        }
        $s2=time();

        if(($end7 - $starttime) > 60 || ($s2-$s1) > 60 || ($starttime - $signTime) > 120) {
            $logfile = './Check_time_' . date("Y-m-d", $starttime) . '.log';
            $dir_name = dirname($logfile);
            if (!file_exists($dir_name)) {
                mkdir(iconv("UTF-8", "GBK", $dir_name), 0777, true);
            }
            $fp = fopen($logfile, "a");//打开文件资源通道 不存在则自动创建
            fwrite($fp, "url:" . 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . "&signId=" . $_GPC ['signId'] . "&signTime=".  $_GPC['signTime'] . "&signMode=" . $_GPC['signMode'] . ", 接收时间：". date("Y-m-d H:i:s", $starttime) . ",接收延时：". ($starttime - $signTime) .",返回耗时:" . ($end7 - $starttime) . ", 上传七牛耗时：" .($s2-$s1). ", remotestatus:".$remotestatus. "\n");//写入文件
            fclose($fp);//关闭资源通道
        }
        exit;
    }else{
        $end8=time();
        $result['data'] = "";
        $result['code'] = 300;
        $result['msg'] = "lose";
        $result['ServerTime'] = date('Y-m-d H:i:s',time());
        $result['CostTime'] = $end8-$starttime;
        echo json_encode($result);
        exit;
    }
}

if ($operation == 'gps') {
    $fstype = false;
    $ckuser = pdo_fetch("SELECT * FROM " . tablename($this->table_idcard) . " WHERE idcard = '{$_GPC['signId']}' And weid = '{$weid}' And schoolid = '{$schoolid}' ");
    $bj = pdo_fetch("SELECT bj_id FROM " . tablename($this->table_students) . " WHERE id = '{$ckuser['sid']}' ");
    $checkthisdata = pdo_fetch("SELECT * FROM " . tablename($this->table_checklog) . " WHERE cardid = '{$_GPC['signId']}' And createtime = '{$_GPC['signTime']}' And schoolid = '{$schoolid}' ");
    if(empty($checkthisdata)){
        if(!empty($ckuser)){
            $times = TIMESTAMP;
            $nowtime = date('H:i',$times);
            if($ckmac['type'] !=0){
                include 'checktime2.php';
            }else{
                include 'checktime.php';
            }
            $signTime = trim($_GPC['signTime']);
            if(!empty($ckuser['sid'])){
                if($school['is_cardpay'] == 1){
                    if($ckuser['severend'] > $times){
                        $data = array(
                            'weid' => $weid,
                            'schoolid' => $schoolid,
                            'macid' => $ckmac['id'],
                            'cardid' => $_GPC ['signId'],
                            'sid' => $ckuser['sid'],
                            'bj_id' => $bj['bj_id'],
                            'type' => $type,
                            'temperature' => $_GPC ['signTemp'],
                            'leixing' => $leixing,
                            'pard' => $ckuser['pard'],
                            'lon' => $_GPC['lon'],
                            'lat' => $_GPC['lat'],
                            'createtime' => $signTime
                        );
                        pdo_insert($this->table_checklog, $data);
                        $checkid = pdo_insertid();
                        if($school['send_overtime'] >= 1){
                            $overtime = $school['send_overtime']*60;
                            $timecha = $times - $signTime;
                            if($overtime >= $timecha){
                                $this->sendMobileJxlxtz($schoolid, $weid, $bj['bj_id'], $ckuser['sid'], $type, $leixing, $checkid, $ckuser['pard']);
                            }else{
                                $result['info'] = "延迟发送之数据将不推送刷卡提示";
                            }
                        }else{
                            $this->sendMobileJxlxtz($schoolid, $weid, $bj['bj_id'], $ckuser['sid'], $type, $leixing, $checkid, $ckuser['pard']);
                        }
                        $fstype = true;
                    }
                }else{
                    $data = array(
                        'weid' => $weid,
                        'schoolid' => $schoolid,
                        'macid' => $ckmac['id'],
                        'cardid' => $_GPC ['signId'],
                        'sid' => $ckuser['sid'],
                        'bj_id' => $bj['bj_id'],
                        'type' => $type,
                        'temperature' => $_GPC ['signTemp'],
                        'leixing' => $leixing,
                        'lon' => $_GPC['lon'],
                        'lat' => $_GPC['lat'],
                        'pard' => $ckuser['pard'],
                        'createtime' => $signTime
                    );
                    pdo_insert($this->table_checklog, $data);
                    $checkid = pdo_insertid();
                    if($school['send_overtime'] >= 1){
                        $overtime = $school['send_overtime']*60;
                        $timecha = $times - $signTime;
                        if($overtime >= $timecha){
                            $this->sendMobileJxlxtz($schoolid, $weid, $bj['bj_id'], $ckuser['sid'], $type, $leixing, $checkid, $ckuser['pard']);
                        }else{
                            $result['info'] = "延迟发送之数据将不推送刷卡提示";
                        }
                    }else{
                        $this->sendMobileJxlxtz($schoolid, $weid, $bj['bj_id'], $ckuser['sid'], $type, $leixing, $checkid, $ckuser['pard']);
                    }
                    $fstype = true;
                }
            }
            if(!empty($ckuser['tid'])){
                $data = array(
                    'weid' => $weid,
                    'schoolid' => $schoolid,
                    'macid' => $ckmac['id'],
                    'cardid' => $_GPC ['signId'],
                    'tid' => $ckuser['tid'],
                    'type' => $type,
                    'leixing' => $leixing,
                    'pard' => 1,
                    'lon' => $_GPC['lon'],
                    'lat' => $_GPC['lat'],
                    'createtime' => $signTime
                );
                pdo_insert($this->table_checklog, $data);
                $fstype = true;
            }
        }
    }
    if ($fstype !=false){
        $result['data'] = "";
        $result['code'] = 1000;
        $result['msg'] = "success";
        $result['ServerTime'] = date('Y-m-d H:i:s',time());
        echo json_encode($result);
        exit;
        //print_r($signData);
    }else{
        $result['data'] = "";
        $result['code'] = 300;
        $result['msg'] = "lose";
        $result['ServerTime'] = date('Y-m-d H:i:s',time());
        echo json_encode($result);
        exit;
        //print_r($signData);
    }
}

if ($operation == 'banner') {
    $banner = unserialize($ckmac['banner']);
    $ims = tomedia($banner['pic1']).'#'.tomedia($banner['pic2']).'#'.tomedia($banner['pic3']).'#'.tomedia($banner['pic4']);
    $result['data'] = array(
        'img' => $ims,
        'mc' => $banner['pop']
    );
    $result['code'] = 1000;
    $result['msg'] = "success";
    $result['ServerTime'] = date('Y-m-d H:i:s',time());
    $temp = array(
        'isflow' => 2,
        'pop' => $banner['pop'],
        'video' => $banner['video'],
        'pic1' => $banner['pic1'],
        'pic1' => $banner['pic1'],
        'pic2' => $banner['pic2'],
        'pic3' => $banner['pic3'],
        'pic4' => $banner['pic4'],
        'VOICEPRE' => $banner['VOICEPRE'],
    );
    $temp1['banner'] = serialize($temp);
    pdo_update($this->table_checkmac, $temp1, array('id' => $ckmac['id']));
    echo json_encode($result);
    exit;
}

if ($operation == 'video') {
    $banner = unserialize($ckmac['banner']);
    $result['data'] = array(
        'videoId' => 2,
        'videoUrl' => $banner['video']
    );
    $result['code'] = 1000;
    $result['msg'] = "success";
    $result['ServerTime'] = date('Y-m-d H:i:s',time());
    $temp = array(
        'isflow' => 2,
        'pop' => $banner['pop'],
        'video' => $banner['video'],
        'pic1' => $banner['pic1'],
        'pic1' => $banner['pic1'],
        'pic2' => $banner['pic2'],
        'pic3' => $banner['pic3'],
        'pic4' => $banner['pic4'],
        'VOICEPRE' => $banner['VOICEPRE'],
    );
    $temp1['banner'] = serialize($temp);
    pdo_update($this->table_checkmac, $temp1, array('id' => $ckmac['id']));
    echo json_encode($result);
    exit;
}

if ($operation == 'getleave') {
    $time = $_GPC['signtime'];
    $ckuser        = pdo_fetch("SELECT sid FROM " . tablename($this->table_idcard) . " WHERE idcard = '{$_GPC['iccode']}' And weid = '{$weid}' And schoolid = '{$schoolid}' ");
    $leave        =  pdo_fetch("SELECT sid,startime1,endtime1 FROM " . tablename($this->table_leave) . " WHERE weid = '{$weid}'  And schoolid = '{$schoolid}' and isliuyan = 0 and status = 1 and startime1 <= '{$time}' and endtime1 >= '{$time}' and sid = '{$ckuser['sid']}' ");
    $result['code'] = 1000;
    $result['msg']    = "success";
    if(!empty($leave)){
        $result['data']['openDoor']   = 0;
    }else{
        $result['data']['openDoor']   = 1;
    }

    echo json_encode($result);
    exit;
}

if ($operation == 'qrcode') {
    $singId = $_GPC['signId']; //18位（前8位是学生的id，后10位是unix时间戳）

    if(strlen($singId) != 18){
        $result['code'] = 2001;
        $result['msg'] = 'signId必须是18位，前8位是学生的id，后10位是unix时间戳';
        echo json_encode($result);
        exit;
    }

    $childId = substr($singId, 0, 8);
    $expire = substr($singId, 8, 10);
    $qrcode =  pdo_fetch("SELECT ticket, expire FROM " . tablename($this->table_qrinfo) . " WHERE qrcid = '{$childId}' And expire = '{$expire}' And weid = '{$weid}' And schoolid = '{$schoolid}' And model=3");
    if(!empty($qrcode)){
        if($qrcode['expire'] < time()){
            $result['code'] = 2002;
            $result['msg'] = '该二维码已过期，禁止通行';
        }else{
            //二维码正确，写入考勤数据(与上面check的逻辑是一样的)
            $fstype = false;
            $ckuser = pdo_fetch("SELECT * FROM " . tablename($this->table_idcard) . " WHERE idcard = :idcard And schoolid = :schoolid ", array(':idcard' =>$_GPC['signId'],':schoolid' =>$schoolid));
            if($_GPC['mactype'] == 'other'){
                $signTime = strtotime($_GPC['signTime']);
            }else{
                $signTime = trim($_GPC['signTime']);
            }
            $checkthisdata = pdo_fetch("SELECT * FROM " . tablename($this->table_checklog) . " WHERE cardid = :cardid And schoolid = :schoolid And createtime = :createtime ", array(':cardid' =>$_GPC['signId'],':schoolid' =>$schoolid,':createtime' =>$signTime));
            if(empty($checkthisdata)){
                if(!empty($ckuser)){
                    $times = TIMESTAMP;
                    $nowtime = date('H:i',$signTime);
                    if($_GPC['picurl']) {
                        load()->func('file');
                        $urls = "http://www.daren007.com/attachment/";
                        $path = "images/fm_jiaoyu/check/". date('Y/m/d/');
                        if (!is_dir(IA_ROOT."/attachment/". $path)) {
                            mkdirs(IA_ROOT."/attachment/". $path, "0777");
                        }
                        $rand = random(30);
                        if(!empty($_GPC['picurl'])) {
                            $picurl = $path.$rand."_1.jpg";
                            if($_GPC['mactype'] == 'other'){
                                $pic_url = base64_decode(str_replace(" ","+",$_GPC['picurl']));
                            }else{
                                $pic_url = file_get_contents($urls.$_GPC['picurl']);
                            }
                            file_write($picurl,$pic_url);
                            if (!empty($_W['setting']['remote']['type'])){
                                $remotestatus = file_remote_upload($picurl);
                            }
                            $pic = $picurl;
                        }
                        if(!empty($_GPC['picurl2'])) {
                            $picurl2 = $path.$rand."_2.jpg";
                            if($_GPC['mactype'] == 'other'){
                                $pic_url2 = base64_decode(str_replace(" ","+",$_GPC['picurl2']));
                            }else{
                                $pic_url2 = file_get_contents($urls.$_GPC['picurl2']);
                            }
                            file_write($picurl2,$pic_url2);
                            if (!empty($_W['setting']['remote']['type'])){
                                $remotestatus = file_remote_upload($picurl2);
                            }
                            $pic2 = $picurl2;
                        }
                    }
                    $signMode = $_GPC['signMode'];
                    if($ckmac['type'] !=0){
                        include 'checktime2.php';
                    }else{
                        include 'checktime.php';
                    }
                    if($_GPC['signId'] == '999999999'){
                        $data = array(
                            'weid' => $weid,
                            'schoolid' => $schoolid,
                            'macid' => $ckmac['id'],
                            'lon' => $_GPC['lon'],
                            'lat' => $_GPC['lat'],
                            'cardid' => $_GPC ['signId'],
                            'type' => "无卡进出",
                            'pic' => $pic,
                            'pic2' => $pic2,
                            'leixing' => $leixing,
                            'createtime' => $signTime
                        );
                        pdo_insert($this->table_checklog, $data);
                        $fstype = true;
                    }
                    if(!empty($ckuser['sid'])){
                        $bj = pdo_fetch("SELECT bj_id FROM " . tablename($this->table_students) . " WHERE id = :id ", array(':id' =>$ckuser['sid']));
                        if($school['is_cardpay'] == 1){
                            if($ckuser['severend'] > $times){
                                $data = array(
                                    'weid' => $weid,
                                    'schoolid' => $schoolid,
                                    'macid' => $ckmac['id'],
                                    'cardid' => $_GPC ['signId'],
                                    'sid' => $ckuser['sid'],
                                    'bj_id' => $bj['bj_id'],
                                    'type' => $type,
                                    'pic' => $pic,
                                    'pic2' => $pic2,
                                    'lon' => $_GPC['lon'],
                                    'lat' => $_GPC['lat'],
                                    'temperature' => $_GPC ['signTemp'],
                                    'leixing' => $leixing,
                                    'pard' => $ckuser['pard'],
                                    'createtime' => $signTime
                                );
                                pdo_insert($this->table_checklog, $data);
                                $checkid = pdo_insertid();
                                if($school['send_overtime'] >= 1){
                                    $overtime = $school['send_overtime']*60;
                                    $timecha = $times - $signTime;
                                    if($overtime >= $timecha){
                                        $this->sendMobileJxlxtz($schoolid, $weid, $bj['bj_id'], $ckuser['sid'], $type, $leixing, $checkid, $ckuser['pard']);
                                    }else{
                                        $result['info'] = "延迟发送之数据将不推送刷卡提示";
                                    }
                                }else{
                                    $this->sendMobileJxlxtz($schoolid, $weid, $bj['bj_id'], $ckuser['sid'], $type, $leixing, $checkid, $ckuser['pard']);
                                }
                            }else{
                                $result['info'] = "本卡已失效,请联系学校管理员";
                            }
                            $fstype = true;
                        }else{
                            $data = array(
                                'weid' => $weid,
                                'schoolid' => $schoolid,
                                'macid' => $ckmac['id'],
                                'cardid' => $_GPC ['signId'],
                                'sid' => $ckuser['sid'],
                                'bj_id' => $bj['bj_id'],
                                'type' => $type,
                                'pic' => $pic,
                                'pic2' => $pic2,
                                'lon' => $_GPC['lon'],
                                'lat' => $_GPC['lat'],
                                'temperature' => $_GPC ['signTemp'],
                                'leixing' => $leixing,
                                'pard' => $ckuser['pard'],
                                'createtime' => $signTime
                            );
                            pdo_insert($this->table_checklog, $data);
                            $checkid = pdo_insertid();
                            if($school['send_overtime'] >= 1){
                                $overtime = $school['send_overtime']*60;
                                $timecha = $times - $signTime;
                                if($overtime >= $timecha){
                                    $this->sendMobileJxlxtz($schoolid, $weid, $bj['bj_id'], $ckuser['sid'], $type, $leixing, $checkid, $ckuser['pard']);
                                }else{
                                    $result['info'] = "延迟发送之数据将不推送刷卡提示";
                                }
                            }else{
                                $this->sendMobileJxlxtz($schoolid, $weid, $bj['bj_id'], $ckuser['sid'], $type, $leixing, $checkid, $ckuser['pard']);
                            }
                            $fstype = true;
                        }
                    }
                    if(!empty($ckuser['tid'])){
                        $data = array(
                            'weid' => $weid,
                            'schoolid' => $schoolid,
                            'macid' => $ckmac['id'],
                            'cardid' => $_GPC ['signId'],
                            'tid' => $ckuser['tid'],
                            'type' => $type,
                            'leixing' => $leixing,
                            'pic' => $pic,
                            'pic2' => $pic2,
                            'pard' => 1,
                            'createtime' => $signTime
                        );
                        pdo_insert($this->table_checklog, $data);
                        $fstype = true;
                    }
                }else{
                    $result['info'] =  "本卡(".$_GPC['signId'].")未绑定任何学生或老师";
                }
            }else{
                $fstype = true;
                $result['info'] = "不可重复相同刷卡数据";
            }
            if ($fstype ==true){
                $result['data']['name'] = $ckuser['pname'];
                if(!empty($ckuser['sid']) && $ckuser['sid'] != 0){
                    $std = pdo_fetch("SELECT bj_id FROM " . tablename($this->table_students) . " WHERE id = :id ", array(':id' =>$ckuser['sid']));
                    $bj = pdo_fetch("SELECT sname FROM " . tablename($this->table_classify) . " WHERE sid = :sid ", array(':sid' =>$std['bj_id']));
                    $result['data']['class'] = $bj['sname'];
                }
//                    $result['data'] = "";
                $result['code'] = 1000;
                $result['msg'] = "success";
                $result['ServerTime'] = date('Y-m-d H:i:s',time());
            }else{
                $result['data'] = "";
                $result['code'] = 300;
                $result['msg'] = "lose";
                $result['ServerTime'] = date('Y-m-d H:i:s',time());
            }
        }
    }else{
        $result['code'] = 2003;
        $result['msg'] = '非法二维码，禁止通行';
        $result['data'] = $sql."  000   ".$qrcode;
    }
    echo json_encode($result);
    exit;
}

/** 根据正常的上课时间算出走读生（Type=1）的允许外出时间段
 *
 * @param $checktime 正常的上课时间
 * @return array 允许外出的时间段
 */
function transTimeset4T1($checktime){
    for($i=0, $len=count($checktime); $i < $len; ++$i){
        $time[$i] = array('startTime'=>$checktime[$i]['start'], 'endTime'=>$checktime[$i]['end']);
    }
    return $time;
}

/** 根据正常的上课时间算出半住宿生（Type=3）的允许外出时间段
 *
 * @param $checktime 正常的上课时间
 * @return array 允许外出的时间段:最后一个时间段.
 */
function transTimeset4T3($checktime){
    $len=count($checktime);
//    $time[0] = array('startTime'=>$checktime[0]['start'], 'endTime'=>$checktime[0]['end']);

    if($len>=1)
        $time[0] = array('startTime'=>$checktime[$len-1]['start'], 'endTime'=>$checktime[$len-1]['end']);

    return $time;
}
/** 根据正常的上课时间算出在接送通道Type=5或6的允许外出时间段
 *
 * @param $checktime 正常的允许通行时间段
 * @return array 允许外出的时间段:最后一个时间段.
 */
function transTimeset4T5($checktime){
    $len=count($checktime);

    if($len>=1)
        $time[0] = array('startTime'=>$checktime[$len-1]['start'], 'endTime'=>$checktime[$len-1]['end']);

    return $time;
}

/** 根据正常的上课时间算出中午自走下午接送生（Type=6）的允许外出时间段
 *
 * @param $checktime 正常的上课时间
 * @return array 允许外出的时间段:中午时间段.
 */
function transTimeset4T6($checktime){
    $start = strtotime("10:30");
    $end = strtotime("14:00");
    $i=0;
    foreach ($checktime as $timeset){
        $t = strtotime($timeset['start']);
        if($t >= $start && $t <= $end) {
            $time[$i] = array('startTime' => $timeset['start'], 'endTime' => $timeset['end']);
            $i++;
        }
    }

    return $time;
}

/** 验证身份证号码是否正确
 * @param $value 身份证号码
 * @return bool 正确true，错误false
 */
function checkIdCard($value){
    if (!preg_match('/^\d{17}[0-9xX]$/', $value)) { //基本格式校验
        return false;
    }

    $parsed = date_parse(substr($value, 6, 8));
    if (!(isset($parsed['warning_count']) && $parsed['warning_count'] == 0)) { //年月日位校验
        return false;
    }
    $base = substr($value, 0, 17);
    $factor = [7, 9, 10, 5, 8, 4, 2, 1, 6, 3, 7, 9, 10, 5, 8, 4, 2];
    $tokens = ['1', '0', 'X', '9', '8', '7', '6', '5', '4', '3', '2'];
    $checkSum = 0;
    for ($i=0; $i<17; $i++) {
        $checkSum += intval(substr($base, $i, 1)) * $factor[$i];
    }
    $mod = $checkSum % 11;
    $token = $tokens[$mod];
    $lastChar = strtoupper(substr($value, 17, 1));
    return ($lastChar === $token); //最后一位校验位校验
}

?>