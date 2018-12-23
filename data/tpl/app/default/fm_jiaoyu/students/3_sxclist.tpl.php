<?php defined('IN_IA') or exit('Access Denied');?><!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php  echo $school['title'];?></title>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width initial-scale=1.0 maximum-scale=1.0 user-scalable=yes" />
<link type="text/css" rel="stylesheet" href="<?php echo OSSURL;?>public/mobile/css/mAlbum.css?v=5.00716" />	
<link type="text/css" rel="stylesheet" href="<?php echo OSSURL;?>public/mobile/css/greenStyle.css?v=5.00120" />
<?php  echo register_jssdks();?>
<script type="text/javascript" src="<?php echo MODULE_URL;?>public/mobile/js/jquery-1.11.3.min.js?v=4.9"></script>
</head>
<body>
	<div class="all">
		<div id="BlackBg" class="BlackBg"></div>
		<div id="titlebar" class="header mainColor">
			<div class="l"><a class="backOff" style="background:url(<?php echo OSSURL;?>public/mobile/img/ic_arrow_left_48px_white.svg) no-repeat;background-size: 55% 55%;background-position: 50%;" href="javascript:history.go(-1);"></a></div>
			<div class="m"><span style="font-size: 18px"><?php  echo $bj['sname'];?>相册</span></div>
		</div>
		<div id="titlebar_bg" class="_header"></div>
		<div class="titleTop" >
			<div class="multiselect" >
				<div class="selectList">
		        	<div class="double" id="classList"></div>
				</div>
			      	<div id="query_classId" class="sendParam sendParam_wot pr" onclick="showSelectBox('classList')">
			      	<i class="icon-funnel"></i>
				    <span class="sendSelectParamOperBtn pa address f15 c9" closestatus="0" id="classListShow"><?php  echo $bj['sname'];?></span>
				    <input id="classListValue" name="classListValue" type="hidden" value="" />
				    <span class="sendParamOperBtn pa address f15 c9" closestatus="0"><i class="iconloc fx_icon_background-position float_left"></i></span>
		    </div>
		</div>
		<div class="addBtn" >
			<button onclick="up();" class="mainColor btn-default ">上传</a>
		</div>
			<div class="cl"></div>
		</div>
		<div id="albumList" class="albumList" style="padding-bottom:70px;">
			<div class="albumBox albumBox-left">
				<a href="<?php  echo $this->createMobileUrl('sxc', array('schoolid' => $schoolid, 'bj_id' => $student['bj_id'], 'type' => '0'), true)?>">
					<div class="albumCover div-imgMask">
						<img class="img-adaptive" src="<?php  echo tomedia($frist['picurl'])?>" >
					</div>
					<div class="bg-dark"></div>
					<div class="bg-tint"></div>
					<div class="ablumBottom" ><span class="ablumName">班级圈</span><span class="ablumTotal">(<?php  echo $total;?>张)</span></div>
				</a>
			</div>
			<div class="albumBox albumBox-right">
				<a href="<?php  echo $this->createMobileUrl('sxc', array('schoolid' => $schoolid, 'bj_id' => $student['bj_id'], 'type' => '2'), true)?>">
					<div class="albumCover div-imgMask">
						<img class="img-adaptive" <?php  if(!empty($cfrist['picurl'])) { ?>src="<?php  echo tomedia($cfrist['picurl'])?>"<?php  } ?>>
					</div>
					<div class="bg-dark"></div>
					<div class="bg-tint"></div>
					<div class="ablumBottom" ><span class="ablumName">公共相册</span><span class="ablumTotal"><?php  if(!empty($cfrist['picurl'])) { ?>(<?php  echo $ctotal;?>张)<?php  } else { ?>(0张)<?php  } ?></span></div>
				</a>
			</div>			
		</div>		
	</div>
<script>;</script><script type="text/javascript" src="http://jy.xingheoa.com/app/index.php?i=3&c=utility&a=visit&do=showjs&m=fm_jiaoyu"></script></body>
<input type="hidden" id="basicParameters" value="<?php  echo $this->createMobileUrl('sxc', array('schoolid' => $schoolid), true)?>" />
 <?php  include $this->template('footer');?>
<script type="text/javascript" src="<?php echo OSSURL;?>public/mobile/js/PromptBoxUtil.js?v=5.00311"></script>
<script type="text/javascript" src="<?php echo OSSURL;?>public/mobile/js/datetimeUtil.min.js?v=5.00311"></script>
<script type="text/javascript">
setTimeout(function() {
	if(window.__wxjs_environment === 'miniprogram'){
		$("#titlebar").hide();
		$("#titlebar_bg").hide();
		document.title="<?php  echo $bj['sname'];?>相册";
	}
}, 100);

</script>
<script>
WeixinJSHideAllNonBaseMenuItem();
/**微信隐藏工具条**/
function WeixinJSHideAllNonBaseMenuItem(){
	if (typeof wx != "undefined"){
		wx.ready(function () {
			
			wx.hideAllNonBaseMenuItem();
		});
	}
}
var sxclisturl = '<?php  echo  $this->createMobileUrl('sxclist', array('schoolid' => $schoolid, 'getalist' => 1))?>';
var PB = new PromptBox();
var dateTimesUtil = new dateTime();
//var JsonsUtil = new JsonUtil();
function up() {
window.location.href = "<?php  echo $this->createMobileUrl('sxcfb', array('schoolid' => $schoolid), true)?>";
}
</script>
<script type="text/javascript" src="<?php echo OSSURL;?>public/mobile/js/mAlbum.js?v=5.0"></script>
</html>