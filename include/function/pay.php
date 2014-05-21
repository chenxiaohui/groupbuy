<?php
function pay_team_ipscardpay($total_money, $order)
{
	global $INI;
	/****************正式环境请更换以下信息***********************/
	//3DES密钥
	$DESkey = $INI['ipscardpay']['deskey'];
	//3DES向量
	$DESiv = $INI['ipscardpay']['desiv'];
	//商户的md5证书
	$MD5key = $INI['ipscardpay']['sec'];
	//商户的RSA公钥
	$RSAkey = $INI['ipscardpay']['rsasec'];
	/****************获取表单信息******************************/
	//商户号
	$pMerCode = $INI['ipscardpay']['mid'];
	//商户交易订单号
	$pBillNo = $order['pay_id'];
	//支付币种
	$pCurrency = 'RMB';
	//语种
	$pLang = 'GB';
	//订单金额(保留两位小数)
	$pAmount = number_format($total_money, 2, '.', '');
	//商户录入日期
	$pDate = date('Ymd',$order['create_time']);
	//信用卡种类  1：国内信用卡 2：国际信用卡
	$pGateWayType = 1;
	//商户附加信息
	$pAttach = '';
	//录入返回签名方式 11: md5withrsa 12: md5摘要
	$pRetEncodeType = 12;
	//订单有效期， 1个小时
	$pBillEXP = 1;
	//支付结果返回地址 
	$pReturnUrl = "{$INI['system']['wwwprefix']}/order/ipscardpay/return.php";
	//错误返回地址 
	$pErrorUrl = '';
	//订单加密方式(pCardInfo的加密方式) 1: rsa 2: 3des
	$pOrderEncodeType = 1;
	//支付结果返回方式：0 ( HTTP方式)  
	$pResultType = '0';
	//访问者权限 
	$pAuthority = '';
	//备用 
	$pDetails = '';
	//商品信息 
	$team = Table::Fetch('team',$order['team_id']);
	$pGoodsInfo = $team['title'];
	
	//md5的source
	$strMd5Temp = $pBillNo . $pMerCode . $pCurrency . $pAmount . $pDate . $MD5key;
	//md5的摘要
	$pSignMD5 = md5($strMd5Temp);

	//提交的信用卡支付网关的url地址(正式环境请更改为：https://gw5.ips.com.cn:444/B2C/AuthTrade/Pay.aspx)
	$form_url = 'http://payat.ips.net.cn/B2C/AuthTrade/Pay.aspx';
	
	$parameter = array(
	  'form_url' => $form_url,      'pBillNo' => $pBillNo, 	'pMerCode' => $pMerCode,
	  'pCurrency' => $pCurrency,	'pLang' => $pLang,		'pAmount' => $pAmount,
      'pDate' => $pDate,			'pAttach' => $pAttach,	'pGateWayType' => $pGateWayType,
	  'pRetEncodeType'=> $pRetEncodeType, 			'pOrderEncodeType' => $pOrderEncodeType, 
	'pSignMD5'=>$pSignMD5,		'pAuthority'=>$pAuthority, 	'pBillEXP'=>$pBillEXP,
	'pCardInfo'=>$pCardInfo,	'pResultType'=>$pResultType, 'pReturnUrl'=>$pReturnUrl,
	'pGoodsInfo'=>$pGoodsInfo, 'order_id'=>$order['id']
	);
	
	return render("block_pay_ipscardpay",$parameter);	
}
function pay_charge_ipscardpay($total_money, $charge_id, $title)
{
	global $INI;
	/****************正式环境请更换以下信息***********************/
	//3DES密钥
	$DESkey = $INI['ipscardpay']['deskey'];
	//3DES向量
	$DESiv = $INI['ipscardpay']['desiv'];
	//商户的md5证书
	$MD5key = $INI['ipscardpay']['sec'];
	//商户的RSA公钥
	$RSAkey = $INI['ipscardpay']['rsasec'];
	/****************获取表单信息******************************/
	//商户号
	$pMerCode = $INI['ipscardpay']['mid'];
	//商户交易订单号
	$pBillNo = $charge_id;
	//支付币种
	$pCurrency = 'RMB';
	//语种
	$pLang = 'GB';
	//订单金额(保留两位小数)
	$pAmount = number_format($total_money, 2, '.', '');
	//商户录入日期
	$pDate = date('Ymd');
	//信用卡种类  1：国内信用卡 2：国际信用卡
	$pGateWayType = 1;
	//商户附加信息
	$pAttach = '';
	//录入返回签名方式 11: md5withrsa 12: md5摘要
	$pRetEncodeType = 12;
	//订单有效期， 1个小时
	$pBillEXP = 1;
	//支付结果返回地址 
	$pReturnUrl = "{$INI['system']['wwwprefix']}/order/ipscardpay/return.php";
	//错误返回地址 
	$pErrorUrl = '';
	//订单加密方式(pCardInfo的加密方式) 1: rsa 2: 3des
	$pOrderEncodeType = 1;
	//支付结果返回方式：0 ( HTTP方式)  
	$pResultType = '0';
	//访问者权限 
	$pAuthority = '';
	//备用 
	$pDetails = '';
	//商品信息 
	$pGoodsInfo = $title;
	
	//md5的source
	$strMd5Temp = $pBillNo . $pMerCode . $pCurrency . $pAmount . $pDate . $MD5key;
	//md5的摘要
	$pSignMD5 = md5($strMd5Temp);

	//提交的信用卡支付网关的url地址(正式环境请更改为：https://gw5.ips.com.cn:444/B2C/AuthTrade/Pay.aspx)
	//$form_url = 'http://payat.ips.net.cn/B2C/AuthTrade/Pay.aspx';
	$form_url = 'https://gw5.ips.com.cn:444/B2C/AuthTrade/Pay.aspx';
	
	$parameter = array(
	  'form_url' => $form_url,      'pBillNo' => $pBillNo, 	'pMerCode' => $pMerCode,
	  'pCurrency' => $pCurrency,	'pLang' => $pLang,		'pAmount' => $pAmount,
      'pDate' => $pDate,			'pAttach' => $pAttach,	'pGateWayType' => $pGateWayType,
	  'pRetEncodeType'=> $pRetEncodeType, 			'pOrderEncodeType' => $pOrderEncodeType, 
	'pSignMD5'=>$pSignMD5,		'pAuthority'=>$pAuthority, 	'pBillEXP'=>$pBillEXP,
	'pCardInfo'=>$pCardInfo,	'pResultType'=>$pResultType, 'pReturnUrl'=>$pReturnUrl,
	'pGoodsInfo'=>$pGoodsInfo, 'order_id'=>'charge'
	);
	
	return render("block_pay_ipscardpay",$parameter);	
}
/* payment: ipspay 环讯支付*/
function pay_team_ipspay($total_money, $order){
	global $INI;
	if($total_money<=0||!order) return null;
	$team = Table::Fetch('team', $order['team_id']);
	$order_id = $order['id'];
	$pay_id = $order['pay_id'];

	
	//提交地址
	$form_url = 'https://pay.ips.com.cn/ipayment.aspx'; //正式

	$parameter = array(
		'form_url' => $form_url,
		//商户号
		'Mer_code' => $INI['ipspay']['mid'], //$INI['ipspay']['mid'],

	//商户证书：登陆http://merchant.ips.com.cn/商户后台下载的商户证书内容
	 'Mer_key' => $INI['ipspay']['sec'],

	//商户订单编号
	'Billno' =>  $order['pay_id'],

	//订单金额(保留2位小数)
	'Amount' => number_format($total_money, 2, '.', ''),

	//订单日期
	'Date' => date('Ymd',$order['create_time']),

	//币种
	'Currency_Type' => 'RMB',

	//支付卡种
	'Gateway_Type' => '01',

	//语言
	'Lang' => 'GB',

	//支付结果成功返回的商户URL
	'Merchanturl' => $INI['system']['wwwprefix'] . '/order/ipspay/return.php',

	//支付结果失败返回的商户URL
	'FailUrl' => '',

	//支付结果错误返回的商户URL
	'ErrorUrl' => '',

	//商户数据包
	'Attach' => $order['title'],

	//显示金额
	'DispAmount' => $total_money,

	//订单支付接口加密方式  md5加密
	'OrderEncodeType' =>2,

	//交易返回接口加密方式 
	'RetEncodeType' => 12,

	//返回方式
	'Rettype' => 1,

	//Server to Server 返回页面URL
	'ServerUrl' => $INI['system']['wwwprefix'] . '/order/ipspay/ServerReturn.php',

	'order_id' =>$order['id'],
	
	);
	//订单支付接口的Md5摘要，原文=订单号+金额+日期+支付币种+商户证书 
	$parameter['SignMD5'] = MD5($parameter['Billno'] . $parameter['Amount'] . $parameter['Date'] . $parameter['Currency_Type'] . $parameter['Mer_key']);
	return render("block_pay_ipspay",$parameter);
}

