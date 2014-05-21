<?php include template("header");?>
<div class="hy_box">

    <div id="content" class="clear settings-box">
            <div class="hy_left_a"><ul><?php echo current_account('/credit/score.php'); ?></ul></div>
           <div class="hy_left_b">
                <div class="head">
                    <h2>积分余额</h2>
                    <ul class="filter">
						<li class="label">分类: </li>
						<?php echo current_credit_index('score'); ?>
					</ul>
                </div>
                <div class="sect">
					<h3 class="credit-title">当前的账户积分是：<strong><?php echo moneyit($login_user['score']); ?></strong></h3>
					<table id="order-list" cellspacing="0" cellpadding="0" border="0" class="coupons-table" width="100%">
						<tr><th width="20%">时间</th><th width="auto">详情</th><th width="20%">收支</th><th width="20%">积分</th></tr>
						<?php if(is_array($credits)){foreach($credits AS $index=>$one) { ?>
						<tr <?php echo $index%2?'':'class="alt"'; ?>><td style="text-align:left;"><?php echo date('Y-m-d H:i', $one['create_time']); ?></td><td><?php echo ZCredit::Explain($one); ?></td><td class="<?php echo $one['direction']; ?>"><?php echo $one['score']>0?'收入':'支出'; ?></td><td><?php echo moneyit($one['score']); ?></td></tr>
						<?php }}?>
						<tr><td colspan="4"><?php echo $pagestring; ?></td></tr>
                    </table>
				</div>
            </div>
            <div class="hy_left_c"></div>
    </div>
    <div class="hy_right">
		<?php include template("block_side_score");?>
    </div>
</div>


<?php include template("footer");?>
