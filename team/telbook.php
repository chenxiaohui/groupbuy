<?php
require_once(dirname(dirname(__FILE__)) . '/app.php');
need_login();
$team_id = $_GET['id'];

if(!isset($team_id))
	redirect('http://localhost/index.php');
	
$team = Table::Fetch('team', $team_id);
$team_price = DB::LimitQuery('team_price', array('condition'=>array('team_id'=>$team_id)));


$ex_con = array(
		'service'=>'telbook',
		'user_id' => $login_user_id,
		'team_id' => $team['id'],
		'state' => 'unpay',
		);
$order = Db::LimitQuery('order', array('condition'=>$ex_con,						
										'one'=>true));

//检查是否只能购买一次
if (strtoupper($team['buyonce'])=='Y') {
	$ex_con['state'] = 'pay';
	unset($ex_con['service']);
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

if ($_POST)
{	
	$table = new Table('order', $_POST);
	
	if (!isset($_POST['team_price_id']))
	{
		Session::Set('notice', '不存在这样的产品');
		redirect("telbook.php?id={$team_id}");
	}
	
	foreach($team_price as $key => $value)
	{
		if ($value['id'] == $table->team_price_id)
		{
			if ($value['team_id'] != $team['id'])
				{
					Session::Set('notice', '不存在这样的产品');
					redirect("telbook.php?id={$team_id}");
				}
				$team_price = $value;
				$table->condbuy = $value['team_lang'] . ' ' . $value['hotellevel'];
				break;
		}
		
	}
	
	if ( isset($order['id']))
		$table->SetPk('id', $order['id']);
	$table->user_id = $login_user_id;
	$table->state = 'unpay';
	$table->team_id = $team['id'];
	$table->city_id = $team['city_id'];
	$table->express = 'N';
	$table->fare = 0;
	$table->service = 'cash';   //指定使用现金付款
	$table->express_id = 0;
	if ( !is_numeric($table->adult_num) || is_nan($table->adult_num)) 
			$table->adult_num = 0;
	if ( !is_numeric($table->child_num) || is_nan($table->child_num) )
			$table->child_num = 0;
	if ( ($table->adult_num + $table->child_num) <=0)
	{
		Session::Set('notice', '购买数量必须大于0');
		redirect("telbook.php?id={$team_id}");
	}
	elseif ( $team['per_number']>0 && ($table->adult_num + $table->child_num) > $team['per_number'] ) {
		Session::Set('error', '您本次购买本单产品已超出限额！');
		redirect( WEB_ROOT . "/team.php?id={$id}"); 
	}
	
	$table->origin = team_tel_origin($team_price, $table->adult_num, $table->child_num);
	$table->price = $team['team_price'];
	$table->credit = 0;
	$table->adult_price = $team_price['adult_price'];
	$table->child_price = $team_price['child_price'];
	if( !isset($order['id']))
		$table->create_time = time();
	$table->traveltime = strtotime($table->traveltime);
	$table->service = 'telbook';
		
	$insert = array(
		'user_id', 'state', 'team_id', 'city_id',  'express_id',
		'fare', 'express', 'origin', 'team_price_id', 
		'realname', 'mobile', 'adult_num', 'child_num', 'adult_price', 'child_price',
		'quantity', 'create_time', 'remark', 'condbuy', 'traveltime', 'service'
	);
	
	$flag = $table->update($insert);
	if ($flag)
		Session::Set('notice', '预订成功，我们的客户人员会尽快和您联系！');
	redirect("/order/view.php?id={$table->id}");
}

if ( !isset($order['team_price_id']))
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
include template('team_telbook');