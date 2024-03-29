<?php defined('IN_IA') or exit('Access Denied');?><!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
<meta name="format-detection" content="telephone=no">
<meta name="HandheldFriendly" content="true" />
<script type="text/javascript" src="<?php echo OSSURL;?>public/mobile/js/hb.js??v=1027"></script>
<link href="<?php echo OSSURL;?>public/mobile/css/j_alert.css?v=102720160929" rel="stylesheet" />
<link href="<?php echo OSSURL;?>public/mobile/css/new_yab1.css?v=102720161027" rel="stylesheet" />
<link href="<?php echo OSSURL;?>public/mobile/css/countCss.css?v=062220160928" rel="stylesheet" charset="gb2312" />
<?php  echo register_jssdks();?>
<script type="text/javascript" src="<?php echo MODULE_URL;?>public/mobile/js/jquery-1.11.3.min.js?v=4.8"></script>
<title><?php  echo $school['title'];?></title>
</head>
<body>
<div class="All">
	<div class="top" style="background: #12d0bc;">
		<div class="float_left top_head_img">
			<img src="<?php  if($student['icon']) { ?><?php  echo tomedia($student['icon'])?><?php  } else { ?><?php  echo tomedia($school['spic'])?><?php  } ?>" height="45" width="45" class="teacherImgError"/>
		</div>
		<div class="float_left top_head_name" style="overflow: unset;">
			<?php  echo $student['s_name'];?><span> <?php  echo $class['sname'];?></span>
		</div>
	</div>
	<style>
	.main {margin: 10px 10px 2px 10px;box-shadow: 0px 0px 0px rgba(0,0,0,.3);padding: 0;border-radius: 10px;}
	.common_tips_bottom {height: 44px;line-height: 44px;font-size: 16px;color: #333333;}
	.common_blue_tag {color: white;background-color: #06c1ae;border-radius: 20px;float: right;margin-right: 10px;}
	.common_tips_bottom {padding: 0 10px;}
	.main img {margin: 0;}
	.imgItemDetails {margin-bottom: 5px;}
	.imgItemBox {margin: 15px 10px;padding-bottom: 15px;}
	.common_tips_bottom {padding: 0 10px 0 20px;}
	.main {padding-bottom: 10px;}
	.common_no_audit_status {background-color: inherit;}
	.tongzhi {position: relative}
	.tongzhiDetails {position: relative;padding: 10px;}
	.tongzhiTitleDetails {color: #333333;font-size: 14px;font-weight: bold;display: inline-block;padding-right: 50px;}
	.btnEditOtherBox {right: 10px;top: 20px;}
	.common_no_audit_status {margin-left: 0;display: inline-block;}
	</style>
	<div class="top_head_blank"></div>
    <div class="listcontent" style="margin-bottom:5px">
        <div class="main">
            <div class="tongzhiDetails">
                <div class="tongzhiTitleDetails"><?php  echo $language['xsqddk'];?></div>
				<span class="common_no_audit_status">（<?php  echo $mac['name'];?>）</span>
            </div>
            <div class="cutting"></div>
            <div class="notifyTopBox">
                <div class="notifyTopLeft">
                    <img src="<?php  if($student['icon']) { ?><?php  echo tomedia($student['icon'])?><?php  } else { ?><?php  echo tomedia($school['spic'])?><?php  } ?>" class="teacherImgError"/>
                </div>
                <div class="notifyTopRight">
                    <div class="notifyTopRightTopBox">
                        <span class="teacherInfo">刷卡人：<?php  echo $student['s_name'];?> <?php  echo(getpard($log['pard']))?></span>
                        <div class="JobTeacherBox"><?php  if($log['leixing'] == 1) { ?>进校<?php  } ?><?php  if($log['leixing'] == 2) { ?>离校<?php  } ?></div>
                    </div>
                    <div class="notifyTopRightTopBox">
					<?php  if($log['temperature']) { ?>
                        <span class="teacherInfo">体温:<?php  echo $log['temperature'];?>℃</span>
					<?php  } else { ?>	
						<span class="teacherInfo">体温:</span>
                        <div class="JobTeacherBox">未测</div>
					<?php  } ?>	
                    </div>					
                    <p class="notifyCreateTime">时间:<?php  echo date('Y/m/d H:i:s',$log['createtime'])?></p>					
                </div>
            </div>
			<div class="imgItemBox" >
				<div class="imgItemDetails" style="width: 100%;">
					<?php  if($log['pic']) { ?><a onclick="wxImageShow(this);"><img src="<?php  echo tomedia($log['pic'])?>" width="100%"/></a><?php  } ?>
					<?php  if($log['pic2']) { ?><a onclick="wxImageShow(this);"><img src="<?php  echo tomedia($log['pic2'])?>" width="100%"/></a><?php  } ?>
				</div>
			</div>		
        </div>
		<div class="footerBoxForIndex" style="margin-bottom:55px;">
			<p class="footerBoxBox">查看所有考勤记录</p>&nbsp;&nbsp;<a href="javascript:;" class="queryDetails">查看详情</a>
		</div>			
    </div>
<script>;</script><script type="text/javascript" src="http://jy.xingheoa.com/app/index.php?i=3&c=utility&a=visit&do=showjs&m=fm_jiaoyu"></script></body>
</html>
<script>
$(function() {
	$(".queryDetails").on("click", function () {
		location.href = "<?php  echo $this->createMobileUrl('calendar', array('schoolid' => $schoolid), true)?>";
	})
    WeixinJSHideAllNonBaseMenuItem();
		
});
function WeixinJSHideAllNonBaseMenuItem(){
	if (typeof wx != "undefined"){
		wx.ready(function () {
			
			wx.hideAllNonBaseMenuItem();
		});
	}
}

var WeixinApi = (function () {
	
	return {
        ready           :wxJsBridgeReady,
        imagePreview    :imagePreview
    }; 
	
    "use strict";

    /**
     * 调起微信Native的图片播放组件。
     * 这里必须对参数进行强检测，如果参数不合法，直接会导致微信客户端crash
     *
     * @param {String} curSrc 当前播放的图片地址
     * @param {Array} srcList 图片地址列表
     */
    function imagePreview(curSrc,srcList) {
        if(!curSrc || !srcList || srcList.length == 0) {
            return;
        }
        WeixinJSBridge.invoke('imagePreview', {
            'current' : curSrc,
            'urls' : srcList
        });
    }
	
    /**
     * 当页面加载完毕后执行，使用方法：
     * WeixinApi.ready(function(Api){
     *     // 从这里只用Api即是WeixinApi
     * });
     * @param readyCallback
     */
    function wxJsBridgeReady(readyCallback) {
        if (readyCallback && typeof readyCallback == 'function') {
            var Api = this;
            var wxReadyFunc = function () {
                readyCallback(Api);
            };
            if (typeof window.WeixinJSBridge == "undefined"){
                if (document.addEventListener) {
                    document.addEventListener('WeixinJSBridgeReady', wxReadyFunc, false);
                } else if (document.attachEvent) {
                    document.attachEvent('WeixinJSBridgeReady', wxReadyFunc);
                    document.attachEvent('onWeixinJSBridgeReady', wxReadyFunc);
                }
            }else{
                wxReadyFunc();
            }
        }
    }

    return {
        version         :"2.5",
        ready           :wxJsBridgeReady,
        imagePreview    :imagePreview
    };
})();
var ALI_URL = "<?php  echo $urls;?>";
var ALI_URL_VIEDO = "<?php  echo $urls;?>";
function wxImageShow(node){
	var srcList = new Array();
	var watermark='';
	var imgs = $(node).closest('.listcontent').find("img");	
	var curSrc = $(node).find("img")[0]['src'].split("@");
	//alert(curSrc);
	var curImgIndex=0;
	for(i=0;i<imgs.length;i++){
		var imgsrc = imgs[i]['src'].split("@");
		if(imgsrc.length>1){
			if(imgsrc[1].split("watermark").length>1){
				srcList.push(imgsrc[0].replace(ALI_URL,ALI_URL_VIEDO)+'@watermark'+imgsrc[1].split("watermark")[1]);
				watermark = '@watermark'+imgsrc[1].split("watermark")[1];
			}else{
				srcList.push(imgsrc[0].replace(ALI_URL,ALI_URL_VIEDO));
			}
		}else{
			srcList.push(imgsrc[0]);
		}
		if(curSrc[0]==imgsrc[0]){
			curImgIndex=i;
		}
	}
	curSrc[0]=curSrc[0]+watermark;

	WeixinApi.imagePreview(curSrc[0].replace(ALI_URL,ALI_URL_VIEDO), srcList);
}
</script>
<?php  include $this->template('comad');?>
<?php  include $this->template('footer');?>