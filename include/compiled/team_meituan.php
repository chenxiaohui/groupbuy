<?php include template("header");?>

<div id="bdw" class="bdw">
<div id="bd" class="cf">
<?php if(is_newbie()){?><div id="sysmsg-guide"><div class="link"><a href="/help/tour.php"></a></div><a id="sysmsg-guide-close" href="javascript:void(0);" class="close">关闭</a></div><?php }?>

<?php if($team['close_time']){?>
<div id="sysmsg-tip" class="sysmsg-tip-deal-close"><div class="sysmsg-tip-top"></div><div class="sysmsg-tip-content"><div class="deal-close"><div class="focus">抱歉，您来晚了，<br />团购已经结束啦。</div><div id="tip-deal-subscribe-body" class="body"><form id="tip-deal-subscribe-form" method="post" action="/subscribe.php" class="validator"><table><tr><td>不想错过明天的团购？立刻订阅每日最新团购信息：&nbsp;</td><td><input type="text" name="email" class="f-text" value="" require="true" datatype="email" /></td><td>&nbsp;<input class="commit" type="submit" value="订阅" /></td></tr></table></form></div></div><span id="sysmsg-tip-close" class="sysmsg-tip-close">关闭</span></div><div class="sysmsg-tip-bottom"></div></div>
<?php }?>

