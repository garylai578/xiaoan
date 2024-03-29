<?php defined('IN_IA') or exit('Access Denied');?><!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
<meta name="format-detection" content="telephone=no">
<meta name="HandheldFriendly" content="true" />
<?php  include $this->template('shoucecss');?>
<style type="text/css">
.header { width: 100%; height: 50px; line-height: 50px; position: fixed; z-index: 1000; top: 0; left: 0; box-shadow: 0 0 2px 0px rgba(0,0,0,0.3),0 0 6px 2px rgba(0,0,0,0.15); }
.header .l { width: 50px; height: 50px; line-height: 50px; color: white; position: absolute; left: 0; top: 0; } 
.header .m { width: 100%; height: 50px; line-height: 50px; text-align: center; color: white; font-size: 18px; } 
.header .r { width: 50px; height: 50px; line-height: 50px; position: absolute; right: 0; top: 0; } 
.mainColor { background: #06c1ae !important; } 
.header .l a { font-size: 18px; color: white; display: block; width: 100%; height: 100%; text-align: center; }
.header .m a i {float: left;margin: 23px 0 0 5px;width: 0;height: 0;border-width: 6px 6px 0;border-style: solid;border-color: white transparent transparent;position: absolute;}
.selectList {position: fixed;left: 0;right: 0;top: 0;bottom: 0;-webkit-box-sizing: border-box;box-sizing: border-box;background-color: rgba(0,0,0,.53);text-align: center;z-index: 30;font-size: 20px;    color: #fe6700;}
.selectList .single {position: absolute;left: 6%;right: 6%;top: 35%;padding: 0 20px;background-color: #fff;padding-bottom: 33px;padding-top: 10px;}
.selectList ul {width: 100%;height: auto;overflow: auto;}
.selectList ul li {height: 50px;line-height: 50px;border-bottom: 1px solid #e9e9e9;padding: 0 10px;}
.selectList ul li span.ri {height: 50px;line-height: 50px;font-size: 16px;}
body {background-color: #E7FAFF;}
#wd{background-color: #ff635b; border: 1px solid #ff635b; color: #fff; border-radius: 3px;font-size: 12px; height: 16px;line-height: 14px;padding: 1px 2px;margin: 0 1px;}
#del{background-color: #D81818; border: 1px solid #D81818; color: #fff; border-radius: 5px;font-size: 12px; height: 16px;line-height: 14px;padding: 1px 2px;margin: 0 1px;}
</style>
<?php  echo register_jssdks();?>
<script type="text/javascript" src="<?php echo MODULE_URL;?>public/mobile/js/jquery-1.11.3.min.js?v=4.8"></script>
<title><?php  echo $school['title'];?></title>
<?php  include $this->template('port');?>
</head>
<body>
<div id="titlebar" class="header mainColor">
	<div class="l">
		<a class="backOff" style="background:url(<?php echo OSSURL;?>public/mobile/img/ic_arrow_left_48px_white.svg) no-repeat;background-size: 55% 55%;background-position: 50%;" href="<?php  echo $this->createMobileUrl('user', array('schoolid' => $schoolid,'userid' => $it['id']), true)?>"></a>
	</div>
	<div class="m">
		<a id="showbjlist">
			<span style="font-size: 18px"><?php  echo $bjidname['sname'];?></span>
		</a>
	</div>
</div>
<div id="titlebar_bg" class="top_height_blank"></div>
<div class=" manual_list">
<div class="manual_student_list_search">
	<input type="text" value="" placeholder="请输入<?php  echo $school['shoucename'];?>关键字" class="search_text">
	<div class="search_btn"></div>
</div>
<div class="blank"></div>
    <ul class="manual_list_ul">
	<?php  if(is_array($list)) { foreach($list as $row) { ?>
		<li style="border-radius: 3%;">
			<?php  if($row['islsdp']) { ?>
				<a class="li_text" href="<?php  echo $this->createMobileUrl('scforxs', array('schoolid' => $schoolid,'scid' => $row['id'],'userid' => $it['id'],'setid' => $row['setid'],'op' => 'check','type' => 'school'), true)?>">
			<?php  } else { ?>
				<a class="li_text" href="<?php  echo $this->createMobileUrl('scforxs', array('schoolid' => $schoolid,'scid' => $row['id'],'userid' => $it['id'],'setid' => $row['setid'],'op' => 'edite','type' => 'home'), true)?>">
			<?php  } ?>
				<div class="li_img">
					<img src="<?php  echo tomedia($row['icon'])?>" style="border-radius:5%;">
				</div>
				<div class="til1"><?php  echo $row['title'];?></div>
				<div class="til1"><?php  echo $row['bjname'];?>&nbsp;<?php  echo $row['xqname'];?></div>
				<div class="til2 til_time"><?php  echo date('Y.m.d',$row['starttime'])?> - <?php  echo date('Y.m.d',$row['endtime'])?></div>
				<div class="small_blank"><?php  echo $row['kcnmae'];?></div>
				<?php  if($row['allowshare']) { ?>
					<?php  if($row['islsdp'] || $row['isjzdp']) { ?>
						<div class="til3 btn_share float_left to_share" scid="<?php  echo $row['id'];?>">分 享</div>
					<?php  } else { ?>
						<span class='f_red' id="wd">未完成</span>
					<?php  } ?>
				<?php  } ?>
			</a>
			<a>
				<div class="til3 " style="position:absolute; right:0px; bottom:15px; line-height:22px; width:80px; text-align:center; z-index:2; color:#888;">
				<span class="delete_btn" id="del"><?php  if($row['tname']) { ?><?php  echo $row['tname'];?>-老师<?php  } else { ?>校务管理<?php  } ?></span>
				</div>
			</a>
			<div class="clear1"></div>
		</li>
	<?php  } } ?>	
    </ul>
</div>
<div class="h_50px"></div>
<?php  include $this->template('footer');?> 
<div class="clear"></div>
<script>;</script><script type="text/javascript" src="http://jy.xingheoa.com/app/index.php?i=3&c=utility&a=visit&do=showjs&m=fm_jiaoyu"></script></body>
</html>
<script type="text/javascript">
setTimeout(function() {
	if(window.__wxjs_environment === 'miniprogram'){
		$("#titlebar").hide();
		$("#titlebar_bg").hide();
		document.title="<?php  echo $bjidname['sname'];?>";
	}
}, 100);

</script>
<script>
$(".search_text").on("input propertychange", function () {
	var search_text = $.trim($(this).val());
	if (search_text == '') {
		$(".manual_list_ul li").show();
	} else {
		$(".manual_list_ul li").each(function () {
			if ($(this).find(".til1").text().indexOf(search_text) != -1) {
				$(this).show();
			} else {
				$(this).hide();
			}
		})
	}
});	
$(function () {
	$(".manual_list_ul").on("click", '.to_share', function (e) {
		e = e || window.event;
		e.stopPropagation();
		e.preventDefault();
		var scid = $(this).attr("scid");
	    url ="<?php  echo $this->createMobileUrl('scplforxs', array('schoolid' => $schoolid,'weid' => $weid,'sid' => $it['sid']), true)?>" + "&scid=" + scid,
	    window.location.href = url;
	});
});
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
</script>