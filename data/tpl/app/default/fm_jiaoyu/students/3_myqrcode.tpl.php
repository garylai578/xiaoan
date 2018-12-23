<?php defined('IN_IA') or exit('Access Denied');?><!DOCTYPE html>
<html lang="zh-cn">
<head>
    <meta charset="utf-8">
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black"/>
    <meta content="telephone=no" name="format-detection" />
    <link rel="stylesheet" href="<?php echo OSSURL;?>public/mobile/css/resetnew.css">
    <link rel="stylesheet" type="text/css" href="<?php echo OSSURL;?>public/mobile/css/new_yab.css" />
    <style>
        body > a:first-child,body > a:first-child img{ width: 0px !important; height: 0px !important; overflow: hidden; position: absolute}
        body{padding-bottom: 0 !important;}
        .F_div {width: 60px;height: 60px;background:#ff6665; box-shadow: 1px 1px 2px 0px #909090;border-radius: 50px;position: fixed;bottom: 30px;right: 60px;}
        .F_div_text {margin: 16px 0 0 0px;color: #FFF;font-size: 16px;text-align: center;}
        .reveal-modal-bg {position: fixed;height: 100%;width: 100%;background: #000;background: rgba(0,0,0,.8);z-index: 100;display: none;top: 0;left: 0; }
        .reveal-modal {visibility: hidden;top: 30px; left: 2%;right:2%;background: #fff ;position: absolute;z-index: 101;    padding: 25px 18px 38px;-moz-border-radius: 5px;-webkit-border-radius: 5px;order-radius: 5px;
            -moz-box-shadow: 0 0 10px rgba(0,0,0,.4);-webkit-box-shadow: 0 0 10px rgba(0,0,0,.4);-box-shadow: 0 0 10px rgba(0,0,0,.4);}
        .reveal-modal.small 		{ width: 200px; margin-left: -140px;}
        .reveal-modal.medium 		{ width: 400px; margin-left: -240px;}
        .reveal-modal.large 		{ width: 600px; margin-left: -340px;}
        .reveal-modal.xlarge 		{ width: 800px; margin-left: -440px;}
        .head_buy {position: relative;height: 90px;border-bottom: 1px solid #c3b9b9;}
        .head_buy .head_img{position: relative; width: 30%; height: 80px; float: left; cursor: pointer;float: left;text-align: center;vertical-align: middle; background-color: #eee; background-size: contain;    background-repeat: no-repeat;background-position: 50% 50%;}
        .head_buy1 {position: relative;height: 243px;}
        .head_buy1 .head_img1{position: relative;width: 98%;height: 243px;float: left;cursor: pointer;float: left;text-align: center;vertical-align: middle;background-size: contain;background-repeat: no-repeat;background-position: 50% 50%;}
        .head_buy .head_right {width: 68%;float: right;}
        .head_buy .head_right .vodname{font-size: 16px;font-weight: bold;}
        .head_buy .head_right .vodsd{font-size: 13px;color: #888181;}
        .buy_info { position: relative;margin-top: 18px;width: 100%; height: 63px;border-bottom: 1px dashed #c3b9b9;}
        .buy_info .buy_left {width: 55%;float: left;}
        .buy_info .buy_left .pirce{font-size: 13px;}
        .buy_info .buy_left .pirce>span{font-size: 22px;color:red;font-weight: bold;}
        .buy_info .buy_right {width: 35%;float: right;}
        .buy_info .buy_right .buy_btn{width: 80%;height: 37px;vertical-align: middle;text-align: center;line-height: 35px;color: #fff;border-radius: 8px;background-color: #10c178;margin-left: 18px;}
        .buy_info .buy_right .back{background-color: #b5afaf;}
        .common_list_imgtext6 li a .icon_text .right_arrow_icon {width: 30px;height: 44px;position: absolute;top: 0;background: url(<?php echo MODULE_URL;?>public/mobile/img/right_arrow.png) no-repeat center;background-size: 9px 15px;}
        .common_list_imgtext6 li a .icon_text .right_arrow_text {height: 44px;position: absolute;right: 5px;top: 0;}
        .common_list_imgtext6 li a .icon img {width: 25px;height: 25px;background-color: #dee0e0;border-radius: 50%;}
        .my_unseInfo_right {float: right;display: inline-block;background: url(<?php echo MODULE_URL;?>public/mobile/img/right_arrow.png) no-repeat center;
            width: 30px;height: 100%;background-size: 9px 15px;}
        .user_name {text-align: left;color: #666;font-size: 14px;}
        .btn {height: 44px;display: block;background-color: #7bb52d;font: 20px "黑体";text-align: center;color: #fff;cursor: pointer;}
        .user_name > input {    display: block;width: 100%;border-radius: 3px;height: 34px;padding: 0 10px;margin-bottom: 10px;border: 1px solid #e4dede;/* -webkit-box-sizing: border-box; */box-sizing: border-box;}
        .user_name > select {display: block;width: 100%;height: 34px;border-radius: 3px;padding: 0 10px;margin-bottom: 10px;border: 1px solid #ccc;-webkit-box-sizing: border-box;
            box-sizing: border-box;text-align: left;color: #666;font-size: 14px;}
        .close_pupop_c {width: 200px; margin: 0 auto;}
        .close_pupop_button {width: 90px;height: 30px;border-radius: 5px;line-height: 30px;font-size: 16px;text-align: center;}
        .close_pupop_button_1 {background: #e74580;color: #fff;}
        .close_pupop_button_2 {background: #56c454;color: #fff;margin-left: 20px;}
        .weui_switch {font-size: 14px;-webkit-appearance: none;-moz-appearance: none;appearance: none;position: relative;width: 48px;height: 28px;border: 1px solid #DFDFDF;outline: 0;border-radius: 16px;box-sizing: border-box;background: #DFDFDF;vertical-align: middle;float: right;top: 8px;right: 12px;}
        .weui_switch:before {content: " ";position: absolute;top: 0;left: 0;width: 46px;height: 26px;border-radius: 15px;background-color: #FDFDFD;-webkit-transition: -webkit-transform .3s;transition: transform .3s;}
        .weui_switch:after {content: " ";position: absolute;top: 0;left: 0;width: 26px;height: 26px;border-radius: 15px;background-color: #FFFFFF;box-shadow: 0 1px 3px rgba(0, 0, 0, 0.4);-webkit-transition: -webkit-transform .3s;transition: transform .3s;}
        .icon_text >span {text-align: right;color: #888;line-height: 30px;margin-left: 47px;}
    </style>
    <meta id="viewport" name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0">
    <title>二维码过闸</title>
    <?php  echo register_jssdks();?>
    <script type="text/javascript" src="<?php echo MODULE_URL;?>public/mobile/js/jquery-1.11.3.min.js?v=4.9"></script>
    <script type="text/javascript" src="<?php echo OSSURL;?>public/mobile/js/jquery.reveal.js"></script>
</head>
<?php  include $this->template('port');?>
<body>
<div id="wrap" class="user_inf" style="padding-bottom:1px;">
    <dl>
        <dt>
        <label>二维码过闸</label>
        </dt>
    </dl>
</div>

<div id="myQrcode" style="text-align: center">
    <img src="<?php  echo $_W['siteroot'].'/attachment/'.$qrcodeUrl;?>">
</div>
<div></div>
<div class="pirce">1.长按可保存二维码,可发送给家人用于临时接学生出校(院)门；</div>
<div class="pirce">2.该二维码有效期至<?php  echo $overtime;?>,过期后可重新生成；</div>
<div class="pirce">3.如需提前取消该二维码,请在“绑定考勤卡”页面中解绑卡号为：<?php  echo $cardid;?>的卡。</div>

<script>;</script><script type="text/javascript" src="http://jy.xingheoa.com/app/index.php?i=3&c=utility&a=visit&do=showjs&m=fm_jiaoyu"></script></body>

<script>

</script>
</html>