<?php
/* import other */
import('configure');
import('current');
import('rewrite');
import('utility');
import('mailer');
import('pay');
import('sms');
import('upgrade');
import('uc');
import('cron');
import('logger');

function template($tFile) {
	global $INI;
	if ( 0===strpos($tFile, 'manage') ) {//管理模板，拼上php
		return __template($tFile);
	}
	if ($INI['skin']['template']) {//其他模板，判断是不是换皮肤了
		$templatedir = DIR_TEMPLATE. '/' . $INI['skin']['template'];
		$checkfile = $templatedir . '/html_header.html';//判断皮肤是不是完整
		if ( file_exists($checkfile) ) {
			return __template($INI['skin']['template'].'/'.$tFile);
		}
	}
	return __template($tFile);//拼上php就行
}

/** 渲染
 * @param unknown_type $tFile
 * @param unknown_type $vs
 */
function render($tFile, $vs=array()) {
	ob_start();
	foreach($GLOBALS AS $_k=>$_v) {
		${$_k} = $_v;
	}
	foreach($vs AS $_k=>$_v) {
		${$_k} = $_v;
	}
	include template($tFile);
	return render_hook(ob_get_clean());
}

/** 替换绝对地址
 * @param unknown_type $c
 * @return Ambigous <mixed, unknown>
 */
function render_hook($c) {
	global $INI;
	$c = preg_replace('#href="/#i', 'href="'.WEB_ROOT.'/', $c);
	$c = preg_replace('#src="/#i', 'src="'.WEB_ROOT.'/', $c);
	$c = preg_replace('#action="/#i', 'action="'.WEB_ROOT.'/', $c);

	/* theme */
	$page = strval($_SERVER['REQUEST_URI']);
	if($INI['skin']['theme'] && !preg_match('#/manage/#i',$page)) {
		$themedir = WWW_ROOT. '/static/theme/' . $INI['skin']['theme'];
		$checkfile = $themedir. '/css/index.css';
		if ( file_exists($checkfile) ) {
			$c = preg_replace('#/static/css/#', "/static/theme/{$INI['skin']['theme']}/css/", $c);
			$c = preg_replace('#/static/img/#', "/static/theme/{$INI['skin']['theme']}/img/", $c);
		}
	}
	$c = preg_replace('#([\'\=\"]+)/static/#', "$1{$INI['system']['cssprefix']}/static/", $c);
	if (strtolower(cookieget('locale','zh_cn'))=='zh_tw') {
		require_once(DIR_FUNCTION  . '/tradition.php');
		$c = str_replace(explode('|',$_charset_simple), explode('|',$_charset_tradition),$c);
	}
	/* encode id */
	$c = rewrite_hook($c);
	$c = obscure_rep($c);
	return $c;
}

/** 输出钩子，处理压缩的问题
 * @param unknown_type $c
 */
function output_hook($c) {
	global $INI;
	if ( 0==abs(intval($INI['system']['gzip'])))  die($c);
	$HTTP_ACCEPT_ENCODING = $_SERVER["HTTP_ACCEPT_ENCODING"];
	if( strpos($HTTP_ACCEPT_ENCODING, 'x-gzip') !== false )
	$encoding = 'x-gzip';
	else if( strpos($HTTP_ACCEPT_ENCODING,'gzip') !== false )
	$encoding = 'gzip';
	else $encoding == false;
	if (function_exists('gzencode')&&$encoding) {
		$c = gzencode($c);
		header("Content-Encoding: {$encoding}");
	}
	$length = strlen($c);
	header("Content-Length: {$length}");
	die($c);
}

$lang_properties = array();
function I($key) {
	global $lang_properties, $LC;
	if (!$lang_properties) {
		$ini = DIR_ROOT . '/i18n/' . $LC. '/properties.ini';
		$lang_properties = Config::Instance($ini);
	}
	return isset($lang_properties[$key]) ?
	$lang_properties[$key] : $key;
}

/** 回应前台的json
 * @param unknown_type $data
 * @param unknown_type $type
 */
function json($data, $type='eval') {
	$type = strtolower($type);
	$allow = array('eval','alert','updater','dialog','mix', 'refresh');
	if (false==in_array($type, $allow))
	return false;
	Output::Json(array( 'data' => $data, 'type' => $type,));
}

/** 跳转
 * @param unknown_type $url
 * @param unknown_type $notice
 * @param unknown_type $error
 */
function redirect($url=null, $notice=null, $error=null) {
	$url = $url ? obscure_rep($url) : $_SERVER['HTTP_REFERER'];
	$url = $url ? $url : '/';
	if ($notice) Session::Set('notice', $notice);
	if ($error) Session::Set('error', $error);
	header("Location: {$url}");
	exit;
}
/** 数组写入php文件
 * @param unknown_type $array
 * @param unknown_type $filename
 * @return number
 */
function write_php_file($array, $filename=null){
	$v = "<?php\r\n\$INI = ";
	$v .= var_export($array, true);
	$v .=";\r\n?>";
	return file_put_contents($filename, $v);
}

/** 数组写入ini文件
 * @param unknown_type $array
 * @param unknown_type $filename
 * @return string|number
 */
