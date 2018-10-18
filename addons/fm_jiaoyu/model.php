<?php
/**
 * 微教育模块
 *QQ：332035136
 * @author 高贵血迹
 */
function p($data)
{
	echo '<pre>';
	print_r($data);
}
function mload()
{
	static $mloader;
	if (empty($mloader)) {
		$mloader = new Mloader();
	}
	return $mloader;
}

class Mloader
{
	private $cache = array();
	function func($name)
	{
		if (isset($this->cache['func'][$name])) {
			return true;
		}
		$file = IA_ROOT . '/addons/fm_jiaoyu/function/' . $name . '.func.php';
		if (file_exists($file)) {
			include $file;
			$this->cache['func'][$name] = true;
			return true;
		} else {
			trigger_error('Invalid Helper Function /addons/fm_jiaoyu/function/' . $name . '.func.php', E_USER_ERROR);
			return false;
		}
	}
	function model($name)
	{
		if (isset($this->cache['model'][$name])) {
			return true;
		}
		$file = IA_ROOT . '/addons/fm_jiaoyu/model/' . $name . '.mod.php';
		if (file_exists($file)) {
			include $file;
			$this->cache['model'][$name] = true;
			return true;
		} else {
			trigger_error('Invalid Model /addons/fm_jiaoyu/model/' . $name . '.mod.php', E_USER_ERROR);
			return false;
		}
	}
	function classs($name)
	{
		if (isset($this->cache['class'][$name])) {
			return true;
		}
		$file = IA_ROOT . '/addons/fm_jiaoyu/class/' . $name . '.class.php';
		if (file_exists($file)) {
			include $file;
			$this->cache['class'][$name] = true;
			return true;
		} else {
			trigger_error('Invalid Class /addons/fm_jiaoyu/class/' . $name . '.class.php', E_USER_ERROR);
			return false;
		}
	}
}

function sub_day($staday)
{
	$value = TIMESTAMP - $staday;
	if ($value < 0) {
		return '';
	} elseif ($value >= 0 && $value < 59) {
		return $value + 1 . "秒";
	} elseif ($value >= 60 && $value < 3600) {
		$min = intval($value / 60);
		return $min . " 分钟";
	} elseif ($value >= 3600 && $value < 86400) {
		$h = intval($value / 3600);
		return $h . " 小时";
	} elseif ($value >= 86400 && $value < 86400 * 30) {
		$d = intval($value / 86400);
		return intval($d) . " 天";
	} elseif ($value >= 86400 * 30 && $value < 86400 * 30 * 12) {
		$mon = intval($value / (86400 * 30));
		return $mon . " 月";
	} else {
		$y = intval($value / (86400 * 30 * 12));
		return $y . " 年";
	}
}

function cut($filename){
	$image = $filename; // 原图
	$imgstream = file_get_contents($image);
	$im = imagecreatefromstring($imgstream);
	$x = imagesx($im);//获取图片的宽
	$y = imagesy($im);//获取图片的高
	 
	// 缩略后的大小
	$xx = 300;
	$yy = 300;
	 
	if($x>$y){
	//图片宽大于高
		$sx = abs(($y-$x)/2);
		$sy = 0;
		$thumbw = $y;
		$thumbh = $y;
	} else {
	//图片高大于等于宽
		$sy = abs(($x-$y)/2.5);
		$sx = 0;
		$thumbw = $x;
		$thumbh = $x;
	  }
	if(function_exists("imagecreatetruecolor")) {
	  $dim = imagecreatetruecolor($yy, $xx); // 创建目标图gd2
	} else {
	  $dim = imagecreate($yy, $xx); // 创建目标图gd1
	}
	imageCopyreSampled ($dim,$im,0,0,$sx,$sy,$yy,$xx,$thumbw,$thumbh);
	imagejpeg ($dim, $filename);
}

function readschootyep(){
	$tyep = checkverstype();
	if($tyep == 1){
		return true;
	}else{
		return false;
	}
}

function register_jssdks($debug = false){
	
	global $_W;
	
	if (defined('HEADER')) {
		echo '';
		return;
	}
	
	$sysinfo = array(
		'uniacid' 	=> $_W['uniacid'],
		'acid' 		=> $_W['acid'],
		'siteroot' 	=> $_W['siteroot'],
		'siteurl' 	=> $_W['siteurl'],
		'attachurl' => $_W['attachurl'],
		'cookie' 	=> array('pre'=>$_W['config']['cookie']['pre'])
	);
	if (!empty($_W['acid'])) {
		$sysinfo['acid'] = $_W['acid'];
	}
	if (!empty($_W['openid'])) {
		$sysinfo['openid'] = $_W['openid'];
	}
	if (defined('MODULE_URL')) {
		$sysinfo['MODULE_URL'] = MODULE_URL;
	}
	$sysinfo = json_encode($sysinfo);
	$jssdkconfig = json_encode($_W['account']['jssdkconfig']);
	$debug = $debug ? 'true' : 'false';
	
	$script = <<<EOF
<script type="text/javascript" src="https://res.wx.qq.com/open/js/jweixin-1.3.0.js"></script>
<script type="text/javascript">
	window.sysinfo = window.sysinfo || $sysinfo || {};
	
	// jssdk config 对象
	jssdkconfig = $jssdkconfig || {};
	
	// 是否启用调试
	jssdkconfig.debug = $debug;
	
	jssdkconfig.jsApiList = [
		'checkJsApi',
		'onMenuShareTimeline',
		'onMenuShareAppMessage',
		'onMenuShareQQ',
		'onMenuShareWeibo',
		'hideMenuItems',
		'showMenuItems',
		'hideAllNonBaseMenuItem',
		'showAllNonBaseMenuItem',
		'translateVoice',
		'startRecord',
		'stopRecord',
		'onRecordEnd',
		'onVoicePlayEnd',
		'onVoiceRecordEnd',
		'playVoice',
		'pauseVoice',
		'stopVoice',
		'uploadVoice',
		'downloadVoice',
		'chooseImage',
		'getLocalImgData',
		'previewImage',
		'uploadImage',
		'downloadImage',
		'getNetworkType',
		'openLocation',
		'getLocation',
		'hideOptionMenu',
		'showOptionMenu',
		'closeWindow',
		'scanQRCode',
		'chooseWXPay',
		'openProductSpecificView',
		'addCard',
		'chooseCard',
		'openCard'
	];
	
	wx.config(jssdkconfig);
	
</script>
EOF;
	echo $script;
}

function tpl_form_field_fans($name, $value = array('openid' => '', 'nickname' => '', 'avatar' => ''))
{
	global $_W;
	if (empty($default)) {
		$default = './resource/images/nopic.jpg';
	}
	$s = '';
	if (!defined('TPL_INIT_TINY_FANS')) {
		$s = '
				<script type="text/javascript">
					function showFansDialog(elm) {
						var btn = $(elm);
						var openid = btn.parent().prev();
						var avatar = btn.parent().prev().prev();
						var nickname = btn.parent().prev().prev().prev();
						var img = btn.parent().parent().next().find("img");
						tiny.selectfan(function(fans){
							if(fans.tag.avatar){
								if(img.length > 0){
									img.get(0).src = fans.tag.avatar;
								}
								openid.val(fans.openid);
								avatar.val(fans.tag.avatar);
								nickname.val(fans.nickname);
							}
						});
					}
				</script>';
		define('TPL_INIT_TINY_FANS', true);
	}
	$s .= '
			<div class="input-group">
				<input type="text" name="' . $name . '[nickname]" value="' . $value['nickname'] . '" class="form-control" readonly>
				<input type="hidden" name="' . $name . '[avatar]" value="' . $value['avatar'] . '">
				<input type="hidden" name="' . $name . '[openid]" value="' . $value['openid'] . '">
				<span class="input-group-btn">
					<button class="btn btn-default" type="button" onclick="showFansDialog(this);">选择粉丝</button>
				</span>
			</div>
			<div class="input-group" style="margin-top:.5em;">
				<img src="' . $value['avatar'] . '" onerror="this.src=\'' . $default . '\'; this.title=\'头像未找到.\'" class="img-responsive img-thumbnail" width="150" />
			</div>';
	return $s;
}
function SchoolTypeFromLocal($schoolid,$weid){
	if(unitchecksctype() == true){
		$data = pdo_fetch("SELECT issale FROM " . tablename('wx_school_index') . " where weid='{$weid}'  and id = '{$schoolid}'");
		if($data['issale'] == 0){
			return true;
		}else{
			return false;
		}
	}else{
		return false;
	}
}
function ifile_put_contents($filename, $data){
	global $_W;
	$filename = MODULE_ROOT . '/' . $filename;
	mkdirs(dirname($filename));
	file_put_contents($filename, $data);
	@chmod($filename, $_W['config']['setting']['filemode']);
	return is_file($filename);
}

function distanceBetween($fP1Lat, $fP1Lon, $fP2Lat, $fP2Lon)
{
	$fEARTH_RADIUS = 6378137;
	$fRadLon1 = deg2rad($fP1Lon);
	$fRadLon2 = deg2rad($fP2Lon);
	$fRadLat1 = deg2rad($fP1Lat);
	$fRadLat2 = deg2rad($fP2Lat);
	$fD1 = abs($fRadLat1 - $fRadLat2);
	$fD2 = abs($fRadLon1 - $fRadLon2);
	$fP = pow(sin($fD1 / 2), 2) + cos($fRadLat1) * cos($fRadLat2) * pow(sin($fD2 / 2), 2);
	return intval($fEARTH_RADIUS * 2 * asin(sqrt($fP)) + 0.5);
}

function get_myqh($bj_id,$schoolid){
	global $_W;
	$allqh = pdo_fetchall("SELECT sid,sname,qh_bjlist,qhtype FROM " . tablename('wx_school_classify') . " where schoolid = :schoolid And type =:type ORDER BY sid DESC", array(':schoolid' => $schoolid,':type' => 'score'));
	$allmyqh = array();
	$i  = 0;
	foreach($allqh as $key => $row){
		if($row['qhtype'] == 1){
			$allmyqh[$i]['sid'] = $row['sid'];
			$allmyqh[$i]['sname'] = $row['sname'];
			$allmyqh[$i]['qhtype'] = $row['qhtype'];
			$i ++;
		}else{	
			$uniarr = explode(',', $row['qh_bjlist']);
			$is = unarr($uniarr,$bj_id);
			if ($is) {
				$allmyqh[$i]['sid'] = $row['sid'];
				$allmyqh[$i]['sname'] = $row['sname'];
				$allmyqh[$i]['qhtype'] = $row['qhtype'];
				$i ++;
			}		
		}
	}
	return $allmyqh;
}

function unitchecksctype(){
	$tyep = checkverstype();
	if($tyep == 0){
		return true;
	}else{
		return false;
	}
}

function unarr($uniarr, $id) {
	foreach ($uniarr as $key => $value) {
		if ($id == $value) {
			return true;
		}
	}
	return false;
}
// 只需调用函数 并传参2即可
// echo getRandomString(2);
// 如果仅仅是生成小写字母你可以使用类似方法

// echo chr(mt_rand(65, 90);
// 大写字母

