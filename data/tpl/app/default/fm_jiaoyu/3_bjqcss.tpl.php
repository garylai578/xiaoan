<?php defined('IN_IA') or exit('Access Denied');?><style>
/*公共样式*/
html {
    -webkit-text-size-adjust: 100%;
}

body, h1, h2, h3, h4, h5, p, table, ul, li, textarea, select, input, a {
    padding: 0;
    margin: 0;
    outline-style: none;
    -webkit-tap-highlight-color: rgba(0,0,0,0);
    -webkit-appearance: none;
    font-size: 14px;
}

body {
    background-color: #f0f0f2;
    padding: 0px;
    margin: 0px;
    width: 100%;
    color: #333333;
    font-family: Helvetica;
    font-size: 14px;
    word-wrap: break-word;
}

html, body {
    width: 100%;
    font-family: "微软雅黑";
}

ul li {
    list-style: none;
}

    ul li a {
        text-decoration: none;
        display: block;
        height: 100%;
        color: #333333;
    }

a, a:hover {
    text-decoration: none; /* display: block; height: 100%; width: 100%; */
}

    a img {
        border: none;
    }

.clear {
    clear: both;
    overflow: hidden;
    height: 1px;
    line-height: 1px;
}

.clear1 {
    clear: both;
    overflow: hidden;
    height: 1px;
    line-height: 1px;
}

.blank {
    clear: both;
    height: 10px;
}

.small_blank {
    height: 5px;
    clear: both;
}

.over_hidden {
    overflow: hidden;
    white-space: nowrap;
    text-overflow: ellipsis;
}

.float_left {
    float: left;
}

.float_right {
    float: right;
}

.float_l {
    float: left;
}

.float_r {
    float: right;
}

h1 {
    font-size: 20px;
    font-weight: bold;
}

.text_center {
    display: block;
    text-align: center;
}

.show {
    display: block;
}

.w50 {
    width: 50%;
    display: block;
}

.clearfloat1 {
    overflow: auto;
    zoom: 1;
}

.box_box {
    display: -moz-box;
    display: -webkit-box;
    display: box;
}

.box_flex1 {
    -moz-box-flex: 1.0;
    -webkit-box-flex: 1.0;
    box-flex: 1.0;
}

.f_red {
    color: #f00;
}

.f_black {
    color: #000;
}

.f_blue {
    color: #30C6E1;
}

.f_grey {
    color: #8d8d8d;
}

.f_orange {
    color: #f60;
}

.f_pink {
    color: #e43373;
}

.top_height_blank {
    height: 60px;
    display: block;
    clear: both;
    opacity: 0;
}

.top_height_blank2 {
    height: 120px;
    display: block;
    clear: both;
}

.top_height_blank3 {
    height: 100px;
    display: block;
    clear: both;
}

.top_height_blank4 {
    height: 70px;
    display: block;
    clear: both;
}

.top_height_blank50 {
    height: 30px;
    display: block;
    clear: both;
}

.top_height_blank110 {
    height: 110px;
    display: block;
    clear: both;
}

.top_height_blank90 {
    height: 90px;
    display: block;
    clear: both;
}

.top_height_blank60 {
    height: 60px;
    display: block;
    clear: both;
}

.top_height_blank70 {
    height: 70px;
    display: block;
    clear: both;
}

.top_height_blank40 {
    height: 40px;
    display: block;
    clear: both;
}

.listTop {
    float: left;
    height: 50px;
    line-height: 50px;
    width: 100%;
    text-align: center;
    font-size: 16px;
    color: #444;
}

.lt_mt50 {
    margin-top: -50px;
}

.lt_mt90 {
    margin-top: -120px;
}

.h20 {
    height: 20px;
}

.h50 {
    height: 50px;
}

.h60 {
    height: 60px;
}

.h100 {
    height: 100px;
}

.white_bg {
    background-color: #fff;
}

.image_contain {
    object-fit: contain;
    width: 100%;
    height: 100%;
}

.image_fill {
    object-fit: fill;
    width: 100%;
    height: 100%;
}

.image_cover {
    object-fit: cover;
    width: 100%;
    height: 100%;
}

.image_scale-down {
    object-fit: scale-down;
    width: 100%;
    height: 100%;
}

/*公共菊花转*/
.common_progress_bg {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    height: 100%;
    width: 100%;
    background: rgba(0, 0, 0, 0.6);
    z-index: 9998;
}

.common_progress {
    position: fixed;
    top: 40%;
    background: #000;
    height: 80px;
    width: 160px;
    border-radius: 12px;
    line-height: 20px;
    text-align: center;
    padding-top: 30px;
    z-index: 9999;
}

    .common_progress > img {
        width: 27px;
        height: 27px;
        padding-top: 30px;
    }

    .common_progress > .common_loading {
        width: 30px;
        height: 30px;
        display: inline-block;
        vertical-align: middle;
        background: url(<?php echo OSSURL;?>public/mobile/img/load.png) no-repeat;
        background-size: 30px;
        -webkit-animation: loading1 2s linear infinite;
    }

@-webkit-keyframes loading1 {
    0% {
        -webkit-transform: rotate(0deg);
    }

    33% {
        -webkit-transform: rotate(120deg);
    }

    66% {
        -webkit-transform: rotate(240deg);
    }

    100% {
        -webkit-transform: rotate(360deg);
    }
}

.common_progress > span {
    margin: 0 0 0 8px;
    color: #fff;
}



/*head_title*/
.head_title {
    width: 200px;
    height: 30px;
    border: 1px solid #30c6e1;
    border-radius: 5px;
    overflow: auto;
    zoom: 1;
    margin: 0 auto;
}

    .head_title li {
        float: left;
        text-align: center;
        height: 100%;
        line-height: 30px;
        color: #000;
        background-color: #fff;
        width: 100px;
    }

        .head_title li a {
            width: 100%;
            display: block;
            height: 100%;
            color: #000;
            font-size: 16px;
        }

        .head_title li:first-child {
            border-radius: 5px 0 0 5px;
        }

        .head_title li:last-child {
            border-radius: 0 5px 5px 0;
        }

        .head_title li.act {
            background-color: #30c6e1;
            color: #fff;
        }

            .head_title li.act a {
                color: #fff;
            }
    /*head_title parent_part*/
    .head_title.parent_p {
        border: 1px solid #55c354;
    }

        .head_title.parent_p li.act {
            background-color: #55c354;
            color: #fff;
        }




/*
.diary_tag_education{ background: url(<?php echo OSSURL;?>public/mobile/img/banjilog_type_0.png) no-repeat 7px center; background-size: 12px; background-color: #46a0d4;}
.diary_tag_activity{ background: url(<?php echo OSSURL;?>public/mobile/img/banjilog_type_4.png) no-repeat 7px center; background-size: 12px; background-color: #66c965;}
.diary_tag_other{ background: url(<?php echo OSSURL;?>public/mobile/img/banjilog_type_5.png) no-repeat 7px center; background-size: 12px; background-color: #db6a74;}
*/




/*语音播放列表*/
.video_list {
    zoom: 1;
    overflow: auto;
    padding: 10px;
}

    .video_list > li {
        font-size: 16px;
        border: 1px solid #ddd;
        background: #fff;
        border-radius: 5px;
        position: relative;
        width: 80px;
        min-width: 80px;
        display: block;
        max-width: 160px;
        color: #ddd;
        padding: 8px 5px;
        padding-right: 36px;
        zoom: 1;
        height: 20px;
        line-height: 20px;
        text-align: right;
        margin-bottom: 10px;
    }

        .video_list > li > .arrow {
            width: 8px;
            height: 9px;
            position: absolute;
            background: url(<?php echo OSSURL;?>public/mobile/img/arrow_left.png) no-repeat;
            background-size: 8px;
            left: -8px;
            top: 13px;
        }

        .video_list > li > .voice_play_tip {
            height: 20px;
            width: 30px;
            background-image: url(<?php echo OSSURL;?>public/mobile/img/voice_icon.png);
            background-size: 14px;
            background-repeat: no-repeat;
            background-position: center;
            position: absolute;
            left: 5px;
        }

        .video_list > li.video_stop > .voice_play_tip {
            background-image: url(<?php echo OSSURL;?>public/mobile/img/voice_start_icon.gif);
        }

        .video_list > li > .delete_voice_btn {
            width: 36px;
            height: 36px;
            background: url("<?php echo OSSURL;?>public/mobile/img/delete_say_btn.png") no-repeat center;
            background-size: 18px;
            position: absolute;
            right: 0px;
            display: block;
            top: 0px;
            z-index: 1;
        }

        .video_list > li > audio {
            display: none;
        }


/*图片放大*/
.slide-view {
    background: rgb(0,0,0);
    position: absolute;
    width: 100%;
    height: 100%;
    overflow: hidden;
    top: 0;
    left: 0;
    z-index: 9999;
}

.container {
    margin-top: 10px;
    padding: 0 5px;
    overflow: hidden;
}

.slideBox {
    width: 100%;
    position: relative;
    margin-top: 10px;
    overflow: hidden;
}

.pv-inner {
    position: relative;
    z-index: -1;
    display: -webkit-box;
    display: -moz-box;
    display: box;
    width: 100%;
    height: 100%;
    -webkit-transition: all 350ms linear;
    -webkit-backface-visibility: hidden;
    -moz-transition: all 350ms linear;
    -moz-backface-visibility: hidden;
    transition: all 350ms linear;
    backface-visibility: hidden;
}

    .pv-inner li {
        text-align: center;
    }

    .pv-inner img {
        max-width: 97%;
        vertical-align: middle;
        -webkit-transform: scale(1) translate(0px,0px);
        -moz-transform: scale(1) translate(0px,0px);
        transform: scale(1) translate(0px,0px);
        max-height: 100%;
        visibility: visible;
        -webkit-transition: 200ms;
        -moz-transition: 200ms;
        transition: 200ms;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
    }

