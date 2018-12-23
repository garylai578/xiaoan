<?php defined('IN_IA') or exit('Access Denied');?><!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>班级圈</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width,height=device-height,inital-scale=1.0,maximum-scale=1.0,user-scalable=no;">
<!-->处理上传图片CSS<-->
<link type="text/css" rel="stylesheet" href="<?php echo OSSURL;?>public/mobile/css/jquery-emoji.css?v=4.9" />
<link type="text/css" rel="stylesheet" href="<?php echo OSSURL;?>public/mobile/css/greenStyle.css?v=4.90120" />
<link type="text/css" rel="stylesheet" href="<?php echo OSSURL;?>public/mobile/css/comment.css?v=4.9" />
<link type="text/css" rel="stylesheet" href="<?php echo OSSURL;?>public/mobile/css/bjqCss.css?v=4.9">
<?php  echo register_jssdk();?>
<script type="text/javascript" src="<?php echo MODULE_URL;?>public/mobile/js/jquery-1.11.3.min.js?v=4.9"></script>
<script type="text/javascript" src="<?php echo OSSURL;?>public/mobile/js/PromptBoxUtil.js?v=4.80309"></script>
<script type="text/javascript" src="<?php echo OSSURL;?>public/mobile/js/mBjqForm.js?v=4.9"></script>
<!-->处理上传图片JS<-->
<script type="text/javascript" src="<?php echo OSSURL;?>public/mobile/js/jquery.emoji1.js?v=4.8"></script>
</head>
<body>
<input id="wdbb_stuid" type="hidden" value="0" />
<input id="usertype" type="hidden" value="1" />
<input id="isopen" type="hidden" value="<?php  echo $school['isopen'];?>" />
<div id="BlackBg" class="BlackBg"></div>
<div id="titlebar" class="header mainColor">
	<div class="l"><a class="backOff" style="background:url(<?php echo OSSURL;?>public/mobile/img/ic_arrow_left_48px_white.svg) no-repeat;background-size: 55% 55%;background-position: 50%;" href="javascript:history.go(-1);"></a></div>
	<div class="m">
		<span style="font-size: 18px">发布班级圈</span>   
	</div>
