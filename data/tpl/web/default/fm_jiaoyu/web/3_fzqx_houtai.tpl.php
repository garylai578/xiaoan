<?php defined('IN_IA') or exit('Access Denied');?>
	<div class="modal-dialog modal-lg" role="document">		
		<div class="modal-content">			
			<div class="modal-header" style="color: black;">					
				<h4 class="modal-title" id="ModalTitle">弹框</h4>	
			</div>
			<div class="modal-body">
				 <div class="form-group">
					<div class="col-sm-9 col-xs-6" style="width:100% !important">
						<div class="input-group text-info" id="stulist" >
							<p style="color: black;font-weight: bold;margin-top: 10px;margin-bottom: 5px;">校园设置&nbsp;&nbsp;&nbsp;&nbsp;<a onclick="checkAll(1001)">全选</a>&nbsp;&nbsp;&nbsp;&nbsp;<a onclick="UncheckAll(1001)">全不选</a></p>
                        	<label  class="checkbox-inline" style="width:140px;margin-left: 10px"><input class="pre" all_id="1001" data_id="00101" type="checkbox" name="qxarr"  value="1000101" style="float: none;" <?php  if(in_array(1000101,$qx)) { ?> checked="checked" <?php  } ?>>查看基本设置</label>
                        	<label  class="checkbox-inline" style="width:140px;margin-left: 10px"><input class="prd" all_id="1001" data_id="00101" type="checkbox" name="qxarr"  value="1000102" style="float: none;" <?php  if(in_array(1000102,$qx)) { ?> checked="checked" <?php  } ?>>编辑基本设置</label>
                        	<label  class="checkbox-inline" style="width:140px;margin-left: 10px"><input class="pre" all_id="1001" data_id="00102" type="checkbox" name="qxarr"  value="1000103" style="float: none;" <?php  if(in_array(1000103,$qx)) { ?> checked="checked" <?php  } ?>>查看功能管理</label>
                        	<label  class="checkbox-inline" style="width:140px;margin-left: 10px"><input class="prd" all_id="1001" data_id="00102" type="checkbox" name="qxarr"  value="1000104" style="float: none;" <?php  if(in_array(1000104,$qx)) { ?> checked="checked" <?php  } ?>>编辑功能管理</label>
                        	<label  class="checkbox-inline" style="width:140px;margin-left: 10px"><input class="pre" all_id="1001" data_id="00103" type="checkbox" name="qxarr"  value="1000105" style="float: none;" <?php  if(in_array(1000105,$qx)) { ?> checked="checked" <?php  } ?>>查看报名设置</label>
                        	<label  class="checkbox-inline" style="width:140px;margin-left: 10px"><input class="prd" all_id="1001" data_id="00103" type="checkbox" name="qxarr"  value="1000106" style="float: none;" <?php  if(in_array(1000106,$qx)) { ?> checked="checked" <?php  } ?>>编辑报名设置</label>
                        	<label  class="checkbox-inline" style="width:140px;margin-left: 10px"><input class="pre" all_id="1001" data_id="00104" type="checkbox" name="qxarr"  value="1000107" style="float: none;" <?php  if(in_array(1000107,$qx)) { ?> checked="checked" <?php  } ?>>查看考勤设置</label>
                        	<label  class="checkbox-inline" style="width:140px;margin-left: 10px"><input class="prd" all_id="1001" data_id="00104" type="checkbox" name="qxarr"  value="1000108" style="float: none;" <?php  if(in_array(1000108,$qx)) { ?> checked="checked" <?php  } ?>>编辑考勤设置</label>
                        	<label  class="checkbox-inline" style="width:140px;margin-left: 10px"><input type="checkbox" all_id="1001" name="qxarr"  value="1000109" style="float: none;" <?php  if(in_array(1000109,$qx)) { ?> checked="checked" <?php  } ?>>查看短信设置</label>
                        	<p style="color: black;font-weight: bold;margin-top: 10px;margin-bottom: 5px;">基础设置&nbsp;&nbsp;&nbsp;&nbsp;<a onclick="checkAll(1002)">全选</a>&nbsp;&nbsp;&nbsp;&nbsp;<a onclick="UncheckAll(1002)">全不选</a></p>
                        	<label  class="checkbox-inline" style="width:140px;margin-left: 10px"><input class="pre" all_id="1002" data_id="00201" type="checkbox" name="qxarr"  value="1000211" style="float: none;" <?php  if(in_array(1000211,$qx)) { ?> checked="checked" <?php  } ?>>查看所有<?php echo NJNAME;?></label>
                        	<label  class="checkbox-inline" style="width:140px;margin-left: 10px"><input class="prd" all_id="1002" data_id="00201" type="checkbox" name="qxarr"  value="1000212" style="float: none;" <?php  if(in_array(1000212,$qx)) { ?> checked="checked" <?php  } ?>>新增/编辑<?php echo NJNAME;?></label>
                        	<label  class="checkbox-inline" style="width:140px;margin-left: 10px"><input class="prd" all_id="1002" data_id="00201" type="checkbox" name="qxarr"  value="1000213" style="float: none;" <?php  if(in_array(1000213,$qx)) { ?> checked="checked" <?php  } ?>>删除<?php echo NJNAME;?></label>
							<label  class="checkbox-inline" style="width:140px;margin-left: 10px"><input class="prd" all_id="1002" data_id="00201" type="checkbox" name="qxarr"  value="1000214" style="float: none;" <?php  if(in_array(1000214,$qx)) { ?> checked="checked" <?php  } ?>>设置<?php echo NJNAME;?>是否毕业</label><br/>
                        	<label  class="checkbox-inline" style="width:140px;margin-left: 10px"><input class="pre" all_id="1002" data_id="00202" type="checkbox" name="qxarr"  value="1000221" style="float: none;" <?php  if(in_array(1000221,$qx)) { ?> checked="checked" <?php  } ?>>查看所有班级</label>
                        	<label  class="checkbox-inline" style="width:140px;margin-left: 10px"><input class="prd" all_id="1002" data_id="00202" type="checkbox" name="qxarr"  value="1000222" style="float: none;" <?php  if(in_array(1000222,$qx)) { ?> checked="checked" <?php  } ?>>新增/编辑班级</label>
                        	<label  class="checkbox-inline" style="width:140px;margin-left: 10px"><input class="prd" all_id="1002" data_id="00202" type="checkbox" name="qxarr"  value="1000223" style="float: none;" <?php  if(in_array(1000223,$qx)) { ?> checked="checked" <?php  } ?>>删除班级</label>
							<label  class="checkbox-inline" style="width:140px;margin-left: 10px"><input class="prd" all_id="1002" data_id="00202" type="checkbox" name="qxarr"  value="1000224" style="float: none;" <?php  if(in_array(1000224,$qx)) { ?> checked="checked" <?php  } ?>>设置班级是否毕业</label><br/>
                        	<label  class="checkbox-inline" style="width:140px;margin-left: 10px"><input class="pre" all_id="1002" data_id="00203" type="checkbox" name="qxarr"  value="1000231" style="float: none;" <?php  if(in_array(1000231,$qx)) { ?> checked="checked" <?php  } ?>>查看所有成绩期号</label>
                        	<label  class="checkbox-inline" style="width:140px;margin-left: 10px"><input class="prd" all_id="1002" data_id="00203" type="checkbox" name="qxarr"  value="1000232" style="float: none;" <?php  if(in_array(1000232,$qx)) { ?> checked="checked" <?php  } ?>>新增/编辑成绩期号</label>
                        	<label  class="checkbox-inline" style="width:140px;margin-left: 10px"><input class="prd" all_id="1002" data_id="00203" type="checkbox" name="qxarr"  value="1000233" style="float: none;" <?php  if(in_array(1000233,$qx)) { ?> checked="checked" <?php  } ?>>删除成绩期号</label><br/>
                        	<label  class="checkbox-inline" style="width:140px;margin-left: 10px"><input class="pre" all_id="1002" data_id="00204" type="checkbox" name="qxarr"  value="1000241" style="float: none;" <?php  if(in_array(1000241,$qx)) { ?> checked="checked" <?php  } ?>>查看所有课程类型</label>
                        	<label  class="checkbox-inline" style="width:140px;margin-left: 10px"><input class="prd" all_id="1002" data_id="00204" type="checkbox" name="qxarr"  value="1000242" style="float: none;" <?php  if(in_array(1000242,$qx)) { ?> checked="checked" <?php  } ?>>新增/编辑课程类型</label>
                        	<label  class="checkbox-inline" style="width:140px;margin-left: 10px"><input class="prd" all_id="1002" data_id="00204" type="checkbox" name="qxarr"  value="1000243" style="float: none;" <?php  if(in_array(1000243,$qx)) { ?> checked="checked" <?php  } ?>>删除课程类型</label><br/>
                        	<label  class="checkbox-inline" style="width:140px;margin-left: 10px"><input class="pre" all_id="1002" data_id="00205" type="checkbox" name="qxarr"  value="1000251" style="float: none;" <?php  if(in_array(1000251,$qx)) { ?> checked="checked" <?php  } ?>>查看所有教室地址</label>
                        	<label  class="checkbox-inline" style="width:140px;margin-left: 10px"><input class="prd" all_id="1002" data_id="00205" type="checkbox" name="qxarr"  value="1000252" style="float: none;" <?php  if(in_array(1000252,$qx)) { ?> checked="checked" <?php  } ?>>新增/编辑教室地址</label>
                        	<label  class="checkbox-inline" style="width:140px;margin-left: 10px"><input class="prd" all_id="1002" data_id="00205" type="checkbox" name="qxarr"  value="1000253" style="float: none;" <?php  if(in_array(1000253,$qx)) { ?> checked="checked" <?php  } ?>>删除教室地址</label><br/>
                        	<label  class="checkbox-inline" style="width:140px;margin-left: 10px"><input class="pre" all_id="1002" data_id="00206" type="checkbox" name="qxarr"  value="1000261" style="float: none;" <?php  if(in_array(1000261,$qx)) { ?> checked="checked" <?php  } ?>>查看所有科目</label>
                        	<label  class="checkbox-inline" style="width:140px;margin-left: 10px"><input class="prd" all_id="1002" data_id="00206" type="checkbox" name="qxarr"  value="1000262" style="float: none;" <?php  if(in_array(1000262,$qx)) { ?> checked="checked" <?php  } ?>>新增/编辑科目</label>
                        	<label  class="checkbox-inline" style="width:140px;margin-left: 10px"><input class="prd" all_id="1002" data_id="00206" type="checkbox" name="qxarr"  value="1000263" style="float: none;" <?php  if(in_array(1000263,$qx)) { ?> checked="checked" <?php  } ?>>删除科目</label><br/>
                        	<label  class="checkbox-inline" style="width:140px;margin-left: 10px"><input class="pre" all_id="1002" data_id="00207" type="checkbox" name="qxarr"  value="1000271" style="float: none;" <?php  if(in_array(1000271,$qx)) { ?> checked="checked" <?php  } ?>>查看所有时段</label>
                        	<label  class="checkbox-inline" style="width:140px;margin-left: 10px"><input  class="prd" all_id="1002" data_id="00207" type="checkbox" name="qxarr"  value="1000272" style="float: none;" <?php  if(in_array(1000272,$qx)) { ?> checked="checked" <?php  } ?>>新增/编辑时段</label>
                        	<label  class="checkbox-inline" style="width:140px;margin-left: 10px"><input  class="prd" all_id="1002" data_id="00207" type="checkbox" name="qxarr"  value="1000273" style="float: none;" <?php  if(in_array(1000273,$qx)) { ?> checked="checked" <?php  } ?>>删除时段</label><br/>
                        	<label  class="checkbox-inline" style="width:140px;margin-left: 10px"><input  class="pre" all_id="1002" data_id="00208" type="checkbox" name="qxarr"  value="1000281" style="float: none;" <?php  if(in_array(1000281,$qx)) { ?> checked="checked" <?php  } ?>>查看所有星期设置</label>
                        	<label  class="checkbox-inline" style="width:140px;margin-left: 10px"><input class="prd" all_id="1002" data_id="00208" type="checkbox" name="qxarr"  value="1000282" style="float: none;" <?php  if(in_array(1000282,$qx)) { ?> checked="checked" <?php  } ?>>新增/编辑星期设置</label>
                        	<label  class="checkbox-inline" style="width:140px;margin-left: 10px"><input class="prd" all_id="1002" data_id="00208" type="checkbox" name="qxarr"  value="1000283" style="float: none;" <?php  if(in_array(1000283,$qx)) { ?> checked="checked" <?php  } ?>>删除星期设置</label>
							<?php  if(($school['is_video']==1 && !empty($school['videoname'])) ) { ?>
							<p style="color: black;font-weight: bold;margin-top: 10px;margin-bottom: 5px;">监控系统&nbsp;&nbsp;&nbsp;&nbsp;<a onclick="checkAll(1003)">全选</a>&nbsp;&nbsp;&nbsp;&nbsp;<a onclick="UncheckAll(1003)">全不选</a></p>
                        	<label  class="checkbox-inline" style="width:140px;margin-left: 10px"><input class="pre" all_id="1003" data_id="00301" type="checkbox" name="qxarr"  value="1000301" style="float: none;" <?php  if(in_array(1000301,$qx)) { ?> checked="checked" <?php  } ?>>查看所有<?php  echo $school['videoname'];?></label>
                        	<label  class="checkbox-inline" style="width:140px;margin-left: 10px"><input class="prd" all_id="1003" data_id="00301" type="checkbox" name="qxarr"  value="1000302" style="float: none;" <?php  if(in_array(1000302,$qx)) { ?> checked="checked" <?php  } ?>>新增/编辑<?php  echo $school['videoname'];?></label>
                        	<label  class="checkbox-inline" style="width:140px;margin-left: 10px"><input class="prd" all_id="1003" data_id="00301" type="checkbox" name="qxarr"  value="1000303" style="float: none;" <?php  if(in_array(1000303,$qx)) { ?> checked="checked" <?php  } ?>>删除<?php  echo $school['videoname'];?></label><br/>
                        	<label  class="checkbox-inline" style="width:140px;margin-left: 10px"><input class="prd" all_id="1003" data_id="00301" type="checkbox" name="qxarr"  value="1000304" style="float: none;" <?php  if(in_array(1000304,$qx)) { ?> checked="checked" <?php  } ?>>查看评论</label>
                        	<label  class="checkbox-inline" style="width:140px;margin-left: 10px"><input class="prd" all_id="1003" data_id="00301" type="checkbox" name="qxarr"  value="1000305" style="float: none;" <?php  if(in_array(1000305,$qx)) { ?> checked="checked" <?php  } ?>>删除评论</label>
							<?php  } ?>
							<p style="color: black;font-weight: bold;margin-top: 10px;margin-bottom: 5px;">食谱管理&nbsp;&nbsp;&nbsp;&nbsp;<a onclick="checkAll(1004)">全选</a>&nbsp;&nbsp;&nbsp;&nbsp;<a onclick="UncheckAll(1004)">全不选</a></p>
                        	<label  class="checkbox-inline" style="width:140px;margin-left: 10px"><input class="pre" all_id="1004" data_id="00401" type="checkbox" name="qxarr"  value="1000401" style="float: none;" <?php  if(in_array(1000401,$qx)) { ?> checked="checked" <?php  } ?>>查看食谱</label>
                        	<label  class="checkbox-inline" style="width:140px;margin-left: 10px"><input class="prd" all_id="1004" data_id="00401" type="checkbox" name="qxarr"  value="1000402" style="float: none;" <?php  if(in_array(1000402,$qx)) { ?> checked="checked" <?php  } ?>>新增/编辑食谱</label>
                        	<label  class="checkbox-inline" style="width:140px;margin-left: 10px"><input class="prd" all_id="1004" data_id="00401" type="checkbox" name="qxarr"  value="1000403" style="float: none;" <?php  if(in_array(1000403,$qx)) { ?> checked="checked" <?php  } ?>>删除食谱</label><br/>
							<p style="color: black;font-weight: bold;margin-top: 10px;margin-bottom: 5px;">幻灯片管理&nbsp;&nbsp;&nbsp;&nbsp;<a onclick="checkAll(1005)">全选</a>&nbsp;&nbsp;&nbsp;&nbsp;<a onclick="UncheckAll(1005)">全不选</a></p>
                        	<label  class="checkbox-inline" style="width:140px;margin-left: 10px"><input class="pre" all_id="1005" data_id="00501" type="checkbox" name="qxarr"  value="1000501" style="float: none;" <?php  if(in_array(1000501,$qx)) { ?> checked="checked" <?php  } ?>>查看幻灯片</label>
                        	<label  class="checkbox-inline" style="width:140px;margin-left: 10px"><input class="prd" all_id="1005" data_id="00501" type="checkbox" name="qxarr"  value="1000502" style="float: none;" <?php  if(in_array(1000502,$qx)) { ?> checked="checked" <?php  } ?>>新增/编辑幻灯片</label>
                        	<label  class="checkbox-inline" style="width:140px;margin-left: 10px"><input class="prd" all_id="1005" data_id="00501" type="checkbox" name="qxarr"  value="1000503" style="float: none;" <?php  if(in_array(1000503,$qx)) { ?> checked="checked" <?php  } ?>>删除幻灯片</label><br/>
                        	<p style="color: black;font-weight: bold;margin-top: 10px;margin-bottom: 5px;">教师管理&nbsp;&nbsp;&nbsp;&nbsp;<a onclick="checkAll(1006)">全选</a>&nbsp;&nbsp;&nbsp;&nbsp;<a onclick="UncheckAll(1006)">全不选</a></p>
                        	<label  class="checkbox-inline" style="width:140px;margin-left: 10px"><input class="pre" all_id="1006" data_id="00601" type="checkbox" name="qxarr"  value="1000601" style="float: none;" <?php  if(in_array(1000601,$qx)) { ?> checked="checked" <?php  } ?>>查看所有教师</label>
                        	<label  class="checkbox-inline" style="width:140px;margin-left: 10px"><input class="prd" all_id="1006" data_id="00601" type="checkbox" name="qxarr"  value="1000602" style="float: none;" <?php  if(in_array(1000602,$qx)) { ?> checked="checked" <?php  } ?>>新增/编辑教师</label>
                        	<label  class="checkbox-inline" style="width:140px;margin-left: 10px"><input class="prd" all_id="1006" data_id="00601" type="checkbox" name="qxarr"  value="1000603" style="float: none;" <?php  if(in_array(1000603,$qx)) { ?> checked="checked" <?php  } ?>>批量导入教师</label>
                        	<label  class="checkbox-inline" style="width:140px;margin-left: 10px"><input class="prd" all_id="1006" data_id="00601" type="checkbox" name="qxarr"  value="1000604" style="float: none;" <?php  if(in_array(1000604,$qx)) { ?> checked="checked" <?php  } ?>>批量绑定班级</label>
                        	<label  class="checkbox-inline" style="width:140px;margin-left: 10px"><input class="prd" all_id="1006" data_id="00601" type="checkbox" name="qxarr"  value="1000605" style="float: none;" <?php  if(in_array(1000605,$qx)) { ?> checked="checked" <?php  } ?>>导出教师绑定码</label>
                        	<label  class="checkbox-inline" style="width:140px;margin-left: 10px"><input class="prd" all_id="1006" data_id="00601" type="checkbox" name="qxarr"  value="1000606" style="float: none;" <?php  if(in_array(1000606,$qx)) { ?> checked="checked" <?php  } ?>>解绑教师</label>
                        	<label  class="checkbox-inline" style="width:140px;margin-left: 10px"><input class="prd" all_id="1006" data_id="00601" type="checkbox" name="qxarr"  value="1000607" style="float: none;" <?php  if(in_array(1000607,$qx)) { ?> checked="checked" <?php  } ?>>删除教师</label><br/>
                        	<p style="color: black;font-weight: bold;margin-top: 10px;margin-bottom: 5px;">学生管理&nbsp;&nbsp;&nbsp;&nbsp;<a onclick="checkAll(1007)">全选</a>&nbsp;&nbsp;&nbsp;&nbsp;<a onclick="UncheckAll(1007)">全不选</a></p>
                        	<label  class="checkbox-inline" style="width:140px;margin-left: 10px"><input class="pre" all_id="1007" data_id="00701" type="checkbox" name="qxarr"  value="1000701" style="float: none;" <?php  if(in_array(1000701,$qx)) { ?> checked="checked" <?php  } ?>>查看所有学生</label>
                        	<label  class="checkbox-inline" style="width:140px;margin-left: 10px"><input class="prd" all_id="1007" data_id="00701" type="checkbox" name="qxarr"  value="1000702" style="float: none;" <?php  if(in_array(1000702,$qx)) { ?> checked="checked" <?php  } ?>>新增/编辑学生</label>
                        	<label  class="checkbox-inline" style="width:140px;margin-left: 10px"><input class="prd" all_id="1007" data_id="00701" type="checkbox" name="qxarr"  value="1000703" style="float: none;" <?php  if(in_array(1000703,$qx)) { ?> checked="checked" <?php  } ?>>批量导入学生</label>
                        	<label  class="checkbox-inline" style="width:140px;margin-left: 10px"><input class="prd" all_id="1007" data_id="00701" type="checkbox" name="qxarr"  value="1000704" style="float: none;" <?php  if(in_array(1000704,$qx)) { ?> checked="checked" <?php  } ?>>导出学生绑定信息</label>
                        	<label  class="checkbox-inline" style="width:140px;margin-left: 10px"><input class="prd" all_id="1007" data_id="00701" type="checkbox" name="qxarr"  value="1000705" style="float: none;" <?php  if(in_array(1000705,$qx)) { ?> checked="checked" <?php  } ?>>打印学生二维码</label>
                        	<label  class="checkbox-inline" style="width:140px;margin-left: 10px"><input class="prd" all_id="1007" data_id="00701" type="checkbox" name="qxarr"  value="1000706" style="float: none;" <?php  if(in_array(1000706,$qx)) { ?> checked="checked" <?php  } ?>>录入成绩</label>
                        	<label  class="checkbox-inline" style="width:140px;margin-left: 10px"><input class="prd" all_id="1007" data_id="00701" type="checkbox" name="qxarr"  value="1000707" style="float: none;" <?php  if(in_array(1000707,$qx)) { ?> checked="checked" <?php  } ?>>解绑学生</label>
                        	<label  class="checkbox-inline" style="width:140px;margin-left: 10px"><input class="prd" all_id="1007" data_id="00701" type="checkbox" name="qxarr"  value="1000708" style="float: none;" <?php  if(in_array(1000708,$qx)) { ?> checked="checked" <?php  } ?>>删除学生</label><br/>
                        	<p style="color: black;font-weight: bold;margin-top: 10px;margin-bottom: 5px;">成绩管理&nbsp;&nbsp;&nbsp;&nbsp;<a onclick="checkAll(1008)">全选</a>&nbsp;&nbsp;&nbsp;&nbsp;<a onclick="UncheckAll(1008)">全不选</a></p>
                        	<label  class="checkbox-inline" style="width:140px;margin-left: 10px"><input class="pre" all_id="1008" data_id="00801" type="checkbox" name="qxarr"  value="1000801" style="float: none;" <?php  if(in_array(1000801,$qx)) { ?> checked="checked" <?php  } ?>>查看所有成绩</label>
                        	<label  class="checkbox-inline" style="width:140px;margin-left: 10px"><input class="prd" all_id="1008" data_id="00801" type="checkbox" name="qxarr"  value="1000802" style="float: none;" <?php  if(in_array(1000802,$qx)) { ?> checked="checked" <?php  } ?>>编辑单个成绩</label>
                        	<label  class="checkbox-inline" style="width:140px;margin-left: 10px"><input class="prd" all_id="1008" data_id="00801" type="checkbox" name="qxarr"  value="1000803" style="float: none;" <?php  if(in_array(1000803,$qx)) { ?> checked="checked" <?php  } ?>>批量导入成绩</label>
                        	<label  class="checkbox-inline" style="width:140px;margin-left: 10px"><input class="prd" all_id="1008" data_id="00801" type="checkbox" name="qxarr"  value="1000804" style="float: none;" <?php  if(in_array(1000804,$qx)) { ?> checked="checked" <?php  } ?>>删除成绩</label><br/>
                        	
                    		<p style="color: black;font-weight: bold;margin-top: 10px;margin-bottom: 5px;">课程管理&nbsp;&nbsp;&nbsp;&nbsp;<a onclick="checkAll(1009)">全选</a>&nbsp;&nbsp;&nbsp;&nbsp;<a onclick="UncheckAll(1009)">全不选</a></p>
                        	<label  class="checkbox-inline" style="width:140px;margin-left: 10px"><input class="pre" all_id="1009" data_id="00901" pre_id="00901" first_pre="1" type="checkbox" name="qxarr"  value="1000901" style="float: none;" <?php  if(in_array(1000901,$qx)) { ?> checked="checked" <?php  } ?>>查看所有课程</label>
                        	<label  class="checkbox-inline" style="width:140px;margin-left: 10px"><input class="prd" all_id="1009" data_id="00901" type="checkbox" name="qxarr"  value="1000902" style="float: none;" <?php  if(in_array(1000902,$qx)) { ?> checked="checked" <?php  } ?>>新增/编辑课程</label>
                        	<label  class="checkbox-inline" style="width:140px;margin-left: 10px"><input class="prd" all_id="1009" data_id="00901" type="checkbox" name="qxarr"  value="1000903" style="float: none;" <?php  if(in_array(1000903,$qx)) { ?> checked="checked" <?php  } ?>>批量导入课程</label>
                        	<label  class="checkbox-inline" style="width:140px;margin-left: 10px"><input class="prd" all_id="1009" data_id="00901" type="checkbox" name="qxarr"  value="1000904" style="float: none;" <?php  if(in_array(1000904,$qx)) { ?> checked="checked" <?php  } ?>>删除课程</label>
                        	<label  class="checkbox-inline" style="width:140px;margin-left: 10px"><input class="pre" all_id="1009" data_id="00911" pre_id="00901" type="checkbox" name="qxarr"  value="1000911" style="float: none;" <?php  if(in_array(1000911,$qx)) { ?> checked="checked" <?php  } ?>>查看课程评论</label>
                        	<label  class="checkbox-inline" style="width:140px;margin-left: 10px"><input class="prd" all_id="1009" data_id="00911" type="checkbox" name="qxarr"  value="1000912" style="float: none;" <?php  if(in_array(1000912,$qx)) { ?> checked="checked" <?php  } ?>>删除课程评论</label>
                        	<label  class="checkbox-inline" style="width:140px;margin-left: 10px"><input class="pre" all_id="1009" data_id="00921" type="checkbox" name="qxarr"  value="1000921" style="float: none;" <?php  if(in_array(1000921,$qx)) { ?> checked="checked" <?php  } ?>>查看课时</label>
                        	<label  class="checkbox-inline" style="width:140px;margin-left: 10px"><input class="prd" all_id="1009" data_id="00921" type="checkbox" name="qxarr"  value="1000922" style="float: none;" <?php  if(in_array(1000922,$qx)) { ?> checked="checked" <?php  } ?>>新增/编辑课时</label>
                        	<label  class="checkbox-inline" style="width:140px;margin-left: 10px"><input class="prd" all_id="1009" data_id="00921" type="checkbox" name="qxarr"  value="1000923" style="float: none;" <?php  if(in_array(1000923,$qx)) { ?> checked="checked" <?php  } ?>>批量导入课时</label>
                        	<label  class="checkbox-inline" style="width:140px;margin-left: 10px"><input class="prd" all_id="1009" data_id="00921" type="checkbox" name="qxarr"  value="1000924" style="float: none;" <?php  if(in_array(1000924,$qx)) { ?> checked="checked" <?php  } ?>>提醒老师授课</label>
                        	<label  class="checkbox-inline" style="width:140px;margin-left: 10px"><input class="prd" all_id="1009" data_id="00921" type="checkbox" name="qxarr"  value="1000925" style="float: none;" <?php  if(in_array(1000925,$qx)) { ?> checked="checked" <?php  } ?>>删除课时</label>
                        	<label  class="checkbox-inline" style="width:140px;margin-left: 10px"><input class="pre" all_id="1009" data_id="00931" pre_id="00901" type="checkbox" name="qxarr"  value="1000931" style="float: none;" <?php  if(in_array(1000931,$qx)) { ?> checked="checked" <?php  } ?>>查看报名情况</label>
                        	<label  class="checkbox-inline" style="width:140px;margin-left: 10px"><input class="prd" all_id="1009" data_id="00931" type="checkbox" name="qxarr"  value="1000932" style="float: none;" <?php  if(in_array(1000932,$qx)) { ?> checked="checked" <?php  } ?>>学生购买与续购课程</label>
                        	<label  class="checkbox-inline" style="width:140px;margin-left: 10px"><input class="prd" all_id="1009" data_id="00931" type="checkbox" name="qxarr"  value="1000933" style="float: none;" <?php  if(in_array(1000933,$qx)) { ?> checked="checked" <?php  } ?>>报名费退费处理</label>
                        	<label  class="checkbox-inline" style="width:140px;margin-left: 10px"><input class="prd" all_id="1009" data_id="00931" type="checkbox" name="qxarr"  value="1000934" style="float: none;" <?php  if(in_array(1000934,$qx)) { ?> checked="checked" <?php  } ?>>删除报名信息</label>
                        	<label  class="checkbox-inline" style="width:140px;margin-left: 10px"><input class="pre" all_id="1009" data_id="00941" type="checkbox" name="qxarr"  value="1000941" style="float: none;" <?php  if(in_array(1000941,$qx)) { ?> checked="checked" <?php  } ?>>查看签到</label>
                        	<label  class="checkbox-inline" style="width:140px;margin-left: 10px"><input class="prd" all_id="1009" data_id="00941" type="checkbox" name="qxarr"  value="1000942" style="float: none;" <?php  if(in_array(1000942,$qx)) { ?> checked="checked" <?php  } ?>>修改签到状态</label>
                        	<label  class="checkbox-inline" style="width:140px;margin-left: 10px"><input class="prd" all_id="1009" data_id="00941" type="checkbox" name="qxarr"  value="1000943" style="float: none;" <?php  if(in_array(1000943,$qx)) { ?> checked="checked" <?php  } ?>>导出签到</label>
                        	<label  class="checkbox-inline" style="width:140px;margin-left: 10px"><input class="prd" all_id="1009" data_id="00941" type="checkbox" name="qxarr"  value="1000944" style="float: none;" <?php  if(in_array(1000944,$qx)) { ?> checked="checked" <?php  } ?>>删除签到</label>
                        	<?php  if(is_showgkk()) { ?>
							<label  class="checkbox-inline" style="width:140px;margin-left: 10px"><input class="pre"  all_id="1009" data_id="00951" type="checkbox" name="qxarr"  value="1000951" style="float: none;" <?php  if(in_array(1000951,$qx)) { ?> checked="checked" <?php  } ?>>查看公开课</label>
                        	<label  class="checkbox-inline" style="width:140px;margin-left: 10px"><input class="prd"  all_id="1009" data_id="00951" type="checkbox" name="qxarr"  value="1000952" style="float: none;" <?php  if(in_array(1000952,$qx)) { ?> checked="checked" <?php  } ?>>新增/编辑公开课</label>
                        	<label  class="checkbox-inline" style="width:140px;margin-left: 10px"><input class="prd"  all_id="1009" data_id="00951" type="checkbox" name="qxarr"  value="1000953" style="float: none;" <?php  if(in_array(1000953,$qx)) { ?> checked="checked" <?php  } ?>>导出公开课</label>
                        	<label  class="checkbox-inline" style="width:140px;margin-left: 10px"><input class="prd"  all_id="1009" data_id="00951" type="checkbox" name="qxarr"  value="1000954" style="float: none;" <?php  if(in_array(1000954,$qx)) { ?> checked="checked" <?php  } ?>>删除公开课</label>
                        	<label  class="checkbox-inline" style="width:140px;margin-left: 10px"><input class="pre"  all_id="1009" data_id="00952" type="checkbox" name="qxarr"  value="1000955" style="float: none;" <?php  if(in_array(1000955,$qx)) { ?> checked="checked" <?php  } ?>>查看评语</label>
                        	<label  class="checkbox-inline" style="width:140px;margin-left: 10px"><input class="prd"  all_id="1009" data_id="00952" type="checkbox" name="qxarr"  value="10009510" style="float: none;" <?php  if(in_array(10009510,$qx)) { ?> checked="checked" <?php  } ?>>导出评语</label>
                        	<label  class="checkbox-inline" style="width:140px;margin-left: 10px"><input class="prd"  all_id="1009" data_id="00952" type="checkbox" name="qxarr"  value="1000956" style="float: none;" <?php  if(in_array(1000956,$qx)) { ?> checked="checked" <?php  } ?>>删除评语</label>
                        	<label  class="checkbox-inline" style="width:140px;margin-left: 10px"><input class="pre"  all_id="1009" data_id="00953" type="checkbox" name="qxarr" id="1000957"  value="1000957" style="float: none;" <?php  if(in_array(1000957,$qx)) { ?> checked="checked" <?php  } ?>>新增/修改评价标准</label>
                        	<label  class="checkbox-inline" style="width:140px;margin-left: 10px"><input class="prd"  all_id="1009" data_id="00953"  type="checkbox" name="qxarr" id="1000958"  value="1000958" style="float: none;" <?php  if(in_array(1000958,$qx)) { ?> checked="checked" <?php  } ?>>删除评价标准</label>
                        	<label  class="checkbox-inline" style="width:140px;margin-left: 10px"><input class="prd"  all_id="1009" data_id="00951" type="checkbox" name="qxarr"  value="1000959" style="float: none;" <?php  if(in_array(1000959,$qx)) { ?> checked="checked" <?php  } ?>>查看统计</label>
                        	<?php  } ?>
                        	<br/>
                        	
                        	<?php  if(($school['is_kb'] == 1)) { ?>
                        	<p style="color: black;font-weight: bold;margin-top: 10px;margin-bottom: 5px;">公立课表管理&nbsp;&nbsp;&nbsp;&nbsp;<a onclick="checkAll(1010)">全选</a>&nbsp;&nbsp;&nbsp;&nbsp;<a onclick="UncheckAll(1010)">全不选</a></p>
                        	<label  class="checkbox-inline" style="width:140px;margin-left: 10px"><input class="pre" all_id="1010" data_id="01001" type="checkbox" name="qxarr"  value="1001001" style="float: none;" <?php  if(in_array(1001001,$qx)) { ?> checked="checked" <?php  } ?>>查看所有公立课表</label>
                        	<label  class="checkbox-inline" style="width:140px;margin-left: 10px"><input class="prd" all_id="1010" data_id="01001" type="checkbox" name="qxarr"  value="1001002" style="float: none;" <?php  if(in_array(1001002,$qx)) { ?> checked="checked" <?php  } ?>>新增/编辑公立课表</label>
                        	<label  class="checkbox-inline" style="width:140px;margin-left: 10px"><input class="prd" all_id="1010" data_id="01001" type="checkbox" name="qxarr"  value="1001003" style="float: none;" <?php  if(in_array(1001003,$qx)) { ?> checked="checked" <?php  } ?>>删除公立课表</label><br/>
                        	<?php  } ?>
                        	<?php  if(($school['is_rest'] == 1 && $school['shoucename'])) { ?>
                        	<p style="color: black;font-weight: bold;margin-top: 10px;margin-bottom: 5px;"><?php  echo $school['shoucename'];?>&nbsp;&nbsp;&nbsp;&nbsp;<a onclick="checkAll(1011)">全选</a>&nbsp;&nbsp;&nbsp;&nbsp;<a onclick="UncheckAll(1011)">全不选</a></p>
                        	<label  class="checkbox-inline" style="width:140px;margin-left: 10px"><input class="pre" all_id="1011" data_id="01101" type="checkbox" name="qxarr"  value="1001101" style="float: none;" <?php  if(in_array(1001101,$qx)) { ?> checked="checked" <?php  } ?>>查看<?php  echo $school['shoucename'];?></label>
                        	<label  class="checkbox-inline" style="width:140px;margin-left: 10px"><input class="prd" all_id="1011" data_id="01101" type="checkbox" name="qxarr"  value="1001102" style="float: none;" <?php  if(in_array(1001102,$qx)) { ?> checked="checked" <?php  } ?>>删除<?php  echo $school['shoucename'];?></label>
                        	<label  class="checkbox-inline" style="width:140px;margin-left: 10px"><input class="pre" all_id="1011" data_id="01111" type="checkbox" name="qxarr"  value="1001111" style="float: none;" <?php  if(in_array(1001111,$qx)) { ?> checked="checked" <?php  } ?>>新增/编辑评价体系</label>
                        	<label  class="checkbox-inline" style="width:140px;margin-left: 10px"><input class="prd" all_id="1011" data_id="01111" type="checkbox" name="qxarr"  value="1001113" style="float: none;" <?php  if(in_array(1001113,$qx)) { ?> checked="checked" <?php  } ?>>删除评价体系</label>
                        	<label  class="checkbox-inline" style="width:140px;margin-left: 10px"><input class="pre" all_id="1011" data_id="01121" type="checkbox" name="qxarr"  value="1001121" style="float: none;" <?php  if(in_array(1001121,$qx)) { ?> checked="checked" <?php  } ?>>查看评语库</label>
                        	<label  class="checkbox-inline" style="width:140px;margin-left: 10px"><input class="prd" all_id="1011" data_id="01121" type="checkbox" name="qxarr"  value="1001122" style="float: none;" <?php  if(in_array(1001122,$qx)) { ?> checked="checked" <?php  } ?>>新增/编辑评语</label>
                        	<label  class="checkbox-inline" style="width:140px;margin-left: 10px"><input class="prd" all_id="1011" data_id="01121" type="checkbox" name="qxarr"  value="1001123" style="float: none;" <?php  if(in_array(1001123,$qx)) { ?> checked="checked" <?php  } ?>>批量导入评语</label>
                        	<label  class="checkbox-inline" style="width:140px;margin-left: 10px"><input class="prd" all_id="1011" data_id="01121" type="checkbox" name="qxarr"  value="1001124" style="float: none;" <?php  if(in_array(1001124,$qx)) { ?> checked="checked" <?php  } ?>>删除评语</label><br/>
                        	<?php  } ?>
							<p style="color: black;font-weight: bold;margin-top: 10px;margin-bottom: 5px;">作业通知请假&nbsp;&nbsp;&nbsp;&nbsp;<a onclick="checkAll(1012)">全选</a>&nbsp;&nbsp;&nbsp;&nbsp;<a onclick="UncheckAll(1012)">全不选</a></p>
                        	<label  class="checkbox-inline" style="width:140px;margin-left: 10px"><input class="pre" all_id="1012" data_id="01201" type="checkbox" name="qxarr"  value="1001201" style="float: none;" <?php  if(in_array(1001201,$qx)) { ?> checked="checked" <?php  } ?>>查看班级通知</label>
                        	<label  class="checkbox-inline" style="width:140px;margin-left: 10px"><input class="prd" all_id="1012" data_id="01201" type="checkbox" name="qxarr"  value="1001202" style="float: none;" <?php  if(in_array(1001202,$qx)) { ?> checked="checked" <?php  } ?>>发布班级通知</label>
                        	<label  class="checkbox-inline" style="width:140px;margin-left: 10px"><input class="prd" all_id="1012" data_id="01201" type="checkbox" name="qxarr"  value="1001203" style="float: none;" <?php  if(in_array(1001203,$qx)) { ?> checked="checked" <?php  } ?>>班级通知发送记录</label>
                        	<label  class="checkbox-inline" style="width:140px;margin-left: 10px"><input class="prd" all_id="1012" data_id="01201" type="checkbox" name="qxarr"  value="1001204" style="float: none;" <?php  if(in_array(1001204,$qx)) { ?> checked="checked" <?php  } ?>>删除班级通知</label>
                        	<label  class="checkbox-inline" style="width:140px;margin-left: 10px"><input class="pre" all_id="1012" data_id="01211" type="checkbox" name="qxarr"  value="1001211" style="float: none;" <?php  if(in_array(1001211,$qx)) { ?> checked="checked" <?php  } ?>>查看校园群发</label>
                        	<label  class="checkbox-inline" style="width:140px;margin-left: 10px"><input class="prd" all_id="1012" data_id="01211" type="checkbox" name="qxarr"  value="1001212" style="float: none;" <?php  if(in_array(1001212,$qx)) { ?> checked="checked" <?php  } ?>>发布校园群发</label>
                        	<label  class="checkbox-inline" style="width:140px;margin-left: 10px"><input class="prd" all_id="1012" data_id="01211" type="checkbox" name="qxarr"  value="1001213" style="float: none;" <?php  if(in_array(1001213,$qx)) { ?> checked="checked" <?php  } ?>>校园群发发送记录</label>
                        	<label  class="checkbox-inline" style="width:140px;margin-left: 10px"><input class="prd" all_id="1012" data_id="01211" type="checkbox" name="qxarr"  value="1001214" style="float: none;" <?php  if(in_array(1001214,$qx)) { ?> checked="checked" <?php  } ?>>删除校园群发</label>
                        	<label  class="checkbox-inline" style="width:140px;margin-left: 10px"><input class="pre" all_id="1012" data_id="01221" type="checkbox" name="qxarr"  value="1001221" style="float: none;" <?php  if(in_array(1001221,$qx)) { ?> checked="checked" <?php  } ?>>查看作业</label>
                        	<label  class="checkbox-inline" style="width:140px;margin-left: 10px"><input class="prd" all_id="1012" data_id="01221" type="checkbox" name="qxarr"  value="1001222" style="float: none;" <?php  if(in_array(1001222,$qx)) { ?> checked="checked" <?php  } ?>>发布作业</label>
                        	<label  class="checkbox-inline" style="width:140px;margin-left: 10px"><input class="prd" all_id="1012" data_id="01221" type="checkbox" name="qxarr"  value="1001223" style="float: none;" <?php  if(in_array(1001223,$qx)) { ?> checked="checked" <?php  } ?>>作业发送记录</label>
                        	<label  class="checkbox-inline" style="width:140px;margin-left: 10px"><input class="prd" all_id="1012" data_id="01221" type="checkbox" name="qxarr"  value="1001224" style="float: none;" <?php  if(in_array(1001224,$qx)) { ?> checked="checked" <?php  } ?>>删除作业</label>
                        	<label  class="checkbox-inline" style="width:140px;margin-left: 10px"><input class="pre" all_id="1012" data_id="01231" type="checkbox" name="qxarr"  value="1001231" style="float: none;" <?php  if(in_array(1001231,$qx)) { ?> checked="checked" <?php  } ?>>查看请假</label>
                        	<label  class="checkbox-inline" style="width:140px;margin-left: 10px"><input class="prd" all_id="1012" data_id="01231"  type="checkbox" name="qxarr"  value="1001232" style="float: none;" <?php  if(in_array(1001232,$qx)) { ?> checked="checked" <?php  } ?>>处理请假</label>
                        	<label  class="checkbox-inline" style="width:140px;margin-left: 10px"><input class="prd" all_id="1012" data_id="01231" type="checkbox" name="qxarr"  value="1001233" style="float: none;" <?php  if(in_array(1001233,$qx)) { ?> checked="checked" <?php  } ?>>删除请假</label>
                        	<label  class="checkbox-inline" style="width:140px;margin-left: 10px"><input class="pre" all_id="1012" data_id="01241" type="checkbox" name="qxarr"  value="1001241" style="float: none;" <?php  if(in_array(1001241,$qx)) { ?> checked="checked" <?php  } ?>>查看留言</label>
                        	<label  class="checkbox-inline" style="width:140px;margin-left: 10px"><input class="prd" all_id="1012" data_id="01241" type="checkbox" name="qxarr"  value="1001242" style="float: none;" <?php  if(in_array(1001242,$qx)) { ?> checked="checked" <?php  } ?>>删除留言</label><br/>
                        	<p style="color: black;font-weight: bold;margin-top: 10px;margin-bottom: 5px;">报名管理&nbsp;&nbsp;&nbsp;&nbsp;<a onclick="checkAll(1013)">全选</a>&nbsp;&nbsp;&nbsp;&nbsp;<a onclick="UncheckAll(1013)">全不选</a></p>
                        	<label  class="checkbox-inline" style="width:140px;margin-left: 10px"><input class="pre" all_id="1013" data_id="01301" type="checkbox" name="qxarr"  value="1001301" style="float: none;" <?php  if(in_array(1001301,$qx)) { ?> checked="checked" <?php  } ?>>查看报名</label>
                        	<label  class="checkbox-inline" style="width:140px;margin-left: 10px"><input class="prd" all_id="1013" data_id="01301" type="checkbox" name="qxarr"  value="1001302" style="float: none;" <?php  if(in_array(1001302,$qx)) { ?> checked="checked" <?php  } ?>>导出报名</label>
                        	<label  class="checkbox-inline" style="width:140px;margin-left: 10px"><input class="prd" all_id="1013" data_id="01301" type="checkbox" name="qxarr"  value="1001304" style="float: none;" <?php  if(in_array(1001304,$qx)) { ?> checked="checked" <?php  } ?>>处理报名</label>
                        	<label  class="checkbox-inline" style="width:140px;margin-left: 10px"><input class="prd" all_id="1013" data_id="01301" type="checkbox" name="qxarr"  value="1001303" style="float: none;" <?php  if(in_array(1001303,$qx)) { ?> checked="checked" <?php  } ?>>删除报名</label>
                        	
                        	<p style="color: black;font-weight: bold;margin-top: 10px;margin-bottom: 5px;">文章系统&nbsp;&nbsp;&nbsp;&nbsp;<a onclick="checkAll(1014)">全选</a>&nbsp;&nbsp;&nbsp;&nbsp;<a onclick="UncheckAll(1014)">全不选</a></p>
                        	<label  class="checkbox-inline" style="width:140px;margin-left: 10px"><input class="pre" all_id="1014" data_id="01401" type="checkbox" name="qxarr"  value="1001401" style="float: none;" <?php  if(in_array(1001401,$qx)) { ?> checked="checked" <?php  } ?>>查看校园公告</label>
                        	<label  class="checkbox-inline" style="width:140px;margin-left: 10px"><input class="prd" all_id="1014" data_id="01401" type="checkbox" name="qxarr"  value="1001402" style="float: none;" <?php  if(in_array(1001402,$qx)) { ?> checked="checked" <?php  } ?>>新增/编辑校园公告</label>
                        	<label  class="checkbox-inline" style="width:140px;margin-left: 10px"><input class="prd" all_id="1014" data_id="01401" type="checkbox" name="qxarr"  value="1001403" style="float: none;" <?php  if(in_array(1001403,$qx)) { ?> checked="checked" <?php  } ?>>删除校园公告</label><br/>
                        	<label  class="checkbox-inline" style="width:140px;margin-left: 10px"><input class="pre" all_id="1014" data_id="01411" type="checkbox" name="qxarr"  value="1001411" style="float: none;" <?php  if(in_array(1001411,$qx)) { ?> checked="checked" <?php  } ?>>查看校园新闻</label>
                        	<label  class="checkbox-inline" style="width:140px;margin-left: 10px"><input class="prd" all_id="1014" data_id="01411" type="checkbox" name="qxarr"  value="1001412" style="float: none;" <?php  if(in_array(1001412,$qx)) { ?> checked="checked" <?php  } ?>>新增/编辑校园新闻</label>
                        	<label  class="checkbox-inline" style="width:140px;margin-left: 10px"><input class="prd" all_id="1014" data_id="01411" type="checkbox" name="qxarr"  value="1001413" style="float: none;" <?php  if(in_array(1001413,$qx)) { ?> checked="checked" <?php  } ?>>删除校园新闻</label><br/>
                        	<label  class="checkbox-inline" style="width:140px;margin-left: 10px"><input class="pre" all_id="1014" data_id="01421" type="checkbox" name="qxarr"  value="1001421" style="float: none;" <?php  if(in_array(1001421,$qx)) { ?> checked="checked" <?php  } ?>>查看精选文章</label>
                        	<label  class="checkbox-inline" style="width:140px;margin-left: 10px"><input class="prd" all_id="1014" data_id="01421" type="checkbox" name="qxarr"  value="1001422" style="float: none;" <?php  if(in_array(1001422,$qx)) { ?> checked="checked" <?php  } ?>>新增/编辑精选文章</label>
                        	<label  class="checkbox-inline" style="width:140px;margin-left: 10px"><input class="prd" all_id="1014" data_id="01421" type="checkbox" name="qxarr"  value="1001423" style="float: none;" <?php  if(in_array(1001423,$qx)) { ?> checked="checked" <?php  } ?>>删除精选文章</label><br/>
                        	<p style="color: black;font-weight: bold;margin-top: 10px;margin-bottom: 5px;">班级圈管理&nbsp;&nbsp;&nbsp;&nbsp;<a onclick="checkAll(1015)">全选</a>&nbsp;&nbsp;&nbsp;&nbsp;<a onclick="UncheckAll(1015)">全不选</a></p>
                        	<label  class="checkbox-inline" style="width:140px;margin-left: 10px"><input class="pre" all_id="1015" data_id="01501" type="checkbox" name="qxarr"  value="1001501" style="float: none;" <?php  if(in_array(1001501,$qx)) { ?> checked="checked" <?php  } ?>>查看班级圈</label>
                        	<?php  if(($school['isopen'] == 1)) { ?>
                        	<label  class="checkbox-inline" style="width:140px;margin-left: 10px"><input class="prd" all_id="1015" data_id="01501" type="checkbox" name="qxarr"  value="1001503" style="float: none;" <?php  if(in_array(1001503,$qx)) { ?> checked="checked" <?php  } ?>>审核班级圈</label>
                        	<?php  } ?>
                        	<label  class="checkbox-inline" style="width:140px;margin-left: 10px"><input class="prd" all_id="1015" data_id="01501" type="checkbox" name="qxarr"  value="1001502" style="float: none;" <?php  if(in_array(1001502,$qx)) { ?> checked="checked" <?php  } ?>>删除班级圈</label><br/>
                        	<p style="color: black;font-weight: bold;margin-top: 10px;margin-bottom: 5px;">相册管理&nbsp;&nbsp;&nbsp;&nbsp;<a onclick="checkAll(1016)">全选</a>&nbsp;&nbsp;&nbsp;&nbsp;<a onclick="UncheckAll(1016)">全不选</a></p>
                        	<label  class="checkbox-inline" style="width:140px;margin-left: 10px"><input class="pre" all_id="1016"  data_id="01601" type="checkbox" name="qxarr"  value="1001601" style="float: none;" <?php  if(in_array(1001601,$qx)) { ?> checked="checked" <?php  } ?>>查看相册</label>
                        	<label  class="checkbox-inline" style="width:140px;margin-left: 10px"><input class="prd" all_id="1016" data_id="01601" type="checkbox" name="qxarr"  value="1001602" style="float: none;" <?php  if(in_array(1001602,$qx)) { ?> checked="checked" <?php  } ?>>上传相片</label>
                        	<label  class="checkbox-inline" style="width:140px;margin-left: 10px"><input class="prd" all_id="1016" data_id="01601" type="checkbox" name="qxarr"  value="1001603" style="float: none;" <?php  if(in_array(1001603,$qx)) { ?> checked="checked" <?php  } ?>>删除相册</label><br/>
                        	<p style="color: black;font-weight: bold;margin-top: 10px;margin-bottom: 5px;">集体活动&nbsp;&nbsp;&nbsp;&nbsp;<a onclick="checkAll(1017)">全选</a>&nbsp;&nbsp;&nbsp;&nbsp;<a onclick="UncheckAll(1017)">全不选</a></p>
                        	<label  class="checkbox-inline" style="width:140px;margin-left: 10px"><input class="pre" all_id="1017" data_id="01701" type="checkbox" name="qxarr"  value="1001701" style="float: none;" <?php  if(in_array(1001701,$qx)) { ?> checked="checked" <?php  } ?>>查看集体活动</label>
                        	<label  class="checkbox-inline" style="width:140px;margin-left: 10px"><input class="prd" all_id="1017" data_id="01701" type="checkbox" name="qxarr"  value="1001702" style="float: none;" <?php  if(in_array(1001702,$qx)) { ?> checked="checked" <?php  } ?>>新增/编辑集体活动</label>
                        	<label  class="checkbox-inline" style="width:140px;margin-left: 10px"><input class="pre" all_id="1017" data_id="01711" type="checkbox" name="qxarr"  value="1001703" style="float: none;" <?php  if(in_array(1001703,$qx)) { ?> checked="checked" <?php  } ?>>查看报名情况</label>
                        	<label  class="checkbox-inline" style="width:140px;margin-left: 10px"><input class="prd" all_id="1017" data_id="01711" type="checkbox" name="qxarr"  value="1001706" style="float: none;" <?php  if(in_array(1001706,$qx)) { ?> checked="checked" <?php  } ?>>导出报名情况</label>
                        	<label  class="checkbox-inline" style="width:140px;margin-left: 10px"><input  class="prd" all_id="1017" data_id="01711" type="checkbox" name="qxarr"  value="1001704" style="float: none;" <?php  if(in_array(1001704,$qx)) { ?> checked="checked" <?php  } ?>>删除报名</label>
                        	<label  class="checkbox-inline" style="width:140px;margin-left: 10px"><input  class="prd" all_id="1017" data_id="01701" type="checkbox" name="qxarr"  value="1001705" style="float: none;" <?php  if(in_array(1001705,$qx)) { ?> checked="checked" <?php  } ?>>删除集体活动</label><br/>
                        	<p style="color: black;font-weight: bold;margin-top: 10px;margin-bottom: 5px;">家政家教&nbsp;&nbsp;&nbsp;&nbsp;<a onclick="checkAll(1018)">全选</a>&nbsp;&nbsp;&nbsp;&nbsp;<a onclick="UncheckAll(1018)">全不选</a></p>
                        	<label  class="checkbox-inline" style="width:140px;margin-left: 10px"><input class="pre" all_id="1018" data_id="01801" type="checkbox" name="qxarr"  value="1001801" style="float: none;" <?php  if(in_array(1001801,$qx)) { ?> checked="checked" <?php  } ?>>查看家政家教</label>
                        	<label  class="checkbox-inline" style="width:140px;margin-left: 10px"><input class="prd" all_id="1018" data_id="01801" type="checkbox" name="qxarr"  value="1001802" style="float: none;" <?php  if(in_array(1001802,$qx)) { ?> checked="checked" <?php  } ?>>新增/编辑家政家教</label>
                        	<label  class="checkbox-inline" style="width:140px;margin-left: 10px"><input class="prd" all_id="1018" data_id="01801" type="checkbox" name="qxarr"  value="1001803" style="float: none;" <?php  if(in_array(1001803,$qx)) { ?> checked="checked" <?php  } ?>>删除家政家教</label>
                        	<label  class="checkbox-inline" style="width:140px;margin-left: 10px"><input class="pre" all_id="1018" data_id="01802" type="checkbox" name="qxarr"  value="1001804" style="float: none;" <?php  if(in_array(1001804,$qx)) { ?> checked="checked" <?php  } ?>>查看预约情况</label>
                        	<label  class="checkbox-inline" style="width:140px;margin-left: 10px"><input class="prd" all_id="1018" data_id="01802" type="checkbox" name="qxarr"  value="1001805" style="float: none;" <?php  if(in_array(1001805,$qx)) { ?> checked="checked" <?php  } ?>>导出预约情况</label>
                        	<label  class="checkbox-inline" style="width:140px;margin-left: 10px"><input class="prd" all_id="1018" data_id="01802" type="checkbox" name="qxarr"  value="1001806" style="float: none;" <?php  if(in_array(1001806,$qx)) { ?> checked="checked" <?php  } ?>>删除预约情况</label><br/>
                        	<p style="color: black;font-weight: bold;margin-top: 10px;margin-bottom: 5px;">校长信箱&nbsp;&nbsp;&nbsp;&nbsp;<a onclick="checkAll(1019)">全选</a>&nbsp;&nbsp;&nbsp;&nbsp;<a onclick="UncheckAll(1019)">全不选</a></p>
                        	<label  class="checkbox-inline" style="width:140px;margin-left: 10px"><input class="pre" all_id="1019" data_id="01901" type="checkbox" name="qxarr"  value="1001901" style="float: none;" <?php  if(in_array(1001901,$qx)) { ?> checked="checked" <?php  } ?>>查看校长信箱</label>
                        	<label  class="checkbox-inline" style="width:140px;margin-left: 10px"><input class="prd" all_id="1019" data_id="01901" type="checkbox" name="qxarr"  value="1001902" style="float: none;" <?php  if(in_array(1001902,$qx)) { ?> checked="checked" <?php  } ?>>回复留言</label>
                        	<label  class="checkbox-inline" style="width:140px;margin-left: 10px"><input class="prd" all_id="1019" data_id="01901" type="checkbox" name="qxarr"  value="1001903" style="float: none;" <?php  if(in_array(1001903,$qx)) { ?> checked="checked" <?php  } ?>>删除留言</label><br/>
                        	<?php  if(($school['is_cost'] != 2)) { ?>
                        	<p style="color: black;font-weight: bold;margin-top: 10px;margin-bottom: 5px;">缴费管理&nbsp;&nbsp;&nbsp;&nbsp;<a onclick="checkAll(1020)">全选</a>&nbsp;&nbsp;&nbsp;&nbsp;<a onclick="UncheckAll(1020)">全不选</a></p>
                        	<label  class="checkbox-inline" style="width:140px;margin-left: 10px"><input class="pre" all_id="1020" data_id="02001" type="checkbox" name="qxarr"  value="1002001" style="float: none;" <?php  if(in_array(1002001,$qx)) { ?> checked="checked" <?php  } ?>>查看缴费项目</label>
                        	<label  class="checkbox-inline" style="width:140px;margin-left: 10px"><input class="prd" all_id="1020" data_id="02001" type="checkbox" name="qxarr"  value="1002002" style="float: none;" <?php  if(in_array(1002002,$qx)) { ?> checked="checked" <?php  } ?>>新增/修改缴费项目</label>
                        	<label  class="checkbox-inline" style="width:140px;margin-left: 10px"><input class="prd" all_id="1020" data_id="02001" type="checkbox" name="qxarr"  value="1002003" style="float: none;" <?php  if(in_array(1002003,$qx)) { ?> checked="checked" <?php  } ?>>删除缴费项目</label><br/>
                        	<p style="color: black;font-weight: bold;margin-top: 10px;margin-bottom: 5px;">订单管理&nbsp;&nbsp;&nbsp;&nbsp;<a onclick="checkAll(1021)">全选</a>&nbsp;&nbsp;&nbsp;&nbsp;<a onclick="UncheckAll(1021)">全不选</a></p>
                        	<label  class="checkbox-inline" style="width:140px;margin-left: 10px"><input class="pre" all_id="1021" data_id="02101" type="checkbox" name="qxarr"  value="1002101" style="float: none;" <?php  if(in_array(1002101,$qx)) { ?> checked="checked" <?php  } ?>>查看订单</label>
                        	<label  class="checkbox-inline" style="width:140px;margin-left: 10px"><input class="prd" all_id="1021" data_id="02101" type="checkbox" name="qxarr"  value="1002102" style="float: none;" <?php  if(in_array(1002102,$qx)) { ?> checked="checked" <?php  } ?>>导出订单</label>
                        	<label  class="checkbox-inline" style="width:140px;margin-left: 10px"><input class="prd" all_id="1021" data_id="02101" type="checkbox" name="qxarr"  value="1002103" style="float: none;" <?php  if(in_array(1002103,$qx)) { ?> checked="checked" <?php  } ?>>处理订单支付状态</label>
                        	<label  class="checkbox-inline" style="width:140px;margin-left: 10px"><input class="prd" all_id="1021" data_id="02101" type="checkbox" name="qxarr"  value="1002104" style="float: none;" <?php  if(in_array(1002104,$qx)) { ?> checked="checked" <?php  } ?>>删除订单</label><br/>
                        	<?php  if(($school['is_chongzhi'] == 1)) { ?>
                        	<p style="color: black;font-weight: bold;margin-top: 10px;margin-bottom: 5px;">充值管理&nbsp;&nbsp;&nbsp;&nbsp;<a onclick="checkAll(1022)">全选</a>&nbsp;&nbsp;&nbsp;&nbsp;<a onclick="UncheckAll(1022)">全不选</a></p>
                        	<label  class="checkbox-inline" style="width:140px;margin-left: 10px"><input class="pre" all_id="1022" data_id="02201" type="checkbox" name="qxarr"  value="1002201" style="float: none;" <?php  if(in_array(1002201,$qx)) { ?> checked="checked" <?php  } ?>>查看充值套餐</label>
                        	<label  class="checkbox-inline" style="width:140px;margin-left: 10px"><input class="prd" all_id="1022" data_id="02201" type="checkbox" name="qxarr"  value="1002202" style="float: none;" <?php  if(in_array(1002202,$qx)) { ?> checked="checked" <?php  } ?>>新增/修改充值套餐</label>
                        	<label  class="checkbox-inline" style="width:140px;margin-left: 10px"><input class="prd" all_id="1022" data_id="02201" type="checkbox" name="qxarr"  value="1002203" style="float: none;" <?php  if(in_array(1002203,$qx)) { ?> checked="checked" <?php  } ?>>删除充值套餐</label><br/>
                        	<?php  } ?>
                        	
                        	<?php  } ?>

                        	<?php  if(($school['is_recordmac'] == 1)) { ?>
							<p style="color: black;font-weight: bold;margin-top: 10px;margin-bottom: 5px;">时间设置&nbsp;&nbsp;&nbsp;&nbsp;<a onclick="checkAll(1029)">全选</a>&nbsp;&nbsp;&nbsp;&nbsp;<a onclick="UncheckAll(1029)">全不选</a></p>
                        	<label  class="checkbox-inline" style="width:140px;margin-left: 10px"><input class="pre" all_id="1029" data_id="02901" type="checkbox" name="qxarr"  value="1002901" style="float: none;" <?php  if(in_array(1002901,$qx)) { ?> checked="checked" <?php  } ?>>时间设置</label>
							<label  class="checkbox-inline" style="width:140px;margin-left: 10px"><input class="prd" all_id="1029" data_id="02901" type="checkbox" name="qxarr"  value="1002902" style="float: none;" <?php  if(in_array(1002903,$qx)) { ?> checked="checked" <?php  } ?>>编辑时间设置</label>
							<label  class="checkbox-inline" style="width:140px;margin-left: 10px"><input class="prd" all_id="1029" data_id="02901" type="checkbox" name="qxarr"  value="1002903" style="float: none;" <?php  if(in_array(1002903,$qx)) { ?> checked="checked" <?php  } ?>>编辑时间设置</label>
                        	<label  class="checkbox-inline" style="width:140px;margin-left: 10px"><input class="prd" all_id="1029" data_id="02901" type="checkbox" name="qxarr"  value="1002904" style="float: none;" <?php  if(in_array(1002903,$qx)) { ?> checked="checked" <?php  } ?>>编辑时间设置</label>
                        	<label  class="checkbox-inline" style="width:140px;margin-left: 10px"><input class="prd" all_id="1029" data_id="02901" type="checkbox" name="qxarr"  value="1002905" style="float: none;" <?php  if(in_array(1002904,$qx)) { ?> checked="checked" <?php  } ?>>删除时间设置</label><br/>
							
							
                        	<p style="color: black;font-weight: bold;margin-top: 10px;margin-bottom: 5px;">考勤记录&nbsp;&nbsp;&nbsp;&nbsp;<a onclick="checkAll(1023)">全选</a>&nbsp;&nbsp;&nbsp;&nbsp;<a onclick="UncheckAll(1023)">全不选</a></p>
                        	<label  class="checkbox-inline" style="width:140px;margin-left: 10px"><input class="pre" all_id="1023" data_id="02301" type="checkbox" name="qxarr"  value="1002301" style="float: none;" <?php  if(in_array(1002301,$qx)) { ?> checked="checked" <?php  } ?>>查看考勤记录</label>
                        	<label  class="checkbox-inline" style="width:140px;margin-left: 10px"><input class="prd" all_id="1023" data_id="02301" type="checkbox" name="qxarr"  value="1002303" style="float: none;" <?php  if(in_array(1002303,$qx)) { ?> checked="checked" <?php  } ?>>导出考勤记录</label>
                        	<label  class="checkbox-inline" style="width:140px;margin-left: 10px"><input class="prd" all_id="1023" data_id="02301" type="checkbox" name="qxarr"  value="1002304" style="float: none;" <?php  if(in_array(1002304,$qx)) { ?> checked="checked" <?php  } ?>>删除考勤记录</label><br/>
                        	<p style="color: black;font-weight: bold;margin-top: 10px;margin-bottom: 5px;">考勤设备&nbsp;&nbsp;&nbsp;&nbsp;<a onclick="checkAll(1024)">全选</a>&nbsp;&nbsp;&nbsp;&nbsp;<a onclick="UncheckAll(1024)">全不选</a></p>
                        	<label  class="checkbox-inline" style="width:140px;margin-left: 10px"><input class="pre" all_id="1024" data_id="02401" type="checkbox" name="qxarr"  value="1002401" style="float: none;" <?php  if(in_array(1002401,$qx)) { ?> checked="checked" <?php  } ?>>查看设备</label>
                        	<label  class="checkbox-inline" style="width:140px;margin-left: 10px"><input class="prd" all_id="1024" data_id="02401" type="checkbox" name="qxarr"  value="1002402" style="float: none;" <?php  if(in_array(1002402,$qx)) { ?> checked="checked" <?php  } ?>>新增/修改设备</label>
                        	<label  class="checkbox-inline" style="width:140px;margin-left: 10px"><input class="prd" all_id="1024" data_id="02401" type="checkbox" name="qxarr"  value="1002403" style="float: none;" <?php  if(in_array(1002403,$qx)) { ?> checked="checked" <?php  } ?>>远程控制</label>
                        	<label  class="checkbox-inline" style="width:140px;margin-left: 10px"><input class="prd" all_id="1024" data_id="02401" type="checkbox" name="qxarr"  value="1002404" style="float: none;" <?php  if(in_array(1002404,$qx)) { ?> checked="checked" <?php  } ?>>删除设备</label><br/>
                        	<p style="color: black;font-weight: bold;margin-top: 10px;margin-bottom: 5px;">考勤卡库&nbsp;&nbsp;&nbsp;&nbsp;<a onclick="checkAll(1025)">全选</a>&nbsp;&nbsp;&nbsp;&nbsp;<a onclick="UncheckAll(1025)">全不选</a></p>
                        	<label  class="checkbox-inline" style="width:140px;margin-left: 10px"><input class="pre" all_id="1025" data_id="02501" type="checkbox" name="qxarr"  value="1002501" style="float: none;" <?php  if(in_array(1002501,$qx)) { ?> checked="checked" <?php  } ?>>查看卡情况</label>
                        	<label  class="checkbox-inline" style="width:140px;margin-left: 10px"><input class="prd" all_id="1025" data_id="02501" type="checkbox" name="qxarr"  value="1002502" style="float: none;" <?php  if(in_array(1002502,$qx)) { ?> checked="checked" <?php  } ?>>新增/修改卡</label>
                        	<label  class="checkbox-inline" style="width:140px;margin-left: 10px"><input class="prd" all_id="1025" data_id="02501" type="checkbox" name="qxarr"  value="1002503" style="float: none;" <?php  if(in_array(1002503,$qx)) { ?> checked="checked" <?php  } ?>>批量导入卡</label>
                        	<label  class="checkbox-inline" style="width:140px;margin-left: 10px"><input class="prd" all_id="1025" data_id="02501" type="checkbox" name="qxarr"  value="1002504" style="float: none;" <?php  if(in_array(1002504,$qx)) { ?> checked="checked" <?php  } ?>>解绑卡</label>
                        	<label  class="checkbox-inline" style="width:140px;margin-left: 10px"><input class="prd" all_id="1025" data_id="02501" type="checkbox" name="qxarr"  value="1002505" style="float: none;" <?php  if(in_array(1002505,$qx)) { ?> checked="checked" <?php  } ?>>删除卡</label><br/>
                        	<?php  } ?>
                        	<?php  if($mallsetinfo['isShow'] == 1) { ?>
							<p style="color: black;font-weight: bold;margin-top: 10px;margin-bottom: 5px;">商品设置&nbsp;&nbsp;&nbsp;&nbsp;<a onclick="checkAll(1026)">全选</a>&nbsp;&nbsp;&nbsp;&nbsp;<a onclick="UncheckAll(1026)">全不选</a></p>
                        	<label  class="checkbox-inline" style="width:140px;margin-left: 10px"><input class="pre" all_id="1026" data_id="02601" type="checkbox" name="qxarr"  value="1002601" style="float: none;" <?php  if(in_array(1002601,$qx)) { ?> checked="checked" <?php  } ?>>查看商品</label>
                        	<label  class="checkbox-inline" style="width:140px;margin-left: 10px"><input class="prd" all_id="1026" data_id="02601" type="checkbox" name="qxarr"  value="1002602" style="float: none;" <?php  if(in_array(1002602,$qx)) { ?> checked="checked" <?php  } ?>>新增/修改商品</label>
                        	<label  class="checkbox-inline" style="width:140px;margin-left: 10px"><input class="prd" all_id="1026" data_id="02601" type="checkbox" name="qxarr"  value="1002603" style="float: none;" <?php  if(in_array(1002603,$qx)) { ?> checked="checked" <?php  } ?>>删除商品</label><br/>
                           	<p style="color: black;font-weight: bold;margin-top: 10px;margin-bottom: 5px;">商城订单&nbsp;&nbsp;&nbsp;&nbsp;<a onclick="checkAll(1027)">全选</a>&nbsp;&nbsp;&nbsp;&nbsp;<a onclick="UncheckAll(1027)">全不选</a></p>
                        	<label  class="checkbox-inline" style="width:140px;margin-left: 10px"><input class="pre" all_id="1027" data_id="02701" type="checkbox" name="qxarr"  value="1002701" style="float: none;" <?php  if(in_array(1002701,$qx)) { ?> checked="checked" <?php  } ?>>查看商城订单</label>
                        	<label  class="checkbox-inline" style="width:140px;margin-left: 10px"><input class="prd" all_id="1027" data_id="02701" type="checkbox" name="qxarr"  value="1002702" style="float: none;" <?php  if(in_array(1002702,$qx)) { ?> checked="checked" <?php  } ?>>导出商城订单</label>
                        	<label  class="checkbox-inline" style="width:140px;margin-left: 10px"><input class="prd" all_id="1027" data_id="02701" type="checkbox" name="qxarr"  value="1002703" style="float: none;" <?php  if(in_array(1002703,$qx)) { ?> checked="checked" <?php  } ?>>处理商城订单状态</label>
                        	<label  class="checkbox-inline" style="width:140px;margin-left: 10px"><input class="prd" all_id="1027" data_id="02701" type="checkbox" name="qxarr"  value="1002704" style="float: none;" <?php  if(in_array(1002704,$qx)) { ?> checked="checked" <?php  } ?>>删除商城订单</label><br/>
                        	<p style="color: black;font-weight: bold;margin-top: 10px;margin-bottom: 5px;">积分管理&nbsp;&nbsp;&nbsp;&nbsp;<a onclick="checkAll(1028)">全选</a>&nbsp;&nbsp;&nbsp;&nbsp;<a onclick="UncheckAll(1028)">全不选</a></p>
                        	<label  class="checkbox-inline" style="width:140px;margin-left: 10px"><input class="pre" all_id="1028" data_id="02801" type="checkbox" name="qxarr"  value="1002801" style="float: none;" <?php  if(in_array(1002801,$qx)) { ?> checked="checked" <?php  } ?>>查看积分记录</label>
                        	<label  class="checkbox-inline" style="width:140px;margin-left: 10px"><input class="prd" all_id="1028" data_id="02801" type="checkbox" name="qxarr"  value="1002802" style="float: none;" <?php  if(in_array(1002802,$qx)) { ?> checked="checked" <?php  } ?>>删除积分记录</label>
                        	<label  class="checkbox-inline" style="width:140px;margin-left: 10px"><input class="pre" all_id="1028" data_id="02811" type="checkbox" name="qxarr"  value="1002811" style="float: none;" <?php  if(in_array(1002811,$qx)) { ?> checked="checked" <?php  } ?>>查看积分规则</label>
                        	<label  class="checkbox-inline" style="width:140px;margin-left: 10px"><input class="prd" all_id="1028" data_id="02811" type="checkbox" name="qxarr"  value="1002812" style="float: none;" <?php  if(in_array(1002812,$qx)) { ?> checked="checked" <?php  } ?>>新增/修改积分规则</label>
                        	<label  class="checkbox-inline" style="width:140px;margin-left: 10px"><input class="prd" all_id="1028" data_id="02811" type="checkbox" name="qxarr"  value="1002813" style="float: none;" <?php  if(in_array(1002813,$qx)) { ?> checked="checked" <?php  } ?>>删除积分规则</label><br/>
                        	<?php  } ?>
						</div>
					</div>
				</div>			
			</div>				
			<div class="modal-footer">	
				<button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
				<button type="button" class="btn btn-primary" id="submit2" style="display: none;" onclick="setdown_ht(<?php  echo $fzid;?>)">确认编辑</button>
			</div>			
		</div>	
	</div>
	<script type="text/javascript">
	function checkAll(all_id){
		$("input[all_id="+ all_id +"]").prop("checked",true);
	}
	function UncheckAll(all_id){
		$("input[all_id="+ all_id +"]").prop("checked",false);
	}
	$(document).ready(function() {
		$(".prd").change(function(){
			if($(this).prop('checked')){
				var data_id = $(this).attr("data_id");
				$(".pre[data_id="+data_id+"]").prop("checked",true);
				if(data_id == "00911" || data_id == "00931"){
					$(".pre[data_id=00901]").prop("checked",true);
				}
				if(data_id == "00953" ){
					$(".pre[data_id=00953]").prop("checked",true);
					$(".pre[data_id=00951]").prop("checked",true);
				}
				if(data_id == "00952" ){
					$(".pre[data_id=00952]").prop("checked",true);
					$(".pre[data_id=00951]").prop("checked",true);
				}
				if(data_id == "01121" ){
					$(".pre[data_id=01111]").prop("checked",true);
				}
				if(data_id == "01711" ){
					$(".pre[data_id=01701]").prop("checked",true);
				}
				if(data_id == "01802" ){
					$(".pre[data_id=01801]").prop("checked",true);
				}
			}
		})

		$(".pre").change(function(){
			if ($(this).prop('checked') == false){
				var data_id = $(this).attr("data_id");
				$(".prd[data_id="+data_id+"]").prop("checked",false);
				if(data_id == "00901"){
					$(".pre[data_id=00911]").prop("checked",false);
					$(".pre[data_id=00931]").prop("checked",false);
					$(".prd[data_id=00911]").prop("checked",false);
					$(".prd[data_id=00931]").prop("checked",false);
				}
				if(data_id == "00951"){
					$(".pre[data_id=00953]").prop("checked",false);
					$(".pre[data_id=00952]").prop("checked",false);
					$(".prd[data_id=00953]").prop("checked",false);
					$(".prd[data_id=00952]").prop("checked",false);
				}
				if(data_id == "01111"){
					$(".pre[data_id=01121]").prop("checked",false);
					$(".prd[data_id=01121]").prop("checked",false);
				}
				if(data_id == "01701"){
					$(".pre[data_id=01711]").prop("checked",false);
					$(".prd[data_id=01711]").prop("checked",false);
				}
				if(data_id == "01801"){
					$(".pre[data_id=01802]").prop("checked",false);
					$(".prd[data_id=01802]").prop("checked",false);
				}
			}else if($(this).prop('checked') == true){
				var pre_id = $(this).attr("pre_id");
				if(pre_id != null){
					//alert(pre_id);
					$(".pre[first_pre=1]").prop("checked",true);
				}
				var data_id = $(this).attr("data_id");
				if(data_id == "00953" ){
					$(".pre[data_id=00951]").prop("checked",true);
				}
				if(data_id == "00952" ){
					$(".pre[data_id=00951]").prop("checked",true);
				}
				if(data_id == "01121"){
					$(".pre[data_id=01111]").prop("checked",true);
				}
				if(data_id == "01711" ){
					$(".pre[data_id=01701]").prop("checked",true);
				}
				if(data_id == "01802" ){
					$(".pre[data_id=01801]").prop("checked",true);
				}
			}
		})
	});
	function setdown_qd(fzid){
		var schoolid = "<?php  echo $_GPC['schoolid'];?>";
		var str = new Array();
		$("input:checkbox[name='qxarr']:checked").each(function(i) {
			var val = $(this).val();
			str[i] =  val ;
		});	
		$.post("<?php  echo $this->createWebUrl('indexajax',array('op'=>'set_fzqx','type'=>2))?>", {'schoolid': schoolid,'fzid':fzid,'sidarr':str}, function(data) {
			console.log(data);
			data = JSON.parse(data);
			console.log(data);
			alert(data.msg);
	 		location.reload();
		});
	}

	function setdown_ht(fzid){
		var schoolid = "<?php  echo $_GPC['schoolid'];?>";
		var str = new Array();
		$("input:checkbox[name='qxarr']:checked").each(function(i) {
			var val = $(this).val();
			str[i] =  val ;
		});	
		$.post("<?php  echo $this->createWebUrl('indexajax',array('op'=>'set_fzqx','type'=>1))?>", {'schoolid': schoolid,'fzid':fzid,'sidarr':str}, function(data) {
			console.log(data);
			data = JSON.parse(data);
			console.log(data);
			alert(data.msg);
	 		location.reload();
		});
	}		


	
	</script>