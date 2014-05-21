<?php
require_once(dirname(dirname(__FILE__)) . '/app.php');

need_login();//需要登录
$condition = array( 'user_id' => $login_user_id, 'team_id > 0', );//查询用户
$selector = strval($_GET['s']);

//查询参数
if ( $selector == 'index' ) {
}
else if ( $selector == 'unpay' ) {
	$condition['state'] = 'unpay';
}
else if ( $selector == 'pay' ) {
	$condition['state'] = 'pay';
}
else if($selector=='timeout'){
		$condition['state'] = 'timeout';
}

$count = Table::Count('order', $condition);
list($pagesize, $offset, $pagestring) = pagestring($count, 10);//分页
//查询对应用户的订单
$orders = DB::LimitQuery('order', array(
	'condition' => $condition,
	'order' => 'ORDER BY create_time DESC,team_id DESC, id ASC',
	'size' => $pagesize,
	'offset' => $offset,
));

$team_ids = Utility::GetColumn($orders, 'team_id');
$teams = Table::Fetch('team', $team_ids);
//项目状态
foreach($teams AS $tid=>$one){
	team_state($one);
	$teams[$tid] = $one;
}
//检查新过期订单
$timenow=time();
$newtimeout=array();
for($i=0;$i<count($orders);$i++)
{
	//不是未付款订单，不考虑，只有未付款的才可能过期,bookgold和telbook不受限制
	if($orders[$i]['state']!='unpay' ||$orders[$i]['service']=='bookgold'
		||$orders[$i]['service']=='telbook') continue;
	//项目过期或者72小时未付款
	if($teams[$orders[$i]['team_id']]['close_time']>0 || $timenow-$orders[$i]['create_time']>259200)
	{
		$orders[$i]['state']='timeout';
		$newtimeout[]=$orders[$i]['id'];
	}
}
//更新新过期的订单回数据库
if(!empty($newtimeout))
{
	foreach($newtimeout as $id)
	DB::Update('order',$id,array('state'=>'timeout'));
}
$pagetitle = '我的订单';
include template('order_index');
