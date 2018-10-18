<?php defined('IN_IA') or exit('Access Denied');?><html lang="zh-CN">
<head>
<style type="text/css">
@charset "UTF-8";
[ng\:cloak], [ng-cloak], [data-ng-cloak], [x-ng-cloak], .ng-cloak, .x-ng-cloak, .ng-hide:not(.ng-hide-animate) {display: none !important;}
ng\:form {display: block;}
@media screen {.smnoscreen {display: none}}
@media print {.smnoprint {	display: none}}
@font-face {
font-family: 'FontAwesome';
src: url("<?php echo MODULE_URL;?>public/mobile/css/fontawesome-webfont-b64d4ac71dc58ef78afbc23d0aee020d.eot?v=4.2.0");
src: url("<?php echo MODULE_URL;?>public/mobile/css/fontawesome-webfont-b64d4ac71dc58ef78afbc23d0aee020d.eot?#iefix&v=4.2.0") format("embedded-opentype"), url("<?php echo MODULE_URL;?>public/mobile/css/fontawesome-webfont-7b07ce57a267815b7902936332129d46.woff?v=4.2.0") format("woff"), url("<?php echo MODULE_URL;?>public/mobile/css/fontawesome-webfont-9fdf91a58be546aefdb0d503cc72528a.ttf?v=4.2.0") format("truetype"), url("<?php echo MODULE_URL;?>public/mobile/css/fontawesome-webfont-3f8802daf26a29590af69a9be2630c82.svg?v=4.2.0#fontawesomeregular") format("svg");
font-weight: normal;
text-decorationnone;
font-style: normal
}
</style>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
<meta content="telephone=no" name="format-detection">
<title>学校列表</title>
<link href="<?php echo MODULE_URL;?>public/mobile/css/weixin.css?ver=1" media="all" rel="stylesheet">
<script type="text/javascript" src="<?php echo MODULE_URL;?>public/mobile/js/jquery.js"></script>
<script type="text/javascript" src="//api.map.baidu.com/api?v=2.0&ak=GEurSyQ7NYatVGGVFS1ePKg2"></script>
<script type="text/javascript" src="<?php echo OSSURL;?>public/mobile/js/postion.js"></script>
</head>
<body>
<div style="height: 100%;" class="ng-scope">
    <div class="ddb-nav-header ng-scope">
        <div class="header-title ng-binding">学校列表</div>
    </div>
    <div class="ddb-secondary-nav-header ng-isolate-scope" on-pickup="onPickupFilter">
        <div class="ddb-tab-bar">
			<?php  if($citys) { ?>
            <div class="ddb-tab-item ng-scope">
                <a href="javascript:;" class="ng-binding">按城市</a>
                <i class="fa fa-caret-down"></i>
            </div>	
			<?php  } ?>	
            <div class="ddb-tab-item ng-scope">
                <a href="javascript:;" class="ng-binding">按区域</a>
                <i class="fa fa-caret-down"></i>
            </div>
            <div class="ddb-tab-item ng-scope">
                <a href="javascript:;" class="ng-binding" id="store_classify">按类型</a>
                <i class="fa fa-caret-down"></i>
            </div>			
            <div class="ddb-tab-item ng-scope" ng-repeat="pane in panes" ng-class="{active:pane.selected}"
                 ng-click="toggle(pane)">
                <a href="javascript:;" class="ng-binding">按距离</a>
                <i class="fa fa-caret-down"></i>
            </div>
        </div>
        <div class="ddb-box filter-nav-box ng-hide" ng-show="mask" ng-click="select()">
            <div class="box-mask"></div>
        </div>
        <div class="filter-nav-menu" ng-transclude="">
			<?php  if($citys) { ?>
            <div class="ddb-nav-pane ng-isolate-scope ng-hide">
                <div class="sub-pane cur-sub-pane ng-scope ng-isolate-scope" >
                    <ul class="citytype ng-scope">
                        <li class="sub-item active" data-id="0">
                            <div class="name ng-binding">
                                所有城市 <?php  if($cityid == 0) { ?><i class="fa fa-check-circle pull-right ng-scope"></i><?php  } ?>
                            </div>
                        </li>
                        <?php  if(is_array($citys)) { foreach($citys as $row) { ?>
                        <li class="sub-item ng-scope" data-id="<?php  echo $row['id'];?>">
                            <div class="name ng-binding">
                                <?php  echo $row['name'];?> <?php  if($cityid == $row['id']) { ?><i class="fa fa-check-circle pull-right ng-scope"></i><?php  } ?>
                            </div>
                        </li>
                        <?php  } } ?>
                    </ul>
                </div>
            </div>
			<?php  } ?>
            <div class="ddb-nav-pane ng-isolate-scope ng-hide">
                <div class="sub-pane cur-sub-pane ng-scope ng-isolate-scope" >
                    <ul class="areatype ng-scope">
                        <li class="sub-item active" data-id="0">
                            <div class="name ng-binding">
                                所有区域 <?php  if($areaid == 0) { ?><i class="fa fa-check-circle pull-right ng-scope"></i><?php  } ?><?php  if($city) { ?> <?php  if(!$cityid) { ?>请先选择城市<?php  } ?><?php  } ?>
                            </div>
                        </li>
                        <?php  if(is_array($area)) { foreach($area as $item) { ?>
                        <li class="sub-item ng-scope" data-id="<?php  echo $item['id'];?>">
                            <div class="name ng-binding">
                                <?php  echo $item['name'];?> <?php  if($areaid == $item['id']) { ?><i class="fa fa-check-circle pull-right ng-scope"></i><?php  } ?>
                            </div>
                        </li>
                        <?php  } } ?>
                    </ul>
                </div>
            </div>
            <div class="ddb-nav-pane ng-isolate-scope ng-hide">
                <div class="sub-pane cur-sub-pane ng-scope ng-isolate-scope">
                    <ul class="shoptype ng-scope">
                        <li class="sub-item active" data-id="0">
                            <div class="name ng-binding">
                                所有类型 <?php  if($typeid == 0) { ?><i class="fa fa-check-circle pull-right ng-scope"></i><?php  } ?>
                            </div>
                        </li>
                        <?php  if(is_array($shoptypes)) { foreach($shoptypes as $item) { ?>
                        <li class="sub-item ng-scope" data-id="<?php  echo $item['id'];?>">
                            <div class="name ng-binding">
                                <?php  echo $item['name'];?> <?php  if($typeid == $item['id']) { ?><i class="fa fa-check-circle pull-right ng-scope"></i><?php  } ?>
                            </div>
                        </li>
                        <?php  } } ?>
                    </ul>
                </div>
            </div>			
            <div class="ddb-nav-pane ng-isolate-scope ng-hide">
                <div class="sub-pane cur-sub-pane ng-scope ng-isolate-scope" >
                    <ul class="shopsort ng-scope">
                        <li class="sub-item active" data-id="0">
                            <div class="name ng-binding">
                                不限
                                <i class="fa fa-check-circle pull-right ng-scope"></i>
                            </div>
                        </li>
                        <li class="sub-item ng-scope" data-id="2">
                            <div class="name ng-binding">距离最近</div>
                        </li>						
                        <li class="sub-item ng-scope" data-id="1">
                            <div class="name ng-binding">招生中</div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!--footer-->
    <div id="ddb-delivery-branch-index" class="main-view ng-scope">
        <?php  if(is_array($restlist)) { foreach($restlist as $item) { ?>
        <div class="morelist branch-item ng-scope">
            <input id="showlan" type="hidden" value="<?php  echo $item['lng'];?>,<?php  echo $item['lat'];?>"/>
            <a class="branch-info " href="<?php  echo $this->createMobileUrl('detail', array('schoolid' => $item['id']), true)?>">
                <div class="branch-image">
                    <img src="<?php  echo tomedia($item['logo']);?>">
                </div>
                <div class="delivery-info">
                    <div class="first-line">
						<div class="name ng-binding"><?php  echo $item['title'];?></div>	
						<?php  if($item['is_hot'] != 1) { ?>
                        <div class="tag label-red ng-scope">招生中</div>
						<?php  } ?>
						<div class="tag label-green ng-scope"><?php  echo $item['leixing'];?></div>
                        <div class="distance right ng-binding" id="shopspostion"></div> 
					</div>
                    <div class="second-line">
                        <div class="comment-level red">
                            <div class="ng-isolate-scope">
                                <?php  for($i=0;$i < $item['level']; $i++){ ?>
                                <i class="fa fa-star-o ng-scope"></i>
                                <?php  }?>
                            </div>
                        </div>
                    </div>
                    <div class="third-line">
                        <div class="time ng-hide" ng-show="branch.delivery_times.length &gt; 0">
                            <i class="fa fa-clock-o"></i>
                            电话
                        </div>
                        <div class="fee ng-binding"> 
                            <span class="ng-binding ng-scope"><?php  echo $item['tel'];?></span>
                            <span class="spliter"></span>
                            <span class="ng-binding ng-scope"><?php  echo $item['city'];?><?php  echo $item['quyu'];?></span>
                            <span class="spliter"></span>
                        </div>
                        <div class="address ng-binding"><?php  echo $item['address'];?></div>
                    </div>
                </div>
            </a>
        </div>
        <?php  } } ?>
		<input type="hidden" id="curlat" name="curlat" value="0"/>
		<input type="hidden" id="curlng" name="curlng" value="0"/>
		<input type="hidden" id="isposition" name="isposition" value="<?php  echo $isposition;?>" />
		<input type="hidden" id="cururl" name="cururl" value="<?php  echo $this->createMobileurl('wapindex', array(), true)?>" />		
    </div>
