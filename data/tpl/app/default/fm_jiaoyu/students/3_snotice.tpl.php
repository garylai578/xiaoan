<?php defined('IN_IA') or exit('Access Denied');?><!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php  echo $school['title'];?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width initial-scale=1.0 maximum-scale=1.0 user-scalable=yes" />
<link type="text/css" rel="stylesheet" href="<?php echo OSSURL;?>public/mobile/css/mGrzxTeacher.css?v=4.8" />
<link type="text/css" rel="stylesheet" href="<?php echo OSSURL;?>public/mobile/css/pageContent.css?v=4.80120" />
<link type="text/css" rel="stylesheet" href="<?php echo OSSURL;?>public/mobile/css/greenStyle.css?v=4.80120" />
<link type="text/css" rel="stylesheet" href="<?php echo OSSURL;?>public/mobile/css/activityNotice.css?v=4.80120" />
<?php  echo register_jssdks();?>
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script type="text/javascript" src="<?php echo MODULE_URL;?>public/mobile/js/jquery-1.11.3.min.js?v=4.9"></script>
</head>
<?php  include $this->template('port');?>
<body>
<div id="titlebar" class="header mainColor">
	<div class="l"><a class="backOff" style="background:url(<?php echo OSSURL;?>public/mobile/img/ic_arrow_left_48px_white.svg) no-repeat;background-size: 55% 55%;background-position: 50%;" href="javascript:history.go(-1);"></a></div>
	<div class="m">
     <span style="font-size: 18px">内容详情</span>   
	</div>
	</div>
	