function write_ini_file($array, $filename=null){
	$ok = null;
	if ($filename) {
		$s =  ";;;;;;;;;;;;;;;;;;\r\n";
		$s .= ";; SYS_INIFILE\r\n";
		$s .= ";;;;;;;;;;;;;;;;;;\r\n";
	}
	foreach($array as $k=>$v) {
		if(is_array($v))   {
			if($k != $ok) {
				$s  .=  "\r\n[{$k}]\r\n";
				$ok = $k;
			}
			$s .= write_ini_file($v);
		}else   {
			if(trim($v) != $v || strstr($v,"["))
			$v = "\"{$v}\"";
			$s .=  "$k = \"{$v}\"\r\n";
		}
	}

	if(!$filename) return $s;
	return file_put_contents($filename, $s);
}

/** 保存配置，数据库，memecache,webroot
 * @param unknown_type $type
 */
function save_config($type='ini') {
	return configure_save();
	global $INI; $q = ZSystem::GetSaveINI($INI);
	if ( strtoupper($type) == 'INI' ) {
		if (!is_writeable(SYS_INIFILE)) return false;
		return write_ini_file($q, SYS_INIFILE);
	}
	if ( strtoupper($type) == 'PHP' ) {
		if (!is_writeable(SYS_PHPFILE)) return false;
		return write_php_file($q, SYS_PHPFILE);
	}
	return false;
}

/** 保存配置到数据库
 * @param unknown_type $ini
 */
function save_system($ini) {
	$system = Table::Fetch('system', 1);
	$ini = ZSystem::GetUnsetINI($ini);
	$value = Utility::ExtraEncode($ini);//编码
	$table = new Table('system', array('value'=>$value));
	if ( $system ) $table->SetPK('id', 1);//更新
	return $table->update(array( 'value'));
}

//登陆验证和跳转
function need_login($wap=false) {
	if ( isset($_SESSION['user_id']) ) {//已经登陆
		if (is_post()) {
			unset($_SESSION['loginpage']);
			unset($_SESSION['loginpagepost']);
		}
		return $_SESSION['user_id'];
	}
	if ( is_get() ) {//没有登陆
		Session::Set('loginpage', $_SERVER['REQUEST_URI']);//记录当前页
	} else {
		Session::Set('loginpage', $_SERVER['HTTP_REFERER']);//记录当前页
		Session::Set('loginpagepost', json_encode($_POST));
	}
	if (true===$wap) {
		return redirect('login.php');
	}
	return redirect(WEB_ROOT . '/account/loginup.php');
}

/** 判断是不是post请求
 * @return string
 */
function need_post() {
	return is_post() ? true : redirect(WEB_ROOT . '/index.php');
}

function need_manager($super=false) {//判断是否是管理员（超级管理员）
	if ( ! is_manager() ) {
		redirect( WEB_ROOT . '/manage/login.php' );
	}
	if ( ! $super ) return true;//不要求超级管理员
	if ( abs(intval($_SESSION['user_id'])) == 1 ) return true;
	return redirect( WEB_ROOT . '/manage/misc/index.php');
}
function need_partner() {
	return is_partner() ? true : redirect( WEB_ROOT . '/biz/login.php');
}

/** 判断是否开放
 * @param unknown_type $b
 * @return string
 */
function need_open($b=true) {
	if (true===$b) {
		return true;
	}
	if ($AJAX) json('本功能未开放', 'alert');
	Session::Set('error', '你访问的功能页未开放');
	redirect( WEB_ROOT . '/index.php');
}

/** 权限验证和跳转
 * @param unknown_type $b
 * @return string|string
 */
function need_auth($b=true) {
	global $AJAX, $INI, $login_user;
	if (is_string($b)) {
		$auths = $INI['authorization'][$login_user['id']];//获取当前用户的权限
		$bs = explode('|', $b);
		$b = is_manager(true);
		if ($b) return true;//超级管理员肯定有权限，而且super权限也只有管理员有
		foreach($bs AS $bo) if(!$b) $b = in_array($bo, $auths);
	}
	if (true===$b) {
		return true;
	}
	if ($AJAX) json('无权操作', 'alert');
	die(include template('manage_misc_noright'));
}

/** 管理员判断，是否管理员（超级管理员），默认强验证
 * @param unknown_type $super 是否超级管理员
 * @param unknown_type $weak 是否可以一地登陆两地通用
 * @return string|boolean|boolean
 */
function is_manager($super=false, $weak=false) {
	global $login_user;//登陆用户
	if ( $weak===false &&
	( !$_SESSION['admin_id']//管理员登陆页面没有登陆
	|| $_SESSION['admin_id'] != $login_user['id']) ) {//管理员登陆不等于用户登陆
		return false;
	}
	if ( ! $super ) return ($login_user['manager'] == 'Y');//管理员即可
	return $login_user['id'] == 1;//超级管理员
}
/** 是否合作伙伴
 * @return boolean
 */
function is_partner() {
	return ($_SESSION['partner_id']>0);
}

function is_newbie(){ return (cookieget('newbie')!='N'); }
function is_get() { return ! is_post(); }
function is_post() {
	return strtoupper($_SERVER['REQUEST_METHOD']) == 'POST';
}

function is_login() {
	return isset($_SESSION['user_id']);
}

/**获取登录前访问的页面
 * @param unknown_type $default
 */
