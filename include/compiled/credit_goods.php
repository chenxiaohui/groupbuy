<?php include template("header");?>

<div class="hy_box">

    <div id="content" class="clear settings-box">
		<div class="box clear">
            <div class="hy_left_a">
            <ul><?php echo current_account('/credit/score.php'); ?></ul>
            </div>
            <div class="box-content" style="padding-top:20px">
                <div class="head">
                    <h2>兑换商品</h2>
                    <ul class="filter">
						<li class="label">分类: </li>
						<?php echo current_credit_index('goods'); ?>
					</ul>
                </div>
                <div class="sect">
					<h3 class="credit-title">当前的账户积分是：<strong><?php echo moneyit($login_user['score']); ?></strong></h3>
					<ul style="padding:10px;">
					<?php if(is_array($goods)){foreach($goods AS $index=>$one) { ?>
						<li style="width:32%; float:left; text-align:center;">
							<div><img alt="<?php echo $one['title']; ?>" src="<?php echo team_image($one['image'], true); ?>" width="160" height="121"></div>
							<div>
								<p class="total">已兑：<strong class="count"><?php echo $one['consume']; ?></strong>&nbsp;存量：<strong class="count"><?php echo $one['number']-$one['consume']; ?></strong></p>
								<p class="total">兑换需积分：<strong class="count"><?php echo $one['score']; ?></strong></p>
								<p class="price"><a href="/credit/ajax.php?id=<?php echo $one['id']; ?>&action=exchange" class="ajaxlink" ask="确定使用<?php echo $one['score']; ?>点积分兑换<?php echo $one['title']; ?>吗？">我现在就要兑换</a></p>
							</div>
						</li>
					<?php }}?>
					</ul>
					<div class="clear"></div>
					<div><?php echo $pagestring; ?></div>
				</div>
            </div>
            <div class="box-bottom"></div>
        </div>
    </div>
    <div class="hy_right">
		<?php include template("block_side_score");?>
    </div>
</div>

</div> <!-- bdw end -->

<?php include template("footer");?>
