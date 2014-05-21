<?php
require_once(dirname(dirname(__FILE__)) . '/app.php');
if(isset($_GET['type']))
	$mail= strval($_GET['type']);//类型名
else 
	$mail='yahoo';
$email=array('163'=>array('网易邮箱','http://mail.163.com/'),
		'qq'=>array('QQ邮箱','http://mail.qq.com/'),
		'gmail'=>array('GMail','http://www.gmail.com/'),
		'hotmail'=>array('Hotmail','http://www.hotmail.com/'),
		'sina'=>array('新浪邮箱','http://mail.sina.com.cn/'),
		'yahoo'=>array('雅虎邮箱','http://mail.cn.yahoo.com/'),
		'sohu'=>array('搜狐邮箱','http://mail.sohu.com/'),
		'139'=>array('139邮箱','http://mail.10086.cn/'),
		'others'=>array('其他邮箱',''));
global $INI;
$helpmail=$INI['mail']['reply'];
$mailname=$email[$mail][0];
$maillink=$email[$mail][1];
switch($mail)
{
	case '163':
		break;
	case 'qq':
		break;
	case 'gmail':
		break;
	case 'hotmail':
		break;
	case 'sina':
		break;
	case 'yahoo':
		break;
	case 'souhu':
		break;
	case '139':
		break;
	case 'others':
		break;		
}
function getEmailList($mail)
{
	global $email;
	$result='';
	foreach($email as $key=>$value)
	{
		if($key!=$mail)
			$result.="<div class=\"hy_right_b_11\"><a href=\"/help/setemails.php?type=$key\">$value[0]</a></div>";
		else 	
			$result.="<div class=\"hy_right_b_11\" style=\"background-color:#ff6600; padding-top:5px;\"><a href=\"/help/setemails.php?type=$key\" style=\"color:#FFFFFF; margin-left:5px;\">$value[0]</a></div>";
	}
	return $result;
}
include template('help_setemails');