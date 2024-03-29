<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('public/header', TEMPLATE_INCLUDEPATH)) : (include template('public/header', TEMPLATE_INCLUDEPATH));?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('public/comhead', TEMPLATE_INCLUDEPATH)) : (include template('public/comhead', TEMPLATE_INCLUDEPATH));?>
<?php  if($operation == 'display') { ?>
<div class="main">
<style>
.form-control-excel {height: 34px;padding: 6px 12px;font-size: 14px;line-height: 1.42857143;color: #555;background-color: #fff;background-image: none;border: 1px solid #ccc;
border-radius: 4px;-webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075);box-shadow: inset 0 1px 1px rgba(0,0,0,.075);-webkit-transition: border-color ease-in-out .15s,-webkit-box-shadow ease-in-out .15s;-o-transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;}
</style>
    <div class="panel panel-info">
        <div class="panel-heading">教师管理</div>
        <div class="panel-body">
            <form action="./index.php" method="get" class="form-horizontal" role="form">
                <input type="hidden" name="c" value="site" />
                <input type="hidden" name="a" value="entry" />
                <input type="hidden" name="m" value="fm_jiaoyu" />
                <input type="hidden" name="do" value="assess" />
                <input type="hidden" name="schoolid" value="<?php  echo $schoolid;?>" />
                <div class="form-group">
                    <label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label" style="width: 100px;">关键字</label>
                    <div class="col-sm-2 col-lg-2">
                        <input class="form-control" name="keyword" id="" type="text" value="<?php  echo $_GPC['keyword'];?>">
                    </div>
					<label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label" style="width: 100px;">按绑定</label>
                    <div class="col-sm-2 col-lg-2">
                        <select style="margin-right:15px;" name="bd_type" class="form-control">
                            <option value="">按绑定状态</option>
								<option value="1" <?php  if($_GPC['bd_type'] == 1) { ?> selected="selected"<?php  } ?>>已绑定</option>
								<option value="2" <?php  if($_GPC['bd_type'] == 2) { ?> selected="selected"<?php  } ?>>未绑定</option>
                        </select>
                    </div>					
					<div class="col-sm-2 col-lg-2">
						<button class="btn btn-default"><i class="fa fa-search"></i> 搜索</button>
					</div>	
					<div class="col-sm-2 col-lg-2">
						<button class="btn btn-success qx_605" name="out_putcode" value="out_putcode"><i class="fa fa-download"></i>导出教师绑定码</button>
					</div>  
					<?php  if(is_showpf()) { ?>
					<div class="col-sm-2 col-lg-2">
						<button class="btn btn-success qx_608" name="out_putTeaInfo" value="out_putTeaInfo"><i class="fa fa-download"></i>导出教师信息</button>
					</div>
					<?php  } ?>					
                </div>
				<div class="form-group">
					<a style="margin-left:40px;background-color: #ffffff;" class="btn btn-primary " href="<?php  echo $this->createWebUrl('assess', array('op' => 'post', 'schoolid' => $schoolid))?>"></a>
					  <a  class="btn btn-primary qx_602" href="<?php  echo $this->createWebUrl('assess', array('op' => 'post', 'schoolid' => $schoolid))?>"><i class="fa fa-plus"></i> 添加教师信息</a>
					  <a class="btn btn-success qx_603" href="javascript:;" onclick="$('.file-container').slideToggle()">批量导入老师</a>
					  <a class="btn btn-success qx_604" href="javascript:;" onclick="$('.file-container1').slideToggle()">批量绑定班级</a>
					  <a class="btn btn-danger qx_603" href="<?php  echo $this->createWebUrl('assess', array('op' => 'clear', 'schoolid' => $schoolid))?>"><i class="fa fa-trash-o"></i> 清除垃圾信息</a>
					  <?php  if(empty($checkbjold)) { ?><a class="btn btn-info qx_602" href="<?php  echo $this->createWebUrl('assess', array('op' => 'changebjdata', 'schoolid' => $schoolid))?>"><i class="fa fa-recycle"></i>恢复授课数据</a><?php  } ?>
					  <a class="btn btn-primary" href="javascript:location.reload()"><i class="fa fa-refresh"></i> 刷新</a>   
				</div>   
            </form>
			<div class="alert we7-page-alert">
				<?php  if(!empty($_GPC['bd_type'])) { ?><p><i class="wi wi-info-sign"></i> 搜索到教师人数:<strong class="text-danger"><?php  echo $total;?>个</strong><?php  } else { ?><p><i class="wi wi-info-sign"></i> 本校教师人数:<strong class="text-danger"><?php  echo $total;?>个</strong>。昨日绑定:<strong class="text-danger"><?php  echo $zrbd;?>人</strong>。今日绑定:<strong class="text-danger"><?php  echo $jrbd;?>人</strong>。</p><?php  } ?>
			</div>
        </div>
    </div>
    <div class="panel panel-default file-container" style="display:none;">
        <div class="panel-body">
            <form id="form">
                <input name="viewfile" id="viewfile" type="text" value="" style="margin-left: 40px;" class="form-control-excel" readonly>
                <a class="btn btn-primary"><label for="unload" style="margin: 0px;padding: 0px;">上传...</label></a>
                <input type="file" class="pull-left btn-primary span3" name="file" id="unload" style="display: none;"
                       onchange="document.getElementById('viewfile').value=this.value;this.style.display='none';">
                <a class="btn btn-primary" onclick="submits('input_tea','form');">导入数据</a>
                <a class="btn btn-info" href="../addons/fm_jiaoyu/public/example/example_assess.xls"><i class="fa fa-download"></i>下载导入模板</a>
            </form>
        </div>
    </div>
    <div class="panel panel-default file-container1" style="display:none;">
        <div class="panel-body">
            <form id="form1">
                <input name="viewfile1" id="viewfile1" type="text" value="" style="margin-left: 40px;" class="form-control-excel" readonly>
                <a class="btn btn-warning"><label for="unload1" style="margin: 0px;padding: 0px;">上传...</label></a>
                <input type="file" class="pull-left btn-primary span3" name="file1" id="unload1" style="display: none;" onchange="document.getElementById('viewfile1').value=this.value;this.style.display='none';">
                <a class="btn btn-danger" onclick="submits('input_teabj','form1');">导入数据</a>
				<a class="btn btn-info" href="<?php  echo $this->createWebUrl('assess', array('out_putbjlist' => 'out_putbjlist', 'schoolid' => $schoolid))?>"><i class="fa fa-download"></i>下载导入模板</a>				
				<a class="btn btn-info" href="<?php  echo $this->createWebUrl('theclass', array('out_putcode' => 'out_putcode', 'schoolid' => $schoolid))?>"><i class="fa fa-download"></i>下载班级对照表</a>
				<a class="btn btn-info" href="<?php  echo $this->createWebUrl('theclass', array('out_putsub' => 'out_putsub', 'schoolid' => $schoolid))?>"><i class="fa fa-download"></i>下载科目对照表</a>
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
               <th class='with-checkbox' style="text-align:left;width: 3%;"><input type="checkbox" class="check_all" /></th>
			   <th style="width:4%;">排序</th>
               <th style="width:6%">姓名</th>
               <th style="width:4%;">性别</th>
			   <?php  if($_W['schooltype']) { ?>
			   <th style="width:18%;text-align:center" >授课信息</th>
               <th style="width:5%;">课程数目</th>
               <th style="width:5%;">课时</th>
			   <?php  } else { ?>
			    <th style="width:5%;"></th>
			   <th style="width:8%;">授课信息</th>
			   <th style="width:5%;"></th>
			   
               <?php  } ?>
				<th style="width:8%;">手机</th>
				
				<th style="width:8%;">微信绑定</th>   
				<th style="width:6%;"></th>                  
               <th style="text-align:right; width:8%;" class="qx_e_d">操作</th>
            </tr>
         </thead>
         <tbody>
            <?php  if(is_array($list)) { foreach($list as $item) { ?>
            <tr>
                <td class="with-checkbox"><input type="checkbox" name="check" value="<?php  echo $item['id'];?>"></td>
				<td><input type="text" class="form-control" name="sort[<?php  echo $item['id'];?>]" value="<?php  echo $item['sort'];?>"></td>
                <td>
                <img style="width:50px;height:50px;border-radius:50%;" src="<?php  if(!empty($item['thumb'])) { ?><?php  echo tomedia($item['thumb'])?><?php  } else { ?><?php  echo tomedia($school['tpic'])?><?php  } ?>" width="50"  style="border-radius: 3px;" /></br></br><?php  echo $item['tname'];?>
                </td>
                <td><?php  if($item['sex'] == 1) { ?><span class="label label-info">男</span><?php  } else { ?><span class="label label-success">女</span><?php  } ?></br></br>
                <span class="label label-success"><?php  echo (date('Y',TIMESTAMP) - date('Y',$item['birthdate']))?>岁</span>
                </td>
				<?php  if(!$_W['schooltype']) { ?>
                <td>
					<?php  
						if(is_array($item['bjlist'])) { 
							foreach($item['bjlist'] as $row){
								echo($row['xqname']);
								echo('</br>');
							}
						}
					?>
				</td>
                <td>
					<?php  
						if(is_array($item['bjlist'])) { 
							foreach($item['bjlist'] as $row){
								echo($row['bjname']);
								echo('</br>');
							}
						}
					?>
				</td>
                <td>
					<?php  
						if(is_array($item['bjlist'])) { 
							foreach($item['bjlist'] as $row){
								echo($row['kmname']);
								echo('</br>');
							}
						}
					?>
				</td>
				<?php  } else { ?>
				 <td >
					<?php  
						if(is_array($item['kclist'])) { 
							foreach($item['kclist'] as $row){
								echo($row['name']);
								echo('&emsp;');
								echo( '<span class="label label-danger" style="height: 20px;line-height: 6px;padding-left: 5px;padding-right: 5px;">完成'.$row['ksnum_yq'].'节</span>');
								echo('&emsp;');
								if($row['OldOrNew'] == 0 ){
									echo( '<span class="label label-info" style="height: 20px;line-height: 6px;padding-left: 5px;padding-right: 5px;">共'.$row['ksnum'].'节</span>');
								}
								echo('</br>');
							}
						}
					?>
				</td>
            
				
				<?php  } ?>
				
				<?php  if($_W['schooltype']) { ?>			
                <td><span class="label label-warning">共<?php  echo $item['kcnum'];?>条</span></td>   
                <td>
                <span class="label label-info">共<?php  echo $item['zks'];?>节</span></br></br>
                <span class="label label-warning">未完<?php  echo $item['wwks'];?>节</span></br></br>
                <span class="label label-danger">已完<?php  echo $item['ywks'];?>节</span>
                </td>
                <?php  } ?>               
                <td><?php  echo $item['mobile'];?></td>
                                  
               <td>
               <?php  if(!empty($item['openid'])) { ?>
               <img style="width:50px;height:50px;border-radius:50%;" src="<?php  echo tomedia($item['avatar'])?>" width="50"  onerror="this.src='./resource/images/nopic.jpg';" style="border-radius: 3px;" /></br><?php  echo $item['nickname'];?> </br>
               <a class="btn btn-default btn-sm qx_606" href="<?php  echo $this->createWebUrl('assess', array('id' => $item['id'], 'op' => 'jiebang', 'schoolid' => $schoolid))?>" onclick="return confirm('此操作不可恢复，确认解绑？');return false;" title="解绑"><i class="fa fa-times"></i>&nbsp;解绑</a>			   
               <?php  } else { ?>
               <span title="<?php  echo $item['code'];?>">绑定码:<?php  echo $item['code'];?></span>
               <?php  } ?>
               </td>
               <td> 
                    <?php  if($item['status'] == 2) { ?><span class="label label-danger">校长</span><?php  } ?>
					<?php  if($item['status'] == 1) { ?><span class="label label-success">教员</span><?php  } ?>
					<?php  if(is_njzr($item['id']) != 0) { ?><span class="label label-info"><?php echo NJNAME;?>管理</span><?php  } ?>
                    <?php  if($item['is_show'] == 1) { ?><span class="label label-danger">隐藏</span><?php  } ?>
					<?php  if($item['is_show'] == 0) { ?><span class="label label-success">显示</span><?php  } ?>
                    <span class="label label-info"><?php  echo $item['Ttitle'];?></span>
               </td>       
               <td style="text-align:right;" class="qx_e_d">
                  <a class="btn btn-default btn-sm qx_602" href="<?php  echo $this->createWebUrl('assess', array('id' => $item['id'], 'op' => 'post', 'schoolid' => $schoolid))?>" title="编辑"><i class="fa fa-pencil"></i></a>&nbsp;&nbsp;<a class="btn btn-default btn-sm qx_607" href="<?php  echo $this->createWebUrl('assess', array('id' => $item['id'], 'op' => 'delete', 'schoolid' => $schoolid))?>" onclick="return confirm('此操作不可恢复，确认删除？');return false;" title="删除"><i class="fa fa-times"></i></a>
               </td>
            </tr>
            <?php  } } ?>
         </tbody>
         <tr>
			<td colspan="7">
				<input name="submit" type="submit" class="btn btn-primary qx_602" value="批量修改排序">
				<input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
		
                <input name="token" type="hidden" value="<?php  echo $_W['token'];?>" />
                <input type="button" class="btn btn-primary qx_607" name="btndeleteall" value="批量删除" />
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
    $(".check_all").click(function(){
        var checked = $(this).get(0).checked;
        $("input[type=checkbox]").attr("checked",checked);
    });

    $("input[name=btndeleteall]").click(function(){
        var check = $("input[type=checkbox][class!=check_all]:checked");
        if(check.length < 1){
            alert('请选择要删除的教师!');
            return false;
        }
        if(confirm("确认要删除选择的教师?")){
            var id = new Array();
            check.each(function(i){
                id[i] = $(this).val();
            });
            var url = "<?php  echo $this->createWebUrl('assess', array('op' => 'deleteall','schoolid' => $schoolid))?>";
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
    <div class="panel-heading"><a class="btn btn-primary" onclick="javascript :history.back(-1);"><i class="fa fa-tasks"></i> 返回教师列表</a></div>
</div>
<div class="main">
    <form action="" method="post" class="form-horizontal form" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php  echo $item['id'];?>" />
      <input type="hidden" name="schoolid" value="<?php  echo $schoolid;?>" />
        <div class="panel panel-default">
            <div class="panel-heading">
                编辑教师详情
            </div>
            <div class="panel-body">
				<div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">教师姓名</label>
                    <div class="col-sm-9">
                        <div class="input-group">
                            <input type="text" name="tname" class="form-control" value="<?php  echo $item['tname'];?>"  required="required" oninvalid="setCustomValidity('教师姓名不能为空！！！');" oninput="setCustomValidity('');"/>
                        </div>
                    </div>
                </div>
				<div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">头像</label>
                    <div class="col-sm-9">                
                        <?php  echo tpl_form_field_image('thumb', $item['thumb'])?>
                        <span class="help-block"></span>
                    </div>
                </div>
				<div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">前端是否显示</label>
                    <div class="col-sm-9">
                        <label for="isshow1" class="radio-inline"><input type="radio" name="is_show" value="1" id="isshow1" <?php  if(empty($item) || $item['is_show'] == 1) { ?>checked="true"<?php  } ?> /> 否</label>
                        &nbsp;&nbsp;&nbsp;
                        <label for="isshow2" class="radio-inline"><input type="radio" name="is_show" value="0" id="isshow2"  <?php  if(!empty($item) && $item['is_show'] == 0) { ?>checked="true"<?php  } ?> /> 是</label>
                        <span class="help-block">是否显示在首页教师风采列表中</span>
                    </div>
                </div>            
				<div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">选择性别</label>
                    <div class="col-sm-9">
                        <label for="isshow1" class="radio-inline"><input type="radio" name="sex" value="1" id="isshow1" <?php  if(empty($item) || $item['sex'] == 1) { ?>checked="true"<?php  } ?> /> 男</label>
                        &nbsp;&nbsp;&nbsp;
                        <label for="isshow2" class="radio-inline"><input type="radio" name="sex" value="0" id="isshow2"  <?php  if(!empty($item) && $item['sex'] == 0) { ?>checked="true"<?php  } ?> /> 女</label>
                        <span class="help-block"></span>
                    </div>
                </div>
				<div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">身份证号码</label>
                    <div class="col-sm-9">
						<div class="input-group">
							<input type="text" name="idcard" class="form-control" value="<?php  echo $item['idcard'];?>" <?php  if(is_showpf()) { ?>  required="required" oninvalid="setCustomValidity('身份证号码不能为空！！！');" oninput="setCustomValidity('');"<?php  } ?>/>
						</div>
					</div>
                </div> 
				<div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">籍贯</label>
                    <div class="col-sm-9">
						<div class="input-group">
							<input type="text" name="jiguan" class="form-control" value="<?php  echo $item['jiguan'];?>" <?php  if(is_showpf()) { ?>  required="required" oninvalid="setCustomValidity('籍贯不能为空！！！');" oninput="setCustomValidity('');"<?php  } ?>/>
						</div>
					</div>
                </div>
				<div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">民族</label>
                    <div class="col-sm-9">
						<div class="input-group">
							<input type="text" name="minzu" class="form-control" value="<?php  echo $item['minzu'];?>" <?php  if(is_showpf()) { ?>  required="required" oninvalid="setCustomValidity('民族不能为空！！！');" oninput="setCustomValidity('');"<?php  } ?>/>
						</div>
					</div>
                </div>
				<div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">政治面貌</label>
                    <div class="col-sm-9">
						<div class="input-group">
							<input type="text" name="zzmianmao" class="form-control" value="<?php  echo $item['zzmianmao'];?>" <?php  if(is_showpf()) { ?>  required="required" oninvalid="setCustomValidity('民族不能为空！！！');" oninput="setCustomValidity('');"<?php  } ?>/>
						</div>
					</div>
                </div>
				<div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">现住址</label>
                    <div class="col-sm-9">
						<div class="input-group">
							<input type="text" name="address" class="form-control" value="<?php  echo $item['address'];?>" />
						</div>
					</div>
                </div>
				<div class="form-group">
                   <label class="col-xs-12 col-sm-3 col-md-2 control-label">出生日期</label>
                   <div class="col-sm-9">
					   <div class="input-group">
						<?php  if(!empty($item['birthdate'])) { ?><?php  echo tpl_form_field_date('birthdate', date('Y-m-d', $item['birthdate']))?><?php  } else { ?><?php  echo tpl_form_field_date('birthdate', date('Y-m-d', 516599001))?><?php  } ?>            
					   </div>
					</div>
                </div>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">固定电话</label>
                    <div class="col-sm-9">
						<div class="input-group">
							<input type="text" name="tel" class="form-control" value="<?php  echo $item['tel'];?>" />
						</div>
					</div>
                </div>            
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">手机号码</label>
                    <div class="col-sm-9">
                  <div class="input-group">
                         <input type="text" name="mobile" class="form-control" value="<?php  echo $item['mobile'];?>" />
                       </div>
                </div>
                </div>
				<div class="form-group">
                   <label class="col-xs-12 col-sm-3 col-md-2 control-label">入职时间</label>
                     <div class="col-sm-9"> 
                    <div class="input-group">
                 <?php  if(!empty($item['jiontime'])) { ?><?php  echo tpl_form_field_date('jiontime', date('Y-m-d', $item['jiontime']))?><?php  } else { ?><?php  echo tpl_form_field_date('jiontime', date('Y-m-d', TIMESTAMP))?><?php  } ?>
                        </div>
                 </div>
                </div>            
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">电子邮箱</label>
                    <div class="col-sm-9">
                        <div class="input-group">
                            <input type="text" name="email" class="form-control" value="<?php  echo $item['email'];?>" />
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">所属分组</label>
                    <div class="col-sm-9">
                        <div class="input-group">
                        <select style="margin-right:15px;" name="fz_id" class="form-control">
                            <option value="0">请选择分组</option>
                            <?php  if(is_array($fz)) { foreach($fz as $it) { ?>
                            <option value="<?php  echo $it['sid'];?>" <?php  if($it['sid'] == $item['fz_id']) { ?> selected="selected"<?php  } ?>><?php  echo $it['sname'];?></option>
                            <?php  } } ?>
                        </select>
                        </div>
                    </div>
                </div>				
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">绑定码</label>
                    <div class="col-sm-9">
                        <div class="input-group">
                            <input type="text" name="code" class="form-control" value="<?php  echo $item['code'];?>" />
                        </div>
                    </div>
                </div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">是否校长</label>
					
					<div class="col-sm-9">
						<label class="radio-inline"><input type="radio" name="status" value="2" id="isshow1" <?php  if(!empty($item) && $item['status'] == 2) { ?>checked="true"<?php  } ?> <?php  if(!empty($item) && is_njzr($item['id']) != 0) { ?> disabled <?php  } ?> /> 是</label>
						&nbsp;&nbsp;&nbsp;
						<label class="radio-inline"><input type="radio" name="status" value="1" id="isshow2"  <?php  if(empty($item) || $item['status'] == 1) { ?>checked="true"<?php  } ?>  <?php  if(!empty($item) && is_njzr($item['id']) != 0) { ?> disabled <?php  } ?>/> 否</label>
						<?php  if(!empty($item) && is_njzr($item['id']) != 0) { ?><span style ="color:red;" class="help-block">当前教师已经是年级主任，不可操作该项</span>
						<?php  } else { ?><span style ="color:red;" class="help-block">您可以设置多个教师为校长身份</span><?php  } ?>
						
					</div>
						
				</div>            
          </div>
         <div class="panel panel-info">
            <div class="panel-heading">
				<a class="btn btn-primary" href="<?php  echo $this->createWebUrl('assess', array('op' => 'display', 'schoolid' => $schoolid))?>"><i class="fa fa-tasks"></i> 返回教师列表</a>
			</div>
         </div>
            <div class="panel-heading">录入教学信息</div>                
            <div class="panel-body">
			<div id="custom-url">
			<?php  if(!$_W['schooltype']) { ?>
			<?php  if($bjlists) { ?>
			<?php  if(is_array($bjlists)) { foreach($bjlists as $row) { ?>
				<input type="hidden" name="old[]" value="1111" />
				<input type="hidden" name="thisid[]" value="<?php  echo $row['id'];?>" />
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">授课信息</label>
					<label class="col-xs-12 col-sm-2 col-md-2 control-label" style="width: 100px;"><?php echo NJNAME;?></label>
					<div class="col-sm-2 col-lg-2">
						<div class="input-group">
							<select style="margin-right:15px;" name="xq_id[]" id="xq_id<?php  echo $row['id'];?>" class="form-control">
								<option value="0">请选择<?php echo NJNAME;?></option>
								<?php  if(is_array($xueqi)) { foreach($xueqi as $it) { ?>
								<option value="<?php  echo $it['sid'];?>" <?php  if($it['sid'] == $row['xq_id']) { ?> selected="selected"<?php  } ?>><?php  echo $it['sname'];?></option>
								<?php  } } ?>
							</select>
						</div>	 
					</div>
					<label class="col-xs-12 col-sm-2 col-md-2 control-label" style="width: 100px;">班级</label>
					<div class="col-sm-2 col-lg-2">
						<div class="input-group">
							<select style="margin-right:15px;" name="bj_id[]" id="bj_id<?php  echo $row['id'];?>" class="form-control">
								<option value="0">请选择班级</option>
								<?php  if(is_array($bj)) { foreach($bj as $it) { ?>
								<option value="<?php  echo $it['sid'];?>" <?php  if($it['sid'] == $row['bj_id']) { ?> selected="selected"<?php  } ?>><?php  echo $it['sname'];?></option>
								<?php  } } ?>
							</select>
						</div>	
					</div>   
					<label class="col-xs-12 col-sm-2 col-md-2 control-label" style="width: 100px;">科目</label>
					<div class="col-sm-2 col-lg-2">
						<div class="input-group">
							<select style="margin-right:15px;" name="km_id[]" class="form-control">
								<option value="0">请选择科目</option>
								<?php  if(is_array($km)) { foreach($km as $it) { ?>
								<option value="<?php  echo $it['sid'];?>" <?php  if($it['sid'] == $row['km_id']) { ?> selected="selected"<?php  } ?>><?php  echo $it['sname'];?></option>
								<?php  } } ?>
							</select>
						</div>	
					</div>
					<div class="col-sm-1" style="margin-top:5px">
						<a onclick="del('<?php  echo $row['id'];?>')" class="custom-url"><i class="fa fa-times-circle"></i></a>
					</div>					
				</div>
				<script type="text/javascript">
				$(document).ready(function() {
					$("#xq_id<?php  echo $row['id'];?>").change(function() {
						var cityId = $("#xq_id<?php  echo $row['id'];?> option:selected").attr('value');
						var type = 1;
						changeGrade<?php  echo $row['id'];?>(cityId, type, function() {
						});
					});		
				});	
				function changeGrade<?php  echo $row['id'];?>(gradeId, type) {
					//alert(cityId);
					var schoolid = "<?php  echo $schoolid;?>";
					var classlevel = [];
					//获取班次
					$.post("<?php  echo $this->createWebUrl('indexajax',array('op'=>'getbjlist'))?>", {'gradeId': gradeId, 'schoolid': schoolid}, function(data) {
					
						data = JSON.parse(data);
						classlevel = data.bjlist;
						
						var htmls = '';
						htmls += '<select id="bj_id<?php  echo $row['id'];?>"><option value="">请选择班级</option>';		
						if (classlevel != '') {
							for (var i in classlevel) {
								htmls += '<option value="' + classlevel[i].sid + '">' + classlevel[i].sname + '</option>';
							}
						}
						$('#bj_id<?php  echo $row['id'];?>').html(htmls);		
					});

				}
				</script>				
			<?php  } } ?>
			<?php  } else { ?>
				<input type="hidden" name="new[]" value="2222" />
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">授课信息</label>
					<label class="col-xs-12 col-sm-2 col-md-2 control-label" style="width: 100px;"><?php echo NJNAME;?></label>
					<div class="col-sm-2 col-lg-2">
						<div class="input-group">
							<select style="margin-right:15px;" name="xq_id_new[]" id="xq" class="form-control">
								<option value="0">请选择<?php echo NJNAME;?></option>
								<?php  if(is_array($xueqi)) { foreach($xueqi as $it) { ?>
								<option value="<?php  echo $it['sid'];?>" <?php  if($it['sid'] == $row['xq_id']) { ?> selected="selected"<?php  } ?>><?php  echo $it['sname'];?></option>
								<?php  } } ?>
							</select>
						</div>	
					</div>
					<label class="col-xs-12 col-sm-2 col-md-2 control-label" style="width: 100px;">班级</label>
					<div class="col-sm-2 col-lg-2">
						<div class="input-group">
							<select style="margin-right:15px;" name="bj_id_new[]" id="bj" class="form-control">
								<option value="0">请选择班级</option>
								<?php  if(is_array($bj)) { foreach($bj as $it) { ?>
								<option value="<?php  echo $it['sid'];?>" <?php  if($it['sid'] == $row['bj_id']) { ?> selected="selected"<?php  } ?>><?php  echo $it['sname'];?></option>
								<?php  } } ?>
							</select>
						</div>	
					</div>   
					<label class="col-xs-12 col-sm-2 col-md-2 control-label" style="width: 100px;">科目</label>
					<div class="col-sm-2 col-lg-2">
						<div class="input-group">
							<select style="margin-right:15px;" name="km_id_new[]" class="form-control">
								<option value="0">请选择科目</option>
								<?php  if(is_array($km)) { foreach($km as $it) { ?>
								<option value="<?php  echo $it['sid'];?>" <?php  if($it['sid'] == $row['km_id']) { ?> selected="selected"<?php  } ?>><?php  echo $it['sname'];?></option>
								<?php  } } ?>
							</select>
						</div>	
					</div>
					<div class="col-sm-1" style="margin-top:5px">
						<a href="javascript:;" class="custom-url-del"><i class="fa fa-times-circle"></i></a>
					</div>					
				</div>			
			<?php  } ?>
			</div>
			<div class="panel panel-default">  
				<div class="clearfix template"> 
					<div class="form-group">
						<label class="col-xs-12 col-sm-3 col-md-2 control-label"></label>
						<div class="col-sm-9 col-xs-12">
							<a href="javascript:;" id="custom-url-add"><i class="fa fa-plus-circle"></i> 添加授课信息</a>
							<span class="help-block">可添加多个授课信息</span>
						</div>
					</div>	
				</div>	
			</div>
			<?php  } ?>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">教学特点</label>
					<div class="col-sm-9">
						<?php  echo tpl_ueditor('headinfo', $item['headinfo']);?>
						<span class="help-block"></span>
					</div>
				</div>
				<div class="form-group">
					 <label class="col-xs-12 col-sm-3 col-md-2 control-label">教学成果</label>
					<div class="col-sm-9">
					   <?php  echo tpl_ueditor('info', $item['info']);?>
						<div class="help-block">教学成果</div>
					</div>
				</div>
				 <div class="form-group">
					 <label class="col-xs-12 col-sm-3 col-md-2 control-label">教学经验</label>
					<div class="col-sm-9">
					   <?php  echo tpl_ueditor('jinyan', $item['jinyan']);?>
						<div class="help-block">教学经验</div>
					</div>
				</div>
			</div>
				
			<?php  if(is_showpf()) { ?>	
			<div class="panel panel-info">
				<div class="panel-heading">
					详细信息 
				</div>
			</div>
			<div class="panel-body">
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">第一学历</label>
					<div class="col-sm-2 col-lg-2">
						<div class="input-group">
							<input type="text" name="first_xl" class="form-control" value="<?php  echo $item['otherinfo']['first_xl'];?>"   required="required" oninvalid="setCustomValidity('第一学历不能为空！！！');" oninput="setCustomValidity('');"/>
						</div>
					</div>
					<label class="col-xs-12 col-sm-2 col-md-2 control-label" style="width: 100px;">专业</label>
					<div class="col-sm-2 col-lg-2">
						<div class="input-group">
							<input type="text" name="first_zy" class="form-control" value="<?php  echo $item['otherinfo']['first_zy'];?>"   required="required" oninvalid="setCustomValidity('专业不能为空！！！');" oninput="setCustomValidity('');"/>
						</div>	
					</div>   
					<label class="col-xs-12 col-sm-2 col-md-2 control-label" style="width: 100px;">毕业院校</label>
					<div class="col-sm-2 col-lg-2">
						<div class="input-group">
							<input type="text" name="first_yx" class="form-control" value="<?php  echo $item['otherinfo']['first_yx'];?>"   required="required" oninvalid="setCustomValidity('毕业院校不能为空！！！');" oninput="setCustomValidity('');"/>
						</div>	
					</div>
					<label class="col-xs-12 col-sm-2 col-md-2 control-label" style="width: 100px;">毕业时间</label>
					<div class="col-sm-2 col-lg-2">
						<?php  echo tpl_form_field_date('first_bytime', $item['otherinfo']['first_bytime'])?>	
					</div>					
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">最高学历</label>
					<div class="col-sm-2 col-lg-2">
						<div class="input-group">
							<input type="text" name="top_xl" class="form-control" value="<?php  echo $item['otherinfo']['top_xl'];?>"   required="required" oninvalid="setCustomValidity('最高学历不能为空！！！');" oninput="setCustomValidity('');"/>
						</div>
					</div>
					<label class="col-xs-12 col-sm-2 col-md-2 control-label" style="width: 100px;">专业</label>
					<div class="col-sm-2 col-lg-2">
						<div class="input-group">
							<input type="text" name="top_zy" class="form-control" value="<?php  echo $item['otherinfo']['top_zy'];?>"   required="required" oninvalid="setCustomValidity('专业不能为空！！！');" oninput="setCustomValidity('');"/>
						</div>	
					</div>   
					<label class="col-xs-12 col-sm-2 col-md-2 control-label" style="width: 100px;">毕业院校</label>
					<div class="col-sm-2 col-lg-2">
						<div class="input-group">
							<input type="text" name="top_yx" class="form-control" value="<?php  echo $item['otherinfo']['top_yx'];?>"   required="required" oninvalid="setCustomValidity('毕业院校不能为空！！！');" oninput="setCustomValidity('');"/>
						</div>	
					</div>
					<label class="col-xs-12 col-sm-2 col-md-2 control-label" style="width: 100px;">毕业时间</label>
					<div class="col-sm-2 col-lg-2">
						<?php  echo tpl_form_field_date('top_bytime',$item['otherinfo']['top_bytime'])?>	
					</div>					
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">主要学习简历</label>
					<div class="col-sm-9">
						<?php  echo tpl_ueditor('main_study_jl', $item['otherinfo']['main_study_jl']);?>
						<div class="help-block">主要学习简历</div>
					</div>
				 </div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">参加工作时间</label>
					<div class="col-sm-2 col-lg-2">
						<?php  echo tpl_form_field_date('time2work',$item['otherinfo']['time2work'])?>	
					</div>
					<label class="col-xs-12 col-sm-2 col-md-2 control-label" style="width: 100px;">任教学科</label>
					<div class="col-sm-2 col-lg-2">
						<div class="input-group">
							<input type="text" name="tea_subject" class="form-control" value="<?php  echo $item['otherinfo']['tea_subject'];?>" />
						</div>	
					</div>   				
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">职称</label>
					<div class="col-sm-2 col-lg-2">
						<div class="input-group">
							<input type="text" name="zhicheng" class="form-control" value="<?php  echo $item['otherinfo']['zhicheng'];?>" />
						</div>
					</div>
					<label class="col-xs-12 col-sm-2 col-md-2 control-label" style="width: 100px;">评审时间</label>
					<div class="col-sm-2 col-lg-2">
						<?php  echo tpl_form_field_date('zc_pstime',$item['otherinfo']['zc_pstime'])?>		
					</div>
					<label class="col-xs-12 col-sm-2 col-md-2 control-label" style="width: 100px;">聘任时间</label>
					<div class="col-sm-2 col-lg-2">
						<?php  echo tpl_form_field_date('zc_prtime',$item['otherinfo']['zc_prtime'])?>	
					</div> 					
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">专业技术职务</label>
					<div class="col-sm-2 col-lg-2">
						<div class="input-group">
							<input type="text" name="zjzhiwu" class="form-control" value="<?php  echo $item['otherinfo']['zjzhiwu'];?>" />
						</div>
					</div>
					<label class="col-xs-12 col-sm-2 col-md-2 control-label" style="width: 100px;">评审时间</label>
					<div class="col-sm-2 col-lg-2">
						<?php  echo tpl_form_field_date('zjzw_pstime',$item['otherinfo']['zjzw_pstime'])?>	
					</div>
					<label class="col-xs-12 col-sm-2 col-md-2 control-label" style="width: 100px;">聘任时间</label>
					<div class="col-sm-2 col-lg-2">
						<?php  echo tpl_form_field_date('zjzw_prtime',$item['otherinfo']['zjzw_prtime'])?>	
					</div> 					
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">主要工作简历</label>
					<div class="col-sm-9">
						<?php  echo tpl_ueditor('main_work_jl', $item['otherinfo']['main_work_jl']);?>
						<div class="help-block">主要工作简历</div>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">教师资格种类</label>
					<div class="col-sm-2 col-lg-2">
						<div class="input-group">
							<input type="text" name="jszg_type" class="form-control" value="<?php  echo $item['otherinfo']['jszg_type'];?>" />
						</div>
					</div>
					<label class="col-xs-12 col-sm-2 col-md-2 control-label" style="width: 100px;">证书编号</label>
					<div class="col-sm-2 col-lg-2">
						<div class="input-group">
							<input type="text" name="jszgzs_num" class="form-control" value="<?php  echo $item['otherinfo']['jszgzs_num'];?>" />
						</div>	
					</div>   
					<label class="col-xs-12 col-sm-2 col-md-2 control-label" style="width: 100px;">普通话等级</label>
					<div class="col-sm-2 col-lg-2">
						<div class="input-group">
							<input type="text" name="pth_level" class="form-control" value="<?php  echo $item['otherinfo']['pth_level'];?>" />
						</div>	
					</div>
					<label class="col-xs-12 col-sm-2 col-md-2 control-label" style="width: 100px;">证书编号</label>
					<div class="col-sm-2 col-lg-2">
						<div class="input-group">
							<input type="text" name="pthzs_num" class="form-control" value="<?php  echo $item['otherinfo']['pthzs_num'];?>" />
						</div>
					</div>					
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">业绩证书情况</label>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">优质课一：级别</label>
					<div class="col-sm-2 col-lg-2">
						<div class="input-group">
							<input type="text" name="yzk1_level" class="form-control" value="<?php  echo $item['otherinfo']['yzk1_level'];?>" />
						</div>
					</div>
					<label class="col-xs-12 col-sm-2 col-md-2 control-label" style="width: 100px;">等次</label>
					<div class="col-sm-2 col-lg-2">
						<div class="input-group">
							<input type="text" name="yzk1_rank" class="form-control" value="<?php  echo $item['otherinfo']['yzk1_rank'];?>" />
						</div>	
					</div>   
					<label class="col-xs-12 col-sm-2 col-md-2 control-label" style="width: 100px;">发证单位</label>
					<div class="col-sm-2 col-lg-2" style="width:30%">
						<div class="input-group" style="width:100%">
							<input type="text" name="yzk1_org" class="form-control" value="<?php  echo $item['otherinfo']['yzk1_org'];?>" />
						</div>	
					</div>					
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">优质课二：级别</label>
					<div class="col-sm-2 col-lg-2">
						<div class="input-group">
							<input type="text" name="yzk2_level" class="form-control" value="<?php  echo $item['otherinfo']['yzk2_level'];?>" />
						</div>
					</div>
					<label class="col-xs-12 col-sm-2 col-md-2 control-label" style="width: 100px;">等次</label>
					<div class="col-sm-2 col-lg-2">
						<div class="input-group">
							<input type="text" name="yzk2_rank" class="form-control" value="<?php  echo $item['otherinfo']['yzk2_rank'];?>" />
						</div>	
					</div>   
					<label class="col-xs-12 col-sm-2 col-md-2 control-label" style="width: 100px;">发证单位</label>
					<div class="col-sm-2 col-lg-2" style="width:30%">
						<div class="input-group" style="width:100%">
							<input type="text" name="yzk2_org" class="form-control" value="<?php  echo $item['otherinfo']['yzk2_org'];?>" />
						</div>	
					</div>					
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">综合表彰一：级别</label>
					<div class="col-sm-2 col-lg-2">
						<div class="input-group">
							<input type="text" name="zhbz1_level" class="form-control" value="<?php  echo $item['otherinfo']['zhbz1_level'];?>" />
						</div>
					</div>
					<label class="col-xs-12 col-sm-2 col-md-2 control-label" style="width: 100px;">等次</label>
					<div class="col-sm-2 col-lg-2">
						<div class="input-group">
							<input type="text" name="zhbz1_rank" class="form-control" value="<?php  echo $item['otherinfo']['zhbz1_rank'];?>" />
						</div>	
					</div>   
					<label class="col-xs-12 col-sm-2 col-md-2 control-label" style="width: 100px;">发证单位</label>
					<div class="col-sm-2 col-lg-2" style="width:30%">
						<div class="input-group" style="width:100%">
							<input type="text" name="zhbz1_org" class="form-control" value="<?php  echo $item['otherinfo']['zhbz1_org'];?>" />
						</div>	
					</div>					
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">综合表彰二：级别</label>
					<div class="col-sm-2 col-lg-2">
						<div class="input-group">
							<input type="text" name="zhbz2_level" class="form-control" value="<?php  echo $item['otherinfo']['zhbz2_level'];?>" />
						</div>
					</div>
					<label class="col-xs-12 col-sm-2 col-md-2 control-label" style="width: 100px;">等次</label>
					<div class="col-sm-2 col-lg-2">
						<div class="input-group">
							<input type="text" name="zhbz2_rank" class="form-control" value="<?php  echo $item['otherinfo']['zhbz2_rank'];?>" />
						</div>	
					</div>   
					<label class="col-xs-12 col-sm-2 col-md-2 control-label" style="width: 100px;">发证单位</label>
					<div class="col-sm-2 col-lg-2" style="width:30%">
						<div class="input-group" style="width:100%">
							<input type="text" name="zhbz2_org" class="form-control" value="<?php  echo $item['otherinfo']['zhbz2_org'];?>" />
						</div>	
					</div>					
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">教科研一：级别</label>
					<div class="col-sm-2 col-lg-2">
						<div class="input-group">
							<input type="text" name="jky1_level" class="form-control" value="<?php  echo $item['otherinfo']['jky1_level'];?>" />
						</div>
					</div>
					<label class="col-xs-12 col-sm-2 col-md-2 control-label" style="width: 100px;">等次</label>
					<div class="col-sm-2 col-lg-2">
						<div class="input-group">
							<input type="text" name="jky1_rank" class="form-control" value="<?php  echo $item['otherinfo']['jky1_rank'];?>" />
						</div>	
					</div>   
					<label class="col-xs-12 col-sm-2 col-md-2 control-label" style="width: 100px;">发证单位</label>
					<div class="col-sm-2 col-lg-2" style="width:30%">
						<div class="input-group" style="width:100%">
							<input type="text" name="jky1_org" class="form-control" value="<?php  echo $item['otherinfo']['jky1_org'];?>" />
						</div>	
					</div>					
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">教科研二：级别</label>
					<div class="col-sm-2 col-lg-2">
						<div class="input-group">
							<input type="text" name="jky2_level" class="form-control" value="<?php  echo $item['otherinfo']['jky2_level'];?>" />
						</div>
					</div>
					<label class="col-xs-12 col-sm-2 col-md-2 control-label" style="width: 100px;">等次</label>
					<div class="col-sm-2 col-lg-2">
						<div class="input-group">
							<input type="text" name="jky2_rank" class="form-control" value="<?php  echo $item['otherinfo']['jky2_rank'];?>" />
						</div>	
					</div>   
					<label class="col-xs-12 col-sm-2 col-md-2 control-label" style="width: 100px;">发证单位</label>
					<div class="col-sm-2 col-lg-2" style="width:30%">
						<div class="input-group" style="width:100%">
							<input type="text" name="jky2_org" class="form-control" value="<?php  echo $item['otherinfo']['jky2_org'];?>" />
						</div>	
					</div>					
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">其他证书（辅导、论文等）</label>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">证书一：级别</label>
					<div class="col-sm-2 col-lg-2">
						<div class="input-group">
							<input type="text" name="qtzs1_level" class="form-control" value="<?php  echo $item['otherinfo']['qtzs1_level'];?>" />
						</div>
					</div>
					<label class="col-xs-12 col-sm-2 col-md-2 control-label" style="width: 100px;">等次</label>
					<div class="col-sm-2 col-lg-2">
						<div class="input-group">
							<input type="text" name="qtzs1_rank" class="form-control" value="<?php  echo $item['otherinfo']['qtzs1_rank'];?>" />
						</div>	
					</div>   
					<label class="col-xs-12 col-sm-2 col-md-2 control-label" style="width: 100px;">发证单位</label>
					<div class="col-sm-2 col-lg-2" style="width:30%">
						<div class="input-group" style="width:100%">
							<input type="text" name="qtzs1_org" class="form-control" value="<?php  echo $item['otherinfo']['qtzs1_org'];?>" />
						</div>	
					</div>					
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">证书二：级别</label>
					<div class="col-sm-2 col-lg-2">
						<div class="input-group">
							<input type="text" name="qtzs2_level" class="form-control" value="<?php  echo $item['otherinfo']['qtzs2_level'];?>" />
						</div>
					</div>
					<label class="col-xs-12 col-sm-2 col-md-2 control-label" style="width: 100px;">等次</label>
					<div class="col-sm-2 col-lg-2">
						<div class="input-group">
							<input type="text" name="qtzs2_rank" class="form-control" value="<?php  echo $item['otherinfo']['qtzs2_rank'];?>" />
						</div>	
					</div>   
					<label class="col-xs-12 col-sm-2 col-md-2 control-label" style="width: 100px;">发证单位</label>
					<div class="col-sm-2 col-lg-2" style="width:30%">
						<div class="input-group" style="width:100%">
							<input type="text" name="qtzs2_org" class="form-control" value="<?php  echo $item['otherinfo']['qtzs2_org'];?>" />
						</div>	
					</div>					
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">证书三：级别</label>
					<div class="col-sm-2 col-lg-2">
						<div class="input-group">
							<input type="text" name="qtzs3_level" class="form-control" value="<?php  echo $item['otherinfo']['qtzs3_level'];?>" />
						</div>
					</div>
					<label class="col-xs-12 col-sm-2 col-md-2 control-label" style="width: 100px;">等次</label>
					<div class="col-sm-2 col-lg-2">
						<div class="input-group">
							<input type="text" name="qtzs3_rank" class="form-control" value="<?php  echo $item['otherinfo']['qtzs3_rank'];?>" />
						</div>	
					</div>   
					<label class="col-xs-12 col-sm-2 col-md-2 control-label" style="width: 100px;">发证单位</label>
					<div class="col-sm-2 col-lg-2" style="width:30%">
						<div class="input-group" style="width:100%">
							<input type="text" name="qtzs3_org" class="form-control" value="<?php  echo $item['otherinfo']['qtzs3_org'];?>" />
						</div>	
					</div>					
				</div>
			</div>
			<?php  } ?>
        </div>			
        <div class="form-group col-sm-12">
            <input type="submit" name="submit" value="提交" class="btn btn-primary col-lg-1" />
            <input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
        </div>
   </form>
</div>
<!--教师新增授课信息-->
<script>
var skid = <?php  echo $lastids;?>;
var divids = skid + 12000;
		$('#custom-url-add').click(function() {
		divids++;
			var html =  '<div class="form-group">'+
						'	<input type="hidden" name="new[]" value="2222" />'+
						'	<label class="col-xs-12 col-sm-3 col-md-2 control-label">授课信息</label>'+
						'	<label class="col-xs-12 col-sm-2 col-md-2 control-label" style="width: 100px;"><?php echo NJNAME;?></label>'+
						'	<div class="col-sm-2 col-lg-2">'+
						'		<div class="input-group">'+
						'			<select style="margin-right:15px;" name="xq_id_new[]" id="xq_id'+divids+'" class="form-control">'+
						'				<option value="0">请选择<?php echo NJNAME;?></option>'+
										<?php  if(is_array($xueqi)) { foreach($xueqi as $it) { ?>
						'					<option value="<?php  echo $it['sid'];?>"><?php  echo $it['sname'];?></option>'+
										<?php  } } ?>
						'			</select>'+
						'		</div>'+
						'	</div>'+
						'	<label class="col-xs-12 col-sm-2 col-md-2 control-label" style="width: 100px;">班级</label>'+
						'	<div class="col-sm-2 col-lg-2">'+
						'		<div class="input-group">'+
						'			<select style="margin-right:15px;" name="bj_id_new[]" id="bj_id'+divids+'" class="form-control">'+
						'				<option value="0">请选择班级</option>'+
										<?php  if(is_array($bj)) { foreach($bj as $it) { ?>
						'					<option value="<?php  echo $it['sid'];?>"><?php  echo $it['sname'];?></option>'+
										<?php  } } ?>
						'			</select>'+
						'		</div>'+
						'	</div>'+
						'	<label class="col-xs-12 col-sm-2 col-md-2 control-label" style="width: 100px;">科目</label>'+
						'	<div class="col-sm-2 col-lg-2">'+
						'		<div class="input-group">'+
						'			<select style="margin-right:15px;" name="km_id_new[]" id="bj_id" class="form-control">'+
						'				<option value="0">请选择科目</option>'+
										<?php  if(is_array($km)) { foreach($km as $it) { ?>
						'					<option value="<?php  echo $it['sid'];?>"><?php  echo $it['sname'];?></option>'+
										<?php  } } ?>						
						'			</select>'+
						'		</div>'+	
						'	</div>'+
						'	<div class="col-sm-1" style="margin-top:5px">'+
						'		<a href="javascript:;" class="custom-url-del"><i class="fa fa-times-circle"></i></a>'+
						'	</div>'+					
						'</div>';
					;
					
			//if($('#custom-url .items').size() < 2) {
			//	util.message('你至少一项评价规则', '', 'error');
			//	return false;
			//}
			$('#custom-url').append(html);
			$(document).ready(function() {
				var thisid = "#xq_id"+divids;
				$(thisid).change(function() {
					var cityId = $(""+thisid+" option:selected").attr('value');
					var type = 1;
					//alert(thisid);
					changeGradess(cityId, type, function() {
					});
				});
				function changeGradess(gradeId, type) {
					var thisid = "#bj_id"+divids;
					var schoolid = "<?php  echo $schoolid;?>";
					var classlevel = [];
					//获取班次
					$.post("<?php  echo $this->createWebUrl('indexajax',array('op'=>'getbjlist'))?>", {'gradeId': gradeId, 'schoolid': schoolid}, function(data) {
					
						data = JSON.parse(data);
						classlevel = data.bjlist;
						
						var htmls = '';
						htmls += '<select id="bj_id"><option value="">请选择班级</option>';		
						if (classlevel != '') {
							for (var i in classlevel) {
								htmls += '<option value="' + classlevel[i].sid + '">' + classlevel[i].sname + '</option>';
							}
						}
						$(thisid).html(htmls);		
					});

				}	
			});	
				
		});
		$(document).on('click', '.remind-reply-del, .comment-reply-del, .times-del, .custom-url-del', function(){
			$(this).parent().parent().remove();
			return false;
		});		
		function del(id) {
			var id = id;
			var truthBeTold = window.confirm('确认要删除已保存授课信息吗 ?'); 
			var url = "<?php  echo $this->createWebUrl('assess',array('op'=>'delclass','schoolid' => $schoolid))?>";
			var submitData = {
					id:id,
					schoolid:"<?php  echo $schoolid;?>",
			};
			if (truthBeTold) {
				$.post(url, submitData, function(data) {
						
				},'json');
				location.reload();
			}
		}		
</script>
<?php  } else if($operation == 'add') { ?>
<div class="panel panel-info">
    <div class="panel-heading"><a class="btn btn-primary" href="<?php  echo $this->createWebUrl('assess', array('op' => 'display', 'schoolid' => $schoolid))?>"><i class="fa fa-tasks"></i> 返回教师列表</a></div>
</div>
<div class="main">
<form action="" method="post" class="form-horizontal form" enctype="multipart/form-data">
        <input type="hidden" name="sid" value="<?php  echo $it['id'];?>" />
      <input type="hidden" name="schoolid" value="<?php  echo $schoolid;?>" />
        <div class="panel panel-default">
            <div class="panel-heading">添加课程</div>
            <div class="panel-body">
             <div class="form-group">
				<label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label" style="width: 100px;">课程名称：</label>
				<div class="col-sm-9">                       
						<input type="text" class="form-control" name="name" value="" />
				 <div class="help-block">如：春季班小学一<?php echo NJNAME;?>数学尖子班，活动类小学一<?php echo NJNAME;?>数学寒春新生公开课，小学六<?php echo NJNAME;?>上学期奥数比赛冲刺培训班</div>
				</div>
            </div>
            <div class="form-group">
				<label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label" style="width: 100px;">教师姓名:</label>
				<div class="col-sm-9" style="color:red;">
				   <?php  echo $item['tname'];?>
				</div>
            </div>
            <?php  if($school['issale'] == 1 || $school['issale'] == 2) { ?>
            <div class="form-group">   
                <label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label" style="width: 100px;">报名费用：</label>
                <div class="col-sm-2 col-lg-2">
					 <div class="input-group">               
						<input type="text" class="form-control" name="cose" value="" />
						<div class="help-block">输入课程所需费用</div>
					 </div>
                </div>
				<?php  if($_W['isfounder']) { ?>
				<label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label" style="width: 100px;">付费至：</label>
				<div class="col-sm-2 col-lg-2">
					 <div class="input-group">
						<select class="form-control" name="payweid" id="payweid">
							<option value="0">请选择收款账户</option>
							<?php  if(is_array($payweid)) { foreach($payweid as $row) { ?>
							<option value="<?php  echo $row['uniacid'];?>" <?php  if($item['payweid']==$row['uniacid']) { ?>selected<?php  } ?>><?php  echo $row['name'];?></option>
							<?php  } } ?>
						</select>
						<div class="help-block">付费至指定公众号设置的支付方式内，不设置这付费至当前公众号</div>
					 </div>
				</div>
				<?php  } ?>				
                <label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label" style="width: 100px;">人数限制：</label>
                <div class="col-sm-2 col-lg-2">
					 <div class="input-group">               
						<input type="text" class="form-control" name="minge" value="" />
						<div class="help-block">输入课程限报人数</div>
					 </div>
                </div>         
            </div>
           <?php  } else if($school['issale'] == 3 || $school['issale'] == 4) { ?>
            <div class="form-group">   
               <label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label" style="width: 100px;">人数限制：</label>
                    <div class="col-sm-2 col-lg-2">
                         <div class="input-group">               
                            <input type="text" class="form-control" name="minge" value="" />
                     <div class="help-block">输入课程限报人数</div>
                         </div>
                </div>         
            </div>      
            <?php  } ?>            
            <div class="form-group">   
                    <label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label" style="width: 100px;">授课地址：</label>
                    <div class="col-sm-2 col-lg-2">
                         <div class="input-group">               
                            <input type="text" class="form-control" name="adrr" value="" />
                     <div class="help-block">如：多媒体教室，阶梯教室，初一二班教室等</div>
                         </div>
                </div>
               <label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label" style="width: 100px;">精品课程</label>
                    <div class="col-sm-2 col-lg-2">
                        <label class="radio-inline">
                            <input type="radio" name="is_hot" value="1" <?php  if($reply['is_hot']==1 || empty($reply)) { ?>checked<?php  } ?>>是
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="is_hot" value="0" <?php  if(isset($reply['is_hot']) && empty($reply['is_hot'])) { ?>checked<?php  } ?>>否
                        </label>
                        <div class="help-block">是否精品课程</div>
                    </div>            
            </div>
            <div class="form-group">
                <label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label" style="width: 100px;">选择<?php echo NJNAME;?>:</label>
				<div class="col-sm-2 col-lg-2">
					<select style="margin-right:15px;" name="xq" id="xq" class="form-control">
						<option value="0">请选择<?php echo NJNAME;?></option>
						<?php  if(is_array($xueqi)) { foreach($xueqi as $it) { ?>
						<option value="<?php  echo $it['sid'];?>" <?php  if($row['sid'] == $item['bj_id1']) { ?> selected="selected"<?php  } ?>><?php  echo $it['sname'];?></option>
						<?php  } } ?>
					</select>
				</div>
                <label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label" style="width: 100px;">选择班级:</label>
				<div class="col-sm-2 col-lg-2">
					<select style="margin-right:15px;" name="bj" id="bj" class="form-control">
						<option value="0">请选择班级</option>
						<?php  if(is_array($bj)) { foreach($bj as $it) { ?>
						<option value="<?php  echo $it['sid'];?>" <?php  if($row['sid'] == $item['bj_id1']) { ?> selected="selected"<?php  } ?>><?php  echo $it['sname'];?></option>
						<?php  } } ?>
					</select>
				</div>
                <label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label" style="width: 100px;">选择科目:</label>
				<div class="col-sm-2 col-lg-2">
					<select style="margin-right:15px;" name="km" class="form-control">
						<option value="0">请选择科目</option>
						<?php  if(is_array($km)) { foreach($km as $it) { ?>
						<option value="<?php  echo $it['sid'];?>" <?php  if($row['sid'] == $item['km_id1']) { ?> selected="selected"<?php  } ?>><?php  echo $it['sname'];?></option>
						<?php  } } ?>
					</select>
				</div>
            </div>   
            <div class="form-group">
                   <label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label" style="width: 100px;">开始时间:</label>
                     <div class="col-sm-2 col-lg-2">
                    <div class="input-group">
                 <?php  echo tpl_form_field_date('start', date('Y-m-d', TIMESTAMP))?>   
                        </div>
                 </div>
                   <label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label" style="width: 100px;">结束时间:</label>
                     <div class="col-sm-2 col-lg-2">
                    <div class="input-group">
                 <?php  echo tpl_form_field_date('end', date('Y-m-d', TIMESTAMP))?>   
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
<?php  } ?>
<script type="text/javascript">
$(document).ready(function() {
	var e_d = 2 ;
	<?php  if(!(IsHasQx($tid_global,1000602,1,$schoolid))) { ?>
		$(".qx_602").hide();
		e_d = e_d -1;
	<?php  } ?>
	<?php  if(!(IsHasQx($tid_global,1000603,1,$schoolid))) { ?>
		$(".qx_603").hide();
	<?php  } ?>
	<?php  if(!(IsHasQx($tid_global,1000604,1,$schoolid))) { ?>
		$(".qx_604").hide();
	<?php  } ?>
	<?php  if(!(IsHasQx($tid_global,1000605,1,$schoolid))) { ?>
		$(".qx_605").hide();
	<?php  } ?>
	<?php  if(!(IsHasQx($tid_global,1000608,1,$schoolid))) { ?>
		$(".qx_608").hide();
	<?php  } ?>
	<?php  if(!(IsHasQx($tid_global,1000606,1,$schoolid))) { ?>
		$(".qx_606").hide();
	<?php  } ?>
	<?php  if(!(IsHasQx($tid_global,1000607,1,$schoolid))) { ?>
		$(".qx_607").hide();
		e_d = e_d -1;
	<?php  } ?>
	if(e_d == 0){
		$(".qx_e_d").hide();
	}





	
	$("#xq_id1").change(function() {
		var type = 1;
		var cityId = $("#xq_id1 option:selected").attr('value');
		changeGrade(cityId,type, function() {
		});
	});	
	$("#xq_id2").change(function() {
		var type = 2;
		var cityId = $("#xq_id2 option:selected").attr('value');
		changeGrade(cityId,type, function() {
		});
	});
	$("#xq_id3").change(function() {
		var type = 3;
		var cityId = $("#xq_id3 option:selected").attr('value');
		changeGrade(cityId,type, function() {
		});
	});	
	$("#xq").change(function() {
		var type = 4;
		var cityId = $("#xq option:selected").attr('value');
		changeGrade(cityId,type, function() {
		});
	});	
});	
function changeGrade(gradeId, type, __result) {
	
	//$('#njidid').val(gradeId);
	
	var schoolid = "<?php  echo $schoolid;?>";
	var classlevel = [];
	//获取班次
	$.post("<?php  echo $this->createWebUrl('indexajax',array('op'=>'getbjlist'))?>", {'gradeId': gradeId, 'schoolid': schoolid}, function(data) {
	
		data = JSON.parse(data);
		classlevel = data.bjlist;
		
		var html = '';
		if (type == 1){
		html += '<select id="bj_id1"><option value="">请选择班级</option>';
		}
		if (type == 2){
		html += '<select id="bj_id2"><option value="">请选择班级</option>';
		}	
		if (type == 3){
		html += '<select id="bj_id2"><option value="">请选择班级</option>';
		}
		if (type == 4){
		html += '<select id="bj"><option value="">请选择班级</option>';
		}		
		if (classlevel != '') {
			for (var i in classlevel) {
				html += '<option value="' + classlevel[i].sid + '">' + classlevel[i].sname + '</option>';
			}
		}
		if (type == 1){
			$('#bj_id1').html(html);
		}
		if (type == 2){
			$('#bj_id2').html(html);
		}	
		if (type == 3){
			$('#bj_id3').html(html);
		}	
		if (type == 4){
			$('#bj').html(html);
		}		
	});
}
</script>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('public/footer', TEMPLATE_INCLUDEPATH)) : (include template('public/footer', TEMPLATE_INCLUDEPATH));?>