<?php
require_once(dirname(dirname(__FILE__)) . '/app.php');
require_once(dirname(__FILE__) . '/paybank.php');

need_login();

if (is_post()) {
	$order_id = abs(intval($_POST['order_id']));
} else {
	$order_id = $id = abs(intval($_GET['id']));
	redirect("/order/bookfundcheck.php?id={$order_id}");
}

if(!$order_id || !($order = Table::Fetch('order', $order_id))) {
	redirect( WEB_ROOT. '/index.php');
}
if ( $order['user_id'] != $login_user['id']) {
	redirect( WEB_ROOT . "/team.php?id={$order['team_id']}");
}

if ( $order['service'] != 'bookgold'){
	redirect( WEB_ROOT . "/order/index.php");
}

$team = Table::Fetch('team', $order['team_id']);
team_state($team);

if (is_post() && $_POST['paytype'] ) {
	$paytype = pay_getservice($_POST['paytype']);
}

/* generate unique pay_id */
if (!($pay_id = $order['pay_id'])) {
	$randid = strtolower(Utility::GenSecret(4, Utility::CHAR_WORD));
	$pay_id = "book-{$order['id']}-{$order['quantity']}-{$randid}";
	Table::UpdateCache('order', $order['id'], array(
				'pay_id' => $pay_id,
				));
}

//peruser buy count
if ($_POST && $team['per_number']>0) {
	$now_count = Table::Count('order', array(
		'user_id' => $login_user_id,
		'team_id' => $team['id'],
		'state' => 'pay',
	), 'quantity');
	$leftnum = ($team['per_number'] - $now_count);
	if ($leftnum <= 0) {
		Session::Set('error', '您购买本单产品的数量已经达到上限，快去关注一下其他产品吧！');
		redirect( WEB_ROOT . "/team.php?id={$id}"); 
	}
}

//payed order
if ( $order['state'] == 'pay' ) {  
	if ( is_get() ) {
		die(include template('order_pay_success'));		
	} else {
		redirect(WEB_ROOT  . "/order/bookfundpay.php?id={$order_id}");
	}
}
else if ( $order['state'] =='halfpay')
{
	if ( is_get() ) {
		die(include template('order_book_success'));		
	} else {
		redirect(WEB_ROOT  . "/order/bookfundpay.php?id={$order_id}");
	}
}
$tmp_usermoney = $login_user['money'];		//账户余额
$tmp_usergold = min(array($login_user['goldcoin'], 
				          intval($team['goldcoin']) * (intval($order['adult_num']) + intval($order['child_num']))
			));  //最多可以使用的金币数目
$total_money = moneyit($order['bookgold'] - $tmp_usermoney - $tmp_usergold);  //除了账户余额和金币之外，额外需要支付的钱

if ($total_money<0) { 	//账户余额和金币足够支付
	$total_money = 0; $paytype = 'credit'; 
} else if($_POST){
	if ($order['credit']!=$credit) {
		Table::UpdateCache('order', $order_id, array('credit'=>$tmp_usermoney,));
	}
	if ($order['goldcoin']!=$tmp_usergold) {
		Table::UpdateCache('order', $order_id, array('goldcoin'=>$tmp_usergold,));
	}
}	

/* credit pay */
if ( $_POST['action'] == 'redirect' ) {
	redirect($_POST['reqUrl']);
}
elseif ( $_POST['service'] == 'credit' ) {
	$tmp_goldcoin = min(array($team['goldcoin'], $login_user['goldcoin']));
	if ( $order['bookgold'] > $login_user['money'] + $tmp_goldcoin  ){
		Table::Delete('order', $order_id);
		redirect( WEB_ROOT . '/order/index.php');
	}
	Table::UpdateCache('order', $order_id, array(
				'money' => 0,
				'state' => 'halfpay',
				'goldcoin'=> $tmp_goldcoin,
				'credit' => $order['bookgold']-$tmp_goldcoin,
				'pay_time' => time(),
				));
	$order = Table::FetchForce('order', $order_id);
	ZTeam::BookOne($order);
	redirect( WEB_ROOT . "/order/bookfundpay.php?id={$order_id}");
}

$pay_callback = "pay_team_{$paytype}";
if ( function_exists($pay_callback) ) {
	$payhtml = $pay_callback($total_money, $order);
	die(include template('bookfund_pay'));
}
else if ( $paytype == 'credit' ) {
	$total_money = $order['bookgold'];
	die(include template('bookfund_pay'));
} 
else {
	Session::Set('error', '无合适的支付方式或余额不足');
	redirect( WEB_ROOT. "/team.php?id={$order_id}");
}