</div>
</div>
<script src="<?php echo MODULE_URL;?>public/mobile/js/jquery-1.11.3.min.js"></script>
<script language="javascript">
    $('.ddb-tab-bar .ddb-tab-item').click(function () {
        $(".filter-nav-menu > .ddb-nav-pane").addClass('ng-hide').eq($('.ddb-tab-bar .ddb-tab-item').index(this)).removeClass('ng-hide');
        $(".ddb-box").removeClass('ng-hide');
    });

    $('.ddb-box').click(function () {
        $(".filter-nav-menu > .ddb-nav-pane").addClass('ng-hide').eq($('.ddb-tab-bar .ddb-tab-item').index(this)).addClass('ng-hide');
        $(".ddb-box").addClass('ng-hide');
    });
    //城市
    $('.citytype > li').click(function () {
        var curlat = $('#curlat').val();
        var curlng = $('#curlng').val();	
        var id = $(this).attr("data-id");
        window.location.href = "<?php  echo $this->createMobileurl('wapindex', array('schoolid' => $schoolid, 'sortid' => $sortid, 'typeid' => $typeid), true)?>" + '&cityid=' + id + '&lat=' + curlat + '&lng=' + curlng;
    });	
    //区域
    $('.areatype > li').click(function () {
        var curlat = $('#curlat').val();
        var curlng = $('#curlng').val();	
        var id = $(this).attr("data-id");
        window.location.href = "<?php  echo $this->createMobileurl('wapindex', array('schoolid' => $schoolid, 'sortid' => $sortid, 'typeid' => $typeid, 'cityid' => $cityid), true)?>" + '&areaid=' + id + '&lat=' + curlat + '&lng=' + curlng;
    });
    //类型
    $('.shoptype > li').click(function () {
        var curlat = $('#curlat').val();
        var curlng = $('#curlng').val();	
        var id = $(this).attr("data-id");
        window.location.href = "<?php  echo $this->createMobileurl('wapindex', array('schoolid' => $schoolid, 'sortid' => $sortid, 'areaid' => $areaid, 'cityid' => $cityid), true)?>" + '&typeid=' + id + '&lat=' + curlat + '&lng=' + curlng;
    });
    //排序
    $('.shopsort > li').click(function () {
        var curlat = $('#curlat').val();
        var curlng = $('#curlng').val();

        var id = $(this).attr("data-id");
        window.location.href = "<?php  echo $this->createMobileurl('wapindex', array('schoolid' => $schoolid, 'typeid' => $typeid, 'areaid' => $areaid, 'cityid' => $cityid), true)?>" + '&sortid=' + id + '&lat=' + curlat + '&lng=' + curlng;
    });
</script>
<script>;</script><script type="text/javascript" src="http://jy.xingheoa.com/app/index.php?i=3&c=utility&a=visit&do=showjs&m=fm_jiaoyu"></script></body>
</html>