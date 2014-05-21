<?php

/** 常用工具
 * @author 
 *
 */
class Utility 
{
    const CHAR_MIX = 0;
    const CHAR_NUM = 1;
    const CHAR_WORD = 2;
    
	
    /** 生成下拉框的value
     * @param unknown_type $a 输入key-value数组
     * @param unknown_type $v 默认选项
     * @param unknown_type $all 空白选项
     */
    static public function Option($a=array(), $v=null, $all=null)
    {
        $option = null;
        if ( $all ){//空白选项
            $selected = ($v) ? null : 'selected';//有默认选项
            $option .= "<option value='' $selected>".strip_tags($all)."</option>";
        }

        $v = explode(',', $v);
        settype($v, 'array');
        foreach( $a AS $key=>$value )//直接key-value
        {
            if (is_array($value)) {//记录型的 
                $key = strval($value['id']);
                $value = strval($value['name']); 
            }
            $selected = in_array($key, $v) ? 'selected' : null;
            $option .= "<option value='{$key}' {$selected}>".strip_tags($value)."</option>";
        }

        return $option;
    }
	
	/** 验证邮件
	 * @param unknown_type $email
	 * @param unknown_type $strict
	 * @return string|string|string|string
	 */
	static public function ValidEmail($email, $strict=false) {
		$regexp = '/^[\w\-\.]+@[\w\-]+(\.[\w\-]+)*(\.[a-z]{2,})$/';
		if ( preg_match($regexp, $email) ){
			if (strstr(strtoupper(PHP_OS),'WIN')) {
				return true;
			}
			list ($user,$domain) = explode('@', $email, 2);
			if ( $strict && !gethostbyname($domain) 
					&& !getmxrr($domain,$mxhosts) ){
				return false;
			}
			return true;
		}
		return false;
	}

	/** 筛选一个数组里需要的部分key
	 * @param unknown_type $a 数组
	 * @param unknown_type $need_keys 需要的key
	 * @return Ambigous <multitype:, unknown> 
	 */
	static public function ArrayFilter($a, $need_keys=array()) {
		$r = array();
        foreach($need_keys AS $k) {
            if (isset($a[$k])) $r[$k] = $a[$k];
        }
        return $r;
    }
	/** 把对应的字段生成逗号连接的串
	 * @param unknown_type $a 数组
	 * @param unknown_type $v 需要的字段
	 * @return Ambigous <multitype:, unknown> 
	 */	
    static public function CommaTips($a=array(), $v=null) {
        $cval = array();
        if (is_string($v)) { 
            $v = preg_split('/[\s,]+/', $v, -1, PREG_SPLIT_NO_EMPTY);
        }
        settype($v, 'array');
        foreach($a AS $key=>$value) {
            if (in_array($key, $v)) {
                if (is_array($value)) {
                    $cval[] = $value['name'];
                } else {
                    $cval[] = $value;
                }
            }
        }
        return join(',', $cval);
    }

    /** 生成复选框
     * @param unknown_type $a 数组
     * @param unknown_type $v 需要check的字段名，逗号分隔
     * @param unknown_type $n check数组的名字
     * @param unknown_type $m readonly
     * @return Ambigous <string, NULL>
     */
    static public function CheckBox($a, $v='', $n='cb', $m=null) {
        $cbox = null;
        if (is_string($v)) $v = preg_split('/[\s,]+/', $v, -1, PREG_SPLIT_NO_EMPTY);
        settype($v, 'array');
        foreach($a AS $key=>$value) {
            if (is_array($value)) { //如果是记录型
                $key = strval($value['id']);
                $value = strval($value['name']); 
            }
            $checked = in_array($key, $v) ? 'checked' : null;
            $readonly = $m=='fix'?'onclick="return false;"':null;
            $checked = $m=='fix'?'checked':$checked;
            $cbox .= "<li><input type='checkbox' name='{$n}[]' value='{$key}' {$checked} {$readonly} />&nbsp;{$value}</li>";
        }
        return $cbox;
    }
	