<?php if($order){?>
<div id="sysmsg-tip" ><div class="sysmsg-tip-top"></div><div class="sysmsg-tip-content">您已经下过订单，但还没有付款。<a href="/order/check.php?id=<?php echo $order['id']; ?>">查看订单并付款</a><span id="sysmsg-tip-close" class="sysmsg-tip-close">关闭</span></div><div class="sysmsg-tip-bottom"></div></div><div id="deal-default"> 
<?php }?>

	<div id="deal-default">
		<div id="content" >
		
		<?php if($first_big){?>
			<div class="primary">
				<h1><a href="/team.php?id=<?php echo $first['id']; ?>"><?php echo $first['title']; ?></a></h1>
				<div class="main">
					<div class="deal-buy">
						<div class="deal-price-tag-open"></div>
						<p class="deal-price"><strong><?php echo $currency; ?><?php echo moneyit($first['team_price']); ?></strong><span><a href="/team.php?id=<?php echo $first['id']; ?>" rel="nofollow"></a></span> </p>
					</div>
					<table class="discount"><tbody>
						<tr>
							<th>原价</th>
							<th>折扣</th>
							<th>节省</th>
						</tr>
						<tr class="number">
							<td><del><?php echo $currency; ?><?php echo moneyit($first['market_price']); ?></del></td>
							<td><?php echo team_discount($first); ?>折</td>
							<td><?php echo $currency; ?><?php echo moneyit($first['market_price']-$first['team_price']); ?></td>
						</tr>
						<tr>
							<td class="status-box" colspan="3">
								<div id="deal-status-147271" class=" deal-status deal-status-open"><p class="deal-buy-tip-top"><strong><?php echo $first['now_number']; ?></strong> 人已购买</p></div>
								<div id="deal-timeleftfirst" curtime="<?php echo $now; ?>000" diff="<?php echo $detail[$first['id']]['diff_time']; ?>000" class="item-time">
								<ul id="counterfirst">
									<?php if($detail[$first['id']]['left_day']>0){?>
									<li><span><?php echo $detail[$first['id']]['left_day']; ?></span>天</li><li><span><?php echo $detail[$first['id']]['left_hour']; ?></span>小时</li><li><span><?php echo $detail[$first['id']]['left_minute']; ?></span>分钟</li>
									<?php } else { ?>
										<li><span><?php echo $detail[$first['id']]['left_hour']; ?></span>小时</li><li><span><?php echo $detail[$first['id']]['left_minute']; ?></span>分钟</li><li><span><?php echo $detail[$first['id']]['left_time']; ?></span>秒</li>
									<?php }?>
								</ul>
								</div>
							</td>
						</tr>
					</tbody></table>
				</div>
				<div class="sidebar">
					<?php if($detail[$first['id']]['is_today']){?>
					<a class="new pngfix" title="点击查看详情" href="/team.php?id=<?php echo $first['id']; ?>" rel="nofollow"></a>
					<?php }?>
					<div class="cover">
						<a title="" href="/team.php?id=<?php echo $first['id']; ?>" rel="nofollow">
						<img src="<?php echo team_image($first['image']); ?>" alt="<?php echo $first['title']; ?>" title="点击查看详情"></a>
						</div>
				</div>
			</div>
			<script>window.x_init_hook_multiclockfirst = function(){X.misc.multiclock('deal-timeleftfirst', 'counterfirst');};</script>
		<?php }?>
			
			<div class="secondary">
			<?php if(is_array($teams)){foreach($teams AS $tindex=>$team) { ?>
				<div class="item <?php if($tindex%2 == 0){?>odd<?php }?>">
					<h1><a href="/team.php?id=<?php echo $team['id']; ?>"><?php echo $team['title']; ?></a></h1>
					<div class="cover">
						<?php if($detail[$team['id']]['is_today']){?>
						<a class="new pngfix" title="点击查看详情" href="/team.php?id=<?php echo $team['id']; ?>" rel="nofollow"></a>
						<?php }?>
						<a title="<?php echo $team['title']; ?>" href="/team.php?id=<?php echo $team['id']; ?>" rel="nofollow"><img src="<?php echo team_image($team['image']); ?>" width="300"  title="点击查看详情" alt="<?php echo $team['title']; ?>"></a>
					</div>
					<div class="inner">
						<div class="deal-buy">
							<div class="deal-price-tag-open"></div>
							<div class="deal-price-tag"></div>
							<p class="deal-price"><strong><?php echo $currency; ?><?php echo moneyit($team['team_price']); ?></strong><span><a href="/team.php?id=<?php echo $team['id']; ?>" rel="nofollow"></a></span> </p>
						</div>
						<table class="discount"><tbody>
							<tr>
								<th>现价</th>
								<td class="price"><strong><?php echo $currency; ?><?php echo moneyit($team['team_price']); ?></strong></td>
							</tr>
							<tr>
								<th>原价</th>
								<td><del><strong><?php echo $currency; ?><?php echo moneyit($team['market_price']); ?></strong></del></td>
							</tr>
							<tr>
								<th>折扣</th>
								<td><strong><?php echo team_discount($team); ?>折</strong></td>
							</tr>
						</tbody></table>
						<div  id="deal-timeleft<?php echo $tindex; ?>" curtime="<?php echo $now; ?>000" diff="<?php echo $detail[$team['id']]['diff_time']; ?>000" class="item-time">
							<ul id="counter<?php echo $tindex; ?>">
							<?php if($detail[$team['id']]['left_day']>0){?>
								<li><span><?php echo $detail[$team['id']]['left_day']; ?></span>天</li><li><span><?php echo $detail[$team['id']]['left_hour']; ?></span>小时</li><li><span><?php echo $detail[$team['id']]['left_minute']; ?></span>分钟</li>
							<?php } else { ?>
								<li><span><?php echo $detail[$team['id']]['left_hour']; ?></span>小时</li><li><span><?php echo $detail[$team['id']]['left_minute']; ?></span>分钟</li><li><span><?php echo $detail[$team['id']]['left_time']; ?></span>秒</li>
							<?php }?>
							</ul>
						</div>
						<div id="deal-status-bjwdrj" class="deal-status deal-status-open">
							<p class="deal-buy-tip-top"><strong><?php echo $team['now_number']; ?></strong> 人已购买</p>
						</div>
					</div>
				</div>
				<script>window.x_init_hook_multiclock<?php echo $tindex; ?> = function(){X.misc.multiclock('deal-timeleft<?php echo $tindex; ?>', 'counter<?php echo $tindex; ?>');};</script>
			<?php }}?>
			</div>
		</div>
	<div id="sidebar">
		<?php include template("block_side_invite");?>
		<?php include template("block_side_bulletin");?>
		<?php include template("block_side_flv");?>
		<?php include template("block_side_others_seconds");?>
		<?php include template("block_side_ask");?>
		<?php include template("block_side_others");?>
		<?php include template("block_side_mobile");?>
		<?php include template("block_side_vote");?>
		<?php include template("block_side_business");?>
		<?php include template("block_side_subscribe");?>
	</div>
</div>
</div> <!-- bd end -->
</div> <!-- bdw end -->

<?php include template("footer");?>
