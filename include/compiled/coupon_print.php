<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" id="<?php echo $INI['sn']['sn']; ?>">
<head>
	<meta http-equiv=content-type content="text/html; charset=UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
	<title><?php echo $INI['system']['couponname']; ?></title>
</head>
<style type="text/css">
body{ background:#fff;}
*{ margin: 0 auto;}
#ecard{ width:660px; clear:both; border:1px solid #000; margin-top:40px;}
#econ{ width:620px; margin:0 auto; margin-bottom:10px; overflow:hidden;}
#etop{ height:80px; border-bottom:1px solid #000;}
#logo{ width:320px; height:80px; float:left; background:url(/.jpg) no-repeat;}
#welcome{ float:left; font-family:"黑体"; font-size:36px; margin-top:20px; text-align:right; width:280px;}
#teamtitle{ width:620px; text-align:left; font-size:20px; font-weight:bold; margin-top:8px; margin-bottom:10px; }
#main{ width:620px; margin-bottom:20px;}
#mleft{ float:left; width:320px; line-height:150%; }
#name{ font-size:20px; font-weight:bold; margin-top:10px;}
#relname{ font-size:14px; padding-left:8px;}
#coupon{ margin-top:20px; font-size:26px; font-family:"黑体"; font-weight:bold; text-align:left;}
#coupon p { line-height:120%; }
#mright{ float:right; width:300px;}
#notice{font-size:14px;padding-top:8px;}
#notice ul{ margin:0px; list-style:none; padding-left:0px;}
#notice ul li{ line-height:26px;}
#server{ background-color:#dcdcdc; width:600px; height:20px; font-size:14px; color:#000; margin-top:20px; line-height:20px; text-align:center; clear:both;}

@media print { 
	.noprint{display:none;}
}
</style>

<body>
<div id="ecard">
<div id="econ">
<!--top -->
<div id="etop">
<div id="logo"><img src="/static/img/coupon-tpl-logo.jpg" /></div>
<div id="welcome">祝您消费愉快！</div>
</div>
<!--endtop -->
<div id="teamtitle"><?php echo $team['product']; ?>
<?php if(isset($coupon['discounttag']) && $coupon['discounttag'] != ''){?>
【<?php echo $coupon['discounttag']; ?>】
<?php }?>
</div>
<!--main -->
<div id="main">

<div id="mleft">
<div id="name">贵宾</div>
<div id="relname"><?php echo $login_user['username']; ?>（<?php echo $login_user['email']; ?>）</div>

<div id="name">有效期</div>
<div id="relname">截止至：<?php echo date('Y年n月j日', $coupon['expire_time']); ?></div>


<div id="name">地址</div>
<div id="relname"><?php echo $partner['address']; ?></div>

<div id="coupon">
	<p>券号:<?php echo $coupon['id']; ?></p>
	<p>密码:<?php echo $coupon['secret']; ?></p>
</div>

</div>
<!--right -->
<div id="mright">
<div id="name">提示</div>
<div id="notice"><?php echo $team['notice']; ?></div>
<div id="name">如何使用<?php echo $INI['system']['couponname']; ?></div>
<div id="notice">
<ul>
	<li>1、本券仅在<?php echo $partner['title']; ?>有效</li>
	<li>2、打印本券（券上有唯一消费码）</li>
	<li>3、持券在有效期内到商家消费</li>
</ul>
</div>

</div>

<div style="clear:both;"></div>
</div>
<!--endmain -->

<div id="server">商家电话：<?php echo $partner['phone']; ?> 地址：<?php echo $partner['address']; ?></div>

</div>

</div>

<div class="noprint" style="text-align:center; margin:20px;"><button style="padding:10px 20px; font-size:16px; cursor:pointer;" onclick="window.print();">打印<?php echo $INI['system']['couponname']; ?></button></div>
</body></html>
