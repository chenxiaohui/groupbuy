<?php
require_once(dirname(dirname(__FILE__)) . '/app.php');
require_once(dirname(__FILE__) . '/paybank.php');
$id = intval($_GET['id']);
$order = Table::Fetch('order', $id);
if (!$order) { 
	Session::Set('error', '订单不存在');
	redirect( WEB_ROOT . '/index.php' );
}

$team = Table::Fetch('team', $order['team_id']);
$team['state'] = team_state($team);
if ( $team['close_time'] ) {
	redirect( WEB_ROOT . "/team.php?id={$id}");
}

if ( $order['state'] == 'unpay' ) {

	/* payservice choice */
	$ordercheck['alipay'] = 'checked';		//默认使用支付宝进行支付
	
	$tmp_goldcoin = min(array($login_user['goldcoin'], $team['goldcoin']));	//程孟力修改
	$credityes = ($login_user['money'] + $tmp_goldcoin >= $order['bookgold']);   
	$creditonly = ($team['team_type'] == 'seconds' && option_yes('creditseconds'));

	/* generator unique pay_id */
	if (! ($order['pay_id'] 
				&& (preg_match('#-(\d+)-(\d+)-#', $order['pay_id'], $m) 
					&& ( $m[1] == $order['id'] && $m[2] == $order['quantity']) )
		  )) {
		$randid = strtolower(Utility::GenSecret(4, Utility::CHAR_WORD));
		$pay_id = "book-{$order['id']}-{$order['quantity']}-{$randid}";
		Table::UpdateCache('order', $order['id'], array(
					'pay_id' => $pay_id,
					));
	}
	die(include template('bookfund_check'));
}
redirect( WEB_ROOT . "/order/view.php?id={$id}");
