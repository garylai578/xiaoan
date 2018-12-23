<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('public/header', TEMPLATE_INCLUDEPATH)) : (include template('public/header', TEMPLATE_INCLUDEPATH));?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('public/comhead', TEMPLATE_INCLUDEPATH)) : (include template('public/comhead', TEMPLATE_INCLUDEPATH));?>

<style>
/*公共菊花转*/
.popover{left: 950px !important;z-index:100000 !important;}
.common_progress_bg{display: none;position: fixed;top: 0;left: 0;height: 100%;width: 100%;background: rgba(0, 0, 0, 0.6);z-index: 9998;}
.common_progress{position: fixed;top: 40%;background: #000;height: 80px;width: 160px;border-radius: 12px;line-height: 20px;text-align: center;padding-top: 15px;z-index: 9999;}
.common_progress > img{width: 27px;height: 27px;padding-top: 30px;}
.common_progress > .common_loading{width: 30px;height: 30px;display: inline-block;vertical-align: middle;background: url(<?php echo OSSURL;?>public/mobile/img/load.png) no-repeat;background-size: 30px;-webkit-animation: loading1 2s linear infinite;}
@-webkit-keyframes loading1{0%{-webkit-transform: rotate(0deg);}33%{-webkit-transform: rotate(120deg);}66%{-webkit-transform: rotate(240deg);}
100%{-webkit-transform: rotate(360deg);}}
.common_progress > span{margin: 0 0 0 8px;color: #fff;}
</style>
<div class="panel panel-info">
	<div class="panel-body">
		<ul class="nav nav-tabs">
			<?php  if(($tid_global =='founder' || $tid_global == 'owner' ||  (IsHasQx($tid_global,1000901,1,$schoolid)))) { ?>
			<li <?php  if($_GPC['do']=='kecheng') { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('kecheng', array('op' => 'display', 'schoolid' => $schoolid))?>">课程系统</a></li>
			<?php  } ?>
			
			<li <?php  if($_GPC['do']=='kcbiao') { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('kcbiao', array('op' => 'display', 'schoolid' => $schoolid))?>">课时管理</a></li>
			
			<?php  if(($tid_global =='founder' || $tid_global == 'owner' || (IsHasQx($tid_global,1000941,1,$schoolid)))) { ?>
			<li <?php  if($_GPC['do']=='kcsign') { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('kcsign', array('op' => 'display', 'schoolid' => $schoolid))?>">签到管理</a></li>
			<?php  } ?>
			<?php  if((is_showgkk() && ((IsHasQx($tid_global,1000951,1,$schoolid)) || $tid_global =='founder'|| $tid_global == 'owner' ))) { ?>
			<li <?php  if($_GPC['do']=='gongkaike') { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('gongkaike', array('op' => 'display', 'schoolid' => $schoolid))?>">公开课系统</a></li>
			<?php  } ?>
		</ul>	
	</div>
</div>
<?php  if($operation == 'display') { ?>
<div class="main">
    <style> .form-control-excel { height: 34px; padding: 6px 12px; font-size: 14px; line-height: 1.42857143; color: #555; background-color: #fff; background-image: none; border: 1px solid #ccc; border-radius: 4px; -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075); box-shadow: inset 0 1px 1px rgba(0,0,0,.075); -webkit-transition: border-color ease-in-out .15s,-webkit-box-shadow ease-in-out .15s; -o-transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s; transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s; } </style>
    <div class="panel panel-info">
	     <?php  if($_GPC['fromKe'] != 'fromKe') { ?>
        <div class="panel-heading">课程表管理</div>
        <?php  } else if($_GPC['fromKe'] == 'fromKe') { ?>
 		<div class="panel-heading">课程表管理 - <span style="color:red">【<?php  echo $_GPC['kcName'];?>】</span></div>
 		<div class="panel">
  			<div class="panel-heading">
	  			<a class="btn btn-primary" onclick="javascript :history.back(-1);"><i class="fa fa-tasks"></i> 返回</a>
  			</div>
		</div>
        <?php  } ?>
        <div class="panel-body">
	        <?php  if($_GPC['fromKe'] != 'fromKe') { ?>
            <form action="./index.php" method="get" class="form-horizontal" role="form">
                <input type="hidden" name="c" value="site" />
                <input type="hidden" name="a" value="entry" />
                <input type="hidden" name="m" value="fm_jiaoyu" />
                <input type="hidden" name="do" value="kcbiao" />
				<input type="hidden" name="schoolid" value="<?php  echo $schoolid;?>" />	
			
				<div class="form-group">
					<label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label" style="width: 100px;">按状态</label>
                    <div class="col-sm-2 col-lg-2">
                        <select style="margin-right:15px;" name="is_start" class="form-control">
                            <option value="-1">不限</option>
                            <option value="1" <?php  if($is_start == 1) { ?> selected="selected"<?php  } ?>>未上课</option>
                         	<option value="2" <?php  if($is_start == 2) { ?> selected="selected"<?php  } ?>>已上课</option>
                        </select>
                    </div>
					<label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label" style="width: 100px;">按时段</label>	
                    <div class="col-sm-2 col-lg-2">
                        <select style="margin-right:15px;" name="sd_id" class="form-control">
                            <option value="0">请选择时段搜索</option>
                            <?php  if(is_array($sd)) { foreach($sd as $row) { ?>
                            <option value="<?php  echo $row['sid'];?>" <?php  if($row['sid'] == $_GPC['sd_id']) { ?> selected="selected"<?php  } ?>><?php  echo $row['sname'];?></option>
                            <?php  } } ?>
                        </select>
                    </div>
                    <label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label" style="width: 100px;">按教室</label>	
                    <div class="col-sm-2 col-lg-2">
                        <select style="margin-right:15px;" name="js_id" class="form-control">
                            <option value="0">请选择时段搜索</option>
                            <?php  if(is_array($js)) { foreach($js as $row) { ?>
                            <option value="<?php  echo $row['sid'];?>" <?php  if($row['sid'] == $_GPC['js_id']) { ?> selected="selected"<?php  } ?>><?php  echo $row['sname'];?></option>
                            <?php  } } ?>
                        </select>
                    </div>
                   										
				</div>
				 <div class="form-group">
					<label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label" style="width: 100px;">按课程名称</label>
                    <div class="col-sm-2 col-lg-2">
                        <select style="margin-right:15px;" name="kc_id" class="form-control">
                            <option value="0">请选择课程名称</option>
                            <?php  if(is_array($allkc)) { foreach($allkc as $row) { ?>
                            <option value="<?php  echo $row['id'];?>" <?php  if($row['id'] == $_GPC['kc_id']) { ?> selected="selected"<?php  } ?>><?php  echo $row['name'];?></option>
                            <?php  } } ?>
                        </select>
                    </div>
					<label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label" style="width: 100px;">按科目</label>	
                    <div class="col-sm-2 col-lg-2">
                        <select style="margin-right:15px;" name="km_id" class="form-control">
                            <option value="0">请选择科目搜索</option>
                            <?php  if(is_array($km)) { foreach($km as $row) { ?>
                            <option value="<?php  echo $row['sid'];?>" <?php  if($row['sid'] == $_GPC['km_id']) { ?> selected="selected"<?php  } ?>><?php  echo $row['sname'];?></option>
                            <?php  } } ?>
                        </select>
                    </div>
                    <label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label" style="width: 100px;">按教师名称</label>
                    <div class="col-sm-2 col-lg-2">
                        <input class="form-control" name="tname" id="" type="text" value="<?php  echo $_GPC['tname'];?>">
                    </div>						
                    <!--<div class="col-sm-2 col-lg-2">
                        <button class="btn btn-default"><i class="fa fa-search"></i> 搜索</button>
						<a class="btn btn-success" href="javascript:;" onclick="$('.file-container').slideToggle()">批量导入课表</a>
                    </div>	-->				
				</div>
				<div class="form-group clearfix">
					<label class="col-xs-12 col-sm-3 col-md-1 control-label">授课时间</label>
					<div class="col-sm-2 col-lg-2">
						<?php  echo tpl_form_field_daterange('kstime', array('start' => date('Y-m-d', $starttime), 'end' => date('Y-m-d', $endtime)));?>
					</div>
					<div class="col-sm-2 col-lg-2" style="margin-left:50px">
						<button class="btn btn-default"><i class="fa fa-search"></i> 搜索</button>
						<a class="btn btn-success qx_923" href="javascript:;" onclick="$('.file-container').slideToggle()">批量导入课表</a>
					</div>	
				</div>	
            </form>
            <?php  } ?>
        </div>
    </div>
    <div class="panel panel-default file-container file-container" style="display:none;">
        <div class="panel-body">
            <form action="" method="post" class="form-horizontal form" enctype="multipart/form-data">
                <input type="hidden" name="leadExcel" value="true">
                <input type="hidden" name="c" value="site" />
                <input type="hidden" name="a" value="entry" />
                <input type="hidden" name="m" value="fm_jiaoyu" />
                <input type="hidden" name="do" value="UploadExcel" />
                <input type="hidden" name="ac" value="kcbiao" />
				<input type="hidden" name="schoolid" value="<?php  echo $schoolid;?>" />

                <a class="btn btn-primary" href="javascript:location.reload()"><i class="fa fa-refresh"></i> 刷新</a>
                <input name="viewfile" id="viewfile" type="text" value="" style="margin-left: 40px;" class="form-control-excel" readonly>
                <a class="btn btn-primary"><label for="unload" style="margin: 0px;padding: 0px;">上传...</label></a>
                <input type="file" class="pull-left btn-primary span3" name="inputExcel" id="unload" style="display: none;"
                       onchange="document.getElementById('viewfile').value=this.value;this.style.display='none';">
                <input type="submit" class="btn btn-primary" name="btnExcel" value="导入数据">
                <a class="btn btn-primary" href="../addons/fm_jiaoyu/public/example/example_kcbiao.xls">下载导入模板</a>
            </form>
        </div>
    </div>	
    <div class="panel panel-default">
        <div class="table-responsive panel-body">
        <table class="table table-hover">
			<thead class="navbar-inner">
				<tr>
                    <th class='with-checkbox' style="width: 2%;"><input type="checkbox" class="check_all" /></th>
					<th style="width:6%">授课教师</th>
					<th style="width:11%;">课程名称</th>	
					<th style="width:10%;">授课科目</th>	
					<th style="width:8%;">授课星期</th>
					<th style="width:10%;">课节或时段</th>						
					<th style="width:8%;">授课教室</th>
                    <th style="width:6%;">课时</th>						
                    <th style="width:6%;">状态</th>
                    <th style="width:8%;"> 教师签到 </th>
                    <th style="width:8%;"> 学生签到 </th>						
					<th class="qx_e_r_d" style="text-align:right;">操作</th>
				</tr>
			</thead>
			<tbody>
				<?php  if(is_array($list)) { foreach($list as $item) { ?>
				<tr>
                    <td class="with-checkbox"><input type="checkbox" name="check" value="<?php  echo $item['id'];?>"></td>
					<td style="overflow:visible; word-break:break-all; text-overflow:auto;white-space:normal"><?php  echo $item['tname'];?></td>
					<td style="overflow:visible; word-break:break-all; text-overflow:auto;white-space:normal"> <div> <?php  echo $item['kcname'];?></br> <span class="label label-info"><?php  echo date('Y年m月d日 H:i',$item['date'])?></span> </div> </td>
                   
                    <td> <?php  if(!empty($category[$item['km_id']])) { ?><?php  echo $category[$item['km_id']]['sname'];?><?php  } ?></td>
                    <td><?php  echo $item['week'];?></td>
                    <td> <?php  if(!empty($category[$item['sd_id']])) { ?><?php  echo $category[$item['sd_id']]['sname'];?><?php  } ?></td>
                    <td> <?php  if(!empty($category[$item['adrr']])) { ?><?php  echo $category[$item['adrr']]['sname'];?><?php  } ?></td>
					<td>第<span class="label label-warning"><?php  echo $item['nub'];?></span>课</td>

                    <td style="overflow:visible; word-break:break-all; text-overflow:visible;white-space:normal">
                    <?php  if($item['date']>TIMESTAMP) { ?><span class="label label-default">未上课</span><?php  } ?>
                    <?php  if($item['date']<TIMESTAMP) { ?><span class="label label-warning">已上课</span><?php  } ?>
					<?php  if(!empty($item['isxiangqing'])) { ?></br><span class="label label-success"><i class="fa fa-check-circle">有详细内容</i></span><?php  } ?>
                    </td>
                 	<td> 
						<?php  if(!empty($item['teaSign'])) { ?>
                     	<span class="label label-info"><?php  echo $item['teaSign'];?></span>
                     	<?php  } else { ?>
                     	<span class="label label-default">未签到</span>
                     	<?php  } ?>
                 	</td>
                    <td>
						<span class="label label-success">已签：<?php  echo $item['signstu'];?>人</span>
						</br>
						<span class="label label-primary">请假：<?php  echo $item['leavetu'];?>人</span>
						
	                    <a class="btn btn-default btn-sm qx_941" href="<?php  echo $this->createWebUrl('kcallstusign', array('ksid' => $item['id'],'kcid' => $item['kcid'], 'schoolid' => $schoolid,'fromKc'=>'fromKc'))?>" title="查看详情"><i class="fa fa-tasks">&nbsp;&nbsp;查看详情</i></a>
	                    </br>
						<span class="label label-danger">未签：<?php  echo $item['unsign'];?>人</span></td>

					<td class="qx_e_r_d" style="text-align:right;">
                        <a class="btn btn-default btn-sm qx_922"
                           href="<?php  echo $this->createWebUrl('kcbiao', array('id' => $item['id'], 'op' => 'post', 'schoolid' => $schoolid))?>"
                           title="编辑"><i class="fa fa-pencil"></i>
                        </a>
                        <?php  if($item['is_remind'] ==0) { ?>
                        <a id="tx_<?php  echo $item['id'];?>" class="btn btn-default btn-sm qx_924"
                          onclick="txsk(<?php  echo $item['id'];?>)"
                           title="提醒授课"><i class="fa fa-bell"></i>
                        </a>
                        <?php  } ?>
                        <a class="btn btn-default btn-sm qx_925" href="<?php  echo $this->createWebUrl('kcbiao', array('id' => $item['id'], 'op' => 'delete', 'schoolid' => $schoolid))?>"
                           onclick="return confirm('此操作不可恢复，确认删除？');return false;" title="删除">
                            <i class="fa fa-times"></i>
                        </a>
					</td>
				</tr>

				<?php  } } ?>
			</tbody>
			<tr>
				<td colspan="3">
					<input name="token" type="hidden" value="<?php  echo $_W['token'];?>" />
                    <input type="button" class="btn btn-primary qx_925" name="btndeleteall" value="批量删除" />
				</td>
				<td colspan="3">
					<input name="token" type="hidden" value="<?php  echo $_W['token'];?>" />
                    <input type="button" class="btn btn-primary qx_924" name="remindall" value="批量提醒" />
				</td>
			</tr>
		</table>
        <?php  echo $pager;?>
        </div>
    </div>
</div>

<script type="text/javascript">
<!--
	var category = <?php  echo json_encode($children)?>;
//-->
//----------全局菊花转----------
$("body").append('<div id="common_progress" class="common_progress_bg" style=""><div class="common_progress"><div class="common_loading"></div><br><span>正在载入...</span></div></div>');

function ajax_start_loading(text) {
    $("#common_progress").css("display", "block");
    $("body").css("position", "fixed");
    $(".common_progress").css("margin-left", $(window).width() / 2 - 80);
    if (text) {
        $("#common_progress span").text(text);
    }
}
// 关闭菊花转
function ajax_stop_loading() {
    $("#common_progress").hide();
    $("body").css("position", "static");
}
function txsk(id){
	ajax_start_loading("正在执行中...");

	$.ajax({
				url: "<?php  echo $this->createWebUrl('kcbiao', array('op' => 'remind'), true)?>",
				type: "post",
				dataType: "json",
				data: {
					id: id,
					schoolid: <?php  echo $schoolid;?>,
					weid:<?php  echo $weid;?>
				},
				success: function (data) {
				ajax_stop_loading() 
					 if(data.result){
					    alert(data.msg);
                       var a_id = "tx_"+id;
						$("#"+a_id).hide();
                    }else{
                        alert(data.msg);
                    }
					
				}
			});
	
}

$(function(){
	var e_r_d = 3 ;
	<?php  if(!(IsHasQx($tid_global,1000922,1,$schoolid))) { ?>
		$(".qx_922").hide();
		e_r_d = e_r_d -1  ;
	<?php  } ?>
	<?php  if(!(IsHasQx($tid_global,1000923,1,$schoolid))) { ?>
		$(".qx_923").hide();
	<?php  } ?>
	<?php  if(!(IsHasQx($tid_global,1000924,1,$schoolid))) { ?>
		$(".qx_924").hide();
		e_r_d = e_r_d -1  ;
	<?php  } ?>
	<?php  if(!(IsHasQx($tid_global,1000925,1,$schoolid))) { ?>
		$(".qx_925").hide();
		e_r_d = e_r_d -1  ;
	<?php  } ?>
	<?php  if(!(IsHasQx($tid_global,1000941,1,$schoolid))) { ?>
		$(".qx_941").hide();
	<?php  } ?>
	if(e_r_d == 0){
		$(".qx_e_r_d").hide();
	}
	
    $(".check_all").click(function(){
        var checked = $(this).get(0).checked;
        $("input[type=checkbox]").attr("checked",checked);
    });

    $("input[name=btndeleteall]").click(function(){
        var check = $("input[type=checkbox][class!=check_all]:checked");
        if(check.length < 1){
            alert('请选择要删除的课程!');
            return false;
        }
        if(confirm("确认要删除选择的课程?")){
            var id = new Array();
            check.each(function(i){
                id[i] = $(this).val();
            });
            var url = "<?php  echo $this->createWebUrl('kcbiao', array('op' => 'deleteall', 'schoolid' => $schoolid))?>";
            $.post(url,{idArr:id},
                function(data){
                    if(data.result){
					    alert(data.msg);
                        location.reload();
                    }else{
                        alert(data.msg);
                    }
                },'json');
        }
    });

     $("input[name=remindall]").click(function(){
        var check = $("input[type=checkbox][class!=check_all]:checked");
        if(check.length < 1){
            alert('请选择要提醒的课程!');
            return false;
        }
        if(confirm("确认要提醒选择的课程?")){
            var id = new Array();
            check.each(function(i){
                id[i] = $(this).val();
            });
            var url = "<?php  echo $this->createWebUrl('kcbiao', array('op' => 'remindall', 'schoolid' => $schoolid))?>";
            $.post(url,{idArr:id},
                function(data){
                    if(data.result){
					    alert(data.msg);
                        location.reload();
                    }else{
                        alert(data.msg);
                    }
                },'json');
        }
    });

});
</script>
<?php  } else if($operation == 'post') { ?>
<link rel="stylesheet" type="text/css" href="../addons/fm_jiaoyu/public/web/css/clockpicker.css" media="all">
<script type="text/javascript" src="../addons/fm_jiaoyu/public/web/js/clockpicker.js"></script>
<link rel="stylesheet" type="text/css" href="../addons/fm_jiaoyu/public/web/css/standalone.css" media="all">
<link rel="stylesheet" type="text/css" href="../addons/fm_jiaoyu/public/web/css/uploadify_t.css?v=4" media="all" />
<div class="panel panel-info">
   <div class="panel-heading"><a class="btn btn-primary" onclick="javascript :history.back(-1);"><i class="fa fa-tasks"></i> 返回</a></div>
</div>
<div class="main">
<form action="" method="post" class="form-horizontal form" enctype="multipart/form-data">
		<input type="hidden" name="tid" value="<?php  echo $item['tid'];?>" />
		<input type="hidden" name="kcid" value="<?php  echo $item['kcid'];?>" />
		<input type="hidden" name="bj_id" value="<?php  echo $item['bj_id'];?>" />
		<input type="hidden" name="km_id" value="<?php  echo $item['km_id'];?>" />
		<input type="hidden" name="schoolid" value="<?php  echo $schoolid;?>" />
        <div class="panel panel-default">
            <div class="panel-heading">
                修改课程
            </div>
            <div class="panel-body">
			    <div class="form-group">
                    <label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label" style="width: 100px;">课程名称：</label>
                    <div class="col-sm-9">                       
                      <?php  echo $kc['name'];?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label" style="width: 100px;">教师姓名:</label>
                  <div class="col-sm-2 col-lg-2">
	                     <select style="margin-right:15px;" name="sktid" class="form-control">
                            <option value="0">请选择授课教师</option>
                            <?php  if(is_array($allteacher)) { foreach($allteacher as $row) { ?>
                            <option value="<?php  echo $row['id'];?>" <?php  if($item['tid'] == $row['id']) { ?>selected="selected"<?php  } ?> ><?php  echo $row['tname'];?></option>
                            <?php  } } ?>
                        </select>
                    </div>
				</div>	
				<div class="form-group">	
                    <label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label" style="width: 100px;">授课地址：</label>
                     <div class="col-sm-2 col-lg-2">
	                     <select style="margin-right:15px;" name="skaddr_new[0]" class="form-control">
                            <option value="0">请选择授课教室</option>
                            <?php  if(is_array($addr)) { foreach($addr as $rowa) { ?>
                            <option value="<?php  echo $rowa['sid'];?>" <?php  if($item['addr_id'] == $rowa['sid']) { ?> selected="selected"<?php  } ?> ><?php  echo $rowa['sname'];?></option>
                            <?php  } } ?>
                        </select>
                    </div>				
                </div>
                <div class="form-group">
					<label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label" style="width: 100px;">班级:</label>
                    <div class="col-sm-2 col-lg-2">                                         
                         <?php  if(!empty($category[$item['bj_id']])) { ?><?php  echo $category[$item['bj_id']]['sname'];?><?php  } ?>
                    </div>
					<label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label" style="width: 100px;">科目:</label>
                    <div class="col-sm-2 col-lg-2">                       
                         <?php  if(!empty($category[$item['km_id']])) { ?><?php  echo $category[$item['km_id']]['sname'];?><?php  } ?>
                    </div>
				</div>	
				<div class="form-group">
                   <label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label" style="width: 100px;">开始时间:</label>
                     <div class="col-sm-2 col-lg-2">
				        <div class="input-group">
				     <?php  echo date('Y-m-d', $kc['start'])?>
                        </div>
				     </div>
                   <label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label" style="width: 100px;">结束时间:</label>
                     <div class="col-sm-2 col-lg-2">
				        <div class="input-group">
				    <?php  echo date('Y-m-d', $kc['end'])?>
                        </div>
				     </div>					 
                </div>	
                <div class="form-group">
					<label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label" style="width: 100px;">选择星期:</label>
                    <div class="col-sm-2 col-lg-2">
                        <select style="margin-right:15px;" name="xq" class="form-control">
                            <option value="<?php  echo $item['xq_id'];?>"><?php  if(!empty($category[$item['xq_id']])) { ?><?php  echo $category[$item['xq_id']]['sname'];?><?php  } ?></option>
                            <?php  if(is_array($xq)) { foreach($xq as $it) { ?>
                            <option value="<?php  echo $it['sid'];?>" <?php  if($it['sid'] == $item['xq_id']) { ?> selected="selected"<?php  } ?>><?php  echo $it['sname'];?></option>
                            <?php  } } ?>
                        </select>
						<div class="help-block">可不选</div>
                    </div>
					<label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label" style="width: 100px;">选择时段:</label>
                    <div class="col-sm-2 col-lg-2">
                        <select style="margin-right:15px;" name="sd" class="form-control">
                            <option value="<?php  echo $item['sd_id'];?>"><?php  if(!empty($category[$item['sd_id']])) { ?><?php  echo $category[$item['sd_id']]['sname'];?><?php  } ?></option>
                            <?php  if(is_array($sd)) { foreach($sd as $it) { ?>
                            <option value="<?php  echo $it['sid'];?>" <?php  if($it['sid'] == $item['sd_id']) { ?> selected="selected"<?php  } ?>><?php  echo $it['sname'];?></option>
                            <?php  } } ?>
                        </select>
                    </div>
				</div>	
				<div class="form-group">
                   <label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label" style="width: 100px;">本节日期:</label>
                     <div class="col-sm-2 col-lg-2">
				        <div class="input-group">
				     <?php  echo tpl_form_field_date('date',date('Y-m-d H:i',$item['date']))?>	
                        </div>
				     </div>
                   <label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label" style="width: 100px;">课程编号:</label>
                     <div class="col-sm-2 col-lg-2">
				        <div class="input-group">
				            <div class="col-sm-9">                       
                              <input type="text" class="form-control" name="nub" value="<?php  echo $item['nub'];?>" /><i style="color:red;">必须为整数</i>
                            </div>
                        </div>
				     </div>					 
                </div>
				<div class="form-group">
                   <label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label" style="width: 100px;">显示详情</label>
                        <label class="radio-inline">
                            <input type="radio" name="isxiangqing" value="1" <?php  if($item['isxiangqing']==1 || empty($item)) { ?>checked<?php  } ?> id="credit1">是
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="isxiangqing" value="0" <?php  if(isset($item['isxiangqing']) && empty($item['isxiangqing'])) { ?>checked<?php  } ?> id="credit0">否
                        </label>
                        <div class="help-block"></div>
                </div>				
				<div id="credit-status1" <?php  if($item['isxiangqing'] == 1) { ?>style="display:block"<?php  } else { ?>style="display:none"<?php  } ?>>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label" style="width: 100px;">本节详情</label>
                    <div class="col-sm-8 col-xs-12">
                       <?php  echo tpl_ueditor('content', $item['content']);?>
                    </div>
                </div>	
				</div>					
             </div>											   
		</div>	
        <div class="form-group col-sm-12">
            <input type="submit" name="submit" value="提交" class="btn btn-primary col-lg-1" />
            <input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
        </div>
    </form>
</div>
<script type="text/javascript">
	var category = <?php  echo json_encode($children)?>;
	$('#credit1').click(function(){
		$('#credit-status1').show();
	});
	$('#credit0').click(function(){
		$('#credit-status1').hide();
	});
</script>
<?php  } ?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('public/footer', TEMPLATE_INCLUDEPATH)) : (include template('public/footer', TEMPLATE_INCLUDEPATH));?>