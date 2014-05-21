<?php include template("header");?>

<div id="bdw" class="bdw">

<div id="recent-deals">

    <div id="content">
        <div class="box">
            <div class="box-top"></div>
            <div class="box-content">
                <div class="head"><h2><?php echo $pagetitle; ?></h2></div>
				<div class="sect">
					<ul class="partner-index-list">
					<?php if(is_array($partners)){foreach($partners AS $index=>$one) { ?>
						<li class="partner-li">
							<div class="pic">
								<a href="/partner.php?id=<?php echo $one['id']; ?>" title="<?php echo $one['title']; ?>" target="_blank"><img alt="<?php echo $one['title']; ?>" src="<?php echo team_image($one['image'], true); ?>" width="200" height="121"></a>
							</div>
							<div class="partner-tittle">
							<h4><a href="/partner.php?id=<?php echo $one['id']; ?>" title="<?php echo $one['title']; ?>" target="_blank"><?php echo mb_strimwidth($one['title'],0,86,'...'); ?></a></h4>
							<p>地址：<?php echo mb_strimwidth($one['address'],0,33,'...','UTF-8'); ?></p>
							<p>联系电话：<?php echo $one['phone']; ?></p>
							</div>
							<div class="partner-cont">
								<p>
								满意度 <strong><?php if($one['comment_num']>0){?><?php echo $one['reputation']; ?>%<?php } else { ?>--<?php }?></strong><br/>
								<?php if($one['comment_num']==0){?>
								暂无点评<br/>
								<?php } else { ?>
								点评数 <strong><?php echo $one['comment_num']; ?></strong><br/>
								<?php }?>
								<a href="/partner.php?id=<?php echo $one['id']; ?>" title="<?php echo $one['title']; ?>" target="_blank">查看全部点评>></a>
								</p>
							</div>
							<div class="clear"></div>
						</li>
					<?php }}?>
					</ul>
					<div class="clear"></div>
					<div><?php echo $pagestring; ?></div>
				</div>
            </div>
            <div class="box-bottom"></div>
        </div>
    </div>
	<div id="sidebar" class="right">
	
		<?php include template("block_side_vote");?>
		<?php include template("block_side_business");?>
		<?php include template("block_side_subscribe");?>
	</div>
</div>
 
</div> <!-- bdw end -->

<?php include template("footer");?>
