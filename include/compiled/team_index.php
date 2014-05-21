<?php include template("header_teamindex");?>
<div class="topnav"><?php echo getTopCityBar();; ?></div>
<script type="text/javascript" src="/static/js/jquery.lazyload.js"></script>
<script type="text/javascript">
<!--
	jQuery(document).ready(function($){$("img").lazyload({effect:showeffect,failurelimit:10})});
//-->
</script>
<div class="topad"><a target="_blank" href="/about/promise.php"></a><a target="_blank" href="/about/promise.php"></a><a target="_blank" href="about/promise.php"></a></div>
<div class="two"><ul>
        <?php if(is_array($teams)){foreach($teams AS $index=>$one) { ?>
            <li class="item">
<h2><a href="/team.php?id=<?php echo $one['id']; ?>" title="<?php echo $one['title']; ?>" target="_blank"  hisefocus="true"><span>(<?php echo $one['name']; ?>)</span><?php echo mb_strimwidth($one['title'],0,86,'...'); ?></a></h2>
<div class="img"><a href="/team.php?id=<?php echo $one['id']; ?>" title="<?php echo $one['title']; ?>" target="_blank"  hisefocus="true"><img alt="<?php echo $one['title']; ?>" original="<?php echo team_image($one['image'], true); ?>" src="/static/css/i/grey.gif" ></a></div>
<div class="chakan">
<div class="chakan_l"><a target="_blank" href="/team.php?id=<?php echo $one['id']; ?>" hisefocus="true"><?php echo moneyit($one['team_price']); ?></a></div>
<div class="chakan_r">原价：<span><?php echo $currency; ?><?php echo moneyit($one['market_price']); ?></span><br>折扣：<span><?php echo team_discount($one); ?>折</span><br>节省：<span><?php echo $currency; ?></span><?php echo moneyit($one['market_price']-$one['team_price']); ?></span></div>
</div>
<div class="renshu"><span><?php echo $one['now_number']; ?></span>人已购买</div>
</li><?php }}?></ul>
<div class="clear"></div>
        
</div>

<?php include template("footer");?>
