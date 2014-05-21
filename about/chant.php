<?php
require_once(dirname(dirname(__FILE__)) . '/app.php');

$page = Table::Fetch('page', 'about_chant');
$pagetitle = '适合我的核心理念' . $INI['system']['abbreviation'];
include template('about_chant');
