<div id="order-pay-dialog" class="order-pay-dialog-c" style="width:380px;">
	<h3><span id="order-pay-dialog-close" class="close" onclick="return X.boxClose();">关闭</span>批量导入订阅邮件</h3>
	<div style="overflow-x:hidden;padding:10px;">
	<p>邮件地址需要每行一个的文本文件</p>
<form method="post" action="/manage/misc/importemail.php" class="validator" enctype="multipart/form-data" >
	<input type="hidden" name="id" value="<?php echo $goods['id']; ?>" />
	<table width="96%" class="coupons-table">
		<tr><td width="80" nowrap><b>订阅城市：</b></td><td><select name="city_id"><?php echo Utility::Option($allcities, null, '-所有城市-'); ?></select></td></tr>
		<tr><td nowrap><b>邮件文件：</b></td><td><input type="file" name="upload_txt" class="f-input" /></td></tr>
		<tr><td colspan="2" height="10">&nbsp;</td></tr>
		<tr><td></td><td><input type="submit" value="导入" class="formbutton" /></td></tr>
	</table>
</form>
	</div>
</div>