// echo chr(mt_rand(97, 122));
function getRandomString($len, $chars=null){
    if (is_null($chars)){
        $chars = "‘abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    }  
    mt_srand(10000000*(double)microtime());
    for ($i = 0, $str = '', $lc = strlen($chars)-1; $i < $len; $i++){
        $str .= $chars[mt_rand(0, $lc)];  
    }
    return $str;
}

function get_mylist($schoolid,$id,$type,$is_over=2){
	
	if($is_over == 2){
		$bj = pdo_fetchall("SELECT sid,sname FROM " . tablename('wx_school_classify') . " where schoolid = :schoolid And type = :type and is_over!=:is_over ORDER BY CONVERT(sname USING gbk) ASC", array(':type' => 'theclass', ':schoolid' => $schoolid,':is_over'=>"2"));
		$nj = pdo_fetchall("SELECT sid,sname FROM " . tablename('wx_school_classify') . " where schoolid = :schoolid And type = :type and is_over!=:is_over ORDER BY CONVERT(sname USING gbk) ASC", array(':type' => 'semester', ':schoolid' => $schoolid,':is_over'=>"2"));
	}elseif($is_over != 2){
		$bj = pdo_fetchall("SELECT sid,sname FROM " . tablename('wx_school_classify') . " where schoolid = :schoolid And type = :type  ORDER BY CONVERT(sname USING gbk) ASC", array(':type' => 'theclass', ':schoolid' => $schoolid));
		$nj = pdo_fetchall("SELECT sid,sname FROM " . tablename('wx_school_classify') . " where schoolid = :schoolid And type = :type ORDER BY CONVERT(sname USING gbk) ASC", array(':type' => 'semester', ':schoolid' => $schoolid));
	}
		
		$bj_str_temp = '0,';
		foreach($bj as $key_b=>$value_b){
			$bj_str_temp .=$value_b['sid'].",";
		}
		$bj_str = trim($bj_str_temp,",");
		$nj_str_temp = '0,';
		foreach($nj as $key_n=>$value_n){
			$nj_str_temp .=$value_n['sid'].",";
		}
		$nj_str = trim($nj_str_temp,",");
	if($type == 'teacher'){
		$bjlist = pdo_fetchall("SELECT id,bj_id,km_id FROM ".tablename('wx_school_user_class')." WHERE tid = :tid And schoolid = :schoolid and FIND_IN_SET(bj_id,:bj_str) ", array(':tid' => $id,':schoolid' => $schoolid,':bj_str'=>$bj_str));
	}
	if($type == 'student'){
		$bjlist = pdo_fetchall("SELECT id,bj_id,km_id FROM ".tablename('wx_school_user_class')." WHERE sid = :sid And schoolid = :schoolid  ", array(':sid' => $id,':schoolid' => $schoolid));
	}
	foreach($bjlist as $key =>$row){
		if(!empty($row['bj_id'])){
			$bjinfo = pdo_fetch("SELECT sname,parentid FROM ".tablename('wx_school_classify')." WHERE sid = :sid ", array(':sid' => $row['bj_id']));
			$xqinfo = pdo_fetch("SELECT sname FROM ".tablename('wx_school_classify')." WHERE sid = :sid ", array(':sid' => $bjinfo['parentid']));
			$bjlist[$key]['xq_id'] = $bjinfo['parentid'];
			$bjlist[$key]['xqname'] = $xqinfo['sname'];
			$bjlist[$key]['bjname'] = $bjinfo['sname'];
		}
		if(!empty($row['km_id'])){	
			$kminfo = pdo_fetch("SELECT sname FROM ".tablename('wx_school_classify')." WHERE sid = :sid ", array(':sid' => $row['km_id']));
			$bjlist[$key]['kmname'] = $kminfo['sname'];
		}
	}	
	return $bjlist;
}

function get_my_score($sid,$qh_id,$schoolid){ //查询本期号总分
	$list = pdo_fetchall("SELECT my_score FROM " . tablename('wx_school_score') . " where  schoolid = :schoolid And qh_id = :qh_id And sid = :sid ", array(':schoolid' => $schoolid,':qh_id' => $qh_id,':sid' => $sid));
	$zongfen = 0;
	if(!empty($list)){
		foreach($list as $key =>$row){
			$zongfen = $zongfen + floatval($row['my_score']);
		}
	}
	return $zongfen;
}

function get_myschool($weid,$openid){ //查询老师所有授课学校
	$list = pdo_fetchall("SELECT schoolid FROM " . tablename('wx_school_user') . " where  weid = :weid And openid = :openid And sid = :sid ", array(':weid' => $weid,':openid' => $openid,':sid' => 0));	
	foreach($list as $key =>$row){
		if(!empty($row['schoolid'])){
			$school = pdo_fetch("SELECT title,logo FROM ".tablename('wx_school_index')." WHERE id = :id ", array(':id' => $row['schoolid']));
			$list[$key]['schoolname'] = $school['title'];
			$list[$key]['schoolicon'] = $school['logo'];
		}		
	}
	return $list;
}
function check_unpay($sid){ //查询未付订单数目
	$unpay = pdo_fetchall("SELECT id,costid FROM " . tablename('wx_school_order') . " where :status = status And :sid = sid ORDER BY id DESC", array(
		 ':status' => 1,
		 ':sid' => $sid
		 ));
	$rest = 0;
	foreach($unpay as $k => $r){
		if(!empty($r['costid'])){
			$obset = pdo_fetch("SELECT is_on FROM ".tablename('wx_school_cost')." WHERE id = '{$r['costid']}'");
			if($obset['is_on'] ==1){
				$rest ++;
			}
		}else{
			$rest  ++ ;
		}
	}
	return $rest;
}
function get_myallclass($weid,$openid){ //查询绑定学生所有班级信息（包含其他学校）
	$user = pdo_fetchall("SELECT id,sid FROM " . tablename('wx_school_user') . " where :weid = weid And :openid = openid And :tid = tid", array(
			':weid' => $weid,
			':openid' => $openid,
			':tid' => 0
	));
	if($user){
		foreach($user as $key => $row){
			$student = pdo_fetch("SELECT id,s_name,schoolid,bj_id FROM " . tablename('wx_school_students') . " where id=:id ", array(':id' => $row['sid']));
			$bajinam = pdo_fetch("SELECT sname FROM " . tablename('wx_school_classify') . " where sid = :sid ", array(':sid' => $student['bj_id']));
			$user[$key]['s_name'] = $student['s_name'];
			$user[$key]['bjname'] = $bajinam['sname'];
			$user[$key]['sid'] = $student['id'];  
			$user[$key]['schoolid'] = $student['schoolid'];
			
		}
		return $user;
	}else{
		return false;
	}
}

function check_bj($tid,$bj_id){ //检查当前班级是否属于本年级管辖且是否为年级主任
	$class = pdo_fetch("SELECT parentid FROM " . tablename('wx_school_classify') . " where sid = :sid ", array(':sid' => $bj_id));
	$status = false;
	if(!empty($class['parentid'])){
		$nianji = pdo_fetch("SELECT tid FROM " . tablename('wx_school_classify') . " where sid = :sid ", array(':sid' => $class['parentid']));
		if($tid == $nianji['tid']){
			$status = true;
		}
	}
	return $status;
}

function get_weidset($weid,$name){
	$item = pdo_fetch("SELECT $name FROM ".tablename('wx_school_set')." WHERE :weid = weid ", array(':weid' => $weid));
	$set = unserialize($item[$name]);	
	return $set;
}

function get_school_sms_rest($schoolid){
	$item = pdo_fetch("SELECT sms_rest_times FROM ".tablename('wx_school_index')." WHERE :id = id ", array(':id' => $schoolid));	
	if ($item['sms_rest_times'] == 0) {
		return false;
	}else{
		return true;
	}
}

function get_school_sms_set($schoolid){
	$item = pdo_fetch("SELECT sms_set FROM ".tablename('wx_school_index')." WHERE :id = id ", array(':id' => $schoolid));
	$set = unserialize($item['sms_set']);	
	return $set;
}

function isallow_sendsms($schoolid,$type){//综合判断是否发送短信
	$item = pdo_fetch("SELECT weid,sms_set,sms_rest_times FROM ".tablename('wx_school_index')." WHERE :id = id ", array(':id' => $schoolid));
	$school_sms_set = unserialize($item['sms_set']);
	$smsset = get_weidset($item['weid'],$type);
	if(!empty($smsset['sms_SignName']) && !empty($smsset['sms_Code']) && $school_sms_set[$type] == 1 && $item['sms_rest_times'] > 0){
		return true;
	}else{
		return false;
	}
}

function check_verifycode($mobile, $code, $weid){
	$bdset = get_weidset($weid,'bd_set');
	$thiscode = pdo_fetch("SELECT createtime FROM ".tablename('uni_verifycode')." WHERE uniacid = :uniacid And receiver = :receiver And verifycode = :verifycode ", array(':uniacid' => $weid, ':receiver' => $mobile, ':verifycode' => $code));
	$resttime = empty($bdset['code_time']) ? 1800 : intval($bdset['code_time']);
	$duibi = TIMESTAMP - $thiscode['createtime'];
	if($duibi < $resttime) {
		return true;
	}else{
		return false;
	}
}

function need_guid($userid,$schoolid,$type){ //检查是否设置新手引导
	global $_W;
	$guids = pdo_fetchall("SELECT id,arr,begintime,endtime FROM " . tablename('wx_school_banners') . " WHERE enabled = 1 And weid = '{$_W['uniacid']}' And place = $type ORDER BY id ASC");
	$user = pdo_fetch("SELECT is_frist FROM ".tablename('wx_school_user')." WHERE :id = id ", array(':id' => $userid));
	foreach($guids as $key => $row){
		$uniarr = explode(',',$row['arr']);
		$is = unarr($uniarr,$schoolid);
		if ($is && TIMESTAMP >= $row['begintime'] && TIMESTAMP < $row['endtime']) {
			$guid = $row['id'];
		}		
	}
	if(!empty($guid) && $user['is_frist'] == 1){
		return $guid;
	}
}

function getvisitorsip(){
	$visitorsip = pdo_fetch("SELECT * FROM ".tablename('wx_school_classify')." WHERE :type = type ", array(':type' => 'thevideos'));
	return $visitorsip['video1'];
}

function getoauthurl(){
	$oauthurl = $_SERVER ['HTTP_HOST'];
	return $oauthurl;
}

function getpard($pard){
	if($pard == 0){
		$jsr  = "";
	}
	if($pard == 1){
		$jsr  = "";
	}
	if($pard == 2){
		$jsr  = "妈妈";
	}
	if($pard == 3){
		$jsr  = "爸爸";
	}
	if($pard == 4){
		$jsr  = "爷爷";
	}
	if($pard == 5){
		$jsr  = "奶奶";
	}
	if($pard == 6){
		$jsr  = "外公";
	}
	if($pard == 7){
		$jsr  = "外婆";
	}
	if($pard == 8){
		$jsr  = "叔叔";
	}
	if($pard == 9){
		$jsr  = "阿姨";
	}
	if($pard == 10){
		$jsr  = "其他家长";
	}
	if($pard == 11){
		$jsr  = "-老师代签";
	}
    return $jsr;
}

function getpardforkqj($pard){
	if($pard == 1){
		$jsr  = "学生";
	}
	if($pard == 2){
		$jsr  = "妈妈";
	}
	if($pard == 3){
		$jsr  = "爸爸";
	}
	if($pard == 4){
		$jsr  = "爷爷";
	}
	if($pard == 5){
		$jsr  = "奶奶";
	}
	if($pard == 6){
		$jsr  = "外公";
	}
	if($pard == 7){
		$jsr  = "外婆";
	}
	if($pard == 8){
		$jsr  = "叔叔";
	}
	if($pard == 9){
		$jsr  = "阿姨";
	}
	if($pard == 10){
		$jsr  = "家长";
	}
    return $jsr;
}

function get_teacher($pard){
	if($pard == 1){
		$jsr  = "老师";
	}
	if($pard == 2){
		$jsr  = "校长";
	}
	if($pard == 3){
		$jsr  = "主任";
	}
    return $jsr;
}

function get_guanxi($pard){ //获取用户绑定时候选定关系称谓
	if($pard == 2){
		$jsr  = "妈妈";
	}
	if($pard == 3){
		$jsr  = "爸爸";
	}
	if($pard == 4){
		$jsr  = "";
	}
	if($pard == 5){
		$jsr  = "家长";
	}	
    return $jsr;
}

function CreateRequest($HttpUrl,$HttpMethod,$COMMON_PARAMS,$secretKey, $PRIVATE_PARAMS, $isHttps)
{
    $FullHttpUrl = $HttpUrl."/v2/index.php";

    /***************对请求参数 按参数名 做字典序升序排列，注意此排序区分大小写*************/
    $ReqParaArray = array_merge($COMMON_PARAMS, $PRIVATE_PARAMS);
    ksort($ReqParaArray);

    /**********************************生成签名原文**********************************
     * 将 请求方法, URI地址,及排序好的请求参数  按照下面格式  拼接在一起, 生成签名原文，此请求中的原文为 
     * GETcvm.api.qcloud.com/v2/index.php?Action=DescribeInstances&Nonce=345122&Region=gz
     * &SecretId=AKIDz8krbsJ5yKBZQ1pn74WFkmLPx3gnPhESA&Timestamp=1408704141
     * &instanceIds.0=qcvm12345&instanceIds.1=qcvm56789
     * ****************************************************************************/
    $SigTxt = $HttpMethod.$FullHttpUrl."?";

    $isFirst = true;
    foreach ($ReqParaArray as $key => $value)
    {
        if (!$isFirst) 
        { 
            $SigTxt = $SigTxt."&";
        }
        $isFirst= false;

        /*拼接签名原文时，如果参数名称中携带_，需要替换成.*/
        if(strpos($key, '_'))
        {
            $key = str_replace('_', '.', $key);
        }

        $SigTxt=$SigTxt.$key."=".$value;
    }

    /*********************根据签名原文字符串 $SigTxt，生成签名 Signature******************/
    $Signature = base64_encode(hash_hmac('sha1', $SigTxt, $secretKey, true));


    /***************拼接请求串,对于请求参数及签名，需要进行urlencode编码********************/
    $Req = "Signature=".urlencode($Signature);
    foreach ($ReqParaArray as $key => $value)
    {
        $Req=$Req."&".$key."=".urlencode($value);
    }

    /*********************************发送请求********************************/
    if($HttpMethod === 'GET')    {
        if($isHttps === true) {
            $Req="https://".$FullHttpUrl."?".$Req;
        }else{
            $Req="http://".$FullHttpUrl."?".$Req;
        }

        $Rsp = file_get_contents($Req);

    }else{
        if($isHttps === true)
        {
            $Rsp= SendPost("https://".$FullHttpUrl,$Req,$isHttps);
        }
        else
        {
            $Rsp= SendPost("http://".$FullHttpUrl,$Req,$isHttps);
        }
    }
    return(json_decode($Rsp,true));
}

function SendPost($FullHttpUrl,$Req,$isHttps){
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $Req);

	curl_setopt($ch, CURLOPT_URL, $FullHttpUrl);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	if ($isHttps === true) {
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,  false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,  false);
	}
	$result = curl_exec($ch);
	return $result;
}

