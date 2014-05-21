<?php
require_once(dirname(dirname(dirname(__FILE__))) . '/app.php');

need_manager();
$condition = array();

($zone = strval($_GET['zone'])) || ($zone = 'city');
if ( $zone ) { $condition['zone'] = $zone; }

$cates = get_zones();//当前是哪个分类

$count = Table::Count('category', $condition);//数量
list($pagesize, $offset, $pagestring) = pagestring($count, 20);

$categories = DB::LimitQuery('category', array(
	'condition' => $condition,
	'order' => 'ORDER BY display ASC, sort_order DESC, id DESC',
	'size' => $pagesize,
	'offset' => $offset,
));

include template('manage_category_index');
