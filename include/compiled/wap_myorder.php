<?php include template("wap_header");?>
<h2>我的订单</h2>
<p>已付款&nbsp;|&nbsp;<a href="myorder.php?s=unpay">未付款</a></p>

<?php if(is_array($orders)){foreach($orders AS $index=>$one) { ?>
<table id="order-list" style="margin:5px 0;" cellspacing="1" cellpadding="2" border="0" bgcolor="#999999" width="100%">
	<tr><td bgcolor="#CCCCCC" width="60" nowrap>日期：</td><td bgcolor="#FFFFFF"><?php echo date('Y-m-d H:i', $one['create_time']); ?></td></tr>
	<tr><td bgcolor="#CCCCCC">项目：</td><td bgcolor="#FFFFFF"><a class="deal-title" href="team.php?id=<?php echo $one['team_id']; ?>" target="_blank"><?php echo $teams[$one['team_id']]['title']; ?></a></td></tr>
	<tr><td bgcolor="#CCCCCC">金额：</td><td bgcolor="#FFFFFF"><?php echo $currency; ?><?php echo moneyit($one['origin']); ?></td></tr>
	<tr><td bgcolor="#CCCCCC">详情：</td><td bgcolor="#FFFFFF"><a href="order.php?id=<?php echo $one['id']; ?>">详情</a></td>
</table>
<?php }}?>

<table><td><?php echo $pagestring; ?></td></tr></table>

<?php include template("wap_footer");?>
