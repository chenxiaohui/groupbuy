<?php
require_once(dirname(dirname(dirname(__FILE__))) . '/app.php');

need_manager();
need_auth('team');

$now = time();
$condition = array(
	'system' => 'Y',
	"end_time > {$now}",
);

$team_id = strval($_GET['team_id']);
$tpricelow = strval($_GET['tpricelow']);
$tpriceup = strval($_GET['tpriceup']);

$cbday = strval($_GET['cbday']);
$ceday = strval($_GET['ceday']);
$pbday = strval($_GET['pbday']);
$peday = strval($_GET['peday']);
if ($team_id){
	$condition["id"]= $team_id;
}

if ($tpricelow){
	$condition[] = "team_price >= {$tpricelow}";
}

if ($tpriceup){
	$condition[] = "team_price <= {$tpriceup}";
}


if ($cbday) { 
	$cbtime = strtotime($cbday);
	$condition[] = "begin_time >= '{$cbtime}'";
}
if ($ceday) { 
	$cetime = strtotime($ceday);
	$condition[] = "begin_time <= '{$cetime}'";
}

if ($pbday) { 
	$pbtime = strtotime($pbday);
	$condition[] = "end_time >= '{$pbtime}'";
}
if ($peday) { 
	$petime = strtotime($peday);
	$condition[] = "end_time <= '{$petime}'";
}

/* filter start */
$tourtypes=Utility::OptionArray($allcities,'id','name');
$tourtype=strval($_GET['tourtype']);
if($tourtype)
	$condition[]="city_ids like '%@$tourtype@%'";

/* filter end */
		
$team_type = strval($_GET['team_type']);
if ($team_type) { $condition['team_type'] = $team_type; }

$count = Table::Count('team', $condition);
list($pagesize, $offset, $pagestring) = pagestring($count, 20);

$teams = DB::LimitQuery('team', array(
	'condition' => $condition,
	'order' => 'ORDER BY id DESC',
	'size' => $pagesize,
	'offset' => $offset,
));
//$cities = Table::Fetch('category', Utility::GetColumn($teams, 'city_id'));
//$groups = Table::Fetch('category', Utility::GetColumn($teams, 'group_id'));
function getBelongCities($city_ids)
{
	global $allcities;
	$cities=array_filter(explode('@',$city_ids));
	$html='';
	foreach($cities as $city)
		if($city!=1)
			$html.=$allcities[$city]['name'].'</br>';
	$html=trim($html,'</br>');
	return $html;
}
$selector = 'index';
include template('manage_team_index');
