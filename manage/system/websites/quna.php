<?php 
$site=array(
	'name'=>'去哪网',//网站名
	'homepage'=>'www.quna.com',//网站地址
	'url'=>'http://hotel.quna.com/detail/$city/$id/20110626/20110627/',//搜索地址模板
	'param'=>array(
		'$city'=>array('beijing'),//模板参数和取值范围
		'$id'=>'expand(1,9371)',//expand函数可以生成取值范围
	),
	
	'xpath'=>array(
		'$hotel_name'=>array(
							'path'=>'//div[@class="JD_IFxititel"]/span',
							'attribute'=>'textContent',
							'func'=>'name_process($hotel_name)',//自定义函数
							),
		'$hotel_loc'=>array(
							'path'=>'//div[@class="JD_IFjeshao"]',
							'attribute'=>'textContent',
							'func'=>'loc_process($hotel_loc)',
							),
		'$hotel_desc'=>array(
							'path'=>'//div[@class="JD_IFjeshao"]',
							'attribute'=>'textContent',
							'func'=>'desc_process($hotel_desc)',
							),
	),
	'pricexpath' =>array(
		'room_type'=>array('path'=>array('//div[@id="tgs"]//div[@class="JD_Ispanf1"]'=>'textContent',
										'//div[@id="tgs"]//div[@class="JD_Ispanf7"]'=>'textContent')
							),
		'hotel_price' =>array('path'=>array('//div[@id="tgs"]//div[@class="JD_Ispanf5"]//span'=>'textContent')),
		'book_link' => array('path'=>
				array('//div[@id="tgs"]//div[@class="JD_Ispanf6"]//a'=>'attributes->getNamedItem(\'href\')->textContent . "@GET@"'))
	),
);

function name_process($hotel_name)//去掉右边简介两个字
{
	$hotel_name = trim($hotel_name, '\n\r\t ');
	$len=mb_strlen($hotel_name,'UTF-8');
	return mb_substr($hotel_name,0,$len-2,'UTF-8');
}
function loc_process($hotel_loc)//去掉右边简介两个字
{
	$hotel_loc = trim($hotel_loc, '\n\r\t ');
	$len=mb_strpos($hotel_loc,'。',0,'UTF-8');
	if($len > 280) $len = 280;
	return mb_substr($hotel_loc,0,$len+1,'UTF-8');
}
function desc_process($hotel_loc)//去掉右边简介两个字
{
	$hotel_loc = trim($hotel_loc, '\n\r\t ');
	$idx=mb_strpos($hotel_loc,'。',0,'UTF-8');
	$len=mb_strlen($hotel_loc,'UTF-8');
	if ($len - $idx > 280) $len = $idx + 280;
	return mb_substr($hotel_loc,$idx+1,$len-$idx,'UTF-8');
}


?>