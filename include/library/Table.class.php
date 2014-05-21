<?php
class Table
{
	public $table_name = null;//表名
	public $pk_name = 'id';//主键名
	public $pk_value = null;//主键值
	public $strip_column = array();
	private $column_values = array();//各字段值,整个一条记录

	public function __get($k=null)//返回字段值
	{
		if ( isset($this->column_values[$k]) )
			return $this->column_values[$k];
		return null;
	}
	//设置字段值
	public function __set($k=null, $v=null)
	{
		$this->column_values[$k] = $v;
	}

	/** 传入一整条记录
	 * @param unknown_type $vs 记录数组
	 */
	public function _set_values($vs=array())
	{
		$this->column_values = $vs;//记录
		if ( isset($vs[$this->pk_name]))//如果已经设定了主键
		{
			$this->pk_value = $vs[$this->pk_name];//获取主键值
		}
	}
	
	/** 构造函数
	 * @param unknown_type $n 
	 * @param unknown_type $record
	 * @param unknown_type $pre
	 */
	public function __construct($n=null, $record=array(), $pre='')
	{
		if ( is_array($n) )//输入一整个记录
		{
			$this->_set_values($n);
			return;
		}
		//表名
		$this->table_name = $n;
		if (strlen($pre)) {//去前缀
			foreach($record AS $k=>$v) {
				if (0===strpos($k,$pre)) {
					$k = substr($k, strlen($pre));//去掉前缀
					if ($k) $this->$k = $v;
					if ($k==$this->pk_name) {//如果有主键
						$this->pk_value = $v;//设置主键值
					}
				}
			}
		} else {//无前缀
			$this->_set_values( $record );
		}
	}
	//设置主键和主键值
	public function SetPk($k=null, $v=null)
	{
		if ( $k && $v )
		{
			$this->pk_name = $k;
			$this->pk_value = $v;
			$this->$k = $v;
		}
	}

	/** 获取一个键值
	 * @param unknown_type $k
	 */
	public function Get($k=null)
	{
		if (null==$k)
			return $this->column_values;
		return $this->__get($k);
	}

	/** 设置一个键值
	 * @param unknown_type $k
	 * @param unknown_type $v
	 */
	public function Set($k, $v=null)
	{
		$this->column_values[$k] = $v;
	}
	
	/** 某个字段自增
	 * @param unknown_type $k
	 * @param unknown_type $v
	 */
	public function Plus($k=null, $v=1)
	{
		if ( array_key_exists($k, $this->column_values) )
		{
			$this->column_values[$k] += $v;
		}
		else throw new Exception( 'Table ' .$this->table_name. ' no column '. $k );
	}

	/** 设置需要stripslashes的column
	 * @return string
	 */
	public function SetStrip() {
		$fields = func_get_args();//获取所有参数
		if ( empty($fields) )//空
			return true;
		if ( is_array($fields[0]) )
			$fields = $fields[0];
		$this->strip_column = $fields;
	}
	///插入
	public function Insert()
	{
		$fields = func_get_args();
		if ( empty($fields) )
			return true;

		if ( is_array($fields[0]) )
			$fields = $fields[0];
		
		$up_array = array();
		foreach( $fields AS $f )
		{
			if ( array_key_exists($f, $this->column_values) )//如果当前记录包含了这个字段
			{
				$up_array[$f] = $this->BuildDBValue($this->column_values[$f], $f);
			}
		}
		if (empty($up_array) )
			return true;

		return DB::Insert($this->table_name, $up_array);
	}
	//更新，传入需要更新的键值
	public function Update()
	{
		$fields = func_get_args();
		if ( empty($fields) )
			return true;

		if ( is_array($fields[0]) )
			$fields = $fields[0];

		$up_array = array();
		foreach( $fields AS $f )
		{
			if ( array_key_exists($f, $this->column_values) )
			{
				$up_array[$f] = $this->BuildDBValue($this->column_values[$f], $f);
			}
		}
		if (empty($up_array) )
			return true;

		if ($this->pk_value) {//有主键值更新，没有插入
			return self::UpdateCache($this->table_name, $this->pk_value, $up_array);
		} else {
			return $this->pk_value = $this->id = DB::Insert($this->table_name, $up_array);
		}
	}
	//更新同时清空cache
	static public function UpdateCache($n, $id, $r=array()) {
		DB::Update($n, $id, $r);
		return Cache::Del(Cache::GetObjectKey($n,$id));
	}
	
