<?php include template("header");?>
<div class="hy_box" style="margin-top:0px">
<div id="content">
        <div id="signup" style="position:relative;">
        <div id="deal-buy-login">
            <h3>已有<?php echo $INI['system']['abbreviation']; ?>账户？</h3>
            <form action="/account/login.php" method="post" id="deal-buy-form-login" class="validator">
            <div id="deal-buy-login-form">
                <p><span>Email</span><input type="text" class="f-input" id="deal-buy-email" name="email" size="30" require="true" datatype="require|limit" min="2" /></p>

                <p><span>密码</span><input type="password" class="f-input" name="password" size="30" datatype="require" require="true" /></p>
                <p class="act">
                    <input type="submit"  class="formbutton" name="login" value="登录"/>
                </p>
            </div>
            </form>
        </div>
    </div>

    <div class="box" id="deal-buy-box">
        <div class="hy_left_a"></div>
        <div class="hy_left_b">
            <div class="head"><h2>请注册或登录<span>快速注册，只需30秒</span></h2></div>
            <div class="sect">
                <form action="/account/signup.php" method="post" id="deal-buy-form-signup" class="validator">
                    <div class="field email">
                        <label for="signup-email-address">Email</label>

                        <input type="text" class="f-input" size="30" name="email" id="signup-email-address" require="true" datatype="email|ajax" msg="格式不正确|已经被注册" url="<?php echo WEB_ROOT; ?>/ajax/validator.php" vname="signupemail"  />
                        <span class="hint">登录及找回密码用，不会公开</span>
                    </div>
                    <div class="field username">
                        <label for="signup-username">用户名</label>
                        <input type="text" class="f-input" size="30" name="username" id="signup-username" require="true" datatype="limit|ajax" min="2" max="16" vname="signupname" url="<?php echo WEB_ROOT; ?>/ajax/validator.php" msg="用户名长度受限|用户名已经被使用" maxLength="16" /><span class="hint">4-16 个字符，一个汉字为两个字符</span>

                    </div>
					<div class="field">
						<label for="signup-password-confirm">手机号码</label>
						<input type="text" size="30" name="mobile" id="signup-mobile" class="number" require="<?php echo option_yes('needmobile')?'true':'require'; ?>" url="<?php echo WEB_ROOT; ?>/ajax/validator.php" datatype="mobile" msg="手机号码不正确|手机号码已经被注册" /><span class="hint">手机号码用于<?php echo $INI['system']['couponname']; ?>的短信通知</span>
					</div>
					<div class="field password">
                        <label for="signup-password">密码</label>
                        <input type="password" size="30" name="password" id="signup-password" class="f-input" datatype="require" require="true" msg="请填写" /><span class="hint">最少 4 个字符</span>
                    </div>
                    <div class="field password">
                        <label for="signup-password-confirm">确认密码</label> 
                        <input type="password" size="30" name="password2" id="signup-password-confirm" class="f-input" require="true" datatype="compare" compare="signup-password" msg="两次输入不一致" />
                    </div>
                    <div class="act">
                        <input type="submit" value="注册" name="commit" id="signup-submit" class="formbutton"/>
                    </div>
                </form>
            </div>
        </div>
        <div class="hy_left_c"></div>

    </div>
</div>
<div class="hy_right">
<?php include template("block_side_about");?>
</div>
</div>

<?php include template("footer");?>