function get_loginpage($default=null) {
	$loginpage = Session::Get('loginpage', true);
	if ($loginpage)  return $loginpage;
	if ($default) return $default;
	return WEB_ROOT . '/index.php';
}
//写入一个城市的信息
function cookie_city($city) {
	if($city) {
		cookieset('city', $city['id']);
		return $city;
	}
	$city_id = cookieget('city');
	$city = Table::Fetch('category', $city_id);
	//if (!$city) $city = get_city();
	if (!$city)
	{
		global $allcities;
		$city = $allcities[1];
	}
	if ($city) return cookie_city($city);
	return $city;
}
//写入一个分类的信息
function cookie_group($group) {
	if($group) {
		cookieset('group', $group['id']);
		return $group;
	}

	$group_id = cookieget('group');
	$group= Table::Fetch('category', $group_id);
	if ($group) return cookie_group($group);
	else
	$group['id']=0;
	return $group;
}

//查询一个城市的信息
function ename_city($ename=null) {
	return DB::LimitQuery('category', array(
		'condition' => array(
			'zone' => 'city',
			'ename' => $ename,
	),
		'one' => true,
	));
}

//查询一个类别的信息
function ename_group($ename=null) {
	return DB::LimitQuery('category', array(
		'condition' => array(
			'zone' => 'group',
			'ename' => $ename,
	),
		'one' => true,
	));
}
/** 写入一个cookie
 * @param unknown_type $k key
 * @param unknown_type $v value
 * @param unknown_type $expire 过期时间
 */
function cookieset($k, $v, $expire=0) {
	$pre = substr(md5($_SERVER['HTTP_HOST']),0,4);//键值
	$k = "{$pre}_{$k}";
	if ($expire==0) {
		$expire = time() + 365 * 86400;
	} else {
		$expire += time();
	}
	setCookie($k, $v, $expire, '/');
}

/** 获取一个cookie
 * @param unknown_type $k key
 * @param unknown_type $default 默认值
 * @return Ambigous <string, unknown>
 */
function cookieget($k, $default='') {
	$pre = substr(md5($_SERVER['HTTP_HOST']),0,4);
	$k = "{$pre}_{$k}";
	return isset($_COOKIE[$k]) ? strval($_COOKIE[$k]) : $default;
}

function moneyit($k) {
	return rtrim(rtrim(sprintf('%.2f',$k), '0'), '.');
}

function debug($v, $e=false) {
	global $login_user_id;
	if ($login_user_id==100000) {
		echo "<pre>";
		var_dump( $v);
		if($e) exit;
	}
}


function getparam($index=0, $default=0) {
	if (is_numeric($default)) {
		$v = abs(intval($_GET['param'][$index]));
	} else $v = strval($_GET['param'][$index]);
	return $v ? $v : $default;
}
/** 获得页码
 * @return Ambigous <number, number>
 */
function getpage() {
	$c = abs(intval($_GET['page']));
	return $c ? $c : 1;
}
/** 分页字符串
 * @param unknown_type $count
 * @param unknown_type $pagesize
 * @param unknown_type $wap
 * @return multitype:unknown NULL number |multitype:unknown NULL number 
 */
function pagestring($count, $pagesize, $wap=false) {
	$p = new Pager($count, $pagesize, 'page');
	if ($wap) {
		return array($pagesize, $p->offset, $p->genWap());
	}
	return array($pagesize, $p->offset, $p->genBasic());
}

function uencode($u) {
	return base64_encode(urlEncode($u));
}
function udecode($u) {
	return urlDecode(base64_decode($u));
}

/* share link */
function share_renren($team) {
	global $login_user_id;
	global $INI;
	if ($team)  {
		$query = array(
				'link' => $INI['system']['wwwprefix'] . "/team.php?id={$team['id']}&r={$login_user_id}",
				'title' => $team['title'],
		);
	}
	else {
		$query = array(
				'link' => $INI['system']['wwwprefix'] . "/r.php?r={$login_user_id}",
				'title' => $INI['system']['sitename'] . '(' .$INI['system']['wwwprefix']. ')',
		);
	}

	$query = http_build_query($query);
	return 'http://share.renren.com/share/buttonshare.do?'.$query;
}

function share_kaixin($team) {
	global $login_user_id;
	global $INI;
	if ($team)  {
		$query = array(
				'rurl' => $INI['system']['wwwprefix'] . "/team.php?id={$team['id']}&r={$login_user_id}",
				'rtitle' => $team['title'],
				'rcontent' => strip_tags($team['summary']),
		);
	}
	else {
		$query = array(
				'rurl' => $INI['system']['wwwprefix'] . "/r.php?r={$login_user_id}",
				'rtitle' => $INI['system']['sitename'] . '(' .$INI['system']['wwwprefix']. ')',
				'rcontent' => $INI['system']['sitename'] . '(' .$INI['system']['wwwprefix']. ')',
		);
	}
	$query = http_build_query($query);
	return 'http://www.kaixin001.com/repaste/share.php?'.$query;
}

function share_douban($team) {
	global $login_user_id;
	global $INI;
	if ($team)  {
		$query = array(
				'url' => $INI['system']['wwwprefix'] . "/team.php?id={$team['id']}&r={$login_user_id}",
				'title' => $team['title'],
		);
	}
	else {
		$query = array(
				'url' => $INI['system']['wwwprefix'] . "/r.php?r={$login_user_id}",
				'title' => $INI['system']['sitename'] . '(' .$INI['system']['wwwprefix']. ')',
		);
	}
	$query = http_build_query($query);
	return 'http://www.douban.com/recommend/?'.$query;
}

