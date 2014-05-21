<?php
require_once(dirname(__FILE__) . '/app.php');

$ename = strval($_GET['ename']);//城市名

($currefer = strval($_GET['refer'])) || ($currefer = strval($_GET['r']));
if ($ename!='none' && $ename) {//none显示列表
	$group = ename_city($ename);//当前城市信息
	if ($group	) { //查到显示当前类别，否则不显示
		cookie_city($city);//cookie设置city
		//cookie_group(0);//设置三级分类为空
		die(require_once(dirname(__FILE__) . '/cityindex.php'));
		redirect(WEB_ROOT .'/index.php'); 
		$currefer = udecode($currefer);
		if ($currefer) {
			redirect($currefer);
		} else if ( $_SERVER['HTTP_REFERER'] ) {
			if (!preg_match('#'.$_SERVER['HTTP_HOST'].'#', $_SERVER['HTTP_REFERER'])) {
				redirect( WEB_ROOT . '/index.php');
			}
			if (preg_match('#/city#', $_SERVER['HTTP_REFERER'])) {
				redirect(WEB_ROOT .'/index.php');
			}
			redirect($_SERVER['HTTP_REFERER']);
		}
		redirect(WEB_ROOT .'/index.php');
	}
}

include template('team_multi');  //你的团购分类模板页