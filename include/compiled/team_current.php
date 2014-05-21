<?php include template("header");?>

<div id="bdw" class="bdw">

<div id="recent-deals">
    <div id="content">
        <div class="box">
            <div class="box-top"></div>
            <div class="box-content">
                <div class="head"><h2><?php echo $city['name']; ?><?php echo $pagetitle; ?></h2></div>
				<div class="sect">
					<ul class="deals-list">
					<?php if(is_array($teams)){foreach($teams AS $index=>$one) { ?>
						<li class="<?php echo $index++%2?'alt':''; ?> <?php echo $index<=2?'first':''; ?>">
							<p class="time"><?php echo date('Y年n月j日', $one['begin_time']); ?> - <?php echo date('Y年n月j日', $one['end_time']); ?></p>
							<h4><a href="/team.php?id=<?php echo $one['id']; ?>" title="<?php echo $one['title']; ?>" target="_blank"><?php echo mb_strimwidth($one['title'],0,86,'...'); ?></a></h4>
							<div class="pic">
								<div class="<?php echo $one['picclass']; ?>"></div>
								<a href="/team.php?id=<?php echo $one['id']; ?>" title="<?php echo $one['title']; ?>" target="_blank"><img alt="<?php echo $one['title']; ?>" src="<?php echo team_image($one['image'], true); ?>" width="200" height="121"></a>
							</div>
							<div class="info"><p class="total"><strong class="count"><?php echo $one['now_number']; ?></strong>人购买</p><p class="price">原价：<strong class="old"><span class="money"><?php echo $currency; ?></span><?php echo moneyit($one['market_price']); ?></strong><br />折扣：<strong class="discount"><?php echo moneyit((10*$one['team_price']/$one['market_price'])); ?>折</strong><br />现价：<strong><span class="money"><?php echo $currency; ?></span><?php echo moneyit($one['team_price']); ?></strong><br />节省：<strong><span class="money"><?php echo $currency; ?></span><?php echo moneyit($one['market_price']-$one['team_price']); ?></strong><br /></p></div>
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
	<div  class="right">
		<?php include template("block_side_contact");?>
            <?php include template("block_side_pay");?>
            <?php include template("block_side_honor");?>
            <?php include template("block_side_attention");?>
           <?php include template("block_side_invite");?>
	</div>
</div>

</div> <!-- bdw end -->

<?php include template("footer");?>
