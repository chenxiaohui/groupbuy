<script type="text/javascript" src="/static/js/jquery.rating.js"></script>
<style type="text/css">
<!--
	.jquery-ratings-star {
  width: 24px;
  height: 24px;
  background-image: url('/static/js/ratyImg/empty-star.png');
  background-repeat: no-repeat;
  position: relative;
  float: left;
  margin-right: 2px;
}

.jquery-ratings-full {
  background-image: url('/static/js/ratyImg/full-star.png');
}
//-->
</style>
<script type="text/javascript">
<!--
	$(document).ready(function() {  
	$('#rating').fadeIn(1500);
	$('#rating').ratings(5,<?php echo $order['level']; ?>).bind('ratingchanged', function(event, data) {
		$('#ratevalue').attr("value",data.rating);
	});
	$('#ratevalue').attr("value",<?php echo $order['level']; ?>);
});
//-->
</script>
<div id="order-pay-dialog" class="order-pay-dialog-c" style="width:540px;">
<h3><span id="order-pay-dialog-close" class="close" onclick="return X.boxClose();">关闭</span>我要点评本单</h3>
	<p class="info" id="smssub-dialog-display-id">请对商家【<?php echo $partner['title']; ?>】做出点评<br/> 一周内可以修改评价！<br/> 亲，点评可以得金币哦！</p>
	<div class="aft_login">
                <div class="aft_login_up">
				<div class="aft_login_up_l">
				<textarea name="comment_content" id="dialog_comment_content"><?php echo htmlspecialchars($order['comment_content']); ?></textarea>
				</div>
				<input type="submit" onmouseout="this.className='input1'" onmouseover="this.className='input2'" class="input1" name="commit" id="pinglun-submit" value="" onclick="X.misc.ordercomment();" ></div>
                <div class="aft_login_down">
				<ul><?php echo radio_grade($order['comment_grade']); ?></ul>		
				<div id="rating" style="float:left;margin: -3px 0px auto;">	
					<input type="hidden" value=0 id="ratevalue"></input>
				</div>
				</div>
    </div>
	
</div>
<script type="text/javascript">

X.misc.ordercomment = function() {
	var s = $("input[name=comment_grade]:checked").val();
	var t = jQuery('#dialog_comment_content').val();
	var l = jQuery('#ratevalue').attr("value");
	if (s&&t) return !X.get(WEB_ROOT + '/order/ajax.php?action=editcomment&id=<?php echo $order['id']; ?>&s='+s+'&t='+encodeURIComponent(t)+'&l='+l);
};
</script>
