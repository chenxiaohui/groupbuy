<?php
require_once(dirname(dirname(__FILE__)) . '/app.php');

if ( $_POST ) {
	$login_user = ZUser::GetLogin($_POST['email'], $_POST['password']);
	if ( !$login_user ) {
		Session::Set('error', '登录失败');
		redirect(WEB_ROOT . '/account/login.php');
	} else if (option_yes('emailverify')
			&& $login_user['enable']=='N'
			&& $login_user['secret']
			) {
		Session::Set('unemail', $_POST['email']);
		redirect(WEB_ROOT .'/account/verify.php');
	} else {
		Session::Set('user_id', $login_user['id']);
		if (abs(intval($_POST['auto_login']))) {
			ZLogin::Remember($login_user);//记住用户
		}
		ZUser::SynLogin($login_user['username'], $_POST['password']);
		ZCredit::Login($login_user['id']);
		redirect(get_loginpage(WEB_ROOT . '/index.php'));
	}
}
$currefer = strval($_GET['r']);
if ($currefer) { Session::Set('loginpage', udecode($currefer)); }//前向连接
$pagetitle = '登录';
include template('account_login');
