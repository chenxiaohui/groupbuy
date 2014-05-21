<?php
require_once(dirname(__FILE__) . '/app.php');

if (!$teams) { redirect( WEB_ROOT . '/team/index.php'); }//没有传入团购

$now = time();
$detail = array();

foreach($teams AS $index => $team) {//所有团购
	//注意当前页面有的元素
	if($team['end_time']<$team['begin_time']){$team['end_time']=$team['begin_time'];}
	$diff_time = $left_time = $team['end_time']-$now;//剩余时间
	if ( $team['team_type'] == 'seconds' && $team['begin_time'] >= $now ) {//秒杀并且已经开始
		$diff_time = $left_time = $team['begin_time']-$now;//计算剩余时间
	}
	//计算滚动条长度
	/* progress bar size */
	$detail[$team['id']]['bar_size'] = ceil(190*($team['now_number']/$team['min_number']));
	$detail[$team['id']]['bar_offset'] = ceil(5*($team['now_number']/$team['min_number']));

	$left_day = floor($diff_time/86400);//剩余天数
	$left_time = $left_time % 86400;	//
	$left_hour = floor($left_time/3600);//剩余小时
	$left_time = $left_time % 3600;		//
	$left_minute = floor($left_time/60);//剩余分钟
	$left_time = $left_time % 60;		//剩余秒数

	$detail[$team['id']]['diff_time'] = $diff_time;//写入细节
	$detail[$team['id']]['left_day'] = $left_day;
	$detail[$team['id']]['left_hour'] = $left_hour;
	$detail[$team['id']]['left_minute'] = $left_minute;
	$detail[$team['id']]['left_time'] = $left_time;
	$detail[$team['id']]['is_today'] = $team['begin_time'] + 3600*24 > time() ? 1:0;//是否就剩下今天了

	/* state */
	$team['state'] = team_state($team);
	$teams[$index] = $team;
}
$team = null;
if($INI['option']['indexmultimeituan'] == 'Y'){//美团样式
	if (count($teams)%2 == 1) {
		$first_big = true;
		$first = array_shift($teams);
	}
	include template('team_meituan');
}else {
	include template('team_multi');//multi模板
};
