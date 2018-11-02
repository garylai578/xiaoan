<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('public/header', TEMPLATE_INCLUDEPATH)) : (include template('public/header', TEMPLATE_INCLUDEPATH));?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('public/comhead', TEMPLATE_INCLUDEPATH)) : (include template('public/comhead', TEMPLATE_INCLUDEPATH));?>
<input type="hidden" name="schoolid" value="<?php  echo $schoolid;?>" />
<ul class="nav nav-tabs">
    <li class="qx_edit <?php  if($operation == 'post') { ?>active<?php  } ?>"><a href="<?php  echo $this->createWebUrl('checkdateset', array('op' => 'post', 'schoolid' => $schoolid))?>"><i class="fa fa-plus"></i>添加</a></li>
    <li <?php  if($operation == 'display') { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('checkdateset', array('op' => 'display', 'schoolid' => $schoolid))?>"><i class="fa fa-cog"></i>日期管理</a></li>
</ul>
 <style>
 ul{margin-top: 0 !important;}
.cLine {overflow: hidden;padding: 5px 0;color:#000000;}
.alert {padding: 8px 35px 0 10px;text-shadow: none;-webkit-box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);-moz-box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);background-color: #f9edbe;border: 1px solid #f0c36d;-webkit-border-radius: 2px;-moz-border-radius: 2px;border-radius: 2px;color: #333333;margin-top: 5px;}
.alert p {margin: 0 0 10px;display: block;}
.alert .bold{font-weight:bold;}
.checkbox input[type=checkbox], .checkbox-inline input[type=checkbox], .radio input[type=radio], .radio-inline input[type=radio] {
     margin-top: 4px; 
}
 </style>
<div class="cLine"> 
    <div class="alert">
    <p><span class="bold">注意：</span>
   时段设置为周五、周六、周日以及正常上课日的进出时段设置，详细设置为寒暑假、特殊上课与特殊休假的设置。

    </p>
    </div>
</div>
<?php  if($operation == 'post') { ?>
<div class="main">
<form action="" method="post" class="form-horizontal form" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php  echo $item['id'];?>" />
		<input type="hidden" name="schoolid" value="<?php  echo $schoolid;?>" />
        <div class="panel panel-default">
            <div class="panel-heading">编辑时间安排</div>
            <div class="panel-body">
				
			    <div class="form-group">
                    <label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label" style="width: 100px;"  >安排名称：</label>
                    <div class="col-sm-9">                       
                            <input type="text" class="form-control" name="name" value="<?php  echo $item['name'];?>" required="required" oninvalid="setCustomValidity('日期安排名称不能为空！');" oninput="setCustomValidity('');"/>
                    </div>
                </div>
				<div class="form-group">
	                <label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label" style="width: 100px;">周五设置：</label>
                    <div class="col-sm-2 col-lg-2">
                        <label class="radio-inline">
                            <input type="radio" name="fridayset" value="1" <?php  if($item['friday']==1) { ?>checked<?php  } ?>>是
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="fridayset" value="0" <?php  if($item['friday']==0) { ?>checked<?php  } ?>>否
                        </label>
                        <div class="help-block">周五单独设置</div>
                    </div>
				</div>	
				<div class="form-group">
	                <label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label" style="width: 100px;">周六设置：</label>
                    <div class="col-sm-2 col-lg-2">
                        <label class="radio-inline">
                            <input type="radio" name="saturdayset" value="1" <?php  if($item['saturday']==1) { ?>checked<?php  } ?>>上课
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="saturdayset" value="0" <?php  if($item['saturday']==0) { ?>checked<?php  } ?>>放假
                        </label>
                        <div class="help-block">周六上课还是放假</div>
                    </div>
				</div>
				<div class="form-group">
	                <label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label" style="width: 100px;">周日设置：</label>
                    <div class="col-sm-2 col-lg-2">
                        <label class="radio-inline">
                            <input type="radio" name="sundayset" value="1" <?php  if($item['sunday']==1) { ?>checked<?php  } ?>>上课
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="sundayset" value="0" <?php  if($item['sunday']==0) { ?>checked<?php  } ?>>放假
                        </label>
                        <div class="help-block">周日上课还是放假</div>
                    </div>
				</div>
				<!--  <div class="form-group">
	               <label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label" style="width: 100px;">法定假日:</label>
					<div class="col-sm-9 col-xs-6">
						<div class="input-group text-info">
                            <label  class="checkbox-inline" style="width:10%;margin-left: 10px"><input type="checkbox" name="holidayarr[]"  value="1"  style="float: none;" <?php  if(($is)) { ?>checked="checked"<?php  } ?>> <?php  echo $row['tname'];?></label>                        
						</div>
						<div class="help-block">选择授课老师，最多五个</div>
					</div>
				</div> -->
				<div class="form-group">
					 <label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label" style="width: 100px;">选择班级：</label>
					<div class="col-sm-9 col-xs-6">
						<div class="input-group text-info">
							<?php  if(is_array($banji)) { foreach($banji as $uni) { ?>
									<label for="uni_<?php  echo $uni['sid'];?>" class="checkbox-inline" style="width:140px;margin-left: 10px"><input id="uni_<?php  echo $uni['sid'];?>" type="checkbox" name="arr[]" value="<?php  echo $uni['sid'];?>"<?php  if(($id && $uni['datesetid'] == $id)) { ?>checked="checked"<?php  } ?> <?php  if(($id && $uni['datesetid'] != 0 && $uni['datesetid'] !=$id) || (empty($id) && $uni['datesetid'] != 0  ) ) { ?>disabled="disabled"<?php  } ?>> <?php  echo $uni['sname'];?></label>
							<?php  } } ?>
						</div>
						<div class="help-block">选择本安排适用的班级,若班级已指定安排则不可选</div>
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
        <div class="panel-body">
            <a class="btn btn-primary" href="javascript:location.reload()"><i class="fa fa-refresh"></i>刷新</a>
        </div>
    </div>
    <div class="panel panel-default">
        <form action="" method="post" class="form-horizontal form" >
            <input type="hidden" name="schoolid" value="<?php  echo $schoolid;?>" />
            <div class="table-responsive panel-body">
                <table class="table table-hover">
                    <thead class="navbar-inner">
                    <tr>
					    <th style="width:100px;">序号</th>
                        <th>安排名称</th>
						<th>周五设置</th>
						<th>周六设置</th>
						<th>周日设置</th>
						<th>适用班级</th>
						<th class="qx_02902">详细设置</th>
						<th class="qx_02903">时段设置</th>
                        <th class="qx_e_d" style="text-align:right;">编辑/删除</th>
                    </tr>
                    </thead>
                    <tbody id="level-list">
                    <?php  if(is_array($datesetlist)) { foreach($datesetlist as $row) { ?>
                    <tr>
					    <td><div class="type-parent"><?php  echo $row['id'];?></div></td>
                        <td><div class="type-parent"><?php  echo $row['name'];?>&nbsp;&nbsp;</div></td>
						<td>
						<?php  if($row['friday'] == 1) { ?>
							<span class="label label-warning">单独设置</span>
						<?php  } else if($row['friday'] == 0) { ?>
							<span class="label label-info">统一设置</span>
						<?php  } ?>
						</td>
						<td>
						<?php  if($row['saturday'] == 1) { ?>
							<span class="label label-warning">上课</span>
						<?php  } else if($row['saturday'] == 0) { ?>
							<span class="label label-info">休息</span>
						<?php  } ?>
						</td>
						<td>
						<?php  if($row['sunday'] == 1) { ?>
							<span class="label label-warning">上课</span>
						<?php  } else if($row['sunday'] == 0) { ?>
							<span class="label label-info">休息</span>
						<?php  } ?>
						</td>
						<td>
						<?php  if($row['mutibj'] == 0 ) { ?>
						<span class="label label-primary" ><?php  echo $row['bjname'];?></span>
						<?php  } else if($row['mutibj'] == 1) { ?>
						<span class="label label-primary" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="<?php  echo $row['bjname'];?>">列表</span>
						<?php  } ?>
						</td>
						<td class="qx_02902"><a class="btn btn-default btn-sm qx_02902" href="<?php  echo $this->createWebUrl('checkdatedetail', array('id' => $row['id'], 'op' => 'display', 'schoolid' => $schoolid))?>" title="详细设置"><i class="fa fa-qrcode">&nbsp;&nbsp;详细设置</i></a></td>
						<td class="qx_02903"><a class="btn btn-default btn-sm qx_02903" href="<?php  echo $this->createWebUrl('checktimeset', array('id' => $row['id'], 'op' => 'post', 'schoolid' => $schoolid))?>" title="时段设置"><i class="fa fa-qrcode">&nbsp;&nbsp;时段设置</i></a></td>
                        <td style="text-align:right;" class="qx_e_d"><a class="btn btn-default btn-sm qx_edit" href="<?php  echo $this->createWebUrl('checkdateset', array('op' => 'post', 'id' => $row['id'], 'schoolid' => $schoolid))?>" title="编辑"><i class="fa fa-pencil"></i></a>&nbsp;&nbsp;<a class="btn btn-default btn-sm qx_delete" href="<?php  echo $this->createWebUrl('checkdateset', array('op' => 'delete', 'id' => $row['id'], 'schoolid' => $schoolid))?>" onclick="return confirm('确认删除此安排吗？');return false;" title="删除"><i class="fa fa-times"></i></a></td>
                    </tr>
                    <?php  } } ?>
                    </tbody>
                </table>
            </div>
        </form>
    </div>
    <?php  echo $pager;?>
</div>
<script type="text/javascript">
$(document).ready(function() {
	var e_d = 2 ;
	<?php  if(!(IsHasQx($tid_global,1002904,1,$schoolid))) { ?>
		$(".qx_edit").hide();
		e_d = e_d - 1 ;
	<?php  } ?>
	<?php  if(!(IsHasQx($tid_global,1002902,1,$schoolid))) { ?>
		$(".qx_02902").hide();
	<?php  } ?>
	<?php  if(!(IsHasQx($tid_global,1002903,1,$schoolid))) { ?>
		$(".qx_02903").hide();
	<?php  } ?>
	<?php  if(!(IsHasQx($tid_global,1002905,1,$schoolid))) { ?>
		$(".qx_delete").hide();
		e_d = e_d - 1 ;
	<?php  } ?>
	if(e_d == 0){
		$(".qx_e_d").hide();
	}
});	
 
</script>
<?php  } ?>
