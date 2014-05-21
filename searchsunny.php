<?php
	require_once(dirname(__FILE__) . '/app.php');
	
	$url = 'http://www.sunnychina.com/hotel/hotel_$idx.html';
	$startindex = $_GET['startindex'];
	$endindex = $_GET['endindex'];
	for ($idx = $startindex; $idx < $endindex; $idx++)
	{
		$hotelurl = str_replace('$idx', $idx, $url);
		
		echo $hotelurl . '&nbsp;&nbsp;&nbsp;';
		parse($hotelurl);
		
	}
	
	function parse($hotelurl)
	{
		$html = file_get_contents($hotelurl);
		$html = mb_convert_encoding($html, 'utf-8', 'gb2312');
		
		$document = new DOMDocument('1.0','utf-8');
		$startpos = strpos($html, '</head>');
		$html = "<html><head><meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">" . substr($html, $startpos);
		@$document->loadHTML($html);
		$xpath = new Domxpath($document);
		
		$hotelnodes = $xpath->query('//div[@class="ititle"]/h1');
		if ( $hotelnodes->length < 0){
			echo 'no count <br>';
			ob_flush();
			flush();
			sleep(1);
			return;
		} 
		echo ' ' . $hotelnodes->length . ' ';
		$hotel_name = $hotelnodes->item(0)->textContent;
		if ( trim($hotel_name,'\'') == '' ){
			echo 'hotel_name is empty <br>';
			ob_flush();
			flush();
			sleep(1);
			return;
		}
		
		$locnodes = $xpath->query('//div[@id="infoleft"]/dl/dd');
		$hotel_loc = $locnodes->item(2)->textContent;
		
		$hotel_desc = $locnodes->item(3)->textContent;
		
		//分析构造价格信息的url ，  同时获得宾馆的 地图位置坐标
		$scriptnodes = $xpath->query('//div[@id="main"]/child::script');
		$scriptinfo = $scriptnodes->item(0)->textContent;
		
		$paramspos = strpos($scriptinfo,'(');
		$paramepos = strpos($scriptinfo, ')', $paramspos);
		$paraminfo = substr($scriptinfo, $paramspos+1, $paramepos - $paramspos -1);
		$param = split(',' ,$paraminfo);
		foreach($param as $key=>$value) $param[$key] = trim($value, '\' ');
		
		$mapparamspos = strpos($scriptinfo, '(', $paramepos);
		$mapparamepos = strpos($scriptinfo, ')', $mapparamspos);
		$mapparaminfo = substr($scriptinfo, $mapparamspos+1, $mapparamepos-$mapparamspos-1);
		$mapparam = split(',', $mapparaminfo);
		foreach($mapparam as $key=>$value) $mapparam[$key] = trim($value, ', ');
		
		if (isset($mapparam[1]) && isset($mapparam[2]))
			$latlon = trim($mapparam[1],'\'') . '@' . trim($mapparam[2], '\' ');
		
		$hotelinfo = array('hotel_name'=>$hotel_name, 
			'hotel_loc'=>substr($hotel_loc, 280), 
			'hotel_desc'=>substr($hotel_desc, 280), 
			'hotel_link'=>substr($hotelurl, 280),
			'latlon'=>$latlon,
			'source'=>'sunnychina');
		$hotel_id = DB::Insert('hotel', $hotelinfo);	
			
		sleep(1);
		
		//获取宾馆价格信息
		$priceurl = "http://www.sunnychina.com/hotel/get_json_one.asp?hotelid=" . $param[1] . "&startdate=2011-8-25&enddate=2011-8-28"
			 ."&elong_id=" . $param[2] . "&shenhe=" . $param[0] . "&jiangjin="
			 . $param[5] . "&min_price=" . $param[10];
		$html = file_get_contents($priceurl);
		$html = mb_convert_encoding($html, 'utf-8', 'gb2312');
		$hotelprice = json_decode($html);
		if(!isset($hotelprice) || !$hotelprice || !$hotelprice->Result)
		{
			echo '<br>';
			ob_flush();
			flush();
			sleep(1);
			return;
		}
		
		echo 'count:' . $hotelprice->RoomCount . '<br>';
		ob_flush();
		flush();
		
		foreach($hotelprice->Room as $key=>$value)
		{
			$room_type = $value->RoomName;
			$room_id = $value->RoomId;
			$rate_id = $value->Rate[0]->RateId;
			
			preg_match('/.(\d+)/i', $value->Rate[0]->AvgPrice, $hotels);
			if ( isset($hotels[1]) && is_numeric($hotels[1]))
				$hotel_price = $hotels[1];
			else $hotel_price = -1;
			
			$book_link = "http://www.sunnychina.com/hotel/room_{$room_id}_{$rate_id}_{$param[1]}.html";
			$hotelprice = array('room_type'=>$room_type,
								'hotel_price'=>$hotel_price,
								'book_link'=>$book_link,
								'hotel_id'=>$hotel_id);
			DB::Insert('hotelprice', $hotelprice);
		}
		sleep(1);
	}