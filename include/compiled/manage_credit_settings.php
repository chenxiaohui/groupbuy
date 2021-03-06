<?php include template("manage_header");?>

<div id="bdw" class="bdw">
<div id="bd" class="cf">
<div id="partner">
	<div class="dashboard" id="dashboard">
		<ul><?php echo mcurrent_credit('settings'); ?></ul>
	</div>
	<div id="content" class="clear mainwide">
        <div class="clear box">
            <div class="box-top"></div>
            <div class="box-content">
                <div class="head"><h2>积分规则</h2></div>
                <div class="sect">
                    <form method="post">
						<div class="wholetip clear"><h3>1、基本规则</h3></div>
						<input type="hidden" name="action" value="settings" />
                        <div class="field">
                            <label>用户注册</label>
                            <input type="text" size="30" name="credit[register]" class="number" value="<?php echo $INI['credit']['register']; ?>"/>
                            <label>用户登录</label>
                            <input type="text" size="30" name="credit[login]" class="number" value="<?php echo $INI['credit']['login']; ?>"/>
						</div>
                        <div class="field">
                            <label>邀请好友</label>
                            <input type="text" size="30" name="credit[invite]" class="number" value="<?php echo $INI['credit']['invite']; ?>"/>
                            <label>购买商品</label>
                            <input type="text" size="30" name="credit[buy]" class="number" value="<?php echo $INI['credit']['buy']; ?>"/>
                        </div>
                        <div class="field">
                            <label>支付返积分</label>
                            <input type="text" size="30" name="credit[pay]" class="number" value="<?php echo $INI['credit']['pay']; ?>"/>
                            <label>充值返积分</label>
                            <input type="text" size="30" name="credit[charge]" class="number" value="<?php echo $INI['credit']['charge']; ?>"/>
							<span class="hint">购买商品/在线充值时，按付款金额的比例返还积分</span>
                        </div>
						<div class="act">
                            <input type="submit" value="保存" name="commit" class="formbutton" />
                        </div>
                    </form>

                    <form method="post">
						<div class="wholetip clear"><h3>1、用户积分充值</h3></div>
						<input type="hidden" name="action" value="charge" />
                        <div class="field">
                            <label>用户名</label>
                            <input type="text" size="30" name="username" class="number" value="0"/>
                            <label>充值积分</label>
                            <input type="text" size="30" name="credit" class="number" value="0"/>
                            <input type="submit" value="充值" name="commit" class="formbutton" />
                        </div>
                    </form>
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

<?php include template("manage_footer");?>