function share_sina($team) {
	global $login_user_id;
	global $INI;
	if ($team)  {
		$query = array(
				'url' => $INI['system']['wwwprefix'] . "/team.php?id={$team['id']}&r={$login_user_id}",
				'title' => $team['title'],
		);
	}
	else {
		$query = array(
				'url' => $INI['system']['wwwprefix'] . "/r.php?r={$login_user_id}",
				'title' => $INI['system']['sitename'] . '(' .$INI['system']['wwwprefix']. ')',
		);
	}
	$query = http_build_query($query);
	return 'http://v.t.sina.com.cn/share/share.php?'.$query;
}

function share_mail($team) {
	global $login_user_id;
	global $INI;
	if (!$team) {
		$team = array(
				'title' => $INI['system']['sitename'] . '(' . $INI['system']['wwwprefix'] . ')',
		);
	}
	$pre[] = "发现一好网站--{$INI['system']['sitename']}，他们每天组织一次团购，超值！";
	if ( $team['id'] ) {
		$pre[] = "今天的团购是：{$team['title']}";
		$pre[] = "我想你会感兴趣的：";
		$pre[] = $INI['system']['wwwprefix'] . "/team.php?id={$team['id']}&r={$login_user_id}";
		$pre = mb_convert_encoding(join("\n\n", $pre), 'GBK', 'UTF-8');
		$sub = "有兴趣吗：{$team['title']}";
	} else {
		$sub = $pre[] = $team['title'];
	}
	$sub = mb_convert_encoding($sub, 'GBK', 'UTF-8');
	$query = array( 'subject' => $sub, 'body' => $pre, );
	$query = http_build_query($query);
	return 'mailto:?'.$query;
}

function domainit($url) {
	if(strpos($url,'//')) { preg_match('#[//]([^/]+)#', $url, $m);
	} else { preg_match('#[//]?([^/]+)#', $url, $m); }
	return $m[1];
}

// that the recursive feature on mkdir() is broken with PHP 5.0.4 for
function RecursiveMkdir($path) {
	if (!file_exists($path)) {
		RecursiveMkdir(dirname($path));
		@mkdir($path, 0777);
	}
}

function upload_image($input, $image=null, $type='team', $scale=false) {
	$year = date('Y'); $day = date('md'); $n = time().rand(1000,9999).'.jpg';
	$z = $_FILES[$input];
	if ($z && strpos($z['type'], 'image')===0 && $z['error']==0) {
		if (!$image) {
			RecursiveMkdir( IMG_ROOT . '/' . "{$type}/{$year}/{$day}" );
			$image = "{$type}/{$year}/{$day}/{$n}";
			$path = IMG_ROOT . '/' . $image;
		} else {
			RecursiveMkdir( dirname(IMG_ROOT .'/' .$image) );
			$path = IMG_ROOT . '/' .$image;
		}
		if ($type=='user') {
			Image::Convert($z['tmp_name'], $path, 48, 48, Image::MODE_CUT);
		}
		else if($type=='team') {
			move_uploaded_file($z['tmp_name'], $path);
		}
		if($type=='team' && $scale) {
			$npath = preg_replace('#(\d+)\.(\w+)$#', "\\1_index.\\2", $path);
			Image::Convert($path, $npath, 308, 170, Image::MODE_CUT);
		}
		return $image;
	}
	return $image;
}

function user_image($image=null) {
	global $INI;
	$image = $image ? $image : 'img/user-no-avatar.gif';
	return "/static/{$image}";
}

function team_image($image=null, $index=false) {
	global $INI;
	if (!$image) return null;
	if ($index) {
		$path = WWW_ROOT . '/static/' . $image;
		$image = preg_replace('#(\d+)\.(\w+)$#', "\\1_index.\\2", $image);
		$dest = WWW_ROOT . '/static/' . $image;
		if (!file_exists($dest) && file_exists($path) ) {
			Image::Convert($path, $dest, 308, 170, Image::MODE_SCALE);
		}
	}
	return "{$INI['system']['imgprefix']}/static/{$image}";
}
//通用评论
function userreview($content) {
	$line = preg_split("/[\n\r]+/", $content, -1, PREG_SPLIT_NO_EMPTY);
	$r = '<ul>';
	$ask=true;
	$index=0;
	global $generalcount;

	foreach($line AS $one) {
		$c = htmlspecialchars($one);
		if($ask)
		{
			$index++;
			$r.="<li><dl><dt><div class=\"qa_sign\">问答$index</div><div class=\"qa_con\">$c</div><div class=\"clear\"></div></dt>";
		}
		else
		$r.="<dd><div class=\"an_con\">$c</div></dd></dl></li>";
		$ask=$ask?false:true;
	}
	$generalcount=$index;
	return $r.'</ul>';
}
//用户评论
function userask($teamasks)
{
	$r = '<ul>';
	$index=0;
	foreach($teamasks as $one)
	{
		$index++;
		$c = htmlspecialchars($one['content']);
		$a = htmlspecialchars($one['comment']);
		$r.="<li><div class=\"a1\"><div class=\"qa_sign\">问答$index</div>$c</div>";
		$r.="<div class=\"an_con\">$a</div></li>";
	}
	return $r.'</ul>';
}
//用户点评
function usercomment($teamcomments)
{
	$r = '';
	if(empty($teamcomments))
		$r='<tr><td>暂无点评</td></tr>';
	$commName=array(
		'bad'=>'差评',
		'none'=>'中评',
		'good'=>'好评',
	);
	foreach($teamcomments as $one)
	{
		$comment = htmlspecialchars($one['comment_content']);
		$username = $one['username'];
		$grade=$commName[$one['comment_grade']];
		$star='';
		for($i=0;$i<$one['level'];$i++)
			$star.='<div class="jquery-ratings-star jquery-ratings-full"></div>';
		//		if($one['score']>1)
		//		{
		//			$userlevel="金牌会员";
		//		}
		//		else if($one['score']>0)
		//		{
		//			$userlevel="银牌会员";
		//		}
			//$r.="<tr><td>$comment<div class=\"s1\">$grade</div></td><td class=\"p_left\"><span>$username</span><div class=\"$jin\"></div><div class=\"jin_r\">$userlevel</div></td></tr>";
		$r.="<tr>
		<td>$comment<div class=\"s1\">$grade</div></td>
		<td><div style='float:left;margin: 6px 0px auto;'>$star</div></td>
		<td class=\"p_left\"><span>$username</span></td>
		</tr>";
	}
	return $r;
}

