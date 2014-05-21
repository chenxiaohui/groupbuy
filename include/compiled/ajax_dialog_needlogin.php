<div id="order-pay-dialog" class="order-pay-dialog-c" style="width:710px;">
<h3><span id="order-pay-dialog-close" class="close" onclick="return X.boxClose();">关闭</span><?php echo $INI['system']['abbreviation']; ?>快速登录与注册</h3>

<div id="content">
	<div id="signup" style="position:relative;">
	<div id="deal-buy-login">
		<h3>已有<?php echo $INI['system']['abbreviation']; ?>账户？</h3>
		<form action="/account/login.php" method="post" id="deal-buy-form-login" class="validator">
		<div id="deal-buy-login-form">
			<p><span>Email</span><input type="text" class="f-input" id="deal-buy-email" name="email" size="30" datatype="email" require="true" /></p>

			<p><span>密码</span><input type="password" class="f-input" name="password" size="30" datatype="require" require="true" /></p>
			<p class="act">
				<input type="submit" class="formbutton" name="login" value="登录"/>
			</p>
		</div>
		</form>
	</div>
</div>

<div class="box" id="deal-buy-box">
	<div class="nobox-top"></div>
	<div class="nobox-content">
		<div class="head"><h2>请注册或登录<span>快速注册，只需30秒</span></h2></div>
		<div class="sect">
			<form action="/account/signup.php" method="post" id="deal-buy-form-signup" class="validator">
				<div class="field email">
					<label for="signup-email-address">Email</label>

					<input type="text" class="f-input" size="30" name="email" id="signup-email-address" require="true" datatype="email" />
					<span class="hint">登录及找回密码用，不会公开</span>
				</div>
				<div class="field username">
					<label for="signup-username">用户名</label>
					<input type="text" class="f-input" size="30" name="username" id="signup-username" datatype="require" require="true" />
					<span class="hint">4-16 个字符，一个汉字为两个字符</span>
				</div>
				<div class="field password">
					<label for="signup-password">密码</label>
					<input type="password" size="30" name="password" id="signup-password" class="f-input" datatype="require" require="true" />
					<span class="hint">最少 4 个字符</span>
				</div>
				<div class="field password">
					<label for="signup-password-confirm">确认密码</label>
					<input type="password" size="30" name="password2" id="signup-password-confirm" class="f-input" datatype="compare" require="true" compare="signup-password" />
				</div>
				<div class="act" style="margin-left:110px;">
					<input type="submit" value="注册" name="commit" id="signup-submit" class="formbutton"/>
				</div>
			</form>
		</div>
	</div>
	<div class="nobox-bottom"></div>
</div>

</div>
</div>
