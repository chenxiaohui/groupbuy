<form id="order-pay-form" method="post" action="ipscardpay/redirect_ipscardpay.php" target="_blank" sid="<?php echo $order_id; ?>">
	<div class="field">
    <label>持卡人姓名</label>
    <input type="text" size="30" name="cardHoldname" class="f-input" value=""/>
	</div>
	<div class="field">
    <label>持卡人证件类型</label>
           <select name="cardHoldidtype" class ="f-input" >
             <option value="1" >身份证</option>
             <option value="2" >护照</option>
             <option value="3" >军官证</option>
             <option value="4" >回乡证</option>
             <option value="5" >台胞证</option>
             <option value="6" >港澳通行证</option>
             <option value="7" >国际海员证</option>
             <option value="8" >外国人永久居住证</option>
             <option value="9" >其他</option>
           </select>
	</div>
	<div class="field">
    <label>持卡人证件号码</label>
    <input type="text" size="30"  name="cardHoldidnum" class="f-input" value=""/>
	</div>
	<div class="field">
    <label>持卡人电话</label>
    <input type="text" size="30"  name="cardHoldphone" class="f-input" value=""/>
	</div>
      <input type="hidden" name="pBillNo" value="<?php echo $pBillNo; ?>" />
      <input type="hidden" name="pMerCode" value="<?php echo $pMerCode; ?>" />
      <input type="hidden" name="pCurrency" value="<?php echo $pCurrency; ?>" />
      <input type="hidden" name="pLang" value="<?php echo $pLang; ?>" />
      <input type="hidden" name="pAmount" value="<?php echo $pAmount; ?>" />
      <input type="hidden" name="pDate" value="<?php echo $pDate; ?>" />
      <input type="hidden" name="pAttach" value="<?php echo $pAttach; ?>" />
      <input type="hidden" name="pGateWayType" value="<?php echo $pGateWayType; ?>" />
      <input type="hidden" name="pRetEncodeType" value="<?php echo $pRetEncodeType; ?>" />
      <input type="hidden" name="pOrderEncodeType" value="<?php echo $pOrderEncodeType; ?>" />
      <input type="hidden" name="pSignMD5" value="<?php echo $pSignMD5; ?>" />
      <input type="hidden" name="pAuthority" value="<?php echo $pAuthority; ?>" />
      <input type="hidden" name="pBillEXP" value="<?php echo $pBillEXP; ?>" />
      <input type="hidden" name="pResultType" value="<?php echo $pResultType; ?>" />  <!-- //支付结果返回方式,HTTP方式  -->
      <input type="hidden" name="pReturnUrl" value="<?php echo $pReturnUrl; ?>" />
      <input type="hidden" name="pAuthSuccessUrl" value="<?php echo $pAuthSuccessUrl; ?>" />
      <input type="hidden" name="pAuthFailureUrl" value="<?php echo $pAuthFailureUrl; ?>" />
      <input type="hidden" name="pGoodsInfo" value="<?php echo $pGoodsInfo; ?>" />
      <img src="/static/css/i/ipspay.gif" /><br/>
	<input type="submit" class="formbutton" value="前往环讯付款" />
</form>