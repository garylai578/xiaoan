<?php

/**
 * 微教育模块
 *
 * @author 高贵血迹
 */

global $_GPC, $_W;
$weid              = $_W['uniacid'];
$action1           = 'jsfz';
$this1             = 'no1';
$action            = 'semester';
$GLOBALS['frames'] = $this->getNaveMenu($_GPC['schoolid'], $action);
$schoolid          = intval($_GPC['schoolid']);
$logo              = pdo_fetch("SELECT logo,title FROM " . tablename($this->table_index) . " WHERE id = '{$schoolid}'");
$operation         = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
if($_W['role'] != 'manager' && !$_W['isfounder'] && $_W['role'] !='owner' ){
		$this->imessage('非法访问，您无权操作该页面','','error');	
	}
if($operation == 'display'){
    if(!empty($_GPC['ssort'])){
        foreach($_GPC['ssort'] as $sid => $ssort){
            pdo_update($this->table_classify, array('ssort' => $ssort), array('sid' => $sid));
        }
        $this->imessage('批量更新排序成功', referer(), 'success');
    }
    $children = array();
    $jsfz     = pdo_fetchall("SELECT * FROM " . tablename($this->table_classify) . " WHERE weid = '{$weid}' And type = 'jsfz' And schoolid = {$schoolid} ORDER BY sid ASC, ssort DESC");
    foreach($jsfz as $index => $row){
        if(!empty($row['parentid'])){
            $children[$row['parentid']][] = $row;
            unset($jsfz[$index]);
        }
    }
}elseif($operation == 'post'){
    $parentid = intval($_GPC['parentid']);
    $sid      = intval($_GPC['sid']);
    if(!empty($sid)){
        $jsfz = pdo_fetch("SELECT * FROM " . tablename($this->table_classify) . " WHERE sid = '$sid'");
    }else{
        $jsfz = array(
            'ssort' => 0,
        );
    }

    if(checksubmit('submit')){
          if(!empty($sid)){
			if(!empty($_GPC['old'])){
        if(empty($_GPC['catename'])){
            $this->imessage('抱歉，请输入分组名称！', referer(), 'error');
        }
        if(empty($_GPC['pname'])){
            $this->imessage('抱歉，请输入称谓！', referer(), 'error');
        }

        $data = array(
            'weid'     => $weid,
            'schoolid' => $_GPC['schoolid'],
            'sname'    => $_GPC['catename'],
            'pname'    => trim($_GPC['pname']),
            'ssort'    => intval($_GPC['ssort']),
            'type'     => 'jsfz',
            
        );


        
          pdo_update($this->table_classify, $data, array('sid' => $sid));
          

        }

        if(!empty($_GPC['new'])){
				foreach($_GPC['new'] as $key => $name){
					$name = trim($_GPC['catename_new'][$key]);
					$pname = trim($_GPC['pname_new'][$key]);
					if(empty($name)){
						$this->imessage('抱歉，请输入分组名称！', referer(), 'error');
					}
					if(empty($pname)){
						$this->imessage('抱歉，请输入称谓！', referer(), 'error');
					}
					$data = array(
					   	'weid'     => $weid,
            			'schoolid' => $_GPC['schoolid'],
       				 	'sname'    => $name,
       				 	'pname'    => $pname,
       				 	'ssort'    => intval($_GPC['ssort_new'][$key]),
            			'type'     => 'jsfz',

					);	
					pdo_insert($this->table_classify, $data);
								
				}
			}
    }else{
			if(!empty($_GPC['new'])){
				foreach($_GPC['new'] as $key => $name){
					$name = trim($_GPC['catename_new'][$key]);
					$pname = trim($_GPC['pname_new'][$key]);
					if(empty($name)){
						$this->imessage('抱歉，请输入分组名称！', referer(), 'error');
					}
					if(empty($pname)){
						$this->imessage('抱歉，请输入称谓！', referer(), 'error');
					}
					$data = array(
						'weid'     => $weid,
            			'schoolid' => $_GPC['schoolid'],
       				 	'sname'    => $name,
       				 	'pname'    => $pname,
       				 	'ssort'    => intval($_GPC['ssort_new'][$key]),
            			'type'     => 'jsfz',
					);	
					pdo_insert($this->table_classify, $data);
					
									
				}
			}			 
		}
       $this->imessage('更新分组成功！',  $this->createWebUrl('jsfz', array('op' => 'display', 'schoolid' => $schoolid)), 'success');
    }
}elseif($operation == 'delete'){
    $sid  = intval($_GPC['sid']);
    $jsfz = pdo_fetch("SELECT sid FROM " . tablename($this->table_classify) . " WHERE sid = '$sid'");
    if(empty($jsfz)){
        $this->imessage('抱歉，分组不存在或是已经被删除！', referer(), 'error');
    }
    pdo_delete($this->table_classify, array('sid' => $sid), 'OR');
    $this->imessage('分组删除成功！', referer(), 'success');
}
include $this->template('web/jsfz');
?>