function pay_charge_ipspay($total_money, $charge_id, $title) {
	global $INI; 
	if($total_money<=0||!$title) return null;

	//提交地址
	$form_url = 'https://pay.ips.com.cn/ipayment.aspx'; //正式

	$parameter = array(
		'form_url' => $form_url,	
		'Mer_code' => $INI['ipspay']['mid'], //$INI['ipspay']['mid'],  //商户号
		'Mer_key' => $INI['ipspay']['sec'],							   //商户证书
		'Billno' =>  $charge_id,										//商户订单编号
		'Amount' => number_format($total_money, 2, '.', ''),    		//订单金额(保留2位小数)
		'Date' => date('Ymd'),    				//订单日期
		'Currency_Type' => 'RMB',        								//币种
		'Gateway_Type' => '01',      									//支付卡种
		'Lang' => 'GB',   												//语言
		'Merchanturl' => $INI['system']['wwwprefix'] . '/order/ipspay/return.php', //支付结果成功返回的商户URL
		'FailUrl' => $INI['system']['wwwprefix'] . '/order/ipspay/return.php',     //支付结果失败返回的商户URL
		'ErrorUrl' => $INI['system']['wwwprefix'] . '/order/ipspay/return.php',    //支付结果错误返回的商户URL
		'Attach' => $title,             //商户数据包 
		'DispAmount' => $total_money,  //显示金额
		'OrderEncodeType' =>2,   	   //订单支付接口加密方式  md5加密
		'RetEncodeType' => 12,  	   //交易返回接口加密方式 
		'Rettype' => 1,                //返回方式
		'ServerUrl' => '',				//Server to Server 返回页面URL
		'order_id' => 'charge',
	);
	//订单支付接口的Md5摘要，原文=订单号+金额+日期+支付币种+商户证书 
	$parameter['SignMD5'] = MD5($parameter['Billno'] . $parameter['Amount'] . $parameter['Date'] . $parameter['Currency_Type'] . $parameter['Mer_key']);
	return render("block_pay_ipspay",$parameter);
}
/* payment: alipay */
function pay_team_alipay($total_money, $order) {
	global $INI; if($total_money<=0||!$order) return null;
	$team = Table::Fetch('team', $order['team_id']);
	$order_id = $order['id'];
	$pay_id = $order['pay_id'];
	$guarantee = strtoupper($INI['alipay']['guarantee'])=='Y';

	/* param */
	$_input_charset = 'utf-8';
	$service = $guarantee ? 'create_partner_trade_by_buyer' : 'create_direct_pay_by_user';
	$partner = $INI['alipay']['mid'];
	$security_code = $INI['alipay']['sec'];
	$seller_email = $INI['alipay']['acc'];
	$itbpay = strval($INI['alipay']['itbpay']);

	$sign_type = 'MD5';
	$out_trade_no = $pay_id;

	$return_url = $INI['system']['wwwprefix'] . '/order/alipay/return.php';
	$notify_url = $INI['system']['wwwprefix'] . '/order/alipay/notify.php';
	$show_url = $INI['system']['wwwprefix'] . "/team.php?id={$team['id']}";
	$show_url = obscure_rep($show_url);

	$subject = mb_substr(strip_tags($team['title']),0,128,'UTF-8');
	$body = $show_url;
	$quantity = $order['quantity'];

	$parameter = array(
			"service"         => $service,
			"partner"         => $partner,      
			"return_url"      => $return_url,  
			"notify_url"      => $notify_url, 
			"_input_charset"  => $_input_charset, 
			"subject"         => $subject,  	 
			"body"            => $body,     	
			"out_trade_no"    => $out_trade_no,
			"payment_type"    => "1",
			"show_url"        => $show_url,
			"seller_email"    => $seller_email,  
			);

	if ($guarantee) {
		$parameter['price'] = $total_money;
		$parameter['quantity'] = 1;
		$parameter['logistics_fee'] = '0.00';
		$parameter['logistics_type'] = 'EXPRESS';
		$parameter['logistics_payment'] = 'SELLER_PAY';
	} else {
		$parameter["total_fee"] = $total_money;
	}

	if ($itbpay) $parameter['it_b_pay'] = $itbpay;
	$alipay = new AlipayService($parameter, $security_code, $sign_type);
	$sign = $alipay->Get_Sign();
	$reqUrl = $alipay->create_url();

	return render('block_pay_alipay', array(
				'order_id' => $order_id,
				'reqUrl' => $reqUrl,
				));
}

