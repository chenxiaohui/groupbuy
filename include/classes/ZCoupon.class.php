<?php
class ZCoupon
{
	static public function Consume($coupon) {
		if ( !$coupon['consume']=='N' ) return false;
		$u = array(
			'ip' => Utility::GetRemoteIp(),
			'consume_time' => time(),
			'consume' => 'Y',
		);
		Table::UpdateCache('coupon', $coupon['id'], $u);
		ZFlow::CreateFromCoupon($coupon);
		return true;
	}

	static public function CheckOrder($order) {
		$coupon_array = array('coupon', 'pickup');
		$team = Table::FetchForce('team', $order['team_id']);
		if (!in_array($team['delivery'], $coupon_array)) return;
		if ( $team['now_number'] >= $team['min_number'] ) {
			//init coupon create;
			$last = ($team['conduser']=='Y') ? 1 : $order['quantity'];
			$offset = max(5, $last);  
			if ( $team['now_number'] - $team['min_number'] < $last) {//达到最低成团数量的时候给   所有购买   的订单    赠送优惠券
				$orders = DB::LimitQuery('order', array(
							'condition' => array(
								'team_id' => $order['team_id'],
								'state' => 'pay',
								),
							));
				foreach($orders AS $order) {	
					self::Create($order);
				}
			}
			else{			//以后仅仅给      当前     购买的订单            赠送优惠券
				self::Create($order);
			}
		}
	}

	static public function Create($order) {
		$team = Table::Fetch('team', $order['team_id']);
		$partner = Table::Fetch('partner', $order['partner_id']);
		$ccon = array('order_id' => $order['id']);
		$count = Table::Count('coupon', $ccon);
		$extrabuy = DB::LimitQuery('extrabuy', array('condition'=>array('orderId' => $order['id'])));

		while($count<$order['quantity']) {
			$id_pre = Utility::GenSecret(4, Utility::CHAR_WORD);
			$id_suf = Utility::GenSecret(8, Utility::CHAR_NUM);
			$id_suf = Utility::VerifyCode($id_suf);
			$id = "{$id_pre}{$id_suf}";
			$cv = Table::Fetch('coupon', $id);
			if ($cv) continue;
			$coupon = array(
					'id' => $id,
					'user_id' => $order['user_id'],
					'buy_id' => $order['buy_id'],
					'partner_id' => $team['partner_id'],
					'order_id' => $order['id'],
					'credit' => $team['credit'],
					'team_id' => $order['team_id'],
					'secret' => Utility::GenSecret(6, Utility::CHAR_WORD),
					'expire_time' => $team['expire_time'],
					'create_time' => time(),
					'discounttag' => '',
					);
			if(DB::Insert('coupon', $coupon))
				sms_coupon($coupon);
			
			$count = Table::Count('coupon', $ccon);
		}
		
		foreach($extrabuy as $key => $value)
		{
			$extrabuycount = $value['count'];
			if ( !is_numeric($extrabuycount) || is_infinite($extrabuycount))
			{
				$extrabuycount = 0;
			}	
			$i = 0;
			while ( $i < $extrabuycount )
			{
				$id_pre = Utility::GenSecret(4, Utility::CHAR_WORD);
				$id_suf = Utility::GenSecret(8, Utility::CHAR_NUM);
				$id_suf = Utility::VerifyCode($id_suf);
				$id = "{$id_pre}{$id_suf}";
				$cv = Table::Fetch('coupon', $id);
				if ($cv) continue;
				$coupon = array(
					'id' => $id,
					'user_id' => $order['user_id'],
					'buy_id' => $order['buy_id'],
					'partner_id' => $team['partner_id'],
					'order_id' => $order['id'],
					'credit' => $team['credit'],
					'team_id' => $order['team_id'],
					'secret' => Utility::GenSecret(6, Utility::CHAR_WORD),
					'expire_time' => $team['expire_time'],
					'create_time' => time(),
					'discounttag'=>$value['tag'],
					);	
				if(DB::Insert('coupon', $coupon))
				{
					sms_coupon($coupon);	
					$i++;
				}				
			}
		}
	}
}
