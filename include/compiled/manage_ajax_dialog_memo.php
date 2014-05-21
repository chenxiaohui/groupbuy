<div id="order-pay-dialog" class="order-pay-dialog-c" style="width:540px;">
<h3><span id="order-pay-dialog-close" class="close" onclick="return X.boxClose();">关闭</span>写点对本订单的注释吧</h3>
	<p class="info" id="smssub-dialog-display-id">亲，写点注释吧！</p>
	<div class="aft_login">
                <div class="aft_login_up">
				<div class="aft_login_up_l">
				<textarea name="comment_content" id="dialog_comment_content"><?php echo htmlspecialchars($order['memo']); ?></textarea>
				</div>
				<input type="submit" onmouseout="this.className='input1'" onmouseover="this.className='input2'" class="input1" name="commit" id="pinglun-submit" value="" onclick="X.misc.ordercomment();" ></div>
                </div>
	
</div>
<script type="text/javascript">
X.misc.ordercomment = function() {
	var t = jQuery('#dialog_comment_content').val();
	return !X.get(WEB_ROOT + '/ajax/manage.php?action=editmemo&id=<?php echo $order['id']; ?>&t='+encodeURIComponent(t));
};
</script>
