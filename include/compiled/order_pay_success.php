<?php include template("header");?>
<div class="hy_box" style="margin-top:0px">
<div id="content">
    
        <div class="hy_left_a"></div>
            <div class="hy_left_b">
			<div class="success"><h2>您的订单，支付成功了！</h2> </div>
            <div class="sect">
                <p class="error-tip">查看所购项目&nbsp;<a href="/team.php?id=<?php echo $order['team_id']; ?>"><?php echo $team['title']; ?></a>&nbsp;的&nbsp;<a href="/order/view.php?id=<?php echo $order_id; ?>">订单详情</a>。</p>
            </div>
		</div>
		<div class="hy_left_c"></div>
	
</div>
<div id="side">
</div>

<?php include template("footer");?>
