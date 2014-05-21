<?php
	//$html = file_get_contents('http://www.sunnychina.com:80/hotel/get_json_one.asp?hotelid=1950&startdate=2011-8-25&enddate=2011-8-28&elong_id=42901004&shenhe=1&jiangjin=0&min_price=398');
	//$encoding = mb_detect_encoding($html);
	//$html = mb_convert_encoding($html,"utf-8","gbk");
	//$priceinfo = json_decode($html);
	//var_dump($priceinfo->Room[0]);
	//var_dump($priceinfo);
	
	//preg_match('/.(\d+)/i', '￥398', $hotel_price);
	//echo $hotel_price[0];
	
//	$html = file_get_contents('http://hotel.elong.com:80/isajax/HotelListNew/Search?viewpath=~/views/2011/HotelList.aspx?Language=CN&_=1309333106764&RankType=0&CityId=0101&CityName=%E5%8C%97%E4%BA%
//
//AC&CheckInDate=2011%2F6%2F30+0%3A00&CheckOutDate=2011%2F7%2F2+0%
//
//3A00&HotelName=&Keywords=&KeywordsType=None&AreaId=&AreaType=0&PoiId=0&LowPrice=0&HighPrice=0&StarLevel=None&BrandId=0&Distance=100&StartLat=0&StartLng=0&EndLat=0&EndLng=0&IsBig
//
//Bed=false&IsDoubleBed=false&IsFreeBreakfast=false&IsFreeNet=false&IsCoupon=false&IsCashback=false&IsNoGuarantee=false&HotelSort=ByDefault&PageIndex=2&PageSize=15&HotelCount=1558
//
//&ListType=Common&Language=CN&CardNo=192928&ApCardNo=&ChannelCode=0000&OrderFromId=50&valueOf=%5Bobject+Object%5D');
//	$hotelinfo = json_decode($html);
//
//	var_dump($hotelinfo);
	require_once(dirname(__FILE__) . '/app.php');
		parseDetail('http://hotel.elong.com/detail_cn_10101109.html');
	function parseDetail($hotelurl)
	{
		$hotelhtml = file_get_contents($hotelurl);
		$hotelhtml = mb_convert_encoding($hotelhtml, 'utf-8', mb_detect_encoding($hotelhtml));
		
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
		
		$hotel_id = DB::Insert('hotel', array('hotel_name'=>mb_substr($hotel_name, 0, 50),
											  'hotel_loc'=>mb_substr($hotel_loc, 0, 100),
											  'hotel_desc'=>$hotel_desc,
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