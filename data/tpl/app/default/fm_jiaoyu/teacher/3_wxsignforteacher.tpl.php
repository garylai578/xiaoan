<?php defined('IN_IA') or exit('Access Denied');?><!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html" charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0" />
<meta name="apple-mobile-web-app-capable" content="no" />
<meta name="format-detection" content="telephone=no" />
<meta name="HandheldFriendly" content="true" />
<link rel="stylesheet" type="text/css" href="<?php echo OSSURL;?>public/mobile/css/new_yab1.css?v=1?v=1111" />
<link rel="stylesheet" type="text/css" href="<?php echo OSSURL;?>public/mobile/css/common.css" />
<!--<script type="text/javascript" src="https://map.qq.com/api/js?v=2.exp&key=YOUR_KEY&libraries=convertor"></script>
-->
<style type="text/css">
.header { width: 100%; height: 50px; line-height: 50px; position: fixed; z-index: 1000; top: 0; left: 0; box-shadow: 0 0 2px 0px rgba(0,0,0,0.3),0 0 6px 2px rgba(0,0,0,0.15); } .header .l { width: 50px; height: 50px; line-height: 50px; color: white; position: absolute; left: 0; top: 0; } .header .m { width: 100%; height: 50px; line-height: 50px; text-align: center; color: white; font-size: 18px; } .header .r { width: 50px; height: 50px; line-height: 50px; position: absolute; right: 0; top: 0; } .mainColor { background: <?php  echo $school['headcolor'];?> !important; } .header .l a { font-size: 18px; color: white; display: block; width: 100%; height: 100%; text-align: center; }
.wd{background-color: #ff635b; border: 1px solid #ff635b; color: #fff; border-radius: 3px;font-size: 12px; height: 16px;line-height: 14px;padding: 1px 2px;margin: 0 1px;}
.signin_section {display: block;margin: 10px;width: auto;background-color: white;border-radius: 10px;position: relative;height: 186px;margin-top:70px;}
.signin_vacationInfo {position: relative;padding: 10px;margin: 0px 0 0px 18px;}
.signin_vacationInfo .signin_mom {color: rgb(34, 34, 34) !important;font-size: 14px;}
.signin_popup_titleInfo {font-size: 14px;}
.signin_mom .signin_sectioncolor: rgb(34, 34, 34);margin-left: 3px;}
.signin_popup_title {font-size: 16px;color: rgb(102, 102, 102);}
.signin_left_dotsVacation {position: absolute;width: 10px;height: 10px;background-color: rgb(51, 189, 97);border-radius: 50%;left: -5px;top: 50%;transform: translateY(-50%);-webkit-transform: translateY(-50%);-moz-transform: translateY(-50%);-ms-transform: translateY(-50%);-o-transform: translateY(-50%);}
.signin_popup_time {font-size: 12px;color: rgb(140, 140, 140);}
.signin_popup_time {margin-left: 3px;}
.signin_vacationInfo:last-child {padding-bottom: 40px;}
.signin_leftBox {position: absolute;border-left: 1px solid rgb(51, 189, 97);left: 18px;top: 15px;height: 120px;}
.needSignin {position: absolute;top: 150px;left: 25%;transform: translateX(-25%);-webkit-transform: translateX(-25%);-moz-transform: translateX(-25%);-ms-transform: translateX(-25%);-o-transform: translateX(-25%);color: white;background-color: rgb(255, 102, 101);width: 120px;height: 30px;border-radius: 15px;display: inline-block;text-align: center;line-height: 30px;font-size: 14px;}
.needSigninShow {position: absolute;top: 150px;left: 40%;transform: translateX(-25%);-webkit-transform: translateX(-25%);-moz-transform: translateX(-25%);-ms-transform: translateX(-25%);-o-transform: translateX(-25%);color: white;background-color: rgb(255, 102, 101);width: 120px;height: 30px;border-radius: 15px;display: inline-block;text-align: center;line-height: 30px;font-size: 14px;}
.btnBack {position: fixed;right: 0.76rem;bottom: 1rem;width: 1.2rem;height: 1.2rem;background-color: rgb(51, 189, 97);text-align: center;line-height: 1.2rem;border-radius: 50% 50%;color: white !important;
font-size: 0.3rem;}
.needSignin.awitAffirm {background-color: rgb(153, 153, 153);}
.needSignin1 {position: absolute;top: 150px;right: 5%;transform: translateX(-25%);-webkit-transform: translateX(-25%);-moz-transform: translateX(-25%);-ms-transform: translateX(-25%);-o-transform: translateX(-25%);color: white;background-color: rgb(230, 137, 26);width: 120px;height: 30px;border-radius: 15px;display: inline-block;text-align: center;line-height: 30px;font-size: 14px;}
/*没有内容*/
.noContent {position: absolute;top: 0;left: 0;width: 100%;}
.noContent1 {position: absolute;top: 0;left: 0;width: 100%;}
</style> 
<?php  echo register_jssdks();?>
<script type="text/javascript" src="<?php echo MODULE_URL;?>public/mobile/js/jquery-1.11.3.min.js?v=4.8"></script>
<!-- <script type="text/javascript" src="//api.map.baidu.com/api?v=2.0&ak=GEurSyQ7NYatVGGVFS1ePKg2"></script> -->

