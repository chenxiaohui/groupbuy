<?php include template("header");?>
<div class="ty_main">
<div class="ty_left" id="deal-buy">
	<div class="ty_left_sign"></div>
    <div class="ty_left_p">1.登记预订<span>2.选择支付方式</span>3.预订成功</div>
    <div class="sect">
    			<span>特别提示：仅成人需要支付预定金，随同成人一起旅行的儿童不需要支付预定金！</span>
                <table class="order-table">
                    <tr>
                        <th class="" width="60%">商品名称</th>
                        <th class="deal-buy-quantity">儿童数量</th>
                        <th class="deal-buy-quantity">成人数量</th>
                        <th class="deal-buy-multi"></th>
                        <th class="deal-buy-price">预订金单价</th>
                        <th class="deal-buy-equal"></th>
                        <th class="deal-buy-total">总价</th>
                    </tr>
                    <tr>
                        <td class="deal-buy-desc"><?php echo $team['title']; ?></td>
                        <td class="deal-buy-quantity"><?php echo $order['child_num']; ?></td>
                        <td class="deal-buy-quantity"><?php echo $order['adult_num']; ?></td>
                        <td class="deal-buy-multi">x</td>
                        <td class="deal-buy-price" id="deal-buy-price">
                        	<span class="money"><?php echo $currency; ?><span><?php echo moneyit($team['goldbook']); ?></td>
                        <td class="deal-buy-equal">=</td>
                        <td class="deal-buy-total" id="deal-buy-t">
                        		<span class="money"><?php echo $currency; ?></span><?php echo moneyit($order['adult_num']*$team['goldbook']); ?>
                        </td>
                    </tr>
					<?php if($order['card']>0){?>
				   <tr id="cardcode-row">
						<td class="deal-buy-desc">代金券：<span id="cardcode-row-n"><?php echo $order['card_id']; ?></span></td>
						<td class="deal-buy-quantity"></td>
						<td class="deal-buy-multi"></td>

						<td class="deal-buy-price"><span class="money"><?php echo $currency; ?></span><?php echo moneyit($order['card']); ?></td>
						<td class="deal-buy-equal">=</td>
						<td class="deal-buy-total">-<span class="money">¥</span><span id="cardcode-row-t"><?php echo $order['card']; ?></span></td>
					</tr>
					<?php }?>

					<tr class="order-total">
                        <td class="deal-buy-desc"><strong>应付总额：</strong></td>
                        <td class="deal-buy-quantity"></td>
                        <td class="deal-buy-multi"></td>
                        <td class="deal-buy-price"></td>
                        <td class="deal-buy-equal">=</td>
                        <td class="deal-buy-total"><span class="money"><?php echo $currency; ?></span><?php echo $order['bookgold']; ?></td>
                    </tr>
                </table>
				<div class="paytype">
                <form action="/order/bookfundpay.php" method="post" class="validator">
				<div class="order-check-form ">
					<div class="order-pay-credit">
						<h3>您的余额</h3>
						<p>账户余额：<strong><span class="money"><?php echo $currency; ?></span><?php echo moneyit($login_user['money']); ?></strong></p>
						<h3>您的金币</h3>
						<p>金币数目：<strong><span class="money"><?php echo $currency; ?></span><?php echo moneyit($login_user['goldcoin']); ?></strong></p>
						<p> 
						<?php if($tmp_goldcoin < $login_user['goldcoin']){?>
						预订可用金币数目：<strong><span class="money"><?php echo $currency; ?></span><?php echo moneyit($tmp_goldcoin); ?></strong>，
						<?php }?>
						<?php if(false==$credityes){?>您的余额不够完成本次付款，还需支付 <strong><span class="money"><?php echo $currency; ?></span><?php echo moneyit($order['bookgold']-$login_user['money']-$tmp_goldcoin); ?></strong>。<?php if($creditonly){?>请赶紧去<a href="/credit/charge.php">充值</a>。<?php } else { ?>请选择支付方式：<?php }?><?php } else { ?>您的余额足够本次购买，请直接确认订单，完成付款。<?php }?></p>
						<div class="other_pay"><?php echo $INI['other']['pay']; ?></div>
					</div>  

				<?php if(false==$creditonly && false==$credityes){?>
					<ul class="typelist">
					<?php if($INI['alipay']['mid']){?>
						<li><input id="check-alipay" type="radio" name="paytype" value="alipay" <?php echo $ordercheck['alipay']; ?> /><label for="check-alipay" class="alipay">支付宝交易，推荐淘宝用户使用</label></li>
					<?php }?>
					<?php if($INI['tenpay']['mid']){?>
						<li><input id="check-tenpay" type="radio" name="paytype" value="tenpay" <?php echo $ordercheck['tenpay']; ?> /><label for="check-tenpay" class="tenpay">财付通交易，推荐拍拍用户使用</label></li>
					<?php }?>
					<?php if($INI['yeepay']['mid']){?>
						<li><input id="check-yeepay" type="radio" name="paytype" value="yeepay" <?php echo $ordercheck['yeepay']; ?> /><label for="check-yeepay" class="yeepay">易宝支付，人民币支付网关</label></li>
					<?php }?>
					<?php if($INI['bill']['mid']){?>
						<li><input id="check-bill" type="radio" name="paytype" value="bill" <?php echo $ordercheck['bill']; ?> /><label for="check-bill" class="bill">快钱交易，助您生活娱乐更加便捷</label></li>
					<?php }?>
					<?php if($INI['chinabank']['mid']){?>
						<li><input id="check-chinabank" type="radio" name="paytype" value="chinabank" <?php echo $ordercheck['chinabank']; ?> /><label for="check-chinabank" class="chinabank">网银支付交易，支持招商、工行、建行、中行等主流银行</label></li>
					<?php }?>
					<?php if($INI['paypal']['mid']){?>
						<li><input id="check-paypal" type="radio" name="paytype" value="paypal" <?php echo $ordercheck['paypal']; ?> /><label for="check-paypal" class="paypal">PayPal, Recommended</label></li>
					<?php }?>
					<?php if($INI['ipspay']['mid']){?>
						<li><input id="check-ipspay" type="radio" name="paytype" value="ipspay" <?php echo $ordercheck['ipspay']; ?>/><label for="check-ipspay" class="ipspay">环讯网银支付</label></li>
					<?php }?>
					<?php if($INI['ipscardpay']['mid']){?>
						<li><input id="check-ipscardpay" type="radio" name="paytype" value="ipscardpay" <?php echo $ordercheck['ipscardpay']; ?>/><label for="check-ipspay" class="ipspay">环讯信用卡支付</label></li>
					<?php }?>
					</ul>

		<?php if($INI['tenpay']['mid']&&'Y'==$INI['tenpay']['direct']){?>
					<div id="paybank">
						<?php if(is_array($paybank)){foreach($paybank AS $one) { ?>
						<p><input id="check-<?php echo $one; ?>" type="radio" name="paytype" value="<?php echo $one; ?>" /><label for="check-<?php echo $one; ?>" class="<?php echo $one; ?>"></label></p>
						<?php }}?>
					</div>  
		<?php }?>

		<?php if($INI['yeepay']['mid']&&'Y'==$INI['yeepay']['direct']){?>
					<div id="paybank">
						<?php if(is_array($yeepaybank)){foreach($yeepaybank AS $one=>$pid) { ?>
						<p><input id="check-<?php echo $one; ?>" type="radio" name="paytype" value="<?php echo $pid; ?>" /><label for="check-<?php echo $one; ?>" class="<?php echo $one; ?>"></label></p>
						<?php }}?>
					</div>  
		<?php }?>

					<?php } else { ?>
					<input type="hidden" name="paytype" value="credit" />
					<?php }?>

					<?php if($credityes || false==$creditonly){?>
					<div class="clear"></div>
					<p class="check-act">
					<input type="hidden" name="order_id" value="<?php echo $order['id']; ?>" />
					<input type="hidden" name="team_id" value="<?php echo $order['team_id']; ?>" />
					<input type="hidden" name="cardcode" value="" />
					<input type="hidden" name="quantity" value="<?php echo $order['quantity']; ?>" />
					<input type="hidden" name="address" value="<?php echo $order['address']; ?>" />
					<input type="hidden" name="express" value="<?php echo $order['express']; ?>" />
					<input type="hidden" name="remark" value="<?php echo $order['remark']; ?>" />
					<input type="submit" value="确认预订，付款" class="formbutton" />
					<?php if(false==$credityes){?>
					<input type="button" value="确认预订，以后再付款" class="formbutton" onclick="location.href='index.php';" />
					<?php }?>
					<a href="/team/bookgold.php?id=<?php echo $order['team_id']; ?>" style="margin-left:1em;">返回修改订单</a>
					<?php }?>
					</p>
					</div>
					</form>
					</div>
					</div>
</div>
<div class="ty_right" id="sidebar">
<?php if(!$order['card_id']){?>
					<?php include template("block_side_card");?>
					<?php }?>
</div>
<div class="clear"></div>
</div>
					<?php include template("footer");?>
