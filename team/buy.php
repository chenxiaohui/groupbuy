<?php
require_once(dirname(dirname(__FILE__)) . '/app.php');
need_login();
$id = abs(intval($_GET['id']));
//id是否有效
$team = Table::Fetch('team', $id);
//程孟力增加价格展示相关
$team_price = DB::LimitQuery('team_price', array('condition'=>array('team_id'=>$id)));

if ( !$team || $team['begin_time']>time() ) {
	Session::Set('error', '团购项目不存在');
	redirect( WEB_ROOT . '/index.php' );
}

/* 查询快递清单 */
if ($team['delivery'] == 'express') {
	$express_ralate = unserialize($team['express_relate']);
	foreach ($express_ralate as $k=>$v) {
		$express[$k] = Table::Fetch('category',$v['id']);
		$express[$k]['relate_data'] = $v['price'];
	}
}

//查询是否有购买但是没有付款的订单
$ex_con = array(
		"service!='bookgold'",
		"service!='telbook'",
		'user_id' => $login_user_id,
		'team_id' => $team['id'],
		'state' => 'unpay',
		);
$order = DB::LimitQuery('order', array(
	'condition' => $ex_con,
	'one' => true,
));

//检查是否只能购买一次
if (strtoupper($team['buyonce'])=='Y') {
	$ex_con['state'] = 'pay';
	if ( Table::Count('order', $ex_con) ) {
		Session::Set('error', '您已经成功购买了本单产品，请勿重复购买，快去关注一下其他产品吧！');
		redirect( WEB_ROOT . "/team.php?id={$id}"); 
	}
}

//检查每个用户购买的数量是否超过上限，同时计算出当前用户还可以购买的上限
if ($team['per_number']>0) {
	$now_count = Table::Count('order', array(
		'user_id' => $login_user_id,
		'team_id' => $id,
		'state' => 'pay',
	), 'adult_count') 
	+ Table::Count('order', array(			//程孟力 增加 修正优惠 购买项的数量
		'user_id' => $login_user_id,
		'team_id' => $id,
		'state' => 'pay'), 'child_count');
	$team['per_number'] -= $now_count;
	if ($team['per_number']<=0) {
		Session::Set('error', '您购买本单产品的数量已经达到上限，快去关注一下其他产品吧！');
		redirect( WEB_ROOT . "/team.php?id={$id}"); 
	}
}
else {
	if ($team['max_number']>0) $team['per_number'] = $team['max_number'] - $team['now_number'];
}

//post buy
if ( $_POST ) {
	//need_login();
	$express_price = (int) $_POST['express_price'];
	$express_id = (int) $_POST['express_id'];
	$condbuy = implode('@', $_POST['condbuy']);
		
	$table = new Table('order', $_POST);

	//程孟力增加 价格展示  查找对应价格的选项
	foreach($team_price as $key => $value)
	{
		if ($value['id'] == $table->team_price_id)
		{
			if ($value['team_id'] !=  $team['id'])
				{
					Session::Set('notice', '不存在这样的产品');
					redirect("telbook.php?id={$team_id}");
				}
				$team_price = $value;
				$table->condbuy = $value['team_lang'] . ' ' . $value['hotellevel'];
				break;
		}
		
	}

	//检查购买的数量不能超过上限
	if ( $table->adult_num + $table->child_num == 0 ) {
		Session::Set('error', '购买数量不能小于1份');
		redirect( WEB_ROOT . "/team/buy.php?id={$team['id']}");
	} 
	elseif ( $team['per_number']>0 && ($table->adult_num + $table->child_num) > $team['per_number'] ) {
		Session::Set('error', '您本次购买本单产品已超出限额！');
		redirect( WEB_ROOT . "/team.php?id={$id}"); 
	}

	if ($order && $order['state']=='unpay') {
		$table->SetPk('id', $order['id']);
	}
	
	if (isset($order))
		$table->SetPk('id', $order['id']);
	$table->user_id = $login_user_id;
	$table->state = 'unpay';
	$table->team_id = $team['id'];
	$table->city_id = $team['city_id'];
	$table->express = ($team['delivery']=='express') ? 'Y' : 'N';
	$table->fare = $table->express=='Y' ? $express_price : 0;
	$table->express_id = $table->express=='Y' ? $express_id : 0;
	$table->price = $team['team_price'];
	$table->credit = 0;
	$table->adult_price = $team_price['adult_price'];
	$table->child_price = $team_price['child_price'];
	$table->adult_num = intval($table->adult_num);
	$table->child_num = intval($table->child_num);	
	$table->traveltime = strtotime($table->traveltime);

	if ( $table->id ) {
		$eorder = Table::Fetch('order', $table->id);
		if ($eorder['state']=='unpay' 
				&& $eorder['team_id'] == $id
				&& $eorder['user_id'] == $login_user_id
		   ) {
			$table->origin = team_origin_2($team_price, $table->adult_num,$table->child_num);
			$table->origin -= $eorder['card'];
			$table->origin -= $eorder['goldcoin'];  //程孟力修改
		} else {
			$eorder = null;
		}
	}
	if (!$eorder){
		$table->SetPk('id', null);
		$table->create_time = time();
		$table->origin = team_origin_2($team_price, $table->adult_num,$table->child_num);
	}

	$insert = array(
			'user_id', 'team_id', 'city_id', 'state', 'express_id',
			'fare', 'express', 'origin', 'price','team_price_id', 
			'address', 'zipcode', 'realname', 'mobile',  'adult_num', 'child_num', 'adult_price', 'child_price',
			'quantity', 'create_time', 'remark', 'condbuy', 'extrabuy', 'traveltime'
		);
	if ($flag = $table->update($insert)) {
		$order_id = abs(intval($table->id));
		
		/* 插入订单来源 */
		$data['order_id'] = $order_id;
		$data['user_id'] = $login_user_id;
		$data['referer'] = $_COOKIE['referer'];
		$data['create_time'] = time();
		DB::Insert('referer', $data);
		
		redirect(WEB_ROOT."/order/check.php?id={$order_id}");
	}
}

