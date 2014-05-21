<?php include template("wap_header");?>

<h2><a href="index.php">今日主推</a>&nbsp;|&nbsp;<a href="now.php">正在团购</a>&nbsp;|&nbsp;往期团购</h2>

<?php if(is_array($teams)){foreach($teams AS $team) { ?>
<p><?php echo ++$index; ?>.&nbsp;<a href="team.php?id=<?php echo $team['id']; ?>"><?php echo $team['title']; ?></a></p>
<p>现价：<?php echo $currency; ?><?php echo moneyit($team['team_price']); ?> , 原价：<?php echo $currency; ?><?php echo moneyit($team['market_price']); ?> , 折扣：<?php echo team_discount($team); ?>折 , 节省：<?php echo $currency; ?><?php echo moneyit($team['market_price']-$team['team_price']); ?></p>
<p><a href="team.php?id=<?php echo $team['id']; ?>"><img src="<?php echo team_image($team['image'], true); ?>" width="200" height="120" /></a></p>
<?php }}?>

<?php echo $pagestring; ?>

<?php include template("wap_footer");?>
