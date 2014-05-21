<?php  
require_once("Curl_Manager.php");  
  
$manager = new Curl_Manager();  
  
$manager->set_action('renren', 'http://passport.renren.com/PLogin.do', 'http://www.renren.com/');//设置动作，(动作名称, 动作对应url，来源referer)  

$para=array(
	'email'=>'',//填入登录名
	'password'=>'',//填入密码
	'autoLogin'=>'1',
	'origURL'=>'http://www.renren.com/home',
	'domain'=>'renren.com',
);

$manager->open();
$manager->cookie();
$manager->post('renren',$para); //打开一个请求，进行get操作  

$manager->open();
$manager->set_action('again', '这里可以请求自己的页面试试', 'http://www.renren.com/');//
$manager->cookie();
$manager->get('again'); //打开一个请求，进行get操作  

echo $manager->body(); // 获得报头(需要自己解析)


  