function pay_charge_alipay($total_money, $charge_id, $title) {
	global $INI; if($total_money<=0||!$title) return null;
	$order_id = 'charge';

	/* param */
	$_input_charset = 'utf-8';
	$service = 'create_direct_pay_by_user';
	$partner = $INI['alipay']['mid'];
	$security_code = $INI['alipay']['sec'];
	$seller_email = $INI['alipay']['acc'];
	$itbpay = strval($INI['alipay']['itbpay']);

	$sign_type = 'MD5';
	$out_trade_no = $charge_id;

	$return_url = $INI['system']['wwwprefix'] . '/order/alipay/return.php';
	$notify_url = $INI['system']['wwwprefix'] . '/order/alipay/notify.php';
	$show_url = $INI['system']['wwwprefix'] . "/credit/index.php";

	$subject = $title;
	$body = $show_url;
	$quantity = 1;

	$parameter = array(
			"service"         => $service,
			"partner"         => $partner,      
			"return_url"      => $return_url,  
			"notify_url"      => $notify_url, 
			"_input_charset"  => $_input_charset, 
			"subject"         => $subject,  	 
			"body"            => $body,     	
			"out_trade_no"    => $out_trade_no,
			"total_fee"       => $total_money,  
			"payment_type"    => "1",
			"show_url"        => $show_url,
			"seller_email"    => $seller_email,  
			);
	if ($itbpay) $parameter['it_b_pay'] = $itbpay;
	$alipay = new AlipayService($parameter, $security_code, $sign_type);
	$sign = $alipay->Get_Sign();
	$reqUrl = $alipay->create_url();

	return render('block_pay_alipay', array(
				'order_id' => $order_id,
				'reqUrl' => $reqUrl,
				));
}

