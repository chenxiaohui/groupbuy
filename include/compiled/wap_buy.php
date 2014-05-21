<?php include template("wap_header");?>

<h2>项目名称</h2>
<p><?php echo $team['title']; ?></p>
<p>数量：<?php if($team['per_number']){?><?php echo $team['per_number']; ?>件<?php } else { ?>不限<?php }?>
<p>单价：<?php echo $currency; ?><?php echo moneyit($team['team_price']); ?></p>

<?php if($team['delivery']=='express'){?>
<p>快递：<?php echo $currency; ?><?php echo moneyit($team['fare']); ?></p>
<?php }?>
<form action="buy.php?id=<?php echo $team['id']; ?>" method="post" >
<input type="hidden" name="id" value="<?php echo $team['id']; ?>" />
<h2>购买选项</h2>
<p>数量<span style="color:red;">(*)</span></p>
<p><input type="text" name="quantity" value="1" <?php echo $team['per_number']==1 ? 'readonly':''; ?> /></p>

<?php if($team['delivery']=='express'){?>
<p>收件人<span style="color:red;">(*)</span></p>
<p><input type="text" name="realname" id="settings-realname" class="f-input" value="<?php echo $login_user['realname']; ?>" /></p>
<p>手机号<span style="color:red;">(*)</span></p>
<p><input type="text" name="mobile" id="settings-mobile" class="number" value="<?php echo $login_user['mobile']; ?>" maxLength="11" /></p>
<p>邮政编码<span style="color:red;">(*)</span></p>
<p><input type="text" name="zipcode" id="settings-mobile" class="number" value="<?php echo $login_user['zipcode']; ?>" maxLength="6" /></p>
<p>收件地址<span style="color:red;">(*)</span></p>
<p><input type="text" name="address" id="settings-address" class="f-input" value="<?php echo $login_user['address']; ?>" /></p>
<?php }?>

<p>订单附言</p>
<p><textarea name="remark" style="width:200px;height:40px;padding:2px;"><?php echo htmlspecialchars($order['remark']); ?></textarea></p>

<p><input type="hidden" name="id" value="<?php echo $order['id']; ?>" /><input type="submit" class="formbutton" name="buy" value="确认无误，购买"/></p>

</form>

<?php include template("wap_footer");?>
