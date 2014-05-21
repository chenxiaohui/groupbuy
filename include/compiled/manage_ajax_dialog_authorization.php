<div id="order-pay-dialog" class="order-pay-dialog-c" style="width:380px;">
	<h3><span id="order-pay-dialog-close" class="close" onclick="return X.boxClose();">关闭</span>管理授权：<?php echo $user['email']; ?></h3>
	<div style="overflow-x:hidden;padding:10px;">
	<form method="POST" id="form_authorization_id">
	<input type="hidden" name="action" value="authorization" />
	<input type="hidden" name="id" value="<?php echo $user['id']; ?>" />
	<table width="96%" class="coupons-table">
		<tr><td width="100"><input type="checkbox" name="auth[]" value="team" <?php echo in_array('team', $INI['authorization'][$user['id']])?'checked':''; ?>/>&nbsp;<b>项目管理员</b></td><td>（编辑、新建项目）</td></tr>
		<tr><td><input type="checkbox" name="auth[]" value="help" <?php echo in_array('help', $INI['authorization'][$user['id']])?'checked':''; ?>/>&nbsp;<b>客服管理员</b></td><td>（本单答疑、页面、模板、公告）</td></tr>
		<tr><td><input type="checkbox" name="auth[]" value="order" <?php echo in_array('order', $INI['authorization'][$user['id']])?'checked':''; ?>/>&nbsp;<b>订单管理员</b></td><td>（订单管理、退款、快递等）</tr>
		<tr><td><input type="checkbox" name="auth[]" value="market" <?php echo in_array('market', $INI['authorization'][$user['id']])?'checked':''; ?>/>&nbsp;<b>营销管理员</b></td><td>（邮件、短信营销、数据下载）</td></tr>
		<tr><td><input type="checkbox" name="auth[]" value="admin" <?php echo in_array('admin', $INI['authorization'][$user['id']])?'checked':''; ?>/>&nbsp;<b>系统管理员</b></td><td>（用户、类别、商户、财务相关等）</tr>
		<tr><td colspan="2"><input type="submit" class="formbutton" value="确定授权" /></td></tr>
	</table>
	</form>
	</div>
</div>
