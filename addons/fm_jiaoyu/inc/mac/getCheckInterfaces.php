<?php
global $_GPC, $_W;
$weid = $_W['uniacid'];
$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
$macid = $_GPC['macid'];

if($operation == 'getMacIfc') {
    echo("i am here");
    if (empty($macid))
        return('设备id不能为空');

    $mac = pdo_fetch("SELECT * FROM " . tablename($this->table_checkmac) . " WHERE macid = '{$macid}'");
    if (empty($mac))
        return "你无权使用本设备！";

    $macIfc = array(
        "check" => "http://jy.xingheoa.com/app/index.php?i=3&c=entry&schoolid=" . $mac["schoolid"] . "&do=checkhx&m=fm_jiaoyu&op=login&mactype=other&macid=" . $macid,
        "login" => "http://jy.xingheoa.com/app/index.php?i=3&c=entry&schoolid=" . $mac["schoolid"] . "&do=checkhx&m=fm_jiaoyu&op=classinfo&mactype=other&macid=" . $macid,
        "class" => "http://jy.xingheoa.com/app/index.php?i=3&c=entry&schoolid=" . $mac["schoolid"] . "&do=checkhx&m=fm_jiaoyu&op=check&mactype=other&macid=" . $macid,
        "banner" => "http://jy.xingheoa.com/app/index.php?i=3&c=entry&schoolid=" . $mac["schoolid"] . "&do=checkhx&m=fm_jiaoyu&op=banner&mactype=other&macid=" . $macid,
        "roomlist" => ""
    );
    return json_encode($macIfc);
}
