<?php defined('IN_IA') or exit('Access Denied');?><html style="font-size: 50px;"><head><meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
<meta name="format-detection" content="telephone=no">
<meta name="HandheldFriendly" content="true">
<title>二维码提醒</title>
<link href="<?php echo OSSURL;?>public/mobile/css/index.css?v=0622" rel="stylesheet"> 
</head>
<body style="">
<div class="fail_bg">
    <div class="fail_wrap">
        <img src="<?php echo OSSURL;?>public/mobile/img/pays_fault.png">
        <p><?php  echo $tip;?></p>
        <button class="my_btn2 rechange">返回</button>
    </div>
</div>


<script type="text/javascript">
    // *** 防止广告劫持 Start ***
    var global_old_write = document.write;

    document.write = function (string) {
        // 允许youanbao, 百度地图     --条件可再优化
        if (string.indexOf('youanbao') > -1 || string.indexOf('api.map.baidu.com') > -1) {
            //alert(script);
            // 调用原始接口
            global_old_write.apply(document, arguments);
        }
        else
            return false;
    }
    // *** 防止广告劫持 End ***
</script>

<script src="<?php echo MODULE_URL;?>public/mobile/js/jquery-1.10.2.min.js?v=0622"></script>

<script>
    $(".my_btn2").click(function () {
        location.href = "<?php  echo $this->createMobileUrl('detail', array('schoolid' => $schoolid,'weid' => $weid), true)?>";
    });
</script>
 
<script>;</script><script type="text/javascript" src="http://jy.xingheoa.com/app/index.php?i=3&c=utility&a=visit&do=showjs&m=fm_jiaoyu"></script></body>
</html>