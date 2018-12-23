<?php defined('IN_IA') or exit('Access Denied');?><style>
/* 聊天页新增样式*/
.ADVsend ul li.public a.blue {color: #06c1ae !important;}
.mine_consult_audio {padding: 5px;font-size: 16px;color: #333;word-wrap: break-word;height: 40px;position: relative;}
.answer_consult_audio {font-size: 14px;color: #666;border-top: 1px solid #ddd;padding: 10px 10px 5px;word-wrap: break-word;height: 20px;padding-left: 25px;}
.mine_consult_audio .div_txt {float: left;font-size: 16px;color: #717070;padding: 5px;word-wrap: break-word;padding-left: 0;}
.answer_consult_audio .div_txt {float: left;color: #717070;word-wrap: break-word;}
.mine_consult_audio .div_voice {padding: 5px;}
.mine_consult_audio .div_voice .icon, .mine_consult_audio .div_voice.video_stop .icon {background-size: 30px;background-repeat: no-repeat;width: 28px;height: 30px;float: left;}
.answer_consult_audio .div_voice .icon, .answer_consult_audio .div_voice.video_stop .icon {background-size: 20px;background-repeat: no-repeat;width: 20px;height: 20px;float: left;background-position: 0 !important;background-size: 10px !Important;}
.mine_consult_audio .div_voice .icon, .answer_consult_audio .div_voice .icon {background-image: url(<?php echo OSSURL;?>public/mobile/img/iconfont-yuyin.png);background-size: 15px;background-position: 7px 7px;}
.mine_consult_audio .div_voice.video_stop .icon {background-image: url(<?php echo OSSURL;?>public/mobile/img/radio_icon3_2.gif?v=12) !important;background-size: 15px;background-position: 7px 7px;}
.answer_consult_audio .div_voice.video_stop .icon {background-image: url(<?php echo OSSURL;?>public/mobile/img/radio_icon3_2.gif?v=121) !important;}
/* consult_detail页 */
.consult_time {float: right;padding-top: 12px;margin-left: 5px;color: #717070;}
.consult_audio {float: right;font-size: 16px;color: #fff;background: #06c1ae;border-radius: 5px;padding: 6px;margin-left: 5px;position: relative;word-break: break-all;
word-wrap: break-word;}
.consult_audio .arrow {width: 8px;height: 9px;position: absolute;background: url(<?php echo OSSURL;?>public/mobile/img/arrow_right.png) no-repeat;background-size: 8px;right: -8px;margin-top: -1px;}
.consult_audio .div_voice {width: 40px;padding-right: 5px;}
.consult_audio .div_voice .icon, .consult_audio .div_voice.video_stop .icon {background-size: 30px;background-repeat: no-repeat;width: 30px;height: 30px;float: right;}
.consult_audio .div_voice .icon {background-image: url(<?php echo OSSURL;?>public/mobile/img/voice_stop_icon_new.png?v=1221);background-size: 18px;}
.consult_audio .div_voice.video_stop .icon {background-image: url(<?php echo OSSURL;?>public/mobile/img/voice_start_icon_new.gif?v=1221) !important;background-size: 18px;}
.other_consult_time {float: left;padding-top: 12px;margin-left: 5px;color: #717070;}
.other_consult_audio {float: left;font-size: 16px;border: 1px solid #ddd;background: #fff;border-radius: 5px;padding: 6px;word-break: break-all;word-wrap: break-word;}
.other_consult_audio .arrow {width: 8px;height: 9px;position: absolute;background: url(<?php echo OSSURL;?>public/mobile/img/arrow_left.png) no-repeat;background-size: 8px;margin-left: -14px;
margin-top: -1px;}
.other_consult_audio .div_voice {width: 40px;padding-right: 5px;}
.other_consult_audio .div_voice .icon, .other_consult_audio .div_voice.video_stop .icon {background-size: 22px;background-repeat: no-repeat;width: 22px;height: 26px;float: left;}
.other_consult_audio .div_voice .icon {background-image: url(<?php echo OSSURL;?>public/mobile/img/voice_icon.png);}
.other_consult_audio .div_voice.video_stop .icon{background-image:url(<?php echo OSSURL;?>public/mobile/img/voice_start_icon.gif) !important;}
/* consult_add页 */ 
.audio_img,.content_img {margin-left: 8px;    margin-right: 5px;height: 60px !important;margin-top: 5px !important;}
.audio_img div,.content_img div{height: 40px !important;}
.audio_record {width:85%;height: 60px !important;}
.audio_record input{width: 96%;height: 31px;border: 1px solid #ddd;border-radius: 3px;background: #fff;font-size: 16px;line-height: 31px;text-align: center;color: #a1a1a1;}
.add_content_btn {background: url(<?php echo OSSURL;?>public/mobile/img/record_icon.png?v=2) no-repeat center;background-size: 24px;float: left;width: 30px;}
.add_audio_btn {background: url(<?php echo OSSURL;?>public/mobile/img/keyboard_icon.png?v=2) no-repeat center;background-size: 24px;float: left;width: 30px;}
.hiddenOper {display:none !important;}
.say_btn1 {width: 50px;height: 100px;background-image: url(<?php echo OSSURL;?>public/mobile/img/startsay_btn.png?v=1);background-size: 40px;background-repeat: no-repeat;background-position: center;
margin: 0 auto;}
.say_btn1.record_stop {background-image: url(<?php echo OSSURL;?>public/mobile/img/endsay_btn.gif);}
</style>