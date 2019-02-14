<?php
/**
 * Created by PhpStorm.
 * User: laiguanhui
 * Date: 2019/2/1
 * Time: 11:06
 */

global $_W, $_GPC;
$operation = in_array ( $_GPC ['op'], array ('default', 'uploadpic', 'xsqj') ) ? $_GPC ['op'] : 'default';
if ($operation == 'default') {
    die ( json_encode ( array (
        'result' => false,
        'msg' => '参数错误'
    ) ) );
}

if($operation == 'uploadpic'){
    //上传图片 (lee 0722)
    $data = explode ( '|', $_GPC ['json'] );
    load()->func('communication');
    load()->func('file');
    $token2 = $this->getAccessToken2();
    $photoUrls = trim($_GPC ['serverId']);
    if(!empty($photoUrls)) {
        $url = 'https://file.api.weixin.qq.com/cgi-bin/media/get?access_token='.$token2.'&media_id='.$photoUrls;
        $pic_data = ihttp_request($url);
        $path = "images/xsqj/img/";
        $picurl = $path.random(30) .".jpg";
        file_write($picurl,$pic_data['content']);
        if (!empty($_W['setting']['remote']['type'])) { //
            $remotestatus = file_remote_upload($picurl); //
            if (is_error($remotestatus)) {
                message('远程附件上传失败，请检查配置并重新上传');
            }
        }
    }
    $data ['data'] = $picurl;
    die ( json_encode ( $data ) );
}

if ($operation == 'xsqj') {
    load()->func('communication');
    load()->func('file');
    $token2 = $this->getAccessToken2();
    if (! $_GPC ['schoolid'] || ! $_GPC ['weid']) {
        die ( json_encode ( array (
            'result' => false,
            'msg' => '非法请求！' ,
            'status' => 2,
            'info' => '非法请求！'
        ) ) );
    }else {
        $leave = pdo_fetch("SELECT * FROM " . tablename($this->table_leave) . " where :schoolid = schoolid And :weid = weid And :sid = sid And :tid = tid And :isliuyan = isliuyan ORDER BY id DESC LIMIT 1", array(
            ':weid' => $_GPC['weid'],
            ':schoolid' => $_GPC ['schoolid'],
            ':tid' => 0,
            ':isliuyan' => 0,
            ':sid' => $_GPC ['sid']
        ));

        if ((time() - $leave['createtime']) < 100) {
            die (json_encode(array(
                'result' => false,
                'msg' => '您请假太频繁了，请待会再试！'
            )));
        }
        if (empty($_GPC['openid'])) {
            die (json_encode(array(
                'result' => false,
                'msg' => '非法请求！'
            )));
        } else {
            $schoolid = $_GPC['schoolid'];
            $weid = $_GPC['weid'];
            $tid = $_GPC['tid'];
            $photoUrls = $_GPC ['photoUrls'];
            $picurl = "";
            foreach($photoUrls as $key => $v) {
                if (!empty($v)) {
                    $picurl .= $v.";";
                }
            }
            $data1 = array(
                'weid' => $_GPC ['weid'],
                'schoolid' => $_GPC ['schoolid'],
                'openid' => $_GPC ['openid'],
                'sid' => $_GPC ['sid'],
                'type' => $_GPC ['qjType'],
                'startime1' => strtotime($_GPC ['startTime']),
                'endtime1' => strtotime($_GPC ['endTime']),
                'conet' => $_GPC ['content'],
                'uid' => $_GPC['uid'],
                'bj_id' => $_GPC['bj_id'],
                'createtime' => time(),
                'picurl' => $picurl,
            );
            pdo_insert($this->table_leave, $data1);
            $leave_id = pdo_insertid();
            $this->sendMobileXsqj($leave_id, $schoolid, $weid, $tid);
            $data ['status'] = 1;
            $data ['info'] = '申请成功，请勿重复申请！';
            $data ['result'] = true;
            die (json_encode($data));
        }
    }
}