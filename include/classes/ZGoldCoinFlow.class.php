<?php
class ZGoldCoinFlow{
	static public function CreateFromOrder($order){
		if (intval($order['goldcoin']) == 0) return;
			//update user money;
		$user = Table::Fetch('user', $order['user_id']);
		Table::UpdateCache('user', $order['user_id'], array(
					'goldcoin' => array( "goldcoin - {$order['goldcoin']}"),    //程孟力增加，用于更改用户的金币数目
					));	
		$goldflow = array(
			'user_id' => $order['user_id'],
			'amount'=> $order['goldcoin'],
		 	'direction' =>'expense',
			'action' => 'buy',
			'detail_id' => $order['team_id'],
			'create_time' => time(),
		);
		DB::Insert('goldcoinflow', $goldflow);
	}
	
	static public function CreateFromRefund($order){
		$user = Table::Fetch('user', $order['user_id']);
		Table::UpdateCache('user', $order['user_id'],array(
					'goldcoin' => array( "goldcoin + {$order['goldcoin']}"),    //程孟力增加，用于更改用户的金币数目
					)); 
		$goldflow = array(
			'user_id' => $order['user_id'],
			'amount'=> $order['goldcoin'],
		 	'direction' =>'income',
			'action' => 'refund',
			'detail_id' => $order['team_id'],
			'create_time' => time(),
		);
		DB::Insert('goldcoinflow', $goldflow);
	}
	
	static public function CreateFromComment($comment)
	{
		$goldflow = array(
			'user_id' => $comment['user_id'],
			'amount' => $comment['amount'],
			'direction' =>'income',
			'action' =>'comment',
			'detail_id' => $comment['team_id'] . '@' . $comment['order_id'] ,
			'create_time' => time(),
		);
		DB::Insert('goldcoinflow', $goldflow);
	}
	
	static public function CreateFromSinaWeibo($forward)
	{
		$goldflow = array(
				'user_id'=> $forward['user_id'],
				'amount' => $forward['amount'],
				'direction' => 'income',
				'action'=>'sinaweibo',
				'detail_id'=>$forward['msg_id'] .  '@' . $forward['forward_id'],
				'create_time'=>time(),
		);
		DB::Insert('goldcoinflow', $goldflow);
	}
	
	static public function Explain($record=array()) {
		if (!$record) return null;
		$action = $record['action'];
		if ('buy' == $action) {
			$team_id = explode("@", $record['detail_id']);
			$team = Table::Fetch('team', $team_id[0]);
			if ($team) {
				return  "购买项目 - <a href=\"/team.php?id={$team['id']}\">{$team['title']}</a>";
			} else {
				return "购买项目 - 该项目已删除";
			}
		}
		else if ('comment' == $action)
		{
			return '购买并评价订单';
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
		else if ( 'sinaweibo' == $action) {
			return "转发新浪微博消息";
		}
	}
}