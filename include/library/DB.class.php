<?php
require_once("log.php");
class DB
{
	static private $mInstance = null;//单体实例

	static private $mConnection = null;//连接实例

	static public $mDebug = false;//是否开启调试

	static public $mError = null;

	static public $mCount = 0;

	static public function &Instance()
	{
		if ( null == self::$mInstance )
		{ 
			$class = __CLASS__;
			self::$mInstance = new $class;
		}
		return self::$mInstance;
	}

	function __construct()
	{
		global $INI;
		if (isset($INI['db']) && $INI['db']) {
			$host = (string) $INI['db']['host'];
			$user = (string) $INI['db']['user'];
			$pass = (string) $INI['db']['pass'];
			$name = (string) $INI['db']['name'];
		} else {
			$config = Config::Instance('php');
			$host = (string) $config['db']['host'];
			$user = (string) $config['db']['user'];
			$pass = (string) $config['db']['pass'];
			$name = (string) $config['db']['name'];
		}
		//连接数据库
		self::$mConnection = mysql_connect( $host, $user, $pass );
		$errot= mysql_error();
		echo $errot;
		if ( mysql_errno() )
			throw new Exception("Connect failed: " . mysql_error());

		@mysql_select_db( $name, self::$mConnection );
		@mysql_query( "SET NAMES UTF8;", self::$mConnection );
	}

	static function GetLinkId() {
		self::Instance();
		return self::$mConnection;
	}

	function __destruct()
	{
		self::Close();
	}

	static public function Debug()
	{
		self::$mDebug = !self::$mDebug;
	}

	static public function Close()
	{
		if ( is_resource( self::$mConnection ) )
		{
			@mysql_close( self::$mConnection );
		}

		self::$mConnection = null;
		self::$mInstance = null;
	}

	
	/** 防注入
	 * @param unknown_type $string
	 */
	static public function EscapeString( $string )
	{
		self::Instance();
		return @mysql_real_escape_string( $string, self::$mConnection );
	}

	/** 获得插入的id
	 * @return number
	 */
	static public function GetInsertId()
	{
		self::Instance();
		return intval( @mysql_insert_id(self::$mConnection) );
	}

	/** 执行查询
	 * @param unknown_type $sql
	 * @return unknown|string
	 */
	static public function Query( $sql )
	{
		self::Instance();

		if ( self::$mDebug )
		{
			echo $sql;
		}

		$result = @mysql_query( $sql, self::$mConnection );
		self::$mCount++;

		if ( $result )
		{
			return $result;
		}
		else
		{
			self::$mError = mysql_error();
		}

		self::Close();
		return false;
	}
	
	/** 取下一条记录
	 * @param unknown_type $query
	 * @return multitype:
	 */
	static public function NextRecord($query) {
		return array_change_key_case(mysql_fetch_assoc($query),CASE_LOWER);
	}
	
	static public function GetTableRow($table, $condition)
	{
		return self::LimitQuery($table, array(
					'condition' => $condition,
					'one' => true,
					));
	}
	//根据id获取记录
	static public function GetDbRowById($table, $ids=array()) { 
		$one = is_array($ids) ? false : true;
		settype($ids, 'array');
		$idstring = join('\',\'', $ids);
		if(preg_match('/[\s]/', $idstring)) return array();
		$q = "SELECT * FROM `{$table}` WHERE id IN ('{$idstring}')";
		$r = self::GetQueryResult($q, $one);
		if ($one) return $r;
		return Utility::AssColumn($r, 'id');
	}

	/** 最常用的查询函数
	 * @param unknown_type $table
	 * @param unknown_type $options
	 */
	static public function LimitQuery($table, $options=array())
	{
		$condition = isset($options['condition']) ? $options['condition'] : null;//获取条件
		$one = isset($options['one']) ? $options['one'] : false;//是否只查询一条
		$offset = isset($options['offset']) ? abs(intval($options['offset'])) : 0;//从偏移开始
		if ( $one ) {
			$size = 1;//往下找几条
		} else {
			$size = isset($options['size']) ? abs(intval($options['size'])) : null;//大小
		}
		$select = isset($options['select']) ? $options['select'] : '*';//select字段
		$order = isset($options['order']) ? $options['order'] : null;
		$cache = isset($options['cache'])?abs(intval($options['cache'])):0;

		$condition = self::BuildCondition( $condition );//建立条件
		$condition = (null==$condition) ? null : "WHERE $condition";

		$limitation = $size ? "LIMIT $offset,$size" : null;

		//程孟力增加,用于多表查询
		if (is_array($table))
		{
			$tablestr = '';
			foreach ($table as $key => $value)
			{
				$tablestr = $tablestr . "{$value}`,`";
			}
			$table = trim($tablestr, "`,`");
		}
		
		$sql = "SELECT {$select} FROM `$table` $condition $order $limitation";
		return self::GetQueryResult( $sql, $one, $cache);
	}
	
