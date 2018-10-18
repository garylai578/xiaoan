<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('public/header', TEMPLATE_INCLUDEPATH)) : (include template('public/header', TEMPLATE_INCLUDEPATH));?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('public/comhead', TEMPLATE_INCLUDEPATH)) : (include template('public/comhead', TEMPLATE_INCLUDEPATH));?>
<input type="hidden" name="schoolid" value="<?php  echo $schoolid;?>" />
    <div class="panel panel-info">
        <div class="panel-body">
           <?php  echo $this -> set_tabbar($action1, $schoolid, $_W['role'], $_W['isfounder']);?>
        </div>
    </div>
<ul class="nav nav-tabs">
    <li class="qx_edit <?php  if($operation == 'post') { ?>active<?php  } ?>"><a href="<?php  echo $this->createWebUrl('theclass', array('op' => 'post', 'schoolid' => $schoolid))?>">添加班级</a></li>
    <li <?php  if($operation == 'display') { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('theclass', array('op' => 'display', 'schoolid' => $schoolid))?>">班级管理</a></li>
</ul>
 <style>
.cLine {overflow: hidden;padding: 5px 0;color:#000000;}
.alert {padding: 8px 35px 0 10px;text-shadow: none;-webkit-box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);-moz-box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
background-color: #f9edbe;border: 1px solid #f0c36d;-webkit-border-radius: 2px;-moz-border-radius: 2px;border-radius: 2px;color: #333333;margin-top: 5px;}
.alert p {margin: 0 0 10px;display: block;}
.alert .bold{font-weight:bold;}
 </style>
<div class="cLine">
    <div class="alert">
    <p><span class="bold">使用方法：</span>    填写班级,如 高一一班,高一二班,高一三班.... </br>   
   <strong><font color='red'>特别提醒: 当你删除该班级项的时候,该班级项下相关的所有数据都会被删除,请谨慎操作!以免丢失数据!</font></strong></br>
   <?php  if($_W['isfounder']) { ?><strong><font style="color:#641DBF;">教室监控: 请查看商业群教室流媒体设置方法!</font></strong><?php  } ?>
    </p>
    </div>
</div>
<?php  if($operation == 'post') { ?>
<div class="main">
    <form action="" method="post" class="form-horizontal form" enctype="multipart/form-data">
        <!-- <input type="hidden" name="parentid" value="<?php  echo $parent['id'];?>" /> -->
        <input type="hidden" name="schoolid" value="<?php  echo $schoolid;?>" />		
        <div class="panel panel-default">
            <div class="panel-heading">班级分类编辑</div>
            <div class="panel-body">
				<div id="custom-url">
				<?php  if($theclass) { ?>
					<input type="hidden" name="old" value="111" />
					<div class="form-group">
						<div class="col-sm-2 col-lg-2">
							<input type="text" name="ssort" placeholder="排序" class="form-control" value="<?php  echo $theclass['ssort'];?>" />
							排序可为空
						</div>
						<div class="col-sm-2 col-lg-2">
							<select style="margin-right:15px;" name="parentid" class="form-control">
								<option value="0">所属年级</option>
								<?php  if(is_array($xueqi)) { foreach($xueqi as $it) { ?>
									<option value="<?php  echo $it['sid'];?>" <?php  if($it['sid'] == $theclass['parentid']) { ?> selected="selected"<?php  } ?>><?php  echo $it['sname'];?></option>
								<?php  } } ?>
							</select>
							必选
						</div>						
						<div class="col-sm-2 col-lg-2">
							<input type="text" name="catename" placeholder="班级名称" class="form-control" value="<?php  echo $theclass['sname'];?>" />
							必填
						</div>
						<div class="col-sm-2 col-lg-2" id="sxname">
							<select name="tid" class="form-control select" style="display:none">

							</select>
							<input type="text" placeholder="班主任或管理" class="form-control sxword" value="<?php  if($tname) { ?><?php  echo $tname['tname'];?><?php  } ?>"/>
						</div>
						<div class="col-sm-2 col-lg-2" style="width: 45px;margin-left: -31px;">	
							<span class="btn btn-default"><i class="fa fa-search"></i></span>
						</div>						
						<div class="col-sm-2 col-lg-2">
							<input type="text" name="cost" placeholder="报名费/元" class="form-control" value="<?php  echo $theclass['cost'];?>" />
							报名需要付费,留空不付
						</div>						
					</div>
					<?php  if($theclass['video']) { ?>
					<div class="form-group">
						<div class="col-sm-2 col-lg-2">
							<input type="text" name="video" placeholder="直播地址" class="form-control" value="<?php  echo $theclass['video'];?>" /><?php  if($_W['isfounder']) { ?>配置方法见商业群文件<?php  } ?>
						</div>					
						<div class="col-sm-9 col-xs-9 col-md-4">
							<div class="input-group clockpicker" style="margin-bottom: 15px">
								<?php  echo tpl_form_field_clock('videostart', $theclass['videostart'])?>
								<span class="input-group-addon">至</span>
								<?php  echo tpl_form_field_clock('videoend', $theclass['videoend'])?>
								<span class="input-group-addon"></span>
							</div>
							监控可用时间段
						</div>
						<div class="col-sm-9 col-xs-9 col-md-4">
							<label for="isshow1" class="radio-inline"><input type="radio" name="allowpy" value="1" id="isshow1" <?php  if(empty($theclass) || $theclass['allowpy'] == 1) { ?>checked="true"<?php  } ?> /> 允许</label>
							&nbsp;&nbsp;&nbsp;
							<label for="isshow2" class="radio-inline"><input type="radio" name="allowpy" value="2" id="isshow2"  <?php  if(!empty($theclass) && $theclass['allowpy'] == 2) { ?>checked="true"<?php  } ?> /> 拒绝</label>
							<span class="help-block"></span>
							是否运行评论本画面
						</div>						
					</div>	
					<?php  } ?>	
				<?php  } else { ?>
					<input type="hidden" name="new[]" value="222" />
					<div class="form-group">
						<div class="col-sm-2 col-lg-2">
							<input type="text" name="ssort_new[]" placeholder="排序" class="form-control" value="<?php  echo $theclass['ssort'];?>" />
							排序可为空
						</div>
						<div class="col-sm-2 col-lg-2">
							<select style="margin-right:15px;" name="parentid_new[]" class="form-control">
								<option>所属年级</option>
								<?php  if(is_array($xueqi)) { foreach($xueqi as $it) { ?>
									<option value="<?php  echo $it['sid'];?>"><?php  echo $it['sname'];?></option>
								<?php  } } ?>
							</select>
							必选
						</div>						
						<div class="col-sm-2 col-lg-2">
							<input type="text" name="catename_new[]" placeholder="班级名称" class="form-control" value="<?php  echo $theclass['sname'];?>" />
							必填
						</div>
						<div class="col-sm-2 col-lg-2" id="sxname">
							<select name="tid_new[]" class="form-control select" style="display:none">

							</select>
							<input type="text" placeholder="班主任或管理" class="form-control sxword" value="<?php  if($tname) { ?><?php  echo $tname['tname'];?><?php  } ?>"/>
						</div>
						<div class="col-sm-2 col-lg-2" style="width: 45px;margin-left: -31px;">	
							<span class="btn btn-default"><i class="fa fa-search"></i></span>
						</div>
						<div class="col-sm-2 col-lg-2">
							<input type="text" name="cost_new[]" placeholder="报名费/元" class="form-control" value="<?php  echo $theclass['sname'];?>" />
							报名需要付费,留空不付
						</div>						
					</div>			
				<?php  } ?>	
                </div>	
				<div class="clearfix template"> 
					<div class="form-group">
						<label class="col-xs-12 col-sm-3 col-md-2 control-label"></label>
						<div class="col-sm-9 col-xs-12">
							<a href="javascript:;" id="custom-url-add"><i class="fa fa-plus-circle"></i> 添加班级</a>
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
<script>
$('#custom-url-add').click(function(){
	var html =  '	<input type="hidden" name="new[]" value="222" />'+
				'	<div class="form-group">'+
				'		<div class="col-sm-2 col-lg-2">'+
				'			<input type="text" name="ssort_new[]" placeholder="排序" class="form-control" value="" />排序可为空'+
				'		</div>'+
				'		<div class="col-sm-2 col-lg-2">'+
				'			<select style="margin-right:15px;" name="parentid_new[]" class="form-control">'+
				'				<option>所属年级</option>'+
								<?php  if(is_array($xueqi)) { foreach($xueqi as $it) { ?>
				'					<option value="<?php  echo $it['sid'];?>"><?php  echo $it['sname'];?></option>'+
								<?php  } } ?>
				'			</select>必选'+
				'		</div>	'+					
				'		<div class="col-sm-2 col-lg-2">'+
				'			<input type="text" name="catename_new[]" placeholder="班级名称" class="form-control" value="" />必填'+
				'		</div>'+
				'		<div class="col-sm-2 col-lg-2" id="sxname">'+
				'			<select name="tid_new[]" class="form-control select" style="display:none">'+
				'			</select>'+
				'			<input type="text" placeholder="班主任或管理" class="form-control sxword" value="<?php  if($tname) { ?><?php  echo $tname['tname'];?><?php  } ?>"/>'+
				'		</div>'+
				'		<div class="col-sm-2 col-lg-2" style="width: 45px;margin-left: -31px;">'+
				'			<span class="btn btn-default"><i class="fa fa-search"></i></span>'+
				'		</div>'+				
				'		<div class="col-sm-2 col-lg-2">'+
				'			<input type="text" name="cost_new[]" placeholder="报名费/元" class="form-control" value="" />报名需要付费,留空不付'+
				'		</div>'+
				'	<div class="col-sm-1" style="margin-top:5px">'+
				'   	<a href="javascript:;" class="custom-url-del"><i class="fa fa-times-circle"></i></a>'+
				'	</div>'+				
				'	</div>'+
				'</div>';
			;
	$('#custom-url').append(html);
});
$(document).on('click', '.custom-url-del', function(){
	$(this).parent().parent().remove();
	return false;
});	

$(document).on('click', '.btn-default', function(){
	var t = $(this).parents().children();
	var want = t.find('input[class*=sxword]');
	var selectdiv = t.find('select[class*=select]');
	
	var tname = want.val();
	want.hide();
	selectdiv.show();
	
	var schoolid = "<?php  echo $schoolid;?>";
	var classlevel = [];
	html1 += '<select id="schoolid"><option value="">请选择老师</option>';
	if(tname != ''){
		$.post("<?php  echo $this->createWebUrl('indexajax',array('op'=>'getallteacher'))?>", {'tname': tname,schoolid:schoolid}, function(data) {
				data = JSON.parse(data);
			if(data.result == true){	
				classlevel = data.teachcers;		
				var html = '';
				if (classlevel != '') {
					for (var i in classlevel) {
						html += '<option value="' + classlevel[i].id + '">' + classlevel[i].tname + '</option>';
					}
				}
				selectdiv.html(html);
			}else{
				selectdiv.hide();
				want.show();
				alert(data.msg);
			}
		});	
	}else{
		var html1 = ''+
								<?php  if(is_array($allls)) { foreach($allls as $it) { ?>
				'					<option value="<?php  echo $it['id'];?>"><?php  echo $it['tname'];?></option>'+
								<?php  } } ?>
				'';
		selectdiv.html(html1);
	}
});
	
</script>
<?php  } else if($operation == 'display') { ?>
<div class="main">
   
    <div class="panel panel-default">
        <form action="" method="post" class="form-horizontal form" >
            <input type="hidden" name="schoolid" value="<?php  echo $schoolid;?>" />
            <div class="table-responsive panel-body">
                <table class="table table-hover">
                    <thead class="navbar-inner">
                    <tr>
					    <th style="width:100px;">序号</th>
						<th>所属年级</th>
                        <th>班级名称</th>
						<th>班级主任</th>
						<th>学生人数</th>
						<th>班级圈消息</th>
						<th>班级之星</th>
						<th>报名费</th>
                        <th class="qx_e_d" style="text-align:right;">编辑/删除</th>
                    </tr>
                    </thead>
                    <tbody id="level-list">
                    <?php  if(is_array($theclass)) { foreach($theclass as $row) { ?>
                    <tr>
					    <td><div class="type-parent"><?php  echo $row['ssort'];?></div></td>
						<td><div class="type-parent"><?php  echo $row['xueqi'];?></div></td>
                        <td><div class="type-parent"><?php  echo $row['sname'];?>&nbsp;&nbsp;</div></td>
						<td><div class="type-parent"><?php  echo $row['name'];?></div></td>
						<td><span class="label label-danger"><?php  echo $row['renshu'];?>人</span></td>
						<td><span class="label label-info"><?php  echo $row['bjqsm'];?>条</span></td>
						<td><input type="checkbox" value="<?php  echo $row['is_bjzx'];?>" name="is_on[]" data-id="<?php  echo $row['sid'];?>" <?php  if($row['is_bjzx'] == 1) { ?>checked<?php  } ?>></td>
						<td><?php  if(!empty($row['cost'])) { ?><span class="label label-success">￥<?php  echo $row['cost'];?></span><?php  } else { ?><span class="label label-danger">未启用</span><?php  } ?></td>
                        <td style="text-align:right;" class="qx_e_d"><a class="btn btn-default btn-sm qx_edit" href="<?php  echo $this->createWebUrl('theclass', array('op' => 'post', 'sid' => $row['sid'], 'schoolid' => $schoolid))?>" title="编辑"><i class="fa fa-pencil"></i></a>&nbsp;&nbsp;<a class="btn btn-default btn-sm qx_delete" href="<?php  echo $this->createWebUrl('theclass', array('op' => 'delete', 'sid' => $row['sid'], 'schoolid' => $schoolid))?>" onclick="return confirm('删除本班将清空本班所有班级圈消息和相册照片,确认吗？');return false;" title="删除"><i class="fa fa-times"></i></a></td>
                    </tr>
                    <?php  } } ?>
                    <!--tr>
                        <td colspan="3">
                            <input name="submit" type="submit" class="btn btn-primary" value="批量更新排序">
                            <input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
                        </td>
                    </tr-->
                    </tbody>
                </table>
            </div>
        </form>
    </div>
    <?php  echo $pager;?>
</div>
<script>
$(document).ready(function() {
	var e_d = 2 ;
	<?php  if(!(IsHasQx($tid_global,1000222,1,$schoolid))) { ?>
		$(".qx_edit").hide();
		e_d = e_d - 1 ;
	<?php  } ?>
	<?php  if(!(IsHasQx($tid_global,1000223,1,$schoolid))) { ?>
		$(".qx_delete").hide();
		e_d = e_d - 1 ;
	<?php  } ?>
	if(e_d == 0){
		$(".qx_e_d").hide();
	}
});	
require(['jquery', 'util', 'bootstrap.switch'], function($, u){

	$(':checkbox[name="is_on[]"]').bootstrapSwitch();
	$(':checkbox[name="is_on[]"]').on('switchChange.bootstrapSwitch', function(e, state){
		var is_on = this.checked ? 1 : 2;
		var id = $(this).data('id');
		$.post("<?php  echo $this->createWebUrl('theclass', array('op' => 'change','schoolid' => $schoolid))?>", {is_on: is_on, id: id}, function(resp){
			setTimeout(function(){
				//location.reload();
			}, 500)
		});
	});
});
</script>
<?php  } ?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('public/footer', TEMPLATE_INCLUDEPATH)) : (include template('public/footer', TEMPLATE_INCLUDEPATH));?>