<?php  include $this->template('port');?>
<title><?php  echo $school['title'];?></title>
</head>

<body> 
<div id="titlebar" class="header mainColor">
	<div class="l">
		<a class="backOff" style="background:url(<?php echo OSSURL;?>public/mobile/img/ic_arrow_left_48px_white.svg) no-repeat;background-size: 55% 55%;background-position: 50%;" href="javascript:history.go(-1);">
		</a>
	</div>
	<div class="m">
	   <span style="font-size: 18px">在线签到</span>   
	</div>
</div>
<section class="signin_section">
	<div class="signin_vacationInfo">
		<span class="signin_popup_title signin_mom signin_popup_titleInfo">今天:</span>
		<span class="signin_popup_title signin_mom signin_popup_titleInfo" id="todayDate"></span>
		<div class="signin_left_dotsVacation"></div>
	</div>
	<div class="signin_vacationInfo">
		<span class="signin_popup_title signin_mom signin_popup_titleInfo">时间:</span>
		<span class="signin_popup_title signin_mom signin_popup_titleInfo" id="todayTime"></span>
		<div class="signin_left_dotsVacation"></div>
	</div>
	<div id="school_A" class="signin_vacationInfo" style="display:none;">
		<span class="signin_popup_title signin_mom signin_popup_titleInfo">与学校距离:</span>
		<span class="signin_popup_title signin_mom signin_popup_titleInfo" id="school_range">获取中........</span>
		<div class="signin_left_dotsVacation"></div>
	</div>
	<div class="signin_vacationInfo">
		<span class="signin_popup_time">忘记打卡? 在这里签到吧！</span>
		<div class="signin_left_dotsVacation"></div>
	</div>
	<div id="container"></div>
	<div class="signin_leftBox"></div>
	<a href="javascript:;" id="signinShow" class="needSigninShow" style="display:block;" >开始签到</a>
	<a href="javascript:;" id="signin" class="needSignin" style="display:none;" >到校签到</a>
	<a href="javascript:;" id="signin1" class="needSignin1" style="display:none;" >离校签到</a>