.slide-view .counts {
    position: absolute;
    top: 5%;
    left: 0;
    right: 0;
    text-align: center;
}

    .slide-view .counts .value {
        border-radius: 9px;
        line-height: 18px;
        padding: 0 6px;
        font-size: 11px;
        display: inline-block;
        background-color: rgba(102, 102, 102, 0.6);
        color: rgb(241, 241, 241);
    }

    .slide-view .counts .picText {
        border-radius: 9px;
        line-height: 18px;
        padding: 0 6px;
        font-size: 11px;
        display: block;
        text-align: center;
        color: rgb(241, 241, 241);
    }

.slide-view .ui-loading {
    position: absolute;
    margin: -10px 0 0 -10px;
    left: 50%;
    top: 50%;
}

.ui-loading {
    display: inline-block;
    position: relative;
    width: 40px;
    height: 20px;
    vertical-align: middle;
    margin: -4px 2px 0 -42px;
}

    .ui-loading .white i {
        background: rgb(255, 255, 255);
    }

#J_loading {
    background: url(<?php echo OSSURL;?>public/mobile/img/loading.gif) no-repeat center;
    background-size: 16px;
}
/*图片放大end*/


.video_bg {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    height: 100%;
    width: 100%;
    background-color: #000;
    background: rgba(0, 0, 0, 1);
    z-index: 99999;
}

    .video_bg video {
        height: 80%;
        width: 100%;
        background-color: #000;
        margin-top: 20%;
    }

    .video_bg .close_video_btn {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background-color: #fff;
        color: #333;
        font-size: 16px;
        text-align: center;
        line-height: 40px;
        position: fixed;
        top: 10px;
        right: 10px;
        z-index: 9999999;
    }

    .video_bg .report_video_btn {
        width: 50px;
        height: 40px;
        color: #fff;
        font-size: 16px;
        text-align: center;
        line-height: 40px;
        position: fixed;
        top: 10px;
        left: 10px;
        z-index: 9999999;
    }

    .video_bg .has_report_video_btn {
        width: 50px;
        height: 40px;
        color: #eee;
        font-size: 16px;
        text-align: center;
        line-height: 40px;
        position: fixed;
        top: 10px;
        left: 10px;
        z-index: 9999999;
    }
/*支付*/
/*还未续费*/


/*暂无缴费记录*/


.F_div {
    width: 60px;
    height: 60px;
    background:#ff6665; 
    box-shadow: 1px 1px 2px 0px #909090;
    border-radius: 50px;
    position: fixed;
    bottom: 30px;
    right: 60px;
}

.F_div_text {
    margin: 20px 0 0 0px;
    color: #FFF;
    font-size: 16px;
    text-align: center;
}


/*通知查看记录*/

/*new_bind*/

/*成长*/
.new_bottom_menu {
    height: 50px;
    width: 100%;
    background-color: #e7e6e6;
    display: box;
    display: -webkit-box;
    position: fixed;
    bottom: 0;
    left: 0;
    border-top: 1px solid #ccc;
}

    .new_bottom_menu li {
        -webkit-box-flex: 1;
        width: 1px;
        height: 50px;
    }

        .new_bottom_menu li a {
            width: 100%;
            height: 100%;
            box-sizing: border-box;
            padding: 30px 0 5px;
            text-align: center;
            font-size: 12px;
            color: #000;
            background-size: auto 20px;
            background-position: center 7px;
            background-repeat: no-repeat;
        }

            .new_bottom_menu li a.act {
                color: #55c354;
            }

        .new_bottom_menu li:nth-child(1) a {
            background-image: url(<?php echo OSSURL;?>public/mobile/img/grow_menu_icon1.png);
        }

        .new_bottom_menu li:nth-child(2) a {
            background-image: url(<?php echo OSSURL;?>public/mobile/img/grow_menu_icon2.png);
        }

        .new_bottom_menu li:nth-child(3) a {
            background-image: url(<?php echo OSSURL;?>public/mobile/img/grow_menu_icon3.png);
        }

        .new_bottom_menu li:nth-child(4) a {
            background-image: url(<?php echo OSSURL;?>public/mobile/img/grow_menu_icon4.png);
        }

        .new_bottom_menu li:nth-child(1) a.act {
            background-image: url(<?php echo OSSURL;?>public/mobile/img/grow_menu_icon1_0.png);
        }

        .new_bottom_menu li:nth-child(2) a.act {
            background-image: url(<?php echo OSSURL;?>public/mobile/img/grow_menu_icon2_0.png);
        }

        .new_bottom_menu li:nth-child(3) a.act {
            background-image: url(<?php echo OSSURL;?>public/mobile/img/grow_menu_icon3_0.png);
        }

        .new_bottom_menu li:nth-child(4) a.act {
            background-image: url(<?php echo OSSURL;?>public/mobile/img/grow_menu_icon4_0.png);
        }

 
/*成长档案*/
 
/*成长档案列表*/
   
/*未读信息*/

/*park*/

.pagination.pagination1, .pagination1 {
    height: 30px;
    position: absolute;
    margin: 0;
    bottom: 0;
    left: 0;
    width: 100%;
    padding: 5px 10px 0 0;
    box-sizing: border-box;
    text-align: center;
    display: block;
}

.swiper-slide {
    position: relative;
}

    .swiper-slide img {
        height: 100%;
    }

    .swiper-slide .new_img_til {
        height: 30px;
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        padding: 0 120px 0 10px;
        box-sizing: border-box;
        color: #fff;
        background-color: rgba(0,0,0,0.5);
        line-height: 30px;
        font-size: 14px;
        text-align: left;
    }

    .swiper-slide .new_call_btn {
        height: 50px;
        width: 50px;
        background: url(<?php echo OSSURL;?>public/mobile/img/new_calling_icon1.png) no-repeat center;
        position: absolute;
        top: 0px;
        right: 0px;
        background-size: 30px;
        display: block;
        z-index: 5;
    }

.swiper-pagination-switch {
    background: rgba(255, 255, 255, 0.4);
}
/*修改*/
.swiper-active-switch {
    background-color: #fff;
}
/*修改*/

.slide_menu_box {
    padding: 5px 0;
    width: 100%;
    background-color: #fff;
    border-bottom: 1px solid #ccc;
    position: relative;
}

.swiper-container2 {
    height: 100%;
}

    .swiper-container2 .swiper-wrapper .swiper-slide {
        width: 120%;
    }
/*edit_8/5*/
.pagination.pagination2, .pagination2 {
    height: 0;
    position: absolute;
    bottom: 0;
    left: 0;
    width: 100%;
    opacity: 0;
}

.slide_icon_div {
    width: 20.2%;
    height: 100px;
    float: left;
}

    .slide_icon_div a {
        width: 100%;
        height: 100%;
        display: block;
        color: #333;
    }

        .slide_icon_div a .icon {
            width: 90%;
            height: 70px;
            display: block;
            margin: 0 auto;
            padding: 5px 0;
            border-radius: 5px;
        }

            .slide_icon_div a .icon img {
                width: 100%;
                height: 100%;
                border-radius: 5px;
            }

        .slide_icon_div a .icon_text {
            width: 100%;
            height: 20px;
            line-height: 20px;
            display: block;
            text-align: center;
            font-size: 12px;
            color: #333;
        }


/*侧边菜单*/
.show_menu_bg.slide_left_menu_bg {
    display: block;
    -webkit-animation-name: fadeIn;
    animation-name: fadeIn;
    -webkit-animation-duration: 400ms;
    animation-duration: 400ms;
    -webkit-animation-fill-mode: both;
    animation-fill-mode: both;
}

.show_menu_bg .slide_left_menu {
    -webkit-animation-name: fadeInRightBig;
    animation-name: fadeInRightBig;
    -webkit-animation-duration: 500ms;
    animation-duration: 500ms;
    -webkit-animation-delay: 100ms;
    animation-delay: 100ms;
    -webkit-animation-fill-mode: both;
    animation-fill-mode: both;
}

.slide_left_menu_bg {
    width: 100%;
    z-index: 998;
    background: rgba(0,0,0,0.5);
    position: fixed;
    min-height: 100%;
    top: 0;
    left: 0;
    zoom: 1;
    overflow: auto;
    display: none;
}

.slide_left_menu {
    width: 60%;
    right: 0;
    background-color: #fff;
    z-index: 999;
    min-height: 100%;
    position: absolute;
    -webkit-overflow-scrolling: touch;
}

.slide_left_menu_til {
    height: 40px;
    line-height: 40px;
    box-sizing: border-box;
    padding: 0 40px 0 15px;
    position: relative;
    font-size: 16px;
}

    .slide_left_menu_til .add_user_btn {
        height: 40px;
        width: 40px;
        background: url(<?php echo OSSURL;?>public/mobile/img/add_people_icon.png) no-repeat center;
        background-size: 20px;
        position: absolute;
        right: 0px;
        top: 0;
        padding: 0 10px;
    }

.slide_left_menu_ul {
    width: 100%;
    border: 1px solid #ccc;
    border-left: none;
    border-right: none;
    box-sizing: border-box;
    padding: 0 10px;
}

    .slide_left_menu_ul li {
        height: 50px;
        line-height: 50px;
        border-bottom: 1px solid #ccc;
        font-size: 16px;
        width: 100%;
        box-sizing: border-box;
        overflow: hidden;
        position: relative;
    }

        .slide_left_menu_ul li.act {
            background: url(<?php echo OSSURL;?>public/mobile/img/be_choose_icon.png) right center no-repeat;
            background-size: 16px;
            background-origin: content-box;
            -moz-background-origin: content-box;
            -webkit-background-origin: content-box;
        }

        .slide_left_menu_ul li:last-of-type {
            border-bottom: none;
        }

        .slide_left_menu_ul li .user_img {
            width: 50px;
            height: 50px;
            position: absolute;
            left: -5px;
            top: 0;
            box-sizing: border-box;
            padding: 10px;
        }

            .slide_left_menu_ul li .user_img img {
                width: 100%;
                height: 100%;
                border-radius: 50%;
            }

        .slide_left_menu_ul li .change_user {
            width: 40px;
            height: 100%;
            position: absolute;
            right: 0;
            top: 0;
            background: url(<?php echo OSSURL;?>public/mobile/img/be_choose_icon.png) center no-repeat;
            background-size: 30px;
        }

@-webkit-keyframes fadeIn {
    0% {
        opacity: 0;
    }

    100% {
        opacity: 1;
    }
}

