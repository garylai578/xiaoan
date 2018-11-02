<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('public/header', TEMPLATE_INCLUDEPATH)) : (include template('public/header', TEMPLATE_INCLUDEPATH));?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('public/comhead', TEMPLATE_INCLUDEPATH)) : (include template('public/comhead', TEMPLATE_INCLUDEPATH));?>
<input type="hidden" name="schoolid" value="<?php  echo $schoolid;?>" />
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
   填写<?php echo NJNAME;?>,如 小班，中班，大班，一<?php echo NJNAME;?>,二<?php echo NJNAME;?>,初一，初二，高一，高二，大一，大二....

    </p>
    </div>
</div>
<div class="panel panel-info">
   <div class="panel-heading"><a class="btn btn-primary" onclick="javascript :history.back(-1);"><i class="fa fa-tasks"></i> 返回</a></div>
</div>
<div class="main">
<form action="" method="post" class="form-horizontal form" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php  echo $id;?>" />
		<input type="hidden" name="schoolid" value="<?php  echo $schoolid;?>" />
        <div class="panel panel-default">
		
          	<div class="panel panel-info">
				<div class="panel-heading">正常上课时段设置</div>
				<div class="panel-body">
					<div class="form-group">
						<label class="col-xs-12 col-sm-3 col-md-2 control-label">时段1</label>
						<div class="col-sm-9 col-xs-9 col-md-4">
							<div class="input-group clockpicker" style="margin-bottom: 15px">
								<?php echo tpl_form_field_clock('work_start1', $workdayset[0]['start']? $workdayset[0]['start']:'00:00')?>
								<span class="input-group-addon">至</span>
								<?php echo tpl_form_field_clock('work_end1', $workdayset[0]['end']?$workdayset[0]['end']:'00:00')?>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label class="col-xs-12 col-sm-3 col-md-2 control-label">时段2</label>
						<div class="col-sm-9 col-xs-9 col-md-4">
							<div class="input-group clockpicker" style="margin-bottom: 15px">
								<?php echo tpl_form_field_clock('work_start2', $workdayset[1]['start']? $workdayset[1]['start']:'00:00')?>
								<span class="input-group-addon">至</span>
								<?php echo tpl_form_field_clock('work_end2', $workdayset[1]['end']?$workdayset[1]['end']:'00:00')?>
							</div>
						</div>
					</div>
					<div class="form-group"> 
						<label class="col-xs-12 col-sm-3 col-md-2 control-label">时段3</label>
						<div class="col-sm-9 col-xs-9 col-md-4">
							<div class="input-group clockpicker" style="margin-bottom: 15px">
								<?php echo tpl_form_field_clock('work_start3', $workdayset[2]['start']?$workdayset[2]['start']:'00:00')?>
								<span class="input-group-addon">至</span>
								<?php echo tpl_form_field_clock('work_end3', $workdayset[2]['end']?$workdayset[2]['end']:'00:00')?>
							</div>
						</div>
					</div>
					<div class="form-group"> 
						<label class="col-xs-12 col-sm-3 col-md-2 control-label">时段4</label>
						<div class="col-sm-9 col-xs-9 col-md-4">
							<div class="input-group clockpicker" style="margin-bottom: 15px">
								<?php echo tpl_form_field_clock('work_start4',$workdayset[3]['start']?$workdayset[3]['start']:'00:00')?>
								<span class="input-group-addon">至</span>
								<?php echo tpl_form_field_clock('work_end4', $workdayset[3]['end']?$workdayset[3]['end']:'00:00')?>
							</div>
						</div>
					</div>
					<div class="form-group"> 
						<label class="col-xs-12 col-sm-3 col-md-2 control-label">时段5</label>
						<div class="col-sm-9 col-xs-9 col-md-4">
							<div class="input-group clockpicker" style="margin-bottom: 15px">
								<?php echo tpl_form_field_clock('work_start5', $workdayset[4]['start']?$workdayset[4]['start']:'00:00')?>
								<span class="input-group-addon">至</span>
								<?php echo tpl_form_field_clock('work_end5', $workdayset[4]['end']?$workdayset[4]['end']:'00:00')?>
							</div>
						</div>
					</div>				
				</div>	
			</div>

			<div class="panel panel-info" <?php  if($checksetinfo['friday'] == 0 ) { ?>style="display:none"<?php  } ?>>
				<div class="panel-heading">周五时段设置</div>
				<div class="panel-body">
					<div class="form-group">
						<label class="col-xs-12 col-sm-3 col-md-2 control-label">时段1</label>
						<div class="col-sm-9 col-xs-9 col-md-4">
							<div class="input-group clockpicker" style="margin-bottom: 15px">
								<?php echo tpl_form_field_clock('fri_start1', $fridayset[0]['start']?$fridayset[0]['start']:'00:00')?>
								<span class="input-group-addon">至</span>
								<?php echo tpl_form_field_clock('fri_end1', $fridayset[0]['end']? $fridayset[0]['end']:'00:00')?>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label class="col-xs-12 col-sm-3 col-md-2 control-label">时段2</label>
						<div class="col-sm-9 col-xs-9 col-md-4">
							<div class="input-group clockpicker" style="margin-bottom: 15px">
								<?php echo tpl_form_field_clock('fri_start2', $fridayset[1]['start']?$fridayset[1]['start']:'00:00')?>
								<span class="input-group-addon">至</span>
								<?php echo tpl_form_field_clock('fri_end2', $fridayset[1]['end']?$fridayset[1]['end']:'00:00')?>
							</div>
						</div>
					</div>
					<div class="form-group"> 
						<label class="col-xs-12 col-sm-3 col-md-2 control-label">时段3</label>
						<div class="col-sm-9 col-xs-9 col-md-4">
							<div class="input-group clockpicker" style="margin-bottom: 15px">
								<?php echo tpl_form_field_clock('fri_start3', $fridayset[2]['start']?$fridayset[2]['start']:'00:00')?>
								<span class="input-group-addon">至</span>
								<?php echo tpl_form_field_clock('fri_end3', $fridayset[2]['end']?$fridayset[2]['end']:'00:00')?>
							</div>
						</div>
					</div>
					<div class="form-group"> 
						<label class="col-xs-12 col-sm-3 col-md-2 control-label">时段4</label>
						<div class="col-sm-9 col-xs-9 col-md-4">
							<div class="input-group clockpicker" style="margin-bottom: 15px">
								<?php echo tpl_form_field_clock('fri_start4', $fridayset[3]['start']? $fridayset[3]['start']:'00:00')?>
								<span class="input-group-addon">至</span>
								<?php echo tpl_form_field_clock('fri_end4', $fridayset[3]['end']?$fridayset[3]['end']:'00:00')?>
							</div>
						</div>
					</div>
					<div class="form-group"> 
						<label class="col-xs-12 col-sm-3 col-md-2 control-label">时段5</label>
						<div class="col-sm-9 col-xs-9 col-md-4">
							<div class="input-group clockpicker" style="margin-bottom: 15px">
								<?php echo tpl_form_field_clock('fri_start5', $fridayset[4]['start']?$fridayset[4]['start']:'00:00')?>
								<span class="input-group-addon">至</span>
								<?php echo tpl_form_field_clock('fri_end5', $fridayset[4]['end']?$fridayset[4]['end']:'00:00')?>
							</div>
						</div>
					</div>				
				</div>	
			</div>
			
			<div class="panel panel-info" <?php  if($checksetinfo['saturday'] == 0 ) { ?>style="display:none"<?php  } ?>>
				<div class="panel-heading">周六时段设置</div>
				<div class="panel-body">
					<div class="form-group">
						<label class="col-xs-12 col-sm-3 col-md-2 control-label">时段1</label>
						<div class="col-sm-9 col-xs-9 col-md-4">
							<div class="input-group clockpicker" style="margin-bottom: 15px">
								<?php echo tpl_form_field_clock('satur_start1', $saturdayset[0]['start']?$saturdayset[0]['start']:'00:00')?>
								<span class="input-group-addon">至</span>
								<?php echo tpl_form_field_clock('satur_end1', $saturdayset[0]['end']?$saturdayset[0]['end']:'00:00')?>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label class="col-xs-12 col-sm-3 col-md-2 control-label">时段2</label>
						<div class="col-sm-9 col-xs-9 col-md-4">
							<div class="input-group clockpicker" style="margin-bottom: 15px">
								<?php echo tpl_form_field_clock('satur_start2', $saturdayset[1]['start']?$saturdayset[1]['start']:'00:00')?>
								<span class="input-group-addon">至</span>
								<?php echo tpl_form_field_clock('satur_end2', $saturdayset[1]['end']?$saturdayset[1]['end']:'00:00')?>
							</div>
						</div>
					</div>
					<div class="form-group"> 
						<label class="col-xs-12 col-sm-3 col-md-2 control-label">时段3</label>
						<div class="col-sm-9 col-xs-9 col-md-4">
							<div class="input-group clockpicker" style="margin-bottom: 15px">
								<?php echo tpl_form_field_clock('satur_start3', $saturdayset[2]['start']?$saturdayset[2]['start']:'00:00')?>
								<span class="input-group-addon">至</span>
								<?php echo tpl_form_field_clock('satur_end3', $saturdayset[2]['end']?$saturdayset[2]['end']:'00:00')?>
							</div>
						</div>
					</div>
					<div class="form-group"> 
						<label class="col-xs-12 col-sm-3 col-md-2 control-label">时段4</label>
						<div class="col-sm-9 col-xs-9 col-md-4">
							<div class="input-group clockpicker" style="margin-bottom: 15px">
								<?php echo tpl_form_field_clock('satur_start4', $saturdayset[3]['start']?$saturdayset[3]['start']:'00:00')?>
								<span class="input-group-addon">至</span>
								<?php echo tpl_form_field_clock('satur_end4', $saturdayset[3]['end']?$saturdayset[3]['end']:'00:00')?>
							</div>
						</div>
					</div>
					<div class="form-group"> 
						<label class="col-xs-12 col-sm-3 col-md-2 control-label">时段5</label>
						<div class="col-sm-9 col-xs-9 col-md-4">
							<div class="input-group clockpicker" style="margin-bottom: 15px">
								<?php echo tpl_form_field_clock('satur_start5', $saturdayset[4]['start']?$saturdayset[4]['start']:'00:00')?>
								<span class="input-group-addon">至</span>
								<?php echo tpl_form_field_clock('satur_end5', $saturdayset[4]['end']?$saturdayset[4]['end']:'00:00')?>
							</div>
						</div>
					</div>				
				</div>	
			</div>
			
			<div class="panel panel-info" <?php  if($checksetinfo['sunday'] == 0 ) { ?>style="display:none"<?php  } ?>>
				<div class="panel-heading">周日时段设置</div>
				<div class="panel-body">
					<div class="form-group">
						<label class="col-xs-12 col-sm-3 col-md-2 control-label">时段1</label>
						<div class="col-sm-9 col-xs-9 col-md-4">
							<div class="input-group clockpicker" style="margin-bottom: 15px">
								<?php echo tpl_form_field_clock('sun_start1', $sundayset[0]['start']?$sundayset[0]['start']:'00:00')?>
								<span class="input-group-addon">至</span>
								<?php echo tpl_form_field_clock('sun_end1', $sundayset[0]['end']?$sundayset[0]['end']:'00:00')?>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label class="col-xs-12 col-sm-3 col-md-2 control-label">时段2</label>
						<div class="col-sm-9 col-xs-9 col-md-4">
							<div class="input-group clockpicker" style="margin-bottom: 15px">
								<?php echo tpl_form_field_clock('sun_start2', $sundayset[1]['start']?$sundayset[1]['start']:'00:00')?>
								<span class="input-group-addon">至</span>
								<?php echo tpl_form_field_clock('sun_end2', $sundayset[1]['end']?$sundayset[1]['end']:'00:00')?>
							</div>
						</div>
					</div>
					<div class="form-group"> 
						<label class="col-xs-12 col-sm-3 col-md-2 control-label">时段3</label>
						<div class="col-sm-9 col-xs-9 col-md-4">
							<div class="input-group clockpicker" style="margin-bottom: 15px">
								<?php echo tpl_form_field_clock('sun_start3', $sundayset[2]['start']?$sundayset[2]['start']:'00:00')?>
								<span class="input-group-addon">至</span>
								<?php echo tpl_form_field_clock('sun_end3', $sundayset[2]['end']?$sundayset[2]['end']:'00:00')?>
							</div>
						</div>
					</div>
					<div class="form-group"> 
						<label class="col-xs-12 col-sm-3 col-md-2 control-label">时段4</label>
						<div class="col-sm-9 col-xs-9 col-md-4">
							<div class="input-group clockpicker" style="margin-bottom: 15px">
								<?php echo tpl_form_field_clock('sun_start4', $sundayset[3]['start']?$sundayset[3]['start']:'00:00')?>
								<span class="input-group-addon">至</span>
								<?php echo tpl_form_field_clock('sun_end4', $sundayset[3]['end']?$sundayset[3]['end']:'00:00')?>
							</div>
						</div>
					</div>
					<div class="form-group"> 
						<label class="col-xs-12 col-sm-3 col-md-2 control-label">时段5</label>
						<div class="col-sm-9 col-xs-9 col-md-4">
							<div class="input-group clockpicker" style="margin-bottom: 15px">
								<?php echo tpl_form_field_clock('sun_start5', $sundayset[4]['start']?$sundayset[4]['start']:'00:00')?>
								<span class="input-group-addon">至</span>
								<?php echo tpl_form_field_clock('sun_end5', $sundayset[4]['end']?$sundayset[4]['end']:'00:00')?>
							</div>
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
$(function(){
	$("input[class='form-control']").attr("readonly","readonly");
});
 
 	
</script>

