<h2>关于本站</h2>
<p>本站为限时团购网站，使用手机访问，可在线使用账户余额购买，请预先充值</p>
<h2>快速导航</h2>
<p>0 <a href="index.php" accesskey="0">今日团购</a></p>
<?php if(is_login()){?>
<p>1 <a href="myorder.php" accesskey="1">我的订单</a></p>
<p>2 <a href="mycoupon.php" accesskey="2">我的<?php echo $INI['system']['couponname']; ?></a></p>
<p>3 <a href="my.php" accesskey="3">个人账户</a></p>
<?php }?>
<p>8 <a href="city.php" accesskey="8">切换城市</a></p>
<p>9 <a href="index.php" accesskey="9">返回首页</a></p>
<?php if(is_login()){?>
<p>x <a href="logout.php" accesskey="x">退出</a></p>
<?php } else { ?>
<p>x <a href="login.php" accesskey="x">登录</a></p>
<?php }?>
<div id="ft">&copy;2010 <?php echo $INI['system']['sitename']; ?></div>
</body>
</html>