/* payment: tenpay */
function pay_team_tenpay($total_money, $order) {
	global $INI; if($total_money<=0||!$order) return null;
	$team = Table::Fetch('team', $order['team_id']);
	$order_id = $order['id'];

	$v_mid = $INI['tenpay']['mid'];
	$v_url = $INI['system']['wwwprefix']. '/order/tenpay/return.php';
	$key   = $INI['tenpay']['sec'];
	$v_oid = $order['pay_id'];
	$v_amount = intval($total_money * 100);
	$v_moneytype = $INI['system']['currencyname'];
	$text = $v_amount.$v_moneytype.$v_oid.$v_mid.$v_url.$key;

	/* must */
	$sp_billno = $v_oid;
	$transaction_id = $v_mid. date('Ymd'). date('His') .rand(1000,9999);
	$desc = mb_convert_encoding($team['title'], 'GBK', 'UTF-8');
	/* end */

	$reqHandler = new PayRequestHandler();
	$reqHandler->init();
	$reqHandler->setKey($key);
	$reqHandler->setParameter("bargainor_id", $v_mid);
	$reqHandler->setParameter("cs", "GBK");
	$reqHandler->setParameter("sp_billno", $sp_billno);
	$reqHandler->setParameter("transaction_id", $transaction_id);
	$reqHandler->setParameter("total_fee", $v_amount);
	$reqHandler->setParameter("return_url", $v_url);
	$reqHandler->setParameter("desc", $desc);
	$reqHandler->setParameter("spbill_create_ip", Utility::GetRemoteIp());
	$reqUrl = $reqHandler->getRequestURL();

	if($_POST['paytype']!='tenpay') {
		$reqHandler->setParameter('bank_type', pay_getqqbank($_POST['paytype']));
		$reqUrl = $reqHandler->getRequestURL();
		redirect( $reqUrl );
	}

	return render('block_pay_tenpay', array(
				'order_id' => $order_id,
				'reqUrl' => $reqUrl,
				));
}