function upload_file_to_cdn($data,$host){
    $ch = curl_init();
	$url = 'http%3a%2f%2fwww.daren007.com%2fapi%2famr.php';	
	if(version_compare(PHP_VERSION,'5.5.0','>=')){
		$postdata = array (
			"type" => 'amr',
			"host" => $host,
			"oauthurl" => getoauthurl(),
			"upload" => new CURLFile(realpath($data))
		);
		curl_setopt($ch, CURLOPT_URL,urldecode($url));
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$response = curl_exec($ch);
	}else{
		$postdata = array (
			"type" => 'amr',
			"host" => $host,
			"oauthurl" => getoauthurl(),
			"upload" => "@".$data
		);
		curl_setopt($ch, CURLOPT_URL, urldecode($url));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_TIMEOUT, 100);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
		$response = curl_exec($ch);
	}
	return $response;
}

function delvioce($data,$host){
    $ch = curl_init();
	$url = 'http%3a%2f%2fwww.daren007.com%2fapi%2famr.php';	
	$postdata = array (
		"type" => 'delamr',
		"host" => $host,
		"oauthurl" => getoauthurl(),
		"mp3name" => $data
	);
	if(version_compare(PHP_VERSION,'5.5.0','>=')){
		curl_setopt($ch, CURLOPT_URL, urldecode($url));
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$response = curl_exec($ch);
	}else{
		curl_setopt($ch, CURLOPT_URL, urldecode($url));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_TIMEOUT, 100);
		$response = curl_exec($ch);
	}
	return $response;
}

function delcheckpic($name){
	global $_W;
    $ch = curl_init();
    $post_data = array (
		"type" => 'delcheckpic',
		"oauthurl" => getoauthurl(),
		"checkpic" => $name
    );	
	$url = 'http%3a%2f%2fwww.daren007.com%2fapi%2famr.php';	
	if(version_compare(PHP_VERSION,'5.5.0','>=')){
		curl_setopt($ch, CURLOPT_URL, urldecode($url));
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
		$response = curl_exec($ch);
	}else{
		curl_setopt($ch, CURLOPT_URL, urldecode($url));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_TIMEOUT, 100);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
		$response = curl_exec($ch);
	}
	return true;
}

function opreatmac($macid,$mactype,$posturl,$type,$schoolname){
    $ch = curl_init();
    $post_data = array (
		"type" => $type,
		"oauthurl" => getoauthurl(),
		"mactype" => $mactype,
		"macid" => $macid,
		"schoolname" => $schoolname,
		"posturl" => $posturl
    );
	if(getoauthurl()){$url = 'http%3a%2f%2fwww.daren007.com%2fapi%2fmac.php';}
	if(version_compare(PHP_VERSION,'5.5.0','>=')){
		curl_setopt($ch, CURLOPT_URL,urldecode($url));
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
		$response = curl_exec($ch);
	}else{
		curl_setopt($ch, CURLOPT_URL, urldecode($url));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_TIMEOUT, 100);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
		$response = curl_exec($ch);
	}	
	return $response;
}

function getImg($picurl){
	$ch=curl_init();
	$timeout=5;
	if(version_compare(PHP_VERSION,'5.5.0','>=')){
		curl_setopt($ch, CURLOPT_URL,$picurl);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout);
		$img=curl_exec($ch);
		curl_close($ch);		
	}else{
		curl_setopt($ch, CURLOPT_URL, $picurl);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout);
		$img=curl_exec($ch);
		curl_close($ch);		
	}	
	delcheckpic($picurl);
	return $img;
}

function DeleteStudent($sid){
	pdo_delete('wx_school_score', array('sid' => $sid));
	pdo_delete('wx_school_answers', array('sid' => $sid));
	pdo_delete('wx_school_leave', array('sid' => $sid));
	pdo_delete('wx_school_media', array('sid' => $sid));
	pdo_delete('wx_school_order', array('sid' => $sid));
	pdo_delete('wx_school_signup', array('sid' => $sid));
	pdo_delete('wx_school_record', array('sid' => $sid));
	pdo_delete('wx_school_checklog', array('sid' => $sid));
	pdo_delete('wx_school_idcard', array('sid' => $sid));
	pdo_delete('wx_school_scforxs', array('sid' => $sid));
	pdo_delete('wx_school_user', array('sid' => $sid));	
}


function DeleteTeacher($tid){
	pdo_delete('wx_school_user_class', array('tid' => $tid));
	pdo_delete('wx_school_tcourse', array('tid' => $tid));
	pdo_delete('wx_school_kcbiao', array('tid' => $tid));
	pdo_delete('wx_school_user', array('tid' => $tid));
	pdo_delete('wx_school_leave', array('tid' => $tid));
	pdo_delete('wx_school_notice', array('tid' => $tid));
	pdo_delete('wx_school_record', array('tid' => $tid));
	pdo_delete('wx_school_checklog', array('tid' => $tid));
	pdo_delete('wx_school_idcard', array('tid' => $tid));
	pdo_delete('wx_school_zjh', array('tid' => $tid));
	pdo_delete('wx_school_scforxs', array('tid' => $tid));
	pdo_delete('wx_school_shouce', array('tid' => $tid));
	pdo_delete('wx_school_shoucepyk', array('tid' => $tid));
}



function getimg_form_oss($picurl){
	$ch=curl_init();
	$timeout=5;
	if(version_compare(PHP_VERSION,'5.5.0','>=')){
		curl_setopt($ch, CURLOPT_URL,$picurl);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout);
		$img=curl_exec($ch);
		curl_close($ch);		
	}else{
		curl_setopt($ch, CURLOPT_URL, $picurl);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout);
		$img=curl_exec($ch);
		curl_close($ch);		
	}	
	return $img;
}

function isChineseName($name){
	if (preg_match('/^([\xe4-\xe9][\x80-\xbf]{2}){2,4}$/', $name)) {
		return true;
	} else {
		return false;
	}
}

function ischeckName($name){
	if (preg_match('/测试/i', $name) || preg_match('/test/i', $name)) {
		return false;
	} else {
		return true;
	}
}

function GetTeacherTitle($status,$fz_id){
	if(empty($fz_id))
	{
		switch ( $status )
		{
			case 1 :
				$title = "老师";
				break;
			case 2 :
				$title = "校长";
				break;
			case 3 :
				$title = "年级管理";
				break;		
			default:
				$title = "老师";
				break;
		}

	}else if(!empty($fz_id))
	{
		$fz = pdo_fetch("SELECT * FROM ".tablename('wx_school_classify')." WHERE :type = type And sid = :sid ", array(':type' => 'jsfz',':sid' => $fz_id));
		if(!empty($fz))
		{
			$title = $fz['pname'];
		}else{
			$title = '老师';
		}
		
	}
	return $title;
	
}

function PointAct ($weid,$schoolid,$userid,$actop)
{
	$teacher = pdo_fetch("SELECT * FROM ".tablename('wx_school_user')." WHERE id ='{$userid}'");
	$tid = $teacher['tid'];
	$timetoday = strtotime(date("Y-m-d",time()));
	$tomorrow = $timetoday + 3600*24;
	
	$act = pdo_fetch("SELECT * FROM ".tablename('wx_school_points')." WHERE  weid ='{$weid}' And schoolid ='{$schoolid}' And op = '{$actop}' And type='1' ");
	$check = pdo_fetchcolumn("SELECT COUNT(1) FROM ".tablename('wx_school_pointsrecord')." WHERE tid = '{$tid}' And weid ='{$weid}' And schoolid ='{$schoolid}' And type='1' And pid = '{$act['id']}' And createtime <= '{$tomorrow}' And createtime >= '{$timetoday}'  ");
	if($act['is_on'] == 1 )
	{
		if($check < $act['dailytime'])
		{
			if(!empty($tid))
			{
				$old = pdo_fetch("SELECT point FROM ".tablename('wx_school_teachers')." WHERE  weid ='{$weid}' And schoolid ='{$schoolid}' And id = '{$tid}'  ");
				$oldpoint = intval($old['point']);
				$add = intval($act['adpoint']);
				$newpoint = $oldpoint + $add;
				pdo_update('wx_school_teachers',array('point' => $newpoint ), array('id' => $tid,'weid' => $weid,'schoolid' => $schoolid));
				$pointtemp = array(
				'weid' => $weid,
				'schoolid' => $schoolid,
				'tid' => $tid,
				'pid' => $act['id'],
				'type' => 1,
				'createtime' => time()
				);
				pdo_insert('wx_school_pointsrecord',$pointtemp);	
			}
		}
	}
	return $add;
}

function PointMission ($weid,$schoolid,$userid,$actop)
{
	$teacher = pdo_fetch("SELECT * FROM ".tablename('wx_school_user')." WHERE id ='{$userid}'");
	$tid = $teacher['tid'];
	$act = pdo_fetch("SELECT * FROM ".tablename('wx_school_points')." WHERE  weid ='{$weid}' And schoolid ='{$schoolid}' And op = '{$actop}' And type='2' ");
	$check = pdo_fetch("SELECT mcount,id FROM ".tablename('wx_school_pointsrecord')." WHERE tid = '{$tid}' And weid ='{$weid}' And schoolid ='{$schoolid}' And type='2' And pid = '{$act['id']}' ");
	if($act['is_on'] == 1 )
	{
		if(!empty($tid))
		{
			if(!empty($check))
			{
				$oldcount = intval($check['mcount']);
				$maxcount = intval($act['dailytime']);
				if($oldcount < $maxcount)
				{
					$tempcount = $oldcount + 1 ;
					if($tempcount == $maxcount){
						$old = pdo_fetch("SELECT point FROM ".tablename('wx_school_teachers')." WHERE  weid ='{$weid}' And schoolid ='{$schoolid}' And id = '{$tid}'  ");
						$oldpoint = intval($old['point']);
						$add = intval($act['adpoint']);
						$newpoint = $oldpoint + $add;
						pdo_update('wx_school_teachers',array('point' => $newpoint ), array('id' => $tid,'weid' => $weid,'schoolid' => $schoolid));
						pdo_update('wx_school_pointsrecord',array('mcount' => $tempcount, 'createtime' => time() ), array('id' => $check['id']));
					}else{
						pdo_update('wx_school_pointsrecord',array('mcount' => $tempcount, 'createtime' => time()), array('id' => $check['id']));
					}
				}
			}else{
				$pointtemp = array(
					'weid' => $weid,
					'schoolid' => $schoolid,
					'tid' => $tid,
					'pid' => $act['id'],
					'type' => 2,
					'mcount' => 1,
					'createtime' => time()
				);
				pdo_insert('wx_school_pointsrecord',$pointtemp);
				if($act['dailytime'] == 1 ){
					$old = pdo_fetch("SELECT point FROM ".tablename('wx_school_teachers')." WHERE  weid ='{$weid}' And schoolid ='{$schoolid}' And id = '{$tid}'  ");
					$oldpoint = intval($old['point']);
					$add = intval($act['adpoint']);
					$newpoint = $oldpoint + $add;
					pdo_update('wx_school_teachers',array('point' => $newpoint ), array('id' => $tid,'weid' => $weid,'schoolid' => $schoolid));
				}
			}
		}
	}
	return $add;
}

