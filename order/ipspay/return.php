<?php
require_once(dirname(dirname(dirname(__FILE__))) . '/app.php');

//----------------------------------------------------
//  接收数据
//  Receive the data
//----------------------------------------------------
$billno = $_GET['billno'];
$amount = $_GET['amount'];
$mydate = $_GET['date'];
$succ = $_GET['succ'];
$msg = $_GET['msg'];
$attach = $_GET['attach'];
$ipsbillno = $_GET['ipsbillno'];
$retEncodeType = $_GET['retencodetype'];
$currency_type = $_GET['Currency_type'];
$signature = $_GET['signature'];

//'----------------------------------------------------
//'   Md5摘要认证
//'   verify  md5
//'----------------------------------------------------
$content = $billno . $amount . $mydate . $succ . $ipsbillno . $currency_type;
//请在该字段中放置商户登陆merchant.ips.com.cn下载的证书
$cert = $INI['ipspay']['sec'];
$signature_1ocal = md5($content . $cert);


if ($signature_1ocal == $signature)
{
	if ($succ == 'Y')
	{
		@list($_, $user_id, $create_time, $_) = explode('-', $billno, 4);
		if ( $_ == 'charge' ) {
			if (ZFlow::CreateFromCharge($amount, $user_id, $create_time, 'ipspay')){
				Session::Set('notice', "环迅充值{$amount}元成功！");
			}
			redirect(WEB_ROOT . '/credit/index.php');
		}
	    if( $_ == 'go'){
			@list($_, $order_id, $city_id, $_) = explode('-', $billno, 4);
			$order = Table::Fetch('order', $order_id);
			if ($order)
			{
				$service = 'ipspay';
				$bank ='环迅支付';
				ZOrder::OnlineIt($order['id'], $order['pay_id'], $amount, $currency_type, $service, $bank);
				redirect( WEB_ROOT . "/order/pay.php?id={$order['id']}");			 
			}
	    }
	    if ( $_=='book'){
	    	@list($_, $order_id, $city_id, $_) = explode('-', $billno, 4);
			$order = Table::Fetch('order', $order_id);
			if ($order)
			{
				$service = 'ipspay';
				$bank ='环迅支付';
				ZOrder::OnlineBook($order['id'], $order['pay_id'], $amount, $currency_type, $service, $bank);
				redirect( WEB_ROOT . "/order/bookfundpay.php?id={$order['id']}");			 
			}	    	
	    }
	}
	else
	{
		@list($_, $user_id, $create_time, $_) = explode('-', $billno, 4);
		if ( $_ == 'charge' ) {
			Session::Set('notice', "环迅充值{$amount}元失败！");
			redirect(WEB_ROOT . '/credit/index.php');
		}
		else
		{
			Session::Set('notice', "环迅支付失败！");
			@list($_, $order_id, $city_id, $_) = explode('-', $billno, 4);
			redirect( WEB_ROOT . "/order/pay.php?id={$order['id']}");	
			
		}
	}
}
else
{
	die('<h3>银行返回错误，签名不正确，请联系适合我，确认交易是否成功！</h3>');
}
?>
