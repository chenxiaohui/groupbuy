<?php 
$site=array(
	'name'=>'阳光旅行网',
	'homepage'=>'www.sunnychina.com',
	'url'=>'http://www.sunnychina.com/hotel/hotel_$id.html',
	'param'=>array(
		'$id'=>'expand(1,1)',
	),
	'xpath'=>array(
		'$hotel_name'=>array(
							'path'=>'//div[@class="ititle"]/h1/a',
							'func'=>'',//自定义函数
							),
		'$hotel_loc'=>array(
							'path'=>'//div[@id="infoleft"]/dl/dd[3]',
							'func'=>'',
							),
		'$hotel_desc'=>array(
							'path'=>'//dd[@class="tjianjie"]',
							'func'=>'',
							),
	),
	
);
function preprocess_document($html)
{
	$target ="<html><head><meta http-equiv=\"Content-Type\" content=\"text/html; charset=gb2312\"><title></title>"; 
	$head_pos = strpos($html, "</head>");
	
	if ($head_pos > 0)
	{
		$html = $target . substr($html, $head_pos);		
	}
	return $html;
}
?>