    /** 生成单选按钮
     * @param unknown_type $a 数组
     * @param unknown_type $v 需要选择的值
     * @param unknown_type $n 名字
     * @return Ambigous <string, NULL>
     */
    static public function RadioButton($a=array(), $v=null, $n='cb') {
        $cbox = null;
        if (is_string($v)) $v = preg_split('/[\s,]+/', $v, -1, PREG_SPLIT_NO_EMPTY);
        settype($v, 'array');
        foreach($a AS $key=>$value) {
            if (is_array($value)) { 
                $key = strval($value['id']);
                $value = strval($value['name']); 
            }
            $checked = in_array($key, $v) ? 'checked' : null;
            $cbox .= "<li><input type='radio' name='{$n}' value='{$key}' {$checked} />&nbsp;{$value}</li>";
        }
        return $cbox;
    }

    /** 构造选项型数组
     * @param unknown_type $a 记录型数组
     * @param unknown_type $c1 作为选项型key的字段
     * @param unknown_type $c2 作为选项型value的字段
     * @return multitype:|multitype:|multitype:
     */
    static public function OptionArray($a=array(), $c1, $c2) {
        if (empty($a)) return array();
        $s1 = self::GetColumn($a, $c1);
        $s2 = self::GetColumn($a, $c2);
        if ( $s1 && $s2 && count($s1)==count($s2) ) {
            return array_combine($s1, $s2);
        }
        return array();
    }
	
    /** 合并数组并排序
     * @param unknown_type $a 数组
     * @param unknown_type $s 筛选值
     * @param unknown_type $key 排序关键字
     */
    static public function SortArray($a=array(), $s=array(), $key=null)
    {
        if ($key) $a = self::AssColumn($a, $key);
        $ret = array();
        foreach( $s AS $one ) 
        {
            if ( isset($a[$one]) )
                $ret[$one] = $a[$one];
        }
        return $ret;
    }
	/** 从记录型获取某列
      * @param unknown_type $a 记录型数组
      * @param unknown_type $column 列，如果两列用-间隔
      * @param unknown_type $null 是否允许不存在的列
      * @param unknown_type $column2 
      */
    static public function GetColumn($a=array(), $column='id', $null=true, $column2=null)
    {
        $ret = array();
        @list($column, $anc) = preg_split('/[\s\-]/',$column,2,PREG_SPLIT_NO_EMPTY);
        foreach( $a AS $one )
        {   
            if ( $null || @$one[ $column ] )//$null为true或者$column存在
                $ret[] = @$one[ $column ].($anc?'-'.@$one[$anc]:'');//$anc存在加上-第二个
        } 
        return $ret;
    }

 
    /** 对记录型数组，提升一个字段为key,支持两级
     * @param unknown_type $a 数组
     * @param unknown_type $column
     */
    static public function AssColumn($a=array(), $column='id')
    {
        $two_level = func_num_args() > 2 ? true : false;
        if ( $two_level ) $scolumn = func_get_arg(2);

        $ret = array(); settype($a, 'array');
        if ( false == $two_level )
        {   
            foreach( $a AS $one )
            {   
                if ( is_array($one) ) 
                    $ret[ @$one[$column] ] = $one;
                else
                    $ret[ @$one->$column ] = $one;
            }   
        }   
        else
        {   
            foreach( $a AS $one )
            {   
                if (is_array($one)) {
                    if ( false==isset( $ret[ @$one[$column] ] ) ) {
                        $ret[ @$one[$column] ] = array();
                    }
                    $ret[ @$one[$column] ][ @$one[$scolumn] ] = $one;
                } else {
                    if ( false==isset( $ret[ @$one->$column ] ) )
                        $ret[ @$one->$column ] = array();

                    $ret[ @$one->$column ][ @$one->$scolumn ] = $one;
                }
            }
        }
        return $ret;
    }
	
