<?php include template("header_nohover");?>
<script type="text/javascript" src="/static/js/jquery.lazyload.js"></script>
<script type="text/javascript">
<!--
		jQuery(document).ready(function($){$("img").lazyload({effect:showeffect,failurelimit:10})});
//-->
</script>
<div class="two">
        <div class="mainbox">
            <div class="right" style="margin-top:0px">
				<?php include template("block_side_search");?>
				<?php include template("block_side_contact");?>
            </div>    
        </div>
        <div class="left">
        	<div class="s_left">
			<div class="s_left_1">
				<div class="s_left_11"><div class="s_left_111"><?php echo $curMon; ?></div><br /><strong><?php echo $curDay; ?></strong> 日</div>
				<div class="s_left_12">
					<div class="s_left_121">团购搜索</div>
					<div class="s_left_122"><div style="padding-top:10px;">您搜索到的“<span><?php echo $mydata; ?></span>”团购信息共搜索到<span><?php echo $teamCount; ?></span>条产品</div>
					</div>
				</div>
			</div>
			<div class="s_left_2"></div>
            <!--搜索无结果开始-->
			<?php if(!hasResult()){?>
            <div class="noresult">
            <span>未找到有关 <b><?php echo $mydata; ?></b> 的搜索结果。建议您：</span>
• 请确保搜索文字拼写正确。<br />
• 缩短关键词。<br />
• 使用相近、相同或其他语义的关键词。<br />
• 多个关键字用空格隔开 
            </div>
			<?php } else { ?>
            <!--搜索无结果结束-->

            <!--循环块开始-->
	    <?php if(is_array($teams)){foreach($teams AS $tindex=>$team) { ?>
			<div class="s_left_3"> 
				<div class="s_left_31">
					<div class="s_left_311"><?php echo ++$mindex; ?></div>					
					<div class="s_left_312"><a href="/team.php?id=<?php echo $team['id']; ?>"><?php echo $team['title']; ?></a></div>
					<div class="s_left_313"></div>
				</div>
				<div class="s_left_32">
                	<!--s_left_321是进行中的样式s_left_421是结束的样式-->
					<?php if(($team['close_time'])){?>
					<div class="s_left_421">
					  <div class="s_a"><?php echo $team['month']; ?></div>
					  <div class="s_b"><?php echo $team['day']; ?></div>
					  <div class="s_c"><?php echo $team['week']; ?></div>
	    			<?php } else { ?>
					<div class="s_left_321">
					  <div class="s_a"><?php echo $team['month']; ?></div>
					  <div class="s_b"><?php echo $team['day']; ?></div>
					  <div class="s_c"><?php echo $team['week']; ?></div>
                    <?php }?>
					</div>
					<div class="s_left_322"><a href="/team.php?id=<?php echo $team['id']; ?>"><img original="<?php echo team_image($team['image']); ?>" src="/static/css/i/grey.gif" /></a></div>
					<div class="s_left_323">
						<a href="/team.php?id=<?php echo $team['id']; ?>"><div class="s_left1"><?php echo moneyit($team['team_price']); ?></div></a>
						<div class="s_left2">
							<div class="s_left21">
								<div class="s_l21">原价<p><?php echo $currency; ?><?php echo moneyit($team['market_price']); ?></p></div>
								<div class="s_l22">折扣<p><?php echo team_discount($team); ?>折</p></div>
								<div class="s_l23">节省<p><?php echo $currency; ?><?php echo moneyit($team['market_price']-$team['team_price']); ?></p></div>
							</div>
						</div>
						<div class="s_left3">
							<div class="s_left31">“</div>
							<div class="s_left32"><?php if(strip_tags($team['summary'])!=$team['summary']){?><?php echo $team['summary']; ?><?php } else { ?><?php echo nl2br(strip_tags($team['summary'])); ?><?php }?></div>
						</div>
					</div>
				</div>
             
			</div>
			<!--循环块结束-->
	      <?php }}?>
	<?php }?>
			</div>
        </div>
</div>
<?php include template("footer");?>
