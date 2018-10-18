<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('public/header', TEMPLATE_INCLUDEPATH)) : (include template('public/header', TEMPLATE_INCLUDEPATH));?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('public/comhead', TEMPLATE_INCLUDEPATH)) : (include template('public/comhead', TEMPLATE_INCLUDEPATH));?>
<input type="hidden" name="schoolid" value="<?php  echo $schoolid;?>" />
    <div class="panel panel-info">
        <div class="panel-body">
           <?php  echo $this -> set_tabbar($action1, $schoolid, $_W['role'], $_W['isfounder']);?>
        </div>
    </div>
<ul class="nav nav-tabs">
    <li class="qx_edit <?php  if($operation == 'post') { ?>active<?php  } ?>"><a href="<?php  echo $this->createWebUrl('score', array('op' => 'post', 'schoolid' => $schoolid))?>">添加成绩期号</a></li>
    <li <?php  if($operation == 'display') { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('score', array('op' => 'display', 'schoolid' => $schoolid))?>">成绩期号管理</a></li>
</ul>
 <style>
.cLine { overflow: hidden;padding: 5px 0;color:#000000;}
.alert {
padding: 8px 35px 0 10px;
text-shadow: none;
-webkit-box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
-moz-box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
background-color: #f9edbe;
border: 1px solid #f0c36d;
-webkit-border-radius: 2px;
-moz-border-radius: 2px;
border-radius: 2px;
color: #333333;
margin-top: 5px;
}
.alert p {
margin: 0 0 10px;
display: block;
}
.alert .bold{
font-weight:bold;
}
 </style>
<div class="cLine">
    <div class="alert">
    <p><span class="bold">使用方法：</span>
   填写成绩期号,如 一诊,第一次月考,第二次月考....<br/>
   <strong><font color='red'>特别提醒: 当你删除该成绩期号项的时候,该成绩期号项下相关的所有数据都会被删除,请谨慎操作!以免丢失数据!</font></strong>
    </p>
    </div>
</div>
<?php  if($operation == 'post') { ?>
<div class="main">
    <form action="" method="post" class="form-horizontal form" enctype="multipart/form-data">
        <input type="hidden" name="parentid" value="<?php  echo $parent['id'];?>" />
		<input type="hidden" name="schoolid" value="<?php  echo $schoolid;?>" />	
        <div class="panel panel-default">
            <div class="panel-heading">
                成绩期号分类编辑编辑
            </div>
            <div class="panel-body">
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">排序</label>
                    <div class="col-sm-9">
                        <input type="text" name="ssort" class="form-control" value="<?php  echo $score['ssort'];?>" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">成绩期号名称</label>
                    <div class="col-sm-9">
                        <input type="text" name="catename" class="form-control" value="<?php  echo $score['sname'];?>" />
                    </div>
                </div>
				<div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">类型</label>
                    <div class="col-sm-9">
                        <label for="isshow3" class="radio-inline"><input type="radio" name="qhtype" value="2" id="isshow3" <?php  if(!empty($score) && $score['qhtype'] == 2) { ?>checked="true"<?php  } ?> /> 指定班级</label>
                        &nbsp;&nbsp;&nbsp;
                        <label for="isshow4" class="radio-inline"><input type="radio" name="qhtype" value="1" id="isshow4"  <?php  if(empty($score['qhtype']) || $score['qhtype'] == 1) { ?>checked="true"<?php  } ?> /> 全校可用</label>
                        <span class="help-block">指定班级或者设定为全校用</span>
                    </div>
                </div>
				<div id="credit-status1" <?php  if(empty($score['qhtype']) || $score['qhtype'] == 2) { ?>style="display:block"<?php  } else { ?>style="display:none"<?php  } ?>>
					<div class="form-group">
						<label class="col-xs-12 col-sm-3 col-md-2 control-label">选择班级</label>
						<div class="col-sm-9 col-xs-6">
							<div class="input-group text-info">
								<label class="checkbox-inline"><input type="checkbox" class="check_all" />全选</label>
								<?php  if(is_array($banji)) { foreach($banji as $uni) { ?>
								<?php  $is = $this->uniarr($uniarr,$uni['sid']);?>
										<label for="uni_<?php  echo $uni['sid'];?>" class="checkbox-inline">
										<input id="uni_<?php  echo $uni['sid'];?>" type="checkbox" name="arr[]" value="<?php  echo $uni['sid'];?>"<?php  if(($is)) { ?>checked="checked"<?php  } ?>> <?php  echo $uni['sname'];?>
										</label>
								<?php  } } ?>
							</div>
							<div class="help-block">选择要应用到的班级</div>
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
    $(".check_all").click(function(){
        var checked = $(this).get(0).checked;
        $("input[type=checkbox]").attr("checked",checked);
    });
	$('#isshow3').click(function(){
		$('#credit-status1').show();
	});
	$('#isshow4').click(function(){
		$('#credit-status1').hide();
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
                        <th>成绩期号名称</th>
                        <th class="qx_e_d" style="text-align:right;">编辑/删除</th>
                    </tr>
                    </thead>
                    <tbody id="level-list">
                    <?php  if(is_array($score)) { foreach($score as $row) { ?>
                    <tr>
					    <td><div class="type-parent"><?php  echo $row['sid'];?></div></td>
                        <td><div class="type-parent"><?php  echo $row['sname'];?>&nbsp;&nbsp;</div></td>
                        <td style="text-align:right;" class="qx_e_d"><a class="btn btn-default btn-sm qx_edit" href="<?php  echo $this->createWebUrl('score', array('op' => 'post', 'sid' => $row['sid'], 'schoolid' => $schoolid))?>" title="编辑"><i class="fa fa-pencil"></i></a>&nbsp;&nbsp;<a class="btn btn-default btn-sm qx_delete" href="<?php  echo $this->createWebUrl('score', array('op' => 'delete', 'sid' => $row['sid'], 'schoolid' => $schoolid))?>" onclick="return confirm('确认删除此分类吗？');return false;" title="删除"><i class="fa fa-times"></i></a></td>
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
<script type="text/javascript">
$(document).ready(function() {
	var e_d = 2 ;
	<?php  if(!(IsHasQx($tid_global,1000232,1,$schoolid))) { ?>
		$(".qx_edit").hide();
		e_d = e_d - 1 ;
	<?php  } ?>
	<?php  if(!(IsHasQx($tid_global,1000233,1,$schoolid))) { ?>
		$(".qx_delete").hide();
		e_d = e_d - 1 ;
	<?php  } ?>
	if(e_d == 0){
		$(".qx_e_d").hide();
	}
});	
</script>
<?php  } ?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('public/footer', TEMPLATE_INCLUDEPATH)) : (include template('public/footer', TEMPLATE_INCLUDEPATH));?>