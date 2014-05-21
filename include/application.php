<?php
/* for rewrite or iis rewrite */
if (isset($_SERVER['HTTP_X_ORIGINAL_URL'])) {
	$_SERVER['REQUEST_URI'] = $_SERVER['HTTP_X_ORIGINAL_URL'];
} else if (isset($_SERVER['HTTP_X_REWRITE_URL'])) {
	$_SERVER['REQUEST_URI'] = $_SERVER['HTTP_X_REWRITE_URL'];
}
/* end */

error_reporting(E_ALL^E_WARNING^E_NOTICE);
define('SYS_TIMESTART', microtime(true));
define('SYS_REQUEST', isset($_SERVER['REQUEST_URI']));
define('DIR_SEPERATOR', strstr(strtoupper(PHP_OS), 'WIN')?'\\':'/');
define('DIR_ROOT', str_replace('\\','/',dirname(__FILE__)));//tuan/include
define('DIR_LIBARAY', DIR_ROOT . '/library');//tuan/include/library
define('DIR_CLASSES', DIR_ROOT . '/classes');
define('DIR_COMPILED', DIR_ROOT . '/compiled');
define('DIR_TEMPLATE', DIR_ROOT . '/template');
define('DIR_FUNCTION', DIR_ROOT . '/function');
define('DIR_CONFIGURE', DIR_ROOT . '/configure');
define('SYS_MAGICGPC', get_magic_quotes_gpc());
define('SYS_PHPFILE', DIR_ROOT . '/configure/system.php');
define('WWW_ROOT', rtrim(dirname(DIR_ROOT),'/'));//tuan
define('IMG_ROOT', dirname(DIR_ROOT) . '/static');//tuan/static
define('ALLCITY', 1);//全国的id


/* encoding */
mb_internal_encoding('UTF-8');
/* end */

//如果找不到类自动加载类，从library或者classes
/* important function */
function __autoload($class_name) {
	$file_name = trim(str_replace('_','/',$class_name),'/').'.class.php';
	$file_path = DIR_LIBARAY. '/' . $file_name;
	if ( file_exists( $file_path ) ) {
		return require_once( $file_path );
	}
	$file_path = DIR_CLASSES. '/' . $file_name;
	if ( file_exists( $file_path ) ) {
		return require_once( $file_path );
	}
	return false;
}
//从function加载是import
function import($funcpre) {
	$file_path = DIR_FUNCTION. '/' . $funcpre . '.php'; 
	if (file_exists($file_path) ) {
		require_once( $file_path );
	}
}

/* json */
if (!function_exists('json_encode')){function json_encode($v){$js = new JsonService(); return $js->encode($v);}}
if (!function_exists('json_decode')){function json_decode($v,$t){$js = new JsonService($t?16:0); return $js->decode($v);}}
/* end json */

/* import */
import('template');
import('common');

/* ob_handler */
if(SYS_REQUEST){ ob_get_clean(); ob_start(); }
/* end ob */