<div id="titlebar_bg" class="_header"></div>
<input type="hidden"  id="hide_sid"  value="<?php  echo $it['sid'];?>">
<input type="hidden"  id="hide_tid"  value="<?php  echo $it['tid'];?>">
<input type="hidden"  id="hide_schoolid"  value="<?php  echo $schoolid;?>">
<input type="hidden"  id="hide_weid"  value="<?php  echo $weid;?>">
		<div class="title"><?php  echo $leave['title'];?></div>		
		<div class="publishInfo">
			<span class="source">发布：<?php  echo $leave['tname'];?></span>
			<span class="time"><?php  echo (date('m-d H:m',$leave['createtime']))?></span>
			<span class="read"></span>			
		</div>
		<div class="content parent">		
			<p id="neirong"><?php  echo htmlspecialchars_decode($leave['content'])?></p><br/>
			<?php  if($leave['video']) { ?>
			<video id="videocon" controls width="100%"  height="264" poster="<?php  echo tomedia($school['logo']);?>" webkit-playsinline playsinline>
				<source src="<?php  echo tomedia($leave['video'])?>" type='video/mp4' />
				<p class="vjs-no-js">你的浏览器不支持该视频</a></p>
			</video>
			<?php  } ?>
			<?php  if($leave['audio']) { ?>
				<div class="app-audio" style="undefinedanimation:undefined;box-sizing: border-box;">
					<div class="inner" style="text-align: left;position: relative;">
						<div id="audio-music-4" data-reload="false" class="wx audioLeft clearfix" data-src="<?php  echo tomedia($leave['audio'])?>">
							<img style="width: 40px;height: 40px;display: inline-block;" alt="语音头像" class="audioLogo" width="40" height="40" src="<?php  if($thisteacher['thumb']) { ?><?php  echo tomedia($thisteacher['thumb'])?><?php  } else { ?><?php  echo tomedia($school['tpic'])?><?php  } ?>">
							<span class="audioBar js-play" style="display: block; margin: 5px 0;width: 185px; height: 42px;display: inline-block;left: 55px; top: 0; background: url(./resource/images/app/sprite_v5.png) 0 0 no-repeat;background-size: 400px 175px;cursor: pointer;">
								<img style="display:none" src="./resource/images/app/player.gif" class="audioAnimation" data-garbage="true">
								<i style="display: block;margin: 12px 15px;width: 13px;height: 17px;left: 21px;top: 12px;z-index: 2;background: url(./resource/images/app/sprite_v5.png) 0 0 no-repeat;background-size: 400px 175px;background-position: -180px -105px;" class="audioStatic"></i>
								<span style="" class="audioLoading" data-garbage="true"><i class="fa fa-spinner fa-pulse"></i></span>
							</span>
							<span style="position: absolute; font-size: 14px;color: #999;left: 250px;bottom: 5px;" class="audio-time"><?php  echo $leave['audiotime'];?>’</span>
							<div class="js-audio-wx" data-id="audio-music-4" id="jp_jplayer_1" style="width: 0px; height: 0px;">
								<img id="jp_poster_1" style="width: 0px; height: 0px; display: none;">
								<audio id="jp_audio_1" autoplay="autoplay" preload="none" src="<?php  echo tomedia($leave['audio'])?>"></audio>
							</div>
						</div>
					</div>
				</div>				
			<?php  } ?>			
			<?php  if(!empty($picarr['p1'])) { ?><a onclick="wxImageShow(this);" ><img src="<?php  echo tomedia($picarr['p1']);?>" alt="" /><a><?php  } ?>
			<?php  if(!empty($picarr['p2'])) { ?></br><a onclick="wxImageShow(this);" ><img src="<?php  echo tomedia($picarr['p2']);?>" alt="" /><a><?php  } ?>
			<?php  if(!empty($picarr['p3'])) { ?></br><a onclick="wxImageShow(this);" ><img src="<?php  echo tomedia($picarr['p3']);?>" alt="" /><a><?php  } ?>
			<?php  if(!empty($picarr['p4'])) { ?></br><a onclick="wxImageShow(this);" ><img src="<?php  echo tomedia($picarr['p4']);?>" alt="" /><a><?php  } ?>
			<?php  if(!empty($picarr['p5'])) { ?></br><a onclick="wxImageShow(this);" ><img src="<?php  echo tomedia($picarr['p5']);?>" alt="" /><a><?php  } ?>
			<?php  if(!empty($picarr['p6'])) { ?></br><a onclick="wxImageShow(this);" ><img src="<?php  echo tomedia($picarr['p6']);?>" alt="" /><a><?php  } ?>
			<?php  if(!empty($picarr['p7'])) { ?></br><a onclick="wxImageShow(this);" ><img src="<?php  echo tomedia($picarr['p7']);?>" alt="" /><a><?php  } ?>
			<?php  if(!empty($picarr['p8'])) { ?></br><a onclick="wxImageShow(this);" ><img src="<?php  echo tomedia($picarr['p8']);?>" alt="" /><a><?php  } ?>
			<?php  if(!empty($picarr['p9'])) { ?></br><a onclick="wxImageShow(this);" ><img src="<?php  echo tomedia($picarr['p9']);?>" alt="" /><a><?php  } ?>
		</div>	
				
		<?php  if(!empty($ZY_contents)) { ?>
		<div class="questionContent">
			<div class="questionBox">
				  <input type="hidden" id="txtQuestionnaireId" value="<?php  echo $leaveid;?>">
					  <?php  if(!empty($testAA)) { ?><span style="color:red;padding-left: 10px;"> 你已经回答过本次问卷，不能再回答交了哦~</span></br></br>
<span style="color:blue;padding-left: 10px;">你的回答：</span>
					  <?php  } ?>
				<?php  if(is_array($ZY_contents)) { foreach($ZY_contents as $key => $row) { ?>
				 
					
					 <?php  if($ZY_contents[$key]['type'] == '1') { ?>
					 
					 <div class="question" name="<?php  echo $ZY_contents[$key]['qorder'];?>" tag="a"> <?php  echo $ZY_contents[$key]['qorder'];?>.&nbsp<?php  echo $ZY_contents[$key]['title'];?>
					 <?php  if(is_array($ZY_contents[$key]['content'])) { foreach($ZY_contents[$key]['content'] as $keys => $rows) { ?>
				
						 <?php  if($testAA[$ZY_contents[$key]['qorder']] == $keys ) { ?>
						 	 <p class="answerOption"><span class="radioOptionsIco" readonly>
						  <img src="<?php echo OSSURL;?>public/mobile/img/radioChecked_01.png" alt="图片无法显示" class="img-unresponsive" readonly>
							  <?php  } else { ?>
							   <p class="answerOption"><span class="radioOptionsIco">
                                        <img src="<?php echo OSSURL;?>public/mobile/img/radioNochecked_02.png" alt="图片无法显示" class="img-responsive">
	                                        <?php  } ?>
                                        <input type="radio" name="answerOption_<?php  echo $ZY_contents[$key]['qorder'];?>" tag="<?php  echo $keys;?>">
                                    </span>
<?php  echo $ZY_contents[$key]['content'][$keys]['title'];?> <?php  if(((!empty($testAA))&&($ZY_contents[$key]['content'][$keys]['is_answer'] == "Yes"))) { ?><span style="color:red;">  【答案】</span><?php  } ?>
                                    
                                    </p>
					<?php  } } ?>
					</div>
					<?php  } else if($ZY_contents[$key]['type'] == '2') { ?>
					<div class="question" name="<?php  echo $ZY_contents[$key]['qorder'];?>" tag="b">
						 <?php  echo $ZY_contents[$key]['qorder'];?>.&nbsp<?php  echo $ZY_contents[$key]['title'];?>
					 <?php  if(is_array($ZY_contents[$key]['content'])) { foreach($ZY_contents[$key]['content'] as $keys => $rows) { ?>


 <p class="answerOption">
					<span class="checkBoxOptionsIco">
						
	<?php  if(in_array($keys, $testAA[$ZY_contents[$key]['qorder']]) ) { ?>
					 <img src="<?php echo OSSURL;?>public/mobile/img/checkBoxChecked_01.png" alt="图片无法显示" class="img-responsive">
				<?php  } else { ?>
									<img src="<?php echo OSSURL;?>public/mobile/img/checkBoxNochecked_02.png" alt="图片无法显示" class="img-responsive">	<?php  } ?>
										
									<input type="checkbox" name="answerOption_<?php  echo $ZY_contents[$key]['qorder'];?>" tag="<?php  echo $keys;?>">
								</span>
<?php  echo $ZY_contents[$key]['content'][$keys]['title'];?><?php  if(((!empty($testAA))&&($ZY_contents[$key]['content'][$keys]['is_answer'] == "Yes"))) { ?><span style="color:red;">  【答案】</span><?php  } ?>

				</p>
				
				<?php  } } ?>
				</div>
					<?php  } else if($ZY_contents[$key]['type'] == '3') { ?>
					<div class="question" name="<?php  echo $ZY_contents[$key]['qorder'];?>" tag="c">
						 <?php  echo $ZY_contents[$key]['qorder'];?>.&nbsp<?php  echo $ZY_contents[$key]['title'];?>
					<p class="answerOption">
					<?php  if(!empty($testAA[$ZY_contents[$key]['qorder']]) ) { ?>
							<textarea name="txtAnswerOption" cols="3" rows="4" placeholder="<?php  echo $testAA[$ZY_contents[$key]['qorder']];?>" tag="b65f7ee0-2b6c-4e75-935c-2a56aa88d400" disabled ></textarea>
							<?php  } else { ?>
							<textarea name="txtAnswerOption" cols="3" rows="4" placeholder="请回答。。。。。。" tag="b65f7ee0-2b6c-4e75-935c-2a56aa88d400" ></textarea>
							<?php  } ?>
						</p>
					</div>
					<?php  } ?>
					
					 
					 <?php  } } ?>
					 <?php  if(empty($testAA)) { ?>
					 <button type="button" id="btSubmit">提交</button>
					 <?php  } ?>
				</div>
				</div>
				<?php  } ?>	