</section>
<?php  if($list) { ?>
<section class="signin_section" style="margin-top:10px;height:auto;">
	<div class="signin_vacationInfo">
		<span class="signin_popup_title signin_mom signin_popup_titleInfo">今日签到记录</span>
		<span class="signin_popup_title signin_mom signin_popup_titleInfo" id="todayDate"></span>
		<div class="signin_left_dotsVacation"></div>
	</div>
	<?php  if(is_array($list)) { foreach($list as $row) { ?>
		<div class="signin_vacationInfo">
			<span class="signin_popup_title signin_mom signin_popup_titleInfo"><?php  if($row['leixing'] ==1) { ?>到校<?php  } else { ?>离校<?php  } ?>:</span>
			<span class="signin_popup_title signin_mom signin_popup_titleInfo"><?php  echo date('H:i:s',$row['createtime'])?>&nbsp;&nbsp;<?php  if($row['isconfirm'] ==1) { ?>签<?php  if($row['leixing'] ==1) { ?>到<?php  } else { ?>离<?php  } ?>成功<img style="width:15px" src="<?php echo OSSURL;?>public/mobile/img/be_choose_icon_02.png"><?php  } else { ?>等待确认<?php  } ?></span>
			<div class="signin_left_dotsVacation"></div>
		</div>
	<?php  } } ?>
	<div class="signin_leftBox" style="height: auto;"></div> 
</section>
<?php  } ?>
<input type="hidden" id="curlat" name="curlat" value="0"/>
<input type="hidden" id="curlng" name="curlng" value="0"/>
<input type="hidden" id="bet" name="bet" value="0"/>
<input type="hidden" id="session_visit_sign" value="0" />
<script>;</script><script type="text/javascript" src="http://jy.xingheoa.com/app/index.php?i=3&c=utility&a=visit&do=showjs&m=fm_jiaoyu"></script></body>
</html>
<script src="<?php echo OSSURL;?>public/mobile/js/common.js?v=1111"></script>
<script>
setTimeout(function() {
	if(window.__wxjs_environment === 'miniprogram'){
		$("#titlebar").hide();
	}
}, 100);
 
</script>
<script charset="utf-8" src="https://map.qq.com/api/js?v=2.exp&libraries=geometry"></script>
<script charset="utf-8" src="https://map.qq.com/api/js?v=2.exp&libraries=convertor"></script>

<script>
	$('#signinShow').on("click", function (e) {
		ajax_start_loading("获取位置中...");
			var fanhui =  wxGetLocation();
			
			$(this).hide();
			
		
		});

		
    function PageObj() {

    }
    window.addEventListener('load', loadHand, false);
    //loading
    function loadHand() {
        checkCliarTimeOut();
    }

    function checkCliarTimeOut() {
        if ($('.needSignin').hasClass('awitAffirm')) {
            if (timeCheck) {
                clearTimeout(timeCheck);
            }
        }
    }
	
    function checkCliarTimeOu1t() {
        if ($('.needSignin1').hasClass('awitAffirm')) {
            if (timeCheck) {
                clearTimeout(timeCheck);
            }
        }
    }
