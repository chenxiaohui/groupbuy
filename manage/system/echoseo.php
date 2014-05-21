<?php
require_once(dirname(dirname(dirname(__FILE__))) . '/app.php');

need_manager(true);

function echoseo()
{
$teams=DB::LimitQuery('team',
array(
	'select'=>'id,seo_title,seo_keyword,seo_description',
	'order'=>'order by id asc',
));
echo '<table style="border-collapse:collapse;"><th>id</th><th>title</th><th>keyword</th><th>description</th>';
foreach($teams as $team)
{
	echo '<tr><td>'.$team['id'].'</td><td>'.$team['seo_title'].'</td><td style="width:200px">'.htmlspecialchars($team['seo_keyword']).'</td><td>'.htmlspecialchars($team['seo_description']).'</td></tr>';
}
echo '</table>';
}
include template('manage_system_echoseo');
