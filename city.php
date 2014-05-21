<?php
require_once(dirname(__FILE__) . '/app.php');

$ename = strval($_GET['ename']);//城市名

($currefer = strval($_GET['refer'])) || ($currefer = strval($_GET['r']));
if ($ename!='none' && $ename) {//none显示列表
	$city = ename_city($ename);//当前城市信息
	if ($city) { //查到显示当前城市，否则不显示
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
	}//没找到，或者城市名就是错的
	else {
		$city=$allcities['1'];
	}
	
}

//$cities = DB::LimitQuery('category', array(
//	'condition' => array( 'zone' => 'city'),
//	'order' => 'ORDER BY sort_order DESC',
//));
//$cities = Utility::AssColumn($cities, 'letter', 'ename');//变成首字母开头
//var_dump(current_classcategory());
include template('city');//city模板
