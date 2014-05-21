<?php
	header("Content-type: text/html; charset=utf-8");
	//require_once(dirname(__FILE__) . '/app.php');	
	$html = file_get_contents('http://hotel.elong.com/detail_cn_30101098.html');
	$html = mb_convert_encoding($html, 'utf-8', mb_detect_encoding($html));
	$document = new DOMDocument();
	@$document->loadHTML($html);
	$xpath = new DOMXpath($document);
	$nodes = $xpath->query('//div');
	echo $nodes->length;