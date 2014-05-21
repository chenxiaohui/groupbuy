<div id="order-pay-dialog" class="order-pay-dialog-c" style="width:600px;">
	<h3><span id="order-pay-dialog-close" class="close" onclick="return X.boxClose();">关闭</span></h3>
	<div style="overflow-x:hidden;padding:10px;" id="dialog-order-id" oid="<?php echo $order['id']; ?>">
	<table width="96%" align="center" class="coupons-table">
		<tr><td width="80"><b>用户信息：</b></td><td><?php echo $user['username']; ?> / <?php echo $user['email']; ?></td></tr>
		<tr><td><b>联系人姓名：</b></td><td><?php echo $order['realname']; ?></td></tr>
		<tr><td><b>联系人电话：</b></td><td><?php echo $order['mobile']; ?></td></tr>
		<tr><td><b>项目名称：</b></td><td><?php echo $team['title']; ?></td></tr>
		<tr><td><b>参团日期：</b></td><td><?php echo date('Y/n/j',$order['traveltime']); ?></td></tr>
		<tr>
			<td><b>购买总数：</b></td><td><?php echo $order['adult_num']+$order['child_num']; ?></td>
		</tr>
		<tr>
			<td><b>总价格：</b></td><td><?php echo $order['origin']; ?></td>
		</tr>
		<tr>
			<td><b>购买方式：</b></td>
			<td>
			<?php if($order['service'] == 'bookgold'){?>
				电话预约
			<?php } else if($order['service'] == 'telbook') { ?>
				支付订金
			<?php } else { ?>
				正常购买
			<?php }?>
			</td>
		</tr>
		<tr>
			<td><b>普通购买：</b></td>
			<td>
					<table>
						<tr>
						<td>成人</td><td>价格：</td><td><?php echo $order['adult_price']; ?></td><td>数量:</td> <td><?php echo $order['adult_num']; ?></td>
						</tr>
					</table>
			</td>
		</tr>
		<tr>
			<td></td>
			<td>	
				<table>
						<tr>
						<td>儿童</td><td>价格：</td><td><?php echo $order['child_price']; ?></td><td>数量:</td> <td><?php echo $order['child_num']; ?></td>
						</tr>
				</table>
			</td>			
		</tr>
		<tr><td><b>优惠购买项：</b></td><td></td></tr>
		<?php if(is_array($extrabuy)){foreach($extrabuy AS $key=>$value) { ?>
		<tr><td><b><?php echo $value['tag']; ?>价格：</b></td><td><?php echo $value['price']; ?></td><td><b>数量：</b></td><td><?php echo $value['count']; ?></td></tr>
		<?php }}?>
	<?php if($order['condbuy']){?>
		<tr><td><b>购买选项：</b></td><td><?php echo $order['condbuy']; ?></td></tr>
	<?php }?>
		<tr><td><b>付款状态：</b></td><td><?php echo $paystate[$order['state']]; ?></td></tr>
		<tr><td><b>交易单号：</b></td><td><?php echo $order['pay_id']; ?></td></tr>
		<tr><td><b>支付序号：</b></td><td><?php echo $order['buy_id']; ?></td></tr>
		<tr><td><b>付款明细：</b></td>
		<td>
			<?php if($order['state'] == 'unpay'){?>
				尚未支付
			<?php } else if($order['state'] == 'halfpay') { ?>
				支付订金<?php echo $order['bookgold']; ?>
			<?php } else { ?>
				<?php if($order['credit']){?>
					余额支付 <b><?php echo moneyit($order['credit']); ?></b> 元
				<?php }?>&nbsp;
				<?php if($order['service']!='credit'&&$order['money']){?>
					<?php echo $payservice[$order['service']]; ?>支付 <b><?php echo moneyit($order['money']); ?></b> 元
					<?php echo $payservice['goldcoin']; ?>支付 <b><?php echo moneyit($order['goldcoin']); ?></b> 元
				<?php }?>
				<?php if($order['card_id']){?>
					&nbsp;代金券：<b><?php echo moneyit($order['card']); ?></b> 元
				<?php }?>
			<?php }?>
		</td></tr>
		<tr><td><b>订购/支付时间：</b></td><td><?php echo date('Y-m-d H:i', $order['create_time']); ?> / <?php echo date('Y-m-d H:i', $order['pay_time']); ?></td></tr>
		<tr><td><b>订单来源：</b></td><td><?php echo $order['referer']['referer']; ?></td></tr>
	
	<?php if($user['mobile']){?>
		<tr><td><b>联系手机：</b></td><td><?php echo $user['mobile']; ?></td></tr>
	<?php }?>
	
	<?php if($user['qq']){?>
		<tr><td><b>QQ：</b></td><td><?php echo $user['qq']; ?></td></tr>
	<?php }?>

	<?php if($user['msn']){?>
		<tr><td><b>MSN：</b></td><td><?php echo $user['msn']; ?></td></tr>
	<?php }?>
	<?php if($order['remark']){?>
		<tr><td width="80"><b>买家留言：</b></td><td><?php echo htmlspecialchars($order['remark']); ?></td></tr>
	<?php }?>

	<?php if($team['delivery']=='express'){?>
		<tr><th colspan="2"><hr/></th></td>
		<tr><td width="100"><b>收件人：</b></td><td><?php echo $order['realname']; ?></td></tr>
		<tr><td><b>手机号码：</b></td><td><?php echo $order['mobile']; ?></td></tr>
		<tr><td><b>收件地址：</b></td><td><?php echo $order['address']; ?></td></tr>
		<tr><td><b>快递公司id：</b></td><td><?php echo $order['express_id']; ?></td></tr>
		<tr><td><b>快递公司：</b></td><td><?php echo $order['express_name']; ?></td></tr>
		<tr><th colspan="2"><hr/></th></td>
		<tr><td><b>快递信息：</b></td><td><select name="express_id" id="order-dialog-select-id"><?php echo Utility::Option($option_express, $order['express_id'], '请选择快递'); ?></select>&nbsp;<input type="text" name="in" id="order-dialog-input-id" value="<?php echo $order['express_no']; ?>" style="width:150px;" maxLength="32" />&nbsp;&nbsp;<input type="submit" value="确定" onclick="return X.manage.orderexpress();"/></td></tr>
	<?php }?>

	<?php if($order['state']=='pay'){?>
		<tr><th colspan="2"><hr/></th></tr>
		<tr>
			<td><b>退款处理：</b></td>
			<td>
				<select name="refund" id="order-dialog-refund-id"><?php echo Utility::Option($option_refund, '', '请选择退款方式'); ?></select>&nbsp;
				<input type="submit" value="确定" onclick="return X.manage.orderrefund();"/>
			</td>
		</tr>
	<?php } else if($order['state'] == 'unpay' && $order['service'] == 'bookgold') { ?>
		<tr><th colspan="2"><hr/></th></tr>
		<tr><td>用户账户</td>
			<td>余额:<b><?php echo $currency; ?><?php echo $user['money']; ?></b>
				&nbsp&nbsp金币：<b><?php echo $currency; ?><?php echo $user['goldcoin']; ?></b>
				&nbsp&nbsp本项目可以使用的金币<b><?php echo $currency; ?><?php echo $goldcoin; ?></b>
				&nbsp&nbsp还需要充值<?php echo $currency; ?><?php echo $needcharge; ?></td></tr>
			</td>
		</tr>	
		<tr><td><b>支付订金：</b></td><td><input type="submit" value="从账户余额 支付订金" onclick="return X.manage.bookpay();"/></td></tr>
	<?php } else if($order['state'] == 'unpay') { ?>
		<tr><th colspan="2"><hr/></th></tr>
		<tr><td>用户账户</td><td>余额:<b><?php echo $currency; ?><?php echo $user['money']; ?></b>&nbsp&nbsp金币：<b><?php echo $currency; ?><?php echo $user['goldcoin']; ?></b>
		&nbsp&nbsp本项目可以使用的金币<b><?php echo $currency; ?><?php echo $goldcoin; ?></b>&nbsp&nbsp还需要充值<?php echo $currency; ?><?php echo $needcharge; ?></td></tr>
		</td></tr>
		<tr><td><b>支付全部：</b></td><td><input type="submit" value="从账户余额 全额支付" onclick="return X.manage.ordercash();"/></td></tr>
	<?php } else if($order['state']=='halfpay') { ?>
		<tr><th colspan="2"><hr/></th></tr>
		<tr>
			<td>用户账户</td>
			<td>余额:<b><?php echo $currency; ?><?php echo $user['money']; ?></b>
			&nbsp&nbsp还需要充值<?php echo $currency; ?><?php echo $needcharge; ?></td></tr>
			</td></tr>
			<tr>
				<td><b>支付余款：</b>
					</td><td><input type="submit" value="从账户余额 全额支付" onclick="return X.manage.orderpay();"/>
				</td>
			</tr>
		<tr>
			<td><b>退定金：</b>
			<td>
				<select name="refund" id="order-dialog-refund-id"><?php echo Utility::Option($option_refund, '', '请选择退款方式'); ?></select>&nbsp;
				<input type="submit" value="确定" onclick="return X.manage.orderrefund();"/>
			</td>
		</tr>
	<?php }?>

	</table>
	</div>
</div>
