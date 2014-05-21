<?php
require_once(dirname(__FILE__) . '/app.php');

$cws = scws_new();
$cws->set_charset('utf8');
$cws->set_duality(true);
$cws->set_ignore(true);

//$teams=DB::LimitQuery("team",array('select'=>'id,title'));
//foreach($teams as $team)
//{
//	updateIndexes(getResult($team['title']),$team['id']);
//	echo $team['title']."<br/>";
//}

$hotels=DB::LimitQuery("hotel", array('select'=>'hotel_name, hotel_id'));
$idx = 0;
foreach($hotels as $hotel)
{
	updateIndexes(getResult($hotel['hotel_name']), $hotel['hotel_id'], 'hotel');
	echo $hotel['hotel_name'] . "&nbsp;&nbsp;";
	
	$idx++;
	if ($idx == 10)
	{
		sleep(1);
		$idx = 0;
	}
}

$cws->close();
	