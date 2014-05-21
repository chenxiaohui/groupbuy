<?php
require_once(dirname(dirname(dirname(__FILE__))) . '/app.php');
$billno = $_POST['billno'];
$currency_type = $_POST['currency_type'];
$amount = $_POST['amount'];
$mydate = $_POST['date'];
$succ = $_POST['succ'];
$msg = $_POST['msg'];
$attach = $_POST['attach'];
$ipsbillno = $_POST['ipsbillno'];
$retEncodeType = $_POST['retencodetype'];
$signature = $_POST['signature'];
$ipsbanktime = $_POST['ipsbanktime']; 

//'----------------------------------------------------
//'   Md5摘要认证
//'   verify  md5
//'----------------------------------------------------
$content = $billno . $amount . $mydate . $succ . $ipsbillno . $currency_type;
//请在该字段中放置商户登陆merchant.ips.com.cn下载的证书
$cert = $INI['ipspay']['sec'];
$signature_1ocal = md5($content . $cert);


if ($signature_1ocal == $signature)  //认证通过
{
	if ($succ == 'Y')
	{
		@list($_, $user_id, $create_time, $_) = explode('-', $billno, 4);
		if ( $_ == 'charge' ) {
			ZFlow::CreateFromCharge($amount, $user_id, $create_time, 'ipspay');
			echo 'ipscheckok';
			exit;
		}
	
		if ( $_ == 'go')
		{
			@list($_, $order_id, $city_id, $_) = explode('-', $billno, 4);
			$order = Table::Fetch('order', $order_id);
			if ($order)
			{
					$service = 'ipspay';
					$bank ='环迅支付';
					ZOrder::OnlineIt($order['id'], $order['pay_id'], $amount, $currency_type, $service, $bank);
					echo 'ipscheckok';		
					exit;	 
			}
		}
		
		if( $_ == 'book')
		{
			@list($_, $order_id, $city_id, $_) = explode('-', $billno, 4);
			$order = Table::Fetch('order', $order_id);
			if ($order)
			{
					$service = 'ipspay';
					$bank ='环迅支付';
					ZOrder::OnlineBook($order['id'], $order['pay_id'], $amount, $currency_type, $service, $bank);
					echo 'ipscheckok';		
					exit;	 
			}		
			
		}

	}
}