<?php
class ZGoldcoin{
	static public function Create($order)
	{
		if (isset($order['id']) && $order['state'] == 'pay')
		{
			$goldcoin = DB::LimitQuery('goldcoinflow', array('condition'=>array('detail_id'=>$order['team_id'] . '@' . $order['id'])));
			if ( !empty($goldcoin))
				return;
				
			$team = Table::Fetch('team', $order['team_id']);
			$quantity = $order['quantity'] + $order['extrabuy'];
			if ( is_numeric($quantity) && !is_nan($quantity) 
				&& is_numeric($team['credit']) && !is_nan($team['credit']) && $team['credit'] > 0 )
			{
				$quantity = $quantity * $team['credit'];
				$user = Table::Fetch('user', $order['user_id']);
				Table::UpdateCache('user', $order['user_id'], array(
							'goldcoin' => array( "`goldcoin`+{$quantity}" ),
							));
				ZGoldCoinFlow::CreateFromComment(array('user_id'=>$order['user_id'],
														'order_id'=>$order['id'],
														'team_id'=>$order['team_id'],
														'amount'=>$quantity));
				Session::Set('notice', '获得了' . $quantity . '个金币');
			}
		}
	}
}