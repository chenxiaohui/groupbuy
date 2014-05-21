<?php
require_once(dirname(dirname(__FILE__)) . '/app.php');

$page = Table::Fetch('page', 'about_choseus');
$pagetitle = '为什么选择适合我' . $INI['system']['abbreviation'];
include template('about_choseus');
