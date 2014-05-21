<?php
require_once(dirname(__FILE__) . '/app.php');
//if(!$INI['db']['host']) redirect( WEB_ROOT . '/install.php' );//如果没有db.php转到install
//if($group['id']!=0)
//{
//	redirect(WEB_ROOT."/class.php?group_id={$group['id']}");
//}
if($city&&option_yes('rewritecity')){//转到cookie的城市页面
	redirect(WEB_ROOT."/{$city['ename']}");
}

//转到对应的显示页面
$request_uri = 'index';
$team = $teams = index_get_team($city['id']);//传入cookie的城市

if ($team && $team['id']) {
	$_GET['id'] = abs(intval($team['id']));//转到单一显示城市
	die(require_once( dirname(__FILE__) . '/team.php'));
}
elseif ($teams) {
	$disable_multi = true;
	die(require_once( dirname(__FILE__) . '/multi.php'));//转到多显示
}
include template('subscribe');
