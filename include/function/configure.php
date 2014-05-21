<?php
//所有配置文件key
function configure_keys() {
	return array(
		//system
		'db',
		'memcache',
		'webroot',
		'system',
		'bulletin',
		//pay
		'alipay',
		'tenpay',
		'bill',
		'chinabank',
		'paypal',
		'yeepay',
	    'ipspay',
		'ipscardpay', //环讯信用卡支付
		'other',
		//settings
		'option',
		'mail',
		'sms',
		'credit',
		'skin',
		'authorization',
		'hotcities',
	);
}
//保存config
function configure_save($key=null) {
	global $INI;
	if ($key && isset($INI[$key])) {//如果当前key不为空且INI里有
		return _configure_save($key, $INI[$key]);
	}
	//没有指定，全部保存
	$keys = configure_keys();
	foreach($keys AS $one) {
		if(isset($INI[$one])) _configure_save($one, $INI[$one]);
	}
	return true;
}
//用数组代码形式保存一个配置
function _configure_save($key, $value) {
	if (!$key) return;
	$php = DIR_CONFIGURE . '/' . $key . '.php';
	$v = "<?php\r\n\$value = ";
	$v .= var_export($value, true);
	$v .=";\r\n?>";
	return file_put_contents($php, $v);
}
//载入每一个配置文件，以配置文件名为key
function configure_load() {
	global $INI;
	$keys = configure_keys();
	foreach($keys AS $one) {
		$INI[$one] = _configure_load($one);
	}
	return $INI;
}
//载入该文件格式的数组配置
function _configure_load($key=null) {
	if (!$key) return NULL;
	$php = DIR_CONFIGURE . '/' . $key . '.php';
	if ( file_exists($php) ) {
		require_once($php);
	}
	return $value;
}