function pay_charge_tenpay($total_money, $charge_id, $title) {
	global $INI; if($total_money<=0||!$title) return null;
	$order_id = 'charge';

	$v_mid = $INI['tenpay']['mid'];
	$v_url = $INI['system']['wwwprefix']. '/order/tenpay/return.php';
	$key   = $INI['tenpay']['sec'];
	$v_oid = $charge_id;
	$v_amount = intval($total_money * 100);
	$v_moneytype = $INI['system']['currencyname'];
	$text = $v_amount.$v_moneytype.$v_oid.$v_mid.$v_url.$key;

	/* must */
	$sp_billno = $v_oid;
	$transaction_id = $v_mid. date('Ymd'). date('His') .rand(1000,9999);
	$desc = mb_convert_encoding($title, 'GBK', 'UTF-8');
	/* end */

	$reqHandler = new PayRequestHandler();
	$reqHandler->init();
	$reqHandler->setKey($key);
	$reqHandler->setParameter("bargainor_id", $v_mid);
	$reqHandler->setParameter("cs", "GBK");
	$reqHandler->setParameter("sp_billno", $sp_billno);
	$reqHandler->setParameter("transaction_id", $transaction_id);
	$reqHandler->setParameter("total_fee", $v_amount);
	$reqHandler->setParameter("return_url", $v_url);
	$reqHandler->setParameter("desc", $desc);
	$reqHandler->setParameter("spbill_create_ip", Utility::GetRemoteIp());
	$reqUrl = $reqHandler->getRequestURL();

	if($_POST['paytype']!='tenpay') {
		$reqHandler->setParameter('bank_type', pay_getqqbank($_POST['paytype']));
		$reqUrl = $reqHandler->getRequestURL();
		redirect( $reqUrl );
	}

	return render('block_pay_tenpay', array(
				'order_id' => $order_id,
				'reqUrl' => $reqUrl,
				));
}

/* payment: chinabank */
function pay_team_chinabank($total_money, $order) {
	global $INI; if($total_money<=0||!$order) return null;
	$team = Table::Fetch('team', $order['team_id']);
	$order_id = $order['id'];

	$v_mid = $INI['chinabank']['mid'];
	$v_url = $INI['system']['wwwprefix']. '/order/chinabank/return.php';
	$key   = $INI['chinabank']['sec'];
	$v_oid = $order['pay_id'];
	$v_amount = $total_money;
	$v_moneytype = $INI['system']['currencyname'];
	$text = $v_amount.$v_moneytype.$v_oid.$v_mid.$v_url.$key;
	$v_md5info = strtoupper(md5($text));

	return render('block_pay_chinabank', array(
				'order_id' => $order_id,
				'v_mid' => $v_mid,
				'v_url' => $v_url,
				'key' => $key,
				'v_oid' => $v_oid,
				'v_moneytype' => $v_moneytype,
				'v_md5info' => $v_md5info,
				));
}

function pay_charge_chinabank($total_money, $charge_id, $title) {
	global $INI; if($total_money<=0||!$title) return null;

	$order_id = 'charge';
	$v_mid = $INI['chinabank']['mid'];
	$v_url = $INI['system']['wwwprefix']. '/order/chinabank/return.php';
	$key   = $INI['chinabank']['sec'];
	$v_oid = $charge_id;
	$v_amount = $total_money;
	$v_moneytype = $INI['system']['currencyname'];
	$text = $v_amount.$v_moneytype.$v_oid.$v_mid.$v_url.$key;
	$v_md5info = strtoupper(md5($text));

	return render('block_pay_chinabank', array(
				'order_id' => $order_id,
				'v_mid' => $v_mid,
				'v_url' => $v_url,
				'key' => $key,
				'v_oid' => $v_oid,
				'v_moneytype' => $v_moneytype,
				'v_md5info' => $v_md5info,
				));
}

