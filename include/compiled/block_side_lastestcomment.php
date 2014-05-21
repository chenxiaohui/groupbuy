<div class="sbox">
	<div class="sbox-top"></div>
	<div class="sbox-content">
		<div class="credit fcomment-list-box" style=" padding-top:1px;padding-bottom:1px;" >
			<h2 style="padding-bottom:5px;">最新点评</h2>
			<ul class="lcComment" id="items">
				<?php if(is_array($now_comments)){foreach($now_comments AS $k=>$v) { ?>
				<li>
					<div class="lcName">  <span><?php echo $users[$v['user_id']]['username']; ?></span>  点评了  <a href="/partner.php?id=<?php echo $v['partner_id']; ?>"><?php echo $cpartners[$v['partner_id']]['title']; ?></a></div>
					<div class="lcCont" style="background-image:url('<?php echo WEB_ROOT; ?>/static/css/i/comment-icon-<?php echo $v['grade']; ?>.gif');">   <a href="/partner.php?id=<?php echo $v['partner_id']; ?>"><?php echo $v['comment']; ?></a></div>
					<div class="lcTime"> 
					<?php if($v['timespan'] < 60){?>
					<?php echo $v['timespan']; ?>秒前
					<?php } else if($v['timespan'] < 3600) { ?>
					<?php echo floor($v['timespan']/60); ?>分钟前
					<?php } else if($v['timespan'] < 86400) { ?>
					<?php echo floor($v['timespan']/3600); ?>小时前
					<?php } else if($v['timespan'] < 259200) { ?>
					<?php echo floor($v['timespan']/86400); ?>天前
					<?php } else { ?>
					3天前
					<?php }?>
					</div>
				</li>	
				<?php }}?>		
			</ul>
			<div class="clear"></div>
		</div>		
	</div>
	<div class="sbox-bottom"></div>
</div>