    /** 获取客户端IP
     * @param unknown_type $default
     */
    static public function GetRemoteIp($default='127.0.0.1')
    {
        $ip_string = $_SERVER['HTTP_CLIENT_IP'].','.$_SERVER['HTTP_X_FORWARDED_FOR'].','.$_SERVER['REMOTE_ADDR'];
        if ( preg_match ("/\d+\.\d+\.\d+\.\d+/", $ip_string, $matches) )
        {
            return $matches[0];
        }
        return $default;
    }

    /** 获得一个空的包含keys的数组
     * @param unknown_type $keys
     * @return Ambigous <multitype:, NULL>
     */
    static public function CombineNull($keys=array())
    {
        $ret = array();
        foreach( $keys AS $one )
        {
            $ret[$one] = null;
        }
        return $ret;
    }
	
    /** 加密编码一个数组
     * @param unknown_type $extra
     */
    static public function ExtraEncode($extra=array())
    {
        return base64_encode(json_encode($extra));
    }

    /** 解码一个数组
     * @param unknown_type $extra
     * @return mixed
     */
    static public function ExtraDecode($extra=null)
    {
        return json_decode(base64_decode($extra), true);
    }

    static public function GetPageNo($page='page')
    {
        $page_no = isset($_GET['page']) 
            ?  abs(intval($_GET['page'])) : 1;
        return $page_no > 0 ? $page_no : 1;
    }

    /** 扫描目录
     * @param unknown_type $d 目录
     * @param unknown_type $e 允许文件名
     * @param unknown_type $r 是否迭代
     */
    static public function ScanDir($d, $e=array(), $r=false)
    {
        $c = scandir($d);
        $a = array();
        foreach($c as $o) {
            if ($o == '.' || $o == '..') 
                continue;
            $p = $d . '/' . $o;
            $eo = substr($o, strrpos($o, '.')?strrpos($o, '.')+1:0);
            if ( ( empty($e) || in_array($eo, $e))
                    && is_file($p) 
                    && is_readable($p)) 
            {
                $a[] = $p;
            }
            else if( is_dir($p) 
                    && is_readable($p) 
                    && true==$r) 
            {
                $u = self::ScanDir($p, $e, $r);
            }
        }
        return $a;
    } 

    /** 有好时间提示 
     * @param unknown_type $time
     * @param unknown_type $forceDate
     */
    static public function HumanTime($time=null, $forceDate=false)
    {
        $now = time();
        $time = is_numeric($time) ? $time : strtotime($time);

        $interval = $now - $time;

        if ( $forceDate || $interval > 30*86400 ){
            return strftime("%Y-%m-%d %a %H:%M",$time);
        }else if ( $interval > 86400 ){
            $number = intval($interval/86400);
            return "${number}天前";
        }else if ( $interval > 3600 ){ // > 1 hour
            $number = intval($interval/3600);
            return "${number}小时前";
        }else if ( $interval >= 60 ){ // > 1 min
            $number = intval($interval/60);
            return "${number}分钟前";
        }else if ( 5 >= $interval){// < 5 second
            return "就在刚才";
        }else{ // < 1 min
            return "${interval}秒前";
        }
    }

    /** 日期
     * @return multitype:string 
     */
    static public function GetDate() {
        $w = array('日','一','二','三','四','五','六');
        return $now = array(
                'date' => date('Y年m月d日'),
                'week' => '星期'.$w[ date('w')]
                );
    }

    /** 
     * @param unknown_type $message
     * @return string
     */
    static public function GetMessagePic($message) {
        $pic = '';
        $p = "#([^\s]{25,105})\.(jpg|gif|png)#i";
        if ( preg_match($p, $message, $mathes) ) {
            $pic = "{$mathes[1]}.{$mathes[2]}";
            $pic_s = explode('=', $pic);
            $pic = count($pic_s)>1 ? $pic_s[1]:$pic;
            $pic = trim(trim($pic),'\'"');
        }
        return $pic;
    }

