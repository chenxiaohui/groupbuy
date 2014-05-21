<?php include template("header");?>



<div class="hy_box">

    <div id="content" class="clear settings-box">
		
            <div class="hy_left_a"><ul><?php echo current_account('/account/settings.php'); ?></ul></div>
            <div class="hy_left_b">
				<div class="head">
					<h2>我的问答</h2>
					<ul class="filter">
						<li><a href="/account/settings.php">帐户设置</a></li>
						<li><a href="/credit/index.php">帐户余额</a></li>
						<li><a href="/goldcoin/index.php">我的金币</a></li>
						<li class="current"><a href="/account/myask.php">我的问答</a></li>
					</ul>
				</div>
				<div class="sect consult-list">
					<ul class="list">
					<?php if(is_array($asks)){foreach($asks AS $one) { ?>
					<li id="ask-entry-<?php echo $one['id']; ?>" >
						<div class="item">
							<p class="user"><strong><?php echo $login_user['username']; ?></strong><span><?php echo Utility::HumanTime($one['create_time']); ?></span></p>
							<div class="clear"></div>
							<p class="text"><?php echo $one['content']; ?></p>
							<p class="reply"><strong>回复：</strong><?php echo $one['comment']; ?></p>
						</div>
					</li>
					<?php }}?>
					</ul>
					<?php echo $pagestring; ?>
				</div>
			</div>
			 <div class="hy_left_c"></div>
		</div>
	<div class="hy_right">
	<?php include template("block_side_invite");?>
	</div>
</div>


<?php include template("footer");?>
