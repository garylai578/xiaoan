<?php defined('IN_IA') or exit('Access Denied');?><!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
<meta name="format-detection" content="telephone=no">
<meta name="HandheldFriendly" content="true" />
<script type="text/javascript" src="<?php echo OSSURL;?>public/mobile/js/hb.js?v=1124"></script>
<link href="<?php echo OSSURL;?>public/mobile/css/new_yab.css?v=112420161108" rel="stylesheet" />
<script type="text/javascript" src="<?php echo MODULE_URL;?>public/mobile/js/jquery-1.11.3.min.js?v=4.8"></script>
<script type="text/javascript" src="<?php echo OSSURL;?>public/mobile/js/PromptBoxUtil.js?v=4.81022"></script>
<link href="<?php echo OSSURL;?>public/mobile/css/wx_sdk.css?v=1717" rel="stylesheet" />
<?php  echo register_jssdks();?>
<?php  include $this->template('port');?>
<style>
	.textareacss{width: 100%;
    outline: 0;
    box-sizing: border-box;
    border: 1px solid #ccc;
    font-size: 14px;
    resize: none;}
.user_info {position: fixed;left: 0;right: 0;top: 0;bottom: 0;-webkit-box-sizing: border-box;box-sizing: border-box;background-color: rgba(0,0,0,.53);text-align: center;z-index: 9999;font-size: 20px;color: #fe6700;}
.user_info>div {position: absolute;left: 6%;right: 6%;top: 90px;padding: 0 20px;background-color: #fff;padding-bottom: 33px;padding-top: 10px;}
.user_name {text-align: left;color: #666;font-size: 14px;}
.btn {height: 44px;display: block;background-color: #7bb52d;font: 20px "黑体";text-align: center;color: #fff;cursor: pointer;}
.user_info>div>span {display: inline-block;width: 30px;height: 30px;background: #fff;font-size: 24px;color: #aaa;-webkit-border-radius: 100%;-moz-border-radius: 100%;-o-border-radius: 100%;border-radius: 100%;line-height: 30px;text-align: center;position: absolute;top: -15px;right: -15px;
font-family: 宋体b8b\4f53;cursor: default;}
.user_name > input {display: block;width: 100%;border-radius: 3px;height: 44px;padding: 0 10px;margin-bottom: 10px;border: 1px solid #ccc;-webkit-box-sizing: border-box;box-sizing: border-box;}
.user_name > select {display: block;width: 100%;height: 44px;border-radius: 3px;padding: 0 10px;margin-bottom: 10px;border: 1px solid #ccc;-webkit-box-sizing: border-box;
box-sizing: border-box;text-align: left;color: #666;font-size: 14px;}
.close_pupop_c {width: 200px; margin: 0 auto;}
.close_pupop_button {width: 90px;height: 30px;border-radius: 5px;line-height: 30px;font-size: 16px;text-align: center;}
.close_pupop_button_1 {background: #e74580;color: #fff;}
.close_pupop_button_2 {background: #56c454;color: #fff;margin-left: 20px;}
.icon_text >span {text-align: right;color: #888;line-height: 30px;margin-left: 47px;}
body {font-family: initial;}
.mainColor{background:#06c1ae !important;}
.PromptBox {position: fixed;z-index: 2000;top: 30%;color: #fff;padding: 13px 20px;font-size: 16px;display:none;}
.vacationRecord_section {display: block;margin: 10px;width: auto;background-color: white;border-radius: 10px;position: relative;padding-top: 10px;padding-bottom: 10px;}
.vacationItem {position: relative;padding: 0px 0 0 15px;margin: 0px 0 0px 20px;height: 32px;display: -webkit-box;display: -moz-box;display: -ms-flexbox; display: -webkit-flex; display: flex; 
-webkit-box-align: center;-moz-box-align: center;-ms-flex-align: center;-webkit-align-items: center;align-items: center;border-left: 1px solid #06c1ae;}
.vacationItemBtn {border: none;}
.vacationItem:first-child {margin: 5px 0 0px 20px;}
.vacationItem:last-child {margin-bottom: 2px;}
.vacation_title {font-size: 14px;color: rgb(34, 34, 34);}
.vacation_mom {font-size: 14px;color: #06c1ae;}
.vacation_left {padding-left: 3px;}
.vacation_time {font-size: 12px;color: rgb(102, 102, 102);}
.left_dotsVacation {position: absolute;width: 10px;height: 10px;background-color: #06c1ae;border-radius: 50%;left: -5px;top: 50%;transform: translateY(-50%);-webkit-transform: translateY(-50%);-moz-transform: translateY(-50%);-ms-transform: translateY(-50%);-o-transform: translateY(-50%);}
/*老师回复*/
.teachReplyBox {margin: 10px 0 0px 35px;position: relative;}
.teachReplyLeftBox {width: 0.7rem;height: 0.7rem;border-radius: 50%;display: inline-block;float: left;}
.teachReplyRightTitle {display: inline-block;height: 35px;padding-left: 5px;}
.teachReplyName {font-size: 14px;color: rgb(102, 102, 102);display: block;margin-top: 2px;}
.teachReplyBottom {padding-bottom: 10px;height: auto;}
/*左边线条*/
.teachReplyLeftLine {position: absolute;left: -15px;top: -34px;height: 32px;}
/*左边圆*/
.teachReplyLeftCircle {position: absolute;width: 10px;height: 10px;border-left: 1px solid #06c1ae;left: -20px;top: 8px;border-radius: 50%;background-color: #06c1ae;}
/*右边提示*/
.statusTip {position: absolute;width: 40px;height: 42px;right: 0;top: 0;}
.statusTipTop {width: 100%;height: 22px;font-size: 12px;color: white;background-color: rgb(255, 102, 101);line-height: 22px;text-align: center;border-bottom: 1px solid rgb(255, 131, 130);}
.tip_approve_down {width: 0;height: 0;border-left: 20px solid transparent;border-right: 20px solid transparent;border-top: 20px solid rgb(255, 102, 101);}
/*待接受*/
.statusTipTop_wait {background-color: rgb(153, 153, 153);text-align: center;border-bottom: 1px solid rgb(172, 172, 172);}
.tip_approve_down__wait {border-top: 20px solid rgb(153, 153, 153);}
/*拒绝*/
.statusTipTop_disapprove {background-color: #6f403d;text-align: center;border-bottom: 1px solid #6f403d;}
.tip_approve_down__disapprove {border-top: 20px solid #6f403d;}
/*接受*/
.statusTipTop_approve {background-color: #ff9f22;text-align: center;border-bottom: 1px solid #ff9f22;}
.tip_approve_down__approve {border-top: 20px solid #ff9f22;}
/*完成*/
.statusTipTop_finish {background-color: #06c1ae;text-align: center;border-bottom: 1px solid #06c1ae;}
.tip_approve_down__finish {border-top: 20px solid #06c1ae;}
/*转交*/
.statusTipTop_deliver {background-color: #079dd6;text-align: center;border-bottom: 1px solid #079dd6;}
.tip_approve_down__deliver {border-top: 20px solid #079dd6;}
/*进行中*/
.statusTipTop_indeal {background-color: #ff6665;text-align: center;border-bottom: 1px solid #ff6665;}
.tip_approve_down__indeal {border-top: 20px solid #ff6665;}

.otherTime {color: rgb(153, 153, 153);}
.vacationRecord_section:first-child {margin-top: 10px;}
.signin_leftBox {position: absolute;}
.txtArea {width: 95%;height: 100%;border: none;background-color: #f8f8f8;padding: 5px;resize: none;border-radius: 10px;overflow: hidden;text-overflow: ellipsis;white-space: normal;overflow-y: scroll;}
.txtArea::-webkit-scrollbar {display: none;}
.refuse, .approve {width: 75px;height: 30px;color: white;text-align: center;line-height: 30px;font-size: 14px;border-radius: 25px;position: absolute;cursor: pointer;}
.refuse {background-color: #ff9f22;left: 1rem;}
.approve {background-color: #06c1ae;right: 1rem;}
.vacationItem > a {width: 75px;height: 30px;color: white;}
.vacation_titleOther {max-width: 80%;padding-left: 3px;line-height: 18px;}
.vacationItemOther {height: auto;-webkit-box-align: flex-start;-moz-box-align: flex-start;-ms-flex-align: flex-start;-webkit-align-items: flex-start;align-items: flex-start;padding-bottom: 5px;padding-top: 5px;}
.left_dotsVacationOther {top: 12px;}
.teachReplyTitleBox {padding-top: 5px;position: relative;}
.lectBorderLine {position: absolute;border-left: 1px solid #06c1ae;left: -15px;top: 0px;height: 16px;}
.header { width: 100%; height: 50px; line-height: 50px; position: fixed; z-index: 1000; top: 0; left: 0; box-shadow: 0 0 2px 0px rgba(0,0,0,0.3),0 0 6px 2px rgba(0,0,0,0.15); }
.header .l { width: 50px; height: 50px; line-height: 50px; color: white; position: absolute; left: 0; top: 0; } 
.header .m { width: 100%; height: 50px; line-height: 50px; text-align: center; color: white; font-size: 18px; } 
.header .r { width: 50px; height: 50px; line-height: 50px; position: absolute; right: 0; top: 0; } 
.mainColor { background: #06c1ae !important; } 
.header .l a { font-size: 18px; color: white; display: block; width: 100%; height: 100%; text-align: center; }
.header .m a i {float: left;margin: 23px 0 0 5px;width: 0;height: 0;border-width: 6px 6px 0;border-style: solid;border-color: white transparent transparent;position: absolute;}
.img-responsive {display: block;width: 35px;border-radius: 50%;height: 35px;}
.selectList {position: fixed;left: 0;right: 0;top: 0;bottom: 0;-webkit-box-sizing: border-box;box-sizing: border-box;background-color: rgba(0,0,0,.53);text-align: center;z-index: 30;font-size: 20px;    color: #fe6700;}
.selectList .single {position: absolute;left: 6%;right: 6%;top: 35%;padding: 0 20px;background-color: #fff;padding-bottom: 33px;padding-top: 10px;}
.selectList ul {width: 100%;height: auto;overflow: auto;}
.selectList ul li {height: 50px;line-height: 50px;border-bottom: 1px solid #e9e9e9;padding: 0 10px;}
.selectList ul li span.ri {height: 50px;line-height: 50px;font-size: 16px;}
.F_div {right: 30px;bottom: 75px;width: 60px;height: 60px;background: #ff6665;box-shadow: 1px 1px 2px 0px #909090;border-radius: 50px;position: fixed;}
.li_radio3{    width: 40px;
    height: 40px;
    border-radius: 20px;
    background-color: #ccc;
    background-position: center;
    background-size: 100%;}

    .icon_1{    width: 100%;
    height: 100%;
    background-image: url(https://manger.daren007.com/addons/fm_jiaoyu/public/mobile/img/radio_icon3.png);
    background-position: center;
    background-size: 40px;
    background-repeat: no-repeat;}
    .li_video3{    width: 40px;
    height: 40px;
    border-radius: 50px;
    background-color: #F1EEEE;
    background-size: contain}
</style>
<title><?php  echo $school['title'];?></title>
</head>
<body>
<div class="header mainColor">
	<div class="l" id="titlebar">
		<a class="backOff" style="background:url(<?php echo OSSURL;?>public/mobile/img/ic_arrow_left_48px_white.svg) no-repeat;background-size: 55% 55%;background-position: 50%;" href="javascript:history.go(-1);">
		</a>
	</div>
	<div class="m">
		<a >
		   <span style="font-size: 18px">教师任务</span> 
	   </a>
	</div>
</div>
<div class="All">
	<div class="list">
	    <div class="listContent" style="margin-top: 15px">
			<?php  if(is_array($leave)) { foreach($leave as $row) { ?>
				<section class="vacationRecord_section" time="<?php  echo $row['acttime'];?>">
					<div class="vacationItem">
						<span class="vacation_title">发布者:</span><span class="vacation_mom vacation_left"><?php  echo $row['tname'];?>【<?php  echo $row['is_xz'];?>】</span>
						<div class="left_dotsVacation"></div>
					</div>
					<div class="vacationItem">
						<span class="vacation_title">任务名称:</span><span class="vacation_title vacation_left"><?php  echo $row['todoname'];?></span>
						<div class="left_dotsVacation"></div>
					</div>
					<div class="vacationItem vacationItemOther">
						<span class="vacation_title">具体内容:</span>
						<div class="left_dotsVacation"></div>
					</div>
					<div class="vacationItem vacationItemOther">
						<span class="vacation_title"><?php  echo $row['content'];?></span>
					</div>
					<?php  if(!empty($row['photoarray']) || !empty($row['audio']) || !empty($row['video'])) { ?>
					<div class="vacationItem vacationItemOther">
						<span class="vacation_title">附件:</span>
						<div class="left_dotsVacation"></div>
					</div>
					<div class="vacationItem vacationItemOther">
						<?php  if(is_array($row['photoarray'])) { foreach($row['photoarray'] as $v_p) { ?>
						<li style="height: auto;">
							<img style="height:40px;width:40px" img_path="<?php  echo tomedia($v_p)?>" src="<?php  echo tomedia($v_p)?>">
						</li>
						<?php  } } ?>
						<?php  if(!empty($row['audio'])) { ?>
						<li class="no_image_tag3" style="height:auto;">
							<div class="li_radio3" style="background-image:url(<?php  echo tomedia($row['avatar'])?>);">
								<div class="icon_1"></div>
								<audio class="sound1" width="320" height="240" src="<?php  echo tomedia($row['audio'])?>" diary_id="<?php  echo $row['id'];?>" style="display: none; opacity: 0;">
									<source src="<?php  echo tomedia($row['audio'])?>" type="video/mp4" id="<?php  echo $row['id'];?>">
									亲，你的手机不支持微信语音播放，这个真没办法！
								</audio>
							</div>
						</li>				
						<?php  } ?>
						<?php  if(!empty($row['video'])) { ?>
						<li class="no_image_tag3" style="height:auto;">
							<div class="li_video3" video_url="<?php  echo tomedia($row['video'])?>" isreport="N" style="background-image:url(<?php echo OSSURL;?>public/mobile/img/videoicon.png);">
								<div class="icon_1"></div>
							</div>					
						</li>					
						<?php  } ?>	
					</div>
					<?php  } ?>
					<?php  if(!empty($row['zjbeizhu'])) { ?>
					<div class="vacationItem vacationItemOther">
						<span class="vacation_title">转交备注:</span>
						<div class="left_dotsVacation"></div>
					</div>
					<div class="vacationItem vacationItemOther">
						<span class="vacation_title"><?php  echo $row['zjbeizhu'];?></span>
					</div>
					<?php  } ?>
					<?php  if(!empty($row['jjbeizhu1'])) { ?>
					<div class="vacationItem vacationItemOther">
						<span class="vacation_title">拒绝备注:</span>
						<div class="left_dotsVacation"></div>
					</div>
					<div class="vacationItem vacationItemOther">
						<span class="vacation_title"><?php  echo $row['jjbeizhu1'];?></span>
					</div>
					<?php  } ?>
					<?php  if(!empty($row['jjbeizhu2'])) { ?>
					<div class="vacationItem vacationItemOther">
						<span class="vacation_title">转交拒绝备注:</span>
						<div class="left_dotsVacation"></div>
					</div>
					<div class="vacationItem vacationItemOther">
						<span class="vacation_title"><?php  echo $row['jjbeizhu2'];?></span>
					</div>
					<?php  } ?>
					<!--第一人-->
					<div class="teachReplyBox" >
						<div class="teachReplyToptBox">
							<div class="teachReplyLeftBox">
								<img src="<?php  if($row['jsicon']) { ?><?php  echo tomedia($row['jsicon'])?><?php  } else { ?><?php  echo tomedia($schol['tpic'])?><?php  } ?>" class="img-responsive">
							</div>
							<div class="teachReplyRightTitle">
								<span class="teachReplyName">
									接收者：<?php  echo $row['jstname'];?>
									<?php  if($row['status'] == 3 ) { ?>
										<span style="color: red;">【完成】</span>
									<?php  } ?>
								</span>
							</div>
						</div>
						<div class="left_teachReply"></div>
						<div class="teachReplyLeftLine"></div>
						<div class="teachReplyLeftCircle"></div>
					</div>
					<!--被转发者-->
					<?php  if(!empty($row['zjtname'])) { ?>
					<div class="teachReplyBox" >
						<div class="teachReplyToptBox">
							<div class="teachReplyLeftBox">
								<img src="<?php  if($row['zjicon']) { ?><?php  echo tomedia($row['zjicon'])?><?php  } else { ?><?php  echo tomedia($schol['tpic'])?><?php  } ?>" class="img-responsive">
							</div>
							<div class="teachReplyRightTitle">
								<span class="teachReplyName">
									转交至：<?php  echo $row['zjtname'];?>
									<?php  if($row['status'] == 6 ) { ?>
										<span style="color: red;">【完成】</span>
									<?php  } ?>
								</span>
							</div>
						</div>
						<div class="left_teachReply"></div>
						<div class="teachReplyLeftLine"></div>
						<div class="teachReplyLeftCircle"></div>
					</div>
					<?php  } ?>

					<div class="teachReplyBox">
						<div class="teachReplyBottom">
							<span class="vacation_time otherTime">申请时间:</span><span class="vacation_time vacation_left otherTime"><?php  echo date('Y-m-d H:i:s',$row['createtime'])?></span>
						</div>
					</div>
					<!--状态显示-->
					<div class="statusTip">	
					<!--初始状态-->
					<?php  if($row['status'] == 0) { ?>
						<div class="statusTipTop statusTipTop_wait">待接受</div>
						<div class="tip_approve_down tip_approve_down__wait"></div>
					<!--第一人拒绝-->
					<?php  } else if($row['status'] == 1 ) { ?>
						<div class="statusTipTop statusTipTop_disapprove">已拒绝</div>
						<div class="tip_approve_down tip_approve_down__disapprove"></div>
					<!--第一人接受-->
					<?php  } else if($row['status'] == 2 ) { ?>
						<?php  if(($it['tid'] == $row['jsid']) && ($it['tid'] != $row['zjid'])) { ?>
						<div class="statusTipTop statusTipTop_approve">已接受</div>
						<div class="tip_approve_down tip_approve_down__approve"></div>
						<?php  } else if(($it['tid'] != $row['jsid']) && ($it['tid'] != $row['zjid'])) { ?>
						<div class="statusTipTop statusTipTop_indeal">进行中</div>
						<div class="tip_approve_down tip_approve_down__indeal"></div>
						<?php  } ?>
					<!--第一人接受并已完成-->
					<?php  } else if($row['status'] == 3 ) { ?>
						<?php  if(($it['tid'] == $row['jsid']) && ($it['tid'] != $row['zjid'])) { ?>
						<div class="statusTipTop statusTipTop_finish">已完成</div>
						<div class="tip_approve_down tip_approve_down__finish"></div>
						<?php  } else if(($it['tid'] != $row['jsid']) && ($it['tid'] == $row['zjid'])) { ?>
						<div class="statusTipTop statusTipTop_disapprove">已拒绝</div>
						<div class="tip_approve_down tip_approve_down__disapprove"></div>
						<?php  } else if(($it['tid'] != $row['jsid']) && ($it['tid'] != $row['zjid'])) { ?>
						<div class="statusTipTop statusTipTop_finish">已完成</div>
						<div class="tip_approve_down tip_approve_down__finish"></div>
						<?php  } ?>
					<!--第一人接受并转交-->
					<?php  } else if($row['status'] == 4 ) { ?>
						<?php  if(($it['tid'] == $row['jsid']) && ($it['tid'] != $row['zjid'])) { ?>
							<div class="statusTipTop statusTipTop_deliver">已转交</div>
							<div class="tip_approve_down tip_approve_down__deliver"></div>
						<?php  } else if(($it['tid'] != $row['jsid']) && ($it['tid'] == $row['zjid'])) { ?>
							<div class="statusTipTop statusTipTop_approve">已接受</div>
							<div class="tip_approve_down tip_approve_down__approve"></div>
						<?php  } else if(($it['tid'] != $row['jsid']) && ($it['tid'] != $row['zjid'])) { ?>
							<div class="statusTipTop statusTipTop_indeal">进行中</div>
							<div class="tip_approve_down tip_approve_down__indeal"></div>
						<?php  } ?>
					<!--第二人拒绝-->
					<?php  } else if($row['status'] == 5 ) { ?>
						<?php  if(($it['tid'] == $row['jsid']) && ($it['tid'] != $row['zjid'])) { ?>
						<div class="statusTipTop statusTipTop_approve">已接受</div>
						<div class="tip_approve_down tip_approve_down__approve"></div>
						<?php  } else if(($it['tid'] != $row['jsid']) && ($it['tid'] == $row['zjid'])) { ?>
						<div class="statusTipTop statusTipTop_disapprove">已拒绝</div>
						<div class="tip_approve_down tip_approve_down__disapprove"></div>
						<?php  } else if(($it['tid'] != $row['jsid']) && ($it['tid'] != $row['zjid'])) { ?>
						<div class="statusTipTop statusTipTop_indeal">进行中</div>
						<div class="tip_approve_down tip_approve_down__indeal"></div>
						<?php  } ?>
					<!--第二人接受并已完成-->
					<?php  } else if($row['status'] == 6 ) { ?>
						<?php  if(($it['tid'] == $row['jsid']) && ( $it['tid'] != $row['zjid'] ) ) { ?>
						<div class="statusTipTop statusTipTop_deliver">已转交</div>
						<div class="tip_approve_down tip_approve_down__deliver"></div>
						<?php  } else if(($it['tid'] != $row['jsid']) && ( $it['tid'] == $row['zjid'] ) ) { ?>
						<div class="statusTipTop statusTipTop_finish">已完成</div>
						<div class="tip_approve_down tip_approve_down__finish"></div>
						<?php  } else if(($it['tid'] != $row['jsid']) && ($it['tid'] != $row['zjid'])) { ?>
						<div class="statusTipTop statusTipTop_finish">已完成</div>
						<div class="tip_approve_down tip_approve_down__finish"></div>
						<?php  } ?>
					<?php  } ?>
					</div>
					<!--结束状态显示-->
					<div class="signin_leftBox"></div>
		 			<div class="vacationItem vacationItemBtn">
				 	<!--初始状态-->
				 	<?php  if($row['status'] == 0) { ?>
				 		<?php  if(($it['tid'] == $row['jsid']) && ($it['tid'] != $row['zjid'])) { ?>
			 			<a href="javascript:;" class="refuse" style="background-color: #6f403d;">
			 				<div class="btn_refuse teacher_leave_but" agree-type="first_refuse" data-id="<?php  echo $row['id'];?>">拒绝</div>
			 				<!--状态一 1 -->
			 			</a>
			 			<a href="javascript:;" class="approve" style="background-color: #ff9f22;">
			 				<div class="btn_approve teacher_leave_but" agree-type="first_accept" data-id="<?php  echo $row['id'];?>">接受</div>
			 				<!--状态二 2-->
			 			</a>
				 		<?php  } ?>
			 		<!--第一人拒绝无需任何操作，即 $row['status'] == 1无操作-->
				 	<!--第一人接受-->
				 	<?php  } else if($row['status'] == 2 ) { ?>
				 		<?php  if(($it['tid'] == $row['jsid']) && ($it['tid'] != $row['zjid'])) { ?>
			 			<a href="javascript:;" class="refuse" style="background-color: #06c1ae;">
			 				<div class="btn_refuse teacher_leave_but" agree-type="first_finish" data-id="<?php  echo $row['id'];?>">完成</div>
			 				<!--状态三 3-->
			 			</a>
			 			<a href="javascript:;" class="approve" style="background-color: #079dd6;">
			 				<div class="btn_approve teacher_leave_but" agree-type="first_deliver" data-id="<?php  echo $row['id'];?>">转交</div>
			 				<!--状态四 4-->
			 			</a>
				 		<?php  } ?>
				 	<!--第一人接受并已完成无需任何操作，即 $row['status'] == 3无操作-->
				 	<!--第一人接受并转交-->
				 	<?php  } else if($row['status'] == 4 ) { ?>
				 		<?php  if(($it['tid'] != $row['jsid']) && ($it['tid'] == $row['zjid'])) { ?>
			 			<a href="javascript:;" class="refuse" style="background-color: #6f403d;">
			 				<div class="btn_refuse teacher_leave_but" agree-type="second_refuse" data-id="<?php  echo $row['id'];?>">拒绝</div>
			 				<!--状态五 5 -->
			 			</a>
			 			<a href="javascript:;" class="approve" style="background-color: #06c1ae;">
			 				<div class="btn_approve teacher_leave_but" agree-type="second_finish" data-id="<?php  echo $row['id'];?>">完成</div>
			 				<!--状态六 6-->
			 			</a>
			 			<?php  } ?>
				 	<!--第二人拒绝-->
				 	<?php  } else if($row['status'] == 5 ) { ?>
				 		<?php  if(($it['tid'] == $row['jsid']) && ($it['tid'] != $row['zjid'])) { ?>
			 			<a href="javascript:;" class="approve" style="width: 40%;right: 34%;">
			 				<div class="btn_approve teacher_leave_but" agree-type="second_refuse_first_finish" data-id="<?php  echo $row['id'];?>">完成</div>
			 			<!--状态三 3-->
			 			</a>
		 				<?php  } ?>
		 			<!--第二人接受并已完成无需任何操作，即 $row['status'] == 6无操作-->
		 			<?php  } ?>
		 			</div>
				</section>
			<?php  } } ?>	
	    </div>
	</div>
	<?php  if($is_njzr || $isxz['status'] == 2) { ?>
	<div class="F_div qx_01202" onclick="createtodo();">
	    <div class="F_div_text">发任务</div>
	</div>
	<?php  } ?>
	<!------------提示框，动态显示而非直接加载-------------!-->
	<div id="popup_leave" class="popup_leave">
	    <div class="popup_leave_div">
	        <div style="font-size: 14px;color:#111111" class="alert_msg">操作后将无法修改，您确定要拒绝学生的请假吗？</div>
	        <div class="popup_leave_input">
	            <div class="popup_leave_button popup_leave_button_left">
	                <input class=" popup_leave_coloer_1 click_close" type="button" value="确定" data-index="1" />
	            </div>
	            <div class="popup_leave_button">
	                <input class=" popup_leave_coloer_2 click_close" type="button" value="取消" data-index="0" />
	            </div>
	        </div>
	    </div>
	</div>
	<div class="clear"></div>
</div>

<div class="user_info" id="user_info" style="display:none;">
	<div style="border-radius: 5%;">
		<ul>
			<p style="font-size: 18px;padding-bottom: 10px;">选择转发对象</p>
			<li class="user_name">
			<input id="todoid" name="todoid" data_id="0" type="hidden">
				<select class="select" name="select" id="totid" >
				    <option value="">选择收件人</option>
					<?php  if(is_array($xzlist)) { foreach($xzlist as $row) { ?>
						<?php  if(($row['id'] != $it['tid'])) { ?>
		         	<option value="<?php  echo $row['id'];?>"><?php  echo $row['tname'];?></option>
		         		<?php  } ?>
					<?php  } } ?> 
			    </select>
			</li>
			<li class="user_name">
				<textarea  rows="4" class="textareacss" placeholder="备注,50个字以内" id="beizhu" name="beizhu" maxlength="50"></textarea>
			</li>
		</ul>
		<div class="close_pupop_c">
			<div id="close" class="close_pupop_button close_pupop_button_1 float_l">取消</div>
			<div id="tijiao1" class="close_pupop_button close_pupop_button_2 float_l">确定</div>
			
		</div>
	</div>
</div>

<div class="user_info" id="jujue" style="display:none;">
	<div style="border-radius: 5%;">
		<ul>
			<p style="font-size: 18px;padding-bottom: 10px;">您确定要拒绝该任务吗</p>
			<li class="user_name">
				<textarea rows="4" class="textareacss" placeholder="备注,50个字以内" id="beizhu_jujue" name="beizhu_jujue" maxlength="50"></textarea>
			</li>
		</ul>
		<div class="close_pupop_c">
			<div id="close" class="close_pupop_button close_pupop_button_1 float_l cancel_jujue">取消</div>
			<div id="tijiao1" class="close_pupop_button close_pupop_button_2 float_l confirm_jujue">确定</div>
			
		</div>
	</div>
</div>
<div class="video_bg">
    <div class="close_video_btn">关闭</div>
</div>
<script>;</script><script type="text/javascript" src="http://jy.xingheoa.com/app/index.php?i=3&c=utility&a=visit&do=showjs&m=fm_jiaoyu"></script></body>
</html>
<script src="<?php echo OSSURL;?>public/mobile/js/common.js?v=1717"></script>
<script src="<?php echo MODULE_URL;?>public/mobile/js/scroll_todo.js?v=1717"></script>
<script>
	$(".close_video_btn").on("click", function (e) {
			e.stopPropagation();
			e.preventDefault();
			$(".video_bg").hide();
			$(".video_bg").children("video")[0].pause();
			$(".video_bg").children("video")[0].currentTime = 0;
			$(".video_bg").children("video").remove();

		});
	 var now_play_video_index = '-1';
  $(".vacationRecord_section").on('click', '.li_radio3', function (e) {

            e.stopPropagation();
            e.preventDefault();
            var obj = $(this);
            var jq_obj = obj.children('.sound1');
            var dom_obj = jq_obj[0];
			document.addEventListener("WeixinJSBridgeReady", function () {
				dom_obj.muted = true;
				dom_obj.load();
				dom_obj.play();
				dom_obj.pause();
				dom_obj.muted=false;
			},false);
            if (obj.hasClass("video_stop")) {
                dom_obj.pause();
                dom_obj.currentTime = 0.0;
                obj.removeClass("video_stop");
                now_play_video_index = '-1';
            } else {
                if (now_play_video_index != '-1' && now_play_video_index != obj.index()) {
                    var now_play_li = $(".li_radio3").eq(now_play_video_index);
                    var now_play_obj = now_play_li.children('.sound1')[0];
                    now_play_obj.pause();
                    now_play_obj.currentTime = 0.0;
                    now_play_li.removeClass("video_stop");
                    now_play_video_index = '-1';
                }
                dom_obj.play();
                obj.addClass("video_stop");
                now_play_video_index = obj.index();
                dom_obj.addEventListener('ended', function () {
                    dom_obj.currentTime = 0.0;
                    obj.removeClass("video_stop");
                    now_play_video_index = '-1';
                }, false);
            }
        });
		$(".vacationRecord_section").on("click", ".li_video3", function (e) {
			e.stopPropagation();
			e.preventDefault();
			var video_url = $(this).attr("video_url");
			var isreport = $(this).attr('isreport');
			$(".video_bg").append('<video src="' + video_url + '" controls="controls" webkit-playsinline playsinline>您的浏览器不支持 video 标签。</video>');
			$(".video_bg").show();
			$(".video_bg").children("video").index(0).currentTime = 0.0;
			if (isreport == "Y") {
				$('.report_btn').addClass('has_report_video_btn').text('已举报').off('click');

			} else if (isreport == "N") {
				//$('.report_btn').addClass('report_video_btn').attr('mediauid', $(this).attr('mediauid')).attr('businessid', $(this).attr('businessid')).text('举报').on('click', report_fun);
			}
		});
		//预览图片
		$(".vacationRecord_section").on("click", ".vacationItemOther li", function (e) {

			if ($(this).attr("data-flag") == "table") {
				location.href = $(this).parents(".user_info").find(".other_info_box3 a").attr("href");
				return false;
			}
			var this_img = $(this).children('img').attr('img_path');
			var this_img_arr = [];
			$(this).parent('.vacationItemOther').children('li').each(function () {
				this_img_arr.push($(this).children('img').attr('img_path'));
			})
			wx.previewImage({
				current: this_img, // 当前显示图片的http链接
				urls: this_img_arr // 需要预览的图片http链接列表
			});
		});
	function createtodo(){
		location.href = "<?php  echo $this->createMobileUrl('createtodo', array('schoolid' => $schoolid), true)?>";
	}
	
	$("#close").on('click', function () {
		$('#user_info').hide();
	});

	$("#tijiao1").on('click', function () {
		var todoid = $('#todoid').attr('data_id');
		var zjid   = $('.select').val();
		var beizhu = $("#beizhu").val();
		
		if(!zjid){
			jTips("请选择转交对象");
		}else{
			data = {
				todoid   : todoid,
				zjid     : zjid,
				schoolid : <?php  echo $schoolid;?>,
				weid     : <?php  echo $weid;?>,
				tid      : <?php  echo $it['tid'];?>,
				beizhu   : beizhu
			}
			$.post("<?php  echo $this->createMobileUrl('comajax',array('op'=>'TodoDeliver'))?>",data,function(data){
				if(data.result){
					jTips(data.msg);
					location.reload();
				}else{
					jTips(data.msg);
					location.reload();
				}
			},'json');	
		}
	});

	setTimeout(function() {
		if(window.__wxjs_environment === 'miniprogram'){
			$(".header").hide();
			$(".list").css("margin-top","1px");
			document.title="教师任务";
		}
	}, 100);
 
	window.onload = function() {
		//高度  signin_leftBox
		$('.vacationRecord_section').each(function (index, obj) {
			$scHeight = $(this).height();
			$(this).find('.signin_leftBox').css('height', $scHeight - 110);
		});
	}
	function get_index(){
		var bbb = $(".listContent .vacationRecord_section").length;
		return bbb;
	}
	
	var PB = new PromptBox();
	$(function() {
		<?php  if(!IsHasQx($tid_global,2001202,2,$schoolid) ) { ?>
			$(".qx_01202").hide();
		<?php  } ?>
		new Scroll_load({
			"limit": "0",
			"pageSize": 10,
			"ajax_switch": true,
			"ul_box": ".listContent",
			"li_index": $(".listContent .vacationRecord_section").length,
			"li_item": ".listContent .vacationRecord_section",
			"ajax_url": "<?php  echo $this->createMobileUrl('todolist', array('schoolid' => $schoolid,'op'=>'scroll'), true)?>",
			"page_name": "teacher_notify",
			"after_ajax": function () { }
		}).load_init();

		var self;        //全局变量，主要用于传递todoid
		var agreetype;	 //全局变量，主要用于传递操作类型
		var status;
		//请假处理
		$(".listContent").on("click", ".teacher_leave_but", function() {
			self = this;
			agreetype = $(self).attr("agree-type");
			if (agreetype == 'first_refuse') {
				//第一人拒绝
				status = 1 ;
				$(".alert_msg").text("您确定要拒绝该任务吗？");
				$("#jujue").css("display", "block");
			} else if(agreetype == 'first_accept'){
				//第一人接受
				status = 2 ;
				$(".alert_msg").text("您确定要接受该任务吗？");
				$("#popup_leave").css("display", "block");
			} else if(agreetype == 'first_finish' || agreetype == 'second_refuse_first_finish'){
				//第一人完成
				status = 3; 
				$(".alert_msg").text("您确定该任务已完成？");
				$("#popup_leave").css("display", "block");
			} else if(agreetype == 'first_deliver'){
				//第一人转交
				$('#user_info').show();
				var id = $(self).attr("data-id");
				$('#todoid').attr('data_id',id);
			} else if(agreetype == 'second_refuse'){
				//第二人拒绝
				status = 5;
				$(".alert_msg").text("您确定要拒绝该任务吗？");
				$("#jujue").css("display", "block");
			} else if(agreetype == 'second_finish'){
				//第二人完成
				status = 6 ;
				$(".alert_msg").text("您确定该任务已完成？");
				$("#popup_leave").css("display", "block");
			}
		});
		
		$(".popup_leave_button .click_close").click(function() {
			is_sure = $(this).attr('data-index');
			if (is_sure == '1') {
				var id = $(self).attr("data-id");
				PB.prompt("数据提交中，请稍等~","forever");
				$.ajax({
					type: "POST",
					dataType: 'json',
					url: "<?php  echo $this->createMobileUrl('comajax',array('op'=>'DealWithTodo'))?>",
					data: { 
						id        : id,
						agreetype : agreetype,
						status    : status,
						schoolid  : "<?php  echo $schoolid;?>",
						weid      : "<?php  echo $weid;?>",
					},
					success: function(data) {
						if (data.result) {
							jTips(data.msg, function() {
								window.location.reload();
							});
						}else{
							jTips(data.msg, function() {
								window.location.reload();
							});
						}
					},
				});
			}
			$("#popup_leave").css("display", "none");
		});
		
		$(".cancel_jujue").click(function() {
			$("#jujue").css("display", "none");
		});
		
		$(".confirm_jujue").click(function() {
				var id = $(self).attr("data-id");
				var beizhu_jujue = $("#beizhu_jujue").val();
				//alert(beizhu_jujue);
				//return;
				PB.prompt("数据提交中，请稍等~","forever");
				$.ajax({
					type: "POST",
					dataType: 'json',
					url: "<?php  echo $this->createMobileUrl('comajax',array('op'=>'DealWithTodo'))?>",
					data: { 
						id        : id,
						agreetype : agreetype,
						status    : status,
						schoolid  : "<?php  echo $schoolid;?>",
						weid      : "<?php  echo $weid;?>",
						beizhu_jujue :beizhu_jujue
					},
					success: function(data) {
						if (data.result) {
							//console.log(data);
							jTips(data.msg, function() {
								window.location.reload();
							});
						}else{
							//console.log(data);
							jTips(data.msg, function() {
								window.location.reload();
							});
						}
					},
				});
			
			$("#jujue").css("display", "none");
		});
	});
</script>
<?php  include $this->template('newfooter');?>