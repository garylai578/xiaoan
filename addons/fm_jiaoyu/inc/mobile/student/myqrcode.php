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

$it = pdo_fetch("SELECT * FROM " . tablename($this->table_user) . " where weid = :weid AND id=:id ", array(':weid' => $weid, ':id' => $_SESSION['user']));
$studentid = $it['sid'];

$qrcode = pdo_fetch("SELECT * FROM " . tablename($this->table_qrinfo) . " where weid = :weid AND schoolid=:schoolid AND qrcid=:id AND type=:qtype ORDER BY expire desc", array(':weid' => $weid, ':schoolid'=>$schoolid, ':id' => $studentid, ':qtype' => 44));
if(empty($qrcode) || $qrcode['expire'] < (time()+3600*2)){ // 如果还没有二维码或者二维码有效期小于2小时的，则生成一个二维码
    define("__ROOT__",dirname(__FILE__));
    include_once __ROOT__.'/../../web/phpqrcode.php';
    $overtime = time() + 3600*48; //默认二维码48小时内有效
    $ticket = sprintf("%018s",  $studentid.$overtime); //  ticket字段是学生id+有效期，不足18位的前面补0，是二维码的文本内容
    $errorCorrectionLevel = 'L';//容错级别
    $matrixPointSize = 6;//生成图片大小
    $qrcodeUrl = ATTACHMENT_ROOT . 'images/fm_jiaoyu/qrcode/'.$ticket.".png";
    QRcode::png($ticket, $qrcodeUrl, $errorCorrectionLevel, $matrixPointSize, 2);
    $qrcodeUrl = str_ireplace(ATTACHMENT_ROOT, '', $qrcodeUrl);
    $cardid = $ticket;

    //  插入数据库二维码信息表
    $data = array('weid'=>$weid, 'schoolid'=>$schoolid, 'qrcid'=>$studentid, 'name'=>'考勤临时二维码', 'type'=>44,
        'ticket'=>$ticket, 'show_url'=>$qrcodeUrl, 'expire'=>$overtime, 'subnum'=>0, 'createtime'=>time(), 'status'=>1);
    pdo_insert($this->table_qrinfo, $data);

    //  插入idcard表
    $stu =  pdo_fetch("SELECT bj_id FROM " . tablename($this->table_students) . " where id = :id", array(':id' => $studentid));
    $idcard = array('weid'=>$weid, 'schoolid'=>$schoolid, 'sid'=>$studentid, 'tid'=>0, 'pname'=>'临时二维码', 'bj_id'=>$stu['bj_id'], 'idcard'=>$ticket, 'pard'=>10, 'createtime'=>time(), 'severend'=>$overtime, 'is_on'=>1, 'usertype'=>0);
    pdo_insert($this->table_idcard, $idcard);

    $overtime = date("Y-m-d H:m:s", $overtime);
}else{  // 如果已经有二维码，并且没有过期，则展示出来
    $qrcodeUrl = $qrcode['show_url'];
    $overtime = date("Y-m-d H:m:s", $qrcode['expire']);
    $cardid = $qrcode['ticket'];
}

// 删除已经过期了二维码及其cardid
$expireQrcode = pdo_fetchall("SELECT ticket FROM " . tablename($this->table_qrinfo) . " where expire < ". time()." and type = 44");
foreach ($expireQrcode as $item=>$value){
    $delCard = array('idcard'=>$value['ticket']);
    pdo_delete($this->table_idcard, $delCard);
}

$del = array('expire <'=>time(), 'type'=>44);
pdo_delete($this->table_qrinfo, $del);

include $this->template('students/myqrcode');
?>