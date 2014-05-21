<?php
class ZFlow {
	static public function CreateFromOrder($order) {
		if ( $order['credit'] == 0 ) return 0;

		//update user money;
		$user = Table::Fetch('user', $order['user_id']);
		Table::UpdateCache('user', $order['user_id'], array(
					'money' => array( "money - {$order['credit']}" ),
					));

		$u = array(
				'user_id' => $order['user_id'],
				'money' => $order['credit'],
				'direction' => 'expense',
				'action' => 'buy',
				'detail_id' => $order['team_id'],
				'create_time' => time(),
				);
		$q = DB::Insert('flow', $u);
	}
	
	static public function CreateFromPayBook($order) {
		$credit = intval($order['origin']) - intval($order['bookgold']);
		if ( $credit == 0) return 0;
		
		$user = Table::Fetch('user', $order['user_id']);
		Table::UpdateCache('user', $order['user_id'], array(
					'money' => array( "money - {$credit}" ),)
			);
		$u = array(
				'user_id' => $order['user_id'],
				'money' => $credit,
				'direction' => 'expense',
				'action' => 'paybook',
				'detail_id' => $order['team_id'],
				'create_time' => time(),
				);
		$q = DB::Insert('flow', $u);
	}

	static public function CreateFromCoupon($coupon) {
		if ( $coupon['credit'] <= 0 ) return 0;

		//update user money;
		$user = Table::Fetch('user', $coupon['user_id']);
		Table::UpdateCache('user', $coupon['user_id'], array(
					'money' => array( "money + {$coupon['credit']}" ),
					));

		$u = array(
				'user_id' => $coupon['user_id'],
				'money' => $coupon['credit'],
				'direction' => 'income',
				'action' => 'coupon',
				'detail_id' => $coupon['id'],
				'create_time' => time(),
				);
		return DB::Insert('flow', $u);
	}
	
	////退款，并设置订单为未支付状态
	static public function CreateFromRefund($order) {
		global $login_user_id;
		if ( $order['state']!='pay' || $order['origin']<=0 ) return 0;
		
		$payback = intval($order['money']) + intval($order['credit']);  //用户实际支付的钱  + 用账户余额支付的钱  ==  应该返到账户余额里面的金额
		
		//update user money;
		$user = Table::Fetch('user', $order['user_id']);
		Table::UpdateCache('user', $order['user_id'], array(
					'money' => array( "money + {$payback}" ),
					));

		//update order
		Table::UpdateCache('order', $order['id'], array('state'=>'unpay', 'money'=>0));

		//insert flow
		$u = array(
				'user_id' => $order['user_id'],
				'admin_id' => $login_user_id,
				'money' => $payback,
				'direction' => 'income',
				'action' => 'refund',
				'detail_id' => $order['team_id'],
				'create_time' => time(),
				);
		return DB::Insert('flow', $u);
	}
	
	//退款，并设置订单为未支付状态
	static public function CreateFromBookRefund($order) {
		global $login_user_id;
		if ( $order['state']!='halfpay' || $order['bookgold']<=0 ) return 0;

		//update user money;
		$user = Table::Fetch('user', $order['user_id']);
		$payback = intval($order['money']) + intval($order['credit']);  //用户实际支付的钱  + 用账户余额支付的钱  ==  应该返到账户余额里面的金额
		//update user money
		Table::UpdateCache('user', $order['user_id'], array(
					'money' => array( "money + {$payback}" ),
					));
		//update order
		Table::UpdateCache('order', $order['id'], array('state'=>'unpay', 'money'=>0));
		//insert flow
		$u = array(
				'user_id' => $order['user_id'],
				'admin_id' => $login_user_id,
				'money' => $payback,		
				'direction' => 'income',
				'action' => 'bookrefund',
				'detail_id' => $order['team_id'],
				'create_time' => time(),
				);
		return DB::Insert('flow', $u);
	}

