<?php
require_once(dirname(__FILE__) . "/app.php");
function print_nodes_recursive($node, $i = 0)
{
	for ( $m = 0; $m < $i; $m++)
		echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
	var_dump($node);
	echo "TextContent . " . $node->textContent;
	if ( $node->nodeType == XML_ELEMENT_NODE )
		echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;tagName: " . $node->tagName;
	echo "<br>";
	foreach($node->childNodes as $childnode)
	{
		if ($childnode->nodeType == XML_ELEMENT_NODE && $childnode->hasChildNodes())
			print_nodes_recursive($childnode, $i+1);
	}
}

//分析速8酒店的地点和酒店信息
$html = file_get_contents("http://www.super8.com.cn/FrontCodeServlet.js?category=RES_COUNTRY,RES_CITY,RES_HOTEL");
$citystartp = strpos($html, 'RES_CITY');
$cityendp = strpos($html, ');', $citystartp);
$citystr = substr($html, $citystartp, $cityendp - $citystartp);
$cityelemp = strpos($citystr, '("');
$cityinfo = array();
while ($cityelemp > 0)
{
	$citynamep = strpos($citystr, '"', $cityelemp+2);
	$citycodesp = strpos($citystr, '"', $citynamep+2);
	$citycodeep = strpos($citystr, '"', $citycodesp+1);
	
	$cityname = substr($citystr, $cityelemp+2, $citynamep - $cityelemp - 2);
	$citycode = substr($citystr, $citycodesp+1, $citycodeep - $citycodesp - 1);
	
	$cityinfo[$citycode] = $cityname;
	$cityelemp = strpos($citystr, '("', $citycodeep);
}

//分析酒店名称和编码
$hotelstartp = strpos($html, 'RES_HOTEL');
$hotelendp = strpos($html, ');', $hotelstartp);
$hotelstr = substr($html, $hotelstartp, $hotelendp - $hotelstartp);
$hotelnamesp = strpos($hotelstr, '("');
$hotelinfo = array();
while ($hotelnamesp > 0)
{
	$hotelnameep = strpos($hotelstr, '"', $hotelnamesp + 2);
	$hotelcodesp = strpos($hotelstr, '"', $hotelnameep + 2);
	$hotelcodeep = strpos($hotelstr, '"', $hotelcodesp + 1);
	$hotelplacesp = strpos($hotelstr, '"', $hotelcodeep + 2);
	$hotelplaceep = strpos($hotelstr, '"', $hotelplacesp + 1);
	
	$hotelname = substr($hotelstr, $hotelnamesp + 2, $hotelnameep - $hotelnamesp - 2);
	$hotelcode = substr($hotelstr, $hotelcodesp+ 1, $hotelcodeep - $hotelcodesp - 1);
	$hotelplacecode = substr($hotelstr, $hotelplacesp+1, $hotelplaceep - $hotelplacesp - 1);
	
	$hotelinfo[$hotelcode] = array($hotelname, $cityinfo[$hotelplacecode]);
	$hotelnamesp = strpos($hotelstr, '("', $hotelplacesp);

	DB::Insert('hotel', array('hotel_name'=>$hotelname,
							  'hotel_loc'=>$cityinfo[$hotelplacecode],
							  'hotel_link'=>"http://www.super8.com.cn/FrontCommandServlet?command=FrontHotelServlet&hotelId={$hotelcode}",
							   'source' =>'super8'));	
}
echo "Finish fetch hotelinfo <br>";

$hotel = DB::LimitQuery('hotel', array('condition'=>array('source'=>'super8')));
foreach($hotel as $key=>$value)
{
	fetch_hotel_price_info($value['hotel_id'], $value['hotel_link'], date('Y-m-d',time()), date('Y-m-d',time()+24*3600) );	
}
echo "Finish fetch priceinfo <br>";


function fetch_hotel_price_info($hotel_id, $hotellink, $arriveDate, $leaveDate)
{
	echo $hotel_id . "$nbsp;";
	ob_flush();
	flush();
	$html = file_get_contents("{$hotellink}&arrivalDate={$arriveDate}&outDate={$leaveDate}");
	//获取订房地址的连接
	$target="document.frmMain.action=";
	$len = strlen($target);   
	$start = strpos($html, $target);
	if ( $start )
	{
		$start = strpos($html, '"', $start);
		$end = strpos($html, '"', $start + 1);
		$booklink = substr($html, $start+1, $end - $start - 1);
	}
	
	//获取所有的酒店价格信息
	$target = "document.getElementById(\"result\").innerHTML='";
	$len = strlen($target);
	$start = strpos($html, $target);
	if ($start)
	{
		$end = strpos($html, "';", $start+$len);
		$hotelinfo = substr($html, $start+$len, $end-$start-$len);
		$hotelinfo = str_replace("return false\" )=\"\"", "return false\"", $hotelinfo);
		
		$hotelinfo = '<meta http-equiv="Content-Type" content="text/html;charset=utf-8">' . $hotelinfo;
		$document = new DomDocument('1.0', 'utf-8');
		@$document->loadHTML($hotelinfo);
		//print_nodes_recursive($document);
	
		$xpath = new DOMXPath($document);
		$nodelist = $xpath->query('//body/div/table/tr');
		$sign = false;
		$bookparam_name = array('hotelId', 'rateCode', 'rmType', 'arrDate', 'depDate', 'rmQty', 'nights', 'adults', 'rmRate', 'fullRate', 'brkfstDesc');
		foreach($nodelist as $node)
		{
			if (!$sign)
			{
				$sign = true;
				continue;
			}
			$childnodelst = $node->childNodes;
			$roomtype = $childnodelst->item(0)->firstChild->textContent;
			$roomprice = $childnodelst->item(3)->firstChild->textContent;
			$roomlink = $childnodelst->item(4)->firstChild->attributes->getNamedItem('onclick');
			if (isset($roomlink))
			{			
				$roombook = $childnodelst->item(4)->firstChild->attributes->getNamedItem('onclick')->textContent;
				
				$paramsp = strpos($roombook, '(');
				$paramep = strpos($roombook, ')');
				$nodecontent = substr($roombook, $paramsp+1, $paramep - $paramsp - 1);
				$nodecontent = split(',', $nodecontent);
				
				$idx = 0;
				foreach($nodecontent as $key => $nodeitem)
				{
					$nodecontent[$key] = $bookparam_name[$idx] . '=' . trim($nodeitem, '\'\\ ');
					$idx++;
				}					
				$nodecontent = "http://www.super8.com.cn/" . $booklink . '@' . 'POST@' . implode('#', $nodecontent);
			}
			DB::Insert('hotelprice',array('hotel_id'=>$hotel_id, 
											'room_type'=>$roomtype,
										   'effec_time'=>strtotime($arriveDate),
											'hotel_price'=>$roomprice,
											'book_link'=>$nodecontent));
		}
	}
	sleep(1);

}
