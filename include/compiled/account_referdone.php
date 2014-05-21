<?php include template("header");?>

<div class="hy_box">

    <div id="content" class="invites refers">
            <div class="hy_left_a">
            <ul><?php echo current_account('/account/refer.php'); ?></ul>
            </div>
            <div class="hy_left_b" id="referrals" >
                <div class="head">
					<h2>我的邀请</h2>
					<ul class="filter">
						<li class="label">分类: </li>
						<?php echo current_invite('referdone'); ?>
					</ul>
				</div>
                <div class="sect refers">
					<div class="share-list">
						<div class="blk im">
							<div class="logo"><img src="/static/css/i/logo_qq.gif" /></div>
							<div class="info">
								<h4>这是您的专用邀请链接，请通过 MSN 或 QQ 发送给好友：</h4>
								<input id="share-copy-text" type="text" value="<?php echo $INI['system']['wwwprefix']; ?>/r.php?r=<?php echo $login_user_id; ?>" size="35" class="f-input" onfocus="this.select()" tip="复制成功，可以通过 MSN 或 QQ 发送给好友了" />
								<input id="share-copy-button" type="button" value="复制" class="formbutton" />
							</div>
						</div>
					</div>

					<table cellspacing="0" cellpadding="0" border="0" class="coupons-table">
					<tr><th width="120">被邀用户</th><th width="305">项目名称</th><th width="150">购买时间</th><th width="40">返利</th></tr>
					<?php if(is_array($invites)){foreach($invites AS $index=>$one) { ?>
						<tr <?php echo $index%2?'':'class="alt"'; ?>><td><?php echo $users[$one['other_user_id']]['username']; ?></td><td style="text-align:left"><a href="/team.php?id=<?php echo $one['team_id']; ?>" target="_blank"><?php echo $teams[$one['team_id']]['title']; ?></a></td><td><?php echo date('Y-m-d H:i', $one['buy_time']); ?></td><td><span class="money"><?php echo $currency; ?></span><?php echo $one['credit']; ?></td></tr>
					<?php }}?>
					</table>
				</div>
            </div>
            <div class="hy_left_c"></div>
        </div>
    <div class="hy_right">
		<?php include template("block_side_invitenotice");?>
    </div>
</div>


<?php include template("footer");?>
