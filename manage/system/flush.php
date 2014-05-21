<?php
require_once(dirname(dirname(dirname(__FILE__))) . '/app.php');
DB::Query( 'delete from indexes');

$cws = scws_new();
$cws->set_charset('utf8');
$cws->set_duality(true);
$cws->set_ignore(true);

$teams=DB::LimitQuery("team",array('select'=>'id,title'));
foreach($teams as $team)
{
	updateIndexes(getResult($team['title']),$team['id']);
	echo $team['title']."<br/>";
	fl();
}
echo "分词表刷新完成";
fl();
function fl()
{
	ob_flush();
	flush(); 
}
$cws->close();