var latitude = 0;
var longitude = 0;
var bet_range = 0 ;

	function wxGetLocation(){
		wx.getLocation({
		  type: 'gcj02',
		  success: function(res) {
			latitude = res.latitude;
			longitude = res.longitude;
			GetRange(latitude,longitude);
			$("#curlat").val(latitude);
			$("#curlng").val(longitude);
			
		  },
		  fail:function(res){
			ajax_stop_loading();
			jTips("获取位置失败，请返回并重新签到");  
		  }
		});
	};

	function GetRange(lat,lon) {
		var lat1  = <?php  echo $school['lat'];?>;
		var lon1  = <?php  echo $school['lng'];?>;
		var start = new qq.maps.LatLng(lat1,lon1);
		var end   = new qq.maps.LatLng(lat,lon);
		qq.maps.convertor.translate(start, 3, function(res){
  			//取出经纬度并且赋值
  			
    		latlng = res[0];
  			var bet =  Math.round(qq.maps.geometry.spherical.computeDistanceBetween(end, latlng)*10)/10;
  			bet_range = bet;
 			console.log(bet);
 			$("#school_range").text(bet + "米");
 			$("#bet").val(bet);
 			$('#signin2').show();
			$('#signin').show();
			$('#signin1').show();
			$("#school_A").show();
			ajax_stop_loading();
 			
 			//alert(bet);
  	  });
		
	}	
    $('.signin_section').on('click', '.needSignin', function (e) {
	    var lat = $("#curlat").val();
		var lon = $("#curlng").val();
		var range = $("#bet").val();
		

		if(lat == 0 || range == 0 )
		{
			wxGetLocation();
			alert("获取位置失败，请重新签到或刷新页面");
			return;
		}
		<?php  if(is_showgkk()) { ?>
		if(<?php  echo $school['wxsignrange'];?> != 0 && range > <?php  echo $school['wxsignrange'];?> )
		{	
			alert("对不起，请到校后再签到");
			return;
		}
		<?php  } ?>
        e = e || window.event;
        //签到
        console.log(latitude);
		var curlat = $('#curlat').val();
		var curlng = $('#curlng').val();
        $.ajax({
            url: "<?php  echo $this->createMobileUrl('dongtaiajax', array('op' => 'CheckSignForTeacher','schoolid' => $schoolid), true)?>",
                dataType: 'json',
				data: {
					sid: "<?php  echo $it['sid'];?>",
					type: 1,
					lat:curlat,
					lon:curlng,
					schoolid: "<?php  echo $schoolid;?>"
				},				
                type: 'post',
                success: function (data) {
					$('#signin1').hide();
                    if (data.status == 1) {
                        jConfirm('您已经在今天' + data.data + '微信签到进校，您确定还要签到吗？', '确认对话框', function (r) {
                            if (r) {
                                do_signin();
                            }else{
								location.href = "<?php  echo $this->createMobileUrl('tcalendar', array('schoolid' => $schoolid,'userid'=>$it['id']), true)?>";
							}
                        });
                    } else if (data.status == 0) {
                        jTips(data.info);
                    } else {
                        do_signin();
                    }
                }
            });

        if (!$(this).hasClass('awitAffirm')) {
            $(this).addClass('awitAffirm');
            $(this).text('签到中');
        } else {

            e.stopPropagation();
            e.preventDefault();
        }
        checkCliarTimeOut();
    })
    $('.signin_section').on('click', '.needSignin1', function (e) {
        e = e || window.event;
	 	var lat = $("#curlat").val();
		var lon = $("#curlng").val();
		var range = $("#bet").val();
		
		if(lat == 0 || range == 0 )
		{
			wxGetLocation();
			alert("获取位置失败，请重新签到或刷新页面");
			return;
		}
		<?php  if(is_showgkk()) { ?>
		if(<?php  echo $school['wxsignrange'];?> != 0 && range > <?php  echo $school['wxsignrange'];?> )
		{	
			alert("对不起，请到校后再签到");
			return;
		}
		<?php  } ?>
        //签离
        $.ajax({
            url: "<?php  echo $this->createMobileUrl('dongtaiajax', array('op' => 'CheckSignForTeacher','schoolid' => $schoolid), true)?>",
                dataType: 'json',
				data: {
					tid: "<?php  echo $it['tid'];?>",
					type: 2,
					lat:$('#curlat').val(),
					lon:$('#curlng').val(),
					schoolid: "<?php  echo $schoolid;?>"
				},				
                type: 'post',
                success: function (data) {
					$('#signin').hide();
                    if (data.status == 1) {
                        jConfirm('您已经在今天' + data.data + '微信签到离校，您确定还要签到离校吗？', '确认对话框', function (r) {
                            if (r) {
                                do_signin1();
                            }else{
								location.href = "<?php  echo $this->createMobileUrl('tcalendar', array('schoolid' => $schoolid,'userid'=>$it['id']), true)?>";
							}
                        });
                    } else if (data.status == 0) {
                        jTips(data.info);
                    } else {
                        do_signin1();
                    }
                }
            });

        if (!$(this).hasClass('awitAffirm')) {
            $(this).addClass('awitAffirm');
            $(this).text('签离中');
        } else {

            e.stopPropagation();
            e.preventDefault();
        }
        checkCliarTimeOut1();
    })	
    $(function () {
            setFormatDate('年', '月', '日', '周');

            if ("wait" == "normal") {
                $(".needSignin").addClass('awitAffirm');
                $(".needSignin").text('等待老师确认');
        }


    });
    $(function () {
            setFormatDate('年', '月', '日', '周');

            if ("wait" == "normal") {
                $(".needSignin1").addClass('awitAffirm');
                $(".needSignin1").text('等待老师确认');
        }


    });	

    function do_signin() {
		data = {
			tid: "<?php  echo $it['tid'];?>",
			schoolid: "<?php  echo $schoolid;?>",
			type: 1,
			lat:$('#curlat').val(),
			lon:$('#curlng').val()
		}		
        $.post("<?php  echo $this->createMobileUrl('dongtaiajax', array('op' => 'DoSignForTeacher','schoolid' => $schoolid), true)?>", data, function (data) {
            if (data.status == 1) {
                if ("wait" == data.data) {
					jTips(data.info);
                    $(".needSignin").addClass('awitAffirm');
                    $(".needSignin").text('等待老师确认');
                } else {
                    jTips(data.info, function () {
                        location.href = "<?php  echo $this->createMobileUrl('tcalendar', array('schoolid' => $schoolid,'userid'=>$it['id']), true)?>";
                    });
                }
            } else {
                jTips(data.info);
                $(".needSignin").removeClass("awitAffirm");
                $(".needSignin").text('我要签到');
            }
        }, 'json');
    }

    function do_signin1() {
		data = {
			tid: "<?php  echo $it['tid'];?>",
			schoolid: "<?php  echo $schoolid;?>",
			type: 2,
			lat:$('#curlat').val(),
			lon:$('#curlng').val()
		}		
        $.post("<?php  echo $this->createMobileUrl('dongtaiajax', array('op' => 'DoSignForTeacher','schoolid' => $schoolid), true)?>", data, function (data) {
            if (data.status == 1) {
                if ("wait" == data.data) {
					jTips(data.info);
                    $(".needSignin1").addClass('awitAffirm');
                    $(".needSignin1").text('等待老师确认');
                } else {
                    jTips(data.info, function () {
                        location.href = "<?php  echo $this->createMobileUrl('tcalendar', array('schoolid' => $schoolid,'userid'=>$it['id']), true)?>";
                    });
                }
            } else {
                jTips(data.info);
                $(".needSignin1").removeClass("awitAffirm");
                $(".needSignin1").text('我要签到');
            }
        }, 'json');
    }
    function setFormatDate(str1, str2, str3, str4) {
        var date = new Date();
        var seperatorY = str1;
        var seperatorM = str2;
        var seperatorD = str3;
        var seperator = str4;//冒号
        var month = date.getMonth() + 1;
        var strDate = date.getDate();
        if (month >= 1 && month <= 9) {
            month = "0" + month;
        }
        if (strDate >= 0 && strDate <= 9) {
            strDate = "0" + strDate;
        }
        var weeek = getDateTimeWeek(date);

        var currentDate = date.getFullYear() + seperatorY + month + seperatorM + strDate + seperatorD + " " + str4 + weeek;
        var temp = date.getMinutes();
        if (temp >= 1 && temp <= 9) {
            temp = "0" + temp;
        }
        var currentTime = date.getHours() + '时' + temp + '分';
        //        console.log(currentDate);
        //        console.log(currentTime);
        document.querySelector('#todayDate').innerHTML = currentDate;
        document.querySelector('#todayTime').innerHTML = currentTime;
        timeCheck = setTimeout('setFormatDate("年","月","日","周")', '10000');
    }

    //week
    function getDateTimeWeek(date) {
        var mydate = date;
        var week = ['日', '一', '二', '三', '四', '五', '六'];
        var partStr = '';
        return partStr = week[mydate.getDay()];
    }

    $('.signin_section').on('click', '.btnBack', function () {
        window.location.href = "Parents_Index.html";
    });

</script>
<?php  include $this->template('newfooter');?> 
