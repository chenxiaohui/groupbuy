<?php include template("header");?>

<script type="text/javascript" src="/static/js/jquery.lazyload.js"></script>
<script type="text/javascript">
<!--
	jQuery(document).ready(function($){$("img").lazyload({effect:showeffect,failurelimit:10})});
//-->
</script>
<div class="topnav"><?php echo getTopCityBar();; ?></div>
<div class="topad"><a target="_blank" href="/about/promise.php"></a><a target="_blank" href="/about/promise.php"></a><a target="_blank" href="about/promise.php"></a></div>
<?php if($team['close_time']){?>
<div id="sysmsg-tip" class="sysmsg-tip-deal-close"><div class="sysmsg-tip-top"></div><div class="sysmsg-tip-content"><div class="deal-close"><div class="focus">抱歉，您来晚了，<br />团购已经结束啦。</div><div id="tip-deal-subscribe-body" class="body"><form id="tip-deal-subscribe-form" method="post" action="/subscribe.php" class="validator"><table><tr><td>不想错过明天的团购？立刻订阅每日最新团购信息：&nbsp;</td><td><input type="text" name="email" class="f-text" value="" require="true" datatype="email" /></td><td>&nbsp;<input class="commit" type="submit" value="订阅"/></td></tr></table></form></div></div><span id="sysmsg-tip-close" class="sysmsg-tip-close">关闭</span></div><div class="sysmsg-tip-bottom"></div></div>
<?php }?>

<?php if($order){?>
<div id="sysmsg-tip" ><div class="sysmsg-tip-top"></div><div class="sysmsg-tip-content">您已经下过订单，但还没有付款。<a href="/order/check.php?id=<?php echo $order['id']; ?>">查看订单并付款</a><span id="sysmsg-tip-close" class="sysmsg-tip-close">关闭</span></div><div class="sysmsg-tip-bottom"></div></div><div id="deal-default"> 
<?php }?>