function checktip($do){ //检查小程序内是否需要弹框提示关注的页面
	$doarr = array('signupjc','tlylist','noticelist','smssage','tmssage','mnoticelist','zuoyelist','bjq','bmlist','signlist','tongxunlu','qingjia','calendar','snoticelist','szuoyelist','slylist','leavelist','callbook');
	if(in_array($do,$doarr)){
		return true;
	}else{
		return false;
	}
}


function CheckMission($tid,$weid,$schoolid){
	
	$all =  pdo_fetchall("SELECT id,dailytime FROM ".tablename('wx_school_points')." WHERE  weid ='{$weid}' And schoolid ='{$schoolid}'  And type='2' And is_on = '1' ");
	$i = 0 ;
	foreach( $all as $key => $value )
	{
		$temp = pdo_fetch("SELECT mcount FROM ".tablename('wx_school_pointsrecord')." WHERE  weid ='{$weid}' And schoolid ='{$schoolid}' And tid = '{$tid}' and pid='{$value['id']}' And type='2' ");
		if($temp['mcount'] == $value['dailytime'])
		{
			continue;
		}elseif($temp['mcount'] < $value['dailytime'])
		{
			//$i++;
			return true;
		}
	}
	return false;
}

function CheckMissionFinished($tid,$pid){
	global $_GPC ,$_W ;
	$all =  pdo_fetch("SELECT id,dailytime FROM ".tablename('wx_school_points')." WHERE  id ='{$pid}' and schoolid='{$_GPC['schoolid']}' And weid='{$_W['uniacid']}'  ");
	$i = 0 ;
	
		$temp = pdo_fetch("SELECT mcount FROM ".tablename('wx_school_pointsrecord')." WHERE   tid = '{$tid}' and pid='{$pid}' And type='2' ");
		if(!$temp)
		{
			$back = "未开始";
			
		}else{
			
		
		if($temp['mcount'] == $all['dailytime'])
		{
			$back = "已完成";
			
		}elseif($temp['mcount'] < $all['dailytime'])
		{
			$back ="完成". $temp['mcount']."/".$all['dailytime'];
			
		}
		}
		return $back;
}

//根据tid获得该教师对应的所有年级主任
function GetNjzr($tid){
	global $_GPC ,$_W ;
	$class= pdo_fetchall("SELECT bj_id FROM ".tablename('wx_school_user_class')." WHERE  tid ='{$tid}' and schoolid='{$_GPC['schoolid']}' And weid='{$_W['uniacid']}' ");
	foreach( $class as $key => $value )
	{
		$temp = pdo_fetch("SELECT parentid FROM ".tablename('wx_school_classify')." WHERE  sid ='{$value['bj_id']}'  ");
		$njzr = pdo_fetch("SELECT tid FROM ".tablename('wx_school_classify')." WHERE  sid ='{$temp['parentid']}'  ");
		$name = pdo_fetch("SELECT tname,openid,id FROM ".tablename('wx_school_teachers')." WHERE   id = '{$njzr['tid']}'  ");
		$njzr_temp[$njzr['tid']] = $name;
	}
	return $njzr_temp;
}

function is_njzr($tid){
	global $_GPC;
	$temp = pdo_fetch("SELECT sid FROM ".tablename('wx_school_classify')." WHERE  type ='semester' And tid ='{$tid}'  ");

	if(!empty($temp))
		return $temp;
	else
		return 0;
}

function getallnj($tid){ //获取当前年级主任所有管辖年级
	global $_GPC,$_W;
	$teacher =  pdo_fetch("SELECT status FROM ".tablename('wx_school_teachers')." WHERE  id ='{$tid}'  and schoolid='{$_GPC['schoolid']}' And weid='{$_W['uniacid']}'  ");
	if($teacher['status'] == 2){
		$temp = pdo_fetchall("SELECT sid,sname FROM ".tablename('wx_school_classify')." WHERE  type ='semester' and schoolid='{$_GPC['schoolid']}' And weid='{$_W['uniacid']}'  ");
	}else{
		$temp = pdo_fetchall("SELECT sid,sname FROM ".tablename('wx_school_classify')." WHERE  type ='semester' And tid ='{$tid}'  and schoolid='{$_GPC['schoolid']}' And weid='{$_W['uniacid']}'  ");
	}
	if(!empty($temp))
		return $temp;
	else
		return 0;
}

function getalljsfz($schoolid){ //获取本校所有教师分组
	$list = pdo_fetchall("SELECT sid,sname FROM ".tablename('wx_school_classify')." WHERE  type ='jsfz' And schoolid= '{$schoolid}' ");
	if(!empty($list)){
		return $list;
	}else{
		return false;
	}	
}

function is_xz($tid){
	global $_W;
	 $isxz = pdo_fetch("SELECT * FROM " . tablename('wx_school_teachers') . " where weid = :weid AND id = :id", array(':weid' => $_W ['uniacid'], ':id' => $tid));
	if(!empty($isxz))
		return 1;
	else
		return 0;
}

function get_myalluser($weid,$openid,$schoolid){ //查询当前微信所有在该学校绑定的用户
	$user = pdo_fetchall("SELECT id,sid,tid FROM " . tablename('wx_school_user') . " where :weid = weid And :openid = openid And :schoolid = schoolid ORDER BY tid DESC, sid DESC ", array(
			':weid' => $weid,
			':openid' => $openid,
			':schoolid' => $schoolid
	));
	
	if($user){
		foreach($user as $key => $row){
			if(!empty($row['sid']) && empty($row['tid']))
			{
				$student = pdo_fetch("SELECT id,s_name,bj_id FROM " . tablename('wx_school_students') . " where id=:id ", array(':id' => $row['sid']));
				$bajinam = pdo_fetch("SELECT sname FROM " . tablename('wx_school_classify') . " where sid = :sid ", array(':sid' => $student['bj_id']));
				$user[$key]['s_name'] = $student['s_name'];
				$user[$key]['bjname'] = $bajinam['sname'];
				$user[$key]['sid'] = $student['id'];  
				$user[$key]['type'] = 1;
			}elseif(empty($row['sid']) && !empty($row['tid']))
			{
				$teacher = pdo_fetch("SELECT id,tname FROM " . tablename('wx_school_teachers') . " where id=:id ", array(':id' => $row['tid']));
				$user[$key]['tname'] = $teacher['tname'];
				$user[$key]['tid'] = $teacher['id'];  
				$user[$key]['type'] = 2;
			}
			
		}
		return $user;
	}else{
		return false;
	}
}

function checkvers(){
	load()->func('communication');
	$url = 'http%3a%2f%2fwww.daren007.com%2fapi%2fgethls.php';
	$data = array(
		'checkver'   => 'checkver',
		'oauthurl' => getoauthurl()
	);	
	$postdata = ihttp_post(urldecode($url), $data);
	if($postdata['code'] ==200){
		$respoed = json_decode($postdata['content'],true);
		if($respoed){
			return($respoed['versions']);
		}
		exit;
	}else{
		return ("访问服务器失败,请检测您的服务器相关设置,错误代码".$postdata['code']);
		exit;				
	}
}

function get_myname($weid,$userid,$schoolid){ //查询当前微信所有在该学校绑定的用户
	$user = pdo_fetch("SELECT id,sid,tid,pard FROM " . tablename('wx_school_user') . " where :weid = weid And :id = id And :schoolid = schoolid ORDER BY tid DESC, sid DESC ", array(
			':weid' => $weid,
			':id' => $userid,
			':schoolid' => $schoolid
	));
	
	if($user){

			if(!empty($user['sid']) && empty($user['tid']))
			{
				$student = pdo_fetch("SELECT id,s_name,bj_id FROM " . tablename('wx_school_students') . " where id=:id ", array(':id' => $user['sid']));
				$bajinam = pdo_fetch("SELECT sname FROM " . tablename('wx_school_classify') . " where sid = :sid ", array(':sid' => $student['bj_id']));
				$user['s_name'] = $student['s_name'];
				$user['bjname'] = $bajinam['sname'];
				$user['sid'] = $student['id'];  
				$user['type'] = 1;
			}elseif(empty($user['sid']) && !empty($user['tid']))
			{
				$teacher = pdo_fetch("SELECT id,tname FROM " . tablename('wx_school_teachers') . " where id=:id ", array(':id' => $user['tid']));
				$user['tname'] = $teacher['tname'];
				$user['tid'] = $teacher['id'];  
				$user['type'] = 2;
			}
			
		
		return $user;
	}else{
		return false;
	}
}

function checkverstype(){
	load()->func('communication');
	$url = 'http%3a%2f%2fwww.daren007.com%2fapi%2fgethls.php';
	$data = array(
		'checkver'   => 'checkver',
		'oauthurl' => getoauthurl()
	);	
	$postdata = ihttp_post(urldecode($url), $data);
	if($postdata['code'] ==200){
		$respoed = json_decode($postdata['content'],true);
		if($respoed){
			return($respoed['ver_type']);
		}
		exit;
	}else{
		return ("访问服务器失败,请检测您的服务器相关设置,错误代码".$postdata['code']);
		exit;				
	}
}

function checkverstypeforhtml(){
	load()->func('communication');
	$url = 'http%3a%2f%2fwww.daren007.com%2fapi%2fgethls.php';
	$data = array(
		'checkver'   => 'checkver',
		'forhtml'   => 'forhtml',
		'oauthurl' => getoauthurl()
	);	
	$postdata = ihttp_post(urldecode($url), $data);
	if($postdata['code'] ==200){
		$respoed = json_decode($postdata['content'],true);
		if($respoed){
			return($respoed['log']);
		}
		exit;
	}else{
		return ("访问服务器失败,请检测您的服务器相关设置,错误代码".$postdata['code']);
		exit;				
	}
}

function is_showgkk(){
	global $_W;
	$oauthurl = getoauthurl();

	if( $oauthurl == "jy.hlgwlkj.com" )
	//if ( $oauthurl == "manger.daren007.com" )
		return 1;
	else
		return 0;
}

function get_device_type() {
	 //全部变成小写字母
	 $agent = strtolower($_SERVER['HTTP_USER_AGENT']);
	 $type = 'other';
	 //分别进行判断
	 if(strpos($agent, 'iphone') || strpos($agent, 'ipad'))
	{
	 $type = 'ios';
	 } 
	  
	 if(strpos($agent, 'android'))
	{
	 $type = 'android';
	 }
	 return $type;
}

function get_myallclass_this_school($weid,$openid,$schoolid){ //查询绑定学生所有班级信息(当前学校)
	$user = pdo_fetchall("SELECT id,sid FROM " . tablename('wx_school_user') . " where :weid = weid And :openid = openid And schoolid=:schoolid And :tid = tid", array(
			':weid' => $weid,
			':openid' => $openid,
			':schoolid' => $schoolid,
			':tid' => 0
	));
	if($user){
		foreach($user as $key => $row){
			$student = pdo_fetch("SELECT id,s_name,bj_id,points FROM " . tablename('wx_school_students') . " where id=:id ", array(':id' => $row['sid']));
			$bajinam = pdo_fetch("SELECT sname FROM " . tablename('wx_school_classify') . " where sid = :sid ", array(':sid' => $student['bj_id']));
			$user[$key]['s_name'] = $student['s_name'];
			$user[$key]['bjname'] = $bajinam['sname'];
			$user[$key]['sid'] = $student['id']; 
			$user[$key]['points'] = $student['points']; 			
		}
		return $user;
	}else{
		return false;
	}
}

//获取权限对应分组
function GetFzByQx ($qx,$type,$schoolid)
{
	$qxid = 0;
	switch ( $qx )
	{
		//s审核教师请假
		case 'shjsqj':
			$qxid = 2001002;
			break;		
		default:
			$qxid = $qx;
			break;
	}  
	$fzlist =  pdo_fetchall("SELECT fzid FROM " . tablename('wx_school_fzqx') . " where qxid={$qxid} And type={$type} and schoolid = {$schoolid}");
	$fzstr = '';
	foreach( $fzlist as $key => $value )
	{
		$fzstr .=$value['fzid'].",";
	}
	$fzstr = trim($fzstr,",");
	return $fzstr;
}

