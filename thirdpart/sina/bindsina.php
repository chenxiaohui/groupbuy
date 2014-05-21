<?php
require_once(dirname(__FILE__) . '/config.php');

need_login();

$o = new WeiboOAuth( WB_AKEY , WB_SKEY  );

$keys = $o->getRequestToken();
$aurl = $o->getAuthorizeURL( $keys['oauth_token'] ,false , $INI['system']['wwwprefix'] . '/thirdpart/sina/bindcallback.php');
$_SESSION['keys'] = $keys;
redirect($aurl);