//获取点评页的好评中评差评项
function radio_grade($grade)
{
	if($grade=="bad")
	return '<li class="hao"><input type="radio" value="good" id="hao" name="comment_grade" />好评</li><li class="zhong"><input type="radio" value="none" id="zhong" name="comment_grade" />中评</li><li class="cha"><input type="radio" value="bad" id="cha" name="comment_grade"  checked="checked" />差评</li>';
	else if($grade=="none")
	return '<li class="hao"><input type="radio" value="good" id="hao" name="comment_grade" />好评</li><li class="zhong"><input type="radio" value="none" id="zhong" name="comment_grade" checked="checked" />中评</li><li class="cha"><input type="radio" value="bad" id="cha" name="comment_grade"  />差评</li>';
	else
	return '<li class="hao"><input type="radio" value="good" id="hao" name="comment_grade" checked="checked" />好评</li><li class="zhong"><input type="radio" value="none" id="zhong" name="comment_grade" />中评</li><li class="cha"><input type="radio" value="bad" id="cha" name="comment_grade"  />差评</li>';
}


function invite_state($invite) {
	if ('Y' == $invite['pay']) return '已返利';
	if ('C' == $invite['pay']) return '审核未通过';
	if ('N' == $invite['pay'] && $invite['buy_time']) return '待返利';
	if (time()-$invite['create_time']>7*86400) return '已过期';
	return '未购买';
}

//团购状态
function team_state(&$team) {
	if ( $team['now_number'] >= $team['min_number'] ) {//够数了
		if ($team['max_number']>0) {
			if ( $team['now_number']>=$team['max_number'] ){//现在大于最大
				if ($team['close_time']==0) {
					$team['close_time'] = $team['end_time'];//关闭时间
				}
				return $team['state'] = 'soldout';//卖光
			}
		}
		if ( $team['end_time'] <= time() ) {//关闭时间
			$team['close_time'] = $team['end_time'];
		}
		return $team['state'] = 'success';//成功
	} else {//不够数
		if ( $team['end_time'] <= time() ) {//到时间了
			$team['close_time'] = $team['end_time'];
			return $team['state'] = 'failure';//失败
		}
	}
	return $team['state'] = 'none';//进行中
}
//一个城市当前团购
function current_team($city_id=0) {
	$today = strtotime(date('Y-m-d'));//今天日期
	$cond = array(
			'team_type' => 'normal',//团购
			"begin_time <= {$today}",//已经开始
			"end_time > {$today}",//没有结束
	);
	/* 数据库匹配多个城市订单,前者按照多城市搜索,后者兼容旧字段city_id搜索 */
	$cond[] = "(city_ids like '%@{$city_id}@%' or city_ids like '%@0@%') or (city_ids = '' and city_id in(0,{$city_id}))";
	$order = 'ORDER BY sort_order DESC, begin_time DESC, id DESC';
	/* normal team 只查一条*/
	$team = DB::LimitQuery('team', array(
				'condition' => $cond,
				'one' => true,
				'order' => $order,
	));
	if ($team) return $team;

	/* seconds team */
	$cond['team_type'] = 'seconds';
	unset($cond['begin_time']);
	$order = 'ORDER BY sort_order DESC, begin_time ASC, id DESC';
	$team = DB::LimitQuery('team', array(
				'condition' => $cond,
				'one' => true,
				'order' => $order,
	));

	return $team;
}

function state_explain($team, $error='false') {
	$state = team_state($team);
	$state = strtolower($state);
	switch($state) {
		case 'none': return '正在进行中';
		case 'soldout': return '已售光';
		case 'failure': if($error) return '团购失败';
		case 'success': return '团购成功';
		default: return '已结束';
	}
}

function get_zones($zone=null) {
	$zones = array(
			'city' => '城市列表',
			'province'=>'省市列表',
			'group' => '项目分类',
			'public' => '讨论区分类',
			'grade' => '用户等级',
			'express' => '快递公司',
			'partner' => '商户分类',
			'guarantee'=>'适合我·保障'
			);
			if ( !$zone ) return $zones;
			if (!in_array($zone, array_keys($zones))) {
				$zone = 'city';
			}
			return array($zone, $zones[$zone]);
}

