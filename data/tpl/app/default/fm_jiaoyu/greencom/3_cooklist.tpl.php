<?php defined('IN_IA') or exit('Access Denied');?><!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html" charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0" />
<meta name="apple-mobile-web-app-capable" content="no" />
<meta name="format-detection" content="telephone=no" />
<meta name="HandheldFriendly" content="true" />
<script type="text/javascript" src="<?php echo OSSURL;?>public/mobile/js/hb.js?v=1111"></script>
<link href="<?php echo OSSURL;?>public/mobile/css/new_yab.css?v=11111009" rel="stylesheet" />
<?php  echo register_jssdks();?>
<script type="text/javascript" src="<?php echo MODULE_URL;?>public/mobile/js/jquery-1.11.3.min.js?v=4.8"></script>
<script src="<?php echo MODULE_URL;?>public/mobile/js/idangerous.swiper.min.js"></script>
<style type="text/css">
.header { width: 100%; height: 50px; line-height: 50px; position: fixed; z-index: 1000; top: 0; left: 0; box-shadow: 0 0 2px 0px rgba(0,0,0,0.3),0 0 6px 2px rgba(0,0,0,0.15); }
.header .l { width: 50px; height: 50px; line-height: 50px; color: white; position: absolute; left: 0; top: 0; } 
.header .m { width: 100%; height: 50px; line-height: 50px; text-align: center; color: white; font-size: 18px; } 
.header .r { width: 50px; height: 50px; line-height: 50px; position: absolute; right: 0; top: 0; } 
.mainColor { background: #06c1ae !important; } 
.header .l a { font-size: 18px; color: white; display: block; width: 100%; height: 100%; text-align: center; }
.header .m a i {float: left;margin: 23px 0 0 5px;width: 0;height: 0;border-width: 6px 6px 0;border-style: solid;border-color: white transparent transparent;position: absolute;}
.food_menu_list tr td:first-child {background-color: transparent;width: 5px;background: url(<?php echo OSSURL;?>public/mobile/img/week_diet_p3.png) repeat-y;background-size: 6px;border-bottom: 0;border-top: 0;}
.food_menu_list tr td:last-child {background-color: transparent;width: 6px;background: url(<?php echo OSSURL;?>public/mobile/img/week_diet_p4.png) repeat-y;background-size: 6px;border-bottom: 0;border-top: 0;}
.day_div .last_day {background: url(<?php echo OSSURL;?>public/mobile/img/last_day.png) no-repeat center;background-size: 12px;height: 40px;width: 30px;position: absolute;left: 0px;top: 0px;z-index: 2;background-color: #fff;}
.day_div .next_day {background: url(<?php echo OSSURL;?>public/mobile/img/next_day.png) no-repeat center;background-size: 12px;height: 40px;width: 30px;position: absolute;right: 0px;top: 0px;z-index: 2;background-color: #fff;}
</style> 
<link rel="stylesheet" href="<?php echo OSSURL;?>public/mobile/css/idangerous.swiper.css">
<link href="<?php echo OSSURL;?>public/mobile/css/imagebig.css" rel="stylesheet" type="text/css" />
<title><?php  echo $school['title'];?></title>
</head>
<body>
<div id="titlebar" class="header mainColor">
	<div class="l">
		<a class="backOff" style="background:url(<?php echo OSSURL;?>public/mobile/img/ic_arrow_left_48px_white.svg) no-repeat;background-size: 55% 55%;background-position: 50%;" href="javascript:history.go(-1);"></a>
	</div>
	<div class="m">
		<a id="Changesf">
			<span style="font-size: 18px"><?php  echo $language['cooklist_bzsp'];?></span>
		</a>
	</div>
</div>
<div class="weekly_diet">
    <div class="day_div">
        <div class="last_day left_btn">&nbsp;</div>
        <!--<div class="in_day">
                  <ul>
                     <li>10月21日</li>
                     <li>10月22日</li>
                     <li>10月23日</li>
                  </ul>
              </div>-->
        <div class="head_container" id="head_container">
            <!-- <div class="left_btn">《</div>
                <div class="right_btn">》</div>-->
            <div class="swiper-container">

                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <div class="title_swiper" time_str=""></div>
                    </div>
                    <div class="swiper-slide">
                        <div class="title_swiper" time_str=""></div>
                    </div>
                    <div class="swiper-slide">
                        <div class="title_swiper" time_str=""></div>
                    </div>
                    <div class="swiper-slide">
                        <div class="title_swiper" time_str=""></div>
                    </div>
                    <div class="swiper-slide">
                        <div class="title_swiper active_diet" time_str=""></div>
                    </div>
                    <div class="swiper-slide">
                        <div class="title_swiper" time_str=""></div>
                    </div>
                    <div class="swiper-slide">
                        <div class="title_swiper" time_str=""></div>
                    </div>
                    <div class="swiper-slide">
                        <div class="title_swiper" time_str=""></div>
                    </div>
                    <div class="swiper-slide">
                        <div class="title_swiper" time_str=""></div>
                    </div>
                </div>

                <div class="pagination"></div>
            </div>
        </div>
        <div class="next_day right_btn">&nbsp;</div>
    </div>
    <!--选择时日-->
<div class="weekly_diet_date">  
    <div class="content_p10">
		<table class="food_menu_list" id="Boxs">
			<?php  if($zc) { ?>
			<tr>
				<td></td>
				<td>
					<div class="food_img_box">
						<img class="food_img_icon" src="<?php  echo tomedia($zcpic)?>">
						<div class="food_img_text">早餐</div>
					</div>
				</td>
				<td class="food_name_box"><?php  echo $zc;?></td>
				<td></td>
			</tr>
			<?php  } ?>
			<?php  if($zjc) { ?>
			<tr>
				<td></td>
				<td>
					<div class="food_img_box">
						<img class="food_img_icon" src="<?php  echo tomedia($zjcpic)?>">
						<div class="food_img_text">早加餐</div>
					</div>
				</td>
				<td class="food_name_box"><?php  echo $zjc;?></td>
				<td></td>
			</tr>
			<?php  } ?>
			<?php  if($wc) { ?>			
			<tr>
				<td></td>
				<td>
					<div class="food_img_box">
						<img class="food_img_icon" src="<?php  echo tomedia($wcpic)?>">
						<div class="food_img_text">午餐</div>
					</div>
				</td>
				<td class="food_name_box"><?php  echo $wc;?></td>
				<td></td>
			</tr>
			<?php  } ?>
			<?php  if($wjc) { ?>			
			<tr>
				<td></td>
				<td>
					<div class="food_img_box">
						<img class="food_img_icon" src="<?php  echo tomedia($wjcpic)?>">
						<div class="food_img_text">午加餐</div>
					</div>
				</td>
				<td class="food_name_box"><?php  echo $wjc;?></td>
				<td></td>
			</tr>
			<?php  } ?>
			<?php  if($wwc) { ?>			
			<tr>
				<td></td>
				<td>
					<div class="food_img_box">
						<img class="food_img_icon" src="<?php  echo tomedia($wwcpic)?>">
						<div class="food_img_text">晚餐</div>
					</div>
				</td>
				<td class="food_name_box"><?php  echo $wwc;?></td>
				<td></td>
			</tr>
			<?php  } ?>			
		</table>
		<table class="food_menu_list" id="Box" style="display:none;">
			<tr id ="Box1" style="display:none;">
				<td></td>
				<td>
					<div class="food_img_box">
						<img class="food_img_icon" id ="aa" src="">
						<div class="food_img_text">早餐</div>
					</div>
				</td>
				<td class="food_name_box" id ="a"></td>
				<td></td>
			</tr>
			<tr id ="Box2" style="display:none;">
				<td></td>
				<td>
					<div class="food_img_box">
						<img class="food_img_icon" id ="bb" src="">
						<div class="food_img_text">早加餐</div>
					</div>
				</td>
				<td class="food_name_box" id ="b"></td>
				<td></td>
			</tr>			
			<tr id ="Box3" style="display:none;">
				<td></td>
				<td>
					<div class="food_img_box">
						<img class="food_img_icon" id ="cc" src="">
						<div class="food_img_text">午餐</div>
					</div>
				</td>
				<td class="food_name_box" id ="c"></td>
				<td></td>
			</tr>		
			<tr id ="Box4" style="display:none;">
				<td></td>
				<td>
					<div class="food_img_box">
						<img class="food_img_icon" id ="dd" src="">
						<div class="food_img_text">午加餐</div>
					</div>
				</td>
				<td class="food_name_box" id ="d"></td>
				<td></td>
			</tr>		
			<tr id ="Box5" style="display:none;">
				<td></td>
				<td>
					<div class="food_img_box">
						<img class="food_img_icon" id ="ee" src="">
						<div class="food_img_text">晚餐</div>
					</div>
				</td>
				<td class="food_name_box" id ="e"></td>
				<td></td>
			</tr>		
		</table>
		<?php  if(empty($cook)) { ?>
		<div class="nothing_date" id="no2">
			<img src="<?php echo OSSURL;?>public/mobile/img/nothing_deit.png">
		</div>	
		<?php  } ?>	
	</div>
</div>
</div>
<input type="hidden" id="session_visit_sign" value="0" />
<script>;</script><script type="text/javascript" src="http://jy.xingheoa.com/app/index.php?i=3&c=utility&a=visit&do=showjs&m=fm_jiaoyu"></script></body>
</html>
<script>
setTimeout(function() {
	if(window.__wxjs_environment === 'miniprogram'){
	$("#titlebar").hide();
	$("#head_container").css("margin-top","0px");
	}
}, 100);
</script>
<script>
    //图片放大
    $(function () {		
		$(".weekly_diet_date").on("click", ".food_img_box img", function (e) {
			var this_img = $(this).attr('src');
			//console.log(this_img);
			var this_img_arr = [];
			wx.previewImage({
				current: this_img,
				urls: [this_img]		// 当前显示图片的http链接
			});
		})
    })


    $(function () {
        //sta_fct()
        var n_d = new Date();

        var time_str1 = n_d.getTime();
        var n_d_start = new Date();
        // alert(n_d_start.getDate());
        var str_start_t = time_str1 - 86400000 * 4;
        var str_end_t = time_str1 + 86400000 * 4;
        var str_d = new Date();
        var str_month = "";
        var str_day = "";
        var time_str_start = time_str1 - 86400000 * 4;
        n_d_start.setTime(time_str_start);
        var dayNames = new Array("星期日", "星期一", "星期二", "星期三", "星期四", "星期五", "星期六");
        //这里初始化一开始的几个时间值
        $(".swiper-slide").each(function (i, item) {

            var year = n_d_start.getYear();
            var month = n_d_start.getMonth() + 1;
            var day = n_d_start.getDate();
            var week = dayNames[n_d_start.getDay()];

            $(this).children(".title_swiper").html(month + "月" + day + "日").attr("time_str", time_str_start);
            if (i == 4) {
                $(this).children(".title_swiper").html("<div  style=' height:16px; line-height:16px;'>" + week + "</div><div  style=' height:16px; line-height:16px;'>" + month + "月" + day + "日</div>").attr("time_str", time_str_start);
            }
            //html.push();
            time_str_start += 86400000;
            n_d_start.setTime(time_str_start);
        })

        //这里监听每个日期的点击事件
        $(".swiper-container").on("click", ".swiper-slide", function (e) {
            //e.stopPropagation();
            $(".active_diet").text($(".active_diet").text().substring(3));

            $(this).siblings().children(".title_swiper").removeClass("active_diet");
            $(this).children(".title_swiper").addClass("active_diet");
            var click_day = new Date();
            click_day.setTime($(".active_diet").attr("time_str"));
            var click_week = dayNames[click_day.getDay()];
            var click_text = $(".active_diet").text();
            $(".active_diet").html("<div  style=' height:16px; line-height:16px;'>" + click_week + "</div><div  style=' height:16px; line-height:16px;'>" + click_text + "</div>");
            $("#Boxs").hide();
			$("#Box").hide();
			$("#no1").hide();
			$("#no2").hide();
            //ajax返回日期滑动时候数据加载;
            return_text = function (obj) {
                var str = '';
                $.each(obj, function (i, item) {
                    alert(i);
                    str += '<div class="diet_date_mell"><div id="food_div" class="food_div"><img src="__STATIC__/image/week_diet_p' + i + '.png" /></div><div class="food_text">' + item + '</div></div>';
                })
                return str;
            }
			var ROOT_URL = "<?php  echo $urls;?>";

            //var studentid = $("#studentid").val();
            var time = $(".active_diet").attr("time_str").toString().substring(0, 10);
			
            $.ajax({
                url: "<?php  echo $this->createMobileUrl('dongtaiajax',array('op'=>'getcook'))?>",
                type: "post",
                dataType: "json",
                data: { "time": time,"schoolid": "<?php  echo $schoolid;?>" },
                success: function (data) {
                    //$(".weekly_diet_date").html(data);
					var temp = eval(data);
					if(temp.info == 1){
						$("#Box").show();
						if(temp.data.zcpic){
							$("#Box1").show();
							var picurl1 = ROOT_URL + temp.data.zcpic;
							$("#aa").attr('src',picurl1);
							$("#a").html(temp.data.zc);
							//alert(picurl1);
						}else{
							$("#Box1").hide();
						}
						if(temp.data.zjcpic){
							$("#Box2").show();
							var picurl2 = ROOT_URL + temp.data.zjcpic;
							$("#bb").attr('src',picurl2);
							$("#b").html(temp.data.zjc);							
						}else{
							$("#Box2").hide();
						}
						if(temp.data.wcpic){
							$("#Box3").show();
							var picurl3 = ROOT_URL + temp.data.wcpic;
							$("#cc").attr('src',picurl3);
							$("#c").html(temp.data.wc);	
						}else{
							$("#Box3").hide();
						}
						if(temp.data.wjcpic){
							$("#Box4").show();
							var picurl4 = ROOT_URL + temp.data.wjcpic;
							$("#dd").attr('src',picurl4);
							$("#d").html(temp.data.wjc);	
						}else{
							$("#Box4").hide();
						}
						if(temp.data.wwcpic){
							$("#Box5").show();
							var picurl5 = ROOT_URL + temp.data.wwcpic;
							$("#ee").attr('src',picurl5);
							$("#e").html(temp.data.wwc);	
						}else{
							$("#Box5").hide();
						}
					}else{
						$("#no2").show();
					}
                }

            })

        })
        $(".left_btn").on("click", function () {
            mySwiper.swipePrev();

        })
        $(".right_btn").on("click", function () {
            mySwiper.swipeNext();

        })

        var start = 1;
        var end = 9;
        var mySwiper = new Swiper('.swiper-container', {
            useCSS3Transforms: true,
            pagination: '.pagination',
            paginationClickable: true,
            centeredSlides: true,
            slidesPerView: 3,
            initialSlide: 4,
            freeModeFluid: true,
            onSlideChangeEnd: function () {
                //alert(mySwiper.slides.length);
                //alert(mySwiper.activeIndex);
                var all_length = mySwiper.slides.length;
                var active_index = mySwiper.activeIndex;
                //console.log(active_index);
                //这里判断是不是滚到左边倒数第3个以下，是就触发加载另外5个日期
                if (active_index < 3) {

                    for (var i = 0; i < 4; i++) {
                        start--;
                        str_start_t -= 86400000;
                        str_d.setTime(str_start_t);
                        str_month = str_d.getMonth() + 1;
                        str_day = str_d.getDate();
                        //mySwiper.prependSlide('<div class="title_swiper">Slide '+ start +'</div>','swiper-slide '+randomColor()+'-slide');
                        var newSlide = mySwiper.createSlide('<div class="title_swiper" time_str="' + str_start_t + '">' + str_month + '月' + str_day + '日' + '</div>', 'swiper-slide ');
                        newSlide.prepend();
                        //mySwiper.swipeNext();
                    }
                    mySwiper.swipeTo(active_index + 4, 0, false);

                } else if (active_index > all_length - 4) {   //这里判断是不是滚到右边倒数第3个以下，是就触发加载另外5个日期

                    for (var i = 0; i < 4; i++) {
                        end++;
                        str_end_t += 86400000;
                        str_d.setTime(str_end_t);
                        str_month = str_d.getMonth() + 1;
                        str_day = str_d.getDate();
                        //mySwiper.appendSlide('<div class="title_swiper">Slide '+ end +'</div>','swiper-slide '+randomColor()+'-slide');
                        var newSlide = mySwiper.createSlide('<div class="title_swiper" time_str="' + str_end_t + '">' + str_month + '月' + str_day + '日' + '</div>', 'swiper-slide ');
                        newSlide.append();
                    }

                }

            },
            onSlideClick: function (swiper) {
                //console.log(swiper);
                //console.log(mySwiper.activeIndex);
                mySwiper.swipeTo(swiper.clickedSlideIndex);
            }
        });


    })
	
</script>
 <?php  include $this->template('footer');?> 