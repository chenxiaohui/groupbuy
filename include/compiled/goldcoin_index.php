<?php include template("header");?>
<div class="hy_box">

    <div id="content" class="clear settings-box">
              <div class="hy_left_a"><ul><?php echo current_account('/account/settings.php'); ?></ul></div>
                <div class="hy_left_b">
				<div class="head">
                    <h2>我的金币</h2>
					<ul class="filter">
						<li><a href="/account/settings.php">帐户设置</a></li>
						<li><a href="/credit/index.php">帐户余额</a></li>
						<li class="current"><a href="/goldcoin/index.php">我的金币</a></li>
						<li><a href="/account/myask.php">我的问答</a></li>
					</ul>
                </div>
                <div class="sect">
					<h3 class="credit-title">您的金币数目 <strong><?php echo moneyit($login_user['goldcoin']); ?></strong></h3>
					<table id="order-list" cellspacing="0" cellpadding="0" border="0" class="coupons-table">
						<tr><th width="120">时间</th><th width="auto">详情</th><th width="50">收支</th><th width="70">数目</th></tr>
						<?php if(is_array($flows)){foreach($flows AS $index=>$one) { ?>
						<tr <?php echo $index%2?'':'class="alt"'; ?>><td style="text-align:left;"><?php echo date('Y-m-d H:i', $one['create_time']); ?></td><td><?php echo ZGoldCoinFlow::Explain($one); ?></td><td class="<?php echo $one['direction']; ?>"><?php echo $one['direction']=='income'?'收入':'支出'; ?></td><td><?php echo moneyit($one['amount']); ?></td></tr>
						<?php }}?>
						<tr><td colspan="4"><?php echo $pagestring; ?></td></tr>
                    </table>
				</div>
            </div>
            <div class="hy_left_c"></div>
		</div>
    
   <div class="hy_right">
		<?php include template("block_side_gold");?>
		<?php include template("block_side_goldtip");?>
    </div>

</div> <!-- bdw end -->

<?php include template("footer");?>