/** 下载xls
 * @param unknown_type $data
 * @param unknown_type $keynames
 * @param unknown_type $name
 */
function down_xls($data, $keynames, $name='dataxls') {
	$xls[] = "<html><meta http-equiv=content-type content=\"text/html; charset=UTF-8\"><body><table border='1'>";
	$xls[] = "<tr><td>ID</td><td>" . implode("</td><td>", array_values($keynames)) . '</td></tr>';
	foreach($data As $o) {
		$line = array(++$index);
		foreach($keynames AS $k=>$v) {
			$line[] = $o[$k];
		}
		$xls[] = '<tr><td>'. implode("</td><td>", $line) . '</td></tr>';
	}
	$xls[] = '</table></body></html>';
	$xls = join("\r\n", $xls);
	header('Content-Disposition: attachment; filename="'.$name.'.xls"');
	die(mb_convert_encoding($xls,'UTF-8','UTF-8'));
}

function option_hotcategory($zone='city', $force=false, $all=false) {
	$cates = option_category($zone, $force, true);
	$r = array();
	foreach($cates AS $id=>$one) {
		if ('Y'==strtoupper($one['display'])) $r[$id] = $one;
	}
	return $all ? $r: Utility::OptionArray($r, 'id', 'name');
}

function getallcities() {
	$cache = 86400*30;
	$cates = DB::LimitQuery('category', array(
		'condition' => array( 'zone' => 'city', ),
		'order' => 'ORDER BY relate_data ASC,sort_order DESC, id ASC',
		'cache' => $cache,
	));
	$cates = Utility::AssColumn($cates, 'id');
	return $cates;
}

function option_category($zone='city', $force=false, $all=false) {
	$cache = $force ? 0 : 86400*30;
	$cates = DB::LimitQuery('category', array(
		'condition' => array( 'zone' => $zone, ),
		'order' => 'ORDER BY sort_order DESC, id DESC',
		'cache' => $cache,
	));
	$cates = Utility::AssColumn($cates, 'id');
	return $all ? $cates : Utility::OptionArray($cates, 'id', 'name');
}
//看选项是不是yes
function option_yes($n, $default=false) {
	global $INI;
	if (false==isset($INI['option'][$n])) return $default;//没这项，直接返回
	$flag = trim(strval($INI['option'][$n]));
	return abs(intval($flag)) || strtoupper($flag) == 'Y';
}

function option_yesv($n, $default='N') {
	return option_yes($n, $default=='Y') ? 'Y' : 'N';
}

function magic_gpc($string) {
	if(SYS_MAGICGPC)//检测是不是要加反斜线
	{
		if(is_array($string)) {//迭代
			foreach($string as $key => $val) {
				$string[$key] = magic_gpc($val);
			}
		} else {//php4.0之前，如果加了magicgpc，那么去掉斜线，使用mysql的处理函数
			$string = stripslashes($string);
		}
	}
	return $string;
}

function team_discount($team, $save=false) {
	if ($team['market_price']<0 || $team['team_price']<0 ) {
		return '?';
	}
	return moneyit((10*$team['team_price']/$team['market_price']));
}

function team_origin_2($team_price, $adult_num=0, $child_num = 0) {
	$origin = intval($team_price['adult_price']) * intval($adult_num) + intval($team_price['child_price']) * intval($child_num);
	//计算快递费用，暂时不使用
	//	if ($team['delivery'] == 'express'
	//	&& ($team['farefree']==0 || $quantity < $team['farefree'])
	//	) {
	//		$origin += $express_price;
	//	}
	return $origin;
}

function team_tel_origin($team_price, $adult_num=0, $child_num=0)
{
	$adult_price = $team_price['adult_price'];
	if (!(  isset($adult_price)
	&& is_numeric($adult_price)
	&& (!is_nan($adult_price)) ) )
	$adult_price = 0;
	$child_price = $team_price['child_price'];
	if (!(  isset($child_price)
	&& is_numeric($child_price)
	&& (!is_nan($child_price)) ) )
	$child_price = 0;

	return $adult_price * $adult_num + $child_price * $child_num;
}

//程孟力 更改 增加优惠价格购买
function team_origin($team, $quantity=0, $express_price = 0, $extrabuy=array()) {
	$origin = $quantity * $team['team_price'];
	if ( !empty($extrabuy))
	{
		foreach($extrabuy as $key => $value)
		{
			$origin += $value['count'] * $value['price'];
			$quantity += $value['count'];
		}
	}
	if ($team['delivery'] == 'express'
	&& ($team['farefree']==0 || $quantity < $team['farefree'])
	) {
		$origin += $express_price;
	}
	return $origin;
}

