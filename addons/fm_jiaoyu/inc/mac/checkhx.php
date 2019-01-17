<?php
/**
 * By 高贵血迹
 */

global $_GPC, $_W;

$operation = in_array ( $_GPC ['op'], array ('default', 'login', 'classinfo', 'check', 'gps', 'banner', 'video','getleave', 'qrcode') ) ? $_GPC ['op'] : 'default';
$weid = $_GPC['i'];
$schoolid = $_GPC['schoolid'];
$macid = $_GPC['macid'];
$ckmac = pdo_fetch("SELECT * FROM " . tablename($this->table_checkmac) . " WHERE macid = '{$macid}' And schoolid = '{$schoolid}' ");
$school = pdo_fetch("SELECT * FROM " . tablename($this->table_index) . " WHERE id = '{$schoolid}' ");
if ($operation == 'default') {
    echo("错误，未知操作");
    exit;
}
if(empty($school)){
    echo("找不到本校");
    exit;
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
                $card = pdo_fetchall("SELECT idcard  FROM " . tablename($this->table_idcard) . " WHERE sid = '{$row['childId']}' ORDER BY id DESC");
                $num = count($card);
                if ($num > 1){
                    foreach($card as $k =>$r){
                        if(!empty($r['idcard'])){
                           $class[$key]['signId'] .= "#" . $r['idcard'];
                        }
                    }
                }else{
                    $class[$key]['signId'] = $card['0']['idcard'];
                }
                //  是否启用人脸识别。人脸识别的id卡号取关系是10（其他家长）的卡号
                if($isface['is_face'] == 1){
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
            } else {
                $sunday = date("Y-n-j",(time()-$nowweek*3600*24));
                $checkdateset      =  pdo_fetch("SELECT * FROM " . tablename($this->table_checkdateset) . " WHERE weid = '{$weid}' And schoolid = {$school['id']} and  id = '{$checkdatesetid}'");
                for($k = 0; $k <7; ++$k){
                    $todaytime = strtotime('+'.$k.' day', strtotime($sunday));
                    $nowdate = date('Y-n-j',$todaytime);
                    $nowyear = date("Y", $todaytime);
                    $checkdateset_holi =  pdo_fetch("SELECT * FROM " . tablename($this->table_checkdatedetail) . " WHERE weid = '{$weid}' And schoolid = {$school['id']} and  checkdatesetid = '{$checkdatesetid}' and year = '{$nowyear}' ");
                    $checktime         =  pdo_fetchall("SELECT * FROM " . tablename($this->table_checktimeset) . " WHERE weid = '{$weid}' And schoolid = {$school['id']} and  checkdatesetid = '{$checkdatesetid}' and date = '{$nowdate}' ORDER BY id ASC ");
                    if(!empty($checktime)){ // 如果checktimeset里的nowdate不为空，则表示周五、周六、周日单独设置了
                        if($checktime[0]['type'] == 6){ //type=1工作日，2周五，3周六，4周日，5特殊上，6特殊休
                            $todaytimeset1 = $todaytimeset2 = $todaytimeset3 = array(array('startTime'=>"00:00", 'endTime'=>"23:59"));
                        }elseif($checktime[0]['type'] == 5){
                            $todaytimeset1 = transTimeset4T1($checktime);
                            $todaytimeset2 = array(array('startTime'=>$checktime[count($checktime)-1]['end'], 'endTime'=>"23:59"));
                            $todaytimeset3 = transTimeset4T3($checktime);
                        }
                    }else{
                        if(($todaytime >= strtotime($checkdateset_holi['win_start']) && $todaytime <= strtotime($checkdateset_holi['win_end'])) || ($todaytime >= strtotime($checkdateset_holi['sum_start']) && $todaytime <= strtotime($checkdateset_holi['sum_end']))){ // 暑假和寒假放假
                            $todaytimeset1 = $todaytimeset2 = $todaytimeset3 = array(array('startTime'=>"00:00", 'endTime'=>"23:59"));
                        }else{
                            $timeset_work = pdo_fetchall("SELECT start,end FROM " . tablename($this->table_checktimeset) . " WHERE weid = '{$weid}' And schoolid = {$school['id']} and  checkdatesetid = '{$checkdatesetid}' and type=1 ORDER BY id ASC ");
                            if($k == 5){//星期五
                                if($checkdateset['friday'] == 1){
                                    $timeset_fri = pdo_fetchall("SELECT start,end FROM " . tablename($this->table_checktimeset) . " WHERE weid = '{$weid}' And schoolid = {$school['id']} and  checkdatesetid = '{$checkdatesetid}' and type=2 ORDER BY id ASC ");
                                    $todaytimeset1 = transTimeset4T1($timeset_fri);
                                    $todaytimeset2 = array(array('startTime'=>$timeset_fri[count($timeset_fri)-1]['end'], 'endTime'=>"23:59"));
                                    $todaytimeset3 =  transTimeset4T3($timeset_fri);
                                }else{
                                    $todaytimeset1 = transTimeset4T1($timeset_work);
                                    $todaytimeset2 = array(array('startTime'=>$timeset_work[count($timeset_work)-1]['end'], 'endTime'=>"23:59"));
                                    $todaytimeset3 =  transTimeset4T3($timeset_work);
                                }
                            }elseif($k == 6){//星期六
                                if($checkdateset['saturday'] == 1){
                                    $timeset_sat = pdo_fetchall("SELECT start,end FROM " . tablename($this->table_checktimeset) . " WHERE weid = '{$weid}' And schoolid = {$school['id']} and  checkdatesetid = '{$checkdatesetid}' and type=3 ORDER BY id ASC ");
                                    $todaytimeset1 = transTimeset4T1($timeset_sat);
                                    $todaytimeset2 = array(array('startTime'=>$timeset_sat[count($timeset_sat)-1]['end'], 'endTime'=>"23:59"));
                                    $todaytimeset3 =  transTimeset4T3($timeset_sat);
                                }else{
                                    $todaytimeset1 = $todaytimeset2 = $todaytimeset3 = array(array('startTime'=>"00:00", 'endTime'=>"23:59"));
                                }
                            }elseif($k == 0){//星期天
                                if($checkdateset['sunday'] == 1){
                                    $timeset_sun = pdo_fetchall("SELECT start,end FROM " . tablename($this->table_checktimeset) . " WHERE weid = '{$weid}' And schoolid = {$school['id']} and  checkdatesetid = '{$checkdatesetid}' and type=4 ORDER BY id ASC ");
                                       $todaytimeset1 = transTimeset4T1($timeset_sun);
                                    $todaytimeset2 = array(array('startTime'=>$timeset_sun[count($timeset_sun)-1]['end'], 'endTime'=>"23:59"));
                                    $todaytimeset3 =  transTimeset4T3($timeset_sun);
                                }else{
                                    $todaytimeset1 = $todaytimeset2 = $todaytimeset3 = array(array('startTime'=>"00:00", 'endTime'=>"23:59"));
                                }
                            }else{//工作日
                                $todaytimeset1 = transTimeset4T1($timeset_work);
                                $todaytimeset2 = array(array('startTime'=>"00:00", 'endTime'=>"00:00"));
                                $todaytimeset3 =  transTimeset4T3($timeset_work);
                            }
                        }
                    }
                    $week1[$k] = array('weekno'=>$k, 'groups'=>$todaytimeset1);
                    $week2[$k] =array('weekno'=>$k, 'groups'=>$todaytimeset2);
                    $week3[$k] =array('weekno'=>$k, 'groups'=>$todaytimeset3);
                }
                $timeset1[0] = array('id'=>0, 'weeks'=>$week1);
                $timeset1[1] = array('id'=>1, 'weeks'=>$week1);
                $timeset1[2] = array('id'=>2, 'weeks'=>$week2);
                $timeset1[3] = array('id'=>3, 'weeks'=>$week3);
            }

            $result['data']['timeset'] = $timeset1;
            $result['data']['leave'] = $leaves;
            $result['code'] = 1000;
            $result['msg'] = "success";
            $result['ServerTime'] = date('Y-m-d H:i:s',time());
            echo json_encode($result);
        }
    }else{
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
                $card = pdo_fetchall("SELECT idcard  FROM " . tablename($this->table_idcard) . " WHERE tid = '{$row['TID']}' ORDER BY id DESC");
                $num = count($card);
                if ($num > 1){
                    foreach($card as $k =>$r){
                        if(!empty($r['idcard'])){
                            $class[$key]['signId'] .= "#" . $r['idcard'];
                        }
                    }
                }else{
                    $class[$key]['signId'] = $card['0']['idcard'];
                }
                //  是否启用人脸识别
                if($isface['is_face'] == 1){
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
            $result['info'] = "本卡未绑定任何学生或老师";
        }
    }else{
        $fstype = true;
        $result['info'] = "不可重复相同刷卡数据";
    }
    if ($fstype ==true){
        $result['data'] = "";
        $result['code'] = 1000;
        $result['msg'] = "success";
        $result['ServerTime'] = date('Y-m-d H:i:s',time());
        echo json_encode($result);
        exit;
    }else{
        $result['data'] = "";
        $result['code'] = 300;
        $result['msg'] = "lose";
        $result['ServerTime'] = date('Y-m-d H:i:s',time());
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
                    $result['info'] = "本卡未绑定任何学生或老师";
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
    for($i=0, $len=count($checktime); $i <= $len; ++$i){
        if($i == 0){
            $time[$i] = array('startTime'=>"06:00", 'endTime'=>$checktime[0]['start']);
        }elseif($i == $len){
            $time[$i] = array('startTime'=>$checktime[$i-1]['end'], 'endTime'=>"23:59");
        }else{
            $time[$i] = array('startTime'=>$checktime[$i-1]['end'], 'endTime'=>$checktime[$i]['start']);
        }
    }
    return $time;
}

/** 根据正常的上课时间算出半住宿生（Type=2）的允许外出时间段
 *
 * @param $checktime 正常的上课时间
 * @return array 允许外出的时间段
 */
function transTimeset4T3($checktime){
    for($i=0, $len=count($checktime), $j=0; $i <= $len; ++$i) {
        if ($i == 0) {
            $time[$j++] = array('startTime' => "06:00", 'endTime' => $checktime[0]['start']);
        } elseif ($i == $len) {
            $time[$j++] = array('startTime' => $checktime[$i - 1]['end'], 'endTime' => "23:59");
        }
    }
    return $time;
}

?>