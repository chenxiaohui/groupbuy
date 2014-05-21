<?php
require_once(dirname(dirname(__FILE__)) . '/app.php');

$id = abs(intval($_GET['id']));
if (!$id || !$team = Table::FetchForce('team', $id) ) {
	redirect( WEB_ROOT . '/team/index.php');
}
$city_ids=array_filter(explode("@",$team['city_ids']));
$city = Table::Fetch('category', current($city_ids));
$subscribe = array(
		'email' => 'help@shihewo.com',
		'secret' => md5($id),
		);
$partner = Table::Fetch('partner', $team['partner_id']);

$week = array('日','一','二','三','四','五','六');
$today = date('Y年n月j日 星期') . $week[date('w')];
$vars = array(
		'today' => $today,
		'team' => $team,
		'city' => $city,
		'subscribe' => $subscribe,
		'partner' => $partner,
		'help_email' => $INI['subscribe']['helpemail'],
		'help_mobile' => $INI['subscribe']['helpphone'],
		'notice_email' => $INI['mail']['reply'],
		);
$help_email =$INI['mail']['helpemail'];
$help_mobile = $INI['mail']['helpphone'];
$notice_email =$INI['mail']['reply'];

include template('mail_subscribe_team');
