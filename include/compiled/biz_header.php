<?php include template("biz_html_header");?>
<script type="text/javascript" src="/static/js/xheditor/xheditor.js"></script> 
<script src="/static/js/scrollup.js" type="text/javascript"></script>
<style type="text/css">
#topanchor, #comtanchor, #footanchor{cursor:pointer;height:32px;width:32px;margin:10px 0}
#topanchor {position: relative;height: 60px;}
#footanchor {position: relative;height: 60px;}
#tcf {position: absolute;left: 50%;top: 50%;bottom: auto;margin-left: 500px;top: 288px;background: url(/static/css/i/navi.gif) no-repeat }
</style>
<div id="tcf">
  <div id="topanchor"></div>
  <div id="footanchor"></div>
</div>
<div class="tone"><div id="Loginstate1_Panel1">
	<dl>
    <?php if(is_partner()){?>
    <dt class="r"><ul id="myaccount-menu"><?php echo current_account(null); ?></ul><a hidefocus="on" onclick="try{if(document.all) {window.external.addFavorite('http://www.shihewo.com/','适合我');} else {window.sidebar.addPanel('适合我团购网','http://www.shihewo.com/','');}}catch(e){};return false;" href="" target= _self>收藏</a></dt><dt class="l">欢迎您！<?php echo $login_partner['title']; ?> | <a href="/biz/logout.php">退出</a></dt>
    <?php } else { ?>
    <dt class="r"><a target="_self" href="" onclick="try{if(document.all) {window.external.addFavorite('http://www.shihewo.com/','适合我团购网');} else {window.sidebar.addPanel('适合我团购网','http://www.shihewo.com/','');}}catch(e){};return false;" hidefocus="on">收藏</a></dt><dt class="m"><a target="_blank" href="/account/signup.php">注册</a></dt><dt class="l"><a target="_blank" href="/account/login.php">登陆</a></dt>
    <?php }?>
    <dt class="jinpai">总有一团，适合我--适合我旅游团购网</dt></dl>
</div></div>
    <div class="thead"><div class="l"><a href="/index.php" title="适合我团购网"></a></div>
    <div class="m"><div class="md_l"></div><div class="mudidi">
        <?php echo $city['name']; ?></div><div class="chosemdd"><a href="/city.php" class="signin">切换 目的地</a></div>    

    </div>
       <form action="/subscribe.php" method="post" id="header-subscribe-form">
    <div class="r"><p>想知道 <?php echo $city['name']; ?> 下期团购是什么吗？</p><input type="hidden" name="city_id" value="<?php echo $city['id']; ?>" /><input id="header-subscribe-email" type="text" xtip="输入Email，订阅每日团购信息..." value="" class="inputext"  name="email" /><input type="hidden" value="1" name="cityid" /><input type="submit" id="dingyue" class="commit" value="" /></div>
        </form>
     <div  style="clear:both"></div></div>
    <div class="nav clear">
    <?php echo current_biz(); ?><?php if(is_partner()){?><div class="nor"><a id="verify-coupon-id" href="javascript:;">消费登记</a></div><?php }?></div>

<?php if($session_notice=Session::Get('notice',true)){?>
<div class="sysmsgw" id="sysmsg-success"><div class="sysmsg"><p><?php echo $session_notice; ?></p><span class="close">关闭</span></div></div> 
<?php }?>
<?php if($session_notice=Session::Get('error',true)){?>
<div class="sysmsgw" id="sysmsg-error"><div class="sysmsg"><p><?php echo $session_notice; ?></p><span class="close">关闭</span></div></div> 
<?php }?>
