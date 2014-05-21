<?php
require_once(dirname(dirname(__FILE__)) . '/app.php');
require_once(dirname(__FILE__) . '/paybank.php');
$id = intval($_GET['id']);//付款订单id
$order = Table::Fetch('order', $id);
if (!$order) { 
	Session::Set('error', '亲，订单不存在哦');
	redirect( WEB_ROOT . '/index.php' );
}

if ( $order['user_id'] != $login_user['id']) {//是不是当前用户
	redirect( WEB_ROOT . "/team.php?id={$order['team_id']}");
}

if ( $order['service'] == 'bookgold') {
	redirect( WEB_ROOT . "/order/bookfundcheck.php?id={$id}");
}
else if ( $order['service'] == 'telbook'){
	redirect( WEB_ROOT . "/order/view.php?id={$id}");
}
//新过期订单
$timenow=time();
$team = Table::Fetch('team', $order['team_id']);
$team['state'] = team_state($team);
if($order['state']=='timeout')//数据库里已经写了过期
{
	Session::Set('error', '亲，订单已经过期了哦');
	redirect( WEB_ROOT . "/team.php?id={$order['team_id']}");
}
//数据库未写过期但是发现过期了(条件：未付款，类型不是gold和tel
else if ($order['state']=='unpay'
		&& $order['service']!='bookgold'
		&& $order['service']!='telbook'
		&& ($team['close_time'] ||$timenow-$order['create_time']>259200)) //新过期
{
	DB::Update('order',$id,array('state'=>'timeout'));
	Session::Set('error', '亲，订单已经过期了哦');
	redirect( WEB_ROOT . "/team.php?id={$order['team_id']}");
}

if ( $order['state'] == 'unpay' ) {
	/* payservice choice */
	if(@$INI[$order['service']]['mid'] || @$INI[$order['service']]['acc']) {
		$ordercheck[$order['service']] = 'checked';
	}
	else {
		foreach($payservice AS $pone) {
			if(@$INI[$order['service']]['mid'] || @$INI[$order['service']]['acc']) { $ordercheck[$order['service']] = 'checked'; }
		}
	}
	$tmp_goldcoin = min(array(intval($login_user['goldcoin']), 
							  intval($team['goldcoin']) * (intval($order['adult_num']) + intval($order['child_num']))
							  ));	//程孟力修改
	$credityes = ($login_user['money'] + $tmp_goldcoin >= $order['origin']);   
	$creditonly = ($team['team_type'] == 'seconds' && option_yes('creditseconds'));

	/* generator unique pay_id */
	if (! ($order['pay_id'] 
				&& (preg_match('#-(\d+)-(\d+)-#', $order['pay_id'], $m) 
					&& ( $m[1] == $order['id'] && $m[2] == $order['quantity']) )
		  )) {
		$randid = strtolower(Utility::GenSecret(4, Utility::CHAR_WORD));
		$pay_id = "go-{$order['id']}-{$order['quantity']}-{$randid}";
		Table::UpdateCache('order', $order['id'], array(
					'pay_id' => $pay_id,
					));
	}
	die(include template('order_check'));
}
redirect( WEB_ROOT . "/order/view.php?id={$id}");
