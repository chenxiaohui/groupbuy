<?php
require_once(dirname(dirname(__FILE__)) . '/app.php');

$page = Table::Fetch('page', 'help_pay');
$pagetitle = '如何付款' . $INI['system']['abbreviation'];
include template('help_pay');