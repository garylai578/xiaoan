<?php

$macid = $_GET['macid'];

// 获取4个接口信息，替代微教育的接口
    if (empty($macid)) {
        echo ('设备id不能为空!');
        exit;
    }

//连接数据库
$mysqli = @new mysqli('127.0.0.1', 'jy_xingheoa_com', 'DmrTAwnNMGSTSdQF');
if ($mysqli->connect_errno) {
    die("could not connect to the database:\r\n" . $mysqli->connect_error);//诊断连接错误
}
$select_db = $mysqli->select_db('jy_xingheoa_com');
if (!$select_db) {
    die("could not connect to the db:\r\n" .  $mysqli->error);
}

$sql = "select * from ims_wx_school_checkmac WHERE macid='{$macid}'";
$res = $mysqli->query($sql);

if($mac=$res->fetch_assoc()){
    $weid = $mac["weid"];
    $macIfc = array(
        "check" => urlencode("http://jy.xingheoa.com/app/index.php?i=".$weid."&c=entry&schoolid=" . $mac["schoolid"] . "&do=checkhx&m=fm_jiaoyu&op=check&mactype=other&macid=" . $macid),
        "login" => urlencode("http://jy.xingheoa.com/app/index.php?i=".$weid."&c=entry&schoolid=" . $mac["schoolid"] . "&do=checkhx&m=fm_jiaoyu&op=login&mactype=other&macid=" . $macid),
        "class" => urlencode("http://jy.xingheoa.com/app/index.php?i=".$weid."&c=entry&schoolid=" . $mac["schoolid"] . "&do=checkhx&m=fm_jiaoyu&op=classinfo&mactype=other&macid=" . $macid),
        "banner" => urlencode("http://jy.xingheoa.com/app/index.php?i=".$weid."&c=entry&schoolid=" . $mac["schoolid"] . "&do=checkhx&m=fm_jiaoyu&op=banner&mactype=other&macid=" . $macid)
    );
    echo json_encode($macIfc);
    exit;
}else{
    echo "你无权使用本设备";
}

