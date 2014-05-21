<?php
require_once(dirname(dirname(__FILE__)) . '/app.php');

$page = Table::Fetch('page', 'about_team');
$pagetitle = '适合我是谁创办的' . $INI['system']['abbreviation'];
include template('about_team');
