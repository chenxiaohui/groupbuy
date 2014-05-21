<?php
header("Content-type: text/html; charset=utf-8");

require_once(dirname(dirname(dirname(__FILE__))) . '/app.php');
$url='';

require('FileList.php');
$files=list_file(dirname(__FILE__).'/websites','/\.php$/');
//foreach($files as $file)
{
	require(dirname(__FILE__).'/websites/quna.php');

	//Parse($site);
	
	$hotellst = DB::LimitQuery('hotel', array('condition'=>array('source'=>'quna',
																'hotel_id>8600'),
												'select'=>'`hotel_id`, `hotel_link`'));	
	
	ParsePrice($hotellst, '/(\d+\/\d+\/)$/i', '20110801/20110825/', $site);
	unset($site);
}

function r($key,$value)
{
	global $url;
	$url=str_replace($key,$value,$url);
}

function Parse($site)
{
	//生成候选集
	$params=$site['param'];
	foreach($params as $key=>$param)
	{
		if(!is_array($param))//不是数组，更改原候选
		{
			eval('$params[$key]='."$param;");
		}
	}
	$res=array();
	//生成笛卡尔积
	foreach($params as $key=>$param)
	{
		$res=Decare($res,$param,$key);
	}

	foreach($res as $code)
	{
		global $url;
		$url=$site['url'];
		eval($code);//执行代码
		echo '<b>'.$url.'</b><br/>';
		ParseUrl($url,$site);
	}
	unset($res);
	//替换生成url
}

function ParsePrice($hotellst, $pattern, $replacement, $site)
{
	foreach($hotellst as $key => $value)
	{
		$hotel_link = preg_replace($pattern, $replacement, $value['hotel_link']);
		parseHotelPrice($value['hotel_id'],$hotel_link, $site);
	}
}
//生成两个集合的笛卡尔积
function Decare($a,$b,$k)
{
	$result=array();
	if(empty($a))//生成自笛卡尔积
	{
		foreach($b as $vb)
		$result[]="r('$k','$vb');";
		return $result;
	}

	foreach($a as $va)
	{
		foreach($b as $vb)
		{
			$result[]=$va."r('$k','$vb');";
		}
	}
	return $result;
}

function expand($begin,$end)
{
	$result=array();
	$i=$begin;
	while($i<=$end)
	{
		$result[]=$i;
		++$i;
	}
	return $result;
}

function expandDate($begin, $length)
{
	$result = array();
	$i = 0;
	while ($i < $length)
	{
		$result[] = date("Ymd",$begin + $i * 24 * 3600);
		$i++;
	}
	return $result;
}

function ParseUrl($url,$site)
{
	$html=file_get_contents($url);
	//if (function_exists("preprocess_document"))
		//$html = preprocess_document($html);
	$encoding = mb_detect_encoding($html);
	mb_convert_encoding($html,"utf-8","gbk");
//	echo $html;
	$xmldoc = new DOMDocument();
	@$xmldoc->loadHTML($html);
	$xpathvar= new Domxpath($xmldoc);

	
	$hotel_name='';
	$hotel_loc='';
	$hotel_desc='';
	//解析酒店名称、地点信息
	foreach($site['xpath'] as $key=>$value)
	{
		//解析
		if(!empty($value['path']))
		{
			$queryResult = $xpathvar->query($value['path']);
			foreach($queryResult as $result)
			{
				eval($key . '=' . '$result->' . "{$value['attribute']};");
			}
			//自定义函数
			if(!empty($value['func']))
			{
				$func=$value['func'];
				eval($key."=$func;");
			}
		}
		
	}
	if ( $hotel_name != '')
	{
		$hotelinfo = array('hotel_name'=>$hotel_name, 
							'hotel_loc'=>$hotel_loc, 
							'hotel_desc'=>$hotel_desc, 
							'hotel_link'=>$url,
							'source'=>'quna');
		$hotel_id = DB::Insert('hotel', $hotelinfo);
	}
		fl();
		sleep(1);
}
//爬取酒店价格信息
function parseHotelPrice($hotel_id, $hotellink, $site)
{	
	$html=file_get_contents($hotellink);
	//if (function_exists("preprocess_document"))
		//$html = preprocess_document($html);
	echo 'Hotel_id: ' . $hotel_id . ' : ';
	$encoding = mb_detect_encoding($html);
	mb_convert_encoding($html,"utf-8","gbk");
	$xmldoc = new DOMDocument();
	@$xmldoc->loadHTML($html);
	$xpathvar= new Domxpath($xmldoc);
	
	//爬取酒店价格信息
	$priceinfolst = array();
	$mincount = 100;
	foreach($site['pricexpath'] as $key => $value)
	{
		if (is_array($value['path']))
		{
			$priceinfolst[$key] = array();
			foreach($value['path'] as $pathkey=>$pathvalue)
			{
				$tmppath = $xpathvar->query($pathkey);
				$priceinfolst[$key][] = array($tmppath, $pathvalue);
				if ($tmppath->length < $mincount)	$mincount = $tmppath->length;
			}
		}
	}

	
	for($idx = 0; $idx < $mincount; $idx++)
	{
		$insertvalues = array();
		foreach($priceinfolst as $key => $value )
		{
			if ( in_array($key,array('room_type', 'hotel_price', 'book_link')) )
			{
				$tmpstr = '';
				foreach($value as $valkey =>$valval)
				{
					$code = '$tmpstr .=$valval[0]->item('. $idx .')->'. "{$valval[1]};";
					eval($code);
				}
				$insertvalues[$key] = $tmpstr;
			}
		}
		$insertvalues['room_type'] = str_replace(array('\n', ' ', '；'), array(''), $insertvalues['room_type']);
		$insertvalues['hotel_price'] = str_replace(array('\n', ' ', '；'), array(''), $insertvalues['hotel_price']);
		$insertvalues['effec_time'] = time();
		$insertvalues['hotel_id'] = $hotel_id;
		//$room_type = $room_type_lst->item($idx)->textContent . 
		//	$room_type_extra_lst->item($idx)->textContent;
		//$hotel_price = -1;
		//$hotel_price = intval($room_price_lst->item($idx)->textContent);
		//$book_link = $book_link_lst->item($idx)->attributes->getNamedItem('href')->textContent;
		
		//$price_item = array('hotel_id'=>$hotel_id,
		//					'room_type' =>$room_type,
		//					'hotel_price' => $hotel_price,
		//					'book_link' => $book_link . "@GET@",
		//					'effec_time' => time());	
		
		$price_id = DB::Insert('hotelprice', $insertvalues);
		echo $price_id . '&nbsp;&nbsp;';
	}
	echo '<br>';
	fl();
	sleep(1);
}

function Store($hotel_name,$hotel_loc,$hotel_desc,$hotel_city)
{
	
}

function fl()
{
	ob_flush();
	flush(); 
}
?>