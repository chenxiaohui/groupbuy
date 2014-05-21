<?php

/**分页
 * @author 
 *
 */
class Pager{

	public $rowCount = 0;
	public $pageNo = 1;
	public $pageSize = 20;//一页记录数
	public $pageCount = 0;
	public $offset = 0;
	public $pageString = 'page';//传入的get参数里表征页码的变量名

	private $script = null;
	private $valueArray = array();

	public function __construct($count=0, $size=20, $string='page')
	{
		$this->defaultQuery();//分析get请求
		$this->pageString = $string;//传入的get参数里表征页码的变量名
		$this->pageSize = abs($size);//页面大小
		$this->rowCount = abs($count);//总记录数

		$this->pageCount = ceil($this->rowCount/$this->pageSize);//总页数
		$this->pageCount = ($this->pageCount<=0)?1:$this->pageCount;
		$this->pageNo = abs(intval(@$_GET[$this->pageString]));//请求页码
		$this->pageNo = $this->pageNo==0 ? 1 : $this->pageNo;
		$this->pageNo = $this->pageNo>$this->pageCount 
			? $this->pageCount : $this->pageNo;
		$this->offset = ( $this->pageNo - 1 ) * $this->pageSize;//偏移
	}

	/** 生成请求url
	 * @param unknown_type $param
	 * @param unknown_type $value
	 * @return string
	 */
	private function genURL( $param, $value ){
		$valueArray = $this->valueArray;
		$valueArray[$param] = $value;
		return $this->script . '?' . http_build_query($valueArray);
	}

	/** 分析get请求
	 * 
	 */
	private function defaultQuery()
	{
		($script_uri = @$_SERVER['SCRIPT_URI']) || ($script_uri = @$_SERVER['REQUEST_URI']);
		$q_pos = strpos($script_uri,'?');
		if ( $q_pos > 0 )
		{
			$qstring = substr($script_uri, $q_pos+1);//query字符串
			parse_str($qstring, $valueArray);//函数把查询字符串解析到变量中
			$script = substr($script_uri,0,$q_pos);//脚本路径
		}
		else
		{
			$script = $script_uri;
			$valueArray = array();
		}
		$this->valueArray = empty($valueArray) ? array() : $valueArray;
		$this->script = $script;
	}

	/**  分页并返回结果
	 * @param unknown_type $switch
	 * @return multitype:NULL unknown 
	 */
	public function paginate($switch=1){
		$from = $this->pageSize*($this->pageNo-1)+1;//开始
		$from = ($from>$this->rowCount) ? $this->rowCount : $from;
		$to = $this->pageNo * $this->pageSize;
		$to = ($to>$this->rowCount) ? $this->rowCount : $to;//范围限制
		$size = $this->pageSize;
		$no = $this->pageNo;//当前页码
		$max = $this->pageCount;//总页码
		$total = $this->rowCount;//总行数

		return array(
			'offset' => $this->offset,
			'from' => $from,
			'to' => $to,
			'size' => $size,
			'no' => $no,
			'max' => $max,
			'total' => $total,
		);
	}

	/** 手机分页结果
	 * @return string
	 */
	public function GenWap() {
		$r = $this->paginate();
		$pagestring= '<p align="right">';
		if( $this->pageNo > 1 ){
			$pageString.= '4 <a href="' . $this->genURL($this->pageString, $this->pageNo-1) . '" accesskey="4">上页</a>';
		}
		if( $this->pageNo >1 && $this->pageNo < $this->pageCount ){
			$pageString.= '｜';
		}
		if( $this->pageNo < $this->pageCount ) {
			$pageString.= '<a href="' .$this->genURL($this->pageString, $this->pageNo+1) . '" accesskey="6">下页</a> 6';
		}
		$pageString.= '</p>';
		return $pageString;
	}
	
	/** 普通分页结果
	 * @return string
	 */
	public function GenBasic() {
		$r = $this->paginate();
		$buffer = null;
		$index = '首页';
		$pre = '上一页';
		$next = '下一页';
		$last = '末页';

		if ($this->pageCount<=7) { 
			$range = range(1,$this->pageCount);
		} else {
			$min = $this->pageNo - 3;
			$max = $this->pageNo + 3;
			if ($min < 1) {
				$max += (3-$min);
				$min = 1;
			}
			if ( $max > $this->pageCount ) {
				$min -= ( $max - $this->pageCount );
				$max = $this->pageCount;
			}
			$min = ($min>1) ? $min : 1;
			$range = range($min, $max);
		}
		
		$buffer .= '<ul class="paginator">';
		$buffer .= "<li>({$this->rowCount})</li>";
		if ($this->pageNo > 1) {
			$buffer .= "<li><a href='".$this->genURL($this->pageString,1)."'>{$index}</a><li><a href='".$this->genURL($this->pageString,$this->pageNo-1)."'>{$pre}</a>";
		}
		foreach($range AS $one) {
			if ( $one == $this->pageNo ) {
				$buffer .= "<li class=\"hov\">{$one}</li>";
			} else {
				$buffer .= "<li><a href='".$this->genURL($this->pageString,$one)."'>{$one}</a><li>";
			}
		}
		if ($this->pageNo < $this->pageCount) {
			$buffer .= "<li><a href='".$this->genURL($this->pageString,$this->pageNo+1)."'>{$next}</a></li><li><a href='".$this->genURL($this->pageString, $this->pageCount)."'>{$last}</a></li>";
		}
		return $buffer . '</ul>';
	}
}
?>
