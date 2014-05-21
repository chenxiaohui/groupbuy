<?php
	//echo preg_replace( '/(\d+\/\d+\/)$/i', '20110701/20110725', 'http://hotel.quna.com/detail/beijing/15/20110626/20110627/');
	//echo preg_replace('/(\d{4}-\d{1,2}-\d{1,2})(.+)(\d{4}-\d{1,2}-\d{1,2})/i',
	// "2011-07-02\${2}2011-07-03/",
	// 'http://www.super8.com.cn/FrontPageServlet?page=7005&PID=001006&menuID=001006004@POST@hotelId=251#rateCode=SRB#rmType=EK#arrDate=2011-06-27#depDate=2011-06-28#rmQty=1#nights=1#adults=1#rmRate=188.0#fullRate=0#brkfstDesc='	);
	//$str ='\n\n客房';
	//$str = str_replace(array('\n'), array(''), '\n\n客房');
	//echo $str;
	

// 从 URL 中取得主机名
preg_match("/^(http:\/\/)?([^\/]+)/i",
    "http://www.php.net/index.html", $matches);
$host = $matches[2];
var_dump($host);
// 从主机名中取得后面两段
preg_match("/[^\.\/]+\.[^\.\/]+$/", $host, $matches);
echo "domain name is: {$matches[0]}\n";
?> 
