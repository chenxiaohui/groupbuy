<?php

class Session
{
	static private $_begin = 0;
	static private $_instance = null;
	static private $_debug = false;

	static public function Init($debug=false)
	{
		self::$_instance = new Session();
		self::$_debug = $debug;
		session_start();//start session
	}

	static public function Set($name, $v) //set a session
	{
		$_SESSION[$name] = $v;
	}

	static public function Get($name,$once=false)//get a session
	{
		$v = null;
		if ( isset($_SESSION[$name]) )//exists
		{
			$v = $_SESSION[$name];
			if ( $once ) unset( $_SESSION[$name] );//only get once
		}
		return $v;
	}

	function __construct()
	{
		self::$_begin = microtime(true);//begin time
	}

	function __destruct()
	{
		global $AJAX, $INI;//调试，并且非ajax
		if (self::$_debug&&!$AJAX) { echo 'Generation Cost: '.(microtime(true)-self::$_begin).'s, Query Count: ' . DB::$mCount; }
		DB::Close();
		$c = ob_get_clean();//获取缓存内容并清除缓存
		if ( function_exists('render_hook') ) {//渲染
			$c = render_hook($c);
		}
		if ( function_exists('output_hook') ) {//输出
			die(output_hook($c));
		}
		die($c);
	}
}
?>
