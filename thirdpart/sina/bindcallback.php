<?php
require_once(dirname(__FILE__) . '/config.php');

need_login();

$o = new WeiboOAuth(WB_AKEY , WB_SKEY , $_SESSION['keys']['oauth_token'] , $_SESSION['keys']['oauth_token_secret']);
$_SESSION['last_key'] = $o->getAccessToken($_REQUEST['oauth_verifier']);


$c = new WeiboClient( WB_AKEY , WB_SKEY , $_SESSION['last_key']['oauth_token'] , $_SESSION['last_key']['oauth_token_secret']  );
$ms = $c->verify_credentials();

if(!$ms['id'] || !$ms['screen_name']) {
	need_login();
}

$sns = "sina:{$ms['id']}";
Table::UpdateCache('user', $login_user_id, array('sns'=>$sns), 'id');

Session::set('notice', "绑定新浪微博用户{$ms['screen_name']}到当前用户成功");
redirect('/index.php');



