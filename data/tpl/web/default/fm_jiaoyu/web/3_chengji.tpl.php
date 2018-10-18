<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('public/header', TEMPLATE_INCLUDEPATH)) : (include template('public/header', TEMPLATE_INCLUDEPATH));?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('public/comhead', TEMPLATE_INCLUDEPATH)) : (include template('public/comhead', TEMPLATE_INCLUDEPATH));?>
<?php  if($operation == 'display') { ?>
<script>
require(['bootstrap'],function($){
	$('.btn,.tips').hover(function(){
		$(this).tooltip('show');
	},function(){
		$(this).tooltip('hide');
	});
});
</script>
<div class="main">
<style>
.form-control-excel {height: 34px;padding: 6px 12px;font-size: 14px;line-height: 1.42857143;color: #555;background-color: #fff;background-image: none;border: 1px solid #ccc;border-radius: 4px;-webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075);box-shadow: inset 0 1px 1px rgba(0,0,0,.075);-webkit-transition: border-color ease-in-out .15s,-webkit-box-shadow ease-in-out .15s;-o-transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;}
</style>
    <div class="panel panel-info">
        <div class="panel-heading">成绩管理</div>
        <div class="panel-body">
            <form action="./index.php" method="get" class="form-horizontal" role="form">
                <input type="hidden" name="c" value="site" />
                <input type="hidden" name="a" value="entry" />
                <input type="hidden" name="m" value="fm_jiaoyu" />
                <input type="hidden" name="do" value="chengji" />
				<input type="hidden" name="schoolid" value="<?php  echo $schoolid;?>" />
                <div class="form-group">
                    <label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label" style="width: 100px;">按学号</label>
                    <div class="col-sm-2 col-lg-2">
                        <input class="form-control" name="xuehao" type="text" value="<?php  echo $_GPC['xuehao'];?>">
                    </div>
                    <label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label" style="width: 100px;">按姓名</label>
                    <div class="col-sm-2 col-lg-2">
                        <input class="form-control" name="xsxm" type="text" value="<?php  echo $_GPC['xsxm'];?>">
                    </div>					
				</div>			
				<div class="form-group">
                 <label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label" style="width: 100px;">按期号</label>				
                    <div class="col-sm-2 col-lg-2">
                        <select style="margin-right:15px;" name="qh_id" class="form-control">
                            <option value="0">请选择期号搜索</option>
                            <?php  if(is_array($qh)) { foreach($qh as $row) { ?>
                            <option value="<?php  echo $row['sid'];?>" <?php  if($row['sid'] == $_GPC['qh_id']) { ?> selected="selected"<?php  } ?>><?php  echo $row['sname'];?></option>
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
                    <div class="col-sm-2 col-lg-2">
                        <button class="btn btn-default"><i class="fa fa-search"></i> 搜索</button>
                    </div>						
                    <div class="col-sm-2 col-lg-2">						
						<a class="btn btn-success qx_803" href="javascript:;" onclick="$('.file-container').slideToggle()">批量导入成绩</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="panel panel-default file-container" style="display:none;">
        <div class="panel-body">
            <form action="" method="post" class="form-horizontal form" enctype="multipart/form-data">
                <input type="hidden" name="leadExcel" value="true">
                <input type="hidden" name="c" value="site" />
                <input type="hidden" name="a" value="entry" />
                <input type="hidden" name="m" value="fm_jiaoyu" />
                <input type="hidden" name="do" value="UploadExcel" />
                <input type="hidden" name="ac" value="chengji" />
				<input type="hidden" name="schoolid" value="<?php  echo $schoolid;?>" />
				<div class="col-sm-2 col-lg-2">
					<select name="qh_id" class="form-control">
						<option value="">请选择期号导入</option>
						<?php  if(is_array($qh)) { foreach($qh as $row) { ?>
						<option value="<?php  echo $row['sid'];?>" <?php  if($row['sid'] == $_GPC['qh_id']) { ?> selected="selected"<?php  } ?>><?php  echo $row['sname'];?></option>
						<?php  } } ?>
					</select>
				</div>	
				<a class="btn btn-primary" href="javascript:location.reload()"><i class="fa fa-refresh"></i> 刷新</a>				
                <input name="viewfile" id="viewfile" type="text" value="" style="margin-left: 40px;" class="form-control-excel" readonly>
                <a class="btn btn-primary"><label for="unload" style="margin: 0px;padding: 0px;">上传...</label></a>
                <input type="file" class="pull-left btn-primary span3" name="inputExcel" id="unload" style="display: none;"
                       onchange="document.getElementById('viewfile').value=this.value;this.style.display='none';">
                <input type="submit" class="btn btn-primary" name="btnExcel" value="导入数据">
                <a class="btn btn-primary" href="../addons/fm_jiaoyu/public/example/example_chengji.xls">下载导入模板</a>
            </form>
        </div>
    </div>
    <div class="panel panel-default">
        <div class="table-responsive panel-body">
        <form action="" method="post" class="form-horizontal form" enctype="multipart/form-data">
		<input type="hidden" name="schoolid" value="<?php  echo $schoolid;?>" />
        <table class="table table-hover">
			<thead class="navbar-inner">
				<tr>
                    <th class='with-checkbox' style="width: 3%;"><input type="checkbox" class="check_all" /></th>
					<th style="width:5%">学号</th>
					<th style="width:5%">姓名</th>
					<th style="width:4%;">性别</th>
					<th style="width:5%;">年龄</th>
                    <th style="width:8%;">手机</th>
                    <th style="width:8%;">期号</th>
					<th style="width:8%;">科目</th>
                    <th style="width:8%;">成绩</th>					
					<th class="qx_e_d" style="text-align:right; width:8%;">操作</th>
				</tr>
			</thead>
			<tbody>
				<?php  if(is_array($list)) { foreach($list as $item) { ?>
				<tr>
                    <td class="with-checkbox"><input type="checkbox" name="check" value="<?php  echo $item['id'];?>"></td>
					<td>
                       <?php  if(!empty($item['numberid'])) { ?><?php  echo $item['numberid'];?><?php  } else { ?><span class="label label-danger">无学号</span><?php  } ?>
                    </td>
					<td><?php  echo $item['s_name'];?></td>	
					<td><?php  if($item['sex'] == 1) { ?><span class="label label-success">男</span><?php  } else { ?><span class="label label-success">女</span><?php  } ?></td>
					<td>
                        <span class="label label-success"><?php  echo (date('Y',TIMESTAMP) - date('Y',$item['birthdate']))?>岁</span>
                    </td>
					<td>
                        <?php  if(!empty($item['sid'])) { ?><?php  echo $item['mobile'];?><?php  } ?>
                    </td>	
                    <td>
					    <?php  if(!empty($category[$item['qh_id']])) { ?><?php  echo $category[$item['qh_id']]['sname'];?><?php  } ?>                       
                    </td>					
                    <td>
                        <?php  if(!empty($category[$item['km_id']])) { ?><?php  echo $category[$item['km_id']]['sname'];?><?php  } ?>
                    </td>					
					<td style="color:#f00;"><?php  echo $item['my_score'];?>&nbsp;分</td> 									
					<td class="qx_e_d" style="text-align:right;">
						<a class="btn btn-default btn-sm qx_802" href="<?php  echo $this->createWebUrl('chengji', array('id' => $item['id'], 'op' => 'post', 'schoolid' => $schoolid))?>" title="编辑"><i class="fa fa-pencil"></i></a>&nbsp;&nbsp;<a class="btn btn-default btn-sm qx_804" href="<?php  echo $this->createWebUrl('chengji', array('id' => $item['id'], 'op' => 'delete', 'schoolid' => $schoolid))?>" onclick="return confirm('此操作不可恢复，确认删除？');return false;" title="删除"><i class="fa fa-times"></i></a>
					</td>
				</tr>
				<?php  } } ?>
			</tbody>
			<tr>
				<td colspan="10">
					<input name="token" type="hidden" value="<?php  echo $_W['token'];?>" />
                    <input type="button" class="btn btn-primary" name="btndeleteall" value="批量删除" />
				</td>
			</tr>
		</table>
        <?php  echo $pager;?>
    </form>
        </div>
    </div>
</div>
<script type="text/javascript">
$(function(){
	var e_d = 2 ;
	<?php  if(!(IsHasQx($tid_global,1000802,1,$schoolid))) { ?>
		$(".qx_802").hide();
		e_d = e_d -1;
	<?php  } ?>
	<?php  if(!(IsHasQx($tid_global,1000803,1,$schoolid))) { ?>
		$(".qx_803").hide();
	<?php  } ?>
	<?php  if(!(IsHasQx($tid_global,1000804,1,$schoolid))) { ?>
		$(".qx_804").hide();
		e_d = e_d -1;
	<?php  } ?>
	
	if(e_d == 0){
		$(".qx_e_d").hide();
	}
	
    $(".check_all").click(function(){
        var checked = $(this).get(0).checked;
        $("input[type=checkbox]").attr("checked",checked);
    });

    $("input[name=btndeleteall]").click(function(){
        var check = $("input[type=checkbox][class!=check_all]:checked");
        if(check.length < 1){
            alert('请选择要删除的成绩!');
            return false;
        }
        if(confirm("确认要删除选择的成绩?")){
            var id = new Array();
            check.each(function(i){
                id[i] = $(this).val();
            });
            var url = "<?php  echo $this->createWebUrl('chengji', array('op' => 'deleteall','schoolid' => $schoolid))?>";
            $.post(
                url,
                {idArr:id},
                function(data){
                    if(data.result){
					    alert(data.msg);
                        location.reload();
                    }else{
                        alert(data.msg);
                    }
                },'json'
            );
        }
    });

});
</script>
<?php  } else if($operation == 'post') { ?>
<div class="panel panel-info">
   <div class="panel-heading"><a class="btn btn-primary" onclick="javascript :history.back(-1);"><i class="fa fa-tasks"></i> 返回</a></div>
</div>
<div class="main">
<form action="" method="post" class="form-horizontal form" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php  echo $item['id'];?>" />
		<input type="hidden" name="sid" value="<?php  echo $item['sid'];?>" />	
		<input type="hidden" name="bj" value="<?php  echo $item['bj_id'];?>" />
		<input type="hidden" name="schoolid" value="<?php  echo $schoolid;?>" />
        <div class="panel panel-default">
            <div class="panel-heading">
                修改成绩
            </div>
            <div class="panel-body">
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">学生姓名:</label>
                    <div class="col-sm-9" style="color:red;">
                       <?php  echo $student['s_name'];?>
                    </div>
                </div>
				<div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">所在班级:</label>
                    <div class="col-sm-9" style="color:red;">
                        <?php  echo $bj['sname'];?>
                    </div>
                </div>	
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">选择期号</label>
                    <div class="col-sm-9">
                        <select class="form-control" style="margin-right:15px;" name="qh" onchange="fetchChildKm(this.options[this.selectedIndex].value)"  autocomplete="off" class="form-control">
                            <option value="0">请选择期号</option>
                            <?php  if(is_array($qh)) { foreach($qh as $it) { ?>
                            <option value="<?php  echo $it['sid'];?>" <?php  if($it['sid'] == $item['qh_id']) { ?> selected="selected"<?php  } ?>><?php  echo $it['sname'];?></option>
                            <?php  } } ?>
                        </select>
                    </div>
                </div>					
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">选择科目</label>
                    <div class="col-sm-9">
                        <select class="form-control" style="margin-right:15px;" name="km" onchange="fetchChildKm(this.options[this.selectedIndex].value)"  autocomplete="off" class="form-control">
                            <option value="0">请选择科目</option>
                            <?php  if(is_array($km)) { foreach($km as $it) { ?>
                            <option value="<?php  echo $it['sid'];?>" <?php  if($it['sid'] == $item['km_id']) { ?> selected="selected"<?php  } ?>><?php  echo $it['sname'];?></option>
                            <?php  } } ?>
                        </select>
                    </div>
                </div>					
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">考试分数</label>
                    <div class="col-sm-9">
                        <div class="input-group">
                            <input type="text" name="score" class="form-control" value="<?php  echo $item['my_score'];?>" />
                        </div>
                    </div>
                </div>	
				<div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">教师点评</label>
                    <div class="col-sm-9">
                        <textarea style="height:150px;" class="form-control richtext" name="info" cols="70"><?php  echo $item['info'];?></textarea>
                        <span class="help-block"></span>
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
<?php  } ?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('public/footer', TEMPLATE_INCLUDEPATH)) : (include template('public/footer', TEMPLATE_INCLUDEPATH));?>