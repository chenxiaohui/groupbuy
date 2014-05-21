<?php
	require_once(dirname(__FILE__) . '/app.php');
	
	$cityhtml = file_get_contents("http://hotel.elong.com/hotcity/hotel.html");
	$citypos =  strpos($cityhtml, '[{');
	$cityhtml = substr($cityhtml, $citypos);
	$cityarray = json_decode($cityhtml);
	
	$url = 'http://hotel.elong.com/search/list_cn_$citycode.html';
	
	foreach($cityarray[0]->TabList as $key => $listinfo)
	{
		foreach ($listinfo->CityList as $key=>$city)
		{
			$city_name = $city->CityNameCn;
			$city_code = $city->CityCode;
			$searchurl = str_replace(array('$citycode'), array($city_code), $url);
			
			
			echo "{$city_name}Search: {$searchurl} <br>";
			ob_flush();
			flush();
			
			parseFirstPage($searchurl);
		}
	}
	
	function parseFirstPage($searchurl)
	{
		$resulthtml = file_get_contents($searchurl);
		
		echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;page1:<br>";
		ob_flush();
		flush();
		
		$resdoc = new DOMDocument();
		@$resdoc->loadHTML($resulthtml);
		$respath = new DOMXpath($resdoc);	

		$hotellink = $respath->query('//div[@class="basic"]/h2/a/@href');
				
		foreach($hotellink as $key =>$value)
		{
			$hotelurl = 'http://hotel.elong.com' . $value->textContent;
			parseDetail($hotelurl);
		}
		
		$pagespos = strpos($resulthtml, 'var HotelListNewController =');
		$target = 'SearchRequestInfo: {';
		$pagespos = strpos($resulthtml, $target, $pagespos);
		$pageepos = strpos($resulthtml, '}', $pagespos);
		$pagestr = substr($resulthtml, $pagespos + strlen($target),
							 $pageepos - $pagespos - strlen($target));

		$pageinfo = array();
		foreach(split(',', $pagestr) as $key => $value)
		{
			$tmp = split(':', $value);
			$pageinfo[trim($tmp[0], "\" \n\r")] = trim($tmp[1], "\" \n\r");
		}
		$hotelcount = $pageinfo['HotelCount'];
		$pagesize = $pageinfo['PageSize'];
		$pagecount = intval($hotelcount / $pagesize) + 1;
		$paramstr = '';
		foreach($pageinfo as $key => $value)
		{
			if ( $key != 'PageIndex')
				$paramstr .= '&' . $key . '=' . $value;
		}
		$paramstr = trim($paramstr, '&');
		
		sleep(1);
		
		for($idx = 2; $idx < $pagecount; $idx++)
		{
			echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Page{$idx}:<br>";
			ob_flush();
			flush();
			
			$searchurl = 'http://hotel.elong.com/search/list_cn_0101.html?pageindex=' . $idx;
			parseHotel($searchurl);	
		}		
		
	}
	function parseHotel($searchurl)
	{		
		$resulthtml = file_get_contents($searchurl);
		
		$resdoc = new DOMDocument();
		@$resdoc->loadHTML($resulthtml);
		$respath = new DOMXpath($resdoc);	

		$hotellink = $respath->query('//div[@class="basic"]/h2/a/@href');
		sleep(1);
				
		foreach($hotellink as $key =>$value)
		{
			$hotelurl = 'http://hotel.elong.com' . $value->textContent;
			parseDetail($hotelurl);
		}
	}

	function parseDetail($hotelurl)
	{
		$count = Table::Count('hotel', array('hotel_link'=> $hotelurl . '@GET@',
														  'source'=>'yilong'));
		if ( $count > 0 )
		{
			$hotel = DB::LimitQuery('hotel', array('condition'=>array('hotel_link'=> $hotelurl . '@GET@',
														  'source'=>'yilong')));
			echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; hotel_id: {$hotel[0]['hotel_id']} $hotelurl is already parsed {$hotel[0]['hotel_id']}<br>";
			ob_flush();
			flush();
			return;
		} 
		
		$hotelhtml = file_get_contents($hotelurl);
		$hoteldoc = new DOMDocument();
		@$hoteldoc->loadHTML($hotelhtml);
		$hotelpath = new DOMXpath($hoteldoc);
		
		$hotel_name_nodes = $hotelpath->query('//div[@class="pt8"]/h1');
		$hotel_name = $hotel_name_nodes->item(0)->textContent;
		$hotel_loc_nodes = $hotelpath->query('//ul[@id="ulBasicInfolist"]/li[1]');
		$hotel_loc = $hotel_loc_nodes->item(0)->textContent;
		$hotel_desc_nodes = $hotelpath->query('//div[@class="p10"]');
		$hotel_desc = $hotel_desc_nodes->item(0)->textContent;
		
		$hoteldetailspos = strpos($hotelhtml, 'var HotelDetailController');
		$hotelnumspos = strpos($hotelhtml, 'hotelID:');
		$hotelnumspos = strpos($hotelhtml, '"', $hotelnumspos);
		$hotelnumepos = strpos($hotelhtml, '"', $hotelnumspos+1);
		$hotel_num = substr($hotelhtml, $hotelnumspos+1, $hotelnumepos - $hotelnumspos - 1);
		
		$target = 'lat: "';
		$hotellatspos = strpos($hotelhtml, $target, $hotelnumepos);
		$hotellatepos = strpos($hotelhtml, '"', $hotellatspos + strlen($target));
		$latlon = substr($hotelhtml, $hotellatspos + strlen($target), $hotellatepos - $hotellatspos - strlen($target));
		
		$target = 'lng: "';
		$hotellonspos = strpos($hotelhtml, $target, $hotellatepos);
		$hotellonepos = strpos($hotelhtml, '"', $hotellonspos + strlen($target));
		$latlon = $latlon . '@' . substr($hotelhtml, $hotellonspos + strlen($target), $hotellonepos - $hotellonspos -  strlen($target));
		
		$target = 'HotelRoom: ';
		$hotelroomspos = strpos($hotelhtml, $target);
		$hotelroomepos = strpos($hotelhtml, 'Ajaxsort: ');
		$hotelinfostr = substr($hotelhtml, $hotelroomspos + strlen($target), $hotelroomepos - $hotelroomspos - strlen($target));
		$hotelinfostr = trim($hotelinfostr, ", \n\r");
		$hotelinfo = json_decode($hotelinfostr);
		
		$hotel_id = DB::Insert('hotel', array('hotel_name'=>mb_substr($hotel_name, 50),
											  'hotel_loc'=>mb_substr($hotel_loc,300),
											  'hotel_desc'=>mb_substr($hotel_desc, 800),
											  'hotel_link'=>$hotelurl,
											  'source'=>'yilong',
											  'latlon'=>$latlon));
		if (!$hotel_id)
		{
			echo "<font color='red'> {$hotel_name}-{$hotelurl} search failed </font>";
			ob_flush();
			flush();
			return;
		}
		else
			echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;hotel_id({$hotel_id}):";
		ob_flush();
		flush();
		
		foreach($hotelinfo[0] as $pricekey => $pricevalue)
		{
			$price = intval(substr($pricevalue->AvgPrice, strlen('&yen;')));
			$priceinfo = array('hotel_id'=>$hotel_id, 
								'hotel_price'=>$price,
							   'book_link'=>"http://hotel.elong.com/florder_cn_{$hotel_num}_{$pricevalue->RmID}_{$pricevalue->RtID}.htm",
							   'room_type'=>$pricevalue->RmName . $pricevalue->RtName);
			$hotel_price_id = DB::Insert('hotelprice', $priceinfo);
			
			echo $hotel_price_id . "&nbsp;&nbsp;&nbsp;";
			ob_flush();
			flush();
		}
		echo "<br>";
		ob_flush();
		flush();
		
		sleep(1);
	}