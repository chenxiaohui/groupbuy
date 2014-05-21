<?php include template("manage_header");?>

<div id="bdw" class="bdw">
<div id="bd" class="cf">
<div id="coupons">
	<div class="dashboard" id="dashboard">
		<ul><?php echo mcurrent_order('index'); ?></ul>
	</div>
    <div id="content" class="coupons-box clear mainwide">
		<div class="box clear">
            <div class="box-top"></div>
            <div class="box-content">
                <div class="head">
                    <h2>当期订单</h2>
				</div>
				<div class="sect" style="padding:0 10px;">
					<form method="get">
						<p style="margin:5px 0;">订单编号：<input type="text" name="id" value="<?php echo htmlspecialchars($id); ?>" class="h-input"/>&nbsp;用户：<input type="text" name="uemail" class="h-input" value="<?php echo htmlspecialchars($uemail); ?>" >&nbsp;项目编号：<input type="text" name="team_id" class="h-input number" value="<?php echo $team_id; ?>" >&nbsp;旅游类型
						<select name="tourtype" class="f-input" style="width:200px;"><?php echo Utility::Option($tourtypes, $tourtype, '------ 请选择类型------'); ?></select>
						</p>
						<p style="margin:5px 0;">下单日期：<input type="text" class="h-input" onFocus="WdatePicker({isShowClear:false,readOnly:true})" name="cbday" value="<?php echo $cbday; ?>" /> - <input type="text" class="h-input" onFocus="WdatePicker({isShowClear:false,readOnly:true})" name="ceday" value="<?php echo $ceday; ?>" />&nbsp;付款日期：<input type="text" class="h-input" onFocus="WdatePicker({isShowClear:false,readOnly:true})" name="pbday" value="<?php echo $pbday; ?>" /> - <input type="text" class="h-input" onFocus="WdatePicker({isShowClear:false,readOnly:true})" name="peday" value="<?php echo $peday; ?>" />
						</p>
						<p style="margin:5px 0;">
						订单状态<select name="state" class="f-input" style="width:200px;"><?php echo Utility::Option($statekind, $state, '------ 请选择状态------'); ?></select>
						订单类型<select name="paykind" class="f-input" style="width:200px;"><?php echo Utility::Option($paykind, $curpay, '------ 请选择类型------'); ?></select>
						</p>
						<p style="margin:5px 0;">
						是否处理<select name="dealed" class="f-input" style="width:200px;"><?php echo Utility::Option($dealkind, $ifdeal, '------ 请选择状态------'); ?></select>
						是否电话联系过<select name="called" class="f-input" style="width:200px;"><?php echo Utility::Option($telkind, $iftel, '------ 请选择状态------'); ?></select>
						</p>
						<p style="margin:5px 0;">
						<input type="submit" value="筛选" class="formbutton"  style="padding:1px 6px;"/>
						</p>

					<form>
				</div>
                <div class="sect">
					<table id="orders-list" cellspacing="0" cellpadding="0" border="0" class="coupons-table">
					<tr>
						<th width="30">ID</th>
						<th width="30">项目</th>
						<th width="180">用户</th>
						<th width="30" nowrap>成人数</th>
						<th width="30" nowrap>儿童数</th>
						<th width="50" nowrap>总款</th>	
						<th width="50" nowrap>状态</th>	
						<th width="50" nowrap>类型</th>	
						<th width="70" nowrap>生成日期</th>	
						<th width="50" nowrap>内容 </th>
						<th width="50" nowrap>操作</th>
						<th width="50" nowrap>是否已经电话联系</th>
						<th width="50" nowrap>是否已经处理过</th>
						<th width="80" nowrap>备注</th>
					</tr>
					<?php if(is_array($orders)){foreach($orders AS $index=>$one) { ?>
					<tr <?php echo $index%2?'':'class="alt"'; ?> id="order-list-id-<?php echo $one['id']; ?>">
						<td><?php echo $one['id']; ?></td>
						<td>(<a class="deal-title" href="/team.php?id=<?php echo $one['team_id']; ?>" target="_blank"><?php echo $one['team_id']; ?></a>)</td>
						<td><a href="/ajax/manage.php?action=userview&id=<?php echo $one['user_id']; ?>" class="ajaxlink"><?php echo $users[$one['user_id']]['email']; ?><br/><?php echo $users[$one['user_id']]['username']; ?></a><?php if(Utility::IsMobile($users[$one['user_id']]['mobile'])){?>&nbsp;&raquo;&nbsp;<a href="/ajax/misc.php?action=sms&v=<?php echo $users[$one['user_id']]['mobile']; ?>" class="ajaxlink">短信</a><?php }?></td>
						<td><?php echo $one['adult_num']; ?></td>
						<td><?php echo $one['child_num']; ?></td>
						<td><span class="money"><?php echo $currency; ?></span><?php echo moneyit($one['origin']); ?></td>
						<td class="state" nowrap>
							<?php if($one["state"] == 'pay'){?>
							已付款
							<?php } else if($one["state"] == 'timeout') { ?>
							已过期
							<?php } else if($one["state"] == 'unpay') { ?>
							未付款
							<?php } else if($one["state"] == "halfpay" ) { ?>
							付订金
							<?php }?>
						</td>
						<td>
								<?php if($one['service'] == 'telbook'){?>
									电话预约
								<?php } else if($one['service'] == 'bookgold') { ?>
									支付订金
								<?php } else { ?>
									正常订单
								<?php }?>
						</td>
						<td class="detail" nowrap>
							<?php echo date('Y/n/j',$one['create_time']); ?>
						</td>
						<td class="detail" nowrap>
							<a href="/ajax/manage.php?action=orderview&id=<?php echo $one['id']; ?>" class="ajaxlink">内容 <br></a>
						</td>						
						<td class="op" nowrap>
						<?php if($one['state']=='pay'){?>
							<a href="/ajax/manage.php?action=orderview&id=<?php echo $one['id']; ?>" class="ajaxlink">详情</a>
						<?php } else if($one['state']=='unpay') { ?>
							<a href="/ajax/manage.php?action=ordercash&id=<?php echo $one['id']; ?>" class="ajaxlink" ask="确认本订单为现金付款？">现金</a>
						<?php } else if($one['state']=='halfpay') { ?>
							<a href="/ajax/manage.php?action=orderpay&id=<?php echo $one['id']; ?>" class="ajaxlink" ask="确认为本订单支付余款?">余款</a>
						<?php }?></td>
						<td class="detail" nowrap>
							<?php if($one['called']=='N'){?>
							<a href="/ajax/manage.php?action=called&id=<?php echo $one['id']; ?>" class="ajaxlink" ><b>未联系</b><br></a>
							<?php } else { ?>
							<a href="/ajax/manage.php?action=called&id=<?php echo $one['id']; ?>" class="ajaxlink" >已联系<br></a>
							<?php }?>
						</td>
						<td class="detail" nowrap>
							<?php if($one['dealed']=='N'){?>
							<a href="/ajax/manage.php?action=dealed&id=<?php echo $one['id']; ?>" class="ajaxlink" ><b>未处理</b><br></a>
							<?php } else { ?>
							<a href="/ajax/manage.php?action=dealed&id=<?php echo $one['id']; ?>" class="ajaxlink" >已处理<br></a>
							<?php }?>
						</td>
						<td class="detail" nowrap>
							<?php if(empty($one['memo'])){?>
							<a href="/ajax/manage.php?action=memo&id=<?php echo $one['id']; ?>" class="ajaxlink" >无备注<br></a>
							<?php } else { ?>
							<a href="/ajax/manage.php?action=memo&id=<?php echo $one['id']; ?>" class="ajaxlink" ><?php echo $one['memo']; ?><br></a>
							<?php }?>
						</td>
					</tr>
					<?php }}?>
					<tr><td colspan="9"><?php echo $pagestring; ?></tr>
                    </table>
				</div>
            </div>
            <div class="box-bottom"></div>
        </div>
    </div>
</div>
</div> <!-- bd end -->
</div> <!-- bdw end -->

<?php include template("manage_footer");?>
