<?php
require_once(dirname(__FILE__) . '/app.php');

$request_uri = 'index';
$team = $teams = index_get_team($city['id']);//获取当前选择城市后所有团购

if ($team && $team['id']) {
	$_GET['id'] = abs(intval($team['id']));
	die(require_once( dirname(__FILE__) . '/team.php'));
}
elseif ($teams) {
	$disable_multi = true;
	die(require_once( dirname(__FILE__) . '/multi.php'));
}

include template('subscribe');
