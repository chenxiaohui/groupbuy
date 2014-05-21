<?php
require_once(dirname(dirname(dirname(__FILE__))) . '/app.php');

need_manager();//需要管理员登陆
need_auth('order');//需要授权

$t_con = array(
	'begin_time < '.time(),
	'end_time > '.time(),
);//时间段验证

$statekind=array(
		'pay'=>'已付款',
		'unpay'=>'未付款',
		'timeout'=>'已过期',
		'halfpay'=>'付订金',
);
$paykind=array(
	'telbook'=>'电话预约',
	'bookgold'=>'支付订金',
	'others'=>'其他',
);
$telkind=array(
	'Y'=>'已经电话联系',
	'N'=>'没有电话联系',
);
$dealkind=array(
	'Y'=>'已经处理',
	'N'=>'没有处理',
);
$tourtypes=Utility::OptionArray($allcities,'id','name');
$tourtype=strval($_GET['tourtype']);
if($tourtype)
	$t_con[]="city_ids like '%@$tourtype@%'";

$teams = DB::LimitQuery('team', array('condition'=>$t_con));//所有team
$t_id = Utility::GetColumn($teams, 'id');

$condition = array(
	'team_id' => $t_id,
	'team_id > 0',
);

/* filter */
$uemail = strval($_GET['uemail']);//用户名
if ($uemail) {
	$field = strpos($uemail, '@') ? 'email' : 'username';//用户名还是email
	$field = is_numeric($uemail) ? 'id' : $field;//id还是别的
	$uuser = Table::Fetch('user', $uemail, $field);
	if($uuser) $condition['user_id'] = $uuser['id'];//加上用户id
	else $uemail = null;
}
$id = abs(intval($_GET['id'])); //订单编号
if ($id) $condition['id'] = $id;
$team_id = abs(intval($_GET['team_id']));//项目编号
if ($team_id && in_array($team_id, $t_id)) {//team_id在上面的有效team_id
	$condition['team_id'] = $team_id;
} else { $team_id = null; }

$cbday = strval($_GET['cbday']);
$ceday = strval($_GET['ceday']);
$pbday = strval($_GET['pbday']);
$peday = strval($_GET['peday']);
$state = strval($_GET['state']);//订单状态
$curpay = strval($_GET['paykind']);//订单类型
$ifdeal = strval($_GET['dealed']);//订单类型
$iftel = strval($_GET['called']);//订单类型

if ($cbday) { //下单日期开始
	$cbtime = strtotime($cbday);
	$condition[] = "create_time >= '{$cbtime}'";
}
if ($ceday) { //下单日期结束
	$cetime = strtotime($ceday);
	$condition[] = "create_time <= '{$cetime}'";
}
if ($pbday) { //付款日期开始
	$pbtime = strtotime($pbday);
	$condition[] = "pay_time >= '{$pbtime}'";
}
if ($peday) { //付款日期结束
	$petime = strtotime($peday);
	$condition[] = "pay_time <= '{$petime}'";
}
if ($state) { //订单状态
	$condition['state'] = $state;
}
if ($curpay) { //订单状态
	if($curpay=='bookgold' || $curpay=='telbook')
	$condition['service'] = $curpay;
		else 
	$condition[] = "service <> 'bookgold' And service <> 'telbook'";
}
if($ifdeal)
	$condition['dealed'] = $ifdeal;
if($iftel)
	$condition['called'] = $iftel;

/* end fiter */

$count = Table::Count('order', $condition);//查询合格
list($pagesize, $offset, $pagestring) = pagestring($count, 20);

$orders = DB::LimitQuery('order', array(
	'condition' => $condition,
	'order' => 'ORDER BY id DESC',
	'size' => $pagesize,
	'offset' => $offset,
));

$pay_ids = Utility::GetColumn($orders, 'pay_id');
$pays = Table::Fetch('pay', $pay_ids);

$user_ids = Utility::GetColumn($orders, 'user_id');
$users = Table::Fetch('user', $user_ids);

$team_ids = Utility::GetColumn($orders, 'team_id');
$teams = Table::Fetch('team', $team_ids);

include template('manage_order_index');
