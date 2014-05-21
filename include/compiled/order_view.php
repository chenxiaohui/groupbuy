<?php include template("header");?>

<div id="bdw" class="bdw">
<div id="bd" class="cf">
<div id="order-detail">
	<div class="dashboard" id="dashboard">
		<ul><?php echo current_account(null); ?></ul>
	</div>
    <div id="content">
		<div class="box clear">
            <div class="box-top"></div>
            <div class="box-content">
                <div class="head">
                    <h2>订单详情</h2>
                </div>
                <div class="sect">
<?php if($order['service'] == 'telbook'){?>
您的预约成功了，我们的客服人员会尽快跟您联系！
<?php }?>
<table cellspacing="0" cellpadding="0" border="0" class="data-table">
    <tr>
        <th>订单编号：</th>
        <td class="orderid"><strong><?php echo $order['id']; ?></strong></td>
        <th>下单时间：</th>
        <td><span><?php echo date('Y-m-d H:i',$order['create_time']); ?></span></td>
    </tr>
    <tr>
        <th>下单序号：</th>
        <td class="orderid"><strong><?php echo $order['buy_id']; ?></strong></td>
        <th>幸运编号：</th>
        <td><span><?php echo $order['luky_id']; ?></span></td>
    </tr>
<?php if($order['condbuy']){?>
    <tr>
        <th>订单选项：</th>
        <td colspan="3" class="status">{<?php echo $order['condbuy']; ?>}</td>
    </tr>
<?php }?>
<?php if($order['remark']){?>
    <tr>
        <th>订单附言：</th>
        <td colspan="3" class="status"><?php echo htmlspecialchars($order['remark']); ?></td>
    </tr>
<?php }?>
</table>

<table cellspacing="0" cellpadding="0" border="0" class="info-table">
    <tr>
        <th class="left" width="auto">项目名称</th>
        <th width="35">单价</th>
        <th width="10"></th>
        <th width="45">数量</th>
        <th width="10"></th>
        <th width="45">总价</th>
        <th width="150">状态</th>
    </tr>
    <tr>
        <td class="left"><a href="/team.php?id=<?php echo $order['team_id']; ?>" target="_blank"><?php echo $team['title']; ?></a></td>
        <td><span class="money"><?php echo $currency; ?></span><?php echo moneyit($order['price']); ?></td>
        <td>x</td>
        <td><?php echo $order['quantity']; ?></td>
        <td>=</td>
        <td class="total"><span class="money"><?php echo $currency; ?></span><?php echo moneyit($order['price']*$order['quantity']); ?></td>
        <td class="status"><?php if(!$express&&!$order['card_id']){?>交易成功<?php } else { ?>-<?php }?></td>
    </tr>
<?php if($order['card_id']){?>
    <tr>
        <td class="left">代金券：<?php echo $order['card_id']; ?></td>
        <td><?php echo moneyit($order['card']); ?></td>
        <td>x</td>
        <td>1</td>
        <td>=</td>
        <td class="total"><span class="money"><?php echo $currency; ?></span><?php echo moneyit($order['card']); ?></td>
        <td class="status">-</td>
    </tr>
<?php }?>

<?php if($express){?>
    <tr>
        <td class="left">快递</td>
        <td><?php echo moneyit($order['fare']); ?></td>
        <td>x</td>
        <td>1</td>
        <td>=</td>
        <td class="total"><span class="money"><?php echo $currency; ?></span><?php echo moneyit($order['fare']); ?></td>
        <td class="status">-</td>
    </tr>
<?php }?>

<?php if($express||$order['card_id']){?>
    <tr>
        <td class="left"></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td class="total"><span class="money"><?php echo $currency; ?></span><?php echo moneyit($order['origin']); ?></td>
        <td class="status">交易成功</td>
    </tr>
<?php }?>

</table>

<?php if($team['delivery']=='coupon'){?>
<table cellspacing="0" cellpadding="0" border="0" class="data-table">
    <tr>
        <th><?php echo $INI['system']['couponname']; ?>：</th>
        <td class="other-coupon">
        	<?php if($order['service'] == 'telbook'){?>
        	电话预约的订单不发放优惠券，您可以直接去旅游！
	        <?php } else if(empty($coupons) ) { ?>
	        <?php echo $INI['system']['couponname']; ?>将在团购成功后，由系统自动发放
	        <?php }?>
	        <?php if(is_array($coupons)){foreach($coupons AS $one) { ?>
	        <p><?php echo $one['id']; ?> - <?php echo $one['secret']; ?></p>
	        <?php }}?>
        </td>
    </tr>
    <tr>
        <th>使用方法：</th>
        <td>至商家消费时，请出示<?php echo $INI['system']['couponname']; ?>，配合商家验证券的编号及密码</td>
    </tr>
</table>
<?php } else if($team['delivery']=='voucher') { ?>
<table cellspacing="0" cellpadding="0" border="0" class="data-table">
    <tr>
        <th>商户券号：</th>
        <td class="other-coupon"><?php if(empty($vouchers)){?>商户券将在团购成功后，由系统自动发放<?php }?><?php if(is_array($vouchers)){foreach($vouchers AS $one) { ?><p><?php echo $one['code']; ?>&nbsp;&nbsp;<a href="/ajax/coupon.php?action=vouchersms&id=<?php echo $one['id']; ?>" class="ajaxlink">短信</a></p><?php }}?></td>
    </tr>
    <tr>
        <th>使用方法：</th>
        <td>至商家消费时，请出示商户券编码，商户券直接可抵用</td>
    </tr>
</table>
<?php } else if($team['delivery']=='express') { ?>
<table cellspacing="0" cellpadding="0" border="0" class="data-table">
    <tr>
        <th>快递：</th>
	<?php if($order['express_id']){?>
        <td><?php echo $option_express[$order['express_id']]; ?>：<?php echo $order['express_no']; ?></td>
	<?php } else { ?>
        <td class="other-coupon">请耐心等待发货</td>
	<?php }?>
    </tr>
    <tr>
        <th>收件人：</th>
        <td><?php echo $order['realname']; ?></td>
    </tr>
    <tr>
        <th>收件地址：</th>
        <td><?php echo $order['address']; ?></td>
    </tr>
    <tr>
        <th>手机号码：</th>
        <td><?php echo $order['mobile']; ?></td>
    </tr>
</table>
<?php } else if($team['delivery']=='pickup') { ?>
<table cellspacing="0" cellpadding="0" border="0" class="data-table">
    <tr>
        <th>自取：</th>
        <td class="other-coupon"></td>
    </tr>
    <tr>
        <th>取货地址：</th>
        <td><?php echo $team['address']; ?></td>
    </tr>
    <tr>
        <th>联系电话：</th>
        <td><?php echo $team['mobile']; ?></td>
    </tr>
</table>
<?php }?>
                </div>
            </div>
            <div class="box-bottom"></div>
        </div>
    </div>
    <div id="sidebar">
    </div>
</div>

</div> <!-- bd end -->
</div> <!-- bdw end -->

<?php include template("footer");?>
