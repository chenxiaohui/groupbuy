<?php
include_once( dirname(__FILE__) . '/microblog/config.php' );
need_manager();
if (!isset($_SESSION['last_key']))
{
	redirect("/manage/market/microblog/loginsina.php");	
}

$c = new WeiboClient( WB_AKEY , WB_SKEY , $_SESSION['last_key']['oauth_token'] , $_SESSION['last_key']['oauth_token_secret']  );
$ms = $c->verify_credentials();
$_SESSION['prompt_name'] = $ms['screen_name'];
$_SESSION['sina_id'] = $ms['id'];
if ($_SESSION['sina_id'] != '2119556367')
{
	$c->oauth->post("http://api.t.sina.com.cn/account/end_session.json");
	redirect("/manage/market/microblog/loginsina.php");	
}
	
$end_time = strtotime('+3 months +1 days');
if ( isset($_POST['blogcontent']))
{
	//$c = new WeiboClient( WB_AKEY , WB_SKEY , $_SESSION['last_key']['oauth_token'] , $_SESSION['last_key']['oauth_token_secret']  );
	$rr = $c->update($_POST['blogcontent']);

	$insert['sina_id'] = $rr['id'];
	$insert['goldcoin'] = intval($_POST['goldcoin']);
	$insert['publish_time'] = time();
	$insert['content'] = $_POST['blogcontent'];
	$insert['end_time'] = strtotime($_POST['end_time']);
	$insert['max_num'] = $_POST['max_num'];
	
	DB::Insert('microblog', $insert);

	Session::set('notice', '发布成功！');
	redirect("/manage/market/microblog.php");
}


$microblog = DB::LimitQuery('microblog');
include template('manage_goldcoin_index');
?>