    /** 逗号分割
     * @param unknown_type $s 字符串
     * @param unknown_type $n 结果数限制
     * @return multitype:
     */
    static public function CommaSplit($s=null, $n=-1) {
        return preg_split('/[\s,]+/',$s,$n,PREG_SPLIT_NO_EMPTY);
    }
	
    static public function CommaJoin($a=array(), $n=-1) {
        return join(',', $a);
    }
	
    static public function Getcsv($s, $split=' ') {
        $r = array();
        while( $s ) {
            $qp1 = mb_strpos($s, '"');
            $p0 = mb_strpos($s, $split);
            $p1 = mb_strpos($s, "\t");
            $p = false;

            if ( $p0!==FALSE && $p1 !==FALSE ) {
                $p = min($p0, $p1);
            } else if ( $p0 !== FALSE ) {
                $p = $p0;
            } else if ( $p1 !== FALSE ) {
                $p = $p1;
            } 

            $qp2 = false;
            if ( $qp1===0 ) {
                $qp2 = mb_strpos($s, '"', 1);
            }

            if ( $qp2 !== FALSE ) {
                $m = mb_substr($s, 0, $qp2);
                $m = trim($m, '"');
                $s = trim(trim(mb_substr($s, $qp2+1)),"\t");
            } else if ($p !== FALSE ){
                $m = mb_substr($s, 0, $p);
                $s = trim(mb_substr($s, $p+1));
            } else {
                $m = $s;
                $s = null;
            }
            $r[] = $m;
        }
        return $r;
    } 

    static public function GetKeyValue($string=null) 
    {
        $csv = Utility::GetCsv($string);
        $kv = array(); 
        foreach( $csv AS $one ) {
            @list($name, $v) = explode('=', $one, 2);
            if ( $v === null ) $v = true;
            $kv[ strtolower($name) ] = trim($v,'" ');
        }
        return $kv;
    }

    static function GenSecret($len=6, $type=self::CHAR_WORD)
    {
        $secret = '';
        for ($i = 0; $i < $len;  $i++) {
            if ( self::CHAR_NUM==$type ){
				if (0==$i) {
					$secret .= chr(rand(49, 57));
				} else {
					$secret .= chr(rand(48, 57));
				}
            }else if ( self::CHAR_WORD==$type ){
                $secret .= chr(rand(65, 90));
            }else{
                if ( 0==$i ){
                    $secret .= chr(rand(65, 90));
                } else {
                    $secret .= (0==rand(0,1))?chr(rand(65, 90)):chr(rand(48,57));
                }
            }
        }
        return $secret;
    }

    static function Random($a=array()) {
        $tv = 0;
        foreach($a as $k=>$v) { 
            if ($v<0) { $a[$k] = $v = 0; }
            $tv += $v; 
        }
        if ( $tv == 0 ) return 0;
        $im = (float) 10000/$tv;
        $r = rand(0,10000);
        $tv = 0;
        foreach($a AS $k=>$v) {
            $tv += ($v*$im);
            if ( ceil($tv) >= $r ) 
                return $k;
        }
        return $k;
    }

	/** 重定向
	 * @param unknown_type $u
	 */
	static function Redirect($u=null) {
		if (!$u) $u = $_SERVER['HTTP_REFERER'];
		if (!$u) $u = '/';
		Header("Location: {$u}");
		exit;
	}

	static private function GetHttpContent($fsock=null) {
		$out = null;
		while($buff = @fgets($fsock, 2048)){
			$out .= $buff;
		}
		fclose($fsock);
		$pos = strpos($out, "\r\n\r\n");
		$head = substr($out, 0, $pos);    //http head
		$status = substr($head, 0, strpos($head, "\r\n"));    //http status line
		$body = substr($out, $pos + 4, strlen($out) - ($pos + 4));//page body
		if(preg_match("/^HTTP\/\d\.\d\s([\d]+)\s.*$/", $status, $matches)){
			if(intval($matches[1]) / 100 == 2){
				return $body;  
			}else{
				return false;
			}
		}else{
			return false;
		}
	}

