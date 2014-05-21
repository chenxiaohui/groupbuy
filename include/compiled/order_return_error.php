<?php include template("header");?>
<div id="bdw" class="bdw">
<div id="bd" class="cf">
<div id="content">
    <div id="order-pay-return" class="box">
        <div class="box-top"></div>
        <div class="box-content">
			<div class="head error"><h2>对不起，支付失败了！</h2></div>
            <div class="sect">
			<?php if($order_id){?>
				<p class="error-tip">返回<a href="/order/check.php?id=<?php echo $order_id; ?>">我的订单</a>重新支付。</p>
			<?php } else { ?>
                <p class="error-tip">返回<a href="/order/list/unpay.php">我的订单</a>重新支付。</p>
			<?php }?>
            </div>
		</div>
        <div class="box-bottom"></div>
    </div>
</div>
<div id="sidebar">
</div>
</div> <!-- bd end -->
</div> <!-- bdw end -->

<?php include template("footer");?>
