<?php include template("header");?>


<div class="hy_box">
	
    <div id="content" class="coupons-box clear">
		
             <div class="hy_left_a">
		<ul><?php echo current_account('/order/index.php'); ?></ul>
            </div>
            <div class="hy_left_b">
                <div class="head">
                    <h2>我的订单</h2>
                    <ul class="filter">
						<li class="label">分类: </li>
						<?php echo current_order_index($selector); ?>
					</ul>
				</div>
                <div class="sect">
					<table id="orders-list" cellspacing="0" cellpadding="0" border="0" class="coupons-table" width="100%">
						<tr><th width="55%">项目名称</th><th width="6%">数量</th><th width="10%">总价</th><th width="10%">状态</th><th width="19%">操作</th></tr>
					<?php if(is_array($orders)){foreach($orders AS $index=>$one) { ?>
						<tr <?php echo $index%2?'':'class="alt"'; ?>>
							<td style="text-align:left;"><a class="deal-title" href="/team.php?id=<?php echo $one['team_id']; ?>" target="_blank"><?php echo $teams[$one['team_id']]['title']; ?></a></td>
							<td><?php echo $one['quantity']; ?></td>
							<td><span class="money"><?php echo $currency; ?></span><?php echo moneyit($one['origin']); ?></td>
							<td>
							<?php if($one['state']=='pay'){?>
								已付款
							<?php } else if($one['state']=='timeout') { ?>
								已过期
							<?php } else if($one['state']=='halfpay' && $one['service']='bookgold') { ?>
								付订金
							<?php } else if($one['service'] == 'telbook') { ?>
								预约成功
							<?php } else { ?>
								未付款
							<?php }?>
							<!--{/if}-->
							</td>
							<td class="op">
								<?php if(($one['state']=='unpay'&&$teams[$one['team_id']]['close_time']==0 && $one['state'] != 'telbook')){?>
									<a href="/order/check.php?id=<?php echo $one['id']; ?>">付款</a>
								<?php } else if($one['state']=='pay'  || $one['service'] == 'telbook') { ?>
									<a href="/order/view.php?id=<?php echo $one['id']; ?>">详情</a>&nbsp;|&nbsp;
									<?php if($one['service'] != 'telbook'){?>
										<a href="/order/ajax.php?action=ordercomment&id=<?php echo $one['id']; ?>" class="ajaxlink"><?php echo $one['comment_time'] ? $option_commentgrade[$one['comment_grade']] : '点评'; ?></a>
									<?php }?>
								<?php } else if($one['state'] =='halfpay') { ?>
									<a href="/order/view.php?id=<?php echo $one['id']; ?>">详情</a>
								<?php }?>
							</td>
						</tr>
					<?php }}?>
						<tr><td colspan="5"><?php echo $pagestring; ?></td></tr>
                    </table>
				</div>
            </div>
             <div class="hy_left_c"></div>

    </div>
    <div class="hy_right">
		<?php include template("block_side_aboutorder");?>
    </div>
</div>

<?php include template("footer");?>