@keyframes fadeIn {
    0% {
        opacity: 0;
    }

    100% {
        opacity: 1;
    }
}

.fadeIn {
    -webkit-animation-name: fadeIn;
    animation-name: fadeIn;
}

@-webkit-keyframes fadeInLeftBig {
    0% {
        opacity: 0;
        -webkit-transform: translate3d(-2000px, 0, 0);
        transform: translate3d(-2000px, 0, 0);
    }

    100% {
        opacity: 1;
        -webkit-transform: none;
        transform: none;
    }
}

@keyframes fadeInLeftBig {
    0% {
        opacity: 0;
        -webkit-transform: translate3d(-2000px, 0, 0);
        transform: translate3d(-2000px, 0, 0);
    }

    100% {
        opacity: 1;
        -webkit-transform: none;
        transform: none;
    }
}

@-webkit-keyframes fadeInRightBig {
    0% {
        opacity: 0;
        -webkit-transform: translate3d(2000px, 0, 0);
        transform: translate3d(2000px, 0, 0);
    }

    100% {
        opacity: 1;
        -webkit-transform: none;
        transform: none;
    }
}

@keyframes fadeInRightBig {
    0% {
        opacity: 0;
        -webkit-transform: translate3d(2000px, 0, 0);
        transform: translate3d(2000px, 0, 0);
    }

    100% {
        opacity: 1;
        -webkit-transform: none;
        transform: none;
    }
}

@-webkit-keyframes fadeOutLeftBig {
    0% {
        opacity: 1;
    }

    100% {
        opacity: 0;
        -webkit-transform: translate3d(-2000px, 0, 0);
        transform: translate3d(-2000px, 0, 0);
    }
}

@keyframes fadeOutLeftBig {
    0% {
        opacity: 1;
    }

    100% {
        opacity: 0;
        -webkit-transform: translate3d(-2000px, 0, 0);
        transform: translate3d(-2000px, 0, 0);
    }
}

.fadeOutLeftBig {
    -webkit-animation-name: fadeOutLeftBig;
    animation-name: fadeOutLeftBig;
}

/* progress */
.progress_bg {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    height: 100%;
    width: 100%;
    background: rgba(0, 0, 0, 0.6);
    z-index: 9998;
}

.progress {
    position: fixed;
    top: 40%;
    background: #000;
    height: 80px;
    width: 160px;
    border-radius: 12px;
    line-height: 20px;
    text-align: center;
    padding-top: 30px;
    z-index: 9999;
}

    .progress > img {
        width: 27px;
        height: 27px;
        padding-top: 30px;
    }

    .progress > .loading {
        width: 30px;
        height: 30px;
        display: inline-block;
        vertical-align: middle;
        background: url(<?php echo OSSURL;?>public/mobile/img/load.png) no-repeat;
        background-size: 30px;
        -webkit-animation: loading1 2s linear infinite;
    }

@-webkit-keyframes loading1 {
    0% {
        -webkit-transform: rotate(0deg);
    }

    33% {
        -webkit-transform: rotate(120deg);
    }

    66% {
        -webkit-transform: rotate(240deg);
    }

    100% {
        -webkit-transform: rotate(360deg);
    }
}

.progress > span {
    margin: 0 0 0 8px;
    color: #fff;
}
/* End of progress_2 */

/*name_book*/

/*表情*/
.face_icon {
    width: 20px;
    height: 20px;
    margin: 0 1px;
    vertical-align: top;
}

.num {
    font-family: Helvetica;
    top: 0px;
    background-color: #ff0000;
    color: #fff;
    position: absolute;
    right: 0px;
    border-radius: 50%;
    padding: 0px;
    line-height: 20px;
    width: 20px;
    height: 20px;
    text-align: center;
    font-size: 10px;
}

#popup_prompt {
    border: 1px solid #ccc;
    border-radius: 5px;
    height: 40px;
}

/*无内容*/

/*pei20150318*/
 
.swiper-container3 {
    position: relative;
    height: 350px;
}

.swiper-slide.swiper-slide_v {
    height: 7px;
    width: 160px;
}
 
.measure_til {
    font-size: 26px;
    line-height: 26px;
}

.hidden {
    display: none;
}
 
/*finger_tips*/
 
  
/*信箱*/
  

.new_empty_icon {
    background: url(<?php echo OSSURL;?>public/mobile/img/new_empty_icon.png) no-repeat center;
    width: 120px;
    height: 140px;
    background-size: 120px;
    margin: 50px auto 10px;
}


/*头部*/
.top_head_blank {
    clear: both;
    height: 60px;
}

.top {
    background: #33bd61;
    height: 60px;
    position: fixed;
    z-index: 10;
    width: 100%;
    top: 0px;
    box-sizing: border-box;
}

.top_1 {
    background: #56c454;
    height: 60px;
    width: 100%;
    top: 0px;
    position: fixed;
    z-index: 10;
}

.top_2 {
    background: #30c6e1;
    height: 60px;
    position: fixed;
    z-index: 10;
    width: 100%;
    top: 0px;
}

.float_left {
    float: left;
}

.float_right {
    float: right;
}
  
/*各种无数据显示*/

/*暂无签到*/
 
/*pei20150318*/
/*暂无通知*/
 
/*pei20150318*/
/*暂无公告*/

 
/*pei20150318*/

/*显示完毕*/
 

/*还未续费*/
 
/*未读信息*/
 
/*亲子时光 20141106 chensz*/
  
/*师资力量 20141106 chensz*/
 
/*幼儿园介绍 20141110 chensz*/
 
/*添加overflow 20141204 chensz*/

/*幼儿园新闻 20141110 chensz*/

/*每日食谱 20141112 chensc*/

 /*2014-11-17 chensz */ /*20141226 chensz 修改*/ /*20141229 chensz 修改*/
  
/*2014-11-17 chensz 修改*/
 
/*----------每日食谱-new----------*/
 
/*请假*/
  
/*修改 2014-11-24 chensz*/
 
/*修改 2014-11-24 chensz*/
  

/*底部加载 2014-11-27 liangjw*/
 
/*加载中 2014-11-27 chensz*/
.YZloadBox {
    width: 100%;
    text-align: center;
}

    .YZloadBox .loading {
        width: 30px;
        height: 30px;
        display: inline-block;
        vertical-align: middle;
        background-size: 30px;
        -webkit-animation: YZloading1 2s linear infinite;
    }

@-webkit-keyframes YZloading1 {
    0% {
        -webkit-transform: rotate(0deg);
    }

    33% {
        -webkit-transform: rotate(120deg);
    }

    66% {
        -webkit-transform: rotate(240deg);
    }

    100% {
        -webkit-transform: rotate(360deg);
    }
}

.YZloadBox p {
    font-weight: lighter;
    margin: 0;
    vertical-align: middle;
    padding-top: 5px;
    font-size: 12px;
    color: #666;
}

/**咨询老师**/
  
.iphone {
    position: absolute;
    right: 10px;
    width: 30px;
    top: 2px;
    height: 30px;
    background: url(<?php echo OSSURL;?>public/mobile/img/phone.png) no-repeat;
    background-size: 30px;
    z-index: 1;
}
/*修改样式 chensz 20141223*/



input[type="submit"], input[type="text"], input[type="button"], select, button {
    -webkit-appearance: none;
    -webkit-tap-highlight-color: rgba(0,0,0,0);
}
   

/**消息提醒**/
 
.switch {
    position: relative;
    width: 60px;
    height: 24px;
    padding: 2px;
    border-radius: 15px;
    transition: all ease-in-out 1s;
}

.switch_on {
    background: #ccc;
    box-shadow: 0px 0px 8px rgba(0,0,0,.3) inset;
}

.switch_off {
    background: #55c354;
    box-shadow: 0px 0px 8px rgba(10,176,96,.8) inset;
}