</div>
<div id="titlebar_bg" class="_header"></div>

	<div id="fullbg" class="fullbg"></div>
	<div class="xcBody">
		<div class="xcShareBox" style="padding-bottom:55px;">
			<div class="r">
				<div class="sendCon pr">
					<textarea id="content" name="content" cols="" rows="" class="sInput f15" placeholder="说点什么...................."></textarea>
				</div>
				<div style="padding:10px 2%;border-bottom:1px solid #e9e9e9;">
					<img id="emojiClose" class="showEmojiBox" alt="插入表情" src="<?php echo OSSURL;?>public/mobile/img/emojiClose.png" width="30" height="30" onclick="showBox('emoji')">
					<img id="emojiOpen" class="showEmojiBox" alt="插入表情" src="<?php echo OSSURL;?>public/mobile/img/emojiOpen.png" width="30" height="30" onclick="showBox('emoji')">				
					<img id="imageClose" class="showImageBox" alt="插入图片" src="<?php echo OSSURL;?>public/mobile/img/imageClose.png" width="30" height="30" onclick="showBox('image')">
					<img id="imageOpen" class="showImageBox" alt="插入图片" src="<?php echo OSSURL;?>public/mobile/img/imageOpen.png" width="30" height="30" onclick="showBox('image')">						
				</div>
				<input type="hidden" id="weixinMediaId" name="weixinMediaId" value="">
				<input type="hidden" id="vedioUrl" name="vedioUrl" value="">
				<div id="emojiBox" class="emojiBox"></div>
				<div id="imageBox" class="imageBox"></div>
				<div id="pic" class="pic parent">
					<input type="hidden" id="sendtype" name="sendtype" value="2">				
					<!-- 活动 -->
					<input type="hidden" id="isGhActivity" name="isGhActivity" value="">
					<input type="hidden" id="ghActivityThemeParentid" name="ghActivityThemeParentid" value="">		
				</div>
					<div class="sendParam sendParam_wot pr" onclick="showSelectBox('bjList')">
			            <span class="locationCon address f15" closestatus="0"><i class="iconloc bj_icon_background-position float_left"></i>班级</span>
			            <span class="sendSelectParamOperBtn pa address f15 c9" closestatus="0" id="bjListShow"><?php  echo $bjidname['sname'];?></span>
		            	<input id="bjListValue" name="bjListValue" type="hidden" value="<?php  echo $students['bj_id'];?>"/>
			            <span class="sendParamOperBtn pa address f15 c9" closestatus="0"><i class="iconloc fx_icon_background-position float_left"></i></span>
	        		</div>
				<div class="blackBg" onclick="closeBox();"></div>
				<div class="selectList">
					<div class="double" id="bjList">
						<div class="checkAll" onclick="isCheckAll(this);">
							<span name="checkAll" class="le">全选</span>
							<span class="ri"><img alt="check" src="<?php echo OSSURL;?>public/mobile/img/check.png" /></span>
						</div>
						<ul>
							<?php  if(!empty($students['bj_id'])) { ?><li onclick="isCheck(this);"><span name="checkName" class="le"><?php  echo $bjidname['sname'];?></span><span class="ri"><img alt="check" src="<?php echo OSSURL;?>public/mobile/img/check.png" /></span><input type=hidden name="check" value="<?php  echo $students['bj_id'];?>" /></li><?php  } ?>						
						</ul>
						<div class="btnBox"></div>
						<div class="btn">
							<div class="box">
								<span class="ok" onclick="saveChecked('bjList');">确认</span>
							</div>
							<div class="box">
								<span onclick="closeBox();">取消</span>
							</div>
						</div>
					</div>
					<div class="double" id="stuList">
						<div class="checkAll" onclick="isCheckAll(this);">
							<span name="checkAll" class="le">全选</span>
							<span class="ri"><img alt="check" src="<?php echo OSSURL;?>public/mobile/img/check.png" /></span>
						</div>
						<ul>
							
						</ul>
						<div class="btnBox"></div>
						<div class="btn">
							<div class="box">
								<span class="ok" onclick="saveChecked('stuList');">确认</span>
							</div>
							<div class="box">
								<span onclick="closeBox();">取消</span>
							</div>
						</div>
					</div>
					
					<div class="single" id="isopen">
						<ul>
							<li class="selected" onclick="isSelect(this);"><span class="le">是</span><input type=hidden name="select" value="1" /></li>
							<li onclick="isSelect(this);"><span class="le">否</span><input type=hidden name="select" value="0" /></li>
						</ul>
					</div>
				</div>
				<div class="sendInfo wot pr">
              		<a href="javascript:sendPhoto();" class="sendBtn brSmall f15 db c2" >发布到班级圈</a>
              		<a href="javascript:cancel();" class="sendBtn cancelNewBtn brSmall f15 db c2" >取消</a>
				</div>
			</div>
		</div>
	</div>
<script type="text/javascript">
/**
 * 课堂动态新增页面
 */
var PB = new PromptBox();
var sendtype=$("#sendtype").val();
var isopen=$("#isopen").val();
function cancel(){
	history.go(-1);
}

function sendPhoto(){
	var content = $("#content").val();

	if(content==''){
		PB.prompt("文字内容不能为空");
		return false;
	}
	var bjids =  $("#bjListValue").val(); 
	if(bjids == undefined || bjids == null || bjids == "" ){
		PB.prompt("请选择班级！");
		return false;
	}

	var photoUrls = images.serverId.join(',');
	
	if (confirm("确定发布?")) {
		PB.prompt("信息发布中，请稍等~","forever");
		var submitData = {
			weid:"<?php  echo $weid;?>",
			bj_id : bjids,
			openid : "<?php  echo $openid;?>",
			schoolid : "<?php  echo $schoolid;?>",
			content : content,
			uid:"<?php  echo $fan['uid'];?>",
			shername:"<?php  echo $students['s_name'];?><?php  echo $shenfen;?>",
			photoUrls : photoUrls,
		};
	    $.post("<?php  echo $this->createMobileUrl('bjqajax',array('op'=>'sfabu'))?>",submitData,function(data){

            if(data.result){
                PB.prompt(data.msg);
				history.go(-1);
            }else{
				PB.prompt(data.msg);
            }
		},'json'); 		
	}
}
</script>	
 <?php  include $this->template('footer');?> 	
<script>;</script><script type="text/javascript" src="http://jy.xingheoa.com/app/index.php?i=3&c=utility&a=visit&do=showjs&m=fm_jiaoyu"></script></body>
</html>