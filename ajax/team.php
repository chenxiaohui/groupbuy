<?php
require_once(dirname(dirname(__FILE__)) . '/app.php');

$action = strval($_GET['action']);
$id = $team_id = abs(intval($_GET['id']));
$team = Table::Fetch('team', $team_id);
if($action!='comment')
	need_login();
if ( $action == 'remove' && $team['user_id'] == $login_user_id ) {
	DB::DelTableRow('team', array('id' => $team_id));
	json("jQuery('#team-list-id-{$team_id}').remove();", 'eval');
}
else if ( $action == 'ask' ) {
	$content = trim($_POST['content']);
	if ( $content ) {
		$table = new Table('ask', $_POST);
		$table->user_id = $login_user_id;
		$table->team_id = $team['id'];
		$table->city_id = $team['city_id'];
		$table->create_time = time();
		$table->content = htmlspecialchars($table->content);
		$table->insert(array('user_id','team_id','city_id','content','create_time', 'type'));
	}
	json(0);
}
else if($action=='comment')
{
	$commcount=intval($_GET['count']);
	list($pagesize, $offset, $pagestring) = pagestring($commcount, 10);//分页
	$teamcomments = DB::LimitQuery(array('order','user'), array(
			'select'=>'comment_grade,comment_content,username,score,level',
			'condition' => array('comment_display'=>'Y','team_id'=>$team_id,'user.id=order.user_id'),
			'order' => 'ORDER BY order.id DESC',
			'size' => $pagesize,
			'offset' => $offset,
			));
	$html = render('ajax_team_comment');
	echo $html;
	return false;
}

json(0);
?>
