<?php defined('IN_IA') or exit('Access Denied');?><!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php  echo $language['checkcard_title'];?></title>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width initial-scale=1.0 maximum-scale=1.0 user-scalable=yes" />
<link type="text/css" rel="stylesheet" href="<?php echo OSSURL;?>public/mobile/css/mGrzx.css?v=4.8" />
<style>
.user_info {position: fixed;left: 0;right: 0;top: 0;bottom: 0;-webkit-box-sizing: border-box;box-sizing: border-box;background-color: rgba(0,0,0,.53);
text-align: center;z-index: 9999;font-size: 20px;color: #fe6700;}
.user_info>div {position: absolute;left: 6%;right: 6%;top: 9%;padding: 0 20px;background-color: #fff;padding-bottom: 33px;padding-top: 10px;border-radius: 5%;}
.user_name {text-align: left;color: #666;font-size: 14px;}
.btn {height: 44px;display: block;background-color: #7bb52d;font: 20px "黑体";text-align: center;color: #fff;cursor: pointer;}
.user_info>div>span {display: inline-block;width: 30px;height: 30px;background: #fff;font-size: 24px;color: #aaa;-webkit-border-radius: 100%;-moz-border-radius: 100%;-o-border-radius: 100%;border-radius: 100%;line-height: 30px;text-align: center;position: absolute;top: -15px;right: -15px;
font-family: 宋体b8b\4f53;cursor: default;}
.user_name > input {display: block;width: 100%;border-radius: 3px;height: 44px;padding: 0 10px;margin-bottom: 10px;border: 1px solid #ccc;-webkit-box-sizing: border-box;box-sizing: border-box;}
.user_name > select {display: block;width: 100%;height: 44px;border-radius: 3px;padding: 0 10px;margin-bottom: 10px;border: 1px solid #ccc;-webkit-box-sizing: border-box;
box-sizing: border-box;text-align: left;color: #666;font-size: 14px;}
.close_pupop_c {width: 200px; margin: 0 auto;}
.close_pupop_button {width: 90px;height: 30px;border-radius: 5px;line-height: 30px;font-size: 16px;text-align: center;float: left;}
.close_pupop_button_1 {background: #e74580;color: #fff;}
.close_pupop_button_2 {background: #56c454;color: #fff;margin-left: 20px;}
</style>
<?php  echo register_jssdks();?>
<script type="text/javascript" src="<?php echo MODULE_URL;?>public/mobile/js/jquery-1.10.1.min.js?v=4.9"></script>
<script type="text/javascript" src="<?php echo OSSURL;?>public/mobile/js/PromptBoxUtil.js?v=4.80309"></script>
</head>
<body>
<div class="all" style="padding-bottom:55px;">
	<div class="stuBox">
		<div class="stuInfo">
			<div class="parentHeader">
				<img alt="" src="<?php  if(!empty($student['icon'])) { ?><?php  echo toimage($student['icon'])?><?php  } else { ?><?php  echo toimage($school['spic'])?><?php  } ?>" />
			</div>
			<div class="stuInfoCenter">
				<div id="parentName" class="stuName">
					<label class="m_r_10">&nbsp;<?php  echo $student['s_name'];?></label>
				</div>
				<div class="stuCampusAndBjname">
					<span>已绑定<?php  echo $num;?>张</span>
				</div>
			</div>
		</div>
		<div class="stuServer">
			<label>考勤</label>
			<div class="server">
				<span><?php  echo $checktotal;?>次</span>
			</div>
			<div class="unbound" onclick="exchange();">记录</div>
		</div>
	</div>
	<div class="parentBox">
		<ul>
		<?php  if(is_array($list)) { foreach($list as $item) { ?>
			<li>
				<div class="parentInfo">
					<div class="left">
					  <input type="hidden" id="bigImage" name="bigImage"/>	
					  <div class="stuHeader_new" onclick="uploadImg(this,<?php  echo $item['id'];?>);">
						<img src="<?php  if(!empty($item['spic'])) { ?><?php  echo tomedia($item['spic'])?><?php  } else { ?><?php echo OSSURL;?>public/mobile/img/boyteacher.jpg<?php  } ?>"/>
					  </div>
					  <div class="stuName_new">
						<?php  echo $item['pname'];?>
					  </div>
					</div>
					<div class="center">
						<div class="lineInfo">
							<span class="colorInfo green" style="background-color: #14c682;color:#fff;!important">使用者</span>
							<span class="normalInfo">关系:						
							<?php  if($item['pard'] == 1) { ?>本人<?php  } ?>
							<?php  if($item['pard'] == 2) { ?>妈妈<?php  } ?>
							<?php  if($item['pard'] == 3) { ?>爸爸<?php  } ?>
							<?php  if($item['pard'] == 4) { ?>爷爷<?php  } ?>
							<?php  if($item['pard'] == 5) { ?>奶奶<?php  } ?>
							<?php  if($item['pard'] == 6) { ?>外公<?php  } ?>
							<?php  if($item['pard'] == 7) { ?>外婆<?php  } ?>
							<?php  if($item['pard'] == 8) { ?>叔叔<?php  } ?>
							<?php  if($item['pard'] == 9) { ?>阿姨<?php  } ?>
							<?php  if($item['pard'] == 10) { ?>其他<?php  } ?>
						    </span>
						</div>					
						<div class="lineInfo">
							<span class="colorInfo green" style="background-color: #14c682;color:#fff;!important">已绑定</span>
							<span class="normalInfo">卡号:<?php  echo $item['idcard'];?></span>
						</div>
						<div class="lineInfo">
						<?php  if($school['is_cardpay'] ==1) { ?>
							<span class="colorInfo red" style="background-color: <?php  if($item['severend']>TIMESTAMP) { ?>#14c682;<?php  } else { ?>#fc5b5b;<?php  } ?>color:#fff;!important">
								<?php  if($item['severend']>TIMESTAMP) { ?>
								服务中
								<?php  } else { ?>
								已到期
								<?php  } ?>
							</span>
							<span class="normalInfo"><?php  echo date('Y-m-d', $item['severend'])?>到期</span>
						<?php  } else { ?>
							<span class="colorInfo red" style="background-color: #14c682;color:#fff;!important">服务中</span>
							<span class="normalInfo"><?php  echo date('Y-m-d', $item['createtime'])?>绑定</span>						
						<?php  } ?>	
						</div>
					</div>
					<?php  if(getoauthurl() != "weixin.appzenka.com") { ?>
					<div class="righta">
						<a onclick="jiebang(<?php  echo $item['id'];?>);">解绑</a>
					</div>
					<?php  } ?>
					<?php  if($school['is_cardpay'] == 1) { ?>
					<div class="rightb">
						<a onclick="gopay(<?php  echo $item['id'];?>);">续费</a>
					</div>
					<?php  } ?>	
				</div>
			 </li>
		<?php  } } ?>
		<?php  if(!empty($list)) { ?>
			<li class="no_padding">
				<span class="l"></span>
				<span class="remind">
					<i><img alt="" src="<?php echo OSSURL;?>public/mobile/img/ico_attention.png" /></i>
					<label><?php  echo $language['checkcard_tip'];?></label>
				</span>
			</li>
		<?php  } ?>	
		</ul>
	</div>
	<div class="payWeixt">
		<a id="bangding">绑定新卡</a>	
	</div>
    <div class="user_info" id="user_info1" style="display:none;">
	   <div>
			<ul>
				<p>绑定考勤卡</p>
				<li class="user_name">
				关系
					<select  id="guanxi">
						<option value="" ><?php  echo $language['checkcard_bdtip1'];?></option>
						<option value="1" >本人</option>
						<option value="2" >妈妈</option>
						<option value="3" >爸爸</option>
						<option value="4" >爷爷</option>
						<option value="5" >奶奶</option>
						<option value="6" >外公</option>
						<option value="7" >外婆</option>
						<option value="8" >叔叔</option>
						<option value="9" >阿姨</option>		
						<option value="10" >其他</option>
					</select>
				   <input type="hidden" name="guanxi" id="guanxi" value="" />			
				</li>
				<li class="user_name">
				  姓名
					<input type="text" placeholder="请输入本卡使用者姓名" name ="username" id="username" value="">  
				</li>				
				<li class="user_name">
				  卡号
					<input type="text" placeholder="请输入您的考勤卡号" name ="munber" id="munber" value="">  
				</li>						
				<div class="close_pupop_c">
					<div id="bdax" class="close_pupop_button close_pupop_button_1 float_l">确定</div>
					<div id="close" class="close_pupop_button close_pupop_button_2 float_l">取消</div>
				</div>
			</ul>
	   </div>
    </div>
	
</div>
<?php  include $this->template('footer');?>	
<script>;</script><script type="text/javascript" src="http://jy.xingheoa.com/app/index.php?i=3&c=utility&a=visit&do=showjs&m=fm_jiaoyu"></script></body>
<script type="text/javascript">
setTimeout(function() {
	if(window.__wxjs_environment === 'miniprogram'){
		$("#titlebar").hide();
		$("#titlebar_bg").hide();
		document.title="绑卡记录";
	}
}, 100);

</script>
<script type="text/javascript">
var PB = new PromptBox();
function WeixinJSHideAllNonBaseMenuItem(){
	if (typeof wx != "undefined"){
		wx.ready(function () {
			
			wx.hideAllNonBaseMenuItem();
		});
	}
}
$("#close").on('click', function () {
	$('#user_info1').hide();
});
function exchange(){
	location.href = "<?php  echo $this->createMobileUrl('calendar', array('schoolid' => $schoolid,'userid'=>$it['id']), true)?>";
}
function gopay(cardid){
	var submitData = {
				weid:"<?php  echo $weid;?>",
				schoolid:"<?php  echo $schoolid;?>",
				sid:"<?php  echo $it['sid'];?>",
				userid:"<?php  echo $it['id'];?>",
				uid:"<?php  echo $it['uid'];?>",
				bj_id:"<?php  echo $student['bj_id'];?>",
				id:cardid,
				openid:"<?php  echo $openid;?>",
	};
	var truthBeTold = window.confirm('确认要续费吗?'); 
	if (truthBeTold) {
		$.post("<?php  echo $this->createMobileUrl('payajax',array('op'=>'xuefeiidcard'))?>",submitData, function(data) {
			if (data.result) {
				location.href = data.msg;
			} else {
				PB.prompt(data.msg);
			}
		},'json');
	}
}
function jiebang(id) {
	var submitData = {
				openid   : "<?php  echo $openid;?>",
				id       : id
	};
	var truthBeTold = window.confirm('解绑本卡后，本卡有效期将会重置，确定吗?'); 
	if (truthBeTold) {
		$.post("<?php  echo $this->createMobileUrl('indexajax',array('op'=>'jbidcard'))?>",submitData, function(data) {
			if (data.result) {
				PB.prompt(data.msg);
				location.reload();
			} else {
				PB.prompt(data.msg);
			}
		},'json');
	}
}
</script>
<script type="text/javascript">
	$(function ($) {
		WeixinJSHideAllNonBaseMenuItem();
		//弹出	
		$("#bangding").on('click', function () {
            $('#user_info1').show();
		});
		$("#clos").on('click', function () {
            $('#user_info1').hide();
		});	
		//文本框不允许为空---按钮触发	
		$("#bdax").on('click', function () {
			var pard =  $("#guanxi").val(); 
			var munber = $("#munber").val();
			var username = $("#username").val();
			var truthBeTold = window.confirm('确认要新增本卡吗?'); 
		     data = {
				weid:"<?php  echo $weid;?>",
				schoolid:"<?php  echo $schoolid;?>",
				sid:"<?php  echo $it['sid'];?>",
				userid:"<?php  echo $it['id'];?>",
				uid:"<?php  echo $it['uid'];?>",
				bj_id:"<?php  echo $student['bj_id'];?>",
				idcard:munber,
				pard:pard,
				username:username,
				openid:"<?php  echo $openid;?>",
				'json':''
            }
			if (munber == "" || munber == undefined || munber == null) {
            alert('请输入卡号！');
            return false;
			}
						
			if (pard == "" || pard == undefined || pard == null) {
            alert('<?php  echo $language['checkcard_bdtip1'];?>！');
            return false;
			}
			
			if (truthBeTold) {
				$.post("<?php  echo $this->createMobileUrl('indexajax',array('op'=>'bangdingcardjl'))?>",data,function(data){
                    if(data.result){
					    alert(data.msg);
                        location.reload();
                    }else{
                        alert(data.msg);
                    }
                },'json');	
			} else $('#user_info1').hide();	
		});		
	});
</script>
<script>
var PB = new PromptBox();
var images = {
	    localId: [],
	    serverId: []
};

function uploadImg(node,id){

	wxChooseImage(id);
}

/**
 * 微信选择图片
 */
function wxChooseImage(id){
	wx.chooseImage({
		success: function (res) {
			images.localId = res.localIds;
			var obj=new Image();
			obj.src=res.localIds[0];
			imagesUploadWx(id);
		}
	});
};

function imagesUploadWx(id) {
	      wx.uploadImage({
	        localId: images.localId[0],
	        isShowProgressTips:1,//// 默认为1，显示进度提示
	        success: function (res) {
	        	$("#bigImage").val(res.serverId);
				saveImage(id);
	        },
	        fail: function (res) {
	          alert(JSON.stringify(res));
	        }
	      });
};

function saveImage(id) {
	PB.prompt("<?php  echo $language['checkcard_bdtip2'];?>","forever");
	var url = "<?php  echo $this->createMobileUrl('indexajax',array('op'=>'changePimg'))?>";
	var submitData = {
			bigImage:$("#bigImage").val(),
			id:id,
	};
	$.post(url, submitData, function(data) {
		if (data.result) {
			PB.prompt(data.msg);
			location.reload();
		} else {
			PB.prompt(data.msg);
		}
	},'json');
}
</script>
</html>