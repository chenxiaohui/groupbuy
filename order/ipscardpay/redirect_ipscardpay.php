<?php
	include dirname(dirname(dirname(__FILE__) )) . "/app.php";
	
	$pCardInfo = Ipscardpay::encrptCardInfo($_POST['cardHoldname'], 
				$_POST['cardHoldidtype'], $_POST['cardHoldidnum'], $_POST['cardHoldphone']);
?>
<form id = "ipspay" action="https://gw5.ips.com.cn:444/B2C/AuthTrade/Pay.aspx">	
      <input type="hidden" name="pBillNo" value="<?php echo $_POST['pBillNo']; ?>" />
      <input type="hidden" name="pMerCode" value="<?php echo $_POST['pMerCode']; ?>" />
      <input type="hidden" name="pCurrency" value="<?php echo $_POST['pCurrency']; ?>" />
      <input type="hidden" name="pLang" value="<?php echo $_POST['pLang']; ?>" />
      <input type="hidden" name="pAmount" value="<?php echo $_POST['pAmount']; ?>" />
      <input type="hidden" name="pDate" value="<?php echo $_POST['pDate']; ?>" />
      <input type="hidden" name="pAttach" value="<?php echo $_POST['pAttach']; ?>" />
      <input type="hidden" name="pGateWayType" value="<?php echo $_POST['pGateWayType']; ?>" />
      <input type="hidden" name="pRetEncodeType" value="<?php echo $_POST['pRetEncodeType']; ?>" />
      <input type="hidden" name="pOrderEncodeType" value="<?php echo $_POST['pOrderEncodeType']; ?>" />
      <input type="hidden" name="pSignMD5" value="<?php echo $_POST['pSignMD5']; ?>" />
      <input type="hidden" name="pAuthority" value="<?php echo $_POST['pAuthority']; ?>" />
      <input type="hidden" name="pBillEXP" value="<?php echo $_POST['pBillEXP']; ?>" />
      <input type="hidden" name="pCardInfo" value="<?php echo $pCardInfo; ?>" />
      <input type="hidden" name="pResultType" value="<?php echo $_POST['pResultType']; ?>" />  <!-- //支付结果返回方式,HTTP方式  -->
      <input type="hidden" name="pReturnUrl" value="<?php echo $_POST['pReturnUrl']; ?>" />
      <input type="hidden" name="pAuthSuccessUrl" value="<?php echo $_POST['pAuthSuccessUrl']; ?>" />
      <input type="hidden" name="pAuthFailureUrl" value="<?php echo $_POST['pAuthFailureUrl']; ?>" />
      <input type="hidden" name="pGoodsInfo" value="<?php echo $_POST['pGoodsInfo']; ?>" />
</form>	

<script type="text/javascript">
	document.write("<h1 color='blue'>提交到银行...</h1>");
	document.getElementById("ipspay").submit();
</script>