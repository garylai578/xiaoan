<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('public/header', TEMPLATE_INCLUDEPATH)) : (include template('public/header', TEMPLATE_INCLUDEPATH));?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('public/comhead', TEMPLATE_INCLUDEPATH)) : (include template('public/comhead', TEMPLATE_INCLUDEPATH));?>

<?php  if($operation == 'post') { ?>
<form class="form-horizontal form" id="form1" action="" method="post" enctype="multipart/form-data">
	<div class="main">
		<div class="panel panel-default">
			<div class="panel-heading">添加考勤设备</div>
			<div class="panel-body">
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label"><span class="require">* </span>设备位置</label>
					<div class="col-sm-9 col-xs-12">
						<input type="text" class="form-control" name="name" value="<?php  echo $item['name'];?>" placeholder="填写考勤机位置">
						<div class="help-block">前端显示考勤地点用</div>
					</div>
				</div>
				<?php  if($_W['isfounder'] || $_W['role'] == 'owner') { ?>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label"><span class="require">* </span>设备品牌</label>
					<div class="col-sm-9 col-xs-12">
						<label class="radio-inline">
							<input type="radio" value="6" class="printer-type" name="macname"<?php  if($item['macname'] == '6') { ?>checked<?php  } ?> id="credit6" <?php  if($item && $item['macname'] != 6) { ?>disabled<?php  } ?>> 万能APP
							<span class="label label-danger">推荐</span>
							<span class="label label-success">兼容所有考勤机</span>
						</label>
						<?php  if(getoauthurl() == 'www.anqinschool.com') { ?>
						<label class="radio-inline">
							<input type="radio" value="1" class="printer-type" name="macname" <?php  if($item['macname'] == '1') { ?>checked<?php  } ?> id="credit1" <?php  if($item && $item['macname'] != 1) { ?>disabled<?php  } ?>> 吉联
						</label>
						<?php  } ?>
						<label class="radio-inline">
							<input type="radio" value="2" class="printer-type" name="macname" <?php  if($item['macname'] == '2') { ?>checked<?php  } ?> id="credit2" <?php  if($item && $item['macname'] != 2) { ?>disabled<?php  } ?>> 讯贞
							<span class="label label-success">推荐</span>
						</label>
						<label class="radio-inline">
							<input type="radio" value="3" class="printer-type" name="macname"<?php  if($item['macname'] == '3') { ?>checked<?php  } ?> id="credit3" <?php  if($item && $item['macname'] != 3) { ?>disabled<?php  } ?>> 优米
							<span class="label label-success">推荐</span>
						</label>
						<label class="radio-inline">
							<input type="radio" value="5" class="printer-type" name="macname"<?php  if($item['macname'] == '5') { ?>checked<?php  } ?> id="credit5" <?php  if($item && $item['macname'] != 5) { ?>disabled<?php  } ?>>护校通
							<span class="label label-success">推荐</span>
						</label>						
						<label class="radio-inline">
							<input type="radio" value="4" class="printer-type" name="macname"<?php  if($item['macname'] == '4') { ?>checked<?php  } ?> id="credit4" <?php  if($item && $item['macname'] != 4) { ?>disabled<?php  } ?>> 安宝贝
							<span class="label label-success">推荐</span>
						</label>							
					</div>
				</div>
				<?php  } else { ?>
				<input type="hidden" name="macname" value="<?php  echo $item['macname'];?>" />
				<input type="hidden" name="id" value="<?php  echo $id;?>" />
				<?php  } ?>
				<div id="credit-status0" <?php  if($item['macname'] == 1) { ?>style="display:block"<?php  } else { ?>style="display:none"<?php  } ?>>
					<div class="form-group">
						<label class="col-xs-12 col-sm-3 col-md-2 control-label"><span class="require">* </span>机器号/设备号</label>
						<div class="col-sm-9 col-xs-12">
							<?php  if(!$item) { ?>
							<input type="text" class="form-control" name="macid_jl" value="<?php  echo $item['macid'];?>" placeholder="填写机器/设备号">
							<div class="help-block">设备显示屏上获取/或设备背后</div>
							<?php  } else { ?>	
							<div class="help-block"><?php  echo $item['macid'];?>不可修改</div>	
							<input type="hidden" name="macid_jl" value="<?php  echo $item['macid'];?>">
							<?php  } ?>
						</div>
					</div>
					<div class="form-group">
						<label class="col-xs-12 col-sm-3 col-md-2 control-label"><span class="require">* </span>进离校区分</label>
						<div class="col-sm-2 col-lg-2">
							<select style="margin-right:15px;" name="type_jl" class="form-control">
								<option value="0">请选择</option>
								<option value="1" <?php  if($item['type'] ==1) { ?> selected="selected"<?php  } ?>>进校设备</option>
								<option value="2" <?php  if($item['type'] ==2) { ?> selected="selected"<?php  } ?>>离校设备</option>
							</select>
							<div class="help-block">双机准确判断进校离校/此设置必须添加2台设备来判断/一台选择进校/台选择为离校/不选择则使用考勤设置里的时间来判断进离校，不太准确</div>
						</div>
					</div>	
				</div>	
				<div id="credit-status1" <?php  if($item['macname'] == 2 || $item['macname'] == 5 || $item['macname'] == 6) { ?>style="display:block"<?php  } else { ?>style="display:none"<?php  } ?>>
					<div class="form-group">
						<label class="col-xs-12 col-sm-3 col-md-2 control-label"><span class="require">* </span>机器号/设备号</label>
						<div class="col-sm-9 col-xs-12">
							<?php  if(!$item) { ?>
								<input type="text" class="form-control" name="macid_xz" value="<?php  echo $item['macid'];?>" placeholder="填写机器号">
								<div class="help-block">考勤机显示屏上获取/或设备背后</div>
							<?php  } else { ?>
								<div class="help-block"><?php  echo $item['macid'];?>   不可修改</div>	
								<input type="hidden" name="macid_xz" value="<?php  echo $item['macid'];?>">
							<?php  } ?>
						</div>
					</div>
					<div id="credit-status66" <?php  if($item['macname'] == 6) { ?>style="display:block"<?php  } else { ?>style="display:none"<?php  } ?>>
						<div class="form-group">
							<label class="col-xs-12 col-sm-3 col-md-2 control-label"><span class="require">* </span>设备类型</label>
							<div class="col-sm-9 col-xs-12">
								<label class="radio-inline">
									<input type="radio" value="1" class="printer-type" name="is_bobao" <?php  if($item['is_bobao'] == '1' || empty($item['is_bobao'])) { ?>checked<?php  } ?> <?php  if($item && $item['is_bobao'] != 1) { ?>disabled<?php  } ?> id="credit7"> 考勤机
								</label>
								<label class="radio-inline">
									<input type="radio" value="2" class="printer-type" name="is_bobao" <?php  if($item['is_bobao'] == '2') { ?>checked<?php  } ?> <?php  if($item && $item['is_bobao'] != 2) { ?>disabled<?php  } ?> id="credit8"> 播报机
								</label>						
							</div>
						</div>	
						<div id="credit-status67" <?php  if($item['is_bobao'] == 2) { ?>style="display:block"<?php  } else { ?>style="display:none"<?php  } ?>>
							<div class="form-group">
								<label class="col-xs-12 col-sm-3 col-md-2 control-label"><span class="require">* </span>是否全校播报</label>
								<div class="col-sm-9 col-xs-12">
									<label class="radio-inline">
										<input type="radio" value="1" class="printer-type" name="is_master" <?php  if($item['is_master'] == '1' || empty($item['is_master'])) { ?>checked<?php  } ?> id="credit9"> 否
									</label>
									<label class="radio-inline">
										<input type="radio" value="2" class="printer-type" name="is_master" <?php  if($item['is_master'] == '2') { ?>checked<?php  } ?> id="credit10"> 是
									</label>						
								</div>
							</div>							
							<div id="credit-status69" <?php  if($item['is_master'] == 1 || empty($item['is_master'])) { ?>style="display:block"<?php  } else { ?>style="display:none"<?php  } ?>>
								<div class="form-group">
									<label class="col-xs-12 col-sm-3 col-md-2 control-label"><span class="require">* </span>分班播报绑定<?php  echo $classes;?></label>
									<div class="col-sm-2 col-lg-2">
										<select style="margin-right:15px;" name="bj_id" class="form-control">
											<option value="0">选择班级</option>
											<?php  if(is_array($class)) { foreach($class as $row) { ?>
											 <option value="<?php  echo $row['id'];?>" <?php  if($row['id'] ==$item['bj_id']) { ?> selected="selected"<?php  } ?>><?php  echo $row['classes'];?></option>
											<?php  } } ?>
										</select>
									</div>	
								</div>
							</div>	
							<div class="form-group">
								<label class="col-xs-12 col-sm-3 col-md-2 control-label"><span class="require">* </span>语音提示</label>
								<div class="col-sm-9 col-xs-12">
									<input type="text" class="form-control" name="VOICEPRE2" value="<?php  echo $banner['VOICEPRE2'];?>" placeholder="例如：[name]最喜欢的[relationship]来了">
									<div class="help-block">变量名含义，名称：[name] 关系：[relationship] </div>
								</div>
							</div>
						</div>	
					</div>
					<div id="credit-status21" <?php  if($item['macname'] == 2) { ?>style="display:block"<?php  } else { ?>style="display:none"<?php  } ?>>
						<div class="form-group">
							<label class="col-xs-12 col-sm-3 col-md-2 control-label"><span class="require">* </span>设备类型</label>
							<div class="col-sm-2 col-lg-2">
								<label class="radio-inline">
									<input type="radio" value="1" class="printer-type" name="is_bobao" <?php  if($item['is_bobao'] == '1' || empty($item['is_bobao'])) { ?>checked<?php  } ?> id="credit11" <?php  if($item && $item['is_bobao'] != 1) { ?>disabled<?php  } ?>> 考勤机
								</label>
								<label class="radio-inline">
									<input type="radio" value="3" class="printer-type" name="is_bobao" <?php  if($item['is_bobao'] == '3') { ?>checked<?php  } ?> id="credit12" <?php  if($item && $item['is_bobao'] != 3) { ?>disabled<?php  } ?>> 智能班牌
								</label>						
							</div>
						</div>
						<div id="credit-status22" <?php  if($item['is_bobao'] == 3) { ?>style="display:block"<?php  } else { ?>style="display:none"<?php  } ?>>
							<div class="form-group">
								<label class="col-xs-12 col-sm-3 col-md-2 control-label"><span class="require">* </span>卡类型</label>
								<div class="col-sm-2 col-lg-2">
									<select style="margin-right:15px;" name="cardtype" class="form-control">
										<option value="1" <?php  if($item['cardtype'] ==1) { ?> selected="selected"<?php  } ?>>IC卡</option>
										<option value="2" <?php  if($item['cardtype'] ==2 || empty($item['cardtype'])) { ?> selected="selected"<?php  } ?>>ID卡</option>
									</select>
									<div class="help-block">无特殊情况此处选择ID卡</div>
								</div>	
							</div>						
							<div class="form-group">
								<label class="col-xs-12 col-sm-3 col-md-2 control-label"><span class="require">* </span>城市名称</label>
								<div class="col-sm-2 col-lg-2">
									<input type="text" class="form-control" name="cityname" value="<?php  echo $item['cityname'];?>" placeholder="输入城市名称">
									<div class="help-block">输入城市，如：长沙</div>
								</div>
							</div>
							<div class="form-group">
								<label class="col-xs-12 col-sm-3 col-md-2 control-label"><span class="require">* </span>城市ID</label>
								<div class="col-sm-2 col-lg-2">
									<input type="text" class="form-control" name="areaid" value="<?php  echo $item['areaid'];?>" placeholder="城市ID">
									<div class="help-block">ID对照表，<a href="https://blog.csdn.net/wu9797/article/details/78768938">点击查看</a></div>
								</div>
							</div>							
							<div class="form-group">
								<label class="col-xs-12 col-sm-3 col-md-2 control-label"><span class="require">* </span>模式选择</label>
								<div class="col-sm-2 col-lg-2">
									<select style="margin-right:15px;" name="model_type" class="form-control">
										 <option value="1" <?php  if($item['model_type'] ==1) { ?> selected="selected"<?php  } ?>>班级模式</option>
										 <option value="2" <?php  if($item['model_type'] ==2) { ?> selected="selected"<?php  } ?>>考试模式</option>
										 <option value="3" <?php  if($item['model_type'] ==3) { ?> selected="selected"<?php  } ?>>视频模式</option>
									</select>
								</div>								
							</div>	
							<div class="form-group">
								<label class="col-xs-12 col-sm-3 col-md-2 control-label" style="color: red;font-size: 18px;right: -367px;">班级模式基础设置</label>
							</div>							
							<div class="form-group">
								<label class="col-xs-12 col-sm-3 col-md-2 control-label"><span class="require">* </span>绑定班级</label>
								<div class="col-sm-2 col-lg-2">
									<select style="margin-right:15px;" name="bj_id" class="form-control">
										<option value="0">选择班级</option>
										<?php  if(is_array($class)) { foreach($class as $row) { ?>
										 <option value="<?php  echo $row['id'];?>" <?php  if($row['id'] ==$item['bj_id']) { ?> selected="selected"<?php  } ?>><?php  echo $row['classes'];?></option>
										<?php  } } ?>
									</select>
								</div>	
							</div>
							<div class="form-group">
								<label class="col-xs-12 col-sm-3 col-md-2 control-label">班级封面</label>
								<div class="col-sm-2 col-lg-2">
									<?php  echo tpl_form_field_image('class_img', $banner['class_img'])?>
									<div class="help-block">宽高比例推荐，4:3</div>
								</div>
							</div>
							<div class="form-group">
								<label class="col-xs-12 col-sm-3 col-md-2 control-label" style="color: red;font-size: 18px;right: -367px;">考试模式基础设置</label>
							</div>							
							<div class="form-group">
								<label class="col-xs-12 col-sm-3 col-md-2 control-label"><span class="require">* </span>选择期号</label>
								<div class="col-sm-2 col-lg-2">
									<select style="margin-right:15px;" name="qh_id" class="form-control">
										<option value="0">选择期号</option>
										<?php  if(is_array($qh)) { foreach($qh as $row) { ?>
										 <option value="<?php  echo $row['sid'];?>" <?php  if($row['sid'] ==$item['qh_id']) { ?> selected="selected"<?php  } ?>><?php  echo $row['sname'];?></option>
										<?php  } } ?>
									</select>
								</div>	
							</div>
							<div class="form-group">
								<label class="col-xs-12 col-sm-3 col-md-2 control-label"><span class="require">* </span>考场名称</label>
								<div class="col-sm-9 col-xs-12">
									<input type="text" class="form-control" name="exam_room_name" value="<?php  echo $item['exam_room_name'];?>" placeholder="输入考场名称">
									<div class="help-block">考场名称，如：第一考场</div>
								</div>
							</div>
							<div class="form-group">
								<label class="col-xs-12 col-sm-3 col-md-2 control-label" style="color: red;font-size: 18px;right: -367px;">公屏模式基础设置</label>
							</div>							
							<div class="form-group">
								<label class="col-xs-12 col-sm-3 col-md-2 control-label"><span class="require">* </span>视频地址</label>
								<div class="col-sm-9 col-xs-12">
									<input type="text" class="form-control" name="video_url" value="<?php  echo $banner['video_url'];?>" placeholder="输入视频固定地址">
									<div class="help-block">输入视频固定地址</div>
								</div>
							</div>							
						</div>	
					</div>	
					<?php  if(empty($item) || $item['is_bobao'] == 1) { ?>	
					<div id="credit-status68" <?php  if($item['macname'] == 2 || $item['macname'] == 5 || $item['macname'] == 6) { ?>style="display:block"<?php  } else { ?>style="display:none"<?php  } ?>>
						<div class="form-group" id="credit-status78" <?php  if($item['macname'] == 2) { ?>style="display:block"<?php  } else { ?>style="display:none"<?php  } ?>>
							<label class="col-xs-12 col-sm-3 col-md-2 control-label"><span class="require">* </span>卡类型</label>
							<div class="col-sm-2 col-lg-2">
								<select style="margin-right:15px;" name="cardtype" class="form-control">
									<option value="1" <?php  if($item['cardtype'] ==1) { ?> selected="selected"<?php  } ?>>IC卡</option>
									<option value="2" <?php  if($item['cardtype'] ==2 || empty($item['cardtype'])) { ?> selected="selected"<?php  } ?>>ID卡</option>
								</select>
								<div class="help-block">无特殊情况此处选择ID卡</div>
							</div>	
						</div>
						<div class="form-group">
							<label class="col-xs-12 col-sm-3 col-md-2 control-label"><span class="require">* </span>进离校区分</label>
							<div class="col-sm-2 col-lg-2">
								<select style="margin-right:15px;" name="type_xz" class="form-control">
									<option value="0">请选择</option>
									<option value="1" <?php  if($item['type'] ==1) { ?> selected="selected"<?php  } ?>>进校设备</option>
									<option value="2" <?php  if($item['type'] ==2) { ?> selected="selected"<?php  } ?>>离校设备</option>
								</select>
								<div class="help-block">双机准确判断进校离校/此设置必须添加2台设备来判断/一台选择进校/台选择为离校/不选择则使用考勤设置里的时间来判断进离校，不太准确</div>
							</div>
						</div>
						<div class="form-group">
							<label class="col-xs-12 col-sm-3 col-md-2 control-label"><span class="require">* </span>广告标题/广告语</label>
							<div class="col-sm-9 col-xs-12">
								<input type="text" class="form-control" name="pop" value="<?php  echo $banner['pop'];?>" placeholder="广告标题">
								<div class="help-block">广告标题/广告语</div>
							</div>
						</div>
						<div class="form-group">
							<label class="col-xs-12 col-sm-3 col-md-2 control-label">体温枪</label>
							<div class="col-sm-9 col-xs-12">
								<input type="text" class="form-control" name="twmac" value="<?php  if($item['twmac'] != -1) { ?><?php  echo $item['twmac'];?><?php  } ?>" placeholder="例如:A0:EA:DC:08:2M">
								<div class="help-block">填写体温枪MAC，不填则不启用</div>
							</div>
						</div>					
						<div class="form-group">
							<label class="col-xs-12 col-sm-3 col-md-2 control-label"><span class="require">* </span>视频链接</label>
							<div class="col-sm-9 col-xs-12">
								<input type="text" class="form-control" name="video" value="<?php  echo $banner['video'];?>" placeholder="视频链接">
								<div class="help-block">设备上显示视频，必须为物理地址不支持代码</div>
							</div>
						</div>					
						<div class="form-group">
							<label class="col-xs-12 col-sm-3 col-md-2 control-label">广告图片1</label>
							<div class="col-sm-9 col-xs-12">
								<?php  echo tpl_form_field_image('pic1', $banner['pic1'])?>
							</div>
						</div>
						<div class="form-group">
							<label class="col-xs-12 col-sm-3 col-md-2 control-label">广告图片2</label>
							<div class="col-sm-9 col-xs-12">
								<?php  echo tpl_form_field_image('pic2', $banner['pic2'])?>
							</div>
						</div>
						<div class="form-group">
							<label class="col-xs-12 col-sm-3 col-md-2 control-label">广告图片3</label>
							<div class="col-sm-9 col-xs-12">
								<?php  echo tpl_form_field_image('pic3', $banner['pic3'])?>
							</div>
						</div>
						<div class="form-group">
							<label class="col-xs-12 col-sm-3 col-md-2 control-label">广告图片4</label>
							<div class="col-sm-9 col-xs-12">
								<?php  echo tpl_form_field_image('pic4', $banner['pic4'])?>
							</div>
						</div>
					</div>
					<?php  } ?>	
				</div>
				<div id="credit-status2" <?php  if($item['macname'] == 3) { ?>style="display:block"<?php  } else { ?>style="display:none"<?php  } ?>>
					<div class="form-group">
						<label class="col-xs-12 col-sm-3 col-md-2 control-label"><span class="require">* </span>机器号/设备号</label>
						<div class="col-sm-9 col-xs-12">
							<?php  if(!$item) { ?>
							<input type="text" class="form-control" name="macid_ym" value="<?php  echo $item['macid'];?>" placeholder="填写机器号">
							<div class="help-block">考勤机显示屏上获取/或设备背后</div>
							<?php  } else { ?>	
							<div class="help-block"><?php  echo $item['macid'];?>   不可修改</div>	
							<input type="hidden" name="macid_ym" value="<?php  echo $item['macid'];?>">
							<?php  } ?>
						</div>
					</div>
					<div class="form-group">
						<label class="col-xs-12 col-sm-3 col-md-2 control-label"><span class="require">* </span>进离校区分</label>
						<div class="col-sm-9 col-xs-12">
							<select style="margin-right:15px;" name="type_ym" class="form-control">
								<option value="0">请选择</option>
								<option value="1" <?php  if($item['type'] ==1) { ?> selected="selected"<?php  } ?>>进校设备</option>
								<option value="2" <?php  if($item['type'] ==2) { ?> selected="selected"<?php  } ?>>离校设备</option>
							</select>
							<div class="help-block">双机准确判断进校离校/此设置必须添加2台设备来判断/一台选择进校/台选择为离校/不选择则使用考勤设置里的时间来判断进离校，不太准确</div>
						</div>
					</div>				
					<div class="form-group">
						<label class="col-xs-12 col-sm-3 col-md-2 control-label"><span class="require">* </span>滚动公告</label>
						<div class="col-sm-9 col-xs-12">
							<input type="text" class="form-control" name="pop1" value="<?php  echo $banner['pop'];?>" placeholder="滚动公告">
							<div class="help-block">显示在待机界面</div>
						</div>
					</div>
					<div class="form-group">
						<label class="col-xs-12 col-sm-3 col-md-2 control-label"><span class="require">* </span>语音提示</label>
						<div class="col-sm-9 col-xs-12">
							<input type="text" class="form-control" name="VOICEPRE1" value="<?php  echo $banner['VOICEPRE'];?>" placeholder="例如：#name#,刷卡成功">
							<div class="help-block">变量名含义，名称：#name# </div>
						</div>
					</div>					
					<div class="form-group">
						<label class="col-xs-12 col-sm-3 col-md-2 control-label">视频文件</label>
						<div class="col-sm-9 col-xs-12">
							<input type="text" class="form-control" name="video1" value="<?php  echo $banner['video'];?>" placeholder="只能填写视频文件名称">
							<div class="help-block">设备上显示视频，必须为物理地址不支持代码，此处地址必须填写文件名，文件储存在<?php  echo $urls;?>之下，请手动上传</div>
						</div>
					</div>					
					<div class="form-group">
						<label class="col-xs-12 col-sm-3 col-md-2 control-label"><span class="require">* </span>广告图片1</label>
						<div class="col-sm-9 col-xs-12">
							<?php  echo tpl_form_field_image('pic11', $banner['pic1'])?>
						</div>
					</div>
					<div class="form-group">
						<label class="col-xs-12 col-sm-3 col-md-2 control-label"><span class="require">* </span>广告图片2</label>
						<div class="col-sm-9 col-xs-12">
							<?php  echo tpl_form_field_image('pic21', $banner['pic2'])?>
						</div>
					</div>
					<div class="form-group">
						<label class="col-xs-12 col-sm-3 col-md-2 control-label"><span class="require">* </span>广告图片3</label>
						<div class="col-sm-9 col-xs-12">
							<?php  echo tpl_form_field_image('pic31', $banner['pic3'])?>
						</div>
					</div>
					<div class="form-group">
						<label class="col-xs-12 col-sm-3 col-md-2 control-label"><span class="require">* </span>广告图片4</label>
						<div class="col-sm-9 col-xs-12">
							<?php  echo tpl_form_field_image('pic41', $banner['pic4'])?>
						</div>
					</div>					
				</div>
				<div id="credit-status3" <?php  if($item['macname'] == 4) { ?>style="display:block"<?php  } else { ?>style="display:none"<?php  } ?>>
					<link href="<?php echo MODULE_URL;?>public/web/css/app.css" rel="stylesheet">
					<style>
					.shopNav .app .app-preview:after {content: "";position: absolute;bottom: 20px;left: 190px;width: 60px;height: 60px;border: 1px solid #ddd;border-radius: 100%;}
					.shopNav .app .app-content {border-bottom: 1px solid #c5c5c5;min-height: 787px;position: relative;background: #fff;overflow: hidden;}
					</style>
					<div class="shopNav ng-scope">
						<div class="app clearfix">
							<div class="app-preview">
								<div class="app-header"></div>		
								<div id="bg_img" class="app-content" style="background:url(<?php  if($banner['bgimg']) { ?><?php  echo tomedia($banner['bgimg'])?><?php  } else { ?><?php echo MODULE_URL;?>public/mobile/img/background.jpg<?php  } ?>) no-repeat;background-size: 420px 787px;">
									<div class="top" id="bgimg"style="padding-top:103px"></div>
									<div class="top1" style="position:relative;cursor: move;width: 420px;padding-left: 6px;">
										<a class="top1 left"><img width="200" height="246" id="top1" src ="<?php echo MODULE_URL;?>public/mobile/img/abbtop1.png"></a>
										<a class="top1 right" style="padding-left: 2px;"><img width="200" height="246" id="top2" src ="<?php echo MODULE_URL;?>public/mobile/img/abbtop2.png"></a>
									</div>	
									<div class="center" style="position:relative;cursor: move;width: 420px;padding-left: 6px;margin-top:5px;">
										<a class="top1 left"><img width="200" height="124" id="center_waether" src ="<?php echo MODULE_URL;?>public/mobile/img/abbcenter1.jpg"></a>
										<a class="top1 right" style="padding-left: 2px;"><img id="center_qrcode"width="200" height="124" src ="<?php  if($banner['qrcode']) { ?><?php  echo tomedia($banner['qrcode'])?><?php  } else { ?><?php echo MODULE_URL;?>public/mobile/img/abbcenter2.jpg<?php  } ?>"></a>
									</div>
									<div class="center" style="position:relative;cursor: move;width: 420px;padding-left: 6px;margin-top:5px;">
										<a class="top1 left"><img width="405" height="253" id="foot_banner" src ="<?php echo MODULE_URL;?>public/mobile/img/abbbot.png"></a>
									</div>
									<div class="center" style="position:relative;cursor: move;width: 410px;padding-left: 6px;margin-top:5px;">
										<input type="text" class="form-control" name="foot_pop" value="<?php  if($banner['pop']) { ?><?php  echo $banner['pop'];?><?php  } else { ?><?php  echo $logo['gonggao'];?><?php  } ?>" placeholder="滚动公告">
									</div>									
								</div>	
							</div>
							<div class="app-side">
								<div id="bgimg_editor" class="editor" style="border: 1px solid #eee;">
									<div class="ng-scope">
									<!--背景图-->
										<div class="app-header-setting">
											<div class="arrow-left"></div>
											<div class="app-header-setting-inner">
												<div class="panel panel-default">
													<div class="panel-body form-horizontal">													
														<div class="form-group">
															<label class="col-xs-3 control-label"><span class="red">*</span>机器号/设备号</label>
															<div class="col-xs-9">
																<?php  if(!$item) { ?>
																<input type="text" name="macid_abb" placeholder="填写机器号" value="<?php  echo $item['macid'];?>" class="form-control ng-pristine ng-untouched ng-valid">
																<?php  } else { ?>	
																<div class="help-block"><?php  echo $item['macid'];?>   不可修改</div>	
																<input type="hidden" name="macid_abb" value="<?php  echo $item['macid'];?>">
																<?php  } ?>															
															</div>
														</div>
														<div class="form-group">
															<label class="col-xs-3 control-label"><span class="red">*</span>进离校区分</label>
															<div class="col-xs-9">
																<select style="margin-right:15px;" name="type_abb" class="form-control">
																	<option value="0">请选择</option>
																	<option value="1" <?php  if($item['type'] ==1) { ?> selected="selected"<?php  } ?>>进校设备</option>
																	<option value="2" <?php  if($item['type'] ==2) { ?> selected="selected"<?php  } ?>>离校设备</option>
																</select>
																<div class="help-block">双机准确判断进校离校</br>此设置必须添加2台设备来判断</br>一台选择进校/台选择为离校</br>不选择则使用考勤设置里的时间来判断进离校，不太准确</div>
															</div>
														</div>														
														<div class="form-group">
															<label class="control-label col-xs-3"><span class="red">*</span>考勤机背景图片</label>
															<div class="col-xs-9">
																<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('public/imgeschoses', TEMPLATE_INCLUDEPATH)) : (include template('public/imgeschoses', TEMPLATE_INCLUDEPATH));?>
																<div class="input-group ">
																	<input type="text" name="bgimg" id="bgimg" value="<?php  if($banner['bgimg']) { ?><?php  echo tomedia($banner['bgimg'])?><?php  } else { ?><?php echo MODULE_URL;?>public/mobile/img/background.jpg<?php  } ?>" class="form-control" autocomplete="off" filename="" url="">
																	<span class="input-group-btn">
																		<button class="btn btn-default" type="button" onclick="showImageDialog_bgimg(this);">选择图片</button>
																	</span>
																</div>
																<div class="input-group " style="margin-top:.5em;">
																	<img src="<?php  if($banner['bgimg']) { ?><?php  echo tomedia($banner['bgimg'])?><?php  } else { ?><?php echo MODULE_URL;?>public/mobile/img/background.jpg<?php  } ?>" onerror="" class="img-responsive img-thumbnail" width="150">
																	<em class="close" style="position:absolute; top: 0px; right: -14px;" title="删除这张图片" onclick="deleteImage(this)">×</em>
																</div>
																<span class="help-block">推荐尺寸1080*1920</span>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>		
								</div>
								<div id="top1_editor" class="editor" style="border: 1px solid #eee;top:100px">
									<div class="ng-scope">
									<!--摄像头设置-->
										<div class="app-header-setting">
											<div class="arrow-left"></div>
											<div class="app-header-setting-inner">
												<div class="panel panel-default">
													<div class="panel-body form-horizontal">	
														<span class="help-block"><span class="red">不启用则留空，则使用考勤机自带摄像头,如启用则必须设置阿里云OSS相关</span></span>
														<div class="form-group">
															<label class="col-xs-3 control-label"><span class="red">*</span>外置全景摄像头</label>
															<div class="col-xs-9">
																<input type="text" name="device_id" placeholder="设备ID" value="<?php  echo $set['device_id'];?>" class="form-control ng-pristine ng-untouched ng-valid">
															</div>
														</div>	
														<div class="form-group">	
															<label class="col-xs-3 control-label"><span class="red">*</span>用户名</label>
															<div class="col-xs-9">
																<input type="text" name="user_id" placeholder="用户名" value="<?php  echo $set['user_id'];?>" class="form-control ng-pristine ng-untouched ng-valid">
															</div>
														</div>
														<div class="form-group">	
															<label class="col-xs-3 control-label"><span class="red">*</span>密码</label>
															<div class="col-xs-9">
																<input type="text" name="pwd" placeholder="密码" value="<?php  echo $set['pwd'];?>" class="form-control ng-pristine ng-untouched ng-valid">
															</div>
														</div>														
													</div>
												</div>
											</div>
										</div>
									</div>		
								</div>
								<div id="top2_editor" class="editor" style="border: 1px solid #eee;top:100px">
									<div class="ng-scope">
									<!--考勤设置-->
										<div class="app-header-setting">
											<div class="arrow-left"></div>
											<div class="app-header-setting-inner">
												<div class="panel panel-default">
													<div class="panel-body form-horizontal">
														<span class="help-block"><span class="red">启用外置摄像头必须启用oss储存,以加快考勤速度</span></span>
														<div class="form-group">	
															<label class="col-xs-3 control-label"><span class="red">*</span>OSS地址</label>
															<div class="col-xs-9">
																<input type="text" name="rootUrl" placeholder="OSS地址" value="<?php  echo $set['rootUrl'];?>" class="form-control ng-pristine ng-untouched ng-valid">
																<span class="help-block">填写你绑定的OSS地址</span>
															</div>
														</div>	
														<div class="form-group">	
															<label class="col-xs-3 control-label"><span class="red">*</span>OSS节点</label>
															<div class="col-xs-9">
																<input type="text" name="endpoint" placeholder="OSS节点" value="<?php  echo $set['endpoint'];?>" class="form-control ng-pristine ng-untouched ng-valid">
																<span class="help-block">如:http://oss-cn-shenzhen.aliyuncs.com/</span>
															</div>
														</div>
														<div class="form-group">	
															<label class="col-xs-3 control-label"><span class="red">*</span>bucket</label>
															<div class="col-xs-9">
																<input type="text" name="bucket" placeholder="填写bucket名称" value="<?php  echo $set['bucket'];?>" class="form-control ng-pristine ng-untouched ng-valid">
																<span class="help-block">填写要储存到指定bucket的名称</span>
															</div>
														</div>														
														<div class="form-group">	
															<label class="col-xs-3 control-label"><span class="red">*</span>accessKeyId</label>
															<div class="col-xs-9">
																<input type="text" name="accessKeyId" placeholder="accessKeyId" value="<?php  echo $set['accessKeyId'];?>" class="form-control ng-pristine ng-untouched ng-valid">
																<span class="help-block">填写阿里云accessKeyId</span>
															</div>
														</div>	
														<div class="form-group">	
															<label class="col-xs-3 control-label"><span class="red">*</span>accessKeySecret</label>
															<div class="col-xs-9">
																<input type="text" name="accessKeySecret" placeholder="accessKeySecret" value="<?php  echo $set['accessKeySecret'];?>" class="form-control ng-pristine ng-untouched ng-valid">
																<span class="help-block">填写阿里云accessKeySecret</span>
															</div>
														</div>														
													</div>
												</div>
											</div>
										</div>
									</div>		
								</div>								
								<div id="weather_editor" class="editor" style="border: 1px solid #eee;top:370px">
									<div class="ng-scope">
									<!--天气-->
										<div class="app-header-setting">
											<div class="arrow-left"></div>
											<div class="app-header-setting-inner">
												<div class="panel panel-default">
													<div class="panel-body form-horizontal">								
														<div class="form-group">
															<label class="col-xs-3 control-label"><span class="red">*</span>weather_id</label>
															<div class="col-xs-9">
																<input type="text" name="weather_id" placeholder="天气weather_id" value="<?php  echo $set['weather_id'];?>" class="form-control ng-pristine ng-untouched ng-valid">
															</div>
														</div>	
														<div class="form-group">	
															<label class="col-xs-3 control-label"><span class="red">*</span>apikey</label>
															<div class="col-xs-9">
																<input type="text" name="apikey" placeholder="天气apikey" value="<?php  echo $set['apikey'];?>" class="form-control ng-pristine ng-untouched ng-valid">
															</div>
														</div>
														<span class="help-block"><a href="http://console.heweather.com/register" target="_blank">点此申请天气接口</a></span>
													</div>
												</div>
											</div>
										</div>
									</div>		
								</div>
								<div id="qrcode_editor" class="editor" style="border: 1px solid #eee;top:370px">
									<div class="ng-scope">
									<!--食谱、二维码-->
										<div class="app-header-setting">
											<div class="arrow-left"></div>
											<div class="app-header-setting-inner">
												<div class="panel panel-default">
													<div class="panel-body form-horizontal">								
														<div class="form-group">
															<label class="control-label col-xs-3"><span class="red">*</span>小图</label>
															<div class="col-xs-9">
																<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('public/imgeschoses', TEMPLATE_INCLUDEPATH)) : (include template('public/imgeschoses', TEMPLATE_INCLUDEPATH));?>
																<div class="input-group ">
																	<input type="text" name="qrcode" id="qrcode" value="<?php  if($banner['qrcode']) { ?><?php  echo tomedia($banner['qrcode'])?><?php  } else { ?><?php echo MODULE_URL;?>public/mobile/img/abbcenter2.jpg<?php  } ?>" class="form-control" autocomplete="off" filename="" url="">
																	<span class="input-group-btn">
																		<button class="btn btn-default" type="button" onclick="showImageDialog_qrcode(this);">选择图片</button>
																	</span>
																</div>
																<div class="input-group " style="margin-top:.5em;">
																	<img src="<?php  if($banner['qrcode']) { ?><?php  echo tomedia($banner['qrcode'])?><?php  } else { ?><?php echo MODULE_URL;?>public/mobile/img/abbcenter2.jpg<?php  } ?>" onerror="" class="img-responsive img-thumbnail" width="150">
																	<em class="close" style="position:absolute; top: 0px; right: -14px;" title="删除这张图片" onclick="deleteImage(this)">×</em>
																</div>
																<span class="help-block">推荐尺寸200*124(此处推荐显示二维码)</span>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>		
								</div>
								<div id="banner_editor" class="editor" style="border: 1px solid #eee;">
									<div class="ng-scope">
									<!--食谱、二维码-->
										<div class="app-header-setting">
											<div class="arrow-left" style="top: 520px;"></div>
											<div class="app-header-setting-inner">
												<div class="panel panel-default">
													<div class="panel-body form-horizontal">								
														<div class="form-group">
															<label class="control-label col-xs-3"><span class="red">*</span>大图幻灯片1</label>
															<div class="col-xs-9">
																<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('public/imgeschoses', TEMPLATE_INCLUDEPATH)) : (include template('public/imgeschoses', TEMPLATE_INCLUDEPATH));?>
																<div class="input-group ">
																	<input type="text" name="pic1_abb" id="pic1" value="<?php  if($banner['pic1']) { ?><?php  echo tomedia($banner['pic1'])?><?php  } else { ?><?php echo MODULE_URL;?>public/mobile/img/abbbot.png<?php  } ?>" class="form-control" autocomplete="off" filename="" url="">
																	<span class="input-group-btn">
																		<button class="btn btn-default" type="button" onclick="showImageDialog_banner(this);">选择图片</button>
																	</span>
																</div>
																<div class="input-group " style="margin-top:.5em;">
																	<img src="<?php  if($banner['pic1']) { ?><?php  echo tomedia($banner['pic1'])?><?php  } else { ?><?php echo MODULE_URL;?>public/mobile/img/abbbot.png<?php  } ?>" onerror="" class="img-responsive img-thumbnail" width="150">
																	<em class="close" style="position:absolute; top: 0px; right: -14px;" title="删除这张图片" onclick="deleteImage(this)">×</em>
																</div>
																<span class="help-block">推荐尺寸405*253</span>
															</div>
														</div>
														<div class="form-group">
															<label class="control-label col-xs-3"><span class="red">*</span>大图幻灯片2</label>
															<div class="col-xs-9">
																<?php  echo tpl_form_field_image('pic2_abb', $banner['pic2'])?>
																<span class="help-block">推荐尺寸405*253</span>
															</div>
														</div>
														<div class="form-group">
															<label class="control-label col-xs-3"><span class="red">*</span>大图幻灯片3</label>
															<div class="col-xs-9">
																<?php  echo tpl_form_field_image('pic3_abb', $banner['pic3'])?>
																<span class="help-block">推荐尺寸405*253</span>
															</div>
														</div>
														<div class="form-group">
															<label class="control-label col-xs-3"><span class="red">*</span>大图幻灯片4</label>
															<div class="col-xs-9">
																<?php  echo tpl_form_field_image('pic4_abb', $banner['pic4'])?>
																<span class="help-block">推荐尺寸405*253</span>
															</div>
														</div>
														<div class="form-group">
															<label class="control-label col-xs-3"><span class="red">*</span>大图幻灯片5</label>
															<div class="col-xs-9">
																<?php  echo tpl_form_field_image('pic5_abb', $banner['pic5'])?>
																<span class="help-block">推荐尺寸405*253</span>
															</div>
														</div>														
													</div>
												</div>
											</div>
										</div>
									</div>		
								</div>								
							</div>							
						</div>	
					</div>
				</div>
				<script type="text/javascript">
					$(document).ready(function() {
						$("#top1_editor").hide();
						$("#top2_editor").hide();
						$("#weather_editor").hide();
						$("#qrcode_editor").hide();
						$("#banner_editor").hide();
					});
					$("#bgimg").click(function(){
						$("#bgimg_editor").show();
						$("#top1_editor").hide();
						$("#top2_editor").hide();						
						$("#weather_editor").hide();
						$("#qrcode_editor").hide();
						$("#banner_editor").hide();						
					});
					$("#top1").click(function(){
						$("#bgimg_editor").hide();
						$("#top1_editor").show();
						$("#top2_editor").hide();						
						$("#weather_editor").hide();
						$("#qrcode_editor").hide();
						$("#banner_editor").hide();						
					});
					$("#top2").click(function(){
						$("#bgimg_editor").hide();
						$("#top1_editor").hide();
						$("#top2_editor").show();						
						$("#weather_editor").hide();
						$("#qrcode_editor").hide();
						$("#banner_editor").hide();						
					});					
					$("#center_waether").click(function(){
						$("#bgimg_editor").hide();
						$("#top1_editor").hide();
						$("#top2_editor").hide();						
						$("#weather_editor").show();
						$("#qrcode_editor").hide();
						$("#banner_editor").hide();						
					});	
					$("#center_qrcode").click(function(){
						$("#bgimg_editor").hide();
						$("#top1_editor").hide();
						$("#top2_editor").hide();						
						$("#weather_editor").hide();
						$("#qrcode_editor").show();
						$("#banner_editor").hide();						
					});	
					$("#foot_banner").click(function(){
						$("#bgimg_editor").hide();
						$("#top1_editor").hide();
						$("#top2_editor").hide();						
						$("#weather_editor").hide();
						$("#qrcode_editor").hide();
						$("#banner_editor").show();						
					});					
				</script>
				<?php  if($_W['isfounder']) { ?>
					<?php  if(!empty($item['macid'])) { ?>
						<?php  if($item['macname'] == 1) { ?>
							<div class="form-group">
								<label class="col-xs-12 col-sm-3 col-md-2 control-label"><span class="require">* </span>设备接口 :</label>
								<div class="col-sm-9 col-xs-12">
									<label class="radio-inline">
										<!-- <a><?php echo $_W['siteroot'] . 'app/index.php?i=' . $item['weid'] . '&c=entry&schoolid=' . $item['schoolid'] . '&do=checkjl&m=fm_jiaoyu'?></a> -->
										<a><?php echo $_W['siteroot'] . 'app/index.php?i=' . $item['weid'] . '&c=entry&schoolid=' . $item['schoolid'] . '&do=checkjl&m=fm_jiaoyu'.'&macid=' . $item['macid'] . ' '?></a>
									<label class="radio-inline">
								</div>
							</div>
						<?php  } ?>
						<?php  if($item['macname'] == 2) { ?>
							<div class="form-group">
								<label class="col-xs-12 col-sm-3 col-md-2 control-label"><span class="require">* </span>设备接口 :</label>
								<div class="col-sm-9 col-xs-12">
									<label class="radio-inline">
										<a><?php echo $_W['siteroot'] . 'app/index.php?i=' . $item['weid'] . '&c=entry&schoolid=' . $item['schoolid'] . '&do=checkxz&m=fm_jiaoyu'?></a>
									</label>			
								</div>
							</div>
						<?php  } ?>
						<?php  if($item['macname'] == 3) { ?>
							<div class="form-group">
								<label class="col-xs-12 col-sm-3 col-md-2 control-label"><span class="require">* </span>设备接口 :</label>
								<div class="col-sm-9 col-xs-12">
									<label class="radio-inline">
										<a><?php echo $_W['siteroot'] . 'app/index.php?i=' . $item['weid'] . '&c=entry&schoolid=' . $item['schoolid'] . '&do=checkym&m=fm_jiaoyu'?></a>
									</label>			
								</div>
								<label class="col-xs-12 col-sm-3 col-md-2 control-label"><span class="require">* </span>文件路径 :</label>
								<div class="col-sm-9 col-xs-12">
									<label class="radio-inline">
										<a><?php  echo $urls;?></a>
									</label>			
								</div>								
							</div>
						<?php  } ?>
						<?php  if($item['macname'] == 4) { ?>
							<div class="form-group">
								<label class="col-xs-12 col-sm-3 col-md-2 control-label"><span class="require">* </span>设备接口 :</label>
								<div class="col-sm-9 col-xs-12">
									<label class="radio-inline">
										<a><?php echo $_W['siteroot'] . 'app/index.php?i=' . $item['weid'] . '&c=entry&schoolid=' . $item['schoolid'] . '&do=checkabb&m=fm_jiaoyu'?></a>
									</label>			
								</div>							
							</div>
						<?php  } ?>						
					<?php  } ?>
				<?php  } ?>
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-9 col-xs-9 col-md-9">
				<input type="hidden" name="token" value="<?php  echo $_W['token'];?>">
				<input name="submit" id="submit" type="submit" value="提交" class="btn btn-primary col-lg-1">
			</div>	
		</div>
	</div>
