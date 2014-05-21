<?php
require_once(dirname(dirname(__FILE__)) . '/app.php');

$page = Table::Fetch('page', 'about_course');
$pagetitle = '适合我的发展历程' . $INI['system']['abbreviation'];
include template('about_course');