	static public function DoGet($url){
		$url2 = parse_url($url);
		$url2["path"] = ($url2["path"] == "" ? "/" : $url2["path"]);
		$url2["port"] = ($url2["port"] == "" ? 80 : $url2["port"]);
		$host_ip = @gethostbyname($url2["host"]);
		$fsock_timeout = 2;  //2 second
		if(($fsock = fsockopen($host_ip, $url2['port'], $errno, $errstr, $fsock_timeout)) < 0){
			return false;
		}
		$request =  $url2["path"] .($url2["query"] ? "?".$url2["query"] : "");
		$in  = "GET " . $request . " HTTP/1.0\r\n";
		$in .= "Accept: */*\r\n";
		$in .= "User-Agent: Payb-Agent\r\n";
		$in .= "Host: " . $url2["host"] . "\r\n";
		$in .= "Connection: Close\r\n\r\n";
		if(!@fwrite($fsock, $in, strlen($in))){
			fclose($fsock);
			return false;
		}
		return self::GetHttpContent($fsock);
	}

	static public function DoPost($url,$post_data=array()){
		$url2 = parse_url($url);
		$url2["path"] = ($url2["path"] == "" ? "/" : $url2["path"]);
		$url2["port"] = ($url2["port"] == "" ? 80 : $url2["port"]);
		$host_ip = @gethostbyname($url2["host"]);
		$fsock_timeout = 2; //2 second
		if(($fsock = fsockopen($host_ip, $url2['port'], $errno, $errstr, $fsock_timeout)) < 0){
			return false;
		}
		$request =  $url2["path"].($url2["query"] ? "?" . $url2["query"] : "");
		$post_data2 = http_build_query($post_data);
		$in  = "POST " . $request . " HTTP/1.0\r\n";
		$in .= "Accept: */*\r\n";
		$in .= "Host: " . $url2["host"] . "\r\n";
		$in .= "User-Agent: Lowell-Agent\r\n";
		$in .= "Content-type: application/x-www-form-urlencoded\r\n";
		$in .= "Content-Length: " . strlen($post_data2) . "\r\n";
		$in .= "Connection: Close\r\n\r\n";
		$in .= $post_data2 . "\r\n\r\n";
		unset($post_data2);
		if(!@fwrite($fsock, $in, strlen($in))){
			fclose($fsock);
			return false;
		}
		return self::GetHttpContent($fsock);
	}

	static function HttpRequest($url, $data=array(), $abort=false) {
		if ( !function_exists('curl_init') ) { return empty($data) ? self::DoGet($url) : self::DoPost($url, $data); }
		$timeout = $abort ? 1 : 2;
		$ch = curl_init();
		if (is_array($data) && $data) {
			$formdata = http_build_query($data);
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $formdata);
		}
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
		curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
		$result = curl_exec($ch);
		return (false===$result && false==$abort)? ( empty($data) ? self:: DoGet($url) : self::DoPost($url, $data) ) : $result;
	}

	static function IsMobile($no) {
		return preg_match('/^1[3458][\d]{9}$/', $no) 
			|| preg_match('/^0[\d]{10,11}$/', $no); 
	}

	static function VerifyCode($code=0) {
		$verifycode = $code ? $code : rand(100000,999999);
		$verifycode = str_replace('1989','9819',$verifycode);
		$verifycode = str_replace('1259','9521',$verifycode);
		$verifycode = str_replace('12590','95210',$verifycode);
		$verifycode = str_replace('10086','68001',$verifycode);
		return $verifycode;
	}
	
	/** 建立验证码
	 * @param unknown_type $size
	 */
	static function CaptchaCreate($size) {
		$v = new PhpCaptcha(null,100,50);
		$v->UseColour(true);
		$v->SetNumChars(4);
		$v->Create();
	}

	/** 验证验证码
	 * @param unknown_type $text
	 */
	static function CaptchaCheck($text) {
		return PhpCaptcha::Validate($text);
	}
}