function IsHasQx($tid,$qx,$type,$schoolid)
{
	$logo = pdo_fetch("SELECT is_qx FROM " . tablename('wx_school_index') . " WHERE id = '{$schoolid}'");
	$qxid = 0;
	switch ( $qx )
	{
		//s审核教师请假
		case 'shjsqj':
			$qxid = 2001002;
			break;		
		default:
			$qxid = $qx;
			break;
	}
	if($tid !='founder' && $tid !='owner' && $tid !='vice_founder'){
		$teacher =  pdo_fetch("SELECT fz_id FROM " . tablename('wx_school_teachers') . " where id={$tid} And schoolid = {$schoolid}"); 
		$fz =  pdo_fetch("SELECT id FROM " . tablename('wx_school_fzqx') . " where qxid={$qxid} And type={$type} and schoolid = {$schoolid} And fzid={$teacher['fz_id']}");
		if(!empty($fz)){
			return true;
		}else{
			return false;
		}
	}else{
		return true;
	}
}

function GetSchoolTypeFromLocal($schoolid,$weid){
	if(unitchecksctype() == true){
		$data = pdo_fetch("SELECT issale FROM " . tablename('wx_school_index') . " where weid='{$weid}'  and id = '{$schoolid}'");
		if($data['issale'] == 1){
			return true;
		}elseif(empty($data['issale']) || $data['issale'] == 0){
			return false;
		}
	}else{
		$type = readschootyep();
		return $type;
	}
}

