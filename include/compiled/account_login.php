<?php include template("header");?>
<div class="logbox">
        <div class="login_box">
            <div class="lb_a">适合我会员</div>
            <form id="login-user-form" method="post" action="/account/login.php" class="validator">
            <table width="100%" cellspacing="0" cellpadding="0" border="0">
            <tbody><tr>
            <td>用户</td><td>
                <input type="text" onfocus="if(this.value=='邮箱/用户名'){this.value='';this.style.color='#666';}" onblur="if(this.value==''){this.value='邮箱/用户名';this.style.color='#999';}" class="in in1" id="login-email-address" value="邮箱/用户名" name="email" require="true" datatype="require|limit" min="2">               
                </td>
            </tr>
            <tr>
            <td>密码</td><td>
                <input type="password" class="in in2" id="login-password" name="password" require="true" datatype="require"><br /><a href="/account/repass.php">忘记密码？</a></td>
            </tr>
            <tr>
            <td style="padding-top: 20px;" colspan="2">
                <input type="submit" onmouseout="this.className='btn1'" onmouseover="this.className='btn2'" class="btn1" name="commit" id="login-submit" value="" ><span><input type="checkbox" value="1" name="auto_login" id="autologin" class="f-check" checked />
                            <label for="autologin">下次自动登录</label></span></td>
            </tr>
            </tbody></table> </form>
            <div><a href="/thirdpart/sina/login.php">使用新浪微博账户登录</a></div>
            <div class="lb_b">还不是<?php echo $INI['system']['abbreviation']; ?>会员吗？赶快去<a href="/account/signup.php">注册！</a></div>
    </div>
    </div>

<?php include template("footer");?>