	/**从sql返回查询结果，比Query函数多了Cache操作
	 * @param unknown_type $sql sql语句
	 * @param unknown_type $one 是否只查询一条
	 * @param unknown_type $cache 过期时间，默认永不过期
	 * @return unknown|multitype:
	 */
	static public function GetQueryResult( $sql, $one=true, $cache=0 )
	{
		$mkey = Cache::GetStringKey($sql);//根据sql从memcache获取mkey
		if ( $cache > 0 ) {//从memcache里查
			$ret = Cache::Get($mkey);
			if ( $ret ) return $ret;
		}
		
		$ret = array();
		if ( $result = self::Query($sql)  )
		{
			while ( $row = mysql_fetch_assoc($result) )
			{
				$row = array_change_key_case($row, CASE_LOWER);
				if ( $one )
				{
					$ret = $row;//直接返回结果
					break;
				}else{ 
					array_push( $ret, $row );
				}
			}

			@mysql_free_result( $result );
		}
		if ($ret) Cache::Set($mkey, $ret, 0, $cache);
		return $ret;
	}

	static public function SaveTableRow($table, $condition)
	{
		return self::Insert($table, $condition);
	}

	/** 插入
	 * @param unknown_type $table
	 * @param unknown_type $condition
	 * @return string|string
	 */
	static public function Insert( $table, $condition )
	{
		self::Instance();

		$sql = "INSERT INTO `$table` SET ";
		$content = null;

		foreach ( $condition as $k => $v )
		{
			$v_str = null;
			if ( is_numeric($v) )
				$v_str = "'{$v}'";
			else if ( is_null($v) )
				$v_str = 'NULL';
			else
				$v_str = "'" . self::EscapeString($v) . "'";

			$content .= "`$k`=$v_str,";
		}

		$content = trim($content, ',');
		$sql .= $content;

		$result = self::Query ($sql);
		if ( false==$result )
		{
			self::Close();
			return false;
		}
		($insert_id = self::GetInsertId()) || ($insert_id =  true) ;
		return $insert_id;
	}

	static public function DelTableRow($table=null, $condition=array())
	{
		return self::Delete($table, $condition);
	}

	static public function Delete($table=null, $condition = array())
	{
		if ( null==$table || empty($condition) )
			return false;
		self::Instance();

		$condition = self::BuildCondition($condition);
		$condition = (null==$condition) ? null : "WHERE $condition";
		$sql = "DELETE FROM `$table` $condition";
		return DB::Query( $sql );
	}

	/** 更新操作
	 * @param unknown_type $table 表名
	 * @param unknown_type $id 主键值或者条件数组
	 * @param unknown_type $updaterow 更新行内容
	 * @param unknown_type $pkname 主键名
	 * @return string|string|string
	 */
	static public function Update( $table=null, $id=1, $updaterow=array(), $pkname='id' )
	{
		if ( null==$table || empty($updaterow) || null==$id)
			return false;//返回
		//更新条件
		if ( is_array($id) ) $condition = self::BuildCondition($id);//id如果是数组
		else $condition = "`$pkname`='".self::EscapeString($id)."'";//否则就key->id

		self::Instance();

		$sql = "UPDATE `$table` SET ";//sql
		$content = null;
		//更新内容
		foreach ( $updaterow as $k => $v )//更新row
		{
			$v_str = null;
			if ( is_numeric($v) )
				$v_str = "'{$v}'";
			else if ( is_null($v) )
				$v_str = 'NULL';
			else if ( is_array($v) )
				$v_str = $v[0]; //for plus/sub/multi; 
			else
				$v_str = "'" . self::EscapeString($v) . "'";

			$content .= "`$k`=$v_str,";
		}

		$content = trim($content, ',');
		$sql .= $content;
		$sql .= " WHERE $condition";//条件
//		phplog::writelog($sql);
		$result = self::Query ($sql);

		if ( false==$result )
		{
			self::Close();
			return false;
		}

		return true;
	}


