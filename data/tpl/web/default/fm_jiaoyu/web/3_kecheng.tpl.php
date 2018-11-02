<?php defined('IN_IA') or exit('Access Denied');?><?php 
	
?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('public/header', TEMPLATE_INCLUDEPATH)) : (include template('public/header', TEMPLATE_INCLUDEPATH));?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('public/comhead', TEMPLATE_INCLUDEPATH)) : (include template('public/comhead', TEMPLATE_INCLUDEPATH));?>
<div class="panel panel-info">
	<div class="panel-body">
		<ul class="nav nav-tabs">
			<li <?php  if($_GPC['do']=='kecheng') { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('kecheng', array('op' => 'display', 'schoolid' => $schoolid))?>">课程系统</a></li>
			<?php  if(($tid_global =='founder' || $tid_global == 'owner' || (IsHasQx($tid_global,1000921,1,$schoolid)))) { ?>
			<li <?php  if($_GPC['do']=='kcbiao') { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('kcbiao', array('op' => 'display', 'schoolid' => $schoolid))?>">课时管理</a></li>
			<?php  } ?>
			<?php  if(($tid_global =='founder'|| $tid_global == 'owner' || (IsHasQx($tid_global,1000941,1,$schoolid))) ) { ?>
			<li <?php  if($_GPC['do']=='kcsign') { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('kcsign', array('op' => 'display', 'schoolid' => $schoolid))?>">签到管理</a></li>
			<?php  } ?>
			<?php  if(((is_showgkk() && ((IsHasQx($tid_global,1000951,1,$schoolid)) || $tid_global =='founder'|| $tid_global == 'owner')) )) { ?>
			<li <?php  if($_GPC['do']=='gongkaike') { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('gongkaike', array('op' => 'display', 'schoolid' => $schoolid))?>">公开课系统</a></li>
			<?php  } ?>
		</ul>	
	</div>
</div>
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
        .form-control-excel {
            height: 34px;
            padding: 6px 12px;
            font-size: 14px;
            line-height: 1.42857143;
            color: #555;
            background-color: #fff;
            background-image: none;
            border: 1px solid #ccc;
            border-radius: 4px;
            -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
            box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
            -webkit-transition: border-color ease-in-out .15s,-webkit-box-shadow ease-in-out .15s;
            -o-transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;
            transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;
        }
    </style>
    <div class="panel panel-info">
        <div class="panel-heading">课程管理</div>
        <div class="panel-body">
            <form action="./index.php" method="get" class="form-horizontal" role="form">
                <input type="hidden" name="c" value="site" />
                <input type="hidden" name="a" value="entry" />
                <input type="hidden" name="m" value="fm_jiaoyu" />
                <input type="hidden" name="do" value="kecheng" />
				<input type="hidden" name="schoolid" value="<?php  echo $schoolid;?>" />
				<div class="form-group">
					   <label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label" style="width: 100px;">课程状态</label>
					<div class="col-sm-9 col-xs-9 col-md-9">
						<div class="btn-group">
							<a href="<?php  echo $this->createWebUrl('kecheng', array('id' => $item['id'], 'is_start' => '-1', 'schoolid' => $schoolid))?>" class="btn <?php  if($is_start == -1) { ?>btn-primary<?php  } else { ?>btn-default<?php  } ?>">不限</a>
							<a href="<?php  echo $this->createWebUrl('kecheng', array('id' => $item['id'], 'is_start' => '1', 'schoolid' => $schoolid))?>" class="btn <?php  if($is_start == 1) { ?>btn-primary<?php  } else { ?>btn-default<?php  } ?>">未开始</a>
							<a href="<?php  echo $this->createWebUrl('kecheng', array('id' => $item['id'], 'is_start' => '2', 'schoolid' => $schoolid))?>" class="btn <?php  if($is_start == 2) { ?>btn-primary<?php  } else { ?>btn-default<?php  } ?>">进行中</a>
							<a href="<?php  echo $this->createWebUrl('kecheng', array('id' => $item['id'], 'is_start' => '3', 'schoolid' => $schoolid))?>" class="btn <?php  if($is_start == 3) { ?>btn-primary<?php  } else { ?>btn-default<?php  } ?>">已结束</a>
						</div>
					</div>
				</div>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label" style="width: 100px;">按课程名称</label>
                    <div class="col-sm-2 col-lg-2">
                        <input class="form-control" name="name" id="" type="text" value="<?php  echo $_GPC['name'];?>">
                    </div>
                    <label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label" style="width: 100px;">按教师名称</label>
                    <div class="col-sm-2 col-lg-2">
                        <input class="form-control" name="tname" id="" type="text" value="<?php  echo $_GPC['tname'];?>">
                    </div>
					<?php  if($school['issale'] != 5) { ?>
                    <div class="col-sm-2 col-lg-2">
						<a class="btn btn-default qx_931" href="<?php  echo $this->createWebUrl('baoming', array('schoolid' => $schoolid))?>">查看报名列表</a>
                    </div>
                    <?php  } ?>
                    <!--预约情况列表是已经做好了的-->
<!--
                    <div class="col-sm-2 col-lg-2">
						<a class="btn btn-success" href="<?php  echo $this->createWebUrl('kcyy', array('schoolid' => $schoolid))?>">查看预约列表</a>
                    </div>	-->				
				</div>	
				<div class="form-group">
						<label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label" style="width: 100px;">按班级</label>
						<div class="col-sm-2 col-lg-2">
							<select style="margin-right:15px;" name="bj_id" class="form-control">
								<option value="0">请选择班级搜索</option>
								<?php  if(is_array($bj)) { foreach($bj as $row) { ?>
								<option value="<?php  echo $row['sid'];?>" <?php  if($row['sid'] == $_GPC['bj_id']) { ?> selected="selected"<?php  } ?>><?php  echo $row['sname'];?></option>
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
							<a class="btn btn-primary qx_602" href="<?php  echo $this->createWebUrl('kecheng', array('op'=>post, 'schoolid' => $schoolid))?>" ><i class="fa fa-plus"></i> 新增课程</a>
						</div>						
						<div class="col-sm-2 col-lg-2" style="width:8%">						
							<a class="btn btn-success qx_903" href="javascript:;"  onclick="$('.file-container').slideToggle()">批量导入课程</a>
						</div>
				</div>	
            </form>
			<div class="form-group">
				 <div class="col-sm-2 col-lg-2 qx_932" style="width:6%">						
					<a class="btn btn-success"  onclick="show_order(1)">购买课程</a>
				</div>
				 <div class="col-sm-2 col-lg-2 qx_932" style="width:6%">						
					<a class="btn btn-success"  onclick="show_order(2)">续购课程</a>
				</div>
			</div>
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
                <input type="hidden" name="ac" value="kecheng" />
				<input type="hidden" name="schoolid" value="<?php  echo $schoolid;?>" />

                <a class="btn btn-primary" href="javascript:location.reload()"><i class="fa fa-refresh"></i> 刷新</a>
                <input name="viewfile" id="viewfile" type="text" value="" style="margin-left: 40px;" class="form-control-excel" readonly>
                <a class="btn btn-primary"><label for="unload" style="margin: 0px;padding: 0px;">上传...</label></a>
                <input type="file" class="pull-left btn-primary span3" name="inputExcel" id="unload" style="display: none;"
                       onchange="document.getElementById('viewfile').value=this.value;this.style.display='none';">
                <input type="submit" class="btn btn-primary" name="btnExcel" value="导入数据">
                <a class="btn btn-primary" href="../addons/fm_jiaoyu/public/example/example_kecheng.xls">下载导入模板</a>
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
                    <th class='with-checkbox' style="width: 20px;"><input type="checkbox" class="check_all" /></th>
					<th style="width:5%;">排序</th>
					<th style="width:5%">课程ID</th>
					<th style="width:10%">课程图片/名称</th>
					<th style="width:6%">授课教师</th>
					<th style="width:13%;">详情</th>
					<th style="width:8%;">课程类型</th>
					<th style="width:8%;">科目/教室</th>	
					<th style="width:10%;">课程费用</th>
					<th style="width:8%;">已报/限报</th>
					<th style="width:8%;">报名情况</th>					
					<th style="width:10%;">授课班级/年级</th>
					<th style="width:8%;">总课时/状态</th>	
                    <th class="qx_t_c" style="width:5%;">添加课表</th>					
					<th class="qx_e_d" style="text-align:right; width:8%;">操作</th>
				</tr>
			</thead>
			<tbody>
				<?php  if(is_array($list)) { foreach($list as $item) { ?>
				<tr>
                    <td class="with-checkbox"><input type="checkbox" name="check" value="<?php  echo $item['id'];?>"></td>
					<td><input type="text" class="form-control" name="ssort[<?php  echo $item['id'];?>]" value="<?php  echo $item['ssort'];?>"></td>
					<td style="text-align:center;color:red;font-size:20px;font-weight:blod;"><?php  echo $item['id'];?></td>
					<td><img src="<?php  echo tomedia($item['thumb'])?>" width="50"></br><span class="label label-danger"><?php  echo $item['name'];?></span></td>
					<td style="overflow:visible; word-break:break-all; text-overflow:auto;white-space:normal">
						<?php  if(is_array($item['tname'])) { foreach($item['tname'] as $v) { ?> 
						<?php  if($v['tid'] == $item['maintid']) { ?>
						<span class="label label-danger" style="background-color: #8a6461;"><?php  echo $v['tname'];?></span>
						<?php  } else { ?>
						<?php  echo $v['tname'];?>
						<?php  } ?>
						</br> 
						<?php  } } ?>
						</td>
					<td style="overflow:visible; word-break:break-all; text-overflow:auto;white-space:normal">
              	      <div>
		              	    <?php  if($item['is_hot']==1) { ?>
							<span class="label label-danger">精品课</span>
							<?php  } ?>
						
							
		              	    </br>
		              	    <span class="label label-info">
			              	    <?php  echo date('Y-m-d',$item['start'])." 至 ".date('Y-m-d',$item['end'])?>
		              	    </span>
		              	    <?php  if($item['isSign'] && $item['OldOrNew'] == 0 ) { ?>
		              	    <span class="label label-inverse">开课前<?php  echo $item['signTime'];?>分钟签到</span>
		              	    <?php  } ?>
	              	    </div>                    
                    </td>
                    <td>
                    	<?php  if($item['OldOrNew'] == 0) { ?>
						<span class="label label-success">固定课表课程</span>
						<?php  } else if($item['OldOrNew'] == 1) { ?>
						<span class="label label-warning">自由签到课程</span>
						<?php  } ?>
						</br></br>
						<span class="label label-danger"><?php  echo $item['course_type'];?></span>
                    </td>
                    <td>
                        <?php  if(!empty($category[$item['km_id']])) { ?><?php  echo $category[$item['km_id']]['sname'];?><?php  } ?>
                    	</br>
                    	<?php  if(!empty($category[$item['adrr']])) { ?><?php  echo $category[$item['adrr']]['sname'];?><?php  } ?>
                    	
                    </td>
					<td style="overflow:visible; word-break:break-all; text-overflow:visible;white-space:normal">
						<?php  if($item['OldOrNew'] == 1 ) { ?>
						&nbsp;&nbsp;<span class="label label-warning" style="font-weight:bold;">首购￥<?php  echo $item['cose'];?></span>
						</br>
						【包含<?php  echo $item['FirstNum'];?>课时】
						</br>
						&nbsp;&nbsp;<span class="label label-danger" style="font-weight:bold;">续购￥<?php  echo $item['RePrice'];?></span>
						</br>
						【<?php  echo $item['ReNum'];?>课时起续】
						<?php  } else { ?>
							<?php  if(empty($item['FirstNum'])) { ?>
							&nbsp;<span class="label label-warning" style="font-weight:bold;">￥<?php  echo $item['cose'];?></span>
							<?php  } else if(!empty($item['FirstNum'])) { ?>
							&nbsp;&nbsp;<span class="label label-warning" style="font-weight:bold;">首购￥<?php  echo $item['cose'];?></span>
							</br>
							【包含<?php  echo $item['FirstNum'];?>课时】
							</br>
							&nbsp;&nbsp;<span class="label label-danger" style="font-weight:bold;">续购￥<?php  echo $item['RePrice'];?></span>
							</br>
							【<?php  echo $item['ReNum'];?>课时起续】
							<?php  } ?>
						<?php  } ?>
						</td>	
					<td style="overflow:visible; word-break:break-all; text-overflow:visible;white-space:normal"><span class="label label-success"><?php  echo $item['yib'];?></span> /&nbsp; <span class="label label-danger"><?php  echo $item['minge'];?></span></td>
					<td><a class="btn btn-default btn-sm qx_931" href="<?php  echo $this->createWebUrl('baoming', array('kcid' => $item['id'], 'schoolid' => $schoolid))?>" title="报名情况"><i class="fa fa-qrcode">&nbsp;&nbsp;报名情况</i></a>
					<?php  if($item['OldOrNew'] == 0) { ?>
					<a class="btn btn-default btn-sm qx_921" href="<?php  echo $this->createWebUrl('kcbiao', array('kcName' => $item['name'], 'schoolid' => $schoolid,'fromKe'=>'fromKe'))?>" title="查看课时"><i class="fa fa-tasks">&nbsp;&nbsp;查看课时</i></a>	
					<?php  } ?>
					</td>
                    <td>
					    <?php  if(!empty($category[$item['xq_id']])) { ?><?php  echo $category[$item['xq_id']]['sname'];?></br><?php  } ?>
                        <?php  if(!empty($category[$item['bj_id']])) { ?><?php  echo $category[$item['bj_id']]['sname'];?><?php  } ?></br><?php  if(!empty($category[$item['xq_id']])) { ?><?php  } else { ?><?php  } ?>
                    </td>					
					
                    <td style="overflow:visible; word-break:break-all; text-overflow:visible;white-space:normal">
	                    <span class="label label-warning">共<?php  echo $item['allks'];?>个课时</span>
	                    </br></br>
                    <?php  if($item['start']>TIMESTAMP) { ?><span class="label label-default">未开始</span><?php  } ?>
                    <?php  if($item['start']<TIMESTAMP && $item['end']>TIMESTAMP) { ?><span class="label label-info">授课中</span><?php  } ?>
                    <?php  if($item['end']<TIMESTAMP) { ?><span class="label label-warning">结束</span><?php  } ?></br></br>
					<?php  if($item['is_show'] == 1) { ?><span class="label label-success">显示</span><?php  } else { ?><span class="label label-danger">不显示</span><?php  } ?>
                    </td>
                    <td class="qx_t_c">
	                    <?php  if($item['end']>TIMESTAMP) { ?>
		                    <?php  if($item['OldOrNew'] == 0 ) { ?>
		                    <a class="btn btn-default btn-sm qx_922" href="<?php  echo $this->createWebUrl('kecheng', array('id' => $item['id'], 'op' => 'add', 'schoolid' => $schoolid))?>" title="添加课表"><i class="fa fa-qrcode">&nbsp;&nbsp;添加课表</i></a>
		                    <?php  } else if($item['OldOrNew'] == 1) { ?>
		                    <span class="label label-default"><i class="fa fa-codepen">&nbsp;&nbsp;自由课时</i></span>
		                    <?php  } ?>
	                    <?php  } else if($item['end']<TIMESTAMP) { ?>
							<span class="label label-default">已结课</i></span>
							<a class="btn btn-default btn-sm qx_911" href="<?php  echo $this->createWebUrl('kcpingjiashow', array('kcid' => $item['id'],  'schoolid' => $schoolid))?>" title="查看评论"><i class="fa fa-qrcode">&nbsp;&nbsp;查看评论</i></a>
	                    <?php  } ?>
                    </td>					
					<td class="qx_e_d" style="text-align:right;">
						<a class="btn btn-default btn-sm qx_902" href="<?php  echo $this->createWebUrl('kecheng', array('id' => $item['id'], 'op' => 'post', 'schoolid' => $schoolid))?>" title="编辑"><i class="fa fa-pencil"></i></a>&nbsp;&nbsp;<a class="btn btn-default btn-sm qx_904" href="<?php  echo $this->createWebUrl('kecheng', array('id' => $item['id'], 'op' => 'delete', 'schoolid' => $schoolid))?>" onclick="return confirm('此操作不可恢复，确认删除？');return false;" title="删除"><i class="fa fa-times"></i></a>
					</td>
				</tr>
				<?php  } } ?>
			</tbody>
			<tr>
				<td colspan="7">
                    <input name="submit" type="submit" class="btn btn-primary qx_902" value="批量修改排序">
                    <input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
                </td>			
				<td colspan="10">
					<input name="token" type="hidden" value="<?php  echo $_W['token'];?>" />
                    <input type="button" class="btn btn-primary qx_904" name="btndeleteall" value="批量删除" />
				</td>
			</tr>
		</table>
        <?php  echo $pager;?>
    </form>
        </div>
    </div>
</div>

<div class="modal fade" id="Modal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="margin-top:60px;">
	<div class="modal-dialog modal-lg" role="document">		
		<div class="modal-content">			
			<div class="modal-header" style="color: black;">					
				<h4 class="modal-title" id="ModalTitle">弹框</h4>	
			</div>
			<div class="modal-body">
				 <div class="form-group">
					<label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label" style="width: 100px;">选择课程:</label>
                    <div class="col-sm-2 col-lg-2" style="width: 20%">
                        <select style="margin-right:15px;" name="select_kc" id="select_kc" class="form-control">
                            <option value="0">请选择课程</option>
                            <?php  if(is_array($listAll)) { foreach($listAll as $it) { ?>
                            <?php  if($it['end']>TIMESTAMP) { ?>
                            <option value="<?php  echo $it['id'];?>" ><?php  echo $it['name'];?></option>
                            <?php  } ?>
                            <?php  } } ?>
                        </select>
                    </div>
                    <label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label xugoukc" style="width: 100px;display: none;">续购课时:</label>
                    <div class="col-sm-2 col-lg-2 xugoukc" style="width: 20%;display: none;">
                       <input type="number" name="xgnum" id="xgnum" class="form-control">
                    </div>
                </div>
                <div class="form-group" style="height:30px"></div>
                <div class="form-group nj_bj" style="display:none;" >
					<label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label" style="width: 100px;">选择年级:</label>
                    <div class="col-sm-2 col-lg-2" style="width: 20%">
                        <select style="margin-right:15px;" name="nj_kcbuy" id="select_nj_kcbuy" class="form-control">
                            <option value="0">请选择年级</option>
                            <?php  if(is_array($xueqi)) { foreach($xueqi as $it) { ?>
                            <option value="<?php  echo $it['sid'];?>" ><?php  echo $it['sname'];?></option>
                            <?php  } } ?>
                        </select>
                    </div>
					<label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label" style="width: 100px;">选择班级:</label>
                    <div class="col-sm-2 col-lg-2" style="width: 20%">
                        <select style="margin-right:15px;" name="bj_kcbuy" id="bj_kcbuy" class="form-control">
                            <option value="0">请选择班级</option>
                            <?php  if(is_array($bj)) { foreach($bj as $it) { ?>
                            <option value="<?php  echo $it['sid'];?>"><?php  echo $it['sname'];?></option>
                            <?php  } } ?>
                        </select>
                    </div>
				</div>
				<div class="form-group nj_bj" style="height:30px"></div>
				 <div class="form-group">
	               <label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label" style="width: 100px;">选择学生</label>
					<div class="col-sm-9 col-xs-6">
						<div class="input-group text-info" id="stulist">
                           抱歉，找不到学生，请重新选择班级
						</div>
					
					</div>
				</div>			
			</div>				
			<div class="modal-footer">	
				<button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
				<button type="button" class="btn btn-primary" id="submit1" onclick="buy_kc()" style="display: none;">确认生成订单</button>
				<button type="button" class="btn btn-primary" id="submit2" onclick="xugou_kc()" style="display: none;">确认生成订单</button>
			</div>			
		</div>	
	</div>
</div>
<script type="text/javascript">
//显示弹框
function show_order(id){
	
	var id=id;
	if(id == 1 ){
		$("#ModalTitle").html("购买课程");
		$('#stulist').html('抱歉，找不到学生，请重新选择班级');	
		$("#select_kc").removeClass("xugoukc");
		$(".xugoukc").hide();
		$("#submit2").hide();
		$(".nj_bj").show();
		$("#submit1").show();
	}else if(id ==2 ){
		$("#ModalTitle").html("续购课程");
		$('#stulist').html('抱歉，找不到学生，请重新选择课程');	
		$("#select_kc").addClass("xugoukc");
		$(".nj_bj").hide();
		$("#submit1").hide();
		$(".xugoukc").show();
		$("#submit2").show();
	}
	$('#Modal1').modal('toggle'); 
}

//班级动作
$('#bj_kcbuy').change(function(){
	var schoolid = "<?php  echo $schoolid;?>";
	var kcid = $("#select_kc").val();
	var bjId = $("#bj_kcbuy option:selected").attr('value');	
	if(bjId != null && bjId != 0){
		$.post("<?php  echo $this->createWebUrl('indexajax',array('op'=>'getstu_bj'))?>", {'bjId': bjId, 'schoolid': schoolid,'kcid':kcid}, function(data) {
			data = JSON.parse(data);
			stulist = data.stulist;
			console.log(data);
			var html   = '';
			if (stulist != '') {
				for (var i in stulist) {
					if(stulist[i].check != true){
						html += '<label  class="checkbox-inline" style="width:20%;min-width:85px;margin-left: 10px"><input type="checkbox" name="sidarr"  value="'+stulist[i].id+'"style="float: none;" > '+stulist[i].s_name+'</label>';
					}
				}
			}
			$('#stulist').html(html);	
		});

	}
});

//课程动作
$('#select_kc').change(function(){
	var schoolid = "<?php  echo $schoolid;?>";
	var kcid = $("#select_kc").val();
	var bjId = $("#bj_kcbuy option:selected").attr('value');
	if(kcid != null && kcid != 0){
		if($("#select_kc").hasClass("xugoukc")){
			$.post("<?php  echo $this->createWebUrl('indexajax',array('op'=>'getstu_kc'))?>", {'schoolid': schoolid,'kcid':kcid}, function(data) {
					data = JSON.parse(data);
					stulist = data.stulist;
					console.log(data);
					var html   = '';
					if (stulist != '') {
						for (var i in stulist) {
							if(stulist[i].check != true){
						html += '<label  class="checkbox-inline" style="width:20%;min-width:85px;margin-left: 10px"><input type="checkbox" name="sidarr"  value="'+stulist[i].id+'"style="float: none;" > '+stulist[i].s_name+'</label>';
					}
						}
					}
					$('#stulist').html(html);	
				});
			
		}else{
			if(bjId != null && bjId != 0){
				$.post("<?php  echo $this->createWebUrl('indexajax',array('op'=>'getstu_bj'))?>", {'bjId': bjId, 'schoolid': schoolid,'kcid':kcid}, function(data) {
					data = JSON.parse(data);
					stulist = data.stulist;
					console.log(data);
					var html   = '';
					if (stulist != '') {
						for (var i in stulist) {
						if(stulist[i].check != true){
						html += '<label  class="checkbox-inline" style="width:20%;min-width:85px;margin-left: 10px"><input type="checkbox" name="sidarr"  value="'+stulist[i].id+'"style="float: none;" > '+stulist[i].s_name+'</label>';
					}
						}
					}
					$('#stulist').html(html);	
				});
			}
		}
	}
});

//购买
function buy_kc(){
	var schoolid = "<?php  echo $schoolid;?>";
	var kcid = $("#select_kc").val();
	var str = new Array();
	$("input:checkbox[name='sidarr']:checked").each(function(i) {
		var val = $(this).val();
		str[i] =  val ;
	});
	console.log(str);
	console.log(kcid);
	$.post("<?php  echo $this->createWebUrl('indexajax',array('op'=>'buy_kc'))?>", {'schoolid': schoolid,'tid':"<?php  echo $_W['tid'];?>",'kcid':kcid,'sidarr':str}, function(data) {
		data = JSON.parse(data);
		alert(data.msg)
 		location.reload();
	});
}

//续购
function xugou_kc(){
	var schoolid = "<?php  echo $schoolid;?>";
	var kcid = $("#select_kc").val();
	var str = new Array();
	var xgnum = $("#xgnum").val();
	$("input:checkbox[name='sidarr']:checked").each(function(i) {
		var val = $(this).val();
		str[i] =  val ;
	});
	console.log(str);
	console.log(kcid);
	$.post("<?php  echo $this->createWebUrl('indexajax',array('op'=>'xugou_kc'))?>", {'schoolid': schoolid,'tid':"<?php  echo $_W['tid'];?>",'kcid':kcid,'sidarr':str,'ksnum':xgnum}, function(data) {
		data = JSON.parse(data);
		alert(data.msg)
 		location.reload();
 		
	});
}
//班级年级联动
$("#select_nj_kcbuy").change(function() {
	var type = 4;
	var cityId = $("#select_nj_kcbuy option:selected").attr('value');
	changeGrade(cityId,type, function() {});
});
function changeGrade(gradeId, type, __result) {
	var schoolid = "<?php  echo $schoolid;?>";
	var classlevel = [];
	//获取班次
	$.post("<?php  echo $this->createWebUrl('indexajax',array('op'=>'getbjlist'))?>", {'gradeId': gradeId, 'schoolid': schoolid}, function(data) {
		data       = JSON.parse(data);
		classlevel = data.bjlist;
		var html   = '';
		
		html += '<select id="bj_kcbuy"><option value="">请选择班级</option>';
		if (classlevel != '') {
			for (var i in classlevel) {
				html += '<option value="' + classlevel[i].sid + '">' + classlevel[i].sname + '</option>';
			}
		}
		$('#bj_kcbuy').html(html);	
	});
}


$(function(){
	var e_d = 2 ;
	var t_c = 2 ;
	<?php  if(!(IsHasQx($tid_global,1000902,1,$schoolid))) { ?>
		$(".qx_902").hide();
		e_d = e_d -1;
	<?php  } ?>
	<?php  if(!(IsHasQx($tid_global,1000903,1,$schoolid))) { ?>
		$(".qx_903").hide();
	<?php  } ?>
	<?php  if(!(IsHasQx($tid_global,1000911,1,$schoolid))) { ?>
		$(".qx_911").hide();
		t_c = t_c - 1 ;
	<?php  } ?>
	<?php  if(!(IsHasQx($tid_global,1000921,1,$schoolid))) { ?>
		$(".qx_921").hide();
	<?php  } ?>
	<?php  if(!(IsHasQx($tid_global,1000922,1,$schoolid))) { ?>
		$(".qx_922").hide();
		t_c = t_c - 1 ;
	<?php  } ?>
	<?php  if(!(IsHasQx($tid_global,1000931,1,$schoolid))) { ?>
		$(".qx_931").hide();
	<?php  } ?>
	<?php  if(!(IsHasQx($tid_global,1000932,1,$schoolid))) { ?>
		$(".qx_932").hide();
	<?php  } ?>
	<?php  if(!(IsHasQx($tid_global,1000904,1,$schoolid))) { ?>
		$(".qx_904").hide();
		e_d = e_d -1;
	<?php  } ?>
	
	if(e_d == 0){
		$(".qx_e_d").hide();
	}
	if(t_c == 0){
		$(".qx_t_c").hide();
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
            var url = "<?php  echo $this->createWebUrl('kecheng', array('op' => 'deleteall', 'schoolid' => $schoolid))?>";
            $.post(
                url,
                {idArr:id},
                function(data){
                    alert('操作成功!');
                    location.reload();
                },'json'
            );
        }
    });
});
</script>
<?php  } else if($operation == 'post') { ?>
<div class="panel panel-info">
   <div class="panel-heading"><a class="btn btn-primary" onclick="javascript :history.back(-1);"><i class="fa fa-tasks"></i>返回课程列表</a></div>
</div>
<div class="main">
<form action="" method="post" class="form-horizontal form" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php  echo $item['id'];?>" />
		<input type="hidden" name="schoolid" value="<?php  echo $schoolid;?>" />
        <div class="panel panel-default">
            <div class="panel-heading">编辑课程</div>
            <div class="panel-body">
				<div class="form-group">	
                    <label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label" style="width: 100px;">前端排序：</label>
                    <div class="col-sm-2 col-lg-2">
                         <div class="input-group">					
                            <input type="text" class="form-control" name="ssort" value="<?php  echo $item['ssort'];?>" />
                         </div>
						 <div class="help-block">数值越大手机前端显示越靠前</div>
					</div>
					<label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label" style="width: 100px;">是否显示：</label>
                    <div class="col-sm-2 col-lg-2">
                        <label class="radio-inline">
                            <input type="radio" name="is_show" value="1" <?php  if($item['is_show']==1) { ?>checked<?php  } ?>>是
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="is_show" value="2" <?php  if($item['is_show']==2) { ?>checked<?php  } ?>>否
                        </label>
                        <div class="help-block">前端是否显示:默认显示</div>
                    </div>									
                </div>	
                <div class="form-group">
	                <label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label" style="width: 100px;">是否推荐：</label>
                    <div class="col-sm-2 col-lg-2">
                        <label class="radio-inline">
                            <input type="radio" name="is_tuijian" value="1" <?php  if($item['is_tuijian']==1) { ?>checked<?php  } ?>>是
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="is_tuijian" value="0" <?php  if($item['is_tuijian']==0) { ?>checked<?php  } ?>>否
                        </label>
                        <div class="help-block">推荐课程在首页以大图形式展示</div>
                    </div>
	                </div>		
			    <div class="form-group">
                    <label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label" style="width: 100px;"  >课程名称：</label>
                    <div class="col-sm-9">                       
                            <input type="text" class="form-control" name="name" value="<?php  echo $item['name'];?>" required="required" oninvalid="setCustomValidity('课程名不能为空！');" oninput="setCustomValidity('');"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label" style="width: 100px;">课程图片：</label>
                    <div class="col-sm-9 col-xs-12">                    
                          <?php  echo tpl_form_field_image('kcthumb', $item['thumb'])?>
                   <div class="help-block">图片尺寸必须为400*400 </div>
					</div>
                </div>
                
                 <div class="form-group">
					<label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label" style="width: 100px;">课程标签:</label>
                    <div class="col-sm-2 col-lg-2">
                        <select style="margin-right:15px;" name="OldOrNew" id="OldOrNew" class="form-control" <?php  if($item) { ?> disabled<?php  } ?>> 
                            <option value="0" <?php  if($item['OldOrNew'] == 0) { ?> selected="selected"<?php  } ?>>固定课表课程</option>
                            <option value="1" <?php  if($item['OldOrNew'] == 1) { ?> selected="selected"<?php  } ?>>自由签到课程</option>
                        </select>
                    </div>
                    <label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label" style="width: 100px;">课程类型:</label>
                    <div class="col-sm-2 col-lg-2">
                        <select style="margin-right:15px;" name="Ctype" id="Ctype" class="form-control">
                            <option value="0" <?php  if($item['Ctype'] == 0) { ?> selected="selected"<?php  } ?>>默认类型</option>
                            <?php  if(is_array($courseType)) { foreach($courseType as $row) { ?>
                            <option value="<?php  echo $row['sid'];?>" <?php  if($item['Ctype'] == $row['sid']) { ?> selected="selected"<?php  } ?>><?php  echo $row['sname'];?></option>
                            <?php  } } ?>
                        </select>
                    </div>					
				</div>
				<div class="form-group" >
					<label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label"  id="signd" <?php  if($item['OldOrNew'] ==1) { ?>style="display: none;width: 100px;" <?php  } else { ?> style="display: block;width: 100px;" <?php  } ?> >是否签到:</label>
					  <div class="col-sm-2 col-lg-2" id="signd_l" <?php  if($item['OldOrNew'] ==1) { ?>style="display: none" <?php  } else { ?>style="display: block"<?php  } ?>>
                        <label class="radio-inline">
                            <input type="radio" name="is_sign" value="1" <?php  if($item['isSign']==1 ) { ?>checked<?php  } ?>  id="sign_y" <?php  if($item) { ?> disabled<?php  } ?>>是
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="is_sign" value="0" <?php  if((isset($item['isSign']) && empty($item['isSign']) || empty($item))) { ?>checked<?php  } ?> id="sign_n" <?php  if($item) { ?> disabled<?php  } ?>>否
                        </label>
                    </div>
                    <label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label sign_detail" <?php  if($item['isSign'] == 1 && $item['OldOrNew'] == 0 ) { ?>  style="width: 100px;display: block;" <?php  } else { ?>  style="width: 100px;display:none;" <?php  } ?> >提前签到范围 :</label>
					  <div class="col-sm-2 col-lg-2 sign_detail" <?php  if($item['isSign'] == 1 && $item['OldOrNew'] == 0 ) { ?> style="display: block;" <?php  } else { ?> style="display: none;" <?php  } ?>>
                         <div class="input-group">		
	                         <input type="number" class="form-control" name="signTime" value="<?php  echo $item['signTime'];?>" />
	                         <div class="help-block">开课前多少分钟可以签到，为空则不限制</div>
                         </div>
				    </div>
                </div>
				<div class="form-group" >
					<label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label"  id="signd2" <?php  if($item['OldOrNew'] ==1) { ?>style="display: none;width: 100px;" <?php  } else { ?> style="display: block;width: 100px;" <?php  } ?> >上课提醒:</label>
					  <div class="col-sm-2 col-lg-2" id="signd_l2" <?php  if($item['OldOrNew'] ==1) { ?>style="display: none" <?php  } else { ?>style="display: block"<?php  } ?>>
                        <label class="radio-inline">
                            <input type="radio" name="is_tx" value="1" <?php  if($item['is_tx']==1 ) { ?>checked<?php  } ?>  id="sign_y2">开启
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="is_tx" value="2" <?php  if(empty($item['is_tx']) || $item['is_tx']==2) { ?>checked<?php  } ?> id="sign_n2">关闭
                        </label>
                    </div>
                    <label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label sign_detail2" <?php  if($item['is_tx'] == 1 && $item['OldOrNew'] == 0 ) { ?>  style="width: 100px;display: block;" <?php  } else { ?>  style="width: 100px;display:none;" <?php  } ?> >提前提醒时间 :</label>
					  <div class="col-sm-2 col-lg-2 sign_detail2" <?php  if($item['is_tx'] == 1 && $item['OldOrNew'] == 0 ) { ?> style="display: block;" <?php  } else { ?> style="display: none;" <?php  } ?>>
                         <div class="input-group">		
	                         <input type="number" class="form-control" name="txtime" value="<?php  echo $item['txtime'];?>" />
	                         <div class="help-block">课程开始前多少分钟提醒学生和老师</div>
                         </div>
				    </div>
                </div>
                <div class="form-group">
	               <label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label" style="width: 100px;">授课老师:</label>
					<div class="col-sm-9 col-xs-6">
						<div class="input-group text-info">
                            <?php  if(is_array($teachers)) { foreach($teachers as $row) { ?>
                            <?php  if(!empty($id)) { ?>
                            <?php  $is = $this->uniarr($uniarr,$row['id']);?>
                            <?php  } ?>
                            <label  class="checkbox-inline" style="width:10%;margin-left: 10px"><input type="checkbox" name="tidarr[]" onclick="check_count(this)" value="<?php  echo $row['id'];?>" tname="<?php  echo $row['tname'];?>" style="float: none;" <?php  if(($is)) { ?>checked="checked"<?php  } ?>> <?php  echo $row['tname'];?></label>
                           
                            <?php  } } ?>
						</div>
						<div class="help-block">选择授课老师，最多五个</div>
					</div>
				</div>

				<div class="form-group">
					<label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label" style="width: 100px;">主讲老师:</label>
                    <div class="col-sm-2 col-lg-2">
                        <select style="margin-right:15px;" name="maintid" id="maintid" class="form-control">
	                         <option value="0"  >请选择主讲老师</option>
	                        <?php  if(is_array($teachers)) { foreach($teachers as $row_z) { ?>
	                        
	                         <?php  $is_z = $this->uniarr($uniarr,$row_z['id']);?>
	                         <?php  if(($is_z)) { ?>
                            <option value="<?php  echo $row_z['id'];?>" <?php  if($item['maintid'] == $row_z['id']) { ?>selected="selected"<?php  } ?> ><?php  echo $row_z['tname'];?></option>
                            <?php  } ?>
                            <?php  } } ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
					<label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label" style="width: 100px;">预约负责老师:</label>
                    <div class="col-sm-2 col-lg-2">
                        <select style="margin-right:15px;" name="yytid" id="yytid" class="form-control">
	                         <option value="0"  >请选择预约负责老师</option>
	                        <?php  if(is_array($teachers)) { foreach($teachers as $row_yy) { ?>
                            <option value="<?php  echo $row_yy['id'];?>" <?php  if($item['yytid'] == $row_yy['id']) { ?>selected="selected"<?php  } ?> ><?php  echo $row_yy['tname'];?></option>
                            <?php  } } ?>
                        </select>
                    </div>
                </div>
				<div class="form-group">	
                    <label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label" style="width: 100px;">报名费用：</label>
                    <div class="col-sm-2 col-lg-2">
                         <div class="input-group">					
                            <input type="text" class="form-control" name="cose" value="<?php  echo $item['cose'];?>" required="required" oninvalid="setCustomValidity('报名费用不能为空！！');" oninput="setCustomValidity('');"/>
							<div class="help-block">输入课程所需费用</div>
                         </div>
				    </div>
					<?php  if($_W['isfounder'] || $_W['role'] == 'owner') { ?>
                    <label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label" style="width: 100px;">付费至：</label>
                    <div class="col-sm-2 col-lg-2">
                         <div class="input-group">
							<select class="form-control" name="payweid" id="payweid">
								<option value="0">请选择收款账户</option>
								<?php  if(is_array($payweid)) { foreach($payweid as $row) { ?>
								<option value="<?php  echo $row['uniacid'];?>" <?php  if($item['payweid']==$row['uniacid']) { ?>selected<?php  } ?>><?php  echo $row['name'];?></option>
								<?php  } } ?>
							</select>
							<div class="help-block">付费至指定公众号设置的支付方式内，不设置则付费至当前公众号</div>
                         </div>
				    </div>
					<?php  } else { ?>
						 <input type="hidden" name="payweid" value="<?php  echo $item['payweid'];?>" />
					<?php  } ?>	
					<label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label" style="width: 100px;">人数限制：</label>
                    <div class="col-sm-2 col-lg-2">
                         <div class="input-group">					
                            <input type="text" class="form-control" name="minge" value="<?php  echo $item['minge'];?>" />
							<div class="help-block">输入课程限报人数</div>
                         </div>
				    </div>
					<label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label" style="width: 100px;">已报人数：</label>
                    <div class="col-sm-2 col-lg-2">
                         <div class="input-group">					
                            <input type="text" class="form-control" name="yibao" value="<?php  echo $item['yibao'];?>" />
							<div class="help-block">已报虚拟人数</div>
                         </div>
				    </div>					
                </div>
                <div class="form-group" id="NewType">	
                    <label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label" style="width: 100px;">续购单价：</label>
                    <div class="col-sm-2 col-lg-2">
                         <div class="input-group">					
                            <input type="text" class="form-control" name="RePrice" value="<?php  echo $item['RePrice'];?>" />
							<div class="help-block">输入续购课程时每个课时单价</div>
                         </div>
				    </div>
					<label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label" style="width: 100px;">总课时：</label>
                    <div class="col-sm-2 col-lg-2">
                         <div class="input-group">					
                            <input type="text" class="form-control" name="AllNum" value="<?php  echo $item['AllNum'];?>" required="required" oninvalid="setCustomValidity('总课时不能为空！！');" oninput="setCustomValidity('');" />
							<div class="help-block">输入本课程一共包含多少课时</div>
                         </div>
				    </div>	
					<label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label" style="width: 100px;">首购课时：</label>
                    <div class="col-sm-2 col-lg-2">
                         <div class="input-group">					
                            <input type="text" class="form-control" name="FirstNum" value="<?php  echo $item['FirstNum'];?>" required="required" oninvalid="setCustomValidity('首购课时不能为空！！');" oninput="setCustomValidity('');" />
							<div class="help-block">输入首次报名包含多少课时</div>
                         </div>
				    </div>
					<label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label" style="width: 100px;">最低续购：</label>
                    <div class="col-sm-2 col-lg-2">
                         <div class="input-group">					
                            <input type="text" class="form-control" name="ReNum" value="<?php  echo $item['ReNum'];?>" />
							<div class="help-block">输入续课时最低续购多少课时</div>
                         </div>
				    </div>					
                </div>
                <?php  if($school['Is_point']==1) { ?>
				<div class="form-group">	
                    <label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label" style="width: 100px;">积分抵用：</label>
                    <div class="col-sm-2 col-lg-2">
                         <div class="input-group">					
                            <input type="text" class="form-control" name="Point2Cost" value="<?php  echo $item['Point2Cost'];?>" />
							<div class="help-block">多少积分抵用1元,为零则不抵用</div>
                         </div>
				    </div>	
					<label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label" style="width: 100px;">积分最低使用：</label>
                    <div class="col-sm-2 col-lg-2">
                         <div class="input-group">					
                            <input type="text" class="form-control" name="MinPoint" value="<?php  echo $item['MinPoint'];?>" />
							<div class="help-block">最低使用多少积分，为零则不限制</div>
                         </div>
				    </div>
					<label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label" style="width: 100px;">积分最高使用：</label>
                    <div class="col-sm-2 col-lg-2">
                         <div class="input-group">					
                            <input type="text" class="form-control" name="MaxPoint" value="<?php  echo $item['MaxPoint'];?>" />
							<div class="help-block">最高使用多少积分，为零则不限制</div>
                         </div>
				    </div>					
                </div>
                <?php  } ?>				
				<div class="form-group">	
                    <label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label" style="width: 100px;">授课教室：</label>
                       <div class="col-sm-2 col-lg-2">
                        <select style="margin-right:15px;" name="adrr" id="adrr" class="form-control">
                            <?php  if(is_array($addr)) { foreach($addr as $row) { ?>
                            <option value="<?php  echo $row['sid'];?>" <?php  if($item['adrr'] == $row['sid']) { ?> selected="selected"<?php  } ?>><?php  echo $row['sname'];?></option>
                            <?php  } } ?>
                        </select>
                    </div>	
                    <div class="col-sm-2 col-lg-2">
                        <label class="radio-inline">
                            <input type="radio" name="is_hot" value="1" <?php  if($item['is_hot']==1 || empty($item)) { ?>checked<?php  } ?>>是
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="is_hot" value="0" <?php  if(isset($item['is_hot']) && empty($item['is_hot'])) { ?>checked<?php  } ?>>否
                        </label>
                        <div class="help-block">是否精品课程</div>
                    </div>									
                </div>
                <div class="form-group">
					<label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label" style="width: 100px;">选择年级:</label>
                    <div class="col-sm-2 col-lg-2">
                        <select style="margin-right:15px;" name="xq" id="select_nj" class="form-control">
                            <option value="0">请选择年级</option>
                            <?php  if(is_array($xueqi)) { foreach($xueqi as $it) { ?>
                            <option value="<?php  echo $it['sid'];?>" <?php  if($it['sid'] == $item['xq_id']) { ?> selected="selected"<?php  } ?>><?php  echo $it['sname'];?></option>
                            <?php  } } ?>
                        </select>
						
                    </div>
			<!-- 		<label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label" style="width: 100px;">选择班级:</label>
                    <div class="col-sm-2 col-lg-2">
                        <select style="margin-right:15px;" name="bj" id="bj" class="form-control">
                            <option value="0">请选择班级</option>
                            <?php  if(is_array($bj)) { foreach($bj as $it) { ?>
                            <option value="<?php  echo $it['sid'];?>" <?php  if($it['sid'] == $item['bj_id']) { ?> selected="selected"<?php  } ?>><?php  echo $it['sname'];?></option>
                            <?php  } } ?>
                        </select>
                    </div> -->
					<label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label" style="width: 100px;">选择科目:</label>
                    <div class="col-sm-2 col-lg-2">
                        <select style="margin-right:15px;" name="km" class="form-control">
                            <option value="0">请选择科目</option>
                            <?php  if(is_array($km)) { foreach($km as $it) { ?>
                            <option value="<?php  echo $it['sid'];?>" <?php  if($it['sid'] == $item['km_id']) { ?> selected="selected"<?php  } ?>><?php  echo $it['sname'];?></option>
                            <?php  } } ?>
                        </select>
                    </div>
				</div>	

				<div class="form-group">
                   <label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label" style="width: 100px;">开始时间:</label>
                     <div class="col-sm-2 col-lg-2">
				        <div class="input-group">
				        <?php  if($item['start']) { ?>
					     <?php  echo tpl_form_field_date('start', date('Y-m-d', $item['start']))?>
					     <?php  } else { ?>
				     	<?php  echo tpl_form_field_date('start', date('Y-m-d',TIMESTAMP))?>
				     	<?php  } ?>
                        </div>
				     </div>
                   <label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label" style="width: 100px;">结束时间:</label>
                     <div class="col-sm-2 col-lg-2">
				        <div class="input-group">
				     	<?php  if($item['end']) { ?>
					    <?php  echo tpl_form_field_date('end', date('Y-m-d', $item['end']))?>
					    <?php  } else { ?>
				     	<?php  echo tpl_form_field_date('end', date('Y-m-d',TIMESTAMP))?>
				     	<?php  } ?>
                        </div>
				     </div>					 
		 
                </div>	
			    <div class="form-group">
                     <label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label" style="width: 100px;">课程大纲</label>
                        <div class="col-sm-9">
							<?php  echo tpl_ueditor('dagang', $item['dagang']);?>
                        <div class="help-block">课程大纲</div>
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

$("#sign_y").click(function(){
	var type = $("#OldOrNew option:selected").attr('value');
	if (type == 0){
		$(".sign_detail").show();
	}
})
$("#sign_n").click(function(){
	$(".sign_detail").hide();
})

$("#sign_y2").click(function(){
	var type = $("#OldOrNew option:selected").attr('value');
	if (type == 0){
		$(".sign_detail2").show();
	}
})
$("#sign_n2").click(function(){
	$(".sign_detail2").hide();
})

function check_count(th){
	var html = ' <option value="0" >请选择主讲老师</option> ';
	if($("input[type='checkbox']:checked").length > 5 ){
		th.checked = false;
		$("input[type='checkbox']").not("input:checked").attr("disabled","disabled");
		alert("对不起，一个课程最多只能指定五个授课老师");
	}else if($("input[type='checkbox']:checked").length <= 5){
		$("input[type='checkbox']:disabled").attr("disabled",false);
	}
	$("input[type='checkbox']:checked").each(function(){
		var tid_j = $(this).attr("value");
		var tname_j = $(this).attr("tname");
		var choosetid = 0 ;
		<?php  if(!empty($item['maintid'])) { ?>
		choosetid = <?php  echo $item['maintid'];?>;
		<?php  } else if(empty($item['maintid']) && !empty($item['tid'])) { ?>
		choosetid = <?php  echo $item['tid'];?>;
		<?php  } ?>
		if(choosetid == tid_j){
			html +=' <option value="'+ tid_j +'"  selected=\"selected\">'+ tname_j +'</option>';
		} else {
			html +=' <option value="'+ tid_j +'">'+ tname_j +'</option>';
		}
	});
	$("#maintid").html(html);
}

$("#OldOrNew").change(function() {
	var type = $("#OldOrNew option:selected").attr('value');
	var sign_val=$('input:radio[name="is_sign"]:checked').val();
	if (type == 1){
		
		$(".sign_detail").hide();
		$("#signd").hide();
		$("#signd_l").hide();
		$(".sign_detail2").hide();
		$("#signd2").hide();
		$("#signd_l2").hide();
	}else if (type == 0){
		$("#signd2").show();
		$("#signd_l2").show();	
		$("#signd").show();
		$("#signd_l").show();
		if (sign_val == 1){
			$(".sign_detail").show();
			$(".sign_detail2").show();
		}else if(sign_val == 0){
			//alert(sign_val);
			$(".sign_detail").hide();
			$(".sign_detail2").hide();
		}
	}
	
});
$("#select_nj").change(function() {
	var type = 4;
	var cityId = $("#select_nj option:selected").attr('value');
	changeGrade(cityId,type, function() {});
});
function changeGrade(gradeId, type, __result) {
	var schoolid = "<?php  echo $schoolid;?>";
	var classlevel = [];
	//获取班次
	$.post("<?php  echo $this->createWebUrl('indexajax',array('op'=>'getbjlist'))?>", {'gradeId': gradeId, 'schoolid': schoolid}, function(data) {
		data       = JSON.parse(data);
		classlevel = data.bjlist;
		var html   = '';
		
		html += '<select id="bj"><option value="">请选择班级</option>';
		if (classlevel != '') {
			for (var i in classlevel) {
				html += '<option value="' + classlevel[i].sid + '">' + classlevel[i].sname + '</option>';
			}
		}
		$('#bj').html(html);	
	});
}
</script>
<?php  } else if($operation == 'add') { ?>
<link rel="stylesheet" type="text/css" href="../addons/fm_jiaoyu/public/web/css/clockpicker.css" media="all">
<script type="text/javascript" src="../addons/fm_jiaoyu/public/web/js/clockpicker.js"></script>
<link rel="stylesheet" type="text/css" href="../addons/fm_jiaoyu/public/web/css/standalone.css" media="all">
<link rel="stylesheet" type="text/css" href="../addons/fm_jiaoyu/public/web/css/uploadify_t.css?v=4" media="all" />
<div class="panel panel-info">
   <div class="panel-heading"><a class="btn btn-primary" href="<?php  echo $this->createWebUrl('kecheng', array('op' => 'display', 'schoolid' => $schoolid))?>"><i class="fa fa-tasks"></i> 返回课程列表</a></div>
</div>
<div class="main">
<form action="" method="post" class="form-horizontal form" enctype="multipart/form-data">
		<input type="hidden" name="tid" value="<?php  echo $item['tid'];?>" />
		<input type="hidden" name="kcid" value="<?php  echo $item['id'];?>" />
		<input type="hidden" name="bj_id" value="<?php  echo $item['bj_id'];?>" />
		<input type="hidden" name="km_id" value="<?php  echo $item['km_id'];?>" />
		<input type="hidden" name="schoolid" value="<?php  echo $schoolid;?>" />
        <div class="panel panel-default">
            <div class="panel-heading" style="color:red;font-size:20px;font-weight:bold;">
               <?php  echo $item['name'];?>
            </div>
            <div class="panel-body">
	            <div id="custom-url">
	           <input type="hidden" name="new[0]" value="222" />
                <div class="form-group">
                    <label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label" style="width: 100px;">教师姓名:</label>
                     <div class="col-sm-2 col-lg-2">
	                     <select style="margin-right:15px;" name="sktid_new[0]" class="form-control">
                            <option value="0">请选择授课教师</option>
                            <?php  if(is_array($teachers)) { foreach($teachers as $row) { ?>
                            <option value="<?php  echo $row['id'];?>" ><?php  echo $row['tname'];?></option>
                            <?php  } } ?>
                        </select>
                    </div>
                    <label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label" style="width: 100px;">授课教室:</label>
                     <div class="col-sm-2 col-lg-2">
	                     <select style="margin-right:15px;" name="skaddr_new[0]" class="form-control">
                            <option value="0">请选择授课教室</option>
                            <?php  if(is_array($addr)) { foreach($addr as $rowa) { ?>
                            <option value="<?php  echo $rowa['sid'];?>" <?php  if($item['adrr'] == $rowa['sid']) { ?> selected="selected"<?php  } ?> ><?php  echo $rowa['sname'];?></option>
                            <?php  } } ?>
                        </select>
                    </div>
                    <label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label" style="width: 100px;">选择时段:</label>
                    <div class="col-sm-2 col-lg-2">
                        <select style="margin-right:15px;" name="sd_new[0]" class="form-control">
                            <option value="0">请选择时段或课节</option>
                            <?php  if(is_array($sd)) { foreach($sd as $it) { ?>
                            <option value="<?php  echo $it['sid'];?>" <?php  if($row['sid'] == $item['sd_id']) { ?> selected="selected"<?php  } ?>><?php  echo $it['sname'];?></option>
                            <?php  } } ?>
                        </select>
                    </div>
                      <label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label" style="width: 100px;">本节日期:</label>
                     <div class="col-sm-2 col-lg-2">
				        <div class="input-group">
				     <?php  echo tpl_form_field_date('date_new[0]',time())?>	
                        </div>
				     </div>
				      <label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label" style="width: 100px;">课程编号:</label>
                     <div class="col-sm-2 col-lg-2">
				        <div class="input-group">
				            <div class="col-sm-9">                       
                              <input type="text" class="form-control" name="nub_new[0]" value="" /><i style="color:red;">&nbsp;&nbsp;必须为整数</i>
                            </div>
                        </div>
				     </div>	
				</div>
				
				</div>
				<div class="clearfix template"> 
					<div class="form-group">
						<label class="col-xs-12 col-sm-3 col-md-2 control-label"></label>
						<div class="col-sm-9 col-xs-12">
							<a href="javascript:;" id="custom-url-add"><i class="fa fa-plus-circle"></i> 添加课时</a>
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
<script type="text/javascript">
	var i=1;
		var option = {
			lang : "zh",
			step : 5,
			timepicker : false,
			closeOnDateSelect : true,
			format : "Y-m-d"
		};
$('#custom-url-add').click(function(){
   var html = '<input type="hidden" name="new['+i+']" value="222" />'+
              '  <div class="form-group">'+
              '      <label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label" style="width: 100px;">教师姓名:</label>'+
              '       <div class="col-sm-2 col-lg-2">'+
	          '           <select style="margin-right:15px;" name="sktid_new['+i+']" class="form-control">'+
              '             <option value="0">请选择授课教师</option>'+
                            <?php  if(is_array($teachers)) { foreach($teachers as $row) { ?>
              '              <option value="<?php  echo $row['id'];?>" ><?php  echo $row['tname'];?></option>'+
                            <?php  } } ?>
              '         </select>'+
              '      </div>'+
              '  <label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label" style="width: 100px;">授课教室:</label>'+
              '       <div class="col-sm-2 col-lg-2">'+
	          '           <select style="margin-right:15px;" name="skaddr_new['+i+']" class="form-control">'+
               '             <option value="0">请选择授课教室</option>'+
                            <?php  if(is_array($addr)) { foreach($addr as $rowa) { ?>
               '             <option value="<?php  echo $rowa['sid'];?>" <?php  if($item['adrr'] == $rowa['sid']) { ?> selected="selected"<?php  } ?> ><?php  echo $rowa['sname'];?></option>'+
                            <?php  } } ?>
               '         </select>'+
               '     </div>'+
              '      <label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label" style="width: 100px;">选择时段:</label>'+
              '      <div class="col-sm-2 col-lg-2">'+
              '          <select style="margin-right:15px;" name="sd_new['+i+']" class="form-control">'+
              '              <option value="0">请选择时段或课节</option>'+
                            <?php  if(is_array($sd)) { foreach($sd as $it) { ?>
              '             <option value="<?php  echo $it['sid'];?>" <?php  if($row['sid'] == $item['sd_id']) { ?> selected="selected"<?php  } ?>><?php  echo $it['sname'];?></option>'+
                            <?php  } } ?>
              '          </select>'+
              '      </div>'+
              '      <label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label" style="width: 100px;">本节日期:</label>'+
              '       <div class="col-sm-2 col-lg-2">'+
			  '        <div class="input-group">'+
			  '<input type="text" name="date_new['+i+']"  placeholder="请选择日期时间" readonly="readonly" class="datetimepicker form-control" style="padding-left:12px;">'	+
		
              '         </div>'+
			  '	     </div>'+
			  '	      <label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label" style="width: 100px;">课程编号:</label>'+
              '       <div class="col-sm-2 col-lg-2">'+
			  '        <div class="input-group">'+
			  '	            <div class="col-sm-9">  ' +                    
              '                <input type="text" class="form-control" name="nub_new['+i+']" value="" /><i style="color:red;">&nbsp;&nbsp;必须为整数</i>'+
              '             </div>'+
              '          </div>'+
              '          </div>'+
              '	<div class="col-sm-1" style="margin-top:5px">'+
				'   	<a href="javascript:;" class="custom-url-del"><i class="fa fa-times-circle"></i></a>'+
				'	</div>'+
		      '</div>';
	$('#custom-url').append(html);

	$(".datetimepicker[name = 'date_new["+i+"]']").datetimepicker(option);
	i++;
});

				

$(document).on('click', '.custom-url-del', function(){
	$(this).parent().parent().remove();
	return false;
});	


	var category = <?php  echo json_encode($children)?>;
	$('#credit1').click(function(){
		$('#credit-status1').show();
	});
	$('#credit0').click(function(){
		$('#credit-status1').hide();
	});

	
</script>
<script type="text/javascript">
    <!--
    var category = <?php  echo json_encode($children)?>;
    //-->
</script>
<?php  } ?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('public/footer', TEMPLATE_INCLUDEPATH)) : (include template('public/footer', TEMPLATE_INCLUDEPATH));?>