function getkcbiao($schoolid,$time,$bj_id) {
	$date = date('Y-m-d',$time);
	$riqi = explode ('-', $date);
	$starttime = mktime(0,0,0,$riqi[1],$riqi[2],$riqi[0]);
	$endtime = $starttime + 86399;
	$condition = " AND begintime < '{$starttime}' AND endtime > '{$endtime}'";
	$cook = pdo_fetch("SELECT * FROM " . tablename('wx_school_timetable') . " WHERE schoolid = :schoolid And bj_id = :bj_id And ishow = 1 $condition", array(':schoolid' => $schoolid,':bj_id' => $bj_id));
	if($cook['monday'] || $cook['tuesday'] || $cook['wednesday'] || $cook['thursday'] || $cook['friday'] || $cook['saturday'] || $cook['sunday']){
		$week = date("w",$endtime);
			if($week ==1){
				if($cook['monday']){
					$thecook = iunserializer($cook['monday']);
					$sd_1 = pdo_fetch("SELECT sname,sd_start,sd_end FROM " . tablename('wx_school_classify') . " WHERE sid = '{$thecook['mon_1_sd']}'");
					$sd_2 = pdo_fetch("SELECT sname,sd_start,sd_end FROM " . tablename('wx_school_classify') . " WHERE sid = '{$thecook['mon_2_sd']}'");
					$sd_3 = pdo_fetch("SELECT sname,sd_start,sd_end FROM " . tablename('wx_school_classify') . " WHERE sid = '{$thecook['mon_3_sd']}'");
					$sd_4 = pdo_fetch("SELECT sname,sd_start,sd_end FROM " . tablename('wx_school_classify') . " WHERE sid = '{$thecook['mon_4_sd']}'");
					$sd_5 = pdo_fetch("SELECT sname,sd_start,sd_end FROM " . tablename('wx_school_classify') . " WHERE sid = '{$thecook['mon_5_sd']}'");
					$sd_6 = pdo_fetch("SELECT sname,sd_start,sd_end FROM " . tablename('wx_school_classify') . " WHERE sid = '{$thecook['mon_6_sd']}'");
					$sd_7 = pdo_fetch("SELECT sname,sd_start,sd_end FROM " . tablename('wx_school_classify') . " WHERE sid = '{$thecook['mon_7_sd']}'");
					$sd_8 = pdo_fetch("SELECT sname,sd_start,sd_end FROM " . tablename('wx_school_classify') . " WHERE sid = '{$thecook['mon_8_sd']}'");
					$sd_9 = pdo_fetch("SELECT sname,sd_start,sd_end FROM " . tablename('wx_school_classify') . " WHERE sid = '{$thecook['mon_9_sd']}'");
					$sd_10 = pdo_fetch("SELECT sname,sd_start,sd_end FROM " . tablename('wx_school_classify') . " WHERE sid = '{$thecook['mon_10_sd']}'");
					$sd_11 = pdo_fetch("SELECT sname,sd_start,sd_end FROM " . tablename('wx_school_classify') . " WHERE sid = '{$thecook['mon_11_sd']}'");
					$sd_12 = pdo_fetch("SELECT sname,sd_start,sd_end FROM " . tablename('wx_school_classify') . " WHERE sid = '{$thecook['mon_12_sd']}'");
					$km_1 = pdo_fetch("SELECT sname,icon FROM " . tablename('wx_school_classify') . " WHERE sid = '{$thecook['mon_1_km']}'");
					$km_2 = pdo_fetch("SELECT sname,icon FROM " . tablename('wx_school_classify') . " WHERE sid = '{$thecook['mon_2_km']}'");
					$km_3 = pdo_fetch("SELECT sname,icon FROM " . tablename('wx_school_classify') . " WHERE sid = '{$thecook['mon_3_km']}'");
					$km_4 = pdo_fetch("SELECT sname,icon FROM " . tablename('wx_school_classify') . " WHERE sid = '{$thecook['mon_4_km']}'");
					$km_5 = pdo_fetch("SELECT sname,icon FROM " . tablename('wx_school_classify') . " WHERE sid = '{$thecook['mon_5_km']}'");
					$km_6 = pdo_fetch("SELECT sname,icon FROM " . tablename('wx_school_classify') . " WHERE sid = '{$thecook['mon_6_km']}'");
					$km_7 = pdo_fetch("SELECT sname,icon FROM " . tablename('wx_school_classify') . " WHERE sid = '{$thecook['mon_7_km']}'");
					$km_8 = pdo_fetch("SELECT sname,icon FROM " . tablename('wx_school_classify') . " WHERE sid = '{$thecook['mon_8_km']}'");
					$km_9 = pdo_fetch("SELECT sname,icon FROM " . tablename('wx_school_classify') . " WHERE sid = '{$thecook['mon_9_km']}'");
					$km_10 = pdo_fetch("SELECT sname,icon FROM " . tablename('wx_school_classify') . " WHERE sid = '{$thecook['mon_10_km']}'");
					$km_11 = pdo_fetch("SELECT sname,icon FROM " . tablename('wx_school_classify') . " WHERE sid = '{$thecook['mon_11_km']}'");
					$km_12 = pdo_fetch("SELECT sname,icon FROM " . tablename('wx_school_classify') . " WHERE sid = '{$thecook['mon_12_km']}'");
					$tehcer1 = findtecher($bj_id,$schoolid,$thecook['mon_1_km']);
					$tehcer2 = findtecher($bj_id,$schoolid,$thecook['mon_2_km']);
					$tehcer3 = findtecher($bj_id,$schoolid,$thecook['mon_3_km']);
					$tehcer4 = findtecher($bj_id,$schoolid,$thecook['mon_4_km']);
					$tehcer5 = findtecher($bj_id,$schoolid,$thecook['mon_5_km']);
					$tehcer6 = findtecher($bj_id,$schoolid,$thecook['mon_6_km']);
					$tehcer7 = findtecher($bj_id,$schoolid,$thecook['mon_7_km']);
					$tehcer8 = findtecher($bj_id,$schoolid,$thecook['mon_8_km']);
					$tehcer9 = findtecher($bj_id,$schoolid,$thecook['mon_9_km']);
					$tehcer10 = findtecher($bj_id,$schoolid,$thecook['mon_10_km']);
					$tehcer11 = findtecher($bj_id,$schoolid,$thecook['mon_11_km']);
					$tehcer12 = findtecher($bj_id,$schoolid,$thecook['mon_12_km']);							
				}
			}
			if($week ==2){
				if($cook['tuesday']){
					$thecook = iunserializer($cook['tuesday']);
					$sd_1 = pdo_fetch("SELECT sname,sd_start,sd_end FROM " . tablename('wx_school_classify') . " WHERE sid = '{$thecook['tus_1_sd']}'");
					$sd_2 = pdo_fetch("SELECT sname,sd_start,sd_end FROM " . tablename('wx_school_classify') . " WHERE sid = '{$thecook['tus_2_sd']}'");
					$sd_3 = pdo_fetch("SELECT sname,sd_start,sd_end FROM " . tablename('wx_school_classify') . " WHERE sid = '{$thecook['tus_3_sd']}'");
					$sd_4 = pdo_fetch("SELECT sname,sd_start,sd_end FROM " . tablename('wx_school_classify') . " WHERE sid = '{$thecook['tus_4_sd']}'");
					$sd_5 = pdo_fetch("SELECT sname,sd_start,sd_end FROM " . tablename('wx_school_classify') . " WHERE sid = '{$thecook['tus_5_sd']}'");
					$sd_6 = pdo_fetch("SELECT sname,sd_start,sd_end FROM " . tablename('wx_school_classify') . " WHERE sid = '{$thecook['tus_6_sd']}'");
					$sd_7 = pdo_fetch("SELECT sname,sd_start,sd_end FROM " . tablename('wx_school_classify') . " WHERE sid = '{$thecook['tus_7_sd']}'");
					$sd_8 = pdo_fetch("SELECT sname,sd_start,sd_end FROM " . tablename('wx_school_classify') . " WHERE sid = '{$thecook['tus_8_sd']}'");
					$sd_9 = pdo_fetch("SELECT sname,sd_start,sd_end FROM " . tablename('wx_school_classify') . " WHERE sid = '{$thecook['tus_9_sd']}'");
					$sd_10 = pdo_fetch("SELECT sname,sd_start,sd_end FROM " . tablename('wx_school_classify') . " WHERE sid = '{$thecook['tus_10_sd']}'");
					$sd_11 = pdo_fetch("SELECT sname,sd_start,sd_end FROM " . tablename('wx_school_classify') . " WHERE sid = '{$thecook['tus_11_sd']}'");
					$sd_12 = pdo_fetch("SELECT sname,sd_start,sd_end FROM " . tablename('wx_school_classify') . " WHERE sid = '{$thecook['tus_12_sd']}'");
					$km_1 = pdo_fetch("SELECT sname,icon FROM " . tablename('wx_school_classify') . " WHERE sid = '{$thecook['tus_1_km']}'");
					$km_2 = pdo_fetch("SELECT sname,icon FROM " . tablename('wx_school_classify') . " WHERE sid = '{$thecook['tus_2_km']}'");
					$km_3 = pdo_fetch("SELECT sname,icon FROM " . tablename('wx_school_classify') . " WHERE sid = '{$thecook['tus_3_km']}'");
					$km_4 = pdo_fetch("SELECT sname,icon FROM " . tablename('wx_school_classify') . " WHERE sid = '{$thecook['tus_4_km']}'");
					$km_5 = pdo_fetch("SELECT sname,icon FROM " . tablename('wx_school_classify') . " WHERE sid = '{$thecook['tus_5_km']}'");
					$km_6 = pdo_fetch("SELECT sname,icon FROM " . tablename('wx_school_classify') . " WHERE sid = '{$thecook['tus_6_km']}'");
					$km_7 = pdo_fetch("SELECT sname,icon FROM " . tablename('wx_school_classify') . " WHERE sid = '{$thecook['tus_7_km']}'");
					$km_8 = pdo_fetch("SELECT sname,icon FROM " . tablename('wx_school_classify') . " WHERE sid = '{$thecook['tus_8_km']}'");
					$km_9 = pdo_fetch("SELECT sname,icon FROM " . tablename('wx_school_classify') . " WHERE sid = '{$thecook['tus_9_km']}'");
					$km_10 = pdo_fetch("SELECT sname,icon FROM " . tablename('wx_school_classify') . " WHERE sid = '{$thecook['tus_10_km']}'");
					$km_11 = pdo_fetch("SELECT sname,icon FROM " . tablename('wx_school_classify') . " WHERE sid = '{$thecook['tus_11_km']}'");
					$km_12 = pdo_fetch("SELECT sname,icon FROM " . tablename('wx_school_classify') . " WHERE sid = '{$thecook['tus_12_km']}'");
					$tehcer1 = findtecher($bj_id,$schoolid,$thecook['tus_1_km']);
					$tehcer2 = findtecher($bj_id,$schoolid,$thecook['tus_2_km']);
					$tehcer3 = findtecher($bj_id,$schoolid,$thecook['tus_3_km']);
					$tehcer4 = findtecher($bj_id,$schoolid,$thecook['tus_4_km']);
					$tehcer5 = findtecher($bj_id,$schoolid,$thecook['tus_5_km']);
					$tehcer6 = findtecher($bj_id,$schoolid,$thecook['tus_6_km']);
					$tehcer7 = findtecher($bj_id,$schoolid,$thecook['tus_7_km']);
					$tehcer8 = findtecher($bj_id,$schoolid,$thecook['tus_8_km']);
					$tehcer9 = findtecher($bj_id,$schoolid,$thecook['tus_9_km']);
					$tehcer10 = findtecher($bj_id,$schoolid,$thecook['tus_10_km']);
					$tehcer11 = findtecher($bj_id,$schoolid,$thecook['tus_11_km']);
					$tehcer12 = findtecher($bj_id,$schoolid,$thecook['tus_12_km']);						
				}		
			}
			if($week ==3){
				if($cook['wednesday']){
					$thecook = iunserializer($cook['wednesday']);	
					$sd_1 = pdo_fetch("SELECT sname,sd_start,sd_end FROM " . tablename('wx_school_classify') . " WHERE sid = '{$thecook['wed_1_sd']}'");
					$sd_2 = pdo_fetch("SELECT sname,sd_start,sd_end FROM " . tablename('wx_school_classify') . " WHERE sid = '{$thecook['wed_2_sd']}'");
					$sd_3 = pdo_fetch("SELECT sname,sd_start,sd_end FROM " . tablename('wx_school_classify') . " WHERE sid = '{$thecook['wed_3_sd']}'");
					$sd_4 = pdo_fetch("SELECT sname,sd_start,sd_end FROM " . tablename('wx_school_classify') . " WHERE sid = '{$thecook['wed_4_sd']}'");
					$sd_5 = pdo_fetch("SELECT sname,sd_start,sd_end FROM " . tablename('wx_school_classify') . " WHERE sid = '{$thecook['wed_5_sd']}'");
					$sd_6 = pdo_fetch("SELECT sname,sd_start,sd_end FROM " . tablename('wx_school_classify') . " WHERE sid = '{$thecook['wed_6_sd']}'");
					$sd_7 = pdo_fetch("SELECT sname,sd_start,sd_end FROM " . tablename('wx_school_classify') . " WHERE sid = '{$thecook['wed_7_sd']}'");
					$sd_8 = pdo_fetch("SELECT sname,sd_start,sd_end FROM " . tablename('wx_school_classify') . " WHERE sid = '{$thecook['wed_8_sd']}'");
					$sd_9 = pdo_fetch("SELECT sname,sd_start,sd_end FROM " . tablename('wx_school_classify') . " WHERE sid = '{$thecook['wed_9_sd']}'");
					$sd_10 = pdo_fetch("SELECT sname,sd_start,sd_end FROM " . tablename('wx_school_classify') . " WHERE sid = '{$thecook['wed_10_sd']}'");
					$sd_11 = pdo_fetch("SELECT sname,sd_start,sd_end FROM " . tablename('wx_school_classify') . " WHERE sid = '{$thecook['wed_11_sd']}'");
					$sd_12 = pdo_fetch("SELECT sname,sd_start,sd_end FROM " . tablename('wx_school_classify') . " WHERE sid = '{$thecook['wed_12_sd']}'");
					$km_1 = pdo_fetch("SELECT sname,icon FROM " . tablename('wx_school_classify') . " WHERE sid = '{$thecook['wed_1_km']}'");
					$km_2 = pdo_fetch("SELECT sname,icon FROM " . tablename('wx_school_classify') . " WHERE sid = '{$thecook['wed_2_km']}'");
					$km_3 = pdo_fetch("SELECT sname,icon FROM " . tablename('wx_school_classify') . " WHERE sid = '{$thecook['wed_3_km']}'");
					$km_4 = pdo_fetch("SELECT sname,icon FROM " . tablename('wx_school_classify') . " WHERE sid = '{$thecook['wed_4_km']}'");
					$km_5 = pdo_fetch("SELECT sname,icon FROM " . tablename('wx_school_classify') . " WHERE sid = '{$thecook['wed_5_km']}'");
					$km_6 = pdo_fetch("SELECT sname,icon FROM " . tablename('wx_school_classify') . " WHERE sid = '{$thecook['wed_6_km']}'");
					$km_7 = pdo_fetch("SELECT sname,icon FROM " . tablename('wx_school_classify') . " WHERE sid = '{$thecook['wed_7_km']}'");
					$km_8 = pdo_fetch("SELECT sname,icon FROM " . tablename('wx_school_classify') . " WHERE sid = '{$thecook['wed_8_km']}'");
					$km_9 = pdo_fetch("SELECT sname,icon FROM " . tablename('wx_school_classify') . " WHERE sid = '{$thecook['wed_9_km']}'");
					$km_10 = pdo_fetch("SELECT sname,icon FROM " . tablename('wx_school_classify') . " WHERE sid = '{$thecook['wed_10_km']}'");
					$km_11 = pdo_fetch("SELECT sname,icon FROM " . tablename('wx_school_classify') . " WHERE sid = '{$thecook['wed_11_km']}'");
					$km_12 = pdo_fetch("SELECT sname,icon FROM " . tablename('wx_school_classify') . " WHERE sid = '{$thecook['wed_12_km']}'");
					$tehcer1 = findtecher($bj_id,$schoolid,$thecook['wed_1_km']);
					$tehcer2 = findtecher($bj_id,$schoolid,$thecook['wed_2_km']);
					$tehcer3 = findtecher($bj_id,$schoolid,$thecook['wed_3_km']);
					$tehcer4 = findtecher($bj_id,$schoolid,$thecook['wed_4_km']);
					$tehcer5 = findtecher($bj_id,$schoolid,$thecook['wed_5_km']);
					$tehcer6 = findtecher($bj_id,$schoolid,$thecook['wed_6_km']);
					$tehcer7 = findtecher($bj_id,$schoolid,$thecook['wed_7_km']);
					$tehcer8 = findtecher($bj_id,$schoolid,$thecook['wed_8_km']);
					$tehcer9 = findtecher($bj_id,$schoolid,$thecook['wed_9_km']);
					$tehcer10 = findtecher($bj_id,$schoolid,$thecook['wed_10_km']);
					$tehcer11 = findtecher($bj_id,$schoolid,$thecook['wed_11_km']);
					$tehcer12 = findtecher($bj_id,$schoolid,$thecook['wed_12_km']);							
				}		
			}
			if($week ==4){
				if($cook['thursday']){
					$thecook = iunserializer($cook['thursday']);
					$sd_1 = pdo_fetch("SELECT sname,sd_start,sd_end FROM " . tablename('wx_school_classify') . " WHERE sid = '{$thecook['thu_1_sd']}'");
					$sd_2 = pdo_fetch("SELECT sname,sd_start,sd_end FROM " . tablename('wx_school_classify') . " WHERE sid = '{$thecook['thu_2_sd']}'");
					$sd_3 = pdo_fetch("SELECT sname,sd_start,sd_end FROM " . tablename('wx_school_classify') . " WHERE sid = '{$thecook['thu_3_sd']}'");
					$sd_4 = pdo_fetch("SELECT sname,sd_start,sd_end FROM " . tablename('wx_school_classify') . " WHERE sid = '{$thecook['thu_4_sd']}'");
					$sd_5 = pdo_fetch("SELECT sname,sd_start,sd_end FROM " . tablename('wx_school_classify') . " WHERE sid = '{$thecook['thu_5_sd']}'");
					$sd_6 = pdo_fetch("SELECT sname,sd_start,sd_end FROM " . tablename('wx_school_classify') . " WHERE sid = '{$thecook['thu_6_sd']}'");
					$sd_7 = pdo_fetch("SELECT sname,sd_start,sd_end FROM " . tablename('wx_school_classify') . " WHERE sid = '{$thecook['thu_7_sd']}'");
					$sd_8 = pdo_fetch("SELECT sname,sd_start,sd_end FROM " . tablename('wx_school_classify') . " WHERE sid = '{$thecook['thu_8_sd']}'");
					$sd_9 = pdo_fetch("SELECT sname,sd_start,sd_end FROM " . tablename('wx_school_classify') . " WHERE sid = '{$thecook['thu_9_sd']}'");
					$sd_10 = pdo_fetch("SELECT sname,sd_start,sd_end FROM " . tablename('wx_school_classify') . " WHERE sid = '{$thecook['thu_10_sd']}'");
					$sd_11 = pdo_fetch("SELECT sname,sd_start,sd_end FROM " . tablename('wx_school_classify') . " WHERE sid = '{$thecook['thu_11_sd']}'");
					$sd_12 = pdo_fetch("SELECT sname,sd_start,sd_end FROM " . tablename('wx_school_classify') . " WHERE sid = '{$thecook['thu_12_sd']}'");
					$km_1 = pdo_fetch("SELECT sname,icon FROM " . tablename('wx_school_classify') . " WHERE sid = '{$thecook['thu_1_km']}'");
					$km_2 = pdo_fetch("SELECT sname,icon FROM " . tablename('wx_school_classify') . " WHERE sid = '{$thecook['thu_2_km']}'");
					$km_3 = pdo_fetch("SELECT sname,icon FROM " . tablename('wx_school_classify') . " WHERE sid = '{$thecook['thu_3_km']}'");
					$km_4 = pdo_fetch("SELECT sname,icon FROM " . tablename('wx_school_classify') . " WHERE sid = '{$thecook['thu_4_km']}'");
					$km_5 = pdo_fetch("SELECT sname,icon FROM " . tablename('wx_school_classify') . " WHERE sid = '{$thecook['thu_5_km']}'");
					$km_6 = pdo_fetch("SELECT sname,icon FROM " . tablename('wx_school_classify') . " WHERE sid = '{$thecook['thu_6_km']}'");
					$km_7 = pdo_fetch("SELECT sname,icon FROM " . tablename('wx_school_classify') . " WHERE sid = '{$thecook['thu_7_km']}'");
					$km_8 = pdo_fetch("SELECT sname,icon FROM " . tablename('wx_school_classify') . " WHERE sid = '{$thecook['thu_8_km']}'");
					$km_9 = pdo_fetch("SELECT sname,icon FROM " . tablename('wx_school_classify') . " WHERE sid = '{$thecook['thu_9_km']}'");
					$km_10 = pdo_fetch("SELECT sname,icon FROM " . tablename('wx_school_classify') . " WHERE sid = '{$thecook['thu_10_km']}'");
					$km_11 = pdo_fetch("SELECT sname,icon FROM " . tablename('wx_school_classify') . " WHERE sid = '{$thecook['thu_11_km']}'");
					$km_12 = pdo_fetch("SELECT sname,icon FROM " . tablename('wx_school_classify') . " WHERE sid = '{$thecook['thu_12_km']}'");
					$tehcer1 = findtecher($bj_id,$schoolid,$thecook['thu_1_km']);
					$tehcer2 = findtecher($bj_id,$schoolid,$thecook['thu_2_km']);
					$tehcer3 = findtecher($bj_id,$schoolid,$thecook['thu_3_km']);
					$tehcer4 = findtecher($bj_id,$schoolid,$thecook['thu_4_km']);
					$tehcer5 = findtecher($bj_id,$schoolid,$thecook['thu_5_km']);
					$tehcer6 = findtecher($bj_id,$schoolid,$thecook['thu_6_km']);
					$tehcer7 = findtecher($bj_id,$schoolid,$thecook['thu_7_km']);
					$tehcer8 = findtecher($bj_id,$schoolid,$thecook['thu_8_km']);
					$tehcer9 = findtecher($bj_id,$schoolid,$thecook['thu_9_km']);
					$tehcer10 = findtecher($bj_id,$schoolid,$thecook['thu_10_km']);
					$tehcer11 = findtecher($bj_id,$schoolid,$thecook['thu_11_km']);
					$tehcer12 = findtecher($bj_id,$schoolid,$thecook['thu_12_km']);						
				}		
			}
			if($week ==5){
				if($cook['friday']){
					$thecook = iunserializer($cook['friday']);	
					$sd_1 = pdo_fetch("SELECT sname,sd_start,sd_end FROM " . tablename('wx_school_classify') . " WHERE sid = '{$thecook['fri_1_sd']}'");
					$sd_2 = pdo_fetch("SELECT sname,sd_start,sd_end FROM " . tablename('wx_school_classify') . " WHERE sid = '{$thecook['fri_2_sd']}'");
					$sd_3 = pdo_fetch("SELECT sname,sd_start,sd_end FROM " . tablename('wx_school_classify') . " WHERE sid = '{$thecook['fri_3_sd']}'");
					$sd_4 = pdo_fetch("SELECT sname,sd_start,sd_end FROM " . tablename('wx_school_classify') . " WHERE sid = '{$thecook['fri_4_sd']}'");
					$sd_5 = pdo_fetch("SELECT sname,sd_start,sd_end FROM " . tablename('wx_school_classify') . " WHERE sid = '{$thecook['fri_5_sd']}'");
					$sd_6 = pdo_fetch("SELECT sname,sd_start,sd_end FROM " . tablename('wx_school_classify') . " WHERE sid = '{$thecook['fri_6_sd']}'");
					$sd_7 = pdo_fetch("SELECT sname,sd_start,sd_end FROM " . tablename('wx_school_classify') . " WHERE sid = '{$thecook['fri_7_sd']}'");
					$sd_8 = pdo_fetch("SELECT sname,sd_start,sd_end FROM " . tablename('wx_school_classify') . " WHERE sid = '{$thecook['fri_8_sd']}'");
					$sd_9 = pdo_fetch("SELECT sname,sd_start,sd_end FROM " . tablename('wx_school_classify') . " WHERE sid = '{$thecook['fri_9_sd']}'");
					$sd_10 = pdo_fetch("SELECT sname,sd_start,sd_end FROM " . tablename('wx_school_classify') . " WHERE sid = '{$thecook['fri_10_sd']}'");
					$sd_11 = pdo_fetch("SELECT sname,sd_start,sd_end FROM " . tablename('wx_school_classify') . " WHERE sid = '{$thecook['fri_11_sd']}'");
					$sd_12 = pdo_fetch("SELECT sname,sd_start,sd_end FROM " . tablename('wx_school_classify') . " WHERE sid = '{$thecook['fri_12_sd']}'");
					$km_1 = pdo_fetch("SELECT sname,icon FROM " . tablename('wx_school_classify') . " WHERE sid = '{$thecook['fri_1_km']}'");
					$km_2 = pdo_fetch("SELECT sname,icon FROM " . tablename('wx_school_classify') . " WHERE sid = '{$thecook['fri_2_km']}'");
					$km_3 = pdo_fetch("SELECT sname,icon FROM " . tablename('wx_school_classify') . " WHERE sid = '{$thecook['fri_3_km']}'");
					$km_4 = pdo_fetch("SELECT sname,icon FROM " . tablename('wx_school_classify') . " WHERE sid = '{$thecook['fri_4_km']}'");
					$km_5 = pdo_fetch("SELECT sname,icon FROM " . tablename('wx_school_classify') . " WHERE sid = '{$thecook['fri_5_km']}'");
					$km_6 = pdo_fetch("SELECT sname,icon FROM " . tablename('wx_school_classify') . " WHERE sid = '{$thecook['fri_6_km']}'");
					$km_7 = pdo_fetch("SELECT sname,icon FROM " . tablename('wx_school_classify') . " WHERE sid = '{$thecook['fri_7_km']}'");
					$km_8 = pdo_fetch("SELECT sname,icon FROM " . tablename('wx_school_classify') . " WHERE sid = '{$thecook['fri_8_km']}'");
					$km_9 = pdo_fetch("SELECT sname,icon FROM " . tablename('wx_school_classify') . " WHERE sid = '{$thecook['fri_9_km']}'");
					$km_10 = pdo_fetch("SELECT sname,icon FROM " . tablename('wx_school_classify') . " WHERE sid = '{$thecook['fri_10_km']}'");
					$km_11 = pdo_fetch("SELECT sname,icon FROM " . tablename('wx_school_classify') . " WHERE sid = '{$thecook['fri_11_km']}'");
					$km_12 = pdo_fetch("SELECT sname,icon FROM " . tablename('wx_school_classify') . " WHERE sid = '{$thecook['fri_12_km']}'");
					$tehcer1 = findtecher($bj_id,$schoolid,$thecook['fri_1_km']);
					$tehcer2 = findtecher($bj_id,$schoolid,$thecook['fri_2_km']);
					$tehcer3 = findtecher($bj_id,$schoolid,$thecook['fri_3_km']);
					$tehcer4 = findtecher($bj_id,$schoolid,$thecook['fri_4_km']);
					$tehcer5 = findtecher($bj_id,$schoolid,$thecook['fri_5_km']);
					$tehcer6 = findtecher($bj_id,$schoolid,$thecook['fri_6_km']);
					$tehcer7 = findtecher($bj_id,$schoolid,$thecook['fri_7_km']);
					$tehcer8 = findtecher($bj_id,$schoolid,$thecook['fri_8_km']);
					$tehcer9 = findtecher($bj_id,$schoolid,$thecook['fri_9_km']);
					$tehcer10 = findtecher($bj_id,$schoolid,$thecook['fri_10_km']);
					$tehcer11 = findtecher($bj_id,$schoolid,$thecook['fri_11_km']);
					$tehcer12 = findtecher($bj_id,$schoolid,$thecook['fri_12_km']);						
				}		
			}
			if($week ==6){
				if($cook['saturday']){
					$thecook = iunserializer($cook['saturday']);
					$sd_1 = pdo_fetch("SELECT sname,sd_start,sd_end FROM " . tablename('wx_school_classify') . " WHERE sid = '{$thecook['sat_1_sd']}'");
					$sd_2 = pdo_fetch("SELECT sname,sd_start,sd_end FROM " . tablename('wx_school_classify') . " WHERE sid = '{$thecook['sat_2_sd']}'");
					$sd_3 = pdo_fetch("SELECT sname,sd_start,sd_end FROM " . tablename('wx_school_classify') . " WHERE sid = '{$thecook['sat_3_sd']}'");
					$sd_4 = pdo_fetch("SELECT sname,sd_start,sd_end FROM " . tablename('wx_school_classify') . " WHERE sid = '{$thecook['sat_4_sd']}'");
					$sd_5 = pdo_fetch("SELECT sname,sd_start,sd_end FROM " . tablename('wx_school_classify') . " WHERE sid = '{$thecook['sat_5_sd']}'");
					$sd_6 = pdo_fetch("SELECT sname,sd_start,sd_end FROM " . tablename('wx_school_classify') . " WHERE sid = '{$thecook['sat_6_sd']}'");
					$sd_7 = pdo_fetch("SELECT sname,sd_start,sd_end FROM " . tablename('wx_school_classify') . " WHERE sid = '{$thecook['sat_7_sd']}'");
					$sd_8 = pdo_fetch("SELECT sname,sd_start,sd_end FROM " . tablename('wx_school_classify') . " WHERE sid = '{$thecook['sat_8_sd']}'");
					$sd_9 = pdo_fetch("SELECT sname,sd_start,sd_end FROM " . tablename('wx_school_classify') . " WHERE sid = '{$thecook['sat_9_sd']}'");
					$sd_10 = pdo_fetch("SELECT sname,sd_start,sd_end FROM " . tablename('wx_school_classify') . " WHERE sid = '{$thecook['sat_10_sd']}'");
					$sd_11 = pdo_fetch("SELECT sname,sd_start,sd_end FROM " . tablename('wx_school_classify') . " WHERE sid = '{$thecook['sat_11_sd']}'");
					$sd_12 = pdo_fetch("SELECT sname,sd_start,sd_end FROM " . tablename('wx_school_classify') . " WHERE sid = '{$thecook['sat_12_sd']}'");
					$km_1 = pdo_fetch("SELECT sname,icon FROM " . tablename('wx_school_classify') . " WHERE sid = '{$thecook['sat_1_km']}'");
					$km_2 = pdo_fetch("SELECT sname,icon FROM " . tablename('wx_school_classify') . " WHERE sid = '{$thecook['sat_2_km']}'");
					$km_3 = pdo_fetch("SELECT sname,icon FROM " . tablename('wx_school_classify') . " WHERE sid = '{$thecook['sat_3_km']}'");
					$km_4 = pdo_fetch("SELECT sname,icon FROM " . tablename('wx_school_classify') . " WHERE sid = '{$thecook['sat_4_km']}'");
					$km_5 = pdo_fetch("SELECT sname,icon FROM " . tablename('wx_school_classify') . " WHERE sid = '{$thecook['sat_5_km']}'");
					$km_6 = pdo_fetch("SELECT sname,icon FROM " . tablename('wx_school_classify') . " WHERE sid = '{$thecook['sat_6_km']}'");
					$km_7 = pdo_fetch("SELECT sname,icon FROM " . tablename('wx_school_classify') . " WHERE sid = '{$thecook['sat_7_km']}'");
					$km_8 = pdo_fetch("SELECT sname,icon FROM " . tablename('wx_school_classify') . " WHERE sid = '{$thecook['sat_8_km']}'");
					$km_9 = pdo_fetch("SELECT sname,icon FROM " . tablename('wx_school_classify') . " WHERE sid = '{$thecook['sat_9_km']}'");
					$km_10 = pdo_fetch("SELECT sname,icon FROM " . tablename('wx_school_classify') . " WHERE sid = '{$thecook['sat_10_km']}'");
					$km_11 = pdo_fetch("SELECT sname,icon FROM " . tablename('wx_school_classify') . " WHERE sid = '{$thecook['sat_11_km']}'");
					$km_12 = pdo_fetch("SELECT sname,icon FROM " . tablename('wx_school_classify') . " WHERE sid = '{$thecook['sat_12_km']}'");
					$tehcer1 = findtecher($bj_id,$schoolid,$thecook['sat_1_km']);
					$tehcer2 = findtecher($bj_id,$schoolid,$thecook['sat_2_km']);
					$tehcer3 = findtecher($bj_id,$schoolid,$thecook['sat_3_km']);
					$tehcer4 = findtecher($bj_id,$schoolid,$thecook['sat_4_km']);
					$tehcer5 = findtecher($bj_id,$schoolid,$thecook['sat_5_km']);
					$tehcer6 = findtecher($bj_id,$schoolid,$thecook['sat_6_km']);
					$tehcer7 = findtecher($bj_id,$schoolid,$thecook['sat_7_km']);
					$tehcer8 = findtecher($bj_id,$schoolid,$thecook['sat_8_km']);
					$tehcer9 = findtecher($bj_id,$schoolid,$thecook['sat_9_km']);
					$tehcer10 = findtecher($bj_id,$schoolid,$thecook['sat_10_km']);
					$tehcer11 = findtecher($bj_id,$schoolid,$thecook['sat_11_km']);
					$tehcer12 = findtecher($bj_id,$schoolid,$thecook['sat_12_km']);						
				}		
			}
			if($week == 0){
				if($cook['sunday']){
					$thecook = iunserializer($cook['sunday']);	
					$sd_1 = pdo_fetch("SELECT sname,sd_start,sd_end FROM " . tablename('wx_school_classify') . " WHERE sid = '{$thecook['sun_1_sd']}'");
					$sd_2 = pdo_fetch("SELECT sname,sd_start,sd_end FROM " . tablename('wx_school_classify') . " WHERE sid = '{$thecook['sun_2_sd']}'");
					$sd_3 = pdo_fetch("SELECT sname,sd_start,sd_end FROM " . tablename('wx_school_classify') . " WHERE sid = '{$thecook['sun_3_sd']}'");
					$sd_4 = pdo_fetch("SELECT sname,sd_start,sd_end FROM " . tablename('wx_school_classify') . " WHERE sid = '{$thecook['sun_4_sd']}'");
					$sd_5 = pdo_fetch("SELECT sname,sd_start,sd_end FROM " . tablename('wx_school_classify') . " WHERE sid = '{$thecook['sun_5_sd']}'");
					$sd_6 = pdo_fetch("SELECT sname,sd_start,sd_end FROM " . tablename('wx_school_classify') . " WHERE sid = '{$thecook['sun_6_sd']}'");
					$sd_7 = pdo_fetch("SELECT sname,sd_start,sd_end FROM " . tablename('wx_school_classify') . " WHERE sid = '{$thecook['sun_7_sd']}'");
					$sd_8 = pdo_fetch("SELECT sname,sd_start,sd_end FROM " . tablename('wx_school_classify') . " WHERE sid = '{$thecook['sun_8_sd']}'");
					$sd_9 = pdo_fetch("SELECT sname,sd_start,sd_end FROM " . tablename('wx_school_classify') . " WHERE sid = '{$thecook['sun_9_sd']}'");
					$sd_10 = pdo_fetch("SELECT sname,sd_start,sd_end FROM " . tablename('wx_school_classify') . " WHERE sid = '{$thecook['sun_10_sd']}'");
					$sd_11 = pdo_fetch("SELECT sname,sd_start,sd_end FROM " . tablename('wx_school_classify') . " WHERE sid = '{$thecook['sun_11_sd']}'");
					$sd_12 = pdo_fetch("SELECT sname,sd_start,sd_end FROM " . tablename('wx_school_classify') . " WHERE sid = '{$thecook['sun_12_sd']}'");
					$km_1 = pdo_fetch("SELECT sname,icon FROM " . tablename('wx_school_classify') . " WHERE sid = '{$thecook['sun_1_km']}'");
					$km_2 = pdo_fetch("SELECT sname,icon FROM " . tablename('wx_school_classify') . " WHERE sid = '{$thecook['sun_2_km']}'");
					$km_3 = pdo_fetch("SELECT sname,icon FROM " . tablename('wx_school_classify') . " WHERE sid = '{$thecook['sun_3_km']}'");
					$km_4 = pdo_fetch("SELECT sname,icon FROM " . tablename('wx_school_classify') . " WHERE sid = '{$thecook['sun_4_km']}'");
					$km_5 = pdo_fetch("SELECT sname,icon FROM " . tablename('wx_school_classify') . " WHERE sid = '{$thecook['sun_5_km']}'");
					$km_6 = pdo_fetch("SELECT sname,icon FROM " . tablename('wx_school_classify') . " WHERE sid = '{$thecook['sun_6_km']}'");
					$km_7 = pdo_fetch("SELECT sname,icon FROM " . tablename('wx_school_classify') . " WHERE sid = '{$thecook['sun_7_km']}'");
					$km_8 = pdo_fetch("SELECT sname,icon FROM " . tablename('wx_school_classify') . " WHERE sid = '{$thecook['sun_8_km']}'");
					$km_9 = pdo_fetch("SELECT sname,icon FROM " . tablename('wx_school_classify') . " WHERE sid = '{$thecook['sun_9_km']}'");
					$km_10 = pdo_fetch("SELECT sname,icon FROM " . tablename('wx_school_classify') . " WHERE sid = '{$thecook['sun_10_km']}'");
					$km_11 = pdo_fetch("SELECT sname,icon FROM " . tablename('wx_school_classify') . " WHERE sid = '{$thecook['sun_11_km']}'");
					$km_12 = pdo_fetch("SELECT sname,icon FROM " . tablename('wx_school_classify') . " WHERE sid = '{$thecook['sun_12_km']}'");
					$tehcer1 = findtecher($bj_id,$schoolid,$thecook['sun_1_km']);
					$tehcer2 = findtecher($bj_id,$schoolid,$thecook['sun_2_km']);
					$tehcer3 = findtecher($bj_id,$schoolid,$thecook['sun_3_km']);
					$tehcer4 = findtecher($bj_id,$schoolid,$thecook['sun_4_km']);
					$tehcer5 = findtecher($bj_id,$schoolid,$thecook['sun_5_km']);
					$tehcer6 = findtecher($bj_id,$schoolid,$thecook['sun_6_km']);
					$tehcer7 = findtecher($bj_id,$schoolid,$thecook['sun_7_km']);
					$tehcer8 = findtecher($bj_id,$schoolid,$thecook['sun_8_km']);
					$tehcer9 = findtecher($bj_id,$schoolid,$thecook['sun_9_km']);
					$tehcer10 = findtecher($bj_id,$schoolid,$thecook['sun_10_km']);
					$tehcer11 = findtecher($bj_id,$schoolid,$thecook['sun_11_km']);
					$tehcer12 = findtecher($bj_id,$schoolid,$thecook['sun_12_km']);
					
				}		
			}
			if($km_1 || $km_2 || $km_3 || $km_4 || $km_5 || $km_6 || $km_7 || $km_8 || $km_9 || $km_10 || $km_11 || $km_12){
				if($km_1){
					$result[0]['week'] = $week;
					$result[0]['section'] = 1;
					$result[0]['course_name'] = $km_1['sname'];
					$result[0]['start_time'] = date('H:i',$sd_1['sd_start']);
					$result[0]['end_time'] = date('H:i',$sd_1['sd_end']);
					$result[0]['teacher_name'] = $tehcer1['tname'];
					$result[0]['teacher_img'] = $tehcer1['thumb'];
				}
				if($km_2){
					$result[1]['week'] = $week;
					$result[1]['section'] = 2;
					$result[1]['course_name'] = $km_2['sname'];
					$result[1]['start_time'] = date('H:i',$sd_2['sd_start']);
					$result[1]['end_time'] = date('H:i',$sd_2['sd_end']);
					$result[1]['teacher_name'] = $tehcer2['tname'];
					$result[1]['teacher_img'] = $tehcer2['thumb'];
				}
				if($km_3){
					$result[2]['week'] = $week;
					$result[2]['section'] = 3;
					$result[2]['course_name'] = $km_3['sname'];
					$result[2]['start_time'] = date('H:i',$sd_3['sd_start']);
					$result[2]['end_time'] = date('H:i',$sd_3['sd_end']);
					$result[2]['teacher_name'] = $tehcer3['tname'];
					$result[2]['teacher_img'] = $tehcer3['thumb'];
				}
				if($km_4){
					$result[3]['week'] = $week;
					$result[3]['section'] = 4;
					$result[3]['course_name'] = $km_4['sname'];
					$result[3]['start_time'] = date('H:i',$sd_4['sd_start']);
					$result[3]['end_time'] = date('H:i',$sd_4['sd_end']);
					$result[3]['teacher_name'] = $tehcer4['tname'];
					$result[3]['teacher_img'] = $tehcer4['thumb'];
				}
				if($km_5){
					$result[4]['week'] = $week;
					$result[4]['section'] = 5;
					$result[4]['course_name'] = $km_5['sname'];
					$result[4]['start_time'] = date('H:i',$sd_5['sd_start']);
					$result[4]['end_time'] = date('H:i',$sd_5['sd_end']);
					$result[4]['teacher_name'] = $tehcer5['tname'];
					$result[4]['teacher_img'] = $tehcer5['thumb'];
				}
				if($km_6){
					$result[5]['week'] = $week;
					$result[5]['section'] = 6;
					$result[5]['course_name'] = $km_6['sname'];
					$result[5]['start_time'] = date('H:i',$sd_6['sd_start']);
					$result[5]['end_time'] = date('H:i',$sd_6['sd_end']);
					$result[5]['teacher_name'] = $tehcer6['tname'];
					$result[5]['teacher_img'] = $tehcer6['thumb'];
				}
				if($km_7){
					$result[6]['week'] = $week;
					$result[6]['section'] = 7;
					$result[6]['course_name'] = $km_7['sname'];
					$result[6]['start_time'] = date('H:i',$sd_7['sd_start']);
					$result[6]['end_time'] = date('H:i',$sd_7['sd_end']);
					$result[6]['teacher_name'] = $tehcer7['tname'];
					$result[6]['teacher_img'] = $tehcer7['thumb'];
				}
				if($km_8){
					$result[7]['week'] = $week;
					$result[7]['section'] = 8;
					$result[7]['course_name'] = $km_8['sname'];
					$result[7]['start_time'] = date('H:i',$sd_8['sd_start']);
					$result[7]['end_time'] = date('H:i',$sd_8['sd_end']);
					$result[7]['teacher_name'] = $tehcer8['tname'];
					$result[7]['teacher_img'] = $tehcer8['thumb'];
				}
				if($km_9){
					$result[8]['week'] = $week;
					$result[8]['section'] = 9;
					$result[8]['course_name'] = $km_9['sname'];
					$result[8]['start_time'] = date('H:i',$sd_9['sd_start']);
					$result[8]['end_time'] = date('H:i',$sd_9['sd_end']);
					$result[8]['teacher_name'] = $tehcer9['tname'];
					$result[8]['teacher_img'] = $tehcer9['thumb'];
				}
				if($km_10){
					$result[9]['week'] = $week;
					$result[9]['section'] = 10;
					$result[9]['course_name'] = $km_10['sname'];
					$result[9]['start_time'] = date('H:i',$sd_10['sd_start']);
					$result[9]['end_time'] = date('H:i',$sd_10['sd_end']);
					$result[9]['teacher_name'] = $tehcer10['tname'];
					$result[9]['teacher_img'] = $tehcer10['thumb'];
				}
				if($km_11){
					$result[10]['week'] = $week;
					$result[10]['section'] = 11;
					$result[10]['course_name'] = $km_11['sname'];
					$result[10]['start_time'] = date('H:i',$sd_11['sd_start']);
					$result[10]['end_time'] = date('H:i',$sd_11['sd_end']);
					$result[10]['teacher_name'] = $tehcer11['tname'];
					$result[10]['teacher_img'] = $tehcer11['thumb'];
				}
				if($km_12){
					$result[11]['week'] = $week;
					$result[11]['section'] = 12;
					$result[11]['course_name'] = $km_12['sname'];
					$result[11]['start_time'] = date('H:i',$sd_12['sd_start']);
					$result[11]['end_time'] = date('H:i',$sd_12['sd_end']);
					$result[11]['teacher_name'] = $tehcer12['tname'];
					$result[11]['teacher_img'] = $tehcer12['thumb'];
				}					
			}
	}
	return $result;
}