function index_get_team($city_id) {
	global $INI;
	$multi = option_yes('indexmulti');//是否启用首页多团
	$city_id = intval($city_id);

	/* 是否首页多团,不是则返回当前城市的当前团购 */
	if (!$multi) return current_team($city_id);//当前城市只查一条

	$now = time();
	$size = abs(intval($INI['system']['sideteam']));
	/* 侧栏团购数小于1,则返回当前城市当前团购数据 */
	if ($size<=1) return current_team($city_id);//当前城市只查一条

	//	总之满足cityid的查出来

	$oc = array(
			'team_type' => 'normal',
			"begin_time < '{$now}'",
			"end_time > '{$now}'",
			'excellent'=>1,
	);
	if($city_id==ALLCITY)//全国只显示首页显示的
	$oc['display']=1;
	//
	/* 数据库匹配多个城市订单,前者按照多城市搜索,后者兼容旧字段city_id搜索 */
	if($city_id!=-1)//只要有一个地方
	$oc[] = "(city_ids like '%@{$city_id}@%' or city_ids like '%@0@%') or (city_ids = '' and city_id in(0,{$city_id}))";
	$teams = DB::LimitQuery('team', array(
				'condition' => $oc,
				'order' => 'ORDER BY `sort_order` DESC, `id` DESC',
				'size' => $size,
	));
	if(count($teams) == 1) return array_pop($teams);
	return $teams;
}
function group_get_team($group_name,$city_id)
{
	$daytime = time();
	$condition = array(
  'group_id' => array(0, abs(intval($group_id))),  //增加group_id
  'city_id' => array(0, abs(intval($city_id))),
   "begin_time <  {$daytime}",
  'OR' => array(
   "now_number >= min_number",
   "end_time > {$daytime}",
	),
	);
	$count = Table::Count('team', $condition);//查询有多少
	list($pagesize, $offset, $pagestring) = pagestring($count, 10);
	$teams = DB::LimitQuery('team', array(
'condition' => $condition,
'order' => 'ORDER BY begin_time DESC, id DESC',
'size' => $pagesize,
'offset' => $offset,
	));
	foreach($teams AS $id=>$one){
		team_state($one);
		if ($one['state']=='none') $one['picclass'] = 'isopen';
		if ($one['state']=='soldout') $one['picclass'] = 'soldout';
		$teams[$id] = $one;
	}
	return $teams;
}

function error_handler($errno, $errstr, $errfile, $errline) {
	switch ($errno) {
		case E_PARSE:
		case E_ERROR:
			echo "<b>Fatal ERROR</b> [$errno] $errstr<br />\n";
			echo "Fatal error on line $errline in file $errfile";
			echo "PHP " . PHP_VERSION . " (" . PHP_OS . ")<br />\n";
			exit(1);
			break;
		default: break;
	}
	return true;
}
/* for obscureid */
function obscure_rep($u) {
	if(!option_yes('encodeid')) return $u;
	if(preg_match('#/manage/#', $_SERVER['REQUEST_URI'])) return $u;
	return preg_replace_callback('#(\?|&)id=(\d+)(\b)#i', obscure_cb, $u);
}
function obscure_did() {
	$gid = strval($_GET['id']);
	if ($gid && preg_match('/^ZT/', $gid)) {
		$id = base64_decode(substr($gid,2))>>2;
		if($id) $_GET['id'] = $id;
	}
}
function obscure_cb($m) {
	$eid = obscure_eid($m[2]);
	return "{$m[1]}id={$eid}{$m[3]}";
}
function obscure_eid($id) {
	return 'ZT'.base64_encode($id<<2);
}
obscure_did();
/* end */

/* for post trim */
function trimarray($o) {
	if (!is_array($o)) return trim($o);
	foreach($o AS $k=>$v) { $o[$k] = trimarray($v); }
	return $o;
}
$_POST = trimarray($_POST);
/* end */

/* verifycapctch */
function verify_captcha($reason='none', $rurl=null) {
	if (option_yes($reason, false)) {
		$v = strval($_REQUEST['vcaptcha']);
		if(!$v || !Utility::CaptchaCheck($v)) {
			Session::Set('error', '验证码不匹配，请重新输入');
			redirect($rurl);
		}
	}
	return true;
}
function groupIdtoName($id)
{
	global $group_names;
	foreach($group_names as $value)
	{
		if($value['id']==$id)
		return $value['name'];
	}
}
function groupIdtoCity($id)
{
	global $allcities;
	global $group_names;

	foreach($group_names as $value)
	{
		if($value['id']==$id)
		{
			//
			foreach($allcities as $city)
			{
				if($city['ename']==$value['czone'])//自定义分组属于一个城市
				{
					return $city;
				}
			}
			break;
		}
	}
}
//获取确实是城市的
function getMainCities()
{
	global $allcities;
	$result=array();
	foreach($allcities as $value)
	{
		if($value['id']==1) continue;
		if(strtoupper($value['relate_data'])=='N')//非二级分类
		$result[$value['id']]=mb_substr($value['name'],0,2);
	}
	return $result;
}
//比上一个函数多了个热卖团,同时多了全国,用于后台编辑所属城市
function getMainCitiesEx()
{
	global $allcities;
	$result=array();
	foreach($allcities as $value)
	{
		if(strtoupper($value['relate_data'])=='N')//非二级分类
		$result[]=array('id'=>$value['id'],'name'=>$value['name']);
	}
	return $result;
}
function MailMainCities()
{
	$result="";
	global $allcities;

	foreach($allcities as $city )
	{
		if(strtoupper($city['relate_data'])=='N')//非二级分类
		$result.='<a href="http://www.shihewo.com/'.$city['ename'].'" style="color:#0066cb;text-decoration:none;">'.$city['name'].'</a> ';
	}
	return $result;
}

