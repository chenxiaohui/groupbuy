<?php include template("wap_header");?>

<h2>登录<?php echo $INI['system']['sitename']; ?></h2>

<form action="login.php" method="POST">
<p>账户：</p>
<p><input type="text" name="email"/></p>
<p>密码：</p>
<p><input type="password" name="password"/></p>
<p><input type="checkbox" name="remember" value="1" checked="checked" />记住我</p>
<p><input type="submit" value="登录" /></p>
</form>

<?php include template("wap_footer");?>