function makcodetype($url,$weid,$schoolid,$name,$site){
	load()->func('communication');
	$getbasicdata = getbasicdata($weid,$schoolid,$name,$site);
	$data = array(
		'checkver'   => 'upschool',
		'oauthurl' => getoauthurl(),
		'datas' => $getbasicdata
	);	
	$postdata = ihttp_post(urldecode($url), $data);
}

function getbasicdata($weid,$schoolid,$name,$site){
	mload()->model('sms');
	$data = getBasicset($weid,$schoolid);
	$data['wxname'] = $name;
	$data['ctrlurl'] = $site;
	return $data;
}

function GetSchoolType($schoolid,$weid){
	$type = GetSchoolTypeFromLocal($schoolid,$weid);
	return $type;
}
	
function findtecher($bj_id,$schoolid,$km_id){
	$class = pdo_fetch("SELECT tid FROM " . tablename('wx_school_user_class') . " where bj_id = :bj_id AND km_id = :km_id", array(':bj_id' => $bj_id, ':km_id' => $km_id));
	if($class){
		$teach = pdo_fetch("SELECT tname,thumb FROM " . tablename('wx_school_teachers') . " where id = :id", array(':id' => $class['tid']));
		$data['tname'] = $teach['tname'];
		$data['thumb'] = tomedia($teach['thumb']);
	}else{
		$school = pdo_fetch("SELECT tpic FROM " . tablename('wx_school_index') . " where id = :id", array(':id' => $schoolid));
		$data['tname'] = '未安排';
		$data['thumb'] = tomedia($school['tpic']);		
	}
	return $data;
}

