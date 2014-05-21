<?php
class FalseCache{public function __call($m, $v){}};//memcache不存在
class Cache
{
	static private $mCache = null;//memcache实例
	static private $gCache = array();
	static private $mInstance = null;//单体模式
	static private $mIndex = 0;//服务器个数

	static public function Instance()
	{
		if ( !self::$mInstance ) self::$mInstance = new Cache();
	}

	static private function _CreateCacheInstance()
	{
		$ini = Config::Instance('php'); 
		settype($ini['memcache'],'array');
		if (!class_exists('Memcache', false)) return new FalseCache();
		$cache_instance = new Memcache();
		foreach( $ini['memcache'] AS $one )
		{
			$server =  (string) $one;
			list($ip, $port, $weight) = explode(':', $server);
			if(!$ip || !$port || !$weight) continue;
			$cache_instance->addServer( $ip
					,$port
					,true
					,$weight
					,1
					,15
					,true
					,array('Cache','FailureCallback')
					);//添加一个服务器
			self::$mIndex++;
		}
		return self::$mIndex ? $cache_instance : new FalseCache();
	}

	private function __construct()
	{
		self::$mCache = self::_CreateCacheInstance();
	}

	static public function FailureCallback($ip, $port)
	{
		self::$mIndex--; if (self::$mIndex<=0) self::$mCache = new FalseCache();
	}

	/** 获取一个结果
	 * @param unknown_type $key
	 */
	static function Get($key) 
	{
		self::Instance();
		if (is_array($key)) {//传入一组key
			$v = array();
			foreach($key as $k) {
				$vv = self::Get($k);//递归获取
				if ($vv) { 
					$v[$k] = $vv; 
				}
			}
			return $v;
		} else {
			if(isset(self::$gCache[$key])) {//本地缓存获取
				return self::$gCache[$key];
			}
			$v = self::$mCache->get($key);
			if ($v) { self::$gCache[$key] = $v; }//添加本地缓存
			return $v;
		}
	}


	/** 添加一个键值
	 * @param unknown_type $key 键
	 * @param unknown_type $var 值
	 * @param unknown_type $flag 是否压缩
	 * @param unknown_type $expire 过期时间
	 */
	static function Add($key, $var, $flag=0, $expire=0) {
		self::Instance();
		self::$mCache->add($key,$var,$flag,$expire);
		self::$gCache[$key] = $var;//本地缓存
	}

	//减少元素值
	static function Dec($key, $value=1){
		self::Instance();
		return self::$mCache->decrement($key, $value);
	}

	//增加元素值
	static function Inc($key, $value=1)
	{
		self::Instance();
		return self::$mCache->increment($key, $value);
	}
	//替换
	static function Replace($key, $var, $flag=0, $expire=0)
	{
		self::Instance();
		return self::$mCache->replace($key, $var, $flag, $expire);
	}

	
	/** 设置，没有增加，有的话替换
	 * @param unknown_type $key
	 * @param unknown_type $var 
	 * @param unknown_type $flag 是否压缩
	 * @param unknown_type $expire 过期时间，0永不过期
	 * @return string
	 */
	static function Set($key, $var, $flag=0, $expire=0) {
		self::Instance();
		self::$mCache->set($key, $var, $flag, $expire);
		self::$gCache[$key] = $var;
		return true;
	}

	/** 删除
	 * @param unknown_type $key
	 * @param unknown_type $timeout
	 * @return string
	 */
	static function Del($key, $timeout=0) {
		self::Instance();
		if (is_array($key)) {
			foreach ($key as $k) { 
				self::$mCache->delete($k, $timeout);
				if (isset(self::$gCache[$k])) unset(self::$gCache[$k]);
			}
		} else {
			self::$mCache->delete($key, $timeout);
			if (isset(self::$gCache[$key])) unset(self::$gCache[$k]);
		}
		return true;
	}
	//清除所有元素
	static function Flush()	{
		self::Instance();
		return self::$mCache->flush();
	}
	//获得一个函数的key
	static function GetFunctionKey($callback, $args=array()) {
		ksort($args);
		$patt = "/(=>)\s*'(\d+)'/";
		$args_string = var_export($args, true);//从arr生成代码
		$args_string = preg_replace($patt, "\\1\\2", $args_string);
		$key = "[FUNC]:$callback($args_string)";
		return self::GenKey( $key );
	}
	//获得一个串的key
	static function GetStringKey($str=null) {
		settype($str, 'array'); $str = var_export($str,true);
		$key = "[STR]:{$str}";
		return self::GenKey( $key );
	}
	//获得一个object的key
	static function GetObjectKey($tablename, $id)
	{
		$key = "[OBJ]:$tablename($id)";
		return self::GenKey( $key );
	}
	//生成key
	static function GenKey($key) {
		$hash = dirname(__FILE__);
		return md5( $hash . $key );
	}
	//写入一个对象
	static function SetObject($tablename, $one) {
		self::Instance();
		foreach($one AS $oone) {
			$k = self::GetObjectKey($tablename, $oone['id']);//获取key
			self::Set($k, $oone);
		}
		return true;
	}
	//获取一个对象
	static function GetObject($tablename, $id) {
		$single = ! is_array($id);
		settype($id, 'array');
		$k = array();
		foreach($id AS $oid) {
			$k[] = self::GetObjectKey($tablename, $oid);
		}
		$r = Utility::AssColumn(self::Get($k), 'id');
		return $single ? array_pop($r) : $r;
	}
	//清除一个对象
	static function ClearObject($tablename, $id) {
		settype($id, 'array');
		foreach($id AS $oid) {
			$key = self::GetObjectKey($tablename, $oid);
			self::Del($key);
		}
		return true;
	}
}
?>
