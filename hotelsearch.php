<?php
require_once(dirname(__FILE__) . '/app.php');
if (isset($_REQUEST['hotelloc']))
{	
	$cws = scws_new();
	$cws->set_charset('utf8');
	$cws->set_duality(true);
	$cws->set_ignore(true);
	$hotel_loc = getResult($_REQUEST['hotelloc']);
}
else
{
	$_REQUEST['hotelloc'] = '北京';
	$hotel_loc = array('北京');
}	
	$hotel_ids =getTeamIdsByWords($hotel_loc, 'hotel') ;	
	
	if (isset($_REQUEST['timecheckin']))
		$timecheckin = $_REQUEST['timecheckin'];
	else
		$timecheckin = date('Y-m-d', time());
	
	if (isset($_REQUEST['timecheckout']))
		$timecheckout = $_REQUEST['timecheckout'];
	else
		$timecheckout = date('Y-m-d', time()+ 24 * 60 * 60 );

$condition = array("hotel_id"=>$hotel_ids);
$count = Table::Count('hotel', $condition);
list($pagesize, $offset, $pagestring) = pagestring($count, 20);

$hotel = DB::LimitQuery('hotel', array('condition'=>$condition,
					'size' => $pagesize,
					'offset' => $offset,
					'order'=>'group by hotel_name'));
$pricecount = array();
foreach ($hotel as $key=>$value)
{
	$hotel[$key]['hotel_price'] = DB::LimitQuery('hotelprice', array('condition'=>array('hotel_id'=>$value['hotel_id'])));
	$pricecount[$key] = count($hotel[$key]['hotel_price']);
}

$count = array('hotel'=>$hotel, 'price_count'=>$pricecount);
array_multisort($count['price_count'], SORT_NUMERIC, SORT_DESC, $count['hotel'], SORT_STRING, SORT_ASC);
$hotel = $count['hotel'];
include template('hotel_index');