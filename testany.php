<?php
	require_once(dirname(__FILE__) . '/app.php');
	
	$cityhtml = file_get_contents("http://hotel.elong.com/hotcity/hotel.html");
	$citypos =  strpos($cityhtml, '[{');
	$cityhtml = substr($cityhtml, $citypos);
	$cityarray = json_decode($cityhtml);
	
	foreach($cityarray[0]->TabList as $key => $listinfo)
	{
		foreach ($listinfo->CityList as $key=>$city)
		{
			$city_name = $city->CityNameCn;
			$city_en = $city->CityNameEn;
			
			$count = Table::Count('city', array('city_name'=>$city_name));
			if ($count>0) continue;
			
			$city_id = DB::Insert('city', array('city_name'=>$city_name, 'en_name'=>$city_en));
			echo $city_name ."&nbsp;&nbsp" . $city_id . "<BR>";
			ob_flush();
			flush();
		}
	}
?> 

