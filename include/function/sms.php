<?php
function sms_send($phone, $content) {
	global $INI;
	if (mb_strlen($content, 'utf-8') < 20) {
		return '短信长度低于20汉字？长点吧～';
	}
	$user = $INI['sms']['user']; // sms9的cpid
	$pass = $INI['sms']['pass']; // sms9的密码
	$channelid = $INI['sms']['channelid']; // sms9的通道id
	if(null==$user) return true;
	$content = iconv("utf-8","gbk//ignore",$content);
	$content = urlencode($content);
	$api = "http://admin.sms9.net/houtai/sms.php?cpid={$user}&password={$pass}&channelid={$channelid}&tele={$phone}&msg={$content}";
	$res = utility::httprequest($api);
	return strpos(strval($res),'success') === false ? strval($res) : true;
}



function sms_coupon($coupon, $mobile=null) {
	global $INI;
	if ( $coupon['consume'] == 'Y' 
			|| $coupon['expire_time'] < strtotime(date('Y-m-d'))) {
		return $INI['system']['couponname'] . '已失效';
	}

	$user = Table::Fetch('user', $coupon['user_id']);
	$order = Table::Fetch('order', $coupon['order_id']);

	if (!Utility::IsMobile($mobile)) {
		$mobile = $order['mobile'];
		if (!Utility::IsMobile($mobile)) {
			$mobile= $user['mobile'];
		}
	}
	if (!Utility::IsMobile($mobile)) {
		return '请设置合法的手机号码，以便接受短信';
	}
	$team = Table::Fetch('team', $coupon['team_id']);
	$partner = Table::Fetch('partner', $coupon['partner_id']);

	$coupon['end'] = date('Y-n-j', $coupon['expire_time']);
	$coupon['name'] = $team['product'];
	$content = render('manage_tpl_smscoupon', array(
				'partner' => $partner,
				'coupon' => $coupon,
				'user' => $user,
				));

	if (true===($code=sms_send($mobile, $content))) {
		Table::UpdateCache('coupon', $coupon['id'], array(
					'sms' => array('`sms` + 1'),
					'sms_time' => time(),
					));
		return true;
	}
	return $code;
}

function sms_voucher($voucher, $mobile=null) {
	global $INI;
	$user = Table::Fetch('user', $voucher['user_id']);
	$order = Table::Fetch('order', $voucher['order_id']);

	if (!Utility::IsMobile($mobile)) {
		$mobile = $order['mobile'];
		if (!Utility::IsMobile($mobile)) {
			$mobile= $user['mobile'];
		}
	}
	if (!Utility::IsMobile($mobile)) {
		return '请设置合法的手机号码，以便接受短信';
	}

	$team = Table::Fetch('team', $voucher['team_id']);
	$partner = Table::Fetch('partner', $team['partner_id']);

	$voucher['end'] = date('Y-n-j', $team['expire_time']);
	$voucher['name'] = $team['product'];
	$content = render('manage_tpl_smsvoucher', array(
				'partner' => $partner,
				'voucher' => $voucher,
				'user' => $user,
				));

	if (true===($code=sms_send($mobile, $content))) {
		Table::UpdateCache('voucher', $voucher['id'], array(
					'sms' => array('`sms` + 1'),
					'sms_time' => time(),
					));
		return true;
	}
	return $code;
}

function sms_express($id, &$flag=null) {
	$order = Table::Fetch('order', $id);
	$team = Table::Fetch('team', $order['team_id']);
	if (!$order['express_id']) {
		$flag = 'No express';
		return false;
	}
	$express = Table::Fetch('category', $order['express_id']);
	$html = render('manage_tpl_smsexpress', array(
				'team' => $team,
				'express_name' => $express['name'],
				'express_no' => $order['express_no'],
				));
	$phone = $order['mobile'];
	if ( true === ($flag = sms_send($phone, $html)) ) {
		Table::UpdateCache('order', $id, array(
			'sms_express' => 'Y',
		));
		return true;
	}
	return false;
}