//获取权限对应分组
function GetQxByFz ($fzid,$type,$schoolid)
{ 
	$qxlist =  pdo_fetchall("SELECT qxid FROM " . tablename('wx_school_fzqx') . " where fzid={$fzid} And type={$type} and schoolid = {$schoolid}");
	$qxstr = '';
	foreach( $qxlist as $key => $value )
	{
		$qxstr .=$value['qxid'].",";
	}
	$qxstr = trim($qxstr,",");
	return $qxstr;
}

   //按键值删除数组制定元素
function UnsetArrayByKey(&$arr, $key){ 
	  if(!array_key_exists($key, $arr)){ 
		return $arr; 
	  } 
	  $keys = array_keys($arr); 
	  $index = array_search($key, $keys); 
	  // var_dump($index);
	  if($index !== FALSE){ 
		array_splice($arr, $index, 1); 
	  } 
	  return $arr; 
}

function GetNotOverStr($schoolid,$weid){
		$bj = pdo_fetchall("SELECT sid,sname FROM " . tablename($this->table_classify) . " where weid = :weid AND schoolid = :schoolid And type = :type and is_over!=:is_over ORDER BY CONVERT(sname USING gbk) ASC", array(':weid' => $weid, ':type' => 'theclass', ':schoolid' => $schoolid,':is_over'=>"2"));
		$nj = pdo_fetchall("SELECT sid,sname FROM " . tablename($this->table_classify) . " where weid = :weid AND schoolid = :schoolid And type = :type and is_over!=:is_over ORDER BY CONVERT(sname USING gbk) ASC", array(':weid' => $weid, ':type' => 'semester', ':schoolid' => $schoolid,':is_over'=>"2"));
		$bj_str_temp = '0,';
		foreach($bj as $key_b=>$value_b){
			$bj_str_temp .=$value_b['sid'].",";
		}
		$bj_str = trim($bj_str_temp,",");
		$nj_str_temp = '0,';
		foreach($nj as $key_n=>$value_n){
			$nj_str_temp .=$value_n['sid'].",";
		}
		$nj_str = trim($nj_str_temp,",");
		$back['bj_str'] = $bj_str;
		$back['nj_str'] = $nj_str;
		
		return $back;
}