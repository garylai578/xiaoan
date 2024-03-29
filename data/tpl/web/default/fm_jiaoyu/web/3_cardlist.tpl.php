<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('public/header', TEMPLATE_INCLUDEPATH)) : (include template('public/header', TEMPLATE_INCLUDEPATH));?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('public/comhead', TEMPLATE_INCLUDEPATH)) : (include template('public/comhead', TEMPLATE_INCLUDEPATH));?>
<ul class="nav nav-tabs">
    <li class="<?php  if($operation == 'display') { ?>active<?php  } ?>"><a href="<?php  echo $this->createWebUrl('cardlist', array('op' => 'display', 'schoolid' => $schoolid))?>">卡库</a></li>
    <li class="<?php  if($operation == 'recording') { ?>active<?php  } ?>"><a href="<?php  echo $this->createWebUrl('cardlist', array('op' => 'recording', 'schoolid' => $schoolid))?>">录卡</a></li>
</ul>
<?php  if($operation == 'recording') { ?>
<div class="main">
 <style>
.form-control-excel { height: 34px;padding: 6px 12px;font-size: 14px;line-height: 1.42857143;color: #555;background-color: #fff;background-image: none; border: 1px solid #ccc;border-radius: 4px; -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075);box-shadow: inset 0 1px 1px rgba(0,0,0,.075);-webkit-transition: border-color ease-in-out .15s,-webkit-box-shadow ease-in-out .15s;-o-transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;}
.cLine {overflow: hidden;padding: 5px 0;color:#000000;}
.alert {padding: 8px 35px 0 10px;text-shadow: none;-webkit-box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);-moz-box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);background-color: #f9edbe;border: 1px solid #f0c36d;-webkit-border-radius: 2px;-moz-border-radius: 2px;border-radius: 2px;color: #333333;margin-top: 5px;}
.alert p {margin: 0 0 10px;display: block;}
.alert .bold{font-weight:bold;}		
</style>	
    <div class="panel panel-info">
        <div class="panel-heading">快速录卡-条件设置</div>
        <div class="panel-body">
			<div class="form-group">	
				<label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label" style="width: 100px;">按班级</label>
				<div class="col-sm-2 col-lg-2">
					<select style="margin-right:15px;" name="bj_id" id="chosebj" class="form-control">
						<option value="0">请选择班级搜索</option>
						<?php  if(is_array($allbjlist)) { foreach($allbjlist as $row) { ?>
						<option value="<?php  echo $row['sid'];?>" <?php  if($row['sid'] == $_GPC['bj_id']) { ?> selected="selected"<?php  } ?>><?php  echo $row['sname'];?><?php  echo $row['info'];?></option>
						<?php  } } ?>
					</select>
				</div>
				<?php  if($logo['is_cardlist'] != 1 || $_W['isfounder'] || $_W['role'] == 'owner' || $logo['is_cardpay'] != 1) { ?>
				<label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label" style="width: 100px;">到期时间</label>
				<div class="col-sm-2 col-lg-2" id="sever">
					<?php  echo tpl_form_field_date('severend', date('Y-m-d'))?>
					<div class="help-block">统一到期时间</div>
				</div>
				<?php  } ?>
				<?php  if($logo['is_cardlist'] != 1 || $_W['isfounder'] || $_W['role'] == 'owner') { ?>
				<label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label" style="width: 100px;">导入空卡</label>
				<div class="col-sm-2 col-lg-2">
					<div class="input-group">
						<input class="form-control inupt_empty" id="card_empty" placeholder="刷卡" onpropertychange="OnPropChanged(event)" type="text" value="" />
					</div>
					<div class="help-block">注意:已经绑定的卡在此处刷卡将会删除绑定信息</div>
				</div>
				<?php  } ?>
			</div>
        </div>
    </div>
	<div class="cLine">
		<div class="alert">
			<p id="empty_cardlist"></p>
		</div>
	</div>
	<div class="cLine">
		<div class="alert">
			<p><span class="bold">提示：</span>请连接读卡器使用快速录卡功能</br>   
			   <?php  if($_W['isfounder'] || $_W['role'] == 'owner') { ?><strong><font color='red'>特别提醒: 要让此卡片库生效必须由管理员在学校考勤设置里设置启用状态!----此句只限管理员查看，其他人看不到</font></strong></br>
			   <font color='red'>录卡说明: 管理员身份在本页可任意录制卡考给学生，如果不限制学校卡库，学校也可以在此页面任意录制卡号，否则校方只能录入由管理员提供的空卡，且管理已提前录入到本校卡库中</font></strong></br><font color='red'>时间提示: 如本校已经启用考勤卡付费设置、顶部的统一时间将无效，以本校考勤卡付费设置的时间为准</font></strong></br><font color='red'>温馨提示: 如果本校尚未启用考勤卡付费和卡库功能：新卡绑定卡的到期时间以顶部设置为准，如卡已在系统空卡库中，则以空卡设置的服务到期时间为准</font></strong><?php  } ?>
			</p>
		</div>
	</div>		
    <div class="panel panel-default" style="width:50%">
        <div class="table-responsive panel-body">
			<input type="hidden" name="schoolid" value="<?php  echo $schoolid;?>" />
			<table class="table table-hover">
				<thead class="navbar-inner">
					<tr>
						<th style="width:2%">学生/老师姓名</th>
						<th style="width:3%">班级</th>
						<th style="width:10%">已绑卡</th>
						<th style="width:4%">输入持卡人</th>
						<th style="width:4%">选择关系</th>
						<th style="text-align:right; width:8%;">录入新卡</th>
					</tr>
				</thead>
				<tbody>
				<?php  if($stulist) { ?>
					<?php  if(is_array($stulist)) { foreach($stulist as $index => $item) { ?>
					<tr id="stu<?php  echo $item['id'];?>">
						<td>
							<img style="width:35px;height:35px;border-radius:50%;" src="<?php  echo $item['icon'];?>" width="50"  style="border-radius: 3px;" /></br><?php  echo $item['s_name'];?>
						</td>
						<td><?php  echo $nowbj['sname'];?></td>
						<td id="cardlist<?php  echo $item['id'];?>">
						<?php  if($item['cards']) { ?>
							<?php  if(is_array($item['cards'])) { foreach($item['cards'] as $row) { ?>
								卡号:<?php  echo $row['idcard'];?>,持卡人:<?php  echo $row['pname'];?>(<?php  echo getpardforkqj($row['pard'])?>)
								<?php  if($row['severend'] > TIMESTAMP) { ?>
									<span class="label label-success">服务中</span>
								<?php  } else { ?>
									<span class="label label-danger">已过期</span>
								<?php  } ?>
								</br>
							<?php  } } ?>
						<?php  } ?>
						</td>
						<td><div class="input-group"><input placeholder="输入持卡人姓名" type="text" id="pname<?php  echo $item['id'];?>" class="form-control" value="<?php  echo $item['s_name'];?>" /></div></td>
						<td>
							<select style="margin-right:15px;" name="pard" id="pard<?php  echo $item['id'];?>" class="form-control">
							<?php  if(is_array($allguanxi)) { foreach($allguanxi as $key => $row) { ?>
							<option value="<?php  echo $key;?>"><?php  echo $row;?></option>
							<?php  } } ?>
							</select>
						</td>
						<td style="text-align:right;float:right">
							<div class="input-group">
								<input class="form-control inupt_val" id="card<?php  echo $index;?>" placeholder="刷卡" data_sid="<?php  echo $item['id'];?>" data_key="<?php  echo $index;?>" onpropertychange="OnPropChanged(event)" type="text" value="" />
							</div>
						</td>
					</tr>
					<?php  } } ?>
				<?php  } ?>	
				</tbody>
			</table>
        </div>
    </div>
</div>
<script type="text/javascript">
$(function(){
	$(".inupt_empty").bind("input propertychange",function(event){
		   var idcard = $(this).val();
		   var severend = $("#sever").find('input[name="severend"]').val();
		   if(idcard.length >= 10){
				$.ajax({
					url: "<?php  echo $this->createWebUrl('cardlist', array('schoolid' => $schoolid))?>",
					type: "post",
					dataType: "json",
					data: {
						op:"writecard",
						severend,severend,
						idcard:idcard
					},
					success: function (data) {
						if (data.result) {
							alert(data.msg);
							var html = "卡号:"+idcard+"<span class='label label-success'>到期:"+severend+"</span></br>";
							$("#empty_cardlist").append(html);
							$("#card_empty").val("");
							$("#card_empty").focus();
						}else{
							alert(data.msg);
							$("#card_empty").val("");
							$("#card_empty").focus();
						}
					}		
				});

		   }
	});
	$(".inupt_val").bind("input propertychange",function(event){
		   var idcard = $(this).val();
		   var severend = $("#sever").find('input[name="severend"]').val();
		   if(idcard.length >= 10){
				var sid = $(this).attr('data_sid');
				var key = $(this).attr('data_key');
				var nextkey = key*1+1;
				var pname = $("#pname"+sid).val();
				var pard = $("#pard"+sid).val();
				$.ajax({
					url: "<?php  echo $this->createWebUrl('cardlist', array('schoolid' => $schoolid))?>",
					type: "post",
					dataType: "json",
					data: {
						op:"getcardinfo",
						sid: sid,
						pname:pname,
						pard:pard,
						severend,severend,
						idcard:idcard,
						bj_id:"<?php  echo $bj_id;?>"
					},
					success: function (data) {
						if (data.result) {
							var html = "卡号:"+idcard+"持卡人:"+pname+"<span class='label label-success'>服务中</span></br>";
							$("#cardlist"+sid).append(html);
							$(this).val("");
							alert(data.msg);
							$("#card"+nextkey).focus(); 
						}else{
							alert(data.msg);
							$("#card"+key).val("");
						}
					}		
				});
		   }
	});
	$(document).ready(function() {
		$("#chosebj").change(function() {
			var BjId = $("#chosebj option:selected").attr('value');
			if(BjId != 0){
				window.location.href="<?php  echo $this->createWebUrl('cardlist', array('op' => 'recording','schoolid' => $schoolid))?>"+'&bj_id='+BjId; 
			}
		});		
	});	
});
</script>
<?php  } else if($operation == 'display') { ?>
<div class="main">
 <style>
.form-control-excel { height: 34px;padding: 6px 12px;font-size: 14px;line-height: 1.42857143;color: #555;background-color: #fff;background-image: none; border: 1px solid #ccc;border-radius: 4px; -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075);box-shadow: inset 0 1px 1px rgba(0,0,0,.075);-webkit-transition: border-color ease-in-out .15s,-webkit-box-shadow ease-in-out .15s;-o-transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;}
.cLine {overflow: hidden;padding: 5px 0;color:#000000;}
.alert {padding: 8px 35px 0 10px;text-shadow: none;-webkit-box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);-moz-box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);background-color: #f9edbe;border: 1px solid #f0c36d;-webkit-border-radius: 2px;-moz-border-radius: 2px;border-radius: 2px;color: #333333;margin-top: 5px;}
.alert p {margin: 0 0 10px;display: block;}
.alert .bold{font-weight:bold;}		
</style>	
    <div class="panel panel-info">
        <div class="panel-heading">考勤卡管理</div>
        <div class="panel-body">
            <form action="./index.php" method="get" class="form-horizontal" role="form">
                <input type="hidden" name="c" value="site" />
                <input type="hidden" name="a" value="entry" />
                <input type="hidden" name="m" value="fm_jiaoyu" />
                <input type="hidden" name="do" value="cardlist" />
				<input type="hidden" name="schoolid" value="<?php  echo $schoolid;?>" />
                <div class="form-group">
                    <label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label" style="width: 100px;">按卡号</label>
                    <div class="col-sm-2 col-lg-2">
                        <input class="form-control" name="idcard" id="" type="text" value="<?php  echo $_GPC['idcard'];?>">
                    </div>
                    <label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label" style="width: 100px;">按学生名</label>
                    <div class="col-sm-2 col-lg-2">
                        <input class="form-control" name="s_name" id="" type="text" value="<?php  echo $_GPC['s_name'];?>">
                    </div>
                    <label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label" style="width: 100px;">按老师名</label>
                    <div class="col-sm-2 col-lg-2">
                        <input class="form-control" name="tname" id="" type="text" value="<?php  echo $_GPC['tname'];?>">
                    </div>
					<?php  if($_W['isfounder'] || $_W['role'] == 'owner') { ?>
                    <label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label" style="width: 100px;">卡库状态</label>
                    <div class="col-sm-2 col-lg-2">
					<?php  if($logo['is_cardlist'] == 1) { ?>
                        <a class="btn btn-primary">启用中 <i class="fa fa-spinner"></i></a>
					<?php  } else { ?>
						<a class="btn btn-primary">未启用<i class="fa fa-circle-o-notch"></i></a>
					<?php  } ?>
                    </div>
					<?php  } ?>	
				</div>
				<div class="form-group">	
					<label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label" style="width: 100px;">按身份</label>
                    <div class="col-sm-2 col-lg-2">
						<select style="margin-right:15px;" name="type" class="form-control">
							<option value="0">不限</option>
							<option value="1" <?php  if($_GPC['type'] == 1) { ?> selected="selected"<?php  } ?>>学生</option>
							<option value="2" <?php  if($_GPC['type'] == 2) { ?> selected="selected"<?php  } ?>>老师</option>
							<option value="3" <?php  if($_GPC['type'] == 3) { ?> selected="selected"<?php  } ?>>未绑定</option>
						</select>
                    </div>
					<label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label" style="width: 100px;">按班级</label>
                    <div class="col-sm-2 col-lg-2">
                        <select style="margin-right:15px;" name="bj_id" class="form-control">
                            <option value="0">请选择班级搜索</option>
                            <?php  if(is_array($bj)) { foreach($bj as $row) { ?>
                            <option value="<?php  echo $row['sid'];?>" <?php  if($row['sid'] == $_GPC['bj_id']) { ?> selected="selected"<?php  } ?>><?php  echo $row['sname'];?></option>
                            <?php  } } ?>
                        </select>
                    </div>
                    <div class="col-sm-2 col-lg-2">
                        <button class="btn btn-default"><i class="fa fa-search"></i>搜索</button>
					</div>	
					<div class="col-sm-2 col-lg-2">
						<?php  if($_W['isfounder'] || $_W['role'] == 'owner' || $logo['is_cardlist'] == 2) { ?><a class="btn btn-success" href="javascript:;" onclick="$('.file-container').slideToggle()">批量导卡<?php  if($_W['isfounder'] || $_W['role'] == 'owner') { ?>(管理员专用)<?php  } ?></a><?php  } ?>
						<?php  if($_W['isfounder'] || $_W['role'] == 'owner') { ?><div class="help-block">卡库功能未启用状态学校可直接添加卡</div><?php  } ?>
                    </div>
					<?php  if($_W['isfounder'] || $_W['role'] == 'owner' || $logo['is_cardlist'] == 1) { ?>
					<div class="col-sm-2 col-lg-2">
						<a class="btn btn-success qx_2503" href="javascript:;" onclick="$('.file-container1').slideToggle()">批量导卡<?php  if($_W['isfounder'] || $_W['role'] == 'owner') { ?>(学校专用)<?php  } ?></a>
						<?php  if($_W['isfounder'] || $_W['role'] == 'owner') { ?><div class="help-block">卡库功能启用中时学校只能下载空卡库然后导入卡</div><?php  } ?>
                    </div>	
					<?php  } ?>	
				</div>	
            </form>
			<div class="alert we7-page-alert">
				<?php  if($_GPC['bj_id']) { ?>
					<p><i class="wi wi-info-sign"></i> 本班绑卡:<strong class="text-danger"><?php  echo $total;?>张</strong>.</p>				
				<?php  } else { ?>
					<p><i class="wi wi-info-sign"></i> 共计卡片数:<strong class="text-danger"><?php  echo $total;?>张</strong>.学生绑卡数:<strong class="text-danger"><?php  echo $xskshl;?>张</strong>.老师绑卡数:<strong class="text-danger"><?php  echo $jskshl;?>张</strong>.空卡数:<strong class="text-danger"><?php  echo $kksm;?>张</strong></p>
				<?php  } ?>
			</div>			
        </div>
    </div>
	<div class="cLine">
		<div class="alert">
			<p><span class="bold">提示：</span>所有卡号只能是由本库提供，未被包含在本库的卡号将无法在本平台微信端绑定和使用</br>   
			   <?php  if($_W['isfounder'] || $_W['role'] == 'owner') { ?><strong><font color='red'>特别提醒: 要让此卡片库生效必须由管理员在学校考勤设置里设置启用状态!----此句只限管理员查看，其他人看不到</font></strong></br><?php  } ?>
			</p>
		</div>
	</div>
    <div class="panel panel-default file-container" style="display:none;">
        <div class="panel-body">
            <form id="form">
                <input name="viewfile" id="viewfile" type="text" value="" style="margin-left: 40px;" class="form-control-excel" readonly>
                <a class="btn btn-primary"><label for="unload" style="margin: 0px;padding: 0px;">上传...</label></a>
                <input type="file" class="pull-left btn-primary span3" name="file" id="unload" style="display: none;"
                       onchange="document.getElementById('viewfile').value=this.value;this.style.display='none';">
                <a class="btn btn-primary" onclick="submits('input_card','form');">导入数据</a>
                <a class="btn btn-info" href="../addons/fm_jiaoyu/public/example/example_cardlist.xls"><i class="fa fa-download"></i>下载导入模板</a>
            </form>
        </div>
    </div>
    <div class="panel panel-default file-container1" style="display:none;">
        <div class="panel-body">
            <form id="form1">
                <input name="viewfile1" id="viewfile1" type="text" value="" style="margin-left: 40px;" class="form-control-excel" readonly>
                <a class="btn btn-warning"><label for="unload1" style="margin: 0px;padding: 0px;">上传...</label></a>
                <input type="file" class="pull-left btn-primary span3" name="file1" id="unload1" style="display: none;" onchange="document.getElementById('viewfile1').value=this.value;this.style.display='none';">
                <a class="btn btn-danger" onclick="submits('input_cardschool','form1');">导入数据</a>
				<a class="btn btn-primary" href="../addons/fm_jiaoyu/public/example/example_cardlist1.xls">下载导入模板</a>
				<a class="btn btn-info" href="<?php  echo $this->createWebUrl('cardlist', array('out_put' => 'out_put', 'schoolid' => $schoolid))?>"><i class="fa fa-download"></i>下载空卡库</a>
            </form>
        </div>
    </div>
	<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('public/excel_input', TEMPLATE_INCLUDEPATH)) : (include template('public/excel_input', TEMPLATE_INCLUDEPATH));?>
    <div class="panel panel-default">
        <div class="table-responsive panel-body">
        <form action="" method="post" class="form-horizontal form" enctype="multipart/form-data">
		<input type="hidden" name="schoolid" value="<?php  echo $schoolid;?>" />
        <table class="table table-hover">
			<thead class="navbar-inner">
				<tr>
                    <th class='with-checkbox' style="width: 3%;"><input type="checkbox" class="check_all" /></th>
					<th style="width:5%">卡号</th>
					<th style="width:5%">持卡人</th>
					<th style="width:5%">学生</th>
					<th style="width:5%">老师</th>
					<th style="width:4%;">绑定关系</th>
					<th style="width:4%;">班级</th>
                    <th style="width:8%;">使用总计</th>
					<th style="width:8%;">绑定时间</th>
					<th style="width:8%;">服务截至时间</th>
					<th class="qx_2504" style="width:5%;"></th>					
					<th class="qx_e_d" style="text-align:right; width:8%;">操作</th>
				</tr>
			</thead>
			<tbody>
				<?php  if(is_array($list)) { foreach($list as $item) { ?>
				<tr>
                    <td class="with-checkbox"><input type="checkbox" name="check" value="<?php  echo $item['id'];?>"></td>
					<td>
                       <span class="label label-info"><?php  echo $item['idcard'];?></span>
                    </td>
					<td>
					<?php  if(!empty($item['pname'])) { ?>
                        <img style="width:35px;height:35px;border-radius:50%;" src="<?php  if($item['scardicon']) { ?><?php  echo $item['scardicon'];?><?php  } ?><?php  if($item['tcardicon']) { ?><?php  echo $item['tcardicon'];?><?php  } ?>" width="50"  style="border-radius: 3px;" /></br><?php  echo $item['pname'];?>
					<?php  } ?>				
					</td>
					<td><?php  if($item['s_name']) { ?><img style="width:35px;height:35px;border-radius:50%;" src="<?php  if($item['sid']) { ?><?php  echo $item['sicon'];?><?php  } ?>" width="50"  style="border-radius: 3px;" /></br><?php  echo $item['s_name'];?><?php  } ?></td>
					<td><?php  if($item['tname']) { ?><img style="width:35px;height:35px;border-radius:50%;" src="<?php  if($item['tid']) { ?><?php  echo $item['ticon'];?><?php  } ?>" width="50"  style="border-radius: 3px;" /></br><?php  echo $item['tname'];?></td><?php  } ?>
					<td>
					<?php  if(!empty($item['pard'])) { ?>
						<span class="label label-success">
								<?php  if($item['pard'] ==1) { ?>本人<?php  } ?>
								<?php  if($item['pard'] ==2) { ?>母亲<?php  } ?>
								<?php  if($item['pard'] ==3) { ?>父亲<?php  } ?>
								<?php  if($item['pard'] ==4) { ?>爷爷<?php  } ?>
								<?php  if($item['pard'] ==5) { ?>奶奶<?php  } ?>
								<?php  if($item['pard'] ==6) { ?>外公<?php  } ?>
								<?php  if($item['pard'] ==7) { ?>外婆<?php  } ?>
								<?php  if($item['pard'] ==8) { ?>叔叔<?php  } ?>
								<?php  if($item['pard'] ==9) { ?>阿姨<?php  } ?>
								<?php  if($item['pard'] ==10) { ?>其他<?php  } ?>
						</span>
					<?php  } ?>
                    </td>					
					<td><?php  echo $item['bjname'];?></td>
					<td>
                        <?php  if(empty($item['sid']) && empty($item['tid'])) { ?><span class="label label-danger">未绑定</span><?php  } else { ?><?php  if(!empty($item['num'])) { ?><span class="label label-success"><?php  echo $item['num'];?>次</span><?php  } else { ?><span class="label label-success">0次</span><?php  } ?><?php  } ?>
                    </td>
                    <td>
                        <?php  if(!empty($item['createtime'])) { ?><?php  echo date('Y-m-d', $item['createtime'])?><?php  } else { ?><span class="label label-danger">未绑定</span><?php  } ?>
                    </td>
                    <td>
                        <?php  if(!empty($item['severend'])) { ?>
							<?php  if(TIMESTAMP>$item['severend']) { ?><span class="label label-danger">服务到期</span><?php  } else { ?><?php  echo date('Y-m-d', $item['severend'])?><?php  } ?>
						<?php  } else { ?>
							<span class="label label-danger">未设置</span>
						<?php  } ?>
                    </td>
					<td class="qx_2504">
					<?php  if(empty($item['sid']) && empty($item['tid'])) { ?><span class="label label-danger">未绑定</span><?php  } else { ?>
						<a class="btn btn-default btn-sm" href="<?php  echo $this->createWebUrl('cardlist', array('id' => $item['id'], 'op' => 'jiebang', 'schoolid' => $schoolid))?>" onclick="return confirm('此操作不可恢复，确认解绑？');return false;" title="解绑"><i class="fa fa-times"></i>&nbsp;解绑</a>
					<?php  } ?>	
					</td>		
					<td class="qx_e_d" style="text-align:right;">
						<a class="btn btn-default btn-sm qx_2502" href="<?php  echo $this->createWebUrl('cardlist', array('id' => $item['id'], 'op' => 'post', 'schoolid' => $schoolid))?>" title="编辑"><i class="fa fa-pencil"></i></a>&nbsp;&nbsp;<a class="btn btn-default btn-sm qx_2505" href="<?php  echo $this->createWebUrl('cardlist', array('id' => $item['id'], 'op' => 'delete', 'schoolid' => $schoolid))?>" onclick="return confirm('此操作不可恢复，确认删除？');return false;" title="删除"><i class="fa fa-times"></i></a>
					</td>
				</tr>
				<?php  } } ?>
			</tbody>
			<tr>
				<td colspan="10">
				<?php  if($_W['isfounder'] || $_W['role'] == 'owner' || $logo['is_cardlist'] == 2) { ?>
				    <div class="col-sm-2 col-lg-2" style="width:20%">
						<?php  echo tpl_form_field_date('setendtime', date('Y-m-d'))?>
						<?php  if($_W['isfounder'] || $_W['role'] == 'owner') { ?><div class="help-block">卡库未启用情况下学校有权自主修改</div><?php  } ?>
                    </div>						
					<input type="button" class="btn btn-primary" name="change_endtime" value="修改到期时间" />
				<?php  } ?>
					<input name="token" type="hidden" value="<?php  echo $_W['token'];?>" />
                    <input type="button" class="btn btn-primary qx_2505" name="btndeleteall" value="批量删除" />
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
	<?php  if((!(IsHasQx($tid_global,1002502,1,$schoolid)))) { ?>
		$(".qx_2502").hide();
		e_d = e_d - 1 ;
	<?php  } ?>
	<?php  if((!(IsHasQx($tid_global,1002503,1,$schoolid)))) { ?>
		$(".qx_2503").hide();
	<?php  } ?>
	<?php  if((!(IsHasQx($tid_global,1002504,1,$schoolid)))) { ?>
		$(".qx_2504").hide();
	<?php  } ?>
	<?php  if((!(IsHasQx($tid_global,1002505,1,$schoolid)))) { ?>
		$(".qx_2505").hide();
		e_d = e_d - 1 ;
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
            alert('请选择要删除的卡号!');
            return false;
        }
        if(confirm("确认要删除选择的卡号?")){
            var id = new Array();
            check.each(function(i){
                id[i] = $(this).val();
            });
            var url = "<?php  echo $this->createWebUrl('cardlist', array('op' => 'deleteall','schoolid' => $schoolid))?>";
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
    $("input[name=change_endtime]").click(function(){
        var check = $("input[type=checkbox][class!=check_all]:checked");
        if(check.length < 1){
            alert('请选择要修改的卡号!');
            return false;
        }
		var setendtime = $("input[name=setendtime]").val();
		if(setendtime == null || setendtime == 0 || setendtime == ""){
			alert('请设置到期时间!');
			return false;
		}
        if(confirm("您确认要修改选中卡的到期时间吗？")){
            var id = new Array();
            check.each(function(i){
                id[i] = $(this).val();
            });
            var url = "<?php  echo $this->createWebUrl('cardlist', array('op' => 'change_endtime', 'schoolid' => $schoolid))?>";
            $.post(
                url,
                {idArr:id,setendtime:setendtime},
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
                修改卡信息
            </div>
            <div class="panel-body">
				<?php  if(!empty($item['sid']) || !empty($item['tid'])) { ?>
					<?php  if(!empty($item['sid'])) { ?>
					<div class="form-group">
						<label class="col-xs-12 col-sm-3 col-md-2 control-label">学生姓名:</label>
						<div class="col-sm-9" style="color:red;">
						   <?php  echo $student['s_name'];?>
						</div>
					</div>
					<?php  } ?>
					<?php  if(!empty($item['tid'])) { ?>
					<div class="form-group">
						<label class="col-xs-12 col-sm-3 col-md-2 control-label">教师姓名:</label>
						<div class="col-sm-9" style="color:red;">
						   <?php  echo $teacher['tname'];?>
						</div>
					</div>
					<?php  } ?>
				<?php  } ?>
				<?php  if(!empty($item['bj_id'])) { ?>
					<div class="form-group">
						<label class="col-xs-12 col-sm-3 col-md-2 control-label">所在班级:</label>
						<div class="col-sm-9" style="color:red;">
							<?php  echo $bj['sname'];?>
						</div>
					</div>
				<?php  } ?>
				<?php  if($_W['isfounder'] || $_W['role'] == 'owner') { ?>
					<div class="form-group">
					   <label class="col-xs-12 col-sm-3 col-md-2 control-label">卡号来源</label>
						<div class="col-sm-2 col-lg-2">
							<label class="radio-inline">
								<input type="radio" name="" value="1" id="credit1">卡库
							</label>
							<label class="radio-inline">
								<input type="radio" name="" value="2" id="credit2">手动
							</label>
							<div class="help-block">卡库：从已导入的卡库中选择空卡更换</br>手动：手动输入卡号（不可与本卡库中卡号重复）</br>学校操作员只能从卡库中选择更换卡号</div>
						</div>
					</div>				
					<div id="credit-status1" style="display:block">
						<div class="form-group">
							<label class="col-xs-12 col-sm-3 col-md-2 control-label">卡号</label>
							<div class="col-sm-2 col-lg-2">
								<select class="form-control" name="idcard_kk">
									<option value="<?php  echo $item['idcard'];?>"><?php  echo $item['idcard'];?></option>
									<?php  if(is_array($allcard_no)) { foreach($allcard_no as $row) { ?>
									<option value="<?php  echo $row['idcard'];?>" ><?php  echo $row['idcard'];?></option>
									<?php  } } ?>
								</select>
								<div class="help-block">从考勤卡库选择空卡更换</div>
							</div>
						</div>	
					</div>
					<div id="credit-status2" style="display:none">
						<div class="form-group">
							<label class="col-xs-12 col-sm-3 col-md-2 control-label">卡号</label>
							<div class="col-sm-2 col-lg-2">
								<input type="text" name="idcard_sd" value="<?php  echo $reply['title'];?>" id="idcard" class="form-control" />
								<div class="help-block">输入卡号，不可与卡库中已导入的卡号重复</div>
							</div>
						</div>	
					</div>				
				<?php  } else { ?>
					<div class="form-group">
						<label class="col-xs-12 col-sm-3 col-md-2 control-label">卡号</label>
						<div class="col-sm-2 col-lg-2">
							<select class="form-control" name="idcard_kk">
								<option value="<?php  echo $item['idcard'];?>"><?php  echo $item['idcard'];?></option>
								<?php  if(is_array($allcard_no)) { foreach($allcard_no as $row) { ?>
								<option value="<?php  echo $row['idcard'];?>" ><?php  echo $row['idcard'];?></option>
								<?php  } } ?>
							</select>
							<div class="help-block">从考勤卡库选择</div>
						</div>
					</div>				
				<?php  } ?>				
				<div class="form-group">
                   <label class="col-xs-12 col-sm-3 col-md-2 control-label">服务截至时间</label>
                     <div class="col-sm-9"> 
				        <div class="input-group">
					  <?php  if(!empty($item['severend'])) { ?><?php  echo tpl_form_field_date('severend', date('Y-m-d', $item['severend']))?><?php  } else { ?><?php  echo tpl_form_field_date('severend', date('Y-m-d', TIMESTAMP))?><?php  } ?>
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
	$('#credit1').click(function(){
		$('#credit-status1').show();
		$('#credit-status2').hide();
		$("#credit1").attr("checked","checked" );
		$("#credit2").removeAttr("checked");
	});
	$('#credit2').click(function(){
		$('#credit-status2').show();
		$('#credit-status1').hide();
		$("#credit2").attr("checked","checked" );
		$("#credit1").removeAttr("checked");		
	});
</script>
<?php  } ?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('public/footer', TEMPLATE_INCLUDEPATH)) : (include template('public/footer', TEMPLATE_INCLUDEPATH));?>