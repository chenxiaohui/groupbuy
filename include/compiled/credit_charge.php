<?php include template("header");?>

<div id="bdw" class="bdw">
<div id="account-charge">
    <div id="content">
        <div class="box">
            <div class="box-top"></div>
            <div class="box-content">
                <div class="head"><h2>充值</h2></div>
                <div class="sect">
                    <div class="charge">
                        <form id="account-charge-form" action="/order/charge.php" method="post" class="validator">
                            <p>请输入充值金额：</p>
                            <p class="number">
                                <input type="text" maxlength="6" class="f-text" name="money" require="true" datatype="money" value="<?php echo $money; ?>" /> 元 （不支持小数，最低 1 元）
                            </p>
                            <p id="account-charge-tip" class="tip" style="visibility:hidden;"></p>
                            <div class="choose">
                                <p class="choose-pay-type">请选择支付方式：</p>
                                <ul class="typelist">
									<?php if($INI['paypal']['mid']){?>
										<li><input id="check-paypal" type="radio" name="paytype" value="paypal" <?php echo $ordercheck['paypal']; ?> /><label for="check-paypal" class="paypal">PayPal, Recommended</label></li>
									<?php }?>
									<?php if($INI['alipay']['mid']){?>
										<li><input id="check-alipay" type="radio" name="paytype" value="alipay" <?php echo $ordercheck['alipay']; ?> /><label for="check-alipay" class="alipay">支付宝交易，推荐淘宝用户使用</label></li>
									<?php }?>
									<?php if($INI['tenpay']['mid']){?>
										<li><input id="check-tenpay" type="radio" name="paytype" value="tenpay" <?php echo $ordercheck['tenpay']; ?> /><label for="check-tenpay" class="tenpay">财付通交易，推荐QQ用户使用</label></li>
									<?php }?>
									<?php if($INI['yeepay']['mid']){?>
										<li><input id="check-bill" type="radio" name="paytype" value="yeepay" <?php echo $ordercheck['bill']; ?> /><label for="check-yeepay" class="yeepay">易宝支付</label></li>
									<?php }?>
									<?php if($INI['bill']['mid']){?>
										<li><input id="check-bill" type="radio" name="paytype" value="bill" <?php echo $ordercheck['bill']; ?> /><label for="check-bill" class="bill">快钱交易</label></li>
									<?php }?>
									<?php if($INI['chinabank']['mid']){?>
										<li><input id="check-chinabank" type="radio" name="paytype" value="chinabank" <?php echo $ordercheck['chinabank']; ?> /><label for="check-chinabank" class="chinabank">支持招商、工行、建行、中行等主流银行的网银支付</label></li>
									<?php }?>
									<?php if($INI['ipspay']['mid']){?>
										<li><input id="check-ipspay" type="radio" name="paytype" value="ipspay" <?php echo $ordercheck['ipspay']; ?> /><label for="check-ipspay" class="ipspay">环迅网银支付</label></li>
									<?php }?>
									<?php if($INI['ipscardpay']['mid']){?>
										<li><input id="check-ipscardpay" type="radio" name="paytype" value="ipscardpay" <?php echo $ordercheck['ipscardpay']; ?> /><label for="check-ipscardpay" class="ipspay">环迅信用卡支付</label></li>
									<?php }?>
                                    </li>
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

                            </div>
                            <div class="clear"></div>
                            <p class="commit">
                                <input type="submit" value="确定，去付款" class="formbutton" />
                            </p>
                        </form>
                    </div>
                </div>
            </div>
            <div class="box-bottom"></div>
        </div>
    </div>
</div>
</div> <!-- bdw end -->

<?php include template("footer");?>