.switch_push {
    position: absolute;
    width: 40px;
    height: 24px;
    background-color: #fff;
    background-image: -webkit-gradient(linear,0% 0%, 0% 100%, from(#FFFFFF), to(#ddd));
    border-radius: 12px;
    box-shadow: 0px 3px 2px rgba(0,0,0,.1),0px -1px 0px rgba(150,150,150,.1) inset;
    transition: all ease-in-out 0.3s;
}

.switch_on .switch_push {
    left: 2px;
}

.switch_off .switch_push {
    left: 22px;
}

.switch_round {
    width: 18px;
    height: 18px;
    margin: 3px 0 0 3px;
    background-color: #eee;
    background-image: -webkit-gradient(linear,0% 0%, 0% 100%, from(#ddd), to(#FFFFFF));
    border-radius: 50%;
}

.unread {
    position: absolute;
    width: 12px;
    height: 12px;
    border-radius: 50%;
    margin-left: -6px;
    margin-top: -6px;
    background-color: #e60012;
}


/**咨询详细页（对话列表）**/
  
/**通话**/
  
/*修改bug chensz 20150102*/
  
/*家长刷卡设置 20150209 chensz*/
  
.del {
    position: absolute;
    top: 10px;
    right: 10px;
    background: url(<?php echo OSSURL;?>public/mobile/img/H_heng.png) no-repeat;
    width: 15px;
    height: 15px;
    background-size: 15px;
    display: none;
}
 
 
 
 
/*我的宝宝——语音播报 chensz 20150211*/
  
/*接送记录*/
 
   
/*无内容*/
  
/*新师资力量 */
  

/*举报列表样式*/
.report_bg {
    width: 100%;
    overflow-y: scroll;
    height: 100%;
    top: 0;
    bottom: 0;
    left: 0;
    position: fixed;
    z-index: 999999998;
    background-color: #fff;
    display: none;
}

.report_title {
    box-sizing: border-box;
    padding: 0 10px;
    background-color: #f1f0f5;
    height: 40px;
    line-height: 40px;
    overflow: hidden;
    color: #8d8c91;
    font-size: 16px;
}

.report_submit_btn {
    background-color: #04be02;
    height: 40px;
    line-height: 40px;
    text-align: center;
    font-size: 14px;
    color: #fff;
    border-radius: 8px;
    margin: 5px 10px;
}

.report_cancel_btn {
    background-color: #f1f0f5;
    height: 40px;
    line-height: 40px;
    text-align: center;
    font-size: 14px;
    color: #8d8c91;
    border-radius: 8px;
    margin: 5px 10px;
}

.report_ul {
    background-color: #fff;
    padding: 0 10px;
}

    .report_ul li {
        border-bottom: 1px solid #efefee;
        padding: 10px;
        line-height: 20px;
        box-sizing: border-box;
        width: 100%;
    }

        .report_ul li.act {
            background: url(<?php echo OSSURL;?>public/mobile/img/B_gou.png) no-repeat right center;
            background-size: 20px;
        }

.report_add_btn {
    height: 30px;
    line-height: 30px;
    font-size: 12px;
    color: #666;
    text-align: right;
}

.report_over_btn {
    height: 30px;
    line-height: 30px;
    font-size: 12px;
    color: #666;
    text-align: right;
}

.new_report_add_btn {
    font-size: 12px;
    color: #55c354;
    margin: 0 5px;
}

.new_report_over_btn {
    font-size: 12px;
    color: #666;
    margin: 0 5px;
}

/*iso_check_box*/
.weui_cell_ft {
    text-align: right;
    color: #888;
    line-height: 30px;
}

.weui_switch {
    font-size: 14px;
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
    position: relative;
    width: 48px;
    height: 28px;
    border: 1px solid #DFDFDF;
    outline: 0;
    border-radius: 16px;
    box-sizing: border-box;
    background: #DFDFDF;
    vertical-align: middle;
}

    .weui_switch:before {
        content: " ";
        position: absolute;
        top: 0;
        left: 0;
        width: 46px;
        height: 26px;
        border-radius: 15px;
        background-color: #FDFDFD;
        -webkit-transition: -webkit-transform .3s;
        transition: transform .3s;
    }

    .weui_switch:after {
        content: " ";
        position: absolute;
        top: 0;
        left: 0;
        width: 26px;
        height: 26px;
        border-radius: 15px;
        background-color: #FFFFFF;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.4);
        -webkit-transition: -webkit-transform .3s;
        transition: transform .3s;
    }

    .weui_switch:checked {
        border-color: #04BE02;
        background-color: #04BE02;
    }

        .weui_switch:checked:before {
            -webkit-transform: scale(0);
            transform: scale(0);
        }

        .weui_switch:checked:after {
            -webkit-transform: translateX(20px);
            transform: translateX(20px);
        }

.main {
    margin: 12px 10px 10px 10px;
    box-shadow: 1px 1px 1px 1px #cdcdcd;
    background: #FFF;
    padding-bottom: 1px;
}


/*3.0*/
.top_ban {
    z-index: 3;
    width: 100%;
    height: 40px;
    box-sizing: border-box;
    background-color: #22292c;
    position: fixed;
    top: 0;
    left: 0;
    padding: 10px 40px;
}

    .top_ban .text {
        width: 100%;
        line-height: 20px;
        overflow: hidden;
        color: #fff;
        font-size: 16px;
    }

    .top_ban .left_div {
        position: absolute;
        left: 0;
        top: 0;
        width: 40px;
        height: 40px;
    }

    .top_ban .right_div {
        position: absolute;
        right: 0;
        top: 0;
        width: 40px;
        height: 40px;
    }

    .top_ban .user_icon {
        background: url(<?php echo OSSURL;?>public/mobile/img/head_icon_3.png) no-repeat center;
        background-size: 20px;
    }

    .top_ban .search_icon {
        background: url(<?php echo OSSURL;?>public/mobile/img/search_icon_3.png) no-repeat center;
        background-size: 20px;
    }

    .top_ban .goback_home_icon {
        background: url(<?php echo OSSURL;?>public/mobile/img/goback_home_icon3.png) no-repeat center;
        background-size: 20px;
    }

.top_head_box3 {
    position: relative;
    height: 150px;
    padding: 10px;
    box-sizing: border-box;
    zoom: 1;
    overflow: hidden;
    background: url(<?php echo OSSURL;?>public/mobile/img/head_bg_3.jpg) no-repeat center;
    background-size: cover;
}

    .top_head_box3 .img {
        width: 70px;
        height: 70px;
        border: 2px solid #fff;
        box-shadow: 1px 1px 1px #ddd;
        border-radius: 80px;
        margin: 0 auto;
    }

        .top_head_box3 .img img {
            border-radius: 80px;
            width: 70px;
            height: 70px;
        }

    .top_head_box3 .user_info_box {
        text-align: center;
        padding: 2px 15px 2px;
    }

        .top_head_box3 .user_info_box .info_text1 {
            font-size: 14px;
            line-height: 20px;
            color: #fff;
        }

        .top_head_box3 .user_info_box .info_text2 {
            font-size: 16px;
            line-height: 26px;
            color: #fff;
        }

        .top_head_box3 .user_info_box .edit_info_btn3 {
            font-size: 14px;
            height: 30px;
            line-height: 30px;
            margin-top: 5px;
            width: 100px;
            text-align: center;
            border-radius: 5px;
            color: #fff;
            background: rgba(0, 0, 0, 0.4);
            margin: 0 auto;
        }

    .top_head_box3 .arrow_right_icon {
        height: 100%;
        width: 30px;
        background: url(<?php echo OSSURL;?>public/mobile/img/right_arrow_icon_3.png) no-repeat center;
        background-size: 10px;
        float: right;
    }

    .top_head_box3 .user_icon {
        background: url(<?php echo OSSURL;?>public/mobile/img/head_icon_3.png) no-repeat center;
        background-size: 24px;
        position: absolute;
        right: 0;
        top: 0;
        width: 40px;
        height: 40px;
        z-index: 999;
    }

    .top_head_box3 .search_icon {
        background: url(<?php echo OSSURL;?>public/mobile/img/search_icon_3.png) no-repeat center;
        background-size: 50px;
        position: absolute;
        left: 5px;
        top: 5px;
        width: 80px;
        height: 40px;
        z-index: 999;
    }

	.top_head_box3 .fabu_icon {
        background: url(<?php echo OSSURL;?>public/mobile/img/camera.png) no-repeat center;
        background-size: 30px;
        position: absolute;
        right: 20px;
        top: 5px;
        width: 40px;
        height: 40px;
        z-index: 999;
    }
	
    .top_head_box3 .index_img {
        width: 76px;
        height: 76px;
        border: 2px solid #fff;
        box-shadow: 1px 1px 1px #ddd;
        position: absolute;
        right: 10px;
        bottom: -15px;
        border-radius: 80px;
    }

        .top_head_box3 .index_img img {
            border-radius: 80px;
            width: 76px;
            height: 76px;
        }

    .top_head_box3 .index_username {
        font-size: 16px;
        line-height: 26px;
        text-align: right;
        color: #fff;
        position: absolute;
        right: 100px;
        bottom: 18px;
        text-overflow: ellipsis;
        white-space: nowrap;
        text-shadow: 1px 1px 0px #666;
        overflow: hidden;
    }

    .top_head_box3.index_top {
        margin-bottom: 17px;
        overflow: hidden;
    }

a.new_info_tips3 {
    /* margin: 50px auto; */
    margin-top: 50px;
    margin-right: auto;
    /* margin-bottom: 50px; */
    margin-left: auto;
    line-height: 30px;
    border-radius: 5px;
    display: block;
    width: 160px;
    height: 34px;
    padding: 2px;
    box-sizing: border-box;
    background-color: #383939;
    color: #fff;
    text-align: center;
    position: relative;
}

/*未读消息*/
.new_info_tips3 .img {
    width: 26px;
    height: 26px;
    border-radius: 3px;
    position: absolute;
    left: 4px;
    top: 4px;
}

.new_info_tips3 .text {
    box-sizing: border-box;
    padding-left: 20px;
}

.new_info_tips3 .img img {
    width: 26px;
    height: 26px;
    border-radius: 3px;
}

.new_info_tips3 .arrow_right_icon {
    width: 10px;
    height: 34px;
    background: url(<?php echo OSSURL;?>public/mobile/img/right_arrow_icon_3_2.png) no-repeat center;
    background-size: 6px;
    position: absolute;
    right: 10px;
    top: 0;
}

/*家长端是否评论样式*/
.other_control_iconStatus {
    display: none;
}

/*new_diary_list3*/
.new_diary_list3 {
    margin: 17px 10px 0 10px;
    margin-left: 10px;
	/*margin-top: 55px;*/
    margin-right: 10px;
}

    .new_diary_list3 > li {
        /*border-bottom:1px solid #ccc;*/
        margin: 10px 0 10px 0;
        border-radius: 10px;
        border-bottom: 1px solid #f3f3f3;
        /*border-top: 1px solid #e1e1df;*/
        background-color: #ffffff;
        position: relative;
        width: 100%;
        padding: 0;
        box-sizing: border-box;
    }

    .new_diary_list3 li .reply_box_div {
        background-color: #ffffff;
        width: 100%;
        height: 30px;
        position: relative;
        display: none;
    }

    .new_diary_list3 li .reply_face_div {
        width: 100%;
        position: relative;
        display: none;
        background-color: #ffffff;
    }

    .new_diary_list3 li .user_img {
        width: 40px;
        height: 40px;
        border-radius: 18px;
        position: absolute;
        left: 10px;
        top: 10px;
    }

        .new_diary_list3 li .user_img img {
            width: 40px;
            height: 40px;
            border-radius: 20px;
        }

    .new_diary_list3 li .user_content {
        width: 100%;
        padding: 5px 10px 5px 54px;
        box-sizing: border-box;
    }

    .new_diary_list3 li .user_info {
        width: 100%;
        color: #55c354;
        line-height: 26px;
        font-size: 15px;
    }

    .new_diary_list3 li .notify_title3 {
        width: 100%;
        color: #000;
        line-height: 22px;
        font-size: 15px;
    }

    .new_diary_list3 li .user_text {
        width: 100%;
        color: #000;
        line-height: 20px;
        font-size: 14px;
        max-height: 120px;
        overflow: hidden;
        box-sizing: border-box;
        padding-right: 15px;
    }

        .new_diary_list3 li .user_text .inside_user_text {
            width: 100%;
            color: #000;
            line-height: 24px;
            font-size: 14px;
        }

            .new_diary_list3 li .user_text .inside_user_text img {
                width: 100%;
            }

                .new_diary_list3 li .user_text .inside_user_text img.face_icon {
                    width: 20px;
                }

        .new_diary_list3 li .user_text.show_all {
            max-height: none;
        }

.empty_search_data {
    display: none;
    text-align: center;
}

    .empty_search_data img {
        width: 100px;
        margin: 30px auto;
    }

.empty_content_data {
    display: none;
    text-align: center;
}

    .empty_content_data img {
        width: 100px;
        margin: 30px auto 2px;
    }

    .empty_content_data .text {
        margin-bottom: 5px;
        text-align: center;
        font-size: 14px;
        color: #55c354;
    }

    .empty_content_data .text2 {
        margin-bottom: 5px;
        text-align: center;
        font-size: 12px;
    }

.show_all_btn {
    display: none;
    height: 26px;
    line-height: 26px;
    font-size: 14px;
    color: #55c354;
}

.diary_tag_activity, .diary_tag_work, .diary_tag_life, .diary_tag_other, .diary_personal, .diary_tag_notify, .diary_tag_recipe {
    font-size: 12px;
    height: 16px;
    line-height: 14px;
    padding: 1px 2px;
    margin: 0 1px;
}

.diary_tag_activity {
    border-radius: 3px;
    background-color: #ff7298;
    border: 1px solid #ff7298;
    color: #fff;
}

.diary_tag_work {
    background-color: #00ddd3;
    border: 1px solid #00ddd3;
    color: #fff;
    border-radius: 3px;
}

.diary_tag_life {
    background-color: #ff9e31;
    border: 1px solid #ff9e31;
    color: #fff;
    border-radius: 3px;
}

.diary_tag_other {
    background-color: #52b3ff;
    border: 1px solid #52b3ff;
    color: #fff;
    border-radius: 3px;
}

.diary_tag_notify {
    background-color: #ff635b;
    border: 1px solid #ff635b;
    color: #fff;
    border-radius: 3px;
}

.diary_tag_recipe {
    background-color: #f4cd00;
    border: 1px solid #f4cd00;
    color: #fff;
    border-radius: 3px;
}

.diary_personal {
    color: #88d39d;
    border: 1px solid #88d39d;
    border-radius: 3px;
}

.user_img_list3 {
    width: 100%;
    zoom: 1;
    overflow: hidden;
    box-sizing: border-box;
    padding-right: 15px;
}

    .user_img_list3 li {
        width: 33.33%;
        height: 70px;
        overflow: hidden;
        box-sizing: border-box;
        padding: 2px;
        float: left;
        margin: 0;
    }

        .user_img_list3 li img {
            width: 100%;
            height: 100%;
        }

        .user_img_list3 li .li_radio3 {
            width: 100%;
            height: 100%;
			border-radius: 20px;
            background-color: #ccc;
            background-position: center;
            background-size: 100%;
        }

            .user_img_list3 li .li_radio3 .icon {
                width: 100%;
                height: 100%;
                background-image: url(<?php echo OSSURL;?>public/mobile/img/radio_icon3.png);
                background-position: center;
                background-size: 40px;
                background-repeat: no-repeat;
            }

            .user_img_list3 li .li_radio3.video_stop .icon {
                width: 100%;
                height: 100%;
                background-image: url(<?php echo OSSURL;?>public/mobile/img/radio_icon3_2.gif);
                background-position: center;
                background-size: 40px;
                background-repeat: no-repeat;
            }

        .user_img_list3 li .li_video3 {
            width: 100%;
            height: 100%;
			border-radius: 50px;
            background-color: #F1EEEE;
            background-size:contain;
        }

            .user_img_list3 li .li_video3 .icon {
                width: 100%;
                height: 100%;
                background-image: url(<?php echo OSSURL;?>public/mobile/img/video_play_icon3.png);
                background-position: center;
                background-size: 40px;
                background-repeat: no-repeat;
            }

            .user_img_list3 li .li_video3 .icon2 {
                width: 100%;
                height: 100%;
                background-image: url(<?php echo OSSURL;?>public/mobile/img/video_pause_icon3.png);
                background-position: center;
                background-size: 40px;
                background-repeat: no-repeat;
            }

.other_info_box3 {
    height: 42px;
    line-height: 42px;
    position: relative;
}

    .other_info_box3 .time {
        font-size: 12px;
        color: #999;
    }

    .other_info_box3 .delete_btn {
        font-size: 12px;
        color: #55c354;
        padding: 0 10px;
    }

    .other_info_box3 .other_control_icon_praise {
        position: absolute;
        right: 35px;
        bottom: 0;
        z-index: 1;
        width: 40px;
        height: 42px;
        background: url(<?php echo OSSURL;?>public/mobile/img/icon_nopraise.png) no-repeat center;
        background-size: 16px;
    }

    .other_info_box3 .other_control_icon {
        position: absolute;
        right: -10px;
        bottom: 0;
        z-index: 1;
        width: 40px;
        height: 42px;
        background: url(<?php echo OSSURL;?>public/mobile/img/noComment.png) no-repeat center;
        background-size: 16px;
    }

    .other_info_box3 .other_control_box {
        display: none;
        color: #fff;
        border-radius: 5px;
        position: absolute;
        z-index: 2;
        right: 25px;
        top: 0;
        width: 130px;
        height: 26px;
        background-color: #4c5154;
    }

        .other_info_box3 .other_control_box .control_item {
            width: 65px;
            line-height: 26px;
            float: left;
            box-sizing: border-box;
            text-align: center;
            font-size: 14px;
        }

            .other_info_box3 .other_control_box .control_item .like_btn {
                padding-left: 20px;
                background: url(<?php echo OSSURL;?>public/mobile/img/like_icon3.png) no-repeat;
                background-position: left center;
                background-size: 14px;
            }

            .other_info_box3 .other_control_box .control_item .comment_btn {
                padding-left: 20px;
                background: url(<?php echo OSSURL;?>public/mobile/img/comment_icon3.png) no-repeat;
                background-position: left center;
                background-size: 14px;
            }

            .other_info_box3 .other_control_box .control_item:first-child {
                border-right: 1px solid #363d40;
            }

    .other_info_box3 .other_control_box {
    }


 

.shadow_box {
    box-shadow: 0 0 0px #ccc;
}
/*new_mypage*/
 
 
 
 
  
/*search_page_box3*/
 
/*comment_box3*/
.comment_box3 {
    background-color: #ffffff;
    position: relative;
    margin-top: 8px;
    display: none;
}

.comment_box3_1 {
    margin: 10px;
    padding: 0 10px;
    background-color: #f4f4f6;
    position: relative;
}

.comment_box3:before {
    /*content:''; position: absolute; top: -8px; left: 10px; width: 10px; height: 10px;
                       /*background: url(<?php echo OSSURL;?>public/mobile/img/comment_div_top_arrow_icon3.png) no-repeat center;*/
    /*background-size: 10px;*/
}

.comment_box3_1:before {
    content: '';
    position: absolute;
    top: -10px;
    left: 10px;
    width: 10px;
    height: 10px;
    background: url(<?php echo OSSURL;?>public/mobile/img/comment_div_top_arrow_icon3.png) no-repeat center;
    background-size: 10px;
}

.like_box_3 :first-child {
    background: url("../../Content/images/icon_okpraise.png") no-repeat no-repeat;
    background-size: 12px;
    padding-left: 18px;
    background-position: left center;
}
.like_box_3 {
    height: auto;
    width: 100%;
    line-height: 25px;
    font-size: 14px;
    color: #06c1ae;
    box-sizing: border-box;
    margin-top: 10px;
}
    .like_box_3 > span:last-child:after {
        content: '等';
        font-size: 14px;
        color: #55c354;
        line-height: 20px;
    }

    .like_box_3 > span {
        line-height: 20px;
        color: #55c354;
         margin: 0 0 0 -2px;
    }
    .like_box_3.noborder {
        border-bottom: none;
    }

.comment_list3 li {
    background-color: transparent;
    margin: 0;
    padding: 5px 0 5px 35px;
    box-sizing: border-box;
    position: relative;
}

.comment_list3 li {
    margin-bottom: 0;
    background-color: transparent;
    padding: 3px 0 3px 35px;
    box-sizing: border-box;
    position: relative;
}

    .comment_list3 li .user_icon {
        position: absolute;
        width: 30px;
        height: 30px;
        left: 0;
        top: 0;
    }

        .comment_list3 li .user_icon img {
            width: 30px;
            height: 30px;
            border-radius: 30px;
        }

    .comment_list3 li .comment_content {
        width: 100%;
        line-height: 18px;
        font-size: 14px;
    }

        .comment_list3 li .comment_content .user_name {
            color: #55c354;
            line-height: 25px;
        }

        .comment_list3 li .comment_content .time {
            color: #999999;
            float: right;
            max-width: 100px;
        }

        .comment_list3 li .comment_content .no_show_btn {
            color: #999999;
            float: right;
            width: 40px;
            text-align: right;
        }

        .comment_list3 li .comment_content .text {
            color: #666666;
            width: 100%;
            word-break: break-all;
        }

        .comment_list3 li .comment_content .comment_btn3 {
            color: #55c354;
            float: right;
            text-align: right;
            width: 40px;
        }

    .comment_list3 li:last-child {
        border-bottom: none;
    }

.comment_box3 .comment_list3 li {
    padding: 0px 0px 0px 3px;
}

.bottom_comment_box3 { /*position: fixed;*/
    width: 100%;
    box-sizing: border-box;
    bottom: 0;
    left: 0;
    z-index: 13;
    font-size: 14px;
    height: 42px;
    border-top: 1px dashed #ccc;
    background-color: #fff;
    line-height: 40px;
    padding: 0 75px 0 45px;
}

    .bottom_comment_box3 .face_icon3 {
        position: absolute;
        left: 0;
        top: 0;
        width: 45px;
        height: 40px;
        background: url(<?php echo OSSURL;?>public/mobile/img/comment_face_icon3.png) no-repeat center;
        background-size: 26px;
    }

    .bottom_comment_box3 .comment_input_box3 {
        width: 100%;
        padding: 5px 0 4px;
        box-sizing: border-box;
        border-radius: 3px;
        height: 30px;
        line-height: 20px;
        border: none;
        border-bottom: 1px solid #ccc;
        background-color: transparent;
    }

    .bottom_comment_box3 .send_comment_btn3 {
        height: 30px;
        line-height: 30px;
        border-radius: 3px;
        width: 55px;
        position: absolute;
        right: 10px;
        top: 5px;
        text-align: center;
        background-color: #55c354;
        color: #fff;
    }

/*diary_detail*/
.new_diary_detail3 {
    margin-bottom: 10px;
    background-color: #fff;
    position: relative;
    width: 100%;
    padding: 5px 10px 5px 54px;
    box-sizing: border-box;
}

    .new_diary_detail3 .user_img {
        width: 36px;
        height: 36px;
        border-radius: 18px;
        position: absolute;
        left: 10px;
        top: 10px;
    }

        .new_diary_detail3 .user_img img {
            width: 36px;
            height: 36px;
            border-radius: 18px;
        }

    .new_diary_detail3 .user_content {
        width: 100%;
    }

    .new_diary_detail3 .user_info {
        width: 100%;
        color: #55c354;
        line-height: 26px;
        font-size: 14px;
    }

    .new_diary_detail3 .user_text {
        width: 100%;
        color: #000;
        line-height: 20px;
        font-size: 14px;
    }


/*删除评论*/
.del_comment_bg {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    height: 100%;
    width: 100%;
    background: rgba(0, 0, 0, 0.6);
    z-index: 9998;
}

.del_comment_btn {
    position: fixed;
    top: 43%;
    background: #fff;
    height: 40px;
    width: 80%;
    border-radius: 2px;
    line-height: 40px;
    z-index: 9999;
    box-sizing: border-box;
    padding: 0 10px;
    margin: 0 auto;
    color: #333;
    left: 0;
    right: 0;
}

 


.common_til2 a {
    background: url(../../Content/images/partent_ico77.png) no-repeat left;
    background-size: 7px 10px;
    padding-left: 18px;
    display: block;
    width: auto;
    height: 100%;
    line-height: 44px;
    /*margin-left: 10px;*/
}

    .common_til2 a.downIcoClass {
        background: url(../../Content/images/fy_partent_ico.png) no-repeat left;
        background-size: 10px 7px;
        padding-left: 18px;
        display: block;
    }


.praiseContent:first-child {
    background: url(<?php echo OSSURL;?>public/mobile/img/icon_okpraise.png) no-repeat no-repeat;
    background-size: 12px;
    padding-left: 18px;
    background-position: left center;
}


/*班级相册*/


.common_list_imgtext6GroupBox {
    margin-top: 10px;
    background-color: white;
}

/*班级相册*/
.class_li {
    border-top: 1px solid #eee;
    border-bottom: 1px solid #eee;
}

.li_line {
    border-bottom: 1px solid #f0f0f2;
    height: auto;
    margin-left: 7.5px;
}

.top_head_my {
    width: 100%;
    height: 88px;
    box-sizing: border-box;
    overflow: hidden;
    background-color: white;
}

    .top_head_my::after {
        content: "";
        display: block;
        height: 0;
        clear: both;
        visibility: hidden;
    }

    .top_head_my .my_img {
        margin: 0 auto;
        width: 65px;
        height: 65px;
        margin-top: 11.5px;
        margin-left: 10px;
        display: inline-block;
        float: left;
    }

        .top_head_my .my_img img {
            margin: 0 auto;
            width: 100%;
            height: 100%;
            border-radius: 80px;
        }

.my_unseInfo {
    display: inline-block;
    margin: 0 auto;
    margin-left: 10px;
    display: inline-block;
    height: 88px;
    float: left;
    box-sizing: border-box;
}

.my_unseInfoName {
    width: auto;
    height: 20px;
    margin-top: 20px;
    font-size: 15px;
    color: black;
    line-height: 20px;
    font-family: "微软雅黑";
    max-width: 170px;
    overflow: hidden;
}

.my_unseInfoDescribe {
    width: auto;
    margin-top: 8px;
    font-size: 13px;
    color: #666666;
}

.my_unseInfo_right {
    float: right;
    display: inline-block;
    background: url(<?php echo OSSURL;?>public/mobile/img/my_right_Ico.png) no-repeat center;
    width: 30px;
    height: 100%;
    background-size: 9px 15px;
}

.top_head_my a {
    display: block;
    width: 100%;
    height: 100%;
    overflow: hidden;
}
.popNoscroll {
    width: 100%;
    height: 100%;
    overflow: hidden;
}
.img-responsive {
    width: 100% !important;
    height: auto !important;
    border: none !important;
}

/*通知改版*/
　　
　
.btnDeleteBox {
    width: 15px;
    position: absolute;
    top: 50%;
    right: 10px;
    transform: translateY(-50%);
    -webkit-transform: translateY(-50%);
    -moz-transform: translateY(-50%);
    -ms-transform: translateY(-50%);
    -o-transform: translateY(-50%);
}

.img-responsive {
    width: 100% !important;
    height: auto !important;
    border: none !important;
}
　　


/*遮罩层*/
.popUpBox {
    position: fixed;
    left: 0px;
    top: 0px;
    width: 100%;
    height: 100%;
    animation-name: popFadeIn;
    -webkit-animation-name: popFadeIn;
    -ms-animation-name: popFadeIn;
    -moz-animation-name: popFadeIn;
    -o-animation-name: popFadeIn;
    -webkit-animation-duration: 600ms;
    animation-duration: 600ms;
    -webkit-animation-fill-mode: both;
    z-index: 100;
}

.popUpBoxOut {
    animation-name: popFadeOut;
    -webkit-animation-name: popFadeOut;
    -ms-animation-name: popFadeOut;
    -moz-animation-name: popFadeOut;
    -o-animation-name: popFadeOut;
    -webkit-animation-duration: 600ms;
    animation-duration: 600ms;
    -webkit-animation-fill-mode: both;
}

@keyframes popFadeIn {
    0% {
        opacity: 0;
    }

    100% {
        opacity: 1;
    }
}

@keyframes popFadeOut {
    0% {
        opacity: 1;
    }

    100% {
        opacity: 0;
    }
}

.trackMatte {
    position: absolute;
    width: 100%;
    height: 100vh;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: black;
    opacity: .5;
}

.popContentBox {
    position: absolute;
    width: 80%;
    margin-left: 10%;
    max-height: 80%;
    top: 50%;
    transform: translateY(-50%);
    -webkit-transform: translateY(-50%);
    -moz-transform: translateY(-50%);
    -ms-transform: translateY(-50%);
    -o-transform: translateY(-50%);
    z-index: 101;
    background-color: white;
    border-radius: 10px;
    overflow-y: scroll;
    overflow-x: hidden;
}

.poptitle {
    width: 100%;
    font-size: 16px;
    color: #333333;
    text-align: center;
    padding: 5px 0;
}
.popNotifyDescribe {
    background: #f0f0f2;
    border-radius: 5px;
}

.popNotifyDescribe span {
   
    border-radius: 10px;
    padding: 12px;
    color: #666666;
    font-size: 14px;
    display: inline-block;
}

.sectionContBox {
    margin: 10px;
}
.btnBox {
    display: -webkit-box; /* 老版本语法: Safari,  iOS, Android browser, older WebKit browsers.  */
    display: -moz-box; /* 老版本语法: Firefox (buggy) */
    display: -ms-flexbox; /* 混合版本语法: IE 10 */
    display: -webkit-flex; /* 新版本语法： Chrome 21+ */
    display: flex; /* 新版本语法： Opera 12.1, Firefox 22+ */
    margin: 20px 0;
}

.btnPass, .btnCancel {
    width: 100px;
    height: 31px;
    font-size: 14px;
    color: white;
    text-align: center;
    line-height: 31px;
    border-radius: 20px;
}
.btnPass {
    background: #06c1ae;
    margin-left: 12px;

}
.btnCancel {
    background: #ff9f22;
    margin-left: auto;
    margin-right: 10px;
}

.popNoscroll {
    width: 100%;
    height: 100%;
    overflow: hidden;
}

.no_recoredBox {
    width: 100%;
    margin-top: 30px;
}
.no_recored_icon {
    width: 45%;
    margin: 0 auto;
}


 .noRecoredDescr {
     width: 100%;
     margin-top: 30px;
     text-align: center;
   
    color: #666666;
    font-size: 14px;
}
.imgItemDetails {
    margin-bottom: 5px;
}
</style>
<style>
.linkDataUrl {text-decoration: underline!important;} 
.recipe_tag_notify {background-color: #f5ca00;color: white;font-size: 12px;border-radius: 3px;height: 16px;line-height: 14px;padding: 1px 2px;margin: 0 1px;}
.other_info_box3 a {color: #55c354 !important;}
body {background-color: #fff;}
.faceBox.faceBox_fixed {bottom: 0;border-bottom: 1px solid #ddd;position: relative;}
.other_control_icon:hover {background: url(<?php echo OSSURL;?>public/mobile/img/okcomment.png) no-repeat center;background-size: 16px;}
/*点赞框*/
.praiseBox {display: block;height: auto;width: 100%;line-height: 25px;font-size: 14px;color: #55c354;box-sizing: border-box;margin-top: 10px;}
.praiseBox::after {content: "";display: block;height: 0;clear: both;visibility: hidden;}
.praiseContent {line-height: 20px;color: #55c354;margin: 0 0 0 -2px;}
.praiseContent:after {content: ',';font-size: 14px;color: #55c354;line-height: 20px;}
.praiseContent:last-child:after {content: '等';font-size: 14px;color: #55c354;line-height: 20px;}
/*背景图片*/
.top_head_box3 {height: 200px;background: none;padding: 0;background-color: rgb(6, 193, 174);}
/*小图片*/
.top_head_box3 .index_img {width: 75px;height: 75px;left: 50%;top: 52%;margin-left: -37.5px;margin-top: -37.5px;box-sizing: border-box;}
.top_head_box3 .index_img img {width: 100%;height: 100%;border-radius: 50%;}
/*姓名*/
.top_head_box3 .index_username {left: 50%;margin-left: -24px;right: 0%;width: 100px;margin-left: -50px;text-align: center;z-index: 999;}
.new_diary_list3 li .notify_title3 {color: #0c0c0c;}
body {background-color: #f0f0f2;}
.top_head_box3 .top_Img {-webkit-filter: blur(50px);-moz-filter: blur(50px);-ms-filter: blur(50px);-o-filter: blur(50px);filter: blur(50px);filter: progid:DXImageTransform.Microsoft.Blur(PixelRadius=50, MakeShadow=false);
position: absolute;top: 50%;left: 50%;height: 100%;width: 100%;z-index: 999;-webkit-transform: translate(-50%, -50%);-ms-transform: translate(-50%, -50%);transform: translate(-50%, -50%);}
.new_diary_list3 li .user_info,
.comment_list3 li .comment_content .user_name,
.like_box_3, .f_green {color: #55c354;}
/*高斯模糊图*/
.top_head_box3 .top_Img {z-index: 1;}
.top_head_box3 .user_icon, .top_head_box3 .search_icon, .top_head_box3 .index_img img,
.top_head_box3 .index_username {z-index: 999;}
.slide_left_menu_bg {z-index: 1000;}
.bottomLine {width: 100%;border-top: 1px solid #f6f6f6;display: block;}
.loading_wrap {position: fixed;top: 0;bottom: 0;width: 100%;left: 0;background-color: #fff;z-index: 9999;}
.ajax_loading {display: box;display: -webkit-box;-webkit-box-orient: vertical;-webkit-box-pack: center;-webkit-box-align: center;width: 100%;height: 100%;}
.inside_user_text a {display: inline-block !important;text-decoration: underline !important;color: #0094ff !important;}
.myCrowns {height: auto;border-radius: 10px;background-color: #fff;margin: 0 10px;padding-bottom: 10px;}
.myCrowns p {margin: 0;padding: 8px 10px;font-size: 16px;}
.myCrowns ._myCrowns {display: -webkit-box;display: -ms-flexbox;display: -webkit-flex;display: flex;-webkit-box-pack: center;-ms-flex-pack: center;-webkit-justify-content: center;justify-content: center;-webkit-box-align: center;-ms-flex-align: center;-webkit-align-items: center;align-items: center;}
.myCrowns ._myCrowns .span2 {width: 100%;display: inline-block;color: #fff;text-align: center;position: absolute;bottom: 3px;margin-left: 0px;font-size: 10px;}
.myCrowns ._myCrowns .crowns img {display: inline-block;width: 90%;margin: 5%;height: 26px;margin-top: -14px;}
.myCrowns ._myCrowns .crowns {width: 25%;-webkit-box-flex: 1.0;height: 100%;margin-bottom: 12px;position: relative;}
.myCrowns ._myCrowns .crowns .mydiv {width: 50%;height: 50%;margin: 0 auto;border-radius: 40%;padding-top: 16px;z-index: 10;}
.myCrowns ._myCrowns .crowns .mydiv img {width:38px;height: 38px;border-radius: 50%;border: 1px solid #feb607;z-index: 10;}
.myCrowns ._myCrowns .crowns .span1 {display: inline-block;width: 18px;height: 18px;background-color: #feb607;border-radius: 15px;color: #fff;text-align: center;line-height: 20px;position: absolute;top: 0;right: 18%;font-size: 14px;}
.myname {background: url(<?php echo OSSURL;?>public/mobile/img/orange.png) no-repeat center;background-size: 90% 20px;width: 90%;height: 26px;margin: 0 auto;margin-top: -14px;    margin-left: 4px;position: absolute;}
.myCrowns ._myCrowns .crowns2 {width: 25%;-webkit-box-flex: 1.0;height: 100%;margin-bottom: 12px;position: relative;}
.myCrowns ._myCrowns .crowns2 .mydiv {width: 50%;height: 50%;margin: 0 auto;border-radius: 40%;z-index: 10;}
.myCrowns ._myCrowns .crowns2 .mydiv img {width:38px;height: 38px;border-radius: 50%;border: 1px solid #46bde4;z-index: 10;}
.myCrowns ._myCrowns .crowns2 .span1 {display: inline-block;width: 18px;height: 18px;background-color: #46bde4;border-radius: 15px;color: #fff;text-align: center;line-height: 20px;position: absolute;top: 0;right: 18%;font-size: 14px;}
.myname2 {background: url(<?php echo OSSURL;?>public/mobile/img/blue.png) no-repeat center;background-size: 90% 20px;width: 90%;height: 26px;margin-top: -11px;margin-left: 2px;position: absolute;}
.myCrowns ._myCrowns .crowns3 {width: 25%;-webkit-box-flex: 1.0;height: 100%;margin-bottom: 12px;position: relative;}
.myCrowns ._myCrowns .crowns3 .mydiv {width: 50%;height: 50%;margin: 0 auto;border-radius: 40%;z-index: 10;}
.myCrowns ._myCrowns .crowns3 .mydiv img {width:38px;height: 38px;border-radius: 50%;border: 1px solid #0abc89;z-index: 10;}
.myCrowns ._myCrowns .crowns3 .span1 {display: inline-block;width: 18px;height: 18px;background-color: #0abc89;border-radius: 15px;color: #fff;text-align: center;line-height: 20px;position: absolute;top: 0;right: 18%;font-size: 14px;}
.myname3 {background: url(<?php echo OSSURL;?>public/mobile/img/green.png) no-repeat center;background-size: 90% 20px;width: 90%;height: 26px;margin-top: -11px;margin-left: 2px;position: absolute;}
.myCrowns ._myCrowns .crowns4 {width: 25%;-webkit-box-flex: 1.0;height: 100%;margin-bottom: 12px;position: relative;}
.myCrowns ._myCrowns .crowns4 .mydiv {width: 50%;height: 50%;margin: 0 auto;border-radius: 40%;z-index: 10;}
.myCrowns ._myCrowns .crowns4 .mydiv img {width:38px;height: 38px;border-radius: 50%;border: 1px solid #7680de;z-index: 10;}
.myCrowns ._myCrowns .crowns4 .span1 {display: inline-block;width: 18px;height: 18px;background-color: #7680de;border-radius: 15px;color: #fff;text-align: center;line-height: 20px;position: absolute;top: 0;right: 18%;font-size: 14px;}
.myname4 {background: url(<?php echo OSSURL;?>public/mobile/img/purple.png) no-repeat center;background-size: 90% 20px;width: 90%;height: 26px;margin-top: -11px;margin-left: 2px;position: absolute;}
.index_username1 {width: 92%;height: 26px;margin-left: 4%;position: absolute;bottom: 15px;color: #fff;text-align: center;}
.index_username1 .jifen {display: inline;width: 27%;line-height: 26px;text-align: left;font-size: 13px;float: left;}
.index_username1 .baobaoName {display: inline-block;width: 32%;line-height: 26px;text-align: center;font-size: 16px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;}
.index_username1 .honor {display: inline-block;width: 34%;text-align: right;font-size: 13px;line-height: 26px;float: right;}
.index_username1 .jifenImg {display: inline-block;background: url(<?php echo OSSURL;?>public/mobile/img/jifen.png) no-repeat center;background-size: 18px 20px;width: 7%;height: 20px;margin-top: 2px;float: left;}
.selectList {position: fixed;left: 0;right: 0;top: 0;bottom: 0;-webkit-box-sizing: border-box;box-sizing: border-box;background-color: rgba(0,0,0,.53);
text-align: center;z-index: 30;font-size: 20px;color: #fe6700;}
.selectList .single {position: absolute;left: 6%;right: 6%;top: 35%;padding: 0 20px;background-color: #fff;padding-bottom: 33px;padding-top: 10px;}
.selectList ul {width: 100%;height: auto;overflow: auto;}
.selectList ul li {height: 50px;line-height: 50px;border-bottom: 1px solid #e9e9e9;padding: 0 10px;}
.selectList ul li span.le {height: 50px;line-height: 50px;float: left;font-size: 16px;}
.selectList ul li span.ri {float: right;height: 50px;line-height: 50px;font-size: 16px;}
header {width: 100%;height: 45px;background-color: #06c1ae;position: relative;text-align: center;position: fixed;z-index:1000;}
.headerContent {margin: 0 auto;width: 250px;height: 100%;font-weight: bold;color: #fff;position: absolute;left: 50%;line-height: 45px;transform: translate(-50%);-webkit-transform: translate(-50%);
-moz-transform: translate(-50%);-ms-transform: translate(-50%);-o-transform: translate(-50%);}
.select_date {margin: 0 10px 0 10px;}
.hederRightBox {width: 21px;height: 100%;display: inline-block;position: absolute;right: 20px;}
.hederRightBox a {width: 100%;height: 21px;display: inline-block;position: absolute;top: 50%;transform: translateY(-50%);-webkit-transform: translateY(-50%);-moz-transform: translateY(-50%);-ms-transform: translateY(-50%);-o-transform: translateY(-50%);}
.hederLeftBox {width: 21px;height: 100%;display: inline-block;position: absolute;left: 5px;}
.hederLeftBox a {width: 100%;height: 21px;display: inline-block;position: absolute;top: 50%;transform: translateY(-50%);-webkit-transform: translateY(-50%);-moz-transform: translateY(-50%);-ms-transform: translateY(-50%);-o-transform: translateY(-50%);}
.add_pic_btn{ background:url(<?php echo OSSURL;?>public/mobile/img/upload_img_icon.png) no-repeat center; background-size: 26px; float: left; width: 30px; height: 45px; padding: 0 5px;}
.add_expression_btn{ background:url(<?php echo OSSURL;?>public/mobile/img/expression_icon.png) no-repeat center; background-size: 26px; float: left; width: 30px; height: 45px; padding: 0 5px;}
.add_video_btn{ background:url(<?php echo OSSURL;?>public/mobile/img/record_icon.png) no-repeat center; background-size: 26px; float: left; width: 30px; height: 45px; padding: 0 5px;}
.add_video_btn2{ background:url(<?php echo OSSURL;?>public/mobile/img/d_video_icon.png) no-repeat center; background-size: 26px; float: left; width: 30px; height: 45px; padding: 0 5px;}
.add_link_btn{ background:url(<?php echo OSSURL;?>public/mobile/img/add_link.png) no-repeat center; background-size: 26px; float: left; width: 30px; height: 45px; padding: 0 5px;}
.feedback_box .feedback_title_box .feedback_title{background:url(<?php echo OSSURL;?>public/mobile/img/select_down_icon.png) no-repeat right center; background-size:16px; -webkit-appearance: none; width:100%; padding-right: 20px; box-sizing: border-box; border:none; overflow:hidden; white-space:nowrap; text-overflow:ellipsis;}
.feedback_box .feedback_title_box .feedback_title.feedback_title_teacher{background:url(<?php echo OSSURL;?>public/mobile/img/select_down_icon2.png) no-repeat right center; background-size:16px; -webkit-appearance: none; width:100%; padding-right: 20px; box-sizing: border-box; border:none;overflow:hidden; white-space:nowrap; text-overflow:ellipsis;}
.del_btn{ height:20px; width: 20px; position: absolute; right: 10px; top: 10px; background: url(<?php echo OSSURL;?>public/mobile/img/delete_say_btn.png) no-repeat center; background-size: 18px; z-index: 2;}
.del_btn2{ height:20px; width: 20px; position: absolute; right: 10px; top: 10px; background: url(<?php echo OSSURL;?>public/mobile/img/delete_say_btn.png) no-repeat center; background-size: 18px; z-index: 2;}
.video_list > li > .arrow { width: 8px; height: 9px; position: absolute; background: url(<?php echo OSSURL;?>public/mobile/img/arrow_left.png) no-repeat; background-size: 8px; left: -8px; top: 13px; }
.video_list > li > .voice_play_tip{ height:20px; width: 30px; background-image: url(<?php echo OSSURL;?>public/mobile/img/voice_icon.png); background-size: 14px; background-repeat: no-repeat; background-position: center; position: absolute; left: 5px;}
.video_list > li.video_stop > .voice_play_tip{ background-image: url(<?php echo OSSURL;?>public/mobile/img/voice_start_icon.gif); }
.video_list > li > .delete_voice_btn{ width: 36px; height: 36px; background: url("<?php echo OSSURL;?>public/mobile/img/delete_say_btn.png") no-repeat center; background-size: 18px; position: absolute; right: 0px; display: block; top: 0px; z-index:1;}
.say_btn1{ width:50px; height: 100px; background-image: url(<?php echo OSSURL;?>public/mobile/img/startsay_btn.png?v=1); background-size: 40px; background-repeat: no-repeat; background-position: center; margin: 0px auto;}
.say_btn1.record_stop{background-image: url(<?php echo OSSURL;?>public/mobile/img/endsay_btn.gif);}
.progress > .loading{ width:30px; height:30px; display:inline-block; vertical-align:middle;background:url(<?php echo OSSURL;?>public/mobile/img/load.png) no-repeat; background-size:30px; -webkit-animation:loading1 2s linear infinite;}
.img_bigger_bg .w_del_img_btn .w_del_img_btn_text{ display:block; width:60px; padding-left:20px; background:url(<?php echo OSSURL;?>public/mobile/img/del_img_icon.png) no-repeat 5px center; background-size:16px; height:17px; line-height:17px; font-size:16px; color:#fff; }
#search_option_box .search_option_btn{ position:absolute; right:0; top:0; width:30px; height:36px; background:url(<?php echo OSSURL;?>public/mobile/img/w_search_icon.png) no-repeat center; background-size:16px;}
.option_li_box .option_title.check_all{background:url(<?php echo OSSURL;?>public/mobile/img/w_bingo_icon.png) no-repeat right center; background-size:20px;}
.option_li_box .option_list_ul li.check{background:url(<?php echo OSSURL;?>public/mobile/img/w_bingo_icon.png) no-repeat right center; background-size:20px;}
.option_li_box2 .option_title2.check_all{background:url(<?php echo OSSURL;?>public/mobile/img/w_bingo_icon.png) no-repeat right center; background-size:20px;}
.option_li_box2 > .option_list_ul1 > li > .sec_ul_box > .option_title2.check_all{background:url(<?php echo OSSURL;?>public/mobile/img/w_bingo_icon.png) no-repeat right center; background-size:20px;}
.option_list_ul2 li.check{background:url(<?php echo OSSURL;?>public/mobile/img/w_bingo_icon.png) no-repeat right center; background-size:20px;}
.option_list_ul3 li.check{background:url(<?php echo OSSURL;?>public/mobile/img/w_bingo_icon.png) no-repeat right center; background-size:20px;}
.favorites_option .favorites_media .favorites_play_icon{ width:80px; height:80px; position:absolute; left:0; top:0; background:url(<?php echo OSSURL;?>public/mobile/img/v_play_icon.png) no-repeat center; background-size:40px;}
.favorites_option .favorites_checkbox{ width:30px; height:30px; margin:5px 25px; background:url(<?php echo OSSURL;?>public/mobile/img/check_icon_off.png) no-repeat center; background-size:26px;}
.favorites_option .favorites_checkbox.checked{ width:30px; height:30px; margin:5px 25px;background:url(<?php echo OSSURL;?>public/mobile/img/check_icon_on.png) no-repeat center; background-size:26px;}
.favorites_option .favorites_radio{ width:30px; height:30px; margin:5px 25px; position:relative; background:url(<?php echo OSSURL;?>public/mobile/img/check_icon_off.png) no-repeat center; background-size:26px;}
.favorites_option .favorites_radio.checked{ width:30px; height:30px; margin:5px 25px; position:relative; background:url(<?php echo OSSURL;?>public/mobile/img/check_icon_on.png) no-repeat center; background-size:26px;}
.favorites_option_li > .arrow { width: 8px; height: 9px; position: absolute; background: url(<?php echo OSSURL;?>public/mobile/img/arrow_left.png) no-repeat; background-size: 8px; left: -8px; top: 13px; }
.favorites_option_li > .voice_play_tip{ height:20px; width: 30px; background-image: url(<?php echo OSSURL;?>public/mobile/img/voice_icon.png); background-size: 14px; background-repeat: no-repeat; background-position: center; position: absolute; left: 5px;}
.favorites_option_li.video_stop > .voice_play_tip{ background-image: url(<?php echo OSSURL;?>public/mobile/img/voice_start_icon.gif); }
.favorites_option_li > .favorites_radio{ width: 36px; height: 36px; background: url(<?php echo OSSURL;?>public/mobile/img/check_icon_off.png) no-repeat center; background-size: 26px; position: absolute; right: -50px; display: block; top: 0px;}
.favorites_option_li > .favorites_radio.checked{ background:url(<?php echo OSSURL;?>public/mobile/img/check_icon_on.png) no-repeat center; background-size:26px;}
.media_list > li > .favorites_play_icon{ width:100%; height:100%; position:absolute; left:0; top:0; background:url(<?php echo OSSURL;?>public/mobile/img/v_play_icon.png) no-repeat center; background-size:40px;}
.media_list > li > .delete_voice_btn{ width: 36px; height: 36px; background: url("<?php echo OSSURL;?>public/mobile/img/delete_say_btn.png") no-repeat center; background-size: 18px; position: absolute; right: 0px; display: block; top: 0px;}
#video_result .tem_video{ width:60px; height:60px; background:url(<?php echo OSSURL;?>public/mobile/img/v_play_icon.png) no-repeat center; background-size:60px; float:left; position:relative; font-size:14px; text-align:center; line-height:60px;}
.blackBg {position: fixed;top: 0;left: 0;right: 0;bottom: 0;background: black;z-index: 89;filter: alpha(opacity:30);opacity: 0.3;display: none;}
.selectList {position: fixed;width: 80%;height: auto;max-height: 70%;overflow: hidden;background: white;border: 1px solid #e9e9e9;z-index: 99999;display: none;left: 10%;top: 50%;border-radius:5px;}
.selectList ul {width: 100%;height: auto;overflow: auto;}
.selectList ul li {height: 50px;line-height: 50px;border-bottom: 1px solid #e9e9e9;padding: 0 10px;}
.selectList ul li span.le {height: 50px;line-height: 50px;font-size: 16px;}
.selectList .btn {position: absolute;width: 100%;height: 50px;bottom: 0;left: 0;}
.selectList .double .btn .box {width: 50%;height: 100%;background: #e9e9e9;float: left;}
.selectList .double .btn .box span.ok {margin-right: 1px;color: #333;}
.selectList .double .btn .box span {display: block;height: 50px;line-height: 50px;text-align: center;background: white;cursor: pointer;color: #333;}

.has_show_over {
    line-height: 30px;
    height: 30px;
    text-align: center;
    color: #666666;
    font-size: 14px;
    overflow: hidden;
}


/*scroll_load 新滚动到底部刷新*/
.jzz_div {
    float: left;
    height: 30px;
    width: 100%;
    position: relative;
    margin-top: 10px;
}

    .jzz_div .jzz {
        height: 20px;
        font-size: 12px;
        padding: 2px 10px;
        vertical-align: middle;
        background: #9e9e9e;
        width: 63px;
        border-radius: 50px;
        margin: 0 auto;
    }

        .jzz_div .jzz span {
            float: left;
            text-align: center;
            vertical-align: middle;
            padding-top: 3px;
            padding-left: 2px;
            color: #FFF;
        }

        .jzz_div .jzz .pir {
            height: 14px;
            width: 14px;
            float: left;
            vertical-align: middle;
            padding-top: 3px;
            vertical-align: middle;
        }

            .jzz_div .jzz .pir img {
                width: 100%;
                height: 100%;
                display: block;
            }

.jzz_text {
    font-size: 12px;
    color: #FFF;
    line-height: 20px;
    text-align: center;
    vertical-align: middle;
}

.jzz_div .jzz.jzz_over {
    width: 120px;
    text-align: center;
    background: transparent;
}

    .jzz_div .jzz.jzz_over .jzz_text {
        color: #333;
    }

    .jzz_div .jzz.jzz_over .pir {
        display: none;
    }

</style>