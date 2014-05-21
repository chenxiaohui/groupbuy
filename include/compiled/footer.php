<?php include template("block_main_friendlink");?>
<div class="feedback"><a href="/feedback/suggest.php">意见反馈</a></div>
<div class="bottom clear">
<div id="footeranchor"></div>
    <dl class="clear">
    <dt class="d1">·用户帮助</dt><dt class="d2">·获取更新</dt><dt class="d3">·商务合作</dt><dt class="d4">·公司信息</dt><dt class="d5"></dt>
    </dl>
    <ul class="clear">
    <li class="l1">·<a href="/help/tour.php" target=_blank>如何团购</a><br /> ·<a href="/vote/index.php" target=_blank>用户调查</a><br /> ·<a href="/help/setemails.php" target=_blank>邮箱白名单</a><br /> ·<a href="/help/faqs.php" target=_blank>常见问题</a></li>
    <li class="l2">·<a href="/subscribe.php" target=_blank>邮件订阅</a><br />·<a href="/feed.php?ename=<?php echo $city['ename']; ?>">RSS订阅</a>
    <?php if($INI['system']['sinajiwai']){?>
					<br /><a href="<?php echo $INI['system']['sinajiwai']; ?>" target="_blank">·新浪微博</a>
				<?php }?>
				<?php if($INI['system']['tencentjiwai']){?>
					<br /><a href="<?php echo $INI['system']['tencentjiwai']; ?>" target="_blank">·腾讯微博</a>
				<?php }?>
    </li>
    <li class="l3">·<a href="/feedback/seller.php">提供团购信息</a><br />·<a href="/biz" target=_blank>商家后台</a>
	<br />·<a href="http://www.jinpai365.com/" target=_blank>金牌旅游网</a><br />·<a href="/help/api.php">开发API</a></li>
    <li class="l4">·<a href="/about/us.php" target=_blank>关于我们</a><br />·<a href="/about/contact.php" target=_blank>联系我们</a><br />·<a href="/feedback/seller.php" target=_blank>加盟合作</a><br />·<a href="/about/contact.php" target=_blank>媒体报道</a></li>
    <li class="l5"><div class="pp"></div></li>
    </ul>
    <div class="banquan">copyright@2011 &nbsp;&nbsp; www.shihewo.com,&nbsp;&nbsp;All Rights Reserved.&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $INI['system']['icp']; ?> &nbsp;&nbsp; 版权所有：<?php echo $INI['system']['abbreviation']; ?><?php if($INI['system']['statcode']){?>&nbsp;<?php echo $INI['system']['statcode']; ?><?php }?></div>
    <div class="tubiao"></div>
	</div>
    
    

<?php include template("html_footer");?>
