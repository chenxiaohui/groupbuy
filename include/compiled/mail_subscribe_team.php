<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Strict//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="robots" content="noindex, nofollow">
</head>
<body style="margin:auto; width:auto; height:auto; background-color:#f2e3cc;font-size:12px;">
<div style="background-color:#FFFFFF; height:45px; width:auto; ">
	<div style="text-align:center; color:#666666; font-family:'lucida Grande','Verdana'; line-height:1.8em">如果您不愿意继续接收适合我旅游网每周推荐邮件，您可以随时<a href="http://www.shihewo.com/unsubscribe.php?code=<?php echo $subscribe['secret']; ?>" style="color:#FF0000; text-decoration:none;">取消订阅</a><br />
	请把<a href="mailto:<?php echo $notice_email; ?>" style="color:#FF0000; text-decoration:none;"><?php echo $notice_email; ?></a>加到您的邮箱联系人中，以确保正确接收此邮件。<a href="http://www.shihewo.com/help/setemails.php" style="color:#FF0000; text-decoration:none;">如何设置？</a></div>
</div>
<div style="width:auto; height:auto; margin:auto; margin-top:50px;">
	<div style="width:655px; height:auto; margin:auto;">
		<div style="background-image:url(http://shihewo.com/static/css/i/e_r2_c2.jpg); width:654px; height:142px; margin:auto; font-size:28px; color:#FFFFFF; font-family:'微软雅黑','黑体','宋体';" >
			<div style=" width:500px; float:left;">
				<div style="padding-top:30px; padding-left:285px;"><strong><?php echo $city['name']; ?></strong>
				</div>
				<div style="padding-left:290px; padding-top:5px; font-size:12px;"><a href="http://www.shihewo.com/city.php" style="color:#ffffcd; font-family:'宋体'">订阅我的目的地</a>
				</div>
			</div>
			<div style="padding-top:35px;color:#c60001;float:right;">
				<div style="width:98px; font-size:50px; height:50px; line-height:50px; font-family:Arial, Helvetica, sans-serif;">5</div>
				<div style="font-size:20px; font-family:'微软雅黑','weiruanyahei','黑体','宋体';">第二期</div>			
			</div>
		</div>
		<div style="background-image:url(http://shihewo.com/static/css/i/e_r3_c2.gif); width:654px; height:34px; margin:auto;">
			<div style="color:#cc3433; font-family:'lucida Grande','Verdana'; font-size:18px; padding-left:170px; padding-top:5px;"><strong><?php echo $help_mobile; ?></strong></div>
		</div>
		<div style="width:610px; height:auto; border:5px #feb896 solid; border-top:none; margin:auto; background-color:#FFFFFF;">
			<div style="width:575px; height:auto; margin:auto; font-size:21px; font-family:'宋体';padding-top:35px;"><strong><span style="color:#fe6700">今日团购：</span><!--链接--><a href="<?php echo $INI['system']['wwwprefix']; ?>/team.php?id=<?php echo $team['id']; ?>&c=maillist" style="color:#0066cb; text-decoration:none;"><?php echo $team['title']; ?></a></strong></div>
			<div style="width:575px; border-bottom:1px #CCCCCC dashed; margin:auto; margin-top:25px; margin-bottom:15px;"></div>
			<div style="width:575px; height:192px; margin:auto;">
				<div style="width:254px; height:auto; float:left;">
                <!--链接-->
					<a href="http://www.shihewo.com/team/buy.php?id=<?php echo $team['id']; ?>"  style="text-decoration:none;"><div style="background-image:url(http://shihewo.com/static/css/i/e_r5_c3.jpg); height:72px; line-height:72px; padding-left:36px;font-size:49px; color:#FFFFFF; font-family:Arial, Helvetica, sans-serif"><?php echo $INI['system']['currency']; ?><?php echo moneyit($team['team_price']); ?></div></a>
					<div style=" width:240px; height:65px; border:1px #feb896 solid; float:right; background-color:#f2e3cc;">
						<div style="width:240px; height:50px; font-size:13px; text-align:center; padding-top:10px; color:#666">
							<div style="width:80px; height:45px; float:left;">原价<p style="color:#999"><strong><?php echo $INI['system']['currency']; ?><?php echo $team['market_price']; ?></strong></p></div>
							<div style="width:78px; height:45px; float:left; border-left:1px #e8cfa6 solid; border-right:1px solid #e8cfa6;">折扣<p style="color:#cc0000;"><strong><?php if($team['team_price']>0){?><?php echo moneyit($team['team_price']/$team['market_price']*10); ?><?php } else { ?>&nbsp;?&nbsp;<?php }?>折</strong></p></div>
							<div style="width:80px; height:45px; float:left;">节省<p style="color:#cc0000"><strong><?php echo $INI['system']['currency']; ?><?php echo moneyit($team['market_price']-$team['team_price']); ?></strong></p></div>
						</div>
					</div>
					<div style="width:255px; float:right; padding-top:5px;">
						<div style="font-size:xx-large; float:left; color:#feb896;"><strong>“</strong></div>
						<div style="font-size:12px; padding-top:10px;"><strong><?php echo strip_tags($team['summary']); ?></strong></div>
					</div>
				</div>
				<div style="width:320px; height:192px; float:right; padding-left:1px;"><a href="<?php echo $INI['system']['wwwprefix']; ?>/team.php?id=<?php echo $team['id']; ?>&c=maillist"><img img alt="<?php echo $team['title']; ?>" src="<?php echo team_image($team['image']); ?>" height="192" width="320" /></img></div>
			</div>
			<div style="width:575px; border-bottom:1px #CCCCCC solid; margin:auto; margin-top:15px;"></div>
			
			
			<div style="width:575px; height:45px; margin:auto;text-align:center; padding-top:15px; padding-bottom:15px;"><a href="http://www.shihewo.com/"><img src="http://shihewo.com/static/css/i/e_r7_c4.png" style="margin:auto;"/></a></div>
			
			<div style="width:575px; height:55px; margin:auto; background-image:url(http://shihewo.com/static/css/i/e_r9_c6.jpg); font-size:12px;"><div style="padding-top:25px;">&nbsp;每邀请一位好友首次购买，您将获得<strong style="color:#FF0000;"><?php echo $INI['system']['currency']; ?><?php echo $INI['system']['invitecredit']; ?></strong>元返利&nbsp;&nbsp;<strong ><a href="<?php echo $INI['system']['wwwprefix']; ?>/account/invite.php" style="color:#006599;">点击获取您的专用邀请链接</a></strong></div></div>
			<div style="width:575px; height:25px; margin:auto; padding-top:35px;"><strong style="font-size:21px; color:#FF0000; font-family:'微软雅黑','黑体','宋体';">适合我热卖团</strong></div>
			<div style="width:575px; height:40px; margin:auto; font-size:15px; padding-top:15px; padding-bottom:30px;line-height:23px;  font-family:'微软雅黑','黑体','宋体';"><strong>
			<?php echo MailMainCities(); ?>
			</strong></div>
		</div>	
	</div>
	<div style="width:655px; height:auto; margin:auto; line-height:1.8em; font-size:12px; padding-top:30px; padding-left:50px; padding-bottom:100px; color:#333333;;">
		如果要或有更好的需求，请随时与我们联系：<?php echo $help_mobile; ?><br />
		工作时间：周一至周日8:00-19:00，邮箱地址：<?php echo $help_email; ?><br />
		如果您不愿意继续接收来自适合我旅游网的邮件，需要退订我们的电子邮件，请在这里<a href="http://www.shihewo.com/unsubscribe.php?code=<?php echo $subscribe['secret']; ?>" style="color:#FF0000">取消订阅</a>
	</div>
</div>
</body>
</html>