	static public function CreateFromInvite($invite) {
		global $login_user_id;
		if ( $invite['pay']!='Y' && $INI['system']['invitecredit']<=0 ) return 0;

		//update user money;
		$user = Table::Fetch('user', $invite['user_id']);
		Table::UpdateCache('user', $invite['user_id'], array(
					'money' => array( "money + {$invite['credit']}" ),
					));

		$u = array(
				'user_id' => $invite['user_id'],
				'admin_id' => $login_user_id,
				'money' => $invite['credit'],
				'direction' => 'income',
				'action' => 'invite',
				'detail_id' => $invite['other_user_id'],
				'create_time' => $invite['buy_time'],
				);
		return DB::Insert('flow', $u);
	}

	static public function CreateFromStore($user_id=0, $money=0) {
		global $login_user_id;
		$money = floatval($money);
		if ( $money == 0 || $user_id <= 0)  return;

		//update user money;
		$user = Table::Fetch('user', $user_id);
		Table::UpdateCache('user', $user_id, array(
					'money' => array( "money + {$money}" ),
					));

		/* switch store|withdraw */
		$direction = ($money>0) ? 'income' : 'expense';
		$action = ($money>0) ? 'store' : 'withdraw';
		$money = abs($money);
		/* end swtich */

		$u = array(
				'user_id' => $user_id,
				'admin_id' => $login_user_id,
				'money' => $money,
				'direction' => $direction,
				'action' => $action,
				'detail_id' => 0,
				'create_time' => time(),
				);
		return DB::Insert('flow', $u);
	}

	static public function CreateFromCharge($money,$user_id,$time,$service='alipay'){
		global $option_service;
		if (!$money || !$user_id || !$time) return 0;
		$pay_id = "charge-{$user_id}-{$time}";
		$pay = Table::Fetch('pay', $pay_id);
		if ( $pay ) return 0;
		$order_id = ZOrder::CreateFromCharge($money,$user_id,$time,$service);
		if (!$order_id) return 0;

		//insert pay record
		$pay = array(
			'id' => $pay_id,
			'order_id' => $order_id,
			'bank' => $option_service[$service],
			'currency' => 'CNY',
			'money' => $money,
			'service' => $service,
			'create_time' => $time,
		);
		DB::Insert('pay', $pay);
		ZCredit::Charge($user_id, $money);
		//end//

		//update user money;
		$user = Table::Fetch('user', $user_id);
		Table::UpdateCache('user', $user_id, array(
					'money' => array( "money + {$money}" ),
					));

		$u = array(
				'user_id' => $user_id,
				'admin_id' => 0,
				'money' => $money,
				'direction' => 'income',
				'action' => 'charge',
				'detail_id' => $pay_id,
				'create_time' => $time,
				);
		return DB::Insert('flow', $u);
	}

	static public function Explain($record=array()) {
		if (!$record) return null;
		$action = $record['action'];
		if ('buy' == $action) {
			$team = Table::Fetch('team', $record['detail_id']);
			if ($team) {
				return  "购买项目 - <a href=\"/team.php?id={$team['id']}\">{$team['title']}</a>";
			} else {
				return "购买项目 - 该项目已删除";
			}
		}
		else if ( 'invite' == $action) {
			$user = Table::Fetch('user', $record['detail_id']);
			return "邀请返利 - 好友{$user['username']}注册并购买";
		}
		else if ( 'store' == $action) {
			return '现金充值';
		}
		else if ( 'withdraw' == $action) {
			return '现金提现';
		}
		else if ( 'coupon' == $action) {
			return "消费返利 - 优惠券消费返利";
		}
		else if ( 'refund' == $action) {
			$team = Table::Fetch('team', $record['detail_id']);
			if ($team) {
				return  "项目退款 - <a href=\"/team.php?id={$team['id']}\">{$team['title']}</a>";
			} else {
				return "项目退款 - 该项目已删除";
			}
		}
		else if ( 'charge' == $action) {
			return "在线充值";
		}
		else if ( 'register' == $action) {
			return "注册送钱";
		}
	}
}
?>
