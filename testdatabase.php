<?php
// 	require_once(dirname(__FILE__) . '/app.php');
// 	$str = '';
// 	$idx = 0;
// 	for($idx=0; $idx < 1000; $idx++)
// 		$str .= '你';
//
// 	$result = false;
// 	while (!$result)
// 	{
// 		$idx--;
//		$str = mb_substr($str, 0, $idx); 		
// 		$result = DB::Insert('test', array('name'=>$str));
// 	}
// 	echo $idx;

$grade = array("score" => array(70, 95, 70.0, 60, "70"),
               "name" => array("Zhang San", "Li Si", "Wang Wu",
                               "Zhao Liu", "Liu Qi"));
array_multisort($grade["score"], SORT_NUMERIC, SORT_DESC);//,
                // 将分数作为数值，由高到低排序
                //$grade["name"], SORT_STRING, SORT_ASC);
                // 将名字作为字符串，由小到大排序
var_dump($grade);
?> 