<div class="two">
    <div class="mainbox">
    <div class="right" >

	<?php include template("block_side_search");?>
	           <?php include template("block_side_invite");?>
		<?php include template("block_side_contact");?>
            
            <?php include template("block_side_honor");?>
            <?php include template("block_side_attention");?>

		<?php include template("block_side_flv");?>		
		<?php include template("block_side_mobile");?>
		<?php include template("block_side_vote");?>
		<?php include template("block_side_business");?>
	</div></div>
    
    <div class="left">
    <?php if(is_array($teams)){foreach($teams AS $tindex=>$team) { ?>
    	<ul>
            <li class="numrelative"><div class="con_num"><?php echo ++$mindex; ?></div></li>
            <li class="share">分享到：<a href="javascript:(function(){window.open('http://v.t.qq.com/share/share.php?title='+encodeURIComponent('<?php echo $team['title']; ?>')+'&amp;url='+encodeURIComponent(location.href)+'&amp;appkey=&amp;site=www.shihewo.com&amp;pic=','_blank','width=450,height=400');})()">腾迅微博</a><a href="javascript:(function(){window.open('http://v.t.sina.com.cn/share/share.php?title='+encodeURIComponent('<?php echo $team['title']; ?>')+'&amp;url='+encodeURIComponent(location.href)+'&amp;source=bookmark','_blank','width=450,height=400');})()" title="新浪微博分享">新浪微博</a><a href="javascript:(function(){window.open('http://t.163.com/article/user /checkLogin.do?link=http://news.163.com/&amp;source='+'适合我团购网'+ '&amp;info='+encodeURIComponent('<?php echo $team['title']; ?>')+' '+encodeURIComponent(location.href),'_blank','width=510,height=300');})()">网易微博</a><a href="javascript:(function(){window.open('http://www.douban.com/recommend/?url='+encodeURIComponent(location.href)+'&amp;title='+encodeURIComponent('<?php echo $team['title']; ?>')+'','_blank','width=450,height=400');})()">豆瓣</a><a href="javascript:void((function(s,d,e){if(/xiaonei\.com/.test(d.location))return;var%20f='http://share.xiaonei.com/share/buttonshare.do?link=',u=d.location,l='<?php echo $team['title']; ?>',p=[e(u),'&amp;title=',e(l)].join('');function%20a(){if(!window.open([f,p].join(''),'xnshare',['toolbar=0,status=0,resizable=1,width=626,height=436,left=',(s.width-626)/2,',top=',(s.height-436)/2].join('')))u.href=[f,p].join('');};if(/Firefox/.test(navigator.userAgent))setTimeout(a,0);else%20a();})(screen,document,encodeURIComponent));">人人</a><a href="javascript:d=document;t=d.selection?(d.selection.type!='None'?d.selection.createRange().text:''):(d.getSelection?d.getSelection():'');void(kaixin=window.open('http://www.kaixin001.com/~repaste/repaste.php?&amp;rurl='+escape(d.location.href)+'&amp;rtitle='+escape('<?php echo $team['title']; ?>')+'&amp;rcontent='+escape('<?php echo $team['title']; ?>'),'kaixin'));kaixin.focus();">开心网</a></li>
            <li class="con">
                <h2><font>今日团购(<?php echo $mindex; ?>)：</font><a target="_blank" href="/team.php?id=<?php echo $team['id']; ?>"><?php echo $team['title']; ?></a></h2>
                <div class="detail">
                    <div class="detail_l">
                        
                        <?php if(($team['state']=='soldout')){?>
                        <div class="detail_l_ab_soldout close_a"><?php echo moneyit($team['team_price']); ?></div>
                        <?php } else if($team['close_time']) { ?>
                        <div class="detail_l_ab_end close_a"><?php echo moneyit($team['team_price']); ?></div>
                        <?php } else { ?>
                        <div class="detail_l_ab"><a <?php echo $team['begin_time']<time()?'href="/team.php?id='.$team['id'].'"':''; ?> hidefocus="true"><?php echo moneyit($team['team_price']); ?></a></div>
                         <?php }?>
                        
                        <table cellspacing="0" cellpadding="0" border="0" width="100%" class="detail_tab">
                        <tbody><tr class="tr1">
                        <td>原价</td><td>折扣</td><td>节省</td>
                        </tr>
                        <tr class="tr2">
                        <td><span class="through"><?php echo $currency; ?><?php echo moneyit($team['market_price']); ?></span></td><td><span><?php echo team_discount($team); ?>折</span></td><td><span><?php echo $currency; ?><?php echo moneyit($team['market_price']-$team['team_price']); ?></span></td>
                        </tr>
                        </tbody></table>
                        <table cellspacing="0" cellpadding="0" border="0" width="100%" class="detail_tab1">
                        <tbody><tr class="tr3">
                        <td><font><?php echo $team['now_number']; ?></font>人已购买</td>
                        </tr>
                        <tr class="tr4">
                        <td>
                        <?php if($team['close_time']==0){?>
                        <?php if($team['state']=='none'){?>
                        <span class=goon>团购进行中<br />继续团购</span>
                        <?php } else { ?>
                        <span class="suc">团购已成功<br>可继续购买</span> 
                        <?php }?>
                        <?php } else { ?>
                        <span class=stop>团购已结束<br />感谢参与</span>
                        <?php }?>
                        </td>
                        </tr>
                        </tbody></table>
                        
                    </div>
                    <div class="detail_r"><a target="_blank" href="/team.php?id=<?php echo $team['id']; ?>"><img original="<?php echo team_image($team['image']); ?>" src="/static/css/i/grey.gif"></a></div>
                </div> 
                <div class="clearboth"></div>          
            </li>
            </ul>
            <?php }}?>
    </div>
    
    <div style="clear: both;"></div>
</div>

<?php include template("footer");?>