<?php  include $this->template('comad');?>
<script>;</script><script type="text/javascript" src="http://jy.xingheoa.com/app/index.php?i=3&c=utility&a=visit&do=showjs&m=fm_jiaoyu"></script></body>
<?php  include $this->template('footer');?>
<script src="<?php echo OSSURL;?>public/mobile/js/faceMap.js?v=5.61" type="text/javascript"></script>
<?php  include $this->template('port');?>
<script type="text/javascript">
setTimeout(function() {
	if(window.__wxjs_environment === 'miniprogram'){
		$("#titlebar").hide();
		$("#titlebar_bg").hide();
		document.title="通知详情";
	}
}, 100);

</script>
<?php  if(empty($testAA)) { ?>
<script>
	var hasSubmit = 'False';
	var hasObject = 'True';

	$(".radioOptionsIco").click(function () {
		var value = $(this).children("img").attr("src");
		if (value == "<?php echo OSSURL;?>public/mobile/img/radioChecked_01.png") {
			$(this).children("img").attr("src", "<?php echo OSSURL;?>public/mobile/img/radioNochecked_02.png");
			$(this).children("input").removeAttr("checked");
		} else {
			$(this).children("img").attr("src", "<?php echo OSSURL;?>public/mobile/img/radioChecked_01.png");
			$(this).children("input").attr("checked", "checked");
			$(this).parent().siblings(".answerOption").find(".radioOptionsIco").children("img").attr("src", "<?php echo OSSURL;?>public/mobile/img/radioNochecked_02.png");
			$(this).parent().siblings(".answerOption").find(".radioOptionsIco").children("input").removeAttr("checked");
		}
	})
	$(".checkBoxOptionsIco").click(function() {
		var value = $(this).children("img").attr("src");
		if (value == "<?php echo OSSURL;?>public/mobile/img/checkBoxChecked_01.png") {
			$(this).children("img").attr("src", "<?php echo OSSURL;?>public/mobile/img/checkBoxNochecked_02.png");
			$(this).children("input").removeAttr("checked");
		} else {
			$(this).children("img").attr("src", "<?php echo OSSURL;?>public/mobile/img/checkBoxChecked_01.png");
			$(this).children("input").attr("checked", "checked");
		}
	});

	$(".btnTrue").click(function () {
		$(".popUpBox").css("display", "none");
		if (hasObject == "True" && hasSubmit == "True") {
			btnSubmit();
		}
	});
	$(".btnFalse").click(function () {
		location.href = "/1046/Notify";
		$(".popUpBox").css("display", "none");
	});
	$(".queryResult").on("click", function() {
		location.href = "/1046/Questionnaire/QueStatistics?sQuestionUid=" + $("#txtQuestionnaireId").val();
	});

	$("#btSubmit").click(function () {
		if (hasObject == "False" || hasSubmit == "True") {
			$(".popUpBox").css("display", "block");
		}
		else {
			btnSubmit();
		}
	});
        //提交
	function btnSubmit() {
		var zy_sid             = $("#hide_sid").val();
		var zy_tid             = $("#hide_tid").val();
		var zy_weid            = $("#hide_weid").val();
		var zy_schoolid        = $("#hide_schoolid").val();
		var txtQuestionnaireId = $("#txtQuestionnaireId").val();

		var txtItemJson = "";
		var d = 0;
		$(".questionContent").find('.question').each(function () {
			d++;
			var txtQueId = $(this).attr("name");
			var txtQueType = $(this).attr("tag");
			//问答题
			if (txtQueType == "c") {
				var txtQueAnswerId = $(this).find("[name=txtAnswerOption]").attr("tag");
				var txtAnserContent = $(this).find('[name=txtAnswerOption]').val();
				
				if( txtAnserContent.indexOf('"') != -1 )
				{
				    txtAnserContent1 = txtAnserContent.replace(/"/g,"“");
				}else{
					txtAnserContent1 = txtAnserContent ;
				}
				//alert(txtAnserContent1);
				if (txtAnserContent != "") {
                        txtItemJson += "{\"tmid\":\"" + txtQueId + "\",\"type\":\"" + txtQueType + "\",\"huida\":\"" + txtAnserContent1 + "\"},";
				}
			} else {
				var radioObj = $(this).find("[name=answerOption_" + txtQueId + "]");
				for (var j = 0; j < radioObj.length; j++) {
					if (radioObj[j].checked) {
						var txtQueAnswerId = $(radioObj[j]).attr("tag");
                            txtItemJson += "{\"tmid\":\"" + txtQueId +  "\",\"type\":\"" + txtQueType + "\",\"huida\":\"" + txtQueAnswerId + "\"},";
					}
				}

			}

		});
        if (txtItemJson != "") {
            txtItemJson = "[" + txtItemJson.substr(0, txtItemJson.length - 1) + "]";
        } else {
            jTips("还没填写任何内容！不能提交哦");
            return false;
        }
        jConfirm('提交回答后不可修改，是否确认提交？', '确认对话框', function (r){
	        if(r){
		$.post("<?php  echo $this->createMobileUrl('indexajax',array('op'=>'tjzy'))?>",{"tid":zy_tid, "sid":zy_sid,"weid":zy_weid,"schoolid":zy_schoolid,"userid":<?php  echo $userid;?>, "txtQuestionnaireId": txtQuestionnaireId, "txtItemJson": txtItemJson, hasSubmit: hasSubmit },function(data){
					if(data.result){
						jTips(data.info);
						window.location.href = "<?php  echo $this->createMobileUrl('snoticelist', array('schoolid' => $schoolid), true)?>"
					}else{
						jTips(data.info);
						window.location.href = "<?php  echo $this->createMobileUrl('snoticelist', array('schoolid' => $schoolid), true)?>"
					}
		},'json');}else{
			return false;
		}});
		
	}
</script>
<?php  } ?>
<script>
icon_replace($("#neirong"));
$(function () {
	//背景音乐播放
	var myaudio = document.getElementById("jp_audio_1");
	//myaudio.play();
	$(".audioBar").on("touchstart", function (e) {
		e.stopPropagation();
		if ($(this).hasClass("on")) {
			myaudio.pause();
		} else {
			myaudio.play();
		}
	});
});
$(function() {

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
<?php 
if (!empty($_W['setting']['remote']['type'])) { 
	$urls = $_W['SITEROOT'].$_W['config']['upload']['attachdir'].'/'; 
	} else {
	$urls = $_W['attachurl'];  
	}
?>
var ALI_URL = "<?php  echo $urls;?>";
var ALI_URL_VIEDO = "<?php  echo $urls;?>";
function wxImageShow(node){
	var srcList = new Array();
	var watermark='';
	var imgs = $(node).closest('.parent').find("img");	
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
</html>