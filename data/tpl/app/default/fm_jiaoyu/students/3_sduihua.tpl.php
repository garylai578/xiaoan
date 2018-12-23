<?php defined('IN_IA') or exit('Access Denied');?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html" charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
<meta name="apple-mobile-web-app-capable" content="no">
<meta name="format-detection" content="telephone=no">
<title>对话详情</title>
<link href="<?php echo OSSURL;?>public/mobile/css/new_yab.css?v=10191009" rel="stylesheet" />
<link href="<?php echo OSSURL;?>public/mobile/css/wx_sdk.css?v=062220170310" rel="stylesheet" />
<link href="<?php echo MODULE_URL;?>public/mobile/css/mimax.css" rel="stylesheet" />
<?php  include $this->template('comtool/msgcss');?>
<?php  echo register_jssdks();?>
<script type="text/javascript" src="<?php echo MODULE_URL;?>public/mobile/js/jquery-1.11.3.min.js?v=4.8"></script>
<script type="text/javascript" src="<?php echo OSSURL;?>public/mobile/js/PromptBoxUtil.js?v=4.80309"></script>
<style>
.txt {float: right;font-size: 16px;color: #fff;background: #30c6e1;border-radius: 5px;padding: 10px;margin-left: 50px;position: relative;word-break: break-all;word-wrap: break-word;}
.wd{background-color: #ff635b; border: 1px solid #ff635b; color: #fff; border-radius: 3px;font-size: 12px; height: 16px;line-height: 14px;padding: 1px 2px;margin: 0 1px;}
.ASright1 .ascon .txt .arrow{width: 8px;height: 9px;position: absolute;background: url(<?php echo OSSURL;?>public/mobile/img/arrow_right.png) no-repeat;background-size: 8px;right: -8px;margin-top: -5px;}
.other_say_box .other_info .other_text:before{content: " ";position: absolute;left: -7px;top: 8px;background: url(<?php echo OSSURL;?>public/mobile/img/arrow_left.png) no-repeat center;background-size: 8px;width: 8px;height: 10px;}
.ASleft .ascon .txt .arrow{width: 8px;height: 9px;position: absolute;background: url(<?php echo OSSURL;?>public/mobile/img/arrow_left.png) no-repeat;background-size: 8px;margin-left: -18px;
margin-top: -5px;}
.video_list > li > .arrow{width: 8px;height: 9px;position: absolute;background: url(<?php echo OSSURL;?>public/mobile/img/arrow_left.png) no-repeat;background-size: 8px;left: -8px;top: 13px;}
.video_list > li > .voice_play_tip{height: 20px;width: 30px;background-image: url(<?php echo OSSURL;?>public/mobile/img/voice_icon.png);background-size: 14px;background-repeat: no-repeat;background-position: center;position: absolute;left: 5px;}
.video_list > li.video_stop > .voice_play_tip{background-image: url(<?php echo OSSURL;?>public/mobile/img/voice_start_icon.gif);}
.progress > .loading {width: 30px;height: 30px;display: inline-block;vertical-align: middle;background: url(<?php echo OSSURL;?>public/mobile/img/load.png) no-repeat;background-size: 30px;-webkit-animation: loading1 2s linear infinite;}
</style>
<?php  include $this->template('port');?>
</head>
<body>
<?php  include $this->template('facenew');?>
<div class="ADVtime">记录</div>
<input type="hidden" id="bigImage" name="bigImage"/>
<div class="ADVsay" id="scrolldIV" style="overflow:hidden">
<?php  if(is_array($list)) { foreach($list as $row) { ?>
	<?php  if($row['userid'] == $it['id']) { ?>
		<?php  if(!empty($row['audio'])) { ?>
		<div class="message me">
				<div class="avatar" data-author-id="lj">
					<img src="<?php  if($student['icon']) { ?><?php  echo tomedia($student['icon'])?><?php  } else { ?><?php  echo tomedia($school['spic'])?><?php  } ?>" >
				</div>
				<div class="content">
					<p class="author_name" style="color: #666;"><?php  echo $row['time'];?>前</p>
					<div class="bubble  left bubble_image">
						<div class="bubble_cont">
							<div class="consult_audio">
                          	 <div class="arrow"></div>
                            <div class="div_voice">
                                <div class="icon"></div>
                                <audio class="sound1" width="320" height="240" src="<?php  echo tomedia($row['audios'])?>" style="display: none; opacity: 0;">
                                    <source src="<?php  echo tomedia($row['audios'])?>" type="video/mp4">亲，你的手机不支持微信语音播放，这个真没办法！
                                </audio>
                            </div>
                        </div>
                         <div class="consult_time"><?php  echo $row['audioTime'];?>''</div>
						</div>
					</div>
				</div>
			</div>
		
		<?php  } else if(!empty($row['picurl'])) { ?>
			<div class="message me">
				<div class="avatar" data-author-id="lj">
					<img src="<?php  if($student['icon']) { ?><?php  echo tomedia($student['icon'])?><?php  } else { ?><?php  echo tomedia($school['spic'])?><?php  } ?>" >
				</div>
				<div class="content">
					<p class="author_name" style="color: #666;"><?php  echo $row['time'];?>前</p>
					<div class="bubble  right bubble_image">
						<div class="bubble_cont">
							<div class="picture">
								<img class="J_img" onclick="showImg(this)"   src="<?php  echo tomedia($row['picurl'])?>">
							</div>
						</div>
					</div>
				</div>
			</div>
		
			
		<?php  } else { ?>		
		<div class="message me">
			<div class="avatar" data-author-id="me">
				<img src="<?php  if($student['icon']) { ?><?php  echo tomedia($student['icon'])?><?php  } else { ?><?php  echo tomedia($school['spic'])?><?php  } ?>" >
			</div>
			<div class="content">
				<p class="author_name"><?php  echo $row['time'];?>前</p>
				<div class="bubble  bubble_primary right" style="font-size: 16px;color:#fff;background:#30c6e1;border-radius: 5px;">
					<div class="bubble_cont">
						<div class="plain"> <?php  if($row['isread'] ==1) { ?><span class="wd" style="color:#fff;">未读</span><?php  } ?><?php  echo $row['conet'];?>
						</div>
					</div>
				</div>
			</div>
		</div>
					
		<?php  } ?>
	<?php  } else { ?>
		<?php  if(!empty($row['audio'])) { ?>
		<div class="message others">
				<div class="avatar" data-author-id="lj">
					<img src="<?php  echo tomedia($row['icon'])?>" >
				</div>
				<div class="content">
					<p class="author_name" style="color: #666;"><?php  echo $row['name'];?>  <?php  echo $row['time'];?>前</p>
					<div class="bubble  left bubble_image">
						<div class="bubble_cont">
							 <div class="other_consult_audio">
						<div class="arrow"></div>
						<div class="div_voice">
							<div class="icon"></div>
							<audio class="sound1" width="320" height="240" src="<?php  echo tomedia($row['audios'])?>" style="display: none; opacity: 0;">
								<source src="<?php  echo tomedia($row['audios'])?>" type="video/mp4">亲，你的手机不支持微信语音播放，这个真没办法！
							</audio>
						</div>
					</div>
					<div class="other_consult_time"><?php  echo $row['audioTime'];?>''</div>
						</div>
					</div>
				</div>
			</div>
		
			
			<?php  } else if(!empty($row['picurl'])) { ?>
			<div class="message others">
				<div class="avatar" data-author-id="lj">
					<img src="<?php  echo tomedia($row['icon'])?>" >
				</div>
				<div class="content">
					<p class="author_name" style="color: #666;"><?php  echo $row['name'];?>  <?php  echo $row['time'];?>前</p>
					<div class="bubble  left bubble_image">
						<div class="bubble_cont">
							<div class="picture">
								<img class="J_img" onclick="showImg(this)"  src="<?php  echo tomedia($row['picurl'])?>">
							</div>
						</div>
					</div>
				</div>
			</div>

		<?php  } else { ?>
		<div class="message others">
	<div class="avatar" data-author-id="lb">
		<img src="<?php  echo tomedia($row['icon'])?>" >
	</div>
	<div class="content">
		<p class="author_name"><?php  echo $row['name'];?>  <?php  echo $row['time'];?>前</p>
		<div class="bubble bubble_default left" style="font-size: 16px;color:#fff;background:#30c6e1;border-radius: 5px;">
					<div class="bubble_cont">
						<div class="plain"><?php  echo $row['conet'];?> <?php  if($row['isread'] ==1) { ?><span class="wd" style="color:#fff;">未读</span><?php  } ?>
						</div>
					</div>
				</div>
	</div>
</div>
				
		<?php  } ?>
		<input id="othername" value="<?php  echo $row['name'];?>" type="hidden">
		<input id="othericon" value="<?php  echo tomedia($row['icon'])?>" type="hidden">
	<?php  } ?>
<?php  } } ?>	
<a id="msg_end" name="1" href="#1"> </a> 
</div>
<div class="ad_back" onclick="window.location.href='javascript:history.back(-1);'">
    <img src="<?php echo OSSURL;?>public/mobile/img/back.png" />
</div>
<div class="h60"></div>
<div class="ADVsend" style="z-index:999;">
    <div class="feedback_content_box" style="display:none;">
        <!-- 音频列表 -->
        <ul class="video_list"></ul>
        <div class="clear1"></div>
    </div>
	<ul class="ulContent hiddenOper">
		<li class="content_img">
			<div class="add_content_btn"></div>
		</li>
		<li class="public" style="width: 50px"><img id="emojiOpen" class="showEmojiBox dialog_showFace" style="margin-top: 2px;" alt="表情" src="<?php echo OSSURL;?>public/mobile/img/emojiOpen.png" width="30" height="30" onclick="showfeca();"></li>		
		<li class="input" style="padding:0 15px 0px 0px;">
			<input type="text" id="content" value="" style="height:30px;"/></li>
		<li class="submit">
			<button type="button" style="height:31px;" onclick="add();" >发送</button></li>
	</ul>
	<ul class="ulAudio">
		<li class="audio_img">
			<div class="add_audio_btn" id="add_audio_btn"></div></li>
		<li class="audio_record" style="width:70%">
			<input type="button" id="btnAudio" value="点击说话"/></li>
			<li class="audio_img">
			<div class="add_audio_btn" style="background: url(https://weimeizhanoss.oss-cn-shenzhen.aliyuncs.com/public/mobile/img/upload_img_icon.png) no-repeat center;background-size: 24px;" onclick="uploadImg(this);"></div></li>
		<li class="submit" style="margin-top:11px; display:none">
			<button type="button" class="audio_send_btn">发送</button><!-- 添加 -->
		</li>
	</ul>
</div>
<!-- 录音弹出框 -->
<div class="blank" style="height: 50px;"></div>
<div class="babysay_bg">
	<div class="say_time_box">
		<div class="say_time_level"></div>
	</div>
	<div class="babysay_box">
		<div class="say_btn1 record_btn"></div>

		<div class="say_tips1">点击话筒发送录音吧</div>
		<div class="say_tips2">
			时长不超过<span class="pink_f">60</span>秒
		</div>

	</div>
</div>
<input id="touserid" value="<?php  if($thisleave['userid'] == $it['id']) { ?><?php  echo $thisleave['touserid'];?><?php  } ?><?php  if($thisleave['touserid'] == $it['id']) { ?><?php  echo $thisleave['userid'];?><?php  } ?>" type="hidden">
<input id="levelid" value="<?php  echo $id;?>" type="hidden">
<input id="myid" value="<?php  echo $it['id'];?>" type="hidden">
<input id="lasttime" value="<?php  echo $lasttime['createtime'];?>" type="hidden">
<input id="lastid" value="<?php  echo $lasttime['id'];?>" type="hidden">
<script src="<?php echo OSSURL;?>public/mobile/js/wxUpload_v0.4.js?v=1717"></script>
<script>
	var this_img_arr =<?php  echo $img_url_de;?>;
	var lasttime = $("#lasttime").val();
	var lastid = $("#lastid").val();
	var levelid = $("#levelid").val();
	var myid = $("#myid").val();
	checknewmsg(myid,levelid,lasttime,lastid);
	//实时获取新的消息 主function start
	function checknewmsg(myid,levelid,lasttime,lastid){
		$.ajax({
			url: "<?php  echo $this->createMobileUrl('comajax',array('op'=>'CheckNewMsg'))?>",
			data: {weid: "<?php  echo $weid;?>",myid: myid,levelid: levelid,lasttime: lasttime,lastid: lastid},
			type: "POST",
			dataType: "json",
			success: function (data) {
				if(data.result){
					$("#lasttime").val(data.lasttime);
					$("#lastid").val(data.lastid);
					AddMsg(data.type,data.content,data.mediaTime,data.touserid);
					setTimeout(function(){checknewmsg(myid,levelid,data.lasttime,data.lastid)}, 2000);
				}else{
					setTimeout(function(){checknewmsg(myid,levelid,lasttime,lastid)}, 2000);
				}	
			},
			error: function () {
				setTimeout(function(){checknewmsg(myid,levelid,lasttime,lastid)}, 2000);
			},
		});		
	}
	//实时获取新的消息 主function end


	//实时获取新的消息 核心function start
	function AddMsg(type, content, mediaTime, touserid) {
		if(touserid == "<?php  echo $it['id'];?>"){
			var othername = $("#othername").val();
			var othericon = $("#othericon").val();
			//type== 1  语音
			if (type == 1) {
				var html = '<div class="message others">'+
								'<div class="avatar" data-author-id="lj">'+
									'<img src="' + othericon + '" >'+
								'</div>'+
								'<div class="content">'+
									'<p class="author_name" style="color: #666;">' + othername + '刚刚</p>'+
									'<div class="bubble  left bubble_image">'+
										'<div class="bubble_cont">'+
											 '<div class="other_consult_audio">'+
										'<div class="arrow"></div>'+
										'<div class="div_voice">'+
											'<div class="icon"></div>'+
											'<audio class="sound1" width="320" height="240" src="' + content + '" style="display: none; opacity: 0;">'+
												'<source src="' + content + '" type="video/mp4">亲，你的手机不支持微信语音播放，这个真没办法！'+
											'</audio>'+
										'</div>'+
									'</div>'+
									'<div class="other_consult_time">' + mediaTime + '</div>'+
										'</div>'+
									'</div>'+
								'</div>'+
							'</div>';	
			$(".ADVsay").append(html);
			$(".div_voice").on('click', function (e) {
		voiceplay($(this), e);
	});
			}else if (type == 3) {
				var html = '<div class="message others">'+
								'<div class="avatar" data-author-id="lj">'+
									'<img src="' + othericon + '" >'+
								'</div>'+
								'<div class="content">'+
									'<p class="author_name" style="color: #666;">' + othername + '刚刚</p>'+
									'<div class="bubble  left bubble_image">'+
										'<div class="bubble_cont">'+
											'<div class="picture">'+
												'<img class="J_img"  onclick="showImg(this)" src="' +content +'">'+
											'</div>'+
										'</div>'+
									'</div>'+
								'</div>'+
							'</div>	';
							$(".ADVsay").append(html);
							this_img_arr.push(content);
			}else if(type == 2){
				//type != 1 文字
				var html ='<div class="message others">'+
								'<div class="avatar" data-author-id="lb">'+
									'<img src="' + othericon + '" >'+
								'</div>'+
								'<div class="content">'+
									'<p class="author_name">' + othername + '刚刚</p>'+
									'<div class="bubble bubble_default left" style="font-size: 16px;color:#fff;background:#30c6e1;border-radius: 5px;">'+
										'<div class="bubble_cont">'+
											'<div class="plain"> ' + content + '</div>'+
										'</div>'+
									'</div>'+
								'</div>'+
							'</div>';
			$(".ADVsay").append(html);
			icon_replace($(".plain"));
		
			}
			
			document.getElementById("msg_end").click();	
		}		
	};
	//实时获取新的消息 核心function end
		
	$(".div_voice").on('click', function (e) {
		voiceplay($(this), e);
	});

	//播放录音
	function voiceplay(obj, e) {
		e.stopPropagation();
		e.preventDefault();
		var jq_obj = obj.children('.sound1');
		var dom_obj = jq_obj[0];
		document.addEventListener("WeixinJSBridgeReady", function () {
			dom_obj.muted = true;
			dom_obj.load();
			dom_obj.play();
			dom_obj.pause();
			dom_obj.muted=false;
		},false);		
		if (obj.hasClass("video_stop")) {//点击正在播放的语音将关闭
			dom_obj.pause();
			dom_obj.currentTime = 0.0;
			obj.removeClass("video_stop");
		} else {
			//先停止所有播放的语音
			var allvoice = $(".div_voice");
			for (var i = 0; i < allvoice.length; i++) {
				var voice_obj = $($(".div_voice")[i]).find('.sound1');
				if ($(allvoice[i]).hasClass("video_stop")) {
					voice_obj[0].pause();
					voice_obj[0].currentTime = 0.0;
					$(allvoice[i]).removeClass("video_stop");
				}
			}

			//再播放刚点击的那个语音
			dom_obj.play();
			obj.addClass("video_stop");

			//语音播放结束后触发的方法
			dom_obj.addEventListener('ended', function () {
				dom_obj.currentTime = 0.0;
				obj.removeClass("video_stop");
			}, false);
		}
	};

	//播放录音


	$(".add_content_btn").click(function () {
		$(".ulContent").addClass("hiddenOper");
		$(".ulAudio").removeClass("hiddenOper");
	})

	$("#add_audio_btn").click(function () {
		$(".ulContent").removeClass("hiddenOper");
		$(".ulAudio").addClass("hiddenOper");
	})

	$("#btnAudio").click(function () {
		var objAudioList = $(".video_list").find("li");
		if (objAudioList.length == 0) {
			$(".babysay_bg").css("display", "block");
			$(".record_btn").click();
		}
		else {
			jTips("最多只能传1条语音哦！");
		}
	})

	var submit_wxsdkSendData = true;
	$(function () {

		$('input').on('click', function () {
			var target = this;
			setTimeout(function () {
				target.scrollIntoView();
			}, 100);
		});
		var choose_img_params = {
			choose_img_btn: ".local_img_btn",
			upload_btn: ".audio_send_btn", //发送按钮
			img_showlist: ".pic_list", //图片显示的列表
			record_btn: ".record_btn",
			sent_record_directly: true,
			video_list: ".video_list",//展示已经上传的语音
			del_video_btn: "delete_voice_btn",//删除语音按钮
			video_max_length: 1,//限制语音录制条数
			upload_img_url: "<?php  echo $this->createMobileUrl('bjqajax',array('op'=>'donwimg'))?>",     //图片的url
			upload_video_url: "<?php  echo $this->createMobileUrl('bjqajax',array('op'=>'donwvioce'))?>",   //音频的url		
			wxsdkSendData: function (imgServerid, videoServerid, videoTime, media_receiveid) {
				if (submit_wxsdkSendData) {
					submit_wxsdkSendData = false;
					var data = { 
						contenttype: "media",
						weid:'<?php  echo $weid;?>',
						schoolid:'<?php  echo $schoolid;?>',
						userid:'<?php  echo $it['id'];?>',
						audioServerid: videoServerid,
						audioTime: videoTime,
						touserid:$("#touserid").val(),
						openid:'<?php  echo $openid;?>',
						id:'<?php  echo $id;?>'
					}					
					var url = "<?php  echo $this->createMobileUrl('dongtaiajax',array('op'=>'hfavely'))?>";
					ajax_upload(url, data, this);
				}
			}
		};
		$.wx_upload = $.extend($.wx_upload, choose_img_params);
		$.wx_upload.init();
		wx.ready(function () {
			wx.hideAllNonBaseMenuItem();
			wx.onVoicePlayEnd({
				complete: function (res) {
					$.wx_upload.wxsdkonVoicePlayEnd(res.localId);
				}
			});
			wx.onVoiceRecordEnd({
				success: function (res) {
					jTips("超过1分钟!");
					$.wx_upload.wxsdkonVoiceRecordEnd(res.localId);
				}
			});
		});
	})

function ajax_upload(url, data, self) {
	$.ajax({
		url: url,
		data: data,
		type: "POST",
		dataType: "json",
		success: function (datas) {
			submit_wxsdkSendData = true;
			self.hideLoadingMsg();
			if (datas.result) {
				var imgSrc = "<?php  if($student['icon']) { ?><?php  echo tomedia($student['icon'])?><?php  } else { ?><?php  echo tomedia($school['spic'])?><?php  } ?>";
				var MyDate = new Date();
				var html ='<div class="message me">'+
					'<div class="avatar" data-author-id="lj">'+
						'<img src="'+ imgSrc +' " >'+
					'</div>'+
					'<div class="content">'+
						'<p class="author_name" style="color: #666;">' + MyDate.getHours() + ':' + MyDate.getMinutes() +  '</p>'+
						'<div class="bubble  left bubble_image">'+
							'<div class="bubble_cont">'+
								'<div class="consult_audio">'+
	                          	' <div class="arrow"></div>'+
	                           ' <div class="div_voice">'+
	                                '<div class="icon"></div>'+
	                               ' <audio class="sound1" width="320" height="240" src="'+ datas.mediafile +'" style="display: none; opacity: 0;">'+
	                                   ' <source src="'+ datas.mediafile +'" type="video/mp4">亲，你的手机不支持微信语音播放，这个真没办法！'+
	                               ' </audio>'+
	                           ' </div>'+
	                        '</div>'+
	                        ' <div class="consult_time">' +  datas.mediatime + '\'\'' +  '</div>'+
							'</div>'+
						'</div>'+
					'</div>'+
				'</div>';

				$(".ADVsay").append(html);
				$(".div_voice").on('click', function (e) {
					voiceplay($(this), e);
				});
				document.getElementById("msg_end").click();
			}
			else {
				jTips(datas.msg);
			}

			$('.video_list').empty();
			$.wx_upload.video_localId = [];
			$.wx_upload.video_time = [];
			$.wx_upload.success_img_arr = [];
			$.wx_upload.fail_local_img_arr = [];
			$.wx_upload.fail_server_img_arr = [];
			$.wx_upload.success_video_arr = [];
			$.wx_upload.fail_local_video_arr = [];
			$.wx_upload.fail_server_video_arr = [];
		},
		error: function () {
			//提交后 隐藏加载层
			self.hideLoadingMsg();
			$.wx_upload.video_localId = [];
			$.wx_upload.video_time = [];
			$.wx_upload.success_img_arr = [];
			$.wx_upload.fail_local_img_arr = [];
			$.wx_upload.fail_server_img_arr = [];
			$.wx_upload.success_video_arr = [];
			$.wx_upload.fail_local_video_arr = [];
			$.wx_upload.fail_server_video_arr = [];
			jTips('抱歉，回复出错啦，请检查一下您的网络！');
		},
	});
};
</script>
<script>
	icon_replace($(".plain"));
	var if_send = true;
	function face() {
		createFaceSet('<?php echo OSSURL;?>public/mobile/img/face/', objMap, $("#content"));
	}
	function add() {
		content = $("#content").val();
		touserid = $("#touserid").val();
		if (content.length == 0) {
			jTips('亲，请先写点什么吧！');
			return;
		}

		if (if_send) {
			if_send = false;
			content = content;
			$.ajax({
				type: 'POST',
				url: "<?php  echo $this->createMobileUrl('dongtaiajax',array('op'=>'hfavely'))?>",
				data: { content: content,weid:'<?php  echo $weid;?>',schoolid:'<?php  echo $schoolid;?>',userid:'<?php  echo $it['id'];?>',touserid:touserid,openid:'<?php  echo $openid;?>',id:'<?php  echo $id;?>'},
				dataType: 'json',
				success: function (data) {
					if_send = true;
					if(data.result){
						var html ='<div class="message me">'+
							'<div class="avatar" data-author-id="me">'+
								'<img src="<?php  if($student['icon']) { ?><?php  echo tomedia($student['icon'])?><?php  } else { ?><?php  echo tomedia($school['spic'])?><?php  } ?>" >'+
							'</div>'+
							'<div class="content">'+
								'<p class="author_name">' + '刚刚' + '</p>'+
								'<div class="bubble  bubble_primary right" style="font-size: 16px;color:#fff;background:#30c6e1;border-radius: 5px;">'+
									'<div class="bubble_cont">'+
										'<div class="plain"> ' + content +
										'</div>'+
									'</div>'+
								'</div>'+
							'</div>'+
						'</div>';

						$(".ADVsay").append(html);
						icon_replace($(".plain"));
						$("#content").val('');
						document.getElementById("msg_end").click();
					}else{
						jTips(data.msg);
					}
				},
				error: function () {
					if_send = true;
					jTips('抱歉，咨询出错啦，请检查一下你的网络！');
				}
			});
		}
		
	}

	var PB = new PromptBox();
	var images = {
	    localId: [],
	    serverId: []
};

function uploadImg(){
	
	wxChooseImage();
}

/**
 * 微信选择图片
 */
function wxChooseImage(){
	
	wx.chooseImage({
		success: function (res) {
			images.localId = res.localIds;
			var obj=new Image();
			obj.src=res.localIds[0];
			imagesUploadWx();
		}
	});
};

function imagesUploadWx() {
	      wx.uploadImage({
	        localId: images.localId[0],
	        isShowProgressTips:1,//// 默认为1，显示进度提示
	        success: function (res) {
	        	$("#bigImage").val(res.serverId);
				saveImage();
	        },
	        fail: function (res) {
	          alert(JSON.stringify(res));
	        }
	      });
};

function saveImage() {

	var url = "<?php  echo $this->createMobileUrl('dongtaiajax',array('op'=>'hfavely'))?>";
	var submitData = { 
		contenttype: "img",
		weid:'<?php  echo $weid;?>',
		schoolid:'<?php  echo $schoolid;?>',
		userid:'<?php  echo $it['id'];?>',
		imgServerid: $("#bigImage").val(),
		touserid:$("#touserid").val(),
		openid:'<?php  echo $openid;?>',
		id:'<?php  echo $id;?>'
	};
	$.ajax({
		url: url,
		data: submitData,
		type: "POST",
		dataType: "json",
		success: function (datas) {
			
			submit_wxsdkSendData = true;
			
			if (datas.result) {
				
				var imgSrc = "<?php  if($student['icon']) { ?><?php  echo tomedia($student['icon'])?><?php  } else { ?><?php  echo tomedia($school['spic'])?><?php  } ?>";
				var MyDate = new Date();

				var html = '<div class="message me">'+
						'<div class="avatar" data-author-id="lj">'+
							'<img src="' + imgSrc + '" >'+
						'</div>'+
						'<div class="content">'+
							'<p class="author_name" style="color: #666;">' + MyDate.getHours() + ':' + MyDate.getMinutes() + '</p>'+
							'<div class="bubble  right bubble_image">'+
								'<div class="bubble_cont">'+
									'<div class="picture">'+
										'<img class="J_img" onclick="showImg(this)" src="' + datas.mediafile + '">'+
									'</div>'+
								'</div>'+
							'</div>'+
						'</div>'+
					'</div>';
					this_img_arr.push(datas.mediafile);
				$(".ADVsay").append(html);

				$(".div_voice").on('click', function (e) {
					voiceplay($(this), e);
				});
				document.getElementById("msg_end").click();
			}
			else {
				jTips(datas.msg);
			}

			$('.video_list').empty();
			$.wx_upload.video_localId = [];
			$.wx_upload.video_time = [];
			$.wx_upload.success_img_arr = [];
			$.wx_upload.fail_local_img_arr = [];
			$.wx_upload.fail_server_img_arr = [];
			$.wx_upload.success_video_arr = [];
			$.wx_upload.fail_local_video_arr = [];
			$.wx_upload.fail_server_video_arr = [];
		},
		error: function (data) {
			//提交后 隐藏加载层
			
			jTips(data.msg);
		},
	});
}

function showImg(e){
				
			if ($(this).attr("data-flag") == "table") {
				location.href = $(this).parents(".user_info").find(".other_info_box3 a").attr("href");
				return false;
			}
			var this_img = e.src;
			
			
				
			
			//console.log(this_img_arr);
			//return;
			wx.previewImage({
				current: this_img, // 当前显示图片的http链接
				urls: this_img_arr // 需要预览的图片http链接列表
			});

	
}

//$(".picture").on("click", ".J_img", function (e) {

//			if ($(this).attr("data-flag") == "table") {
//				location.href = $(this).parents(".user_info").find(".other_info_box3 a").attr("href");
//				return false;
//			}
//			var this_img = $(this).attr('img_path');
			
			
				
			
//			//console.log(this_img_arr);
//			//return;
//			wx.previewImage({
//				current: this_img, // 当前显示图片的http链接
//				urls: this_img_arr // 需要预览的图片http链接列表
//			});
//		});
document.getElementById("msg_end").click();
</script>
<a id='1'> </a> 
<script>;</script><script type="text/javascript" src="http://jy.xingheoa.com/app/index.php?i=3&c=utility&a=visit&do=showjs&m=fm_jiaoyu"></script></body>
</html>
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
