<?php include template("wap_header");?>

<h2><?php echo $INI['system']['couponname']; ?>验证及消费登记</h2>
<form method="get" action="verify.php">
<p>请您输入<?php echo $INI['system']['couponname']; ?>编号和密码进行操作（查询免输密码）</p>
<p><?php echo $INI['system']['couponname']; ?>编号：<input id="coupon-dialog-input-id" type="text" name="id" class="f-input" style="text-transform:uppercase;" maxLength="12" /></p>
<p><?php echo $INI['system']['couponname']; ?>密码：<input id="coupon-dialog-input-secret" type="text" name="secret" style="text-transform:uppercase;" class="f-input" maxLength="8" /></p>
<p><input id="coupon-dialog-query" class="formbutton" value="查询" name="query" type="submit" />&nbsp;&nbsp;&nbsp;<input id="coupon-dialog-consume" name="consume" class="formbutton" value="消费（需密码）" type="submit" /></p>
</form>

<?php include template("wap_footer");?>
