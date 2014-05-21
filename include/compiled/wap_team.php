<?php include template("wap_header");?>

<h2>今日主推&nbsp;|&nbsp;<a href="now.php">正在团购</a>&nbsp;|&nbsp;<a href="done.php">往期团购</a></h2>
<p><a href="team.php?id=<?php echo $team['id']; ?>"><?php echo $team['title']; ?></a></p>
<p><?php echo $team['now_number']; ?>人已购买&nbsp;<?php if($team['state']=='soldout'){?>已售罄<?php } else if($team['close_time']) { ?>已结束<?php } else { ?><a href="buy.php?id=<?php echo $team['id']; ?>">购买</a><?php }?></p>

<p>现价：<?php echo $currency; ?><?php echo moneyit($team['team_price']); ?> , 原价：<?php echo $currency; ?><?php echo moneyit($team['market_price']); ?> , 折扣：<?php echo team_discount($team); ?>折 , 节省：<?php echo $currency; ?><?php echo moneyit($team['market_price']-$team['team_price']); ?></p>
<p><a href="buy.php?id=<?php echo $team['id']; ?>"><img src="<?php echo team_image($team['image'], true); ?>" width="200" height="120" /></a></p>
<?php if(trim(strip_tags($team['summary']))){?>
<h2>本单详情</h2>
<p><?php echo htmlspecialchars($team['summary']); ?></p>
<?php }?>
<?php if(trim(strip_tags($team['notice']))){?>
<h2>特别提示</h2>
<p><?php echo $team['notice']; ?></p>
<?php }?>
<?php if(trim(strip_tags($team['userreview']))){?>
<h2>他们说</h2>
<p><?php echo userreview($team['userreview']); ?></p>
<?php }?>
<?php if(trim(strip_tags($team['systemreview']))){?>
<h2><?php echo $INI['system']['abbreviation']; ?>说</h2>
<p><?php echo $team['systemreview']; ?></p>
<?php }?>
<h2>购买</h2>
<p><?php echo $team['now_number']; ?>人已购买&nbsp;<?php if($team['state']=='soldout'){?>已售罄<?php } else if($team['close_time']) { ?>已结束<?php } else { ?><a href="buy.php?id=<?php echo $team['id']; ?>">购买</a><?php }?></p>

<?php include template("wap_footer");?>
