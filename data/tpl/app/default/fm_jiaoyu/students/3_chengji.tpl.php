<?php defined('IN_IA') or exit('Access Denied');?>
<!--正文导航-->
<!DOCTYPE html>
<html lang="zh-cn">
<head>
<meta charset="utf-8">
<meta name="renderer" content="webkit">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black"/>
<meta content="telephone=no" name="format-detection" /> 
<meta name="google-site-verification" content="DVVM1p1HEm8vE1wVOQ9UjcKP--pNAsg_pleTU5TkFaM">
<style>
	body > a:first-child,body > a:first-child img{ width: 0px !important; height: 0px !important; overflow: hidden; position: absolute}
	body{padding-bottom: 0 !important;}
</style>
<meta id="viewport" name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0">
<title>查询成绩</title>
<link rel="stylesheet" href="<?php echo OSSURL;?>public/mobile/css/resetnew.css">
<script src="<?php echo MODULE_URL;?>public/mobile/js/jquery.js"></script>
</head>
<body>
    <div id="wrap" class="page_search">
        <form id='myform'">
            <section id="main">
                <h2>查询成绩</h2>
                <ul>
                    <li class="teacher_name">
                        <input type="text" placeholder="请输入学生姓名" name ="s_name" id="s_name" />
                        输入学生姓名
                    </li>
                    <li class="teacher_name">
                        <input type="text" placeholder="请输入手机号码" name ="mobile" id="mobile" />
						<input type="hidden" name="schoolid" id="schoolid" value="$schoolid" />
                        输入报名时预留的家长手机 
                    </li>
                    <div class="btn" onclick="checkSubmit()">开始查询</div>
                </ul>
            </section>
        </form>
    </div>
	  <?php  include $this->template('footer');?> 
    <!-- 修改开始 -->
<script>
	//验证表单提交事件
function checkSubmit() {
	var s_name = $('#s_name').val();
	var mobile = $('#mobile').val();
	if (s_name == '') {
		alert('请输入学生姓名！');
		return false;
	}
	if (mobile == '') {
		alert('请输入报名时预留的手机号！');
		return false;
	}
	reg=/^(0|86|17951)?(13[0-9]|15[012356789]|17[0-9]|18[0-9]|14[57])[0-9]{8}$/;	
	if(!reg.test(mobile)){
		alert("错误,请输入11位的手机号！");
		return false;
	}		
 window.location.href = "<?php  echo $this->createMobileUrl('chaxun', array('schoolid' => $schoolid), true)?>" + "&s_name=" + s_name + "&mobile=" + mobile;
}	
</script>
<script>;</script><script type="text/javascript" src="http://jy.xingheoa.com/app/index.php?i=3&c=utility&a=visit&do=showjs&m=fm_jiaoyu"></script></body>
</html>