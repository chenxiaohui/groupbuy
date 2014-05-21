<?php
require_once(dirname(__FILE__) . '/app.php');//单团购显示

$id = abs(intval($_GET['id']));//团购iD
if (!$id || !$team = Table::FetchForce('team', $id) ) {//ID为空，
	redirect( WEB_ROOT . '/team/index.php');
}

/* refer */
if ($_rid = abs(intval($_GET['r']))) { 
	if($_rid) cookieset('_rid', abs(intval($_GET['r'])));
	redirect( WEB_ROOT . "/team.php?id={$id}");
}
$teamcity = Table::Fetch('category', $team['city_id']);//团购所在城市的信息
//$city = $teamcity ? $teamcity : $city;
//$city = $city ? $city : array('id'=>0, 'name'=>'全部');//$cityid可以为0

$pagetitle = $team['title'];//团购名

$discount_price = $team['market_price'] - $team['team_price'];//剩了多少钱
$discount_rate = team_discount($team);//折扣率

$left = array();
$now = time();

if($team['end_time']<$team['begin_time']){$team['end_time']=$team['begin_time'];}//关闭时间开始时间不对的

$diff_time = $left_time = $team['end_time']-$now;//时间差（还剩时间）
if ( $team['team_type'] == 'seconds' && $team['begin_time'] >= $now ) {
	$diff_time = $left_time = $team['begin_time']-$now;
}

$left_day = floor($diff_time/86400);
$left_time = $left_time % 86400;
$left_hour = floor($left_time/3600);
$left_time = $left_time % 3600;
$left_minute = floor($left_time/60);
$left_time = $left_time % 60;

/* progress bar size */
$bar_size = ceil(190*($team['now_number']/$team['min_number']));
$bar_offset = ceil(5*($team['now_number']/$team['min_number']));
$partner = Table::Fetch('partner', $team['partner_id']);
$team['state'] = team_state($team);

/* your order *///你的订单状态
if ($login_user_id && 0==$team['close_time']) {
	$order = DB::LimitQuery('order', array(
				'condition' => array(
					'team_id' => $id,
					'user_id' => $login_user_id,
					'state' => 'unpay',
					),
				'one' => true,
				));
}
/* end order */

/*kxx team_type */
if ($team['team_type'] == 'seconds') {//秒杀
	die(include template('team_view_seconds'));
}
if ($team['team_type'] == 'goods') {
	die(include template('team_view_goods'));//热销商品
}
/*xxk*/

/*seo*/
$seo_title = $team['seo_title'];
$seo_keyword = $team['seo_keyword'];
$seo_description = $team['seo_description'];
if($seo_title) $pagetitle = $seo_title;
/*end*/

//处理答疑信息
$condition = array( 'length(comment)>0', 'type' => 'ask', );
//
if(option_yes('teamask')) { $condition[] = 'team_id > 0'; }//一单显示所有答疑
else { $condition['team_id'] = $id; }
//$generalcount = ceil(substr_count($team['userreview'],"\r\n"));

/*pageit*/
$count = Table::Count('ask', $condition);
$teamasks = DB::LimitQuery('ask', array(
			'condition' => $condition,
			'order' => 'ORDER BY id DESC',
			'size' => 10,
			'offset' => 0,
			));
//官方问答
$asks=array();
$line = preg_split("/[\n\r]+/", $team['userreview'], -1, PREG_SPLIT_NO_EMPTY);
for($i=0;$i<count($line);$i+=2) 
{
	if($i+1<count($line))
	{
		$asks[]=array('content'=>$line[$i],'comment'=>$line[$i+1]);
		
	}
}
foreach($teamasks as $ask)
	$asks[]=$ask;

/*endpage*/
//查询点评信息
$commcount = Table::Count('order', array('comment_display'=>'Y','team_id'=>$team['id']));
$teamcomments = DB::LimitQuery(array('order','user'), array(
			'select'=>'comment_grade,comment_content,username,score,level',
			'condition' => array('comment_display'=>'Y','team_id'=>$team['id'],'user.id=order.user_id'),
			'order' => 'ORDER BY order.id DESC',
			'size' => 10,
			'offset' => 0,
			));
$team_price = DB::LimitQuery('team_price', array('condition'=> array('team_id'=>$team['id'])));
include template('team_view');