///***
// * 调试函数
// * @param 
// * @return mixed
// ***/
//
//function dbx() {
//	echo '<pre>';
//	if(func_num_args()){
//		foreach (func_get_args() as $k => $v) {
//			echo "------- dbx $k -------<br/>";
//			print_r($v);
//			echo "<br/>";
//		}
//	};
//	echo '</pre>';
//}
//
//function dpx() {
//    echo '<pre>';
//	if(func_num_args()){
//		foreach (func_get_args() as $k => $v) {
//			echo "------- dbx $k -------<br/>";
//			var_dump($v);
//			echo "<br/>";
//		}
//	};
//    echo '</pre>';
//}
//
//function dbt() {
//    echo '<pre>';
//	if(func_num_args()){
//		foreach (func_get_args() as $k => $v) {
//			echo "------- dbx $k -------<br/>";
//			echo "<textarea cols=20 rows=6>";
//			print_r($v);
//			echo "</textarea>";
//			echo "<br/>";
//		}
//	};
//    echo '</pre>';
//}
//得到头部分类的城市，自己的函数
function current_classcategory() {
	$allprovinces=DB::LimitQuery('category', array(
		'condition' => array('zone' => 'province','display'=>'Y'),
		'order' => 'ORDER BY sort_order DESC',
		'cache'=>86400*30,
	));
	global $allcities;
	$allMaincities=array();
	$allclasses=array();
	foreach($allcities as $city)
	{
		if($city['display']=='Y')
		{
			if($city['relate_data']=='N')//主城市
				$allMaincities[]=$city;
			else 
				$allclasses[]=$city;
		}
	}
	
	$links=array();
	foreach($allprovinces as $province)
	{
		$linkprovince=array();//一个省的信息
		$linkprovince['name']=$province['name'];
		$linkprovince['letter']=$province['letter'];
		$linkprovince['city']=array();
		foreach($allMaincities as $city)
		{
//			if($city['id']==ALLCITY) continue;
			if($city['czone']==$province['ename'])//属于这个省
			{
				unset($linkcity);
				$linkcity['name']=$city['name'];
				$linkcity['ename']=$city['ename'];
				$linkcity['class']=array();
				foreach($allclasses as $class)
					{
						if($class['czone']==$city['ename'])//属于这个市
						{
							$linkclass=array(
							'id'=>$class['id'],
							'ename'=>$class['ename'],
							'name'=>$class['name'],
							);
							$linkcity['class'][]=$linkclass;//加入一个分类
						}
					}
				$linkprovince['city'][]=$linkcity;
			}
		}
		$links[]=$linkprovince;
	}
	
	return city_link($links);
}


//把分类输出，自己的函数
function city_link($links) {
	$html = '';
	
	
	foreach($links as $province) 
	{
		$html.='<div class="city_box"><div class="city_box_t"><b>'.$province['letter'].'</b>'.$province['name'].'</div>';
		$lineindex = 1;
		foreach($province['city'] as $city){
			{
				$html.='<table cellpadding="0" cellspacing="0" border="0" class="city_list_tab" width=100%><tr><td class="w"><a href="/city.php?ename='.$city['ename'].'" class="hotcity">'.$city['name'];
				if(count($province['city'] )>1 && $lineindex < count($province['city'])) //热卖团两行加线
					$stylename="line";
				else 
					$stylename="";
				$html.='</a></td><td class="r '.$stylename.'">';
				$lineindex++;
				$hasreturn=false;
				foreach($city['class'] as $class)
				{
					//if(!$hasreturn && mb_strpos($class['name'],"到"))//出现哪到哪旅游
//					{
//						$html.='<br/>';
//						$hasreturn=true;
//					}
					if($class['name']=="上海到北京旅游"||$class['name']=="上海到西安旅游")
					{
						$html.='<div class="aline"></div>';	
					}
					$html.='<a href="/city.php?ename='.$class['ename'].'" >'.$class['name'].'</a>';
				
				}
				$html.='</td></tr></table>';
			}
		}
		$html.='</div>';
		
	}	
	return $html;
}

function getGuarantee($ids)
{
	$html="";
	$allguarantees =option_category('guarantee',false,true);
	if (!empty($ids)) {
		$guarantee_ids=array_filter(explode('@', $ids));
	}
	foreach ($allguarantees as $n=>$guarantee)
	{
		if(in_array($n,$guarantee_ids))
			$html.='<div class="'.$guarantee['czone'].'"></div>';
	}
	return $html;
}

//得到分类，系统原来的函数
function current_teamcategory($gid='0') {
	global $city;
	$a = array(
			'/team/goods.php' => '所有',
			);
	foreach(option_hotcategory('group') AS $id=>$name) {
		$a["/team/goods.php?gid={$id}"] = $name;
	}
	$l = "/team/goods.php?gid={$gid}";
	if (!$gid) $l = "/team/goods.php";
	return current_link($l, $a, true);
}

//获取热门城市信息列表
function gethotcities($strcities) {
	global $allcities;
	$cityname=explode(',',$strcities);
	$hotcities=array();
	foreach($cityname as $name)
	{
		foreach($allcities as $city)
		{
			if($city['name']==$name)//找到
			{
				$hotcities[]=$city;
				break;
			}
		}
	}
	return $hotcities;
}

