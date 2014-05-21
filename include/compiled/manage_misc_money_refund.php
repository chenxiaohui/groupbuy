<?php include template("manage_header");?>

<div id="bdw" class="bdw">
<div id="bd" class="cf">
<div id="money">
	<div class="dashboard" id="dashboard">
		<ul><?php echo mcurrent_misc('money'); ?></ul>
	</div>
    <div id="content" class="coupons-box clear mainwide">
		<div class="box clear">
            <div class="box-top"></div>
            <div class="box-content">
                <div class="head">
                    <h2>退款记录 (总金额：<span class="currency"><?php echo $currency; ?></span><?php echo $summary; ?>)</h2>
                    <ul class="filter">
						<li class="label">分类: </li>
						<?php echo mcurrent_misc_money($s); ?>
					</ul>
				</div>
                <div class="sect">
					<table id="orders-list" cellspacing="0" cellpadding="0" border="0" class="coupons-table">
						<tr><th width="360">项目名称</th><th width="160">Email/用户名</th><th width="80">动作</th><th width="80">金额</th><th width="160">操作员</th><th width="140">退款时间</th></tr>
					<?php if(is_array($flows)){foreach($flows AS $index=>$one) { ?>
						<tr <?php echo $index%2?'':'class="alt"'; ?>>
							<td><a class="deal-title" href="/team.php?id=<?php echo $one['detail_id']; ?>" target="_blank"><?php echo $teams[$one['detail_id']]['title']; ?></a></td>
							<td nowrap><?php echo $users[$one['user_id']]['email']; ?><br/><?php echo $users[$one['user_id']]['username']; ?></td>
							<td nowrap>退款</td>
							<td nowrap><span class="money"><?php echo $currency; ?></span><?php echo moneyit($one['money']); ?></td>
							<td nowrap><?php echo $users[$one['admin_id']]['email']; ?><br/><?php echo $users[$one['admin_id']]['username']; ?></td>
							<td nowrap><?php echo date('Y-m-d H:i', $one['create_time']); ?></td>
						</tr>
					<?php }}?>
						<tr><td colspan="6"><?php echo $pagestring; ?></td></tr>
                    </table>
				</div>
            </div>
            <div class="box-bottom"></div>
        </div>
    </div>
</div>

</div> <!-- bd end -->
</div> <!-- bdw end -->

<?php include template("manage_footer");?>
