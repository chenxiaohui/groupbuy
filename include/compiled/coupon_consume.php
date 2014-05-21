<?php include template("header");?>
<div class="hy_box">
    <div id="content" class="coupons-box clear">
            <div class="hy_left_a">
            <ul><?php echo current_account('/coupon/index.php'); ?></ul>
            </div>
            <div class="hy_left_b">
                <div class="head">
                    <h2>我的<?php echo $INI['system']['couponname']; ?></h2>
                    <ul class="filter">
						<li class="label">分类: </li>
						<?php echo current_coupon_sub('consume'); ?>
					</ul>
				</div>
                <div class="sect">
					<table id="orders-list" cellspacing="0" cellpadding="0" border="0" class="coupons-table" width="100%">
						<tr><th width="400">项目名称</th><th width="100" nowrap><?php echo $INI['system']['couponname']; ?>编号</th><th width="100" nowrap>消费日期</th></tr>
					<?php if(is_array($coupons)){foreach($coupons AS $index=>$one) { ?>
						<tr <?php echo $index%2?'':'class="alt"'; ?>>
							<td><a class="deal-title" href="/team.php?id=<?php echo $one['team_id']; ?>" target="_blank"><?php echo $teams[$one['team_id']]['title']; ?></a></td>
							<td><?php echo $one['id']; ?></td>
							<td><?php echo date('Y-m-d', $one['consume_time']); ?></td>
						</tr>	
					<?php }}?>
						<tr><td colspan="3"><?php echo $pagestring; ?></td></tr>
                    </table>
				</div>
            </div>
           <div class="hy_left_c"></div>
        </div>
   <div class="hy_right">
		<?php include template("block_side_aboutcoupon");?>
    </div>
</div>

<?php include template("footer");?>
