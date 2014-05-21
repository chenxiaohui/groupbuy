<?php
require_once(dirname(dirname(dirname(__FILE__))) . '/app.php');
require_once(dirname(__FILE__) . '/current.php');

need_manager();
need_auth('team');

$id = abs(intval($_GET['id']));
$team = $eteam = Table::Fetch('team', $id);
//获取全国的ID
if ( is_get() && empty($team) ) {//新建
	$team = array();
	$team['id'] = 0;
	$team['user_id'] = $login_user_id;
	$team['begin_time'] = strtotime('+1 days');
	$team['end_time'] = strtotime('+2 days'); 
	$team['expire_time'] = strtotime('+3 months +1 days');
	$team['min_number'] = 10;
	$team['per_number'] = 1;
	$team['market_price'] = 1;
	$team['team_price'] = 1;
	$team['delivery'] = 'coupon';
	$team['address'] = $profile['address'];
	$team['mobile'] = $profile['mobile'];
	$team['fare'] = 5;
	$team['farefree'] = 0;
	$team['bonus'] = abs(intval($INI['system']['invitecredit']));
	$team['conduser'] = $INI['system']['conduser'] ? 'Y' : 'N';
	$team['buyonce'] = 'Y';
	$team['tuanlei'] = 'N';
//	$team['display']=1;
}//打开
else if ( is_post() ) {
	
	$team = $_POST;
	//为了懒加载，写入的时候把src替换为original
	//$team['detail']= str_replace("src","src=\"http://www.shihewo.com/static/css/i/grey.gif\" original",$team['detail']);//结果
	
	//如果产品为空，默认为项目标题
	if(empty($team['product']))
		$team['product']=$team['title'];
	$insert = array(
		'title', 'market_price', 'team_price', 'end_time', 
		'begin_time', 'expire_time', 'min_number', 'max_number', 
		'summary', 'notice', 'per_number', 'product', 
		'image', 'image1', 'image2', 'flv', 'now_number',
		'detail', 'userreview', 'card', 'goldcoin', 'systemreview', 
		'conduser', 'buyonce', 'bonus', 'sort_order',
		'delivery', 'mobile', 'address', 'fare', 
		'express', 'credit', 'farefree', 'pre_number',
		'user_id', 'city_id', 'group_id', 'partner_id',
		'team_type', 'sort_order', 'farefree', 'state',
		'condbuy','express_relate','city_ids','guarantee_ids','display','excellent','tuanlei',
		'seo_title', 'seo_keyword', 'seo_description','telbook','goldbook',
		);

	$team['user_id'] = $login_user_id;
	$team['state'] = 'none';
	$team['begin_time'] = strtotime($team['begin_time']);
	
	$team['partner_id'] = abs(intval($team['partner_id']));
	$team['sort_order'] = abs(intval($team['sort_order']));
	$team['fare'] = abs(intval($team['fare']));
	$team['farefree'] = intval($team['farefree']);
	$team['display']=intval($team['display']);
	$team['tuanlei']=intval($team['tuanlei']);	
	$team['excellent']=intval($team['excellent']);
	$team['pre_number'] = abs(intval($team['pre_number']));
	$team['end_time'] = strtotime($team['end_time']);
	$team['expire_time'] = strtotime($team['expire_time']);
	$team['image'] = upload_image('upload_image',$eteam['image'],'team',true);
	$team['image1'] = upload_image('upload_image1',$eteam['image1'],'team');
	$team['image2'] = upload_image('upload_image2',$eteam['image2'],'team');
	$team['team_price'] = intval($_POST["adult_price0"]);
	
	/* 序列化选取的城市 */
	if(!in_array(1,$team['city_ids']))
		$team['city_ids'][]=1;
	if (!empty($team['city_ids'])) {
		$team['city_ids'] = '@'.implode('@', $team['city_ids']).'@';
	}else {
		Session::Set('notice', '请选择项目发布的城市');
		include template('manage_team_edit');
		return ;
	}
	/* 序列化选取的保障*/
	//if (!empty($team['guarantee_ids'])) {
		$team['guarantee_ids'] = '@'.implode('@', $team['guarantee_ids']).'@';
//	}else {
//		Session::Set('notice', '请选择项目的保障');
//		include template('manage_team_edit');
//		return ;
//	}
	
	/* 自定义快递价格 */
	$express_relate = $team['express_relate'];
	foreach ($express_relate as $k=>$v) {
		$e[$k]['id'] = $v;
		$e[$k]['price'] = $team["express_price_{$v}"];
	}
	$team['express_relate'] = serialize($e);

	//team_type == goods
	if($team['team_type'] == 'goods'){ 
		$team['min_number'] = 1; 
		$team['conduser'] = 'N';
	}

	if ( !$id ) {
		$team['now_number'] = $team['pre_number'];
	} else {
		$field = strtoupper($table->conduser)=='Y' ? null : 'quantity';
		$now_number = Table::Count('order', array(
					'team_id' => $id,
					'state' => 'pay',
					), $field);
		$team['now_number'] = ($now_number + $team['pre_number']);

		/* 增加了总数，未卖完状态 */
		if ( $team['max_number'] > $team['now_number'] ) {
			$team['close_time'] = 0;
			$insert[] = 'close_time';
		}

		/* update coupon */
		DB::Update('coupon', array('team_id' => $id), array(
			'expire_time' => $team['expire_time'],
		));
	}
	
	//分词部分
	if($team['id'])
	{
	$cws = scws_new();
	$cws->set_charset('utf8');
	$cws->set_duality(true);
	$cws->set_ignore(true);
	$words=getResult($team['title']);
	updateIndexes($words,$team['id']);
	$cws->close();
	}	
	//seo
	$team['seo_title']= $team['title'];
	$team['seo_keyword'] = trim(strip_tags($team['systemreview'])). " " . $INI['system']['seokeyword'];	
	$team['seo_description'] = str_replace('&nbsp;','',strip_tags($team['summary']));
	
	//编辑现有
	//dbx($team);
	$insert = array_unique($insert);	
	$table = new Table('team', $team);
	$table->SetStrip('detail', 'systemreview', 'notice');


	//
	if ( $team['id'] && $team['id'] == $id ) {//编辑，并且合法
		$table->SetPk('id', $id);
		$table->update($insert);//更新
		
		//程孟力 增加
		for ($i = 0; $i <$_POST["discountIndex"]; $i++)
		{
			if ($_POST["discountTag{$i}"] =="delete")
			{
				if ($_POST["discountId{$i}"] != -1)
				{
					DB::delete("discount", array("discountid"=> $_POST["discountId{$i}"]));
				}
				continue;	
			}
			$discount = array(
								 "teamId" => $team['id'],
								 "discountTag" =>$_POST["discountTag{$i}"], 
								 "discountPrice"=>$_POST["discountPrice{$i}"],
								 "discountDesc"=> $_POST["discountDesc{$i}"]);
			//var_dump($discount);	
			if ($_POST["discountId{$i}"] != -1)
				DB::Update("discount",$_POST["discountId{$i}"],$discount,  "discountid");
			else
				DB::insert("discount", $discount);			
		}
		//陈晓辉 仿程孟力 增加
			for ($i = 0; $i < $_POST["teampriceIndex"]; $i++)
		{
			if ($_POST["team_lang{$i}"] == "delete")
			{
				if(intval($_POST["teampriceId{$i}"]) != -1)
				{
					DB::delete("team_price", array("id"=>$_POST["teampriceId{$i}"]));
				}
				continue;
			}
			else
			{
				$teamprice = array(
					"team_id"=>$team["id"],
					"team_lang"=>$_POST["team_lang{$i}"],
					"hotellevel"=>$_POST["hotellevel{$i}"],
					"adult_price"=>$_POST["adult_price{$i}"],
					"child_price"=>$_POST["child_price{$i}"],
					"end_time"=>strtotime($_POST["end_time{$i}"]),
				);
		
				if (intval($_POST["teampriceId{$i}"]) != -1)
					echo 'succeed update' . DB::Update('team_price',$_POST["teampriceId{$i}"], $teamprice,  "id");
				else
					DB::Insert('team_price', $teamprice); 
				
			}
		}
		
		
		log_admin('team', '编辑team项目',$insert);
		Session::Set('notice', '编辑项目信息成功');
		redirect( WEB_ROOT . "/manage/team/index.php");
	} 
	else if ( $team['id'] ) {
		log_admin('team', '非法编辑team项目',$insert);
		Session::Set('error', '非法编辑');
		redirect( WEB_ROOT . "/manage/team/index.php");
	}
	
	
	
	$team['id'] = $table->insert($insert);
	if ( $team['id']) {
		//分词部分
		$cws = scws_new();
		$cws->set_charset('utf8');
		$cws->set_duality(true);
		$cws->set_ignore(true);
		if($team['id'])
			updateIndexes(getResult($team['title']),$team['id']);
		$cws->close();
		//程孟力 增加，插入儿童成人价格
		for ($i = 0; $i <$_POST["discountIndex"]; $i++)
		{
			if ($_POST["discountTag{$i}"] =="delete")
			{
				continue;
			}
			$discount = array(
								 "teamId" => $team['id'],
								 "discountTag" =>$_POST["discountTag{$i}"], 
								 "discountPrice"=>$_POST["discountPrice{$i}"],
								 "discountDesc"=> $_POST["discountDesc{$i}"]);	
				DB::insert("discount", $discount);			
		}
		//陈晓辉 仿程孟力 增加，插入价格展示，如住宿标准等
		for ($i = 0; $i < $_POST["teampriceIndex"]; $i++)
		{
			if ($_POST["team_lang{$i}"] == "delete")
			{
				continue;
			}
			$teamprice = array(
					"team_id"=>$team["id"],
					"team_lang"=>$_POST["team_lang{$i}"],
					"hotellevel"=>$_POST["hotellevel{$i}"],
					"adult_price"=>$_POST["adult_price{$i}"],
					"child_price"=>$_POST["child_price{$i}"]
				);
				DB::insert("team_price", $teamprice);	
		}
		
		log_admin('team', '新建team项目',$insert);
		Session::Set('notice', '新建项目成功');
		redirect( WEB_ROOT . "/manage/team/index.php");
	}
	else {
		log_admin('team', '新建team项目失败',$insert);
		Session::Set('error', '新建项目失败');
		redirect(null);
	}
}
//读取信息，把orginal替换成src，为了懒加载
//$team['detail']= str_replace("src=\"http://www.shihewo.com/static/css/i/grey.gif\" original","src",$team['detail']);//结果
//读取信息
$groups = DB::LimitQuery('category', array(
			'condition' => array( 'zone' => 'group', ),
			));