//获取上面的城市、分类条
function getTopCityBar($city=null)
{
	if($city==null)
	{
		global $city;
	}
	global $allcities;
	global $INI;
	$hotcities=gethotcities($INI['hotcities']['city']);
	$curCity=classtoCity($city);//当前分类所在的城市，比如北京一日游应该回到北京
	$html='<a href="http://www.shihewo.com/'.$curCity['ename'].'" target="_blank" class="bg">'.$curCity['name'].'</a>';

	if($curCity['id']==1)
	{
		foreach($hotcities as $class)
		{
			$html.='<a href="http://www.shihewo.com/'.$class['ename'].'" target="_blank">'.$class['name'].'</a>';
		}
		$html.='<a href="http://www.shihewo.com/city.php">更多>></a>';
	}
	else
	foreach($allcities as $class)
	{
		if($class['czone']==$curCity['ename'] && strtoupper($class['relate_data'])=='Y')//是这个城市的,并且是二级
		$html.='<a href="http://www.shihewo.com/'.$class['ename'].'" target="_blank">'.$class['name'].'</a>';
	}
	return $html;
}

//从北京一日游这种变成北京热卖团
function classIDtoCity($classId)
{
	global $allcities;
	foreach($allcities as $value)
	{
		if($value['id']==$classId)
		{
			if(strtoupper($value['relate_data'])=='N')
			return $value;
			else //找到对应上一级
			foreach($allcities as $city)
			{
				if($city['ename']==$value['czone'])
				return $city;
			}
		}
	}
}
function classtoCity($class)
{
	global $allcities;

	if(strtoupper($class['relate_data'])=='N')//不是二级分类，可以直接返回
	return $class;
	else //找到对应上一级
	foreach($allcities as $city)
	{
		if($city['ename']==$class['czone'])
		return $city;
	}
}

function getResult($data,$n=20)
{
	global $cws;
	if (get_magic_quotes_gpc())
	$data= stripslashes($data);
	$cws->send_text($data);
	$list = $cws->get_tops($n);//默认最多处理20个
	settype($list, 'array');
	$arr=array();
	foreach ($list as $tmp)
	{
		$arr[]=$tmp['word'];
	}
	return $arr;
}
//根据单子ID和分词更新数据库里的index
function updateIndexes($words,$id, $type='team')
{
	foreach($words as $word)
	{
		$curIndex = db::LimitQuery('indexes', array(
			'condition'=>array( 'word' => $word, 'type'=>$type),'one'=>true)	
		);//查询对应分词

		if(!empty($curIndex))//已有
		{
			$ids=array_filter(explode('@', $curIndex['link']));
			if(in_array($id,$ids))//存在词，并且已经包含
			continue;
			else
			$ids[]=$id;
			$strids='@'.implode('@',$ids).'@';
			DB::Update("indexes",array('word' => $word, 'type'=>$type),array('link' => $strids));
		}
		else //插入新的
		{
			$strids="@$id@";
			DB::Insert("indexes",array('word' => $word,'link' => $strids, 'type'=>$type));
		}
	}
}
function pinyin($str)
{
	global $pinyindata;
	$result='';
	if(!eregi("[^\x80-\xff]","$str"))//是否全中文
	{
		$i=0;
		while($i<mb_strlen($str))
		{
			//取得每个字	
			$character=mb_substr($str,$i,1,'utf-8');
			$pos=mb_strpos($pinyindata,$character,0,'utf-8');
			if($pos)
			{
				$end=mb_strpos($pinyindata,"\n",$pos,'utf-8');
				$pinyin=mb_substr($pinyindata,$pos+1,$end-$pos-1,'utf-8');
				$pinyins=explode(' ',$pinyin);
				$result.=$pinyins[0];
			}
			++$i;
		}
	}
	else
	{
		$result=$str;
	}

	unset ($pinyindata);	
	return $result;
}

//根据输入的分词查找对应的单号
function getTeamIdsByWords($words, $type = 'team')
{
	$resultTeams =array();
	foreach($words as $word)
	{
		$strteams= db::LimitQuery('indexes', array(
				'select'=>'link',
				'condition'=>array( 'word' => $word, 'type'=>$type),'one'=>true,
				'cache'=>0)
		);

		$teams=array_filter(explode('@',$strteams['link']));

		$resultTeams=array_merge($resultTeams,$teams);
	}
	$result=array_count_values($resultTeams);
	arsort($result);
	$res=array();
	if(current($result)>1)//有高匹配的
	{
		foreach($result as $key=>$value)
		{
			if($value>1)
			$res[]=$key;
		}
	}
	else
	{
		foreach($result as $key=>$value)
		{
			$res[]=$key;
		}
	}

	return $res;
}
function getTeamsByIds($ids)
{
	$now = time();
	//	global $INI;
	//	$size = abs(intval($INI['system']['sideteam']));
	$teams=array();
	//	$index=0;
	foreach($ids as $id)
	{
		//	$index++;
		//	if($index>$size) break;
		//	总之满足cityid的查出来
		$oc = array(
		//'team_type' => 'normal',
		//"begin_time < '{$now}'",
		//"end_time > '{$now}'",
			"id"=>$id,
		//'excellent'=>1,
		);
		//
		$team = DB::LimitQuery('team', array(
				'condition' => $oc,
				'one' => true,
				'cache'=>86400*30,

		));
		$teams[]=$team;
	}
	//if(count($teams) == 1) return array_pop($teams);
	return $teams;
}
set_error_handler('error_handler');