</form>
<script>
$(function(){
	$('#credit1').click(function(){
		$('#credit-status0').show();
		$('#credit-status1').hide();
		$('#credit-status2').hide();
		$('#credit-status3').hide();
	});
	$('#credit2').click(function(){
		$('#credit-status0').hide();
		$('#credit-status1').show();
		$('#credit-status2').hide();
		$('#credit-status3').hide();
		$('#credit-status66').hide();
		$('#credit-status68').hide();
		$('#credit-status78').show();
		$('#credit-status21').show();
		$('#credit-status22').hide();
	});
	$('#credit3').click(function(){
		$('#credit-status0').hide();
		$('#credit-status2').show();
		$('#credit-status1').hide();
		$('#credit-status3').hide();
	});	
	$('#credit4').click(function(){
		$('#credit-status0').hide();
		$('#credit-status3').show();
		$('#credit-status2').hide();
		$('#credit-status1').hide();
	});	
	$('#credit5').click(function(){
		$('#credit-status0').hide();
		$('#credit-status1').show();
		$('#credit-status2').hide();
		$('#credit-status3').hide();
		$('#credit-status66').hide();
		$('#credit-status68').show();
		$('#credit-status78').hide();		
	});
	$('#credit6').click(function(){
		$('#credit-status0').hide();
		$('#credit-status1').show();
		$('#credit-status2').hide();
		$('#credit-status3').hide();
		$('#credit-status66').show();
		$('#credit-status68').hide();
		$('#credit-status78').hide();
		$('#credit-status21').hide();
		$('#credit-status22').hide();		
	});	
	$('#credit7').click(function(){
		$('#credit-status67').hide();
		$('#credit-status68').show();
	});	
	$('#credit8').click(function(){
		$('#credit-status67').show();
		$('#credit-status68').hide();
	});	
	$('#credit9').click(function(){
		$('#credit-status69').show();
	});
	$('#credit10').click(function(){
		$('#credit-status69').hide();
	});
	$('#credit11').click(function(){
		$('#credit-status68').show();
		$('#credit-status22').hide();
	});	
	$('#credit12').click(function(){
		$('#credit-status68').hide();
		$('#credit-status22').show();
	});		
});
</script>
<?php  } else if($operation == 'display') { ?>
<div class="clearfix">
	<form class="form-horizontal" action="" method="post">
		<div class="form-group">
			<div class="col-sm-12">
				<a class="btn btn-success col-lg-1 qx_2402" href="<?php  echo $this->createWebUrl('check', array('op' => 'post','schoolid' => $schoolid));?>"/><i class="fa fa-plus-circle"> </i>  添加设备</a>
			</div>
		</div>
		<div class="panel panel-default">
			<div class="panel-body table-responsive">
				<table class="table table-hover">
					<thead class="navbar-inner">
						<tr>
							<?php  if($_W['isfounder'] || $_W['role'] == 'owner') { ?><th>设备品牌</th><?php  } ?>
							<th class="qx_2402">状态</th>
							<th>名称</th>
							<th>设备判断</th>
							<th>大屏广告</th>
							<th class="qx_2403">远程控制</th>
							<th>机器号</th>
							<th class="qx_e_d" style="width:150px; text-align:right;">状态/修改/删除</th>
						</tr>
					</thead>
					<tbody>
						<?php  if(is_array($list)) { foreach($list as $item) { ?>
						<tr>
							<?php  if($_W['isfounder'] || $_W['role'] == 'owner') { ?><td>
								<span><?php  if($item['macname'] == '1') { ?>吉联<?php  } ?><?php  if($item['macname'] == '2') { ?>讯贞<?php  } ?><?php  if($item['macname'] == '3') { ?>优米<?php  } ?><?php  if($item['macname'] == '4') { ?>安宝贝<?php  } ?><?php  if($item['macname'] == '5') { ?>护校通<?php  } ?><?php  if($item['macname'] == '6') { ?>万能考勤机<?php  } ?></span>
							</td><?php  } ?>
							<td class="qx_2402"><input type="checkbox" value="<?php  echo $item['is_on'];?>" name="is_on[]" data-id="<?php  echo $item['id'];?>" <?php  if($item['is_on'] == 1) { ?>checked<?php  } ?>></td>
							<td><?php  echo $item['name'];?></td>
							<td><?php  if($item['is_bobao'] ==1) { ?><?php  if($item['type'] ==1) { ?>进校设备<?php  } else if($item['type'] ==2) { ?>离校设备<?php  } else { ?>单机模式<?php  } ?><?php  } else { ?><?php  if($item['is_bobao'] ==2) { ?>播报机<?php  } ?><?php  if($item['is_bobao'] ==3) { ?>智能班牌<?php  } ?><?php  } ?></td>
							<td>
							<?php  if(!empty($item['banner'])) { ?>
								<?php  if($item['isflow'] == 2) { ?>
								<span class="label label-success">已同步</span>					
								<?php  } else if($item['isflow'] ==1) { ?>
								<span class="label label-danger">未同步</span>
							    <?php  } ?>
							<?php  } else { ?>
							无
							<?php  } ?>
							</td>
							<td class="qx_2403">
								<?php  if($item['macname'] == '4' || $item['is_bobao'] ==3) { ?>
								    <?php  if($item['is_bobao'] ==3) { ?>
										<a class="btn btn-default" href="javascript::;"  data-toggle="tooltip" data-placement="top" title="修改模式" onclick="show_window(<?php  echo $item['id'];?>,<?php  echo $item['model_type'];?>);">修改模式</a>
										<?php  if($item['model_type'] ==2) { ?>
											<a class="btn btn-default" href="<?php  echo $this->createWebUrl('check', array('op' => 'posta','id' => $item['id'], 'schoolid' => $schoolid))?>" title="修改模式">考试安排</a>
										<?php  } ?>
									<?php  } else { ?>
										<a class="btn btn-default" href="javascript::;"  data-toggle="tooltip" data-placement="top" title="执行任务" onclick="show_order(<?php  echo $item['id'];?>);">执行任务</a>
									<?php  } ?>									
								<?php  } else { ?>
									<span class="label label-danger">不支持</span>
								<?php  } ?>
							</td>							
							<td><?php  echo $item['macid'];?></td>
							<td style="text-align:right;">
								<?php  if($item['macname'] == '2') { ?>
								<a href="<?php  echo $this->createWebUrl('xz_device', array('id' => $item['id'], 'schoolid' => $schoolid))?>" class="btn btn-info btn-sm qx_2402" title="高级配置" data-toggle="tooltip" data-placement="top" ><i class="fa fa-plane"> </i></a>
								<?php  } ?>
								<a href="<?php  echo $this->createWebUrl('check', array('op' => 'post', 'id' => $item['id'], 'schoolid' => $schoolid))?>" class="btn btn-default btn-sm qx_2402" title="编辑" data-toggle="tooltip" data-placement="top" ><i class="fa fa-edit"> </i></a>
								<a href="<?php  echo $this->createWebUrl('check', array('op' => 'delete', 'id' => $item['id'], 'schoolid' => $schoolid))?>" class="btn btn-default btn-sm qx_2404" title="删除" data-toggle="tooltip" data-placement="top" onclick="if(!confirm('删除后将不可恢复，确定删除吗?')) return false;"><i class="fa fa-times"> </i></a>
							</td>
						</tr>
						<?php  } } ?>
					</tbody>
				</table>
			</div>
		</div>
	</form>
</div> 
<style>
/*公共菊花转*/
.popover{left: 950px !important;z-index:100000 !important;}
.common_progress_bg{display: none;position: fixed;top: 0;left: 0;height: 100%;width: 100%;background: rgba(0, 0, 0, 0.6);z-index: 9998;}
.common_progress{position: fixed;top: 40%;background: #000;height: 80px;width: 160px;border-radius: 12px;line-height: 20px;text-align: center;padding-top: 30px;z-index: 9999;}
.common_progress > img{width: 27px;height: 27px;padding-top: 30px;}
.common_progress > .common_loading{width: 30px;height: 30px;display: inline-block;vertical-align: middle;background: url(<?php echo OSSURL;?>public/mobile/img/load.png) no-repeat;background-size: 30px;-webkit-animation: loading1 2s linear infinite;}
@-webkit-keyframes loading1{0%{-webkit-transform: rotate(0deg);}33%{-webkit-transform: rotate(120deg);}66%{-webkit-transform: rotate(240deg);}
100%{-webkit-transform: rotate(360deg);}}
.common_progress > span{margin: 0 0 0 8px;color: #fff;}
</style>
<script src="<?php echo OSSURL;?>public/mobile/js/common.js?v=1717"></script>
<div class="modal fade" id="Modal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="  margin-top: 60px;">
	<div class="modal-dialog modal-lg" role="document">		
		<div class="modal-content">			
		<form class="table-responsive form-inline bv-form" method="post" action="" id="form-credit" novalidate="novalidate">				
			<div class="modal-header">					
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>					
				<h4 class="modal-title" id="myModalLabel">执行命令</h4>	
			</div>
			<div class="modal-body">
				<table class="table table-hover table-bordered">						
					<tbody>
						<tr>	
							<input type="hidden" id="macidforabb" value="">
							<th width="150">选择命令</th>							
							<td>								
								<select id="order" class="form-control" >									
									<option value="1">立即更新学生和卡信息（只更新）</option>									
									<option value="2">重新初始化学生和卡信息</option>	
									<option value="3">更新图片</option>	
									<option value="4">重启设备</option>	
								</select>							
							</td>						
						</tr>
						<tr>	
							<th width="150">								
								<select id="time_type" class="form-control" >									
									<option value="1">立即执行</option>									
									<option value="2">指定时间</option>	
								</select>
							</th>							
							<td>								
								<div class="input-group clockpicker" style="margin-bottom: 15px">
									<div class="input-group clockpicker" style="margin-bottom: 15px">					
											<script type="text/javascript">
												require(["datetimepicker"], function(){
													$(function(){
															var option = {
																lang : "zh",
																step : 5,
																timepicker : false,
																closeOnDateSelect : true,
																format : "Y-m-d"
															};
														$(".datetimepicker[name = 'dotime1']").datetimepicker(option);
													});
												});
											</script><input type="text" name="dotime1" id="dotime1" value="" placeholder="请选择日期时间" readonly="readonly" class="datetimepicker form-control" style="padding-left:12px;">									
											<script type="text/javascript">
												require(["clockpicker"], function($){
													$(function(){
														$(".clockpicker").clockpicker({
															autoclose: true
														});
													});
												});
											</script>
												<div class="input-group clockpicker">
													<span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
													<input type="text" name="dotime2" id="dotime2" value="" class="form-control">
												</div>								
									</div>
								</div>
								<span class="help-block">如设置指定时间，请选择类型</span>	
							</td>						
						</tr>
						<tr>	
							<th width="150">执行中任务</th>							
							<td id="loading_order"></td>
						</tr>
					</tbody>
				</table>				
			</div>				
			<div class="modal-footer">	
				<button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
				<button type="button" class="btn btn-primary" id="submit">提交</button>
			</div>			
		</form>		
		</div>	
	</div>
</div>
<div class="modal fade" id="Modal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="  margin-top: 60px;">
	<div class="modal-dialog modal-lg" role="document">		
		<div class="modal-content">			
		<form class="table-responsive form-inline bv-form" method="post" action="" id="form-credit" novalidate="novalidate">				
			<div class="modal-header">					
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>					
				<h4 class="modal-title" id="myModalLabel">控制</h4>	
			</div>
			<div class="modal-body">
				<table class="table table-hover table-bordered">						
					<tbody>
						<tr>	
							<input type="hidden" id="macidforbp" value="">
							<th width="150">选择模式</th>							
							<td>								
								<select id="model_type" class="form-control" >									
									<option value="1" id="ms1">班级模式</option>									
									<option value="2" id="ms2">考试模式</option>	
									<option value="3" id="ms3">视频模式</option>	
								</select>							
							</td>						
						</tr>
					</tbody>
				</table>				
			</div>				
			<div class="modal-footer">	
				<button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
				<button type="button" class="btn btn-primary" id="submit1">提交</button>
			</div>			
		</form>		
		</div>	
	</div>
</div>
<script type="text/javascript">
function show_window(id,model_type){
	var id = id;
	$('#Modal2').modal('toggle');
	$("#model_type").val(model_type); 
	$('#macidforbp').val(id);
}
function show_order(id){
	$("#loading_order").empty();//先清空任务列表,然后在添加新获取的任务
	 var id = id;
	 $('#Modal1').modal('toggle');
	 $('#macidforabb').val(id);
		$.post("<?php  echo $this->createWebUrl('indexajax', array('op' => 'getloadingorder'))?>",{id:id}, function(data){
			if(data.result){
				var html = '<span id=\"order'+data.id+'\" class="help-block">'+data.ordername+'<a onclick="del('+data.id+')" class="custom-url"><i class="fa fa-times-circle"></i></a></span>';					
				$('#loading_order').append(html);	
			}else{
				var html =  '<span class="help">当前无执行中的任务</span>';
				$('#loading_order').append(html);			
			}
		},'json');	 
}
function del(id){
	 var id = id;
		$.post("<?php  echo $this->createWebUrl('indexajax', array('op' => 'delorder'))?>",{id:id}, function(data){
			if(data.result){
				alert(data.msg);
				$("#loading_order").empty();
				var html =  '<span class="help">当前无执行中的任务</span>';
				$('#loading_order').append(html);					
			}else{
				alert(data.msg);
			}
		},'json');	 
}
$(function(){
	
	var e_d = 2 ;
	<?php  if((!(IsHasQx($tid_global,1002402,1,$schoolid)))) { ?>
		$(".qx_2402").hide();
		e_d = e_d - 1 ;
	<?php  } ?>
	<?php  if((!(IsHasQx($tid_global,1002403,1,$schoolid)))) { ?>
		$(".qx_2403").hide();
	<?php  } ?>
	<?php  if((!(IsHasQx($tid_global,1002404,1,$schoolid)))) { ?>
		$(".qx_2404").hide();
		e_d = e_d - 1 ;
	<?php  } ?>
	if(e_d == 0){
		$(".qx_e_d").hide();
	}


	$('#submit').click(function(){
		var dotime1 = $("#dotime1").val();
		var dotime2 = $("#dotime2").val();
		var time_type = $("#time_type").val();
		var submitData = {
			schoolid :"<?php  echo $schoolid;?>",
			weid :"<?php  echo $weid;?>",
			macid : $("#macidforabb").val(),
			order : $("#order").val(),
			time_type : time_type,
			dotime1 : dotime1,
			dotime2 : dotime2,
		};		
		$.post("<?php  echo $this->createWebUrl('indexajax', array('op' => 'createorder'))?>",submitData, function(data){
			if(data.result){
				if(time_type == 1){
					checkorder(data.id);
				}else{
					$('#Modal1').modal('toggle');
					alert(data.msg);
				}				
			}else{
				$('#Modal1').modal('toggle');
				alert(data.msg);
			}
		},'json');
	});
	$('#submit1').click(function(){
		var submitData = {
			schoolid :"<?php  echo $schoolid;?>",
			weid :"<?php  echo $weid;?>",
			macid : $("#macidforbp").val(),
			model_type : $("#model_type").val(),
		};		
		$.post("<?php  echo $this->createWebUrl('indexajax', array('op' => 'changemactype'))?>",submitData, function(data){
			if(data.result){
				$('#Modal2').modal('toggle');
				alert(data.msg);
				location.reload();
			}else{
				$('#Modal2').modal('toggle');
				alert(data.msg);
			}
		},'json');
	});	
});	
function checkorder(id){
	ajax_start_loading("命令发送中......请不要关闭本页面");
	var id = id;
	$.post("<?php  echo $this->createWebUrl('indexajax', array('op' => 'checkorder'))?>",{id: id}, function(data){
		if(data.result){
			ajax_stop_loading();
			$('#Modal1').modal('toggle');
			alert(data.msg);
		}else{
			setTimeout(checkorder(id), 5000);
		}	
	},'json');
}
require(['jquery', 'util', 'bootstrap.switch'], function($, u){

	$(':checkbox[name="is_on[]"]').bootstrapSwitch();
	$(':checkbox[name="is_on[]"]').on('switchChange.bootstrapSwitch', function(e, state){
		var is_on = this.checked ? 1 : 2;
		var id = $(this).data('id');
		$.post("<?php  echo $this->createWebUrl('check', array('op' => 'change'))?>", {is_on: is_on, id: id}, function(resp){
			setTimeout(function(){
				//location.reload();
			}, 500)
		});
	});
});
</script>
<?php  } else if($operation == 'posta') { ?>
<div class="main">
    <form action="" method="post" class="form-horizontal form" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php  echo $id;?>" />
		<input type="hidden" name="schoolid" value="<?php  echo $schoolid;?>" />        
        <div class="panel panel-default">
            <div class="panel-heading">考试安排</div>
            <div class="panel-body">
				<div id="custom-url">
					<?php  if(!empty($exam_plan)) { ?>
						<?php  if(is_array($exam_plan)) { foreach($exam_plan as $key => $row) { ?>
							<input type="hidden" name="new[$key]" value="111" />
							<div class="form-group">
								<label class="col-sm-2" style="width:5%;padding: 0px;text-align: right;">科目</label>
								<div class="col-sm-2 col-lg-2">
								<select style="margin-right:15px;" name="exam_course[$key]" class="form-control">
									<option value="0">科目</option>
									<?php  if(is_array($allkm)) { foreach($allkm as $it) { ?>
									 <option value="<?php  echo $it['sname'];?>" <?php  if($it['sname'] == $row['exam_course']) { ?> selected="selected"<?php  } ?>><?php  echo $it['sname'];?></option>
									<?php  } } ?>
								</select>						
								</div>
								<label class="col-sm-2" style="width:8%;padding: 0px;text-align: right;">开始时间</label>
								<div class="col-sm-2 col-lg-2" style="width:8%">
									<?php  echo tpl_form_field_clock('exam_start_time[$key]',$row['exam_start_time'])?>
								</div>
								<label class="col-sm-2" style="width:8%;padding: 0px;text-align: right;">结束时间</label>
								<div class="col-sm-2 col-lg-2" style="width:8%">
									<?php  echo tpl_form_field_clock('exam_end_time[$key]',$row['exam_end_time'])?>
								</div>
								<label class="col-sm-2" style="width:5%;padding: 0px;text-align: right;">监考老师1</label>
								<div class="col-sm-2 col-lg-2">
									<select style="margin-right:15px;" name="exam_teacher1[$key]" class="form-control">
										<option value="0">选择老师</option>
										<?php  if(is_array($allteacher)) { foreach($allteacher as $it) { ?>
										 <option value="<?php  echo $it['tname'];?>" <?php  if($it['tname'] == $row['exam_teacher1']) { ?> selected="selected"<?php  } ?>><?php  echo $it['tname'];?></option>
										<?php  } } ?>
									</select>							
								</div>
								<label class="col-sm-2" style="width:5%;padding: 0px;text-align: right;">监考老师2</label>
								<div class="col-sm-2 col-lg-2">
									<select style="margin-right:15px;" name="exam_teacher2[$key]" class="form-control">
										<option value="0">选择老师</option>
										<?php  if(is_array($allteacher)) { foreach($allteacher as $it) { ?>
										 <option value="<?php  echo $it['tname'];?>" <?php  if($it['tname'] == $row['exam_teacher2']) { ?> selected="selected"<?php  } ?>><?php  echo $it['tname'];?></option>
										<?php  } } ?>
									</select>							
								</div>
								<div class="col-sm-1" style="margin-top:5px">
									<a href="javascript:;" class="custom-url-del"><i class="fa fa-times-circle"></i></a>
								</div>							
							</div>
						<?php  } } ?>	
					<?php  } else { ?>
						<input type="hidden" name="new[0]" value="111" />
						<div class="form-group">
							<label class="col-sm-2" style="width:5%;padding: 0px;text-align: right;">科目</label>
							<div class="col-sm-2 col-lg-2">
							<select style="margin-right:15px;" name="exam_course[0]" class="form-control">
								<option value="0">科目</option>
								<?php  if(is_array($allkm)) { foreach($allkm as $it) { ?>
									<option value="<?php  echo $it['sname'];?>"><?php  echo $it['sname'];?></option>
								<?php  } } ?>
							</select>						
							</div>
							<label class="col-sm-2" style="width:8%;padding: 0px;text-align: right;">开始时间</label>
							<div class="col-sm-2 col-lg-2" style="width:8%">
								<?php  echo tpl_form_field_clock('exam_start_time[0]')?>
							</div>
							<label class="col-sm-2" style="width:8%;padding: 0px;text-align: right;">结束时间</label>
							<div class="col-sm-2 col-lg-2" style="width:8%">
								<?php  echo tpl_form_field_clock('exam_end_time[0]')?>
							</div>
							<label class="col-sm-2" style="width:5%;padding: 0px;text-align: right;">监考老师1</label>
							<div class="col-sm-2 col-lg-2">
								<select style="margin-right:15px;" name="exam_teacher1[0]" class="form-control">
									<option value="0">选择老师</option>
									<?php  if(is_array($allteacher)) { foreach($allteacher as $it) { ?>
									 <option value="<?php  echo $it['tname'];?>"><?php  echo $it['tname'];?></option>
									<?php  } } ?>
								</select>							
							</div>
							<label class="col-sm-2" style="width:5%;padding: 0px;text-align: right;">监考老师2</label>
							<div class="col-sm-2 col-lg-2">
								<select style="margin-right:15px;" name="exam_teacher2[0]" class="form-control">
									<option value="0">选择老师</option>
									<?php  if(is_array($allteacher)) { foreach($allteacher as $it) { ?>
									 <option value="<?php  echo $it['tname'];?>"><?php  echo $it['tname'];?></option>
									<?php  } } ?>
								</select>							
							</div>					
						</div>
					<?php  } ?>
                </div>
				<div class="clearfix template"> 
					<div class="form-group">
						<label class="col-xs-12 col-sm-3 col-md-2 control-label"></label>
						<div class="col-sm-9 col-xs-12">
							<a href="javascript:;" id="custom-url-add"><i class="fa fa-plus-circle"></i> 添加安排</a>
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
	<?php  if(!empty($exam_plan)) { ?>
		var sid = "<?php  echo $lastkey;?>";
		var i = sid + 1;
	<?php  } else { ?>
		var i = 1;
	<?php  } ?>
	$('#custom-url-add').click(function(){
	var html =  '<div class="form-group">'+
				'<input type="hidden" name="new['+i+']" value="111" />'+
				'		<label class="col-sm-2" style="width:5%;padding: 0px;text-align: right;">科目</label>'+
				'		<div class="col-sm-2 col-lg-2">'+
				'		<select style="margin-right:15px;" name="exam_course['+i+']" class="form-control">'+
				'			<option value="0">科目</option>'+
							<?php  if(is_array($allkm)) { foreach($allkm as $it) { ?>
				'				<option value="<?php  echo $it['sname'];?>"><?php  echo $it['sname'];?></option>'+
							<?php  } } ?>
				'		</select>'+						
				'		</div>'+
				'		<label class="col-sm-2" style="width:8%;padding: 0px;text-align: right;">结束时间</label>'+
				'		<div class="col-sm-2 col-lg-2" style="width:8%">'+
				'			<div class="input-group clockpicker">'+
				'				<span class="input-group-addon"><i class="fa fa-clock-o"></i></span>'+
				'				<input type="text" name="exam_start_time['+i+']"  class="form-control">'+
				'			</div>'+							
				'		</div>'+
				'		<label class="col-sm-2" style="width:8%;padding: 0px;text-align: right;">结束时间</label>'+
				'		<div class="col-sm-2 col-lg-2" style="width:8%">'+
				'			<div class="input-group clockpicker">'+
				'				<span class="input-group-addon"><i class="fa fa-clock-o"></i></span>'+
				'				<input type="text" name="exam_end_time['+i+']"  class="form-control">'+
				'			</div>'+				
				'		</div>'+
				'		<label class="col-sm-2" style="width:5%;padding: 0px;text-align: right;">监考老师1</label>'+
				'		<div class="col-sm-2 col-lg-2">'+
				'			<select style="margin-right:15px;" name="exam_teacher1['+i+']" class="form-control">'+
				'				<option value="0">选择老师</option>'+
								<?php  if(is_array($allteacher)) { foreach($allteacher as $it) { ?>
				'				 <option value="<?php  echo $it['tname'];?>"><?php  echo $it['tname'];?></option>'+
								<?php  } } ?>
				'			</select>'+							
				'		</div>'+
				'		<label class="col-sm-2" style="width:5%;padding: 0px;text-align: right;">监考老师2</label>'+
				'		<div class="col-sm-2 col-lg-2">'+
				'			<select style="margin-right:15px;" name="exam_teacher2['+i+']" class="form-control">'+
				'				<option value="0">选择老师</option>'+
								<?php  if(is_array($allteacher)) { foreach($allteacher as $it) { ?>
				'				 <option value="<?php  echo $it['tname'];?>"><?php  echo $it['tname'];?></option>'+
								<?php  } } ?>
				'			</select>'+							
				'		</div>'+
				'	<div class="col-sm-1" style="margin-top:5px">'+
				'   	<a href="javascript:;" class="custom-url-del"><i class="fa fa-times-circle"></i></a>'+
				'	</div>'+				
				'</div>';
			;			
	$('#custom-url').append(html);
	$("[name = 'exam_start_time["+i+"]']").clockpicker({autoclose: true});
	$("[name = 'exam_end_time["+i+"]']").clockpicker({autoclose: true});
	i++;
});

$(document).on('click', '.custom-url-del', function(){
	$(this).parent().parent().remove();
	return false;
});	
</script>
<?php  } ?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('public/footer', TEMPLATE_INCLUDEPATH)) : (include template('public/footer', TEMPLATE_INCLUDEPATH));?>