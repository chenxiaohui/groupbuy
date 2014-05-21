<?php
class Ipscardpay{
	static function encrptCardInfo($cardHoldname, $cardHoldidtype, $cardHoldidnum, $cardHoldphone)
	{
		global $INI;
		$RSAkey = $INI['ipscardpay']['rsasec'];
		//目前使用非直连方式 持卡人姓名， 持卡人证件类型
		  $pCardInfo = $cardHoldname . '|' .
		               $cardHoldidtype . '|' .
		               $cardHoldidnum . '|' .
		               $cardHoldphone;
		               
		//RSA加密$pCardInfo
		require_once(dirname(dirname(__FILE__)) . '/function/rsa.function.php');
		//读取RSA公钥中的Modulus和Exponent
		$xml = new DOMDocument();
		$xml->loadXML($RSAkey);
		$Modulus = $xml->getElementsByTagName('Modulus')->item(0)->nodeValue;
		$Exponent = $xml->getElementsByTagName('Exponent')->item(0)->nodeValue;
		unset($xml);
		$publicKey = kimssl_pkey_get_public($Modulus, $Exponent);
		openssl_public_encrypt($pCardInfo, $pCardInfo, $publicKey);
		$pCardInfo = base64_encode($pCardInfo);
		openssl_free_key($publicKey);
		return $pCardInfo;	
	}
	
	static function postToipsGate()
	{
		if (isset($_POST['cardHoldidnum']))
		{
			$pCardInfo = Ipscardpay::encrptCardInfo($_POST['cardHoldname'], $_POST['cardHoldidtype'], $_POST['cardHoldidnum'], $_POST['cardHoldphone']);
			
			postToIpsCatGate($params, 'ssl://gw5.ips.com.cn', 444, "/B2C/AuthTrade/Pay.aspx", "/order/pay.php");
			exit;
		}		
	}

}