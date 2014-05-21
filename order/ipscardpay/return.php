<?php
require_once(dirname(dirname(dirname(__FILE__))) . '/app.php');
//商户证书
$md5cert = $INI['ipscardpay']['sec'];
//商户订单号
$pBillNo = $_GET['pBillNo'];
//商户号
$pMerCode = $_GET['pMerCode'];
//支付币种
$pCurrency = $_GET['pCurrency'];
//交易金额
$pAmount = $_GET['pAmount'];
//商户录入日期
$pDate = $_GET['pDate'];
//结果标志: Y– 成功  N – 失败 S-录入成功 F-录入失败
$pSucc = $_GET['pSucc'];
//返回的加密方式
$pRetEncodeType = $_GET['pRetEncodeType']; 
//附加信息
$pAttach = $_GET['pAttach'];
//数字签名
$pSignature = $_GET['pSignature'];
//IPS处理时间
$pIpsBankTime = $_GET['pIpsBankTime'];
//IPS订单号
$pIpsBillNo = $_GET['pIpsBillNo'];
//银行返回信息
$pMsg = $_GET['pMsg'];
//验证明文
$content = $pBillNo . $pAmount . $pDate . $pSucc . $pIpsBillNo . $pCurrency;

$verify = false;
//md5摘要验证  
if($pRetEncodeType == '12')
{
	//明文=订单编号+订单金额+订单日期+成功标志+IPS订单编号+币种+商户证书
	$content = $content . $md5cert;

	$signature_local = MD5($content);

	if ($signature_local == $pSignature)
	{
		$verify = true;
	}    
}

//签名验证结果
if($verify)
{
	switch($pSucc)
	{
		Case "S":
			//录入结果成功
			echo '录入成功';
			break;
		Case "F":
			//录入结果失败，商户可以记录失败原因或做其他操作
			echo '录入失败' . $pMsg;
			break;		
		Case "Y":
			@list($_, $user_id, $create_time, $_) = explode('-', $pBillNo, 4);
			if ( $_ == 'charge' ) {
				if (ZFlow::CreateFromCharge($pAmount, $user_id, $create_time, 'ipspay')){			
					echo '支付成功';
					break;	
				}
				else
				{
					echo '支付失败';
					break;
				}
			}
		
			@list($_, $order_id, $city_id, $_) = explode('-', $pBillNo, 4);
			$order = Table::Fetch('order', $order_id);
			if ($order)
			{
				if (($order['origin'] - $order['credit'] - $pAmount) < 0.01)   //交易成功
				{
					$service = 'ipspay';
					$bank ='环迅支付';
					ZOrder::OnlineIt($order['id'], $order['pay_id'], $pAmount, $pCurrency, $service, $bank);
					echo '支付成功';
					break;		 
				}
				else
				{
						echo '支付失败';
						break;
				}
			}
			echo '支付失败';
			break;
		Case "N":
			//支付结果失败，商户可以记录失败原因或做其他操作
			echo '支付失败' . $pMsg;
			break;	
	}
}