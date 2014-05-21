<?php
// +----------------------------------------------------------------------+
// | Copyright (c) 2008-2010 Willko Cheng                                 |
// +----------------------------------------------------------------------+
// | Authors: Willko Cheng <willko@foxmail.com>                           |
// | Blog: http://willko.javaeye.com/                                     |
// +----------------------------------------------------------------------+

class Curl_Manager {
	private $_is_temp_cookie = false;
	private $_header;
	private $_body;
	private $_ch;
	
	private $_proxy;
	private $_proxy_port;
	private $_proxy_type = 'HTTP'; // or SOCKS5
	private $_proxy_auth = 'BASIC'; // or NTLM
	private $_proxy_user;
	private $_proxy_pass;
	
	protected $_cookie;//cookie
	protected $_options;
	protected $_url = array ();//所有url
	protected $_referer = array ();
	
	private $encode=false;
	private $followlocation=true;
	
	public function setEncode($encode)
	{
		$this->encode=$encode;
	}
	
	public function setFollow($follow)
	{
		$this->follow_location=$follow;
	}
	
	public function __construct($options = array()) {
		$defaults = array ();
		
		$defaults ['timeout'] = 30;
		$defaults ['temp_root'] = sys_get_temp_dir ();
		//http请求头部
		$defaults ['user_agent'] = 'Mozilla/5.0 (Windows; U; Windows NT 6.0; zh-CN; rv:1.8.1.20) Gecko/20081217 Firefox/2.0.0.20';
		
		$this->_options = array_merge ( $defaults, $options );//传入参数
	}
	//初始化
	public function open() {
		$this->_ch = curl_init ();//初始化curl
		
		if($this->followlocation)
			curl_setopt($this->_ch, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt ( $this->_ch, CURLOPT_HEADER, true );//设置header
		curl_setopt ( $this->_ch, CURLOPT_RETURNTRANSFER, true );// 设置cURL 参数，要求结果保存到字符串中还是输出到屏幕上。
		curl_setopt ( $this->_ch, CURLOPT_USERAGENT, $this->_options ['user_agent'] );//浏览器
		curl_setopt ( $this->_ch, CURLOPT_CONNECTTIMEOUT, $this->_options ['timeout'] );
		curl_setopt ( $this->_ch, CURLOPT_HTTPHEADER, array('Expect:') ); // for lighttpd 417 Expectation Failed
		
		
		$this->_header = '';
		$this->_body = '';
		
		return $this;
	}
	
	public function close() {
		if (is_resource ( $this->_ch )) {//关闭
			curl_close ( $this->_ch );
		}
		
		if (isset ( $this->_cookie ) && $this->_is_temp_cookie && is_file ( $this->_cookie )) {
			unlink ( $this->_cookie );//删除一个文件
		}
	}
	//启动cookie
	public function cookie() {
		if (! isset ( $this->_cookie )) {
			if (! empty ( $this->_cookie ) && $this->_is_temp_cookie && is_file ( $this->_cookie )) {
				unlink ( $this->_cookie );
			}
			
			$this->_cookie = tempnam ( $this->_options ['temp_root'], 'curl_manager_cookie_' );
			$this->_is_temp_cookie = true;//建立临时cookie文件
		}
		//CURLOPT_COOKIEJAR：连接结束后保存cookie信息的文件
		curl_setopt ( $this->_ch, CURLOPT_COOKIEJAR, $this->_cookie );
		//CURLOPT_COOKIEFILE：包含cookie信息的文件，cookie文件的格式可以是Netscape格式,或者只是HTTP头的格式
		curl_setopt ( $this->_ch, CURLOPT_COOKIEFILE, $this->_cookie );
		
		return $this;
	}
	//安全连接
	public function ssl() {
		curl_setopt ( $this->_ch, CURLOPT_SSL_VERIFYPEER, false );//ssl
		curl_setopt	( $this->_ch, CURLOPT_SSL_VERIFYHOST, 2); 
	
		return $this;
	}
	
	//代理
	public function proxy($host = null, $port = null, $type = null, $user = null, $pass = null, $auth = null) {
		$this->_proxy = isset ( $host ) ? $host : $this->_proxy;
		$this->_proxy_port = isset ( $port ) ? $port : $this->_proxy_port;
		$this->_proxy_type = isset ( $type ) ? $type : $this->_proxy_type;
		
		$this->_proxy_auth = isset ( $auth ) ? $auth : $this->_proxy_auth;
		$this->_proxy_user = isset ( $user ) ? $user : $this->_proxy_user;
		$this->_proxy_pass = isset ( $pass ) ? $pass : $this->_proxy_pass;
		
		if (! empty ( $this->_proxy )) {
			curl_setopt ( $this->_ch, CURLOPT_PROXYTYPE, $this->_proxy_type == 'HTTP' ? CURLPROXY_HTTP : CURLPROXY_SOCKS5 );
			curl_setopt ( $this->_ch, CURLOPT_PROXY, $this->_proxy );
			curl_setopt ( $this->_ch, CURLOPT_PROXYPORT, $this->_proxy_port );
		}
		
		if (! empty ( $this->_proxy_user )) {
			curl_setopt ( $this->_ch, CURLOPT_PROXYAUTH, $this->_proxy_auth == 'BASIC' ? CURLAUTH_BASIC : CURLAUTH_NTLM );
			curl_setopt ( $this->_ch, CURLOPT_PROXYUSERPWD, "[{$this->_proxy_user}]:[{$this->_proxy_pass}]" );
		}
		
		return $this;
	}
	//post请求
	public function post($action, $query = array()) {
	if($this->encode)
	{
		if (is_array($query)) {
			foreach ($query as $key => $val) {
				if ($val{0} != '@') {//上传文件
					$encode_key = urlencode($key);

					if ($encode_key != $key) {
						unset($query[$key]);
					}

					$query[$encode_key] = urlencode($val);
				}
			}
		}
	}
		curl_setopt ( $this->_ch, CURLOPT_POST, true );//post
		curl_setopt ( $this->_ch, CURLOPT_URL, $this->_url [$action] );
		curl_setopt ( $this->_ch, CURLOPT_REFERER, $this->_referer [$action] );
		curl_setopt ( $this->_ch, CURLOPT_POSTFIELDS, $query );
		
		$this->_requrest ();
		
		return $this;
	}
	
	public function get($action, $query = array()) {
		$url = $this->_url [$action];
		
		if (! empty ( $query )) {
			$url .= strpos ( $url, '?' ) === false ? '?' : '&';//没问号加问号，否则加&
			$url .= is_array ( $query ) ? http_build_query ( $query ) : $query;
		}
		
		curl_setopt ( $this->_ch, CURLOPT_URL, $url );
		curl_setopt ( $this->_ch, CURLOPT_REFERER, $this->_referer [$action] );//前向连接
		
		$this->_requrest ();
		
		return $this;
	}
	
	public function put($action, $query = array()) {
		curl_setopt ( $this->_ch, CURLOPT_CUSTOMREQUEST, 'PUT' );
		
		return $this->post ( $action, $query );
	}
	
	public function delete($action, $query = array()) {
		curl_setopt ( $this->_ch, CURLOPT_CUSTOMREQUEST, 'DELETE' );
		
		return $this->post ( $action, $query );
	}
	
	public function head($action, $query = array()) {
		curl_setopt ( $this->_ch, CURLOPT_CUSTOMREQUEST, 'HEAD' );
		
		return $this->post ( $action, $query );
	}
	
	public function options($action, $query = array()) {
		curl_setopt ( $this->_ch, CURLOPT_CUSTOMREQUEST, 'OPTIONS' );
		
		return $this->post ( $action, $query );
	}
	
	public function trace($action, $query = array()) {
		curl_setopt ( $this->_ch, CURLOPT_CUSTOMREQUEST, 'TRACE' );
		
		return $this->post ( $action, $query );
	}
	
	public function connect() {
	
	}
	
	public function follow_location() {
		preg_match ( '#Location:\s*(.+)#i', $this->header (), $match );
		
		if (isset ( $match [1] )) {
			$this->set_action ( 'auto_location_gateway', $match [1], $this->effective_url () );
			
			$this->get ( 'auto_location_gateway' )->follow_location ();
		}
		
		return $this;
	}
	
	public function set_action($action, $url, $referer = '') {
		$this->_url [$action] = $url;//添加一个动作名，一个对应的网址
		$this->_referer [$action] = $referer;
		
		return $this;
	}
	
	public function header() {
		return $this->_header;
	}
	
	public function body() {
		return $this->_body;
	}
	
	public function effective_url() {
		return curl_getinfo ( $this->_ch, CURLINFO_EFFECTIVE_URL );
	}

	public function http_code() {
		return curl_getinfo($this->_ch, CURLINFO_HTTP_CODE);
	}
	
	private function _requrest() {
		$response = curl_exec ( $this->_ch );
		
		$errno = curl_errno ( $this->_ch );
		
		if ($errno > 0) {
			throw new Curl_Manager_Exception ( curl_error ( $this->_ch ), $errno );
		}
		
		$header_size = curl_getinfo ( $this->_ch, CURLINFO_HEADER_SIZE );
		
		$this->_header = substr ( $response, 0, $header_size );
		$this->_body = substr ( $response, $header_size );
	}
	
	public function __destruct() {
		$this->close ();
	}
}

class Curl_Manager_Exception extends Exception {

}