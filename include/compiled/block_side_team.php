<!--{if $team}-->
<div class="right_t"><h2><a href="/team/current.php">今日其他团购</a></h2></div>
<div class="right_m">
<div class="tip others">
<h3><a href="/team.php?id=<?php echo $team['id']; ?>"><?php echo mb_strimwidth($one['title'],0,128,'...'); ?></a></h3>
<p><a href="/team.php?id=<?php echo $one['id']; ?>"><img src="<?php echo team_image($team['image'], true); ?>" width="192" height="108" border="0" /></a></p>
<p class="price">团购价: <span><?php echo $currency; ?>$<?php echo $team['market_price']-$team['team_price']; ?></span> <br>原价: <s><?php echo $currency; ?><?php echo moneyit($team['market_price']); ?></s>  <br>折扣: <?php echo team_discount($team); ?>折</p>			
			<div class="others_btn">
				<div class="now_num">已有 <strong><?php echo $team['now_number']; ?></strong> 人购买</div>
				<a href="/team.php?id=<?php echo $one['id']; ?>" title="<?php echo $one['title']; ?>" target="_blank"><span>查看详情</span></a>
			</div>
			<div class="clear"></div>
		<div class="hr" ></div>
</div>
</div>
<div class="right_b"></div>



<!--{/team}-->
