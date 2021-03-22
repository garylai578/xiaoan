<?php
// 上传各个学校的停车场过车信息

global $_GPC, $_W;

$operation = in_array ( $_GPC ['op'], array ('default', 'check') ) ? $_GPC ['op'] : 'default';
$weid = $_GPC['i'];
$schoolid = $_GPC['schoolid'];
$macid = $_GPC['macid'];
$school = pdo_fetch("SELECT * FROM " . tablename($this->table_index) . " WHERE id = '{$schoolid}' ");

if ($operation == 'default') {
    echo("错误，未知操作");
    exit;
}
if(empty($school)){
    echo("找不到本校");
    exit;
}
if ($operation == 'check') {
    $carNums = 0;
    $carPassNums = 0;

    foreach ($_GPC['cardata'] as $cardata) {
        $data = array(
            'cid' => $cardata[0],
            'sid' => $cardata[1],
            'license' => $cardata[2],
            'licenseColor' => $cardata[3],
            'type' => $cardata[4]
        );
        $ii = pdo_insert('wx_school_car', $data);
        if($ii)
            $carNums++;
    }

    foreach ($_GPC['carpassdata'] as $carpassdata) {
        $data = array(
            'sid' => $carpassdata[0],
            'cid' => $carpassdata[1],
            'directType' => $carpassdata[2],
            'passTime' => $carpassdata[3],
            'sendTime' => $carpassdata[4],
            'picPath1' => $carpassdata[5],
        );
        $ii = pdo_insert('wx_school_carpass', $data);
        if($ii)
            $carPassNums++;
    }

    $result['carNums'] = $carNums;
    $result['carpassNums'] = $carPassNums;
    echo json_encode($result);
    exit;
}