/* payment: bill */
function pay_team_bill($total_money, $order) {
	global $INI, $login_user; if($total_money<=0||!$order) return null;
	$team = Table::Fetch('team', $order['team_id']);

	$order_id = $order['id'];
	$merchantAcctId = $INI['bill']['mid'];	
	$key = $INI['bill']['sec']; 
	$inputCharset = "1";
	$pageUrl = $INI['system']['wwwprefix'] . '/order/bill/return.php';
	$bgUrl = $INI['system']['wwwprefix'] . '/order/bill/return.php';
	$version = "v2.0";
	$language = "1";
	$signType = "1";	
	$payerName = $login_user['username'];
	$payerContactType = "1";	
	$payerContact = $login_user['email'];	
	$orderId = $order['pay_id'];
	$orderAmount = intval($total_money * 100);
	$orderTime = date('YmdHis');
	$productName = mb_substr(strip_tags($team['title']),0,255,'UTF-8');
	$productNum="1";
	$productId="";
	$productDesc="";
	$ext1="";
	$ext2="";
	$payType="00";
	$bankId="";
	$redoFlag="0";
	$pid=""; 

	$sv = billAppendParam($sv,"inputCharset",$inputCharset);
	$sv = billAppendParam($sv,"pageUrl",$pageUrl);
	$sv = billAppendParam($sv,"bgUrl",$bgUrl);
	$sv = billAppendParam($sv,"version",$version);
	$sv = billAppendParam($sv,"language",$language);
	$sv = billAppendParam($sv,"signType",$signType);
	$sv = billAppendParam($sv,"merchantAcctId",$merchantAcctId);
	$sv = billAppendParam($sv,"payerName",$payerName);
	$sv = billAppendParam($sv,"payerContactType",$payerContactType);
	$sv = billAppendParam($sv,"payerContact",$payerContact);
	$sv = billAppendParam($sv,"orderId",$orderId);
	$sv = billAppendParam($sv,"orderAmount",$orderAmount);
	$sv = billAppendParam($sv,"orderTime",$orderTime);
	$sv = billAppendParam($sv,"productName",$productName);
	$sv = billAppendParam($sv,"productNum",$productNum);
	$sv = billAppendParam($sv,"productId",$productId);
	$sv = billAppendParam($sv,"productDesc",$productDesc);
	$sv = billAppendParam($sv,"ext1",$ext1);
	$sv = billAppendParam($sv,"ext2",$ext2);
	$sv = billAppendParam($sv,"payType",$payType);	
	$sv = billAppendParam($sv,"bankId",$bankId);
	$sv = billAppendParam($sv,"redoFlag",$redoFlag);
	$sv = billAppendParam($sv,"pid",$pid);
	$sv = billAppendParam($sv,"key",$key);
	$signMsg= strtoupper(md5($sv));

	return render('block_pay_bill', array(
				'order_id' => $order_id,
				'merchantAcctId' => $merchantAcctId,
				'key' => $key,
				'inputCharset' => $inputCharset,
				'pageUrl' => $pageUrl,
				'bgUrl' => $bgUrl,
				'version' => $version,
				'language' => $language,
				'signType' => $signType,
				'payerName' => $payerName,
				'payerContactType' => $payerContactType,
				'payerContact' => $payerContact,
				'orderId' => $orderId,
				'orderAmount' => $orderAmount,
				'orderTime' => $orderTime,
				'productName' => $productName,
				'productNum' => $productNum,
				'productId' => $productId,
				'productDesc' => $productDesc,
				'ext1' => $ext1,
				'ext2' => $ext2,
				'payType' => $payType,
				'bankId' => $bankId,
				'redoFlag' => $redoFlag,
				'pid' => $pid,
				'signMsg' => $signMsg,
				));
}

function pay_charge_bill($total_money, $charge_id, $title) {
	global $INI, $login_user; if($total_money<=0||!$title) return null;

	$order_id = 'charge';
	$merchantAcctId = $INI['bill']['mid'];	
	$key = $INI['bill']['sec']; 
	$inputCharset = "1";
	$pageUrl = $INI['system']['wwwprefix'] . '/order/bill/return.php';
	$bgUrl = $INI['system']['wwwprefix'] . '/order/bill/return.php';
	$version = "v2.0";
	$language = "1";
	$signType = "1";	
	$payerName = $login_user['username'];
	$payerContactType = "1";	
	$payerContact = $login_user['email'];	
	$orderId = $charge_id;
	$orderAmount = intval($total_money * 100);
	$orderTime = date('YmdHis');
	$productName = mb_substr(strip_tags($title),0,255,'UTF-8');
	$productNum="1";
	$productId="";
	$productDesc="";
	$ext1="";
	$ext2="";
	$payType="00";
	$bankId="";
	$redoFlag="0";
	$pid=""; 

	$sv = billAppendParam($sv,"inputCharset",$inputCharset);
	$sv = billAppendParam($sv,"pageUrl",$pageUrl);
	$sv = billAppendParam($sv,"bgUrl",$bgUrl);
	$sv = billAppendParam($sv,"version",$version);
	$sv = billAppendParam($sv,"language",$language);
	$sv = billAppendParam($sv,"signType",$signType);
	$sv = billAppendParam($sv,"merchantAcctId",$merchantAcctId);
	$sv = billAppendParam($sv,"payerName",$payerName);
	$sv = billAppendParam($sv,"payerContactType",$payerContactType);
	$sv = billAppendParam($sv,"payerContact",$payerContact);
	$sv = billAppendParam($sv,"orderId",$orderId);
	$sv = billAppendParam($sv,"orderAmount",$orderAmount);
	$sv = billAppendParam($sv,"orderTime",$orderTime);
	$sv = billAppendParam($sv,"productName",$productName);
	$sv = billAppendParam($sv,"productNum",$productNum);
	$sv = billAppendParam($sv,"productId",$productId);
	$sv = billAppendParam($sv,"productDesc",$productDesc);
	$sv = billAppendParam($sv,"ext1",$ext1);
	$sv = billAppendParam($sv,"ext2",$ext2);
	$sv = billAppendParam($sv,"payType",$payType);	
	$sv = billAppendParam($sv,"bankId",$bankId);
	$sv = billAppendParam($sv,"redoFlag",$redoFlag);
	$sv = billAppendParam($sv,"pid",$pid);
	$sv = billAppendParam($sv,"key",$key);
	$signMsg= strtoupper(md5($sv));

	return render('block_pay_bill', array(
				'order_id' => $order_id,
				'merchantAcctId' => $merchantAcctId,
				'key' => $key,
				'inputCharset' => $inputCharset,
				'pageUrl' => $pageUrl,
				'bgUrl' => $bgUrl,
				'version' => $version,
				'language' => $language,
				'signType' => $signType,
				'payerName' => $payerName,
				'payerContactType' => $payerContactType,
				'payerContact' => $payerContact,
				'orderId' => $orderId,
				'orderAmount' => $orderAmount,
				'orderTime' => $orderTime,
				'productName' => $productName,
				'productNum' => $productNum,
				'productId' => $productId,
				'productDesc' => $productDesc,
				'ext1' => $ext1,
				'ext2' => $ext2,
				'payType' => $payType,
				'bankId' => $bankId,
				'redoFlag' => $redoFlag,
				'pid' => $pid,
				'signMsg' => $signMsg,
				));
}