$groups = Utility::OptionArray($groups, 'id', 'name');

$partners = DB::LimitQuery('partner', array(
			'order' => 'ORDER BY id DESC',
			));
$partners = Utility::OptionArray($partners, 'id', 'title');
$selector = $team['id'] ? 'edit' : 'create';

/*读取优惠价格信息，如儿童优惠*/
if ($team['id'])
{
	$discount = db::LimitQuery('discount', array(
			'condition'=>array( 'teamId' => $team['id'])));
}
/*读取价格展示信息，如住宿标准*/
if ($team['id'])
{
	$teamprice= db::LimitQuery('team_price', array(
			'condition'=>array( 'team_id' => $team['id'])));
}

/* 快递公司信息 */
$express = db::LimitQuery('category',array(
			'condition' => array( 'zone' => 'express', 'display'=>'Y'),
			));
/* 快递公司信息 */
$express = db::LimitQuery('category',array(
			'condition' => array( 'zone' => 'express', 'display'=>'Y'),
			));
$relate = unserialize($team['express_relate']);
/* 合并订单快递和快递表快递数据 */
foreach ($relate as $k=>$v) {
	$ids[] = $v['id'];
	$data[$v['id']] = $v['price'];
}
foreach ($express as $k=>$v) {
	if (in_array($v['id'] , $ids)) {
		$express[$k]['relate_data'] = $data[$v['id']];
		$express[$k]['checked'] = 'checked';
	}
}
$allguarantees =option_category('guarantee',false,true);
//$allclasses=DB::LimitQuery('category', array(
//		'condition' => array('zone'=>'city','display'=>'Y','relate_data'=>'Y'),
//		'order' => 'ORDER BY ename ASC',
//		'cache'=>86400*30,
//		));
/* 反序列化城市信息 */
$city_ids = array_filter(explode('@', $team['city_ids']));
$guarantee_ids=array_filter(explode('@', $team['guarantee_ids']));
if(strchr($team['guarantee_ids'],'0'))
	$guarantee_ids[]=0;

include template('manage_team_edit');