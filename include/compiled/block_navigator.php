<li><a href="/">首页</a></li>
<li><a href="/team/index.php">往期团购</a></li>

<?php if(option_yes('navpredict')){?>
<li><a href="/team/predict.php">团购预告</a></li>
<?php }?>

<?php if(option_yes('navseconds')){?>
<li><a href="/team/seconds.php">秒杀抢团</a></li>
<?php }?>

<?php if(option_yes('navgoods')){?>
<li><a href="/team/goods.php">热销商品</a></li>
<?php }?>

<?php if(option_yes('navpartner')){?>
<li><a href="/partner/index.php">品牌商户</a></li>
<?php }?>

<li><a href="/help/tour.php">团购达人</a></li>

<?php if(option_yes('navforum')){?>
<li><a href="/forum/index.php">讨论区</a></li>
<?php }?>