/* payment: paypal */
function pay_team_paypal($total_money, $order) {
	global $INI, $login_user; if($total_money<=0||!$order) return null;
	$team = Table::Fetch('team', $order['team_id']);
	
	$order_id = $order['id'];
	$cmd = '_xclick';
	$business = $INI['paypal']['mid'];
	$location = $INI['paypal']['loc'];
	$currency_code = $INI['system']['currencyname'];

	$item_number = $order['pay_id'];
	$item_name = $team['title'];
	$amount = $total_money;
	$quantity = 1;

	$post_url = "https://www.paypal.com/row/cgi-bin/webscr";
	$return_url = $INI['system']['wwwprefix'] . '/order/index.php';
	$notify_url = $INI['system']['wwwprefix'] . '/order/paypal/ipn.php';
	$cancel_url = $INI['system']['wwwprefix'] . "/order/index.php";

	return render('block_pay_paypal', array(
				'order_id' => $order_id,
				'cmd' => $cmd,
				'business' => $business,
				'location' => $location,
				'currency_code' => $currency_code,
				'item_number' => $item_number,
				'item_name' => $item_name,
				'amount' => $amount,
				'quantity' => $quantity,
				'post_url' => $post_url,
				'return_url' => $return_url,
				'notify_url' => $notify_url,
				'cancel_url' => $cancel_url,
				'login_user' => $login_user,
				));
}

function pay_charge_paypal($total_money, $charge_id, $title) {
	global $INI, $login_user; if($total_money<=0||!$title) return null;

	$order_id = 'charge';
	$cmd = '_xclick';
	$business = $INI['paypal']['mid'];
	$location = $INI['paypal']['loc'];
	$currency_code = $INI['system']['currencyname'];

	$item_number = $charge_id;
	$item_name = $title;
	$amount = $total_money;
	$quantity = 1;

	$post_url = "https://www.paypal.com/row/cgi-bin/webscr";
	$return_url = $INI['system']['wwwprefix'] . '/order/index.php';
	$notify_url = $INI['system']['wwwprefix'] . '/order/paypal/ipn.php';
	$cancel_url = $INI['system']['wwwprefix'] . "/order/index.php";

	return render('block_pay_paypal', array(
				'order_id' => $order_id,
				'cmd' => $cmd,
				'business' => $business,
				'location' => $location,
				'currency_code' => $currency_code,
				'item_number' => $item_number,
				'item_name' => $item_name,
				'amount' => $amount,
				'quantity' => $quantity,
				'post_url' => $post_url,
				'return_url' => $return_url,
				'notify_url' => $notify_url,
				'cancel_url' => $cancel_url,
				'login_user' => $login_user,
				));
}

