<?php
require_once(dirname(dirname(__FILE__)) . '/app.php');

$action = strval($_GET['action']);
$id = abs(intval($_GET['id']));
need_login();
$order = Table::Fetch('order', $id);
if ( !$order || $order['state']!='pay' 
		|| $order['user_id']!=$login_user_id){
	json('非法访问', 'alert');
}
//程孟力修改
if ($order['service'] == 'telbook'){
	json('电话预约的订单不享受点评', 'alert');
}

if ( 'ordercomment' == $action ) {
	if( $order['comment_time'] 
		&& time()-$order['comment_time']>7*86400 ){
			json('点评时间已经超过一周，不能再次修改', 'alert');
	}

	$team = Table::Fetch('team', $order['team_id']);
	$partner = Table::Fetch('partner', $team['partner_id']);
	$html = render('ajax_dialog_ordercomment');
	json($html, 'dialog');
}
elseif ( 'editcomment' == $action ) {
	$team = Table::Fetch('team', $order['team_id']);
	$partner_id = abs(intval($team['partner_id']));//商家id
	$level=intval($_GET['l']);
	if(!$level)
		$level=5;
	$u = array(
		'comment_grade' => strval($_GET['s']),
		'comment_content' => strval($_GET['t']),
		'level'=> $level,
		'partner_id' => $partner_id,
	);
	if (!$order['comment_time']) {
		$u['comment_time'] = time();
	}
	Table::UpdateCache('order', $id, $u);//更新评价
	
	/* update partner */
	$c = array(
		'partner_id' => $partner_id,
		'state' => 'pay',
		'comment_display' => 'Y',
		'comment_time > 0',
	);
	$l = DB::LimitQuery('order', array(//查询这个商家的所有成交
				'condition' => $c,
				'select' => 'COUNT(1) AS count, comment_grade',
				'order' => 'GROUP BY comment_grade',
				));
	$l = Utility::OptionArray($l, 'comment_grade', 'count');
	$u = array(
		'comment_good' => abs(intval($l['good'])),
		'comment_none' => abs(intval($l['none'])),
		'comment_bad' => abs(intval($l['bad'])),
	);
	//更新商家信息评价数
	Table::UpdateCache('partner', $partner_id, $u);
	/* end update */

	ZGoldcoin::Create($order);  //发放金币, 程孟力修改
	json( array(
				array('data'=>'点评成功', 'type' => 'alert',),
				array('data'=>'X.boxClose();', 'type' => 'eval',),
				array('data'=>'null', 'type' => 'refresh',),
			   ), 'mix');
}


