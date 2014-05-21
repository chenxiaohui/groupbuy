<?php
require_once(dirname(dirname(__FILE__)) . '/app.php');

$daytime = strtotime(date('Y-m-d'));//当前日期
$condition = array(
	'team_type' => 'normal',//团购
	"begin_time <= '{$daytime}'",//开始早于今天的
);
$city_id = abs(intval($city['id']));//城市ID
//满足条件的城市
$condition[] = "(city_ids like '%@{$city_id}@%' or city_ids like '%@0@%') or (city_ids = '' and city_id in(0,{$city_id}))";

if (!option_yes('displayfailure')) {//不显示失败团购
	$condition['OR'] = array(
		"now_number >= min_number",//成功的
		"end_time > '{$daytime}'",
	);
}

$group_id = abs(intval($_GET['gid']));//指定group_Id
if ($group_id) $condition['group_id'] = $group_id;

$count = Table::Count('team', $condition);
list($pagesize, $offset, $pagestring) = pagestring($count, 10);
$condition[] = "team.group_id=category.id";
$teams = DB::LimitQuery(array('team', 'category'), array(
	'select'=>'team.*, category.name',
	'condition' => $condition,
	'order' => 'ORDER BY begin_time DESC, sort_order DESC, id DESC',
	'size' => $pagesize,
	'offset' => $offset,
));
//$group_names=DB::LimitQuery('category', array(
//						'condition' => array(
//									'zone'=>'group',
//							),
//						'select'=>'id,name',
//						'cache'=>'true',
//					));
foreach($teams AS $id=>$one){
	team_state($one);
	if (!$one['close_time']) $one['picclass'] = 'isopen';
	if ($one['state']=='soldout') $one['picclass'] = 'soldout';
	//$one['group_name']=groupIdtoName($one['group_id']);
	$teams[$id] = $one;
}

$category = Table::Fetch('category', $group_id);
$pagetitle = '往期团购';
include template('team_index');
