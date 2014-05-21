<?php
require_once(dirname(dirname(__FILE__)) . '/app.php');
require_once(dirname(__FILE__) . '/inc.php');

$id = abs(intval($_GET['id']));//团购id
//查询对应的团购
if (!$id || !$team = Table::Fetch('team', $id) ) {
	redirect( WEB_ROOT . '/team/index.php');
}

team_state($team);//获得团购状态
$pagetitle = "{$INI['system']['abbreviation']}答疑 {$team['title']}";
$condition = array( 'length(comment)>0', 'type' => 'ask', );

if(option_yes('teamask')) { $condition[] = 'team_id > 0'; }//一单显示所有答疑
else { $condition['team_id'] = $id; }

/*pageit*/
$count = Table::Count('ask', $condition);
list($pagesize, $offset, $pagestring) = pagestring($count, 10);//每页十个，显示几页
$asks = DB::LimitQuery('ask', array(
			'condition' => $condition,
			'order' => 'ORDER BY id DESC',
			'size' => $pagesize,
			'offset' => $offset,
			));
/*endpage*/

$user_ids = Utility::GetColumn($asks, 'user_id');
$users = Table::Fetch('user', $user_ids);
include template('team_ask');
