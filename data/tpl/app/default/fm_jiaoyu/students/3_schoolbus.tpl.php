<?php defined('IN_IA') or exit('Access Denied');?><!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
          "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0" />
<title>轨迹</title>
<style type="text/css">
body, html, #allmap {width: 100%;height: 100%;overflow: hidden;margin: 0;}
#address_distance_tips {text-align: center;z-index: 999;display: none;width: 100%;height: 40px;line-height: 20px;box-sizing: border-box;padding: 10px;font-size: 14px;
position: fixed;top: 0;left: 0;color: #fff;background-color: rgba(0,0,0,0.8);}
</style>
<script>
var _hmt = _hmt || [];
(function () {
var hm = document.createElement("script");
hm.src = "https://hm.baidu.com/hm.js?e6c44a88bd78113bfe161250284d9863";
var s = document.getElementsByTagName("script")[0];
s.parentNode.insertBefore(hm, s);
})();
</script>
<?php  echo register_jssdks();?>
<input type="hidden" id="nowid" value="<?php  echo $todayfrist[0]['id'];?>">
<input type="hidden" id="macid" value="<?php  echo $todayfrist[0]['macid'];?>">
<input type="hidden" id="createtime" value="<?php  echo date('Y-m-d',$todayfrist[0]['createtime'])?>">
<script type="text/javascript" src="<?php echo MODULE_URL;?>public/mobile/js/jquery-1.10.1.min.js?v=4.8"></script>
<script src="http://api.map.baidu.com/api?v=2.0&ak=6a84aab54c14e9561287b6d577f4c616"></script>
    <script type="text/javascript">
        window.onload = function () {
            // 百度地图API功能
            draw_time = 0;
            var if_has_data = false;
			<?php  if($todayfrist) { ?>
				var old_point=[[<?php  echo $fristpoint;?>]];
			<?php  } else { ?>
				var old_point=[];
			<?php  } ?>
            for (var i = 0; i < old_point.length; i++) {
                if (old_point[i].length != 0) {
                    if_has_data = true;
                    break;
                }
            }
            if (if_has_data == false) {
                document.getElementById('address_distance_tips').style.display = 'block';
                document.getElementById('address_distance_tips').textContent = '暂无校车信息！';

            } else {
                //  old_point[0]=[113.306, 23.120];
                var new_point = [];
                var my_address_point;
                var mk;
                //var pt;
                var address_info = '';
                var marker2 = [];
                var map = new BMap.Map("allmap");

                map.centerAndZoom(new BMap.Point(old_point[0][0], old_point[0][1]), 16);
                // var marker1 = new BMap.Marker(new BMap.Point(116.404, 39.915));  // 创建标注

                // map.addOverlay(marker1);              // 将标注添加到地图中
                map.addControl(new BMap.NavigationControl());  //添加默认缩放平移控件
                map.enableScrollWheelZoom(true);
                map.addControl(new BMap.NavigationControl({ anchor: BMAP_ANCHOR_BOTTOM_RIGHT, type: BMAP_NAVIGATION_CONTROL_ZOOM }));  //右下角，仅包含缩放按钮

                map.addControl(new BMap.MapTypeControl({ mapTypes: [BMAP_NORMAL_MAP, BMAP_HYBRID_MAP] }));     //2D图，卫星图
                var gc = new BMap.Geocoder();

                //创建信息窗口
                var myIcon = new BMap.Icon("<?php echo OSSURL;?>public/mobile/img/school_car.png?v=0316", new BMap.Size(50, 20));
                var arr_index = draw_time;
                marker2[arr_index] = [];
                for (var i = 0; i < old_point.length; i++) {
                    if (old_point[i].length == 0) {
                        marker2[arr_index][i] = '';
                    } else {
                        var pt = new BMap.Point(old_point[i][0], old_point[i][1]);

                        marker2[arr_index][i] = new BMap.Marker(pt, { icon: myIcon });
                        map.centerAndZoom(pt, 16);

                        //map.clearOverlays();
                        if (arr_index - 1 > 0) {
                            map.removeOverlay(marker2[i][(arr_index - 1)]);
                        }

                        map.addOverlay(marker2[arr_index][i]);

                        marker2[arr_index][i].addEventListener("click", function () {
                            console.log(arr_index);
                            var pt2 = this.point;
                            map.centerAndZoom(pt2, 16);
                            gc.getLocation(this.point, function (rs) {
                                var addComp = rs.addressComponents;
                                address_info = addComp.street + ", " + addComp.streetNumber;
                                var infoWindow = new BMap.InfoWindow(address_info);  // 创建信息窗口对象
                                map.openInfoWindow(infoWindow, pt2);
                            });

                        });

                    }

                }

            }

            //获取两点间距离
            function get_distance(point1, point2) {
                //console.log((map.getDistance(point1,point2)).toFixed(2));
                //判断两点距离大小
                if (!!point1) {
                    if ((map.getDistance(point1, point2)).toFixed(2) < 1500) {
                        console.log('小于:' + (map.getDistance(point1, point2)).toFixed(2));
                        //alert('距离小于1公里');
                        return true;

                    } else {
                        console.log('大于:' + (map.getDistance(point1, point2)).toFixed(2));
                        return false;
                        //document.getElementById('address_distance_tips').style.display='none';
                    }
                }
                return false;

            }

            //function draw_line(longitude, latitude) {
            function draw_line(point1, point2) {

                var longitude = point1[0];
                var latitude = point1[1];
                var longitude_new = point2[0];
                var latitude_new = point2[1];
                console.log('longitude:' + longitude + 'latitude:' + latitude + 'longitude_new:' + longitude_new + 'latitude_new' + latitude_new);

                if (longitude == longitude_new && latitude == latitude_new) {
                } else {
                    var polyline = new BMap.Polyline([
                    new BMap.Point(longitude, latitude),
                    new BMap.Point(longitude_new, latitude_new)

                    ], { strokeColor: "blue", strokeWeight: 3, strokeOpacity: 0.5 });
                    map.addOverlay(polyline);
                }


            }

            function ajax_get_point() {
				var nowid = $("#nowid").val();
				var macid = $("#macid").val();
				var lasttime = $("#createtime").val();
                $.ajax({
                    url: '<?php  echo $this->createMobileUrl('comajax', array('op' => 'AddGather','schoolid' => $schoolid), true)?>',
                    type: 'post',
                    dataType: 'json',
                    data: {schoolid: "<?php  echo $schoolid;?>",nowid:nowid,macid:macid,lasttime:lasttime },
                    success: function(data) {
                        draw_time++;
                        setTimeout(function() {
                            console.log(data.data);
							 $('#nowid').attr("value",data.id);
                            get_myaddress();
                            var arr_index = draw_time;
                            marker2[arr_index] = [];
							new_point = [];
							
                            var data_arr = data.data.split(';');
                            if_has_data = false;
                            for (var i = 0; i < data_arr.length; i++) {
                                new_point.push(eval(data_arr[i]));
                                if (new_point[i].length != 0) {
                                    if_has_data = true;
                                }
                            }

                            console.log('new_point:');
                            console.log(new_point);

                            var check_distance = false;
                            var close_point = '';
                            for (var i = 0; i < old_point.length; i++) {
                                if (old_point[i].length != 0 && new_point[i].length != 0) {
                                    draw_line(old_point[i], new_point[i]);
                                }
                                if (new_point[i].length != 0) {
                                    var pt = new BMap.Point(new_point[i][0], new_point[i][1]);
                                    if (!check_distance && !get_distance(my_address_point, pt)) {
                                        document.getElementById('address_distance_tips').style.display = 'none';
                                    } else {
                                        if (close_point == '') {
                                            close_point = pt;
                                        }
                                        check_distance = true;
                                        document.getElementById('address_distance_tips').style.display = 'block';
                                        document.getElementById('address_distance_tips').textContent = '距离小于1公里';
                                    }


                                    marker2[arr_index][i] = new BMap.Marker(pt, { icon: myIcon });
                                    map.centerAndZoom(pt, 16);
                                    if (arr_index - 1 >= 0) {
                                        map.removeOverlay(marker2[(arr_index - 1)][i]);
                                    }
                                    map.addOverlay(marker2[arr_index][i]);
                                    marker2[arr_index][i].addEventListener("click", function() {
                                        console.log(arr_index);
                                        var pt2 = this.point;
                                        map.centerAndZoom(pt2, 16);
                                        gc.getLocation(this.point, function(rs) {
                                            var addComp = rs.addressComponents;
                                            address_info = addComp.street + ", " + addComp.streetNumber;
                                            var infoWindow = new BMap.InfoWindow(address_info); 
                                            map.openInfoWindow(infoWindow, pt2);
                                        });
                                    });

                                } else {
                                    marker2[arr_index][i] = '';
                                }

                            }

                            if (close_point != '') {
                                map.centerAndZoom(close_point, 16);
                            }
                            old_point = [];
                            old_point = new_point;
                            ajax_get_point();
                        }, 2000);
                    },
                    error: function() {

                    }
                });
            }

            setTimeout(function () {
				var macid = $("#macid").val();
				if(macid){
					ajax_get_point();
				}
            }, 200);

            // 获取自己经纬度

            var geolocation = new BMap.Geolocation();

            function get_myaddress() {
                geolocation.getCurrentPosition(function(r) {
                    if (this.getStatus() == BMAP_STATUS_SUCCESS) {
                        my_address_point = r.point;
                        if (!!mk) {
                            map.removeOverlay(mk);
                            mk = new BMap.Marker(r.point);
                            map.addOverlay(mk);
                        } else {
                            mk = new BMap.Marker(r.point);
                            map.addOverlay(mk);
                            // map.panTo(r.point);
                            var check_distance = false;
                            var close_point = '';
                            for (var i = 0; i < old_point.length; i++) {
                                var pt = new BMap.Point(old_point[i][0], old_point[i][1]);
                                if (!check_distance && !get_distance(my_address_point, pt)) {
                                    document.getElementById('address_distance_tips').style.display = 'none';

                                } else {
                                    check_distance = true;
                                    if (close_point == '') {
                                        close_point = pt;
                                    }

                                    document.getElementById('address_distance_tips').style.display = 'block';
                                    document.getElementById('address_distance_tips').textContent = '距离小于1公里';
                                }
                            }
                            if (close_point != '') {
                                map.centerAndZoom(close_point, 16);
                            }

                        }

                        // alert('您的位置：'+r.point.lng+','+r.point.lat);
                    } else {
                        alert('failed' + this.getStatus());
                    }
                }, { enableHighAccuracy: true });
            }
            get_myaddress();

            // });

        }

    </script>

</head>

<body>
    <div id="address_distance_tips"></div>
    <div id="allmap"></div>
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