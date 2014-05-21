<?php
require_once(dirname(dirname(__FILE__)) . '/app.php');

need_login();
$pagetitle = '我的金币';
include template('credit_gold');