//each user per day per buy
if (!$order) { 
	$order = json_decode(Session::Get('loginpagepost'),true);
	settype($order, 'array');
	if ($order['mobile']) $login_user['mobile'] = $order['mobile'];
	if ($order['zipcode']) $login_user['zipcode'] = $order['zipcode'];
	if ($order['address']) $login_user['address'] = $order['address'];
	if ($order['realname']) $login_user['realname'] = $order['realname'];
	$order['quantity'] = 1;
}
//end;

$order['origin'] = team_origin($team, $order['quantity'],$expressprice, $extrabuy);

if ($team['max_number']>0 && $team['conduser']=='N') {
	$left = $team['max_number'] - $team['now_number'];
	if ($team['per_number']>0) {
		$team['per_number'] = min($team['per_number'], $left);
	} else {
		$team['per_number'] = $left;
	}
}

$team['condbuy'] = explode('@', $team['condbuy']);
foreach ($team['condbuy'] as $k=>$v) {
	$team['condbuy'][$k] = nanooption($v);
}

//增加相关选项，用于显示和选择旅游的等级
if ( !isset($order['team_price_id']) || intval($order['team_price_id']) == 0)
{
	$order = array('adult_num'=>0, 'child_num'=>0, 'team_price_id'=>$team_price[0]['id'], 'traveltime'=>time());
}

$pricelist = array();
foreach($team_price as $key => $value)
{
	$pricelist[$value['team_lang']] .= $value['hotellevel'] . ',' . $value['id'] . ',' . $value['adult_price'] . ',' .  $value['child_price'] . '|';
	if( $value['id'] == $order['team_price_id'] )
	{
		$lang_select[$value['team_lang']] = "selected";
		$level_select[$value['hotellevel']] = "selected";
		$team_price = $value;
	}
}

if ( empty($lang_select))
{
	$team_price = $team_price[0];
	$lang_select[$team_price['team_lang']] = "selected";
	$level_select[$team_price['hotellevel']] = "selected";
	$order['team_price_id'] = $team_price['id'];
}

foreach($pricelist as $key =>$value)
{
	$pricelist[$key] = trim($value, '|');
	if ($lang_select[$key] == 'selected')
	{
		$levellist= explode('|', $pricelist[$key]);
		foreach($levellist as $lkey=>$lvalue)
		{
			$levelinfo = explode(',', $lvalue);
			$hotellevellist[$levelinfo[0]] = $levelinfo[1] . ',' . $levelinfo[2] . ',' . $levelinfo[3]; 
		}
		
	}
}

include template('team_buy');
