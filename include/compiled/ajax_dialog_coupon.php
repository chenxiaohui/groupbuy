<div id="order-pay-dialog" class="order-pay-dialog-c" style="width:380px;">
<h3><span id="order-pay-dialog-close" class="close" onclick="return X.boxClose();">关闭</span><?php echo $INI['system']['couponname']; ?>验证及消费登记</h3>
	<p class="info" id="coupon-dialog-display-id">请您输入<?php echo $INI['system']['couponname']; ?>编号和密码<br/>进行操作（查询免输密码）</p>
	<p class="notice"><?php echo $INI['system']['couponname']; ?>编号：<input id="coupon-dialog-input-id" type="text" name="id" class="f-input" style="text-transform:uppercase;" maxLength="12" onkeyup="X.coupon.dialoginputkeyup(this);" /></p>
	<p class="notice"><?php echo $INI['system']['couponname']; ?>密码：<input id="coupon-dialog-input-secret" type="text" name="secret" style="text-transform:uppercase;" class="f-input" maxLength="8" onkeyup="X.coupon.dialoginputkeyup(this);" /></p>
	<p class="act"><input id="coupon-dialog-query" class="formbutton" value="查询" name="query" type="submit" onclick="return X.coupon.dialogquery();"/>&nbsp;&nbsp;&nbsp;<input id="coupon-dialog-consume" name="consume" class="formbutton" value="消费（需密码）" type="submit" onclick="return X.coupon.dialogconsume();" ask="每张<?php echo $INI['system']['couponname']; ?>只能消费一次，确定消费吗？"/></p>
</div>