/* payment: yeepay */
function pay_team_yeepay($total_money, $order) {
	global $INI, $login_user; if($total_money<=0||!$order) return null;
	$team = Table::Fetch('team', $order['team_id']);
	require_once( WWW_ROOT . '/order/yeepay/yeepayCommon.php');

	$order_id = $order['id'];
	$pay_id = $order['pay_id'];
	$p0_Cmd = 'Buy';
	$p1_MerId = $INI['yeepay']['mid'];
	$p2_Order = $pay_id;
	$p3_Amt = $total_money;
	$p4_Cur = "CNY";
	$p5_Pid = "ZuituGo-{$_SERVER['HTTP_HOST']}({$team['id']})";
	$p6_Pcat = '';
	$p5_Pdesc = "ZuituGo-{$_SERVER['HTTP_HOST']}({$team['id']})";
	$p8_Url = $INI['system']['wwwprefix'] . '/order/yeepay/callback.php';
	$p9_SAF = '0';
	$pa_MP = '';
	$pd_FrpId = strval($_REQUEST['pd_FrpId']);
	$pr_NeedResponse = '1';
	$merchantKey = $INI['yeepay']['sec'];

	$hmac = getReqHmacString($p1_MerId,$p2_Order,$p3_Amt,$p4_Cur,$p5_Pid,$p6_Pcat,$p7_Pdesc,$p8_Url,$pa_MP,$pd_FrpId,$pr_NeedResponse,$merchantKey);

	return render('block_pay_yeepay', array(
				'order_id' => $order_id,
				'p0_Cmd' => $p0_Cmd,
				'p1_MerId' => $p1_MerId,
				'p2_Order' => $p2_Order,
				'p3_Amt' => $p3_Amt,
				'p4_Cur' => $p4_Cur,
				'p5_Pid' => $p5_Pid,
				'p6_Pcat' => $p6_Pcat,
				'p7_Pdesc' => $p7_Pdesc,
				'p8_Url' => $p8_Url,
				'p9_SAF' => $p9_SAF,
				'pa_MP' => $pa_MP,
				'pd_FrpId' => $pd_FrpId,
				'pr_NeedResponse' => $pr_NeedResponse,
				'merchantKey' => $merchantKey,
				'hmac' => $hmac,
				));
}

function pay_charge_yeepay($total_money, $charge_id, $title) {
	global $INI, $login_user; if($total_money<=0||!$title) return null;
	require_once( WWW_ROOT . '/order/yeepay/yeepayCommon.php');

	$order_id = 'charge';
	$p0_Cmd = 'Buy';
	$p1_MerId = $INI['yeepay']['mid'];
	$p2_Order = $charge_id;
	$p3_Amt = $total_money;
	$p4_Cur = "CNY";
	$p5_Pid = "ZuituGo-Charge({$total_money})";
	$p6_Pcat = '';
	$p5_Pdesc = "ZuituGo-Charge({$total_money})";
	$p8_Url = $INI['system']['wwwprefix'] . '/order/yeepay/callback.php';
	$p9_SAF = '0';
	$pa_MP = '';
	$pd_FrpId = strval($_REQUEST['pd_FrpId']);
	$pr_NeedResponse = '1';
	$merchantKey = $INI['yeepay']['sec'];

	$hmac = getReqHmacString($p1_MerId,$p2_Order,$p3_Amt,$p4_Cur,$p5_Pid,$p6_Pcat,$p7_Pdesc,$p8_Url,$pa_MP,$pd_FrpId,$pr_NeedResponse,$merchantKey);

	return render('block_pay_yeepay', array(
				'order_id' => $order_id,
				'p0_Cmd' => $p0_Cmd,
				'p1_MerId' => $p1_MerId,
				'p2_Order' => $p2_Order,
				'p3_Amt' => $p3_Amt,
				'p4_Cur' => $p4_Cur,
				'p5_Pid' => $p5_Pid,
				'p6_Pcat' => $p6_Pcat,
				'p7_Pdesc' => $p7_Pdesc,
				'p8_Url' => $p8_Url,
				'p9_SAF' => $p9_SAF,
				'pa_MP' => $pa_MP,
				'pd_FrpId' => $pd_FrpId,
				'pr_NeedResponse' => $pr_NeedResponse,
				'merchantKey' => $merchantKey,
				'hmac' => $hmac,
				));
}

/* pay util function */
function billAppendParam($s, $k, $v){
	$joinstring = $s ? '&' : null;
	return $v=='' ? $s : "{$s}{$joinstring}{$k}={$v}";
}
