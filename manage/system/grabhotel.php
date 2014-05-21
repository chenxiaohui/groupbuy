<?php
require_once(dirname(dirname(dirname(__FILE__))) . '/app.php');

need_manager(true);

$system = Table::Fetch('system', 1);//查找系统那条记录


include template('manage_system_grabhotel');
