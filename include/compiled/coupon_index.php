<?php include template("header");?>


<div class="hy_box">
	
    <div id="content" class="coupons-box clear">
		
            <div class="hy_left_a"><ul><?php echo current_account('/coupon/index.php'); ?></ul></div>
            <div class="hy_left_b">
                <div class="head">
                    <h2>我的<?php echo $INI['system']['couponname']; ?></h2>
                    <ul class="filter">
						<li class="label">分类: </li>
						<?php echo current_coupon_sub('index'); ?>
					</ul>
				</div>
                <div class="sect">
					<?php if($selector=='index'&&!$coupons){?>
					<div class="notice">目前没有可用的<?php echo $INI['system']['couponname']; ?></div>
					<?php }?>
					<table id="orders-list" cellspacing="0" cellpadding="0" border="0" class="coupons-table" width="100%">
						<tr><th width="55%">项目名称</th><th width="10%" nowrap><?php echo $INI['system']['couponname']; ?>编号</th><th width="10%" nowrap>密码</th><th width="10%" nowrap>有效日期</th><th width="15%">操作</th></tr>
					<?php if(is_array($coupons)){foreach($coupons AS $index=>$one) { ?>
						<tr <?php echo $index%2?'':'class="alt"'; ?>>
							<td><a class="deal-title" href="/team.php?id=<?php echo $one['team_id']; ?>" target="_blank"><?php echo $teams[$one['team_id']]['title']; ?> 
							<?php if(isset($one['discounttag']) && $one['discounttag'] != ''){?>
								【<?php echo $one['discounttag']; ?>】
							<?php }?>
						   </a></td>
							<td><?php echo $one['id']; ?></td>
							<td><?php echo $one['secret']; ?></td>
							<td><?php echo date('Y-m-d', $one['expire_time']); ?></td>
							<td><a href="/ajax/coupon.php?action=sms&id=<?php echo $one['id']; ?>" class="ajaxlink">短信</a>｜<a href="/coupon/print.php?id=<?php echo $one['id']; ?>" target="_blank">打印</a></td>
						</tr>	
					<?php }}?>
						<tr><td colspan="5"><?php echo $pagestring; ?></td></tr>
                    </table>
				</div>
            </div>
            <div class="hy_left_c"></div>
    </div>
    <div class="hy_right">
		<?php include template("block_side_aboutcoupon");?>
    </div>
</div>


<?php include template("footer");?>
