<?php
require_once(dirname(__FILE__) . '/app.php');
if(isset($_GET['keywords']))
{
// 分词
$cws = scws_new();
$cws->set_charset('utf8');
$cws->set_duality(true);
$cws->set_ignore(true);
$mydata=$_GET['keywords'];
$teams=getTeamsByIds(getTeamIdsByWords(getResult($mydata)));
$words=$cws->get_tops($n);//默认最多处理20个;
date_default_timezone_set("PRC");
$teamCount=count($teams);
//标出命中的字段
foreach ($teams as $key=>$team)
{
	//日期处理
	$endtime=$team['end_time'];
	$teams[$key]['month']=date("Y年n月",$endtime);
	$teams[$key]['day']=date("j",$endtime);
	$weekarray=array("日","一","二","三","四","五","六");  
	$teams[$key]['week']="星期".$weekarray[date("w",$endtime)];
	
	team_state($teams[$key]);
	foreach($words as $word)
	{
		$needle=$word['word'];
		$teams[$key]['title']=mb_ereg_replace($needle,"<span>$needle</span>",$teams[$key]['title']);
	}
}
$cws->close();
}
function hasResult()
{
	global $teamCount;
	return ($teamCount>0);
}

include template('team_search');  //你的团购分类模板页
?>