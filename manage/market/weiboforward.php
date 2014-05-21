<?php
require_once(dirname(dirname(dirname(__FILE__))) . '/app.php');
include_once( dirname(__FILE__) . '/microblog/config.php' );
include_once( dirname(__FILE__) . '/microblog/weibooauth.php' );
need_manager();

if ( !isset($_SESSION['last_key']))
	redirect("/manage/goldcoin/loginsina.php");
$_GET['id']='12341071789';
//$weibomsg = Table::Fetch('microblog', $_GET['id'], 'sina_id');
//if ( !isset($_GET["id"]) || !isset($weibomsg))
//	redirect("/manage/goldcoin/index.php");
	

//更新转发信息
$forwards = DB::LimitQuery('forwardmsg', array('select'=>'max(forward_id) as max, count(*) as count',
								'condition'=>array('msg_id'=>$_GET['id']),
								'one'=>true));
$msg = DB::LimitQuery('microblog', array('select'=>'end_time, max_num',
											'condition'=>array('sina_id'=>$_GET['id']),
											'one'=>true));
//if (time() < $msg['end_time'] && $forwards['count'] < $msg['max_num'])
//{
	//更新转发
	$c = new WeiboClient( WB_AKEY , WB_SKEY , $_SESSION['last_key']['oauth_token'] , $_SESSION['last_key']['oauth_token_secret']  );
	$newforward = $c->get_forwards($_GET['id'], 200, $forwards['max']);
	$forwarduser = DB::LimitQuery('forwardmsg', array('select'=>'user_sina_id',
												'condition'=>array('msg_id'=>$_GET['id'])));
	$forwarduser_sinaid = Utility::GetColumn($forwarduser, 'user_sina_id');
	foreach($newforward as $key => $value)
	{
		//已经有转发记录的，再次转发不发金币
		if ( !in_array($value['user']['id'], $forwarduser_sinaid))
		{
			$sns = "sina:{$value['user']['id']}";
			$exist_user = Table::Fetch('user', $sns, 'sns');
			if ($exist_user)
			{
				$insert = array('user_id'=>$exist_user['id'],
								'user_sina_id'=>$value['user']['id'],
								'msg_id'=>$_GET['id'],
								'forward_id'=>$value['id']								
								);
				DB::Insert('forwardmsg',$insert);				
			}
			
		}	
	}
//}

$forwarddetail = DB::LimitQuery('forwardmsg', array('condition'=>array('msg_id'=>$_GET['id'])));
$userids = Utility::GetColumn($forwarddetail, 'user_id');
$userinfo = DB::LimitQuery('user', array('condition'=>array('id'=>$userids)));
$userinfo_detail = array();
foreach($userinfo as $key=>$value) {
	$userinfo_detail[$value['id']]= $value;
}

//发放金币
foreach($forwarddetail as $key => $value)
{
	if ( !isset($value['goldcoin']) || $value['goldcoin'] == 0){
		$forward['user_id'] = $value['user_id'];
		$forward['amount'] = $weibomsg['goldcoin'];
		$forward['msg_id'] = $_GET['id'];
		$forward['forward_id'] = $value['forward_id'];
				
		ZGoldCoinFlow::CreateFromSinaWeibo($forward);
		Table::UpdateCache('user', $forward['user_id'], array(
							'goldcoin' => array( "`goldcoin`+{$forward['amount']}" ),
							));
		Table::UpdateCache('forwardmsg',$value['id'], array('goldcoin'=>$forward['amount']) );
	}
	
}

$forwarddetail = DB::LimitQuery('forwardmsg', array('condition'=>array('msg_id'=>$_GET['id'])));	
include(template('manage_goldcoin_weiboforward'));
?>