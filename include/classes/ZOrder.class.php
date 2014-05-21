<?php
class ZOrder {
	//后台支付订金
	static public function ManagePayBook($order){
		if ( $order['service'] != 'bookgold' && $order['state'] != 'unpay')
			return -1;
			
		$user = Table::Fetch('user',$order['user_id']);
		$team = Table::Fetch('team', $order['team_id']);
		
		$goldcoin = min(array(intval($user['goldcoin']), 
							  intval($team['goldcoin']) * (intval($order['adult_num']) + intval($order['child_num']))
							 ));
		$credit = intval($user['money']);
		$bookgold = intval($order['bookgold']);
		if ( $goldcoin + $credit > $bookgold )
		{
			Table::UpdateCache('order', $order['id'], array(
					'pay_id' => $pay_id,
					'money' => 0,
					'goldcoin' => $goldcoin,
					'credit' => $bookgold - $goldcoin,
					'state' => 'halfpay',
					'pay_time' => time(),
				));
			$order = Table::FetchForce('order', $order['id']);
			
			ZTeam::BookOne($order);
			return 1;
		}
		return 0;
	}
	
	//在线预约并付款成功的处理
	static public function OnlineBook($order_id, $pay_id, $money, $currency='CNY', $service='alipay', $bank='支付宝'){
		list($_, $_, $quantity, $_) = explode('-', $pay_id);
		if (!$order_id || !$pay_id || $money <= 0 ) return false;
		$order = Table::Fetch('order', $order_id);
	
		$user = Table::Fetch('user', $order['user_id']);
		$team = Table::Fetch('team', $order['team_id']);
		team_state($team); 
		if ( $order['state'] == 'unpay' ) {

			/* Sold Out */
			if ('soldout' == $team['state']) {
				$order['state'] = 'halfpay';
				$order['credit'] = 0;
				$order['money'] = $money;		//如果购买不成功，应该返给用户的金额
				ZFlow::CreateFromBookRefund($order);
				return true;
			}
			
			if ( $user['money'] < $order['credit'] 
				|| $user['goldcoin'] < $order['goldcoin']){
				$order['state'] = 'halfpay';
				$order['credit'] = 0;
				$order['money'] = $money;		//如果购买不成功，应该返给用户的金额
				ZFlow::CreateFromBookRefund($order);
				return true;
			}
				
			Table::UpdateCache('order', $order_id, array(
					'pay_id' => $pay_id,
					'money' => $money,
					'state' => 'halfpay',
					'pay_time' => time(),
				));
			$order = Table::FetchForce('order', $order_id);
			
			if ( $order['state'] == 'halfpay' ) {
				$table = new Table('pay');
				$table->id = $pay_id;
				$table->order_id = $order_id;
				$table->money = $money;
				$table->currency = $currency;
				$table->bank = $bank;
				$table->service = $service;
				$table->create_time = time();
				$table->insert( array('id', 'order_id', 'money', 'currency', 'service', 'create_time', 'bank') );
				
				//TeamBuy Operation
				ZTeam::BookOne($order);
			}
		}
		return true;
	}
	
	//用户在线支付成功之后，对订单的后续处理
	static public function OnlineIt($order_id, $pay_id, $money, $currency='CNY', $service='alipay', $bank='支付宝'){ 
		list($_, $_, $quantity, $_) = explode('-', $pay_id);
		if (!$order_id || !$pay_id || $money <= 0 ) return false;
		$order = Table::Fetch('order', $order_id);
		
		$team = Table::Fetch('team', $order['team_id']);
		$user = Table::Fetch('user', $order['user_id']);
		team_state($team); 
		if ( $order['state'] == 'unpay' ) {

			/* Sold Out */
			if ('soldout' == $team['state']) {
				$order['state'] = 'pay';
				$order['money'] = $money;		//应该返给用户的金额
				$order['credit'] = 0;
				ZFlow::CreateFromRefund($order);		//退款，并设置订单为未支付状态
				return true;
			}
			
			if ($user['money'] < $order['money'] 
				|| $user['goldcoin'] < $order['goldcoin'])  //如果用户的金币不够的话，或者余额不够的话，需要退款
			{
				$order['state'] = 'pay';
				$order['money'] = $money;		//应该返给用户的金额
				$order['credit'] = 0;
				ZFlow::CreateFromRefund($order);
				return true;
			}

			Table::UpdateCache('order', $order_id, array(
				'pay_id' => $pay_id,
				'money' => $money,
				'state' => 'pay',
				'service' => $service,
				'quantity' => $quantity,
				'pay_time' => time(),
			));
			$order = Table::FetchForce('order', $order_id);
			if ( $order['state'] == 'pay' ) {
				$table = new Table('pay');
				$table->id = $pay_id;
				$table->order_id = $order_id;
				$table->money = $money;
				$table->currency = $currency;
				$table->bank = $bank;
				$table->service = $service;
				$table->create_time = time();
				$table->insert( array('id', 'order_id', 'money', 'currency', 'service', 'create_time', 'bank') );
				
				//TeamBuy Operation
				ZTeam::BuyOne($order);
			}
		}
		return true;
	}

	// 后台使用账户余额进行付款
	static public function CashIt($order) {
		global $login_user_id;
		if ($order['state']=='pay' ) return 0;
		$user = Table::Fetch('user', $order['user_id']);
		
		if( intval($order['origin']) > $user['money'])
		{
			return 0;
		}
		//update order
		Table::UpdateCache('order', $order['id'], array(
			'state' => 'pay',
			'service' => 'cash',
			'admin_id' => $login_user_id,
			'money' => 0,
			'credit' => $order['origin'],
			'goldcoin' => 0,
			'pay_time' => time(),
		));

		$order = Table::FetchForce('order', $order['id']);
		ZTeam::BuyOne($order);
		return 1;
	}
	//支付预定金之外的费用
	static public function CashBook($order) {
		global $login_user_id;
		if ( $order['state'] != 'halfpay' ) return 0;
		$user = Table::Fetch('user', $order['user_id']);
		if (intval($order['origin']) - intval($order['bookgold']) >  intval($user['money']) )
			return 0;
		$credit = intval($order['origin']) - intval($order['bookgold']) + intval($order['credit']);
		Table::UpdateCache('order', $order['id'], array(
			'state' => 'pay',
			'admin_id' => $login_user_id,
			'money' => 0,	
			'credit' => $credit ,
			'pay_time' => time(),
		));
		
		$order = Table::FetchForce('order', $order['id']);
		ZTeam::PayBook($order);
		return 1;
	}

	static public function CreateFromCharge($money, $user_id, $time,$service) {
		if (!$money || !$user_id || !$time || !$service) return 0;
		$pay_id = "charge-{$user_id}-{$time}";
		$oarray = array(
			'user_id' => $user_id,
			'pay_id' => $pay_id,
			'service' => $service,
			'state' => 'pay',
			'money' => $money,
			'origin' => $money,
			'create_time' => $time,
		);
		return DB::Insert('order', $oarray);
	}
}
?>
