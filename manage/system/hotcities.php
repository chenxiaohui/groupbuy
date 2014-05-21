<?php
require_once(dirname(dirname(dirname(__FILE__))) . '/app.php');

need_manager(true);

$system = Table::Fetch('system', 1);//查找系统那条记录

if ($_POST) {
	unset($_POST['commit']);//把提交的清空，防止再次提交
	$INI = Config::MergeINI($INI, $_POST);//合并现有的和提交的结果
	$INI = ZSystem::GetUnsetINI($INI);
	save_config();

	$value = Utility::ExtraEncode($INI);
	$table = new Table('system', array('value'=>$value));
	if ( $system ) $table->SetPK('id', 1);
	$flag = $table->update(array( 'value'));

	Session::Set('notice', '更新系统信息成功');
	redirect(WEB_ROOT.'/manage/system/hotcities.php');	
}

include template('manage_system_hotcities');