	/** 查询一个表的字段
	 * @param unknown_type $table
	 * @param unknown_type $select_map
	 * @return Ambigous <multitype:, multitype:string unknown Ambigous <multitype:, unknown> >
	 */
	static public function GetField($table, $select_map = array())
	{
		$fields = array();
		$q = self::Query( "DESC `$table`" );

		while($r=mysql_fetch_assoc($q) )
		{
			$Field = $r['Field'];
			$Type = $r['Type'];

			$type = 'varchar';
			$cate = 'other';
			$extra = null;

			if ( preg_match( '/^id$/i', $Field ) )
				$cate = 'id';
			else if ( preg_match( '/^_time/i', $Field ) )
				$cate = 'integer';
			else if ( preg_match( '/^_number/i', $Field ) )
				$cate = 'integer';
			else if ( preg_match ( '/_id$/i', $Field ) )
				$cate = 'fkey';


			if ( preg_match('/text/i', $Type ) )
			{
				$type = 'text';
				$cate = 'text';
			}
			if ( preg_match('/date/i', $Type ) )
			{
				$type = 'date';
				$cate = 'time';
			}
			else if ( preg_match( '/int/i', $Type) )
			{
				$type = 'int';
			}
			else if ( preg_match( '/(enum|set)\((.+)\)/i', $Type, $matches ) )
			{
				$type = strtolower($matches[1]);
				eval("\$extra=array($matches[2]);");
				$extra = array_combine($extra, $extra);

				foreach( $extra AS $k=>$v)
				{
					$extra[$k] = isset($select_map[$k]) ? $select_map[$k] : $v;
				}
				$cate = 'select';
			}

			$fields[] = array(
					'name' => $Field,
					'type' => $type,
					'extra' => $extra,
					'cate' => $cate,
					);
		}
		return $fields;
	}

	/** 存在性
	 * @param unknown_type $table
	 * @param unknown_type $condition
	 * @return Ambigous <string, unknown>
	 */
	static public function Exist($table, $condition=array())
	{
		$row = self::LimitQuery($table, array(
					'condition' => $condition,
					'one' => true,
					));

		return empty($row) ? false : (isset($row['id']) ? $row['id'] : true);
	}
	//建立条件语句
	static public function BuildCondition($condition=array(), $logic='AND')
	{
		/*叶子：value:数字，null，数组，字符串
		  如果key是数字，或key是and，or，继续构建
		 */
		
		//如果已经是string了或者为空，返回
		if ( is_string( $condition ) || is_null($condition) )
			return $condition;

		$logic = strtoupper( $logic );//逻辑
		$content = null;//结果
		foreach ( $condition as $k => $v )
		{
			$v_str = null;//$v应该的值
			$v_connect = '=';//连接字
			//没有key，用默认logic进入构建
			if ( is_numeric($k) )
			{
				$content .= $logic . ' (' . self::BuildCondition( $v, $logic ) . ')';
				continue;
			}

			$maybe_logic = strtoupper($k);//逻辑词，进入构建
			if ( in_array($maybe_logic, array('AND','OR')))
			{
				$content .= $logic . ' (' . self::BuildCondition( $v, $maybe_logic ) . ')';
				continue;
			}
			//value是数字
			if ( is_numeric($v) ) {
				$v_str = "'{$v}'";
			}//value是null
			else if ( is_null($v) ) {
				$v_connect = ' IS ';
				$v_str = ' NULL';
			}
			else if ( is_array($v) ) {//v是数组
				if ( isset($v[0]) ) {
					$v_str = null;
					foreach($v AS $one) {
						if (is_numeric($one)) {//数字
							$v_str .= ','.$one;
						} else {
							$v_str .= ',\''.self::EscapeString($one).'\'';
						}
					}
					$v_str = '(' . trim($v_str, ',') .')';
					$v_connect = 'IN';//IN查询
				} else if ( empty($v) ) {//v是空的
					$v_str = $k;
					$v_connect = '<>';//不等于
				} else {
					$v_connect = array_shift(array_keys($v));
					$v_s = array_shift(array_values($v));
					$v_str = "'".self::EscapeString($v_s)."'";
                    $v_str = is_numeric($v_s) ? "'{$v_s}'" : $v_str ;
				}
			} 
			else {
				$v_str = "'".self::EscapeString($v)."'";
			}

			$content .= " $logic `$k` $v_connect $v_str ";
		}

		$content = preg_replace( '/^\s*'.$logic.'\s*/', '', $content );
		$content = preg_replace( '/\s*'.$logic.'\s*$/', '', $content );
		$content = trim($content);

		return $content;
	}

	static public function CheckInt($id)
	{
		$id = intval($id);

		if ( 0>=$id )
			throw new Exception('must int!');

		return $id;
	}
}
?>
