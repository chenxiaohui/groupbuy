<?php
require_once(dirname(dirname(__FILE__)) . '/app.php');

$page = Table::Fetch('page', 'about_pay');
$pagetitle = '关于' . $INI['system']['abbreviation'];
include template('about_pay');