	/** db处理，删除tag，转义线什么的
	 * @param unknown_type $v 值
	 * @param unknown_type $f 字段名
	 */
	private function BuildDBValue($v, $f=null) {
		if (is_array($v)) return ','. join(',', $v) . ',';//逗号连起来
		global $striped_field;
		if (is_array($striped_field) && in_array($f, $striped_field)) {
			$v = strip_tags($v);
		}
		return in_array($f,$this->strip_column) ? stripslashes($v) : $v;
	}
	//根据id字段返回几行
	static private function _Fetch($n=null, $ids=array()) {
		$r = Cache::GetObject($n, $ids);//先查cache
		$diff = array_diff($ids, array_keys($r));//ids-r
		if(!$diff) return $r;//cache中有，返回cache
		$rr = DB::GetDbRowById($n, array_values($diff));//查没有的
		Cache::SetObject($n, $rr);//写入chache
		$r = array_merge($r, $rr);//合并结果
		return Utility::SortArray($r, $ids, 'id');//排序
	}
	//不考虑cache，直接获取，之后写入cache
	static public function FetchForce($n=null, $ids=array()) {
		if ( empty($ids) || !$ids ) return array();
		$single = is_array($ids) ? false : true;
		settype($ids, 'array'); $ids = array_values($ids);
		$ids = array_diff($ids, array(NULL));

		$r = DB::GetDbRowById($n, $ids);
		Cache::SetObject($n, $r);
		return $single ? array_pop($r):Utility::SortArray($r,$ids,'id');
	}	
	
	/** 获取ids对应的记录
	 * @param unknown_type $n 表名
	 * @param unknown_type $ids 所有的id
	 * @param unknown_type $k 主键名
	 * @return multitype:|Ambigous <unknown, mixed>|unknown|unknown
	 */
	static public function Fetch($n=null,$ids=array(),$k='id')
	{
		if ( empty($ids) || !$ids) return array();
		$single = is_array($ids) ? false : true;//是否是数组

		settype($ids, 'array'); $ids = array_values($ids);//获得所有ids值
		$ids = array_diff($ids, array(NULL));//去掉null

		if ($k=='id') { 
			$r = self::_Fetch($n, $ids);
			return $single ? array_pop($r) : $r;//如果id只有一个,返回，否则返回数组
		}
		//如果不是按照id
		$result = DB::LimitQuery($n, array(
					'condition' => array( $k => $ids, ),
					'one' => $single,
					));

		if ( $single ) { return $result; }
		return $result;
	}
	
	/** 获取count或sum
	 * @param unknown_type $n
	 * @param unknown_type $condition
	 * @param unknown_type $sum
	 * @return number
	 */
	static public function Count($n=null, $condition=null, $sum=null)
	{
		$condition = DB::BuildCondition( $condition );
		$condition = null==$condition ? null : "WHERE $condition";
		$zone = $sum ? "SUM({$sum})" : "COUNT(1)";
		$sql = "SELECT {$zone} AS count FROM `$n` $condition";
		$row = DB::GetQueryResult($sql, true);
		return $sum ? (0+$row['count']) : intval($row['count']);
	}

	/**
	 * @param unknown_type $n
	 * @param unknown_type $id
	 * @param unknown_type $k
	 */
	static public function Delete($n=null, $id=null, $k='id')
	{
		settype( $id, 'array' );
		$idstring = join('\',\'', $id);
		if(preg_match('/[\s]/', $idstring)) return false;
		$sql = "DELETE FROM `$n` WHERE `{$k}` IN('$idstring')";
		DB::Query( $sql );
		if ($k!='id') return true;
		Cache::ClearObject($n, $id);//从cache删除
		return True;
	}
}
?>
