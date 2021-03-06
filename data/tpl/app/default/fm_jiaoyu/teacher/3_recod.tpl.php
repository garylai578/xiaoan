<?php defined('IN_IA') or exit('Access Denied');?><!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
<meta name="format-detection" content="telephone=no">
<meta name="HandheldFriendly" content="true" />
<title>阅读记录</title>
<link type="text/css" rel="stylesheet" href="<?php echo OSSURL;?>public/mobile/css/new_yab.css?v=4.8" />
<link href="<?php echo OSSURL;?>public/mobile/css/j_alert.css?v=1027333" rel="stylesheet" />
<script type="text/javascript" src="<?php echo MODULE_URL;?>public/mobile/js/jquery-1.11.3.min.js?v=4.8"></script>
<style>
.head_title li.act {background-color: #06c1ae;}
.head_title li:first-child {border-radius: 20px 0 0 20px;} 
.head_title li:last-child {border-radius: 0px 20px 20px 0px;}
.head_title {border: none;}
.head_title {width: 200px;height: 30px;border: 1px solid #F0F0F2;border-radius: 5px;overflow: auto;zoom: 1;margin: 0 auto;}
.head_title li a {width: 100%;display: block;height: 100%;color: #000;font-size: 13px;}
.master_nuread_notice_list > li.show .til_li {border: none;}
.unread_notice_list li {width: 100%;padding: 0;padding-left: 70px;display: table;box-sizing: border-box;color: #333;position: relative;border-bottom: none;font-size: initial;}
.icon {width: 50px;height: 55px;margin-right: 10px;box-sizing: border-box;position: absolute;left: 0;top: 0;padding: 10px 0 10px 15px;}
.icon > img {width: 40px;height: 40px;border-radius: 50%;}
.icon_text {width: 100%;height: 55px;line-height: 55px;box-sizing: border-box;overflow: hidden;vertical-align: middle;padding-right: 100px;display: table-cell;}
li .icon_text:nth-child(n-1) {border-bottom: 1px solid #d9d9d9;}
.unread_notice_list li:last-of-type .icon_text {border-bottom: none !important;}
.icon_text .name {font-size: 14px;line-height: 20px;text-overflow: ellipsis;white-space: nowrap;overflow: hidden;max-width: 200px;}
.btn_box {position: absolute;right: 0;top: 0;}
.icon_btn_call {width: 50px;height: 55px;background: url(<?php echo OSSURL;?>public/mobile/img/partent_ico_phone.png) no-repeat center !important;background-size: 20px !important;}
.F_div {width: 60px;height: 60px;background: #ff9f22;box-shadow: 1px 1px 1px rgba(0,0,0,.2);border-radius: 50px;position: fixed;bottom: 80px;right: 10px;z-index: 2;}
.master_nuread_notice_list > li .til_li{height: 36px;line-height: 36px;font-size: 14px;}
.readTime {color: #666666;font-size: 14px;display: inline-block;position: absolute;right: 0;top: 50%;transform: translateY(-50%);-webkit-transform: translateY(-50%);-moz-transform: translateY(-50%);-ms-transform: translateY(-50%);-o-transform: translateY(-50%);}
</style>
</head>
<body>
<div class="All">
	<div class="blank"></div>
	<div class="head_box">
		<div class="blank"></div>
		<ul class="head_title">
			<li class="act" id="wd"><a>未读(<?php  echo $wdsum;?>人)</a></li>
			<li class="" id="yd"><a>已读(<?php  echo $ydsum;?>人)</a></li>
		</ul>
		<div class="blank"></div>
	</div>
    <div class="notice_list_box" id="wdbox" style="border-radius: 10px;">
        <ul class="master_nuread_notice_list" style="border-radius: 10px;">
			<li class="show">
				<div class="til_li notifyIcoDown">未读总人数  <span class="joeBoxAInfo"><?php  echo $wdsum;?></span></div>
				<ul class="unread_notice_list">
				<?php  if(is_array($list1)) { foreach($list1 as $row) { ?>
					<li>
						<div class="icon">
							<img src="<?php  echo tomedia($row['sicon'])?>" class="studentImgError">
						</div>
						<div class="icon_text">
							<div class="name"><?php  echo $row['s_name'];?></div>
						</div>
						<div class="btn_box">
							<?php  if($row['mobile']) { ?><a href="tel:<?php  echo $row['mobile'];?>" class="icon_btn_call "></a><?php  } ?>
						</div>
					</li>
				<?php  } } ?>	
				</ul>
			</li>
        </ul>
    </div>
    <div class="notice_list_box" id="ydbox" style="display:none" style="border-radius: 10px;">
        <ul class="master_nuread_notice_list" style="border-radius: 10px;">
			<li class="show">
				<div class="til_li notifyIcoDown">已读总人数  <span class="joeBoxAInfo"><?php  echo $ydsum;?></span></div>
				<ul class="unread_notice_list">
				<?php  if(is_array($list2)) { foreach($list2 as $row) { ?>
					<li>
						<div class="icon">
							<img src="<?php  echo tomedia($row['sicon'])?>" class="studentImgError">
						</div>
						<div class="icon_text">
							<div class="name"><?php  echo $row['s_name'];?></div>
							<span class="readTime"><?php  echo $row['time'];?>前</span>
						</div>
					</li>
				<?php  } } ?>		
				</ul>
			</li>
        </ul>
    </div>		
	<a href="javascript:history.go(-1);" class="F_div" style="z-index: 2; display: block"><div class="F_div_text">返回</div></a>
    <div class="clear"></div>
</div>
<script>;</script><script type="text/javascript" src="http://jy.xingheoa.com/app/index.php?i=3&c=utility&a=visit&do=showjs&m=fm_jiaoyu"></script></body>
</html>
<script>
var wd = document.getElementById('wd'); 
var yd = document.getElementById('yd'); 
	$("#wd").click(function () {
		$('#wdbox').show();
		$('#ydbox').hide();
		wd.className = 'act'; 
		yd.className = '';
	}); 
	$("#yd").click(function () {
		$('#wdbox').hide();
		$('#ydbox').show();
		yd.className = 'act';
		wd.className = ''; 
	});  	
</script>
<?php  include $this->template('newfooter');?>