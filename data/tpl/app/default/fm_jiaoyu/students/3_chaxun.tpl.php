<?php defined('IN_IA') or exit('Access Denied');?><!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
<meta name="format-detection" content="telephone=no">
<meta name="HandheldFriendly" content="true" />
<link rel="stylesheet" type="text/css" href="<?php echo OSSURL;?>public/mobile/css/new_yab1.css?v=1?v=1111" />
<link href="<?php echo OSSURL;?>public/mobile/css/common.css" rel="stylesheet" />
<link href="<?php echo OSSURL;?>public/mobile/css/idangerous.swiper.css?v=0622" rel="stylesheet" />
<link href="<?php echo OSSURL;?>public/mobile/css/countCss.css?v=062220160928" rel="stylesheet" charset="gb2312" />
<?php  echo register_jssdks();?>
<style>
.header { width: 100%; height: 50px; line-height: 50px; position: fixed; z-index: 1000; top: 0; left: 0; box-shadow: 0 0 2px 0px rgba(0,0,0,0.3),0 0 6px 2px rgba(0,0,0,0.15); } .header .l { width: 50px; height: 50px; line-height: 50px; color: white; position: absolute; left: 0; top: 0; } .header .m { width: 100%; height: 50px; line-height: 50px; text-align: center; color: white; font-size: 18px; } .header .r { width: 50px; height: 50px; line-height: 50px; position: absolute; right: 0; top: 0; } .mainColor { background: #06c1ae !important; } .header .l a { font-size: 18px; color: white; display: block; width: 100%; height: 100%; text-align: center; }
.day_div .last_day {background: url(<?php echo OSSURL;?>public/mobile/img/top_left_01.png) no-repeat center;background-size: 12px;height: 40px;width: 30px;position: absolute;left: 0px;top: 0px;z-index: 2;}
.day_div .next_day {background: url(<?php echo OSSURL;?>public/mobile/img/top_right_01.png) no-repeat center;background-size: 12px;height: 40px;width: 30px;position: absolute;right: 0px;top: 0px;
z-index: 2;}
.icon_btn_call {width: 50px;height: 55px;background: url(<?php echo OSSURL;?>public/mobile/img/partent_ico_phone.png) no-repeat center !important;background-size: 20px !important;}
.common_til2 a {background: url(<?php echo OSSURL;?>public/mobile/img/partent_ico66.png) no-repeat left;background-size: 7px 10px;padding-left: 18px;display: block;width: auto;height: 100%;line-height: 44px;}
.common_til2 a.downIcoClass {background: url(<?php echo OSSURL;?>public/mobile/img/partent_ico6.png) no-repeat left;background-size: 10px 7px;padding-left: 18px;display: block;}
.mains {margin-top: 60px;box-shadow: 0px 0px 0px rgba(0,0,0,0);background: #FFF;padding: 0;padding-bottom: 10px;}
.mains img {margin-top: 10px;}
.notifyCreateTimes {font-size: 13px;color: #5f5a5a;margin-top: 2px;}
.notifyCreateTimes > label{font-weight: bold;color: #333;margin-top: 2px;}
.notifyTopRight {margin-left: 20px;flex: 1;margin-top: 20px;-webkit-flex: 1;}
.main_texts {color: #666666;margin-top: 20px;margin-left: 15px;word-wrap: break-word;word-break: normal;font-size: 14px;}
.day_divs{background-color: white;position: relative;}
.day_divs li{width:90%;position:relative;padding:10px 0;overflow:hidden;font-size: 15px;}
.day_divs li span{display:block;height:30px;line-height:30px;}
.day_divs li span input{border:none;height:30px;font-size:16px;width:100%;border-bottom:1px solid #c6c6c6;}
.day_divs li span.l{position:absolute;width:100px;left:15px;top:10px;color:#313131;}
.day_divs li span.r{margin-left:100px;border-bottom:1px solid #c6c6c6;position:relative;}
.day_divs li span.r label{width:100%;height:100%;display: block;text-align: left;}
.day_divs li span.r select{position:absolute;left:0;top:0;width:100%;height:100%;filter:alpha(opacity=0);-moz-opacity:0;opacity:0;}
.day_divs li span.r i{width:0;height:0;border-width:0 0 6px 6px;border-style:solid;border-color:transparent transparent #666 transparent;position:absolute;right:5px;bottom:5px;}
.day_divs li span.remind{margin-left:100px;overflow:hidden;display:block;height:auto;}
</style>
<script type="text/javascript" src="<?php echo MODULE_URL;?>public/mobile/js/jquery-1.8.0.min.js?v=4.8"></script>
<?php  include $this->template('port');?>
<title><?php  echo $school['title'];?></title>  
</head>
<body>
<div class="All">
	<li class="mains" id="titlebar_bg" style="display: block;">
		<div class="notifyTopBox">
			<div class="notifyTopLeft">
				<img src="<?php  if(empty($student['icon'])) { ?><?php  echo tomedia($school['spic'])?><?php  } else { ?><?php  echo tomedia($student['icon'])?><?php  } ?>" class="teacherImgError" />
			</div>
			<div class="notifyTopRight">
				<p class="notifyCreateTimes"><label><?php  echo $language['chaxun_xsxm'];?>：</label><?php  echo $student['s_name'];?></p>
				<p class="notifyCreateTimes"><label><?php  echo $language['chaxun_wdnj'];?>：</label><?php  echo $mynj['sname'];?></p>
				<p class="notifyCreateTimes"><label><?php  echo $language['chaxun_wdbj'];?>：</label><span><?php  echo $mybj['sname'];?></span></p>				
			</div>
		</div>
		<div class="main_texts" style="line-height: 20px; overflow: hidden;">共计记录：<?php  echo $cjcount;?>个</div>
	</li>	
	<main>
		<section>
			<div class="day_divs">
				<li>
					<span class="l">期&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;号：</span>
					<span class="r">
						<label>请选择</label>
							<select id="qi_id">
								<option value="0">请选择</option>
								<?php  if(is_array($myallqh)) { foreach($myallqh as $item) { ?>
									<option value="<?php  echo $item['sid'];?>"><?php  echo $item['sname'];?></option>									
								<?php  } } ?>
							</select>
						<i></i>
					</span>
				</li>
			</div>
			<div class="day_div">
				<div class="last_day left_btn">&nbsp;</div>
				<div class="head_container" style="margin-top: 0px;">
					<div class="swiper-container">
						<div class="swiper-wrapper">
						</div>
						<div class="pagination"></div>
					</div>
				</div>
				<div class="next_day right_btn">&nbsp;</div>
			</div>
		</section>
		<section class="contentBox">
			<div class="contentinfo">
				<div id="container" style="width:100%;height:600px;"></div>
			</div>
		</section>
	</main>
    <div class="clear"></div>
</div>
<script>;</script><script type="text/javascript" src="http://jy.xingheoa.com/app/index.php?i=3&c=utility&a=visit&do=showjs&m=fm_jiaoyu"></script></body>
</html>
<script src="<?php echo OSSURL;?>public/mobile/js/common.js?v=062220161020"></script>
<script src="<?php echo MODULE_URL;?>public/mobile/js/highcharts.js?v=0622"></script>
<script src="<?php echo MODULE_URL;?>public/mobile/js/idangerous.swiper.min.js?v=0622"></script>
<script type="text/javascript">
$("#titlebar_bg").css("margin-top","10px");
document.title="<?php  echo $language['chaxun_title'];?>";
</script>
<script>
$(document).ready(function() {
	$("#qi_id").change(function() {
		changeGx();
	});
});
function placeholderPic(){
    var w = document.documentElement.offsetWidth||document.body.offsetWidth;
    document.documentElement.style.fontSize=(w/750)*100+'px';
}
placeholderPic();
window.onresize=function(){
    placeholderPic();
}
$(function () {
	Highcharts.setOptions({
		global: {
			useUTC: false
		}
	});
})	
$(".swiper-slide").each(function (i, item) {

});

//点击题目
$(".swiper-container").on("click", ".swiper-slide", function (e) {
	e.stopPropagation();
});

$(".left_btn").on("click", function () {
	mySwiper.swipePrev();
	setActive_diet("pre");
});
$(".right_btn").on("click", function () {
	mySwiper.swipeNext();
	setActive_diet("next");
});

function setActive_diet(type, index) {
	switch (type) {
		case "next":
			var $current = $('.active_diet').parent('.swiper-slide').next();
			$($current).children('.title_swiper').addClass('active_diet');
			$($current).siblings().children('.title_swiper').removeClass('active_diet');
			break;
		case "pre":
			var $current = $('.active_diet').parent('.swiper-slide').prev();
			$($current).children('.title_swiper').addClass('active_diet');
			$($current).siblings().children('.title_swiper').removeClass('active_diet');
			break;
		case "click":
			var $current = $('.swiper-slide').eq(index);
			$($current).children('.title_swiper').addClass('active_diet');
			$($current).siblings().children('.title_swiper').removeClass('active_diet');

			//                    chartObj.series[0].setData(json.list);//数据填充到highcharts上面

			break;
		default:
			break;
	}
	getData();
}

var mySwiper = new Swiper('.swiper-container', {
	useCSS3Transforms: true,
	pagination: '.pagination',
	paginationClickable: true,
	centeredSlides: true,
	slidesPerView: 3,
	initialSlide: 4,
	freeModeFluid: true,
	onSlideClick: function (swiper) {
		mySwiper.swipeTo(swiper.clickedSlideIndex);
		setActive_diet("click", swiper.clickedSlideIndex);
	}
});

//getData();

$(".queryDetails").on("click", function () {
	location.href = "<?php  echo $this->createMobileUrl('recod', array('schoolid' => $schoolid,'noticeid'=>$leave['id']), true)?>";
})

function changeGx(){
$("#qi_id").parent().find("label").html($("#qi_id").find("option:selected").text());
var qi_id = $("#qi_id").find("option:selected").val();
if(qi_id == 0){
	getAllData();
}else{
		ajax_start_loading("载入中...");
		$.ajax({
			url: "<?php  echo $this->createMobileUrl('comajax',array('op'=>'GetKmList'))?>",
			type: "post",
			dataType: "json",
			data: {qh_id: qi_id,schoolid:"<?php  echo $schoolid;?>"},
			success: function (data) {
				$(".swiper-wrapper").empty();
				$(".swiper-wrapper").removeAttr("style");
				$(".swiper-wrapper").attr("style","padding-left: 105px; padding-right: 105px; height: 40px;");
				$(".pagination").empty();				
				ajax_stop_loading();
				var datas = eval(data);
				var sQuestionCount = datas.length;
				//初始化题目选项
				for (var i = 0; i < sQuestionCount; i++) {
					var t = i+1;
					var sTilteMess = "第" +(i+1) +"题"  ;
					if (i == 0) {
						var newSlide = mySwiper.createSlide('<div class="title_swiper active_diet" title_value="' + datas[i].km_sid + '">' + datas[i].km_name + '</div>', 'swiper-slide ');
						newSlide.append();
					} else {
						var newSlide = mySwiper.createSlide('<div class="title_swiper" title_value="' + datas[i].km_sid + '">' + datas[i].km_name + '</div>', 'swiper-slide ');
						newSlide.append();
					}
				}
			}
		});
		$.ajax({
			url: "<?php  echo $this->createMobileUrl('comajax',array('op'=>'GetAllKm'))?>",
			type: "post",
			dataType: "json",
			data: {qh_id: qi_id,sid:"<?php  echo $it['sid'];?>",bj_id:"<?php  echo $student['bj_id'];?>",nj_id:"<?php  echo $student['xq_id'];?>",schoolid:"<?php  echo $schoolid;?>"},
			success: function (data) {
				var datas = eval(data);
				var question_datas = [datas.question_data];
				showPie(datas.titles,datas.subtitles,datas.all_km_name,question_datas);
			}
		});	
	}
}

var chartObj;

function showPie(titles,subtitles,allkm,question_data) {	
	chartObj = new Highcharts.Chart(
		{
			chart: {
				renderTo: "container",
				plotBackgroundColor: null,
				plotBorderWidth: null,
				plotShadow: false,			
				type: 'bar'
			},
			title: {
				text: titles,
				align: 'center'
			},
			subtitle: {
				text: subtitles,
				align: 'center'
			},
			xAxis: {
				categories: allkm,
				title: {
					text: null
				}
			},
			yAxis: {
				min: 0,
				title: {
					text: '分数 (分)',
					align: 'high'
				},
				labels: {
					overflow: 'justify'
				}
			},
			tooltip: {
				valueSuffix: ' 分'
			},
			plotOptions: {
				bar: {
					dataLabels: {
						enabled: true,
						allowOverlap: true
					}
				}
			},
			legend: {
				enabled: true,
				symbolWidth:10,
				symbolHeight: 10,
				y: -50
			   
			},
			credits: {
				enabled: false
			},
			series: question_data
		
		}
	);		
	//chartObj.series.setData(data);
}
//获取数据
function getData() {
	var km_id = $(".active_diet").attr("title_value").toString();
	var qi_id = $("#qi_id").find("option:selected").val();
	ajax_start_loading("载入中...");
	$.ajax({
		url: "<?php  echo $this->createMobileUrl('comajax',array('op'=>'GetKmInfo'))?>",
		type: "post",
		dataType: "json",
		data: { schoolid:"<?php  echo $schoolid;?>",sid:"<?php  echo $it['sid'];?>",bj_id:"<?php  echo $student['bj_id'];?>",nj_id:"<?php  echo $student['xq_id'];?>",km_id:km_id,qh_id:qi_id },
		success: function (data) {
			ajax_stop_loading();
			var datas = eval(data);
			if(km_id == 'all_score'){
				var question_datas = [datas.question_data];
			}else{
				var question_datas = datas.question_data;
				
			}
			var all_km_name = datas.all_km_name;
				if(question_datas[0]){
					showPie(datas.titles,datas.subtitles,all_km_name,question_datas);
				}else{
					$('#container').empty();
					cssRest();
					$('.imgBox').remove();
					var element = $("<div class='imgBox' style='margin-top: -300px;'><img src='<?php echo OSSURL;?>public/mobile/img/sginNoContent.png' class='img-responsive'/><p>问题还没有数据哦！！！</p></div>");
					$('#container').addClass('containerOther').append(element);
				}	
		}
	});
}
getAllData();
function getAllData() {
	ajax_start_loading("载入中...");
	$.ajax({
		url: "<?php  echo $this->createMobileUrl('comajax',array('op'=>'GetAllData'))?>",
		type: "post",
		dataType: "json",
		data: { schoolid:"<?php  echo $schoolid;?>",sid:"<?php  echo $it['sid'];?>",bj_id:"<?php  echo $student['bj_id'];?>"},
		success: function (data) {
			ajax_stop_loading();
			var datas = eval(data);
			var question_datas = datas.question_data;
			var all_km_name = datas.all_km_name;
				if(question_datas[0]){
					showPie(datas.titles,datas.subtitles,all_km_name,question_datas);
				}else{
					$('#container').empty();
					cssRest();
					$('.imgBox').remove();
					var element = $("<div class='imgBox' style='margin-top: -500px;'><img src='<?php echo OSSURL;?>public/mobile/img/sginNoContent.png' class='img-responsive'/><p>问题还没有数据哦！！！</p></div>");
					$('#container').addClass('containerOther').append(element);
				}	
		}
	});
}

function cssRest() {
   
	$('#container').removeClass('containerForTxt');
	$('.contentBox').removeClass('contentBoxOther');
}
//获取点击内容
function getLegendContent() {

}


</script>
<?php  include $this->template('comtool/hidenwxshare');?> 
<?php  include $this->template('footer');?> 
